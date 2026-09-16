<section class="py-5">

    <div class="container">

        <div class="text-center mb-5">

            <h6 class="text-warning fw-bold text-uppercase">
                Featured Artisans
            </h6>

            <h2 class="fw-bold mb-3">
                Meet the Hands Behind Every Craft
            </h2>

            <p class="text-secondary col-lg-8 mx-auto">
                Every handcrafted product carries a story. Meet some of the talented
                Mangyan artisans who continue to preserve indigenous traditions through
                their craftsmanship.
            </p>

        </div>

        @php

        $artisans = [

            [
                'name'=>'Maria Lumang',
                'tribe'=>'Iraya',
                'craft'=>'Basket Weaver',
                'image'=>'artisan1.jpg'
            ],

            [
                'name'=>'Juan Dalid',
                'tribe'=>'Hanunuo',
                'craft'=>'Beadwork Artist',
                'image'=>'artisan2.jpg'
            ],

            [
                'name'=>'Lita Bansud',
                'tribe'=>'Alangan',
                'craft'=>'Traditional Weaver',
                'image'=>'artisan3.jpg'
            ]

        ];

        @endphp

        <div class="row justify-content-center g-4">

            @foreach($artisans as $artisan)

            <div class="col-md-6 col-lg-4">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <img
                        src="{{ asset('images/artisans/'.$artisan['image']) }}"
                        class="card-img-top"
                        alt="{{ $artisan['name'] }}"
                        style="height:280px; object-fit:cover;">

                    <div class="card-body text-center">

                        <h5 class="fw-bold">
                            {{ $artisan['name'] }}
                        </h5>

                        <p class="text-warning mb-1">
                            {{ $artisan['tribe'] }} Tribe
                        </p>

                        <p class="text-secondary">
                            {{ $artisan['craft'] }}
                        </p>

                        <a href="/artisans"
                           class="btn btn-outline-warning">

                            View Profile

                        </a>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>