<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - E-Commerce Mandala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-body">
    <main class="auth-wrapper">
        <section class="auth-card">
            <div class="auth-visual d-none d-lg-flex">
                <div>
                    <h1 class="display-6 fw-black mb-3"></h1>
                    <p class="text-white-50 mb-4">
                    <div class="auth-feature-list">
                        <span>Role Admin & User</span>
                        <span>Manajemen Produk</span>
                        <span>Transaksi Penjualan</span>
                    </div>
                </div>
            </div>

            <div class="auth-form-panel">
                <div class="mb-4">
                    <div class="brand-logo mb-3 d-lg-none"></div>
                    <p class="text-primary fw-bold mb-1">E-Commerce Mandala</p>
                    <h2 class="fw-black mb-2">Masuk ke Aplikasi</h2>
                    <p class="text-secondary mb-0">Gunakan akun admin atau user untuk melanjutkan.</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('login.process') }}" method="POST" class="vstack gap-3">
                    @csrf
                    <div>
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="admin@mandala.test" autofocus required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button class="btn btn-primary btn-lg w-100 mt-2">Login</button>
                </form>

                <div class="login-demo-box mt-4">
                    <div class="fw-bold mb-2">Akun Demo</div>
                    <div class="small text-secondary">Admin: <span class="fw-semibold text-dark">admin@mandala.test</span> / password</div>
                    <div class="small text-secondary">User: <span class="fw-semibold text-dark">user@mandala.test</span> / password</div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
