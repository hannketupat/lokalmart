<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
        ]);

        $user->update($request->only(['name', 'email', 'role', 'phone', 'city', 'province', 'district']));

        return back()->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus');
    }
}
