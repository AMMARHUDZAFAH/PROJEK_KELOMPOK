@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📦 Manajemen Pesanan</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">← Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card bg-transparent">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-white bg-transparent">
                <thead class="bg-transparent">
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Pembeli</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong>#{{ $order->id }}</strong>
                        </td>
                        <td>
                            {{ $order->user->name }}<br>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </td>
                        <td>
                            <strong>Rp {{ number_format($order->total_price, 0) }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                        </td>
                        <td>
                            <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Force dark background + light text in night mode for readability */
    body:not(.day-mode) .table.text-white tbody td,
    body:not(.day-mode) .table.text-white tbody th {
        background-color: rgba(20,20,30,0.8) !important;
        color: #fff !important;
    }

    body:not(.day-mode) .table.text-white thead th {
        background-color: rgba(30,30,50,0.6) !important;
        color: rgba(255,255,255,0.95) !important;
    }

    /* Day mode: ensure text is dark on light background */
    body.day-mode .table.text-white td,
    body.day-mode .table.text-white th {
        background-color: #fff !important;
        color: #212529 !important;
    }
</style>
@endpush
