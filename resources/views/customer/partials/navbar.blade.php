<nav class="top-navbar sticky-top">

    {{-- LOGO --}}
    <div>
        <a href="{{ route('dashboard') }}"
           class="d-flex align-items-center text-decoration-none customer-brand">

            <img
                src="{{ asset('image/logo/mindorich-logo.png') }}"
                width="60"
                alt="MINDOrich"
            >

            <div class="d-flex flex-column ms-0" style="margin-left:-4px;">
                <h3 class="fw-bold text-warning mb-0" style="line-height:1;">
                    INDOrich
                </h3>

                <small class="text-muted mt-0 pt-0" style="line-height:1;">
                    Pampamayanang Mangyan Ugnayan Inc.
                </small>
            </div>

        </a>
    </div>


    {{-- MOBILE MENU BUTTON --}}
    <button
        class="customer-mobile-menu-btn"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#customerMobileMenu"
        aria-controls="customerMobileMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <i class="bi bi-list"></i>
    </button>


    {{-- NAVIGATION --}}
    <div class="customer-nav-wrapper collapse" id="customerMobileMenu">

        <div class="d-flex align-items-center gap-3 customer-nav-inner">

            <a href="{{ route('customer.dashboard') }}"
               class="customer-nav-link">
                Home
            </a>

            <a href="{{ route('customer.shop') }}"
               class="customer-nav-link">
                Shop
            </a>

            <a href="{{ route('customer.orders') }}"
               class="customer-nav-link">
                Order
            </a>

            <a href="{{ route('customer.cart') }}"
               class="customer-nav-link">
                Cart
            </a>


            {{-- NOTIFICATION --}}
            <div class="dropdown">

                <button
                    class="notification-btn"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >

                    <i class="bi bi-bell"></i>

                    {{-- Notification Count --}}
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="notification-badge">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif

                </button>


                {{-- Notification Dropdown --}}
                <ul class="dropdown-menu dropdown-menu-end notification-menu shadow border-0 rounded-4">

                    <li class="notification-header">
                        <strong>Notifications</strong>
                    </li>

                    @if(auth()->user()->unreadNotifications->count() > 0)

                        @foreach(auth()->user()->unreadNotifications->take(5) as $notification)

                            <li class="notification-item">

                                <form
                                    action="{{ route('customer.notifications.read', $notification->id) }}"
                                    method="POST"
                                    class="m-0"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn btn-link text-decoration-none text-dark d-block w-100 text-start p-0"
                                    >

                                        <div class="fw-semibold">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                        </div>

                                        <div class="small text-muted mt-1">
                                            {{ $notification->data['message'] ?? '' }}
                                        </div>

                                        <div class="small text-muted mt-1">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>

                                    </button>
                                </form>

                            </li>

                        @endforeach

                    @else

                        <li>
                            <div class="notification-empty">
                                <i class="bi bi-bell-slash"></i>

                                <p class="mb-0">
                                    No new notifications
                                </p>
                            </div>
                        </li>

                    @endif

                </ul>

            </div>


            {{-- CUSTOMER PROFILE --}}
            <div class="dropdown">

                <button
                    type="button"
                    class="customer-profile-btn"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >

                    <i class="bi bi-person-circle me-2"></i>

                    {{ auth()->user()->name }}

                </button>


                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4">

                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person me-2"></i>
                            My Profile
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('customer.settings') }}">
                            <i class="bi bi-gear me-2"></i>
                            Settings
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button
                                type="submit"
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

    </div>

</nav>