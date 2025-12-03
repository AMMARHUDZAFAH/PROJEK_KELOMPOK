@extends('layouts.app')

@section('content')

<!-- CSS KHUSUS HALAMAN INI -->
<style>
    /* 1. TOMBOL TERLARIS (Target pakai ID biar prioritas TERTINGGI) */
    #btn-terlaris-special {
        border: 2px solid rgba(255, 255, 255, 0.5) !important;
        color: #ffffff !important;
        background: transparent !important;
        font-weight: 600;
    }
    #btn-terlaris-special:hover {
        background: #ffffff !important;
        color: #000000 !important;
        border-color: #ffffff !important;
    }

    /* Override Mode Siang */
    body.day-mode #btn-terlaris-special {
        border: 2px solid #0d6efd !important;
        color: #0d6efd !important;
    }
    body.day-mode #btn-terlaris-special:hover {
        background: #0d6efd !important;
        color: #ffffff !important;
    }

    /* 2. TEXT & CARD UTILS */
    .text-hero-adaptive { color: #fff; text-shadow: 0 2px 10px rgba(0,0,0,0.5); }
    .text-hero-sub-adaptive { color: rgba(255,255,255,0.8); }
    body.day-mode .text-hero-adaptive { color: #003366; text-shadow: none; }
    body.day-mode .text-hero-sub-adaptive { color: #555; }

    .bg-glass-product {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        overflow: hidden;
    }
    body.day-mode .bg-glass-product {
        background: #fff;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .text-adaptive { color: #fff !important; }
    body.day-mode .text-adaptive { color: #333 !important; }

    /* Input Fix */
    .bg-input {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        border: 1px solid rgba(255,255,255,0.2) !important;
    }
    .input-group-text {
        background-color: rgba(255, 255, 255, 0.15) !important;
        border: 1px solid rgba(255,255,255,0.2) !important;
        color: #fff !important;
    }
    
    /* FIX: Paksa Dropdown Text Hitam */
    option { background-color: #fff !important; color: #000 !important; }

    body.day-mode .bg-input {
        background-color: #f8f9fa !important;
        color: #333 !important;
        border: 1px solid #ddd !important;
    }
    body.day-mode .input-group-text {
        background-color: #e9ecef !important;
        border: 1px solid #ddd !important;
        color: #555 !important;
    }
    
    .hover-top { transition: transform 0.3s; }
    .hover-top:hover { transform: translateY(-5px); }

/* TOMBOL UTAMA ADAPTIF (Lihat Semua & Cari Sekarang) */
    .btn-primary-adaptive {
        background-color: #ffffff !important; /* Malam: Putih */
        color: #0d6efd !important; /* Teks Biru */
        border: none !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2) !important;
    }
    .btn-primary-adaptive:hover {
        background-color: #e2e6ea !important;
        transform: translateY(-2px);
    }

    /* Override Mode Siang */
    body.day-mode .btn-primary-adaptive {
        background-color: #0d6efd !important; /* Siang: Biru */
        color: #ffffff !important; /* Teks Putih */
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3) !important;
    }
    body.day-mode .btn-primary-adaptive:hover {
        background-color: #0b5ed7 !important;
    }}

</style>

<div class="container py-5">

    <!-- 1. HERO SECTION -->
    <div class="row justify-content-center mb-5 product-card-anim position-relative" style="z-index:2;">
        <div class="col-lg-10">
            <div class="row align-items-center">
                
                <!-- Kolom Kiri -->
                <div class="col-lg-6 text-center text-lg-start mb-4">
                    <h2 class="fw-bold display-5 mb-2 text-hero-adaptive">🛍️ Temukan Gadget Impianmu</h2>
                    <p class="text-hero-sub-adaptive lead mb-3">
                        Jelajahi koleksi elektronik terbaik dengan harga terjangkau.
                    </p>

    
                <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-lg-start">
                    <!-- GANTI CLASS DI SINI -->
                    <a href="{{ route('products.index') }}" class="btn btn-primary-adaptive rounded-pill px-4 shadow-sm">
                        Lihat Semua
                    </a>

                    <!-- Tombol Terlaris (Tetap) -->
                    <a href="{{ route('products.index', ['sort'=>'popular']) }}" 
                       id="btn-terlaris-special" 
                       class="btn rounded-pill px-4">
                        Terlaris
                    </a>
                </div>
            </div>

                <!-- Kolom Kanan: Search -->
                <div class="col-lg-6">
                    <div class="card shadow-lg border-0" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 20px;">
                        <div class="card-body p-4">
                            <form method="GET" class="row g-3">
                                
                                <!-- Input 1 -->
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-uppercase text-white opacity-75 mb-1">Cari Nama Barang</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" name="q" value="{{ request('q') }}" class="form-control bg-input shadow-none" placeholder="Contoh: Laptop Gaming...">
                                    </div>
                                </div>

                                <!-- Input 2 -->
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-uppercase text-white opacity-75 mb-1">Pilih Jenis Produk</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-grid-fill"></i></span>
                                        <select name="category" class="form-select bg-input shadow-none cursor-pointer">
                                            <option value="">Semua Kategori</option>
                                            @foreach($categories as $c)
                                                <option value="{{ $c->id }}" @if(request('category')==$c->id) selected @endif>
                                                    {{ $c->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Tombol Cari -->
                                <div class="col-12 d-grid mt-4">
                                    <!-- Ganti 'btn-primary' jadi 'btn-primary-adaptive' -->
                                    <button class="btn btn-primary-adaptive fw-bold py-2 rounded-3 shadow-sm">
                                        🔍 Cari Sekarang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
<!-- 2. DAFTAR PRODUK -->
    <div class="row" style="z-index:2;">
    @forelse($products as $p)
        <div class="col-md-3 mb-4 product-card-anim">
            <!-- Tambah position-relative biar stretched-link tahu batasnya -->
            <div class="card h-100 shadow-sm hover-top bg-glass-product position-relative">

                <!-- Gambar -->
                <div class="position-relative bg-white d-flex align-items-center justify-content-center" style="height: 220px;">
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}" class="w-100 h-100" style="object-fit:cover;">
                    @else
                        <div class="text-muted small">No Image</div>
                    @endif

                    @if($p->category)
                    <span class="badge badge-category-final position-absolute top-0 start-0 m-3 rounded-pill px-3 py-2">
                        {{ $p->category->name }}
                    </span>
                    @endif
                </div>

                <!-- Info -->
                <div class="card-body d-flex flex-column p-4">
                    <h5 class="fw-bold mb-1 text-adaptive lh-sm">{{ Str::limit($p->name, 40) }}</h5>

                    <div class="mb-3 mt-2">
                        <h5 class="text-primary fw-bold">Rp {{ number_format($p->price,0,',','.') }}</h5>
                        <div class="mt-1">
                            @if($p->stock > 0)
                                <small class="text-success fw-bold"><i class="bi bi-check-circle-fill"></i> Ready</small>
                            @else
                                <small class="text-danger fw-bold"><i class="bi bi-x-circle-fill"></i> Habis</small>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('products.show', $p) }}" 
                       class="btn btn-outline-primary rounded-pill w-100 mt-auto fw-bold stretched-link">
                        Lihat Detail
                    </a>
                </div>

            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 product-card-anim">
            <div class="mb-3" style="font-size:4rem;">🛸</div>
            <h4 class="fw-bold text-hero-adaptive">Produk tidak ditemukan</h4>
            <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-4 fw-bold mt-3">Reset Pencarian</a>
        </div>
    @endforelse
    </div>

  

    <div class="mt-5 d-flex justify-content-center">
        {{ $products->links() }}
    </div>

</div>
@endsection