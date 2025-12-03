@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 product-card-anim">
        <h2 class="fw-bold text-adaptive"><i class="bi bi-cart3 me-2"></i>Keranjang Belanja</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-adaptive rounded-pill px-4 fw-bold">
            <i class="bi bi-arrow-left me-1"></i> Lanjut Belanja
        </a>
    </div>

    <!-- Alert Sukses/Error -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center gap-2 product-card-anim">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($items->isEmpty())
        <!-- KOSONG (Desain Baru Transparan) -->
        <div class="card border-0 shadow-sm bg-glass-cart text-center py-5 product-card-anim">
            <div class="card-body">
                <div class="mb-3" style="font-size: 4rem;">🛒</div>
                <h4 class="fw-bold text-adaptive">Keranjang Anda Kosong</h4>
                <p class="text-adaptive-soft mb-4">Belum ada produk yang ditambahkan.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                    Mulai Belanja
                </a>
            </div>
        </div>
    @else
        <!-- ADA ISI -->
        <div class="row">
            
            <!-- LIST ITEM -->
            <div class="col-lg-8 mb-4 product-card-anim" style="animation-delay: 0.1s">
                <div class="card border-0 shadow-sm bg-glass-cart overflow-hidden">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 text-reset">
                            <thead class="bg-transparent border-bottom border-white border-opacity-10">
                                <tr>
                                    <th class="ps-4 py-3 text-adaptive opacity-75">Produk</th>
                                    <th class="py-3 text-adaptive opacity-75">Harga</th>
                                    <th class="py-3 text-adaptive opacity-75" style="width: 120px;">Qty</th>
                                    <th class="py-3 text-adaptive opacity-75">Subtotal</th>
                                    <th class="py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/'.$item->product->image) }}" class="rounded shadow-sm" style="width:60px;height:60px;object-fit:cover;">
                                            @else
                                                <div class="bg-secondary bg-opacity-25 rounded d-flex align-items-center justify-content-center" style="width:60px;height:60px;">
                                                    <i class="bi bi-image text-adaptive opacity-50"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0 fw-bold text-adaptive">{{ Str::limit($item->product->name, 25) }}</h6>
                                                <small class="text-adaptive-soft">{{ $item->product->category?->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-adaptive">Rp {{ number_format($item->product->price, 0) }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center gap-2">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" 
                                                   class="form-control form-control-sm text-center bg-transparent border-secondary text-adaptive" style="width: 60px;">
                                            <button type="submit" class="btn btn-sm btn-link text-primary p-0" title="Update">
                                                <i class="bi bi-arrow-clockwise fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="fw-bold text-primary">Rp {{ number_format($item->product->price * $item->quantity, 0) }}</td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm text-danger hover-danger p-0" onclick="return confirm('Hapus produk ini?')">
                                                <i class="bi bi-trash3-fill fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- SUMMARY -->
            <div class="col-lg-4 product-card-anim" style="animation-delay: 0.2s">
                <div class="card border-0 shadow-sm bg-glass-cart sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-adaptive">🧾 Ringkasan Pesanan</h5>
                        
                        <div class="d-flex justify-content-between mb-2 text-adaptive opacity-75">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($total, 0) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-white border-opacity-10 text-adaptive opacity-75">
                            <span>Pengiriman</span>
                            <span class="text-success fw-bold">Gratis</span>
                        </div>
                        <div class="d-flex justify-content-between fs-4 mb-4 text-adaptive">
                            <strong>Total</strong>
                            <strong class="text-primary">Rp {{ number_format($total, 0) }}</strong>
                        </div>

                        <a href="{{ route('checkout.show') }}" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow-sm mb-3">
                            Lanjut Checkout <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                        
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 rounded-pill btn-sm" onclick="return confirm('Kosongkan semua keranjang?')">
                                <i class="bi bi-trash me-1"></i> Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>

<style>
    /* 1. TEXT ADAPTIF */
    .text-adaptive { color: #fff !important; }
    .text-adaptive-soft { color: rgba(255, 255, 255, 0.7) !important; }
    
    body.day-mode .text-adaptive { color: #333 !important; }
    body.day-mode .text-adaptive-soft { color: #666 !important; }

    /* 2. GLASS CARD */
    .bg-glass-cart {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    body.day-mode .bg-glass-cart {
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    /* 3. BUTTONS */
    .btn-outline-adaptive {
        border: 1px solid rgba(255,255,255,0.5);
        color: #fff;
    }
    .btn-outline-adaptive:hover { background: #fff; color: #333; }

    body.day-mode .btn-outline-adaptive {
        border: 1px solid #0d6efd;
        color: #0d6efd;
    }
    body.day-mode .btn-outline-adaptive:hover {
        background: #0d6efd; color: #fff;
    }

    /* 4. TABLE CLEANUP */
    .table { --bs-table-bg: transparent; }
    .text-reset { color: inherit !important; }
    
    /* Input qty di tabel */
    .form-control { color: inherit !important; }
</style>
@endsection