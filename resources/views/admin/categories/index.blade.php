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

        <div class="card bg-transparent">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-white bg-transparent">
                    <thead class="bg-transparent">
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
                                <td class="text-dark"><strong>#{{ $category->id }}</strong></td>
                                <td class="text-dark">{{ $category->name }}</td>
                                <td class="text-dark">
                                    <small class="text-muted">
                                        {{ Str::limit($category->description, 50) }}
                                    </small>
                                </td>
                                <td class="text-dark"><small class="text-muted">{{ $category->created_at->format('d/m/Y H:i') }}</small></td>
                                <td class="text-dark">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning ">
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
                                <td colspan="5" class="text-center py-4 text-muted text-dark">Belum ada kategori. <a href="{{ route('admin.categories.create') }}">Tambah sekarang</a></td>
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

    /* Fix <td> text color in dark mode - very specific selectors */
    body:not(.day-mode) .table.text-white tbody td.text-dark,
    body:not(.day-mode) .table.text-white tr td.text-dark {
        color: rgba(0, 0, 0, 0.95) !important;
        background-color: transparent !important;
    }

    body.day-mode .table.text-white tbody td.text-dark,
    body.day-mode .table.text-white tr td.text-dark {
        color: #000000 !important;
        background-color: transparent !important;
    }

    /* Override .text-muted inside .text-dark cells */
    body:not(.day-mode) .table.text-white td.text-dark .text-muted,
    body:not(.day-mode) .table.text-white td.text-dark small.text-muted {
        color: rgba(0, 0, 0, 0.95) !important;
    }

    body.day-mode .table.text-white td.text-dark .text-muted,
    body.day-mode .table.text-white td.text-dark small.text-muted {
        color: #000000 !important;
    }
</style>
@endpush
