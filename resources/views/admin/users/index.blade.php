@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">👥 Manage Users</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">← Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered mt-3 text-white bg-transparent">
        <thead class="bg-transparent">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr @if($u->trashed()) class="table-secondary" @endif>
                <td>
                    {{ $u->name }}
                    @if($u->trashed())
                        <span class="badge bg-warning ms-2">Trashed</span>
                    @endif
                </td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role }}</td>
                <td>
                    @if($u->trashed())
                        <form action="{{ route('admin.users.restore', $u->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-success">Restore</button>
                        </form>
                        <form action="{{ route('admin.users.forceDelete', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus permanen?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete Permanen</button>
                        </form>
                    @else
                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection

@push('styles')
<style>
    /* CUSTOM SYSTEM: Night mode (.day-mode absence) */
    body:not(.day-mode) .table.text-white tbody td,
    body:not(.day-mode) .table.text-white tbody th {
        background-color: rgba(20,20,30,0.8) !important;
        color: #fff !important;
    }

    body:not(.day-mode) .table.text-white thead th {
        background-color: rgba(30,30,50,0.6) !important;
        color: rgba(255,255,255,0.95) !important;
    }

    /* CUSTOM SYSTEM: Day mode (.day-mode present) */
    body.day-mode .table.text-white td,
    body.day-mode .table.text-white th {
        background-color: #fff !important;
        color: #212529 !important;
    }

    /* Make trashed rows remain readable in night mode (custom system) */
    body:not(.day-mode) .table.table-secondary td {
        background-color: rgba(40,40,60,0.8) !important;
        color: #fff !important;
    }

    /* BOOTSTRAP SYSTEM: Dark mode (data-bs-theme="dark") */
    html[data-bs-theme="dark"] .table.text-white tbody td,
    html[data-bs-theme="dark"] .table.text-white tbody th {
        background-color: rgba(20,20,30,0.8) !important;
        color: #fff !important;
    }

    html[data-bs-theme="dark"] .table.text-white thead th {
        background-color: rgba(30,30,50,0.6) !important;
        color: rgba(255,255,255,0.95) !important;
    }

    html[data-bs-theme="dark"] .table.table-secondary td {
        background-color: rgba(40,40,60,0.8) !important;
        color: #fff !important;
    }

    /* BOOTSTRAP SYSTEM: Light mode (data-bs-theme="light") */
    html[data-bs-theme="light"] .table.text-white td,
    html[data-bs-theme="light"] .table.text-white th {
        background-color: #fff !important;
        color: #212529 !important;
    }
</style>
@endpush
