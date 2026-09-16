@extends('customer.layouts.customer')

@section('title', 'Home')

@section('content')

{{-- =========================================================
     HOME / HERO
========================================================= --}}
<div class="customer-hero">

    {{-- Hero Image --}}
    <img
        src="{{ asset('image/hero/basket3.jpg') }}"
        alt="Mangyan Handicrafts"
        class="customer-hero-image"
    >

    {{-- Hero Content --}}
    <div class="customer-hero-content">

        <div class="customer-hero-badge">
            Welcome to MINDOrich
        </div>


        <h1 class="customer-hero-title">

            Welcome back,

            <span class="hero-name">
                {{ auth()->user()->name }}!
            </span>

        </h1>


        <div class="customer-hero-divider">
            <span>✦</span>
        </div>


        <p class="customer-hero-description">
            Discover authentic Mangyan artisan products,
            celebrate indigenous craftsmanship, and support
            local makers from Mindoro.
        </p>


        {{-- Buttons --}}
        <div class="customer-hero-buttons">

            <a
                href="{{ route('customer.shop') }}"
                class="customer-hero-btn customer-hero-btn-primary"
            >
                <i class="bi bi-bag me-2"></i>
                Shop Now
            </a>


            <a
                href="{{ route('public.tribes') }}"
                class="customer-hero-btn customer-hero-btn-secondary"
            >
                <i class="bi bi-people me-2"></i>
                Meet Our Artisans
            </a>

        </div>


        {{-- Features --}}
        <div class="customer-hero-features">

            <div class="customer-hero-feature">

                <i class="bi bi-flower1 customer-hero-feature-icon"></i>

                <div class="customer-hero-feature-text">
                    <strong>Authentic</strong>
                    Handcrafted
                </div>

            </div>


            <div class="customer-hero-feature">

                <i class="bi bi-shield-check customer-hero-feature-icon"></i>

                <div class="customer-hero-feature-text">
                    <strong>Support Local</strong>
                    Communities
                </div>

            </div>


            <div class="customer-hero-feature">

                <i class="bi bi-heart customer-hero-feature-icon"></i>

                <div class="customer-hero-feature-text">
                    <strong>Made with</strong>
                    Heritage
                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     ABOUT MINDORICH
========================================================= --}}
<section id="about-mindorich" class="py-5">
    <div class="container py-lg-4">

        {{-- Section Header --}}
        <div class="text-center mb-5">

            <span class="section-label">
                ABOUT MINDOrich
            </span>

            <h2 class="fw-bold mt-2 mb-3">
                Where Culture, Community, and Craft Come Together
            </h2>

            <p class="text-muted mx-auto mb-0" style="max-width: 720px;">
                MINDOrich connects the rich cultural heritage of the Mangyan
                communities with people who value authentic indigenous
                craftsmanship.
            </p>

        </div>


        {{-- Main About Content --}}
        <div class="row align-items-stretch g-4">

            {{-- Left Content --}}
            <div class="col-lg-6">

                <div class="about-box h-100">

                    <div class="about-icon">
                        <i class="bi bi-flower1"></i>
                    </div>

                    <span class="section-label">
                        OUR PURPOSE
                    </span>

                    <h3 class="fw-bold mt-2 mb-3">
                        Preserving Heritage Through Opportunity
                    </h3>

                    <p class="text-muted mb-3">
                        MINDOrich is a digital platform created to help
                        showcase Mangyan culture, communities, and
                        traditional craftsmanship.
                    </p>

                    <p class="text-muted mb-4">
                        Through the platform, customers can discover
                        authentic products while local producers gain a
                        wider space to share their skills, stories, and
                        handcrafted products.
                    </p>

                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-warning"></i>

                        <span class="small fw-semibold text-dark">
                            Supporting local producers and preserving
                            cultural heritage
                        </span>
                    </div>

                </div>

            </div>


            {{-- Right Side --}}
            <div class="col-lg-6">

                <div class="row g-3 h-100">

                    {{-- Cultural Heritage --}}
                    <div class="col-12">

                        <div class="about-highlight h-100">

                            <div class="d-flex align-items-start gap-3">

                                <div class="about-icon mb-0 flex-shrink-0">
                                    <i class="bi bi-book"></i>
                                </div>

                                <div>

                                    <h5 class="fw-bold mb-2">
                                        Cultural Heritage
                                    </h5>

                                    <p class="text-muted mb-0 small">
                                        Discover the traditions, identity,
                                        and craftsmanship of the eight
                                        Mangyan tribes of Mindoro.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Community --}}
                    <div class="col-md-6">

                        <div class="about-stat h-100 text-start">

                            <div class="about-icon mb-3">
                                <i class="bi bi-people"></i>
                            </div>

                            <h5 class="fw-bold mb-2">
                                Community
                            </h5>

                            <p class="text-muted small mb-0">
                                Connecting customers with local producers
                                and their communities.
                            </p>

                        </div>

                    </div>


                    {{-- Marketplace --}}
                    <div class="col-md-6">

                        <div class="about-stat h-100 text-start">

                            <div class="about-icon mb-3">
                                <i class="bi bi-bag-heart"></i>
                            </div>

                            <h5 class="fw-bold mb-2">
                                Marketplace
                            </h5>

                            <p class="text-muted small mb-0">
                                Giving authentic Mangyan products a wider
                                place to be discovered and appreciated.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Mission Strip --}}
        <div class="about-highlight mt-4">

            <div class="row align-items-center g-3">

                <div class="col-lg-2 text-lg-center">

                    <div class="about-icon mb-0 mx-lg-auto">
                        <i class="bi bi-heart-fill"></i>
                    </div>

                </div>

                <div class="col-lg-10">

                    <span class="section-label">
                        OUR MISSION
                    </span>

                    <p class="fw-semibold mb-1 mt-1">
                        To promote Mangyan products and indigenous
                        craftsmanship while creating meaningful opportunities
                        for local producers.
                    </p>

                    <p class="text-muted small mb-0">
                        MINDOrich aims to bring culture closer to people
                        while helping preserve the traditions and identity
                        of the Mangyan communities.
                    </p>

                </div>

            </div>

        </div>

    </div>
</section>


{{-- =========================================================
     8 MANGYAN TRIBES
========================================================= --}}
<section id="tribes" class="py-5 tribes-section">
    <div class="container py-lg-4">

        <div class="text-center mb-5">
            <span class="section-label">OUR COMMUNITIES</span>

            <h2 class="fw-bold mt-2">
                Discover the 8 Mangyan Tribes
            </h2>

            <p class="text-muted mx-auto" style="max-width:700px;">
                Explore the unique traditions, stories, and craftsmanship
                preserved by the eight Mangyan tribes of Mindoro.
            </p>
        </div>

        @php
            $tribes = [
                [
                    'name' => 'Iraya',
                    'slug' => 'iraya',
                    'image' => 'iraya.jpg',
                    'desc' => 'Known for basket weaving and traditional craftsmanship.',
                    'history' => 'The Iraya are one of the eight recognized Mangyan groups of Mindoro. Their communities have maintained a distinct language, traditions, and cultural identity in northern Mindoro.',
                    'location' => 'Northern Mindoro',
                    'heritage' => 'Their heritage includes traditional knowledge, community practices, language, and craftsmanship passed through generations.'
                ],
                [
                    'name' => 'Alangan',
                    'slug' => 'alangan',
                    'image' => 'alangan.jpg',
                    'desc' => 'Recognized for their rich oral traditions and indigenous arts.',
                    'history' => 'The Alangan are one of the eight recognized Mangyan groups of Mindoro. They maintain their own language and cultural traditions and a long connection with their ancestral communities.',
                    'location' => 'Central and northern Mindoro',
                    'heritage' => 'Their heritage includes oral traditions, farming knowledge, indigenous arts, language, and community practices.'
                ],
                [
                    'name' => 'Tadyawan',
                    'slug' => 'tadyawan',
                    'image' => 'tadyawan.jpg',
                    'desc' => 'Preserves farming traditions and cultural heritage.',
                    'history' => 'The Tadyawan are one of the eight indigenous groups of Mindoro. They have preserved a distinct language and cultural identity while adapting to changes in their communities.',
                    'location' => 'Eastern and northeastern Mindoro',
                    'heritage' => 'Tadyawan heritage is reflected in language, farming knowledge, community traditions, and connections to ancestral lands.'
                ],
                [
                    'name' => 'Tau-buid',
                    'slug' => 'tau-buid',
                    'image' => 'taubuid.jpg',
                    'desc' => 'Known for their deep connection with the forests of Mindoro.',
                    'history' => 'The Tau-buid, also written Tawbuid, are one of the eight Mangyan ethnolinguistic groups of Mindoro. Their communities have traditionally lived in upland areas and maintain distinctive cultural practices.',
                    'location' => 'Central and western Mindoro',
                    'heritage' => 'Their heritage includes upland environmental knowledge, community traditions, language, and a connection to ancestral territory.'
                ],
                [
                    'name' => 'Hanunuo',
                    'slug' => 'hanunuo',
                    'image' => 'hanunuo.jpg',
                    'desc' => 'Famous for the Hanunuo Mangyan script and literature.',
                    'history' => 'The Hanunuo are one of the eight Mangyan groups and are especially known for preserving an indigenous writing tradition. Their script and ambahan poetry are important parts of their cultural continuity.',
                    'location' => 'Southeastern Mindoro',
                    'heritage' => 'Hanunuo heritage includes Surat Hanunuo Mangyan and ambahan poetry, which preserve language, values, knowledge, and teachings across generations.'
                ],
                [
                    'name' => 'Buhid',
                    'slug' => 'buhid',
                    'image' => 'buhid.jpg',
                    'desc' => 'Maintains indigenous writing and traditional lifestyles.',
                    'history' => 'The Buhid are one of the eight indigenous groups of Mindoro. They have maintained a distinct language and an indigenous writing tradition that remains an important part of their cultural identity.',
                    'location' => 'Central and southern Mindoro',
                    'heritage' => 'Buhid heritage includes Surat Buhid Mangyan, traditional knowledge, language, and community practices passed between generations.'
                ],
                [
                    'name' => 'Ratagnon',
                    'slug' => 'ratagnon',
                    'image' => 'ratagnon.jpg',
                    'desc' => 'One of the smallest Mangyan groups preserving their identity.',
                    'history' => 'The Ratagnon are one of the eight Mangyan ethnolinguistic groups of Mindoro. They are associated with the southern part of the island and maintain a distinct cultural and linguistic identity.',
                    'location' => 'Southern Mindoro',
                    'heritage' => 'Ratagnon heritage is closely connected to language, community identity, traditional practices, and their southern Mindoro homeland.'
                ],
                [
                    'name' => 'Bangon',
                    'slug' => 'bangon',
                    'image' => 'bangon.jpg',
                    'desc' => 'A culturally rich Mangyan tribe living in central Mindoro.',
                    'history' => 'Bangon is recognized as one of the eight Mangyan groups of Mindoro. Bangon communities maintain their own identity while sharing the broader Mangyan heritage of ancestral lands, language, and community traditions.',
                    'location' => 'Central and southern parts of Mindoro',
                    'heritage' => 'Bangon heritage includes community traditions, livelihood knowledge, language, and the continuing protection of ancestral lands.'
                ]
            ];
        @endphp

        <div class="row g-4">

            @foreach($tribes as $tribe)
                <div class="col-6 col-md-4 col-lg-3">

                    <div class="tribe-card h-100">

                        <div class="tribe-image-wrapper">
                            <img
                                src="{{ asset('image/tribes/'.$tribe['image']) }}"
                                alt="{{ $tribe['name'] }}"
                                class="tribe-image"
                            >
                        </div>

                        <div class="p-3 text-center">
                            <h5 class="fw-bold mb-2">
                                {{ $tribe['name'] }}
                            </h5>

                            <p class="small text-muted mb-3">
                                {{ $tribe['desc'] }}
                            </p>

                            <button
                                type="button"
                                class="btn btn-sm btn-outline-warning rounded-pill px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#tribeModal-{{ $tribe['slug'] }}"
                            >
                                Learn More
                            </button>
                        </div>

                    </div>

                </div>

                {{-- Tribe Learn More Modal --}}
                <div
                    class="modal fade"
                    id="tribeModal-{{ $tribe['slug'] }}"
                    tabindex="-1"
                    aria-labelledby="tribeModalLabel-{{ $tribe['slug'] }}"
                    aria-hidden="true"
                >
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 rounded-4 overflow-hidden">

                            <div class="modal-header border-0 p-0 position-relative">
                                <img
                                    src="{{ asset('image/tribes/'.$tribe['image']) }}"
                                    alt="{{ $tribe['name'] }} Mangyan"
                                    class="w-100"
                                    style="width: 100%; height: auto; max-height: 400px; object-fit: contain; background: #f8f5ee;"
                                >

                                <button
                                    type="button"
                                    class="btn-close position-absolute top-0 end-0 m-3 bg-white rounded-circle p-2"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>

                            <div class="modal-body p-4 p-lg-5">

                                <span class="section-label">
                                    MANGYAN HERITAGE
                                </span>

                                <h3
                                    class="fw-bold mt-2 mb-4"
                                    id="tribeModalLabel-{{ $tribe['slug'] }}"
                                >
                                    {{ $tribe['name'] }}
                                </h3>

                                <div class="mb-4">
                                    <h6 class="fw-bold mb-2">
                                        History & Background
                                    </h6>

                                    <p class="text-muted mb-0">
                                        {{ $tribe['history'] }}
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="fw-bold mb-2">
                                        Community Area
                                    </h6>

                                    <p class="text-muted mb-0">
                                        {{ $tribe['location'] }}
                                    </p>
                                </div>

                                <div>
                                    <h6 class="fw-bold mb-2">
                                        Cultural Heritage
                                    </h6>

                                    <p class="text-muted mb-0">
                                        {{ $tribe['heritage'] }}
                                    </p>
                                </div>

                            </div>

                            <div class="modal-footer border-0 px-4 px-lg-5 pb-4">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary rounded-pill px-4"
                                    data-bs-dismiss="modal"
                                >
                                    Close
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

            @endforeach

        </div>

    </div>
</section>


{{-- =========================================================
     FEATURED PRODUCTS
========================================================= --}}
<section id="featured-products" class="py-5">
    <div class="container py-lg-4">

        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="section-label">SHOP FAVORITES</span>

                <h2 class="fw-bold mt-2 mb-1">
                    Featured Products
                </h2>

                <p class="text-muted mb-0">
                    Discover products loved by our customers.
                </p>
            </div>
        </div>

        @php
            $products = \App\Models\Product::where('status', 'Available')
                ->withSum([
                    'inventoryMovements as units_sold' => function ($q) {
                        $q->whereIn('movement_type', [
                            'Walk-in Sale',
                            'Online Sale'
                        ]);
                    }
                ], 'quantity')
                ->orderByDesc('units_sold')
                ->limit(8)
                ->get();
        @endphp

        <div class="row g-4">

            @forelse($products as $product)

                <div class="col-6 col-md-4 col-lg-3">
                    @include(
                        'customer.partials.product-card',
                        ['product' => $product]
                    )
                </div>

            @empty

                <div class="col-12">
                    <div class="empty-products text-center py-5">
                        <div class="empty-icon mb-3">
                            🛍️
                        </div>

                        <h5 class="fw-bold">
                            No Featured Products Yet
                        </h5>

                        <p class="text-muted mb-0">
                            Products added by the administrator will
                            appear here once they become available.
                        </p>
                    </div>
                </div>

            @endforelse

        </div>

    </div>
</section>


{{-- =========================================================
     CUSTOMER HOME STYLES
========================================================= --}}
<style>

    .customer-hero {
        background:
            radial-gradient(
                circle at 85% 25%,
                rgba(244, 180, 0, .16),
                transparent 32%
            ),
            linear-gradient(
                135deg,
                #fffdf7 0%,
                #ffffff 60%,
                #fff9e8 100%
            );
    }

    .min-vh-50 {
        min-height: 480px;
    }

    .section-label {
        display: inline-block;
        color: #c69200;
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .about-box,
    .about-stat,
    .about-highlight {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 8px 30px rgba(0,0,0,.06);
        border: 1px solid rgba(0,0,0,.04);
    }

    .about-box {
        padding: 40px;
        height: 100%;
    }

    .about-icon {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #fff3cd;
        color: #c69200;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .about-stat {
        padding: 28px 15px;
        text-align: center;
        height: 100%;
    }

    .stat-number {
        color: #d39b00;
        font-size: 2rem;
        font-weight: 800;
    }

    .stat-label {
        color: #666;
        font-size: .9rem;
    }

    .about-highlight {
        padding: 25px;
        border-left: 4px solid #f4b400;
    }

    .tribes-section {
        background: #fafafa;
    }

    .tribe-card {
        background: #fff;
        border-radius: 22px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,.05);
        box-shadow: 0 7px 24px rgba(0,0,0,.06);
        transition: all .25s ease;
    }

    .tribe-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 32px rgba(0,0,0,.10);
    }

    .tribe-image-wrapper {
    height: 190px;
    padding: 10px;
    background: #f8f5ee;
    overflow: hidden;
}

    .tribe-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    border-radius: 15px;
    display: block;
}

    .empty-products {
        background: #fafafa;
        border: 1px dashed #ddd;
        border-radius: 24px;
    }

    .empty-icon {
        font-size: 42px;
    }

    .hero-art {
        width: 300px;
        height: 300px;
        position: relative;
    }

    .hero-circle {
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: #fff3cd;
        left: 40px;
        top: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #d39b00;
        font-size: 65px;
        box-shadow: 0 15px 40px rgba(0,0,0,.06);
    }

    .hero-card {
        position: absolute;
        width: 75px;
        height: 75px;
        background: #fff;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        box-shadow: 0 10px 25px rgba(0,0,0,.10);
    }

    .hero-card-one {
        left: 5px;
        top: 55px;
    }

    .hero-card-two {
        right: 5px;
        top: 90px;
    }

    .hero-card-three {
        right: 35px;
        bottom: 15px;
    }

    @media (max-width: 767.98px) {

        .min-vh-50 {
            min-height: auto;
        }

        .hero-art {
            width: 240px;
            height: 240px;
            margin-top: 20px;
        }

        .hero-circle {
            width: 175px;
            height: 175px;
            left: 32px;
            top: 30px;
        }

        .about-box {
            padding: 28px;
        }

        .tribe-image-wrapper {
            height: 140px;
        }
    }

</style>

@endsection