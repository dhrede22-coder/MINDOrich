@extends('admin.layouts.app')

@section('title', 'Historical Purchase Details')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Historical Purchase Details
            </h2>

            <p class="text-muted mb-0">
                {{ $historicalPurchase->purchase_number }}
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('historical-purchases.index') }}"
               class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-1"></i>
                Back

            </a>

            <a href="{{ route('historical-purchases.edit', $historicalPurchase) }}"
               class="btn btn-primary">

                <i class="bi bi-pencil me-1"></i>
                Edit

            </a>

        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

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

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="bi bi-exclamation-circle me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Purchase Information --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white py-3">

            <h5 class="mb-0 fw-semibold">

                <i class="bi bi-file-earmark-text me-2"></i>

                Purchase Information

            </h5>

        </div>

        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-3">

                    <small class="text-muted d-block mb-1">
                        Purchase Number
                    </small>

                    <div class="fw-bold">
                        {{ $historicalPurchase->purchase_number }}
                    </div>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block mb-1">
                        Purchase Date
                    </small>

                    <div class="fw-bold">

                        {{ $historicalPurchase->purchase_date?->format('F d, Y') ?? 'N/A' }}

                    </div>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block mb-1">
                        Producer
                    </small>

                    <div class="fw-bold">

                        {{ $historicalPurchase->producer->producer_name ?? 'N/A' }}

                    </div>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block mb-1">
                        Status
                    </small>

                    <span class="badge bg-success">

                        {{ $historicalPurchase->status }}

                    </span>

                </div>

            </div>


            @if($historicalPurchase->notes)

                <div class="mt-4">

                    <small class="text-muted d-block mb-1">
                        Notes
                    </small>

                    <div>
                        {{ $historicalPurchase->notes }}
                    </div>

                </div>

            @endif

        </div>

    </div>


    {{-- Purchase Items --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white py-3">

            <h5 class="mb-0 fw-semibold">

                <i class="bi bi-box-seam me-2"></i>

                Purchase Items

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>Product</th>

                            <th class="text-center">
                                Quantity In
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

                            <th class="text-end">
                                Total
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($historicalPurchase->items as $item)

                            <tr>

                                <td class="fw-semibold">

                                    {{ $item->product->product_name ?? 'N/A' }}

                                </td>

                                <td class="text-center">

                                    {{ $item->quantity_in }}

                                </td>

                                <td class="text-center">

                                    {{ $item->reject_quantity }}

                                </td>

                                <td class="text-center">

                                    {{ $item->good_quantity }}

                                </td>

                                <td class="text-end">

                                    ₱{{ number_format($item->purchase_price, 2) }}

                                </td>

                                <td class="text-center">

                                    {{ $item->remaining_quantity }}

                                </td>

                                <td class="text-end fw-semibold">

                                    ₱{{ number_format(
                                        $item->quantity_in * $item->purchase_price,
                                        2
                                    ) }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                    <tfoot>

                        <tr>

                            <td colspan="6"
                                class="text-end fw-bold">

                                Total Purchase Cost:

                            </td>

                            <td class="text-end fw-bold">

                                ₱{{ number_format(
                                    $historicalPurchase->total_purchase_cost,
                                    2
                                ) }}

                            </td>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>


    {{-- Delete --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="fw-bold mb-1">
                        Delete Historical Purchase
                    </h6>

                    <p class="text-muted mb-0 small">
                        This action cannot be undone.
                    </p>

                </div>

                <form action="{{ route('historical-purchases.destroy', $historicalPurchase) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this historical purchase?');">

                    @csrf

                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-outline-danger">

                        <i class="bi bi-trash me-1"></i>

                        Delete Purchase

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection