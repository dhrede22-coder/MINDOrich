@extends('admin.layouts.app')

@section('title', 'Customer Details')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Customer Details
            </h4>

            <p class="text-muted mb-0">
                View customer information and verification details.
            </p>
        </div>

        <a
            href="{{ route('admin.customers.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Back to Customers
        </a>

    </div>


    {{-- =========================================================
         SUCCESS MESSAGE
    ========================================================== --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- =========================================================
         CUSTOMER INFORMATION
    ========================================================== --}}
    <div class="row g-4">


        {{-- =====================================================
             LEFT SIDE - CUSTOMER INFORMATION
             ===================================================== --}}
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    {{-- CUSTOMER HEADER --}}
                    <div class="d-flex align-items-center mb-4">

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="
                                width:60px;
                                height:60px;
                                background:#f1f3f5;
                            "
                        >
                            <i
                                class="bi bi-person fs-3 text-primary"
                            ></i>
                        </div>

                        <div>

                            <h5 class="fw-bold mb-1">
                                {{ $user->name }}
                            </h5>

                            <span class="text-muted">
                                Online Customer
                            </span>

                        </div>

                    </div>


                    {{-- EMAIL --}}
                    <div class="mb-3">

                        <label class="text-muted small">
                            Email Address
                        </label>

                        <div class="fw-semibold">
                            {{ $user->email }}
                        </div>

                    </div>


                    {{-- CONTACT NUMBER --}}
                    <div class="mb-3">

                        <label class="text-muted small">
                            Contact Number
                        </label>

                        <div class="fw-semibold">
                            {{ $user->contact_number ?? 'Not provided' }}
                        </div>

                    </div>


                    {{-- =================================================
                         DELIVERY INFORMATION
                    ================================================== --}}
                    <div class="border-top pt-4 mt-4 mb-4">

                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-geo-alt me-2"></i>
                            Delivery Information
                        </h6>


                        {{-- HOUSE / STREET --}}
                        <div class="mb-3">

                            <label class="text-muted small">
                                House / Unit No. & Street
                            </label>

                            <div class="fw-semibold">
                                {{ $user->house_street ?? 'Not provided' }}
                            </div>

                        </div>


                        {{-- BARANGAY --}}
                        <div class="mb-3">

                            <label class="text-muted small">
                                Barangay
                            </label>

                            <div class="fw-semibold">
                                {{ $user->barangay ?? 'Not provided' }}
                            </div>

                        </div>


                        {{-- MUNICIPALITY / CITY --}}
                        <div class="mb-3">

                            <label class="text-muted small">
                                Municipality / City
                            </label>

                            <div class="fw-semibold">
                                {{ $user->municipality_city ?? 'Not provided' }}
                            </div>

                        </div>


                        {{-- PROVINCE --}}
                        <div class="mb-3">

                            <label class="text-muted small">
                                Province
                            </label>

                            <div class="fw-semibold">
                                {{ $user->province ?? 'Not provided' }}
                            </div>

                        </div>


                        {{-- POSTAL CODE --}}
                        <div class="mb-3">

                            <label class="text-muted small">
                                Postal Code
                            </label>

                            <div class="fw-semibold">
                                {{ $user->postal_code ?? 'Not provided' }}
                            </div>

                        </div>


                        {{-- LANDMARK --}}
                        <div class="mb-3">

                            <label class="text-muted small">
                                Landmark
                            </label>

                            <div class="fw-semibold">
                                {{ $user->landmark ?? 'Not provided' }}
                            </div>

                        </div>


                        {{-- LEGACY / COMPLETE ADDRESS --}}
                        <div class="mb-0">

                            <label class="text-muted small">
                                Complete Address
                            </label>

                            <div class="fw-semibold">
                                {{ $user->address ?? 'Not provided' }}
                            </div>

                        </div>

                    </div>


                    {{-- VERIFICATION STATUS --}}
                    <div class="mb-3">

                        <label class="text-muted small d-block mb-1">
                            Verification Status
                        </label>

                        @if($user->verification_status === 'Approved')

                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Approved
                            </span>

                        @elseif($user->verification_status === 'Rejected')

                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle me-1"></i>
                                Rejected
                            </span>

                        @elseif($user->verification_status === 'Under Review')

                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-clock me-1"></i>
                                Under Review
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                Not Verified
                            </span>

                        @endif

                    </div>


                    {{-- VERIFIED DATE --}}
                    @if($user->verified_at)

                        <div class="mb-3">

                            <label class="text-muted small">
                                Verified Date
                            </label>

                            <div class="fw-semibold">
                                {{ \Carbon\Carbon::parse($user->verified_at)->format('F d, Y h:i A') }}
                            </div>

                        </div>

                    @endif


                    {{-- REJECTION NOTES --}}
                    @if($user->verification_notes)

                        <div class="alert alert-danger mt-3">

                            <div class="fw-semibold mb-1">
                                Verification Notes
                            </div>

                            <div>
                                {{ $user->verification_notes }}
                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- =====================================================
             RIGHT SIDE - VERIFICATION
             ===================================================== --}}
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    {{-- VERIFICATION HEADER --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>

                            <h5 class="fw-bold mb-1">
                                Verification Information
                            </h5>

                            <p class="text-muted mb-0">
                                Review the customer's submitted credentials.
                            </p>

                        </div>

                        <i
                            class="bi bi-shield-check text-primary fs-2"
                        ></i>

                    </div>


                    {{-- =================================================
                         ID INFORMATION
                    ================================================== --}}
                    <div class="row g-3 mb-4">

                        <div class="col-md-6">

                            <label class="text-muted small">
                                ID Type
                            </label>

                            <div class="fw-semibold">
                                {{ $user->id_type ?? 'Not provided' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted small">
                                ID Number
                            </label>

                            <div class="fw-semibold">
                                {{ $user->id_number ?? 'Not provided' }}
                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         VALID ID FRONT
                    ================================================== --}}
                    <div class="mb-4">

                        <label class="text-muted small d-block mb-2">
                            Valid ID - Front
                        </label>

                        @php
                            $frontIdImage = $user->id_front_image ?: $user->id_image;
                        @endphp

                        @if($frontIdImage)

                            <div class="border rounded p-2 text-center">

                                <img
                                    src="{{ asset('storage/' . $frontIdImage) }}"
                                    alt="Customer Valid ID Front"
                                    class="img-fluid rounded"
                                    style="
                                        max-height:420px;
                                        width:100%;
                                        object-fit:contain;
                                    "
                                >

                            </div>

                        @else

                            <div class="border rounded p-4 text-center text-muted">

                                <i class="bi bi-image fs-1 d-block mb-2"></i>

                                No valid ID front image has been uploaded.

                            </div>

                        @endif

                    </div>


                    {{-- =================================================
                         VALID ID BACK
                    ================================================== --}}
                    <div class="mb-4">

                        <label class="text-muted small d-block mb-2">
                            Valid ID - Back
                        </label>

                        @if($user->id_back_image)

                            <div class="border rounded p-2 text-center">

                                <img
                                    src="{{ asset('storage/' . $user->id_back_image) }}"
                                    alt="Customer Valid ID Back"
                                    class="img-fluid rounded"
                                    style="
                                        max-height:420px;
                                        width:100%;
                                        object-fit:contain;
                                    "
                                >

                            </div>

                        @else

                            <div class="border rounded p-4 text-center text-muted">

                                <i class="bi bi-image fs-1 d-block mb-2"></i>

                                No valid ID back image has been uploaded.

                            </div>

                        @endif

                    </div>


                    {{-- =================================================
                         APPROVE / REJECT
                    ================================================== --}}
                    @if($user->verification_status !== 'Approved')

                        <div class="border-top pt-4">

                            <h6 class="fw-bold mb-3">
                                Verification Action
                            </h6>


                            <div class="d-flex gap-2">

                                {{-- APPROVE --}}
                                <form
                                    method="POST"
                                    action="{{ route('admin.customers.approve', $user) }}"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                        onclick="return confirm('Are you sure you want to approve this customer?')"
                                    >
                                        <i class="bi bi-check-circle me-1"></i>
                                        Approve
                                    </button>

                                </form>


                                {{-- REJECT --}}
                                <button
                                    type="button"
                                    class="btn btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rejectCustomerModal"
                                >
                                    <i class="bi bi-x-circle me-1"></i>
                                    Reject
                                </button>

                            </div>

                        </div>

                    @else

                        <div class="alert alert-success mb-0">

                            <i class="bi bi-check-circle me-2"></i>

                            This customer has already been approved.

                        </div>

                    @endif

                </div>

            </div>


            {{-- =====================================================
                 CUSTOMER ORDER HISTORY
                 ===================================================== --}}
            <div class="card border-0 shadow-sm mt-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>

                            <h5 class="fw-bold mb-1">
                                Order History
                            </h5>

                            <p class="text-muted mb-0">
                                Previous online orders of this customer.
                            </p>

                        </div>

                        <span class="badge bg-primary">
                            {{ $orders->count() }} Orders
                        </span>

                    </div>


                    @if($orders->count())

                        <div class="table-responsive">

                            <table class="table align-middle mb-0">

                                <thead>

                                    <tr>

                                        <th>Order</th>

                                        <th>Date</th>

                                        <th>Status</th>

                                        <th class="text-end">
                                            Total
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($orders as $order)

                                        <tr>

                                            <td class="fw-semibold">
                                                {{ $order->sale_number }}
                                            </td>

                                            <td>
                                                {{ $order->created_at->format('M d, Y') }}
                                            </td>

                                            <td>

                                                @if($order->status === 'Completed')

                                                    <span class="badge bg-success">
                                                        Completed
                                                    </span>

                                                @elseif($order->status === 'Cancelled')

                                                    <span class="badge bg-danger">
                                                        Cancelled
                                                    </span>

                                                @elseif($order->status === 'Processing')

                                                    <span class="badge bg-info">
                                                        Processing
                                                    </span>

                                                @else

                                                    <span class="badge bg-warning text-dark">
                                                        {{ $order->status }}
                                                    </span>

                                                @endif

                                            </td>

                                            <td class="text-end fw-semibold">
                                                ₱{{ number_format($order->total_amount, 2) }}
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="text-center text-muted py-4">

                            <i class="bi bi-bag-x fs-1 d-block mb-2"></i>

                            This customer has no online orders yet.

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     REJECT CUSTOMER MODAL
     ============================================================= --}}
<div
    class="modal fade"
    id="rejectCustomerModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <form
                method="POST"
                action="{{ route('admin.customers.reject', $user) }}"
            >

                @csrf
                @method('PATCH')

                <div class="modal-header">

                    <h5 class="modal-title fw-bold">
                        Reject Customer Verification
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <div class="modal-body">

                    <p class="text-muted">
                        Please provide a reason for rejecting this customer's verification.
                    </p>

                    <label class="form-label fw-semibold">
                        Rejection Reason
                    </label>

                    <textarea
                        name="verification_notes"
                        class="form-control"
                        rows="4"
                        placeholder="Enter rejection reason..."
                        required
                    ></textarea>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        <i class="bi bi-x-circle me-1"></i>
                        Reject Customer
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection