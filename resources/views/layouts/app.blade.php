<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'ElectroHub') }}</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS (Yang baru tadi) -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/form-fixes.css') }}" rel="stylesheet">
    
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body @unless(request()->is('login') || request()->is('register')) class="has-fixed-navbar" @endunless>

    <!-- 1. BACKGROUND GLOBAL (Diam di belakang) -->
    <div class="page-bg">
        <div class="page-stars"></div>
        <div class="comet"></div>
        <div class="cloud-layer"></div>
    </div>

 <!-- 2. NAVBAR (Hanya muncul jika BUKAN di halaman login/register) -->
    @unless(request()->is('login') || request()->is('register'))
        @include('layouts.navbar')
    @endunless

    <!-- 3. TOMBOL TOGGLE DRAGGABLE (Bisa Digeser) -->
    <!-- ID 'modeToggleWrapper' penting buat JS draggable -->
    <div id="modeToggleWrapper" class="position-fixed d-flex align-items-center justify-content-center shadow-lg rounded-circle" 
         style="z-index: 9999; bottom: 30px; right: 30px; width: 60px; height: 60px; cursor: move; background: var(--bs-body-bg); border: 2px solid var(--bs-border-color);">
        
        <button id="modeToggle" class="btn btn-link text-decoration-none p-0 w-100 h-100 d-flex align-items-center justify-content-center fs-3">
            <span id="toggleIcon">🌙</span>
        </button>
    </div>

    <!-- 4. KONTEN UTAMA -->
    <main>
        <!-- Konten setiap halaman masuk sini -->
        @yield('content')
    </main>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @stack('scripts')
</body>
</html>