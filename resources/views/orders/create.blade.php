@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Alert -->
            <div class="alert alert-success mb-4" role="alert">
                <h4 class="alert-heading">✓ Pesanan Berhasil Dibuat!</h4>
                <p>Nomor pesanan Anda: <strong>#{{ $order->id }}</strong></p>
                <hr>
                <p class="mb-0">Silakan selesaikan pembayaran sesuai dengan instruksi yang diberikan.</p>
            </div>

            <!-- Order Details -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">📋 Detail Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Status Pesanan</h6>
                            <span class="badge bg-warning">Menunggu Pembayaran</span>
                        </div>
                        <div class="col-md-6 text-end">
                            <h6>Tanggal Pesanan</h6>
                            <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>📍 Alamat Pengiriman</h6>
                            <p class="mb-0 small">{{ $order->address }}</p>
                            <p class="small text-muted">{{ $order->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>👤 Data Pembeli</h6>
                            <p class="mb-0 small">{{ $order->user->name }}</p>
                            <p class="small text-muted">{{ $order->user->email }}</p>
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
                                <td>{{ $item->product->name }}</td>
                                <td>Rp {{ number_format($item->price, 0) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->price * $item->quantity, 0) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 text-end">
                            <h5>Total Pembayaran:</h5>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-primary">Rp {{ number_format($order->total_price, 0) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="card mb-4 border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">💳 Instruksi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <h6>Transfer Bank</h6>
                    <p>
                        <strong>Bank:</strong> BCA<br>
                        <strong>Nomor Rekening:</strong> 1234567890<br>
                        <strong>Atas Nama:</strong> PT Electrohub Indonesia<br>
                        <strong>Jumlah:</strong> Rp {{ number_format($order->total_price, 0) }}<br>
                        <strong>Kode Unik:</strong> {{ rand(100, 999) }} (Tambahkan ke jumlah transfer)
                    </p>
                    <div class="alert alert-warning mt-3 mb-0">
                        <small>Pesanan akan diproses 1x24 jam setelah pembayaran dikonfirmasi</small>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">Lihat Detail Pesanan</a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Lanjut Belanja</a>
            </div>
        </div>
    </div>
</div>
@endsection
