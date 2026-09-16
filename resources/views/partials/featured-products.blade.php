<section class="py-5 bg-light">

    <div class="container">

        <!-- Section Title -->
        <div class="text-center mb-5">

            <h6 class="text-warning fw-bold text-uppercase">
                Featured Products
            </h6>

            <h2 class="fw-bold mb-3">
                Authentic Mangyan Handicrafts
            </h2>

            <p class="text-secondary col-lg-8 mx-auto">
                Browse some of the finest handcrafted products made by Mangyan artisans.
                Every purchase helps preserve indigenous culture while supporting local communities.
            </p>

        </div>

        @php

        $products = [

            [
                'name' => 'Handwoven Basket',
                'tribe' => 'Iraya',
                'price' => '₱1,250',
                'image' => 'basket.jpg'
            ],

            [
                'name' => 'Beaded Necklace',
                'tribe' => 'Hanunuo',
                'price' => '₱850',
                'image' => 'necklace.jpg'
            ],

            [
                'name' => 'Native Hat',
                'tribe' => 'Tau-buid',
                'price' => '₱950',
                'image' => 'hat.jpg'
            ],

            [
                'name' => 'Bamboo Tray',
                'tribe' => 'Alangan',
                'price' => '₱700',
                'image' => 'tray.jpg'
            ]

        ];

        @endphp

        <div class="row g-4">

            @foreach($products as $product)

            <div class="col-md-6 col-lg-3">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <img
                        src="{{ asset('image/products/'.$product['image']) }}"
                        class="card-img-top"
                        alt="{{ $product['name'] }}"
                        style="
                            height:250px;
                            object-fit:cover;
                            border-top-left-radius:1rem;
                            border-top-right-radius:1rem;
                        ">

                    <div class="card-body text-center">

                        <h5 class="fw-bold">
                            {{ $product['name'] }}
                        </h5>

                        <p class="text-muted mb-1">
                            {{ $product['tribe'] }} Tribe
                        </p>

                        <h5 class="text-warning fw-bold mb-3">
                            {{ $product['price'] }}
                        </h5>

                        <a href="/marketplace"
                           class="btn btn-warning w-100 fw-semibold">
                            View Details
                        </a>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

        <div class="text-center mt-5">

            <a href="/marketplace" class="btn btn-outline-warning btn-lg px-5">
                View All Products
            </a>

        </div>

    </div>

</section>