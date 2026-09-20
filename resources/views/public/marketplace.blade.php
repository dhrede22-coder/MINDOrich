@extends('layouts.public')

@section('title', 'MINDOrich | Marketplace')

@section('content')

@include('partials.navbar')


<!-- ============================================================
     MARKETPLACE HERO
============================================================ -->
<section class="py-5 public-marketplace-hero">

    <div class="container">

        <div class="row align-items-center g-4 g-lg-5">

            <!-- LEFT -->
            <div class="col-lg-6">

                <p class="text-warning fw-bold text-uppercase mb-3">
                    MINDOrich Marketplace
                </p>

                <h1 class="fw-bold mb-4 public-marketplace-title">
                    Discover authentic Mangyan crafts and cultural keepsakes.
                </h1>

                <p class="lead text-secondary mb-4">
                    Explore a curated showcase of traditional Mangyan artistry,
                    handcrafted by indigenous communities in Mindoro. This page
                    presents an introductory view of the kinds of products you can
                    expect from MINDOrich.
                </p>

                <div class="d-flex flex-column flex-sm-row gap-2">

                    <a
                        href="/"
                        class="btn btn-warning btn-lg px-4"
                    >
                        Back to Home
                    </a>

                    <a
                        href="/about"
                        class="btn btn-outline-dark btn-lg px-4"
                    >
                        Learn About PMUI
                    </a>

                </div>

            </div>


            <!-- RIGHT -->
            <div class="col-lg-6">

                <div class="bg-warning bg-opacity-10 rounded-4 p-4 p-sm-5 shadow-sm h-100">

                    <h2 class="fw-bold text-warning mb-3 public-marketplace-card-title">
                        Support heritage makers
                    </h2>

                    <p class="text-secondary mb-0">
                        The MINDOrich Marketplace celebrates traditional craftsmanship,
                        sustainable culture, and community-driven artisan stories.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ============================================================
     MARKETPLACE SHOWCASE
============================================================ -->
<section class="py-5 bg-light">

    <div class="container">

        <div class="text-center mb-5">

            <h2 class="fw-bold">
                Marketplace Showcase
            </h2>

            <p class="text-secondary mx-auto col-lg-8">
                This introductory showcase highlights the types of handmade products
                found in the MINDOrich community. These sample cards are illustrative
                only and are not pulled from the live product catalog.
            </p>

        </div>


        <div class="row g-4">

            <!-- Product 1 -->
            <div class="col-12 col-md-6 col-lg-4">

                <div class="card h-100 border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <span class="badge bg-warning text-dark mb-3">
                            Sample Showcase
                        </span>

                        <h5 class="fw-bold">
                            Handwoven Basket
                        </h5>

                        <p class="text-secondary">
                            A traditional Mangyan woven basket made
                            with natural fibers, ideal for home display or daily use.
                        </p>

                        <p class="small text-muted mb-0">
                            Representative showcase only.
                        </p>

                    </div>

                </div>

            </div>


            <!-- Product 2 -->
            <div class="col-12 col-md-6 col-lg-4">

                <div class="card h-100 border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <span class="badge bg-warning text-dark mb-3">
                            Sample Showcase
                        </span>

                        <h5 class="fw-bold">
                            Traditional Textile
                        </h5>

                        <p class="text-secondary">
                            A handcrafted textile inspired by
                            Mangyan patterns and cultural heritage.
                        </p>

                        <p class="small text-muted mb-0">
                            Representative showcase only.
                        </p>

                    </div>

                </div>

            </div>


            <!-- Product 3 -->
            <div class="col-12 col-md-6 col-lg-4">

                <div class="card h-100 border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <span class="badge bg-warning text-dark mb-3">
                            Sample Showcase
                        </span>

                        <h5 class="fw-bold">
                            Artisan Keepsake
                        </h5>

                        <p class="text-secondary">
                            A small handcrafted item representing
                            local Mangyan tradition and craftsmanship.
                        </p>

                        <p class="small text-muted mb-0">
                            Representative showcase only.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ============================================================
     FINAL CTA
============================================================ -->
<section class="py-5">

    <div class="container">

        <div class="p-4 p-md-5 rounded-4 shadow-sm bg-white text-center">

            <h2 class="fw-bold mb-4 public-marketplace-cta-title">
                Browse via the platform
            </h2>

            <p class="text-secondary mb-4 col-lg-8 mx-auto">
                While this page offers a visual introduction, MINDOrich is designed
                to highlight cultural authenticity and support Mangyan artisans.
            </p>

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">

                <a
                    href="/"
                    class="btn btn-warning btn-lg px-4"
                >
                    Return Home
                </a>

                <a
                    href="/contact"
                    class="btn btn-outline-dark btn-lg px-4"
                >
                    Contact PMUI
                </a>

            </div>

        </div>

    </div>

</section>


<style>
    .public-marketplace-title {
        font-size: clamp(2.1rem, 5vw, 3.5rem);
        line-height: 1.12;
    }

    .public-marketplace-card-title {
        line-height: 1.2;
    }

    .public-marketplace-cta-title {
        line-height: 1.2;
    }

    @media (max-width: 991.98px) {

        .public-marketplace-title {
            font-size: clamp(2rem, 6vw, 3rem);
        }

    }

    @media (max-width: 575.98px) {

        .public-marketplace-hero {
            padding-top: 2.5rem !important;
            padding-bottom: 2.5rem !important;
        }

        .public-marketplace-title {
            font-size: 2rem;
        }

        .public-marketplace-card-title {
            font-size: 1.75rem;
        }

        .public-marketplace-cta-title {
            font-size: 1.75rem;
        }

        .public-marketplace-hero .lead {
            font-size: 1rem;
            line-height: 1.6;
        }

    }
</style>


@include('partials.footer')

@endsection