@props(['product'])

@php
    $image = $product->image ?? 'https://picsum.photos/seed/' . $product->slug . '/600/600';
    $distance = number_format(0.7 + ($product->id % 32) * 0.2, 1, '.', ',');
@endphp

<div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
    <a href="#" class="block relative aspect-square overflow-hidden bg-gray-100">
        <img src="{{ $image }}" alt="{{ $product->name }}"
             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

        <span class="absolute top-2.5 left-2.5 px-2.5 py-1 rounded-full text-[11px] font-bold text-white {{ $product->condition === 'bekas' ? 'bg-amber-400' : 'bg-emerald-500' }}">
            {{ $product->condition === 'bekas' ? 'Bekas' : 'Baru' }}
        </span>

        <button type="button" title="Favorit"
                class="absolute top-2 right-2 grid place-items-center w-8 h-8 rounded-full bg-white/95 shadow text-gray-400 hover:text-rose-500 transition">
            <i data-lucide="heart" class="w-4 h-4"></i>
        </button>
    </a>

    <div class="p-3.5 space-y-1.5">
        <a href="#" class="block font-semibold text-sm text-gray-800 line-clamp-2 leading-snug hover:text-indigo-600 transition">
            {{ $product->name }}
        </a>
        <p class="text-base font-extrabold text-indigo-600">{{ $product->formatted_price }}</p>
        <p class="text-xs text-gray-400">📍 {{ $product->city }} • {{ $distance }} km</p>
        <div class="flex items-center justify-between pt-1.5 border-t border-gray-100">
            <p class="text-xs text-gray-500 font-medium truncate max-w-[60%]">{{ $product->user->name }}</p>
            @if($product->user->rating > 0)
                <span class="text-xs text-gray-700 font-semibold shrink-0">
                    <span class="text-amber-400">★</span> {{ number_format($product->user->rating, 1) }}
                </span>
            @else
                <span class="text-[11px] text-sky-500 font-medium bg-sky-50 px-2 py-0.5 rounded-full shrink-0">Penjual baru</span>
            @endif
        </div>
    </div>
</div>