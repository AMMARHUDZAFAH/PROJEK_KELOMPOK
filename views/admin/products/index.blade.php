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

    <table class="table">
        <thead>
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
                <td>{{ $p->name }}</td>
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
