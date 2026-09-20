<section class="py-5 bg-light">

    <div class="container">

        <!-- Section Title -->
        <div class="text-center mb-5">

            <h6 class="text-warning fw-bold text-uppercase">
                Featured Products
            </h6>

            <h2 class="fw-bold mb-3">
                Top Best-Selling Mangyan Handicrafts
            </h2>

            <p class="text-secondary col-lg-8 mx-auto">
                Discover some of the most loved handcrafted products from Mangyan communities.
                Every purchase helps support local producers and preserve indigenous craftsmanship.
            </p>

        </div>


        <div class="row g-4">

            @forelse($products as $product)

                @php
                    $pricing = $product->pricing();
                    $promotion = $pricing['promotion'];
                @endphp


                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden public-product-card">

                        <!-- Product Image -->
                        <div class="position-relative">

                            @if($product->featured_image)

                                <img
                                    src="{{ asset('storage/' . $product->featured_image) }}"
                                    class="card-img-top public-product-image"
                                    alt="{{ $product->product_name }}"
                                >

                            @else

                                <div class="d-flex flex-column align-items-center justify-content-center bg-light text-secondary public-product-placeholder">

                                    <i class="bi bi-image fs-1 mb-2"></i>

                                    <span>
                                        No Image Available
                                    </span>

                                </div>

                            @endif


                            <!-- Best Seller Rank -->
                            <span class="position-absolute top-0 start-0 m-2 m-sm-3 badge bg-warning text-dark px-2 px-sm-3 py-2 rounded-pill public-best-seller-badge">
                                #{{ $loop->iteration }} Best Seller
                            </span>

                        </div>


                        <div class="card-body text-center d-flex flex-column">

                            <!-- Product Name -->
                            <h5 class="fw-bold mb-2">
                                {{ $product->product_name }}
                            </h5>


                            <!-- Tribe -->
                            <p class="text-muted mb-2">
                                {{ $product->producer?->tribe?->tribe_name ?? 'Mangyan Tribe' }}
                            </p>


                            <!-- Price -->
                            @if($promotion && $pricing['effective_price'] < $pricing['original_price'])

                                <div class="d-flex flex-wrap justify-content-center align-items-center gap-1 gap-sm-2 mb-2">

                                    <span class="text-muted text-decoration-line-through">
                                        ₱{{ number_format($pricing['original_price'], 2) }}
                                    </span>

                                    <span class="text-warning fw-bold fs-5">
                                        ₱{{ number_format($pricing['effective_price'], 2) }}
                                    </span>

                                </div>


                                <div class="mb-2">

                                    <span class="badge bg-danger rounded-pill">
                                        🔥 HOT DEAL
                                    </span>

                                </div>

                            @else

                                <h5 class="text-warning fw-bold mb-2">
                                    ₱{{ number_format($pricing['effective_price'], 2) }}
                                </h5>

                            @endif


                            <!-- Units Sold -->
                            <p class="text-secondary small mb-3">
                                {{ number_format($product->units_sold) }} sold
                            </p>


                            <!-- Product Link -->
                            @auth

                                @if(auth()->user()->role?->name === 'Customer')

                                    <a
                                        href="{{ route('customer.product.show', $product) }}"
                                        class="btn btn-warning w-100 fw-semibold mt-auto"
                                    >
                                        View Details
                                    </a>

                                @else

                                    <a
                                        href="{{ route('login') }}"
                                        class="btn btn-warning w-100 fw-semibold mt-auto"
                                    >
                                        Login to View
                                    </a>

                                @endif

                            @else

                                <a
                                    href="{{ route('login') }}"
                                    class="btn btn-warning w-100 fw-semibold mt-auto"
                                >
                                    Login to View
                                </a>

                            @endauth

                        </div>

                    </div>

                </div>


            @empty

                <div class="col-12">

                    <div class="text-center py-5">

                        <i class="bi bi-box-seam fs-1 text-secondary"></i>

                        <h5 class="fw-bold mt-3">
                            No Best-Selling Products Yet
                        </h5>

                        <p class="text-muted mb-0">
                            Featured products will appear here once completed sales are recorded.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>


        <!-- Bottom CTA -->
        <div class="text-center mt-5">

            <a
                href="{{ route('login') }}"
                class="btn btn-outline-warning btn-lg px-3 px-sm-5"
            >
                Login to Shop
            </a>

        </div>

    </div>

</section>


<style>
    .public-product-image,
    .public-product-placeholder {
        width: 100%;
        height: clamp(190px, 34vw, 250px);
    }

    .public-product-image {
        object-fit: contain;
        object-position: center;
        background: #fff;
        padding: 10px;
    }

    .public-product-placeholder {
        min-height: 190px;
    }

    .public-best-seller-badge {
        font-size: 0.8rem;
    }

    @media (max-width: 575.98px) {

        .public-product-image,
        .public-product-placeholder {
            height: 210px;
        }

        .public-best-seller-badge {
            font-size: 0.7rem;
            padding: 0.35rem 0.5rem !important;
        }

        .public-product-card .card-body {
            padding: 1rem;
        }

        .public-product-card h5 {
            font-size: 1rem;
        }

    }
</style>