@extends('customer.layouts.customer')

@section('title', 'Order Details')

@section('content')

<div class="container py-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>
        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
@endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold mb-1">Order Details</h1>

            <p class="text-muted mb-0">
                {{ $sale->sale_number }}
            </p>
        </div>

        <a
            href="{{ route('customer.orders') }}"
            class="btn btn-outline-secondary"
        >
            ← Back to Orders
        </a>

    </div>

    <div class="row g-4">

        {{-- Order Information --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h4 class="fw-bold mb-0">
                            Ordered Products
                        </h4>

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

                    @foreach($sale->saleItems as $item)

                        <div class="d-flex align-items-center border-bottom py-3">

                            {{-- Product Image --}}
                            @if($item->product?->featured_image)

                                <img
                                    src="{{ asset('storage/' . $item->product->featured_image) }}"
                                    alt="{{ $item->product->product_name }}"
                                    class="rounded-3 me-3"
                                    style="width:90px;height:90px;object-fit:cover;"
                                >

                            @else

                                <div
                                    class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3"
                                    style="width:90px;height:90px;"
                                >
                                    <span class="text-muted small">
                                        No Image
                                    </span>
                                </div>

                            @endif

                            {{-- Product Details --}}
                            <div class="flex-grow-1">

                                <h6 class="fw-bold mb-1">
                                    {{ $item->product?->product_name ?? 'Product unavailable' }}
                                </h6>

                                <p class="text-muted mb-1">
                                    ₱{{ number_format($item->price, 2) }}
                                    ×
                                    {{ $item->quantity }}
                                </p>

                                @if(
    $sale->sale_type === 'Online' &&
    $sale->status === 'Delivered' &&
    !$item->review()->exists()
)
    <form
        action="{{ route('customer.reviews.store', $item) }}"
        method="POST"
        class="mt-3"
    >
        @csrf

        <div class="mb-2">
            <label class="form-label fw-semibold mb-1">
                Rate this product
            </label>

            <div>
                @for($rating = 1; $rating <= 5; $rating++)
                    <label class="me-2">
                        <input
                            type="radio"
                            name="rating"
                            value="{{ $rating }}"
                            required
                        >
                        {{ $rating }} ★
                    </label>
                @endfor
            </div>
        </div>

        <div class="mb-2">
            <textarea
                name="body"
                class="form-control"
                rows="2"
                maxlength="2000"
                placeholder="Write a review (optional)..."
            >{{ old('body') }}</textarea>
        </div>

        <button
            type="submit"
            class="btn btn-sm btn-dark"
        >
            <i class="bi bi-star me-1"></i>
            Submit Review
        </button>
    </form>
@endif

                            </div>

                            {{-- Subtotal --}}
                            <div class="text-end">

                                <strong>
                                    ₱{{ number_format($item->subtotal, 2) }}
                                </strong>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

        {{-- Order Summary --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h4 class="fw-bold mb-4">
                        Order Summary
                    </h4>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Order Number
                        </span>

                        <strong>
                            {{ $sale->sale_number }}
                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Date
                        </span>

                        <span>
                            {{ $sale->created_at->format('M d, Y') }}
                        </span>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Payment Method
                        </span>

                        <strong>
                            {{ $sale->payment_method }}
                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Payment Status
                        </span>

                        <span class="badge
                            @if($sale->payment_status === 'Paid')
                                bg-success
                            @else
                                bg-warning text-dark
                            @endif
                        ">
                            {{ $sale->payment_status }}
                        </span>

                    </div>

                    @if(
                        $sale->payment_method === 'GCash' &&
                        $sale->payment_status === 'Failed'
                    )
                        <div class="mt-3">

                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                Your GCash payment was rejected. Please submit a new
                                reference number and proof of payment.
                            </div>

                            <form
                                action="{{ route('customer.order.gcash.resubmit', $sale) }}"
                                method="POST"
                                enctype="multipart/form-data"
                            >
                                @csrf
                                @method('PATCH')

                                <div class="mb-3">
                                    <label
                                        for="gcash_reference"
                                        class="form-label fw-semibold"
                                    >
                                        New GCash Reference Number
                                    </label>

                                    <input
                                        type="text"
                                        name="gcash_reference"
                                        id="gcash_reference"
                                        class="form-control"
                                        value="{{ old('gcash_reference') }}"
                                        maxlength="100"
                                        required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label
                                        for="gcash_proof"
                                        class="form-label fw-semibold"
                                    >
                                        New Proof of Payment
                                    </label>

                                    <input
                                        type="file"
                                        name="gcash_proof"
                                        id="gcash_proof"
                                        class="form-control"
                                        accept="image/png,image/jpeg,image/webp"
                                        required
                                    >

                                    <div class="form-text">
                                        JPG, PNG, or WebP. Maximum 2 MB.
                                    </div>
                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    <i class="bi bi-upload me-2"></i>
                                    Resubmit Payment
                                </button>

                            </form>

                        </div>
                    @endif

                    <hr>

                    <div class="d-flex justify-content-between">

                        <span class="fw-bold">
                            Total
                        </span>

                        <strong class="text-warning fs-4">
                            ₱{{ number_format($sale->total_amount, 2) }}
                        </strong>

                    </div>

                </div>

            </div>

            {{-- Notes --}}
            @if($sale->notes)

                <div class="card border-0 shadow-sm rounded-4 mt-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-2">
                            Order Notes
                        </h5>

                        <p class="text-muted mb-0">
                            {{ $sale->notes }}
                        </p>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection