<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right" style="position: relative; z-index: 1030;">
    <li class="dropdown">
        <!-- Toggle untuk desktop -->
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user d-none d-md-flex align-items-center">
            <img alt="image" src="{{ auth()->user()->foto_url }}" class="rounded-circle mr-1" style="width: 30px; height: 30px; object-fit: cover;">
            <div class="d-none d-lg-inline-block">Hi, {{ auth()->user()->nama }}</div>
        </a>
        
        <!-- Toggle untuk mobile -->
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user d-flex d-md-none align-items-center">
            <img alt="image" src="{{ auth()->user()->foto_url }}" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
        </a>
        
        <div class="dropdown-menu dropdown-menu-right" style="position: absolute; right: 0; left: auto;">
            <div class="dropdown-title d-flex align-items-center">
                <img alt="image" src="{{ auth()->user()->foto_url }}" class="rounded-circle mr-2" style="width: 30px; height: 30px; object-fit: cover;">
                <div>
                    <div>{{ auth()->user()->nama }}</div>
                    <small class="text-muted">{{ auth()->user()->level }}</small>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </form>
        </div>
    </li>
</ul>
</nav>

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" class="text-white">
                <i class="fas fa-book-reader mr-2"></i>
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}" class="text-white">
                <i class="fas fa-book-reader"></i>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-header">Menu</li>
            
            <!-- Book Browsing (All Users) -->
            <li class="{{ request()->routeIs('books.browse') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('books.browse') }}">
                    <i class="fas fa-book"></i> <span>Daftar Buku</span>
                </a>
            </li>

            @if(in_array(auth()->user()->level, ['admin', 'petugas']))
                <!-- Book Management -->
                <li class="{{ request()->routeIs('books.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('books.index') }}">
                        <i class="fas fa-book-open"></i> <span>Manajemen Buku</span>
                    </a>
                </li>

                <!-- Category Management -->
                <li class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('categories.index') }}">
                        <i class="fas fa-tags"></i> <span>Kategori</span>
                    </a>
                </li>
            @endif

            <!-- Loan Management -->
            <li class="{{ request()->routeIs('loans.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('loans.index') }}">
                    <i class="fas fa-hand-holding"></i> <span>Peminjaman</span>
                </a>
            </li>

            <!-- User Management (Admin Only) -->
            @if(auth()->user()->level === 'admin')
                <li class="{{ request()->routeIs('users.*') ? 'active' : '' }} menu-users">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="fas fa-users"></i> <span>Pengguna</span>
                    </a>
                </li>
            @endif
        </ul>
    </aside>
</div>

<style>
    .main-sidebar {
        background: #f8fafc !important;
        box-shadow: 2px 0 16px rgba(0,0,0,0.06);
        padding-top: 0;
        padding-bottom: 0;
    }
    .sidebar-brand {
        background: transparent !important;
        color: #4e73df !important;
        padding: 1rem 1rem 0.5rem 1rem;
        margin-bottom: 0.5rem;
        border-radius: 0 0 1rem 1rem;
        text-align: center;
    }
    .sidebar-brand a {
        color: #4e73df !important;
        font-weight: bold;
        font-size: 1.2rem;
        letter-spacing: 1px;
    }
    .sidebar-menu {
        margin-top: 1rem;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    .sidebar-menu li {
        margin-bottom: 0.25rem;
    }
    .sidebar-menu li.menu-users {
        margin-top: 1.2rem;
    }
    .sidebar-menu li a {
        border-radius: 8px;
        margin-bottom: 2px;
        transition: background 0.2s;
        color: #4e73df !important;
        background: transparent !important;
        display: flex;
        align-items: center;
        padding: 0.75rem 1.25rem;
        font-size: 1rem;
    }
    .sidebar-menu li.active > a, .sidebar-menu li a:hover {
        background: #e3e9f7 !important;
        color: #224abe !important;
    }
    .sidebar-menu .menu-header {
        color: #6c757d;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        padding: 0.75rem 1.25rem 0.5rem 1.25rem;
        margin-top: 1.5rem;
        margin-bottom: 0.5rem;
        border-bottom: 1px solid #e3e9f7;
        letter-spacing: 1px;
        background: #f4f6fb;
        border-radius: 6px 6px 0 0;
    }
    .sidebar-menu .nav-link i {
        width: 22px;
        margin-right: 12px;
        text-align: center;
        font-size: 1.1em;
    }
    .navbar-bg {
        background: #fff;
        height: 70px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .main-navbar {
        height: 70px;
    }
    .main-navbar .navbar-nav .nav-link {
        color: #6c757d;
    }
    .main-navbar .navbar-nav .nav-link:hover {
        color: #4e73df;
    }
    .dropdown-menu {
        border: none;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    }
    .dropdown-item {
        padding: 0.5rem 1.5rem;
    }
    .dropdown-item i {
        width: 20px;
        margin-right: 10px;
        text-align: center;
    }
    .dropdown-title {
        padding: 0.5rem 1.5rem;
        font-size: 0.8rem;
        text-transform: uppercase;
        color: #6c757d;
        font-weight: 600;
    }
</style>
