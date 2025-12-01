<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="login-body"> <!-- Class untuk background gerak -->

    @if (session('success'))
        <div class="alert alert-success position-absolute top-0 start-50 translate-middle-x mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-4 shadow-lg login-card" style="width: 400px;"> <!-- Class login-card untuk efek 3D -->
        <div class="text-center mb-4">
            <h1 style="font-size: 3rem;">⚡</h1>
            <h3 class="fw-bold text-dark">Welcome Back!</h3>
            <p class="text-muted small">Silakan login untuk lanjut belanja</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="emailInput" placeholder="name@example.com" required>
                <label for="emailInput">Email address</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" name="password" class="form-control" id="passInput" placeholder="Password" required>
                <label for="passInput">Password</label>
            </div>

            <button class="btn btn-primary w-100 py-2 fw-bold" style="font-size: 1.1rem;">🚀 Masuk Sekarang</button>
        </form>

        <p class="text-center mt-4 mb-0 text-muted">
            Belum punya akun? <a href="/register" class="text-decoration-none fw-bold">Daftar disini</a>
        </p>
    </div>

    <!-- Jangan lupa load script custom JS kita -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>