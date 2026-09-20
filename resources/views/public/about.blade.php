@extends('layouts.public')

@section('title', 'About MINDOrich')

@section('content')

@include('partials.navbar')


<!-- ============================================================
     ABOUT MINDORICH HERO
============================================================ -->
<section class="py-5 public-about-hero">

    <div class="container">

        <div class="row align-items-center g-4 g-lg-5">

            <!-- LEFT -->
            <div class="col-lg-6">

                <p class="text-warning fw-bold text-uppercase mb-3">
                    About MINDOrich
                </p>

                <h1 class="fw-bold mb-4 public-about-main-title">
                    A platform for Mangyan heritage, artisan stories,
                    and mindful commerce.
                </h1>

                <p class="lead text-secondary mb-4">
                    <strong>MINDOrich</strong> is the official Indigenous Artisan Profiling
                    and E-Commerce platform of Pampamayanang Mangyan Ugnayan Inc. It
                    promotes authentic Mangyan craftsmanship while preserving indigenous
                    heritage through digital connection.
                </p>

                <div class="d-flex flex-column flex-sm-row gap-2">

                    <a
                        href="/marketplace"
                        class="btn btn-warning btn-lg px-4"
                    >
                        Visit Marketplace
                    </a>

                    <a
                        href="/"
                        class="btn btn-outline-dark btn-lg px-4"
                    >
                        Back to Home
                    </a>

                </div>

            </div>


            <!-- RIGHT -->
            <div class="col-lg-6">

                <div class="bg-warning bg-opacity-10 rounded-4 p-4 p-sm-5 shadow-sm h-100">

                    <h2 class="fw-bold text-warning mb-3">
                        Our purpose
                    </h2>

                    <p class="text-secondary mb-0">
                        MINDOrich brings Mangyan artisans and customers together by
                        showcasing handcrafted products, sharing community stories,
                        and supporting sustainable local livelihoods.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ============================================================
     ABOUT PMUI + MISSION
============================================================ -->
<section class="py-5 bg-light">

    <div class="container">

        <div class="row g-4 g-lg-5">

            <!-- ABOUT PMUI -->
            <div class="col-lg-6">

                <div class="p-4 p-md-5 rounded-4 shadow-sm bg-white h-100">

                    <span class="badge bg-warning text-dark px-3 py-2 mb-3">
                        About PMUI
                    </span>

                    <h2 class="fw-bold mb-4 public-about-section-title">
                        Pampamayanang Mangyan Ugnayan Inc.
                    </h2>

                    <p class="text-secondary mb-3">
                        Pampamayanang Mangyan Ugnayan Inc. (PMUI) is dedicated to
                        preserving the culture, traditions, and livelihoods of the
                        Mangyan communities in Mindoro through sustainable development
                        and digital innovation.
                    </p>

                    <p class="text-secondary mb-0">
                        PMUI supports indigenous artisans by creating a platform where
                        their craftsmanship is valued, their heritage is respected, and
                        their stories are shared with customers.
                    </p>

                </div>

            </div>


            <!-- MISSION -->
            <div class="col-lg-6">

                <div class="p-4 p-md-5 rounded-4 shadow-sm bg-white h-100">

                    <h2 class="fw-bold text-warning mb-4 public-about-section-title">
                        Mission & Purpose
                    </h2>

                    <p class="text-secondary mb-3">
                        Our mission is to preserve indigenous heritage for future
                        generations by empowering Mangyan artisans and promoting
                        authentic cultural products.
                    </p>

                    <p class="text-secondary mb-0">
                        Through community profiling and digital commerce, MINDOrich
                        helps sustain local livelihoods while making traditional
                        craftsmanship accessible to a wider audience.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ============================================================
     CORE VALUES / FOCUS
============================================================ -->
<section class="py-5">

    <div class="container">

        <div class="row g-4">

            <!-- Heritage -->
            <div class="col-12 col-md-6 col-lg-4">

                <div class="p-4 rounded-4 shadow-sm bg-white h-100">

                    <h3 class="fw-bold text-warning mb-3">
                        Heritage Focus
                    </h3>

                    <p class="text-secondary mb-0">
                        MINDOrich supports the preservation of Mangyan traditions through
                        storytelling, artisan profiling, and meaningful commerce.
                    </p>

                </div>

            </div>


            <!-- Community -->
            <div class="col-12 col-md-6 col-lg-4">

                <div class="p-4 rounded-4 shadow-sm bg-white h-100">

                    <h3 class="fw-bold text-warning mb-3">
                        Community Care
                    </h3>

                    <p class="text-secondary mb-0">
                        We center community impact by creating opportunities that value
                        culture, craftsmanship, and sustainable livelihoods.
                    </p>

                </div>

            </div>


            <!-- Cultural Connection -->
            <div class="col-12 col-md-6 col-lg-4">

                <div class="p-4 rounded-4 shadow-sm bg-white h-100">

                    <h3 class="fw-bold text-warning mb-3">
                        Cultural Connection
                    </h3>

                    <p class="text-secondary mb-0">
                        Visitors can discover Mangyan artistry, learn about each tribe,
                        and support authentic handmade products directly online.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ============================================================
     FINAL CTA
============================================================ -->
<section class="py-5 bg-light">

    <div class="container">

        <div class="p-4 p-md-5 rounded-4 shadow-sm bg-white text-center">

            <h2 class="fw-bold mb-4 public-about-cta-title">
                Explore more of MINDOrich
            </h2>

            <p class="text-secondary mb-4 col-lg-8 mx-auto">
                Learn more about the people, traditions, and products that make
                this platform a bridge between heritage and modern digital commerce.
            </p>

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">

                <a
                    href="/marketplace"
                    class="btn btn-warning btn-lg px-4"
                >
                    Shop Marketplace
                </a>

                <a
                    href="/"
                    class="btn btn-outline-dark btn-lg px-4"
                >
                    Return Home
                </a>

            </div>

        </div>

    </div>

</section>


<style>
    .public-about-main-title {
        font-size: clamp(2.1rem, 5vw, 3.5rem);
        line-height: 1.12;
    }

    .public-about-section-title {
        line-height: 1.2;
    }

    .public-about-cta-title {
        line-height: 1.2;
    }

    @media (max-width: 991.98px) {

        .public-about-main-title {
            font-size: clamp(2rem, 6vw, 3rem);
        }

    }

    @media (max-width: 575.98px) {

        .public-about-hero {
            padding-top: 2.5rem !important;
            padding-bottom: 2.5rem !important;
        }

        .public-about-main-title {
            font-size: 2rem;
        }

        .public-about-section-title {
            font-size: 1.75rem;
        }

        .public-about-cta-title {
            font-size: 1.75rem;
        }

    }
</style>


@include('partials.footer')

@endsection