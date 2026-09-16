@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')

<style>
    /* =========================================================
       REPORT SUMMARY CARDS
       Prevent large peso amounts from wrapping
    ========================================================== */

    .report-summary-card .card-body {
        min-width: 0;
        overflow: hidden;
    }

    .report-summary-card .report-value {
        white-space: nowrap;
        font-size: 24px;
        line-height: 1.2;
        letter-spacing: -0.4px;
    }

    @media (max-width: 1399.98px) {
        .report-summary-card .report-value {
            font-size: 22px;
        }
    }

    @media (max-width: 1199.98px) {
        .report-summary-card .report-value {
            font-size: 24px;
        }
    }

    @media (max-width: 575.98px) {
        .report-summary-card .report-value {
            font-size: 22px;
        }
    }
</style>


<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-bar-chart-line me-2"></i>
                Reports
            </h4>

            <p class="text-muted mb-0">
                View sales, products, customers, tribes, craftsmen, and inventory performance.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
    href="{{ route('admin.reports.export.pdf', request()->query()) }}"
    class="btn btn-outline-danger"
>
    <i class="bi bi-file-earmark-pdf me-1"></i>
    Export PDF
</a>

<a
    href="{{ route('admin.reports.export.excel', request()->query()) }}"
    class="btn btn-outline-success"
>
    <i class="bi bi-file-earmark-excel me-1"></i>
    Export Excel
</a>

        </div>

    </div>


    {{-- DATE FILTER --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.reports.index') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            <i class="bi bi-calendar3 me-1"></i>
                            Period
                        </label>

                        <select
                            name="period"
                            class="form-select"
                            id="periodSelect"
                        >

                            <option value="today"
                                {{ $period === 'today' ? 'selected' : '' }}>
                                Today
                            </option>

                            <option value="week"
                                {{ $period === 'week' ? 'selected' : '' }}>
                                This Week
                            </option>

                            <option value="month"
                                {{ $period === 'month' ? 'selected' : '' }}>
                                This Month
                            </option>

                            <option value="year"
                                {{ $period === 'year' ? 'selected' : '' }}>
                                This Year
                            </option>

                            <option value="custom"
                                {{ $period === 'custom' ? 'selected' : '' }}>
                                Custom Date
                            </option>

                        </select>

                    </div>


                    <div class="col-md-3">

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


                    <div class="col-md-3">

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


                    <div class="col-md-3 d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary flex-grow-1"
                        >
                            <i class="bi bi-funnel me-1"></i>
                            Apply Filter
                        </button>

                        <a
                            href="{{ route('admin.reports.index') }}"
                            class="btn btn-outline-secondary"
                        >
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- SALES OVERVIEW --}}
    <div class="row g-4 mb-4">

        {{-- TOTAL SALES --}}
        <div class="col-xl-2 col-md-4 col-sm-6">

            <div class="card border-0 shadow-sm h-100 report-summary-card">

                <div class="card-body">

                    <div class="text-muted small">
                        <i class="bi bi-cash-stack me-1"></i>
                        Total Sales
                    </div>

                    <h4 class="fw-bold mt-2 mb-0 report-value">
                        ₱{{ number_format($totalSales, 2) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- TOTAL ORDERS --}}
        <div class="col-xl-2 col-md-4 col-sm-6">

            <div class="card border-0 shadow-sm h-100 report-summary-card">

                <div class="card-body">

                    <div class="text-muted small">
                        <i class="bi bi-cart-check me-1"></i>
                        Total Orders
                    </div>

                    <h4 class="fw-bold mt-2 mb-0 report-value">
                        {{ number_format($totalOrders) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- ONLINE SALES --}}
        <div class="col-xl-2 col-md-4 col-sm-6">

            <div class="card border-0 shadow-sm h-100 report-summary-card">

                <div class="card-body">

                    <div class="text-muted small">
                        <i class="bi bi-globe2 me-1"></i>
                        Online Sales
                    </div>

                    <h4 class="fw-bold mt-2 mb-0 report-value">
                        ₱{{ number_format($onlineSales, 2) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- WALK-IN SALES --}}
        <div class="col-xl-2 col-md-4 col-sm-6">

            <div class="card border-0 shadow-sm h-100 report-summary-card">

                <div class="card-body">

                    <div class="text-muted small">
                        <i class="bi bi-shop me-1"></i>
                        Walk-in Sales
                    </div>

                    <h4 class="fw-bold mt-2 mb-0 report-value">
                        ₱{{ number_format($walkInSales, 2) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- COMPLETED ORDERS --}}
        <div class="col-xl-2 col-md-4 col-sm-6">

            <div class="card border-0 shadow-sm h-100 report-summary-card">

                <div class="card-body">

                    <div class="text-muted small">
                        <i class="bi bi-check-circle me-1"></i>
                        Completed Orders
                    </div>

                    <h4 class="fw-bold mt-2 mb-0 report-value">
                        {{ number_format($completedOrders) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- PENDING ORDERS --}}
        <div class="col-xl-2 col-md-4 col-sm-6">

            <div class="card border-0 shadow-sm h-100 report-summary-card">

                <div class="card-body">

                    <div class="text-muted small">
                        <i class="bi bi-hourglass-split me-1"></i>
                        Pending Orders
                    </div>

                    <h4 class="fw-bold mt-2 mb-0 report-value">
                        {{ number_format($pendingOrders) }}
                    </h4>

                </div>

            </div>

        </div>

    </div>


    {{-- SALES TREND --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>

                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-graph-up-arrow me-2"></i>
                        Sales Trend
                    </h5>

                    <p class="text-muted mb-0">
                        Sales performance over the selected period.
                    </p>

                </div>

            </div>

            <div style="height: 320px;">
                <canvas id="salesTrendChart"></canvas>
            </div>

        </div>

    </div>


    {{-- ONLINE VS WALK-IN + PAYMENT --}}
    <div class="row g-4 mb-4">

        {{-- ORDER TYPE --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-pie-chart me-2"></i>
                        Online vs Walk-in Sales
                    </h5>

                    <p class="text-muted">
                        Sales comparison by order type.
                    </p>

                    <div style="height: 280px;">
                        <canvas id="orderTypeChart"></canvas>
                    </div>

                </div>

            </div>

        </div>


        {{-- PAYMENT METHOD --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-credit-card me-2"></i>
                        Sales by Payment Method
                    </h5>

                    <p class="text-muted">
                        Current active payment methods.
                    </p>

                    <div style="height: 280px;">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>

                    <div class="text-center mt-2">

                        <span class="badge bg-secondary">
                            <i class="bi bi-clock me-1"></i>
                            GCash — Coming Soon
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- TOP PRODUCTS --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>

                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-box-seam me-2"></i>
                        Top Selling Products
                    </h5>

                    <p class="text-muted mb-0">
                        Best-performing products based on sales.
                    </p>

                </div>

                <select class="form-select" style="width: 180px;">

                    <option>
                        Total Sales
                    </option>

                    <option>
                        Products Sold
                    </option>

                    <option>
                        Orders
                    </option>

                </select>

            </div>


            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th>Rank</th>
                            <th>Product</th>
                            <th>Products Sold</th>
                            <th>Orders</th>
                            <th class="text-end">Total Sales</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($topProducts as $index => $product)

                            <tr>

                                <td>

                                    <span class="fw-semibold">
                                        #{{ $index + 1 }}
                                    </span>

                                </td>


                                <td>

                                    <i class="bi bi-box me-1"></i>

                                    {{ $product['name'] }}

                                </td>


                                <td>
                                    {{ number_format($product['quantity']) }}
                                </td>


                                <td>
                                    {{ number_format($product['orders']) }}
                                </td>


                                <td class="text-end">
                                    ₱{{ number_format($product['sales'], 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center text-muted py-4"
                                >

                                    <i class="bi bi-inbox me-1"></i>

                                    No product sales data available.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- TOP TRIBES --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>

                    <h5 class="fw-bold mb-1">

                        <i class="bi bi-people-fill me-2"></i>

                        Top Tribes

                    </h5>

                    <p class="text-muted mb-0">
                        Top-performing tribes based on sales.
                    </p>

                </div>


                <select class="form-select" style="width: 180px;">

                    <option>
                        Total Sales
                    </option>

                    <option>
                        Products Sold
                    </option>

                    <option>
                        Orders
                    </option>

                </select>

            </div>


            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th>Rank</th>
                            <th>Tribe</th>
                            <th>Products Sold</th>
                            <th>Orders</th>
                            <th class="text-end">Total Sales</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($topTribes as $index => $tribe)

                            <tr>

                                <td>

                                    <span class="fw-semibold">
                                        #{{ $index + 1 }}
                                    </span>

                                </td>


                                <td>

                                    <i class="bi bi-people me-1"></i>

                                    {{ $tribe['name'] }}

                                </td>


                                <td>
                                    {{ number_format($tribe['quantity']) }}
                                </td>


                                <td>
                                    {{ number_format($tribe['orders']) }}
                                </td>


                                <td class="text-end">
                                    ₱{{ number_format($tribe['sales'], 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center text-muted py-4"
                                >

                                    <i class="bi bi-inbox me-1"></i>

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
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>

                    <h5 class="fw-bold mb-1">

                        <i class="bi bi-person-workspace me-2"></i>

                        Top Craftsmen

                    </h5>

                    <p class="text-muted mb-0">
                        Top-performing craftsmen based on sales.
                    </p>

                </div>


                <div class="d-flex gap-2">

                    <select class="form-select">

                        <option>
                            All Tribes
                        </option>

                        @foreach($tribes as $tribe)

                            <option value="{{ $tribe->id }}">
                                {{ $tribe->tribe_name }}
                            </option>

                        @endforeach

                    </select>


                    <select class="form-select">

                        <option>
                            Total Sales
                        </option>

                        <option>
                            Products Sold
                        </option>

                        <option>
                            Orders
                        </option>

                    </select>

                </div>

            </div>


            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th>Rank</th>
                            <th>Craftsman</th>
                            <th>Tribe</th>
                            <th>Products Sold</th>
                            <th>Orders</th>
                            <th class="text-end">Total Sales</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($topCraftsmen as $index => $craftsman)

                            <tr>

                                <td>

                                    <span class="fw-semibold">
                                        #{{ $index + 1 }}
                                    </span>

                                </td>


                                <td>

                                    <i class="bi bi-person me-1"></i>

                                    {{ $craftsman['name'] }}

                                </td>


                                <td>
                                    {{ $craftsman['tribe'] }}
                                </td>


                                <td>
                                    {{ number_format($craftsman['quantity']) }}
                                </td>


                                <td>
                                    {{ number_format($craftsman['orders']) }}
                                </td>


                                <td class="text-end">
                                    ₱{{ number_format($craftsman['sales'], 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center text-muted py-4"
                                >

                                    <i class="bi bi-inbox me-1"></i>

                                    No craftsman sales data available.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- CUSTOMER ANALYTICS --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <h5 class="fw-bold mb-1">

                <i class="bi bi-person-lines-fill me-2"></i>

                Top Customers

            </h5>

            <p class="text-muted">
                Customers with the highest purchase activity.
            </p>


            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th>Rank</th>
                            <th>Customer</th>
                            <th>Orders</th>
                            <th class="text-end">Total Spent</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($topCustomers as $index => $customer)

                            <tr>

                                <td>

                                    <span class="fw-semibold">
                                        #{{ $index + 1 }}
                                    </span>

                                </td>


                                <td>

                                    <i class="bi bi-person-circle me-1"></i>

                                    {{ $customer['name'] }}

                                </td>


                                <td>
                                    {{ number_format($customer['orders']) }}
                                </td>


                                <td class="text-end">
                                    ₱{{ number_format($customer['spent'], 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center text-muted py-4"
                                >

                                    <i class="bi bi-inbox me-1"></i>

                                    No customer sales data available.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- INVENTORY PERFORMANCE --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <h5 class="fw-bold mb-3">

                <i class="bi bi-boxes me-2"></i>

                Inventory Performance

            </h5>


            <div class="row g-3">

                <div class="col-md-3">

                    <div class="border rounded p-3">

                        <div class="text-muted small">

                            <i class="bi bi-box me-1"></i>

                            Total Products

                        </div>

                        <h5 class="fw-bold mb-0">
                            {{ number_format($totalProducts) }}
                        </h5>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="border rounded p-3">

                        <div class="text-muted small">

                            <i class="bi bi-check-circle me-1"></i>

                            Available

                        </div>

                        <h5 class="fw-bold mb-0">
                            {{ number_format($availableProducts) }}
                        </h5>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="border rounded p-3">

                        <div class="text-muted small">

                            <i class="bi bi-exclamation-triangle me-1"></i>

                            Low Stock

                        </div>

                        <h5 class="fw-bold mb-0">
                            {{ number_format($lowStockProducts) }}
                        </h5>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="border rounded p-3">

                        <div class="text-muted small">

                            <i class="bi bi-x-circle me-1"></i>

                            Out of Stock

                        </div>

                        <h5 class="fw-bold mb-0">
                            {{ number_format($outOfStockProducts) }}
                        </h5>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- DETAILED SALES REPORT --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>

                    <h5 class="fw-bold mb-1">

                        <i class="bi bi-receipt me-2"></i>

                        Detailed Sales Report

                    </h5>

                    <p class="text-muted mb-0">
                        Detailed transactions within the selected period.
                    </p>

                </div>

            </div>


            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th>Date</th>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Payment</th>
                            <th>Total</th>
                            <th>Status</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($sales as $sale)

                            <tr>

                                <td>
                                    {{ $sale->created_at->format('M d, Y') }}
                                </td>


                                <td>

                                    <span class="fw-semibold">
                                        {{ $sale->sale_number }}
                                    </span>

                                </td>


                                <td>

                                    @if($sale->user)

                                        {{ $sale->user->name }}

                                    @else

                                        Walk-in Customer

                                    @endif

                                </td>


                                <td>

                                    @if($sale->sale_type === 'Online')

                                        <span class="badge bg-primary">
                                            Online
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Walk-in
                                        </span>

                                    @endif

                                </td>


                                <td>
                                    {{ $sale->payment_method }}
                                </td>


                                <td>
                                    ₱{{ number_format($sale->total_amount, 2) }}
                                </td>


                                <td>

                                    @if($sale->status === 'Completed')

                                        <span class="badge bg-success">
                                            Completed
                                        </span>

                                    @elseif($sale->status === 'Pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif($sale->status === 'Processing')

                                        <span class="badge bg-info text-dark">
                                            Processing
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            {{ $sale->status }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center text-muted py-4"
                                >

                                    <i class="bi bi-inbox me-1"></i>

                                    No sales data available.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | SALES TREND
    |--------------------------------------------------------------------------
    */

    const salesTrend =
        document.getElementById('salesTrendChart');

    if (salesTrend) {

        new Chart(salesTrend, {

            type: 'line',

            data: {

                labels: @json(
                    $salesTrend->pluck('date')
                ),

                datasets: [{

                    label: 'Sales',

                    data: @json(
                        $salesTrend->pluck('sales')
                    ),

                    tension: 0.35,

                    fill: true

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: true
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {

                            callback: function(value) {

                                return '₱' +
                                    Number(value).toLocaleString();

                            }

                        }

                    }

                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | ONLINE VS WALK-IN
    |--------------------------------------------------------------------------
    */

    const orderType =
        document.getElementById('orderTypeChart');

    if (orderType) {

        new Chart(orderType, {

            type: 'doughnut',

            data: {

                labels: [
                    'Online',
                    'Walk-in'
                ],

                datasets: [{

                    data: [
                        {{ $onlineSales }},
                        {{ $walkInSales }}
                    ]

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENT METHOD
    |--------------------------------------------------------------------------
    */

    const paymentMethod =
        document.getElementById('paymentMethodChart');

    if (paymentMethod) {

        new Chart(paymentMethod, {

            type: 'doughnut',

            data: {

                labels: [
                    'Cash',
                    'COD'
                ],

                datasets: [{

                    data: [
                        {{ $cashSales }},
                        {{ $codSales }}
                    ]

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false

            }

        });

    }

});

</script>

@endpush

@endsection