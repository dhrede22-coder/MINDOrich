@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')

<style>

/* =========================================================
   MINDOrich ORDERS
========================================================= */

.orders-page {
    padding-bottom: 2rem;
}

/* ---------------------------------------------------------
   HEADER
--------------------------------------------------------- */

.orders-header {
    background: linear-gradient(
        135deg,
        #ffffff 0%,
        #faf7f2 100%
    );

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    padding: 1.25rem 1.5rem;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);
}

.orders-header-icon {
    width: 46px;
    height: 46px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: rgba(200, 138, 43, 0.12);
    color: #a86f1f;

    font-size: 1.3rem;

    flex-shrink: 0;
}

.orders-header h4 {
    color: #1f2937;
}

.orders-header p {
    font-size: 0.9rem;
}

/* ---------------------------------------------------------
   CREATE BUTTON
--------------------------------------------------------- */

.orders-create-btn {
    background: #c88a2b;
    border-color: #c88a2b;

    color: #ffffff;

    border-radius: 10px;

    padding: 0.65rem 1rem;

    font-weight: 600;

    white-space: nowrap;
}

.orders-create-btn:hover,
.orders-create-btn:focus {
    background: #a86f1f;
    border-color: #a86f1f;
    color: #ffffff;
}

/* ---------------------------------------------------------
   SECTION
--------------------------------------------------------- */

.order-section-icon {
    width: 38px;
    height: 38px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f8f9fa;
    color: #374151;

    flex-shrink: 0;
}

.order-section-title {
    font-size: 0.98rem;
    font-weight: 700;

    color: #1f2937;

    margin-bottom: 0.1rem;
}

.order-section-subtitle {
    font-size: 0.78rem;

    color: #6b7280;

    margin-bottom: 0;
}

/* ---------------------------------------------------------
   KPI CARDS
--------------------------------------------------------- */

.order-kpi {
    position: relative;

    height: 100%;

    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 14px;

    padding: 1rem 1.1rem;

    box-shadow: 0 3px 10px rgba(31, 41, 55, 0.035);

    overflow: hidden;
}

.order-kpi::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;
    bottom: 0;

    width: 4px;

    background: #c88a2b;
}

.order-kpi.warning::before {
    background: #c88a2b;
}

.order-kpi.info::before {
    background: #0d6efd;
}

.order-kpi.success::before {
    background: #198754;
}

.order-kpi-label {
    color: #6b7280;

    font-size: 0.76rem;
    font-weight: 600;

    margin-bottom: 0.25rem;
}

.order-kpi-value {
    color: #1f2937;

    font-size: 1.45rem;
    font-weight: 700;

    line-height: 1.2;
}

.order-kpi-icon {
    width: 40px;
    height: 40px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f8f9fa;

    color: #374151;

    font-size: 1.05rem;
}

/* ---------------------------------------------------------
   FILTER CARD
--------------------------------------------------------- */

.orders-filter-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);
}

.orders-filter-card .form-label {
    color: #374151;

    font-size: 0.78rem;
}

.orders-filter-card .form-control,
.orders-filter-card .form-select {
    min-height: 40px;

    border-radius: 9px;

    border-color: rgba(31, 41, 55, 0.12);

    font-size: 0.82rem;
}

.orders-filter-card .form-control:focus,
.orders-filter-card .form-select:focus {
    border-color: #c88a2b;

    box-shadow: 0 0 0 0.2rem rgba(200, 138, 43, 0.12);
}

/* ---------------------------------------------------------
   FILTER BUTTON
--------------------------------------------------------- */

.orders-reset-btn {
    width: 40px;
    height: 40px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    color: #6b7280;
}

/* ---------------------------------------------------------
   ORDERS DIRECTORY
--------------------------------------------------------- */

.orders-directory-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);

    overflow: hidden;
}

.orders-directory-header {
    padding: 1.1rem 1.25rem;

    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 1rem;

    border-bottom: 1px solid rgba(31, 41, 55, 0.06);
}

.orders-see-all-btn {
    border-radius: 9px;

    font-size: 0.78rem;
    font-weight: 600;
}

/* ---------------------------------------------------------
   TABLE
--------------------------------------------------------- */

.orders-table-wrapper {
    overflow-x: auto;
}

.orders-table {
    margin-bottom: 0;
}

.orders-table thead th {
    background: #f8f9fa;

    color: #6b7280;

    font-size: 0.72rem;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: 0.025em;

    padding: 0.85rem 1rem;

    border-bottom: 1px solid rgba(31, 41, 55, 0.07);

    white-space: nowrap;
}

.orders-table tbody td {
    padding: 0.9rem 1rem;

    color: #374151;

    font-size: 0.82rem;

    border-color: rgba(31, 41, 55, 0.06);

    vertical-align: middle;
}

.orders-table tbody tr:last-child td {
    border-bottom: 0;
}

.orders-table tbody tr:hover {
    background: #faf7f2;
}

/* ---------------------------------------------------------
   ORDER NUMBER
--------------------------------------------------------- */

.order-number-wrapper {
    display: flex;
    align-items: center;
    gap: 0.7rem;
}

.order-number-icon {
    width: 36px;
    height: 36px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: rgba(47, 93, 80, 0.10);

    color: #2f5d50;

    flex-shrink: 0;
}

.order-number {
    color: #1f2937;

    font-weight: 700;

    font-size: 0.82rem;
}

.order-date {
    color: #6b7280;

    font-size: 0.72rem;
}

/* ---------------------------------------------------------
   TYPE
--------------------------------------------------------- */

.order-type {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;

    padding: 0.38rem 0.65rem;

    border-radius: 999px;

    font-size: 0.68rem;

    font-weight: 700;

    white-space: nowrap;
}

.order-type.walk-in {
    background: rgba(200, 138, 43, 0.12);
    color: #a86f1f;
}

.order-type.online {
    background: rgba(13, 110, 253, 0.09);
    color: #0d6efd;
}

/* ---------------------------------------------------------
   CUSTOMER
--------------------------------------------------------- */

.order-customer {
    color: #374151;

    font-weight: 600;
}

/* ---------------------------------------------------------
   ITEMS
--------------------------------------------------------- */

.order-items {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;

    color: #374151;

    font-weight: 600;
}

.order-items i {
    color: #6b7280;
}

/* ---------------------------------------------------------
   TOTAL
--------------------------------------------------------- */

.order-total {
    color: #1f2937;

    font-weight: 700;

    white-space: nowrap;
}

/* ---------------------------------------------------------
   STATUS
--------------------------------------------------------- */

.order-status {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;

    padding: 0.38rem 0.65rem;

    border-radius: 999px;

    font-size: 0.68rem;

    font-weight: 700;

    white-space: nowrap;
}

.order-status-dot {
    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: currentColor;
}

.order-status.paid,
.order-status.completed {
    background: rgba(25, 135, 84, 0.10);
    color: #198754;
}

.order-status.pending {
    background: rgba(200, 138, 43, 0.12);
    color: #a86f1f;
}

.order-status.processing {
    background: rgba(13, 110, 253, 0.09);
    color: #0d6efd;
}

.order-status.refunded {
    background: rgba(108, 117, 125, 0.10);
    color: #6c757d;
}

.order-status.failed,
.order-status.cancelled {
    background: rgba(220, 53, 69, 0.08);
    color: #dc3545;
}

/* ---------------------------------------------------------
   VIEW BUTTON
--------------------------------------------------------- */

.order-view-btn {
    width: 34px;
    height: 34px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: rgba(47, 93, 80, 0.08);

    color: #2f5d50;

    border: 1px solid transparent;

    font-size: 0.82rem;
}

.order-view-btn:hover {
    background: #2f5d50;
    color: #ffffff;
}

/* ---------------------------------------------------------
   EMPTY STATE
--------------------------------------------------------- */

.order-empty-icon {
    width: 56px;
    height: 56px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 14px;

    background: #f8f9fa;

    color: #9ca3af;

    font-size: 1.4rem;
}

/* ---------------------------------------------------------
   RESPONSIVE
--------------------------------------------------------- */

@media (max-width: 767.98px) {

    .orders-header {
        padding: 1rem;
    }

    .orders-header-action {
        width: 100%;
    }

    .orders-create-btn {
        width: 100%;
    }

    .orders-directory-header {
        align-items: flex-start;

        flex-direction: column;
    }

}

</style>


<div class="container-fluid orders-page">


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="orders-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div class="d-flex align-items-center gap-3">

                <div class="orders-header-icon">

                    <i class="bi bi-cart-check-fill"></i>

                </div>

                <div>

                    <h4 class="fw-bold mb-1">
                        Orders
                    </h4>

                    <p class="text-muted mb-0">
                        Manage walk-in and online orders.
                    </p>

                </div>

            </div>


            <div class="orders-header-action">

                <a
                    href="{{ route('orders.create') }}"
                    class="btn orders-create-btn"
                >

                    <i class="bi bi-plus-circle me-2"></i>

                    Create Order

                </a>

            </div>

        </div>

    </div>


    {{-- =====================================================
         ORDER OVERVIEW
    ====================================================== --}}

    <div class="mb-4">

        <div class="d-flex align-items-center gap-2 mb-3">

            <div class="order-section-icon">

                <i class="bi bi-bar-chart-line-fill"></i>

            </div>

            <div>

                <div class="order-section-title">
                    Order Overview
                </div>

                <p class="order-section-subtitle">
                    Quick summary of current customer orders.
                </p>

            </div>

        </div>


        <div class="row g-3">


            {{-- TOTAL --}}

            <div class="col-xl-3 col-md-6">

                <div class="order-kpi">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="order-kpi-label">
                                Total Orders
                            </div>

                            <div class="order-kpi-value">
                                {{ $totalOrders }}
                            </div>

                        </div>

                        <div class="order-kpi-icon">

                            <i class="bi bi-cart-check"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- PENDING --}}

            <div class="col-xl-3 col-md-6">

                <div class="order-kpi warning">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="order-kpi-label">
                                Pending
                            </div>

                            <div class="order-kpi-value">
                                {{ $pendingOrders }}
                            </div>

                        </div>

                        <div class="order-kpi-icon">

                            <i class="bi bi-hourglass-split"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- PROCESSING --}}

            <div class="col-xl-3 col-md-6">

                <div class="order-kpi info">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="order-kpi-label">
                                Processing
                            </div>

                            <div class="order-kpi-value">
                                {{ $processingOrders }}
                            </div>

                        </div>

                        <div class="order-kpi-icon">

                            <i class="bi bi-box-seam"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- COMPLETED --}}

            <div class="col-xl-3 col-md-6">

                <div class="order-kpi success">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="order-kpi-label">
                                Completed
                            </div>

                            <div class="order-kpi-value">
                                {{ $completedOrders }}
                            </div>

                        </div>

                        <div class="order-kpi-icon">

                            <i class="bi bi-check-circle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>


    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="orders-filter-card mb-4">

        <div class="p-4">

            <div class="d-flex align-items-center gap-2 mb-3">

                <div class="order-section-icon">

                    <i class="bi bi-funnel-fill"></i>

                </div>

                <div>

                    <div class="order-section-title">
                        Order Filters
                    </div>

                    <p class="order-section-subtitle">
                        Search and filter orders by type, status, and payment.
                    </p>

                </div>

            </div>


            <form
                method="GET"
                action="{{ route('orders.index') }}"
            >

                <div class="row g-3 align-items-end">


                    {{-- SEARCH --}}

                    <div class="col-lg-4 col-md-6">

                        <label class="form-label fw-semibold">
                            Search Order
                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Search by order number"
                        >

                    </div>


                    {{-- ORDER TYPE --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Order Type
                        </label>

                        <select
                            name="sale_type"
                            class="form-select"
                        >

                            <option value="">
                                All Types
                            </option>

                            <option
                                value="Walk-in"
                                {{ request('sale_type') === 'Walk-in' ? 'selected' : '' }}
                            >
                                Walk-in
                            </option>

                            <option
                                value="Online"
                                {{ request('sale_type') === 'Online' ? 'selected' : '' }}
                            >
                                Online
                            </option>

                        </select>

                    </div>


                    {{-- STATUS --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Order Status
                        </label>

                        <select
                            name="status"
                            class="form-select"
                        >

                            <option value="">
                                All Status
                            </option>

                            <option
                                value="Pending"
                                {{ request('status') === 'Pending' ? 'selected' : '' }}
                            >
                                Pending
                            </option>

                            <option
                                value="Processing"
                                {{ request('status') === 'Processing' ? 'selected' : '' }}
                            >
                                Processing
                            </option>

                            <option
                                value="Completed"
                                {{ request('status') === 'Completed' ? 'selected' : '' }}
                            >
                                Completed
                            </option>

                            <option
                                value="Cancelled"
                                {{ request('status') === 'Cancelled' ? 'selected' : '' }}
                            >
                                Cancelled
                            </option>

                        </select>

                    </div>


                    {{-- PAYMENT --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Payment
                        </label>

                        <select
                            name="payment_status"
                            class="form-select"
                        >

                            <option value="">
                                All Payments
                            </option>

                            <option
                                value="Pending"
                                {{ request('payment_status') === 'Pending' ? 'selected' : '' }}
                            >
                                Pending
                            </option>

                            <option
                                value="Paid"
                                {{ request('payment_status') === 'Paid' ? 'selected' : '' }}
                            >
                                Paid
                            </option>

                            <option
                                value="Failed"
                                {{ request('payment_status') === 'Failed' ? 'selected' : '' }}
                            >
                                Failed
                            </option>

                            <option
                                value="Refunded"
                                {{ request('payment_status') === 'Refunded' ? 'selected' : '' }}
                            >
                                Refunded
                            </option>

                        </select>

                    </div>


                    {{-- RESET --}}

                    <div class="col-lg-2 col-md-6">

                        <a
                            href="{{ route('orders.index') }}"
                            class="btn btn-light border orders-reset-btn"
                            title="Reset Filters"
                        >

                            <i class="bi bi-arrow-counterclockwise"></i>

                        </a>

                    </div>


                </div>

            </form>

        </div>

    </div>


    {{-- =====================================================
         SEE ALL
    ====================================================== --}}

    <div class="d-flex justify-content-end mb-3">

        <a
            href="{{ request()->fullUrlWithQuery(['all' => 1]) }}"
            class="btn btn-outline-primary orders-see-all-btn"
        >

            <i class="bi bi-cart-check me-2"></i>

            See All Orders

        </a>

    </div>


    {{-- =====================================================
         ORDERS DIRECTORY
    ====================================================== --}}

    <div class="orders-directory-card">


        <div class="orders-directory-header">

            <div class="d-flex align-items-center gap-3">

                <div class="order-section-icon">

                    <i class="bi bi-receipt-cutoff"></i>

                </div>

                <div>

                    <div class="order-section-title">
                        All Orders
                    </div>

                    <p class="order-section-subtitle">
                        View and manage customer orders.
                    </p>

                </div>

            </div>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="orders-table-wrapper">

            <table class="table orders-table align-middle">

                <thead>

                    <tr>

                        <th>
                            Order
                        </th>

                        <th>
                            Type
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Items
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Payment
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-end">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($orders as $order)

                        <tr>


                            {{-- ORDER NUMBER --}}

                            <td>

                                <div class="order-number-wrapper">

                                    <div class="order-number-icon">

                                        <i class="bi bi-receipt"></i>

                                    </div>

                                    <div>

                                        <div class="order-number">

                                            {{ $order->sale_number }}

                                        </div>

                                        <div class="order-date">

                                            {{ $order->created_at->format('M d, Y') }}

                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- TYPE --}}

                            <td>

                                @if($order->sale_type === 'Walk-in')

                                    <span class="order-type walk-in">

                                        <i class="bi bi-shop"></i>

                                        Walk-in

                                    </span>

                                @else

                                    <span class="order-type online">

                                        <i class="bi bi-globe"></i>

                                        Online

                                    </span>

                                @endif

                            </td>


                            {{-- CUSTOMER --}}

                            <td>

                                <span class="order-customer">

                                    {{ $order->user->name ?? 'Walk-in Customer' }}

                                </span>

                            </td>


                            {{-- ITEMS --}}

                            <td>

                                <span class="order-items">

                                    <i class="bi bi-box-seam"></i>

                                    {{ $order->saleItems->sum('quantity') }}

                                </span>

                            </td>


                            {{-- TOTAL --}}

                            <td>

                                <span class="order-total">

                                    ₱{{ number_format($order->total_amount, 2) }}

                                </span>

                            </td>


                            {{-- PAYMENT --}}

                            <td>

                                @if($order->payment_status === 'Paid')

                                    <span class="order-status paid">

                                        <span class="order-status-dot"></span>

                                        Paid

                                    </span>

                                @elseif($order->payment_status === 'Pending')

                                    <span class="order-status pending">

                                        <span class="order-status-dot"></span>

                                        Pending

                                    </span>

                                @elseif($order->payment_status === 'Refunded')

                                    <span class="order-status refunded">

                                        <span class="order-status-dot"></span>

                                        Refunded

                                    </span>

                                @else

                                    <span class="order-status failed">

                                        <span class="order-status-dot"></span>

                                        {{ $order->payment_status }}

                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if($order->status === 'Completed')

                                    <span class="order-status completed">

                                        <span class="order-status-dot"></span>

                                        Completed

                                    </span>

                                @elseif($order->status === 'Processing')

                                    <span class="order-status processing">

                                        <span class="order-status-dot"></span>

                                        Processing

                                    </span>

                                @elseif($order->status === 'Pending')

                                    <span class="order-status pending">

                                        <span class="order-status-dot"></span>

                                        Pending

                                    </span>

                                @else

                                    <span class="order-status cancelled">

                                        <span class="order-status-dot"></span>

                                        {{ $order->status }}

                                    </span>

                                @endif

                            </td>


                            {{-- ACTION --}}

                            <td class="text-end">

                                <a
                                    href="{{ route('orders.show', $order) }}"
                                    class="order-view-btn"
                                    title="View Order"
                                >

                                    <i class="bi bi-eye"></i>

                                </a>

                            </td>


                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center py-5"
                            >

                                <div class="order-empty-icon mx-auto mb-3">

                                    <i class="bi bi-cart-x"></i>

                                </div>

                                <h6 class="fw-semibold">
                                    No orders found
                                </h6>

                                <p class="text-muted small mb-0">
                                    There are currently no orders to display.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     LIVE SEARCH / AUTO FILTER
========================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector(
        'form[action="{{ route('orders.index') }}"]'
    );

    if (!form) {
        return;
    }

    const searchInput = form.querySelector(
        'input[name="search"]'
    );

    const filters = form.querySelectorAll('select');

    let timer;


    /* -------------------------------------------------------
       Live Search
    ------------------------------------------------------- */

    if (searchInput) {

        searchInput.addEventListener('keyup', function () {

            clearTimeout(timer);

            timer = setTimeout(function () {

                form.submit();

            }, 400);

        });

    }


    /* -------------------------------------------------------
       Auto Filter
    ------------------------------------------------------- */

    filters.forEach(function (filter) {

        filter.addEventListener('change', function () {

            form.submit();

        });

    });

});

</script>

@endsection