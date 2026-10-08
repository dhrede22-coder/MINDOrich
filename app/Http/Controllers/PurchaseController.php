<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Producer;
use App\Models\Purchase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PURCHASE LIST
    |--------------------------------------------------------------------------
    */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $producerId = $request->input('producer_id');
        $productId = $request->input('product_id');
        $status = $request->input('status');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $purchases = Purchase::query()
            ->with('producer')
            ->withCount('purchaseItems')

            // Search by Purchase Number
            ->when($search, function ($query) use ($search) {
                $query->where(
                    'purchase_number',
                    'like',
                    '%' . $search . '%'
                );
            })

            // Filter by Producer
            ->when($producerId, function ($query) use ($producerId) {
                $query->where('producer_id', $producerId);
            })

            // Filter by Product
            ->when($productId, function ($query) use ($productId) {
                $query->whereHas('purchaseItems', function ($query) use ($productId) {
                    $query->where('product_id', $productId);
                });
            })

            // Filter by Status
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })

            // Filter by Date From
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('purchase_date', '>=', $dateFrom);
            })

            // Filter by Date To
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('purchase_date', '<=', $dateTo);
            })

            ->latest('purchase_date')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | FILTER DATA
        |--------------------------------------------------------------------------
        */

        $producers = Producer::query()
            ->orderBy('producer_name')
            ->get([
                'id',
                'producer_name',
            ]);


        $products = Product::query()
            ->where('status', '!=', 'Archived')
            ->orderBy('product_name')
            ->get([
                'id',
                'product_name',
            ]);


        $statuses = [
            'Pending',
            'Completed',
            'Cancelled',
        ];


        return view(
            'admin.purchases.index',
            compact(
                'purchases',
                'producers',
                'products',
                'statuses',
                'search',
                'producerId',
                'productId',
                'status',
                'dateFrom',
                'dateTo'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE PURCHASE
    |--------------------------------------------------------------------------
    */
    public function create(): View
    {
        $producers = Producer::query()
            ->where('status', 'Active')
            ->orderBy('producer_name')
            ->get();

        $products = Product::query()
            ->where('status', '!=', 'Archived')
            ->orderBy('product_name')
            ->get();

        return view(
            'admin.purchases.create',
            compact(
                'producers',
                'products'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE PURCHASE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'producer_id' => [
                'required',
                'exists:producers,id',
            ],

            'purchase_date' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.product_id' => [
                'required',
                'exists:products,id',
            ],

            'items.*.quantity_in' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.reject_quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'items.*.purchase_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'items.*.received_at' => [
                'required',
                'date',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDATE REJECT QUANTITY
        |--------------------------------------------------------------------------
        */

        foreach ($validated['items'] as $index => $item) {

            if (
                (int) $item['reject_quantity']
                >
                (int) $item['quantity_in']
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        "items.$index.reject_quantity"
                            => 'Reject quantity cannot be greater than quantity in.',
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATE PRODUCT PRODUCER
        |--------------------------------------------------------------------------
        |
        | Every product in a purchase must belong to the selected producer.
        |
        */

        $productIds = collect($validated['items'])
            ->pluck('product_id')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $products = Product::whereIn('id', $productIds)
            ->get()
            ->keyBy('id');


        foreach ($validated['items'] as $index => $item) {

            $product = $products->get(
                (int) $item['product_id']
            );

            if (!$product) {
                continue;
            }

            if (
                (int) $product->producer_id
                !==
                (int) $validated['producer_id']
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        "items.$index.product_id" =>
                            "{$product->product_name} does not belong to the selected producer.",
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE PURCHASE
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $validated,
            &$purchase
        ) {

            /*
            |--------------------------------------------------------------------------
            | Generate Purchase Number
            |--------------------------------------------------------------------------
            */

            $purchaseNumber = 'PO-' . now()->format('YmdHis');

            while (
                Purchase::where(
                    'purchase_number',
                    $purchaseNumber
                )->exists()
            ) {

                $purchaseNumber =
                    'PO-' . now()->format('YmdHis')
                    . '-' . random_int(10, 99);
            }


            /*
            |--------------------------------------------------------------------------
            | Calculate Total Purchase Cost
            |--------------------------------------------------------------------------
            |
            | Reject items are included because they were still paid for.
            |
            */

            $totalPurchaseCost = collect($validated['items'])
                ->sum(function ($item) {

                    return (int) $item['quantity_in']
                        *
                        (float) $item['purchase_price'];
                });


            /*
            |--------------------------------------------------------------------------
            | Create Purchase
            |--------------------------------------------------------------------------
            */

            $purchase = Purchase::create([
                'purchase_number' => $purchaseNumber,
                'producer_id' => $validated['producer_id'],
                'purchase_date' => $validated['purchase_date'],
                'status' => 'Completed',
                'total_purchase_cost' => round(
                    $totalPurchaseCost,
                    2
                ),
                'notes' => $validated['notes'] ?? null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Create Purchase Items
            |--------------------------------------------------------------------------
            */

            foreach ($validated['items'] as $item) {

                $quantityIn =
                    (int) $item['quantity_in'];

                $rejectQuantity =
                    (int) $item['reject_quantity'];

                $goodQuantity =
                    $quantityIn - $rejectQuantity;


                /*
                |--------------------------------------------------------------------------
                | Create Purchase Item / FIFO Batch
                |--------------------------------------------------------------------------
                */

                $purchaseItem =
                    $purchase->purchaseItems()->create([

                        'product_id' =>
                            $item['product_id'],

                        'quantity_in' =>
                            $quantityIn,

                        'reject_quantity' =>
                            $rejectQuantity,

                        'good_quantity' =>
                            $goodQuantity,

                        'purchase_price' =>
                            $item['purchase_price'],

                        'remaining_quantity' =>
                            $goodQuantity,

                        'received_at' =>
                            $item['received_at'],
                    ]);


                /*
                |--------------------------------------------------------------------------
                | Update Product Stock
                |--------------------------------------------------------------------------
                */

                $product = Product::query()
                    ->lockForUpdate()
                    ->findOrFail(
                        $item['product_id']
                    );


                $product->increment(
                    'stock',
                    $goodQuantity
                );


                /*
                |--------------------------------------------------------------------------
                | Update Product Status
                |--------------------------------------------------------------------------
                */

                $product->refresh();

                if ($goodQuantity > 0) {

                    $product->update([
                        'status' => 'Available',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | Inventory Movement
                |--------------------------------------------------------------------------
                */

                $product->inventoryMovements()->create([

                    'purchase_item_id' =>
                        $purchaseItem->id,

                    'movement_type' =>
                        'Stock In',

                    'quantity' =>
                        $goodQuantity,

                    'remarks' =>
                        "Wholesale purchase {$purchase->purchase_number}",
                ]);
            }
        });


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.purchases.index')
            ->with(
                'success',
                "Purchase {$purchase->purchase_number} was recorded successfully."
            );
    }


    /*
    |--------------------------------------------------------------------------
    | PURCHASE DETAILS
    |--------------------------------------------------------------------------
    */
    public function show(Purchase $purchase): View
{
    $purchase->load([
        'producer',
        'purchaseItems.product',
        'purchaseItems.fifoAllocations.saleItem.sale',
    ]);

    return view(
        'admin.purchases.show',
        compact('purchase')
    );
}
}