<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{   public function index(Request $request)
{
    $favorites = $request->user()
        ->favorites()
        ->with([
            'category',
            'producer',
        ])
        ->latest('favorites.created_at')
        ->get();

    return view('customer.favorites', compact('favorites'));
}
    public function toggle(Request $request, Product $product): RedirectResponse
    {
        $user = $request->user();

        if ($user->favorites()->where('products.id', $product->id)->exists()) {
            $user->favorites()->detach($product->id);

            return back()->with(
                'success',
                "{$product->product_name} was removed from your favorites."
            );
        }

        $user->favorites()->attach($product->id);

        return back()->with(
            'success',
            "{$product->product_name} was added to your favorites."
        );
    }
}