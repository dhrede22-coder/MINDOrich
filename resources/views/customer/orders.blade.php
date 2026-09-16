@extends('customer.layouts.customer')

@section('title', 'My Orders')

@section('content')

<style>
    /* =========================================================
       ORDERS PAGE
       Scoped CSS para hindi makaapekto sa ibang pages
    ========================================================= */

    .orders-page {
        background: #f7f8fc;
        min-height: 100vh;
        padding: 55px 0 80px;
    }

    .orders-container {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* =========================
       HEADER
    ========================= */

    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 32px;
    }

    .orders-header-label {
        color: #d99a00;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .orders-header h1 {
        margin: 0;
        color: #242424;
        font-size: 34px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .orders-header p {
        margin: 8px 0 0;
        color: #777;
        font-size: 15px;
    }

    .orders-count {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 12px;
        padding: 10px 16px;
        color: #555;
        font-size: 14px;
    }

    .orders-count strong {
        color: #d99a00;
    }

    /* =========================
       ALERT
    ========================= */

    .orders-alert {
        border: none;
        border-radius: 12px;
        margin-bottom: 24px;
    }

    /* =========================
       ORDER CARD
    ========================= */

    .order-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 18px;
        margin-bottom: 22px;
        overflow: hidden;
        transition: 0.2s ease;
    }

    .order-card:hover {
        border-color: #e1c26a;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    }

    /* =========================
       ORDER TOP
    ========================= */

    .order-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 22px 24px;
        border-bottom: 1px solid #eeeeee;
    }

    .order-number {
        color: #222;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .order-date {
        color: #888;
        font-size: 13px;
    }

    /* =========================
       STATUS
    ========================= */

    .order-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 13px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
    }

    .order-status i {
        font-size: 9px;
    }

    .status-pending {
        color: #956d00;
        background: #fff6d9;
    }

    .status-processing {
        color: #2563a6;
        background: #eaf4ff;
    }

    .status-completed {
        color: #18794e;
        background: #e9f8f0;
    }

    .status-cancelled {
        color: #b42318;
        background: #fff0ef;
    }

    .status-default {
        color: #666;
        background: #f1f1f1;
    }

    /* =========================
       PRODUCTS
    ========================= */

    .order-products {
        padding: 8px 24px;
    }

    .order-product {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 17px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .order-product:last-child {
        border-bottom: none;
    }

    .order-product-image {
        width: 82px;
        height: 82px;
        flex: 0 0 82px;
        border-radius: 12px;
        overflow: hidden;
        background: #f5f5f5;
        border: 1px solid #eeeeee;
    }

    .order-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .order-product-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #aaa;
        font-size: 25px;
    }

    .order-product-info {
        flex: 1;
        min-width: 0;
    }

    .order-product-name {
        color: #262626;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .order-product-meta {
        color: #888;
        font-size: 13px;
    }

    .order-product-meta .price {
        color: #555;
    }

    .order-product-subtotal {
        text-align: right;
        min-width: 110px;
    }

    .order-product-subtotal small {
        display: block;
        color: #999;
        font-size: 11px;
        margin-bottom: 3px;
    }

    .order-product-subtotal strong {
        color: #333;
        font-size: 15px;
    }

    /* =========================
       ORDER FOOTER
    ========================= */

    .order-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding: 20px 24px;
        background: #fffdf7;
        border-top: 1px solid #f0eadc;
    }

    .order-payment {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .order-payment-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff4cf;
        color: #d99a00;
        font-size: 18px;
    }

    .order-payment-label {
        color: #999;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .order-payment-value {
        color: #333;
        font-size: 14px;
        font-weight: 600;
    }

    .order-total {
        text-align: right;
    }

    .order-total-label {
        color: #999;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .order-total-value {
        color: #d99a00;
        font-size: 22px;
        font-weight: 700;
    }

    /* =========================
       BUTTONS
    ========================= */

    .order-actions {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 0 24px 22px;
    }

    .order-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 42px;
        padding: 0 17px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s ease;
    }

    .order-btn-view {
        color: #b47d00;
        background: #fff;
        border: 1px solid #e4b62e;
    }

    .order-btn-view:hover {
        color: #fff;
        background: #e4b62e;
        border-color: #e4b62e;
    }

    .order-btn-cancel {
        color: #b42318;
        background: #fff;
        border: 1px solid #e7aaa5;
    }

    .order-btn-cancel:hover {
        color: #fff;
        background: #c9362b;
        border-color: #c9362b;
    }

    /* =========================
       EMPTY ORDERS
    ========================= */

    .empty-orders {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 18px;
        padding: 70px 30px;
        text-align: center;
    }

    .empty-orders-icon {
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

    .empty-orders h3 {
        color: #292929;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .empty-orders p {
        color: #888;
        font-size: 14px;
        margin-bottom: 24px;
    }

    .shop-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #e7a900;
        color: #fff;
        padding: 12px 22px;
        border-radius: 9px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s ease;
    }

    .shop-btn:hover {
        background: #d49600;
        color: #fff;
    }

    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 768px) {

        .orders-page {
            padding: 35px 0 60px;
        }

        .orders-container {
            padding: 0 15px;
        }

        .orders-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 15px;
        }

        .orders-header h1 {
            font-size: 28px;
        }

        .order-top {
            padding: 18px;
        }

        .order-products {
            padding: 6px 18px;
        }

        .order-product {
            align-items: flex-start;
        }

        .order-product-image {
            width: 68px;
            height: 68px;
            flex-basis: 68px;
        }

        .order-product-subtotal {
            min-width: auto;
        }

        .order-bottom {
            padding: 18px;
            align-items: flex-start;
            flex-direction: column;
        }

        .order-total {
            text-align: left;
            width: 100%;
        }

        .order-actions {
            padding: 0 18px 18px;
            flex-wrap: wrap;
        }
    }

    @media (max-width: 480px) {

        .order-top {
            gap: 12px;
            align-items: flex-start;
        }

        .order-status {
            font-size: 10px;
            padding: 6px 9px;
        }

        .order-product {
            flex-wrap: wrap;
        }

        .order-product-info {
            width: calc(100% - 84px);
        }

        .order-product-subtotal {
            width: 100%;
            text-align: left;
            padding-left: 84px;
        }

        .order-actions .order-btn {
            flex: 1;
        }
    }
</style>


<div class="orders-page">

    <div class="orders-container">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="orders-header">

            <div>
                <div class="orders-header-label">
                    My Account
                </div>

                <h1>
                    My Orders
                </h1>

                <p>
                    View your orders and track their status.
                </p>
            </div>

            <div class="orders-count">
                <strong>{{ $orders->count() }}</strong>
                {{ $orders->count() === 1 ? 'Order' : 'Orders' }}
            </div>

        </div>


        {{-- =====================================================
             SUCCESS MESSAGE
        ====================================================== --}}

        @if(session('success'))

            <div
                class="alert alert-success alert-dismissible fade show orders-alert"
                role="alert"
            >
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>
            </div>

        @endif


        {{-- =====================================================
             ERROR MESSAGE
        ====================================================== --}}

        @if(session('error'))

            <div
                class="alert alert-danger alert-dismissible fade show orders-alert"
                role="alert"
            >
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>
            </div>

        @endif


        {{-- =====================================================
             ORDERS
        ====================================================== --}}

        @forelse($orders as $order)

            <div class="order-card">

                {{-- Order Header --}}
                <div class="order-top">

                    <div>

                        <div class="order-number">
                            Order #{{ $order->sale_number }}
                        </div>

                        <div class="order-date">
                            <i class="bi bi-calendar3 me-1"></i>

                            {{ $order->created_at->format('M d, Y') }}

                            <span class="mx-1">•</span>

                            {{ $order->created_at->format('h:i A') }}
                        </div>

                    </div>


                    {{-- Status --}}
                    @if($order->status === 'Pending')

                        <span class="order-status status-pending">
                            <i class="bi bi-circle-fill"></i>
                            Pending
                        </span>

                    @elseif($order->status === 'Processing')

                        <span class="order-status status-processing">
                            <i class="bi bi-circle-fill"></i>
                            Processing
                        </span>

                    @elseif($order->status === 'Completed')

                        <span class="order-status status-completed">
                            <i class="bi bi-check-circle-fill"></i>
                            Completed
                        </span>

                    @elseif($order->status === 'Cancelled')

                        <span class="order-status status-cancelled">
                            <i class="bi bi-x-circle-fill"></i>
                            Cancelled
                        </span>

                    @else

                        <span class="order-status status-default">
                            {{ $order->status }}
                        </span>

                    @endif

                </div>


                {{-- =================================================
                     PRODUCTS
                ================================================== --}}

                <div class="order-products">

                    @foreach($order->saleItems as $item)

                        <div class="order-product">

                            {{-- Product Image --}}
                            <div class="order-product-image">

                                @if($item->product?->featured_image)

                                    <img
                                        src="{{ asset('storage/' . $item->product->featured_image) }}"
                                        alt="{{ $item->product->product_name }}"
                                    >

                                @else

                                    <div class="order-product-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>

                                @endif

                            </div>


                            {{-- Product Information --}}
                            <div class="order-product-info">

                                <div class="order-product-name">

                                    {{ $item->product?->product_name ?? 'Product unavailable' }}

                                </div>

                                <div class="order-product-meta">

                                    <span class="price">
                                        ₱{{ number_format($item->price, 2) }}
                                    </span>

                                    <span class="mx-1">
                                        ×
                                    </span>

                                    {{ $item->quantity }}

                                </div>

                            </div>


                            {{-- Subtotal --}}
                            <div class="order-product-subtotal">

                                <small>
                                    Subtotal
                                </small>

                                <strong>
                                    ₱{{ number_format($item->subtotal, 2) }}
                                </strong>

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- =================================================
                     ORDER SUMMARY
                ================================================== --}}

                <div class="order-bottom">

                    {{-- Payment --}}
                    <div class="order-payment">

                        <div class="order-payment-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <div>

                            <div class="order-payment-label">
                                Payment Method
                            </div>

                            <div class="order-payment-value">
                                {{ $order->payment_method }}
                            </div>

                        </div>

                    </div>


                    {{-- Total --}}
                    <div class="order-total">

                        <div class="order-total-label">
                            Order Total
                        </div>

                        <div class="order-total-value">
                            ₱{{ number_format($order->total_amount, 2) }}
                        </div>

                    </div>

                </div>


                {{-- =================================================
                     ACTIONS
                ================================================== --}}

                <div class="order-actions">

                    <a
                        href="{{ route('customer.order.show', $order->id) }}"
                        class="order-btn order-btn-view"
                    >
                        <i class="bi bi-eye"></i>
                        View Order
                    </a>


                    {{-- Only Pending orders can be cancelled --}}
                    @if($order->status === 'Pending')

                        <form
                            action="{{ route('customer.order.cancel', $order->id) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to cancel this order?');"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="order-btn order-btn-cancel"
                            >
                                <i class="bi bi-x-circle"></i>
                                Cancel Order
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        @empty


            {{-- =================================================
                 EMPTY STATE
            ================================================== --}}

            <div class="empty-orders">

                <div class="empty-orders-icon">
                    <i class="bi bi-bag-x"></i>
                </div>

                <h3>
                    No Orders Yet
                </h3>

                <p>
                    You haven't placed any orders yet.
                    Start exploring our collection.
                </p>

                <a
                    href="{{ route('customer.shop') }}"
                    class="shop-btn"
                >
                    <i class="bi bi-bag"></i>
                    Start Shopping
                </a>

            </div>

        @endforelse

    </div>

</div>

@endsection