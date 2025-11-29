@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <h2 class="mb-4">📊 Admin Dashboard</h2>

        <!-- Quick Action Buttons -->
        <div class="mb-4 d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                👤 Kelola Pengguna
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                🗂️ Kelola Kategori
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-info text-white">
                📦 Kelola Produk
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-warning">
                📋 Kelola Pesanan
            </a>
        </div>

        <!-- Sales Stats -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm border-primary">
                    <div class="card-body">
                        <h5 class="card-title text-primary">💰 Total Penjualan</h5>
                        <h3 class="mb-0">Rp {{ number_format($totalRevenue, 0) }}</h3>
                        <small class="text-muted">Dari pesanan selesai</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm border-success">
                    <div class="card-body">
                        <h5 class="card-title text-success">✅ Pesanan Selesai</h5>
                        <h3 class="mb-0">{{ $completedOrders }}</h3>
                        <small class="text-muted">Pesanan yang sudah dikirim</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm border-warning">
                    <div class="card-body">
                        <h5 class="card-title text-warning">⏳ Pesanan Pending</h5>
                        <h3 class="mb-0">{{ $pendingOrders }}</h3>
                        <small class="text-muted">Menunggu pembayaran</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm border-info">
                    <div class="card-body">
                        <h5 class="card-title text-info">📦 Total Produk</h5>
                        <h3 class="mb-0">{{ $productCount }}</h3>
                        <small class="text-muted">Produk di katalog</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Stats -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h4>{{ $userCount }}</h4>
                        <p class="mb-0">👤 Pengguna</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h4>{{ $categoryCount }}</h4>
                        <p class="mb-0">🗂️ Kategori</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h4>{{ $orderCount }}</h4>
                        <p class="mb-0">📋 Total Pesanan</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h4>{{ $totalUsers }}</h4>
                        <p class="mb-0">👥 Pelanggan Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">📋 Pesanan Terbaru</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Pembeli</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none">
                                                <strong>#{{ $order->id }}</strong>
                                            </a>
                                        </td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>Rp {{ number_format($order->total_price, 0) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                                        </td>
                                        <td><small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3 text-muted">Belum ada pesanan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">Lihat Semua Pesanan →</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">📦 Produk Terbaru</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($latestProducts as $product)
                            <a href="{{ route('admin.products.show', $product) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $product->name }}</strong>
                                        <br>
                                        <small class="text-muted">Rp {{ number_format($product->price, 0) }}</small>
                                    </div>
                                    <span class="badge bg-info">{{ $product->stock }} stok</span>
                                </div>
                            </a>
                        @empty
                            <div class="list-group-item text-center py-3 text-muted">Belum ada produk</div>
                        @endforelse
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">Lihat Semua Produk →</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">📊 Status Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Selesai</span>
                                <strong>{{ $completedOrders }}</strong>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: {{ $orderCount > 0 ? ($completedOrders/$orderCount*100) : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Diproses</span>
                                <strong>{{ $processingOrders }}</strong>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-info" style="width: {{ $orderCount > 0 ? ($processingOrders/$orderCount*100) : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Pending</span>
                                <strong>{{ $pendingOrders }}</strong>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: {{ $orderCount > 0 ? ($pendingOrders/$orderCount*100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection