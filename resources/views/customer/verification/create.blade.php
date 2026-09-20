@extends('customer.layouts.customer')

@section('title', 'Account Verification')

@section('content')

<div class="container py-5">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}
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
    ========================================================== --}}
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
    ========================================================== --}}
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
    ========================================================== --}}
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
    ========================================================== --}}

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
    ========================================================== --}}
    @if(
        $user->verification_status !== 'Approved' &&
        $user->verification_status !== 'Under Review'
    )

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4 p-md-5">

                {{-- FORM HEADER --}}
                <div class="mb-4">

                    <h5 class="fw-bold mb-1">
                        Submit Verification Details
                    </h5>

                    <p class="text-muted mb-0">
                        Please provide complete and accurate information for account verification and delivery.
                    </p>

                </div>


                {{-- =================================================
                     VERIFICATION FORM
                ================================================== --}}
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

                            {{-- NAME --}}
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


                            {{-- EMAIL --}}
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


                            {{-- CONTACT NUMBER --}}
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

                        </div>

                    </div>


                    <hr class="my-4">


                    {{-- =================================================
                         DELIVERY INFORMATION
                    ================================================== --}}
                    <div class="mb-4">

                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-geo-alt me-2"></i>
                            Delivery Information
                        </h6>


                        <div class="row g-3">

                            {{-- HOUSE / STREET --}}
                            <div class="col-md-6">

                                <label
                                    for="house_street"
                                    class="form-label fw-semibold"
                                >
                                    House / Unit No. & Street
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="house_street"
                                    id="house_street"
                                    class="form-control @error('house_street') is-invalid @enderror"
                                    value="{{ old('house_street', $user->house_street) }}"
                                    placeholder="e.g. Purok 2, Rizal Street"
                                    required
                                >

                                @error('house_street')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- BARANGAY --}}
                            <div class="col-md-6">

                                <label
                                    for="barangay"
                                    class="form-label fw-semibold"
                                >
                                    Barangay
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="barangay"
                                    id="barangay"
                                    class="form-control @error('barangay') is-invalid @enderror"
                                    value="{{ old('barangay', $user->barangay) }}"
                                    placeholder="Enter your barangay"
                                    required
                                >

                                @error('barangay')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- MUNICIPALITY / CITY --}}
                            <div class="col-md-6">

                                <label
                                    for="municipality_city"
                                    class="form-label fw-semibold"
                                >
                                    Municipality / City
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="municipality_city"
                                    id="municipality_city"
                                    class="form-control @error('municipality_city') is-invalid @enderror"
                                    value="{{ old('municipality_city', $user->municipality_city) }}"
                                    placeholder="Enter your municipality or city"
                                    required
                                >

                                @error('municipality_city')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- PROVINCE --}}
                            <div class="col-md-6">

                                <label
                                    for="province"
                                    class="form-label fw-semibold"
                                >
                                    Province
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="province"
                                    id="province"
                                    class="form-control @error('province') is-invalid @enderror"
                                    value="{{ old('province', $user->province) }}"
                                    placeholder="Enter your province"
                                    required
                                >

                                @error('province')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- POSTAL CODE --}}
                            <div class="col-md-6">

                                <label
                                    for="postal_code"
                                    class="form-label fw-semibold"
                                >
                                    Postal Code
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="postal_code"
                                    id="postal_code"
                                    class="form-control @error('postal_code') is-invalid @enderror"
                                    value="{{ old('postal_code', $user->postal_code) }}"
                                    placeholder="Enter postal code"
                                    required
                                >

                                @error('postal_code')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- LANDMARK --}}
                            <div class="col-md-6">

                                <label
                                    for="landmark"
                                    class="form-label fw-semibold"
                                >
                                    Landmark
                                    <span class="text-muted fw-normal">(Optional)</span>
                                </label>

                                <input
                                    type="text"
                                    name="landmark"
                                    id="landmark"
                                    class="form-control @error('landmark') is-invalid @enderror"
                                    value="{{ old('landmark', $user->landmark) }}"
                                    placeholder="e.g. Near barangay hall"
                                >

                                @error('landmark')

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
                    ================================================== --}}
                    <div class="mb-4">

                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-card-text me-2"></i>
                            Valid ID Information
                        </h6>


                        <div class="row g-3">

                            {{-- ID TYPE --}}
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


                            {{-- ID NUMBER --}}
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


                            {{-- ID FRONT --}}
                            <div class="col-md-6">

                                <label
                                    for="id_front_image"
                                    class="form-label fw-semibold"
                                >
                                    Valid ID - Front
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="file"
                                    name="id_front_image"
                                    id="id_front_image"
                                    class="form-control @error('id_front_image') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    required
                                >

                                <div class="form-text">
                                    Upload the front side of your valid ID. Maximum file size: 5MB.
                                </div>

                                @error('id_front_image')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- ID BACK --}}
                            <div class="col-md-6">

                                <label
                                    for="id_back_image"
                                    class="form-label fw-semibold"
                                >
                                    Valid ID - Back
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="file"
                                    name="id_back_image"
                                    id="id_back_image"
                                    class="form-control @error('id_back_image') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    required
                                >

                                <div class="form-text">
                                    Upload the back side of your valid ID. Maximum file size: 5MB.
                                </div>

                                @error('id_back_image')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         PRIVACY / VERIFICATION NOTICE
                    ================================================== --}}
                    <div class="alert alert-light border rounded-3 mb-4">

                        <div class="d-flex">

                            <i class="bi bi-shield-lock fs-5 me-2"></i>

                            <div>

                                <strong>
                                    Verification Notice
                                </strong>

                                <p class="text-muted small mb-0 mt-1">
                                    Your submitted information and valid ID images will be reviewed
                                    by the administrator before you can place an online order.
                                    Please make sure that all information and uploaded ID images are
                                    accurate and clearly visible.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         SUBMIT BUTTON
                    ================================================== --}}
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
        ========================================================== --}}
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
        ========================================================== --}}
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