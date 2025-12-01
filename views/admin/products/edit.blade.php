@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Edit Product</h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">← Back</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Errors:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($categories->isEmpty())
        <div class="alert alert-warning">
            <strong>No categories found.</strong> Please <a href="{{ route('admin.categories.create') }}" class="alert-link">create a category</a> first.
        </div>
    @else
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="card p-4">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label"><strong>Product Name</strong></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" placeholder="e.g., Laptop Pro" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Category</strong></label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                    <option value="">-- Select a category --</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @if(old('category_id', $product->category_id)==$c->id) selected @endif>{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>Price (Rp)</strong></label>
                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" placeholder="0.00" required>
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>Stock</strong></label>
                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" placeholder="0" required>
                    @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Product Image</strong></label>
                @if($product->image)
                    <div class="mb-2">
                        <small class="text-muted">Current image:</small>
                        <div><img src="{{ asset('storage/'.$product->image) }}" style="max-width:120px;border-radius:4px;" /></div>
                    </div>
                @endif
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                <small class="form-text text-muted">JPG, PNG. Max 2MB. (Leave empty to keep current image)</small>
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Description</strong></label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Enter product description...">{{ old('description', $product->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-link">Cancel</a>
            </div>
        </form>
    @endif
</div>
@endsection
