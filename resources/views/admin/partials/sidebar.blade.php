<aside class="sidebar">

   <!-- Logo -->
<div class="logo-area">

    <a href="{{ url('/') }}" class="logo-brand">

        <img src="{{ asset('image/logo/mindorich-logo.png') }}"
             alt="MINDOrich"
             class="logo-img">

        <span class="logo-title">
            INDOrich
        </span>

    </a>

</div>

    <!-- Menu -->

    <ul class="sidebar-menu">

        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                <i class="bi bi-grid"></i>

                Dashboard

            </a>
        </li>

       <li>

    <a href="{{ route('producers.index') }}"
       class="{{ request()->routeIs('producers.*') ? 'active' : '' }}">

        <i class="bi bi-people"></i>

        Producers

    </a>

</li>
<li>
    <a href="{{ route('products.index') }}"
       class="{{ request()->routeIs('products.*') ? 'active' : '' }}">

        <i class="bi bi-box-seam"></i>

        Products

    </a>
</li>

        <li>

            <a href="{{ route('orders.index') }}"
   class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">

    <i class="bi bi-cart3"></i>

    Orders

</a>

        </li>

        <li>

            <a href="{{ route('admin.customers.index') }}"
   class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
    <i class="bi bi-people"></i>
    <span>Customers</span>
</a>

        </li>

        <li>

            <a href="{{ route('admin.reports.index') }}"
   class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
    <i class="bi bi-bar-chart-line"></i>
    <span>Reports</span>
</a>

        </li>

        <li>

            <a href="{{ route('admin.analytics.index') }}"
   class="{{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
    <i class="bi bi-bar-chart-line"></i>
    <span>Analytics</span>
</a>

        </li>

        <li>

            <a href="#">

                <i class="bi bi-megaphone"></i>

                Announcements

            </a>

        </li>

        <li>

    <a href="{{ route('settings.index') }}"
       class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">

        <i class="bi bi-gear"></i>

        Settings

    </a>

</li>

    </ul>

</aside>