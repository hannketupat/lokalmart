@extends('layouts.app')

@section('title', 'Daftar | LokalMart')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-b from-indigo-50 via-white to-white">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-indigo-100 blur-3xl opacity-60"></div>
        <div class="absolute top-40 -left-24 w-80 h-80 rounded-full bg-violet-100 blur-3xl opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                {{-- KIRI: FORM REGISTER --}}
                <div class="w-full max-w-md mx-auto lg:mx-0">
                    <div class="flex items-center gap-3">
                        <span class="grid place-items-center w-12 h-12 rounded-2xl bg-indigo-600 text-white shadow-md">
                            <i data-lucide="store" class="w-6 h-6"></i>
                        </span>
                        <div>
                            <p class="text-xl font-extrabold tracking-tight text-gray-900 leading-none">
                                Lokal<span class="text-indigo-600">Mart</span>
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Marketplace lokal se-Indonesia</p>
                        </div>
                    </div>

                    <h1 class="mt-8 text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-gray-900">
                        Buat Akun Baru
                    </h1>
                    <p class="mt-2 text-base text-gray-500">
                        Gabung gratis dan mulai jual beli barang di sekitarmu.
                    </p>

                    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
                        @csrf

                        {{-- NAMA LENGKAP --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                            <div class="relative mt-1.5">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                </span>
                                <input id="name" type="text" name="name" value="{{ old('name') }}"
                                       placeholder="Nama lengkap kamu" autocomplete="name" required autofocus
                                       class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-11 pr-4 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            @error('name')
                                <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                            <div class="relative mt-1.5">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="mail" class="w-4 h-4"></i>
                                </span>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                       placeholder="nama@email.com" autocomplete="email" required
                                       class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-11 pr-4 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- NOMOR WHATSAPP --}}
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700">Nomor WhatsApp</label>
                            <div class="relative mt-1.5">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-500">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </span>
                                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                                       placeholder="081234567890" inputmode="numeric" autocomplete="tel" required
                                       class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-11 pr-4 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <p class="mt-1.5 text-xs text-gray-400">📱 Digunakan pembeli untuk chat kamu via WhatsApp. Pastikan nomor aktif.</p>
                            @error('phone')
                                <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- PASSWORD & KONFIRMASI --}}
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div x-data="{ show: false }">
                                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                                <div class="relative mt-1.5">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i data-lucide="lock" class="w-4 h-4"></i>
                                    </span>
                                    <input id="password" :type="show ? 'text' : 'password'" name="password"
                                           placeholder="Min. 8 karakter" autocomplete="new-password" required
                                           class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-11 pr-11 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <button type="button" @click="show = !show"
                                            class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1.5 text-gray-400 hover:text-gray-600"
                                            :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                                        <i data-lucide="eye" x-show="!show" class="w-5 h-5"></i>
                                        <i data-lucide="eye-off" x-show="show" class="w-5 h-5"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div x-data="{ show: false }">
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                                <div class="relative mt-1.5">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i data-lucide="lock" class="w-4 h-4"></i>
                                    </span>
                                    <input id="password_confirmation" :type="show ? 'text' : 'password'"
                                           name="password_confirmation" placeholder="Ulangi password"
                                           autocomplete="new-password" required
                                           class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-11 pr-11 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <button type="button" @click="show = !show"
                                            class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1.5 text-gray-400 hover:text-gray-600"
                                            :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                                        <i data-lucide="eye" x-show="!show" class="w-5 h-5"></i>
                                        <i data-lucide="eye-off" x-show="show" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION LOKASI (opsi dirender dari PHP di partial) --}}
                        @include('partials.location-data')

                        {{-- SYARAT & KETENTUAN --}}
                        <label class="flex items-start gap-2.5 select-none cursor-pointer">
                            <input type="checkbox" name="terms" value="1"
                                   class="mt-0.5 w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm text-gray-600">
                                Saya setuju dengan
                                <a href="#" class="font-bold text-indigo-600 hover:text-indigo-800">Syarat &amp; Ketentuan</a>
                                dan
                                <a href="#" class="font-bold text-indigo-600 hover:text-indigo-800">Kebijakan Privasi</a>.
                            </span>
                        </label>

                        <button type="submit"
                                class="w-full rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-3.5 shadow-sm transition">
                            Daftar
                        </button>
                    </form>

                    <div class="mt-6 flex items-center gap-4">
                        <span class="h-px flex-1 bg-gray-200"></span>
                        <span class="text-xs text-gray-400 font-medium">atau</span>
                        <span class="h-px flex-1 bg-gray-200"></span>
                    </div>

                    <p class="mt-6 text-center text-sm text-gray-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800">
                            Masuk di sini
                        </a>
                    </p>
                </div>

                {{-- KANAN: ILUSTRASI --}}
                <div class="hidden lg:block">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-gradient-to-tr from-indigo-600 via-violet-600 to-fuchsia-500 rounded-[2.5rem] blur-2xl opacity-40"></div>

                        <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                            <img src="https://picsum.photos/seed/lokalmart-register/720/820" alt="Ilustrasi marketplace lokal"
                                 class="w-full aspect-[720/820] object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/90 via-indigo-900/30 to-transparent"></div>

                            <div class="absolute inset-x-0 bottom-0 p-8">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-white text-xs font-bold">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                    Marketplace Lokal
                                </span>
                                <h2 class="mt-4 text-2xl text-white font-extrabold leading-snug">
                                    Jual &amp; Beli<br>Lebih Dekat
                                </h2>
                                <ul class="mt-5 space-y-2.5 text-sm text-white/85">
                                    <li class="flex items-center gap-2.5">
                                        <span class="grid place-items-center w-6 h-6 rounded-full bg-emerald-400 text-emerald-950">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        </span>
                                        Gratis bergabung, tanpa biaya tersembunyi
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <span class="grid place-items-center w-6 h-6 rounded-full bg-emerald-400 text-emerald-950">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        </span>
                                        Barang di sekitar lokasi kamu
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <span class="grid place-items-center w-6 h-6 rounded-full bg-emerald-400 text-emerald-950">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        </span>
                                        Transaksi COD yang aman
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection