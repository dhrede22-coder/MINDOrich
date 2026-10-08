@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">Historical Sale Details</h4>

            <p class="text-muted mb-0">
                Details of a sale recorded before the system was implemented.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('historical-sales.index') }}"
               class="btn btn-light border">

                <i class="bi bi-arrow-left me-1"></i>
                Back

            </a>

            <a href="{{ route('historical-sales.edit', $historicalSale) }}"
               class="btn btn-primary">

                <i class="bi bi-pencil me-1"></i>
                Edit

            </a>

        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <i class="bi bi-exclamation-circle me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Sale Information --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <h6 class="mb-0">
                <i class="bi bi-receipt me-2"></i>
                Sale Information
            </h6>

        </div>


        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Sales Date
                    </small>

                    <strong>
                        {{ $historicalSale->sales_date->format('M d, Y') }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        OR Number
                    </small>

                    <strong>
                        {{ $historicalSale->or_number ?? '—' }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Customer Name
                    </small>

                    <strong>
                        {{ $historicalSale->customer_name ?? '—' }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Sale Type
                    </small>

                    @if($historicalSale->sale_type === 'Online')

                        <span class="badge bg-primary">
                            Online
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            Walk-in
                        </span>

                    @endif

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Payment Method
                    </small>

                    <strong>
                        {{ $historicalSale->payment_method }}
                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Total Amount
                    </small>

                    <strong class="fs-5">
                        ₱{{ number_format(
                            $historicalSale->total_amount,
                            2
                        ) }}
                    </strong>

                </div>


                @if($historicalSale->notes)

                    <div class="col-12">

                        <small class="text-muted d-block">
                            Notes
                        </small>

                        <div>
                            {{ $historicalSale->notes }}
                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- Sale Items --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <h6 class="mb-0">
                <i class="bi bi-box-seam me-2"></i>
                Sale Items
            </h6>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>Product</th>

                            <th>Quantity</th>

                            <th>Unit Price</th>

                            <th>Subtotal</th>

                            <th>Historical FIFO COGS</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($historicalSale->items as $item)

                            @php

                                $fifoCogs = $item->fifoAllocations->sum(
                                    fn ($allocation) =>
                                        (float) $allocation->cost_subtotal
                                );

                            @endphp

                            <tr>

                                <td>

                                    <strong>
                                        {{ $item->product->product_name ?? '—' }}
                                    </strong>

                                </td>


                                <td>
                                    {{ $item->quantity }}
                                </td>


                                <td>
                                    ₱{{ number_format(
                                        $item->unit_price,
                                        2
                                    ) }}
                                </td>


                                <td>
                                    ₱{{ number_format(
                                        $item->subtotal,
                                        2
                                    ) }}
                                </td>


                                <td>

                                    @if($item->fifoAllocations->isNotEmpty())

                                        <span class="text-success fw-semibold">

                                            ₱{{ number_format(
                                                $fifoCogs,
                                                2
                                            ) }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            Not allocated
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>


                    <tfoot class="table-light">

                        @php

                            $totalFifoCogs = $historicalSale->items->sum(
                                fn ($item) =>
                                    $item->fifoAllocations->sum(
                                        fn ($allocation) =>
                                            (float) $allocation->cost_subtotal
                                    )
                            );

                            $historicalGrossProfit =
                                (float) $historicalSale->total_amount
                                -
                                $totalFifoCogs;

                        @endphp

                        <tr>

                            <th colspan="3"
                                class="text-end">

                                Total

                            </th>

                            <th>

                                ₱{{ number_format(
                                    $historicalSale->total_amount,
                                    2
                                ) }}

                            </th>

                            <th>

                                ₱{{ number_format(
                                    $totalFifoCogs,
                                    2
                                ) }}

                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>


    {{-- Historical FIFO Summary --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <h6 class="mb-0">
                <i class="bi bi-calculator me-2"></i>
                Historical FIFO Summary
            </h6>

        </div>


        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-4">

                    <div class="border rounded p-3">

                        <small class="text-muted d-block">
                            Sales Revenue
                        </small>

                        <h5 class="mb-0">
                            ₱{{ number_format(
                                $historicalSale->total_amount,
                                2
                            ) }}
                        </h5>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="border rounded p-3">

                        <small class="text-muted d-block">
                            Historical FIFO COGS
                        </small>

                        <h5 class="mb-0">
                            ₱{{ number_format(
                                $totalFifoCogs,
                                2
                            ) }}
                        </h5>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="border rounded p-3">

                        <small class="text-muted d-block">
                            Historical Gross Profit
                        </small>

                        <h5 class="mb-0">
                            ₱{{ number_format(
                                $historicalGrossProfit,
                                2
                            ) }}
                        </h5>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- FIFO Allocation Details --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <h6 class="mb-0">
                <i class="bi bi-arrow-repeat me-2"></i>
                FIFO Allocation Details
            </h6>

        </div>


        <div class="card-body">

            @php
                $hasAllocations = $historicalSale->items->contains(
                    fn ($item) => $item->fifoAllocations->isNotEmpty()
                );
            @endphp


            @if($hasAllocations)

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>Product</th>

                                <th>Historical Purchase #</th>

                                <th>Quantity</th>

                                <th>Unit Cost</th>

                                <th>Cost Subtotal</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($historicalSale->items as $item)

                                @foreach($item->fifoAllocations as $allocation)

                                    <tr>

                                        <td>
                                            {{ $item->product->product_name ?? '—' }}
                                        </td>

                                        <td>

                                            {{ $allocation
                                                ->historicalPurchaseItem
                                                ->historicalPurchase
                                                ->purchase_number
                                                ?? '—' }}

                                        </td>

                                        <td>
                                            {{ $allocation->quantity }}
                                        </td>

                                        <td>
                                            ₱{{ number_format(
                                                $allocation->unit_cost,
                                                2
                                            ) }}
                                        </td>

                                        <td>
                                            ₱{{ number_format(
                                                $allocation->cost_subtotal,
                                                2
                                            ) }}
                                        </td>

                                    </tr>

                                @endforeach

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-4">

                    <i class="bi bi-info-circle fs-2 text-muted"></i>

                    <p class="text-muted mb-0 mt-2">
                        No Historical FIFO allocation found.
                    </p>

                </div>

            @endif

        </div>

    </div>


    {{-- Delete --}}
    <div class="d-flex justify-content-end mb-4">

        <form action="{{ route(
                    'historical-sales.destroy',
                    $historicalSale
                ) }}"
              method="POST"
              onsubmit="return confirm(
                  'Are you sure you want to delete this historical sale?'
              );">

            @csrf

            @method('DELETE')

            <button type="submit"
                    class="btn btn-outline-danger">

                <i class="bi bi-trash me-1"></i>

                Delete Historical Sale

            </button>

        </form>

    </div>

</div>

@endsection