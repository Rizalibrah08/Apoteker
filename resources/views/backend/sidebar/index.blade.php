<aside class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('img/logo-zapotek.jpg') }}" alt="Zapotek Logo"
            style="width: 40px; height: 40px; border-radius: 8px; margin-right: 10px; object-fit: cover;">
        <span class="logo-text">Zapotek</span>
    </div>

    <div class="sidebar-menu">
        <div class="menu-label">Menu Utama</div>

        <a href="{{ route('dashboard.index') }}"
            class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('kasir.index') }}" class="nav-link {{ request()->routeIs('kasir.index') ? 'active' : '' }}">
            <i class="fas fa-cash-register"></i>
            <span>Kasir</span>
        </a>

        @if(Auth::user()->role == 'admin')
            <a href="{{ route('obat.index') }}" class="nav-link {{ request()->routeIs('obat.index') ? 'active' : '' }}">
                <i class="fas fa-pills"></i>
                <span>Data Obat</span>
            </a>
        @endif

        <a href="{{ route('laporan.index') }}"
            class="nav-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Laporan</span>
        </a>

        <div class="menu-label" style="margin-top: 1.5rem;">Lainnya</div>

        <a href="{{ route('pengaturan.index') }}"
            class="nav-link {{ request()->routeIs('pengaturan.index') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span>
        </a>

        <!-- Logout Form -->
        <a href="#" class="nav-link text-danger"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background={{ Auth::user()->role == 'admin' ? '4A90E2' : '2ecc71' }}&color=fff"
                    alt="{{ Auth::user()->name }}" style="width: 100%; border-radius: 50%;">
            </div>
            <div class="user-info">
                <h4 style="text-transform: capitalize;">{{ Str::limit(Auth::user()->name, 15) }}</h4>
                <p style="text-transform: capitalize;">{{ Auth::user()->role }}</p>
            </div>
        </div>
    </div>
</aside>