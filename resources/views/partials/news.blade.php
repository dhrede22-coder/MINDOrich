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

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <img
                        src="{{ asset('images/news/'.$item['image']) }}"
                        class="card-img-top"
                        alt="{{ $item['title'] }}"
                        style="height:240px; object-fit:cover;">

                    <div class="card-body">

                        <small class="text-warning fw-semibold">
                            {{ $item['date'] }}
                        </small>

                        <h5 class="fw-bold mt-2">
                            {{ $item['title'] }}
                        </h5>

                        <p class="text-secondary">
                            {{ $item['description'] }}
                        </p>

                        <a href="/news"
                           class="btn btn-outline-warning">
                            Read More
                        </a>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>