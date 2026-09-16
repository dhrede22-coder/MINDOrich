<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
{
    $cartItems = auth()->user()
        ->cartItems()
        ->with('product')
        ->get();

    $cart = $cartItems->mapWithKeys(function ($item) {
        return [
            $item->product_id => [
                'id' => $item->product->id,
                'name' => $item->product->product_name,
                'price' => $item->product->price,
                'image' => $item->product->featured_image,
                'quantity' => $item->quantity,
            ],
        ];
    })->toArray();

    return view('customer.cart', compact('cart'));
}

   public function add(Request $request, Product $product)
{
    if ($product->status !== 'Available') {
        return back()->with('error', 'This product is currently unavailable.');
    }

    if ($product->stock <= 0) {
        return back()->with('error', 'This product is out of stock.');
    }

    $cartItem = auth()->user()
        ->cartItems()
        ->where('product_id', $product->id)
        ->first();

    if ($cartItem) {
        if ($cartItem->quantity >= $product->stock) {
            return back()->with(
                'error',
                'You cannot add more than the available stock.'
            );
        }

        $cartItem->increment('quantity');
    } else {
        auth()->user()->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    return back()->with('success', 'Product added to cart.');
}

    public function update(Request $request, Product $product)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $cartItem = auth()->user()
        ->cartItems()
        ->where('product_id', $product->id)
        ->first();

    if (!$cartItem) {
        return back()->with(
            'error',
            'Product is not in your cart.'
        );
    }

    if ($request->quantity > $product->stock) {
        return back()->with(
            'error',
            'Quantity cannot exceed available stock.'
        );
    }

    $cartItem->update([
        'quantity' => $request->quantity,
    ]);

    return back()->with('success', 'Cart updated.');
}

    public function remove(Product $product)
{
    $cartItem = auth()->user()
        ->cartItems()
        ->where('product_id', $product->id)
        ->first();

    if ($cartItem) {
        $cartItem->delete();
    }

    return back()->with('success', 'Product removed from cart.');
}

    public function clear()
{
    auth()->user()->cartItems()->delete();

    return back()->with('success', 'Cart cleared.');
}
}