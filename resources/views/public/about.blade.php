@extends('layouts.public')

@section('title', 'About MINDOrich')

@section('content')

@include('partials.navbar')

<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="text-warning fw-bold text-uppercase mb-3">About MINDOrich</p>
                <h1 class="display-5 fw-bold mb-4">
                    A platform for Mangyan heritage, artisan stories, and mindful commerce.
                </h1>
                <p class="lead text-secondary mb-4">
                    <strong>MINDOrich</strong> is the official Indigenous Artisan Profiling
                    and E-Commerce platform of Pampamayanang Mangyan Ugnayan Inc. It
                    promotes authentic Mangyan craftsmanship while preserving indigenous
                    heritage through digital connection.
                </p>
                <a href="/marketplace" class="btn btn-warning btn-lg me-3">Visit Marketplace</a>
                <a href="/" class="btn btn-outline-dark btn-lg">Back to Home</a>
            </div>
            <div class="col-lg-6 text-center">
                <div class="bg-warning bg-opacity-10 rounded-4 p-5 shadow-sm">
                    <h2 class="fw-bold text-warning mb-3">Our purpose</h2>
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

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="p-4 rounded-4 shadow-sm bg-white h-100">
                    <span class="badge bg-warning text-dark px-3 py-2 mb-3">About PMUI</span>
                    <h2 class="fw-bold mb-4">Pampamayanang Mangyan Ugnayan Inc.</h2>
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
            <div class="col-lg-6">
                <div class="p-4 rounded-4 shadow-sm bg-white h-100">
                    <h2 class="fw-bold text-warning mb-4">Mission & Purpose</h2>
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

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="p-4 rounded-4 shadow-sm bg-white h-100">
                    <h3 class="fw-bold text-warning">Heritage Focus</h3>
                    <p class="text-secondary mb-0">
                        MINDOrich supports the preservation of Mangyan traditions through
                        storytelling, artisan profiling, and meaningful commerce.
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 rounded-4 shadow-sm bg-white h-100">
                    <h3 class="fw-bold text-warning">Community Care</h3>
                    <p class="text-secondary mb-0">
                        We center community impact by creating opportunities that value
                        culture, craftsmanship, and sustainable livelihoods.
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 rounded-4 shadow-sm bg-white h-100">
                    <h3 class="fw-bold text-warning">Cultural Connection</h3>
                    <p class="text-secondary mb-0">
                        Visitors can discover Mangyan artistry, learn about each tribe,
                        and support authentic handmade products directly online.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container text-center">
        <div class="p-5 rounded-4 shadow-sm bg-white">
            <h2 class="fw-bold mb-4">Explore more of MINDOrich</h2>
            <p class="text-secondary mb-4">
                Learn more about the people, traditions, and products that make
                this platform a bridge between heritage and modern digital commerce.
            </p>
            <a href="/marketplace" class="btn btn-warning btn-lg me-3">Shop Marketplace</a>
            <a href="/" class="btn btn-outline-dark btn-lg">Return Home</a>
        </div>
    </div>
</section>

@include('partials.footer')

@endsection
