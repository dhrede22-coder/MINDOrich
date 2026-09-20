<section class="py-5">

    <div class="container">

        <!-- Section Title -->
        <div class="text-center mb-5">

            <h6 class="text-warning fw-bold text-uppercase">
                Latest News & Events
            </h6>

            <h2 class="fw-bold mb-3">
                Stay Updated with PMUI
            </h2>

            <p class="text-secondary col-lg-8 mx-auto">
                Discover the latest community activities, cultural events,
                training programs, and announcements from Pampamayanang
                Mangyan Ugnayan Inc.
            </p>

        </div>


        @php

        $news = [

            [
                'title' => 'Mangyan Handicraft Training Workshop',
                'date' => 'August 2026',
                'image' => 'news1.jpg',
                'description' => 'PMUI conducted a livelihood training workshop for Mangyan artisans to improve product quality and market readiness.'
            ],

            [
                'title' => 'Cultural Heritage Celebration',
                'date' => 'July 2026',
                'image' => 'news2.jpg',
                'description' => 'The eight Mangyan tribes gathered to celebrate and promote their traditions, music, dances, and indigenous crafts.'
            ],

            [
                'title' => 'MINDOrich Marketplace Launch',
                'date' => 'June 2026',
                'image' => 'news3.jpg',
                'description' => 'PMUI officially introduced the MINDOrich platform to promote authentic Mangyan products through digital technology.'
            ]

        ];

        @endphp


        <div class="row g-4">

            @foreach($news as $item)

                <div class="col-12 col-md-6 col-lg-4">

                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden public-news-card">

                        <!-- News Image -->
                        <img
                            src="{{ asset('images/news/' . $item['image']) }}"
                            class="card-img-top public-news-image"
                            alt="{{ $item['title'] }}"
                        >


                        <!-- News Content -->
                        <div class="card-body d-flex flex-column">

                            <small class="text-warning fw-semibold">
                                {{ $item['date'] }}
                            </small>

                            <h5 class="fw-bold mt-2 mb-3 public-news-title">
                                {{ $item['title'] }}
                            </h5>

                            <p class="text-secondary mb-4">
                                {{ $item['description'] }}
                            </p>

                            <a
                                href="/news"
                                class="btn btn-outline-warning mt-auto align-self-start"
                            >
                                Read More
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>


<style>
    .public-news-image {
        width: 100%;
        height: clamp(180px, 30vw, 240px);
        object-fit: cover;
        object-position: center;
    }

    .public-news-title {
        line-height: 1.3;
    }

    @media (max-width: 575.98px) {

        .public-news-image {
            height: 210px;
        }

        .public-news-card .card-body {
            padding: 1.1rem;
        }

        .public-news-title {
            font-size: 1.05rem;
        }

    }
</style>