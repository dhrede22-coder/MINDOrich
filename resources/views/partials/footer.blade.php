<footer class="bg-dark text-white pt-5 pb-3 public-footer">

    <div class="container">

        <div class="row gy-4">

            <!-- Logo & About -->
            <div class="col-12 col-sm-6 col-lg-4">

                <div class="d-flex align-items-center mb-3">

                    <img
                        src="{{ asset('image/logo/mindorich-logo.png') }}"
                        alt="MINDOrich Logo"
                        class="me-2 public-footer-logo"
                    >

                    <div>

                        <h4 class="fw-bold text-warning mb-0">
                            INDOrich
                        </h4>

                        <small class="public-footer-subtitle">
                            Pampamayanang Mangyan Ugnayan Inc.
                        </small>

                    </div>

                </div>

                <p class="text-light mb-0">

                    MINDOrich is an Indigenous Artisan Profiling and
                    E-Commerce Platform dedicated to preserving Mangyan
                    culture while empowering local artisans through
                    sustainable digital commerce.

                </p>

            </div>


            <!-- Quick Links -->
            <div class="col-6 col-sm-6 col-lg-2">

                <h5 class="text-warning mb-3">
                    Quick Links
                </h5>

                <ul class="list-unstyled public-footer-links">

                    <li>
                        <a href="/" class="text-white text-decoration-none">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="/about" class="text-white text-decoration-none">
                            About PMUI
                        </a>
                    </li>

                    <li>
                        <a href="/tribes" class="text-white text-decoration-none">
                            Mangyan Tribes
                        </a>
                    </li>

                    <li>
                        <a href="/marketplace" class="text-white text-decoration-none">
                            Marketplace
                        </a>
                    </li>

                </ul>

            </div>


            <!-- Explore -->
            <div class="col-6 col-sm-6 col-lg-3">

                <h5 class="text-warning mb-3">
                    Explore
                </h5>

                <ul class="list-unstyled public-footer-links">

                    <li>
                        Featured Products
                    </li>

                    <li>
                        Featured Artisans
                    </li>

                    <li>
                        Community Impact
                    </li>

                    <li>
                        Latest News
                    </li>

                </ul>

            </div>


            <!-- Contact -->
            <div class="col-12 col-sm-6 col-lg-3">

                <h5 class="text-warning mb-3">
                    Contact
                </h5>

                <p class="mb-2">
                    📍 Victoria, Oriental Mindoro
                </p>

                <p class="mb-2">
                    📞 +63 XXX XXX XXXX
                </p>

                <p class="mb-2">
                    ✉️ info@mindorich.com
                </p>

                <p class="mb-0">
                    🌐 Facebook: PMUI
                </p>

            </div>

        </div>


        <hr class="border-secondary my-4">


        <div class="text-center">

            <small>

                © {{ date('Y') }}
                <strong>MINDOrich</strong>.
                All Rights Reserved.

                <br>

                Developed for Pampamayanang Mangyan Ugnayan Inc.

            </small>

        </div>

    </div>

</footer>


<style>
    .public-footer-logo {
        width: 55px;
        height: auto;
        flex-shrink: 0;
    }

    .public-footer-subtitle {
        line-height: 1.2;
    }

    .public-footer-links li {
        margin-bottom: 0.65rem;
    }

    .public-footer-links li:last-child {
        margin-bottom: 0;
    }

    @media (max-width: 575.98px) {

        .public-footer-logo {
            width: 48px;
        }

        .public-footer h4 {
            font-size: 1.25rem;
        }

        .public-footer-subtitle {
            font-size: 0.7rem;
        }

        .public-footer h5 {
            font-size: 1rem;
        }

        .public-footer p,
        .public-footer li {
            font-size: 0.9rem;
        }

    }
</style>