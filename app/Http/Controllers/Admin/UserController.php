<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withTrashed()->where('id', '!=', Auth::id())->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id() || $user->role === 'admin') {
            return back()->with('error', 'Tidak bisa menghapus akun ini.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User dipindah ke trash.');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil direstore.');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if ($user->id === Auth::id() || $user->role === 'admin') {
            return back()->with('error', 'Tidak bisa menghapus akun ini.');
        }
        $user->forceDelete();
        return redirect()->route('admin.users.index')->with('success', 'User dihapus permanen.');
    }
}
