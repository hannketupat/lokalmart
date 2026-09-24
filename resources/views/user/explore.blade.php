@extends('layouts.app')

@section('title', 'Jelajahi Barang | LokalMart')

@section('content')
    <div x-data="{ filterOpen: false }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-[280px_1fr] lg:gap-8 items-start">

            {{-- SIDEBAR FILTER --}}
            <aside class="lg:sticky lg:top-20 hidden lg:block">
                <form action="{{ route('explore') }}" method="GET"
                      class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-5">
                    @if(request()->has('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div>
                        <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                            <i data-lucide="sliders-horizontal" class="w-4 h-4 text-indigo-600"></i> Filter
                        </h2>
                    </div>

                    {{-- KATEGORI --}}
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wide text-gray-500">Kategori</h3>
                        <div class="mt-2.5 space-y-2">
                            @foreach($categories as $category)
                                <label class="flex items-center gap-2.5 cursor-pointer select-none group">
                                    <input type="checkbox" name="category" value="{{ $category->slug }}"
                                           @checked(request('category') === $category->slug)
                                           class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 group-hover:border-indigo-400">
                                    <span class="text-sm text-gray-600 group-hover:text-gray-900">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    {{-- LOKASI --}}
                    <div class="rounded-2xl bg-indigo-50 border border-indigo-200 p-4">
                        @include('partials.location-data', ['isExplore' => true])
                    </div>

                    <div class="border-t border-gray-100"></div>

                    {{-- HARGA --}}
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wide text-gray-500">Harga</h3>
                        <div class="mt-2.5 grid grid-cols-2 gap-2">
                            <input type="number" name="price_min" min="0" step="1000" value="{{ request('price_min') }}"
                                   placeholder="Min"
                                   class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <input type="number" name="price_max" min="0" step="1000" value="{{ request('price_max') }}"
                                   placeholder="Max"
                                   class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                        <p class="mt-1.5 text-[11px] text-gray-400">Harga dalam Rupiah (Rp)</p>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    {{-- KONDISI --}}
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wide text-gray-500">Kondisi</h3>
                        <div class="mt-2.5 space-y-2">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="radio" name="condition" value="" @checked(!request('condition'))
                                       class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-600">Semua</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="radio" name="condition" value="baru" @checked(request('condition') === 'baru')
                                       class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-600">Baru</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="radio" name="condition" value="bekas" @checked(request('condition') === 'bekas')
                                       class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-600">Bekas</span>
                            </label>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    {{-- URUTKAN --}}
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wide text-gray-500">Urutkan</h3>
                        <select name="sort"
                                class="mt-2.5 w-full rounded-xl border border-gray-200 bg-white py-2.5 px-3 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="terbaru" @selected($sort === 'terbaru')>Terbaru</option>
                            <option value="termurah" @selected($sort === 'termurah')>Termurah</option>
                            <option value="termahal" @selected($sort === 'termahal')>Termahal</option>
                            <option value="terdekat" @selected($sort === 'terdekat')>Terdekat</option>
                        </select>
                    </div>

                    <div class="pt-1 space-y-2">
                        <button type="submit"
                                class="w-full rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-3 shadow-sm transition">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('explore') }}"
                           class="block text-center w-full rounded-xl border border-gray-200 hover:border-gray-300 text-gray-600 hover:text-gray-900 text-sm font-semibold py-3 transition">
                            Reset
                        </a>
                    </div>
                </form>
            </aside>

            {{-- HASIL --}}
            <div>
                <div class="mb-6">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900">
                        {{ $products->total() }} barang ditemukan
                    </h1>
                    @if(request('search'))
                        <p class="mt-1 text-sm text-gray-500">
                            Hasil pencarian untuk '<span class="font-semibold text-gray-700">{{ request('search') }}</span>'
                        </p>
                    @endif
                </div>

                @if($products->isEmpty())
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                        <i data-lucide="search-x" class="w-14 h-14 text-gray-200 mx-auto"></i>
                        <h2 class="mt-4 text-lg font-bold text-gray-800">Barang tidak ditemukan</h2>
                        <p class="mt-1 text-sm text-gray-500">Coba ubah filter atau kata kunci pencarian</p>
                        <a href="{{ route('explore') }}"
                            class="inline-block mt-6 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition">
                            Reset Filter
                        </a>
                    </div>
                @else
                    {{-- BUTTON FILTER - MOBILE ONLY (< md) --}}
                    <button type="button" 
                            @click="filterOpen = true"
                            class="md:hidden flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold mb-6 w-full md:w-auto">
                        <i data-lucide="sliders-horizontal" class="w-4 h-4 text-indigo-600"></i>
                        Filter
                    </button>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $products->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>

        {{-- FILTER MODAL - ALPINE X-DATA --}}
        <div class="fixed inset-0 z-50 overflow-y-auto md:hidden"
             x-show="filterOpen"
             x-cloak>
            
            {{-- Backdrop --}}
            <div x-show="filterOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/50"
                 @click="filterOpen = false"></div>

            {{-- Modal Content --}}
            <div class="flex min-h-full items-center justify-center p-4">
                <div x-show="filterOpen"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                     class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl">
                    
                    {{-- Modal Header --}}
                    <div class="border-b border-gray-100 px-5 py-4 flex items-center justify-between">
                        <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                            <i data-lucide="sliders-horizontal" class="w-4 h-4 text-indigo-600"></i>
                            Filter & Urutkan
                        </h2>
                        <button @click="filterOpen = false"
                                class="text-gray-400 hover:text-gray-600 transition">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    {{-- Modal Body --}}
                    <form action="{{ route('explore') }}" method="GET">
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <div class="px-5 py-5 space-y-5 max-h-[70vh] overflow-y-auto">
                            
                            {{-- KATEGORI --}}
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wide text-gray-500">Kategori</h3>
                                <div class="mt-2.5 space-y-2">
                                    @foreach($categories as $category)
                                        <label class="flex items-center gap-2.5 cursor-pointer select-none group">
                                            <input type="checkbox" name="category" value="{{ $category->slug }}"
                                                   @checked(request('category') === $category->slug)
                                                   class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 group-hover:border-indigo-400">
                                            <span class="text-sm text-gray-600 group-hover:text-gray-900">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="border-t border-gray-100"></div>

                            {{-- LOKASI --}}
                            <div class="rounded-2xl bg-indigo-50 border border-indigo-200 p-4">
                                @include('partials.location-data', ['isExplore' => true])
                            </div>

                            <div class="border-t border-gray-100"></div>

                            {{-- HARGA --}}
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wide text-gray-500">Harga</h3>
                                <div class="mt-2.5 grid grid-cols-2 gap-2">
                                    <input type="number" name="price_min" min="0" step="1000" value="{{ request('price_min') }}"
                                           placeholder="Min"
                                           class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <input type="number" name="price_max" min="0" step="1000" value="{{ request('price_max') }}"
                                           placeholder="Max"
                                           class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>
                                <p class="mt-1.5 text-[11px] text-gray-400">Harga dalam Rupiah (Rp)</p>
                            </div>

                            <div class="border-t border-gray-100"></div>

                            {{-- KONDISI --}}
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wide text-gray-500">Kondisi</h3>
                                <div class="mt-2.5 space-y-2">
                                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                        <input type="radio" name="condition" value="" @checked(!request('condition'))
                                               class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm text-gray-600">Semua</span>
                                    </label>
                                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                        <input type="radio" name="condition" value="baru" @checked(request('condition') === 'baru')
                                               class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm text-gray-600">Baru</span>
                                    </label>
                                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                        <input type="radio" name="condition" value="bekas" @checked(request('condition') === 'bekas')
                                               class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm text-gray-600">Bekas</span>
                                    </label>
                                </div>
                            </div>

                            <div class="border-t border-gray-100"></div>

                            {{-- URUTKAN --}}
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wide text-gray-500">Urutkan</h3>
                                <select name="sort"
                                        class="mt-2.5 w-full rounded-xl border border-gray-200 bg-white py-2.5 px-3 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="terbaru" @selected($sort === 'terbaru')>Terbaru</option>
                                    <option value="termurah" @selected($sort === 'termurah')>Termurah</option>
                                    <option value="termahal" @selected($sort === 'termahal')>Termahal</option>
                                    <option value="terdekat" @selected($sort === 'terdekat')>Terdekat</option>
                                </select>
                            </div>

                        </div>

                        {{-- Modal Footer --}}
                        <div class="border-t border-gray-100 px-5 py-4 space-y-2 sticky bottom-0 bg-white rounded-b-2xl">
                            <button type="submit"
                                    class="w-full rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-3 shadow-sm transition">
                                Terapkan Filter
                            </button>
                            <a href="{{ route('explore') }}"
                               class="block text-center w-full rounded-xl border border-gray-200 hover:border-gray-300 text-gray-600 hover:text-gray-900 text-sm font-semibold py-3 transition">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var boxes = document.querySelectorAll('input[name="category"]');
            boxes.forEach(function (box) {
                box.addEventListener('change', function () {
                    boxes.forEach(function (other) {
                        if (other !== box) other.checked = false;
                    });
                });
            });
        });
    </script>
@endsection