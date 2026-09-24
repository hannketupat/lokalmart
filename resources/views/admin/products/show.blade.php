@extends('layouts.admin')

@section('title', 'Detail Produk - Admin Panel')

@section('page-title', 'Detail Produk')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
        <a href="{{ route('admin.products.edit', $product) }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Edit</a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="aspect-video bg-gray-100">
            @if($product->image)
                <img src="{{ productImageUrl($product) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <i data-lucide="image" class="w-12 h-12"></i>
                </div>
            @endif
        </div>

        <div class="p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @switch($product->status)
                            @case('active') bg-emerald-100 text-emerald-700 @break
                            @case('draft') bg-gray-100 text-gray-700 @break
                            @case('inactive') bg-gray-100 text-gray-700 @break
                            @case('sold') bg-indigo-100 text-indigo-700 @break
                            @default bg-gray-100 text-gray-700
                        @endswitch">
                        {{ ucfirst($product->status) }}
                    </span>
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">{{ ucfirst($product->condition) }}</span>
                </div>
                <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Deskripsi</h3>
                <p class="mt-1 text-gray-900 whitespace-pre-line">{{ $product->description }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-t border-gray-100 pt-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Penjual</h3>
                    <p class="mt-1 text-gray-900">{{ $product->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $product->user->email }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Lokasi</h3>
                    <p class="mt-1 text-gray-900">{{ $product->city }}, {{ $product->province }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Kategori</h3>
                    <p class="mt-1 text-gray-900">{{ $product->category->name ?? '-' }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Dibuat</h3>
                    <p class="mt-1 text-gray-900">{{ $product->created_at->format('d F Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection