@props(['product'])

<div x-show="codModalOpen" x-cloak x-transition.opacity
     class="fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/50" @click="codModalOpen = false"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden"
         @click.outside="codModalOpen = false">
        {{-- HEADER --}}
        <div class="flex items-start justify-between px-6 pt-6 pb-5 border-b border-gray-100">
            <div class="flex items-start gap-3">
                <span class="grid place-items-center w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 shrink-0">
                    <i data-lucide="handshake" class="w-5 h-5"></i>
                </span>
                <div>
                    <h3 class="text-lg font-extrabold text-gray-900">Ajukan COD</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Isi detail pertemuan COD</p>
                </div>
            </div>
            <button type="button" @click="codModalOpen = false"
                    class="p-2 rounded-full text-gray-400 hover:bg-gray-100 transition" aria-label="Tutup">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="px-6 py-5 space-y-5 max-h-[60vh] overflow-y-auto">
                {{-- INFO PRODUK --}}
                <div class="flex items-center gap-3 rounded-xl bg-gray-50 border border-gray-100 p-3">
                    <img src="{{ productImageUrl($product) }}" alt="{{ $product->name }}"
                         class="w-[60px] h-[60px] rounded-lg object-cover shrink-0">
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ $product->name }}</p>
                        <p class="text-sm font-extrabold text-indigo-600 mt-0.5">{{ formatRupiah($product->price) }}</p>
                    </div>
                </div>

                {{-- LOKASI COD --}}
                <div>
                    <label for="cod_location" class="block text-sm font-bold text-gray-700 mb-1.5">
                        Lokasi COD <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="cod_location" name="cod_location"
                           value="{{ old('cod_location') }}"
                           placeholder="Cth: Cibinong City Mall, depan Starbucks"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('cod_location') border-rose-300 @enderror">
                    @error('cod_location')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- TANGGAL & WAKTU --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="cod_date" class="block text-sm font-bold text-gray-700 mb-1.5">
                            Tanggal COD <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="cod_date" name="cod_date"
                               value="{{ old('cod_date') }}"
                               min="{{ date('Y-m-d') }}"
                               class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('cod_date') border-rose-300 @enderror">
                        @error('cod_date')
                            <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="cod_time" class="block text-sm font-bold text-gray-700 mb-1.5">
                            Waktu COD <span class="text-rose-500">*</span>
                        </label>
                        <input type="time" id="cod_time" name="cod_time"
                               value="{{ old('cod_time') }}"
                               class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('cod_time') border-rose-300 @enderror">
                        @error('cod_time')
                            <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- CATATAN --}}
                <div>
                    <label for="note" class="block text-sm font-bold text-gray-700 mb-1.5">
                        Catatan <span class="text-xs font-normal text-gray-400">(opsional)</span>
                    </label>
                    <textarea id="note" name="note" rows="3"
                              placeholder="Cth: Tolong bawa charger & dus"
                              class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm outline-none resize-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('note') border-rose-300 @enderror">{{ old('note') }}</textarea>
                    @error('note')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- INFO BOX --}}
                <div class="flex items-start gap-3 rounded-xl bg-amber-50 border border-amber-200 p-3.5">
                    <span class="text-base leading-none shrink-0">⚠️</span>
                    <p class="text-xs text-amber-700 leading-relaxed">
                        Pastikan lokasi COD merupakan tempat umum dan aman. Hindari lokasi sepi.
                    </p>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/60 flex items-center justify-end gap-3">
                <button type="button" @click="codModalOpen = false"
                        class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold shadow-sm transition">
                    <i data-lucide="handshake" class="w-4 h-4"></i> Ajukan COD
                </button>
            </div>
        </form>
    </div>
</div>