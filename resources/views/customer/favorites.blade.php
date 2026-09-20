@extends('customer.layouts.customer')

@section('title', 'My Favorites')

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="mb-5">
        <span class="text-uppercase small fw-semibold text-muted">
            MY COLLECTION
        </span>

        <h1 class="fw-bold mb-2">
            My Favorites
        </h1>

        <p class="text-muted mb-0">
            Products you've saved for later.
        </p>
    </div>


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


    @if($favorites->count())

        <div class="row g-4">

            @foreach($favorites as $product)

                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">

                        {{-- Image --}}
                        <div
                            class="position-relative"
                            style="height:240px;"
                        >

                            @if($product->featured_image)

                                <img
                                    src="{{ asset('storage/' . $product->featured_image) }}"
                                    alt="{{ $product->product_name }}"
                                    class="w-100 h-100"
                                    style="object-fit:cover;"
                                >

                            @else

                                <div
                                    class="w-100 h-100 bg-light d-flex align-items-center justify-content-center"
                                >
                                    <i class="bi bi-image fs-1 text-muted"></i>
                                </div>

                            @endif

                        </div>


                        {{-- Product Info --}}
                        <div class="card-body p-4">

                            <small class="text-muted">
                                {{ $product->category?->category_name ?? 'Uncategorized' }}
                            </small>

                            <h5 class="fw-bold mt-2 mb-2">
                                {{ $product->product_name }}
                            </h5>

                            <p class="text-muted small mb-3">
                                Crafted by
                                {{ $product->producer?->producer_name ?? 'Mangyan Producer' }}
                            </p>

                            <div class="fw-bold fs-5 mb-3">
                                ₱{{ number_format($product->price, 2) }}
                            </div>


                            {{-- Actions --}}
                            <div class="d-flex gap-2">

                                <a
                                    href="{{ route('customer.product.show', $product) }}"
                                    class="btn btn-warning flex-grow-1"
                                >
                                    <i class="bi bi-eye me-1"></i>
                                    View Product
                                </a>

                                <form
                                    action="{{ route('customer.favorites.toggle', $product) }}"
                                    method="POST"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger"
                                        title="Remove from favorites"
                                        aria-label="Remove from favorites"
                                    >
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body text-center py-5">

                <i class="bi bi-heart fs-1 text-muted"></i>

                <h4 class="fw-bold mt-3">
                    No Favorites Yet
                </h4>

                <p class="text-muted mb-4">
                    Save products you like and find them here later.
                </p>

                <a
                    href="{{ route('customer.shop') }}"
                    class="btn btn-warning px-4"
                >
                    <i class="bi bi-shop me-1"></i>
                    Browse Products
                </a>

            </div>

        </div>

    @endif

</div>

@endsection