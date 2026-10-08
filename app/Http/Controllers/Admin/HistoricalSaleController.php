<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoricalSale;
use App\Models\HistoricalPurchaseItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricalSaleController extends Controller
{
    public function index()
    {
        $historicalSales = HistoricalSale::with([
            'items.product',
        ])
        ->latest('sales_date')
        ->get();

        return view(
            'admin.historical-sales.index',
            compact('historicalSales')
        );
    }

    public function create()
    {
        $products = Product::orderBy('product_name')->get();

        return view(
            'admin.historical-sales.create',
            compact('products')
        );
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'sales_date' => ['required', 'date'],
        'or_number' => ['nullable', 'string', 'max:255'],
        'customer_name' => ['nullable', 'string', 'max:255'],
        'sale_type' => ['required', 'in:Online,Walk-in'],
        'payment_method' => [
            'required',
            'in:Cash,GCash,Bank Transfer',
        ],
        'notes' => ['nullable', 'string'],

        'items' => ['required', 'array', 'min:1'],
        'items.*.product_id' => [
            'required',
            'exists:products,id',
        ],
        'items.*.quantity' => [
            'required',
            'integer',
            'min:1',
        ],
        'items.*.unit_price' => [
            'required',
            'numeric',
            'min:0',
        ],
    ]);

    $totalAmount = 0;

    foreach ($validated['items'] as $item) {
        $totalAmount +=
            (int) $item['quantity']
            *
            (float) $item['unit_price'];
    }

    try {

        $historicalSale = DB::transaction(function () use (
            $validated,
            $totalAmount
        ) {

            /*
             * Create the historical sale first.
             * This does NOT affect current inventory.
             */
            $historicalSale = HistoricalSale::create([
                'sales_date' => $validated['sales_date'],
                'or_number' => $validated['or_number'] ?? null,
                'customer_name' => $validated['customer_name'] ?? null,
                'sale_type' => $validated['sale_type'],
                'payment_method' => $validated['payment_method'],
                'total_amount' => $totalAmount,
                'notes' => $validated['notes'] ?? null,
            ]);


            foreach ($validated['items'] as $item) {

                $quantity = (int) $item['quantity'];
                $unitPrice = (float) $item['unit_price'];

                /*
                 * Create the historical sale item.
                 */
                $historicalSaleItem = $historicalSale->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $quantity * $unitPrice,
                ]);


                /*
                 * Find available historical purchase batches
                 * using FIFO:
                 *
                 * Oldest purchase first.
                 */
                $purchaseItems = HistoricalPurchaseItem::where(
                    'product_id',
                    $item['product_id']
                )
                    ->where('remaining_quantity', '>', 0)
                    ->whereHas('historicalPurchase', function ($query) use (
                        $validated
                    ) {
                        $query
                            ->where('status', 'Completed')
                            ->whereDate(
                                'purchase_date',
                                '<=',
                                $validated['sales_date']
                            );
                    })
                    ->with('historicalPurchase')
                    ->orderBy(
                        HistoricalPurchaseItem::query()
                            ->getModel()
                            ->qualifyColumn('id')
                    )
                    ->lockForUpdate()
                    ->get();


                /*
                 * Check whether enough historical stock
                 * exists for this sale item.
                 */
                $availableQuantity = $purchaseItems->sum(
                    fn ($purchaseItem) =>
                        (int) $purchaseItem->remaining_quantity
                );

                if ($availableQuantity < $quantity) {

                    throw new \Exception(
                        'Not enough historical purchase quantity available for ' .
                        $historicalSaleItem->product->product_name .
                        '. Available: ' .
                        $availableQuantity .
                        ', Required: ' .
                        $quantity .
                        '.'
                    );
                }


                /*
                 * FIFO allocation.
                 */
                $remainingToAllocate = $quantity;

                foreach ($purchaseItems as $purchaseItem) {

                    if ($remainingToAllocate <= 0) {
                        break;
                    }

                    $allocationQuantity = min(
                        $remainingToAllocate,
                        (int) $purchaseItem->remaining_quantity
                    );

                    $unitCost = (float) $purchaseItem->purchase_price;

                    $costSubtotal =
                        $allocationQuantity * $unitCost;


                    /*
                     * Create Historical FIFO allocation.
                     */
                    $historicalSaleItem->fifoAllocations()->create([
                        'historical_purchase_item_id' =>
                            $purchaseItem->id,

                        'quantity' =>
                            $allocationQuantity,

                        'unit_cost' =>
                            $unitCost,

                        'cost_subtotal' =>
                            $costSubtotal,
                    ]);


                    /*
                     * Reduce only the historical purchase
                     * remaining quantity.
                     *
                     * Current product stock is NOT touched.
                     */
                    $purchaseItem->decrement(
                        'remaining_quantity',
                        $allocationQuantity
                    );


                    $remainingToAllocate -= $allocationQuantity;
                }
            }

            return $historicalSale;
        });

    } catch (\Exception $e) {

        return back()
            ->withInput()
            ->withErrors([
                'items' => $e->getMessage(),
            ]);
    }


    return redirect()
        ->route(
            'historical-sales.show',
            $historicalSale
        )
        ->with(
            'success',
            'Historical sale recorded successfully with FIFO costing.'
        );
}

    public function show(HistoricalSale $historicalSale)
    {
        $historicalSale->load([
            'items.product',
            'items.fifoAllocations.historicalPurchaseItem',
        ]);

        return view(
            'admin.historical-sales.show',
            compact('historicalSale')
        );
    }

    public function edit(HistoricalSale $historicalSale)
    {
        if (
            $historicalSale->items()
                ->whereHas('fifoAllocations')
                ->exists()
        ) {
            return redirect()
                ->route(
                    'historical-sales.show',
                    $historicalSale
                )
                ->with(
                    'error',
                    'This historical sale cannot be edited because it is already connected to Historical FIFO.'
                );
        }

        $historicalSale->load('items');

        $products = Product::orderBy('product_name')->get();

        return view(
            'admin.historical-sales.edit',
            compact(
                'historicalSale',
                'products'
            )
        );
    }

    public function update(
        Request $request,
        HistoricalSale $historicalSale
    ) {
        if (
            $historicalSale->items()
                ->whereHas('fifoAllocations')
                ->exists()
        ) {
            return redirect()
                ->route(
                    'historical-sales.show',
                    $historicalSale
                )
                ->with(
                    'error',
                    'This historical sale cannot be edited because it is already connected to Historical FIFO.'
                );
        }

        $validated = $request->validate([
            'sales_date' => ['required', 'date'],
            'or_number' => ['nullable', 'string', 'max:255'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'sale_type' => ['required', 'in:Online,Walk-in'],
            'payment_method' => [
                'required',
                'in:Cash,GCash,Bank Transfer',
            ],
            'notes' => ['nullable', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => [
                'required',
                'exists:products,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $totalAmount = 0;

        foreach ($validated['items'] as $item) {
            $totalAmount +=
                (int) $item['quantity']
                *
                (float) $item['unit_price'];
        }

        $historicalSale->update([
            'sales_date' => $validated['sales_date'],
            'or_number' => $validated['or_number'] ?? null,
            'customer_name' => $validated['customer_name'] ?? null,
            'sale_type' => $validated['sale_type'],
            'payment_method' => $validated['payment_method'],
            'total_amount' => $totalAmount,
            'notes' => $validated['notes'] ?? null,
        ]);

        $historicalSale->items()->delete();

        foreach ($validated['items'] as $item) {

            $quantity = (int) $item['quantity'];
            $unitPrice = (float) $item['unit_price'];

            $historicalSale->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $quantity * $unitPrice,
            ]);
        }

        return redirect()
            ->route(
                'historical-sales.show',
                $historicalSale
            )
            ->with(
                'success',
                'Historical sale updated successfully.'
            );
    }

    public function destroy(HistoricalSale $historicalSale)
    {
        if (
            $historicalSale->items()
                ->whereHas('fifoAllocations')
                ->exists()
        ) {
            return redirect()
                ->route(
                    'historical-sales.show',
                    $historicalSale
                )
                ->with(
                    'error',
                    'This historical sale cannot be deleted because it is already connected to Historical FIFO.'
                );
        }

        $historicalSale->delete();

        return redirect()
            ->route('historical-sales.index')
            ->with(
                'success',
                'Historical sale deleted successfully.'
            );
    }
}