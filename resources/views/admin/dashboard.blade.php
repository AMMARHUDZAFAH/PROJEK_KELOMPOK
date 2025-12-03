@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- HEADER DASHBOARD -->
    <div class="d-flex justify-content-between align-items-center mb-4 product-card-anim">
        <div>
            <h2 class="fw-bold mb-0 text-white">📊 Admin Dashboard</h2>
            <p class="mb-0 text-white-50">Ringkasan aktivitas toko kamu hari ini</p>
        </div>
        <div class="badge bg-white bg-opacity-10 border border-light text-white p-2 px-3 rounded-pill shadow-sm backdrop-blur">
            📅 {{ now()->format('d M Y') }}
        </div>
    </div>

    <!-- 1. QUICK ACTION BUTTONS -->
    <div class="row mb-4 product-card-anim">
        <div class="col-12">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary px-4 rounded-pill shadow-sm">
                    <i class="bi bi-people-fill me-1"></i> Kelola User
                </a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary px-4 rounded-pill shadow-sm">
                    <i class="bi bi-tags-fill me-1"></i> Kategori
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-info text-white px-4 rounded-pill shadow-sm">
                    <i class="bi bi-box-seam-fill me-1"></i> Produk
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-warning px-4 rounded-pill shadow-sm">
                    <i class="bi bi-cart-check-fill me-1"></i> Pesanan
                </a>
                <a href="{{ route('admin.export.products.pdf') }}" class="btn btn-outline-light px-4 rounded-pill shadow-sm" target="_blank">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF Produk
                </a>
                <a href="{{ route('admin.export.profit.csv') }}" class="btn btn-outline-light px-4 rounded-pill shadow-sm">
                    <i class="bi bi-file-earmark-spreadsheet-fill me-1"></i> Excel Keuntungan
                </a>
            </div>
        </div>
    </div>

    <!-- 2. STATISTIK CARDS (Glass Effect) -->
    <div class="row mb-4">
        <!-- Card 1 -->
        <div class="col-md-3 mb-3 product-card-anim" style="animation-delay: 0.1s">
            <div class="card h-100 shadow-sm border-0 bg-transparent-glass">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-success bg-opacity-25 text-success rounded-circle me-3">
                            <i class="bi bi-cash-stack fs-4"></i>
                        </div>
                        <h6 class="mb-0 fw-bold opacity-75 text-white">Total Omset</h6>
                    </div>
                    <h3 class="fw-bold mb-0 text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-3 mb-3 product-card-anim" style="animation-delay: 0.2s">
            <div class="card h-100 shadow-sm border-0 bg-transparent-glass">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-primary bg-opacity-25 text-primary rounded-circle me-3">
                            <i class="bi bi-bag-check-fill fs-4"></i>
                        </div>
                        <h6 class="mb-0 fw-bold opacity-75 text-white">Pesanan Selesai</h6>
                    </div>
                    <h3 class="fw-bold mb-0 text-white">{{ $completedOrders }}</h3>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-3 mb-3 product-card-anim" style="animation-delay: 0.3s">
            <div class="card h-100 shadow-sm border-0 bg-transparent-glass">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-warning bg-opacity-25 text-warning rounded-circle me-3">
                            <i class="bi bi-hourglass-split fs-4"></i>
                        </div>
                        <h6 class="mb-0 fw-bold opacity-75 text-white">Perlu Diproses</h6>
                    </div>
                    <h3 class="fw-bold mb-0 text-white">{{ $pendingOrders }}</h3>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-3 mb-3 product-card-anim" style="animation-delay: 0.4s">
            <div class="card h-100 shadow-sm border-0 bg-transparent-glass">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-info bg-opacity-25 text-info rounded-circle me-3">
                            <i class="bi bi-box-fill fs-4"></i>
                        </div>
                        <h6 class="mb-0 fw-bold opacity-75 text-white">Total Produk</h6>
                    </div>
                    <h3 class="fw-bold mb-0 text-white">{{ $productCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TABEL PESANAN TERBARU -->
    <!-- 2.5 SALES CHART -->
    <div class="row mb-4">
        <div class="col-12 product-card-anim">
            <div class="card shadow-sm border-0 bg-transparent-glass">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <h5 class="mb-0 fw-bold text-white"><i class="bi bi-graph-up me-2 text-success"></i>Grafik Penjualan (30 hari)</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 mb-4 product-card-anim" style="animation-delay: 0.5s">
            <div class="card shadow-sm border-0 h-100 bg-transparent-glass">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <h5 class="mb-0 fw-bold text-white"><i class="bi bi-receipt me-2 text-primary"></i>Pesanan Terbaru</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 text-white">
                        <thead class="bg-transparent border-bottom border-white border-opacity-10">
                            <tr>
                                <th class="ps-4 opacity-75 text-white">ID</th>
                                <th class="opacity-75 text-white">Pembeli</th>
                                <th class="opacity-75 text-white">Total</th>
                                <th class="opacity-75 text-white">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestOrders as $order)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td class="ps-4 fw-bold text-primary">#{{ $order->id }}</td>
                                    <td>
                                        <span class="fw-bold d-block text-white">{{ $order->user->name }}</span>
                                        <small class="opacity-50 text-white-50">{{ $order->user->email }}</small>
                                    </td>
                                    <td class="fw-bold text-white">Rp {{ number_format($order->total_price, 0) }}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-{{ $order->status_badge }} bg-opacity-75">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 opacity-50 text-white">Belum ada pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- LIST PRODUK -->
        <div class="col-lg-4 mb-4 product-card-anim" style="animation-delay: 0.6s">
            <div class="card shadow-sm border-0 h-100 bg-transparent-glass">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <h5 class="mb-0 fw-bold text-white"><i class="bi bi-stars me-2 text-warning"></i>Produk Baru</h5>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($latestProducts as $product)
                        <div class="list-group-item bg-transparent border-bottom border-white border-opacity-10 py-3 d-flex align-items-center gap-3">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" class="rounded" style="width: 45px; height: 45px; object-fit: cover;">
                            @else
                                <div class="bg-secondary bg-opacity-25 rounded d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-image opacity-50 text-white"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-0 fw-bold text-white">{{ Str::limit($product->name, 20) }}</h6>
                                <small class="text-primary fw-bold">Rp {{ number_format($product->price, 0) }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center opacity-50 text-white">Kosong</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS MANUAL GLASS */
    .bg-transparent-glass {
        background: rgba(255, 255, 255, 0.1) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    body.day-mode .bg-transparent-glass {
        background: rgba(255, 255, 255, 0.85) !important;
        border: 1px solid rgba(0,0,0,0.1);
    }

    /* Pastikan text putih di mode malam */
    .text-white { color: #fff !important; }
    .text-white-50 { color: rgba(255, 255, 255, 0.5) !important; }

    /* Override mode siang */
    body.day-mode .text-white { color: #333 !important; }
    body.day-mode .text-white-50 { color: #666 !important; }

    .icon-box {
        width: 45px; height: 45px;
        display: flex; align-items: center; justify-content: center;
    }
    .backdrop-blur { backdrop-filter: blur(5px); }
    
    /* Tabel transparan */
    .table { --bs-table-bg: transparent; color: inherit; }
</style>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function(){
            const ctx = document.getElementById('salesChart');
            if(!ctx) return;

            // fetch data endpoint
            fetch('{{ route('admin.sales.data') }}')
                .then(r => r.json())
                .then(payload => {
                    const labels = payload.labels || [];
                    const data = payload.data || [];

                    const isDay = document.body.classList.contains('day-mode');
                    const lineColor = isDay ? '#0d6efd' : '#64b5f6';
                    const bgColor = isDay ? 'rgba(13,110,253,0.12)' : 'rgba(100,181,246,0.12)';

                    new Chart(ctx.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Pendapatan (Rp)',
                                data: data,
                                fill: true,
                                backgroundColor: bgColor,
                                borderColor: lineColor,
                                pointRadius: 2,
                                tension: 0.25
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    ticks: {
                                        // format number short
                                        callback: function(value){
                                            return new Intl.NumberFormat('id-ID').format(value);
                                        },
                                        color: isDay ? '#000' : '#fff'
                                    },
                                    grid: { color: isDay ? 'rgba(0,0,0,0.06)' : 'rgba(255,255,255,0.06)' }
                                },
                                x: {
                                    ticks: { color: isDay ? '#000' : '#fff' },
                                    grid: { display: false }
                                }
                            },
                            plugins: {
                                legend: { labels: { color: isDay ? '#000' : '#fff' } },
                                tooltip: { callbacks: { label: function(context){ return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y); } } }
                            }
                        }
                    });
                })
                .catch(err => console.error('Sales chart load error', err));
        })();
    </script>
@endpush
@endsection