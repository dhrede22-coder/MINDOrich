@extends('admin.layouts.app')

@section('title', 'Customers')

@section('content')

<style>

/* =========================================================
   MINDOrich CUSTOMERS
========================================================= */

.customers-page {
    padding-bottom: 2rem;
}

/* ---------------------------------------------------------
   HEADER
--------------------------------------------------------- */

.customers-header {
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

.customers-header-icon {
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

.customers-header h4 {
    color: #1f2937;
}

.customers-header p {
    font-size: 0.9rem;
}

/* ---------------------------------------------------------
   SECTION
--------------------------------------------------------- */

.customer-section-icon {
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

.customer-section-title {
    font-size: 0.98rem;
    font-weight: 700;

    color: #1f2937;

    margin-bottom: 0.1rem;
}

.customer-section-subtitle {
    font-size: 0.78rem;

    color: #6b7280;

    margin-bottom: 0;
}

/* ---------------------------------------------------------
   KPI CARDS
--------------------------------------------------------- */

.customer-kpi {
    position: relative;

    height: 100%;

    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 14px;

    padding: 1rem 1.1rem;

    box-shadow: 0 3px 10px rgba(31, 41, 55, 0.035);

    overflow: hidden;
}

.customer-kpi::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;
    bottom: 0;

    width: 4px;

    background: #c88a2b;
}

.customer-kpi.success::before {
    background: #198754;
}

.customer-kpi.info::before {
    background: #0d6efd;
}

.customer-kpi.warning::before {
    background: #c88a2b;
}

.customer-kpi.neutral::before {
    background: #6b7280;
}

.customer-kpi-label {
    color: #6b7280;

    font-size: 0.76rem;
    font-weight: 600;

    margin-bottom: 0.25rem;
}

.customer-kpi-value {
    color: #1f2937;

    font-size: 1.45rem;
    font-weight: 700;

    line-height: 1.2;
}

.customer-kpi-icon {
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
   TABS
--------------------------------------------------------- */

.customers-tabs-wrapper {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);

    border-radius: 14px;

    padding: 0.35rem;

    box-shadow: 0 3px 10px rgba(31, 41, 55, 0.035);
}

.customers-tabs {
    border-bottom: 0;
}

.customers-tabs .nav-link {
    border: 0;

    border-radius: 10px;

    color: #6b7280;

    font-size: 0.8rem;
    font-weight: 600;

    padding: 0.65rem 1rem;
}

.customers-tabs .nav-link:hover {
    color: #2f5d50;
    background: #faf7f2;
}

.customers-tabs .nav-link.active {
    background: #2f5d50;
    color: #ffffff;
}

.customer-tab-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-width: 20px;
    height: 20px;

    padding: 0 0.35rem;

    border-radius: 999px;

    font-size: 0.65rem;

    background: rgba(200, 138, 43, 0.15);
    color: #a86f1f;
}

.customers-tabs .nav-link.active .customer-tab-count {
    background: rgba(255, 255, 255, 0.18);
    color: #ffffff;
}

/* ---------------------------------------------------------
   DIRECTORY CARD
--------------------------------------------------------- */

.customers-directory-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);

    overflow: hidden;
}

.customers-directory-header {
    padding: 1.1rem 1.25rem;

    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 1rem;

    border-bottom: 1px solid rgba(31, 41, 55, 0.06);
}

.customers-see-all-btn {
    border-radius: 9px;

    font-size: 0.78rem;
    font-weight: 600;
}

/* ---------------------------------------------------------
   TABLE
--------------------------------------------------------- */

.customers-table-wrapper {
    overflow-x: auto;
}

.customers-table {
    margin-bottom: 0;
}

.customers-table thead th {
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

.customers-table tbody td {
    padding: 0.9rem 1rem;

    color: #374151;

    font-size: 0.82rem;

    border-color: rgba(31, 41, 55, 0.06);

    vertical-align: middle;
}

.customers-table tbody tr:last-child td {
    border-bottom: 0;
}

.customers-table tbody tr:hover {
    background: #faf7f2;
}

/* ---------------------------------------------------------
   CUSTOMER NAME
--------------------------------------------------------- */

.customer-name-wrapper {
    display: flex;
    align-items: center;
    gap: 0.7rem;
}

.customer-avatar {
    width: 36px;
    height: 36px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: rgba(47, 93, 80, 0.10);

    color: #2f5d50;

    font-weight: 700;

    flex-shrink: 0;
}

.customer-name {
    color: #1f2937;

    font-weight: 700;

    font-size: 0.82rem;
}

.customer-reference {
    color: #6b7280;

    font-size: 0.7rem;
}

/* ---------------------------------------------------------
   CONTACT
--------------------------------------------------------- */

.customer-contact {
    color: #4b5563;

    white-space: nowrap;
}

.customer-contact i {
    color: #6b7280;
}

/* ---------------------------------------------------------
   DATE
--------------------------------------------------------- */

.customer-date {
    color: #4b5563;

    white-space: nowrap;
}

.customer-date i {
    color: #6b7280;
}

/* ---------------------------------------------------------
   VERIFICATION
--------------------------------------------------------- */

.customer-status {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;

    padding: 0.38rem 0.65rem;

    border-radius: 999px;

    font-size: 0.68rem;

    font-weight: 700;

    white-space: nowrap;
}

.customer-status-dot {
    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: currentColor;
}

.customer-status.approved {
    background: rgba(25, 135, 84, 0.10);
    color: #198754;
}

.customer-status.review {
    background: rgba(200, 138, 43, 0.12);
    color: #a86f1f;
}

.customer-status.rejected {
    background: rgba(220, 53, 69, 0.08);
    color: #dc3545;
}

.customer-status.pending {
    background: rgba(108, 117, 125, 0.10);
    color: #6c757d;
}

/* ---------------------------------------------------------
   ACTION
--------------------------------------------------------- */

.customer-view-btn {
    width: 34px;
    height: 34px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: rgba(47, 93, 80, 0.08);

    color: #2f5d50;

    border: 1px solid transparent;

    font-size: 0.82rem;
}

.customer-view-btn:hover {
    background: #2f5d50;
    color: #ffffff;
}

/* ---------------------------------------------------------
   EMPTY STATE
--------------------------------------------------------- */

.customer-empty-icon {
    width: 56px;
    height: 56px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 14px;

    background: #f8f9fa;

    color: #9ca3af;

    font-size: 1.4rem;
}

/* ---------------------------------------------------------
   RESPONSIVE
--------------------------------------------------------- */

@media (max-width: 767.98px) {

    .customers-header {
        padding: 1rem;
    }

    .customers-directory-header {
        align-items: flex-start;

        flex-direction: column;
    }

    .customers-tabs .nav-link {
        padding: 0.55rem 0.7rem;
    }

}

</style>


<div class="container-fluid customers-page">


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="customers-header mb-4">

        <div class="d-flex align-items-center gap-3">

            <div class="customers-header-icon">

                <i class="bi bi-people-fill"></i>

            </div>

            <div>

                <h4 class="fw-bold mb-1">
                    Customers
                </h4>

                <p class="text-muted mb-0">
                    Manage walk-in and online customers.
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
         CUSTOMER OVERVIEW
    ====================================================== --}}

    <div class="mb-4">

        <div class="d-flex align-items-center gap-2 mb-3">

            <div class="customer-section-icon">

                <i class="bi bi-bar-chart-line-fill"></i>

            </div>

            <div>

                <div class="customer-section-title">
                    Customer Overview
                </div>

                <p class="customer-section-subtitle">
                    Quick summary of your walk-in and online customers.
                </p>

            </div>

        </div>


        <div class="row g-3">


            {{-- WALK-IN --}}

            <div class="col-xl-3 col-md-6">

                <div class="customer-kpi">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="customer-kpi-label">
                                Walk-in Customers
                            </div>

                            <div class="customer-kpi-value">
                                {{ $walkInCustomers->count() }}
                            </div>

                        </div>

                        <div class="customer-kpi-icon">

                            <i class="bi bi-shop"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ONLINE --}}

            <div class="col-xl-3 col-md-6">

                <div class="customer-kpi info">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="customer-kpi-label">
                                Online Customers
                            </div>

                            <div class="customer-kpi-value">
                                {{ $onlineCustomers->count() }}
                            </div>

                        </div>

                        <div class="customer-kpi-icon">

                            <i class="bi bi-globe"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- UNDER REVIEW --}}

            <div class="col-xl-3 col-md-6">

                <div class="customer-kpi warning">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="customer-kpi-label">
                                Under Review
                            </div>

                            <div class="customer-kpi-value">

                                {{ $onlineCustomers->where(
                                    'verification_status',
                                    'Under Review'
                                )->count() }}

                            </div>

                        </div>

                        <div class="customer-kpi-icon">

                            <i class="bi bi-clock-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- APPROVED --}}

            <div class="col-xl-3 col-md-6">

                <div class="customer-kpi success">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="customer-kpi-label">
                                Approved
                            </div>

                            <div class="customer-kpi-value">

                                {{ $onlineCustomers->where(
                                    'verification_status',
                                    'Approved'
                                )->count() }}

                            </div>

                        </div>

                        <div class="customer-kpi-icon">

                            <i class="bi bi-check-circle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>


    {{-- =====================================================
         CUSTOMER TYPE TABS
    ====================================================== --}}

    <div class="customers-tabs-wrapper mb-4">

        <ul
            class="nav nav-tabs customers-tabs"
            id="customerTabs"
            role="tablist"
        >


            {{-- WALK-IN TAB --}}

            <li
                class="nav-item"
                role="presentation"
            >

                <button
                    class="nav-link {{ request('tab') !== 'online' ? 'active' : '' }}"
                    id="walkin-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#walkin"
                    type="button"
                    role="tab"
                >

                    <i class="bi bi-shop me-2"></i>

                    Walk-in Customers

                </button>

            </li>


            {{-- ONLINE TAB --}}

            <li
                class="nav-item"
                role="presentation"
            >

                <button
                    class="nav-link {{ request('tab') === 'online' ? 'active' : '' }}"
                    id="online-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#online"
                    type="button"
                    role="tab"
                >

                    <i class="bi bi-globe me-2"></i>

                    Online Customers


                    @if(
                        $onlineCustomers
                            ->where('verification_status', 'Under Review')
                            ->count() > 0
                    )

                        <span class="customer-tab-count ms-1">

                            {{ $onlineCustomers
                                ->where('verification_status', 'Under Review')
                                ->count()
                            }}

                        </span>

                    @endif

                </button>

            </li>


        </ul>

    </div>


    {{-- =====================================================
         TAB CONTENT
    ====================================================== --}}

    <div
        class="tab-content"
        id="customerTabsContent"
    >


        {{-- =================================================
             WALK-IN CUSTOMERS
        ================================================== --}}

        <div
            class="tab-pane fade {{ request('tab') !== 'online' ? 'show active' : '' }}"
            id="walkin"
            role="tabpanel"
        >

            <div class="customers-directory-card">


                {{-- HEADER --}}

                <div class="customers-directory-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="customer-section-icon">

                            <i class="bi bi-shop"></i>

                        </div>

                        <div>

                            <div class="customer-section-title">
                                Walk-in Customers
                            </div>

                            <p class="customer-section-subtitle">
                                Customers served directly at the store.
                            </p>

                        </div>

                    </div>


                    <a
                        href="{{ request()->fullUrlWithQuery([
                            'walkin_all' => 1,
                            'tab' => 'walkin'
                        ]) }}"
                        class="btn btn-outline-primary customers-see-all-btn"
                    >

                        <i class="bi bi-people me-2"></i>

                        See All Customers

                    </a>

                </div>


                @if($walkInCustomers->count() > 0)

                    <div class="customers-table-wrapper">

                        <table class="table customers-table align-middle">

                            <thead>

                                <tr>

                                    <th>
                                        Customer
                                    </th>

                                    <th>
                                        Contact
                                    </th>

                                    <th>
                                        Date
                                    </th>

                                    <th class="text-end">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($walkInCustomers as $customer)

                                    <tr>


                                        {{-- CUSTOMER --}}

                                        <td>

                                            <div class="customer-name-wrapper">

                                                <div class="customer-avatar">

                                                    <i class="bi bi-person-fill"></i>

                                                </div>

                                                <div>

                                                    <div class="customer-name">

                                                        {{ $customer->user->name ?? 'Walk-in Customer' }}

                                                    </div>

                                                    <div class="customer-reference">

                                                        {{ $customer->sale_number }}

                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- CONTACT --}}

                                        <td>

                                            <span class="customer-contact">

                                                <i class="bi bi-telephone me-1"></i>

                                                {{ $customer->user->contact_number ?? '—' }}

                                            </span>

                                        </td>


                                        {{-- DATE --}}

                                        <td>

                                            <span class="customer-date">

                                                <i class="bi bi-calendar3 me-1"></i>

                                                {{ $customer->created_at->format('M d, Y') }}

                                            </span>

                                        </td>


                                        {{-- ACTION --}}

                                        <td class="text-end">

                                            <a
                                                href="{{ route('orders.show', $customer) }}"
                                                class="customer-view-btn"
                                                title="View Order"
                                            >

                                                <i class="bi bi-eye"></i>

                                            </a>

                                        </td>


                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-5">

                        <div class="customer-empty-icon mx-auto mb-3">

                            <i class="bi bi-shop"></i>

                        </div>

                        <h6 class="fw-bold">
                            No walk-in customers yet
                        </h6>

                        <p class="text-muted mb-0">
                            Walk-in customers will appear here.
                        </p>

                    </div>

                @endif


            </div>

        </div>


        {{-- =================================================
             ONLINE CUSTOMERS
        ================================================== --}}

        <div
            class="tab-pane fade {{ request('tab') === 'online' ? 'show active' : '' }}"
            id="online"
            role="tabpanel"
        >

            <div class="customers-directory-card">


                {{-- HEADER --}}

                <div class="customers-directory-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="customer-section-icon">

                            <i class="bi bi-globe"></i>

                        </div>

                        <div>

                            <div class="customer-section-title">
                                Online Customers
                            </div>

                            <p class="customer-section-subtitle">
                                Customers registered through the online marketplace.
                            </p>

                        </div>

                    </div>


                    <a
                        href="{{ request()->fullUrlWithQuery([
                            'online_all' => 1,
                            'tab' => 'online'
                        ]) }}"
                        class="btn btn-outline-primary customers-see-all-btn"
                    >

                        <i class="bi bi-people me-2"></i>

                        See All Customers

                    </a>

                </div>


                @if($onlineCustomers->count() > 0)

                    <div class="customers-table-wrapper">

                        <table class="table customers-table align-middle">

                            <thead>

                                <tr>

                                    <th>
                                        Customer
                                    </th>

                                    <th>
                                        Email
                                    </th>

                                    <th>
                                        Contact
                                    </th>

                                    <th>
                                        Verification
                                    </th>

                                    <th>
                                        Registered
                                    </th>

                                    <th class="text-end">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($onlineCustomers as $customer)

                                    <tr>


                                        {{-- CUSTOMER --}}

                                        <td>

                                            <div class="customer-name-wrapper">

                                                <div class="customer-avatar">

                                                    <i class="bi bi-person-fill"></i>

                                                </div>

                                                <div>

                                                    <div class="customer-name">

                                                        {{ $customer->name }}

                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- EMAIL --}}

                                        <td>

                                            <span class="customer-contact">

                                                <i class="bi bi-envelope me-1"></i>

                                                {{ $customer->email }}

                                            </span>

                                        </td>


                                        {{-- CONTACT --}}

                                        <td>

                                            <span class="customer-contact">

                                                <i class="bi bi-telephone me-1"></i>

                                                {{ $customer->contact_number ?? '—' }}

                                            </span>

                                        </td>


                                        {{-- VERIFICATION --}}

                                        <td>

                                            @if($customer->verification_status === 'Approved')

                                                <span class="customer-status approved">

                                                    <span class="customer-status-dot"></span>

                                                    Approved

                                                </span>

                                            @elseif($customer->verification_status === 'Under Review')

                                                <span class="customer-status review">

                                                    <span class="customer-status-dot"></span>

                                                    Under Review

                                                </span>

                                            @elseif($customer->verification_status === 'Rejected')

                                                <span class="customer-status rejected">

                                                    <span class="customer-status-dot"></span>

                                                    Rejected

                                                </span>

                                            @else

                                                <span class="customer-status pending">

                                                    <span class="customer-status-dot"></span>

                                                    Pending

                                                </span>

                                            @endif

                                        </td>


                                        {{-- REGISTERED --}}

                                        <td>

                                            <span class="customer-date">

                                                <i class="bi bi-calendar3 me-1"></i>

                                                {{ $customer->created_at->format('M d, Y') }}

                                            </span>

                                        </td>


                                        {{-- ACTION --}}

                                        <td class="text-end">

                                            <a
                                                href="{{ route('admin.customers.show', $customer) }}"
                                                class="customer-view-btn"
                                                title="View Customer"
                                            >

                                                <i class="bi bi-eye"></i>

                                            </a>

                                        </td>


                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-5">

                        <div class="customer-empty-icon mx-auto mb-3">

                            <i class="bi bi-people"></i>

                        </div>

                        <h6 class="fw-bold">
                            No online customers yet
                        </h6>

                        <p class="text-muted mb-0">
                            Registered online customers will appear here.
                        </p>

                    </div>

                @endif


            </div>

        </div>


    </div>

</div>

@endsection