@php
    $isExplore = $isExplore ?? false;

    if ($isExplore) {
        $provinceValue = request('province');
        $cityValue = request('city');
        $districtValue = request('district');
        $requiredAttr = '';
    } else {
        $provinceValue = old('province');
        $cityValue = old('city');
        $districtValue = old('district');
        $requiredAttr = 'required';
    }

    $locations = [
        'DKI Jakarta' => [
            'Kota Jakarta Pusat' => ['Gambir', 'Senen', 'Menteng', 'Tanah Abang', 'Cempaka Putih'],
            'Kota Jakarta Utara' => ['Kelapa Gading', 'Penjaringan', 'Koja', 'Tanjung Priok', 'Cilincing'],
            'Kota Jakarta Barat' => ['Cengkareng', 'Grogol Petamburan', 'Kembangan', 'Kebon Jeruk', 'Tambora'],
            'Kota Jakarta Selatan' => ['Kebayoran Baru', 'Kebayoran Lama', 'Setiabudi', 'Jagakarsa', 'Tebet'],
            'Kota Jakarta Timur' => ['Jatinegara', 'Kramat Jati', 'Pasar Rebo', 'Duren Sawit', 'Cakung'],
        ],
        'Jawa Barat' => [
            'Kota Bandung' => ['Coblong', 'Bandung Kidul', 'Antapani', 'Arcamanik', 'Sumur Bandung'],
            'Kota Bogor' => ['Bogor Selatan', 'Bogor Tengah', 'Bogor Timur', 'Bogor Utara', 'Tanah Sareal'],
            'Kota Bekasi' => ['Bekasi Timur', 'Bekasi Barat', 'Bekasi Selatan', 'Bekasi Utara', 'Jatiasih'],
            'Kabupaten Bandung' => ['Soreang', 'Ciparay', 'Margahayu', 'Majalaya', 'Dayeuhkolot'],
            'Kota Depok' => ['Pancoran Mas', 'Beji', 'Cimanggis', 'Sukmajaya', 'Tapos'],
        ],
        'Banten' => [
            'Kota Tangerang' => ['Ciledug', 'Batuceper', 'Cibodas', 'Karawaci', 'Benda'],
            'Kota Tangerang Selatan' => ['Serpong', 'Ciputat', 'Pamulang', 'Setu', 'Pondok Aren'],
            'Kota Serang' => ['Serang', 'Cipocok Jaya', 'Curug', 'Taktakan', 'Kasemen'],
            'Kota Cilegon' => ['Cilegon', 'Ciwandan', 'Jombang', 'Grogol', 'Pulomerak'],
            'Kabupaten Tangerang' => ['Legok', 'Pagedangan', 'Cikupa', 'Balaraja', 'Kronjo'],
        ],
        'Jawa Tengah' => [
            'Kota Semarang' => ['Semarang Timur', 'Semarang Utara', 'Semarang Selatan', 'Gajah Mungkur', 'Tembalang'],
            'Kota Surakarta' => ['Laweyan', 'Serengan', 'Pasar Kliwon', 'Jebres', 'Banjarsari'],
            'Kota Magelang' => ['Magelang Selatan', 'Magelang Utara', 'Magelang Tengah'],
            'Kabupaten Semarang' => ['Ungaran Timur', 'Ungaran Barat', 'Ambarawa', 'Tengaran', 'Banyubiru'],
            'Kota Salatiga' => ['Sidorejo', 'Tingkir', 'Argomulyo', 'Sidomukti'],
        ],
        'Jawa Timur' => [
            'Kota Surabaya' => ['Gubeng', 'Genteng', 'Sukolilo', 'Tambaksari', 'Wonokromo'],
            'Kota Malang' => ['Klojen', 'Lowokwaru', 'Sukun', 'Blimbing', 'Kedungkandang'],
            'Kota Kediri' => ['Mojoroto', 'Kota', 'Pesantren'],
            'Kabupaten Sidoarjo' => ['Sidoarjo', 'Taman', 'Gedangan', 'Waru', 'Candi'],
            'Kota Batu' => ['Batu', 'Junrejo', 'Bumiaji'],
        ],
    ];
@endphp

@if($isExplore)
    <div>
        <div class="flex items-center gap-2">
            <span class="text-lg leading-none">📍</span>
            <h3 class="text-sm font-bold text-gray-900">Lokasi</h3>
        </div>
        <p class="mt-0.5 text-[11px] text-gray-400">Menampilkan barang di sekitar kamu</p>
        <div class="mt-3 space-y-3">
@else
    <div class="border-t border-gray-200 pt-6">
        <div class="flex items-center gap-2.5">
            <span class="grid place-items-center w-8 h-8 rounded-xl bg-indigo-100 text-indigo-600">
                <i data-lucide="map-pin" class="w-4 h-4"></i>
            </span>
            <h2 class="text-base font-bold text-gray-900">Lokasi Kamu</h2>
        </div>

        <div class="mt-4 flex items-start gap-3 rounded-xl bg-indigo-50 border border-indigo-100 p-3.5">
            <span class="text-lg leading-none">📍</span>
            <p class="text-xs text-indigo-800 leading-relaxed">
                Lokasi digunakan untuk menampilkan barang di sekitar kamu.
            </p>
        </div>

        <div class="mt-4 space-y-4">
@endif

        {{-- PROVINSI --}}
        <div>
            <label for="province" class="block text-sm font-semibold text-gray-700">Provinsi</label>
            <select id="province" name="province" {{ $requiredAttr }}
                    class="mt-1.5 w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="" @selected(!$provinceValue)>Pilih Provinsi</option>
                @foreach($locations as $provinceName => $cities)
                    <option value="{{ $provinceName }}" @selected($provinceValue === $provinceName)>{{ $provinceName }}</option>
                @endforeach
            </select>
            @error('province')
                <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- KOTA --}}
        <div>
            <label for="city" class="block text-sm font-semibold text-gray-700">Kota / Kabupaten</label>
            <select id="city" name="city" {{ $requiredAttr }}
                    class="mt-1.5 w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="" @selected(!$cityValue)>Pilih Kota</option>
                @foreach($locations as $provinceName => $cities)
                    @foreach($cities as $cityName => $districts)
                        <option data-province="{{ $provinceName }}" value="{{ $cityName }}"
                                @selected($cityValue === $cityName)>{{ $cityName }}</option>
                    @endforeach
                @endforeach
            </select>
            @error('city')
                <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- KECAMATAN --}}
        <div>
            <label for="district" class="block text-sm font-semibold text-gray-700">Kecamatan</label>
            <select id="district" name="district" {{ $requiredAttr }}
                    class="mt-1.5 w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="" @selected(!$districtValue)>Pilih Kecamatan</option>
                @foreach($locations as $provinceName => $cities)
                    @foreach($cities as $cityName => $districts)
                        @foreach($districts as $districtName)
                            <option data-city="{{ $cityName }}" value="{{ $districtName }}"
                                    @selected($districtValue === $districtName)>{{ $districtName }}</option>
                        @endforeach
                    @endforeach
                @endforeach
            </select>
            @error('district')
                <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
            @enderror
        </div>

@if($isExplore)
        </div>
    </div>
@else
        </div>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var province = document.getElementById('province');
        var city = document.getElementById('city');
        var district = document.getElementById('district');

        if (!province || !city || !district) return;

        function eachOption(select, fn) {
            Array.prototype.forEach.call(select.options, fn);
        }

        function isVisible(select, value) {
            var opt = null;
            eachOption(select, function (o) {
                if (o.value === value) opt = o;
            });
            return opt ? opt.style.display !== 'none' : false;
        }

        function firstVisible(select) {
            var found = '';
            eachOption(select, function (o) {
                if (o.value && o.style.display !== 'none' && !found) found = o.value;
            });
            return found;
        }

        function filterCities() {
            var pv = province.value;

            eachOption(city, function (o) {
                if (o.value) {
                    o.style.display = (o.getAttribute('data-province') === pv) ? '' : 'none';
                }
            });

            if (!pv) {
                city.value = '';
            } else if (city.value && isVisible(city, city.value)) {
                // tetap pertahankan pilihan kota lama jika masih cocok
            } else {
                city.value = firstVisible(city);
            }

            filterDistricts();
        }

        function filterDistricts() {
            var cv = city.value;

            eachOption(district, function (o) {
                if (o.value) {
                    o.style.display = (o.getAttribute('data-city') === cv) ? '' : 'none';
                }
            });

            if (!cv) {
                district.value = '';
            } else if (district.value && isVisible(district, district.value)) {
                // tetap pertahankan pilihan kecamatan lama jika masih cocok
            } else {
                district.value = firstVisible(district);
            }
        }

        province.addEventListener('change', function () { filterCities(); });
        city.addEventListener('change', function () { filterDistricts(); });

        // Inisialisasi: pakai nilai dari PHP, atau default ke provinsi pertama
        var provinceValue = @json($provinceValue ?? '');
        var cityValue = @json($cityValue ?? '');
        var districtValue = @json($districtValue ?? '');

        if (provinceValue) {
            province.value = provinceValue;
        } else {
            province.value = province.options.length > 1 ? province.options[1].value : '';
        }

        filterCities();

        if (cityValue && isVisible(city, cityValue)) {
            city.value = cityValue;
            filterDistricts();
        }
        if (districtValue && isVisible(district, districtValue)) {
            district.value = districtValue;
        }
    });
</script>