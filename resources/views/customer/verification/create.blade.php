@extends('customer.layouts.customer')

@section('title', 'Account Verification')

@section('content')

<div class="container py-5">

    {{-- =========================================================
         PAGE HEADER
         ========================================================= --}}
    <div class="mb-4">

        <h2 class="fw-bold mb-1">
            Account Verification
        </h2>

        <p class="text-muted mb-0">
            Verify your account before placing an online order.
        </p>

    </div>


    {{-- =========================================================
         SUCCESS MESSAGE
         ========================================================= --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show rounded-3"
             role="alert">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- =========================================================
         ERROR MESSAGE
         ========================================================= --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show rounded-3"
             role="alert">

            <i class="bi bi-exclamation-circle me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- =========================================================
         VALIDATION ERRORS
         ========================================================= --}}
    @if($errors->any())

        <div class="alert alert-danger rounded-3">

            <div class="fw-semibold mb-2">
                Please check the following:
            </div>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =========================================================
         CURRENT VERIFICATION STATUS
         ========================================================= --}}

    @if($user->verification_status === 'Approved')

        {{-- APPROVED --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <div class="d-flex align-items-center">

                    <div class="me-3">

                        <div
                            class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center"
                            style="width:55px;height:55px;"
                        >

                            <i class="bi bi-shield-check text-success fs-4"></i>

                        </div>

                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Account Verified
                        </h5>

                        <p class="text-muted mb-0">
                            Your account has been verified. You can now place online orders.
                        </p>

                    </div>

                </div>

            </div>

        </div>


    @elseif($user->verification_status === 'Under Review')

        {{-- UNDER REVIEW --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <div class="d-flex align-items-center">

                    <div class="me-3">

                        <div
                            class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center"
                            style="width:55px;height:55px;"
                        >

                            <i class="bi bi-hourglass-split text-warning fs-4"></i>

                        </div>

                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Verification Under Review
                        </h5>

                        <p class="text-muted mb-0">
                            Your verification details have been submitted.
                            Please wait for the admin to review your account.
                        </p>

                    </div>

                </div>

            </div>

        </div>


    @elseif($user->verification_status === 'Rejected')

        {{-- REJECTED --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <div class="d-flex align-items-center mb-3">

                    <div class="me-3">

                        <div
                            class="rounded-circle bg-danger-subtle d-flex align-items-center justify-content-center"
                            style="width:55px;height:55px;"
                        >

                            <i class="bi bi-shield-x text-danger fs-4"></i>

                        </div>

                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Verification Rejected
                        </h5>

                        <p class="text-muted mb-0">
                            Your submitted information was not approved.
                            Please review the reason and submit again.
                        </p>

                    </div>

                </div>


                @if(filled($user->verification_notes))

                    <div class="alert alert-danger mb-0">

                        <strong>
                            Admin Notes:
                        </strong>

                        <div class="mt-1">
                            {{ $user->verification_notes }}
                        </div>

                    </div>

                @endif

            </div>

        </div>

    @endif


    {{-- =========================================================
         VERIFICATION FORM
         ========================================================= --}}
    @if(
        $user->verification_status !== 'Approved' &&
        $user->verification_status !== 'Under Review'
    )

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4 p-md-5">

                {{-- Form Header --}}
                <div class="mb-4">

                    <h5 class="fw-bold mb-1">
                        Submit Verification Details
                    </h5>

                    <p class="text-muted mb-0">
                        Please provide accurate information and a valid government-issued ID.
                    </p>

                </div>


                {{-- =================================================
                     VERIFICATION FORM
                     ================================================= --}}
                <form
                    action="{{ route('customer.verification.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf


                    {{-- =================================================
                         CUSTOMER INFORMATION
                         ================================================= --}}
                    <div class="mb-4">

                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-person me-2"></i>
                            Customer Information
                        </h6>


                        <div class="row g-3">

                            {{-- Name --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $user->name }}"
                                    readonly
                                >

                            </div>


                            {{-- Email --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    value="{{ $user->email }}"
                                    readonly
                                >

                            </div>


                            {{-- Contact Number --}}
                            <div class="col-md-6">

                                <label
                                    for="contact_number"
                                    class="form-label fw-semibold"
                                >
                                    Contact Number
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="contact_number"
                                    id="contact_number"
                                    class="form-control @error('contact_number') is-invalid @enderror"
                                    value="{{ old('contact_number', $user->contact_number) }}"
                                    placeholder="Enter your contact number"
                                    required
                                >

                                @error('contact_number')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Address --}}
                            <div class="col-12">

                                <label
                                    for="address"
                                    class="form-label fw-semibold"
                                >
                                    Complete Address
                                    <span class="text-danger">*</span>
                                </label>

                                <textarea
                                    name="address"
                                    id="address"
                                    rows="3"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Enter your complete address"
                                    required
                                >{{ old('address', $user->address) }}</textarea>

                                @error('address')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>


                    <hr class="my-4">


                    {{-- =================================================
                         VALID ID INFORMATION
                         ================================================= --}}
                    <div class="mb-4">

                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-card-text me-2"></i>
                            Valid ID Information
                        </h6>


                        <div class="row g-3">

                            {{-- ID Type --}}
                            <div class="col-md-6">

                                <label
                                    for="id_type"
                                    class="form-label fw-semibold"
                                >
                                    ID Type
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="id_type"
                                    id="id_type"
                                    class="form-select @error('id_type') is-invalid @enderror"
                                    required
                                >

                                    <option value="">
                                        Select ID Type
                                    </option>

                                    <option
                                        value="PhilID / National ID"
                                        {{ old('id_type', $user->id_type) === 'PhilID / National ID' ? 'selected' : '' }}
                                    >
                                        PhilID / National ID
                                    </option>

                                    <option
                                        value="Driver's License"
                                        {{ old('id_type', $user->id_type) === "Driver's License" ? 'selected' : '' }}
                                    >
                                        Driver's License
                                    </option>

                                    <option
                                        value="Passport"
                                        {{ old('id_type', $user->id_type) === 'Passport' ? 'selected' : '' }}
                                    >
                                        Passport
                                    </option>

                                    <option
                                        value="UMID"
                                        {{ old('id_type', $user->id_type) === 'UMID' ? 'selected' : '' }}
                                    >
                                        UMID
                                    </option>

                                    <option
                                        value="Postal ID"
                                        {{ old('id_type', $user->id_type) === 'Postal ID' ? 'selected' : '' }}
                                    >
                                        Postal ID
                                    </option>

                                    <option
                                        value="Other Valid ID"
                                        {{ old('id_type', $user->id_type) === 'Other Valid ID' ? 'selected' : '' }}
                                    >
                                        Other Valid ID
                                    </option>

                                </select>

                                @error('id_type')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- ID Number --}}
                            <div class="col-md-6">

                                <label
                                    for="id_number"
                                    class="form-label fw-semibold"
                                >
                                    ID Number
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="id_number"
                                    id="id_number"
                                    class="form-control @error('id_number') is-invalid @enderror"
                                    value="{{ old('id_number', $user->id_number) }}"
                                    placeholder="Enter your ID number"
                                    required
                                >

                                @error('id_number')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- ID Image --}}
                            <div class="col-12">

                                <label
                                    for="id_image"
                                    class="form-label fw-semibold"
                                >
                                    Upload Valid ID
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="file"
                                    name="id_image"
                                    id="id_image"
                                    class="form-control @error('id_image') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    required
                                >

                                <div class="form-text">
                                    Accepted formats: JPG, JPEG, PNG, WEBP.
                                    Maximum file size: 5MB.
                                </div>

                                @error('id_image')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         PRIVACY / VERIFICATION NOTICE
                         ================================================= --}}
                    <div class="alert alert-light border rounded-3 mb-4">

                        <div class="d-flex">

                            <i class="bi bi-shield-lock fs-5 me-2"></i>

                            <div>

                                <strong>
                                    Verification Notice
                                </strong>

                                <p class="text-muted small mb-0 mt-1">
                                    Your submitted information will be reviewed
                                    by the administrator before you can place an
                                    online order. Please make sure that the
                                    information and uploaded ID are accurate.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         SUBMIT BUTTON
                         ================================================= --}}
                    <div class="d-flex justify-content-end gap-2">

                        <a
                            href="{{ route('customer.shop') }}"
                            class="btn btn-light border px-4"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="btn btn-warning px-4"
                        >

                            <i class="bi bi-send me-2"></i>

                            Submit for Verification

                        </button>

                    </div>

                </form>

            </div>

        </div>

    @elseif($user->verification_status === 'Under Review')

        {{-- =========================================================
             UNDER REVIEW ACTION
             ========================================================= --}}
        <div class="text-center mt-4">

            <a
                href="{{ route('customer.shop') }}"
                class="btn btn-warning px-4"
            >
                <i class="bi bi-shop me-2"></i>
                Continue Shopping
            </a>

        </div>

    @else

        {{-- =========================================================
             APPROVED ACTION
             ========================================================= --}}
        <div class="text-center mt-4">

            <a
                href="{{ route('customer.checkout') }}"
                class="btn btn-warning px-4"
            >
                <i class="bi bi-cart-check me-2"></i>
                Continue to Checkout
            </a>

        </div>

    @endif

</div>

@endsection