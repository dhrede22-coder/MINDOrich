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
            Settings
        </h2>

        <p class="text-muted mb-0">
            Manage your account preferences, security, notifications, and account settings.
        </p>

    </div>


    {{-- =========================================================
         ACCOUNT PREFERENCES
    ========================================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4 p-lg-5">

            <div class="d-flex align-items-center mb-4">

                <div
                    class="rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="
                        width: 52px;
                        height: 52px;
                        background: #fff4d5;
                        color: #c69200;
                        font-size: 22px;
                    "
                >
                    <i class="bi bi-person-lines-fill"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">
                        Account Preferences
                    </h5>

                    <p class="text-muted small mb-0">
                        Manage your contact information and address.
                    </p>
                </div>

            </div>


            <div class="row g-4">

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Contact Number
                    </label>

                    <div class="form-control bg-light">
                        {{ $user->contact_number ?: 'Not provided' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Address
                    </label>

                    <div class="form-control bg-light">
                        {{ $user->address ?: 'Not provided' }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         ACCOUNT VERIFICATION
    ========================================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4 p-lg-5">

            <div class="d-flex align-items-center mb-4">

                <div
                    class="rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="
                        width: 52px;
                        height: 52px;
                        background: #fff4d5;
                        color: #c69200;
                        font-size: 22px;
                    "
                >
                    <i class="bi bi-shield-check"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">
                        Account Verification
                    </h5>

                    <p class="text-muted small mb-0">
                        View your verification status and submitted information.
                    </p>
                </div>

            </div>


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


            {{-- SUBMITTED INFORMATION --}}
            <div class="row g-4">

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Contact Number
                    </label>

                    <div class="form-control bg-light">
                        {{ $user->contact_number ?: 'Not provided' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Address
                    </label>

                    <div class="form-control bg-light">
                        {{ $user->address ?: 'Not provided' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        ID Type
                    </label>

                    <div class="form-control bg-light">
                        {{ $user->id_type ?: 'Not provided' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        ID Number
                    </label>

                    <div class="form-control bg-light">
                        {{ $user->id_number ?: 'Not provided' }}
                    </div>

                </div>

            </div>


            {{-- VERIFIED DATE --}}
            @if($user->verified_at)

                <div class="mt-4">

                    <div class="small text-muted mb-1">
                        Verified Date
                    </div>

                    <div class="fw-semibold">
                        {{ $user->verified_at->format('F d, Y') }}
                    </div>

                </div>

            @endif


            {{-- ADMIN NOTES --}}
            @if(filled($user->verification_notes))

                <div class="alert alert-danger mt-4 mb-0">

                    <strong>
                        Admin Notes:
                    </strong>

                    <div class="mt-1">
                        {{ $user->verification_notes }}
                    </div>

                </div>

            @endif


            {{-- RESUBMIT --}}
            @if($user->verification_status === 'Rejected' || !$user->verification_status)

                <div class="mt-4">

                    <a
                        href="{{ route('customer.verification.create') }}"
                        class="btn btn-warning px-4"
                    >
                        <i class="bi bi-arrow-repeat me-1"></i>

                        {{ $user->verification_status === 'Rejected'
                            ? 'Resubmit Verification'
                            : 'Submit Verification'
                        }}
                    </a>

                </div>

            @endif

        </div>

    </div>


    {{-- =========================================================
         SECURITY
    ========================================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4 p-lg-5">

            <div class="d-flex align-items-center mb-4">

                <div
                    class="rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="
                        width: 52px;
                        height: 52px;
                        background: #f3f3f3;
                        color: #555;
                        font-size: 22px;
                    "
                >
                    <i class="bi bi-shield-lock"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">
                        Security
                    </h5>

                    <p class="text-muted small mb-0">
                        Keep your account secure by updating your password.
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
                        Change Password
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
         NOTIFICATIONS
    ========================================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4 p-lg-5">

            <div class="d-flex align-items-center mb-4">

                <div
                    class="rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="
                        width: 52px;
                        height: 52px;
                        background: #fff4d5;
                        color: #c69200;
                        font-size: 22px;
                    "
                >
                    <i class="bi bi-bell"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">
                        Notifications
                    </h5>

                    <p class="text-muted small mb-0">
                        Manage the notifications you receive from MINDOrich.
                    </p>
                </div>

            </div>


            @if(session('success'))

                <div class="alert alert-success rounded-3">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>

            @endif


            <form
                method="POST"
                action="{{ route('customer.settings.update') }}"
            >

                @csrf
                @method('PATCH')


                {{-- ORDER NOTIFICATIONS --}}
                <div class="d-flex align-items-center justify-content-between py-3 border-bottom">

                    <div class="pe-3">

                        <div class="fw-semibold">
                            Order Notifications
                        </div>

                        <div class="text-muted small">
                            Receive updates about your orders, payments, and order status.
                        </div>

                    </div>


                    <div class="form-check form-switch mb-0">

                        <input
                            type="hidden"
                            name="order_notifications"
                            value="0"
                        >

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="order_notifications"
                            id="order_notifications"
                            value="1"
                            {{ $user->order_notifications ? 'checked' : '' }}
                        >

                        <label
                            class="form-check-label"
                            for="order_notifications"
                        ></label>

                    </div>

                </div>


                {{-- PRODUCT NOTIFICATIONS --}}
                <div class="d-flex align-items-center justify-content-between py-3">

                    <div class="pe-3">

                        <div class="fw-semibold">
                            Product Notifications
                        </div>

                        <div class="text-muted small">
                            Receive notifications about new products and product updates.
                        </div>

                    </div>


                    <div class="form-check form-switch mb-0">

                        <input
                            type="hidden"
                            name="product_notifications"
                            value="0"
                        >

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="product_notifications"
                            id="product_notifications"
                            value="1"
                            {{ $user->product_notifications ? 'checked' : '' }}
                        >

                        <label
                            class="form-check-label"
                            for="product_notifications"
                        ></label>

                    </div>

                </div>


                <div class="text-end mt-4">

                    <button
                        type="submit"
                        class="btn btn-warning px-4"
                    >
                        <i class="bi bi-check-circle me-1"></i>
                        Save Notification Settings
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
         PRIVACY & ACCOUNT
    ========================================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4 p-lg-5">

            <div class="d-flex align-items-center mb-4">

                <div
                    class="rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="
                        width: 52px;
                        height: 52px;
                        background: #fbeaea;
                        color: #c0392b;
                        font-size: 22px;
                    "
                >
                    <i class="bi bi-shield-exclamation"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">
                        Privacy & Account
                    </h5>

                    <p class="text-muted small mb-0">
                        Manage your account and session.
                    </p>
                </div>

            </div>


            {{-- LOGOUT --}}
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 py-3 border-bottom">

                <div class="pe-md-3">

                    <div class="fw-semibold">
                        Logout
                    </div>

                    <div class="text-muted small">
                        Sign out of your MINDOrich account on this device.
                    </div>

                </div>


                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="flex-shrink-0"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-outline-secondary px-4"
                    >
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Logout
                    </button>

                </form>

            </div>


            {{-- DELETE ACCOUNT --}}
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 py-3">

                <div class="pe-md-3">

                    <div class="fw-semibold text-danger">
                        Delete Account
                    </div>

                    <div class="text-muted small">
                        Permanently delete your account and account-related data.
                    </div>

                </div>


                <form
                    method="POST"
                    action="{{ route('profile.destroy') }}"
                    onsubmit="return confirm('Are you sure you want to permanently delete your account? This action cannot be undone.');"
                    class="flex-shrink-0"
                    style="width: 100%; max-width: 430px;"
                >

                    @csrf
                    @method('DELETE')


                    <div class="d-flex flex-column flex-sm-row gap-2">

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Current password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="submit"
                            class="btn btn-danger px-4 flex-shrink-0"
                        >
                            <i class="bi bi-trash3 me-1"></i>
                            Delete Account
                        </button>

                    </div>


                    @error('password', 'userDeletion')

                        <div class="text-danger small mt-2">
                            {{ $message }}
                        </div>

                    @enderror

                </form>

            </div>

        </div>

    </div>


</div>

@endsection