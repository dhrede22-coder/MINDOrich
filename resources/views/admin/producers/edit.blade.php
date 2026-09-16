@extends('admin.layouts.app')

@section('title', 'Edit Craftsman')

@section('content')


<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <a href="{{ route('producers.index') }}"
               class="text-decoration-none text-muted">

                <i class="bi bi-arrow-left"></i>

                Back to Producers

            </a>

            <h2 class="fw-bold mt-2 mb-1">

    Edit Craftsman

            </h2>

            <p class="text-muted mb-0">

                Update the craftsman's profile and information.

            </p>

        </div>

    </div>

   <form action="{{ route('producers.update', $producer) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

        <div class="row">

            <!-- LEFT -->

            <div class="col-lg-6">

                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body">

                        <h5 class="fw-bold mb-4">

                            Basic Information

                        </h5>

                        <div class="mb-4">

    <label class="form-label fw-semibold">

        Producer Photo

    </label>

    <div class="text-center border rounded-4 p-4 bg-light">

        <img id="previewImage"
     src="{{ $producer->photo ? asset('storage/'.$producer->photo) : asset('image/default-avatar.png') }}"
     class="rounded-circle mb-3"
     width="140"
     height="140"
     style="object-fit:cover;">

        <input type="file"
       name="photo"
       id="photo"
       class="form-control @error('photo') is-invalid @enderror"
       accept="image/*">

@error('photo')
<div class="invalid-feedback d-block">
    {{ $message }}
</div>
@enderror
        <small class="text-muted d-block mt-2">

            JPG, PNG (Max 2MB)

        </small>

    </div>

</div>

                        <div class="mb-3">

                            <label class="form-label">

                                Producer Name

                            </label>

                            <input type="text"
       name="producer_name"
       class="form-control"
       value="{{ old('producer_name', $producer->producer_name) }}">

@error('producer_name')
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
@enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Tribe

                            </label>

                            <select name="tribe_id"
        class="form-select @error('tribe_id') is-invalid @enderror">

                               <option value="">Select Tribe</option>

                               @foreach($tribes as $tribe)

                               <option value="{{ $tribe->id }}"
    {{ old('tribe_id', $producer->tribe_id) == $tribe->id ? 'selected' : '' }}>

    {{ $tribe->tribe_name }}

</option>

    @endforeach

</select>
@error('tribe_id')
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
@enderror
                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Gender

                            </label>

                           <select name="gender" class="form-select">

    <option value="">Select Gender</option>

    <option value="Male"
        {{ old('gender', $producer->gender) == 'Male' ? 'selected' : '' }}>
        Male
    </option>

    <option value="Female"
        {{ old('gender', $producer->gender) == 'Female' ? 'selected' : '' }}>
        Female
    </option>

</select>

@error('gender')
<div class="invalid-feedback d-block">
    {{ $message }}
</div>
@enderror

                        </div>

                        <div>

                            <label class="form-label">

                                Birthdate

                            </label>

                           <input type="date"
       name="birthdate"
       class="form-control"
       value="{{ old('birthdate', $producer->birthdate) }}">

@error('birthdate')
<div class="invalid-feedback d-block">
    {{ $message }}
</div>
@enderror

                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-lg-6">

                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body">

                        <h5 class="fw-bold mb-4">

                            Additional Information

                        </h5>

                        <div class="mb-3">

                            <label class="form-label">

                                Contact Number

                            </label>

                           <input type="text"
       name="contact_number"
       class="form-control"
       maxlength="11"
       placeholder="09XXXXXXXXX"
       value="{{ old('contact_number', $producer->contact_number) }}">

@error('contact_number')
<div class="invalid-feedback d-block">
    {{ $message }}
</div>
@enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Address

                            </label>

                            <input type="text"
       name="address"
       class="form-control"
       value="{{ old('address', $producer->address) }}">

@error('address')
<div class="invalid-feedback d-block">
    {{ $message }}
</div>
@enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Specialization

                            </label>

                            <input type="text"
       name="specialization"
       class="form-control"
       value="{{ old('specialization', $producer->specialization) }}">

@error('specialization')
<div class="invalid-feedback d-block">
    {{ $message }}
</div>
@enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Years of Experience

                            </label>

                            <input type="number"
       name="years_of_experience"
       class="form-control"
       min="0"
       step="1"
       value="{{ old('years_of_experience', $producer->years_of_experience) }}">

@error('years_of_experience')
<div class="invalid-feedback d-block">
    {{ $message }}
</div>
@enderror

                        </div>

                        <div>

                            <label class="form-label">

                                Status

                            </label>

                           <select name="status"
        class="form-select">

    <option value="">Select Status</option>

    <option value="Active"
        {{ old('status', $producer->status) == 'Active' ? 'selected' : '' }}>
        Active
    </option>

    <option value="Inactive"
        {{ old('status', $producer->status) == 'Inactive' ? 'selected' : '' }}>
        Inactive
    </option>

</select>

@error('status')
<div class="invalid-feedback d-block">
    {{ $message }}
</div>
@enderror

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Biography -->

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <h5 class="fw-bold mb-4">

                    Biography

                </h5>

                <textarea
    name="biography"
    class="form-control"
    rows="6"
    placeholder="Tell something about the producer...">{{ old('biography', $producer->biography) }}</textarea>

@error('biography')
<div class="invalid-feedback d-block">
    {{ $message }}
</div>
@enderror

            </div>

        </div>

        <div class="d-flex justify-content-end gap-3 mt-4">

            <a href="{{ route('producers.index') }}"
               class="btn btn-light">

                Cancel

            </a>

            <button class="btn btn-warning">

                <i class="bi bi-check-circle me-2"></i>

                Update 

            </button>

        </div>

    </form>

</div>

@endsection
@push('scripts')

<script>

document.getElementById('photo').addEventListener('change',function(e){

    const file=e.target.files[0];

    if(file){

        document.getElementById('previewImage').src=
        URL.createObjectURL(file);

    }

});

</script>

@endpush