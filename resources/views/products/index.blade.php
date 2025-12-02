@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    <!-- 1. HEADER & SEARCH BAR (Ada animasinya juga) -->
    <div class="row justify-content-center mb-5 product-card-anim">
        <div class="col-lg-10">
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