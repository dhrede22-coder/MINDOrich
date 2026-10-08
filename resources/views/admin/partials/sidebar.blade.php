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

        {{-- Dashboard --}}
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                <i class="bi bi-grid"></i>

                Dashboard

            </a>
        </li>


        {{-- Producers --}}
        <li>

            <a href="{{ route('producers.index') }}"
               class="{{ request()->routeIs('producers.*') ? 'active' : '' }}">

                <i class="bi bi-people"></i>

                Producers

            </a>

        </li>


        {{-- Products --}}
        <li>

            <a href="{{ route('products.index') }}"
               class="{{ request()->routeIs('products.*') ? 'active' : '' }}">

                <i class="bi bi-box-seam"></i>

                Products

            </a>

        </li>


        {{-- Categories --}}
        <li>

            <a href="{{ route('categories.index') }}"
               class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">

                <i class="bi bi-tags"></i>

                Categories

            </a>

        </li>


        {{-- Purchases --}}
        <li>

            <a href="{{ route('admin.purchases.index') }}"
               class="{{ request()->routeIs('admin.purchases.*') ? 'active' : '' }}">

                <i class="bi bi-bag-check"></i>

                Purchases

            </a>

        </li>


        {{-- Expenses --}}
        <li>

            <a href="{{ route('expenses.index') }}"
               class="{{ request()->routeIs('expenses.*') ? 'active' : '' }}">

                <i class="bi bi-wallet2"></i>

                <span>Expenses</span>

            </a>

        </li>


        {{-- Historical Records --}}
        <li class="mt-2">

            <a href="javascript:void(0);"
               onclick="toggleHistoricalRecords()">

                <i class="bi bi-clock-history"></i>

                <span>Historical Records</span>

                <i id="historicalRecordsArrow"
                   class="bi bi-chevron-down ms-auto"></i>

            </a>


            <ul id="historicalRecordsMenu"
                style="
                    display: none;
                    list-style: none;
                    padding-left: 20px;
                    margin-top: 5px;
                ">

                {{-- Historical Purchases --}}
                <li>

                    <a href="{{ route('historical-purchases.index') }}"
                       class="{{ request()->routeIs('historical-purchases.*') ? 'active' : '' }}">

                        <i class="bi bi-clock-history"></i>

                        <span>Historical Purchases</span>

                    </a>

                </li>


                {{-- Historical Sales --}}
               <li>
    <a href="{{ route('historical-sales.index') }}"
       class="{{ request()->routeIs('historical-sales.*') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i>
        <span>Historical Sales</span>
    </a>
</li>

            </ul>

        </li>


        {{-- Orders --}}
        <li>

            <a href="{{ route('orders.index') }}"
               class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">

                <i class="bi bi-cart3"></i>

                Orders

            </a>

        </li>


        {{-- Customers --}}
        <li>

            <a href="{{ route('admin.customers.index') }}"
               class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">

                <i class="bi bi-people"></i>

                <span>Customers</span>

            </a>

        </li>


        {{-- Reports --}}
        <li>

            <a href="{{ route('admin.reports.index') }}"
               class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">

                <i class="bi bi-file-earmark-bar-graph"></i>

                <span>Reports</span>

            </a>

        </li>


        {{-- Analytics --}}
        <li>

            <a href="{{ route('admin.analytics.index') }}"
               class="{{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">

                <i class="bi bi-graph-up-arrow"></i>

                <span>Analytics</span>

            </a>

        </li>


        {{-- Announcements --}}
        <li>

            <a href="#">

                <i class="bi bi-megaphone"></i>

                Announcements

            </a>

        </li>


        {{-- Settings --}}
        <li>

            <a href="{{ route('settings.index') }}"
               class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">

                <i class="bi bi-gear"></i>

                Settings

            </a>

        </li>

    </ul>

</aside>


<script>

function toggleHistoricalRecords() {

    const menu = document.getElementById('historicalRecordsMenu');
    const arrow = document.getElementById('historicalRecordsArrow');

    if (menu.style.display === 'none') {

        menu.style.display = 'block';

        arrow.classList.remove('bi-chevron-down');
        arrow.classList.add('bi-chevron-up');

    } else {

        menu.style.display = 'none';

        arrow.classList.remove('bi-chevron-up');
        arrow.classList.add('bi-chevron-down');

    }

}

</script>