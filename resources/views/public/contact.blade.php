@extends('layouts.public')

@section('title', 'MINDOrich | Contact')

@section('content')

@include('partials.navbar')


<!-- ============================================================
     CONTACT HERO
============================================================ -->
<section class="py-5 public-contact-hero">

    <div class="container">

        <div class="row align-items-center g-4 g-lg-5">

            <!-- LEFT -->
            <div class="col-lg-6">

                <p class="text-warning fw-bold text-uppercase mb-3">
                    Contact MINDOrich
                </p>

                <h1 class="fw-bold mb-4 public-contact-title">
                    Get in touch with the MINDOrich team
                </h1>

                <p class="lead text-secondary mb-4">
                    We welcome visitors who want to learn more about the Mangyan
                    communities, authentic craftsmanship, and the purpose behind
                    the MINDOrich platform.
                </p>

                <p class="text-secondary mb-4">
                    For questions about the platform, artisan collaborations, or
                    cultural heritage, please reach out using the contact details
                    below.
                </p>

                <div class="d-flex flex-column flex-sm-row gap-2">

                    <a
                        href="/"
                        class="btn btn-warning btn-lg px-4"
                    >
                        Back to Home
                    </a>

                    <a
                        href="/marketplace"
                        class="btn btn-outline-dark btn-lg px-4"
                    >
                        Visit Marketplace
                    </a>

                </div>

            </div>


            <!-- RIGHT -->
            <div class="col-lg-6">

                <div class="bg-warning bg-opacity-10 rounded-4 p-4 p-sm-5 shadow-sm h-100">

                    <h2 class="fw-bold text-warning mb-3 public-contact-card-title">
                        Reach us today
                    </h2>

                    <p class="text-secondary mb-0">
                        Contact information is shared from the existing public
                        landing content and is presented here for visitor reference.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ============================================================
     CONTACT INFORMATION
============================================================ -->
<section class="py-5 bg-light">

    <div class="container">

        <div class="row g-4">

            <!-- Location -->
            <div class="col-12 col-md-6 col-lg-4">

                <div class="p-4 rounded-4 shadow-sm bg-white h-100">

                    <h3 class="fw-bold text-warning mb-3">
                        Location
                    </h3>

                    <p class="text-secondary mb-0">
                        Victoria, Oriental Mindoro
                    </p>

                </div>

            </div>


            <!-- Phone -->
            <div class="col-12 col-md-6 col-lg-4">

                <div class="p-4 rounded-4 shadow-sm bg-white h-100">

                    <h3 class="fw-bold text-warning mb-3">
                        Phone
                    </h3>

                    <p class="text-secondary mb-0">
                        +63 XXX XXX XXXX
                    </p>

                </div>

            </div>


            <!-- Email -->
            <div class="col-12 col-md-6 col-lg-4">

                <div class="p-4 rounded-4 shadow-sm bg-white h-100">

                    <h3 class="fw-bold text-warning mb-3">
                        Email
                    </h3>

                    <p class="text-secondary mb-0">
                        info@mindorich.com
                    </p>

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

        <div class="row justify-content-center">

            <div class="col-12 col-lg-8">

                <div class="p-4 p-md-5 rounded-4 shadow-sm bg-white text-center">

                    <h2 class="fw-bold mb-4 public-contact-cta-title">
                        Connect with PMUI
                    </h2>

                    <p class="text-secondary mb-4">
                        If you have questions about Mangyan products or the platform,
                        this page provides existing contact details without implying
                        live support availability.
                    </p>

                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">

                        <a
                            href="/about"
                            class="btn btn-warning btn-lg px-4"
                        >
                            Learn About PMUI
                        </a>

                        <a
                            href="/marketplace"
                            class="btn btn-outline-dark btn-lg px-4"
                        >
                            Browse Marketplace
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<style>
    .public-contact-title {
        font-size: clamp(2.1rem, 5vw, 3.5rem);
        line-height: 1.12;
    }

    .public-contact-card-title,
    .public-contact-cta-title {
        line-height: 1.2;
    }

    @media (max-width: 991.98px) {

        .public-contact-title {
            font-size: clamp(2rem, 6vw, 3rem);
        }

    }

    @media (max-width: 575.98px) {

        .public-contact-hero {
            padding-top: 2.5rem !important;
            padding-bottom: 2.5rem !important;
        }

        .public-contact-title {
            font-size: 2rem;
        }

        .public-contact-card-title,
        .public-contact-cta-title {
            font-size: 1.75rem;
        }

        .public-contact-hero .lead {
            font-size: 1rem;
            line-height: 1.6;
        }

    }
</style>


@include('partials.footer')

@endsection