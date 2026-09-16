<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Sale::with([
            'user',
            'saleItems.product',
        ]);

        // Search by Sale Number
        if ($request->filled('search')) {

            $query->where(
                'sale_number',
                'like',
                '%' . $request->search . '%'
            );
        }

        // Filter by Sale Type
        if ($request->filled('sale_type')) {

            $query->where(
                'sale_type',
                $request->sale_type
            );
        }

        // Filter by Status
        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        // Filter by Payment Status
        if ($request->filled('payment_status')) {

            $query->where(
                'payment_status',
                $request->payment_status
            );
        }

        $orders = $request->boolean('all')
    ? $query->latest()->get()
    : $query->latest()->limit(10)->get();

// Order Statistics
$totalOrders = Sale::count();

$pendingOrders = Sale::where(
    'status',
    'Pending'
)->count();

$processingOrders = Sale::where(
    'status',
    'Processing'
)->count();

$completedOrders = Sale::where(
    'status',
    'Completed'
)->count();

return view(
    'admin.orders.index',
    compact(
        'orders',
        'totalOrders',
        'pendingOrders',
        'processingOrders',
        'completedOrders'
    )
);

    }
    /**
 * Show the form for creating a new order.
 */
public function create()
{
    $products = Product::with([
        'category',
        'producer',
    ])
    ->where(
        'stock',
        '>',
        0
    )
    ->where(
        'status',
        'Available'
    )
    ->orderBy(
        'product_name'
    )
    ->get();

    $categories = Category::orderBy(
        'category_name'
    )->get();

    $productData = $products->map(function ($product) {
    return [
        'id' => $product->id,
        'name' => $product->product_name,
        'description' => $product->description ?? 'No description available.',
        'price' => (float) $product->price,
        'stock' => (int) $product->stock,
        'category_id' => $product->category_id,
        'category' => $product->category->category_name ?? 'Uncategorized',
        'producer' => $product->producer->producer_name ?? '—',
        'image' => $product->featured_image
            ? asset('storage/' . $product->featured_image)
            : null,
    ];
})->values();

    return view(
        'admin.orders.create',
        compact(
            'products',
            'categories',
            'productData'
        )
    );
}

public function store(Request $request)
{
    $validated = $request->validate([
        'sale_type' => 'required|in:Walk-in',
        'user_id' => 'nullable|exists:users,id',
        'payment_method' => 'required|in:Cash,GCash',
        'notes' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    $quantitiesByProductId = [];

    foreach ($validated['items'] as $item) {
        $productId = (int) $item['product_id'];
        $quantity = (int) $item['quantity'];

        $quantitiesByProductId[$productId] =
            ($quantitiesByProductId[$productId] ?? 0) + $quantity;
    }

    try {
        $sale = DB::transaction(function () use (
            $validated,
            $quantitiesByProductId
        ) {
            $productIds = array_keys($quantitiesByProductId);

            $products = Product::whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== count($productIds)) {
                throw ValidationException::withMessages([
                    'items' => 'One or more selected products are no longer available.',
                ]);
            }

            $lineItems = [];
            $totalAmount = 0;

            foreach ($quantitiesByProductId as $productId => $quantity) {
                $product = $products->get($productId);

                if ($product->status !== 'Available') {
                    throw ValidationException::withMessages([
                        'items' => "{$product->product_name} is not currently available for sale.",
                    ]);
                }

                if ($quantity > $product->stock) {
                    throw ValidationException::withMessages([
                        'items' => "Insufficient stock for {$product->product_name}.",
                    ]);
                }

                $price = (float) $product->price;
                $subtotal = round($price * $quantity, 2);

                $lineItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];

                $totalAmount = round($totalAmount + $subtotal, 2);
            }

            do {
                $saleNumber = 'ORD-' . now()->format('Ymd-His') . '-'
                    . random_int(1000, 9999);
            } while (Sale::where('sale_number', $saleNumber)->exists());

            $sale = Sale::create([
                'sale_number' => $saleNumber,
                'user_id' => $validated['user_id'] ?? null,
                'sale_type' => $validated['sale_type'],
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'Paid',
                'status' => 'Completed',
                'total_amount' => $totalAmount,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($lineItems as $lineItem) {
    $product = $lineItem['product'];
    $newStock = $product->stock - $lineItem['quantity'];

    SaleItem::create([
        'sale_id' => $sale->id,
        'product_id' => $product->id,
        'quantity' => $lineItem['quantity'],
        'price' => $lineItem['price'],
        'subtotal' => $lineItem['subtotal'],
    ]);

    $product->update([
        'stock' => $newStock,
        'status' => $newStock === 0
            ? 'Out of Stock'
            : 'Available',
    ]);

    InventoryMovement::create([
        'product_id' => $product->id,
        'sale_id' => $sale->id,
        'movement_type' => 'Walk-in Sale',
        'quantity' => $lineItem['quantity'],
        'remarks' => "Walk-in Sale {$sale->sale_number}",
    ]);
}

            return $sale;
        });
    } catch (ValidationException $exception) {
        throw $exception;
    } catch (\Throwable $exception) {
        return redirect()
            ->back()
            ->withInput()
            ->withErrors([
                'items' => 'Unable to create the order. Please try again.',
            ]);
    }

    return redirect()
        ->route('orders.show', $sale)
        ->with('success', 'Order created successfully.');
}

    /**
 * Display the specified order.
 */
public function show(Sale $sale)
{
    $sale->load([
        'user',
        'saleItems.product',
    ]);

    return view(
        'admin.orders.show',
        compact('sale')
    );
}
public function receipt(Sale $sale)
{
    $sale->load([
        'user',
        'saleItems.product',
    ]);

    return view(
        'admin.orders.receipt',
        compact('sale')
    );
}
public function updateStatus(Request $request, Sale $sale)
{
    $validated = $request->validate([
        'status' => 'required|in:Pending,Processing,Completed,Cancelled',
    ]);

    $sale->update([
        'status' => $validated['status'],
    ]);

    return redirect()
        ->route('orders.show', $sale)
        ->with('success', 'Order status updated successfully.');
}

public function verifyGcash(Sale $sale)
{
    $sale->update([
        'payment_status' => 'Paid',
        'gcash_verified_at' => now(),
    ]);

    return redirect()
        ->route('orders.show', $sale)
        ->with('success', 'GCash payment verified successfully.');
}

public function rejectGcash(Sale $sale)
{
    $sale->update([
        'payment_status' => 'Failed',
        'gcash_verified_at' => null,
    ]);

    return redirect()
        ->route('orders.show', $sale)
        ->with('success', 'GCash payment rejected.');
}
}
