@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    
    <div class="card p-4 p-md-5 login-card product-card-anim" style="width: 100%; max-width: 420px;"> 
        
        <div class="text-center mb-4">
            <div style="font-size: 3rem;">⚡</div> 
            <h3 class="fw-bold mt-2">Welcome Back!</h3>
            <p class="opacity-75 small">Masuk untuk melanjutkan belanja</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger py-2 small mb-4 border-0 shadow-sm rounded-3">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success py-2 small mb-4 border-0 shadow-sm rounded-3">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            
            <!-- Email (Tanpa Form Floating) -->
            <div class="mb-3 text-start">
                <label for="emailInput" class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-control" id="emailInput" 
                       placeholder="name@example.com" required>
            </div>

            <!-- Password -->
            <div class="mb-4 text-start">
                <label for="passInput" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="passInput" 
                       placeholder="Masukkan password kamu" required>
            </div>

            <button class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm mb-3">
                Masuk Sekarang
            </button>
        </form>

        <div class="text-center mt-3">
            <span class="opacity-75 small">Belum punya akun?</span>
            <a href="/register" class="text-decoration-none fw-bold text-primary ms-1">Daftar disini</a>
        </div>
    </div>

</div>
@endsection