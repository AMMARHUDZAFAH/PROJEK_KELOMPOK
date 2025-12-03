@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 product-card-anim">
        <h2 class="fw-bold text-adaptive mb-0">👤 Profil Saya</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-adaptive rounded-pill px-4 fw-bold shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali Belanja
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center gap-2 product-card-anim">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- 1. KARTU INFORMASI USER -->
        <div class="col-lg-8 mb-4 product-card-anim" style="animation-delay: 0.1s">
            <div class="card border-0 shadow-sm bg-glass-profile h-100">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <h5 class="mb-0 fw-bold text-adaptive"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Informasi Akun</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-adaptive-soft">Nama Lengkap</div>
                        <div class="col-sm-8 fw-bold text-adaptive">{{ Auth::user()->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-adaptive-soft">Email</div>
                        <div class="col-sm-8 fw-bold text-adaptive">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4 text-adaptive-soft">Status</div>
                        <div class="col-sm-8">
                            <!-- Badge Status User -->
                            <span class="badge rounded-pill badge-status-adaptive px-3 py-2">
                                {{ Auth::user()->role === 'admin' ? 'Admin' : 'Pelanggan' }}
                            </span>
                        </div>
                    </div>

                    <!-- Tombol Edit Profil -->
                    <button type="button" class="btn btn-edit-adaptive rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil-square me-1"></i> Edit Profil
                    </button>
                </div>
            </div>
        </div>

        <!-- 2. KARTU STATISTIK (Kanan) -->
        <div class="col-lg-4 mb-4 product-card-anim" style="animation-delay: 0.2s">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm bg-glass-profile text-center py-4">
                        <h1 class="fw-bold text-primary mb-0">{{ Auth::user()->orders ? Auth::user()->orders->count() : 0 }}</h1>
                        <small class="text-adaptive-soft fw-bold">📦 Total Pesanan</small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card border-0 shadow-sm bg-glass-profile text-center py-4">
                        <h3 class="fw-bold text-success mb-0">
                            Rp {{ number_format(Auth::user()->orders ? Auth::user()->orders->where('status', 'completed')->sum('total_price') : 0, 0) }}
                        </h3>
                        <small class="text-adaptive-soft fw-bold">💰 Total Belanja (Selesai)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TABEL PESANAN TERBARU -->
    <div class="card border-0 shadow-sm bg-glass-profile product-card-anim" style="animation-delay: 0.3s">
        <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
            <h5 class="mb-0 fw-bold text-adaptive"><i class="bi bi-clock-history me-2 text-warning"></i>Pesanan Terbaru</h5>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-reset">
                <thead class="bg-transparent border-bottom border-white border-opacity-10">
                    <tr>
                        <th class="ps-4 py-3 text-adaptive opacity-75">No. Pesanan</th>
                        <th class="py-3 text-adaptive opacity-75">Tanggal</th>
                        <th class="py-3 text-adaptive opacity-75">Total</th>
                        <th class="py-3 text-adaptive opacity-75">Status</th>
                        <th class="py-3 text-adaptive opacity-75">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $orders = Auth::user()->orders ?? collect([]); @endphp
                    @forelse($orders->sortByDesc('created_at')->take(5) as $order)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td class="ps-4 fw-bold text-primary">#{{ $order->id }}</td>
                        <td class="text-adaptive">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="fw-bold text-adaptive">Rp {{ number_format($order->total_price, 0) }}</td>
                        <td>
                            <!-- 
                                PERBAIKAN DISINI: 
                                Tidak pakai 'bg-{{ $order->status_badge }}' lagi.
                                Pakai class custom 'badge-status-{{ $order->status }}'
                            -->
                            <span class="badge rounded-pill badge-status-{{ $order->status }} px-3 py-2">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-adaptive rounded-pill px-3">
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-adaptive-soft">
                            <div class="mb-2" style="font-size: 2rem;">🍃</div>
                            Belum ada riwayat pesanan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-transparent border-top border-white border-opacity-10 p-3 text-center">
            <a href="{{ route('orders.index') }}" class="btn btn-link text-decoration-none fw-bold text-primary">Lihat Semua Pesanan →</a>
        </div>
    </div>

</div>

<!-- MODAL EDIT PROFIL -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background: var(--bs-body-bg); color: var(--bs-body-color);">
            <div class="modal-header border-bottom border-secondary border-opacity-10">
                <h5 class="modal-title fw-bold">✏️ Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label opacity-75">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label opacity-75">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary border-opacity-10">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* 1. TEXT ADAPTIF */
    .text-adaptive { color: #fff !important; }
    .text-adaptive-soft { color: rgba(255, 255, 255, 0.7) !important; }
    
    body.day-mode .text-adaptive { color: #333 !important; }
    body.day-mode .text-adaptive-soft { color: #666 !important; }

    /* 2. CARD GLASS */
    .bg-glass-profile {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
    }
    body.day-mode .bg-glass-profile {
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.05);
        color: #333;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05) !important;
    }

    /* 3. BUTTONS */
    .btn-outline-adaptive { border: 1px solid rgba(255,255,255,0.5); color: #fff; }
    .btn-outline-adaptive:hover { background: #fff; color: #333; }
    body.day-mode .btn-outline-adaptive { border: 1px solid #0d6efd; color: #0d6efd; }
    body.day-mode .btn-outline-adaptive:hover { background: #0d6efd; color: #fff; }

    .btn-edit-adaptive { background: #ffffff; color: #0d6efd; border: none; }
    .btn-edit-adaptive:hover { background: #f0f0f0; transform: translateY(-2px); }
    body.day-mode .btn-edit-adaptive { background: #0d6efd; color: #fff; }
    body.day-mode .btn-edit-adaptive:hover { background: #0b5ed7; }

    /* 4. STATUS BADGE USER (Admin/Pelanggan) */
    .badge-status-adaptive { background: rgba(25, 135, 84, 0.2); color: #20c997; border: 1px solid rgba(25, 135, 84, 0.4); }
    body.day-mode .badge-status-adaptive { background: #d1e7dd; color: #0f5132; border: none; }

    /* 5. STATUS PESANAN (Custom Classes per Status) */
    
    /* Pending (Menunggu Pembayaran) */
    .badge-status-pending { background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.4); }
    body.day-mode .badge-status-pending { background: #fff3cd; color: #856404; border: none; }

    /* Paid / Processing */
    .badge-status-paid, .badge-status-processing { background: rgba(13, 110, 253, 0.2); color: #0d6efd; border: 1px solid rgba(13, 110, 253, 0.4); }
    body.day-mode .badge-status-paid,
    body.day-mode .badge-status-processing { background: #cfe2ff; color: #084298; border: none; }

    /* Shipped */
    .badge-status-shipped { background: rgba(13, 202, 240, 0.2); color: #0dcaf0; border: 1px solid rgba(13, 202, 240, 0.4); }
    body.day-mode .badge-status-shipped { background: #cff4fc; color: #055160; border: none; }

    /* Completed */
    .badge-status-completed { background: rgba(25, 135, 84, 0.2); color: #198754; border: 1px solid rgba(25, 135, 84, 0.4); }
    body.day-mode .badge-status-completed { background: #d1e7dd; color: #0f5132; border: none; }

    /* Cancelled */
    .badge-status-cancelled { background: rgba(220, 53, 69, 0.2); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.4); }
    body.day-mode .badge-status-cancelled { background: #f8d7da; color: #842029; border: none; }

    /* 6. TABLE */
    .table { --bs-table-bg: transparent; }
    .text-reset { color: inherit !important; }
</style>
@endsection