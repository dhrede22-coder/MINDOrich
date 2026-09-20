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

    @php
        $tribeImages = [
            'Iraya' => 'iraya.jpg',
            'Alangan' => 'alangan.jpg',
            'Tadyawan' => 'tadyawan.jpg',
            'Tau-buid' => 'taubuid.jpg',
            'Hanunuo' => 'hanunuo.jpg',
            'Buhid' => 'buhid.jpg',
            'Ratagnon' => 'ratagnon.jpg',
            'Bangon' => 'bangon.jpg',
        ];
    @endphp

    <div class="row g-4">

        @forelse($tribes as $tribe)

            <div class="col-12 col-sm-6 col-lg-3">

                <div class="card h-100 border-0 shadow-sm overflow-hidden public-tribe-card">

                    <!-- Tribe Image -->
                    @if(isset($tribeImages[$tribe->tribe_name]))

                        <img
                            src="{{ asset('image/tribes/' . $tribeImages[$tribe->tribe_name]) }}"
                            class="card-img-top public-tribe-card-image"
                            alt="{{ $tribe->tribe_name }}"
                        >

                    @else

                        <div class="d-flex align-items-center justify-content-center bg-light text-secondary public-tribe-placeholder">

                            <div class="text-center">

                                <i class="bi bi-image fs-1"></i>

                                <div class="small mt-2">
                                    No Image Available
                                </div>

                            </div>

                        </div>

                    @endif


                    <div class="card-body text-center">

                        <!-- Tribe Name -->
                        <h5 class="fw-bold">
                            {{ $tribe->tribe_name }}
                        </h5>

                        <!-- Description -->
                        <p class="text-secondary small">
                            {{ $tribe->description ?? 'Learn more about this Mangyan community and its cultural heritage.' }}
                        </p>

                        <!-- Learn More -->
                        <button
                            type="button"
                            class="btn btn-outline-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#tribeModal-{{ $tribe->id }}"
                        >
                            Learn More
                        </button>

                    </div>

                </div>

            </div>


            <!-- Tribe Information Modal -->
            <div
                class="modal fade"
                id="tribeModal-{{ $tribe->id }}"
                tabindex="-1"
                aria-labelledby="tribeModalLabel-{{ $tribe->id }}"
                aria-hidden="true"
            >

                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                    <div class="modal-content border-0 rounded-4 overflow-hidden">

                        <!-- Modal Image -->
                        <div class="modal-header border-0 p-0 position-relative">

                            @if(isset($tribeImages[$tribe->tribe_name]))

                                <img
                                    src="{{ asset('image/tribes/' . $tribeImages[$tribe->tribe_name]) }}"
                                    alt="{{ $tribe->tribe_name }} Mangyan"
                                    class="w-100 public-tribe-modal-image"
                                >

                            @endif

                            <button
                                type="button"
                                class="btn-close position-absolute top-0 end-0 m-3 bg-white rounded-circle p-2"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>

                        </div>


                        <!-- Modal Body -->
                        <div class="modal-body p-3 p-sm-4 p-lg-5">

                            <span class="text-warning fw-bold text-uppercase small">
                                Mangyan Heritage
                            </span>

                            <h3
                                class="fw-bold mt-2 mb-4 public-tribe-modal-title"
                                id="tribeModalLabel-{{ $tribe->id }}"
                            >
                                {{ $tribe->tribe_name }}
                            </h3>


                            <!-- History -->
                            <div class="mb-4">

                                <h6 class="fw-bold mb-2">
                                    History & Background
                                </h6>

                                <p class="text-muted mb-0">
                                    {{ $tribe->history ?? 'Information about this tribe is currently unavailable.' }}
                                </p>

                            </div>


                            <!-- Community Area -->
                            <div class="mb-4">

                                <h6 class="fw-bold mb-2">
                                    Community Area
                                </h6>

                                <p class="text-muted mb-0">
                                    {{ $tribe->location ?? 'Information about the community area is currently unavailable.' }}
                                </p>

                            </div>


                            <!-- Language -->
                            <div class="mb-4">

                                <h6 class="fw-bold mb-2">
                                    Language
                                </h6>

                                <p class="text-muted mb-0">
                                    {{ $tribe->language ?? 'Information about the language is currently unavailable.' }}
                                </p>

                            </div>


                            <!-- Cultural Heritage -->
                            <div>

                                <h6 class="fw-bold mb-2">
                                    Cultural Heritage
                                </h6>

                                <p class="text-muted mb-0">
                                    {{ $tribe->description ?? 'Information about this tribe’s cultural heritage is currently unavailable.' }}
                                </p>

                            </div>

                        </div>


                        <!-- Modal Footer -->
                        <div class="modal-footer border-0 px-3 px-sm-4 px-lg-5 pb-4">

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

        @empty

            <div class="col-12">

                <div class="text-center py-5">

                    <i class="bi bi-people fs-1 text-secondary"></i>

                    <h5 class="fw-bold mt-3">
                        No Mangyan Tribes Available
                    </h5>

                    <p class="text-muted mb-0">
                        Tribe information will appear here once available.
                    </p>

                </div>

            </div>

        @endforelse

    </div>

</div>


<style>
    .public-tribe-card-image,
    .public-tribe-placeholder {
        width: 100%;
        height: clamp(180px, 28vw, 250px);
    }

    .public-tribe-card-image {
        object-fit: contain;
        object-position: center;
        background: #fff;
        padding: 10px;
    }

    .public-tribe-placeholder {
        min-height: 180px;
    }

    .public-tribe-modal-image {
        width: 100%;
        height: clamp(220px, 45vw, 400px);
        object-fit: contain;
        object-position: center;
        background: #f8f5ee;
    }

    .public-tribe-modal-title {
        line-height: 1.2;
    }

    @media (max-width: 575.98px) {

        .public-tribe-modal-title {
            font-size: 1.6rem;
        }

        .public-tribe-card .card-body {
            padding: 1.1rem;
        }

        .public-tribe-card-image,
        .public-tribe-placeholder {
            height: 190px;
        }

        .public-tribe-modal-image {
            height: 240px;
        }
    }
</style>