@extends('layouts.app')

@section('title', 'Produk Saya | LokalMart')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Produk Saya</h1>
                <p class="mt-1.5 text-sm text-gray-500">Kelola barang yang sedang kamu jual</p>
            </div>
            <a href="{{ route('products.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold shadow-sm transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Jual Barang
            </a>
        </div>

        {{-- TABS --}}
        @php
            $tabs = [
                'semua' => 'Semua',
                'aktif' => 'Aktif',
                'draft' => 'Draft',
                'transaksi' => 'Dalam Transaksi',
                'terjual' => 'Terjual',
            ];
        @endphp
        <div class="mt-6 flex gap-1 overflow-x-auto border-b border-gray-200">
            @foreach($tabs as $key => $label)
                <a href="{{ route('products.my', ['tab' => $key]) }}"
                   class="whitespace-nowrap px-4 py-2.5 text-sm border-b-2 -mb-px transition
                          {{ $tab === $key
                              ? 'border-indigo-600 text-indigo-600 font-bold'
                              : 'border-transparent text-gray-500 hover:text-gray-800 font-medium' }}">
                    {{ $label }}
                    <span class="ml-1.5 text-xs {{ $tab === $key ? 'text-indigo-400' : 'text-gray-400' }}">{{ $counts[$key] }}</span>
                </a>
            @endforeach
        </div>

        {{-- LIST PRODUK --}}
        @php
            $statusLabel = [
                'active' => ['Aktif', 'bg-emerald-50 text-emerald-600'],
                'draft' => ['Draft', 'bg-amber-50 text-amber-600'],
                'inactive' => ['Nonaktif', 'bg-gray-100 text-gray-500'],
                'sold' => ['Terjual', 'bg-indigo-50 text-indigo-600'],
            ];
        @endphp

        @if($products->isEmpty())
            <div class="mt-10 bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                <span class="mx-auto grid place-items-center w-16 h-16 rounded-2xl bg-gray-100 text-gray-300">
                    <i data-lucide="package" class="w-8 h-8"></i>
                </span>
                <h2 class="mt-5 text-lg font-bold text-gray-800">Belum ada produk</h2>
                <p class="mt-1 text-sm text-gray-500">Mulai jual barang pertamamu sekarang</p>
                <a href="{{ route('products.create') }}"
                   class="inline-block mt-6 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition">
                    Jual Barang
                </a>
            </div>
        @else
            <div class="mt-6 space-y-4">
                @foreach($products as $product)
                    @php
                        [$label, $badgeClass] = $statusLabel[$product->status] ?? ['Lainnya', 'bg-gray-100 text-gray-500'];
                    @endphp
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5 flex gap-4 sm:gap-5 hover:shadow-md transition group">
                        <a href="{{ route('products.show', $product->slug) }}"
                           class="shrink-0 w-24 h-24 sm:w-28 sm:h-28 rounded-lg overflow-hidden bg-gray-100">
                            <img src="{{ productImageUrl($product) }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </a>

                        <div class="flex-1 min-w-0 flex flex-col justify-between">
                            <div>
                                <div class="flex items-start justify-between gap-3">
                                    <a href="{{ route('products.show', $product->slug) }}"
                                       class="font-semibold text-sm sm:text-base text-gray-800 line-clamp-2 hover:text-indigo-600 transition">
                                        {{ $product->name }}
                                    </a>
                                </div>
                                <div class="mt-1.5 flex flex-wrap items-center gap-2">
                                    <span class="text-sm sm:text-base font-extrabold text-indigo-600">{{ formatRupiah($product->price) }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold {{ $badgeClass }}">{{ $label }}</span>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-400 inline-flex items-center gap-1.5">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                {{ $product->views }} dilihat
                                <span class="text-gray-300">•</span>
                                {{ timeAgo($product->created_at) }}
                            </p>
                        </div>

                        {{-- DROPDOWN ACTION --}}
                        <div class="relative shrink-0 self-start" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open"
                                    class="p-2 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
                                <i data-lucide="more-vertical" class="w-5 h-5"></i>
                            </button>

                            <div x-show="open" x-transition x-cloak
                                 class="absolute right-0 mt-2 w-44 rounded-2xl border border-gray-100 bg-white shadow-xl p-1.5 z-20">
                                <a href="{{ route('products.show', $product->slug) }}"
                                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm text-gray-700 hover:bg-gray-50">
                                    <i data-lucide="eye" class="w-4 h-4 text-gray-400"></i> Lihat
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm text-gray-700 hover:bg-gray-50">
                                    <i data-lucide="pencil" class="w-4 h-4 text-gray-400"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('products.toggle', $product->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm text-gray-700 hover:bg-gray-50">
                                        <i data-lucide="{{ $product->status === 'active' ? 'toggle-left' : 'toggle-right' }}" class="w-4 h-4 text-gray-400"></i>
                                        {{ $product->status === 'active' ? 'Nonaktifkan' : ($product->status === 'inactive' ? 'Aktifkan' : 'Publikasikan') }}
                                    </button>
                                </form>
                                <div class="pt-1 mt-1 border-t border-gray-100">
                                    <form method="POST" action="{{ route('products.destroy', $product->id) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm text-rose-600 hover:bg-rose-50">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection