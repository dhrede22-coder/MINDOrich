@extends('customer.layouts.customer')

@section('content')

<div class="container py-5">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}

    <div class="mb-4">
        <span class="text-uppercase fw-semibold"
              style="font-size: 13px; letter-spacing: 2px; color: #c69200;">
            MY ACCOUNT
        </span>

        <h2 class="fw-bold mt-2 mb-1">
            My Profile
        </h2>

        <p class="text-muted mb-0">
            Manage your account information and view your verification status.
        </p>
    </div>


    {{-- =========================================================
        SUCCESS MESSAGE
    ========================================================== --}}

    @if(session('status'))
        <div class="alert alert-success rounded-3">
            {{ session('status') }}
        </div>
    @endif


    {{-- =========================================================
        VALIDATION ERRORS
    ========================================================== --}}

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

        {{-- =====================================================
            PROFILE INFORMATION
        ====================================================== --}}

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4 p-lg-5">

                    <div class="d-flex align-items-center mb-4">

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="
                                width: 58px;
                                height: 58px;
                                background: #fff4d5;
                                color: #c69200;
                                font-size: 25px;
                            "
                        >
                            <i class="bi bi-person"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">
                                Profile Information
                            </h5>

                            <p class="text-muted small mb-0">
                                Update your name and email address.
                            </p>
                        </div>

                    </div>

                    <form
    method="POST"
    action="{{ route('profile.update') }}"
    enctype="multipart/form-data"
>
                        @csrf
                        @method('PATCH')

                        {{-- PROFILE PICTURE --}}
                    <div class="mb-4">

                        <div class="d-flex align-items-center gap-3">

                            @if($user->profile_image)
                                <img
                                    src="{{ asset('storage/' . $user->profile_image) }}"
                                    alt="Profile Picture"
                                    class="rounded-circle"
                                    style="
                                        width: 90px;
                                        height: 90px;
                                        object-fit: cover;
                                        border: 3px solid #fff4d5;
                                    "
                                >
                            @else
                                <div
                                    class="rounded-circle d-flex align-items-center justify-content-center"
                                    style="
                                        width: 90px;
                                        height: 90px;
                                        background: #fff4d5;
                                        color: #c69200;
                                        font-size: 38px;
                                    "
                                >
                                    <i class="bi bi-person"></i>
                                </div>
                            @endif

                            <div>
                                <label
                                    for="profile_image"
                                    class="form-label fw-semibold mb-1"
                                >
                                    Profile Picture
                                </label>

                                <input
                                    type="file"
                                    id="profile_image"
                                    name="profile_image"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.webp"
                                >

                                <div class="text-muted small mt-1">
                                    JPG, JPEG, PNG, or WEBP. Maximum 2MB.
                                </div>

                                @error('profile_image')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                    </div>


                        {{-- NAME --}}
                        <div class="mb-4">

                            <label
                                for="name"
                                class="form-label fw-semibold"
                            >
                                Full Name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $user->name) }}"
                                required
                                autofocus
                            >

                            @error('name')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- EMAIL --}}
                        <div class="mb-4">

                            <label
                                for="email"
                                class="form-label fw-semibold"
                            >
                                Email Address
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email', $user->email) }}"
                                required
                            >

                            @error('email')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="text-end">

                            <button
                                type="submit"
                                class="btn btn-warning px-4"
                            >
                                <i class="bi bi-check-circle me-1"></i>
                                Save Changes
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- =====================================================
            ACCOUNT STATUS
        ====================================================== --}}

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        Account Status
                    </h5>


                    {{-- VERIFICATION STATUS --}}
                    <div class="mb-4">

                        <div class="small text-muted mb-2">
                            Verification Status
                        </div>

                        @if($user->verification_status === 'Approved')

                            <span class="badge bg-success px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i>
                                Approved
                            </span>

                        @elseif($user->verification_status === 'Under Review')

                            <span class="badge bg-warning text-dark px-3 py-2">
                                <i class="bi bi-hourglass-split me-1"></i>
                                Under Review
                            </span>

                        @elseif($user->verification_status === 'Rejected')

                            <span class="badge bg-danger px-3 py-2">
                                <i class="bi bi-x-circle me-1"></i>
                                Rejected
                            </span>

                        @else

                            <span class="badge bg-secondary px-3 py-2">
                                {{ $user->verification_status ?? 'Pending' }}
                            </span>

                        @endif

                    </div>


                    {{-- VERIFIED DATE --}}
                    @if($user->verified_at)

                        <div class="mb-4">

                            <div class="small text-muted mb-1">
                                Verified Date
                            </div>

                            <div class="fw-semibold">
                                {{ $user->verified_at->format('F d, Y') }}
                            </div>

                        </div>

                    @endif


                    {{-- CONTACT --}}
                    <div class="mb-4">

                        <div class="small text-muted mb-1">
                            Contact Number
                        </div>

                        <div class="fw-semibold">
                            {{ $user->contact_number ?: 'Not provided' }}
                        </div>

                    </div>


                    {{-- ADDRESS --}}
                    <div>

                        <div class="small text-muted mb-1">
                            Address
                        </div>

                        <div class="fw-semibold">
                            {{ $user->address ?: 'Not provided' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            CHANGE PASSWORD
        ====================================================== --}}

        <div class="col-12">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4 p-lg-5">

                    <div class="d-flex align-items-center mb-4">

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="
                                width: 58px;
                                height: 58px;
                                background: #f3f3f3;
                                color: #555;
                                font-size: 23px;
                            "
                        >
                            <i class="bi bi-lock"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">
                                Change Password
                            </h5>

                            <p class="text-muted small mb-0">
                                Keep your account secure with a strong password.
                            </p>
                        </div>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('password.update') }}"
                    >
                        @csrf
                        @method('PUT')


                        <div class="row g-4">

                            {{-- CURRENT PASSWORD --}}
                            <div class="col-md-4">

                                <label
                                    for="current_password"
                                    class="form-label fw-semibold"
                                >
                                    Current Password
                                </label>

                                <input
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    class="form-control"
                                    autocomplete="current-password"
                                    required
                                >

                                @error('current_password', 'updatePassword')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- NEW PASSWORD --}}
                            <div class="col-md-4">

                                <label
                                    for="password"
                                    class="form-label fw-semibold"
                                >
                                    New Password
                                </label>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control"
                                    autocomplete="new-password"
                                    required
                                >

                                @error('password', 'updatePassword')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- CONFIRM PASSWORD --}}
                            <div class="col-md-4">

                                <label
                                    for="password_confirmation"
                                    class="form-label fw-semibold"
                                >
                                    Confirm New Password
                                </label>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control"
                                    autocomplete="new-password"
                                    required
                                >

                                @error('password_confirmation', 'updatePassword')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        <div class="text-end mt-4">

                            <button
                                type="submit"
                                class="btn btn-dark px-4"
                            >
                                <i class="bi bi-shield-lock me-1"></i>
                                Update Password
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection