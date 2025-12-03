@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 product-card-anim">
        <div>
            <h2 class="fw-bold mb-0 text-adaptive">📦 Pesanan Saya</h2>
            <p class="text-adaptive-soft mb-0">Riwayat belanja kamu di ElectroHub</p>
        </div>
        
        @if($orders->isNotEmpty())
        <div class="badge bg-white bg-opacity-10 border border-white border-opacity-25 p-2 px-3 rounded-pill shadow-sm">
            Total: {{ $orders->total() }} Pesanan
        </div>
        @endif
    </div>

    @if($orders->isEmpty())
        <!-- Tampilan Kosong -->
        <div class="text-center py-5 product-card-anim">
            <div class="mb-3" style="font-size: 4rem;">🛍️</div>
            <h4 class="fw-bold text-adaptive">Belum ada pesanan</h4>
            <p class="text-adaptive-soft mb-4">Yuk mulai belanja dan dapatkan gadget impianmu!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                Mulai Belanja
            </a>
        </div>
    @else
        <!-- List Pesanan -->
        <div class="row">
            @foreach($orders as $order)
            <div class="col-lg-8 mx-auto mb-4 product-card-anim">
                
                <!-- CARD ORDER (GLASS) -->
                <div class="card border-0 shadow-sm bg-glass-order overflow-hidden hover-scale">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            
                            <!-- Kiri: Info Utama -->
                            <div class="col-md-8 mb-3 mb-md-0">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="fw-bold mb-0 text-adaptive">Pesanan #{{ $order->id }}</h5>
                                        <small class="text-adaptive-soft opacity-75">
                                            <i class="bi bi-clock me-1"></i> {{ $order->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                    
                                    <!-- BADGE STATUS ADAPTIF -->
                                    <span class="badge rounded-pill badge-status-{{ $order->status }} px-3 py-2">
                                        {{ $order->status_label }}
                                    </span>
                                </div>
                                
                                <div class="row mt-3 text-adaptive-soft" style="font-size: 0.9rem;">
                                    <div class="col-6">
                                        <span>Total Pembayaran</span>
                                        <div class="fw-bold text-adaptive fs-5">Rp {{ number_format($order->total_price, 0) }}</div>
                                    </div>
                                    <div class="col-6">
                                        <span>Jumlah Produk</span>
                                        <div class="fw-bold text-adaptive">{{ $order->items->count() }} item</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kanan: Tombol Aksi -->
                            <div class="col-md-4 text-md-end border-start-glass ps-md-4">
                                <span class="d-block mb-1 text-adaptive-soft small">Alamat Pengiriman:</span>
                                <p class="mb-3 text-truncate text-adaptive fw-medium" style="max-width: 200px;">
                                    {{ Str::limit($order->address, 25) }}
                                </p>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-adaptive rounded-pill w-100 fw-bold">
                                    Lihat Detail
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>

<style>
    /* 1. TEXT ADAPTIF */
    .text-adaptive { color: #fff !important; }
    .text-adaptive-soft { color: rgba(255,255,255,0.7) !important; }

    body.day-mode .text-adaptive { color: #333 !important; }
    body.day-mode .text-adaptive-soft { color: #666 !important; }

    /* 2. CARD GLASS */
    .bg-glass-order {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    body.day-mode .bg-glass-order {
        background: #fff;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 5px 20px rgba(0,0,0,0.05) !important;
    }

    /* 3. PEMBATAS TENGAH */
    .border-start-glass { border-left: 1px solid rgba(255,255,255,0.1); }
    body.day-mode .border-start-glass { border-left: 1px solid rgba(0,0,0,0.1); }

    /* 4. BUTTON DETAIL */
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

    /* 5. BADGE STATUS CUSTOM (Biar Gak Silau) */
    
    /* Default (Malam) -> Transparan Berwarna */
    .badge-status-pending { background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.3); }
    .badge-status-paid { background: rgba(13, 202, 240, 0.2); color: #0dcaf0; border: 1px solid rgba(13, 202, 240, 0.3); }
    .badge-status-processing { background: rgba(13, 110, 253, 0.2); color: #0d6efd; border: 1px solid rgba(13, 110, 253, 0.3); }
    .badge-status-shipped { background: rgba(102, 16, 242, 0.2); color: #6f42c1; border: 1px solid rgba(102, 16, 242, 0.3); }
    .badge-status-completed { background: rgba(25, 135, 84, 0.2); color: #198754; border: 1px solid rgba(25, 135, 84, 0.3); }
    .badge-status-cancelled { background: rgba(220, 53, 69, 0.2); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.3); }

    /* Mode Siang -> Solid Soft */
    body.day-mode .badge-status-pending { background: #fff3cd; color: #856404; border: none; }
    body.day-mode .badge-status-paid { background: #cff4fc; color: #055160; border: none; }
    body.day-mode .badge-status-processing { background: #cfe2ff; color: #084298; border: none; }
    body.day-mode .badge-status-shipped { background: #e0cffc; color: #3d0a91; border: none; }
    body.day-mode .badge-status-completed { background: #d1e7dd; color: #0f5132; border: none; }
    body.day-mode .badge-status-cancelled { background: #f8d7da; color: #842029; border: none; }

    /* Efek Hover Card */
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: translateY(-3px); }
</style>
@endsection