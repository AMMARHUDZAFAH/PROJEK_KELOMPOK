<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="container d-flex justify-content-center py-5">
        <div class="card p-4 shadow-sm" style="width: 380px;">
            <h3 class="mb-3 text-center">🧑‍💻 Register</h3>

            <form method="POST" action="/register">
                @csrf

                <input type="text" name="name" class="form-control mb-2" placeholder="Nama lengkap" required>

                <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

                <input type="password" name="password" class="form-control mb-3" placeholder="Password (minimal 6 char)"
                    required>

                <input type="password" name="password_confirmation" class="form-control mb-3"
                    placeholder="Konfirmasi Password" required>

                <button class="btn btn-success w-100">Register</button>
            </form>

            <p class="text-center mt-3">
                Sudah punya akun? <a href="/login">Login</a>
            </p>
        </div>
    </div>

</body>

</html>