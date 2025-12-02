@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Pesanan #{{ $order->id }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Info -->
            <div class="card mb-4 bg-transparent">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Tanggal Pesanan</p>
                            <p class="mb-0"><strong>{{ $order->created_at->format('d F Y H:i') }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Status</p>
                            <p class="mb-0">
                                <span class="badge bg-{{ $order->status_badge }} fs-6">{{ $order->status_label }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="card mb-4 bg-transparent">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">👤 Informasi Pembeli</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>{{ $order->user->name }}</strong><br>
                        <small class="text-muted">{{ $order->user->email }}</small>
                    </p>
                    <hr class="my-3">
                    <p class="text-muted mb-1">Alamat Pengiriman</p>
                    <p class="mb-0">
                        <strong>{{ $order->address }}</strong><br>
                        <small>📱 {{ $order->phone }}</small>
                    </p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card mb-4 bg-transparent">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">📦 Item Pesanan</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-transparent">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                                        @endif
                                        <div>
                                            <strong>{{ $item->product->name ?? 'Produk Dihapus' }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->price, 0) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td><strong>Rp {{ number_format($item->price * $item->quantity, 0) }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Status Update Form -->
            <div class="card bg-transparent">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">🔄 Perbarui Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Status Baru</label>
                            <select name="status" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Menunggu Pembayaran</option>
                                <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>✅ Dibayar</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>🔄 Sedang Diproses</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>🚚 Dikirim</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>✨ Selesai</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">💾 Simpan Status</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card sticky-top bg-transparent" style="top: 20px;">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">💰 Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    @php
                        $subtotal = $order->items->sum(fn($item) => $item->price * $item->quantity);
                    @endphp
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($subtotal, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkir:</span>
                        <span>Gratis</span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong class="fs-5">Rp {{ number_format($order->total_price, 0) }}</strong>
                    </div>

                    <hr class="my-3">

                    <div class="bg-transparent p-3 rounded border border-white border-opacity-10">
                        <p class="text-muted mb-1"><small>Status Pembayaran</small></p>
                        @if($order->status === 'pending')
                            <div class="alert alert-warning mb-0 py-2">
                                ⚠️ Menunggu konfirmasi pembayaran dari pembeli
                            </div>
                        @elseif($order->status === 'paid')
                            <div class="alert alert-success mb-0 py-2">
                                ✅ Pembayaran telah diterima
                            </div>
                        @elseif($order->status === 'cancelled')
                            <div class="alert alert-danger mb-0 py-2">
                                ❌ Pesanan dibatalkan
                            </div>
                        @else
                            <div class="alert alert-info mb-0 py-2">
                                ℹ️ Status: {{ $order->status_label }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
