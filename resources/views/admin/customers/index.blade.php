@extends('admin.layouts.app')

@section('title', 'Customers')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Customers</h2>
            <p class="text-muted mb-0">Manage walk-in and online customers.</p>
        </div>
    </div>

    {{-- CUSTOMER TYPE TABS --}}
    <ul class="nav nav-tabs mb-4" id="customerTabs" role="tablist">

        <li class="nav-item" role="presentation">
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

        <li class="nav-item" role="presentation">
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

                @if($onlineCustomers->where('verification_status', 'Under Review')->count() > 0)
                    <span class="badge bg-warning text-dark ms-1">
                        {{ $onlineCustomers->where('verification_status', 'Under Review')->count() }}
                    </span>
                @endif
            </button>
        </li>

    </ul>

    {{-- TAB CONTENT --}}
    <div class="tab-content" id="customerTabsContent">

        {{-- WALK-IN CUSTOMERS --}}
        <div
            class="tab-pane fade {{ request('tab') !== 'online' ? 'show active' : '' }}"
            id="walkin"
            role="tabpanel"
        >
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">Walk-in Customers</h5>
                            <p class="text-muted small mb-0">
                                Customers served directly at the store.
                            </p>
                        </div>

                        <a href="{{ request()->fullUrlWithQuery([
                            'walkin_all' => 1,
                            'tab' => 'walkin'
                        ]) }}"
                           class="btn btn-outline-primary">
                            <i class="bi bi-people me-2"></i>
                            See All Customers
                        </a>
                    </div>

                    @if($walkInCustomers->count() > 0)
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>CUSTOMER</th>
                                        <th>CONTACT</th>
                                        <th>DATE</th>
                                        <th class="text-end">ACTION</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($walkInCustomers as $customer)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $customer->user->name ?? 'Walk-in Customer' }}
                                                </div>
                                                <div class="text-muted small">
                                                    {{ $customer->sale_number }}
                                                </div>
                                            </td>

                                            <td>
                                                {{ $customer->user->contact_number ?? '—' }}
                                            </td>

                                            <td>
                                                {{ $customer->created_at->format('M d, Y') }}
                                            </td>

                                            <td class="text-end">
                                                <a
                                                    href="{{ route('orders.show', $customer) }}"
                                                    class="btn btn-sm btn-primary"
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
                            <i class="bi bi-shop fs-1 text-muted"></i>
                            <h6 class="fw-bold mt-3">No walk-in customers yet</h6>
                            <p class="text-muted mb-0">
                                Walk-in customers will appear here.
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ONLINE CUSTOMERS --}}
        <div
            class="tab-pane fade {{ request('tab') === 'online' ? 'show active' : '' }}"
            id="online"
            role="tabpanel"
        >
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">Online Customers</h5>
                            <p class="text-muted small mb-0">
                                Customers registered through the online marketplace.
                            </p>
                        </div>

                        <a href="{{ request()->fullUrlWithQuery([
                            'online_all' => 1,
                            'tab' => 'online'
                        ]) }}"
                           class="btn btn-outline-primary">
                            <i class="bi bi-people me-2"></i>
                            See All Customers
                        </a>
                    </div>

                    @if($onlineCustomers->count() > 0)
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>CUSTOMER</th>
                                        <th>EMAIL</th>
                                        <th>CONTACT</th>
                                        <th>VERIFICATION</th>
                                        <th>REGISTERED</th>
                                        <th class="text-end">ACTION</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($onlineCustomers as $customer)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $customer->name }}
                                                </div>
                                            </td>

                                            <td>{{ $customer->email }}</td>

                                            <td>
                                                {{ $customer->contact_number ?? '—' }}
                                            </td>

                                            <td>
                                                @if($customer->verification_status === 'Approved')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        Approved
                                                    </span>
                                                @elseif($customer->verification_status === 'Under Review')
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="bi bi-clock me-1"></i>
                                                        Under Review
                                                    </span>
                                                @elseif($customer->verification_status === 'Rejected')
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle me-1"></i>
                                                        Rejected
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $customer->created_at->format('M d, Y') }}
                                            </td>

                                            <td class="text-end">
                                                <a
                                                    href="{{ route('admin.customers.show', $customer) }}"
                                                    class="btn btn-sm btn-primary"
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
                            <i class="bi bi-people fs-1 text-muted"></i>
                            <h6 class="fw-bold mt-3">No online customers yet</h6>
                            <p class="text-muted mb-0">
                                Registered online customers will appear here.
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
