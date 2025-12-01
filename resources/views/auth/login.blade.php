<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ElectroHub</title>
    
    <!-- 1. Link Bootstrap (Wajib) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- 2. Link CSS Custom Kita (Pastikan file ini ada di public/css/custom.css) -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    <!-- 3. Font Keren -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="login-body">

    <!-- Card Login -->
    <div class="card p-4 login-card"> 
        
        <div class="text-center mb-4">
            <div style="font-size: 2.5rem;">⚡</div> 
            <h4 class="fw-bold text-dark mt-2">Welcome Back!</h4>
            <p class="text-muted small">Login untuk lanjut belanja</p>
        </div>

        <!-- Alert Error/Success -->
        @if(session('error'))
            <div class="alert alert-danger py-2 small mb-3 border-0 shadow-sm">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success py-2 small mb-3 border-0 shadow-sm">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            
            <!-- Email -->
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="emailInput" placeholder="name@example.com" required>
                <label for="emailInput">Email address</label>
            </div>

            <!-- Password -->
            <div class="form-floating mb-4">
                <input type="password" name="password" class="form-control" id="passInput" placeholder="Password" required>
                <label for="passInput">Password</label>
            </div>

            <button class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                Masuk Sekarang
            </button>
        </form>

        <p class="text-center mt-4 mb-0 small text-muted">
            Belum punya akun? <a href="/register" class="text-decoration-none fw-bold text-primary">Daftar disini</a>
        </p>
    </div>

    <!-- Script JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>