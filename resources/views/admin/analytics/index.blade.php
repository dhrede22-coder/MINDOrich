@extends('admin.layouts.app')

@section('title', 'Analytics')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-bar-chart-line-fill me-2"></i>
                Analytics
            </h2>

            <p class="text-muted mb-0">
                Monitor sales, orders, products, tribes, and craftsmen performance.
            </p>
        </div>

    </div>


    {{-- =========================================================
         FILTER
    ========================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('admin.analytics.index') }}"
                class="row g-3 align-items-end"
            >

                <div class="col-md-3">

                    <label class="form-label fw-semibold">
                        <i class="bi bi-calendar3 me-1"></i>
                        Period
                    </label>

                    <select
                        name="period"
                        id="period"
                        class="form-select"
                        onchange="toggleCustomDates()"
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


                <div
                    class="col-md-3 custom-date-field"
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


                <div
                    class="col-md-3 custom-date-field"
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


                <div class="col-md-auto">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-funnel-fill me-1"></i>
                        Apply Filter
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
         OVERVIEW CARDS
    ========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- TOTAL SALES --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Total Sales
                            </p>

                            <h3 class="fw-bold mb-0">
                                ₱{{ number_format($totalSales, 2) }}
                            </h3>

                        </div>

                        <div class="fs-1 text-success">
                            <i class="bi bi-cash-stack"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- TOTAL ORDERS --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Total Orders
                            </p>

                            <h3 class="fw-bold mb-0">
                                {{ number_format($totalOrders) }}
                            </h3>

                        </div>

                        <div class="fs-1 text-primary">
                            <i class="bi bi-cart-check-fill"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ONLINE SALES --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Online Sales
                            </p>

                            <h3 class="fw-bold mb-0">
                                ₱{{ number_format($onlineSales, 2) }}
                            </h3>

                        </div>

                        <div class="fs-1 text-info">
                            <i class="bi bi-globe2"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- WALK-IN SALES --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Walk-in Sales
                            </p>

                            <h3 class="fw-bold mb-0">
                                ₱{{ number_format($walkInSales, 2) }}
                            </h3>

                        </div>

                        <div class="fs-1 text-warning">
                            <i class="bi bi-shop"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         SECONDARY STATISTICS
    ========================================================== --}}

    <div class="row g-4 mb-4">

        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="fs-2 text-success me-3">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                        <div>

                            <div class="text-muted">
                                Completed Orders
                            </div>

                            <h4 class="fw-bold mb-0">
                                {{ number_format($completedOrders) }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="fs-2 text-warning me-3">
                            <i class="bi bi-clock-fill"></i>
                        </div>

                        <div>

                            <div class="text-muted">
                                Pending Orders
                            </div>

                            <h4 class="fw-bold mb-0">
                                {{ number_format($pendingOrders) }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="fs-2 text-danger me-3">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>

                        <div>

                            <div class="text-muted">
                                Out of Stock
                            </div>

                            <h4 class="fw-bold mb-0">
                                {{ number_format($outOfStockProducts) }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         CHARTS
    ========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- SALES TREND --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-graph-up-arrow me-2"></i>
                        Sales Trend
                    </h5>

                    <p class="text-muted small mb-0">
                        Sales performance during the selected period.
                    </p>

                </div>

                <div class="card-body">

                    <div style="height: 330px;">
                        <canvas id="salesTrendChart"></canvas>
                    </div>

                </div>

            </div>

        </div>


        {{-- ONLINE VS WALK-IN --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-pie-chart-fill me-2"></i>
                        Sales by Type
                    </h5>

                    <p class="text-muted small mb-0">
                        Online versus walk-in sales.
                    </p>

                </div>

                <div class="card-body">

                    <div style="height: 330px;">
                        <canvas id="salesTypeChart"></canvas>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         ORDER STATUS
    ========================================================== --}}

    <div class="row g-4 mb-4">

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-list-check me-2"></i>
                        Order Status
                    </h5>

                    <p class="text-muted small mb-0">
                        Overview of order statuses.
                    </p>

                </div>

                <div class="card-body">

                    <div style="height: 280px;">
                        <canvas id="orderStatusChart"></canvas>
                    </div>

                </div>

            </div>

        </div>


        {{-- INVENTORY --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-boxes me-2"></i>
                        Inventory Performance
                    </h5>

                    <p class="text-muted small mb-0">
                        Current product availability.
                    </p>

                </div>

                <div class="card-body">

                    <div style="height: 280px;">
                        <canvas id="inventoryChart"></canvas>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
     TOP PRODUCTS
========================================================== --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white border-0 pt-4 px-4">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">
                    <i class="bi bi-trophy-fill me-2"></i>
                    Top Products
                </h5>

                <p class="text-muted small mb-0">
                    Best-performing products based on sales.
                </p>

            </div>

        </div>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="ps-4">
                            #
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

                            {{-- RANK --}}
                            <td class="ps-4">

                                @if($index === 0)

                                    <span
                                        class="fw-bold"
                                        title="Top 1"
                                    >
                                        <i class="bi bi-trophy-fill me-1"></i>
                                        1
                                    </span>

                                @elseif($index === 1)

                                    <span
                                        class="fw-bold"
                                        title="Top 2"
                                    >
                                        <i class="bi bi-award-fill me-1"></i>
                                        2
                                    </span>

                                @elseif($index === 2)

                                    <span
                                        class="fw-bold"
                                        title="Top 3"
                                    >
                                        <i class="bi bi-award-fill me-1"></i>
                                        3
                                    </span>

                                @else

                                    <span class="fw-bold">
                                        {{ $index + 1 }}
                                    </span>

                                @endif

                            </td>


                            {{-- PRODUCT --}}
                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="me-2">

                                        <i class="bi bi-box-seam-fill"></i>

                                    </div>

                                    <span class="fw-semibold">
                                        {{ $product->product_name }}
                                    </span>

                                </div>

                            </td>


                            {{-- QUANTITY --}}
                            <td>

                                <span class="fw-medium">

                                    {{ number_format(
                                        $product->quantity_sold
                                    ) }}

                                </span>

                                <small class="text-muted">
                                    units
                                </small>

                            </td>


                            {{-- SALES --}}
                            <td class="fw-semibold">

                                ₱{{ number_format(
                                    $product->total_sales,
                                    2
                                ) }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="text-center text-muted py-4"
                            >

                                <i class="bi bi-bar-chart-line d-block fs-3 mb-2"></i>

                                No product sales data available.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


    {{-- =========================================================
     TOP TRIBES + TOP CRAFTSMEN
========================================================== --}}

<div class="row g-4 mb-4">

    {{-- TOP TRIBES --}}
    <div class="col-lg-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white border-0 pt-4 px-4">

                <h5 class="fw-bold mb-1">
                    <i class="bi bi-people-fill me-2"></i>
                    Top Tribes
                </h5>

                <p class="text-muted small mb-0">
                    Tribes with the highest sales performance.
                </p>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">#</th>

                                <th>Tribe</th>

                                <th>Sold</th>

                                <th>Sales</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($topTribes as $index => $tribe)

                                <tr>

                                    <td class="ps-4">

                                        @if($index === 0)

                                            <span class="fw-bold">
                                                <i class="bi bi-trophy-fill me-1"></i>
                                                1
                                            </span>

                                        @elseif($index === 1)

                                            <span class="fw-bold">
                                                <i class="bi bi-award-fill me-1"></i>
                                                2
                                            </span>

                                        @elseif($index === 2)

                                            <span class="fw-bold">
                                                <i class="bi bi-award-fill me-1"></i>
                                                3
                                            </span>

                                        @else

                                            <span class="fw-bold">
                                                {{ $index + 1 }}
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div class="me-2">
                                                <i class="bi bi-people-fill"></i>
                                            </div>

                                            <span class="fw-semibold">
                                                {{ $tribe->tribe_name }}
                                            </span>

                                        </div>

                                    </td>

                                    <td>

                                        <span class="fw-medium">
                                            {{ number_format($tribe->quantity_sold) }}
                                        </span>

                                        <small class="text-muted">
                                            units
                                        </small>

                                    </td>

                                    <td class="fw-semibold">
                                        ₱{{ number_format($tribe->total_sales, 2) }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="text-center text-muted py-4"
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

    </div>


    {{-- TOP CRAFTSMEN --}}
    <div class="col-lg-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white border-0 pt-4 px-4">

                <h5 class="fw-bold mb-1">
                    <i class="bi bi-person-badge-fill me-2"></i>
                    Top Craftsmen
                </h5>

                <p class="text-muted small mb-0">
                    Craftsmen with the highest sales performance.
                </p>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">#</th>

                                <th>Craftsman</th>

                                <th>Sold</th>

                                <th>Sales</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($topCraftsmen as $index => $craftsman)

                                <tr>

                                    <td class="ps-4">

                                        @if($index === 0)

                                            <span class="fw-bold">
                                                <i class="bi bi-trophy-fill me-1"></i>
                                                1
                                            </span>

                                        @elseif($index === 1)

                                            <span class="fw-bold">
                                                <i class="bi bi-award-fill me-1"></i>
                                                2
                                            </span>

                                        @elseif($index === 2)

                                            <span class="fw-bold">
                                                <i class="bi bi-award-fill me-1"></i>
                                                3
                                            </span>

                                        @else

                                            <span class="fw-bold">
                                                {{ $index + 1 }}
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div class="me-2">
                                                <i class="bi bi-person-badge-fill"></i>
                                            </div>

                                            <span class="fw-semibold">
                                                {{ $craftsman->producer_name }}
                                            </span>

                                        </div>

                                    </td>

                                    <td>

                                        <span class="fw-medium">
                                            {{ number_format($craftsman->quantity_sold) }}
                                        </span>

                                        <small class="text-muted">
                                            units
                                        </small>

                                    </td>

                                    <td class="fw-semibold">
                                        ₱{{ number_format($craftsman->total_sales, 2) }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="text-center text-muted py-4"
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

</div>


    {{-- =========================================================
         INVENTORY SUMMARY
    ========================================================== --}}

    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="fs-2 text-success me-3">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                        <div>

                            <p class="text-muted mb-1">
                                Available Products
                            </p>

                            <h4 class="fw-bold mb-0">
                                {{ number_format($availableProducts) }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="fs-2 text-warning me-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>

                        <div>

                            <p class="text-muted mb-1">
                                Low Stock Products
                            </p>

                            <h4 class="fw-bold mb-0">
                                {{ number_format($lowStockProducts) }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="fs-2 text-danger me-3">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>

                        <div>

                            <p class="text-muted mb-1">
                                Out of Stock Products
                            </p>

                            <h4 class="fw-bold mb-0">
                                {{ number_format($outOfStockProducts) }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     CHART.JS
============================================================== --}}

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    // ---------------------------------------------------------
    // DATE FILTER
    // ---------------------------------------------------------

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


    // ---------------------------------------------------------
    // SALES TREND DATA
    // ---------------------------------------------------------

    const salesTrendLabels = @json(
        $salesTrend->pluck('date')
    );

    const salesTrendData = @json(
        $salesTrend->pluck('total')
    );


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
                    $salesTrend->pluck('total')
                ),

                tension: 0.35,

                fill: true,

                borderWidth: 3,

                pointRadius: 4,

                pointHoverRadius: 6
            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: true
                },

                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₱' +
                                Number(context.raw)
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

                y: {

                    beginAtZero: true,

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


    // ---------------------------------------------------------
// SALES TYPE
// ---------------------------------------------------------

const salesTypeLabels = @json(
    $salesByType->pluck('sale_type')
);

const salesTypeData = @json(
    $salesByType->pluck('total_sales')
);

const salesTypeChart =
    document.getElementById('salesTypeChart');

if (salesTypeChart) {

    new Chart(salesTypeChart, {

        type: 'doughnut',

        data: {

            labels: salesTypeLabels,

            datasets: [{

                data: salesTypeData,

                borderWidth: 2,

                hoverOffset: 8

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: '62%',

            plugins: {

                legend: {

                    position: 'bottom',

                    labels: {

                        padding: 18,

                        usePointStyle: true,

                        pointStyle: 'circle'
                    }

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            const value =
                                Number(context.raw || 0);

                            const total =
                                context.dataset.data
                                    .reduce(
                                        (sum, item) =>
                                            sum + Number(item || 0),
                                        0
                                    );

                            const percentage =
                                total > 0
                                    ? ((value / total) * 100).toFixed(1)
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


    // ---------------------------------------------------------
// ORDER STATUS
// ---------------------------------------------------------

const orderStatusLabels = @json(
    $orderStatus->keys()
);

const orderStatusData = @json(
    $orderStatus->values()
);

const orderStatusChart =
    document.getElementById('orderStatusChart');

if (orderStatusChart) {

    new Chart(orderStatusChart, {

        type: 'doughnut',

        data: {

            labels: orderStatusLabels,

            datasets: [{

                data: orderStatusData,

                borderWidth: 2,

                hoverOffset: 8
            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: '62%',

            plugins: {

                legend: {

                    position: 'bottom',

                    labels: {

                        padding: 18,

                        usePointStyle: true,

                        pointStyle: 'circle'
                    }

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            const value =
                                Number(context.raw || 0);

                            const total =
                                context.dataset.data
                                    .reduce(
                                        (sum, item) =>
                                            sum + Number(item || 0),
                                        0
                                    );

                            const percentage =
                                total > 0
                                    ? ((value / total) * 100).toFixed(1)
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


    // ---------------------------------------------------------
// INVENTORY
// ---------------------------------------------------------

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

            datasets: [{

                label: 'Products',

                data: [
                    {{ $availableProducts }},
                    {{ $lowStockProducts }},
                    {{ $outOfStockProducts }}
                ],

                borderWidth: 1,

                borderRadius: 6,

                barThickness: 45
            }]

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

                    }

                }

            }

        }

    });

}

</script>

@endpush

@endsection