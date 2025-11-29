@extends('layouts.app')

@section('content')
<div class="container py-5">
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mb-4">← Kembali</a>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4>Pesanan #{{ $order->id }}</h4>
                            <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-{{ $order->status_badge }} fs-6">{{ $order->status_label }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">📦 Daftar Produk</h5>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex gap-2 align-items-center">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/'.$item->product->image) }}" style="width:40px;height:40px;object-fit:cover;border-radius:4px">
                                        @endif
                                        <div>
                                            <strong>{{ $item->product->name }}</strong><br>
                                            <small class="text-muted">{{ $item->product->category?->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->price, 0) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-bold">Rp {{ number_format($item->price * $item->quantity, 0) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">📍 Alamat Pengiriman</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $order->user->name }}</strong></p>
                    <p class="mb-1">Telepon: {{ $order->phone }}</p>
                    <p class="mb-0">{{ $order->address }}</p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top:20px">
                <div class="card-body">
                    <h5 class="card-title mb-3">💰 Ringkasan Pembayaran</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($order->total_price, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span>Pengiriman:</span>
                        <span class="text-success">Gratis</span>
                    </div>
                    <div class="d-flex justify-content-between fs-5 mb-3">
                        <strong>Total:</strong>
                        <strong class="text-primary">Rp {{ number_format($order->total_price, 0) }}</strong>
                    </div>

                    <div class="alert alert-info mb-3">
                        <strong>Status:</strong> {{ $order->status_label }}
                    </div>

                    @if($order->status === 'pending')
                    <div class="alert alert-warning">
                        <small><strong>⏳ Menunggu pembayaran</strong><br>Pesanan ini belum dibayar. Silakan lakukan pembayaran untuk melanjutkan.</small>
                    </div>
                    @elseif($order->status === 'paid')
                    <div class="alert alert-success">
                        <small><strong>✓ Pembayaran diterima</strong><br>Pesanan akan segera diproses.</small>
                    </div>
                    @elseif($order->status === 'processing')
                    <div class="alert alert-info">
                        <small><strong>📦 Diproses</strong><br>Pesanan sedang disiapkan untuk dikirim.</small>
                    </div>
                    @elseif($order->status === 'shipped')
                    <div class="alert alert-info">
                        <small><strong>🚚 Dikirim</strong><br>Pesanan sedang dalam perjalanan.</small>
                    </div>
                    @elseif($order->status === 'completed')
                    <div class="alert alert-success">
                        <small><strong>✓ Selesai</strong><br>Pesanan telah diterima.</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
