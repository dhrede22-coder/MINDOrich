@extends('customer.layouts.customer')

@section('title', 'My Cart')

@section('content')

<style>
    /* =====================================================
       CART PAGE
       Scoped para hindi maapektuhan ang ibang customer pages
    ===================================================== */

    .cart-page {
        background: #f7f8fc;
        min-height: 100vh;
        padding: 50px 0 80px;
    }

    .cart-container {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ================= HEADER ================= */

    .cart-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 30px;
    }

    .cart-label {
        color: #d99a00;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 7px;
    }

    .cart-header h1 {
        margin: 0;
        color: #242424;
        font-size: 34px;
        font-weight: 700;
    }

    .cart-header p {
        margin: 7px 0 0;
        color: #777;
        font-size: 15px;
    }

    .continue-shopping {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 18px;
        border: 1px solid #e1ad24;
        border-radius: 9px;
        background: #fff;
        color: #b47d00;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: .2s ease;
    }

    .continue-shopping:hover {
        background: #e7a900;
        border-color: #e7a900;
        color: #fff;
    }

    /* ================= ALERT ================= */

    .cart-alert {
        border: none;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    /* ================= CART CARD ================= */

    .cart-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 14px;
        transition: .2s ease;
    }

    .cart-card:hover {
        border-color: #e3c66c;
        box-shadow: 0 8px 25px rgba(0,0,0,.05);
    }

    .cart-card-body {
        padding: 20px 22px;
    }

    .cart-product {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    /* ================= CHECKBOX ================= */

    .cart-check {
        width: 20px;
        height: 20px;
        accent-color: #e5a900;
        cursor: pointer;
        flex-shrink: 0;
    }

    /* ================= IMAGE ================= */

    .cart-product-image {
        width: 88px;
        height: 88px;
        flex: 0 0 88px;
        border-radius: 12px;
        overflow: hidden;
        background: #f5f5f5;
        border: 1px solid #eee;
    }

    .cart-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ================= INFO ================= */

    .cart-product-info {
        flex: 1;
        min-width: 170px;
    }

    .cart-product-name {
        color: #252525;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .cart-product-price {
        color: #888;
        font-size: 13px;
    }

    /* ================= QUANTITY ================= */

    .cart-quantity-form {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .cart-quantity-form input {
        width: 68px;
        height: 38px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
    }

    .cart-update-btn {
        height: 38px;
        padding: 0 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #fff;
        color: #666;
        font-size: 12px;
        font-weight: 600;
        transition: .2s ease;
    }

    .cart-update-btn:hover {
        border-color: #dba400;
        color: #b47d00;
    }

    /* ================= SUBTOTAL ================= */

    .cart-subtotal {
        min-width: 115px;
        text-align: right;
    }

    .cart-subtotal-label {
        display: block;
        color: #999;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 3px;
    }

    .cart-subtotal strong {
        color: #333;
        font-size: 16px;
    }

    /* ================= REMOVE ================= */

    .cart-remove-btn {
        width: 38px;
        height: 38px;
        border: 1px solid #e4b4b0;
        border-radius: 8px;
        background: #fff;
        color: #b42318;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .2s ease;
    }

    .cart-remove-btn:hover {
        background: #c9362b;
        border-color: #c9362b;
        color: #fff;
    }

    /* ================= CART TOOLBAR ================= */

    .cart-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 14px;
    }

    .select-all-wrapper {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #444;
        font-size: 14px;
        font-weight: 600;
    }

    .select-all-wrapper span {
        color: #777;
        font-weight: 400;
    }

    /* ================= BOTTOM ================= */

    .cart-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fffdf7;
        border: 1px solid #f0eadc;
        border-radius: 16px;
        padding: 20px 22px;
        margin-top: 20px;
    }

    .selected-info-label {
        color: #999;
        font-size: 12px;
        margin-bottom: 3px;
    }

    .selected-info-text {
        color: #333;
        font-size: 14px;
        font-weight: 600;
    }

    .selected-info-text span {
        color: #d99a00;
    }

    .cart-total {
        text-align: right;
    }

    .cart-total-label {
        color: #999;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .cart-total-value {
        color: #d99a00;
        font-size: 23px;
        font-weight: 700;
    }

    .checkout-selected-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 0 22px;
        border: none;
        border-radius: 9px;
        background: #e5a900;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        transition: .2s ease;
        cursor: pointer;
    }

    .checkout-selected-btn:hover {
        background: #d39500;
    }

    .checkout-selected-btn:disabled {
        background: #d8d8d8;
        color: #888;
        cursor: not-allowed;
    }

    /* ================= EMPTY ================= */

    .empty-cart {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 18px;
        padding: 70px 30px;
        text-align: center;
    }

    .empty-cart-icon {
        width: 78px;
        height: 78px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff6d9;
        color: #d99a00;
        font-size: 32px;
    }

    .empty-cart h3 {
        font-size: 22px;
        font-weight: 700;
        color: #292929;
    }

    .empty-cart p {
        color: #888;
        font-size: 14px;
        margin-bottom: 24px;
    }

    .browse-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 22px;
        border-radius: 9px;
        background: #e5a900;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
    }

    .browse-btn:hover {
        background: #d39500;
        color: #fff;
    }

    /* ================= RESPONSIVE ================= */

    @media (max-width: 768px) {

        .cart-page {
            padding: 35px 0 60px;
        }

        .cart-container {
            padding: 0 15px;
        }

        .cart-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .cart-header h1 {
            font-size: 28px;
        }

        .cart-product {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .cart-product-info {
            min-width: calc(100% - 145px);
        }

        .cart-quantity-form {
            margin-left: 45px;
        }

        .cart-subtotal {
            margin-left: auto;
        }

        .cart-bottom {
            flex-direction: column;
            align-items: stretch;
            gap: 18px;
        }

        .cart-total {
            text-align: left;
        }

        .checkout-selected-btn {
            width: 100%;
        }
    }

    @media (max-width: 480px) {

        .cart-card-body {
            padding: 16px;
        }

        .cart-product-image {
            width: 70px;
            height: 70px;
            flex-basis: 70px;
        }

        .cart-product-info {
            min-width: calc(100% - 100px);
        }

        .cart-quantity-form {
            margin-left: 29px;
        }

        .cart-subtotal {
            margin-left: 0;
            text-align: left;
        }

        .cart-toolbar {
            padding: 12px;
        }
    }
</style>


<div class="cart-page">

    <div class="cart-container">

        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="cart-header">

            <div>

                <div class="cart-label">
                    My Account
                </div>

                <h1>
                    My Cart
                </h1>

                <p>
                    Review the products you want to purchase.
                </p>

            </div>

            <a
                href="{{ route('customer.shop') }}"
                class="continue-shopping"
            >
                <i class="bi bi-arrow-left"></i>
                Continue Shopping
            </a>

        </div>


        {{-- =================================================
             ALERTS
        ================================================== --}}

        @if(session('success'))

            <div class="alert alert-success cart-alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger cart-alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ session('error') }}
            </div>

        @endif


        @if(empty($cart))

            {{-- =================================================
                 EMPTY CART
            ================================================== --}}

            <div class="empty-cart">

                <div class="empty-cart-icon">
                    <i class="bi bi-cart3"></i>
                </div>

                <h3>
                    Your Cart is Empty
                </h3>

                <p>
                    You haven't added any products to your cart yet.
                </p>

                <a
                    href="{{ route('customer.shop') }}"
                    class="browse-btn"
                >
                    <i class="bi bi-bag"></i>
                    Browse Products
                </a>

            </div>

        @else

            {{-- =================================================
                 SELECT ALL TOOLBAR
            ================================================== --}}

            <div class="cart-toolbar">

                <label class="select-all-wrapper">

                    <input
                        type="checkbox"
                        id="selectAll"
                        class="cart-check"
                    >

                    Select All

                    <span>
                        ({{ count($cart) }} {{ count($cart) === 1 ? 'item' : 'items' }})
                    </span>

                </label>

            </div>


            {{-- =================================================
                 CART PRODUCTS
            ================================================== --}}

            <div id="cartProducts">

                @foreach($cart as $item)

                    <div
                        class="cart-card"
                        data-product-id="{{ $item['id'] }}"
                        data-price="{{ $item['price'] }}"
                    >

                        <div class="cart-card-body">

                            <div class="cart-product">

                                {{-- Checkbox --}}
                                <input
                                    type="checkbox"
                                    class="cart-check product-checkbox"
                                    value="{{ $item['id'] }}"
                                >


                                {{-- Product Image --}}
                                <div class="cart-product-image">

                                    <img
                                        src="{{ $item['image']
                                            ? asset('storage/' . $item['image'])
                                            : asset('image/placeholder.png') }}"
                                        alt="{{ $item['name'] }}"
                                    >

                                </div>


                                {{-- Product Information --}}
                                <div class="cart-product-info">

                                    <div class="cart-product-name">
                                        {{ $item['name'] }}
                                    </div>

                                    <div class="cart-product-price">
                                        ₱{{ number_format($item['price'], 2) }}
                                        each
                                    </div>

                                </div>


                                {{-- Quantity --}}
                                <form
                                    action="{{ route('customer.cart.update', $item['id']) }}"
                                    method="POST"
                                    class="cart-quantity-form"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <input
                                        type="number"
                                        name="quantity"
                                        value="{{ $item['quantity'] }}"
                                        min="1"
                                        class="form-control"
                                    >

                                    <button
                                        type="submit"
                                        class="cart-update-btn"
                                    >
                                        Update
                                    </button>

                                </form>


                                {{-- Subtotal --}}
                                <div class="cart-subtotal">

                                    <span class="cart-subtotal-label">
                                        Subtotal
                                    </span>

                                    <strong>
                                        ₱{{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </strong>

                                </div>


                                {{-- Remove --}}
                                <form
                                    action="{{ route('customer.cart.remove', $item['id']) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="cart-remove-btn"
                                        title="Remove product"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- =================================================
                 SELECTED TOTAL
            ================================================== --}}

            <div class="cart-bottom">

                <div>

                    <div class="selected-info-label">
                        Selected Products
                    </div>

                    <div class="selected-info-text">
                        <span id="selectedCount">0</span>
                        selected
                    </div>

                </div>


                <div class="cart-total">

                    <div class="cart-total-label">
                        Selected Total
                    </div>

                    <div class="cart-total-value">
                        ₱<span id="selectedTotal">0.00</span>
                    </div>

                </div>


                <button
                    type="button"
                    id="checkoutSelectedBtn"
                    class="checkout-selected-btn"
                    disabled
                >
                    <i class="bi bi-credit-card"></i>
                    Checkout Selected
                </button>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     SELECTED PRODUCT SCRIPT
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const selectAll =
        document.getElementById('selectAll');

    const checkboxes =
        document.querySelectorAll('.product-checkbox');

    const selectedCount =
        document.getElementById('selectedCount');

    const selectedTotal =
        document.getElementById('selectedTotal');

    const checkoutButton =
        document.getElementById('checkoutSelectedBtn');


    function updateSelectedProducts() {

        let count = 0;
        let total = 0;

        checkboxes.forEach(function (checkbox) {

            if (checkbox.checked) {

                count++;

                const card =
                    checkbox.closest('.cart-card');

                const price =
                    parseFloat(card.dataset.price) || 0;

                const quantityInput =
                    card.querySelector(
                        'input[name="quantity"]'
                    );

                const quantity =
                    parseInt(quantityInput.value) || 1;

                total += price * quantity;
            }

        });


        if (selectedCount) {
            selectedCount.textContent = count;
        }


        if (selectedTotal) {
            selectedTotal.textContent =
                total.toLocaleString('en-PH', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
        }


        if (checkoutButton) {
            checkoutButton.disabled = count === 0;
        }


        if (selectAll) {

            selectAll.checked =
                checkboxes.length > 0 &&
                count === checkboxes.length;

        }

    }


    /* Select All */

    if (selectAll) {

        selectAll.addEventListener(
            'change',
            function () {

                checkboxes.forEach(
                    function (checkbox) {

                        checkbox.checked =
                            selectAll.checked;

                    }
                );

                updateSelectedProducts();

            }
        );

    }


    /* Individual products */

    checkboxes.forEach(
        function (checkbox) {

            checkbox.addEventListener(
                'change',
                updateSelectedProducts
            );

        }
    );


    /* Checkout Selected */

    if (checkoutButton) {

        checkoutButton.addEventListener(
            'click',
            function () {

                const selected = [];

                checkboxes.forEach(
                    function (checkbox) {

                        if (checkbox.checked) {
                            selected.push(
                                checkbox.value
                            );
                        }

                    }
                );


                if (selected.length === 0) {
                    return;
                }


                /*
                 * Temporary navigation.
                 *
                 * Next step:
                 * CheckoutController will read
                 * these selected product IDs.
                 */

                const params =
                    new URLSearchParams();

                selected.forEach(
                    function (id) {

                        params.append(
                            'selected[]',
                            id
                        );

                    }
                );


                window.location.href =
                    "{{ route('customer.checkout') }}"
                    + "?"
                    + params.toString();

            }
        );

    }


    updateSelectedProducts();

});

</script>

@endsection