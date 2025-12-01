@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <style>
            /* Dashboard UI animations (non-functional, purely visual) */
            .anim-fade {
                opacity: 0;
                transform: translateY(8px);
                transition: opacity .5s ease, transform .5s ease;
            }
            .anim-fade.visible {
                opacity: 1;
                transform: none;
            }
            .anim-card {
                will-change: transform, box-shadow;
                transition: transform .18s ease, box-shadow .18s ease;
            }
            .anim-card:hover {
                transform: translateY(-6px) scale(1.01);
                box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            }
            .btn-animate {
                transition: transform .12s ease, box-shadow .12s ease;
            }
            .btn-animate:active { transform: scale(.98); }
            .count { font-variant-numeric: tabular-nums; }
            .progress .progress-bar { transition: width 1s ease; }
            .status-badge { transition: transform .18s ease; }
            .status-badge:hover { transform: scale(1.06); }
            /* Blue background hero for dashboard */
            .dashboard-hero{
                position: relative;
                overflow: hidden;
                background: linear-gradient(135deg,#0b5ed7 0%, #3da5ff 55%, #e6f4ff 100%);
                color: #fff;
                border-radius: 12px;
                padding: 1.25rem;
                box-shadow: 0 8px 32px rgba(13,110,253,0.12);
            }
            .dashboard-hero:before{
                content: '';
                position: absolute;
                right: -120px;
                top: -60px;
                width: 360px;
                height: 360px;
                background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.12), rgba(255,255,255,0) 40%);
                transform: rotate(15deg);
                pointer-events: none;
            }
            .dashboard-hero .card{ background: rgba(255,255,255,0.95); }
            .dashboard-hero h2{ color: #fff; }
            .dashboard-hero .text-muted{ color: rgba(0,0,0,0.55); }
            .dashboard-hero .btn{ box-shadow: 0 6px 18px rgba(13,110,253,0.12); }
            .dashboard-hero .badge{ box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
        </style>

        <h2 class="mb-4 anim-fade">📊 Admin Dashboard</h2>
        <div class="dashboard-hero mb-4">

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
                <div class="card text-center shadow-sm border-primary anim-card anim-fade">
                    <div class="card-body">
                        <h5 class="card-title text-primary">💰 Total Penjualan</h5>
                        <h3 class="mb-0"><span class="count" data-prefix="Rp " data-target="{{ $totalRevenue }}">Rp {{ number_format($totalRevenue, 0) }}</span></h3>
                        <small class="text-muted">Dari pesanan selesai</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm border-success anim-card anim-fade">
                    <div class="card-body">
                        <h5 class="card-title text-success">✅ Pesanan Selesai</h5>
                        <h3 class="mb-0"><span class="count" data-target="{{ $completedOrders }}">{{ $completedOrders }}</span></h3>
                        <small class="text-muted">Pesanan yang sudah dikirim</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm border-warning anim-card anim-fade">
                    <div class="card-body">
                        <h5 class="card-title text-warning">⏳ Pesanan Pending</h5>
                        <h3 class="mb-0"><span class="count" data-target="{{ $pendingOrders }}">{{ $pendingOrders }}</span></h3>
                        <small class="text-muted">Menunggu pembayaran</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm border-info anim-card anim-fade">
                    <div class="card-body">
                        <h5 class="card-title text-info">📦 Total Produk</h5>
                        <h3 class="mb-0"><span class="count" data-target="{{ $productCount }}">{{ $productCount }}</span></h3>
                        <small class="text-muted">Produk di katalog</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Stats -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm anim-card anim-fade">
                    <div class="card-body">
                        <h4><span class="count" data-target="{{ $userCount }}">{{ $userCount }}</span></h4>
                        <p class="mb-0">👤 Pengguna</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm anim-card anim-fade">
                    <div class="card-body">
                        <h4><span class="count" data-target="{{ $categoryCount }}">{{ $categoryCount }}</span></h4>
                        <p class="mb-0">🗂️ Kategori</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm anim-card anim-fade">
                    <div class="card-body">
                        <h4><span class="count" data-target="{{ $orderCount }}">{{ $orderCount }}</span></h4>
                        <p class="mb-0">📋 Total Pesanan</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm anim-card anim-fade">
                    <div class="card-body">
                        <h4><span class="count" data-target="{{ $totalUsers }}">{{ $totalUsers }}</span></h4>
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
        <script>
            (function(){
                function formatNumber(n){
                    try{ return new Intl.NumberFormat('id-ID').format(Math.round(n)); }catch(e){ return n; }
                }

                document.addEventListener('DOMContentLoaded', function(){
                    // reveal elements with stagger
                    document.querySelectorAll('.anim-fade').forEach(function(el, i){
                        setTimeout(function(){ el.classList.add('visible'); }, 80 * i);
                    });

                    // animate counters
                    document.querySelectorAll('.count').forEach(function(el){
                        var target = parseFloat(el.getAttribute('data-target')) || 0;
                        var prefix = el.getAttribute('data-prefix') || '';
                        var duration = 900;
                        var start = 0;
                        var startTime = null;

                        function step(timestamp){
                            if (!startTime) startTime = timestamp;
                            var progress = Math.min((timestamp - startTime) / duration, 1);
                            var value = Math.floor(progress * (target - start) + start);
                            el.textContent = prefix + formatNumber(value);
                            if (progress < 1) {
                                window.requestAnimationFrame(step);
                            } else {
                                // ensure final exact value
                                el.textContent = prefix + formatNumber(target);
                            }
                        }

                        // start only if target > 0
                        if (target > 0) window.requestAnimationFrame(step);
                    });

                    // animate progress bars from 0 to their width
                    document.querySelectorAll('.progress .progress-bar').forEach(function(bar){
                        var to = bar.style.width || '0%';
                        bar.style.width = '0%';
                        setTimeout(function(){ bar.style.width = to; }, 60);
                    });
                });
            })();
        </script>
    </div>
@endsection