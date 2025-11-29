@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Category</h3>

    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Category Name</label>
            <input value="{{ $category->name }}" type="text" name="name" class="form-control" required>
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
