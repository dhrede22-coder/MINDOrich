<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'producer'])
            ->where('status', 'Available');

        // Search by product name
        if ($request->filled('search')) {
            $query->where(
                'product_name',
                'like',
                '%' . $request->search . '%'
            );
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where(
                'category_id',
                $request->category
            );
        }

        // Price filter
        if ($request->filled('min_price')) {
            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        if ($request->filled('max_price')) {
            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        // Sorting
        switch ($request->get('sort')) {

            case 'price_low':
                $query->orderBy('price', 'asc');
                break;

            case 'price_high':
                $query->orderBy('price', 'desc');
                break;

            case 'latest':
                $query->latest();
                break;

            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::orderBy('category_name')->get();

        return view('customer.shop', compact(
            'products',
            'categories'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Product Details
    |--------------------------------------------------------------------------
    */

    public function show(Product $product)
    {
        // Only available products can be viewed
        abort_if($product->status !== 'Available', 404);

        // Load product information and images
        $product->load([
            'category',
            'producer',
            'productImages'
        ]);

        // Related products
        $relatedProducts = Product::with([
                'category',
                'producer'
            ])
            ->where('status', 'Available')
            ->where('id', '!=', $product->id)
            ->when($product->category_id, function ($query) use ($product) {
                $query->where(
                    'category_id',
                    $product->category_id
                );
            })
            ->latest()
            ->limit(8)
            ->get();

        return view(
            'customer.product-details',
            compact(
                'product',
                'relatedProducts'
            )
        );
    }
}