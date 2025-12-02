@extends('layouts.app')

@section('content')
<div class="page-bg">
    <div class="page-stars" aria-hidden="true"></div>
    <div class="container py-5">
    <style>
        /* Page full background + hero */
        .page-bg { min-height: 100vh; position: relative; overflow: hidden; background: linear-gradient(180deg,#f0f6ff 0%, #fff 60%); }
        .page-bg::before{ content:''; position:absolute; inset:0; background: radial-gradient(circle at 10% 20%, rgba(11,94,215,0.06), transparent 20%), radial-gradient(circle at 80% 80%, rgba(96,165,250,0.03), transparent 20%); pointer-events:none; z-index:0; }
        .page-bg .page-stars { position:absolute; inset:0; z-index:0; pointer-events:none; }
        .page-bg .page-stars .star{ position:absolute; width:4px; height:4px; border-radius:50%; background: rgba(255,255,255,0.6); box-shadow:0 0 10px rgba(255,255,255,0.75); }
        .page-bg .container{ position:relative; z-index:1; }

        /* Products hero + falling stars */
        .products-hero { background: linear-gradient(135deg, #0b5ed7 0%, #60a5fa 55%, #eaf6ff 100%); border-radius: 14px; padding: 1.5rem; box-shadow: 0 12px 40px rgba(11,94,215,0.08); margin-bottom: 1rem; color: #fff; overflow: hidden; }
        .products-hero .display-6, .products-hero .text-muted { color: rgba(255,255,255,0.95); }
        .products-hero .card{ background: rgba(255,255,255,0.95); }
        .products-hero > .products-stars { position: absolute; inset: 0 0 auto 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .products-hero .hero-content { position: relative; z-index: 2; }

        /* stars */
        .products-stars .star{ position: absolute; top: -10px; width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.95); box-shadow: 0 0 10px rgba(255,255,255,0.9); opacity: 0.95; transform-origin: center; }
        @keyframes fall { 0% { transform: translateY(-10px) translateX(0) rotate(0deg); opacity: 1; } 100% { transform: translateY(120vh) translateX(30px) rotate(270deg); opacity: 0; } }

        /* keep product cards clear and images visible */
        .card .badge { background: #fff; color: #000; }
    </style>
    
    <!-- 1. HEADER & SEARCH BAR (Ada animasinya juga) -->
        <div class="row justify-content-center mb-5 product-card-anim products-hero anim-fade position-relative">
            <div class="products-stars" aria-hidden="true"></div>
                <script>
                    // Falling stars effect in product hero
                    document.addEventListener('DOMContentLoaded', function(){
                        var starsWrapper = document.querySelector('.products-stars');
                        if(!starsWrapper) return;
                        var starCount = 12;
                        var wrapperWidth = starsWrapper.offsetWidth || document.documentElement.clientWidth;
                        for(var i=0;i<starCount;i++){
                            var s = document.createElement('span');
                            s.className = 'star';
                            var left = Math.random() * 100;
                            var size = Math.random() * 5 + 4; // 4..9
                            var duration = Math.random() * 6 + 4; // 4..10s
                            var delay = Math.random() * -duration; // start at random progress
                            s.style.left = left + '%';
                            s.style.width = size + 'px';
                            s.style.height = size + 'px';
                            s.style.animation = 'fall ' + duration + 's linear ' + delay + 's infinite';
                            s.setAttribute('aria-hidden','true');
                            starsWrapper.appendChild(s);
                        }
                        // page-level stars
                        var pageStarsWrap = document.querySelector('.page-stars');
                        if(pageStarsWrap){
                            var pageStarCount = 25;
                            for(var j=0;j<pageStarCount;j++){
                                var ps = document.createElement('span');
                                ps.className = 'star';
                                var leftp = Math.random() * 100;
                                var sizep = Math.random() * 3 + 2; // 2..5
                                var durationp = Math.random() * 12 + 8; // 8..20s
                                var delayp = Math.random() * -durationp;
                                ps.style.left = leftp + '%';
                                ps.style.width = sizep + 'px';
                                ps.style.height = sizep + 'px';
                                ps.style.animation = 'fall ' + durationp + 's linear ' + delayp + 's infinite';
                                pageStarsWrap.appendChild(ps);
                            }
                        }
                    });
                </script>
        <div class="col-lg-10 hero-content">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark display-6">🛍️ Temukan Gadget Impianmu</h2>
                <p class="text-muted">Jelajahi koleksi elektronik terbaik dengan harga terjangkau</p>
            </div>

            <!-- Card Pencarian -->
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
                            <button class="btn btn-primary w-100 fw-bold h-100" style="min-height: 45px;">
                                Filter & Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. DAFTAR PRODUK -->
    <div class="row">
        @forelse($products as $p)
        <!-- Tambah class 'product-card-anim' disini biar muncul satu-satu -->
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
                    
                    <!-- Badge Kategori (Nempel di gambar) -->
                    @if($p->category)
                        <span class="badge bg-white text-dark position-absolute top-0 start-0 m-3 shadow-sm" style="font-weight: 500;">
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

                    <a href="{{ route('products.show', $p) }}" class="btn btn-outline-primary w-100 mt-auto rounded-pill fw-bold">
                        Lihat Detail
                    </a>
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

    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
    </div>
</div>

<style>
/* Tambahan CSS kecil khusus halaman ini */
.hover-top {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-top:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>
@endsection