@extends('admin.layouts.app')

@section('title', 'View Product')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Product Details
            </h2>

            <p class="text-muted mb-0">
                View information about this product.
            </p>

        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('products.edit', $product) }}"
               class="btn btn-warning">

                <i class="bi bi-pencil me-2"></i>

                Edit Product

            </a>

            <a href="{{ route('products.index') }}"
               class="btn btn-light border">

                <i class="bi bi-arrow-left me-2"></i>

                Back to Products

            </a>

        </div>

    </div>


    {{-- Product Overview --}}
    <div class="row g-4">

        {{-- Product Image --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="text-center">

                        @if($product->featured_image)

                            <img
                                src="{{ asset('storage/' . $product->featured_image) }}"
                                class="img-fluid rounded-4"
                                style="width: 100%; height: 320px; object-fit: cover;"
                                alt="{{ $product->product_name }}">

                        @else

                            <div
                                class="bg-light rounded-4 d-flex align-items-center justify-content-center"
                                style="height: 320px;">

                                <i class="bi bi-image text-muted"
                                   style="font-size: 70px;"></i>

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


        {{-- Product Information --}}
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


                    {{-- Product Details --}}
                    <div class="row g-4">

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Craftsman
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
                                Price
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

                                {{ $product->stock }}

                            </strong>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Minimum Stock
                            </small>

                            <strong>
                                {{ $product->minimum_stock }}
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


                    {{-- Inventory --}}
                    <div class="border-top mt-4 pt-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Inventory
                                </h5>

                                <p class="text-muted small mb-0">
                                    View stock movement history.
                                </p>

                            </div>

                            <a href="{{ route('products.inventory.history', $product) }}"
                               class="btn btn-info">

                                <i class="bi bi-clock-history me-2"></i>

                                Inventory History

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection