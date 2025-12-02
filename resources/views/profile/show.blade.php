@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">👤 Profil Saya</h2>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">← Belanja</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- User Info Card -->
                <div class="col-md-8 mb-4">
                    <div class="card bg-transparent">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">📋 Informasi Akun</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Nama Lengkap</label>
                                <p class="mb-0"><strong>{{ Auth::user()->name }}</strong></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Email</label>
                                <p class="mb-0"><strong>{{ Auth::user()->email }}</strong></p>
                            </div>
                            <div class="mb-0">
                                <label class="form-label text-muted">Role</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ Auth::user()->role === 'admin' ? 'danger' : 'success' }}">
                                        {{ Auth::user()->role === 'admin' ? '👨‍💼 Admin' : '👤 Pelanggan' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                ✏️ Edit Profil
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="col-md-4 mb-4">
                    <div class="card text-center mb-3">
                        <div class="card-body">
                            <h3 class="text-primary">{{ Auth::user()->orders ? Auth::user()->orders->count() : 0 }}</h3>
                            <p class="text-muted mb-0">📋 Total Pesanan</p>
                        </div>
                    </div>
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-success">
                                Rp {{ number_format(Auth::user()->orders ? Auth::user()->orders->where('status', 'completed')->sum('total_price') : 0, 0) }}
                            </h3>
                            <p class="text-muted mb-0">💰 Total Belanja</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card bg-transparent">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">📦 Pesanan Terbaru</h5>
                </div>
                @if(Auth::user()->orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-transparent">
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $orders = Auth::user()->orders ?? collect([]);
                                @endphp
                                @forelse($orders->sortByDesc('created_at')->take(5) as $order)
                                <tr>
                                    <td><strong>#{{ $order->id }}</strong></td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>Rp {{ number_format($order->total_price, 0) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">Lihat</a>
                                    </td>
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
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-secondary">Lihat Semua Pesanan →</a>
                    </div>
                @else
                    <div class="card-body text-center py-5 text-muted">
                        <p class="mb-0">Anda belum melakukan pembelian</p>
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary mt-2">Mulai Belanja</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">✏️ Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ Auth::user()->name }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ Auth::user()->email }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
