<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Sale::with([
            'saleItems.product',
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.orders', compact('orders'));
    }

    public function show(Sale $sale)
    {
        if ($sale->user_id !== auth()->id()) {
            abort(403);
        }

        $sale->load([
            'saleItems.product',
        ]);

        return view('customer.order-show', compact('sale'));
    }

    public function resubmitGcashPayment(Request $request, Sale $sale)
    {
        if ($sale->user_id !== auth()->id()) {
            abort(403);
        }

        if (
            $sale->payment_method !== 'GCash' ||
            $sale->payment_status !== 'Failed'
        ) {
            return redirect()
                ->route('customer.order.show', $sale)
                ->with('error', 'This order is not eligible for GCash resubmission.');
        }

        $validated = $request->validate([
            'gcash_reference' => 'required|string|max:100',
            'gcash_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gcashProofPath = $request->file('gcash_proof')->store(
            'payment_proofs',
            'public'
        );

        $sale->update([
            'gcash_reference' => $validated['gcash_reference'],
            'gcash_proof' => $gcashProofPath,
            'payment_status' => 'Pending',
            'gcash_verified_at' => null,
        ]);

        return redirect()
            ->route('customer.order.show', $sale)
            ->with('success', 'GCash payment proof submitted for review.');
    }

    /*
    |--------------------------------------------------------------------------
    | Cancel Order
    |--------------------------------------------------------------------------
    */

    public function cancel(Sale $sale)
    {
        /*
        |--------------------------------------------------------------------------
        | Make sure this order belongs to the logged-in customer
        |--------------------------------------------------------------------------
        */

        if ($sale->user_id !== auth()->id()) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Only Pending orders can be cancelled
        |--------------------------------------------------------------------------
        */

        if ($sale->status !== 'Pending') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Only pending orders can be cancelled.'
                );
        }

        DB::transaction(function () use ($sale) {

            $sale->load([
                'saleItems.product',
                'saleItems.fifoAllocations',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Return Stock + Restore FIFO Batches
            |--------------------------------------------------------------------------
            */

            foreach ($sale->saleItems as $item) {

                $product = $item->product;

                if (!$product) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Restore Product Stock
                |--------------------------------------------------------------------------
                */

                $product->increment(
                    'stock',
                    $item->quantity
                );

                $product->refresh();

                $product->update([
                    'status' => 'Available',
                ]);

                /*
                |--------------------------------------------------------------------------
                | Restore FIFO Purchase Batches
                |--------------------------------------------------------------------------
                */

                $fifoAllocations = $item->fifoAllocations;

                if ($fifoAllocations->isNotEmpty()) {

                    foreach ($fifoAllocations as $allocation) {

                        $purchaseItem = $allocation
                            ->purchaseItem()
                            ->lockForUpdate()
                            ->first();

                        if (!$purchaseItem) {
                            continue;
                        }

                        $purchaseItem->increment(
                            'remaining_quantity',
                            $allocation->quantity
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | Inventory Movement Per FIFO Batch
                        |--------------------------------------------------------------------------
                        */

                        InventoryMovement::create([
                            'product_id' => $product->id,
                            'sale_id' => $sale->id,
                            'purchase_item_id' => $purchaseItem->id,
                            'movement_type' => 'Returned',
                            'quantity' => $allocation->quantity,
                            'remarks' =>
                                "FIFO stock returned from cancelled order {$sale->sale_number}",
                        ]);
                    }

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Legacy Sale Fallback
                    |--------------------------------------------------------------------------
                    |
                    | Older orders may not have FIFO allocation records.
                    | Their stock is still restored normally.
                    |
                    */

                    InventoryMovement::create([
                        'product_id' => $product->id,
                        'sale_id' => $sale->id,
                        'movement_type' => 'Returned',
                        'quantity' => $item->quantity,
                        'remarks' =>
                            "Stock returned from cancelled order {$sale->sale_number}",
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Cancel Order
            |--------------------------------------------------------------------------
            */

            $sale->update([
                'status' => 'Cancelled',
                'payment_status' => 'Pending',
            ]);
        });

        return redirect()
            ->route('customer.orders')
            ->with(
                'success',
                "Order {$sale->sale_number} has been cancelled successfully."
            );
    }
}