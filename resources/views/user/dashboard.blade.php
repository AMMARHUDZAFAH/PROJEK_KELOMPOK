@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <style>
        /* User dashboard styling */
        .user-hero {
            background: linear-gradient(135deg, #0B5ED7 0%, #60A5FA 60%);
            padding: 1.5rem;
            border-radius: 12px;
            color: #fff;
            box-shadow: 0 12px 40px rgba(11,94,215,0.12);
            overflow: hidden;
        }
        .user-hero:before {
            content: '';
            position: absolute;
            pointer-events: none;
        }
        .user-hero .avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(255,255,255,0.95);
            color: #0B5ED7;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.5rem;
        }
        .quick-btns .btn { transition: transform .12s ease; }
        .quick-btns .btn:active { transform: translateY(1px); }
        .anim-fade { opacity: 0; transform: translateY(8px); transition: opacity .4s ease, transform .4s ease; }
        .anim-fade.visible { opacity: 1; transform: none; }
    </style>

    <div class="user-hero p-4 position-relative anim-fade">
        <div class="d-flex align-items-center gap-3">
            <div class="avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="mb-0">Selamat datang, {{ Auth::user()->name }}!</h2>
                <p class="mb-0 text-white-50">Semoga harimu menyenangkan — lihat ringkasan aktivitas atau mulai belanja sekarang.</p>
            </div>
        </div>

        <div class="mt-3 quick-btns">
            <a href="{{ route('orders.index') }}" class="btn btn-light btn-sm me-2">📋 Pesanan Saya</a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm">🛍️ Mulai Belanja</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            setTimeout(function(){ document.querySelectorAll('.anim-fade').forEach(function(el){ el.classList.add('visible'); }); }, 60);
        });
    </script>

</div>
@endsection
