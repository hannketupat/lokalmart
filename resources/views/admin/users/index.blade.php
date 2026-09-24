@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Admin Panel')

@section('page-title', 'Pengguna')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6 px-4 md:px-0">
        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Pengguna</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Bergabung</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar ?? 'https://i.pravatar.cc/40?u=' . $user->id }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700">{{ $user->phone ?? '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $user->city }}, {{ $user->province }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Aktif</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg" title="Lihat">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg" title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada pengguna</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARD LIST --}}
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($users as $user)
                <div class="p-4">
                    <div class="flex items-start gap-3">
                        <img src="{{ $user->avatar ?? 'https://i.pravatar.cc/40?u=' . $user->id }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full shrink-0">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ $user->phone ?? '-' }} • {{ $user->city }}, {{ $user->province }}</p>
                            <div class="mt-1.5 flex items-center gap-2 flex-wrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Aktif</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-400">Bergabung {{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <a href="{{ route('admin.users.show', $user) }}" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-xs font-semibold transition">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat
                        </a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-xs font-semibold transition">
                            <i data-lucide="edit" class="w-3.5 h-3.5"></i> Edit
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg border border-rose-200 text-rose-600 text-xs font-semibold transition">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-500">Belum ada pengguna</div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection