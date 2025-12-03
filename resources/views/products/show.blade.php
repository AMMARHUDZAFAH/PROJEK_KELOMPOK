@extends('layouts.app')

@section('content')

<!-- CSS KHUSUS HALAMAN INI -->
<style>
    /* 1. TEXT ADAPTIF */
    .text-adaptive { color: #fff !important; }
    .text-adaptive-soft { color: rgba(255, 255, 255, 0.7) !important; }
    
    body.day-mode .text-adaptive { color: #212529 !important; }
    body.day-mode .text-adaptive-soft { color: #6c757d !important; }

    /* 2. BREADCRUMB */
    .breadcrumb-item a { color: #38bdf8 !important; text-decoration: none; }
    .breadcrumb-item.active { color: rgba(255, 255, 255, 0.6) !important; }
    .breadcrumb-item + .breadcrumb-item::before { color: rgba(255, 255, 255, 0.4) !important; }

    body.day-mode .breadcrumb-item a { color: #0d6efd !important; }
    body.day-mode .breadcrumb-item.active { color: #6c757d !important; }
    body.day-mode .breadcrumb-item + .breadcrumb-item::before { color: #6c757d !important; }

    /* 3. CARD GLASS */
    .bg-glass-product {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
    }
    body.day-mode .bg-glass-product {
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    /* 4. BADGE STATUS FIX (SOLUSI DISINI) */
    .badge-glass {
        color: #fff !important; /* Teks selalu putih */
        backdrop-filter: blur(4px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.2);
        padding: 0.5em 1em;
        font-weight: 600;
    }
    
    /* Mode Malam: Warna agak transparan biar glowing */
    .bg-glass-primary { background-color: rgba(13, 110, 253, 0.85) !important; }
    .bg-glass-success { background-color: rgba(25, 135, 84, 0.85) !important; }
    .bg-glass-danger  { background-color: rgba(220, 53, 69, 0.85) !important; }

    /* Mode Siang: Warna Solid Standar */
    body.day-mode .bg-glass-primary { background-color: #0d6efd !important; border-color: transparent; }
    body.day-mode .bg-glass-success { background-color: #198754 !important; border-color: transparent; }
    body.day-mode .bg-glass-danger  { background-color: #dc3545 !important; border-color: transparent; }

    /* 5. INPUT QTY */
    .form-control-qty {
        background-color: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        color: #fff !important;
        text-align: center;
        font-weight: bold;
    }
    body.day-mode .form-control-qty {
        background-color: #fff !important;
        border: 1px solid #ced4da !important;
        color: #333 !important;
    }

    /* 6. INFO PENGIRIMAN */
    .shipping-box {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    body.day-mode .shipping-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
    }
</style>

<div class="container py-5">
    
    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4 product-card-anim">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 20) }}</li>
        </ol>
    </nav>

    <div class="row product-card-anim">
        <!-- 1. GAMBAR PRODUK -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-lg overflow-hidden bg-glass-product h-100">
                <div class="card-body p-0 d-flex align-items-center justify-content-center bg-white" style="min-height: 400px;">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid" style="max-height: 400px; object-fit: contain;">
                    @else
                        <div class="text-muted fs-4">No Image Available</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2. INFO PRODUK -->
        <div class="col-lg-6">
            <div class="p-4 bg-glass-product h-100 shadow-lg">
                
                <!-- Judul -->
                <h2 class="fw-bold mb-2 text-adaptive">{{ $product->name }}</h2>
                
                <!-- Kategori & Stok (DIPERBAIKI) -->
                <div class="d-flex align-items-center gap-2 mb-4">
                    <!-- Badge Kategori -->
                    <span class="badge rounded-pill badge-glass bg-glass-primary">
                        {{ $product->category?->name }}
                    </span>

                    <!-- Badge Stok -->
                    @if($product->stock > 0)
                        <span class="badge rounded-pill badge-glass bg-glass-success">
                            <i class="bi bi-check-circle-fill me-1"></i> Tersedia: {{ $product->stock }}
                        </span>
                    @else
                        <span class="badge rounded-pill badge-glass bg-glass-danger">
                            <i class="bi bi-x-circle-fill me-1"></i> Habis
                        </span>
                    @endif
                </div>

                <!-- Harga -->
                <h1 class="fw-bold text-primary mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</h1>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <h5 class="fw-bold text-adaptive">Deskripsi Produk</h5>
                    <p class="text-adaptive-soft" style="line-height: 1.6;">
                        {{ $product->description ?: 'Tidak ada deskripsi untuk produk ini.' }}
                    </p>
                </div>

                <hr class="border-secondary opacity-25 my-4">

                <!-- Form Beli -->
                @auth
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <div class="row align-items-end g-3">
                                <div class="col-auto">
                                    <label class="form-label text-adaptive-soft fw-bold small">Jumlah</label>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                           class="form-control form-control-lg form-control-qty" style="width: 100px;">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm rounded-3">
                                        <i class="bi bi-cart-plus me-2"></i> Tambah Keranjang
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-lg w-100 disabled" disabled>Stok Habis</button>
                    @endif
                @else
                    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center gap-3">
                        <i class="bi bi-info-circle-fill fs-4"></i>
                        <div>
                            <strong>Ingin membeli barang ini?</strong><br>
                            Silakan <a href="{{ route('login') }}" class="fw-bold text-decoration-underline">Login</a> terlebih dahulu.
                        </div>
                    </div>
                @endauth

                <!-- Info Pengiriman -->
                <div class="shipping-box mt-4">
                    <h6 class="fw-bold text-adaptive mb-3"><i class="bi bi-truck me-2 text-warning"></i>Informasi Pengiriman</h6>
                    <ul class="list-unstyled text-adaptive-soft mb-0 small spacing-y-2">
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Pengiriman aman ke seluruh Indonesia</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Garansi uang kembali 100%</li>
                        <li><i class="bi bi-check2 text-success me-2"></i>Jaminan produk original</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection