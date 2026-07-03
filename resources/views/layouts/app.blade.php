<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Commerce Mandala')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@php
    $role = session('auth_user_role');
    $name = session('auth_user_name', 'Pengguna');
    $initials = collect(explode(' ', $name))->filter()->map(fn ($word) => strtoupper(substr($word, 0, 1)))->take(2)->implode('');
@endphp

<div class="app-layout">
    <aside class="sidebar no-print">
        <a class="brand-box text-decoration-none" href="{{ route('dashboard') }}">
            <span class="brand-logo">EM</span>
            <span>
                <span class="brand-title">Mandala Store</span>
                <span class="brand-subtitle">Sales Management</span>
            </span>
        </a>

        <div class="sidebar-section">Menu Utama</div>
        <nav class="sidebar-nav">
            <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <span class="nav-dot"></span> Dashboard
            </a>
            <a class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                <span class="nav-dot"></span> Produk
            </a>
            @if ($role === 'admin')
                <a class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                    <span class="nav-dot"></span> Kategori
                </a>
                <a class="sidebar-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                    <span class="nav-dot"></span> Supplier
                </a>
            @endif
            <a class="sidebar-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                <span class="nav-dot"></span> Transaksi
            </a>
        </nav>

        <div class="sidebar-user mt-auto">
            <div class="avatar">{{ $initials ?: 'U' }}</div>
            <div class="min-w-0">
                <div class="fw-bold text-truncate">{{ $name }}</div>
                <div class="small text-secondary text-capitalize">{{ $role }}</div>
            </div>
        </div>
    </aside>

    <div class="main-area">
        <nav class="topbar no-print">
            <button class="btn btn-light border d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                Menu
            </button>
            <div>
                <div class="small text-secondary">Aplikasi E-Commerce</div>
                <div class="fw-bold">@yield('title', 'Dashboard')</div>
            </div>
            <div class="ms-auto d-flex align-items-center gap-2">
                <span class="role-pill text-capitalize">{{ $role }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
        </nav>

        <main class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show no-print" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger no-print">
                    <div class="fw-bold mb-1">Data belum dapat disimpan:</div>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<div class="offcanvas offcanvas-start no-print" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold">Mandala Store</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="d-grid gap-2">
            <a class="btn btn-light text-start" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="btn btn-light text-start" href="{{ route('products.index') }}">Produk</a>
            @if ($role === 'admin')
                <a class="btn btn-light text-start" href="{{ route('categories.index') }}">Kategori</a>
                <a class="btn btn-light text-start" href="{{ route('suppliers.index') }}">Supplier</a>
            @endif
            <a class="btn btn-light text-start" href="{{ route('transactions.index') }}">Transaksi</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
