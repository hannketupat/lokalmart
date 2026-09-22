@props(['product'])

@php
    $image = productImageUrl($product);
    $distance = number_format(0.7 + ($product->id % 32) * 0.2, 1, '.', ',');
    $isFavorited = $product->isFavoritedBy(auth()->id());
@endphp

<div x-data="{ favorited: {{ $isFavorited ? 'true' : 'false' }}, busy: false }"
     class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
    <div class="relative aspect-square overflow-hidden bg-gray-100">
        <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
            <img src="{{ $image }}" alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        </a>

        <span class="absolute top-2.5 left-2.5 px-2.5 py-1 rounded-full text-[11px] font-bold text-white {{ $product->condition === 'bekas' ? 'bg-amber-400' : 'bg-emerald-500' }}">
            {{ $product->condition === 'bekas' ? 'Bekas' : 'Baru' }}
        </span>

        <button type="button"
                @click.stop="
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
                :title="favorited ? 'Hapus dari favorit' : 'Tambah ke favorit'"
                class="absolute top-2 right-2 grid place-items-center w-8 h-8 rounded-full bg-white/95 shadow transition"
                :class="favorited ? 'text-rose-500 favorited-heart' : 'text-gray-400 hover:text-rose-500'">
            <i data-lucide="heart" class="w-4 h-4"></i>
        </button>
    </div>

    <div class="p-3.5 space-y-1.5">
        <a href="{{ route('products.show', $product->slug) }}" class="block">
            <h3 class="font-semibold text-sm text-gray-800 line-clamp-2 leading-snug group-hover:text-indigo-600 transition">
                {{ $product->name }}
            </h3>
        </a>
        <p class="text-base font-extrabold text-indigo-600">{{ formatRupiah($product->price) }}</p>
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

        <a href="{{ waLink($product->user->phone, waProductMessage($product)) }}" target="_blank" rel="noopener"
           onclick="event.stopPropagation();"
           class="mt-1.5 inline-flex items-center justify-center gap-1.5 w-full px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i> Chat WhatsApp
        </a>
    </div>
</div>
