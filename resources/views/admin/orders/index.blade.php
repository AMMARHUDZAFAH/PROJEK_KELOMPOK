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
                        <td class="text-dark">
                            <strong>#{{ $order->id }}</strong>
                        </td>
                        <td class="text-dark">
                            {{ $order->user->name }}<br>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </td>
                        <td class="text-dark">
                            <strong>Rp {{ number_format($order->total_price, 0) }}</strong>
                        </td>
                        <td class="text-dark">
                            <span class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                        </td>
                        <td class="text-dark">
                            <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </td>
                        <td class="text-dark">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted text-dark">Belum ada pesanan</td>
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
    /* Only keep thead styling. Removed any rules targeting <td> as requested. */
    body:not(.day-mode) .table.text-white thead th {
        background-color: rgba(30,30,50,0.6) !important;
        color: rgba(255,255,255,0.95) !important;
    }

    html[data-bs-theme="dark"] .table.text-white thead th {
        background-color: rgba(30,30,50,0.6) !important;
        color: rgba(255,255,255,0.95) !important;
    }

    html[data-bs-theme="light"] .table.text-white thead th {
        background-color: #fff !important;
        color: #212529 !important;
    }

    /* Ultra-specific selectors for dark mode - force visibility */
    body:not(.day-mode) .table.text-white tbody tr td,
    body:not(.day-mode) .table.text-white tbody tr td.text-dark,
    body:not(.day-mode) .table.text-white tbody tr td.text-dark small,
    body:not(.day-mode) .table.text-white tbody tr td.text-dark small.text-muted,
    body:not(.day-mode) .table.text-white tbody tr td.text-dark .text-muted {
        color: rgba(255,255,255,0.95) !important;
    }

    /* Day mode - ensure dark text */
    body.day-mode .table.text-white tbody tr td,
    body.day-mode .table.text-white tbody tr td.text-dark,
    body.day-mode .table.text-white tbody tr td.text-dark small,
    body.day-mode .table.text-white tbody tr td.text-dark small.text-muted,
    body.day-mode .table.text-white tbody tr td.text-dark .text-muted {
        color: #000000 !important;
    }
</style>
@endpush
