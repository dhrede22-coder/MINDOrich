<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryController extends Controller
{
    /**
     * Add stock to a product.
     */
    public function addStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($validated, $product) {

            $lockedProduct = Product::whereKey($product->id)
                ->lockForUpdate()
                ->firstOrFail();

            $lockedProduct->increment(
    'stock',
    $validated['quantity']
);

            if ($lockedProduct->status !== 'Archived') {

                $lockedProduct->update([
                    'status' => 'Available',
                ]);

            }

            InventoryMovement::create([
                'product_id' => $lockedProduct->id,
                'movement_type' => 'Stock In',
                'quantity' => $validated['quantity'],
                'remarks' => $validated['remarks'] ?? null,
            ]);
        });

        return redirect()
            ->back()
            ->with('success', 'Stock added successfully.');
    }
    /**
 * Remove stock from a product.
 */
public function removeStock(Request $request, Product $product)
{
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1',
        'remarks' => 'nullable|string|max:500',
    ]);

    DB::transaction(function () use ($validated, $product) {

        $lockedProduct = Product::whereKey($product->id)
            ->lockForUpdate()
            ->firstOrFail();

        if ($validated['quantity'] > $lockedProduct->stock) {

            throw ValidationException::withMessages([
                'quantity' => 'Cannot remove more stock than the current stock.'
            ]);

        }

        $newStock = $lockedProduct->stock - $validated['quantity'];

        $lockedProduct->decrement(
    'stock',
    $validated['quantity']
);

if ($newStock == 0) {

    $lockedProduct->update([
        'status' => 'Out of Stock',
    ]);

} else {

    $lockedProduct->update([
        'status' => 'Available',
    ]);

}

        InventoryMovement::create([
            'product_id' => $lockedProduct->id,
            'movement_type' => 'Stock Out',
            'quantity' => $validated['quantity'],
            'remarks' => $validated['remarks'] ?? null,
        ]);
    });

    return redirect()
        ->back()
        ->with('success', 'Stock removed successfully.');
}
    /**
 * Display inventory history for a product.
 */
public function history(Product $product)
{
    $movements = $product->inventoryMovements()
        ->latest()
        ->get();

    return view(
        'admin.products.inventory-history',
        compact('product', 'movements')
    );
}
}
