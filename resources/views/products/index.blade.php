@extends('layouts.app')

@section('content')
<!-- WRAPPER UTAMA -->
<div class="page-bg">

    <!-- DEKORASI LATAR (Bintang, Komet, Awan) -->
    <div class="page-stars"></div>
    <div class="comet"></div>
    <div class="cloud-layer"></div>

    <!-- AREA TOGGLE MODE (DIPERBAIKI POSISINYA) -->
    <!-- top: 85px supaya tidak ketutup Navbar -->
    <div class="position-fixed end-0 me-3 d-flex align-items-center" style="z-index:9999; top: 85px;">
        
        <!-- Label "Mode Malam Aktif" (Hanya muncul saat Gelap) -->
        <span class="night-mode-label badge bg-dark me-2 py-2 px-3 rounded-pill shadow-sm border border-secondary">
            Mode Malam Aktif
        </span>

        <!-- Tombol Toggle -->
        <button id="modeToggle" 
            class="btn btn-light shadow-sm rounded-circle p-0 d-flex align-items-center justify-content-center border"
            style="width:45px; height:45px; font-size:20px;">
            🌙
        </button>
    </div>

    <div class="container py-5" style="position: relative; z-index: 10;">

        <!-- 1. HERO SECTION + SEARCH -->
        <div class="row justify-content-center mb-5 product-card-anim products-hero position-relative">
            <div class="products-stars" aria-hidden="true"></div>

            <div class="col-lg-10 hero-content">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-white display-6">🛍️ Temukan Gadget Impianmu</h2>
                    <p class="text-white-50">Jelajahi koleksi elektronik terbaik dengan harga terjangkau</p>
                </div>

                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <form method="GET" class="row g-3 align-items-end">
                            <!-- Input Search -->
                            <div class="col-md-5">
                                <label class="form-label fw-bold small text-uppercase text-muted">Cari Produk</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                    <input type="text" name="q" value="{{ request('q') }}" class="form-control bg-light border-0 text-dark-fix" placeholder="Contoh: iPhone 13, Laptop...">
                                </div>
                            </div>
                            <!-- Input Kategori -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">Kategori</label>
                                <select name="category" class="form-select bg-light border-0 text-dark-fix">
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
                <!-- Text juga berubah warna sesuai mode -->
                <h4 class="fw-bold text-white-fix">Produk tidak ditemukan</h4>
                <p class="text-white-50-fix">Coba cari dengan kata kunci lain atau reset filter.</p>
                
                <!-- TOMBOL RESET DIPERBAIKI (Pakai class btn-reset-dynamic) -->
                <a href="{{ route('products.index') }}" class="btn btn-reset-dynamic rounded-pill px-4 fw-bold">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset Pencarian
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links() }}
        </div>

    </div> <!-- End Container -->
</div> <!-- End Page BG -->

@endsection