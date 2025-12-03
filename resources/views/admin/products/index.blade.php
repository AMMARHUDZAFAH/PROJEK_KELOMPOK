@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">📦 Products</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">+ Add Product</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table text-white bg-transparent">
        <thead class="bg-transparent">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td class="text-dark" style="width:80px">
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}" class="img-fluid" />
                    @endif
                </td>
                <td class="text-dark">{{ $p->name }}</td>
                <td class="text-dark">{{ $p->category?->name }}</td>
                <td class="text-dark">{{ number_format($p->price,2) }}</td>
                <td class="text-dark">{{ $p->stock }}</td>
                <td class="text-dark">
                    <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete product?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
</div>
@endsection

@push('styles')
<style>
    /* CUSTOM SYSTEM: Night mode (.day-mode absence) */
    body:not(.day-mode) .table.text-white tbody th {
        background-color: rgba(20,20,30,0.8) !important;
        color: #000000ff !important;
    }

    body:not(.day-mode) .table.text-white thead th {
        background-color: rgba(30,30,50,0.6) !important;
        color: rgba(255,255,255,0.95) !important;
    }

    /* CUSTOM SYSTEM: Day mode (.day-mode present) */
    body.day-mode .table.text-white th {
        background-color: #fff !important;
        color: #212529 !important;
    }

    /* BOOTSTRAP SYSTEM: Dark mode (data-bs-theme="dark") */
    html[data-bs-theme="dark"] .table.text-white tbody th {
        background-color: rgba(20,20,30,0.8) !important;
        color: #000000ff !important;
    }

    html[data-bs-theme="dark"] .table.text-white thead th {
        background-color: rgba(30,30,50,0.6) !important;
        color: rgba(0, 0, 0, 0.95) !important;
    }

    /* BOOTSTRAP SYSTEM: Light mode (data-bs-theme="light") */
    html[data-bs-theme="light"] .table.text-white th {
        background-color: #fff !important;
        color: #212529 !important;
    }

    /* Fix <td> text color in dark mode - ensure td.text-dark stays black */
    body:not(.day-mode) .table.text-white tbody td.text-dark,
    body:not(.day-mode) .table.text-white tr td.text-dark {
        color: #000000 !important;
        background-color: transparent !important;
    }

    body.day-mode .table.text-white tbody td.text-dark,
    body.day-mode .table.text-white tr td.text-dark {
        color: #000000 !important;
        background-color: transparent !important;
    }
</style>
@endpush
