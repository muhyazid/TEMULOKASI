<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ asset('lte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">NEMULOKASI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Data Lokasi -->
                <li class="nav-item">
                    <a href="{{ route('lokasi') }}" class="nav-link {{ Request::is('lokasi') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p>Data Lokasi</p>
                    </a>
                </li>

                <!-- Perhitungan Fuzzy Tsukamoto -->
                <li class="nav-item">
                    <a href="{{ route('fuzzy.index') }}" class="nav-link {{ Request::is('fuzzy*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-brain"></i>
                        <p>Fuzzy Tsukamoto</p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
