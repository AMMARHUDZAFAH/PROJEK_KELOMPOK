@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center mt-3" style="min-height: 80vh;">
    
    <div class="card p-4 p-md-5 login-card product-card-anim" style="width: 100%; max-width: 480px;">
        
        <div class="text-center mb-4">
            <div style="font-size: 3rem;">📝</div>
            <h3 class="fw-bold mt-2">Join ElectroHub</h3>
            <p class="opacity-75 small">Buat akun barumu sekarang</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small mb-4 border-0 shadow-sm rounded-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <!-- Nama -->
            <div class="mb-3 text-start">
                <label for="nameInput" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" id="nameInput" placeholder="Contoh: Budi Santoso" required>
            </div>

            <!-- Email -->
            <div class="mb-3 text-start">
                <label for="emailInput" class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-control" id="emailInput" placeholder="name@example.com" required>
            </div>

            <div class="row g-2 mb-4">
                <div class="col-6 text-start">
                    <div class="mb-0">
                        <label for="passInput" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="passInput" placeholder="******" required>
                    </div>
                </div>
                <div class="col-6 text-start">
                    <div class="mb-0">
                        <label for="confPassInput" class="form-label">Confirm</label>
                        <input type="password" name="password_confirmation" class="form-control" id="confPassInput" placeholder="******" required>
                    </div>
                </div>
            </div>

            <button class="btn btn-success w-100 py-3 fw-bold rounded-pill shadow-sm mb-3">
                ✨ Daftar Sekarang
            </button>
        </form>

        <div class="text-center mt-3">
            <span class="opacity-75 small">Sudah punya akun?</span>
            <a href="/login" class="text-decoration-none fw-bold text-primary ms-1">Login disini</a>
        </div>
    </div>

</div>
@endsection