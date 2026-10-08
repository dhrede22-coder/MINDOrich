@extends('admin.layouts.app')

@section('title', 'Purchases')

@section('content')

<style>

/* =========================================================
   MINDOrich PURCHASES
========================================================= */

.purchases-page {
    padding-bottom: 2rem;
}

/* ---------------------------------------------------------
   HEADER
--------------------------------------------------------- */

.purchases-header {
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

.purchases-header-icon {
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

.purchases-header h4 {
    color: #1f2937;
}

.purchases-header p {
    font-size: 0.9rem;
}

/* ---------------------------------------------------------
   ADD PURCHASE BUTTON
--------------------------------------------------------- */

.purchases-add-btn {
    background: #c88a2b;
    border-color: #c88a2b;

    color: #ffffff;

    border-radius: 10px;

    padding: 0.65rem 1rem;

    font-weight: 600;

    white-space: nowrap;
}

.purchases-add-btn:hover,
.purchases-add-btn:focus {
    background: #a86f1f;
    border-color: #a86f1f;
    color: #ffffff;
}

/* ---------------------------------------------------------
   ALERT
--------------------------------------------------------- */

.purchases-alert {
    border-radius: 12px;
    border: 1px solid rgba(31, 41, 55, 0.08);
}

/* ---------------------------------------------------------
   SECTION HEADING
--------------------------------------------------------- */

.purchase-section-icon {
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

.purchase-section-title {
    font-size: 0.98rem;
    font-weight: 700;

    color: #1f2937;

    margin-bottom: 0.1rem;
}

.purchase-section-subtitle {
    font-size: 0.78rem;

    color: #6b7280;

    margin-bottom: 0;
}

/* ---------------------------------------------------------
   KPI
--------------------------------------------------------- */

.purchase-kpi {
    position: relative;

    height: 100%;

    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 14px;

    padding: 1rem 1.1rem;

    box-shadow: 0 3px 10px rgba(31, 41, 55, 0.035);

    overflow: hidden;
}

.purchase-kpi::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;
    bottom: 0;

    width: 4px;

    background: #c88a2b;
}

.purchase-kpi.success::before {
    background: #198754;
}

.purchase-kpi.warning::before {
    background: #c88a2b;
}

.purchase-kpi.neutral::before {
    background: #6b7280;
}

.purchase-kpi-label {
    color: #6b7280;

    font-size: 0.76rem;
    font-weight: 600;

    margin-bottom: 0.25rem;
}

.purchase-kpi-value {
    color: #1f2937;

    font-size: 1.4rem;
    font-weight: 700;

    line-height: 1.2;
}

.purchase-kpi-icon {
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

.purchases-filter-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);
}

.purchases-filter-card .form-label {
    color: #374151;
    font-size: 0.78rem;
}

.purchases-filter-card .form-control,
.purchases-filter-card .form-select {
    min-height: 40px;

    border-radius: 9px;

    border-color: rgba(31, 41, 55, 0.12);

    font-size: 0.82rem;
}

.purchases-filter-card .form-control:focus,
.purchases-filter-card .form-select:focus {
    border-color: #c88a2b;

    box-shadow: 0 0 0 0.2rem rgba(200, 138, 43, 0.12);
}

.purchases-filter-icon {
    background: #f8f9fa;

    border-color: rgba(31, 41, 55, 0.12);

    color: #6b7280;
}

/* ---------------------------------------------------------
   FILTER BUTTONS
--------------------------------------------------------- */

.purchases-filter-btn {
    background: #2f5d50;
    border-color: #2f5d50;

    border-radius: 9px;

    font-size: 0.8rem;
    font-weight: 600;
}

.purchases-filter-btn:hover {
    background: #24493f;
    border-color: #24493f;
}

.purchases-clear-btn {
    border-radius: 9px;

    font-size: 0.8rem;
    font-weight: 600;
}

/* ---------------------------------------------------------
   PURCHASE DIRECTORY
--------------------------------------------------------- */

.purchases-directory-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);

    overflow: hidden;
}

.purchases-directory-header {
    padding: 1.1rem 1.25rem;

    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 1rem;

    border-bottom: 1px solid rgba(31, 41, 55, 0.06);
}

/* ---------------------------------------------------------
   TABLE
--------------------------------------------------------- */

.purchases-table-wrapper {
    overflow-x: auto;
}

.purchases-table {
    margin-bottom: 0;
}

.purchases-table thead th {
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

.purchases-table tbody td {
    padding: 0.9rem 1rem;

    color: #374151;

    font-size: 0.82rem;

    border-color: rgba(31, 41, 55, 0.06);

    vertical-align: middle;
}

.purchases-table tbody tr:last-child td {
    border-bottom: 0;
}

.purchases-table tbody tr:hover {
    background: #faf7f2;
}

/* ---------------------------------------------------------
   PURCHASE NUMBER
--------------------------------------------------------- */

.purchase-number-wrapper {
    display: flex;
    align-items: center;
    gap: 0.7rem;
}

.purchase-number-icon {
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

.purchase-number {
    color: #1f2937;

    font-weight: 700;

    font-size: 0.82rem;
}

/* ---------------------------------------------------------
   PRODUCER
--------------------------------------------------------- */

.purchase-producer {
    font-weight: 600;

    color: #374151;
}

/* ---------------------------------------------------------
   DATE
--------------------------------------------------------- */

.purchase-date {
    color: #4b5563;

    white-space: nowrap;
}

/* ---------------------------------------------------------
   ITEMS
--------------------------------------------------------- */

.purchase-items {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;

    color: #374151;

    font-weight: 600;
}

.purchase-items i {
    color: #6b7280;
}

/* ---------------------------------------------------------
   TOTAL
--------------------------------------------------------- */

.purchase-total {
    color: #1f2937;

    font-weight: 700;

    white-space: nowrap;
}

/* ---------------------------------------------------------
   STATUS
--------------------------------------------------------- */

.purchase-status {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;

    padding: 0.38rem 0.65rem;

    border-radius: 999px;

    font-size: 0.68rem;

    font-weight: 700;

    white-space: nowrap;
}

.purchase-status-dot {
    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: currentColor;
}

.purchase-status.completed {
    background: rgba(25, 135, 84, 0.10);
    color: #198754;
}

.purchase-status.pending {
    background: rgba(200, 138, 43, 0.12);
    color: #a86f1f;
}

.purchase-status.cancelled {
    background: rgba(108, 117, 125, 0.10);
    color: #6c757d;
}

/* ---------------------------------------------------------
   VIEW BUTTON
--------------------------------------------------------- */

.purchase-view-btn {
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

.purchase-view-btn:hover {
    background: #2f5d50;
    color: #ffffff;
}

/* ---------------------------------------------------------
   PAGINATION
--------------------------------------------------------- */

.purchases-pagination {
    padding: 1rem 1.25rem;

    border-top: 1px solid rgba(31, 41, 55, 0.06);
}

/* ---------------------------------------------------------
   EMPTY STATE
--------------------------------------------------------- */

.purchase-empty-icon {
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

    .purchases-header {
        padding: 1rem;
    }

    .purchases-header-action {
        width: 100%;
    }

    .purchases-add-btn {
        width: 100%;
    }

    .purchases-directory-header {
        align-items: flex-start;

        flex-direction: column;
    }

}

</style>


<div class="container-fluid purchases-page">


    {{-- =====================================================
         SUCCESS ALERT
    ====================================================== --}}

    @if(session('success'))

        <div
            class="alert alert-success purchases-alert alert-dismissible fade show mb-4"
            role="alert"
        >

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>

    @endif


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="purchases-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div class="d-flex align-items-center gap-3">

                <div class="purchases-header-icon">

                    <i class="bi bi-bag-check-fill"></i>

                </div>

                <div>

                    <h4 class="fw-bold mb-1">
                        Purchases
                    </h4>

                    <p class="text-muted mb-0">
                        Track wholesale purchases from Mangyan Producers.
                    </p>

                </div>

            </div>


            <div class="purchases-header-action">

                <a
                    href="{{ route('admin.purchases.create') }}"
                    class="btn purchases-add-btn"
                >

                    <i class="bi bi-plus-circle me-2"></i>

                    Add Purchase

                </a>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PURCHASE OVERVIEW
    ====================================================== --}}

    <div class="mb-4">

        <div class="d-flex align-items-center gap-2 mb-3">

            <div class="purchase-section-icon">

                <i class="bi bi-bar-chart-line-fill"></i>

            </div>

            <div>

                <div class="purchase-section-title">
                    Purchase Overview
                </div>

                <p class="purchase-section-subtitle">
                    Quick summary of your purchase records.
                </p>

            </div>

        </div>


        <div class="row g-3">


            {{-- TOTAL PURCHASES --}}

            <div class="col-xl-3 col-md-6">

                <div class="purchase-kpi">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="purchase-kpi-label">
                                Total Purchases
                            </div>

                            <div class="purchase-kpi-value">
                                {{ number_format($purchases->total()) }}
                            </div>

                        </div>

                        <div class="purchase-kpi-icon">

                            <i class="bi bi-bag-check"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- COMPLETED --}}

            <div class="col-xl-3 col-md-6">

                <div class="purchase-kpi success">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="purchase-kpi-label">
                                Completed
                            </div>

                            <div class="purchase-kpi-value">

                                {{ number_format(
                                    $purchases->where('status', 'Completed')->count()
                                ) }}

                            </div>

                        </div>

                        <div class="purchase-kpi-icon">

                            <i class="bi bi-check-circle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- PENDING --}}

            <div class="col-xl-3 col-md-6">

                <div class="purchase-kpi warning">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="purchase-kpi-label">
                                Pending
                            </div>

                            <div class="purchase-kpi-value">

                                {{ number_format(
                                    $purchases->where('status', 'Pending')->count()
                                ) }}

                            </div>

                        </div>

                        <div class="purchase-kpi-icon">

                            <i class="bi bi-clock-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- CANCELLED --}}

            <div class="col-xl-3 col-md-6">

                <div class="purchase-kpi neutral">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="purchase-kpi-label">
                                Cancelled
                            </div>

                            <div class="purchase-kpi-value">

                                {{ number_format(
                                    $purchases->where('status', 'Cancelled')->count()
                                ) }}

                            </div>

                        </div>

                        <div class="purchase-kpi-icon">

                            <i class="bi bi-x-circle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>


    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="purchases-filter-card mb-4">

        <div class="p-4">

            <div class="d-flex align-items-center gap-2 mb-3">

                <div class="purchase-section-icon">

                    <i class="bi bi-funnel-fill"></i>

                </div>

                <div>

                    <div class="purchase-section-title">
                        Purchase Filters
                    </div>

                    <p class="purchase-section-subtitle">
                        Narrow down purchase records by number, producer, product, status, or date.
                    </p>

                </div>

            </div>


            <form
                action="{{ route('admin.purchases.index') }}"
                method="GET"
            >

                <div class="row g-3">


                    {{-- SEARCH --}}

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            Search Purchase
                        </label>

                        <div class="input-group">

                            <span class="input-group-text purchases-filter-icon">

                                <i class="bi bi-search"></i>

                            </span>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                value="{{ request('search') }}"
                                placeholder="Purchase number..."
                            >

                        </div>

                    </div>


                    {{-- PRODUCER --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Producer
                        </label>

                        <select
                            name="producer_id"
                            class="form-select"
                        >

                            <option value="">
                                All Producers
                            </option>

                            @foreach($producers as $producer)

                                <option
                                    value="{{ $producer->id }}"
                                    {{ request('producer_id') == $producer->id ? 'selected' : '' }}
                                >

                                    {{ $producer->producer_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- PRODUCT --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Product
                        </label>

                        <select
                            name="product_id"
                            class="form-select"
                        >

                            <option value="">
                                All Products
                            </option>

                            @foreach($products as $product)

                                <option
                                    value="{{ $product->id }}"
                                    {{ request('product_id') == $product->id ? 'selected' : '' }}
                                >

                                    {{ $product->product_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- STATUS --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select"
                        >

                            <option value="">
                                All Status
                            </option>

                            @foreach($statuses as $purchaseStatus)

                                <option
                                    value="{{ $purchaseStatus }}"
                                    {{ request('status') === $purchaseStatus ? 'selected' : '' }}
                                >

                                    {{ $purchaseStatus }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- DATE FROM --}}

                    <div class="col-lg-1 col-md-6">

                        <label class="form-label fw-semibold">
                            From
                        </label>

                        <input
                            type="date"
                            name="date_from"
                            class="form-control"
                            value="{{ request('date_from') }}"
                        >

                    </div>


                    {{-- DATE TO --}}

                    <div class="col-lg-1 col-md-6">

                        <label class="form-label fw-semibold">
                            To
                        </label>

                        <input
                            type="date"
                            name="date_to"
                            class="form-control"
                            value="{{ request('date_to') }}"
                        >

                    </div>


                </div>


                {{-- FILTER BUTTONS --}}

                <div class="d-flex flex-wrap gap-2 mt-3">

                    <button
                        type="submit"
                        class="btn btn-primary purchases-filter-btn"
                    >

                        <i class="bi bi-funnel me-1"></i>

                        Apply Filters

                    </button>


                    @if(
                        request('search') ||
                        request('producer_id') ||
                        request('product_id') ||
                        request('status') ||
                        request('date_from') ||
                        request('date_to')
                    )

                        <a
                            href="{{ route('admin.purchases.index') }}"
                            class="btn btn-outline-secondary purchases-clear-btn"
                        >

                            <i class="bi bi-x-circle me-1"></i>

                            Clear Filters

                        </a>

                    @endif

                </div>

            </form>

        </div>

    </div>


    {{-- =====================================================
         PURCHASE DIRECTORY
    ====================================================== --}}

    <div class="purchases-directory-card">


        <div class="purchases-directory-header">

            <div class="d-flex align-items-center gap-3">

                <div class="purchase-section-icon">

                    <i class="bi bi-receipt-cutoff"></i>

                </div>

                <div>

                    <div class="purchase-section-title">
                        Purchase Directory
                    </div>

                    <p class="purchase-section-subtitle">
                        View and manage wholesale purchase records.
                    </p>

                </div>

            </div>


            <div class="text-muted small">

                {{ $purchases->total() }}

                {{ $purchases->total() === 1 ? 'purchase' : 'purchases' }}

            </div>

        </div>


        {{-- =================================================
             PURCHASE TABLE
        ================================================== --}}

        <div class="purchases-table-wrapper">

            @if($purchases->count())

                <table class="table purchases-table align-middle">

                    <thead>

                        <tr>

                            <th>
                                Purchase No.
                            </th>

                            <th>
                                Producer
                            </th>

                            <th>
                                Purchase Date
                            </th>

                            <th>
                                Items
                            </th>

                            <th>
                                Total Paid
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

                        @foreach($purchases as $purchase)

                            <tr>


                                {{-- PURCHASE NUMBER --}}

                                <td>

                                    <div class="purchase-number-wrapper">

                                        <div class="purchase-number-icon">

                                            <i class="bi bi-receipt"></i>

                                        </div>

                                        <div class="purchase-number">

                                            {{ $purchase->purchase_number }}

                                        </div>

                                    </div>

                                </td>


                                {{-- PRODUCER --}}

                                <td>

                                    <span class="purchase-producer">

                                        {{ $purchase->producer->producer_name ?? 'N/A' }}

                                    </span>

                                </td>


                                {{-- DATE --}}

                                <td>

                                    <span class="purchase-date">

                                        <i class="bi bi-calendar3 me-1 text-muted"></i>

                                        {{ $purchase->purchase_date->format('M d, Y') }}

                                    </span>

                                </td>


                                {{-- ITEMS --}}

                                <td>

                                    <span class="purchase-items">

                                        <i class="bi bi-box-seam"></i>

                                        {{ $purchase->purchase_items_count }}

                                    </span>

                                </td>


                                {{-- TOTAL --}}

                                <td>

                                    <span class="purchase-total">

                                        ₱{{ number_format($purchase->total_purchase_cost, 2) }}

                                    </span>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if($purchase->status === 'Completed')

                                        <span class="purchase-status completed">

                                            <span class="purchase-status-dot"></span>

                                            Completed

                                        </span>

                                    @elseif($purchase->status === 'Pending')

                                        <span class="purchase-status pending">

                                            <span class="purchase-status-dot"></span>

                                            Pending

                                        </span>

                                    @else

                                        <span class="purchase-status cancelled">

                                            <span class="purchase-status-dot"></span>

                                            Cancelled

                                        </span>

                                    @endif

                                </td>


                                {{-- ACTION --}}

                                <td class="text-end">

                                    <a
                                        href="{{ route('admin.purchases.show', $purchase) }}"
                                        class="purchase-view-btn"
                                        title="View Purchase"
                                    >

                                        <i class="bi bi-eye"></i>

                                    </a>

                                </td>


                            </tr>

                        @endforeach

                    </tbody>

                </table>


                {{-- PAGINATION --}}

                <div class="purchases-pagination">

                    {{ $purchases->links('pagination::bootstrap-5') }}

                </div>


            @else

                {{-- EMPTY STATE --}}

                <div class="text-center py-5 px-3">

                    <div class="purchase-empty-icon mx-auto mb-3">

                        <i class="bi bi-receipt"></i>

                    </div>

                    <h5 class="fw-semibold">
                        No purchases found
                    </h5>

                    <p class="text-muted mb-3">

                        No purchase records match your current search or filters.

                    </p>


                    <a
                        href="{{ route('admin.purchases.index') }}"
                        class="btn btn-outline-secondary purchases-clear-btn me-2"
                    >

                        <i class="bi bi-x-circle me-1"></i>

                        Clear Filters

                    </a>


                    <a
                        href="{{ route('admin.purchases.create') }}"
                        class="btn purchases-add-btn"
                    >

                        <i class="bi bi-plus-lg me-1"></i>

                        Add Purchase

                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection