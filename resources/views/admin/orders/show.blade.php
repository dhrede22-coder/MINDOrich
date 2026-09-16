@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Order Details
            </h2>

            <p class="text-muted mb-0">
                View complete information about this order.
            </p>

        </div>

        <div class="d-flex gap-2">

    @if($sale->status === 'Completed' && $sale->sale_type === 'Walk-in')

        <a href="{{ route('orders.receipt', $sale) }}"
           class="btn btn-dark"
           target="_blank">

            <i class="bi bi-printer me-2"></i>

            Print Receipt

        </a>

    @endif

    <a href="{{ route('orders.index') }}"
       class="btn btn-light border">

        <i class="bi bi-arrow-left me-2"></i>

        Back to Orders

    </a>

</div>

    </div>


    {{-- Order Summary --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <div class="row g-4">

                {{-- Order Number --}}
                <div class="col-md-3">

                    <small class="text-muted d-block mb-1">
                        Order Number
                    </small>

                    <div class="fw-bold">
                        {{ $sale->sale_number }}
                    </div>

                </div>


                {{-- Order Type --}}
                <div class="col-md-3">

                    <small class="text-muted d-block mb-1">
                        Order Type
                    </small>

                    @if($sale->sale_type === 'Walk-in')

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

                </div>


                {{-- Customer --}}
                <div class="col-md-3">

                    <small class="text-muted d-block mb-1">
                        Customer
                    </small>

                    <div class="fw-semibold">

                        {{ $sale->user->name ?? 'Walk-in Customer' }}

                    </div>

                </div>


                {{-- Date --}}
                <div class="col-md-3">

                    <small class="text-muted d-block mb-1">
                        Date
                    </small>

                    <div class="fw-semibold">

                        {{ $sale->created_at->format('M d, Y h:i A') }}

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Products --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-1">
                Order Items
            </h5>

            <p class="text-muted small mb-4">
                Products included in this order.
            </p>


            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>PRODUCT</th>

                            <th class="text-center">
                                QUANTITY
                            </th>

                            <th class="text-end">
                                PRICE
                            </th>

                            <th class="text-end">
                                SUBTOTAL
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($sale->saleItems as $item)

                            <tr>

                                <td>

                                    <div class="fw-semibold">

                                        {{ $item->product->product_name ?? 'Product unavailable' }}

                                    </div>

                                </td>


                                <td class="text-center">

                                    {{ $item->quantity }}

                                </td>


                                <td class="text-end">

                                    ₱{{ number_format($item->price, 2) }}

                                </td>


                                <td class="text-end fw-semibold">

                                    ₱{{ number_format($item->subtotal, 2) }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center text-muted py-4">

                                    No items found for this order.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- Payment & Status --}}
    <div class="row g-4">

        <div class="col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Payment Information
                    </h5>

                    <div class="mb-3">

                        <small class="text-muted d-block">
                            Payment Method
                        </small>

                        <span class="fw-semibold">

                            {{ $sale->payment_method ?? '—' }}

                        </span>

                    </div>

                    <div>

                        <small class="text-muted d-block">
                            Payment Status
                        </small>

                        <span class="fw-semibold">

                            {{ $sale->payment_status ?? '—' }}

                        </span>

                    </div>
                    @if($sale->payment_method === 'GCash')
    <div class="mt-4">

        <small class="text-muted d-block">
            GCash Reference Number
        </small>

        <span class="fw-semibold">
            {{ $sale->gcash_reference ?? '—' }}
        </span>

    </div>

    @if($sale->gcash_proof)
        <div class="mt-4">

            <small class="text-muted d-block mb-2">
                Proof of Payment
            </small>

            <img
                src="{{ asset('storage/' . $sale->gcash_proof) }}"
                alt="GCash Proof of Payment"
                class="img-fluid border rounded"
                style="max-width: 300px;"
            >

        </div>
    @endif
    @if($sale->payment_status === 'Pending')
    <div class="mt-4 d-flex gap-2">

        <form
            action="{{ route('orders.gcash.verify', $sale) }}"
            method="POST"
        >
            @csrf
            @method('PATCH')

            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle me-1"></i>
                Verify Payment
            </button>
        </form>

        <form
            action="{{ route('orders.gcash.reject', $sale) }}"
            method="POST"
        >
            @csrf
            @method('PATCH')

            <button type="submit" class="btn btn-danger">
                <i class="bi bi-x-circle me-1"></i>
                Reject Payment
            </button>
        </form>

    </div>
@endif
@endif

                </div>

            </div>

        </div>


        <div class="col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Order Summary
                    </h5>

                    <div class="d-flex justify-content-between align-items-center mb-3">

    <span class="text-muted">
        Status
    </span>

    <span class="badge
        @if($sale->status === 'Completed')
            bg-success
        @elseif($sale->status === 'Processing')
            bg-primary
        @elseif($sale->status === 'Cancelled')
            bg-danger
        @else
            bg-warning text-dark
        @endif
    ">
        {{ $sale->status }}
    </span>

</div>

<form
    action="{{ route('orders.status.update', $sale) }}"
    method="POST"
>
    @csrf
    @method('PATCH')

    <label class="form-label fw-semibold">
        Update Order Status
    </label>

    <div class="d-flex gap-2">

        <select
            name="status"
            class="form-select"
        >
            <option value="Pending"
                {{ $sale->status === 'Pending' ? 'selected' : '' }}>
                Pending
            </option>

            <option value="Processing"
                {{ $sale->status === 'Processing' ? 'selected' : '' }}>
                Processing
            </option>

            <option value="Completed"
                {{ $sale->status === 'Completed' ? 'selected' : '' }}>
                Completed
            </option>

            <option value="Cancelled"
                {{ $sale->status === 'Cancelled' ? 'selected' : '' }}>
                Cancelled
            </option>
        </select>

        <button
            type="submit"
            class="btn btn-warning"
        >
            Update
        </button>

    </div>
</form>

                    <hr>

                    <div class="d-flex justify-content-between">

                        <span class="fw-bold">
                            Total Amount
                        </span>

                        <span class="fw-bold fs-5">
                            ₱{{ number_format($sale->total_amount, 2) }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @if(filled($sale->notes))

        <div class="card border-0 shadow-sm mt-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-3">
                    Notes
                </h5>

                <p class="text-secondary mb-0">
                    {{ $sale->notes }}
                </p>

            </div>

        </div>

    @endif

</div>

@endsection
