@extends('layouts.app')

@section('title', 'LokalMart | Temukan Barang di Sekitarmu')

@section('content')
    @php
        $heroImage = $products->first()->image ?? 'https://picsum.photos/seed/lokalmart-hero/720/640';
        $categoryColors = [
            'bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600',
            'bg-rose-50 text-rose-500 group-hover:bg-rose-500',
            'bg-amber-50 text-amber-500 group-hover:bg-amber-500',
            'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600',
            'bg-violet-50 text-violet-600 group-hover:bg-violet-600',
            'bg-sky-50 text-sky-500 group-hover:bg-sky-500',
        ];

        $steps = [
            ['icon' => 'search', 'title' => 'Cari Produk', 'desc' => 'Temukan barang yang kamu butuhkan dari penjual terdekat di sekitarmu.'],
            ['icon' => 'message-circle', 'title' => 'Chat via WhatsApp', 'desc' => 'Tanyakan detail, kondisi, dan nego harga langsung lewat WhatsApp.'],
            ['icon' => 'handshake', 'title' => 'Sepakati COD', 'desc' => 'Atur waktu, tempat, dan kesepakatan transaksi tatap muka.'],
            ['icon' => 'shield-check', 'title' => 'Selesaikan Transaksi', 'desc' => 'Bayar tunai saat barang diterima. Aman dan minim risiko.'],
        ];
    @endphp

    {{-- HERO --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-indigo-50 via-white to-white">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-indigo-100 blur-3xl opacity-60"></div>
        <div class="absolute top-40 -left-24 w-80 h-80 rounded-full bg-violet-100 blur-3xl opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="grid lg:grid-cols-2 gap-14 items-center">
                <div>
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wide">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                        Marketplace Lokal Se-Indonesia
                    </span>
                    <h1 class="mt-6 text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900 leading-tight">
                        Temukan Barang<br>
                        di <span class="text-indigo-600">Sekitarmu</span>
                    </h1>
                    <p class="mt-5 text-lg text-gray-500 max-w-lg leading-relaxed">
                        Marketplace lokal untuk jual beli barang dengan mudah dan aman melalui COD.
                    </p>

                    <form action="{{ route('landing') }}" method="GET" class="mt-8 max-w-lg">
                        <div class="relative flex items-center bg-white rounded-full border border-gray-200 shadow-sm p-1.5 focus-within:ring-2 focus-within:ring-indigo-500">
                            <span class="pl-4 text-lg">🔍</span>
                            <input type="text" name="q" value="{{ request('q') }}"
                                   placeholder="Cari barang di sekitar kamu..."
                                   class="flex-1 min-w-0 px-3 py-3 text-sm outline-none bg-transparent placeholder:text-gray-400">
                            <button class="shrink-0 px-6 py-3 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition">
                                Cari
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-600">
                        <span class="flex items-center gap-1.5"><i data-lucide="check-circle" class="w-4 h-4 text-emerald-500"></i> Gratis bergabung</span>
                        <span class="flex items-center gap-1.5"><i data-lucide="check-circle" class="w-4 h-4 text-emerald-500"></i> COD aman</span>
                        <span class="flex items-center gap-1.5"><i data-lucide="check-circle" class="w-4 h-4 text-emerald-500"></i> Penjual terverifikasi</span>
                    </div>
                </div>

                <div class="relative max-w-xl mx-auto w-full">
                    <div class="absolute -inset-6 bg-gradient-to-tr from-indigo-100 via-violet-100 to-rose-100 rounded-[2.5rem] blur-xl opacity-70"></div>

                    <div class="relative bg-white rounded-3xl border border-gray-100 shadow-xl p-3 rotate-1">
                        <img src="{{ $heroImage }}" alt="Produk LokalMart"
                             class="w-full aspect-[4/3] object-cover rounded-2xl">
                    </div>

                    <div class="absolute -top-5 -right-3 sm:-right-6 bg-white rounded-2xl shadow-lg border border-gray-100 px-4 py-3 flex items-center gap-3 -rotate-3">
                        <span class="grid place-items-center w-10 h-10 rounded-full bg-emerald-100 text-emerald-600"><i data-lucide="shield-check" class="w-5 h-5"></i></span>
                        <div>
                            <p class="text-sm font-bold text-gray-900">COD Aman</p>
                            <p class="text-xs text-gray-400">Bayar saat terima</p>
                        </div>
                    </div>

                    <div class="absolute -bottom-5 -left-3 sm:-left-6 bg-white rounded-2xl shadow-lg border border-gray-100 px-4 py-3 flex items-center gap-3 rotate-2">
                        <span class="grid place-items-center w-10 h-10 rounded-full bg-amber-100 text-amber-500 text-lg">★</span>
                        <div>
                            <p class="text-sm font-bold text-gray-900">4.9 / 5.0</p>
                            <p class="text-xs text-gray-400">Rating penjual lokal</p>
                        </div>
                    </div>

                    <div class="absolute bottom-12 right-2 bg-indigo-600 text-white rounded-2xl shadow-lg px-4 py-2 text-sm font-semibold rotate-3">
                        💬 Chat via WhatsApp langsung
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- KATEGORI --}}
    <section id="kategori" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 scroll-mt-24">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-600">Kategori</span>
                <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold text-gray-900">Jelajahi Kategori</h2>
            </div>
            <a href="#" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">Lihat semua →</a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @forelse($categories as $category)
                <a href="#" class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center text-center hover:shadow-lg hover:border-indigo-100 transition-all">
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

    {{-- PRODUK POPULER --}}
    <section id="produk" class="bg-white border-y border-gray-100 scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600">Populer</span>
                    <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold text-gray-900">Barang Populer di Sekitarmu</h2>
                </div>
                <a href="#" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">Lihat semua →</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @forelse($products as $product)
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

    {{-- CARA KERJA --}}
    <section id="cara-kerja" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 scroll-mt-24">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-indigo-600">Cara Kerja</span>
            <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold text-gray-900">Bagaimana LokalMart Bekerja?</h2>
            <p class="mt-3 text-gray-500">Empat langkah mudah untuk bertransaksi jual beli secara langsung dan aman.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($steps as $step)
                <div class="relative bg-white rounded-2xl border border-gray-100 shadow-sm p-6 pt-8 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <span class="absolute top-0 -translate-y-1/2 left-6 grid place-items-center w-11 h-11 rounded-2xl bg-indigo-600 text-white shadow-md">
                        <i data-lucide="{{ $step['icon'] }}" class="w-5 h-5"></i>
                    </span>
                    <span class="absolute top-5 right-6 text-4xl font-extrabold text-gray-100">{{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="text-base font-bold text-gray-900 mt-6">{{ $step['title'] }}</h3>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>
@endsection