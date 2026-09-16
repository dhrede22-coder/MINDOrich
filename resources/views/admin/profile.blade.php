@extends('admin.layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">My Profile</h3>
        <p class="text-muted mb-0">
            Manage your administrator account information.
        </p>
    </div>


    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- VALIDATION ERRORS --}}
    @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <strong>Please check the following:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="row g-4">

        {{-- PROFILE INFORMATION --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <h5 class="fw-bold mb-1">
                        Profile Information
                    </h5>

                    <small class="text-muted">
                        Update your personal information.
                    </small>

                </div>


                <div class="card-body p-4">

                    <form
                        method="POST"
                        action="{{ route('admin.profile.update') }}"
                    >

                        @csrf
                        @method('PATCH')


                        {{-- NAME --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control rounded-3"
                                value="{{ old('name', $user->name) }}"
                                required
                            >

                        </div>


                        {{-- EMAIL --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control rounded-3"
                                value="{{ old('email', $user->email) }}"
                                required
                            >

                        </div>


                        {{-- CONTACT --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Contact Number
                            </label>

                            <input
                                type="text"
                                name="contact_number"
                                class="form-control rounded-3"
                                value="{{ old('contact_number', $user->contact_number) }}"
                                placeholder="Enter contact number"
                            >

                        </div>


                        {{-- ADDRESS --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Address
                            </label>

                            <textarea
                                name="address"
                                class="form-control rounded-3"
                                rows="3"
                                placeholder="Enter address"
                            >{{ old('address', $user->address) }}</textarea>

                        </div>


                        <hr class="my-4">


                        {{-- CHANGE PASSWORD --}}
                        <h5 class="fw-bold mb-1">
                            Change Password
                        </h5>

                        <p class="text-muted small mb-3">
                            Leave these fields blank if you don't want to change your password.
                        </p>


                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                New Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control rounded-3"
                                placeholder="Enter new password"
                            >

                        </div>


                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Confirm New Password
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control rounded-3"
                                placeholder="Confirm new password"
                            >

                        </div>


                        {{-- SAVE BUTTON --}}
                        <button
                            type="submit"
                            class="btn btn-warning rounded-3 px-4 fw-semibold"
                        >

                            <i class="bi bi-check-lg me-2"></i>

                            Save Changes

                        </button>

                    </form>

                </div>

            </div>

        </div>


        {{-- ACCOUNT SUMMARY --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4 text-center">

                    <div
                        class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="
                            width:80px;
                            height:80px;
                            background:#fff3cd;
                        "
                    >

                        <i
                            class="bi bi-person-fill"
                            style="
                                font-size:38px;
                                color:#f4b400;
                            "
                        ></i>

                    </div>


                    <h5 class="fw-bold mb-1">
                        {{ $user->name }}
                    </h5>

                    <p class="text-muted mb-3">
                        {{ $user->email }}
                    </p>


                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                        Administrator
                    </span>


                    <hr class="my-4">


                    <div class="text-start">

                        <small class="text-muted d-block">
                            Account Status
                        </small>

                        <strong class="text-success">
                            <i class="bi bi-check-circle me-1"></i>
                            Active
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection