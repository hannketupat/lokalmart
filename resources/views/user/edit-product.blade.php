@extends('layouts.app')

@section('title', 'Edit Barang | LokalMart')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Edit Barang</h1>
            <p class="mt-1.5 text-sm text-gray-500">Perbarui detail barang kamu</p>
        </div>

        <div class="lg:grid lg:grid-cols-[1fr_380px] lg:gap-8 items-start">

            {{-- FORM --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- 1. UPLOAD FOTO --}}
                    <div>
                        <label class="text-sm font-bold text-gray-900">Foto Barang</label>
                        <div class="mt-2.5 flex items-center gap-4">
                            <div class="w-28 h-28 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 shrink-0">
                                <img id="current-img" src="{{ productImageUrl($product) }}" alt="Foto lama"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <label for="image"
                                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 hover:border-indigo-300 hover:text-indigo-600 cursor-pointer transition">
                                    <i data-lucide="refresh-cw" class="w-4 h-4"></i> Ganti Foto
                                    <input type="file" name="image" id="image" accept="image/*" class="hidden">
                                </label>
                                <p class="mt-2 text-[11px] text-gray-400">Kosongkan jika tidak ingin mengganti foto. Format: JPG, PNG. Maks 2MB.</p>
                                <div id="upload-preview" class="hidden mt-3">
                                    <img id="preview-img" src="#" alt="Preview" class="w-24 h-24 object-cover rounded-xl border border-gray-200">
                                </div>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 2. NAMA BARANG --}}
                    <div class="mt-6">
                        <label for="name" class="block text-sm font-bold text-gray-900">Nama Barang</label>
                        <input type="text" id="name" name="name" maxlength="100" value="{{ old('name', $product->name) }}"
                               placeholder="Contoh: Sepeda Fixie Hitam Ukuran M"
                               class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('name')
                            <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 3. KATEGORI --}}
                    <div class="mt-6">
                        <label for="category_id" class="block text-sm font-bold text-gray-900">Kategori</label>
                        <select id="category_id" name="category_id"
                                class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 grid sm:grid-cols-2 gap-6">
                        {{-- 4. HARGA --}}
                        <div>
                            <label for="price" class="block text-sm font-bold text-gray-900">Harga</label>
                            <div class="mt-2 relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-400">Rp</span>
                                <input type="number" id="price" name="price" min="1000" step="1000" value="{{ old('price', $product->price) }}"
                                       placeholder="0"
                                       class="w-full rounded-xl border border-gray-200 bg-white pl-10 pr-4 py-3 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            @error('price')
                                <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1.5 text-[11px] text-gray-400">Minimal Rp1.000</p>
                        </div>

                        {{-- 5. KONDISI --}}
                        <div>
                            <span class="block text-sm font-bold text-gray-900">Kondisi</span>
                            <div class="mt-2 grid grid-cols-2 gap-3">
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="radio" name="condition" value="baru" @checked(old('condition', $product->condition) === 'baru')
                                           class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-700">Baru</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="radio" name="condition" value="bekas" @checked(old('condition', $product->condition) === 'bekas')
                                           class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-700">Bekas</span>
                                </label>
                            </div>
                            @error('condition')
                                <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- 6. DESKRIPSI --}}
                    <div class="mt-6">
                        <div class="flex items-center justify-between">
                            <label for="description" class="block text-sm font-bold text-gray-900">Deskripsi</label>
                            <span id="desc-counter" class="text-[11px] text-gray-400">{{ strlen(old('description', $product->description)) }} karakter</span>
                        </div>
                        <textarea id="description" name="description" rows="5" minlength="20"
                                  placeholder="Ceritakan kondisi, kelengkapan, dan alasan menjual barang ini..."
                                  class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-[11px] text-gray-400">Minimal 20 karakter agar deskripsi terlihat informatif</p>
                    </div>

                    {{-- 7. LOKASI --}}
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        @include('partials.location-data', [
                            'isExplore' => false,
                            'defaultLoc' => [
                                'province' => $product->province,
                                'city' => $product->city,
                                'district' => $product->district,
                            ],
                        ])
                    </div>

                    {{-- 8. STATUS --}}
                    <div class="mt-6 rounded-2xl bg-gray-50 border border-gray-100 p-4 flex items-center justify-between">
                        <p class="text-sm text-gray-600">
                            Status saat ini:
                            <span class="font-bold
                                {{ $product->status === 'active' ? 'text-emerald-600' : ($product->status === 'draft' ? 'text-amber-600' : 'text-gray-500') }}">
                                {{ $product->status === 'active' ? 'Aktif' : ($product->status === 'draft' ? 'Draft' : ($product->status === 'inactive' ? 'Nonaktif' : 'Terjual')) }}
                            </span>
                        </p>
                    </div>

                    {{-- 9. BUTTON GROUP --}}
                    <div class="mt-6 flex flex-col sm:flex-row gap-3">
                        <button type="submit"
                                class="flex-1 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-3.5 shadow-sm transition">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('products.my') }}"
                           class="flex-1 text-center rounded-xl border border-gray-200 text-gray-600 hover:border-gray-300 hover:text-gray-900 text-sm font-bold py-3.5 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            {{-- PREVIEW --}}
            <aside class="lg:sticky lg:top-20 mt-6 lg:mt-0">
                <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">Preview</h2>
                <div class="mt-3 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="relative aspect-square bg-gray-100 grid place-items-center">
                        <img id="preview-image" src="{{ productImageUrl($product) }}" alt="Preview foto"
                             class="w-full h-full object-cover">
                        <span id="preview-condition-badge"
                              class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[11px] font-bold text-white {{ $product->condition === 'bekas' ? 'bg-amber-400' : 'bg-emerald-500' }}">{{ $product->condition === 'bekas' ? 'Bekas' : 'Baru' }}</span>
                    </div>
                    <div class="p-4 space-y-1.5">
                        <p id="preview-name" class="font-semibold text-sm text-gray-800 line-clamp-2 leading-snug">{{ $product->name }}</p>
                        <p id="preview-price" class="text-base font-extrabold text-indigo-600">{{ formatRupiah($product->price) }}</p>
                        <p id="preview-location" class="text-xs text-gray-400">📍 {{ $product->district }}, {{ $product->city }}, {{ $product->province }}</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var imageInput = document.getElementById('image');
            var uploadPreview = document.getElementById('upload-preview');
            var previewImg = document.getElementById('preview-img');
            var previewImage = document.getElementById('preview-image');

            imageInput.addEventListener('change', function () {
                var file = this.files[0];
                if (!file) return;
                var objectUrl = URL.createObjectURL(file);
                previewImg.src = objectUrl;
                uploadPreview.classList.remove('hidden');
                previewImage.src = objectUrl;
            });

            function rupiahPreview(value) {
                var num = parseInt(value, 10);
                if (isNaN(num)) return 'Rp0';
                return 'Rp' + num.toLocaleString('id-ID');
            }

            function updatePreview() {
                var name = document.getElementById('name');
                var price = document.getElementById('price');
                var province = document.getElementById('province');
                var city = document.getElementById('city');
                var district = document.getElementById('district');

                document.getElementById('preview-name').textContent = name.value.trim() || 'Nama barang kamu muncul di sini';
                document.getElementById('preview-price').textContent = rupiahPreview(price.value);

                var location = [];
                if (district && district.value) location.push(district.value);
                if (city && city.value) location.push(city.value);
                if (province && province.value) location.push(province.value);
                document.getElementById('preview-location').textContent = '📍 ' + (location.join(', ') || 'Lokasi barang');

                var isBekas = document.querySelector('input[name="condition"][value="bekas"]:checked');
                var badge = document.getElementById('preview-condition-badge');
                var bekas = isBekas !== null;
                badge.textContent = bekas ? 'Bekas' : 'Baru';
                badge.className = 'absolute top-3 left-3 px-2.5 py-1 rounded-full text-[11px] font-bold text-white ' + (bekas ? 'bg-amber-400' : 'bg-emerald-500');
            }

            ['name', 'price'].forEach(function (id) {
                document.getElementById(id).addEventListener('input', updatePreview);
            });
            ['province', 'city', 'district'].forEach(function (id) {
                var el = document.getElementById(id);
                if (el) el.addEventListener('change', updatePreview);
            });
            document.querySelectorAll('input[name="condition"]').forEach(function (radio) {
                radio.addEventListener('change', updatePreview);
            });

            var description = document.getElementById('description');
            var counter = document.getElementById('desc-counter');
            function updateCounter() {
                var len = description.value.length;
                counter.textContent = len + ' karakter';
                counter.classList.toggle('text-rose-500', len > 0 && len < 20);
            }
            description.addEventListener('input', updateCounter);
        });
    </script>
@endsection