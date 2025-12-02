@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    <!-- Tombol Kembali -->
    <a href="{{ route('orders.index') }}" class="btn btn-outline-adaptive rounded-pill mb-4 fw-bold shadow-sm px-4">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>

    <div class="row">
        <!-- KOLOM KIRI -->
        <div class="col-lg-8">
            
            <!-- 1. Header Order -->
            <div class="card border-0 shadow-sm mb-4 product-card-anim bg-glass">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="text-adaptive">
                            <h4 class="fw-bold mb-1">Pesanan #{{ $order->id }}</h4>
                            <small class="opacity-75"><i class="bi bi-calendar3 me-1"></i> {{ $order->created_at->format('d M Y, H:i') }}</small>
                        </div>
                        <div>
                            <span class="badge rounded-pill bg-{{ $order->status_badge }} px-3 py-2 fs-6 shadow-sm">
                                {{ $order->status_label }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Daftar Produk (YANG MASALAH TADI) -->
            <div class="card border-0 shadow-sm mb-4 product-card-anim bg-glass">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <h5 class="mb-0 fw-bold text-adaptive"><i class="bi bi-box-seam me-2 text-primary"></i>Daftar Produk</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <!-- Tambahkan class 'text-adaptive' di setiap th -->
                                <th class="ps-4 text-adaptive opacity-75">Produk</th>
                                <th class="text-adaptive opacity-75">Harga</th>
                                <th class="text-center text-adaptive opacity-75">Qty</th>
                                <th class="text-end pe-4 text-adaptive opacity-75">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr class="border-bottom-glass">
                                <td class="ps-4">
                                    <div class="d-flex gap-3 align-items-center">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/'.$item->product->image) }}" class="rounded shadow-sm" style="width:50px;height:50px;object-fit:cover;">
                                        @else
                                            <div class="bg-secondary bg-opacity-25 rounded d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                                <i class="bi bi-image text-adaptive opacity-50"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <!-- Paksa warna teks disini -->
                                            <strong class="d-block text-adaptive">{{ $item->product->name }}</strong>
                                            <small class="text-adaptive-soft">{{ $item->product->category?->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-adaptive">Rp {{ number_format($item->price, 0) }}</td>
                                <td class="text-center text-adaptive">{{ $item->quantity }}</td>
                                <td class="fw-bold text-end pe-4 text-primary">Rp {{ number_format($item->price * $item->quantity, 0) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Alamat -->
            <div class="card border-0 shadow-sm mb-4 product-card-anim bg-glass">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <h5 class="mb-0 fw-bold text-adaptive"><i class="bi bi-geo-alt me-2 text-danger"></i>Alamat Pengiriman</h5>
                </div>
                <div class="card-body p-4 text-adaptive">
                    <h6 class="fw-bold">{{ $order->user->name }}</h6>
                    <p class="mb-1 opacity-75"><i class="bi bi-telephone me-2"></i> {{ $order->phone }}</p>
                    <p class="mb-0 opacity-75"><i class="bi bi-map me-2"></i> {{ $order->address }}</p>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top product-card-anim bg-glass" style="top: 100px; animation-delay: 0.4s">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4 fw-bold text-adaptive">💰 Ringkasan Pembayaran</h5>

                    <div class="d-flex justify-content-between mb-2 text-adaptive opacity-75">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->total_price, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-white border-opacity-10 text-adaptive opacity-75">
                        <span>Pengiriman</span>
                        <span class="text-success fw-bold">Gratis</span>
                    </div>
                    <div class="d-flex justify-content-between fs-5 mb-4 text-adaptive">
                        <strong>Total</strong>
                        <strong class="text-primary">Rp {{ number_format($order->total_price, 0) }}</strong>
                    </div>

                    <!-- Status Alerts -->
                    @if($order->status === 'pending')
                        <div class="alert alert-warning border-0 shadow-sm"><i class="bi bi-hourglass-split me-2"></i>Menunggu Pembayaran</div>
                    @elseif($order->status === 'paid')
                        <div class="alert alert-success border-0 shadow-sm"><i class="bi bi-check-circle-fill me-2"></i>Pembayaran Diterima</div>
                    @elseif($order->status === 'processing')
                        <div class="alert alert-info border-0 shadow-sm"><i class="bi bi-box-seam me-2"></i>Sedang Diproses</div>
                    @elseif($order->status === 'shipped')
                        <div class="alert alert-primary border-0 shadow-sm"><i class="bi bi-truck me-2"></i>Sedang Dikirim</div>
                    @elseif($order->status === 'completed')
                        <div class="alert alert-success border-0 shadow-sm"><i class="bi bi-star-fill me-2"></i>Selesai</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* 1. GLASS EFFECT */
    .bg-glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .border-bottom-glass {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* 2. TEXT ADAPTIVE (YANG PENTING INI) */
    /* Default (Mode Malam) -> PUTIH */
    .text-adaptive { color: #ffffff !important; }
    .text-adaptive-soft { color: rgba(255, 255, 255, 0.7) !important; }
    
    /* Mode Siang (Override) -> HITAM */
    body.day-mode .text-adaptive { color: #212529 !important; }
    body.day-mode .text-adaptive-soft { color: #6c757d !important; }

    /* Fix Background Card di Siang Hari */
    body.day-mode .bg-glass {
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    /* Fix Garis di Siang Hari */
    body.day-mode .border-bottom-glass {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    body.day-mode .border-white { border-color: rgba(0,0,0,0.1) !important; }

    /* 3. BUTTON */
    .btn-outline-adaptive { color: #fff; border: 2px solid rgba(255,255,255,0.5); }
    .btn-outline-adaptive:hover { background: #fff; color: #333; }
    
    body.day-mode .btn-outline-adaptive { color: #333; border: 2px solid #ccc; }
    body.day-mode .btn-outline-adaptive:hover { background: #333; color: #fff; }

    /* 4. TABLE CLEANUP */
    .table { --bs-table-bg: transparent; }
    
    /* Pastikan header table tidak punya background sendiri */
    .table > :not(caption) > * > * {
        background-color: transparent !important;
        color: inherit; /* Ikut parent */
    }
</style>
@endsection