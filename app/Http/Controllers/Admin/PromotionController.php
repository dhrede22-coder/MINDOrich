<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PromotionController extends Controller
{
    public function index(): View
    {
        $promotions = Promotion::withCount('products')
            ->latest()
            ->get();

        return view(
            'admin.promotions.index',
            compact('promotions')
        );
    }

    public function create(): View
    {
        $products = Product::orderBy('product_name')->get();

        return view(
            'admin.promotions.create',
            compact('products')
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'discount_type' => [
                'required',
                'in:percentage,fixed',
            ],

            'discount_value' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'starts_at' => [
                'nullable',
                'date',
            ],

            'ends_at' => [
                'nullable',
                'date',
                'after_or_equal:starts_at',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'product_ids' => [
                'nullable',
                'array',
            ],

            'product_ids.*' => [
                'integer',
                'exists:products,id',
            ],
        ]);

        DB::transaction(function () use ($validated) {

            $promotion = Promotion::create([
                'name' => $validated['name'],
                'discount_type' => $validated['discount_type'],
                'discount_value' => $validated['discount_value'],
                'starts_at' => $validated['starts_at'] ?? null,
                'ends_at' => $validated['ends_at'] ?? null,
                'status' => $validated['status'],
            ]);

            $promotion->products()->sync(
                $validated['product_ids'] ?? []
            );
        });

        return redirect()
            ->route('promotions.index')
            ->with(
                'success',
                'Promotion created successfully.'
            );
    }

    public function edit(Promotion $promotion): View
    {
        $products = Product::orderBy('product_name')->get();

        $promotion->load('products');

        return view(
            'admin.promotions.edit',
            compact(
                'promotion',
                'products'
            )
        );
    }

    public function update(
        Request $request,
        Promotion $promotion
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'discount_type' => [
                'required',
                'in:percentage,fixed',
            ],

            'discount_value' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'starts_at' => [
                'nullable',
                'date',
            ],

            'ends_at' => [
                'nullable',
                'date',
                'after_or_equal:starts_at',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'product_ids' => [
                'nullable',
                'array',
            ],

            'product_ids.*' => [
                'integer',
                'exists:products,id',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $promotion
        ) {
            $promotion->update([
                'name' => $validated['name'],
                'discount_type' => $validated['discount_type'],
                'discount_value' => $validated['discount_value'],
                'starts_at' => $validated['starts_at'] ?? null,
                'ends_at' => $validated['ends_at'] ?? null,
                'status' => $validated['status'],
            ]);

            $promotion->products()->sync(
                $validated['product_ids'] ?? []
            );
        });

        return redirect()
            ->route('promotions.index')
            ->with(
                'success',
                'Promotion updated successfully.'
            );
    }

    public function destroy(Promotion $promotion): RedirectResponse
    {
        $promotion->delete();

        return redirect()
            ->route('promotions.index')
            ->with(
                'success',
                'Promotion deleted successfully.'
            );
    }
}