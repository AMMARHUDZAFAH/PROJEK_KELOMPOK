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
    
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <!-- 1. BACKGROUND GLOBAL (Diam di belakang) -->
    <div class="page-bg">
        <div class="page-stars"></div>
        <div class="comet"></div>
        <div class="cloud-layer"></div>
    </div>

    <!-- 2. NAVBAR -->
    @include('layouts.navbar')

    <!-- 3. TOMBOL TOGGLE GLOBAL (Melayang) -->
    <div class="position-fixed end-0 me-3 d-flex align-items-center" style="z-index:9999; top: 85px;">
        <button id="modeToggle" 
            class="btn btn-light shadow-sm rounded-circle p-0 d-flex align-items-center justify-content-center border"
            style="width:45px; height:45px; font-size:20px;">
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
</body>
</html>