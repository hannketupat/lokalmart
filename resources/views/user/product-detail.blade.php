@extends('layouts.app')

@section('title', $product->name . ' | LokalMart')

@section('content')
    <div x-data="{ codModalOpen: false, favorited: {{ $product->isFavoritedBy(auth()->id()) ? 'true' : 'false' }}, busy: false }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- BREADCRUMB --}}
        <nav class="flex items-center gap-1.5 text-sm text-gray-500 min-w-0">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 font-medium shrink-0">Home</a>
            <span class="text-gray-300 shrink-0">/</span>
            <a href="{{ route('explore', ['category' => $product->category->slug]) }}" class="hover:text-indigo-600 font-medium truncate">{{ $product->category->name }}</a>
            <span class="text-gray-300 shrink-0">/</span>
            <span class="text-gray-700 font-semibold truncate">{{ $product->name }}</span>
        </nav>

        <div class="mt-6 lg:grid lg:grid-cols-[1fr_400px] lg:gap-8 items-start">

            {{-- KOLOM KIRI --}}
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="relative aspect-square bg-gray-100">
                        <img src="{{ productImageUrl($product) }}" alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                        @if($product->condition === 'bekas')
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold text-white bg-amber-400">Bekas</span>
                        @endif
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                        <i data-lucide="align-left" class="w-4 h-4 text-indigo-600"></i> Deskripsi Produk
                    </h2>
                    <div class="mt-3 border-t border-gray-100"></div>
                    <p class="mt-4 text-sm text-gray-600 leading-relaxed whitespace-pre-line">{!! nl2br(e($product->description)) !!}</p>
                </div>
            </div>

            {{-- KOLOM KANAN (sticky) --}}
            <aside class="lg:sticky lg:top-20 mt-6 lg:mt-0">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                    <div class="flex items-center justify-between gap-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $product->condition === 'bekas' ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }}">
                            {{ $product->condition === 'bekas' ? 'Bekas' : 'Baru' }}
                        </span>
                        @if($product->status === 'sold')
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">Terjual</span>
                        @endif
                    </div>

                    <h1 class="mt-3 text-2xl font-extrabold text-gray-900 leading-snug">{{ $product->name }}</h1>

                    <p class="mt-3 text-3xl font-extrabold text-indigo-600">{{ formatRupiah($product->price) }}</p>

                    <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-1.5 text-sm text-gray-500">
                        <span class="inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-4 h-4 text-gray-400"></i> {{ $product->district }}, {{ $product->city }}</span>
                        <span class="inline-flex items-center gap-1"><i data-lucide="clock" class="w-4 h-4 text-gray-400"></i> {{ timeAgo($product->created_at) }}</span>
                        <span class="inline-flex items-center gap-1"><i data-lucide="eye" class="w-4 h-4 text-gray-400"></i> {{ $product->views }}x dilihat</span>
                    </div>

                    <div class="my-5 border-t border-gray-100"></div>

                    {{-- CARD PENJUAL --}}
                    <div class="flex items-center gap-3">
                        <img src="{{ $product->user->avatar ?? 'https://i.pravatar.cc/150?u=' . $product->user->id }}"
                             alt="{{ $product->user->name }}"
                             class="w-12 h-12 rounded-full object-cover ring-2 ring-indigo-100">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $product->user->name }}</p>
                            <p class="text-xs text-gray-500">
                                <span class="text-amber-400">★</span>
                                {{ $product->user->rating > 0 ? number_format($product->user->rating, 1) . ' • ' : '' }}{{ max(0, $product->user->receivedReviews()->count()) }} ulasan
                            </p>
                        </div>
                    </div>
                    <p class="mt-3 text-xs text-gray-400 leading-relaxed">
                        <span class="font-semibold text-gray-500 inline-flex items-center gap-1"><i data-lucide="package-check" class="w-3.5 h-3.5"></i> {{ $product->user->total_transactions ?? 0 }} transaksi berhasil</span>
                    </p>
                    <a href="#" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 hover:border-indigo-300 hover:text-indigo-600 transition">
                        <i data-lucide="user" class="w-4 h-4"></i> Lihat Profil
                    </a>

                    <div class="my-5 border-t border-gray-100"></div>

                    {{-- BUTTON GROUP --}}
                    <div class="space-y-2.5">
                        <button type="button"
                                @click="
                                    @if(auth()->check())
                                        if (busy) return;
                                        busy = true;
                                        fetch('{{ route('favorites.toggle', $product->id) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                                'Accept': 'application/json'
                                            }
                                        })
                                        .then(function (r) { return r.json(); })
                                        .then(function (d) { favorited = d.favorited; })
                                        .finally(function () { busy = false; })
                                    @else
                                        window.location.href = '{{ route('login') }}';
                                    @endif
                                "
                                :class="favorited
                                    ? 'border-rose-200 bg-rose-50 text-rose-500 favorited-heart'
                                    : 'border-gray-200 text-gray-700 hover:border-rose-200 hover:bg-rose-50 hover:text-rose-500'"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border text-sm font-bold transition">
                            <i data-lucide="heart" class="w-4 h-4"></i>
                            <span x-text="favorited ? 'Tersimpan di Favorit' : 'Simpan ke Favorit'"></span>
                        </button>
                        @if($product->user_id === auth()->id())
                            <button type="button" disabled title="Ini produk milikmu sendiri"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-emerald-600 text-white text-sm font-bold opacity-50 cursor-not-allowed">
                                <i data-lucide="message-circle" class="w-4 h-4"></i> Chat via WhatsApp
                            </button>
                        @else
                            <a href="{{ waLink($product->user->phone, waProductMessage($product)) }}" target="_blank" rel="noopener"
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold shadow-sm transition">
                                <i data-lucide="message-circle" class="w-4 h-4"></i> Chat via WhatsApp
                            </a>
                        @endif
                        <button type="button" @click="codModalOpen = true" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold shadow-sm transition">
                            🤝 Ajukan COD
                        </button>
                    </div>

                    {{-- INFO BOX --}}
                    <div class="mt-4 rounded-xl bg-gray-50 border border-gray-100 p-4 space-y-2.5">
                        <p class="text-xs text-gray-600 flex items-start gap-2">
                            <span class="text-sm leading-none shrink-0">🔒</span>
                            Transaksi aman dengan COD
                        </p>
                        <p class="text-xs text-gray-600 flex items-start gap-2">
                            <span class="text-sm leading-none shrink-0">📍</span>
                            COD di tempat umum yang aman
                        </p>
                    </div>
                </div>
            </aside>
        </div>

        {{-- INFORMASI PENJUAL --}}
        <section class="mt-14">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600">Penjual</span>
                    <h2 class="mt-2 text-2xl font-extrabold text-gray-900">Informasi Penjual</h2>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ $product->user->avatar ?? 'https://i.pravatar.cc/150?u=' . $product->user->id }}"
                         alt="{{ $product->user->name }}"
                         class="w-14 h-14 rounded-full object-cover ring-2 ring-indigo-100">
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $product->user->name }}</p>
                        <p class="text-xs text-gray-400">Penjual LokalMart</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Rating</p>
                    <p class="mt-1 text-sm font-bold text-gray-800"><span class="text-amber-400">★</span> {{ $product->user->rating > 0 ? number_format($product->user->rating, 1) : 'Belum ada rating' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Transaksi Berhasil</p>
                    <p class="mt-1 text-sm font-bold text-gray-800">{{ $product->user->total_transactions ?? 0 }} transaksi</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Lokasi</p>
                    <p class="mt-1 text-sm font-bold text-gray-800">{{ trim($product->user->district . ', ' . $product->user->city, ', ') ?: 'Belum diatur' }}</p>
                </div>
            </div>
        </section>

        {{-- LOKASI / MAP --}}
        <section class="mt-10">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600">Lokasi</span>
                    <h2 class="mt-2 text-2xl font-extrabold text-gray-900">Lokasi Penjual</h2>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="relative h-64 bg-gradient-to-br from-indigo-50 to-violet-50 grid place-items-center">
                    <div class="absolute inset-0 opacity-[0.07] pointer-events-none"
                         style="background-image: repeating-linear-gradient(0deg, #4f46e5 0 1px, transparent 1px 28px), repeating-linear-gradient(90deg, #4f46e5 0 1px, transparent 1px 28px);"></div>
                    <div class="relative text-center px-6">
                        <span class="mx-auto grid place-items-center w-14 h-14 rounded-full bg-indigo-600 text-white shadow-lg shadow-indigo-200">
                            <i data-lucide="map-pin" class="w-7 h-7"></i>
                        </span>
                        <p class="mt-3 text-sm font-bold text-gray-800">{{ $product->district }}, {{ $product->city }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Provinsi {{ $product->province }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50/60">
                    <p class="text-xs text-gray-500 inline-flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-500"></i> Sepakati lokasi COD dengan penjual melalui WhatsApp
                    </p>
                </div>
            </div>
        </section>

        {{-- BARANG LAIN DARI PENJUAL --}}
        <section class="mt-14">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600">Penjual ini</span>
                    <h2 class="mt-2 text-2xl font-extrabold text-gray-900">Barang lainnya dari penjual ini</h2>
                </div>
            </div>

            @if($relatedProducts->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                    <i data-lucide="package-open" class="w-12 h-12 text-gray-300 mx-auto"></i>
                    <p class="mt-4 text-sm text-gray-500 font-medium">Belum ada barang lain dari penjual ini.</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                    @foreach($relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            @endif
        </section>

        <x-cod-modal :product="$product" />
    </div>
@endsection