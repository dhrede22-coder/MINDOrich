@extends('admin.layouts.app')

@section('title', 'View Product')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Product Details
            </h2>

            <p class="text-muted mb-0">
                View information about this product.
            </p>

        </div>


        <div class="d-flex gap-2 flex-wrap">

            <a
                href="{{ route('products.edit', $product) }}"
                class="btn btn-warning"
            >
                <i class="bi bi-pencil me-2"></i>
                Edit Product
            </a>


            <a
                href="{{ route('products.index') }}"
                class="btn btn-light border"
            >
                <i class="bi bi-arrow-left me-2"></i>
                Back to Products
            </a>

        </div>

    </div>


    {{-- =========================================================
        PRODUCT OVERVIEW
    ========================================================== --}}
    <div class="row g-4">


        {{-- =====================================================
            PRODUCT IMAGE
        ====================================================== --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="text-center">

                        @if($product->featured_image)

                            <img
                                src="{{ asset('storage/' . $product->featured_image) }}"
                                class="img-fluid rounded-4"
                                style="
                                    width: 100%;
                                    height: 320px;
                                    object-fit: cover;
                                "
                                alt="{{ $product->product_name }}"
                            >

                        @else

                            <div
                                class="bg-light rounded-4 d-flex align-items-center justify-content-center"
                                style="height: 320px;"
                            >

                                <i
                                    class="bi bi-image text-muted"
                                    style="font-size: 70px;"
                                ></i>

                            </div>

                        @endif

                    </div>


                    @if($product->featured)

                        <div class="text-center mt-3">

                            <span class="badge bg-warning text-dark px-3 py-2">

                                <i class="bi bi-star-fill me-1"></i>

                                Featured Product

                            </span>

                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- =====================================================
            PRODUCT INFORMATION
        ====================================================== --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start mb-4">

                        <div>

                            <h3 class="fw-bold mb-1">
                                {{ $product->product_name }}
                            </h3>

                            <p class="text-muted mb-0">
                                {{ $product->category->category_name ?? 'No Category' }}
                            </p>

                        </div>


                        @if($product->status === 'Available')

                            <span class="badge bg-success px-3 py-2">
                                Available
                            </span>

                        @elseif($product->status === 'Out of Stock')

                            <span class="badge bg-danger px-3 py-2">
                                Out of Stock
                            </span>

                        @else

                            <span class="badge bg-secondary px-3 py-2">
                                {{ $product->status }}
                            </span>

                        @endif

                    </div>


                    {{-- PRODUCT DETAILS --}}
                    <div class="row g-4">

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Producer
                            </small>

                            <strong>
                                {{ $product->producer->producer_name ?? '—' }}
                            </strong>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Category
                            </small>

                            <strong>
                                {{ $product->category->category_name ?? '—' }}
                            </strong>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                SRP
                            </small>

                            <strong class="fs-5">
                                ₱{{ number_format($product->price, 2) }}
                            </strong>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Current Stock
                            </small>

                            <strong class="fs-5">
                                {{ number_format($product->stock) }}
                            </strong>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Minimum Stock
                            </small>

                            <strong>
                                {{ number_format($product->minimum_stock) }}
                            </strong>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Status
                            </small>

                            <strong>
                                {{ $product->status }}
                            </strong>

                        </div>


                        <div class="col-12">

                            <hr>

                            <small class="text-muted d-block mb-2">
                                Description
                            </small>

                            <p class="mb-0">
                                {{ $product->description ?: 'No description provided.' }}
                            </p>

                        </div>

                    </div>


                    {{-- =================================================
                        INVENTORY
                    ================================================== --}}
                    <div class="border-top mt-4 pt-4">

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Inventory
                                </h5>

                                <p class="text-muted small mb-0">
                                    View stock movement history.
                                </p>

                            </div>


                            <a
                                href="{{ route('products.inventory.history', $product) }}"
                                class="btn btn-info"
                            >
                                <i class="bi bi-clock-history me-2"></i>
                                Inventory History
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        FIFO PURCHASE BATCHES
    ========================================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mt-4">

        <div class="card-header bg-white border-0 p-4">

            <div>

                <h5 class="fw-bold mb-1">
                    FIFO Purchase Batches
                </h5>

                <p class="text-muted small mb-0">
                    Purchase batches used to track the cost of this product.
                </p>

            </div>

        </div>


        <div class="card-body p-0">

            @if($product->purchaseItems->count())

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">
                                    Purchase
                                </th>

                                <th>
                                    Received
                                </th>

                                <th class="text-center">
                                    Qty In
                                </th>

                                <th class="text-center">
                                    Reject
                                </th>

                                <th class="text-center">
                                    Good
                                </th>

                                <th class="text-end">
                                    Purchase Price
                                </th>

                                <th class="text-center">
                                    Remaining
                                </th>

                                <th class="text-end pe-4">
                                    Remaining Cost
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($product->purchaseItems->sortBy([
                                ['received_at', 'asc'],
                                ['id', 'asc'],
                            ]) as $purchaseItem)

                                @php

                                    $remainingCost =
                                        (float) $purchaseItem->remaining_quantity
                                        *
                                        (float) $purchaseItem->purchase_price;

                                @endphp

                                <tr>

                                    {{-- Purchase --}}
                                    <td class="ps-4">

                                        <div class="fw-semibold">

                                            {{ $purchaseItem->purchase->purchase_number ?? 'N/A' }}

                                        </div>

                                        @if($purchaseItem->purchase)

                                            <small class="text-muted">

                                                {{ $purchaseItem->purchase->producer->producer_name ?? '—' }}

                                            </small>

                                        @endif

                                    </td>


                                    {{-- Received Date --}}
                                    <td>

                                        {{ $purchaseItem->received_at?->format('M d, Y') ?? '—' }}

                                    </td>


                                    {{-- Qty In --}}
                                    <td class="text-center">

                                        {{ number_format($purchaseItem->quantity_in) }}

                                    </td>


                                    {{-- Reject --}}
                                    <td class="text-center">

                                        @if($purchaseItem->reject_quantity > 0)

                                            <span class="text-danger fw-semibold">

                                                {{ number_format($purchaseItem->reject_quantity) }}

                                            </span>

                                        @else

                                            0

                                        @endif

                                    </td>


                                    {{-- Good --}}
                                    <td class="text-center">

                                        <span class="text-success fw-semibold">

                                            {{ number_format($purchaseItem->good_quantity) }}

                                        </span>

                                    </td>


                                    {{-- Purchase Price --}}
                                    <td class="text-end">

                                        ₱{{ number_format($purchaseItem->purchase_price, 2) }}

                                    </td>


                                    {{-- Remaining --}}
                                    <td class="text-center">

                                        <span class="fw-semibold">

                                            {{ number_format($purchaseItem->remaining_quantity) }}

                                        </span>

                                    </td>


                                    {{-- Remaining Cost --}}
                                    <td class="text-end pe-4">

                                        ₱{{ number_format($remainingCost, 2) }}

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5 px-3">

                    <i class="bi bi-box-seam fs-1 text-muted"></i>

                    <h6 class="fw-bold mt-3">
                        No Purchase Batches
                    </h6>

                    <p class="text-muted mb-0">
                        No FIFO purchase batches have been recorded for this product yet.
                    </p>

                </div>

            @endif

        </div>

    </div>


    {{-- =========================================================
        FIFO SUMMARY
    ========================================================== --}}
    @php

        $fifoRemaining =
            $product->purchaseItems->sum('remaining_quantity');

        $fifoRemainingCost =
            $product->purchaseItems->sum(function ($item) {

                return
                    (float) $item->remaining_quantity
                    *
                    (float) $item->purchase_price;

            });

        $fifoRemainingSalesValue =
            $product->purchaseItems->sum(function ($item) use ($product) {

                return
                    (float) $item->remaining_quantity
                    *
                    (float) $product->price;

            });

        $fifoPotentialProfit =
            $fifoRemainingSalesValue
            -
            $fifoRemainingCost;

    @endphp


    @if($product->purchaseItems->count())

        <div class="row g-3 mt-1 mb-4">

            <div class="col-lg-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <small class="text-muted">
                            FIFO Remaining Qty
                        </small>

                        <h4 class="fw-bold mt-2 mb-0">
                            {{ number_format($fifoRemaining) }}
                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <small class="text-muted">
                            FIFO Remaining Cost
                        </small>

                        <h4 class="fw-bold mt-2 mb-0">
                            ₱{{ number_format($fifoRemainingCost, 2) }}
                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <small class="text-muted">
                            Remaining Sales Value
                        </small>

                        <h4 class="fw-bold mt-2 mb-0">
                            ₱{{ number_format($fifoRemainingSalesValue, 2) }}
                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <small class="text-muted">
                            Potential Profit
                        </small>

                        <h4 class="fw-bold mt-2 mb-0 text-success">
                            ₱{{ number_format($fifoPotentialProfit, 2) }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>

    @endif

</div>

@endsection