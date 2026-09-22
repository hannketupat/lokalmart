@extends('layouts.app')

@section('title', $user->name . ' - Profil')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Profil -->
    <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-indigo-600 via-indigo-700 to-indigo-900">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative px-6 py-10 sm:px-10 sm:py-12">
            <div class="flex flex-col sm:flex-row items-center sm:items-end gap-6">
                <div class="relative">
                    <div class="w-24 h-24 rounded-full border-4 border-white bg-white/10 overflow-hidden flex items-center justify-center">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl font-bold text-white/80">{{ Str::upper($user->name[0]) }}</span>
                        @endif
                    </div>
                </div>

                <div class="flex-1 text-center sm:text-left">
                    <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
                    @if($user->city || $user->province)
                        <p class="mt-1 text-indigo-100 flex items-center justify-center sm:justify-start gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $user->city ?? '' }}{{ $user->city && $user->province ? ', ' : '' }}{{ $user->province ?? '' }}
                        </p>
                    @endif
                    <div class="mt-4 flex items-center justify-center sm:justify-start gap-6 text-sm">
                        <div class="flex items-center gap-1.5 text-indigo-100">
                            <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="font-semibold">{{ number_format($avgRating, 1) }}</span>
                            <span class="text-indigo-200">({{ $user->receivedReviews()->count() }} review)</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-indigo-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <span>{{ $transactionsCount }} transaksi</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-indigo-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Bergabung {{ $user->joined_at?->format('F Y') ?? 'baru' }}</span>
                        </div>
                    </div>

                    @if(auth()->check() && auth()->id() === $user->id)
                        <div class="mt-6 flex justify-center sm:justify-start">
                            <a href="{{ route('profile.edit') }}"
                               class="px-6 py-2.5 bg-white text-indigo-600 font-semibold rounded-xl hover:bg-indigo-50 transition shadow-sm">
                                Edit Profil
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Menu -->
    <div class="mt-6 border-b border-gray-200">
        <nav class="flex gap-1 overflow-x-auto pb-1" aria-label="Menu profil">
            <a href="#profil" class="px-4 py-3 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600 whitespace-nowrap" data-tab="profil">Profil</a>
            <a href="#barang" class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap" data-tab="barang">Barang Saya ({{ $productsCount }})</a>
            <a href="{{ route('favorites.index') }}" class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap" data-tab="favorit">Favorit</a>
            <a href="{{ route('transactions.index') }}" class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap" data-tab="transaksi">Transaksi</a>
        </nav>
    </div>

    <!-- Tab Content: Profil (Default) -->
    <div id="tab-profil" class="mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Barang dari {nama} -->
            <div class="lg:col-span-2">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Barang dari {{ $user->name }}</h2>
                @if($activeProducts->isEmpty())
                    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                        <svg class="mx-auto w-12 h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada barang</h3>
                        <p class="mt-2 text-sm text-gray-500">{{ $user->name }} belum menjual barang apapun</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($activeProducts as $product)
                            <article class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow">
                                <a href="{{ route('products.show', $product->slug) }}" class="block">
                                    <div class="aspect-square bg-gray-100 relative overflow-hidden">
                                        @if($product->images->first())
                                            <img src="{{ $product->images->first()->path }}"
                                                 alt="{{ $product->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif>
                                        @if($product->condition)
                                            <span class="absolute top-2 left-2 px-2 py-0.5 text-xs font-medium rounded-full bg-white/90 backdrop-blur text-gray-700">
                                                {{ ucfirst($product->condition) }}
                                            </span>
                                        @endif>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-medium text-gray-900 line-clamp-1 group-hover:text-indigo-600 transition">{{ $product->title }}</h3>
                                        <p class="mt-1 text-lg font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="mt-1 text-sm text-gray-500 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $product->city }}{{ $product->city && $product->province ? ', ' : '' }}{{ $product->province }}
                                        </p>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>

                    @if($productsCount > 4)
                        <div class="mt-6 text-center">
                            <a href="{{ route('products.my') }}"
                               class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition">
                                Lihat semua barang
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    @endif>
                @endif
            </div>

            <!-- Review -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-24">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Review</h2>

                    <div class="text-center mb-6">
                        <div class="text-5xl font-bold text-gray-900">{{ number_format($avgRating, 1) }}</div>
                        <div class="flex items-center justify-center gap-1 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($avgRating) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="mt-2 text-sm text-gray-500">{{ $user->receivedReviews()->count() }} ulasan</p>
                    </div>

                    @if($receivedReviews->isEmpty())
                        <p class="text-center text-sm text-gray-500 py-4">Belum ada review</p>
                    @else
                        <div class="space-y-4">
                            @foreach($receivedReviews as $review)
                                <div class="border-t border-gray-100 pt-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <img src="{{ $review->reviewer->avatar ?? 'https://i.pravatar.cc/40?u=' . $review->reviewer->id }}"
                                             alt="{{ $review->reviewer->name }}"
                                             class="w-8 h-8 rounded-full">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $review->reviewer->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-0.5 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-700">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection