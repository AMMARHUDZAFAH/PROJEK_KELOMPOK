@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2>📂 Kelola Kategori</h2>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    ➕ Tambah Kategori
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Dibuat</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td><strong>#{{ $category->id }}</strong></td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <small class="text-muted">
                                        {{ Str::limit($category->description, 50) }}
                                    </small>
                                </td>
                                <td><small class="text-muted">{{ $category->created_at->format('d/m/Y H:i') }}</small></td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada kategori. <a href="{{ route('admin.categories.create') }}">Tambah sekarang</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
