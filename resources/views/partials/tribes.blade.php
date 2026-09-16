<div class="container">

    <!-- Section Title -->
    <div class="text-center mb-5">

        <h6 class="text-warning fw-bold text-uppercase">
            Mangyan Tribes
        </h6>

        <h2 class="fw-bold mb-3">
            Discover the Eight Mangyan Tribes of Mindoro
        </h2>

        <p class="text-secondary col-lg-8 mx-auto">
            Each Mangyan tribe has its own unique language, traditions,
            craftsmanship, and cultural identity. Learn more about the
            indigenous communities that continue to preserve Mindoro's
            rich heritage.
        </p>

    </div>

    <div class="row g-4">

        @php

        $tribes = [

            [
                'name' => 'Iraya',
                'image' => 'iraya.jpg',
                'desc' => 'Known for basket weaving and traditional craftsmanship.'
            ],

            [
                'name' => 'Alangan',
                'image' => 'alangan.jpg',
                'desc' => 'Recognized for their rich oral traditions and indigenous arts.'
            ],

            [
                'name' => 'Tadyawan',
                'image' => 'tadyawan.jpg',
                'desc' => 'Preserves farming traditions and cultural heritage.'
            ],

            [
                'name' => 'Tau-buid',
                'image' => 'taubuid.jpg',
                'desc' => 'Known for their deep connection with the forests of Mindoro.'
            ],

            [
                'name' => 'Hanunuo',
                'image' => 'hanunuo.jpg',
                'desc' => 'Famous for the Hanunuo Mangyan script and literature.'
            ],

            [
                'name' => 'Buhid',
                'image' => 'buhid.jpg',
                'desc' => 'Maintains indigenous writing and traditional lifestyles.'
            ],

            [
                'name' => 'Ratagnon',
                'image' => 'ratagnon.jpg',
                'desc' => 'One of the smallest Mangyan groups preserving their identity.'
            ],

            [
                'name' => 'Bangon',
                'image' => 'bangon.jpg',
                'desc' => 'A culturally rich Mangyan tribe living in central Mindoro.'
            ]

        ];

        @endphp

        @foreach($tribes as $tribe)

        <div class="col-md-6 col-lg-3">

            <div class="card h-100 border-0 shadow-sm">

                <img
                    src="{{ asset('image/tribes/'.$tribe['image']) }}"
                    class="card-img-top"
                    alt="{{ $tribe['name'] }}"
                    style="
                        height:250px;
                        object-fit:contain;
                        object-position:center;
                        background:#fff;
                        padding:10px;
                    ">

                <div class="card-body text-center">

                    <h5 class="fw-bold">
                        {{ $tribe['name'] }}
                    </h5>

                    <p class="text-secondary small">
                        {{ $tribe['desc'] }}
                    </p>

                    <a href="/tribes"
                       class="btn btn-outline-warning btn-sm">
                        Learn More
                    </a>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>