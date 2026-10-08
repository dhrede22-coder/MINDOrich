@extends('admin.layouts.app')

@section('title', 'Analytics')

@section('content')

<style>

/* =========================================================
   MINDOrich ANALYTICS
   Same visual system as Reports
========================================================= */

.analytics-page {
    padding-bottom: 2rem;
}

/* ---------------------------------------------------------
   PAGE HEADER
--------------------------------------------------------- */

.analytics-header {
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

.analytics-header .analytics-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    background: rgba(200, 138, 43, 0.12);
    color: #a86f1f;

    font-size: 1.35rem;
}

.analytics-header h4 {
    color: #1f2937;
}

.analytics-header p {
    font-size: 0.9rem;
}

.analytics-period-pill {
    display: inline-flex;
    align-items: center;

    padding: 0.45rem 0.75rem;

    border-radius: 999px;

    background: #f3f4f6;
    color: #4b5563;

    font-size: 0.78rem;
    font-weight: 600;
}

/* ---------------------------------------------------------
   FILTER CARD
--------------------------------------------------------- */

.analytics-filter-card {
    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;
    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);
}

.analytics-filter-card .form-label {
    font-size: 0.82rem;
    color: #4b5563;
}

.analytics-filter-card .form-select,
.analytics-filter-card .form-control {
    border-radius: 10px;
    min-height: 42px;
}

/* ---------------------------------------------------------
   SECTION CARDS
--------------------------------------------------------- */

.analytics-section-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);

    overflow: hidden;
}

.analytics-section-header {
    padding: 1.15rem 1.25rem;

    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.analytics-section-icon {
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

.analytics-section-title {
    font-size: 0.98rem;
    font-weight: 700;

    color: #1f2937;

    margin-bottom: 0.1rem;
}

.analytics-section-subtitle {
    font-size: 0.78rem;
    color: #6b7280;

    margin: 0;
}

/* ---------------------------------------------------------
   KPI CARDS
--------------------------------------------------------- */

.analytics-kpi {
    position: relative;

    height: 100%;

    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 14px;

    padding: 1rem 1.1rem;

    box-shadow: 0 3px 10px rgba(31, 41, 55, 0.035);

    overflow: hidden;
}

.analytics-kpi::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;
    bottom: 0;

    width: 4px;

    background: #2f5d50;
}

.analytics-kpi.success::before {
    background: #198754;
}

.analytics-kpi.warning::before {
    background: #c88a2b;
}

.analytics-kpi.danger::before {
    background: #dc3545;
}

.analytics-kpi.info::before {
    background: #0d6efd;
}

.analytics-kpi.neutral::before {
    background: #6b7280;
}

.analytics-kpi-label {
    color: #6b7280;
    font-size: 0.76rem;
    font-weight: 600;

    margin-bottom: 0.25rem;
}

.analytics-kpi-value {
    color: #1f2937;

    font-size: 1.35rem;
    font-weight: 700;

    line-height: 1.2;

    white-space: nowrap;
}

.analytics-kpi-note {
    color: #9ca3af;
    font-size: 0.72rem;

    margin-top: 0.25rem;
}

.analytics-kpi-icon {
    width: 38px;
    height: 38px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f8f9fa;
    color: #374151;

    font-size: 1rem;
}

/* ---------------------------------------------------------
   CHART
--------------------------------------------------------- */

.analytics-chart-body {
    padding: 0 1.25rem 1.25rem;
}

.analytics-chart {
    position: relative;
    width: 100%;
    height: 310px;
}

.analytics-chart-sm {
    position: relative;
    width: 100%;
    height: 270px;
}

/* ---------------------------------------------------------
   TABLES
--------------------------------------------------------- */

.analytics-table-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);

    overflow: hidden;
}

.analytics-table-card .table {
    margin-bottom: 0;
}

.analytics-table-card thead th {
    background: #f8f9fa;

    color: #6b7280;

    font-size: 0.74rem;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: 0.025em;

    border-bottom: 1px solid rgba(31, 41, 55, 0.07);

    padding: 0.8rem 1rem;

    white-space: nowrap;
}

.analytics-table-card tbody td {
    padding: 0.85rem 1rem;

    color: #374151;

    font-size: 0.84rem;

    border-color: rgba(31, 41, 55, 0.06);
}

.analytics-table-card tbody tr:last-child td {
    border-bottom: 0;
}

.analytics-table-card .table-hover tbody tr:hover {
    background: #faf7f2;
}

/* ---------------------------------------------------------
   RANK
--------------------------------------------------------- */

.analytics-rank {
    width: 30px;
    height: 30px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: #f3f4f6;

    color: #4b5563;

    font-size: 0.78rem;
    font-weight: 700;
}

.analytics-rank.top {
    background: rgba(200, 138, 43, 0.12);
    color: #a86f1f;
}

/* ---------------------------------------------------------
   ENTITY ICON
--------------------------------------------------------- */

.analytics-entity-icon {
    width: 34px;
    height: 34px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: #f8f9fa;

    color: #2f5d50;

    flex-shrink: 0;
}

/* ---------------------------------------------------------
   INVENTORY SUMMARY
--------------------------------------------------------- */

.inventory-summary-card {
    border-radius: 14px;

    border: 1px solid rgba(31, 41, 55, 0.08);

    background: #ffffff;

    padding: 1rem;
}

.inventory-summary-icon {
    width: 40px;
    height: 40px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f8f9fa;

    font-size: 1.05rem;
}

/* ---------------------------------------------------------
   RESPONSIVE
--------------------------------------------------------- */

@media (max-width: 767.98px) {

    .analytics-header {
        padding: 1rem;
    }

    .analytics-header-actions {
        margin-top: 1rem;
        width: 100%;
    }

    .analytics-period-pill {
        width: 100%;
        justify-content: center;
    }

    .analytics-kpi-value {
        font-size: 1.2rem;
    }

    .analytics-chart {
        height: 270px;
    }

    .analytics-chart-sm {
        height: 250px;
    }

}

</style>


<div class="container-fluid analytics-page">


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="analytics-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div class="d-flex align-items-center gap-3">

                <div class="analytics-icon">
                    <i class="bi bi-bar-chart-line-fill"></i>
                </div>

                <div>

                    <h4 class="fw-bold mb-1">
                        Analytics
                    </h4>

                    <p class="text-muted mb-0">
                        Analyze sales trends, order activity, and inventory performance.
                    </p>

                </div>

            </div>


            <div class="analytics-header-actions">

                <span class="analytics-period-pill">

    <i class="bi bi-calendar3 me-2"></i>

    @if($period === 'custom')

        {{ request('from')
            ? \Carbon\Carbon::parse(request('from'))->format('M d, Y')
            : 'Start Date'
        }}

        <span class="mx-1">–</span>

        {{ request('to')
            ? \Carbon\Carbon::parse(request('to'))->format('M d, Y')
            : 'End Date'
        }}

    @elseif($period === 'today')

        Today

    @elseif($period === 'week')

        This Week

    @elseif($period === 'year')

        This Year

    @else

        This Month

    @endif

</span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         DATE FILTER
    ====================================================== --}}

    <div class="analytics-section-card analytics-filter-card mb-4">

        <div class="analytics-section-header">

            <div class="analytics-section-icon">
                <i class="bi bi-funnel-fill"></i>
            </div>

            <div>

                <div class="analytics-section-title">
                    Analytics Filter
                </div>

                <p class="analytics-section-subtitle">
                    Select the period you want to analyze.
                </p>

            </div>

        </div>


        <div class="px-4 pb-4">

            <form
                method="GET"
                action="{{ route('admin.analytics.index') }}"
            >

                <div class="row g-3 align-items-end">

                    {{-- PERIOD --}}

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            Period
                        </label>

                        <select
                            name="period"
                            id="period"
                            class="form-select"
                            onchange="toggleCustomDates()"
                        >

                            <option
                                value="today"
                                {{ $period === 'today' ? 'selected' : '' }}
                            >
                                Today
                            </option>

                            <option
                                value="week"
                                {{ $period === 'week' ? 'selected' : '' }}
                            >
                                This Week
                            </option>

                            <option
                                value="month"
                                {{ $period === 'month' ? 'selected' : '' }}
                            >
                                This Month
                            </option>

                            <option
                                value="year"
                                {{ $period === 'year' ? 'selected' : '' }}
                            >
                                This Year
                            </option>

                            <option
                                value="custom"
                                {{ $period === 'custom' ? 'selected' : '' }}
                            >
                                Custom Date
                            </option>

                        </select>

                    </div>


                    {{-- FROM --}}

                    <div
                        class="col-lg-3 col-md-6 custom-date-field"
                        style="{{ $period === 'custom' ? '' : 'display:none;' }}"
                    >

                        <label class="form-label fw-semibold">
                            From
                        </label>

                        <input
                            type="date"
                            name="from"
                            class="form-control"
                            value="{{ request('from') }}"
                        >

                    </div>


                    {{-- TO --}}

                    <div
                        class="col-lg-3 col-md-6 custom-date-field"
                        style="{{ $period === 'custom' ? '' : 'display:none;' }}"
                    >

                        <label class="form-label fw-semibold">
                            To
                        </label>

                        <input
                            type="date"
                            name="to"
                            class="form-control"
                            value="{{ request('to') }}"
                        >

                    </div>


                    {{-- BUTTON --}}

                    <div class="col-lg-auto col-md-6">

                        <button
                            type="submit"
                            class="btn btn-primary px-4"
                        >

                            <i class="bi bi-funnel-fill me-1"></i>

                            Apply Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =====================================================
         PERFORMANCE SNAPSHOT
    ====================================================== --}}

    <div class="mb-4">

        <div class="d-flex align-items-center gap-2 mb-3">

            <div class="analytics-section-icon">
                <i class="bi bi-speedometer2"></i>
            </div>

            <div>

                <div class="analytics-section-title">
                    Performance Snapshot
                </div>

                <p class="analytics-section-subtitle">
                    Key sales and order indicators for the selected period.
                </p>

            </div>

        </div>


        <div class="row g-3">

            {{-- TOTAL SALES --}}

            <div class="col-xl-3 col-md-6">

                <div class="analytics-kpi success">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="analytics-kpi-label">
                                Total Sales
                            </div>

                            <div class="analytics-kpi-value">
                                ₱{{ number_format($totalSales, 2) }}
                            </div>

                            <div class="analytics-kpi-note">
                                Completed sales revenue
                            </div>

                        </div>

                        <div class="analytics-kpi-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- TOTAL ORDERS --}}

            <div class="col-xl-3 col-md-6">

                <div class="analytics-kpi info">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="analytics-kpi-label">
                                Total Orders
                            </div>

                            <div class="analytics-kpi-value">
                                {{ number_format($totalOrders) }}
                            </div>

                            <div class="analytics-kpi-note">
                                Orders within period
                            </div>

                        </div>

                        <div class="analytics-kpi-icon">
                            <i class="bi bi-cart-check-fill"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- ONLINE SALES --}}

            <div class="col-xl-3 col-md-6">

                <div class="analytics-kpi">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="analytics-kpi-label">
                                Online Sales
                            </div>

                            <div class="analytics-kpi-value">
                                ₱{{ number_format($onlineSales, 2) }}
                            </div>

                            <div class="analytics-kpi-note">
                                Completed online sales
                            </div>

                        </div>

                        <div class="analytics-kpi-icon">
                            <i class="bi bi-globe2"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- WALK-IN SALES --}}

            <div class="col-xl-3 col-md-6">

                <div class="analytics-kpi warning">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="analytics-kpi-label">
                                Walk-in Sales
                            </div>

                            <div class="analytics-kpi-value">
                                ₱{{ number_format($walkInSales, 2) }}
                            </div>

                            <div class="analytics-kpi-note">
                                Completed walk-in sales
                            </div>

                        </div>

                        <div class="analytics-kpi-icon">
                            <i class="bi bi-shop"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- COMPLETED ORDERS --}}

            <div class="col-xl-3 col-md-6">

                <div class="analytics-kpi success">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="analytics-kpi-label">
                                Completed Orders
                            </div>

                            <div class="analytics-kpi-value">
                                {{ number_format($completedOrders) }}
                            </div>

                            <div class="analytics-kpi-note">
                                Successfully completed
                            </div>

                        </div>

                        <div class="analytics-kpi-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- PENDING ORDERS --}}

            <div class="col-xl-3 col-md-6">

                <div class="analytics-kpi warning">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="analytics-kpi-label">
                                Pending Orders
                            </div>

                            <div class="analytics-kpi-value">
                                {{ number_format($pendingOrders) }}
                            </div>

                            <div class="analytics-kpi-note">
                                Requires attention
                            </div>

                        </div>

                        <div class="analytics-kpi-icon">
                            <i class="bi bi-clock-fill"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- AVAILABLE PRODUCTS --}}

            <div class="col-xl-3 col-md-6">

                <div class="analytics-kpi success">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="analytics-kpi-label">
                                Available Products
                            </div>

                            <div class="analytics-kpi-value">
                                {{ number_format($availableProducts) }}
                            </div>

                            <div class="analytics-kpi-note">
                                Currently available
                            </div>

                        </div>

                        <div class="analytics-kpi-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- OUT OF STOCK --}}

            <div class="col-xl-3 col-md-6">

                <div class="analytics-kpi danger">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="analytics-kpi-label">
                                Out of Stock
                            </div>

                            <div class="analytics-kpi-value">
                                {{ number_format($outOfStockProducts) }}
                            </div>

                            <div class="analytics-kpi-note">
                                Products unavailable
                            </div>

                        </div>

                        <div class="analytics-kpi-icon">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         SALES OVERVIEW
    ====================================================== --}}

    <div class="analytics-section-card mb-4">

        <div class="analytics-section-header">

            <div class="analytics-section-icon">
                <i class="bi bi-graph-up-arrow"></i>
            </div>

            <div>

                <div class="analytics-section-title">
                    Sales Overview
                </div>

                <p class="analytics-section-subtitle">
                    Visualize sales activity and order distribution.
                </p>

            </div>

        </div>


        <div class="row g-0">


            {{-- SALES TREND --}}

            <div class="col-lg-8">

                <div class="analytics-chart-body">

                    <div class="mb-3">

                        <div class="fw-semibold">
                            Sales Trend
                        </div>

                        <small class="text-muted">
                            Completed sales revenue over time.
                        </small>

                    </div>

                    <div class="analytics-chart">

                        <canvas id="salesTrendChart"></canvas>

                    </div>

                </div>

            </div>


            {{-- SALES TYPE --}}

            <div class="col-lg-4">

                <div class="analytics-chart-body">

                    <div class="mb-3">

                        <div class="fw-semibold">
                            Sales by Type
                        </div>

                        <small class="text-muted">
                            Online versus walk-in sales.
                        </small>

                    </div>

                    <div class="analytics-chart-sm">

                        <canvas id="salesTypeChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         ORDER + INVENTORY ANALYTICS
    ====================================================== --}}

    <div class="row g-4 mb-4">


        {{-- ORDER STATUS --}}

        <div class="col-lg-6">

            <div class="analytics-section-card h-100">

                <div class="analytics-section-header">

                    <div class="analytics-section-icon">
                        <i class="bi bi-list-check"></i>
                    </div>

                    <div>

                        <div class="analytics-section-title">
                            Order Status
                        </div>

                        <p class="analytics-section-subtitle">
                            Distribution of orders by status.
                        </p>

                    </div>

                </div>

                <div class="analytics-chart-body">

                    <div class="analytics-chart-sm">

                        <canvas id="orderStatusChart"></canvas>

                    </div>

                </div>

            </div>

        </div>


        {{-- INVENTORY --}}

        <div class="col-lg-6">

            <div class="analytics-section-card h-100">

                <div class="analytics-section-header">

                    <div class="analytics-section-icon">
                        <i class="bi bi-boxes"></i>
                    </div>

                    <div>

                        <div class="analytics-section-title">
                            Inventory Status
                        </div>

                        <p class="analytics-section-subtitle">
                            Current product availability and stock condition.
                        </p>

                    </div>

                </div>

                <div class="analytics-chart-body">

                    <div class="analytics-chart-sm">

                        <canvas id="inventoryChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PRODUCT PERFORMANCE
    ====================================================== --}}

    <div class="analytics-table-card mb-4">

        <div class="analytics-section-header">

            <div class="analytics-section-icon">
                <i class="bi bi-trophy-fill"></i>
            </div>

            <div>

                <div class="analytics-section-title">
                    Top Products
                </div>

                <p class="analytics-section-subtitle">
                    Best-performing products based on quantity sold and sales revenue.
                </p>

            </div>

        </div>


        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th class="ps-4">
                            Rank
                        </th>

                        <th>
                            Product
                        </th>

                        <th>
                            Quantity Sold
                        </th>

                        <th>
                            Sales
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($topProducts as $index => $product)

                        <tr>

                            <td class="ps-4">

                                <span
                                    class="analytics-rank {{ $index < 3 ? 'top' : '' }}"
                                >

                                    {{ $index + 1 }}

                                </span>

                            </td>


                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    <div class="analytics-entity-icon">

                                        <i class="bi bi-box-seam"></i>

                                    </div>

                                    <div>

                                        <div class="fw-semibold">
                                            {{ $product->product_name }}
                                        </div>

                                        <small class="text-muted">
                                            Product performance
                                        </small>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <span class="fw-semibold">
                                    {{ number_format($product->quantity_sold) }}
                                </span>

                                <small class="text-muted">
                                    units
                                </small>

                            </td>


                            <td>

                                <span class="fw-semibold">

                                    ₱{{ number_format(
                                        $product->total_sales,
                                        2
                                    ) }}

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="text-center text-muted py-5"
                            >

                                <i class="bi bi-box-seam d-block fs-3 mb-2"></i>

                                No product sales data available.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
         TRIBE + CRAFTSMAN PERFORMANCE
    ====================================================== --}}

    <div class="row g-4 mb-4">


        {{-- TOP TRIBES --}}

        <div class="col-lg-6">

            <div class="analytics-table-card h-100">

                <div class="analytics-section-header">

                    <div class="analytics-section-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <div>

                        <div class="analytics-section-title">
                            Top Tribes
                        </div>

                        <p class="analytics-section-subtitle">
                            Sales performance by Mangyan tribe.
                        </p>

                    </div>

                </div>


                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th class="ps-4">
                                    Rank
                                </th>

                                <th>
                                    Tribe
                                </th>

                                <th>
                                    Sold
                                </th>

                                <th>
                                    Sales
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($topTribes as $index => $tribe)

                                <tr>

                                    <td class="ps-4">

                                        <span
                                            class="analytics-rank {{ $index < 3 ? 'top' : '' }}"
                                        >

                                            {{ $index + 1 }}

                                        </span>

                                    </td>


                                    <td>

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="analytics-entity-icon">

                                                <i class="bi bi-people-fill"></i>

                                            </div>

                                            <span class="fw-semibold">

                                                {{ $tribe->tribe_name }}

                                            </span>

                                        </div>

                                    </td>


                                    <td>

                                        <span class="fw-semibold">

                                            {{ number_format(
                                                $tribe->quantity_sold
                                            ) }}

                                        </span>

                                        <small class="text-muted">
                                            units
                                        </small>

                                    </td>


                                    <td>

                                        <span class="fw-semibold">

                                            ₱{{ number_format(
                                                $tribe->total_sales,
                                                2
                                            ) }}

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="text-center text-muted py-5"
                                    >

                                        <i class="bi bi-people d-block fs-3 mb-2"></i>

                                        No tribe sales data available.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- TOP CRAFTSMEN --}}

        <div class="col-lg-6">

            <div class="analytics-table-card h-100">

                <div class="analytics-section-header">

                    <div class="analytics-section-icon">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>

                    <div>

                        <div class="analytics-section-title">
                            Top Craftsmen
                        </div>

                        <p class="analytics-section-subtitle">
                            Sales performance by Mangyan producer.
                        </p>

                    </div>

                </div>


                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th class="ps-4">
                                    Rank
                                </th>

                                <th>
                                    Craftsman
                                </th>

                                <th>
                                    Sold
                                </th>

                                <th>
                                    Sales
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($topCraftsmen as $index => $craftsman)

                                <tr>

                                    <td class="ps-4">

                                        <span
                                            class="analytics-rank {{ $index < 3 ? 'top' : '' }}"
                                        >

                                            {{ $index + 1 }}

                                        </span>

                                    </td>


                                    <td>

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="analytics-entity-icon">

                                                <i class="bi bi-person-badge-fill"></i>

                                            </div>

                                            <span class="fw-semibold">

                                                {{ $craftsman->producer_name }}

                                            </span>

                                        </div>

                                    </td>


                                    <td>

                                        <span class="fw-semibold">

                                            {{ number_format(
                                                $craftsman->quantity_sold
                                            ) }}

                                        </span>

                                        <small class="text-muted">
                                            units
                                        </small>

                                    </td>


                                    <td>

                                        <span class="fw-semibold">

                                            ₱{{ number_format(
                                                $craftsman->total_sales,
                                                2
                                            ) }}

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="text-center text-muted py-5"
                                    >

                                        <i class="bi bi-person-badge d-block fs-3 mb-2"></i>

                                        No craftsman sales data available.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         INVENTORY SUMMARY
    ====================================================== --}}

    <div class="analytics-section-card">

        <div class="analytics-section-header">

            <div class="analytics-section-icon">
                <i class="bi bi-boxes"></i>
            </div>

            <div>

                <div class="analytics-section-title">
                    Inventory Summary
                </div>

                <p class="analytics-section-subtitle">
                    Current product availability and stock condition.
                </p>

            </div>

        </div>


        <div class="px-4 pb-4">

            <div class="row g-3">


                {{-- AVAILABLE --}}

                <div class="col-lg-4">

                    <div class="inventory-summary-card">

                        <div class="d-flex align-items-center gap-3">

                            <div class="inventory-summary-icon text-success">

                                <i class="bi bi-check-circle-fill"></i>

                            </div>

                            <div>

                                <div class="text-muted small">
                                    Available Products
                                </div>

                                <div class="fw-bold fs-4">
                                    {{ number_format($availableProducts) }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- LOW STOCK --}}

                <div class="col-lg-4">

                    <div class="inventory-summary-card">

                        <div class="d-flex align-items-center gap-3">

                            <div class="inventory-summary-icon text-warning">

                                <i class="bi bi-exclamation-triangle-fill"></i>

                            </div>

                            <div>

                                <div class="text-muted small">
                                    Low Stock Products
                                </div>

                                <div class="fw-bold fs-4">
                                    {{ number_format($lowStockProducts) }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- OUT OF STOCK --}}

                <div class="col-lg-4">

                    <div class="inventory-summary-card">

                        <div class="d-flex align-items-center gap-3">

                            <div class="inventory-summary-icon text-danger">

                                <i class="bi bi-x-circle-fill"></i>

                            </div>

                            <div>

                                <div class="text-muted small">
                                    Out of Stock Products
                                </div>

                                <div class="fw-bold fs-4">
                                    {{ number_format($outOfStockProducts) }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     CHART.JS
========================================================= --}}

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

/* =========================================================
   DATE FILTER
========================================================= */

function toggleCustomDates() {

    const period =
        document.getElementById('period').value;

    const fields =
        document.querySelectorAll('.custom-date-field');

    fields.forEach(function(field) {

        field.style.display =
            period === 'custom'
                ? ''
                : 'none';

    });

}


/* =========================================================
   CHART DEFAULTS
========================================================= */

Chart.defaults.font.family =
    "'Inter', 'Segoe UI', sans-serif";

Chart.defaults.color = '#6b7280';


/* =========================================================
   SALES TREND
========================================================= */

const salesTrendChart =
    document.getElementById('salesTrendChart');

if (salesTrendChart) {

    new Chart(salesTrendChart, {

        type: 'line',

        data: {

            labels: @json(
                $salesTrend->pluck('date')
            ),

            datasets: [

                {

                    label: 'Sales',

                    data: @json(
                        $salesTrend->pluck('total')
                    ),

                    tension: 0.35,

                    fill: true,

                    borderWidth: 2,

                    pointRadius: 3,

                    pointHoverRadius: 6

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {

                intersect: false,

                mode: 'index'

            },

            plugins: {

                legend: {

                    display: false

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return '₱' +
                                Number(context.raw || 0)
                                .toLocaleString(
                                    'en-PH',
                                    {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }
                                );

                        }

                    }

                }

            },

            scales: {

                x: {

                    grid: {

                        display: false

                    }

                },

                y: {

                    beginAtZero: true,

                    grid: {

                        color:
                            'rgba(31, 41, 55, 0.06)'

                    },

                    ticks: {

                        callback: function(value) {

                            return '₱' +
                                Number(value)
                                .toLocaleString(
                                    'en-PH',
                                    {
                                        maximumFractionDigits: 0
                                    }
                                );

                        }

                    }

                }

            }

        }

    });

}


/* =========================================================
   SALES BY TYPE
========================================================= */

const salesTypeChart =
    document.getElementById('salesTypeChart');

if (salesTypeChart) {

    new Chart(salesTypeChart, {

        type: 'doughnut',

        data: {

            labels: @json(
                $salesByType->pluck('sale_type')
            ),

            datasets: [

                {

                    data: @json(
                        $salesByType->pluck('total_sales')
                    ),

                    borderWidth: 2,

                    hoverOffset: 7

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: '64%',

            plugins: {

                legend: {

                    position: 'bottom',

                    labels: {

                        padding: 16,

                        usePointStyle: true,

                        pointStyle: 'circle'

                    }

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            const value =
                                Number(
                                    context.raw || 0
                                );

                            const total =
                                context.dataset.data
                                    .reduce(
                                        (sum, item) =>
                                            sum +
                                            Number(item || 0),
                                        0
                                    );

                            const percentage =
                                total > 0
                                    ? (
                                        (value / total) *
                                        100
                                    ).toFixed(1)
                                    : 0;

                            return ' ₱' +
                                value.toLocaleString(
                                    'en-PH',
                                    {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }
                                ) +
                                ' (' +
                                percentage +
                                '%)';

                        }

                    }

                }

            }

        }

    });

}


/* =========================================================
   ORDER STATUS
========================================================= */

const orderStatusChart =
    document.getElementById('orderStatusChart');

if (orderStatusChart) {

    new Chart(orderStatusChart, {

        type: 'doughnut',

        data: {

            labels: @json(
                $orderStatus->keys()
            ),

            datasets: [

                {

                    data: @json(
                        $orderStatus->values()
                    ),

                    borderWidth: 2,

                    hoverOffset: 7

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: '64%',

            plugins: {

                legend: {

                    position: 'bottom',

                    labels: {

                        padding: 16,

                        usePointStyle: true,

                        pointStyle: 'circle'

                    }

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            const value =
                                Number(
                                    context.raw || 0
                                );

                            const total =
                                context.dataset.data
                                    .reduce(
                                        (sum, item) =>
                                            sum +
                                            Number(item || 0),
                                        0
                                    );

                            const percentage =
                                total > 0
                                    ? (
                                        (value / total) *
                                        100
                                    ).toFixed(1)
                                    : 0;

                            return ' ' +
                                context.label +
                                ': ' +
                                value +
                                ' orders (' +
                                percentage +
                                '%)';

                        }

                    }

                }

            }

        }

    });

}


/* =========================================================
   INVENTORY
========================================================= */

const inventoryChart =
    document.getElementById('inventoryChart');

if (inventoryChart) {

    new Chart(inventoryChart, {

        type: 'bar',

        data: {

            labels: [

                'Available',
                'Low Stock',
                'Out of Stock'

            ],

            datasets: [

                {

                    label: 'Products',

                    data: [

                        {{ $availableProducts }},
                        {{ $lowStockProducts }},
                        {{ $outOfStockProducts }}

                    ],

                    borderWidth: 1,

                    borderRadius: 7,

                    barThickness: 42

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    display: false

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return ' ' +
                                Number(context.raw)
                                .toLocaleString() +
                                ' products';

                        }

                    }

                }

            },

            scales: {

                x: {

                    grid: {

                        display: false

                    }

                },

                y: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0

                    },

                    grid: {

                        color:
                            'rgba(31, 41, 55, 0.06)'

                    }

                }

            }

        }

    });

}

</script>

@endpush

@endsection