@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="fw-bold mb-1">
                Orders
            </h1>

            <p class="text-muted mb-0">
                Manage walk-in and online orders.
            </p>

        </div>
        <a href="{{ route('orders.create') }}"
       class="btn btn-warning">

        <i class="bi bi-plus-circle me-1"></i>

        Create Order

    </a>

    </div>


    {{-- Statistics --}}
    <div class="row g-4 mb-4">

        {{-- Total Orders --}}
        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <p class="text-muted mb-2">
                            Total Orders
                        </p>

                        <h2 class="fw-bold mb-0">
                            {{ $totalOrders }}
                        </h2>

                    </div>

                    <div class="fs-1 text-warning">
                        <i class="bi bi-cart-check"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- Pending --}}
        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <p class="text-muted mb-2">
                            Pending
                        </p>

                        <h2 class="fw-bold mb-0">
                            {{ $pendingOrders }}
                        </h2>

                    </div>

                    <div class="fs-1 text-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- Processing --}}
        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <p class="text-muted mb-2">
                            Processing
                        </p>

                        <h2 class="fw-bold mb-0">
                            {{ $processingOrders }}
                        </h2>

                    </div>

                    <div class="fs-1 text-primary">
                        <i class="bi bi-box-seam"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- Completed --}}
        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <p class="text-muted mb-2">
                            Completed
                        </p>

                        <h2 class="fw-bold mb-0">
                            {{ $completedOrders }}
                        </h2>

                    </div>

                    <div class="fs-1 text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


</div>
{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET"
              action="{{ route('orders.index') }}">

            <div class="row g-3 align-items-end">

                {{-- Search --}}
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Search Order
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search by order number">

                </div>


                {{-- Sale Type --}}
                <div class="col-md-2">

                    <label class="form-label fw-semibold">
                        Order Type
                    </label>

                    <select name="sale_type"
                            class="form-select">

                        <option value="">
                            All Types
                        </option>

                        <option value="Walk-in"
                            {{ request('sale_type') === 'Walk-in' ? 'selected' : '' }}>
                            Walk-in
                        </option>

                        <option value="Online"
                            {{ request('sale_type') === 'Online' ? 'selected' : '' }}>
                            Online
                        </option>

                    </select>

                </div>


                {{-- Status --}}
                <div class="col-md-2">

                    <label class="form-label fw-semibold">
                        Order Status
                    </label>

                    <select name="status"
                            class="form-select">

                        <option value="">
                            All Status
                        </option>

                        <option value="Pending"
                            {{ request('status') === 'Pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="Processing"
                            {{ request('status') === 'Processing' ? 'selected' : '' }}>
                            Processing
                        </option>

                        <option value="Completed"
                            {{ request('status') === 'Completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="Cancelled"
                            {{ request('status') === 'Cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                    </select>

                </div>


                {{-- Payment Status --}}
                <div class="col-md-2">

                    <label class="form-label fw-semibold">
                        Payment
                    </label>

                    <select name="payment_status"
                            class="form-select">

                        <option value="">
                            All Payments
                        </option>

                        <option value="Pending"
                            {{ request('payment_status') === 'Pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="Paid"
                            {{ request('payment_status') === 'Paid' ? 'selected' : '' }}>
                            Paid
                        </option>

                        <option value="Failed"
                            {{ request('payment_status') === 'Failed' ? 'selected' : '' }}>
                            Failed
                        </option>

                        <option value="Refunded"
                            {{ request('payment_status') === 'Refunded' ? 'selected' : '' }}>
                            Refunded
                        </option>

                    </select>

                </div>


                {{-- Buttons --}}
                <div class="col-md-2 d-flex gap-2">

                    

                    <a href="{{ route('orders.index') }}"
                       class="btn btn-light border"
                       title="Reset Filters">

                        <i class="bi bi-arrow-counterclockwise"></i>

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>
{{-- Orders Table --}}

<div class="d-flex justify-content-end mb-3">

    <a href="{{ request()->fullUrlWithQuery(['all' => 1]) }}"
       class="btn btn-outline-primary">

        <i class="bi bi-cart-check me-2"></i>

        See All Orders

    </a>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h5 class="fw-bold mb-1">
                    All Orders
                </h5>

                <p class="text-muted small mb-0">
                    View and manage customer orders.
                </p>

            </div>

        </div>


        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>

                    <tr>

                        <th>ORDER</th>

                        <th>TYPE</th>

                        <th>CUSTOMER</th>

                        <th>ITEMS</th>

                        <th>TOTAL</th>

                        <th>PAYMENT</th>

                        <th>STATUS</th>

                        <th class="text-end">ACTION</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($orders as $order)

                        <tr>

                            {{-- Order Number --}}
                            <td>

                                <div class="fw-semibold">
                                    {{ $order->sale_number }}
                                </div>

                                <small class="text-muted">
                                    {{ $order->created_at->format('M d, Y') }}
                                </small>

                            </td>


                            {{-- Type --}}
                            <td>

                                @if($order->sale_type === 'Walk-in')

                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-shop me-1"></i>
                                        Walk-in
                                    </span>

                                @else

                                    <span class="badge bg-primary">
                                        <i class="bi bi-globe me-1"></i>
                                        Online
                                    </span>

                                @endif

                            </td>


                            {{-- Customer --}}
                            <td>

                                {{ $order->user->name ?? 'Walk-in Customer' }}

                            </td>


                            {{-- Items --}}
                            <td>

                                {{ $order->saleItems->sum('quantity') }}

                            </td>


                            {{-- Total --}}
                            <td>

                                <span class="fw-semibold">
                                    ₱{{ number_format($order->total_amount, 2) }}
                                </span>

                            </td>


                            {{-- Payment --}}
                            <td>

                                @if($order->payment_status === 'Paid')

                                    <span class="badge bg-success">
                                        Paid
                                    </span>

                                @elseif($order->payment_status === 'Pending')

                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>

                                @elseif($order->payment_status === 'Refunded')

                                    <span class="badge bg-secondary">
                                        Refunded
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        {{ $order->payment_status }}
                                    </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($order->status === 'Completed')

                                    <span class="badge bg-success">
                                        Completed
                                    </span>

                                @elseif($order->status === 'Processing')

                                    <span class="badge bg-primary">
                                        Processing
                                    </span>

                                @elseif($order->status === 'Pending')

                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        {{ $order->status }}
                                    </span>

                                @endif

                            </td>


                            {{-- Action --}}
                            <td class="text-end">

                                <a href="{{ route('orders.show', $order) }}"
                                   class="btn btn-sm btn-primary"
                                   title="View Order">

                                    <i class="bi bi-eye"></i>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i class="bi bi-cart-x fs-1 d-block mb-3"></i>

                                    <h6 class="fw-semibold">
                                        No orders found
                                    </h6>

                                    <p class="small mb-0">
                                        There are currently no orders to display.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('form[action="{{ route('orders.index') }}"]');
    const searchInput = form.querySelector('input[name="search"]');
    const filters = form.querySelectorAll('select');

    let timer;

    // Live Search
    searchInput.addEventListener('keyup', function () {

        clearTimeout(timer);

        timer = setTimeout(function () {
            form.submit();
        }, 400);

    });

    // Auto Filter
    filters.forEach(function (filter) {

        filter.addEventListener('change', function () {
            form.submit();
        });

    });

});
</script>

@endsection
