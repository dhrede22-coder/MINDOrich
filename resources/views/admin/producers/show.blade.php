@extends('admin.layouts.app')

@section('title', 'View Craftsman')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <a href="{{ route('producers.index') }}"
           class="text-decoration-none text-muted">

            <i class="bi bi-arrow-left"></i>

            Back to Producers (Craftsmen)

        </a>

        <h2 class="fw-bold mt-2 mb-1">

            Craftsman Profile

        </h2>

        <p class="text-muted mb-0">

            View complete information about this craftsman.

        </p>

    </div>

</div>

<div class="row">

   <!-- LEFT SIDE -->
<div class="col-lg-4">

    <!-- Profile Card -->
    <div class="card border-0 shadow rounded-4 overflow-hidden">

        <!-- Header -->
        <div class="text-center py-4"
             style="background:linear-gradient(135deg,#f9d976,#f39f86);">

            @if($producer->photo)

                <img src="{{ asset('storage/' . $producer->photo) }}"
                     class="rounded-circle border border-4 border-white shadow"
                     width="170"
                     height="170"
                     style="object-fit:cover;">

            @else

                <img src="{{ asset('image/default-avatar.png') }}"
                     class="rounded-circle border border-4 border-white shadow"
                     width="170"
                     height="170">

            @endif

        </div>

        <div class="card-body text-center">

            <h3 class="fw-bold mb-2">

                {{ $producer->producer_name }}

            </h3>

            <span class="badge rounded-pill px-4 py-2
                {{ $producer->status == 'Active'
                    ? 'bg-success'
                    : 'bg-secondary' }}">

                {{ $producer->status }}

            </span>
            <div class="mt-3">

    <small class="text-muted d-block">

        Member Since

    </small>

    <span class="fw-semibold">

        {{ $producer->created_at->format('F Y') }}

    </span>

</div>

            <hr>

            <!-- Statistics -->
            <div class="row text-center">

                <div class="col-4">

                    <h5 class="fw-bold text-warning">

                        {{ $producer->years_of_experience }}

                    </h5>

                    <small class="text-muted">

                        Years

                    </small>

                </div>

                <div class="col-4">

                    <h6 class="fw-bold">

                        {{ $producer->tribe->tribe_name }}

                    </h6>

                    <small class="text-muted">

                        Tribe

                    </small>

                </div>

                <div class="col-4">

                    <h6 class="fw-bold">

                        {{ $producer->gender }}

                    </h6>

                    <small class="text-muted">

                        Gender

                    </small>

                </div>

            </div>

        </div>

    </div>

    <!-- Biography -->
    <div class="card border-0 shadow-sm rounded-4 mt-4">

        <div class="card-body">

            <h5 class="fw-bold mb-3">

                <i class="bi bi-journal-text text-warning me-2"></i>

                Biography

            </h5>

            <p class="text-muted mb-0">

                {{ $producer->biography }}

            </p>

        </div>

    </div>

</div>
    <!-- RIGHT SIDE -->
    <div class="col-lg-8">

       <!-- Basic Information -->
<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body">

        <h5 class="fw-bold mb-4">

            <i class="bi bi-person-circle text-warning me-2"></i>

            Basic Information

        </h5>

        <div class="row">

            <div class="col-md-6 mb-4">

                <small class="text-muted d-block">

                    Craftsman Name

                </small>

                <span class="fw-semibold fs-6">

                    {{ $producer->producer_name }}

                </span>

            </div>

            <div class="col-md-6 mb-4">

                <small class="text-muted d-block">

                    Tribe

                </small>

                <span class="fw-semibold fs-6">

                    {{ $producer->tribe->tribe_name }}

                </span>

            </div>

            <div class="col-md-6 mb-4">

                <small class="text-muted d-block">

                    Gender

                </small>

                <span class="fw-semibold fs-6">

                    {{ $producer->gender }}

                </span>

            </div>

            <div class="col-md-6 mb-4">

                <small class="text-muted d-block">

                    Birthdate

                </small>

                <span class="fw-semibold fs-6">

                    {{ \Carbon\Carbon::parse($producer->birthdate)->format('F d, Y') }}

                </span>

            </div>

        </div>

    </div>

</div>

        <!-- Contact Information -->
<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body">

        <h5 class="fw-bold mb-4">

            <i class="bi bi-telephone-fill text-warning me-2"></i>

            Contact Information

        </h5>

        <div class="row">

            <div class="col-md-6 mb-4">

                <small class="text-muted d-block">

                    Contact Number

                </small>

                <span class="fw-semibold fs-6">

                    {{ $producer->contact_number }}

                </span>

            </div>

            <div class="col-md-6 mb-4">

                <small class="text-muted d-block">

                    Address

                </small>

                <span class="fw-semibold fs-6">

                    {{ $producer->address }}

                </span>

            </div>

        </div>

    </div>

</div>

        <!-- Professional Information -->
<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body">

        <h5 class="fw-bold mb-4">

            <i class="bi bi-briefcase-fill text-warning me-2"></i>

            Professional Information

        </h5>

        <div class="row">

            <div class="col-md-6 mb-4">

                <small class="text-muted d-block">

                    Specialization

                </small>

                <span class="fw-semibold fs-6">

                    {{ $producer->specialization }}

                </span>

            </div>

            <div class="col-md-6 mb-4">

                <small class="text-muted d-block">

                    Years of Experience

                </small>

                <span class="fw-semibold fs-6">

                    {{ $producer->years_of_experience }} Years

                </span>

            </div>

        </div>

    </div>

</div>

        <!-- Buttons -->
        <div class="d-flex justify-content-end gap-2 mt-4">

           <a href="{{ route('producers.edit', $producer) }}"
   class="btn btn-warning">

                <i class="bi bi-pencil-square me-2"></i>

                Edit

            </a>

            <a href="{{ route('producers.index') }}"
               class="btn btn-secondary">

                Back

            </a>

        </div>

    </div>

</div>

@endsection
@push('styles')
<style>

.profile-card{
    background: linear-gradient(135deg,#fff8e6,#ffffff);
    border:none;
    transition:.3s;
}

.profile-card:hover{
    transform:translateY(-3px);
}

.profile-img{
    width:180px;
    height:180px;
    object-fit:cover;
    border-radius:50%;
    border:6px solid #fff;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
}

.info-card{
    border:none;
    border-radius:20px;
    transition:.25s;
}

.info-card:hover{
    transform:translateY(-2px);
}

.info-label{
    font-size:.82rem;
    color:#8c8c8c;
}

.info-value{
    font-weight:600;
    font-size:1rem;
}

</style>
@endpush