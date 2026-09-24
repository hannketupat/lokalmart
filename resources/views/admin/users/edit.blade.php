@extends('layouts.admin')

@section('title', 'Edit Pengguna - Admin Panel')

@section('page-title', 'Edit Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Pengguna: {{ $user->name }}</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ $user->name }}" required
                       class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required
                       class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" required
                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                <input type="text" name="phone" value="{{ $user->phone ?? '' }}"
                       class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                    <input type="text" name="city" value="{{ $user->city ?? '' }}"
                           class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                    <input type="text" name="province" value="{{ $user->province ?? '' }}"
                           class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                <input type="text" name="district" value="{{ $user->district ?? '' }}"
                       class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection