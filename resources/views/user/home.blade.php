@extends('layouts.app')

@section('title', 'Home | LokalMart')

@section('content')
    <div x-data="{ showLocationModal: false }">

        {{-- HERO LOKASI --}}
        <section class="relative overflow-hidden bg-gradient-to-b from-indigo-50 via-indigo-50/60 to-white">
            <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-indigo-100 blur-3xl opacity-60"></div>
            <div class="absolute top-32 -left-24 w-64 h-64 rounded-full bg-violet-100 blur-3xl opacity-50"></div>

            <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-10 sm:py-14">
                <div class="relative bg-white/80 backdrop-blur rounded-3xl border border-indigo-100 shadow-sm overflow-hidden">
                    <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-violet-100 blur-3xl opacity-40 pointer-events-none"></div>

                    <div class="relative flex flex-wrap items-center justify-between gap-x-6 gap-y-4 px-6 sm:px-10 py-8 sm:py-10">
                        <div>
                            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wide">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                Lokasi Kamu
                            </span>
                            <h1 class="mt-3 text-xl md:text-2xl lg:text-3xl font-extrabold tracking-tight text-gray-900">
                                Barang di sekitar kamu
                            </h1>
                            <p class="mt-2 text-sm sm:text-base text-gray-500 flex items-center gap-1.5">
                                📍 {{ trim($user->district . ', ' . $user->city, ', ') }}
                            </p>
                        </div>

                        <button type="button" @click="showLocationModal = true"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-indigo-600 text-indigo-600 hover:bg-indigo-50 text-sm font-semibold transition">
                            <i data-lucide="pencil" class="w-4 h-4"></i> Ubah Lokasi
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- MODAL UBAH LOKASI --}}
        <div x-show="showLocationModal" x-cloak x-transition.opacity
             class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/50" @click="showLocationModal = false"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <span class="grid place-items-center w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </span>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Ubah Lokasi</h3>
                            <p class="text-xs text-gray-400">Fitur ini akan segera hadir</p>
                        </div>
                    </div>
                    <button type="button" @click="showLocationModal = false"
                            class="p-2 rounded-full text-gray-400 hover:bg-gray-100 transition">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <p class="mt-4 text-sm text-gray-500 leading-relaxed">
                    Saat ini kamu berlokasi di
                    <span class="font-semibold text-gray-800">📍 {{ trim($user->district . ', ' . $user->city, ', ') }}</span>.
                    Fitur perubahan lokasi akan tersedia di pembaruan berikutnya.
                </p>
                <button type="button" @click="showLocationModal = false"
                        class="mt-6 w-full rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-3 transition">
                    Mengerti
                </button>
            </div>
        </div>

        @php
            $categoryColors = [
                'bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600',
                'bg-rose-50 text-rose-500 group-hover:bg-rose-500',
                'bg-amber-50 text-amber-500 group-hover:bg-amber-500',
                'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600',
                'bg-violet-50 text-violet-600 group-hover:bg-violet-600',
                'bg-sky-50 text-sky-500 group-hover:bg-sky-500',
            ];
        @endphp

        {{-- KATEGORI --}}
        <section class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-12">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600">Kategori</span>
                    <h2 class="mt-2 text-xl md:text-2xl lg:text-3xl font-extrabold text-gray-900">Jelajahi Kategori</h2>
                </div>
                <a href="{{ route('explore') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 shrink-0">Lihat semua →</a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @forelse($categories as $category)
                    <a href="{{ route('explore', ['category' => $category->slug]) }}"
                       class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center text-center hover:shadow-lg hover:border-indigo-100 hover:-translate-y-0.5 transition-all">
                        <span class="grid place-items-center w-14 h-14 rounded-2xl {{ $categoryColors[$loop->index % count($categoryColors)] }} group-hover:text-white transition-colors">
                            <i data-lucide="{{ $category->icon }}" class="w-7 h-7"></i>
                        </span>
                        <p class="mt-4 text-sm font-bold text-gray-800">{{ $category->name }}</p>
                        <p class="mt-1 text-xs text-gray-400">{{ $category->products_count }} produk</p>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-400 py-10">Belum ada kategori.</p>
                @endforelse
            </div>
        </section>

        {{-- REKOMENDASI --}}
        <section class="bg-white border-y border-gray-100">
            <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-12">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-indigo-600">Rekomendasi</span>
                        <h2 class="mt-2 text-xl md:text-2xl lg:text-3xl font-extrabold text-gray-900">Rekomendasi untuk kamu</h2>
                        <p class="mt-2 text-sm md:text-base text-gray-500">Barang terbaru dari penjual di sekitar lokasimu.</p>
                    </div>
                    <a href="{{ route('explore') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 shrink-0">Lihat semua →</a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                    @forelse($recommended as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <div class="col-span-full text-center py-16">
                            <i data-lucide="package-open" class="w-12 h-12 text-gray-300 mx-auto"></i>
                            <p class="mt-4 text-gray-500 font-medium">Belum ada produk tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection