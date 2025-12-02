@extends('layouts.app')

@section('content')
<div class="page-bg">
    <div class="page-stars" aria-hidden="true"></div>
    <div class="comet" aria-hidden="true"></div> <!-- ★ KOMET -->

    <div class="container py-5">
    <style>
        /* ============================================================
           1. BACKGROUND LANGIT MALAM
        ============================================================ */
        .page-bg { 
            min-height: 100vh; 
            position: relative; 
            overflow: hidden; 
            background: linear-gradient(180deg,#001b33 0%, #00264d 40%, #003366 100%);
        }
        .page-bg::before{
            content:''; 
            position:absolute; 
            inset:0; 
            background: 
                radial-gradient(circle at 20% 30%, rgba(255,255,255,0.15), transparent 25%),
                radial-gradient(circle at 80% 70%, rgba(255,255,255,0.1), transparent 25%);
            pointer-events:none; 
            z-index:0;
        }

        /* ============================================================
           2. BINTANG HALUS DI LATAR
        ============================================================ */
        .page-bg .page-stars .star { 
            position:absolute;
            width:3px; 
            height:3px; 
            border-radius:50%; 
            background: rgba(255,255,255,0.95);
            box-shadow:0 0 8px rgba(255,255,255,0.7);
            mix-blend-mode:screen;
        }

        /* ============================================================
           3. HERO GRADIENT
        ============================================================ */
        .products-hero { 
            background: linear-gradient(135deg,#0055cc 0%, #1a6fff 40%, #66aaff 100%);
            border-radius: 14px; 
            padding: 1.5rem; 
            box-shadow: 0 18px 50px rgba(13,110,253,0.25); 
            margin-bottom: 1rem; 
            color: #fff; 
            overflow: hidden; 
            position:relative;
        }
        .products-stars .star {
            background: rgba(255,255,255,0.98); 
            box-shadow:0 0 12px rgba(255,255,255,0.8);
        }

        /* ============================================================
           4. ANIMASI BINTANG JATOH
        ============================================================ */
        @keyframes fall { 
            0% { transform: translateY(-20px) translateX(0) rotate(0deg); opacity: 1; } 
            100% { transform: translateY(120vh) translateX(40px) rotate(270deg); opacity: 0; } 
        }

        /* ============================================================
           5. KOMET MELINTAS
        ============================================================ */
        .comet {
            position: absolute;
            top: -50px;
            left: -200px;
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 0 10px white, 0 0 20px white;
            opacity: 0;
            transform: rotate(45deg);
        }

        @keyframes cometFly {
            0% {
                opacity: 0;
                transform: translate(-100px, -100px) scale(0.6) rotate(45deg);
            }
            5% {
                opacity: 1;
            }
            40% {
                transform: translate(800px, 600px) scale(1.2) rotate(45deg);
                opacity: 1;
            }
            60% {
                opacity: 0;
            }
            100% {
                transform: translate(900px, 700px) scale(1.2) rotate(45deg);
            }
        }
    </style>

    <script>
        /* ============================================================
           6. GENERATE BINTANG + KOMET OTOMATIS
        ============================================================ */

        document.addEventListener('DOMContentLoaded', function(){

            /* --- Bintang di background --- */
            var pageStarsWrap = document.querySelector('.page-stars');
            var pageStarCount = 30;
            for (var j = 0; j < pageStarCount; j++) {
                var s = document.createElement('span');
                s.className = 'star';
                s.style.left = Math.random() * 100 + '%';
                s.style.top = Math.random() * 100 + '%';
                s.style.opacity = Math.random() * 0.9;
                s.style.transform = 'scale(' + (Math.random()*1.5+0.4) + ')';
                pageStarsWrap.appendChild(s);
            }

            /* --- Komet melintas tiap 5-10 detik --- */
            const comet = document.querySelector('.comet');
            function summonComet() {
                let delay = Math.random() * 5000 + 5000; // 5s - 10s
                comet.style.animation = 'none';
                void comet.offsetWidth; // reset animation
                comet.style.animation = `cometFly 3s ease-out`;
                setTimeout(summonComet, delay);
            }
            summonComet();
        });
    </script>


    <!-- HERO SECTION + SEARCH -->
    <div class="row justify-content-center mb-5 product-card-anim products-hero anim-fade position-relative">
        <div class="products-stars" aria-hidden="true"></div>

        <div class="col-lg-10 hero-content">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark display-6">🛍️ Temukan Gadget Impianmu</h2>
                <p class="text-muted">Jelajahi koleksi elektronik terbaik dengan harga terjangkau</p>
            </div>

            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label fw-bold small text-uppercase text-muted">Cari Produk</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control bg-light border-0" placeholder="Contoh: iPhone 13, Laptop...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Kategori</label>
                            <select name="category" class="form-select bg-light border-0">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" @if(request('category')==$c->id) selected @endif>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary w-100 fw-bold h-100" style="min-height: 45px;">Filter & Cari</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- PRODUK -->
    <div class="row">
        @forelse($products as $p)
        <div class="col-md-3 mb-4 product-card-anim">
            <div class="card h-100 border-0 shadow-sm hover-top" style="border-radius: 12px; overflow: hidden;">

                <div class="position-relative" style="height: 220px; background: #f8f9fa;">
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $p->name }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                            <small>No Image</small>
                        </div>
                    @endif

                    @if($p->category)
                        <span class="badge bg-white text-dark position-absolute top-0 start-0 m-3 shadow-sm">
                            {{ $p->category->name }}
                        </span>
                    @endif
                </div>

                <div class="card-body d-flex flex-column p-4">
                    <h5 class="card-title fw-bold text-dark mb-1">{{ Str::limit($p->name, 40) }}</h5>
                    <div class="mb-3">
                        <h5 class="text-primary fw-bold mb-0">Rp {{ number_format($p->price, 0, ',', '.') }}</h5>
                        @if($p->stock > 0)
                            <small class="text-success"><i class="bi bi-check-circle-fill"></i> Stok Tersedia</small>
                        @else
                            <small class="text-danger"><i class="bi bi-x-circle-fill"></i> Habis</small>
                        @endif
                    </div>

                    <a href="{{ route('products.show', $p) }}" class="btn btn-outline-primary w-100 mt-auto rounded-pill fw-bold">Lihat Detail</a>
                </div>
            </div>
        </div>

        @empty
        <div class="col-12 text-center py-5 product-card-anim">
            <div class="mb-3" style="font-size: 4rem;">😢</div>
            <h4 class="fw-bold">Produk tidak ditemukan</h4>
            <p class="text-muted">Coba cari dengan kata kunci lain atau reset filter.</p>
            <a href="{{ route('products.index') }}" class="btn btn-secondary rounded-pill px-4">Reset Pencarian</a>
        </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $products->links() }}
    </div>

    </div>
</div>

<style>
.hover-top {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-top:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>
@endsection
