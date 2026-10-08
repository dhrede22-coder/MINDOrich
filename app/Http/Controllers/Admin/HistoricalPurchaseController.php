<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoricalPurchase;
use App\Models\Producer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricalPurchaseController extends Controller
{
    public function index()
    {
        $historicalPurchases = HistoricalPurchase::with([
            'producer',
            'items.product',
        ])
        ->latest('purchase_date')
        ->get();

        return view(
            'admin.historical-purchases.index',
            compact('historicalPurchases')
        );
    }

    public function create()
    {
        $producers = Producer::orderBy('producer_name')->get();
        $products = Product::orderBy('product_name')->get();

        return view(
            'admin.historical-purchases.create',
            compact('producers', 'products')
        );
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'purchase_number' => ['required', 'string', 'max:255', 'unique:historical_purchases,purchase_number'],
        'producer_id' => ['required', 'exists:producers,id'],
        'purchase_date' => ['required', 'date'],
        'status' => ['required', 'in:Completed'],
        'notes' => ['nullable', 'string'],

        'items' => ['required', 'array', 'min:1'],
        'items.*.product_id' => ['required', 'exists:products,id'],
        'items.*.quantity_in' => ['required', 'integer', 'min:1'],
        'items.*.reject_quantity' => ['required', 'integer', 'min:0'],
        'items.*.purchase_price' => ['required', 'numeric', 'min:0'],
    ]);

    foreach ($validated['items'] as $index => $item) {
        if ((int) $item['reject_quantity'] > (int) $item['quantity_in']) {
            return back()
                ->withInput()
                ->withErrors([
                    "items.$index.reject_quantity" =>
                        'Reject quantity cannot be greater than quantity in.',
                ]);
        }
    }

    $totalPurchaseCost = 0;

    foreach ($validated['items'] as $item) {
        $totalPurchaseCost +=
            (int) $item['quantity_in'] *
            (float) $item['purchase_price'];
    }

    $historicalPurchase = HistoricalPurchase::create([
        'purchase_number' => $validated['purchase_number'],
        'producer_id' => $validated['producer_id'],
        'purchase_date' => $validated['purchase_date'],
        'status' => $validated['status'],
        'total_purchase_cost' => $totalPurchaseCost,
        'notes' => $validated['notes'] ?? null,
    ]);

    foreach ($validated['items'] as $item) {
        $quantityIn = (int) $item['quantity_in'];
        $rejectQuantity = (int) $item['reject_quantity'];
        $goodQuantity = $quantityIn - $rejectQuantity;

        $historicalPurchase->items()->create([
            'product_id' => $item['product_id'],
            'quantity_in' => $quantityIn,
            'reject_quantity' => $rejectQuantity,
            'good_quantity' => $goodQuantity,
            'purchase_price' => $item['purchase_price'],
            'remaining_quantity' => $goodQuantity,
            'received_at' => $validated['purchase_date'],
        ]);
    }

    return redirect()
        ->route('historical-purchases.index')
        ->with('success', 'Historical purchase recorded successfully.');
}

   public function show(HistoricalPurchase $historicalPurchase)
{
    $historicalPurchase->load([
        'producer',
        'items.product',
        'items.fifoAllocations',
    ]);

    return view(
        'admin.historical-purchases.show',
        compact('historicalPurchase')
    );
}

public function edit(HistoricalPurchase $historicalPurchase)
{
    if (
        $historicalPurchase->items()
            ->whereHas('fifoAllocations')
            ->exists()
    ) {
        return redirect()
            ->route('historical-purchases.show', $historicalPurchase)
            ->with('error', 'This historical purchase cannot be edited because it is already used by a historical sale.');
    }

    $historicalPurchase->load('items');

    $producers = Producer::orderBy('producer_name')->get();
    $products = Product::orderBy('product_name')->get();

    return view(
        'admin.historical-purchases.edit',
        compact(
            'historicalPurchase',
            'producers',
            'products'
        )
    );
}

public function update(
    Request $request,
    HistoricalPurchase $historicalPurchase
) {
    if (
        $historicalPurchase->items()
            ->whereHas('fifoAllocations')
            ->exists()
    ) {
        return redirect()
            ->route('historical-purchases.show', $historicalPurchase)
            ->with('error', 'This historical purchase cannot be edited because it is already used by a historical sale.');
    }

    $validated = $request->validate([
        'purchase_number' => [
            'required',
            'string',
            'max:255',
            'unique:historical_purchases,purchase_number,' . $historicalPurchase->id,
        ],

        'producer_id' => [
            'required',
            'exists:producers,id',
        ],

        'purchase_date' => [
            'required',
            'date',
        ],

        'status' => [
            'required',
            'in:Completed',
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
    ]);

    foreach ($validated['items'] as $index => $item) {
        if (
            (int) $item['reject_quantity']
            >
            (int) $item['quantity_in']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    "items.$index.reject_quantity" =>
                        'Reject quantity cannot be greater than quantity in.',
                ]);
        }
    }

    DB::transaction(function () use (
        $validated,
        $historicalPurchase
    ) {
        $totalPurchaseCost = 0;

        foreach ($validated['items'] as $item) {
            $totalPurchaseCost +=
                (int) $item['quantity_in']
                *
                (float) $item['purchase_price'];
        }

        $historicalPurchase->update([
            'purchase_number' => $validated['purchase_number'],
            'producer_id' => $validated['producer_id'],
            'purchase_date' => $validated['purchase_date'],
            'status' => $validated['status'],
            'total_purchase_cost' => $totalPurchaseCost,
            'notes' => $validated['notes'] ?? null,
        ]);

        $historicalPurchase->items()->delete();

        foreach ($validated['items'] as $item) {

            $quantityIn = (int) $item['quantity_in'];

            $rejectQuantity = (int) $item['reject_quantity'];

            $goodQuantity =
                $quantityIn - $rejectQuantity;

            $historicalPurchase->items()->create([
                'product_id' => $item['product_id'],
                'quantity_in' => $quantityIn,
                'reject_quantity' => $rejectQuantity,
                'good_quantity' => $goodQuantity,
                'purchase_price' => $item['purchase_price'],
                'remaining_quantity' => $goodQuantity,
                'received_at' => $validated['purchase_date'],
            ]);
        }
    });

    return redirect()
        ->route('historical-purchases.show', $historicalPurchase)
        ->with(
            'success',
            'Historical purchase updated successfully.'
        );
}

public function destroy(HistoricalPurchase $historicalPurchase)
{
    if (
        $historicalPurchase->items()
            ->whereHas('fifoAllocations')
            ->exists()
    ) {
        return redirect()
            ->route('historical-purchases.show', $historicalPurchase)
            ->with(
                'error',
                'This historical purchase cannot be deleted because it is already used by a historical sale.'
            );
    }

    $historicalPurchase->delete();

    return redirect()
        ->route('historical-purchases.index')
        ->with(
            'success',
            'Historical purchase deleted successfully.'
        );
}
}