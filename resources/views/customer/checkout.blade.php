@extends('customer.layouts.customer')

@section('title', 'Checkout')

@section('content')

<style>
    /* =====================================================
       CHECKOUT PAGE
       Scoped CSS - hindi makakaapekto sa ibang pages
    ===================================================== */

    .checkout-page {
        background: #f7f8fc;
        min-height: 100vh;
        padding: 50px 0 80px;
    }

    .checkout-container {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* =========================
       HEADER
    ========================= */

    .checkout-header {
        margin-bottom: 30px;
    }

    .checkout-label {
        color: #d99a00;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 7px;
    }

    .checkout-header h1 {
        margin: 0;
        color: #242424;
        font-size: 34px;
        font-weight: 700;
    }

    .checkout-header p {
        color: #777;
        font-size: 15px;
        margin: 7px 0 0;
    }

    /* =========================
       ALERT
    ========================= */

    .checkout-alert {
        border: none;
        border-radius: 12px;
        margin-bottom: 22px;
    }

    /* =========================
       CARD
    ========================= */

    .checkout-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 18px;
        overflow: hidden;
    }

    .checkout-card + .checkout-card {
        margin-top: 18px;
    }

    .checkout-card-body {
        padding: 24px;
    }

    .checkout-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #282828;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 22px;
    }

    .checkout-card-title i {
        color: #d99a00;
        font-size: 19px;
    }

    /* =========================
       ORDER ITEMS
    ========================= */

    .checkout-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid #eeeeee;
    }

    .checkout-item:first-of-type {
        padding-top: 0;
    }

    .checkout-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .checkout-item-image {
        width: 82px;
        height: 82px;
        flex: 0 0 82px;
        border-radius: 12px;
        overflow: hidden;
        background: #f5f5f5;
        border: 1px solid #eeeeee;
    }

    .checkout-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .checkout-item-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #aaa;
        font-size: 24px;
    }

    .checkout-item-info {
        flex: 1;
        min-width: 0;
    }

    .checkout-item-name {
        color: #292929;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .checkout-item-price {
        color: #888;
        font-size: 13px;
    }

    .checkout-item-quantity {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 7px;
        padding: 5px 9px;
        border-radius: 7px;
        background: #f7f7f7;
        color: #666;
        font-size: 12px;
    }

    .checkout-item-total {
        min-width: 115px;
        text-align: right;
    }

    .checkout-item-total small {
        display: block;
        color: #999;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 3px;
    }

    .checkout-item-total strong {
        color: #333;
        font-size: 15px;
    }

    /* =========================
       PAYMENT METHOD
    ========================= */

    .payment-option {
        position: relative;
    }

    .payment-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .payment-label {
        position: relative;
        display: flex;
        align-items: center;
        gap: 13px;
        min-height: 78px;
        padding: 15px;
        border: 1px solid #e1e1e1;
        border-radius: 12px;
        background: #fff;
        cursor: pointer;
        transition: .2s ease;
    }

    .payment-label:hover {
        border-color: #dfb342;
    }

    .payment-option input:checked + .payment-label {
        border-color: #e3aa18;
        background: #fffaf0;
        box-shadow: 0 0 0 2px rgba(227, 170, 24, .08);
    }

    .payment-icon {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #fff3cc;
        color: #d99a00;
        font-size: 19px;
    }

    .payment-info {
        flex: 1;
    }

    .payment-name {
        color: #333;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .payment-description {
        color: #999;
        font-size: 11px;
    }

    .payment-check {
        color: #d99a00;
        font-size: 17px;
        display: none;
    }

    .payment-option input:checked
        + .payment-label
        .payment-check {
        display: block;
    }

    /* =========================
       COMING SOON
    ========================= */

    .payment-disabled {
        opacity: .62;
        cursor: not-allowed;
        background: #fafafa;
    }

    .coming-soon-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 8px;
        border-radius: 20px;
        background: #f0f0f0;
        color: #777;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    /* =========================
       NOTES
    ========================= */

    .checkout-notes {
        width: 100%;
        min-height: 120px;
        border: 1px solid #dedede;
        border-radius: 10px;
        padding: 13px 14px;
        resize: vertical;
        font-size: 13px;
        color: #333;
        outline: none;
        transition: .2s ease;
    }

    .checkout-notes:focus {
        border-color: #dfad27;
        box-shadow: 0 0 0 3px rgba(223, 173, 39, .08);
    }

    .notes-hint {
        color: #999;
        font-size: 11px;
        margin-top: 7px;
    }

    /* =========================
       SUMMARY
    ========================= */

    .summary-card {
        position: sticky;
        top: 25px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .summary-row strong {
        color: #333;
    }

    .summary-divider {
        border: none;
        border-top: 1px solid #eeeeee;
        margin: 18px 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .summary-total-label {
        color: #333;
        font-size: 16px;
        font-weight: 700;
    }

    .summary-total-value {
        color: #d99a00;
        font-size: 25px;
        font-weight: 700;
    }

    .payment-summary {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 18px;
        padding: 12px;
        border-radius: 10px;
        background: #fffaf0;
    }

    .payment-summary i {
        color: #d99a00;
        font-size: 17px;
    }

    .payment-summary-text {
        color: #666;
        font-size: 12px;
    }

    .payment-summary-text strong {
        display: block;
        color: #333;
        font-size: 13px;
        margin-top: 2px;
    }

    /* =========================
       BUTTONS
    ========================= */

    .place-order-btn {
        width: 100%;
        min-height: 48px;
        margin-top: 22px;
        border: none;
        border-radius: 10px;
        background: #e5a900;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        transition: .2s ease;
    }

    .place-order-btn:hover {
        background: #d39500;
    }

    .place-order-btn i {
        margin-right: 7px;
    }

    .back-btn {
        width: 100%;
        min-height: 43px;
        margin-top: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border: 1px solid #ddd;
        border-radius: 9px;
        background: #fff;
        color: #666;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: .2s ease;
    }

    .back-btn:hover {
        color: #b47d00;
        border-color: #dfb342;
        background: #fffdf8;
    }

    /* =========================
       ORDER TYPE BADGE
    ========================= */

    .checkout-type {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 20px;
        padding: 7px 11px;
        border-radius: 20px;
        background: #fff6d9;
        color: #956d00;
        font-size: 11px;
        font-weight: 700;
    }

    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 991px) {

        .summary-card {
            position: static;
        }
    }

    @media (max-width: 768px) {

        .checkout-page {
            padding: 35px 0 60px;
        }

        .checkout-container {
            padding: 0 15px;
        }

        .checkout-header h1 {
            font-size: 28px;
        }

        .checkout-card-body {
            padding: 19px;
        }

        .checkout-item {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .checkout-item-image {
            width: 70px;
            height: 70px;
            flex-basis: 70px;
        }

        .checkout-item-info {
            width: calc(100% - 90px);
        }

        .checkout-item-total {
            width: 100%;
            text-align: left;
            padding-left: 86px;
        }
    }

    @media (max-width: 576px) {

        .checkout-item-total {
            padding-left: 0;
        }

        .payment-label {
            min-height: 70px;
        }
    }
</style>


<div class="checkout-page">

    <div class="checkout-container">

        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="checkout-header">

            <div class="checkout-label">
                Order Checkout
            </div>

            <h1>
                Checkout
            </h1>

            <p>
                Review your order and complete your purchase.
            </p>

        </div>


        {{-- =================================================
             VALIDATION ERRORS
        ================================================== --}}

        @if($errors->any())

            <div
                class="alert alert-danger alert-dismissible fade show checkout-alert"
                role="alert"
            >

                <strong>
                    Unable to place order.
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        @endif


        <form
    action="{{ route('customer.checkout.place') }}"
    method="POST"
    enctype="multipart/form-data"
>

            @csrf


            <div class="row g-4">

                {{-- =================================================
                     LEFT SIDE
                ================================================== --}}

                <div class="col-lg-8">


                    {{-- Order Type --}}
                    @if($isBuyNow ?? false)

                        <div class="checkout-type">
                            <i class="bi bi-lightning-fill"></i>
                            Buy Now Order
                        </div>

                    @else

                        <div class="checkout-type">
                            <i class="bi bi-cart-check"></i>
                            Cart Checkout
                        </div>

                    @endif


                    {{-- =================================================
                         ORDER ITEMS
                    ================================================== --}}

                    <div class="checkout-card">

                        <div class="checkout-card-body">

                            <div class="checkout-card-title">

                                <i class="bi bi-bag-check"></i>

                                Order Items

                            </div>


                            @foreach($cart as $item)

                                <div class="checkout-item">

                                    {{-- Image --}}
                                    <div class="checkout-item-image">

                                        @if(!empty($item['image']))

                                            <img
                                                src="{{ asset('storage/' . $item['image']) }}"
                                                alt="{{ $item['name'] }}"
                                            >
                                            

                                        @else

                                            <div class="checkout-item-placeholder">
                                                <i class="bi bi-image"></i>
                                            </div>

                                        @endif

                                    </div>


                                    {{-- Details --}}
                                    <div class="checkout-item-info">

                                        <div class="checkout-item-name">
                                            {{ $item['name'] }}
                                        </div>

                                        <div class="checkout-item-price">
                                            ₱{{ number_format($item['price'], 2) }}
                                            each
                                        </div>

                                        <div class="checkout-item-quantity">

                                            <i class="bi bi-box-seam"></i>

                                            Quantity:
                                            {{ $item['quantity'] }}

                                        </div>

                                    </div>


                                    {{-- Item Total --}}
                                    <div class="checkout-item-total">

                                        <small>
                                            Subtotal
                                        </small>

                                        <strong>
                                            ₱{{ number_format(
                                                $item['price'] * $item['quantity'],
                                                2
                                            ) }}
                                        </strong>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>


                    {{-- =================================================
                         PAYMENT METHOD
                    ================================================== --}}

                    <div class="checkout-card mt-4">

                        <div class="checkout-card-body">

                            <div class="checkout-card-title">

                                <i class="bi bi-wallet2"></i>

                                Payment Method

                            </div>


                            <div class="row g-3">

                                {{-- COD --}}
                                <div class="col-md-6">

                                    <div class="payment-option">

                                        <input
                                            type="radio"
                                            name="payment_method"
                                            id="payment_cod"
                                            value="COD"
                                            checked
                                        >

                                        <label
                                            for="payment_cod"
                                            class="payment-label"
                                        >

                                            <div class="payment-icon">
                                                <i class="bi bi-truck"></i>
                                            </div>

                                            <div class="payment-info">

                                                <div class="payment-name">
                                                    Cash on Delivery
                                                </div>

                                                <div class="payment-description">
                                                    Pay when your order arrives.
                                                </div>

                                            </div>

                                            <i class="bi bi-check-circle-fill payment-check"></i>

                                        </label>

                                    </div>

                                </div>


                                {{-- GCash Coming Soon --}}
                                <div class="col-md-6">

                                    <div class="payment-option">

                                        <input
    type="radio"
    name="payment_method"
    id="payment_gcash"
    value="GCash"
>

                                        <label
    for="payment_gcash"
    class="payment-label"
>

                                            <div class="payment-icon">
                                                <i class="bi bi-phone"></i>
                                            </div>

                                            <div class="payment-info">

                                                <div class="payment-name">
                                                    GCash
                                                </div>

                                                <div class="payment-description">
                                                    Pay securely using GCash.
                                                </div>

                                            </div>

                                            <i class="bi bi-check-circle-fill payment-check"></i>

                                        </label>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    @if(!empty($gcashQrCode))
    <div id="gcash-payment-details"
         class="mt-3 p-3 border rounded text-center"
         style="display: none;">
        <div class="small fw-semibold mb-2">
    GCash Payment Instructions
</div>

<div class="text-muted small mb-3 text-start">
    1. Scan the QR code and send your payment using GCash.<br>
    2. Save your payment receipt or screenshot.<br>
    3. Enter your GCash reference number below.<br>
    4. Upload your proof of payment before placing the order.
</div>

        <img
            src="{{ asset('storage/' . $gcashQrCode) }}"
            alt="GCash QR Code"
            class="img-fluid"
            style="max-width: 220px;"
        >
        <div class="mt-3 text-center">
    <a 
        href="{{ asset('storage/' . $gcashQrCode) }}" 
        download 
        class="btn btn-outline-primary btn-sm"
    >
        <i class="bi bi-download me-1"></i>
        Download QR Code
    </a>
</div>
        <div class="text-start mt-3">
    <label for="gcash_reference" class="form-label fw-semibold">
        GCash Reference Number
    </label>

    <input
        type="text"
        name="gcash_reference"
        id="gcash_reference"
        class="form-control"
        value="{{ old('gcash_reference') }}"
        placeholder="Enter your GCash reference number"
        maxlength="100"
    >
</div>
<div class="text-start mt-3">
    <label for="gcash_proof" class="form-label fw-semibold">
        Proof of Payment
    </label>

    <input
        type="file"
        name="gcash_proof"
        id="gcash_proof"
        class="form-control"
        accept="image/png,image/jpeg,image/webp"
    >

    <div class="form-text">
        Upload a screenshot or photo of your GCash payment. JPG, PNG, or WebP. Maximum 2 MB.
    </div>
</div>
    </div>
@endif


                    {{-- =================================================
                         ORDER NOTES
                    ================================================== --}}

                    <div class="checkout-card mt-4">

                        <div class="checkout-card-body">

                            <div class="checkout-card-title">

                                <i class="bi bi-chat-left-text"></i>

                                Order Notes

                            </div>

                            <textarea
                                name="notes"
                                class="checkout-notes"
                                rows="4"
                                maxlength="1000"
                                placeholder="Add special instructions or notes for your order..."
                            >{{ old('notes') }}</textarea>

                            <div class="notes-hint">
                                Optional. You may add delivery instructions or other important notes.
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     RIGHT SIDE
                ================================================== --}}

                <div class="col-lg-4">

                    <div class="checkout-card summary-card">

                        <div class="checkout-card-body">

                            <div class="checkout-card-title">

                                <i class="bi bi-receipt"></i>

                                Order Summary

                            </div>


                            {{-- Subtotal --}}
                            <div class="summary-row">

                                <span>
                                    Subtotal
                                </span>

                                <strong>
                                    ₱{{ number_format($subtotal, 2) }}
                                </strong>

                            </div>


                            {{-- Delivery --}}
                            <div class="summary-row">

                                <span>
                                    Delivery
                                </span>

                                <strong>
                                    Free
                                </strong>

                            </div>


                            <hr class="summary-divider">


                            {{-- Total --}}
                            <div class="summary-total">

                                <span class="summary-total-label">
                                    Total
                                </span>

                                <span class="summary-total-value">
                                    ₱{{ number_format($subtotal, 2) }}
                                </span>

                            </div>


                            {{-- Payment Summary --}}
<div class="payment-summary">

    <i id="payment-summary-icon" class="bi bi-truck"></i>

    <div class="payment-summary-text">

        Payment Method

        <strong id="payment-summary-name">
            Cash on Delivery
        </strong>

    </div>

</div>

                            {{-- Place Order --}}
                            <button
                                type="submit"
                                class="place-order-btn"
                            >

                                <i class="bi bi-check2-circle"></i>

                                Place Order

                            </button>


                            {{-- Back Button --}}
                            @if($isBuyNow ?? false)

                                <a
                                    href="{{ route(
                                        'customer.product.show',
                                        array_key_first($cart)
                                    ) }}"
                                    class="back-btn"
                                >
                                    <i class="bi bi-arrow-left"></i>
                                    Back to Product
                                </a>

                            @else

                                <a
                                    href="{{ route('customer.cart') }}"
                                    class="back-btn"
                                >
                                    <i class="bi bi-arrow-left"></i>
                                    Back to Cart
                                </a>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
<script>
    const codRadio = document.getElementById('payment_cod');
    const gcashRadio = document.getElementById('payment_gcash');
    const gcashDetails = document.getElementById('gcash-payment-details');

    const paymentSummaryName = document.getElementById('payment-summary-name');
    const paymentSummaryIcon = document.getElementById('payment-summary-icon');

    function updatePaymentDetails() {
        if (gcashRadio.checked) {
            gcashDetails.style.display = 'block';

            paymentSummaryName.textContent = 'GCash';
            paymentSummaryIcon.className = 'bi bi-phone';
        } else {
            gcashDetails.style.display = 'none';

            paymentSummaryName.textContent = 'Cash on Delivery';
            paymentSummaryIcon.className = 'bi bi-truck';
        }
    }

    codRadio.addEventListener('change', updatePaymentDetails);
    gcashRadio.addEventListener('change', updatePaymentDetails);

    updatePaymentDetails();
</script>
@endsection