<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, SaleItem $saleItem)
    {
        $user = Auth::user();

        $sale = $saleItem->sale;

        /*
        |--------------------------------------------------------------------------
        | CHECK ORDER OWNERSHIP
        |--------------------------------------------------------------------------
        */
        if (!$sale || $sale->user_id !== $user->id) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK REVIEW ELIGIBILITY
        |--------------------------------------------------------------------------
        */
        if (
            $sale->sale_type !== 'Online' ||
            $sale->status !== 'Delivered'
        ) {
            return back()->with(
                'error',
                'You can only review products from delivered online orders.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PREVENT DUPLICATE REVIEW
        |--------------------------------------------------------------------------
        */
        if ($saleItem->review()->exists()) {
            return back()->with(
                'error',
                'You have already reviewed this product.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATE REVIEW
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([
            'rating' => [
                'required',
                'integer',
                'between:1,5',
            ],
            'body' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE REVIEW
        |--------------------------------------------------------------------------
        */
        ProductReview::create([
            'user_id' => $user->id,
            'product_id' => $saleItem->product_id,
            'sale_id' => $sale->id,
            'sale_item_id' => $saleItem->id,
            'rating' => $validated['rating'],
            'body' => $validated['body'] ?? null,
        ]);

        return back()->with(
            'success',
            'Your review has been submitted successfully.'
        );
    }
}