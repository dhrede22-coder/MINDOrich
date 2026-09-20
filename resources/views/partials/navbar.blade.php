<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top public-navbar">
    <div class="container">

        <!-- Logo / Brand -->
        <a class="navbar-brand d-flex align-items-center gap-1" href="/">

            <img
                src="{{ asset('image/logo/mindorich-logo.png') }}"
                alt="MINDOrich Logo"
                class="public-navbar-logo"
            >

            <div class="d-flex flex-column public-navbar-brand-text"
     style="margin-left:-4px;">

                <h3 class="fw-bold text-warning mb-0 public-navbar-title">
                    INDOrich
                </h3>

                <small class="text-muted public-navbar-subtitle">
                    Pampamayanang Mangyan Ugnayan Inc.
                </small>

            </div>

        </a>


        <!-- Mobile Toggle -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>


        <!-- Navigation -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link active" href="/">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/about">
                        About
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/tribes">
                        Mangyan Tribes
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/marketplace">
                        Marketplace
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/contact">
                        Contact
                    </a>
                </li>

                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <a
                        href="{{ route('login') }}"
                        class="btn btn-warning px-4 public-login-btn"
                    >
                        Login
                    </a>
                </li>

            </ul>

        </div>

    </div>
</nav>


<style>
    .public-navbar-logo {
        width: 60px;
        height: auto;
        flex-shrink: 0;
    }

    .public-navbar-title {
        line-height: 1;
        font-size: 1.75rem;
    }

    .public-navbar-subtitle {
        line-height: 1.1;
        font-size: 0.75rem;
        max-width: 260px;
    }

    .public-navbar .nav-link {
        white-space: nowrap;
    }

    .public-login-btn {
        white-space: nowrap;
    }

    @media (max-width: 991.98px) {
        .public-navbar .navbar-collapse {
            padding-top: 1rem;
            padding-bottom: 0.5rem;
        }

        .public-navbar .navbar-nav {
            align-items: stretch !important;
        }

        .public-navbar .nav-item {
            margin-bottom: 0.25rem;
        }

        .public-navbar .nav-link {
            padding: 0.6rem 0.75rem;
        }

        .public-login-btn {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 575.98px) {
        .public-navbar {
            padding-top: 0.55rem;
            padding-bottom: 0.55rem;
        }

        .public-navbar-logo {
            width: 46px;
        }

        .public-navbar-title {
            font-size: 1.4rem;
        }

        .public-navbar-subtitle {
            font-size: 0.62rem;
            max-width: 170px;
        }

        .public-navbar-brand-text {
            min-width: 0;
        }

        .public-navbar .navbar-toggler {
            padding: 0.35rem 0.5rem;
        }
    }
</style>