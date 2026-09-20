<section class="py-5 mt-lg-5 public-hero">

    <div class="container">

        <div class="row align-items-center g-5">

            <!-- LEFT -->
            <div class="col-lg-6">

                <p class="text-warning fw-bold text-uppercase mb-3">
                    Preserving Heritage
                </p>

                <h1 class="fw-bold mb-4 public-hero-title">
                    Empowering
                    <span class="text-warning">
                        Mangyan Communities
                    </span>
                    Through Culture,
                    Craftsmanship,
                    and Digital Innovation.
                </h1>

                <p class="lead text-muted mb-4 mb-lg-5">
                    MINDOrich is the official Indigenous Artisan Profiling
                    and E-Commerce platform of Pampamayanang Mangyan Ugnayan Inc.
                    promoting authentic Mangyan craftsmanship while preserving
                    indigenous heritage.
                </p>

                <div class="d-flex flex-column flex-sm-row gap-2">

                    <a
                        href="/marketplace"
                        class="btn btn-warning btn-lg px-4"
                    >
                        Explore Marketplace
                    </a>

                    <a
                        href="/about"
                        class="btn btn-outline-dark btn-lg px-4"
                    >
                        Learn More
                    </a>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-6 text-center">

                <img
                    src="{{ asset('image/hero/hero-1.jpg') }}"
                    class="img-fluid w-100 rounded-4 shadow public-hero-image"
                    alt="Mangyan Community"
                >

            </div>

        </div>

    </div>

</section>


<style>
    .public-hero-title {
        font-size: clamp(2.3rem, 5.5vw, 4.5rem);
        line-height: 1.08;
    }

    .public-hero-image {
        max-height: 600px;
        object-fit: cover;
        object-position: center;
    }

    @media (max-width: 991.98px) {
        .public-hero {
            margin-top: 1rem;
        }

        .public-hero-title {
            font-size: clamp(2.2rem, 7vw, 3.5rem);
        }

        .public-hero-image {
            max-height: 500px;
        }
    }

    @media (max-width: 575.98px) {
        .public-hero {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }

        .public-hero-title {
            font-size: clamp(2rem, 10vw, 2.8rem);
            line-height: 1.12;
        }

        .public-hero .lead {
            font-size: 1rem;
            line-height: 1.6;
        }

        .public-hero-image {
            max-height: 350px;
        }

        .public-hero .btn {
            width: 100%;
        }
    }
</style>