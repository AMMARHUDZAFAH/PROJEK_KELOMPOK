@extends('layouts.app')

@section('content')
<!-- WRAPPER UTAMA -->
<div class="page-bg">

    <!-- DEKORASI LATAR (Bintang, Komet, Awan) -->
    <div class="page-stars"></div>
    <div class="comet"></div>
    <div class="cloud-layer"></div>

    <!-- TOMBOL TOGGLE SIANG/MALAM -->
    <button id="modeToggle" 
        class="position-fixed top-0 end-0 m-4 btn btn-light shadow-sm rounded-circle p-2 d-flex align-items-center justify-content-center"
        style="z-index:999; width:45px; height:45px; font-size:20px;">
        🌙
    </button>

    <div class="container py-5" style="position: relative; z-index: 10;">

        <!-- 1. HERO SECTION + SEARCH -->
        <div class="row justify-content-center mb-5 product-card-anim products-hero position-relative">
            <div class="products-stars" aria-hidden="true"></div>

            <div class="col-lg-10 hero-content">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark display-6">🛍️ Temukan Gadget Impianmu</h2>
                    <p class="text-muted">Jelajahi koleksi elektronik terbaik dengan harga terjangkau</p>
                </div>

                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <form method="GET" class="row g-3 align-items-end">
                            <!-- Input Search -->
                            <div class="col-md-5">
                                <label class="form-label fw-bold small text-uppercase text-muted">Cari Produk</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                    <input type="text" name="q" value="{{ request('q') }}" class="form-control bg-light border-0" placeholder="Contoh: iPhone 13, Laptop...">
                                </div>
                            </div>
                            <!-- Input Kategori -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">Kategori</label>
                                <select name="category" class="form-select bg-light border-0">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" @if(request('category')==$c->id) selected @endif>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Tombol Cari -->
                            <div class="col-md-3">
                                <button class="btn btn-primary w-100 fw-bold h-100" style="min-height: 45px;">Filter & Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. DAFTAR PRODUK -->
        <div class="row">
            @forelse($products as $p)
            <div class="col-md-3 mb-4 product-card-anim">
                <div class="card h-100 border-0 shadow-sm hover-top" style="border-radius: 12px; overflow: hidden;">
                    
                    <!-- Gambar Produk -->
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

                    <!-- Info Produk -->
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
            <!-- Tampilan Jika Kosong -->
            <div class="col-12 text-center py-5 product-card-anim">
                <div class="mb-3" style="font-size: 4rem;">😢</div>
                <h4 class="fw-bold text-white">Produk tidak ditemukan</h4>
                <p class="text-white-50">Coba cari dengan kata kunci lain atau reset filter.</p>
                <a href="{{ route('products.index') }}" class="btn btn-outline-light rounded-pill px-4">Reset Pencarian</a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links() }}
        </div>

    </div> <!-- End Container -->
</div> <!-- End Page BG -->

<!-- STYLE CSS -->
<style>
    /* 1. SETUP GLOBAL BACKGROUND (DEFAULT: NIGHT) */
    .page-bg { 
        min-height: 100vh; 
        position: relative; 
        overflow: hidden; 
        background: linear-gradient(180deg,#001b33 0%, #00264d 40%, #003366 100%);
        transition: background 1s ease;
    }
    .page-bg::before{
        content:''; position:absolute; inset:0; 
        background: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.15), transparent 25%),
                    radial-gradient(circle at 80% 70%, rgba(255,255,255,0.1), transparent 25%);
        pointer-events:none; z-index:0;
    }

    /* 2. BINTANG & KOMET (NIGHT) */
    .page-bg .page-stars .star { 
        position:absolute; width:3px; height:3px; border-radius:50%; 
        background: rgba(255,255,255,0.95); box-shadow:0 0 8px rgba(255,255,255,0.7);
        transition: opacity 1s;
    }
    .comet {
        position: absolute; top: -50px; left: -200px; width: 4px; height: 4px;
        background: white; border-radius: 50%; box-shadow: 0 0 10px white, 0 0 20px white;
        opacity: 0; transform: rotate(45deg); z-index: 5;
    }

    /* 3. HERO SECTION */
    .products-hero { 
        background: linear-gradient(135deg,#0055cc 0%, #1a6fff 40%, #66aaff 100%);
        border-radius: 14px; padding: 1.5rem; 
        box-shadow: 0 18px 50px rgba(13,110,253,0.25); 
        margin-bottom: 1rem; color: #fff; overflow: hidden; position:relative;
    }
    .products-stars .star { background: rgba(255,255,255,0.98); box-shadow:0 0 12px rgba(255,255,255,0.8); }

    /* 4. ANIMASI KOMET */
    @keyframes cometFly {
        0% { opacity: 0; transform: translate(-100px, -100px) scale(0.6) rotate(45deg); }
        5% { opacity: 1; }
        40% { transform: translate(800px, 600px) scale(1.2) rotate(45deg); opacity: 1; }
        60% { opacity: 0; }
        100% { transform: translate(900px, 700px) scale(1.2) rotate(45deg); }
    }

    /* 5. MODE SIANG (DAY MODE) */
    body.day-mode .page-bg {
        background: linear-gradient(180deg,#bfe8ff 0%, #e9f7ff 40%, #ffffff 100%);
    }
    body.day-mode .page-bg::before {
        background: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.5), transparent 40%),
                    radial-gradient(circle at 80% 70%, rgba(255,255,255,0.4), transparent 40%);
    }
    body.day-mode .page-stars .star, 
    body.day-mode .comet { opacity: 0 !important; }

    body.day-mode .products-hero {
        background: linear-gradient(135deg,#4dabff 0%, #74c0ff 40%, #a5d8ff 100%);
    }

    /* 6. AWAN (DAY MODE) */
    .cloud-layer { position:absolute; top:0; left:0; width:100%; height:100%; pointer-events:none; overflow:hidden; z-index:5; }
    .cloud { position:absolute; background: white; border-radius: 50px; filter: blur(2px); opacity: .9; }
    @keyframes cloudMove { from { transform: translateX(-200px); } to { transform: translateX(140vw); } }

    /* 7. LAINNYA */
    .hover-top { transition: transform .3s, box-shadow .3s; }
    .hover-top:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>

<!-- SCRIPT JAVASCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function(){

        // --- 1. SETUP BINTANG BACKGROUND ---
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

        // --- 2. SETUP KOMET ---
        const comet = document.querySelector('.comet');
        function summonComet() {
            if(document.body.classList.contains('day-mode')) {
                setTimeout(summonComet, 5000); 
                return; // Gak munculin komet kalau siang
            }
            let delay = Math.random() * 5000 + 5000; 
            comet.style.animation = 'none';
            void comet.offsetWidth;
            comet.style.animation = `cometFly 3s ease-out`;
            setTimeout(summonComet, delay);
        }
        summonComet();

        // --- 3. SETUP AWAN (DAY MODE) ---
        const cloudLayer = document.querySelector('.cloud-layer');
        function createCloud() {
            let cloud = document.createElement('div');
            cloud.className = 'cloud';
            let size = Math.random()*80 + 70; 
            cloud.style.width = size + 'px';
            cloud.style.height = (size*0.6) + 'px';
            cloud.style.top = Math.random()*40 + '%';
            cloud.style.left = '-200px';
            cloud.style.animation = `cloudMove ${20 + Math.random()*25}s linear infinite`;
            cloudLayer.appendChild(cloud);
            setTimeout(()=>cloud.remove(), 45000);
        }
        function cloudLoop() {
            if (document.body.classList.contains('day-mode')) {
                createCloud();
            }
            setTimeout(cloudLoop, 3000);
        }
        cloudLoop();

        // --- 4. TOGGLE BUTTON LOGIC ---
        const toggleBtn = document.getElementById('modeToggle');
        
        // Cek LocalStorage saat load
        if (localStorage.getItem('mode') === 'day') {
            document.body.classList.add('day-mode');
            toggleBtn.innerHTML = "🌚";
        }

        toggleBtn.addEventListener('click', () => {
            document.body.classList.toggle('day-mode');
            if (document.body.classList.contains('day-mode')) {
                toggleBtn.innerHTML = "🌚";
                localStorage.setItem('mode','day');
            } else {
                toggleBtn.innerHTML = "🌙";
                localStorage.setItem('mode','night');
            }
        });
    });
</script>

@endsection