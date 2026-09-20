<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Producer;
use App\Models\User;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $query = Product::with(['producer', 'category']);

    // Search by Product Name
    if ($request->filled('search')) {

        $query->where(
            'product_name',
            'like',
            '%' . $request->search . '%'
        );

    }

    // Filter by Category
    if ($request->filled('category')) {

        $query->where(
            'category_id',
            $request->category
        );

    }

    // Filter by Craftsman
    if ($request->filled('producer')) {

        $query->where(
            'producer_id',
            $request->producer
        );

    }

    // Filter by Status
    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );

    }

    $products = $request->boolean('all')
    ? $query->latest()->get()
    : $query->latest()->limit(10)->get();

    // Statistics
    $totalProducts = Product::count();

    $availableProducts = Product::where(
        'status',
        'Available'
    )->count();

    $lowStockProducts = Product::whereColumn(
        'stock',
        '<=',
        'minimum_stock'
    )
    ->where('stock', '>', 0)
    ->count();

    $totalCategories = Category::count();

    // Filter Options
    $categories = Category::orderBy(
        'category_name'
    )->get();

    $producers = Producer::orderBy(
        'producer_name'
    )->get();

    return view(
        'admin.products.index',
        compact(
            'products',
            'categories',
            'producers',
            'totalProducts',
            'availableProducts',
            'lowStockProducts',
            'totalCategories'
        )
    );
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $categories = Category::orderBy('category_name')->get();

    $producers = Producer::orderBy('producer_name')->get();

    return view('admin.products.create', compact(
        'categories',
        'producers'
    ));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'producer_id' => 'required|exists:producers,id',
        'category_id' => 'required|exists:categories,id',
        'product_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'minimum_stock' => 'required|integer|min:0',
        'status' => 'required|in:Available,Out of Stock,Archived',
        'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($request->hasFile('featured_image')) {

        $validated['featured_image'] =
            $request->file('featured_image')->store(
                'products',
                'public'
            );

    }

    $product = Product::create($validated);

    User::whereHas('role', function ($query) {
    $query->where('name', 'Customer');
})
->where('verification_status', 'Approved')
->where('product_notifications', true)
->get()
->each(function ($customer) use ($product) {
    $customer->notify(
        new \App\Notifications\CustomerNotification(
            'New Product Available',
            "A new product, {$product->product_name}, has been added to MINDOrich.",
            'product',
            $product->id
        )
    );
});

    return redirect()
        ->route('products.index')
        ->with('success', 'Product added successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
{
    $product->load([
        'producer',
        'category',
    ]);

    return view(
        'admin.products.show',
        compact('product')
    );
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
{
    $categories = Category::orderBy('category_name')->get();

    $producers = Producer::orderBy('producer_name')->get();

    return view(
        'admin.products.edit',
        compact(
            'product',
            'categories',
            'producers'
        )
    );
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'producer_id' => 'required|exists:producers,id',
        'category_id' => 'required|exists:categories,id',
        'product_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'minimum_stock' => 'required|integer|min:0',
        'status' => 'required|in:Available,Out of Stock,Archived',
        'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($request->hasFile('featured_image')) {

        $validated['featured_image'] =
            $request->file('featured_image')->store(
                'products',
                'public'
            );
    }

    $product->update($validated);

    return redirect()
        ->route('products.index')
        ->with('success', 'Product updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
{
    if ($product->inventoryMovements()->exists()) {

        return redirect()
            ->back()
            ->withErrors([
                'delete' => 'This product cannot be deleted because it has inventory history.'
            ]);
    }

    if ($product->saleItems()->exists()) {

        return redirect()
            ->back()
            ->withErrors([
                'delete' => 'This product cannot be deleted because it has sales records.'
            ]);
    }

    $product->productImages()->delete();

    $product->delete();

    return redirect()
        ->route('products.index')
        ->with('success', 'Product deleted successfully.');
}
}
