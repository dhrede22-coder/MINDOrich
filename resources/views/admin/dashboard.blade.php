@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
    .dashboard-page {
        padding-bottom: 30px;
    }

    /* ================================
       DASHBOARD HEADER
    ================================= */
    .dashboard-header {
        background: linear-gradient(135deg, #ffffff 0%, #faf7f2 100%);
        border: 1px solid #eee8df;
        border-radius: 20px;
        padding: 28px 30px;
        margin-bottom: 24px;
    }

    .dashboard-header h2 {
        color: #1f2937;
        font-size: 28px;
        margin-bottom: 6px;
    }

    .dashboard-header p {
        color: #6b7280;
        margin-bottom: 0;
    }

    .dashboard-date {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 14px;
        padding: 8px 13px;
        border-radius: 10px;
        background: #f4eadb;
        color: #8a5a18;
        font-size: 13px;
        font-weight: 600;
    }

    /* ================================
       STAT CARDS
    ================================= */
    .dashboard-stat {
        background: #ffffff;
        border: 1px solid #eeeef0;
        border-radius: 16px;
        padding: 20px;
        height: 100%;
        transition: all .2s ease;
    }

    .dashboard-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .stat-value {
        font-size: 27px;
        font-weight: 700;
        color: #1f2937;
        line-height: 1;
    }

    .stat-description {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 8px;
    }

    /* ================================
       SECTION CARDS
    ================================= */
    .dashboard-card {
        background: #ffffff;
        border: 1px solid #eeeef0;
        border-radius: 16px;
        height: 100%;
        overflow: hidden;
    }

    .dashboard-card-header {
        padding: 20px 22px 14px;
        border-bottom: 1px solid #f0f0f0;
    }

    .dashboard-card-header h5 {
        color: #1f2937;
        font-size: 17px;
        margin-bottom: 4px;
    }

    .dashboard-card-header small {
        color: #9ca3af;
    }

    .dashboard-card-body {
        padding: 20px 22px;
    }

    /* ================================
       TOP PRODUCERS
    ================================= */
    .producer-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f1f1;
    }

    .producer-item:first-child {
        padding-top: 0;
    }

    .producer-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .producer-avatar {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        border-radius: 50%;
        overflow: hidden;
        background: #f4f4f4;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .producer-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .producer-name {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
    }

    .producer-tribe {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 2px;
    }

    .producer-sales {
        font-size: 14px;
        font-weight: 700;
        color: #2f5d50;
        white-space: nowrap;
    }

    /* ================================
       RECENT ORDERS
    ================================= */
    .orders-table th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #9ca3af;
        font-weight: 700;
        border-bottom: 1px solid #eeeeee;
        padding: 13px 16px;
        white-space: nowrap;
    }

    .orders-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f3f3f3;
        font-size: 13px;
        color: #4b5563;
        vertical-align: middle;
    }

    .orders-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .orders-table tbody tr:hover {
        background: #fafafa;
    }

    .order-number {
        font-weight: 700;
        color: #1f2937;
    }

    .order-customer {
        color: #374151;
        font-weight: 500;
    }

    .order-product {
        max-width: 180px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .03em;
    }

    /* ================================
       INVENTORY FOCUS
    ================================= */
    .inventory-card {
        background: #1f2937;
        color: white;
        border-radius: 16px;
        padding: 22px;
        height: 100%;
    }

    .inventory-card h5 {
        margin-bottom: 4px;
    }

    .inventory-subtitle {
        color: rgba(255,255,255,.6);
        font-size: 13px;
        margin-bottom: 22px;
    }

    .stock-item {
        margin-bottom: 17px;
    }

    .stock-item:last-child {
        margin-bottom: 0;
    }

    .stock-name-row {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 7px;
    }

    .stock-name {
        font-size: 13px;
        color: rgba(255,255,255,.9);
    }

    .stock-number {
        font-size: 12px;
        font-weight: 700;
        color: #fca5a5;
    }

    .stock-progress {
        height: 6px;
        background: rgba(255,255,255,.12);
        border-radius: 10px;
        overflow: hidden;
    }

    .stock-progress-bar {
        height: 100%;
        background: #ef4444;
        border-radius: 10px;
    }

    .inventory-empty {
        text-align: center;
        padding: 28px 10px;
    }

    .inventory-empty i {
        font-size: 32px;
        color: #4ade80;
    }

    .inventory-empty p {
        color: rgba(255,255,255,.65);
        font-size: 13px;
        margin-top: 10px;
        margin-bottom: 0;
    }

    /* ================================
       QUICK ACTIONS
    ================================= */
    .quick-actions {
        background: #ffffff;
        border: 1px solid #eeeef0;
        border-radius: 16px;
        padding: 20px 22px;
    }

    .quick-actions-title {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 14px;
    }

    .quick-action {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        text-decoration: none;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        transition: all .2s ease;
        background: #fff;
    }

    .quick-action:hover {
        border-color: #c88a2b;
        color: #a86f1f;
        background: #fffaf3;
    }

    .quick-action i {
        font-size: 16px;
    }

    /* ================================
       RESPONSIVE
    ================================= */
    @media (max-width: 767px) {

        .dashboard-header {
            padding: 22px;
        }

        .dashboard-header h2 {
            font-size: 23px;
        }

        .stat-value {
            font-size: 23px;
        }

        .orders-table {
            min-width: 700px;
        }
    }
</style>


<div class="container-fluid dashboard-page">

    {{-- =========================================================
         DASHBOARD HEADER
    ========================================================== --}}
    <div class="dashboard-header">

        <div class="d-flex flex-column flex-md-row justify-content-between
                    align-items-md-center gap-3">

            <div>

                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="text-warning fs-5">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </span>

                    <span class="small fw-semibold text-muted">
                        ADMIN DASHBOARD
                    </span>
                </div>

                <h2 class="fw-bold">
                    Welcome back, PMUI Administrator
                </h2>

                <p>
                    Here's a quick overview of what's happening in MINDOrich.
                </p>

                <div class="dashboard-date">
                    <i class="bi bi-calendar3"></i>
                    {{ now()->format('F d, Y') }}
                </div>

            </div>

            

        </div>

    </div>


    {{-- =========================================================
         STATISTICS
    ========================================================== --}}
    <div class="row g-3 mb-4">

        {{-- PRODUCTS --}}
        <div class="col-xl-3 col-md-6">

            <div class="dashboard-stat">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <div class="stat-label">
                            Products
                        </div>

                        <div class="stat-value counter"
                             data-target="{{ $products }}">
                            0
                        </div>

                        <div class="stat-description">
                            Products in system
                        </div>
                    </div>

                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi bi-box-seam"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- PRODUCERS --}}
        <div class="col-xl-3 col-md-6">

            <div class="dashboard-stat">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <div class="stat-label">
                            Producers
                        </div>

                        <div class="stat-value counter"
                             data-target="{{ $producers }}">
                            0
                        </div>

                        <div class="stat-description">
                            Registered producers
                        </div>
                    </div>

                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-people"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- CUSTOMERS --}}
        <div class="col-xl-3 col-md-6">

            <div class="dashboard-stat">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <div class="stat-label">
                            Customers
                        </div>

                        <div class="stat-value counter"
                             data-target="{{ $customers }}">
                            0
                        </div>

                        <div class="stat-description">
                            Registered customers
                        </div>
                    </div>

                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-person"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- PENDING ORDERS --}}
        <div class="col-xl-3 col-md-6">

            <div class="dashboard-stat">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <div class="stat-label">
                            Pending Orders
                        </div>

                        <div class="stat-value counter"
                             data-target="{{ $pendingOrders }}">
                            0
                        </div>

                        <div class="stat-description text-danger">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Needs attention
                        </div>
                    </div>

                    <div class="stat-icon bg-danger-subtle text-danger">
                        <i class="bi bi-cart3"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         SALES + TOP PRODUCERS
    ========================================================== --}}
    <div class="row g-3 mb-4">

        {{-- SALES OVERVIEW --}}
        <div class="col-lg-8">

            <div class="dashboard-card">

                <div class="dashboard-card-header">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <h5 class="fw-bold">
                                Sales Overview
                            </h5>

                            <small>
                                Monthly revenue performance
                            </small>
                        </div>

                        <span class="badge bg-light text-dark fw-normal">
                            <i class="bi bi-graph-up me-1"></i>
                            Revenue
                        </span>

                    </div>

                </div>

                <div class="dashboard-card-body">

                    <div style="height: 310px;">
                        <canvas id="salesChart"></canvas>
                    </div>

                </div>

            </div>

        </div>


        {{-- TOP PRODUCERS --}}
        <div class="col-lg-4">

            <div class="dashboard-card">

                <div class="dashboard-card-header">

                    <h5 class="fw-bold">
                        Top Producers
                    </h5>

                    <small>
                        Based on sales performance
                    </small>

                </div>

                <div class="dashboard-card-body">

                    @forelse($topProducers as $producer)

                        <div class="producer-item">

                            <div class="d-flex align-items-center gap-3">

                                <div class="producer-avatar">

                                    @if($producer->photo)

                                        <img
                                            src="{{ asset('storage/' . $producer->photo) }}"
                                            alt="{{ $producer->producer_name }}"
                                        >

                                    @else

                                        <i class="bi bi-person text-muted"></i>

                                    @endif

                                </div>

                                <div>

                                    <div class="producer-name">
                                        {{ $producer->producer_name }}
                                    </div>

                                    <div class="producer-tribe">
                                        {{ $producer->tribe_name ?? 'Mangyan Producer' }}
                                    </div>

                                </div>

                            </div>

                            <div class="producer-sales">
                                ₱{{ number_format($producer->total_sales, 2) }}
                            </div>

                        </div>

                    @empty

                        <div class="text-center text-muted py-4">

                            <i class="bi bi-people fs-3 d-block mb-2"></i>

                            <small>
                                No producer sales data available.
                            </small>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         RECENT ORDERS + INVENTORY
    ========================================================== --}}
    <div class="row g-3 mb-4">

        {{-- RECENT ORDERS --}}
        <div class="col-lg-8">

            <div class="dashboard-card">

                <div class="dashboard-card-header">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5 class="fw-bold mb-1">
                                Recent Orders
                            </h5>

                            <small>
                                Latest customer transactions
                            </small>

                        </div>

                        <a href="{{ route('orders.index') }}"
                           class="btn btn-sm btn-light fw-semibold">

                            View All
                            <i class="bi bi-arrow-right ms-1"></i>

                        </a>

                    </div>

                </div>


                <div class="table-responsive">

                    <table class="table orders-table align-middle mb-0">

                        <thead>

                            <tr>

                                <th>Order</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($recentOrders as $order)

                                @php

                                    $firstItem = $order->saleItems->first();

                                    $productName =
                                        $firstItem?->product?->product_name
                                        ?? 'No Product';

                                    $status = strtolower(
                                        $order->status ?? 'pending'
                                    );

                                    $statusClass = match ($status) {

                                        'completed',
                                        'delivered'
                                            => 'bg-success text-white',

                                        'processing'
                                            => 'bg-warning text-dark',

                                        'shipped'
                                            => 'bg-primary text-white',

                                        'cancelled'
                                            => 'bg-danger text-white',

                                        'pending'
                                            => 'bg-secondary text-white',

                                        default
                                            => 'bg-secondary text-white',

                                    };

                                @endphp


                                <tr>

                                    <td>

                                        <div class="order-number">
                                            {{ $order->sale_number }}
                                        </div>

                                    </td>


                                    <td>

                                        <div class="order-customer">
                                            {{ $order->user?->name ?? 'Guest Customer' }}
                                        </div>

                                    </td>


                                    <td>

                                        <div class="order-product">

                                            {{ $productName }}

                                            @if($order->saleItems->count() > 1)

                                                <small class="text-muted">
                                                    +{{ $order->saleItems->count() - 1 }}
                                                    more
                                                </small>

                                            @endif

                                        </div>

                                    </td>


                                    <td>

                                        <strong class="text-dark">
                                            ₱{{ number_format(
                                                $order->total_amount,
                                                2
                                            ) }}
                                        </strong>

                                    </td>


                                    <td>

                                        <span class="status-badge {{ $statusClass }}">
                                            {{ strtoupper($order->status ?? 'Pending') }}
                                        </span>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="5"
                                        class="text-center text-muted py-5">

                                        <i class="bi bi-cart-x fs-3 d-block mb-2"></i>

                                        No orders available.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- INVENTORY FOCUS --}}
        <div class="col-lg-4">

            <div class="inventory-card">

                <h5 class="fw-bold">
                    Inventory Focus
                </h5>

                <div class="inventory-subtitle">
                    Products that may need replenishment.
                </div>


                @forelse($lowStockProducts as $product)

                    @php

                        $stock = (int) $product->stock;

                        $minimumStock = max(
                            (int) $product->minimum_stock,
                            1
                        );

                        $percentage = min(
                            100,
                            max(
                                5,
                                ($stock / $minimumStock) * 100
                            )
                        );

                    @endphp


                    <div class="stock-item">

                        <div class="stock-name-row">

                            <span class="stock-name">
                                {{ $product->product_name }}
                            </span>

                            <span class="stock-number">
                                {{ $stock }} left
                            </span>

                        </div>


                        <div class="stock-progress">

                            <div
                                class="stock-progress-bar"
                                style="width: {{ $percentage }}%"
                            ></div>

                        </div>

                    </div>


                @empty

                    <div class="inventory-empty">

                        <i class="bi bi-check-circle"></i>

                        <p>
                            All products have sufficient stock.
                        </p>

                    </div>

                @endforelse


                @if($lowStockProducts->count() > 0)

                    <a href="{{ route('products.index') }}"
                       class="btn btn-warning w-100 mt-4 fw-semibold">

                        <i class="bi bi-box-seam me-1"></i>
                        Review Inventory

                    </a>

                @endif

            </div>

        </div>

    </div>


    {{-- =========================================================
         QUICK ACTIONS
    ========================================================== --}}
    <div class="quick-actions">

        <div class="quick-actions-title">
            <i class="bi bi-lightning-charge me-1 text-warning"></i>
            Quick Actions
        </div>


        <div class="d-flex flex-wrap gap-2">

            <a href="{{ route('orders.create') }}"
               class="quick-action">

                <i class="bi bi-cart-plus text-warning"></i>
                Create Order

            </a>


            <a href="{{ route('products.create') }}"
               class="quick-action">

                <i class="bi bi-box-seam text-primary"></i>
                Add Product

            </a>


            <a href="{{ route('admin.purchases.create') }}"
               class="quick-action">

                <i class="bi bi-bag-plus text-success"></i>
                Add Purchase

            </a>


            <a href="{{ route('expenses.create') }}"
               class="quick-action">

                <i class="bi bi-wallet2 text-danger"></i>
                Record Expense

            </a>


            <a href="{{ route('admin.reports.index') }}"
               class="quick-action">

                <i class="bi bi-file-earmark-bar-graph text-secondary"></i>
                View Reports

            </a>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    /* ============================================================
       COUNTER ANIMATION
    ============================================================ */

    document.querySelectorAll('.counter').forEach(counter => {

        const target = Number(counter.dataset.target);

        let count = 0;

        const speed = 30;

        const update = () => {

            const increment = Math.max(
                1,
                Math.ceil(target / 40)
            );

            count += increment;

            if (count < target) {

                counter.innerText = count;

                setTimeout(update, speed);

            } else {

                counter.innerText = target;

            }

        };

        update();

    });


    /* ============================================================
       SALES CHART
    ============================================================ */

    const ctx = document.getElementById('salesChart');

    if (ctx) {

        const chartContext = ctx.getContext('2d');

        const gradient = chartContext.createLinearGradient(
            0,
            0,
            0,
            350
        );

        gradient.addColorStop(
            0,
            'rgba(244,180,0,.25)'
        );

        gradient.addColorStop(
            1,
            'rgba(244,180,0,0)'
        );


        const chartLabels = {!! json_encode(
            $salesLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
        ) !!};


        const chartData = {!! json_encode(
            $salesData ?? [42000, 50000, 47000, 61000, 59000, 72000]
        ) !!};


        new Chart(ctx, {

            type: 'line',

            data: {

                labels: chartLabels,

                datasets: [{

                    label: 'Revenue',

                    data: chartData,

                    borderColor: '#F4B400',

                    backgroundColor: gradient,

                    fill: true,

                    borderWidth: 3,

                    tension: .4,

                    pointRadius: 0,

                    pointHoverRadius: 6,

                    pointBackgroundColor: '#F4B400'

                }]

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

                        backgroundColor: '#1f2937',

                        padding: 12,

                        callbacks: {

                            label: function(context) {

                                return ' ₱' +
                                    Number(
                                        context.raw
                                    ).toLocaleString(
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
                        },

                        ticks: {
                            color: '#9ca3af'
                        }

                    },


                    y: {

                        beginAtZero: true,

                        grid: {
                            color: '#f0f0f0'
                        },

                        ticks: {

                            color: '#9ca3af',

                            callback: function(value) {

                                return '₱' +
                                    Number(
                                        value / 1000
                                    ) +
                                    'k';

                            }

                        }

                    }

                }

            }

        });

    }

</script>

@endpush