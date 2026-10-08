@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Purchase Details
            </h2>

            <p class="text-muted mb-0">
                {{ $purchase->purchase_number }}
            </p>
        </div>

        <a
            href="{{ route('admin.purchases.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Back to Purchases
        </a>

    </div>


    {{-- =========================================================
        PURCHASE INFORMATION
    ========================================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="row g-4">

                <div class="col-lg-3 col-md-6">

                    <small class="text-muted d-block mb-1">
                        Purchase Number
                    </small>

                    <div class="fw-bold">
                        {{ $purchase->purchase_number }}
                    </div>

                </div>


                <div class="col-lg-3 col-md-6">

                    <small class="text-muted d-block mb-1">
                        Producer
                    </small>

                    <div class="fw-bold">
                        {{ $purchase->producer->producer_name ?? 'N/A' }}
                    </div>

                </div>


                <div class="col-lg-3 col-md-6">

                    <small class="text-muted d-block mb-1">
                        Purchase Date
                    </small>

                    <div class="fw-bold">
                        {{ $purchase->purchase_date?->format('F d, Y') ?? 'N/A' }}
                    </div>

                </div>


                <div class="col-lg-3 col-md-6">

                    <small class="text-muted d-block mb-1">
                        Status
                    </small>

                    @if($purchase->status === 'Completed')

                        <span class="badge bg-success px-3 py-2">
                            Completed
                        </span>

                    @elseif($purchase->status === 'Pending')

                        <span class="badge bg-warning text-dark px-3 py-2">
                            Pending
                        </span>

                    @else

                        <span class="badge bg-secondary px-3 py-2">
                            Cancelled
                        </span>

                    @endif

                </div>

            </div>


            @if($purchase->notes)

                <div class="mt-4 pt-3 border-top">

                    <small class="text-muted d-block mb-1">
                        Notes
                    </small>

                    <div>
                        {{ $purchase->notes }}
                    </div>

                </div>

            @endif

        </div>

    </div>


    {{-- =========================================================
        BASIC PURCHASE SUMMARY
    ========================================================== --}}
    @php

    $totalQuantityIn =
        $purchase->purchaseItems->sum('quantity_in');

    $totalReject =
        $purchase->purchaseItems->sum('reject_quantity');

    $totalGood =
        $purchase->purchaseItems->sum('good_quantity');

    $totalRemaining =
        $purchase->purchaseItems->sum('remaining_quantity');

    $totalRemainingCost =
        $purchase->purchaseItems->sum(function ($item) {

            return
                (float) $item->remaining_quantity
                *
                (float) $item->purchase_price;

        });

    $totalRemainingSalesValue =
        $purchase->purchaseItems->sum(function ($item) {

            return
                (float) $item->remaining_quantity
                *
                (float) ($item->product->price ?? 0);

        });

    $totalRemainingPotentialProfit =
        $totalRemainingSalesValue
        -
        $totalRemainingCost;


    /*
    |--------------------------------------------------------------------------
    | ACTUAL FIFO SALES / PROFIT
    |--------------------------------------------------------------------------
    */

    $totalSoldQuantity = 0;

    $totalFifoCogs = 0;

    $totalSalesRevenue = 0;


    foreach ($purchase->purchaseItems as $purchaseItem) {

        foreach ($purchaseItem->fifoAllocations as $allocation) {

            $sale = $allocation->saleItem->sale ?? null;

            /*
            | Cancelled orders are excluded because their FIFO quantity
            | was restored back to the purchase batch.
            */

            if ($sale && $sale->status === 'Cancelled') {
                continue;
            }


            $quantity =
                (int) $allocation->quantity;


            $fifoCost =
                (float) $allocation->cost_subtotal;


            $salesPrice =
                (float) $allocation->saleItem->price;


            $revenue =
                $quantity * $salesPrice;


            $totalSoldQuantity += $quantity;

            $totalFifoCogs += $fifoCost;

            $totalSalesRevenue += $revenue;

        }

    }


    $totalActualFifoProfit =
        $totalSalesRevenue
        -
        $totalFifoCogs;

@endphp


    <div class="row g-3 mb-4">

        {{-- Qty In --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <small class="text-muted">
                        Total Qty In
                    </small>

                    <h4 class="fw-bold mt-2 mb-0">
                        {{ number_format($totalQuantityIn) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- Reject --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <small class="text-muted">
                        Total Reject
                    </small>

                    <h4 class="fw-bold mt-2 mb-0 text-danger">
                        {{ number_format($totalReject) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- Good --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <small class="text-muted">
                        Total Good
                    </small>

                    <h4 class="fw-bold mt-2 mb-0 text-success">
                        {{ number_format($totalGood) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- Remaining --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <small class="text-muted">
                        Remaining
                    </small>

                    <h4 class="fw-bold mt-2 mb-0">
                        {{ number_format($totalRemaining) }}
                    </h4>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        FINANCIAL SUMMARY
    ========================================================== --}}
    <div class="row g-3 mb-4">

        {{-- Total Paid --}}
        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <small class="text-muted">
                        Total Purchase Cost
                    </small>

                    <h4 class="fw-bold mt-2 mb-0">
                        ₱{{ number_format($purchase->total_purchase_cost, 2) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- Remaining Cost --}}
        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <small class="text-muted">
                        Remaining Cost
                    </small>

                    <h4 class="fw-bold mt-2 mb-0">
                        ₱{{ number_format($totalRemainingCost, 2) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- Remaining Sales Value --}}
        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <small class="text-muted">
                        Remaining Sales Value
                    </small>

                    <h4 class="fw-bold mt-2 mb-0">
                        ₱{{ number_format($totalRemainingSalesValue, 2) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- Remaining Profit --}}
        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <small class="text-muted">
                        Remaining Potential Profit
                    </small>

                    <h4 class="fw-bold mt-2 mb-0 text-success">
                        ₱{{ number_format($totalRemainingPotentialProfit, 2) }}
                    </h4>

                </div>

            </div>

        </div>

    </div>
    <div class="row g-3 mb-4">

    {{-- Sold Quantity --}}
    <div class="col-lg-4 col-md-6">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body p-4">

                <small class="text-muted">
                    Sold Qty
                </small>

                <h4 class="fw-bold mt-2 mb-0">
                    {{ number_format($totalSoldQuantity) }}
                </h4>

            </div>

        </div>

    </div>


    {{-- FIFO COGS --}}
    <div class="col-lg-4 col-md-6">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body p-4">

                <small class="text-muted">
                    FIFO Cost of Goods Sold
                </small>

                <h4 class="fw-bold mt-2 mb-0">
                    ₱{{ number_format($totalFifoCogs, 2) }}
                </h4>

            </div>

        </div>

    </div>


    {{-- Actual FIFO Profit --}}
    <div class="col-lg-4 col-md-6">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body p-4">

                <small class="text-muted">
                    Actual FIFO Profit
                </small>

                <h4 class="fw-bold mt-2 mb-0 text-success">
                    ₱{{ number_format($totalActualFifoProfit, 2) }}
                </h4>

            </div>

        </div>

    </div>

</div>


    {{-- =========================================================
        PURCHASED PRODUCTS
    ========================================================== --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 p-4">

            <div>

                <h5 class="fw-bold mb-1">
                    Purchased Products
                </h5>

                <small class="text-muted">
                    Purchase batch and profitability information
                </small>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="ps-4">
                                Product
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

                            <th class="text-end">
                                SRP
                            </th>

                            <th class="text-end">
                                Profit / Item
                            </th>

                            <th class="text-center">
                                Remaining
                            </th>

                            <th class="text-end">
                                Total Paid
                            </th>

                            <th class="pe-4">
                                &nbsp;
                            </th>

                        </tr>

                    </thead>


                    <tbody>

    @forelse($purchase->purchaseItems as $item)

        @php

    $purchasePrice =
        (float) $item->purchase_price;

    $srp =
        (float) ($item->product->price ?? 0);

    $profitPerItem =
        $srp - $purchasePrice;

    $remainingCost =
        (float) $item->remaining_quantity
        *
        $purchasePrice;

    $remainingSalesValue =
        (float) $item->remaining_quantity
        *
        $srp;

    $remainingProfit =
        $remainingSalesValue
        -
        $remainingCost;


    /*
    |--------------------------------------------------------------------------
    | ACTUAL FIFO SALES FOR THIS BATCH
    |--------------------------------------------------------------------------
    */

    $batchSoldQuantity = 0;

    $batchFifoCogs = 0;

    $batchSalesRevenue = 0;


    foreach ($item->fifoAllocations as $allocation) {

        $sale = $allocation->saleItem->sale ?? null;

        // Exclude cancelled sales
        if ($sale && $sale->status === 'Cancelled') {
            continue;
        }


        $allocatedQuantity =
            (int) $allocation->quantity;

        $fifoCost =
            (float) $allocation->cost_subtotal;

        $sellingPrice =
            (float) $allocation->saleItem->price;

        $revenue =
            $allocatedQuantity * $sellingPrice;


        $batchSoldQuantity +=
            $allocatedQuantity;

        $batchFifoCogs +=
            $fifoCost;

        $batchSalesRevenue +=
            $revenue;

    }


    $batchActualProfit =
        $batchSalesRevenue
        -
        $batchFifoCogs;

@endphp


                            <tr>

                                {{-- Product --}}
                                <td class="ps-4">

                                    <div class="fw-semibold">
                                        {{ $item->product->product_name ?? 'N/A' }}
                                    </div>

                                </td>


                                {{-- Qty In --}}
                                <td class="text-center">

                                    {{ number_format($item->quantity_in) }}

                                </td>


                                {{-- Reject --}}
                                <td class="text-center">

                                    @if($item->reject_quantity > 0)

                                        <span class="text-danger fw-semibold">
                                            {{ number_format($item->reject_quantity) }}
                                        </span>

                                    @else

                                        0

                                    @endif

                                </td>


                                {{-- Good --}}
                                <td class="text-center">

                                    <span class="text-success fw-semibold">
                                        {{ number_format($item->good_quantity) }}
                                    </span>

                                </td>


                                {{-- Purchase Price --}}
                                <td class="text-end">

                                    ₱{{ number_format($purchasePrice, 2) }}

                                </td>


                                {{-- SRP --}}
                                <td class="text-end">

                                    ₱{{ number_format($srp, 2) }}

                                </td>


                                {{-- Profit / Item --}}
                                <td class="text-end">

                                    @if($profitPerItem >= 0)

                                        <span class="text-success fw-semibold">
                                            ₱{{ number_format($profitPerItem, 2) }}
                                        </span>

                                    @else

                                        <span class="text-danger fw-semibold">
                                            ₱{{ number_format($profitPerItem, 2) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Remaining --}}
                                <td class="text-center">

                                    <span class="fw-semibold">
                                        {{ number_format($item->remaining_quantity) }}
                                    </span>

                                </td>


                                {{-- Total Paid --}}
                                <td class="text-end">

                                    ₱{{
                                        number_format(
                                            $item->quantity_in
                                            * $purchasePrice,
                                            2
                                        )
                                    }}

                                </td>


                                {{-- Details --}}
                                <td class="pe-4 text-end">

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-light border"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#batch-{{ $item->id }}"
                                    >
                                        <i class="bi bi-chevron-down"></i>
                                    </button>

                                </td>

                            </tr>


                            {{-- =================================================
                                BATCH DETAILS
                            ================================================== --}}
                            <tr>

                                <td colspan="10" class="p-0 border-0">

                                    <div
                                        class="collapse bg-light"
                                        id="batch-{{ $item->id }}"
                                    >

                                        <div class="p-4">

    <div class="row g-3">

        {{-- Sold Quantity --}}
        <div class="col-lg-3 col-md-6">

            <div class="small text-muted">
                Sold Qty
            </div>

            <div class="fw-bold">
                {{ number_format($batchSoldQuantity) }}
            </div>

        </div>


        {{-- FIFO COGS --}}
        <div class="col-lg-3 col-md-6">

            <div class="small text-muted">
                FIFO COGS
            </div>

            <div class="fw-bold">
                ₱{{ number_format($batchFifoCogs, 2) }}
            </div>

        </div>


        {{-- Sales Revenue --}}
        <div class="col-lg-3 col-md-6">

            <div class="small text-muted">
                Sales Revenue
            </div>

            <div class="fw-bold">
                ₱{{ number_format($batchSalesRevenue, 2) }}
            </div>

        </div>


        {{-- Actual Profit --}}
        <div class="col-lg-3 col-md-6">

            <div class="small text-muted">
                Actual FIFO Profit
            </div>

            <div class="fw-bold text-success">
                ₱{{ number_format($batchActualProfit, 2) }}
            </div>

        </div>

    </div>


    <hr class="my-3">


    <div class="row g-3">

        {{-- Remaining Cost --}}
        <div class="col-lg-4 col-md-6">

            <div class="small text-muted">
                Remaining Cost
            </div>

            <div class="fw-semibold">
                ₱{{ number_format($remainingCost, 2) }}
            </div>

        </div>


        {{-- Remaining Sales Value --}}
        <div class="col-lg-4 col-md-6">

            <div class="small text-muted">
                Remaining Sales Value
            </div>

            <div class="fw-semibold">
                ₱{{ number_format($remainingSalesValue, 2) }}
            </div>

        </div>


        {{-- Remaining Potential Profit --}}
        <div class="col-lg-4 col-md-6">

            <div class="small text-muted">
                Remaining Potential Profit
            </div>

            <div class="fw-semibold text-success">
                ₱{{ number_format($remainingProfit, 2) }}
            </div>

        </div>

    </div>

</div>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="10"
                                    class="text-center text-muted py-5"
                                >

                                    <i class="bi bi-box-seam fs-1 d-block mb-2"></i>

                                    No purchase items found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>


                    <tfoot class="table-light">

                        <tr>

                            <th
                                colspan="8"
                                class="text-end"
                            >
                                Total Paid:
                            </th>

                            <th class="text-end">

                                ₱{{
                                    number_format(
                                        $purchase->total_purchase_cost,
                                        2
                                    )
                                }}

                            </th>

                            <th></th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection