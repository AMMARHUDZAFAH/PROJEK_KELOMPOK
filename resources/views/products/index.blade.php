@extends('layouts.app')

@section('content')
<div class="container py-5">
    <style>
        /* Page hero background for product listing */
        .products-hero {
            background: linear-gradient(135deg, #0b5ed7 0%, #60a5fa 55%, #eaf6ff 100%);
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 12px 40px rgba(11,94,215,0.08);
            margin-bottom: 1rem;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .products-hero .display-6 { color: rgba(255,255,255,0.95); }
        .products-hero .text-muted { color: rgba(255,255,255,0.85); }
        .products-hero .card { background: rgba(255,255,255,0.95); }

        /* Card accent & hover enhancement */
        .anim-card { transition: transform .22s ease, box-shadow .22s ease; }
        .anim-card:hover { transform: translateY(-6px) scale(1.01); box-shadow: 0 12px 36px rgba(11,94,215,0.12); }

        /* Staggered reveal for product cards */
        .anim-fade { opacity: 0; transform: translateY(8px); transition: opacity .45s ease, transform .45s ease; }
        .anim-fade.visible { opacity: 1; transform: none; }

        /* Decorative circle */
        .products-hero:after{ content:''; position:absolute; right:-120px; top:-60px; width:360px; height:360px; background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.12), rgba(255,255,255,0) 40%); transform: rotate(15deg); pointer-events:none; }

        /* Improve price / badge contrast */
        .card .badge { background: rgba(255,255,255,0.95); color: #000; }
    </style>
    
    <!-- 1. HEADER & SEARCH BAR (Ada animasinya juga) -->
    <div class="row justify-content-center mb-5 product-card-anim products-hero anim-fade">
        <div class="col-lg-10">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark display-6">🛍️ Temukan Gadget Impianmu</h2>
                <p class="text-muted">Jelajahi koleksi elektronik terbaik dengan harga terjangkau</p>
            </div>

            <!-- Card Pencarian -->
            <div class="card shadow-sm border-0 anim-card" style="border-radius: 15px;">
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
            <div class="card h-100 border-0 shadow-sm hover-top anim-card anim-fade" style="border-radius: 12px; overflow: hidden;">
                
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

                    <a href="{{ route('products.show', $p) }}" class="btn btn-outline-primary w-100 mt-auto rounded-pill fw-bold btn-animate">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12 text-center py-5 product-card-anim anim-card anim-fade">
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

<style>
/* Tambahan CSS kecil khusus halaman ini */
.hover-top {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-top:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
/* Button micro interaction */
.btn-animate { transition: transform .12s ease, box-shadow .12s ease; }
.btn-animate:active { transform: scale(.99); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        // reveal stagger
        var els = document.querySelectorAll('.anim-fade');
        els.forEach(function(el, idx){ setTimeout(function(){ el.classList.add('visible'); }, idx * 70); });

        // small shimmer for product image area when image absent
        document.querySelectorAll('.position-relative').forEach(function(el){
            if(!el.querySelector('img')) {
                el.style.background = 'linear-gradient(90deg, #f8f9fa 20%, #eef6ff 50%, #f8f9fa 80%)';
            }
        });
    });
}</script>
@endsection