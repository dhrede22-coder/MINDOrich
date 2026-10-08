<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryController extends Controller
{
    /**
     * Remove stock from a product using FIFO batches.
     */
    public function removeStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use (
            $validated,
            $product
        ) {

            /*
            |--------------------------------------------------------------------------
            | LOCK PRODUCT
            |--------------------------------------------------------------------------
            */

            $lockedProduct = Product::query()
                ->lockForUpdate()
                ->findOrFail($product->id);


            /*
            |--------------------------------------------------------------------------
            | GET FIFO BATCHES
            |--------------------------------------------------------------------------
            |
            | Oldest purchase batches are consumed first.
            |
            */

            $purchaseItems = PurchaseItem::query()
                ->where('product_id', $lockedProduct->id)
                ->where('remaining_quantity', '>', 0)
                ->whereHas('purchase', function ($query) {
                    $query->where('status', 'Completed');
                })
                ->orderBy('received_at')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();


            $fifoAvailable = $purchaseItems->sum(
                'remaining_quantity'
            );


            /*
            |--------------------------------------------------------------------------
            | VALIDATE FIFO STOCK
            |--------------------------------------------------------------------------
            */

            if ((int) $validated['quantity'] > $fifoAvailable) {

                throw ValidationException::withMessages([
                    'quantity' =>
                        'Cannot remove more stock than the available FIFO-costed stock. Please check the product purchase batches first.',
                ]);
            }


            $quantityToRemove =
                (int) $validated['quantity'];


            $remainingToRemove =
                $quantityToRemove;


            /*
            |--------------------------------------------------------------------------
            | CONSUME FIFO BATCHES
            |--------------------------------------------------------------------------
            */

            foreach ($purchaseItems as $purchaseItem) {

                if ($remainingToRemove <= 0) {
                    break;
                }


                $availableInBatch =
                    (int) $purchaseItem->remaining_quantity;


                $quantityFromBatch = min(
                    $availableInBatch,
                    $remainingToRemove
                );


                /*
                |--------------------------------------------------------------------------
                | Reduce Purchase Batch
                |--------------------------------------------------------------------------
                */

                $purchaseItem->decrement(
                    'remaining_quantity',
                    $quantityFromBatch
                );


                /*
                |--------------------------------------------------------------------------
                | Record Stock Out Movement
                |--------------------------------------------------------------------------
                */

                InventoryMovement::create([
                    'product_id' =>
                        $lockedProduct->id,

                    'purchase_item_id' =>
                        $purchaseItem->id,

                    'movement_type' =>
                        'Stock Out',

                    'quantity' =>
                        $quantityFromBatch,

                    'remarks' =>
                        $validated['remarks']
                        ?? 'Manual FIFO stock removal',
                ]);


                $remainingToRemove -=
                    $quantityFromBatch;
            }


            /*
            |--------------------------------------------------------------------------
            | Update Product Stock
            |--------------------------------------------------------------------------
            */

            $lockedProduct->decrement(
                'stock',
                $quantityToRemove
            );


            /*
            |--------------------------------------------------------------------------
            | Update Product Status
            |--------------------------------------------------------------------------
            */

            $lockedProduct->refresh();

            if (
                $lockedProduct->stock <= 0
                &&
                $lockedProduct->status !== 'Archived'
            ) {

                $lockedProduct->update([
                    'status' => 'Out of Stock',
                ]);

            } elseif (
                $lockedProduct->stock > 0
                &&
                $lockedProduct->status !== 'Archived'
            ) {

                $lockedProduct->update([
                    'status' => 'Available',
                ]);
            }
        });


        return redirect()
            ->back()
            ->with(
                'success',
                'Stock removed successfully using FIFO batches.'
            );
    }


    /**
     * Display inventory history for a product.
     */
    public function history(Product $product)
    {
        $movements = $product->inventoryMovements()
            ->with([
                'purchaseItem.purchase',
            ])
            ->latest()
            ->get();

        return view(
            'admin.products.inventory-history',
            compact(
                'product',
                'movements'
            )
        );
    }
}