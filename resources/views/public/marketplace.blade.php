@extends('layouts.public')

@section('title', 'MINDOrich | Marketplace')

@section('content')

@include('partials.navbar')

<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="text-warning fw-bold text-uppercase mb-3">MINDOrich Marketplace</p>
                <h1 class="display-5 fw-bold mb-4">
                    Discover authentic Mangyan crafts and cultural keepsakes.
                </h1>
                <p class="lead text-secondary mb-4">
                    Explore a curated showcase of traditional Mangyan artistry,
                    handcrafted by indigenous communities in Mindoro. This page
                    presents an introductory view of the kinds of products you can
                    expect from MINDOrich.
                </p>
                <a href="/" class="btn btn-warning btn-lg me-3">Back to Home</a>
                <a href="/about" class="btn btn-outline-dark btn-lg">Learn About PMUI</a>
            </div>
            <div class="col-lg-6 text-center">
                <div class="bg-warning bg-opacity-10 rounded-4 p-5 shadow-sm">
                    <h2 class="fw-bold text-warning mb-3">Support heritage makers</h2>
                    <p class="text-secondary mb-0">
                        The MINDOrich Marketplace celebrates traditional craftsmanship,
                        sustainable culture, and community-driven artisan stories.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Marketplace Showcase</h2>
            <p class="text-secondary mx-auto col-lg-8">
                This introductory showcase highlights the types of handmade products
                found in the MINDOrich community. These sample cards are illustrative
                only and are not pulled from the live product catalog.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-3">Sample Showcase</span>
                        <h5 class="fw-bold">Handwoven Basket</h5>
                        <p class="text-secondary">A traditional Mangyan woven basket made
                            with natural fibers, ideal for home display or daily use.</p>
                        <p class="small text-muted mb-0">Representative showcase only.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-3">Sample Showcase</span>
                        <h5 class="fw-bold">Traditional Textile</h5>
                        <p class="text-secondary">A handcrafted textile inspired by
                            Mangyan patterns and cultural heritage.</p>
                        <p class="small text-muted mb-0">Representative showcase only.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-3">Sample Showcase</span>
                        <h5 class="fw-bold">Artisan Keepsake</h5>
                        <p class="text-secondary">A small handcrafted item representing
                            local Mangyan tradition and craftsmanship.</p>
                        <p class="small text-muted mb-0">Representative showcase only.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container text-center">
        <div class="p-5 rounded-4 shadow-sm bg-white">
            <h2 class="fw-bold mb-4">Browse via the platform</h2>
            <p class="text-secondary mb-4">
                While this page offers a visual introduction, MINDOrich is designed
                to highlight cultural authenticity and support Mangyan artisans.
            </p>
            <a href="/" class="btn btn-warning btn-lg me-3">Return Home</a>
            <a href="/contact" class="btn btn-outline-dark btn-lg">Contact PMUI</a>
        </div>
    </div>
</section>

@include('partials.footer')

@endsection
