@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')

<style>
    .reports-page {
        padding-bottom: 2rem;
    }

    .reports-header {
        background: linear-gradient(135deg, #ffffff 0%, #faf7f2 100%);
        border: 1px solid rgba(31, 41, 55, .08);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 .125rem .35rem rgba(0, 0, 0, .04);
    }

    .reports-header .report-icon {
        width: 46px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(200, 138, 43, .12);
        color: #a86f1f;
        font-size: 1.25rem;
        flex: 0 0 auto;
    }

    .report-period-pill {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .45rem .75rem;
        border-radius: 999px;
        background: #f3f4f6;
        color: #4b5563;
        font-size: .82rem;
        font-weight: 600;
    }

    .report-filter-card,
    .report-section-card {
        border: 1px solid rgba(31, 41, 55, .08) !important;
        border-radius: 16px !important;
        box-shadow: 0 .125rem .35rem rgba(0, 0, 0, .04) !important;
    }

    .report-filter-card .card-body {
        padding: 1rem 1.25rem;
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: .75rem;
        margin-bottom: 1rem;
    }

    .section-heading .section-icon {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #f8f9fa;
        color: #374151;
        flex: 0 0 auto;
    }

    .section-heading h5 {
        margin: 0;
        font-weight: 700;
    }

    .section-heading p {
        margin: .15rem 0 0;
        color: #6b7280;
        font-size: .86rem;
    }

    .report-kpi {
        height: 100%;
        border: 1px solid rgba(31, 41, 55, .08);
        border-radius: 14px;
        padding: 1rem 1.05rem;
        background: #fff;
        position: relative;
        overflow: hidden;
    }

    .report-kpi::before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 4px;
        background: #c88a2b;
    }

    .report-kpi .kpi-label {
        color: #6b7280;
        font-size: .82rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .report-kpi .kpi-value {
        margin-top: .35rem;
        font-size: 1.45rem;
        font-weight: 750;
        line-height: 1.2;
        color: #111827;
        white-space: nowrap;
    }

    .report-kpi .kpi-note {
        margin-top: .25rem;
        color: #9ca3af;
        font-size: .75rem;
    }

    .report-kpi.primary::before { background: #2f5d50; }
    .report-kpi.success::before { background: #198754; }
    .report-kpi.warning::before { background: #c88a2b; }
    .report-kpi.danger::before { background: #dc3545; }
    .report-kpi.info::before { background: #0d6efd; }
    .report-kpi.neutral::before { background: #6b7280; }

    .financial-flow {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        align-items: stretch;
    }

    .financial-step {
        padding: 1rem;
        border: 1px solid rgba(31, 41, 55, .08);
        background: #fff;
        min-height: 108px;
    }

    .financial-step:first-child {
        border-radius: 12px 0 0 12px;
    }

    .financial-step:last-child {
        border-radius: 0 12px 12px 0;
    }

    .financial-step + .financial-step {
        border-left: 0;
    }

    .financial-step .step-label {
        font-size: .78rem;
        color: #6b7280;
        font-weight: 600;
    }

    .financial-step .step-value {
        margin-top: .45rem;
        font-size: 1.3rem;
        font-weight: 750;
        color: #111827;
        white-space: nowrap;
    }

    .financial-step .step-note {
        font-size: .72rem;
        color: #9ca3af;
        margin-top: .15rem;
    }

    .report-chart {
        height: 310px;
    }

    .report-chart-sm {
        height: 270px;
    }

    .report-table-card {
        height: 100%;
    }

    .report-table-card .card-body {
        padding: 0;
    }

    .report-table-card .table-wrap {
        max-height: 390px;
        overflow: auto;
    }

    .report-table-card table {
        margin-bottom: 0;
    }

    .report-table-card thead th {
        position: sticky;
        top: 0;
        z-index: 1;
        background: #f8f9fa;
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .02em;
        color: #6b7280;
        white-space: nowrap;
    }

    .report-table-card td {
        font-size: .88rem;
        white-space: nowrap;
    }

    .report-table-card .card-header {
        background: #fff;
        border-bottom: 1px solid rgba(31, 41, 55, .08);
        padding: 1rem 1.1rem;
    }

    .report-accordion .accordion-item {
        border: 1px solid rgba(31, 41, 55, .08);
        border-radius: 12px !important;
        overflow: hidden;
        margin-bottom: .75rem;
    }

    .report-accordion .accordion-button {
        font-weight: 700;
        background: #fff;
        box-shadow: none;
        padding: 1rem 1.1rem;
    }

    .report-accordion .accordion-button:not(.collapsed) {
        color: #1f2937;
        background: #faf7f2;
    }

    .report-accordion .accordion-body {
        padding: 0;
    }

    .inventory-highlight {
        border-radius: 14px;
        padding: 1rem 1.1rem;
        background: #f8f9fa;
        border: 1px solid rgba(31, 41, 55, .08);
    }

    .inventory-highlight .label {
        color: #6b7280;
        font-size: .8rem;
        font-weight: 600;
    }

    .inventory-highlight .value {
        margin-top: .3rem;
        font-size: 1.3rem;
        font-weight: 750;
    }

    .table-empty {
        padding: 2.5rem 1rem !important;
        text-align: center;
        color: #9ca3af;
    }

    .table-empty i {
        font-size: 1.6rem;
        display: block;
        margin-bottom: .5rem;
    }

    @media (max-width: 991.98px) {
        .financial-flow {
            grid-template-columns: 1fr;
        }

        .financial-step,
        .financial-step:first-child,
        .financial-step:last-child {
            border-radius: 0;
        }

        .financial-step + .financial-step {
            border-left: 1px solid rgba(31, 41, 55, .08);
            border-top: 0;
        }

        .report-kpi .kpi-value,
        .financial-step .step-value {
            white-space: normal;
        }
    }

    @media (max-width: 575.98px) {
        .reports-header {
            padding: 1rem;
        }

        .reports-header-actions {
            width: 100%;
        }

        .reports-header-actions .btn {
            flex: 1;
        }

        .report-chart,
        .report-chart-sm {
            height: 250px;
        }
    }
</style>


<div class="container-fluid reports-page">

    {{-- PAGE HEADER --}}
    <div class="reports-header mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">

            <div class="d-flex align-items-center gap-3">
                <div class="report-icon">
                    <i class="bi bi-bar-chart-line"></i>
                </div>

                <div>
                    <h4 class="fw-bold mb-1">Reports & Performance</h4>
                    <p class="text-muted mb-2">
                        A clear overview of sales, profitability, and inventory.
                    </p>

                    <span class="report-period-pill">
                        <i class="bi bi-calendar3"></i>
                        {{ $from->format('M d, Y') }} – {{ $to->format('M d, Y') }}
                    </span>
                </div>
            </div>

            <div class="d-flex gap-2 reports-header-actions">
                <a href="{{ route('admin.reports.export.pdf', request()->query()) }}"
                   class="btn btn-outline-danger">
                    <i class="bi bi-file-earmark-pdf me-1"></i>
                    PDF
                </a>

                <a href="{{ route('admin.reports.export.excel', request()->query()) }}"
                   class="btn btn-outline-success">
                    <i class="bi bi-file-earmark-excel me-1"></i>
                    Excel
                </a>
            </div>

        </div>
    </div>

    {{-- DATE FILTER --}}
    <div class="card report-filter-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.index') }}">
                <div class="row g-3 align-items-end">

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold small">
                            <i class="bi bi-calendar3 me-1"></i>
                            Reporting Period
                        </label>

                        <select name="period" class="form-select" id="periodSelect">
                            <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Today</option>
                            <option value="week" {{ $period === 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="month" {{ $period === 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="year" {{ $period === 'year' ? 'selected' : '' }}>This Year</option>
                            <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Custom Date</option>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold small">From</label>
                        <input type="date"
                               name="from"
                               class="form-control"
                               value="{{ request('from') }}">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold small">To</label>
                        <input type="date"
                               name="to"
                               class="form-control"
                               value="{{ request('to') }}">
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-funnel me-1"></i>
                            Apply Filter
                        </button>

                        <a href="{{ route('admin.reports.index') }}"
                           class="btn btn-outline-secondary"
                           title="Reset filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>


    {{-- FINANCIAL SNAPSHOT --}}
    <div class="section-heading">
        <div class="section-icon">
            <i class="bi bi-speedometer2"></i>
        </div>
        <div>
            <h5>Financial Snapshot</h5>
            <p>Key figures for the selected reporting period.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-xl col-md-6">
            <div class="report-kpi primary">
                <div class="kpi-label"><i class="bi bi-cash-stack"></i> Total Sales</div>
                <div class="kpi-value">₱{{ number_format($totalSales, 2) }}</div>
                <div class="kpi-note">Completed sales revenue</div>
            </div>
        </div>

        <div class="col-xl col-md-6">
            <div class="report-kpi info">
                <div class="kpi-label"><i class="bi bi-cart-check"></i> Total Orders</div>
                <div class="kpi-value">{{ number_format($totalOrders) }}</div>
                <div class="kpi-note">Completed orders</div>
            </div>
        </div>

        <div class="col-xl col-md-6">
            <div class="report-kpi success">
                <div class="kpi-label"><i class="bi bi-graph-up-arrow"></i> Gross Profit</div>
                <div class="kpi-value">₱{{ number_format($fifoGrossProfit, 2) }}</div>
                <div class="kpi-note">Sales revenue less FIFO COGS</div>
            </div>
        </div>

        <div class="col-xl col-md-6">
            <div class="report-kpi warning">
                <div class="kpi-label"><i class="bi bi-wallet2"></i> Operating Expenses</div>
                <div class="kpi-value">₱{{ number_format($operatingExpenses, 2) }}</div>
                <div class="kpi-note">Excludes FIFO COGS</div>
            </div>
        </div>

        <div class="col-xl col-md-6">
            <div class="report-kpi {{ $netProfit >= 0 ? 'success' : 'danger' }}">
                <div class="kpi-label"><i class="bi bi-calculator"></i> Net Profit</div>
                <div class="kpi-value">₱{{ number_format($netProfit, 2) }}</div>
                <div class="kpi-note">Gross profit less operating expenses</div>
            </div>
        </div>

    </div>

    {{-- SALES BREAKDOWN --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="report-kpi neutral">
                <div class="kpi-label"><i class="bi bi-globe2"></i> Online Sales</div>
                <div class="kpi-value">₱{{ number_format($onlineSales, 2) }}</div>
                <div class="kpi-note">Completed online sales</div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="report-kpi neutral">
                <div class="kpi-label"><i class="bi bi-shop"></i> Walk-in Sales</div>
                <div class="kpi-value">₱{{ number_format($walkInSales, 2) }}</div>
                <div class="kpi-note">Completed walk-in sales</div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="report-kpi success">
                <div class="kpi-label"><i class="bi bi-check-circle"></i> Completed Orders</div>
                <div class="kpi-value">{{ number_format($completedOrders) }}</div>
                <div class="kpi-note">Successfully completed</div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="report-kpi warning">
                <div class="kpi-label"><i class="bi bi-hourglass-split"></i> Pending Orders</div>
                <div class="kpi-value">{{ number_format($pendingOrders) }}</div>
                <div class="kpi-note">Still awaiting completion</div>
            </div>
        </div>

    </div>


    {{-- SALES OVERVIEW --}}
    <div class="section-heading mt-4">
        <div class="section-icon">
            <i class="bi bi-graph-up-arrow"></i>
        </div>
        <div>
            <h5>Sales Overview</h5>
            <p>See how sales are performing during the selected period.</p>
        </div>
    </div>

    <div class="card report-section-card mb-4">
        <div class="card-body p-3 p-lg-4">
            <div class="mb-3">
                <h6 class="fw-bold mb-1">Sales Trend</h6>
                <p class="text-muted small mb-0">Sales performance over time.</p>
            </div>
            <div class="report-chart">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-lg-6">
            <div class="card report-section-card h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="mb-3">
                        <h6 class="fw-bold mb-1">
                            <i class="bi bi-pie-chart me-2"></i>
                            Sales by Order Type
                        </h6>
                        <p class="text-muted small mb-0">Online compared with walk-in sales.</p>
                    </div>

                    <div class="report-chart-sm">
                        <canvas id="orderTypeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card report-section-card h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="mb-3">
                        <h6 class="fw-bold mb-1">
                            <i class="bi bi-credit-card me-2"></i>
                            Sales by Payment Method
                        </h6>
                        <p class="text-muted small mb-0">Recorded payment methods in the selected period.</p>
                    </div>

                    <div class="report-chart-sm">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- PROFITABILITY --}}
    <div class="section-heading mt-4">
        <div class="section-icon">
            <i class="bi bi-calculator"></i>
        </div>
        <div>
            <h5>Profitability</h5>
            <p>How sales revenue turns into gross profit and net profit.</p>
        </div>
    </div>

    <div class="card report-section-card mb-4">
        <div class="card-body p-3 p-lg-4">

            <div class="financial-flow">

                <div class="financial-step">
                    <div class="step-label">FIFO Sales Revenue</div>
                    <div class="step-value">₱{{ number_format($fifoSalesRevenue, 2) }}</div>
                    <div class="step-note">Sales with complete FIFO allocation</div>
                </div>

                <div class="financial-step">
                    <div class="step-label">FIFO COGS</div>
                    <div class="step-value">₱{{ number_format($fifoCogs, 2) }}</div>
                    <div class="step-note">Cost of goods sold using FIFO</div>
                </div>

                <div class="financial-step">
                    <div class="step-label">Gross Profit</div>
                    <div class="step-value">₱{{ number_format($fifoGrossProfit, 2) }}</div>
                    <div class="step-note">Revenue − FIFO COGS</div>
                </div>

                <div class="financial-step">
                    <div class="step-label">Operating Expenses</div>
                    <div class="step-value">₱{{ number_format($operatingExpenses, 2) }}</div>
                    <div class="step-note">Operating expenses only</div>
                </div>

                <div class="financial-step">
                    <div class="step-label">Net Profit</div>
                    <div class="step-value">₱{{ number_format($netProfit, 2) }}</div>
                    <div class="step-note">Gross Profit − Expenses</div>
                </div>

            </div>

        </div>
    </div>


    {{-- INVENTORY --}}
    <div class="section-heading mt-4">
        <div class="section-icon">
            <i class="bi bi-boxes"></i>
        </div>
        <div>
            <h5>Inventory Status</h5>
            <p>Current product availability and inventory value.</p>
        </div>
    </div>

    <div class="card report-section-card mb-4">
        <div class="card-body p-3 p-lg-4">

            <div class="row g-3 mb-3">

                <div class="col-lg-3 col-md-6">
                    <div class="inventory-highlight">
                        <div class="label"><i class="bi bi-box me-1"></i> Total Products</div>
                        <div class="value">{{ number_format($totalProducts) }}</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="inventory-highlight">
                        <div class="label"><i class="bi bi-check-circle me-1"></i> Available</div>
                        <div class="value">{{ number_format($availableProducts) }}</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="inventory-highlight">
                        <div class="label"><i class="bi bi-exclamation-triangle me-1"></i> Low Stock</div>
                        <div class="value">{{ number_format($lowStockProducts) }}</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="inventory-highlight">
                        <div class="label"><i class="bi bi-x-circle me-1"></i> Out of Stock</div>
                        <div class="value">{{ number_format($outOfStockProducts) }}</div>
                    </div>
                </div>

            </div>

            <div class="row g-3">

                <div class="col-lg-4 col-md-6">
                    <div class="inventory-highlight">
                        <div class="label"><i class="bi bi-boxes me-1"></i> Current Inventory Cost</div>
                        <div class="value">₱{{ number_format($currentInventoryCost, 2) }}</div>
                        <div class="text-muted small mt-1">Value of remaining current FIFO inventory.</div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="inventory-highlight">
                        <div class="label"><i class="bi bi-cart-plus me-1"></i> Purchase Cost</div>
                        <div class="value">₱{{ number_format($totalPurchaseCost, 2) }}</div>
                        <div class="text-muted small mt-1">Purchases recorded in the selected period.</div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="inventory-highlight">
                        <div class="label"><i class="bi bi-box-arrow-in-down me-1"></i> Units Received</div>
                        <div class="value">
                            {{ number_format($totalGoodUnits) }}
                            <span class="text-muted fs-6 fw-normal">good</span>
                        </div>
                        <div class="text-muted small mt-1">
                            {{ number_format($totalRejectUnits) }} rejected units.
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    {{-- SALES PERFORMANCE BREAKDOWNS --}}
    <div class="section-heading mt-4">
        <div class="section-icon">
            <i class="bi bi-trophy"></i>
        </div>
        <div>
            <h5>Sales Performance</h5>
            <p>Open a section to review products, tribes, craftsmen, or customers.</p>
        </div>
    </div>

    <div class="accordion report-accordion mb-4" id="reportBreakdowns">

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingProducts">
                <button class="accordion-button" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseProducts"
                        aria-expanded="true"
                        aria-controls="collapseProducts">
                    <i class="bi bi-box-seam me-2"></i>
                    Top Selling Products
                </button>
            </h2>
            <div id="collapseProducts"
                 class="accordion-collapse collapse show"
                 aria-labelledby="headingProducts"
                 data-bs-parent="#reportBreakdowns">
                <div class="accordion-body">
                    <div class="px-3 pt-3 pb-2">
                        <p class="text-muted small mb-0">
                            Products with the highest sales activity in the selected period.
                        </p>
                    </div>

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


    
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTribes">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseTribes"
                        aria-expanded="false"
                        aria-controls="collapseTribes">
                    <i class="bi bi-people-fill me-2"></i>
                    Top Tribes
                </button>
            </h2>
            <div id="collapseTribes"
                 class="accordion-collapse collapse"
                 aria-labelledby="headingTribes"
                 data-bs-parent="#reportBreakdowns">
                <div class="accordion-body">
                    <div class="px-3 pt-3 pb-2">
                        <p class="text-muted small mb-0">
                            Tribes with the highest sales contribution.
                        </p>
                    </div>

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


    
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingCraftsmen">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseCraftsmen"
                        aria-expanded="false"
                        aria-controls="collapseCraftsmen">
                    <i class="bi bi-person-workspace me-2"></i>
                    Top Craftsmen / Producers
                </button>
            </h2>
            <div id="collapseCraftsmen"
                 class="accordion-collapse collapse"
                 aria-labelledby="headingCraftsmen"
                 data-bs-parent="#reportBreakdowns">
                <div class="accordion-body">
                    <div class="px-3 pt-3 pb-2">
                        <p class="text-muted small mb-0">
                            Producers with the highest sales contribution.
                        </p>
                    </div>

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


    
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingCustomers">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseCustomers"
                        aria-expanded="false"
                        aria-controls="collapseCustomers">
                    <i class="bi bi-person-lines-fill me-2"></i>
                    Top Customers
                </button>
            </h2>
            <div id="collapseCustomers"
                 class="accordion-collapse collapse"
                 aria-labelledby="headingCustomers"
                 data-bs-parent="#reportBreakdowns">
                <div class="accordion-body">
                    <div class="px-3 pt-3 pb-2">
                        <p class="text-muted small mb-0">
                            Customers with the highest purchase activity.
                        </p>
                    </div>

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


    
                </div>
            </div>
        </div>

    </div>


    {{-- DETAILED SALES --}}
    <div class="section-heading mt-4">
        <div class="section-icon">
            <i class="bi bi-receipt"></i>
        </div>
        <div>
            <h5>Detailed Sales</h5>
            <p>Transaction-level sales records for the selected period.</p>
        </div>
    </div>

    <div class="card report-section-card mb-4">
        <div class="card-body p-0">
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