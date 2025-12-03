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
                <td style="width:80px">
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}" class="img-fluid" />
                    @endif
                </td>
                <td class="">{{ $p->name }}</td>
                <td>{{ $p->category?->name }}</td>
                <td>{{ number_format($p->price,2) }}</td>
                <td>{{ $p->stock }}</td>
                <td>
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
