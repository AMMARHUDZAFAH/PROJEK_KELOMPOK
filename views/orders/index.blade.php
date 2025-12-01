@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📦 Pesanan Saya</h2>
    </div>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center py-5">
            <h5>Belum ada pesanan</h5>
            <p class="mb-3">Mulai belanja dan buat pesanan pertama Anda</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Mulai Belanja</a>
        </div>
    @else
        <div class="row">
            @foreach($orders as $order)
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-1">Pesanan #{{ $order->id }}</h6>
                                <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <small class="text-muted">Total Pembayaran</small>
                                <h6>Rp {{ number_format($order->total_price, 0) }}</h6>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Jumlah Produk</small>
                                <h6>{{ $order->items->count() }} item</h6>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Alamat</small>
                                <p class="mb-0"><small>{{ Str::limit($order->address, 30) }}</small></p>
                            </div>
                            <div class="col-md-3 text-end">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{ $orders->links() }}
    @endif
</div>
@endsection
