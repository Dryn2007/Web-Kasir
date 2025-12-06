<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Ambil user yang role-nya BUKAN admin
        // withCount('orders') otomatis menghitung jumlah transaksi user tersebut
        $users = User::where('role', '!=', 'admin')
            ->withCount('orders')
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Hapus user (Soft delete jika diaktifkan di model, atau permanent)

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
