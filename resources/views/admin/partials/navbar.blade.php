@php

    // Pending Orders
    $pendingOrders = \App\Models\Sale::where(
        'status',
        'Pending'
    )->count();


    // Pending Customer Validation
    $pendingCustomers = \App\Models\User::whereHas(
        'role',
        function ($query) {
            $query->where('name', 'Customer');
        }
    )
    ->where(
        'verification_status',
        'Pending'
    )
    ->count();

@endphp


<nav class="top-navbar">

    <div class="d-flex align-items-center gap-3 ms-auto">


        <!-- =====================================================
             NOTIFICATIONS
        ====================================================== -->

        <div class="dropdown">

            <button
                type="button"
                class="btn btn-light border rounded-circle position-relative"
                style="width:45px;height:45px;"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >

                <i class="bi bi-bell fs-5"></i>


                @if($pendingOrders + $pendingCustomers > 0)

                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                    >

                        {{ $pendingOrders + $pendingCustomers }}

                    </span>

                @endif

            </button>


            <!-- Notification Dropdown -->

            <div
                class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-0"
                style="width:350px;"
            >


                <!-- Header -->

                <div class="p-3 border-bottom">

                    <h6 class="fw-bold mb-1">
                        Notifications
                    </h6>

                    <small class="text-muted">
                        Admin notifications
                    </small>

                </div>


                <!-- =================================================
                     PENDING ORDERS
                ================================================== -->

                @if($pendingOrders > 0)

                    <div class="p-3 border-bottom">

                        <div class="d-flex align-items-start gap-3">


                            <!-- Icon -->

                            <div
                                class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center"
                                style="width:42px;height:42px;min-width:42px;"
                            >

                                <i class="bi bi-cart-check fs-5"></i>

                            </div>


                            <!-- Message -->

                            <div class="flex-grow-1">

                                <h6 class="fw-semibold mb-1">

                                    Pending Orders

                                </h6>


                                <p class="text-muted small mb-2">

                                    You have

                                    <strong>
                                        {{ $pendingOrders }}
                                    </strong>

                                    pending

                                    {{ $pendingOrders == 1 ? 'order' : 'orders' }}.

                                </p>


                                <a
                                    href="{{ route('orders.index') }}"
                                    class="text-warning text-decoration-none fw-semibold small"
                                >

                                    View Orders

                                    <i class="bi bi-arrow-right ms-1"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                @endif


                <!-- =================================================
                     PENDING CUSTOMER VALIDATION
                ================================================== -->

                @if($pendingCustomers > 0)

                    <div class="p-3">

                        <div class="d-flex align-items-start gap-3">


                            <!-- Icon -->

                            <div
                                class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                style="width:42px;height:42px;min-width:42px;"
                            >

                                <i class="bi bi-person-check fs-5"></i>

                            </div>


                            <!-- Message -->

                            <div class="flex-grow-1">

                                <h6 class="fw-semibold mb-1">

                                    Pending Customer Validation

                                </h6>


                                <p class="text-muted small mb-2">

                                    You have

                                    <strong>
                                        {{ $pendingCustomers }}
                                    </strong>

                                    customer

                                    {{ $pendingCustomers == 1 ? 'account' : 'accounts' }}

                                    waiting for validation.

                                </p>


                                <a
                                    href="{{ route('admin.customers.index') }}"
                                    class="text-primary text-decoration-none fw-semibold small"
                                >

                                    View Customers

                                    <i class="bi bi-arrow-right ms-1"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                @endif


                <!-- =================================================
                     NO NOTIFICATIONS
                ================================================== -->

                @if($pendingOrders == 0 && $pendingCustomers == 0)

                    <div class="text-center p-4">

                        <i
                            class="bi bi-check-circle text-success fs-2"
                        ></i>


                        <h6 class="fw-semibold mt-2 mb-1">

                            All caught up!

                        </h6>


                        <p class="text-muted small mb-0">

                            There are no pending notifications.

                        </p>

                    </div>

                @endif


            </div>

        </div>


        <!-- =====================================================
             PROFILE
        ====================================================== -->

        <div class="dropdown">

            <button
                type="button"
                class="btn btn-light border rounded-pill dropdown-toggle px-3"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >

                <i class="bi bi-person-circle me-2"></i>

                {{ auth()->user()->name }}

            </button>


            <ul
                class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4"
            >

                <li>

                    <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">

                        <i class="bi bi-person me-2"></i>

                        My Profile

                    </a>

                </li>


                <li>

                    <a class="dropdown-item" href="{{ route('settings.index') }}">
    <i class="bi bi-gear me-2"></i>
    Settings
</a>

                </li>


                <li>

                    <hr class="dropdown-divider">

                </li>


                <li>

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >

                        @csrf

                        <button
                            class="dropdown-item text-danger"
                        >

                            <i class="bi bi-box-arrow-right me-2"></i>

                            Logout

                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</nav>