@props(['transaction'])

@php
    $counterparty = auth()->id() === $transaction->buyer_id
        ? $transaction->seller
        : $transaction->buyer;
@endphp

<div x-data="{ rating: 0, hoverRating: 0, comment: '' }"
     x-show="ratingModalOpen" x-cloak x-transition.opacity
     class="fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/50" @click="ratingModalOpen = false"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
         @click.outside="ratingModalOpen = false"
         x-transition:enter="ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        {{-- HEADER --}}
        <div class="flex items-start justify-between px-6 pt-6 pb-5 border-b border-gray-100">
            <div class="flex items-start gap-3">
                <span class="grid place-items-center w-10 h-10 rounded-xl bg-amber-50 text-amber-500 shrink-0">
                    <i data-lucide="star" class="w-5 h-5"></i>
                </span>
                <div>
                    <h3 class="text-lg font-extrabold text-gray-900">Beri Rating</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Nilai pengalaman transaksi COD-mu</p>
                </div>
            </div>
            <button type="button" @click="ratingModalOpen = false"
                    class="p-2 rounded-full text-gray-400 hover:bg-gray-100 transition" aria-label="Tutup">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('reviews.store', $transaction) }}" method="POST">
            @csrf
            <input type="hidden" name="rating" :value="rating">

            <div class="px-6 py-5 space-y-5 max-h-[60vh] overflow-y-auto">
                {{-- INFO PRODUK --}}
                <div class="flex items-center gap-3 rounded-xl bg-gray-50 border border-gray-100 p-3">
                    <img src="{{ productImageUrl($transaction->product) }}"
                         alt="{{ $transaction->product->name }}"
                         class="w-[60px] h-[60px] rounded-lg object-cover shrink-0">
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ $transaction->product->name }}</p>
                        <p class="text-sm font-extrabold text-indigo-600 mt-0.5">{{ formatRupiah($transaction->price) }}</p>
                    </div>
                </div>

                {{-- PERTANYAAN --}}
                <p class="text-sm font-semibold text-gray-700 leading-relaxed">
                    Bagaimana pengalamanmu bertransaksi dengan
                    <span class="text-indigo-600 font-bold">{{ $counterparty->name }}</span>?
                </p>

                {{-- STAR RATING --}}
                <div class="flex items-center justify-center gap-1.5 select-none">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                                @click="rating = {{ $i }}"
                                @mouseenter="hoverRating = {{ $i }}"
                                @mouseleave="hoverRating = 0"
                                aria-label="Beri rating {{ $i }} bintang"
                                class="p-1 transition transform hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                 class="w-10 h-10 transition-colors"
                                 :fill="(hoverRating >= {{ $i }} || (!hoverRating && rating >= {{ $i }})) ? '#facc15' : '#e5e7eb'"
                                 :stroke="(hoverRating >= {{ $i }} || (!hoverRating && rating >= {{ $i }})) ? '#eab308' : '#d1d5db'"
                                 stroke-width="1">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        </button>
                    @endfor
                </div>

                <p class="text-center text-xs font-bold"
                   :class="rating > 0 ? 'text-amber-600' : 'text-gray-400'"
                   x-text="rating === 0 ? 'Pilih bintang 1-5' : ({ 1: 'Buruk', 2: 'Kurang', 3: 'Cukup baik', 4: 'Bagus!', 5: 'Luar biasa!' }[rating] || '')">
                </p>

                {{-- KOMENTAR --}}
                <div>
                    <label for="comment" class="block text-sm font-bold text-gray-700 mb-1.5">
                        Komentar <span class="text-xs font-normal text-gray-400">(opsional)</span>
                    </label>
                    <textarea id="comment" name="comment" rows="3" maxlength="500"
                              x-model="comment"
                              placeholder="Tulis pengalamanmu (opsional)"
                              class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm outline-none resize-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                    <p class="mt-1 text-right text-xs text-gray-400">
                        <span x-text="comment.length"></span>/500
                    </p>
                </div>

                @error('rating')
                    <p class="text-xs text-rose-500">{{ $message }}</p>
                @enderror
                @error('comment')
                    <p class="text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- FOOTER --}}
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/60 flex items-center justify-end gap-3">
                <button type="button" @click="ratingModalOpen = false"
                        class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="submit"
                        :disabled="rating === 0"
                        :class="rating === 0
                            ? 'bg-indigo-300 cursor-not-allowed'
                            : 'bg-indigo-600 hover:bg-indigo-700 shadow-sm'"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-white text-sm font-bold transition">
                    <i data-lucide="send" class="w-4 h-4"></i> Kirim Rating
                </button>
            </div>
        </form>
    </div>
</div>
