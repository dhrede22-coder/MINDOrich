@extends('admin.layouts.app')

@section('title', 'Producers')

@section('content')

<style>

/* =========================================================
   MINDOrich PRODUCERS
   Same visual system as Reports & Analytics
========================================================= */

.producers-page {
    padding-bottom: 2rem;
}

/* ---------------------------------------------------------
   ALERT
--------------------------------------------------------- */

.producers-alert {
    border-radius: 12px;
    border: 1px solid rgba(220, 53, 69, 0.15);
}

/* ---------------------------------------------------------
   PAGE HEADER
--------------------------------------------------------- */

.producers-header {
    background: linear-gradient(
        135deg,
        #ffffff 0%,
        #faf7f2 100%
    );

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    padding: 1.25rem 1.5rem;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);
}

.producers-header-icon {
    width: 46px;
    height: 46px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: rgba(200, 138, 43, 0.12);
    color: #a86f1f;

    font-size: 1.3rem;

    flex-shrink: 0;
}

.producers-header h4 {
    color: #1f2937;
}

.producers-header p {
    font-size: 0.9rem;
}

/* ---------------------------------------------------------
   ADD BUTTON
--------------------------------------------------------- */

.producers-add-btn {
    background: #c88a2b;
    border-color: #c88a2b;

    color: #ffffff;

    border-radius: 10px;

    padding: 0.65rem 1rem;

    font-weight: 600;

    white-space: nowrap;
}

.producers-add-btn:hover,
.producers-add-btn:focus {
    background: #a86f1f;
    border-color: #a86f1f;
    color: #ffffff;
}

/* ---------------------------------------------------------
   SECTION
--------------------------------------------------------- */

.producers-section-title {
    font-size: 0.98rem;
    font-weight: 700;

    color: #1f2937;

    margin-bottom: 0.1rem;
}

.producers-section-subtitle {
    font-size: 0.78rem;

    color: #6b7280;

    margin-bottom: 0;
}

.producers-section-icon {
    width: 38px;
    height: 38px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f8f9fa;
    color: #374151;

    flex-shrink: 0;
}

/* ---------------------------------------------------------
   KPI CARDS
--------------------------------------------------------- */

.producer-kpi {
    position: relative;

    height: 100%;

    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 14px;

    padding: 1rem 1.1rem;

    box-shadow: 0 3px 10px rgba(31, 41, 55, 0.035);

    overflow: hidden;
}

.producer-kpi::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;
    bottom: 0;

    width: 4px;

    background: #c88a2b;
}

.producer-kpi.green::before {
    background: #2f5d50;
}

.producer-kpi.blue::before {
    background: #0d6efd;
}

.producer-kpi.pink::before {
    background: #dc3545;
}

.producer-kpi-label {
    color: #6b7280;

    font-size: 0.76rem;
    font-weight: 600;

    margin-bottom: 0.25rem;
}

.producer-kpi-value {
    color: #1f2937;

    font-size: 1.45rem;
    font-weight: 700;

    line-height: 1.2;
}

.producer-kpi-icon {
    width: 40px;
    height: 40px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f8f9fa;

    color: #374151;

    font-size: 1.05rem;
}

/* ---------------------------------------------------------
   FILTER CARD
--------------------------------------------------------- */

.producers-filter-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);

    overflow: hidden;
}

.producers-filter-header {
    padding: 1.1rem 1.25rem 0.85rem;

    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.producers-filter-body {
    padding: 0 1.25rem 1.25rem;
}

.producers-filter-body .form-label {
    font-size: 0.78rem;

    color: #4b5563;

    font-weight: 600;

    margin-bottom: 0.4rem;
}

.producers-filter-body .form-control,
.producers-filter-body .form-select {
    min-height: 42px;

    border-radius: 10px;

    border-color: rgba(31, 41, 55, 0.12);
}

.producers-filter-body .form-control:focus,
.producers-filter-body .form-select:focus {
    border-color: #c88a2b;

    box-shadow: 0 0 0 0.2rem rgba(200, 138, 43, 0.12);
}

.producers-clear {
    color: #6b7280;

    font-size: 0.78rem;

    text-decoration: none;
}

.producers-clear:hover {
    color: #a86f1f;
}

/* ---------------------------------------------------------
   DIRECTORY CARD
--------------------------------------------------------- */

.producers-directory-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);

    overflow: hidden;
}

.producers-directory-header {
    padding: 1.1rem 1.25rem;

    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 1rem;

    border-bottom: 1px solid rgba(31, 41, 55, 0.06);
}

/* ---------------------------------------------------------
   SEE ALL BUTTON
--------------------------------------------------------- */

.producers-see-all {
    border-radius: 9px;

    font-size: 0.78rem;
    font-weight: 600;

    padding: 0.5rem 0.8rem;
}

/* ---------------------------------------------------------
   TABLE
--------------------------------------------------------- */

.producers-table-wrapper {
    overflow-x: auto;
}

.producers-table {
    margin-bottom: 0;
}

.producers-table thead th {
    background: #f8f9fa;

    color: #6b7280;

    font-size: 0.72rem;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: 0.025em;

    padding: 0.85rem 1rem;

    border-bottom: 1px solid rgba(31, 41, 55, 0.07);

    white-space: nowrap;
}

.producers-table tbody td {
    padding: 0.85rem 1rem;

    color: #374151;

    font-size: 0.82rem;

    border-color: rgba(31, 41, 55, 0.06);

    vertical-align: middle;
}

.producers-table tbody tr:last-child td {
    border-bottom: 0;
}

.producers-table tbody tr:hover {
    background: #faf7f2;
}

/* ---------------------------------------------------------
   PRODUCER PROFILE
--------------------------------------------------------- */

.producer-avatar {
    width: 42px;
    height: 42px;

    border-radius: 11px;

    object-fit: cover;

    flex-shrink: 0;

    border: 1px solid rgba(31, 41, 55, 0.08);
}

.producer-avatar-placeholder {
    width: 42px;
    height: 42px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 11px;

    background: #f8f9fa;

    color: #6b7280;

    border: 1px solid rgba(31, 41, 55, 0.07);

    flex-shrink: 0;
}

.producer-name {
    color: #1f2937;

    font-weight: 700;

    font-size: 0.84rem;
}

.producer-meta {
    color: #9ca3af;

    font-size: 0.72rem;

    margin-top: 0.1rem;
}

/* ---------------------------------------------------------
   STATUS
--------------------------------------------------------- */

.producer-status {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;

    padding: 0.38rem 0.65rem;

    border-radius: 999px;

    font-size: 0.7rem;

    font-weight: 700;
}

.producer-status.active {
    background: rgba(25, 135, 84, 0.10);
    color: #198754;
}

.producer-status.inactive {
    background: rgba(108, 117, 125, 0.10);
    color: #6c757d;
}

.producer-status-dot {
    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: currentColor;
}

/* ---------------------------------------------------------
   ACTION BUTTONS
--------------------------------------------------------- */

.producer-action-btn {
    width: 34px;
    height: 34px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    border: 1px solid transparent;

    font-size: 0.82rem;
}

.producer-view-btn {
    background: rgba(13, 110, 253, 0.08);
    color: #0d6efd;
}

.producer-view-btn:hover {
    background: #0d6efd;
    color: #ffffff;
}

.producer-edit-btn {
    background: rgba(200, 138, 43, 0.10);
    color: #a86f1f;
}

.producer-edit-btn:hover {
    background: #c88a2b;
    color: #ffffff;
}

.producer-delete-btn {
    background: rgba(220, 53, 69, 0.08);
    color: #dc3545;
}

.producer-delete-btn:hover {
    background: #dc3545;
    color: #ffffff;
}

/* ---------------------------------------------------------
   EMPTY STATE
--------------------------------------------------------- */

.producer-empty-icon {
    width: 50px;
    height: 50px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: #f8f9fa;

    color: #9ca3af;

    font-size: 1.25rem;
}

/* ---------------------------------------------------------
   DELETE MODAL
--------------------------------------------------------- */

.producer-delete-modal {
    border: 0;

    border-radius: 16px;

    overflow: hidden;
}

.producer-delete-icon {
    width: 64px;
    height: 64px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 16px;

    background: rgba(220, 53, 69, 0.08);

    color: #dc3545;

    font-size: 1.7rem;
}

/* ---------------------------------------------------------
   RESPONSIVE
--------------------------------------------------------- */

@media (max-width: 767.98px) {

    .producers-header {
        padding: 1rem;
    }

    .producers-header-action {
        width: 100%;

        margin-top: 1rem;
    }

    .producers-add-btn {
        width: 100%;
    }

    .producers-directory-header {
        align-items: flex-start;

        flex-direction: column;
    }

    .producers-see-all {
        width: 100%;
    }

}

</style>


<div class="container-fluid producers-page">


    {{-- =====================================================
         ALERT
    ====================================================== --}}

    @if(session('delete_error'))

        <div
            class="alert alert-danger producers-alert alert-dismissible fade show mb-4"
            role="alert"
        >

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ session('delete_error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>

    @endif


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="producers-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div class="d-flex align-items-center gap-3">

                <div class="producers-header-icon">

                    <i class="bi bi-people-fill"></i>

                </div>

                <div>

                    <h4 class="fw-bold mb-1">
                        Producers
                    </h4>

                    <p class="text-muted mb-0">
                        Manage Mangyan producers and artisan profiles.
                    </p>

                </div>

            </div>


            <div class="producers-header-action">

                <a
                    href="{{ route('producers.create') }}"
                    class="btn producers-add-btn"
                >

                    <i class="bi bi-plus-circle me-2"></i>

                    Add Producer

                </a>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PRODUCER OVERVIEW
    ====================================================== --}}

    <div class="mb-4">

        <div class="d-flex align-items-center gap-2 mb-3">

            <div class="producers-section-icon">

                <i class="bi bi-bar-chart-line-fill"></i>

            </div>

            <div>

                <div class="producers-section-title">
                    Producer Overview
                </div>

                <p class="producers-section-subtitle">
                    A quick summary of the registered Mangyan producers.
                </p>

            </div>

        </div>


        <div class="row g-3">


            {{-- TOTAL PRODUCERS --}}

            <div class="col-xl-3 col-md-6">

                <div class="producer-kpi">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="producer-kpi-label">
                                Total Producers
                            </div>

                            <div class="producer-kpi-value">
                                {{ number_format($totalProducers) }}
                            </div>

                        </div>

                        <div class="producer-kpi-icon">

                            <i class="bi bi-people-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- TOTAL TRIBES --}}

            <div class="col-xl-3 col-md-6">

                <div class="producer-kpi green">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="producer-kpi-label">
                                Total Tribes
                            </div>

                            <div class="producer-kpi-value">
                                {{ number_format($totalTribes) }}
                            </div>

                        </div>

                        <div class="producer-kpi-icon">

                            <i class="bi bi-diagram-3-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- MALE --}}

            <div class="col-xl-3 col-md-6">

                <div class="producer-kpi blue">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="producer-kpi-label">
                                Male Producers
                            </div>

                            <div class="producer-kpi-value">
                                {{ number_format($maleProducers) }}
                            </div>

                        </div>

                        <div class="producer-kpi-icon">

                            <i class="bi bi-person-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FEMALE --}}

            <div class="col-xl-3 col-md-6">

                <div class="producer-kpi pink">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="producer-kpi-label">
                                Female Producers
                            </div>

                            <div class="producer-kpi-value">
                                {{ number_format($femaleProducers) }}
                            </div>

                        </div>

                        <div class="producer-kpi-icon">

                            <i class="bi bi-person-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>


    {{-- =====================================================
         SEARCH & FILTERS
    ====================================================== --}}

    <div class="producers-filter-card mb-4">


        <div class="producers-filter-header">

            <div class="producers-section-icon">

                <i class="bi bi-funnel-fill"></i>

            </div>

            <div>

                <div class="producers-section-title">
                    Search & Filters
                </div>

                <p class="producers-section-subtitle">
                    Find producers by name, tribe, gender, or status.
                </p>

            </div>

        </div>


        <div class="producers-filter-body">

            <form
                id="searchForm"
                method="GET"
                action="{{ route('producers.index') }}"
            >

                <div class="row g-3 align-items-end">


                    {{-- SEARCH --}}

                    <div class="col-xl-5 col-lg-4">

                        <label class="form-label">
                            Search Producer
                        </label>

                        <div class="position-relative">

                            <i
                                class="bi bi-search position-absolute"
                                style="
                                    left: 14px;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    color: #9ca3af;
                                    pointer-events: none;
                                "
                            ></i>

                            <input
                                type="text"
                                name="search"
                                id="searchInput"
                                class="form-control ps-5"
                                placeholder="Search producer name..."
                                value="{{ request('search') }}"
                            >

                        </div>

                    </div>


                    {{-- TRIBE --}}

                    <div class="col-xl-2 col-lg-2 col-md-4">

                        <label class="form-label">
                            Tribe
                        </label>

                        <select
                            name="tribe"
                            class="form-select auto-submit"
                        >

                            <option value="">
                                All Tribes
                            </option>

                            @foreach($tribes as $tribe)

                                <option
                                    value="{{ $tribe->id }}"
                                    {{ request('tribe') == $tribe->id ? 'selected' : '' }}
                                >

                                    {{ $tribe->tribe_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- GENDER --}}

                    <div class="col-xl-2 col-lg-2 col-md-4">

                        <label class="form-label">
                            Gender
                        </label>

                        <select
                            name="gender"
                            class="form-select auto-submit"
                        >

                            <option value="">
                                All Gender
                            </option>

                            <option
                                value="Male"
                                {{ request('gender') == 'Male' ? 'selected' : '' }}
                            >
                                Male
                            </option>

                            <option
                                value="Female"
                                {{ request('gender') == 'Female' ? 'selected' : '' }}
                            >
                                Female
                            </option>

                        </select>

                    </div>


                    {{-- STATUS --}}

                    <div class="col-xl-2 col-lg-2 col-md-4">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select auto-submit"
                        >

                            <option value="">
                                All Status
                            </option>

                            <option
                                value="Active"
                                {{ request('status') == 'Active' ? 'selected' : '' }}
                            >
                                Active
                            </option>

                            <option
                                value="Inactive"
                                {{ request('status') == 'Inactive' ? 'selected' : '' }}
                            >
                                Inactive
                            </option>

                        </select>

                    </div>


                    {{-- CLEAR --}}

                    <div class="col-xl-1 col-lg-2 col-md-12">

                        @if(request()->hasAny([
                            'search',
                            'tribe',
                            'gender',
                            'status'
                        ]))

                            <a
                                href="{{ route('producers.index') }}"
                                class="producers-clear"
                            >

                                <i class="bi bi-x-circle me-1"></i>

                                Clear

                            </a>

                        @endif

                    </div>


                </div>

            </form>

        </div>

    </div>


    {{-- =====================================================
         PRODUCER DIRECTORY
    ====================================================== --}}

    <div class="producers-directory-card">


        {{-- DIRECTORY HEADER --}}

        <div class="producers-directory-header">

            <div class="d-flex align-items-center gap-3">

                <div class="producers-section-icon">

                    <i class="bi bi-person-lines-fill"></i>

                </div>

                <div>

                    <div class="producers-section-title">
                        Producer Directory
                    </div>

                    <p class="producers-section-subtitle">
                        Registered Mangyan producers and artisan profiles.
                    </p>

                </div>

            </div>


            <a
                href="{{ request()->fullUrlWithQuery(['all' => 1]) }}"
                class="btn btn-outline-primary producers-see-all"
            >

                <i class="bi bi-people me-1"></i>

                See All Producers

            </a>

        </div>


        {{-- TABLE --}}

        <div class="producers-table-wrapper">

            <table class="table producers-table align-middle">

                <thead>

                    <tr>

                        <th>
                            Producer
                        </th>

                        <th>
                            Tribe
                        </th>

                        <th>
                            Gender
                        </th>

                        <th>
                            Contact
                        </th>

                        <th>
                            Specialization
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($producers as $producer)

                        <tr>


                            {{-- PRODUCER --}}

                            <td>

                                <div class="d-flex align-items-center gap-3">


                                    @if($producer->photo)

                                        <img
                                            src="{{ asset('storage/' . $producer->photo) }}"
                                            alt="{{ $producer->producer_name }}"
                                            class="producer-avatar"
                                        >

                                    @else

                                        <div class="producer-avatar-placeholder">

                                            <i class="bi bi-person"></i>

                                        </div>

                                    @endif


                                    <div>

                                        <div class="producer-name">

                                            {{ $producer->producer_name }}

                                        </div>

                                        <div class="producer-meta">

                                            Producer / Craftsman

                                        </div>

                                    </div>


                                </div>

                            </td>


                            {{-- TRIBE --}}

                            <td>

                                <span class="fw-semibold">

                                    {{ $producer->tribe->tribe_name ?? '—' }}

                                </span>

                            </td>


                            {{-- GENDER --}}

                            <td>

                                @if($producer->gender === 'Male')

                                    <span class="text-primary">

                                        <i class="bi bi-gender-male me-1"></i>

                                        Male

                                    </span>

                                @elseif($producer->gender === 'Female')

                                    <span class="text-danger">

                                        <i class="bi bi-gender-female me-1"></i>

                                        Female

                                    </span>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- CONTACT --}}

                            <td>

                                @if($producer->contact_number)

                                    <span>

                                        <i class="bi bi-telephone me-1 text-muted"></i>

                                        {{ $producer->contact_number }}

                                    </span>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- SPECIALIZATION --}}

                            <td>

                                @if($producer->specialization)

                                    <span>

                                        {{ $producer->specialization }}

                                    </span>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if($producer->status === 'Active')

                                    <span class="producer-status active">

                                        <span class="producer-status-dot"></span>

                                        Active

                                    </span>

                                @else

                                    <span class="producer-status inactive">

                                        <span class="producer-status-dot"></span>

                                        {{ $producer->status }}

                                    </span>

                                @endif

                            </td>


                            {{-- ACTIONS --}}

                            <td class="text-end">

                                <div class="d-flex justify-content-end gap-1">


                                    {{-- VIEW --}}

                                    <a
                                        href="{{ route('producers.show', $producer) }}"
                                        class="producer-action-btn producer-view-btn"
                                        title="View Producer"
                                    >

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('producers.edit', $producer) }}"
                                        class="producer-action-btn producer-edit-btn"
                                        title="Edit Producer"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    {{-- DELETE --}}

                                    <button
                                        type="button"
                                        class="producer-action-btn producer-delete-btn delete-btn"
                                        data-id="{{ $producer->id }}"
                                        data-name="{{ $producer->producer_name }}"
                                        data-url="{{ route('producers.destroy', $producer) }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        title="Delete Producer"
                                    >

                                        <i class="bi bi-trash"></i>

                                    </button>


                                </div>

                            </td>


                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                            >

                                <div class="producer-empty-icon mx-auto mb-3">

                                    <i class="bi bi-people"></i>

                                </div>

                                <div class="fw-semibold text-dark mb-1">

                                    No producers found

                                </div>

                                <div class="text-muted small">

                                    Try changing your search or filter criteria.

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     DELETE PRODUCER MODAL
========================================================= --}}

<div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-labelledby="deleteModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content producer-delete-modal shadow">


            {{-- HEADER --}}

            <div class="modal-header border-0 px-4 pt-4">

                <h5
                    class="modal-title fw-bold"
                    id="deleteModalLabel"
                >

                    Delete Producer

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- BODY --}}

            <div class="modal-body px-4 pb-3 text-center">

                <div class="producer-delete-icon mb-3">

                    <i class="bi bi-trash"></i>

                </div>


                <h5 class="fw-bold mb-2">

                    Are you sure?

                </h5>


                <p class="text-muted mb-1">

                    You are about to delete:

                </p>


                <div
                    id="deleteProducerName"
                    class="fw-bold text-dark mb-4"
                ></div>


                <div class="alert alert-warning rounded-3 mb-0 small">

                    <i class="bi bi-exclamation-circle me-1"></i>

                    This action cannot be undone.

                </div>

            </div>


            {{-- FOOTER --}}

            <div class="modal-footer border-0 px-4 pb-4 justify-content-center">

                <button
                    type="button"
                    class="btn btn-light border px-4"
                    data-bs-dismiss="modal"
                >

                    Cancel

                </button>


                <form
                    id="deleteForm"
                    method="POST"
                >

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger px-4"
                    >

                        <i class="bi bi-trash me-2"></i>

                        Delete Producer

                    </button>

                </form>

            </div>


        </div>

    </div>

</div>


{{-- =========================================================
     SCRIPTS
========================================================= --}}

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       DELETE MODAL
    ===================================================== */

    const deleteModal =
        document.getElementById('deleteModal');


    if (deleteModal) {

        deleteModal.addEventListener(
            'show.bs.modal',
            function (event) {

                const button =
                    event.relatedTarget;

                const name =
                    button.getAttribute('data-name');

                const url =
                    button.getAttribute('data-url');


                document.getElementById(
                    'deleteProducerName'
                ).textContent = name;


                document.getElementById(
                    'deleteForm'
                ).action = url;

            }
        );

    }


    /* =====================================================
       LIVE SEARCH + FILTERS
    ===================================================== */

    const form =
        document.getElementById('searchForm');

    const searchInput =
        document.getElementById('searchInput');

    const filters =
        document.querySelectorAll('.auto-submit');


    if (!form) {
        return;
    }


    let timer;


    /* LIVE SEARCH */

    if (searchInput) {

        searchInput.addEventListener(
            'keyup',
            function () {

                clearTimeout(timer);

                timer = setTimeout(
                    function () {

                        form.submit();

                    },
                    400
                );

            }
        );

    }


    /* AUTO FILTER */

    filters.forEach(function (filter) {

        filter.addEventListener(
            'change',
            function () {

                form.submit();

            }
        );

    });

});

</script>

@endpush

@endsection