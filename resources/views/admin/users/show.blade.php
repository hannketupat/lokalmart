@extends('layouts.admin')

@section('title', 'Detail Pengguna - Admin Panel')

@section('page-title', 'Detail Pengguna')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
        <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Edit</a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-6 border-b border-gray-100 flex items-center gap-4">
            <img src="{{ $user->avatar ?? 'https://i.pravatar.cc/80?u=' . $user->id }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                <p class="text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Telepon</h3>
                    <p class="mt-1 text-gray-900">{{ $user->phone ?? '-' }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Role</h3>
                    <p class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Lokasi</h3>
                    <p class="mt-1 text-gray-900">{{ $user->city ?? '-' }}, {{ $user->province ?? '-' }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Kecamatan</h3>
                    <p class="mt-1 text-gray-900">{{ $user->district ?? '-' }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Rating</h3>
                    <p class="mt-1 text-gray-900">{{ $user->rating ?? 0 }} / 5.00</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total Transaksi</h3>
                    <p class="mt-1 text-gray-900">{{ $user->total_transactions ?? 0 }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Status</h3>
                    <p class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Aktif</span>
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Bergabung</h3>
                    <p class="mt-1 text-gray-900">{{ $user->created_at->format('d F Y') }}</p>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-sm text-gray-500">Produk Dijual</p>
                        <p class="mt-1 text-2xl font-bold text-gray-900">{{ $user->products()->count() }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-sm text-gray-500">Produk Aktif</p>
                        <p class="mt-1 text-2xl font-bold text-gray-900">{{ $user->products()->where('status', 'active')->count() }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-sm text-gray-500">Review Diterima</p>
                        <p class="mt-1 text-2xl font-bold text-gray-900">{{ $user->receivedReviews()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection