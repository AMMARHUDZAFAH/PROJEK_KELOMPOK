@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>{{ $product->name }}</h2>
    <p><strong>Category:</strong> {{ $product->category?->name }}</p>
    <p><strong>Price:</strong> {{ number_format($product->price,2) }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>
    @if($product->image)
        <div class="mb-3"><img src="{{ asset('storage/'.$product->image) }}" style="max-width:300px" /></div>
    @endif
    <div>{{ $product->description }}</div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-link">Back</a>
</div>
@endsection
