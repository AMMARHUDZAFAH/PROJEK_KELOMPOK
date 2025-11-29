@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Product Images & Details -->
        <div class="col-lg-6 mb-4">
            @if($product->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded" style="max-height:500px;width:100%;object-fit:contain">
                </div>
            @else
                <div style="height:500px;background:#f0f0f0;border-radius:8px;display:flex;align-items:center;justify-content:center">
                    <span class="text-muted">No Image</span>
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>

            <h1 class="mb-2">{{ $product->name }}</h1>
            
            <div class="mb-3">
                <span class="badge bg-secondary">{{ $product->category?->name }}</span>
                @if($product->stock > 0)
                    <span class="badge bg-success">Tersedia</span>
                @else
                    <span class="badge bg-danger">Habis</span>
                @endif
            </div>

            <div class="mb-4">
                <h2 class="text-primary mb-2">Rp {{ number_format($product->price, 0) }}</h2>
                <p class="text-muted">
                    <i class="bi bi-box"></i> Stok: <strong>{{ $product->stock }} unit</strong>
                </p>
            </div>

            <div class="mb-4">
                <h5>Deskripsi Produk</h5>
                <p>{{ $product->description ?: 'No description available' }}</p>
            </div>

            @auth
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row g-2 align-items-end">
                            <div class="col-auto">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width:80px" required>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-bag-plus"></i> Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="alert alert-warning">Produk ini sedang habis</div>
                @endif
            @else
                <div class="alert alert-info">
                    <a href="{{ route('login') }}" class="alert-link">Login</a> untuk membeli produk ini
                </div>
            @endauth

            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title">Informasi Pengiriman</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">✓ Pengiriman gratis ke seluruh Indonesia</li>
                        <li class="mb-2">✓ Garansi uang kembali 100%</li>
                        <li>✓ Dapat ditukar dalam 30 hari</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>
@endsection
