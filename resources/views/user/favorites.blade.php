@extends('layouts.app')

@section('title', 'Favorit Saya | LokalMart')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Favorit Saya</h1>
                <p class="mt-1.5 text-sm text-gray-500">
                    {{ $favorites->count() }} barang yang kamu simpan
                </p>
            </div>
            <a href="{{ route('explore') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold shadow-sm transition">
                <i data-lucide="compass" class="w-4 h-4"></i> Jelajahi Barang
            </a>
        </div>

        {{-- GRID FAVORIT --}}
        @if($favorites->isEmpty())
            <div class="mt-10 bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                <span class="mx-auto grid place-items-center w-16 h-16 rounded-2xl bg-rose-50 text-rose-400">
                    <i data-lucide="heart" class="w-8 h-8"></i>
                </span>
                <h2 class="mt-5 text-lg font-bold text-gray-800">Belum ada favorit</h2>
                <p class="mt-1 text-sm text-gray-500">Klik ikon ❤️ pada barang yang kamu suka agar tersimpan di sini</p>
                <a href="{{ route('explore') }}"
                   class="inline-block mt-6 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition">
                    Jelajahi Barang
                </a>
            </div>
        @else
            <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
                @foreach($favorites as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif
    </div>
@endsection
