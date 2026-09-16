@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-1">
            Dashboard
        </h2>

        <p class="text-muted mb-0">
            Overview of MINDOrich activities and performance.
        </p>
    </div>

    <!-- Statistics -->
    <div class="row g-4 mb-4">

        {{-- PRODUCTS --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Products
                            </small>

                            <h2
                                class="fw-bold mt-2 mb-1 counter"
                                data-target="{{ $products }}"
                            >
                                0
                            </h2>

                            <small class="text-success">
                                Products in system
                            </small>

                        </div>

                        <div class="icon-circle bg-warning-subtle">

                            <i class="bi bi-box text-warning fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- PRODUCERS --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Producers
                            </small>

                            <h2
                                class="fw-bold mt-2 mb-1 counter"
                                data-target="{{ $producers }}"
                            >
                                0
                            </h2>

                            <small class="text-success">
                                Producers registered
                            </small>

                        </div>

                        <div class="icon-circle bg-success-subtle">

                            <i class="bi bi-people text-success fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- CUSTOMERS --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Customers
                            </small>

                            <h2
                                class="fw-bold mt-2 mb-1 counter"
                                data-target="{{ $customers }}"
                            >
                                0
                            </h2>

                            <small class="text-success">
                                Customers registered
                            </small>

                        </div>

                        <div class="icon-circle bg-primary-subtle">

                            <i class="bi bi-person text-primary fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- PENDING ORDERS --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Pending Orders
                            </small>

                            <h2
                                class="fw-bold mt-2 mb-1 counter"
                                data-target="{{ $pendingOrders }}"
                            >
                                0
                            </h2>

                            <small class="text-danger">
                                Needs Attention
                            </small>

                        </div>

                        <div class="icon-circle bg-danger-subtle">

                            <i class="bi bi-cart text-danger fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Analytics -->
    <div class="row g-4">

        {{-- SALES ANALYTICS --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0 pt-4">

                    <h5 class="fw-bold">
                        Sales Analytics
                    </h5>

                    <small class="text-muted">
                        Monthly Revenue
                    </small>

                </div>

                <div style="height:330px;">

                    <canvas id="salesChart"></canvas>

                </div>

            </div>

        </div>


      {{-- TOP PRODUCERS --}}
<div class="col-lg-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 pt-4">

            <h5 class="fw-bold">
                Top Producers
            </h5>

            <small class="text-muted">
                Highest sales performance
            </small>

        </div>

        <div class="card-body">

            @forelse($topProducers as $producer)

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div class="d-flex align-items-center gap-3">

    @if($producer->photo)
        <img
            src="{{ asset('storage/' . $producer->photo) }}"
            alt="{{ $producer->producer_name }}"
            class="rounded-circle"
            width="48"
            height="48"
            style="object-fit: cover;"
        >
    @else
        <div
            class="rounded-circle bg-light d-flex align-items-center justify-content-center"
            style="width: 48px; height: 48px;"
        >
            <i class="bi bi-person text-muted fs-5"></i>
        </div>
    @endif

    <div>

        <strong>
            {{ $producer->producer_name }}
        </strong>

        <br>

        <small class="text-muted">
            {{ $producer->tribe_name ?? 'Mangyan Producer' }}
        </small>

    </div>

</div>

                    <strong>
                        ₱{{ number_format($producer->total_sales, 2) }}
                    </strong>

                </div>

            @empty

                <div class="text-center text-muted py-3">
                    No producer sales data available.
                </div>

            @endforelse

        </div>

    </div>

</div>


    <!-- Bottom Section -->

    <div class="row mt-4">

        {{-- RECENT ORDERS --}}
<div class="col-lg-8">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">
                    Recent Orders
                </h5>

                <small class="text-muted">
                    Latest customer orders
                </small>

            </div>

            <a
    href="{{ route('orders.index') }}"
    class="text-warning text-decoration-none fw-semibold"
>
    View All

    <i class="bi bi-arrow-right"></i>
</a>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>
                                Order ID
                            </th>

                            <th>
                                Customer
                            </th>

                            <th>
                                Product
                            </th>

                            <th>
                                Amount
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($recentOrders as $order)

                            @php

                                $firstItem = $order->saleItems->first();

                                $productName = $firstItem?->product?->product_name
                                    ?? 'No Product';

                            @endphp


                            <tr>

                                <td class="fw-semibold">

                                    {{ $order->sale_number }}

                                </td>


                                <td>

                                    {{ $order->user?->name ?? 'Guest Customer' }}

                                </td>


                                <td>

                                    {{ $productName }}

                                    @if($order->saleItems->count() > 1)

                                        <small class="text-muted">

                                            +{{ $order->saleItems->count() - 1 }}
                                            more

                                        </small>

                                    @endif

                                </td>


                                <td class="fw-semibold">

                                    ₱{{ number_format(
                                        $order->total_amount,
                                        2
                                    ) }}

                                </td>


                                <td>

                                    @php

                                        $status = strtolower(
                                            $order->status ?? 'pending'
                                        );

                                        $statusClass = match ($status) {

                                            'completed',
                                            'delivered' => 'bg-success',

                                            'processing' => 'bg-warning text-dark',

                                            'shipped' => 'bg-primary',

                                            'cancelled' => 'bg-danger',

                                            'pending' => 'bg-secondary',

                                            default => 'bg-secondary',

                                        };

                                    @endphp


                                    <span
                                        class="badge {{ $statusClass }} rounded-pill"
                                    >
                                        {{ strtoupper($order->status ?? 'Pending') }}
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center text-muted py-5"
                                >

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

</div>


        {{-- RIGHT WIDGETS --}}
        <div class="col-lg-4">




            {{-- LOW STOCK --}}
<div class="card border-0 rounded-4 bg-dark text-white">

    <div class="card-body">

        <h5 class="fw-bold mb-3">
            Inventory Focus
        </h5>

        <p class="small text-white-50">
            Low stock products requiring replenishment.
        </p>


        @forelse($lowStockProducts as $product)

            @php

                $stock = (int) $product->stock;

                $minimumStock = max(
                    (int) $product->minimum_stock,
                    1
                );

                /*
                 * Calculate stock percentage.
                 * We use minimum stock as the reference
                 * so products below the minimum are clearly visible.
                 */

                $percentage = min(
                    100,
                    max(
                        5,
                        ($stock / $minimumStock) * 100
                    )
                );

            @endphp


            <div class="mb-3">

                <div class="d-flex justify-content-between">

                    <small>
                        {{ $product->product_name }}
                    </small>

                    <small>
                        {{ $stock }} left
                    </small>

                </div>


                <div
                    class="progress mt-2"
                    style="height:8px;"
                >

                    <div
                        class="progress-bar bg-danger"
                        style="width: {{ $percentage }}%"
                    ></div>

                </div>

            </div>


        @empty

            <div class="text-center py-3">

                <i class="bi bi-check-circle fs-3 text-success"></i>

                <p class="small text-white-50 mb-0 mt-2">
                    All products have sufficient stock.
                </p>

            </div>

        @endforelse


        @if($lowStockProducts->count() > 0)

            <button
                class="btn btn-warning w-100 fw-semibold rounded-3"
            >
                Restock Products
            </button>

        @endif

    </div>

</div>

@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>


/*
|--------------------------------------------------------------------------
| COUNTER ANIMATION
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| SALES CHART
|--------------------------------------------------------------------------
*/

const ctx = document.getElementById('salesChart');

if (ctx) {

    const gradient =
        ctx.getContext('2d').createLinearGradient(
            0,
            0,
            0,
            350
        );


    gradient.addColorStop(
        0,
        'rgba(244,180,0,.35)'
    );


    gradient.addColorStop(
        1,
        'rgba(244,180,0,0)'
    );


    /*
    |--------------------------------------------------------------------------
    | USE CONTROLLER DATA IF AVAILABLE
    |--------------------------------------------------------------------------
    */

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

                tension: .45,

                pointRadius: 0,

                pointHoverRadius: 6,

                pointBackgroundColor: '#F4B400'

            }]

        },


        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    display: false

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

                        color: '#EFEFEF'

                    },


                    ticks: {

                        callback: function(value) {

                            return '₱' +
                                Number(value / 1000) +
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