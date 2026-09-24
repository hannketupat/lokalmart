@extends('layouts.admin')

@section('title', 'Kelola Produk - Admin Panel')

@section('page-title', 'Produk')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6 px-4 md:px-0">
        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Produk</h1>
    </div>

    {{-- TABS --}}
    <div class="flex gap-1 overflow-x-auto border-b border-gray-200 mb-6">
        @php
            $tabs = [
                'all' => 'Semua',
                'pending' => 'Pending',
                'active' => 'Active',
                'rejected' => 'Rejected',
            ];
        @endphp
        @foreach($tabs as $key => $label)
            <a href="{{ route('admin.products.index', ['status' => $key]) }}"
               class="whitespace-nowrap px-4 py-2.5 text-sm border-b-2 -mb-px transition
                      {{ $status === $key
                          ? 'border-indigo-600 text-indigo-600 font-bold'
                          : 'border-transparent text-gray-500 hover:text-gray-800 font-medium' }}">
                {{ $label }}
                <span class="ml-1.5 text-xs {{ $status === $key ? 'text-indigo-400' : 'text-gray-400' }}">{{ $counts[$key] }}</span>
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Penjual</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kondisi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Dibuat</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                        $statusBadge = [
                            'active' => 'bg-emerald-100 text-emerald-700',
                            'pending' => 'bg-amber-100 text-amber-700',
                            'draft' => 'bg-gray-100 text-gray-700',
                            'inactive' => 'bg-gray-100 text-gray-700',
                            'rejected' => 'bg-red-100 text-red-700',
                            'sold' => 'bg-indigo-100 text-indigo-700',
                        ];
                    @endphp
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ productImageUrl($product) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-xl object-cover">
                                    <div>
                                        <p class="font-medium text-gray-900 truncate max-w-xs">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $product->category->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700">{{ $product->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->user->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusBadge[$product->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                                @if($product->status === 'rejected' && $product->rejection_reason)
                                    <p class="mt-1 text-xs text-red-600 max-w-[180px] leading-snug">{{ $product->rejection_reason }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">{{ ucfirst($product->condition) }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $product->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($product->status === 'pending')
                                        <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition" title="Setujui">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i> Setujui
                                            </button>
                                        </form>
                                        <button type="button"
                                                @click="$dispatch('open-reject-modal', { id: {{ $product->id }}, name: '{{ addslashes($product->name) }}' })"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition" title="Tolak">
                                            <i data-lucide="x" class="w-3.5 h-3.5"></i> Tolak
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.products.show', $product) }}" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg" title="Lihat">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg" title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus produk ini?')">
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
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">Belum ada produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARD LIST --}}
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($products as $product)
                <div class="p-4">
                    <div class="flex items-start gap-3">
                        <img src="{{ productImageUrl($product) }}" alt="{{ $product->name }}" class="w-14 h-14 rounded-xl object-cover shrink-0">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">{{ $product->category->name ?? '-' }}</p>
                            <p class="mt-1 text-sm font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="mt-1.5 flex items-center gap-2 flex-wrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusBadge[$product->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">{{ ucfirst($product->condition) }}</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-400">{{ $product->user->name }} • {{ $product->created_at->format('d M Y') }}</p>
                            @if($product->status === 'rejected' && $product->rejection_reason)
                                <p class="mt-1 text-xs text-red-600 leading-snug">{{ $product->rejection_reason }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @if($product->status === 'pending')
                            <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition">
                                    <i data-lucide="check" class="w-3.5 h-3.5"></i> Setujui
                                </button>
                            </form>
                            <button type="button"
                                    @click="$dispatch('open-reject-modal', { id: {{ $product->id }}, name: '{{ addslashes($product->name) }}' })"
                                    class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition">
                                <i data-lucide="x" class="w-3.5 h-3.5"></i> Tolak
                            </button>
                        @endif
                        <a href="{{ route('admin.products.show', $product) }}" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-xs font-semibold transition">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-xs font-semibold transition">
                            <i data-lucide="edit" class="w-3.5 h-3.5"></i> Edit
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg border border-rose-200 text-rose-600 text-xs font-semibold transition">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-500">Belum ada produk</div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    </div>
</div>

@include('admin.products.reject-modal')
@endsection
