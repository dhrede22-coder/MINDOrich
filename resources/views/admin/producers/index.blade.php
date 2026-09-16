@extends('admin.layouts.app')

@section('title', 'Producers')

@section('content')
@if(session('delete_error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('delete_error') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
        </button>
    </div>
@endif

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
    Producers <span class="text-muted fs-5">(Craftsmen)</span>
</h2>
            <p class="text-muted mb-0">
                Manage Mangyan producers and artisan profiles.
            </p>

        </div>

        <a href="{{ route('producers.create') }}"
          class="btn btn-warning">

          <i class="bi bi-plus-circle me-2"></i>

          Add Producer

        </a>

    </div>

    <!-- Statistics -->
    <div class="row g-4 mb-4">

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

    <div>

        <small class="text-muted">
            Total Producers
        </small>

        <h2 class="fw-bold mt-2 mb-0">
            {{ $totalProducers }}
        </h2>

    </div>

    <i class="bi bi-people-fill fs-1 text-warning"></i>

</div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

    <div>

        <small class="text-muted">
            Total Tribes
        </small>

        <h2 class="fw-bold mt-2 mb-0">
            {{ $totalTribes }}
        </h2>

    </div>

    <i class="bi bi-diagram-3-fill fs-1 text-success"></i>

</div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

    <div>

        <small class="text-muted">
            Male Producers
        </small>

        <h2 class="fw-bold mt-2 mb-0">
            {{ $maleProducers }}
        </h2>

    </div>

    <i class="bi bi-person-fill fs-1 text-primary"></i>

</div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

    <div>

        <small class="text-muted">
            Female Producers
        </small>

        <h2 class="fw-bold mt-2 mb-0">
            {{ $femaleProducers }}
        </h2>

    </div>

    <i class="bi bi-person-fill fs-1 text-danger"></i>

</div>

                </div>

            </div>

        </div>

    </div>

   <!-- Search & Filters -->
<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body">

        <form id="searchForm"
              method="GET"
              action="{{ route('producers.index') }}">

            <div class="row g-3 align-items-center">

                <!-- Search -->
                <div class="col-lg-5">

                    <input
                        type="text"
                        name="search"
                        id="searchInput"
                        class="form-control"
                        placeholder="🔍 Search craftsman..."
                        value="{{ request('search') }}">

                </div>

                <!-- Tribe -->
                <div class="col-lg-2">

                    <select
                        name="tribe"
                        class="form-select auto-submit">

                        <option value="">All Tribes</option>

                        @foreach($tribes as $tribe)

                            <option
                                value="{{ $tribe->id }}"
                                {{ request('tribe') == $tribe->id ? 'selected' : '' }}>

                                {{ $tribe->tribe_name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Gender -->
                <div class="col-lg-2">

                    <select
                        name="gender"
                        class="form-select auto-submit">

                        <option value="">All Gender</option>

                        <option value="Male"
                            {{ request('gender') == 'Male' ? 'selected' : '' }}>
                            Male
                        </option>

                        <option value="Female"
                            {{ request('gender') == 'Female' ? 'selected' : '' }}>
                            Female
                        </option>

                    </select>

                </div>

                <!-- Status -->
                <div class="col-lg-2">

                    <select
                        name="status"
                        class="form-select auto-submit">

                        <option value="">All Status</option>

                        <option value="Active"
                            {{ request('status') == 'Active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="Inactive"
                            {{ request('status') == 'Inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>

                <!-- Clear -->
                <div class="col-lg-1 text-end">

                    @if(request()->hasAny(['search','tribe','gender','status']))

                        <a href="{{ route('producers.index') }}"
                           class="text-decoration-none small">

                            Clear

                        </a>

                    @endif

                </div>

            </div>

        </form>

    </div>

</div>

    <!-- Producer Table -->

<div class="d-flex justify-content-end mb-3">

    <a href="{{ request()->fullUrlWithQuery(['all' => 1]) }}"
       class="btn btn-outline-primary">

        <i class="bi bi-people me-2"></i>

        See All Producers

    </a>

</div>

<div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Photo</th>

                            <th>Producer Name</th>

                            <th>Tribe</th>

                            <th>Gender</th>

                            <th>Contact</th>

                            <th>Specialization</th>

                            <th>Status</th>

                            <th width="170">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

@forelse($producers as $producer)

<tr>

    <td>
        @if($producer->photo)
            <img src="{{ asset('storage/' . $producer->photo) }}"
                 width="50"
                 height="50"
                 class="rounded-circle"
                 style="object-fit: cover;">
        @else
            <img src="{{ asset('image/default-avatar.png') }}"
                 width="50"
                 height="50"
                 class="rounded-circle">
        @endif
    </td>

    <td>{{ $producer->producer_name }}</td>

    <td>{{ $producer->tribe->tribe_name }}</td>

    <td>{{ $producer->gender }}</td>

    <td>{{ $producer->contact_number }}</td>

    <td>{{ $producer->specialization }}</td>

    <td>
        <span class="badge bg-success">
            {{ $producer->status }}
        </span>
    </td>

    <td>

        <a href="{{ route('producers.show', $producer) }}"
   class="btn btn-sm btn-primary">
    <i class="bi bi-eye"></i>
</a>

        <a href="{{ route('producers.edit', $producer) }}"
   class="btn btn-sm btn-warning">
    <i class="bi bi-pencil"></i>
</a>

     <button
    type="button"
    class="btn btn-sm btn-danger delete-btn"
    data-id="{{ $producer->id }}"
    data-name="{{ $producer->producer_name }}"
    data-url="{{ route('producers.destroy', $producer) }}"
    data-bs-toggle="modal"
    data-bs-target="#deleteModal">

    <i class="bi bi-trash"></i>


</button>

    </td>

</tr>


@empty

<tr>

    <td colspan="8" class="text-center py-5 text-muted">

        No producers found.

    </td>

</tr>

@endforelse

</tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
{{-- Delete Producer Modal --}}
<div class="modal fade"
     id="deleteModal"
     tabindex="-1"
     aria-labelledby="deleteModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            {{-- Header --}}
            <div class="modal-header border-0 px-4 pt-4">

                <h4 class="modal-title fw-bold"
                    id="deleteModalLabel">

                    Delete Craftsman

                </h4>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>

            </div>


            {{-- Body --}}
            <div class="modal-body px-4 pb-3 text-center">

                <div class="mb-3">

                    <i class="bi bi-exclamation-triangle"
                       style="
                           font-size: 64px;
                           color: #dc3545;
                       ">
                    </i>

                </div>


                <h4 class="fw-bold mb-2">

                    Are you sure?

                </h4>


                <p class="text-muted mb-2">

                    You are about to delete:

                </p>


                <h5 class="fw-bold mb-4"
                    id="deleteProducerName">

                </h5>


                <div class="alert alert-warning rounded-3 mb-0">

                    <i class="bi bi-exclamation-circle me-2"></i>

                    This action cannot be undone.

                </div>

            </div>


            {{-- Footer --}}
            <div class="modal-footer border-0 px-4 pb-4 justify-content-center">

                <button type="button"
                        class="btn btn-light border px-4"
                        data-bs-dismiss="modal">

                    Cancel

                </button>


                <form id="deleteForm"
                      method="POST">

                    @csrf

                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger px-4">

                        <i class="bi bi-trash me-2"></i>

                        Delete Craftsman

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const deleteModal = document.getElementById('deleteModal');

    deleteModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const name = button.getAttribute('data-name');
        const url = button.getAttribute('data-url');

        document.getElementById('deleteProducerName').textContent = name;

        document.getElementById('deleteForm').action = url;

    });

});

</script>
<script>

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const filters = document.querySelectorAll('.auto-submit');

    let timer;

    // Live Search
    searchInput.addEventListener('keyup', function () {

        clearTimeout(timer);

        timer = setTimeout(function () {

            form.submit();

        }, 400);

    });

    // Auto Filter
    filters.forEach(filter => {

        filter.addEventListener('change', function () {

            form.submit();

        });

    });

});

</script>

@endpush

