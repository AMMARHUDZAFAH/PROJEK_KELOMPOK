@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2>🛒 Shopping Cart</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Continue Shopping</a>
    </div>
<style>
    /* ===== TRANSITIONS GLOBAL ===== */
    * {
        transition: 0.25s ease;
    }

    /* ===== BACKGROUND GRADIENT UTAMA ===== */
    body {
        background: linear-gradient(160deg, #01082D 0%, #041D56 40%, #0F2573 100%) !important;
        min-height: 100vh;
        padding-bottom: 40px;
    }

    /* ===== CARD EFFECT: SOFT SHADOW & LIFT ===== */
    .card {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4) !important;
        border-radius: 12px
         !important;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(38,108,169,0.3) !important;
    }

    /* ===== HOVER EFFECT UNTUK BARIS TABEL ===== */
    tbody tr:hover {
        background-color: rgba(173, 225, 251, 0.08) !important;
    }

    /* ===== DIVIDER GLOW UNTUK SUMMARY ===== */
    .card-body > div {
        border-bottom: 1px solid rgba(173,225,251,0.1);
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    .card-body > div:last-child {
        border-bottom: none !important;
    }

    /* ===== HIGHLIGHT UTAMA: TOTAL ===== */
    .fs-5 strong {
        color: #ADE1FB !important;
        text-shadow: 0 0 8px rgba(38,108,169,0.4);
    }

    /* ===== BUTTON ENHANCEMENTS ===== */
    .btn-primary {
        box-shadow: 0 0 10px rgba(38,108,169,0.5);
        font-weight: 600;
    }

    .btn-primary:hover {
        box-shadow: 0 0 15px rgba(173,225,251,0.7);
    }

    .btn-outline-primary:hover,
    .btn-outline-danger:hover {
        box-shadow: 0 0 10px rgba(38,108,169,0.4);
        transform: translateY(-2px);
    }

    /* ===== CART IMAGES ===== */
    td img {
        border: 2px solid #266CA9;
        border-radius: 8px !important;
        box-shadow: 0 0 8px rgba(38,108,169,0.4);
    }

    td img:hover {
        transform: scale(1.05);
    }

    /* ===== INPUT NUMBER ===== */
    .form-control {
        border-radius: 6px !important;
    }

    .form-control:hover {
        border-color: #ADE1FB !important;
    }

    /* Highlight saat fokus */
    .form-control:focus {
        box-shadow: 0 0 8px rgba(173,225,251,0.3) !important;
    }

    /* ===== EMPTY CART CONTAINER ===== */
    .alert-info {
        border-radius: 14px;
        background: linear-gradient(135deg, #266CA9 0%, #0F2573 100%) !important;
        color: #fff !important;
        padding: 40px !important;
    }

    /* ===== HEADER SECTION ===== */
    h2 {
        text-shadow: 0 0 12px rgba(173,225,251,0.4);
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .d-flex a.btn-outline-primary {
        font-weight: 600;
    }

    h2 {
        color: #ADE1FB !important; /* paling terang */
        text-shadow: 0 0 12px rgba(0,0,0,0.7), 0 0 8px rgba(173,225,251,0.3);
        font-weight: 700 !important;
        letter-spacing: 0.5px;
    }

    /* ===== TEKS PRODUK ===== */
tbody td h6 {
    color: #0F2573 !important;   /* biru gelap, jelas terbaca */
    font-weight: 600;
}

tbody td small {
    color: #266CA9 !important;  /* biru terang untuk kategori */
}

/* ===== HARGA & SUBTOTAL ===== */
tbody td:nth-child(2),
tbody td:nth-child(4) {
    color: #0F2573 !important;
    font-weight: 600;
}

/* ===== TOMBOL UPDATE ===== */
.btn-outline-secondary {
    border-color: #0F2573 !important;
    color: #0F2573 !important;
    font-weight: 600;
}

.btn-outline-secondary:hover {
    background: #0F2573 !important;
    color: white !important;
}

/* ===== TOMBOL HAPUS ===== */
.btn-danger,
.btn-danger:focus {
    background: #041D56 !important;
    border: none !important;
}

.btn-danger:hover {
    background: #01082D !important;
}
/* ===== CARD SUMMARY ===== */
.card-body {
    background: linear-gradient(160deg, #041D56 0%, #01082D 100%) !important;
    border-radius: 12px !important;
    color: #ADE1FB !important;
}

/* Title Ringkasan */
.card-title {
    color: #ADE1FB !important;
    font-weight: 700 !important;
    text-shadow: 0 0 8px rgba(173,225,251,0.4);
}

/* Label */
.card-body span {
    color: #D2ECFF !important;
}

/* Value total */
.fs-5 strong {
    color: #ADE1FB !important;
    text-shadow: 0 0 6px rgba(173,225,251,0.3);
}

/* Garis divider */
.card-body > div {
    border-bottom: 1px solid rgba(173,225,251,0.12) !important;
}

/* Tombol Checkout */
.btn-primary {
    background: #266CA9 !important;
    border: none !important;
}

.btn-primary:hover {
    background: #0F2573 !important;
    box-shadow: 0 0 10px rgba(173,225,251,0.4);
}

/* Tombol Kosongkan */
.btn-outline-danger {
    border: 1px solid #266CA9 !important;
    color: #ADE1FB !important;
}

.btn-outline-danger:hover {
    background: #266CA9 !important;
    color: white !important;
}
.card {
    background: rgba(1, 8, 45, 0.6) !important;
    border: 1px solid rgba(38,108,169,0.2) !important;
}

</style>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($items->isEmpty())
        <div class="alert alert-info text-center py-5">
            <h5>Keranjang Anda kosong</h5>
            <p class="mb-3">Belum ada produk di keranjang</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Mulai Belanja</a>
        </div>
    @else
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/'.$item->product->image) }}" style="width:60px;height:60px;object-fit:cover;border-radius:4px">
                                            @else
                                                <div style="width:60px;height:60px;background:#f0f0f0;border-radius:4px"></div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                <small class="text-muted">{{ $item->product->category?->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->product->price, 0) }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            <div class="input-group" style="width:100px">
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="form-control form-control-sm">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">Update</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>Rp {{ number_format($item->product->price * $item->quantity, 0) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top:20px">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Ringkasan Pesanan</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>Rp {{ number_format($total, 0) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pengiriman:</span>
                            <span class="text-success">Gratis</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 fs-5">
                            <strong>Total:</strong>
                            <strong>Rp {{ number_format($total, 0) }}</strong>
                        </div>

                        <a href="{{ route('checkout.show') }}" class="btn btn-primary w-100 mb-2">Lanjut ke Checkout</a>
                        
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Kosongkan keranjang?')">Kosongkan Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
