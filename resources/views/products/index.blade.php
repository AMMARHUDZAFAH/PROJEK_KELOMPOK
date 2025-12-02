@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- 1. HERO SECTION + SEARCH -->
    <!-- Hapus class 'products-hero' yang bawa background biru sendiri -->
    <div class="row justify-content-center mb-5 product-card-anim">
        
        <div class="col-lg-10 text-center">
            <div class="mb-4">
                <!-- JUDUL ADAPTIF: Putih di malam, Biru Tua di siang -->
                <h2 class="fw-bold display-5 mb-2 text-hero-adaptive">
                    🛍️ Temukan Gadget Impianmu
                </h2>
                <p class="text-hero-sub-adaptive fs-5">
                    Jelajahi koleksi elektronik terbaik dengan harga terjangkau
                </p>
            </div>

            <!-- SEARCH CARD (Glassmorphism) -->
            <div class="card shadow-lg border-0 bg-transparent" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <form method="GET" class="row g-3 align-items-end">
                        <!-- Input Search -->
                        <div class="col-md-5 text-start">
                            <label class="form-label fw-bold small text-uppercase opacity-75">Cari Produk</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control border-0 bg-transparent shadow-none" placeholder="Contoh: iPhone 13...">
                            </div>
                        </div>
                        <!-- Input Kategori -->
                        <div class="col-md-4 text-start">
                            <label class="form-label fw-bold small text-uppercase opacity-75">Kategori</label>
                            <select name="category" class="form-select border-0 bg-transparent shadow-none">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" @if(request('category')==$c->id) selected @endif>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Tombol Cari -->
                        <div class="col-md-3">
                            <button class="btn btn-primary w-100 fw-bold py-2 rounded-3 shadow-sm">
                                <i class="bi bi-funnel-fill me-1"></i> Filter
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
        <div class="col-md-3 mb-4 product-card-anim">
            <!-- Card Produk (Glass Effect Global) -->
            <div class="card h-100 border-0 shadow-sm hover-top overflow-hidden">
                
                <!-- Gambar Produk -->
                <div class="position-relative bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 220px;">
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $p->name }}">
                    @else
                        <div class="text-muted small">No Image</div>
                    @endif

                    @if($p->category)
                        <span class="badge bg-dark bg-opacity-75 position-absolute top-0 start-0 m-3 shadow-sm backdrop-blur">
                            {{ $p->category->name }}
                        </span>
                    @endif
                </div>

                <!-- Info Produk -->
                <div class="card-body d-flex flex-column p-4">
                    <!-- NAMA PRODUK ADAPTIF (Otomatis Putih/Hitam) -->
                    <h5 class="card-title fw-bold mb-1 text-adaptive lh-sm">
                        {{ Str::limit($p->name, 40) }}
                    </h5>
                    
                    <div class="mb-3 mt-2">
                        <h5 class="text-primary fw-bold mb-0">Rp {{ number_format($p->price, 0, ',', '.') }}</h5>
                        <div class="mt-1">
                            @if($p->stock > 0)
                                <small class="text-success fw-bold"><i class="bi bi-check-circle-fill"></i> Ready</small>
                            @else
                                <small class="text-danger fw-bold"><i class="bi bi-x-circle-fill"></i> Habis</small>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('products.show', $p) }}" class="btn btn-outline-primary w-100 mt-auto rounded-pill fw-bold">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        @empty
        <!-- Tampilan Jika Kosong -->
        <div class="col-12 text-center py-5 product-card-anim">
            <div class="mb-3" style="font-size: 4rem;">🛸</div>
            <h4 class="fw-bold text-hero-adaptive">Produk tidak ditemukan</h4>
            <p class="text-hero-sub-adaptive">Coba cari dengan kata kunci lain.</p>
            
            <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
                <i class="bi bi-arrow-counterclockwise"></i> Reset Pencarian
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">
        {{ $products->links() }}
    </div>

</div>

<!-- CSS KHUSUS HALAMAN INI -->
<style>
    /* 1. TEXT HERO ADAPTIF */
    /* Malam: Putih, Siang: Biru Gelap (Biar kontras sama langit biru muda) */
    .text-hero-adaptive { color: #fff; text-shadow: 0 2px 10px rgba(0,0,0,0.5); }
    .text-hero-sub-adaptive { color: rgba(255,255,255,0.8); }

    body.day-mode .text-hero-adaptive { color: #003366; text-shadow: none; }
    body.day-mode .text-hero-sub-adaptive { color: #555; }

    /* 2. TEXT PRODUK ADAPTIF */
    /* Malam: Putih, Siang: Hitam */
    .text-adaptive { color: #fff; }
    body.day-mode .text-adaptive { color: #333; }

    /* 3. INPUT FORM FIX */
    /* Input form dipaksa putih bersih backgroundnya biar teks user (hitam) kebaca */
    .form-control, .form-select {
        background-color: #fff !important; 
        color: #333 !important;
    }

    /* 4. HOVER CARD */
    .hover-top { transition: transform 0.3s, box-shadow 0.3s; }
    .hover-top:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 15px 30px rgba(0,0,0,0.2) !important; 
    }
    
    .backdrop-blur { backdrop-filter: blur(4px); }
</style>
@endsection