<section class="py-5">

    <div class="container">

        <div class="row align-items-center g-5">

            <!-- LEFT SIDE -->
            <div class="col-lg-6 text-center">

                <div class="d-flex align-items-center justify-content-center py-3 py-lg-0">

                    <img
                        src="{{ asset('image/logo/mindorich-logo.png') }}"
                        class="img-fluid"
                        alt="MINDOrich Logo"
                        style="
                            max-width:350px;
                            width:100%;
                            height:auto;
                        "
                    >

                </div>

            </div>


            <!-- RIGHT SIDE -->
            <div class="col-lg-6">

                <span class="badge bg-warning text-dark px-3 py-2 mb-3">
                    ABOUT MINDOrich
                </span>

                <h2 class="fw-bold mb-4 public-about-title">

                    A Digital Platform Connecting
                    <span class="text-warning">
                        Culture,
                        Communities,
                        and Commerce
                    </span>

                </h2>

                <p class="text-secondary">

                    <strong>MINDOrich</strong> is an Indigenous Artisan Profiling
                    and E-Commerce Platform developed to preserve, promote,
                    and empower the rich cultural heritage of the Mangyan
                    communities in Oriental Mindoro.

                </p>

                <p class="text-secondary">

                    More than an online marketplace, MINDOrich serves as a
                    digital cultural hub where visitors can discover the
                    stories of the eight Mangyan tribes, explore authentic
                    handcrafted products, and learn about the artisans whose
                    skills have been passed down through generations.

                </p>

                <p class="text-secondary">

                    Through community profiling and digital commerce,
                    MINDOrich supports sustainable livelihoods while helping
                    preserve indigenous traditions for future generations.

                </p>


                <!-- Statistics -->
                <div class="row g-3 mt-4">

                    <div class="col-6">

                        <h3 class="fw-bold text-warning mb-1">
                            8
                        </h3>

                        <small class="text-muted">
                            Mangyan Tribes
                        </small>

                    </div>

                    <div class="col-6">

                        <h3 class="fw-bold text-warning mb-1">
                            100%
                        </h3>

                        <small class="text-muted">
                            Authentic Products
                        </small>

                    </div>

                </div>


                <a
                    href="/about"
                    class="btn btn-warning mt-4 px-4"
                >
                    Learn More
                </a>

            </div>

        </div>

    </div>

</section>


<style>
    .public-about-title {
        line-height: 1.2;
    }

    @media (max-width: 991.98px) {
        .public-about-title {
            font-size: 2rem;
        }
    }

    @media (max-width: 575.98px) {
        .public-about-title {
            font-size: 1.75rem;
        }

        .public-about-title span {
            display: inline;
        }

        .public-about-logo {
            max-width: 280px;
        }

        .public-about-stats small {
            font-size: 0.8rem;
        }
    }
</style>