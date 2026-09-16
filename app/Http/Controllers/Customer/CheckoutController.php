<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Setting;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Checkout Page
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        // ======================================================
// CUSTOMER VERIFICATION CHECK
// Only verified customers can proceed to checkout.
// ======================================================
$gcashQrCode = Setting::where('key', 'gcash_qr_code')->value('value');
$user = auth()->user();

if ($user->verification_status !== 'Approved') {
    return redirect()
        ->route('customer.verification.create')
        ->with(
            'error',
            'Please complete your account verification before placing an order.'
        );
}
        /*
        |--------------------------------------------------------------------------
        | BUY NOW
        |--------------------------------------------------------------------------
        */

        if (session()->has('buy_now')) {

            $cart = session()->get('buy_now', []);

            if (empty($cart)) {
                return redirect()
                    ->route('customer.shop')
                    ->with('error', 'Your cart is empty.');
            }

            $subtotal = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            return view('customer.checkout', [
                'cart' => $cart,
                'subtotal' => $subtotal,
                'isBuyNow' => true,
                'gcashQrCode' => $gcashQrCode,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | SELECTED PRODUCTS FROM CART
        |--------------------------------------------------------------------------
        */

        if ($request->filled('selected')) {

            $selectedIds = collect($request->input('selected'))
                ->map(fn ($id) => (int) $id)
                ->filter()
                ->values()
                ->toArray();

            $normalCart = auth()->user()
                ->cartItems()
                ->with('product')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [
                        $item->product_id => [
                            'id' => $item->product->id,
                            'name' => $item->product->product_name,
                            'price' => $item->product->price,
                            'image' => $item->product->featured_image,
                            'quantity' => $item->quantity,
                        ],
                    ];
                })
                ->toArray();

            if (empty($normalCart)) {
                return redirect()
                    ->route('customer.shop')
                    ->with('error', 'Your cart is empty.');
            }

            $selectedCart = [];

            foreach ($normalCart as $id => $item) {

                if (in_array((int) $id, $selectedIds, true)) {
                    $selectedCart[$id] = $item;
                }
            }

            if (empty($selectedCart)) {
                return redirect()
                    ->route('customer.cart')
                    ->with('error', 'Please select at least one product.');
            }

            /*
            |--------------------------------------------------------------------------
            | Store selected products temporarily
            |--------------------------------------------------------------------------
            */

            session()->put(
                'checkout_selected',
                $selectedCart
            );

            $cart = $selectedCart;

            $subtotal = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            return view('customer.checkout', [
                'cart' => $cart,
                'subtotal' => $subtotal,
                'isBuyNow' => false,
                'gcashQrCode' => $gcashQrCode,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | EXISTING SELECTED CHECKOUT SESSION
        |--------------------------------------------------------------------------
        |
        | This allows the customer to refresh the checkout page
        | without losing the selected products.
        |
        */

        if (session()->has('checkout_selected')) {

            $cart = session()->get('checkout_selected', []);

            if (empty($cart)) {
                return redirect()
                    ->route('customer.cart')
                    ->with('error', 'Please select products from your cart.');
            }

            $subtotal = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            return view('customer.checkout', [
                'cart' => $cart,
                'subtotal' => $subtotal,
                'isBuyNow' => false,
                'gcashQrCode' => $gcashQrCode,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL CART
        |--------------------------------------------------------------------------
        */

        $cart = auth()->user()
            ->cartItems()
            ->with('product')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->product_id => [
                        'id' => $item->product->id,
                        'name' => $item->product->product_name,
                        'price' => $item->product->price,
                        'image' => $item->product->featured_image,
                        'quantity' => $item->quantity,
                    ],
                ];
            })
            ->toArray();

        if (empty($cart)) {
            return redirect()
                ->route('customer.shop')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('customer.checkout', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'isBuyNow' => false,
            'gcashQrCode' => $gcashQrCode,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | BUY NOW
    |--------------------------------------------------------------------------
    */

    public function buyNow(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = (int) $validated['quantity'];


        /*
        |--------------------------------------------------------------------------
        | Check Product
        |--------------------------------------------------------------------------
        */

        if ($product->status !== 'Available') {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'This product is no longer available.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Check Stock
        |--------------------------------------------------------------------------
        */

        if ($quantity > $product->stock) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    "Only {$product->stock} item(s) are available."
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Clear Previous Checkout Sessions
        |--------------------------------------------------------------------------
        */

        session()->forget('checkout_selected');


        /*
        |--------------------------------------------------------------------------
        | Store Buy Now Separately
        |--------------------------------------------------------------------------
        */

        $buyNow = [
            $product->id => [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => (float) $product->price,
                'image' => $product->featured_image,
                'quantity' => $quantity,
            ],
        ];

        session()->put('buy_now', $buyNow);


        /*
        |--------------------------------------------------------------------------
        | Go Directly To Checkout
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('customer.checkout');
    }


    /*
    |--------------------------------------------------------------------------
    | PLACE ORDER
    |--------------------------------------------------------------------------
    */

    public function placeOrder(Request $request)
    {
            // ======================================================
    // CUSTOMER VERIFICATION CHECK
    // Prevent unverified customers from placing orders.
    // ======================================================

    $user = auth()->user();

    if ($user->verification_status !== 'Approved') {
        return redirect()
            ->route('customer.verification.create')
            ->with(
                'error',
                'Your account must be verified before you can place an order.'
            );
    }
       $validated = $request->validate([
    'payment_method' => 'required|in:COD,GCash',
    'gcash_reference' => 'required_if:payment_method,GCash|nullable|string|max:100',
    'gcash_proof' => 'required_if:payment_method,GCash|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    'notes' => 'nullable|string|max:1000',
]);


        /*
        |--------------------------------------------------------------------------
        | Determine Checkout Source
        |--------------------------------------------------------------------------
        */

        $isBuyNow = session()->has('buy_now');
        $isSelectedCheckout = session()->has('checkout_selected');


        if ($isBuyNow) {

            $cart = session()->get('buy_now', []);

        } elseif ($isSelectedCheckout) {

            $cart = session()->get('checkout_selected', []);

        } else {

            $cart = session()->get('cart', []);
        }


        /*
        |--------------------------------------------------------------------------
        | Empty Check
        |--------------------------------------------------------------------------
        */

        if (empty($cart)) {

            return redirect()
                ->route('customer.shop')
                ->with(
                    'error',
                    'Your cart is empty.'
                );
        }

$gcashProofPath = null;

if ($request->hasFile('gcash_proof')) {
    $gcashProofPath = $request->file('gcash_proof')->store(
        'payment_proofs',
        'public'
    );
}
        try {

            $sale = DB::transaction(function () use (
    $cart,
    $validated,
    $gcashProofPath
) {

                $productIds = array_keys($cart);


                /*
                |--------------------------------------------------------------------------
                | Lock Products
                |--------------------------------------------------------------------------
                */

                $products = Product::whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');


                if ($products->count() !== count($productIds)) {

                    throw ValidationException::withMessages([
                        'cart' =>
                            'One or more products are no longer available.',
                    ]);
                }


                $totalAmount = 0;
                $lineItems = [];


                /*
                |--------------------------------------------------------------------------
                | Validate Products
                |--------------------------------------------------------------------------
                */

                foreach ($cart as $item) {

                    $product = $products->get($item['id']);

                    $quantity = (int) $item['quantity'];


                    if (!$product) {

                        throw ValidationException::withMessages([
                            'cart' =>
                                'A product in your cart could not be found.',
                        ]);
                    }


                    if ($product->status !== 'Available') {

                        throw ValidationException::withMessages([
                            'cart' =>
                                "{$product->product_name} is no longer available.",
                        ]);
                    }


                    if ($quantity > $product->stock) {

                        throw ValidationException::withMessages([
                            'cart' =>
                                "Insufficient stock for {$product->product_name}.",
                        ]);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Always Use Current Database Price
                    |--------------------------------------------------------------------------
                    */

                    $price = (float) $product->price;

                    $subtotal = round(
                        $price * $quantity,
                        2
                    );


                    $lineItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $subtotal,
                    ];


                    $totalAmount = round(
                        $totalAmount + $subtotal,
                        2
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Generate Order Number
                |--------------------------------------------------------------------------
                */

                do {

                    $saleNumber =
                        'ORD-' .
                        now()->format('Ymd-His') .
                        '-' .
                        random_int(1000, 9999);

                } while (
                    Sale::where(
                        'sale_number',
                        $saleNumber
                    )->exists()
                );


                /*
                |--------------------------------------------------------------------------
                | Create Sale
                |--------------------------------------------------------------------------
                */

                $sale = Sale::create([
    'sale_number' => $saleNumber,
    'user_id' => auth()->id(),
    'sale_type' => 'Online',
    'payment_method' =>
        $validated['payment_method'],
    'payment_status' => 'Pending',
    'status' => 'Pending',
    'total_amount' => $totalAmount,
    'notes' =>
        $validated['notes'] ?? null,
    'gcash_reference' =>
        $validated['gcash_reference'] ?? null,
    'gcash_proof' => $gcashProofPath,
]);


                /*
                |--------------------------------------------------------------------------
                | Create Sale Items + Update Inventory
                |--------------------------------------------------------------------------
                */

                foreach ($lineItems as $lineItem) {

                    $product = $lineItem['product'];

                    $newStock =
                        $product->stock -
                        $lineItem['quantity'];


                    /*
                    |--------------------------------------------------------------------------
                    | Sale Item
                    |--------------------------------------------------------------------------
                    */

                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' =>
                            $lineItem['quantity'],
                        'price' =>
                            $lineItem['price'],
                        'subtotal' =>
                            $lineItem['subtotal'],
                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Update Product Stock
                    |--------------------------------------------------------------------------
                    */

                    $product->update([
                        'stock' => $newStock,

                        'status' =>
                            $newStock === 0
                                ? 'Out of Stock'
                                : 'Available',
                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Inventory Movement
                    |--------------------------------------------------------------------------
                    */

                    InventoryMovement::create([
                        'product_id' => $product->id,
                        'sale_id' => $sale->id,
                        'movement_type' => 'Online Sale',
                        'quantity' =>
                            $lineItem['quantity'],
                        'remarks' =>
                            "Order {$sale->sale_number}",
                    ]);
                }


                return $sale;
            });
            auth()->user()->notify(
    new \App\Notifications\OrderNotification(
        $sale,
        'Order Placed',
        "Your order {$sale->sale_number} has been placed successfully."
    )
);


            /*
            |--------------------------------------------------------------------------
            | CLEAR CHECKOUT SOURCE
            |--------------------------------------------------------------------------
            */

            if ($isBuyNow) {

                /*
                | Buy Now does NOT touch normal cart.
                */

                session()->forget('buy_now');

            } elseif ($isSelectedCheckout) {

                /*
                |--------------------------------------------------------------------------
                | Remove ONLY Purchased Products
                |--------------------------------------------------------------------------
                */

                auth()->user()
                    ->cartItems()
                    ->whereIn('product_id', array_keys($cart))
                    ->delete();

                /*
                |--------------------------------------------------------------------------
                | Clear Selected Checkout Session
                |--------------------------------------------------------------------------
                */

                session()->forget(
                    'checkout_selected'
                );

            } else {

                /*
                | Normal checkout = clear entire cart.
                */

                auth()->user()
                    ->cartItems()
                    ->delete();
            }


            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route(
                    'customer.checkout.success',
                    $sale
                )
                ->with(
                    'success',
                    'Purchase successful!'
                );


        } catch (ValidationException $exception) {

            throw $exception;

        } catch (\Throwable $exception) {

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'cart' =>
                        'Unable to place your order. Please try again.',
                ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Checkout Success
    |--------------------------------------------------------------------------
    */

    public function success(Sale $sale)
    {
        if ($sale->user_id !== auth()->id()) {
            abort(403);
        }


        $sale->load([
            'saleItems.product',
        ]);


        return view(
            'customer.checkout-success',
            compact('sale')
        );
    }
}