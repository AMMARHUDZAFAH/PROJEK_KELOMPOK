<!DOCTYPE html>
<html>

<head>
    <title>Register - ElectroHub</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS (Wajib ada file public/css/custom.css yang tadi dibuat) -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="login-body"> <!-- Background animasi -->

    <!-- Alert Sukses (Melayang di atas) -->
    @if (session('success'))
        <div class="alert alert-success position-absolute top-0 start-50 translate-middle-x mt-3 shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Alert Error (Kalau ada salah input) -->
    @if ($errors->any())
        <div class="alert alert-danger position-absolute top-0 start-50 translate-middle-x mt-3 shadow" style="z-index: 1050; width: 90%; max-width: 450px;">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Kartu Register (Lebih lebar dikit dari login biar muat) -->
    <div class="card p-4 shadow-lg login-card" style="width: 450px;">
        
        <div class="text-center mb-4">
            <h1 style="font-size: 3rem;">📝</h1>
            <h3 class="fw-bold text-dark">Join ElectroHub!</h3>
            <p class="text-muted small">Buat akun baru dalam hitungan detik</p>
        </div>

        <form method="POST" action="/register">
            @csrf

            <!-- Nama Lengkap -->
            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="nameInput" placeholder="Nama Lengkap" required>
                <label for="nameInput">Nama Lengkap</label>
            </div>

            <!-- Email -->
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="emailInput" placeholder="name@example.com" required>
                <label for="emailInput">Alamat Email</label>
            </div>

            <!-- Password -->
            <div class="row g-2 mb-4">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="password" name="password" class="form-control" id="passInput" placeholder="Password" required>
                        <label for="passInput">Password</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="password" name="password_confirmation" class="form-control" id="confPassInput" placeholder="Confirm" required>
                        <label for="confPassInput">Ulangi Pass</label>
                    </div>
                </div>
            </div>

            <button class="btn btn-success w-100 py-2 fw-bold" style="font-size: 1.1rem;">
                ✨ Daftar Sekarang
            </button>
        </form>

        <p class="text-center mt-4 mb-0 text-muted">
            Sudah punya akun? <a href="/login" class="text-decoration-none fw-bold text-primary">Login disini</a>
        </p>
    </div>

    <!-- Script JS Custom (Buat efek 3D Tilt) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

</body>

</html>