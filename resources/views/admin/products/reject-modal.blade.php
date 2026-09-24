<div x-data="{ open: false, productId: null, productName: '' }"
     @open-reject-modal.window="open = true; productId = $event.detail.id; productName = $event.detail.name"
     x-cloak>
    <div x-show="open"
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/50" @click="open = false"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6"
             @click.outside="open = false">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Tolak Produk</h3>
                    <p class="mt-1 text-sm text-gray-500">Berikan alasan penolakan untuk <span class="font-semibold text-gray-800" x-text="productName"></span></p>
                </div>
                <button type="button" @click="open = false" class="p-2 rounded-full text-gray-400 hover:bg-gray-100 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form method="POST" :action="'/admin/products/' + productId + '/reject'">
                @csrf
                @method('PATCH')
                <div class="mt-5">
                    <label for="reject-reason" class="block text-sm font-bold text-gray-900">Alasan Penolakan</label>
                    <textarea id="reject-reason" name="reason" rows="4" maxlength="500" required
                              placeholder="Contoh: Foto tidak jelas, deskripsi tidak lengkap, kategori salah..."
                              class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-rose-500 focus:border-transparent resize-none"></textarea>
                    <p class="mt-1.5 text-[11px] text-gray-400">Maksimal 500 karakter</p>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <button type="button" @click="open = false"
                            class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold shadow-sm transition">
                        Tolak Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
