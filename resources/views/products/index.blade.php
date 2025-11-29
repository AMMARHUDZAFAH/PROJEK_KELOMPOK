@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-3">All Products</h2>

    <form method="GET" class="row mb-3 g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Search</label>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search product name">
        </div>
        <div class="col-md-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-control">
                <option value="">All categories</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @if(request('category')==$c->id) selected @endif>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="row">
        @foreach($products as $p)
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                @if($p->image)
                    <img src="{{ asset('storage/'.$p->image) }}" class="card-img-top" style="height:160px;object-fit:cover" />
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $p->name }}</h5>
                    <p class="card-text text-muted mb-2">{{ $p->category?->name }}</p>
                    <p class="card-text mb-3">Rp {{ number_format($p->price,2) }}</p>
                    <a href="{{ route('products.show', $p) }}" class="mt-auto btn btn-sm btn-primary">View</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $products->links() }}
</div>
@endsection
