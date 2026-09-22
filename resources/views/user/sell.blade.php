@extends('layouts.app')

@section('title', 'Jual Barang | LokalMart')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Jual Barang</h1>
            <p class="mt-1.5 text-sm text-gray-500">Isi detail barang yang ingin kamu jual</p>
        </div>

        <div class="lg:grid lg:grid-cols-[1fr_380px] lg:gap-8 items-start">

            {{-- FORM --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <form id="sell-form" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="action" id="action-input" value="">

                    {{-- 1. UPLOAD FOTO --}}
                    <div>
                        <label class="text-sm font-bold text-gray-900">Foto Barang</label>
                        <label for="image" id="drop-zone"
                               class="mt-2.5 flex flex-col items-center justify-center gap-3 rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 p-8 cursor-pointer text-center hover:border-indigo-400 hover:bg-indigo-50/40 transition">
                            <span class="grid place-items-center w-14 h-14 rounded-full bg-indigo-100 text-indigo-600">
                                <i data-lucide="cloud-upload" class="w-7 h-7"></i>
                            </span>
                            <span class="text-sm font-semibold text-gray-700">Tarik & letakkan foto di sini</span>
                            <span class="text-xs text-gray-400">atau klik untuk memilih file</span>
                            <span class="mt-1 text-[11px] text-gray-400">Format: JPG, PNG. Maks 2MB.</span>
                            <input type="file" name="image" id="image" accept="image/*" class="hidden">
                            <div id="upload-preview" class="hidden mt-2">
                                <img id="preview-img" src="#" alt="Preview" class="w-32 h-32 object-cover rounded-xl border border-gray-200">
                            </div>
                        </label>
                        @error('image')
                            <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 2. NAMA BARANG --}}
                    <div class="mt-6">
                        <label for="name" class="block text-sm font-bold text-gray-900">Nama Barang</label>
                        <input type="text" id="name" name="name" maxlength="100" value="{{ old('name') }}"
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
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
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
                                <input type="number" id="price" name="price" min="1000" step="1000" value="{{ old('price') }}"
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
                                    <input type="radio" name="condition" id="condition-baru" value="baru" @checked(old('condition', 'baru') === 'baru')
                                           class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-700">Baru</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="radio" name="condition" id="condition-bekas" value="bekas" @checked(old('condition') === 'bekas')
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
                            <span id="desc-counter" class="text-[11px] text-gray-400">0 karakter</span>
                        </div>
                        <textarea id="description" name="description" rows="5" minlength="20"
                                  placeholder="Ceritakan kondisi, kelengkapan, dan alasan menjual barang ini..."
                                  class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-[11px] text-gray-400">Minimal 20 karakter agar deskripsi terlihat informatif</p>
                    </div>

                    {{-- 7. LOKASI --}}
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        @include('partials.location-data', ['isExplore' => false, 'useUserLocation' => true])
                    </div>

                    {{-- 8. TIPS BOX --}}
                    <div class="mt-6 rounded-2xl bg-amber-50 border border-amber-200 p-4">
                        <p class="text-sm text-amber-800 leading-relaxed">
                            <span class="inline-block mr-1">💡</span>
                            Gunakan foto yang jelas dan deskripsi yang lengkap agar barang lebih mudah ditemukan.
                        </p>
                    </div>

                    {{-- 9. BUTTON GROUP --}}
                    <div class="mt-6 grid sm:grid-cols-2 gap-3">
                        <button type="button" onclick="submitAction('draft')"
                                class="w-full rounded-xl border border-indigo-600 text-indigo-600 hover:bg-indigo-50 text-sm font-bold py-3.5 transition">
                            Simpan sebagai Draft
                        </button>
                        <button type="button" onclick="submitAction('publish')"
                                class="w-full rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-3.5 shadow-sm transition">
                            Publikasikan Barang
                        </button>
                    </div>
                </form>
            </div>

            {{-- PREVIEW --}}
            <aside class="lg:sticky lg:top-20 mt-6 lg:mt-0">
                <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">Preview</h2>
                <div class="mt-3 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="relative aspect-square bg-gray-100 grid place-items-center">
                        <img id="preview-image" src="https://picsum.photos/seed/lokalmart-placeholder/600/600" alt="Preview foto"
                             class="w-full h-full object-cover">
                        <span id="preview-condition-badge"
                              class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[11px] font-bold text-white bg-emerald-500">Baru</span>
                    </div>
                    <div class="p-4 space-y-1.5">
                        <p id="preview-name" class="font-semibold text-sm text-gray-800 line-clamp-2 leading-snug">Nama barang kamu muncul di sini</p>
                        <p id="preview-price" class="text-base font-extrabold text-indigo-600">Rp0</p>
                        <p id="preview-location" class="text-xs text-gray-400">📍 Lokasi barang</p>
                    </div>
                </div>
                <p class="mt-3 text-xs text-gray-400 leading-relaxed">Ini tampilan barang kamu di halaman explore</p>
            </aside>
        </div>
    </div>

    <script>
        function submitAction(value) {
            document.getElementById('action-input').value = value;
            document.getElementById('sell-form').submit();
        }

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

            var dropZone = document.getElementById('drop-zone');
            ['dragover', 'dragenter'].forEach(function (eventName) {
                dropZone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    dropZone.classList.add('border-indigo-400', 'bg-indigo-50/40');
                });
            });
            ['dragleave', 'drop'].forEach(function (eventName) {
                dropZone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    dropZone.classList.remove('border-indigo-400', 'bg-indigo-50/40');
                });
            });
            dropZone.addEventListener('drop', function (e) {
                var files = e.dataTransfer.files;
                if (files.length) {
                    imageInput.files = files;
                    imageInput.dispatchEvent(new Event('change'));
                }
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

                var isBekas = document.getElementById('condition-bekas').checked;
                var badge = document.getElementById('preview-condition-badge');
                badge.textContent = isBekas ? 'Bekas' : 'Baru';
                badge.className = 'absolute top-3 left-3 px-2.5 py-1 rounded-full text-[11px] font-bold text-white ' + (isBekas ? 'bg-amber-400' : 'bg-emerald-500');
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
            updateCounter();
            updatePreview();
        });
    </script>
@endsection