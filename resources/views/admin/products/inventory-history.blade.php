@extends('admin.layouts.app')

@section('title', 'Inventory History')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Inventory History
            </h2>

            <p class="text-muted mb-0">
                Stock movement history for {{ $product->product_name }}.
            </p>

        </div>

        <a href="{{ route('products.index') }}"
           class="btn btn-light border">

            <i class="bi bi-arrow-left me-2"></i>

            Back to Products

        </a>

    </div>


    {{-- Product Summary --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <h4 class="fw-bold mb-1">
                        {{ $product->product_name }}
                    </h4>

                    <p class="text-muted mb-0">

                        Current Stock:
                        <strong class="text-success">
                            {{ $product->stock }}
                        </strong>

                    </p>

                </div>


                <div class="col-md-4 text-md-end mt-3 mt-md-0">

                    <span class="badge bg-success fs-6 px-3 py-2">

                        {{ $product->stock }} in stock

                    </span>

                </div>

            </div>

        </div>

    </div>


    {{-- Inventory History --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h5 class="fw-bold mb-1">
                        Stock Movements
                    </h5>

                    <p class="text-muted small mb-0">
                        Record of all inventory changes.
                    </p>

                </div>

                <span class="text-muted">
                    {{ $movements->count() }} movement(s)
                </span>

            </div>


            @if($movements->count() > 0)

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr>

                                <th>Date</th>

                                <th>Type</th>

                                <th>Quantity</th>

                                <th>Purchase Batch</th>

                                <th>Remarks</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($movements as $movement)

                                <tr>

                                    {{-- Date --}}
                                    <td>

                                        <div class="fw-semibold">

                                            {{ $movement->created_at->format('M d, Y') }}

                                        </div>

                                        <small class="text-muted">

                                            {{ $movement->created_at->format('h:i A') }}

                                        </small>

                                    </td>


                                    {{-- Movement Type --}}
                                    <td>

                                        @if($movement->movement_type === 'Stock In')

                                            <span class="badge bg-success">

                                                <i class="bi bi-arrow-down-circle me-1"></i>

                                                Stock In

                                            </span>

                                        @elseif($movement->movement_type === 'Stock Out')

                                            <span class="badge bg-secondary">

                                                <i class="bi bi-arrow-up-circle me-1"></i>

                                                Stock Out

                                            </span>

                                        @elseif($movement->movement_type === 'Returned')

                                            <span class="badge bg-warning text-dark">

                                                <i class="bi bi-arrow-return-left me-1"></i>

                                                Returned

                                            </span>

                                        @else

                                            <span class="badge bg-secondary">

                                                {{ $movement->movement_type }}

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Quantity --}}
                                    <td>

                                        @if($movement->movement_type === 'Stock In')

                                            <span class="text-success fw-bold">

                                                +{{ $movement->quantity }}

                                            </span>

                                        @elseif($movement->movement_type === 'Returned')

                                            <span class="text-success fw-bold">

                                                +{{ $movement->quantity }}

                                            </span>

                                        @else

                                            <span class="fw-bold">

                                                {{ $movement->quantity }}

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Purchase Batch --}}
                                    <td>

                                        @if($movement->purchaseItem && $movement->purchaseItem->purchase)

                                            <div class="fw-semibold">

                                                {{ $movement->purchaseItem->purchase->purchase_number }}

                                            </div>

                                            <small class="text-muted">

                                                Batch #{{ $movement->purchase_item_id }}

                                            </small>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Remarks --}}
                                    <td>

                                        {{ $movement->remarks ?? '—' }}

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <i class="bi bi-box-seam fs-1 text-muted"></i>

                    <h6 class="fw-bold mt-3">
                        No inventory movements yet
                    </h6>

                    <p class="text-muted mb-0">
                        Stock changes will appear here.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection