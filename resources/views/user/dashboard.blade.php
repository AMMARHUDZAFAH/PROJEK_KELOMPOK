@extends('layouts.app')

@section('content')
<div class="container mt-5">
    
    <!-- Hero Section dengan Class Adaptif -->
    <!-- user-hero-adaptive: Class custom buatan kita di bawah -->
    <div class="user-hero-adaptive p-4 p-md-5 position-relative anim-fade rounded-4 shadow-lg overflow-hidden">
        
        <div class="d-flex align-items-center gap-4 position-relative" style="z-index: 2;">
            <!-- Avatar -->
            <div class="avatar flex-shrink-0 shadow-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            
            <!-- Teks Sapaan -->
            <div>
                <h2 class="fw-bold mb-1 text-reset">Selamat datang, {{ Auth::user()->name }}! 👋</h2>
                <p class="mb-0 opacity-75" style="font-size: 1.1rem;">
                    Semoga harimu menyenangkan — lihat ringkasan aktivitas atau mulai belanja sekarang.
                </p>
            </div>
        </div>

        <!-- Tombol Aksi Cepat -->
        <div class="mt-4 quick-btns d-flex gap-2 position-relative" style="z-index: 2;">
            <a href="{{ route('orders.index') }}" class="btn btn-primary-adaptive px-4 py-2 rounded-pill fw-bold">
                <i class="bi bi-receipt me-1"></i> Pesanan Saya
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-adaptive px-4 py-2 rounded-pill fw-bold">
                <i class="bi bi-cart me-1"></i> Mulai Belanja
            </a>
        </div>

        <!-- Hiasan Background (Opsional, biar gak sepi) -->
        <div class="bg-decoration"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            setTimeout(function(){ 
                document.querySelectorAll('.anim-fade').forEach(function(el){ 
                    el.classList.add('visible'); 
                }); 
            }, 100);
        });
    </script>

</div>

<style>
    /* 1. HERO ADAPTIF */
    
    /* DEFAULT (MODE MALAM): Glassmorphism Biru Gelap */
    .user-hero-adaptive {
        background: rgba(13, 110, 253, 0.15); /* Biru transparan */
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    .user-hero-adaptive .avatar {
        background: #fff;
        color: #0d6efd;
        width: 80px; height: 80px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800;
    }
    .btn-primary-adaptive {
        background: #0d6efd; border: none; color: #fff;
    }
    .btn-outline-adaptive {
        background: transparent; border: 2px solid rgba(255,255,255,0.5); color: #fff;
    }
    .btn-outline-adaptive:hover {
        background: #fff; color: #0d6efd;
    }

    /* OVERRIDE MODE SIANG: Putih Bersih */
    body.day-mode .user-hero-adaptive {
        background: #ffffff; /* Putih Solid */
        color: #333;
        border: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08) !important;
    }
    body.day-mode .user-hero-adaptive .avatar {
        background: #0d6efd; /* Avatar jadi biru */
        color: #fff;
    }
    body.day-mode .btn-primary-adaptive {
        background: #0d6efd; color: #fff;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }
    body.day-mode .btn-outline-adaptive {
        border: 2px solid #0d6efd; color: #0d6efd;
    }
    body.day-mode .btn-outline-adaptive:hover {
        background: #0d6efd; color: #fff;
    }

    /* Animasi Fade In */
    .anim-fade { opacity: 0; transform: translateY(10px); transition: all 0.6s ease; }
    .anim-fade.visible { opacity: 1; transform: none; }

    /* Hiasan Bulat Samar di Pojok */
    .bg-decoration {
        position: absolute; top: -50%; right: -10%; width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%; pointer-events: none;
    }
    body.day-mode .bg-decoration {
        background: radial-gradient(circle, rgba(13,110,253,0.1) 0%, transparent 70%);
    }
</style>
@endsection