@extends('layouts.public')

@section('title', 'MINDOrich | Contact')

@section('content')

@include('partials.navbar')

<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="text-warning fw-bold text-uppercase mb-3">Contact MINDOrich</p>
                <h1 class="display-5 fw-bold mb-4">Get in touch with the MINDOrich team</h1>
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
                <a href="/" class="btn btn-warning btn-lg me-3">Back to Home</a>
                <a href="/marketplace" class="btn btn-outline-dark btn-lg">Visit Marketplace</a>
            </div>
            <div class="col-lg-6 text-center">
                <div class="bg-warning bg-opacity-10 rounded-4 p-5 shadow-sm">
                    <h2 class="fw-bold text-warning mb-3">Reach us today</h2>
                    <p class="text-secondary mb-0">
                        Contact information is shared from the existing public
                        landing content and is presented here for visitor reference.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="p-4 rounded-4 shadow-sm bg-white h-100">
                    <h3 class="fw-bold text-warning mb-3">Location</h3>
                    <p class="text-secondary mb-0">Victoria, Oriental Mindoro</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 rounded-4 shadow-sm bg-white h-100">
                    <h3 class="fw-bold text-warning mb-3">Phone</h3>
                    <p class="text-secondary mb-0">+63 XXX XXX XXXX</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 rounded-4 shadow-sm bg-white h-100">
                    <h3 class="fw-bold text-warning mb-3">Email</h3>
                    <p class="text-secondary mb-0">info@mindorich.com</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="p-5 rounded-4 shadow-sm bg-white text-center">
                    <h2 class="fw-bold mb-4">Connect with PMUI</h2>
                    <p class="text-secondary mb-4">
                        If you have questions about Mangyan products or the platform,
                        this page provides existing contact details without implying
                        live support availability.
                    </p>
                    <a href="/about" class="btn btn-warning btn-lg me-3">Learn About PMUI</a>
                    <a href="/marketplace" class="btn btn-outline-dark btn-lg">Browse Marketplace</a>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.footer')

@endsection
