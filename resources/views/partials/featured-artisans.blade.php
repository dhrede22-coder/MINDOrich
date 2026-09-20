<section class="py-5">

    <div class="container">

        <div class="text-center mb-5">

            <h6 class="text-warning fw-bold text-uppercase">
                Featured Artisans
            </h6>

            <h2 class="fw-bold mb-3">
                Meet the Hands Behind Every Craft
            </h2>

            <p class="text-secondary col-lg-8 mx-auto">
                Every handcrafted product carries a story. Meet some of the talented
                Mangyan artisans who continue to preserve indigenous traditions through
                their craftsmanship.
            </p>

        </div>


        <div class="row justify-content-center g-4">

            @forelse($producers as $producer)

                <div class="col-12 col-md-6 col-lg-4">

                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden public-artisan-card">

                        <!-- Producer Photo -->
                        @if($producer->photo)

                            <img
                                src="{{ asset('storage/' . $producer->photo) }}"
                                class="card-img-top public-artisan-image"
                                alt="{{ $producer->producer_name }}"
                            >

                        @else

                            <img
                                src="{{ asset('image/default-avatar.png') }}"
                                class="card-img-top public-artisan-image"
                                alt="{{ $producer->producer_name }}"
                            >

                        @endif


                        <div class="card-body text-center d-flex flex-column">

                            <!-- Producer Name -->
                            <h5 class="fw-bold mb-2">
                                {{ $producer->producer_name }}
                            </h5>


                            <!-- Tribe -->
                            <p class="text-warning mb-2">
                                {{ $producer->tribe?->tribe_name ?? 'Mangyan Tribe' }} Tribe
                            </p>


                            <!-- Specialization -->
                            <p class="text-secondary mb-2 public-artisan-specialization">
                                {{ $producer->specialization ?? 'Traditional Handicrafts' }}
                            </p>


                            <!-- Units Sold -->
                            <p class="text-muted small mb-3">
                                {{ number_format($producer->units_sold) }} products sold
                            </p>


                            <!-- Action -->
                            @auth

                                @if(auth()->user()->role?->name === 'Customer')

                                    <a
                                        href="{{ route('customer.shop') }}"
                                        class="btn btn-outline-warning mt-auto"
                                    >
                                        Explore Products
                                    </a>

                                @else

                                    <a
                                        href="{{ route('login') }}"
                                        class="btn btn-outline-warning mt-auto"
                                    >
                                        Login to Explore
                                    </a>

                                @endif

                            @else

                                <a
                                    href="{{ route('login') }}"
                                    class="btn btn-outline-warning mt-auto"
                                >
                                    Login to Explore
                                </a>

                            @endauth

                        </div>

                    </div>

                </div>


            @empty

                <div class="col-12">

                    <div class="text-center py-5">

                        <i class="bi bi-people fs-1 text-secondary"></i>

                        <h5 class="fw-bold mt-3">
                            No Featured Artisans Yet
                        </h5>

                        <p class="text-muted mb-0">
                            Featured artisans will appear here once completed sales are recorded.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>

    </div>

</section>


<style>
    .public-artisan-image {
        width: 100%;
        height: clamp(180px, 30vw, 220px);
        object-fit: contain;
        object-position: center;
        background: #f8f9fa;
    }

    .public-artisan-specialization {
        min-height: 2.5rem;
    }

    @media (max-width: 575.98px) {

        .public-artisan-image {
            height: 200px;
        }

        .public-artisan-card .card-body {
            padding: 1.1rem;
        }

        .public-artisan-card h5 {
            font-size: 1.05rem;
        }

        .public-artisan-specialization {
            min-height: auto;
        }

    }
</style>