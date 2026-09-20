@extends('layouts.app')

@section('title', 'Masuk | LokalMart')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-b from-indigo-50 via-white to-white">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-indigo-100 blur-3xl opacity-60"></div>
        <div class="absolute top-40 -left-24 w-80 h-80 rounded-full bg-violet-100 blur-3xl opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                {{-- KIRI: FORM LOGIN --}}
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

                    <h1 class="mt-8 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900">
                        Selamat Datang Kembali
                    </h1>
                    <p class="mt-2 text-base text-gray-500">
                        Masuk untuk lanjut belanja barang di sekitar kamu.
                    </p>

                    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                        @csrf

                        {{-- EMAIL --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                            <div class="relative mt-1.5">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="mail" class="w-4 h-4"></i>
                                </span>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                       placeholder="nama@email.com" autocomplete="email" required autofocus
                                       class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-11 pr-4 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div x-data="{ show: false }">
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                    Lupa password?
                                </a>
                            </div>
                            <div class="relative mt-1.5">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="lock" class="w-4 h-4"></i>
                                </span>
                                <input id="password" :type="show ? 'text' : 'password'" name="password"
                                       placeholder="Masukkan password" autocomplete="current-password" required
                                       class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-11 pr-12 text-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <button type="button" @click="show = !show"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-gray-400 hover:text-gray-600"
                                        :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                                    <i data-lucide="eye" x-show="!show" class="w-5 h-5"></i>
                                    <i data-lucide="eye-off" x-show="show" class="w-5 h-5"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- INGAT SAYA --}}
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-2.5 select-none cursor-pointer">
                                <input type="checkbox" name="remember" value="1"
                                       class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-600">Ingat saya</span>
                            </label>
                        </div>

                        <button type="submit"
                                class="w-full rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-3.5 shadow-sm transition">
                            Masuk
                        </button>
                    </form>

                    <div class="mt-6 flex items-center gap-4">
                        <span class="h-px flex-1 bg-gray-200"></span>
                        <span class="text-xs text-gray-400 font-medium">atau</span>
                        <span class="h-px flex-1 bg-gray-200"></span>
                    </div>

                    <p class="mt-6 text-center text-sm text-gray-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-800">
                            Daftar sekarang
                        </a>
                    </p>
                </div>

                {{-- KANAN: ILUSTRASI --}}
                <div class="hidden lg:block">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-gradient-to-tr from-indigo-600 via-violet-600 to-fuchsia-500 rounded-[2.5rem] blur-2xl opacity-40"></div>

                        <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                            <img src="https://picsum.photos/seed/lokalmart-login/720/820" alt="Ilustrasi marketplace lokal"
                                 class="w-full aspect-[720/820] object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/90 via-indigo-900/30 to-transparent"></div>

                            <div class="absolute inset-x-0 bottom-0 p-8">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-white text-xs font-bold">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                    Marketplace Lokal
                                </span>
                                <h2 class="mt-4 text-2xl text-white font-extrabold leading-snug">
                                    Temukan Barang<br>di Sekitarmu
                                </h2>
                                <ul class="mt-5 space-y-2.5 text-sm text-white/85">
                                    <li class="flex items-center gap-2.5">
                                        <span class="grid place-items-center w-6 h-6 rounded-full bg-emerald-400 text-emerald-950">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        </span>
                                        Gratis bergabung &amp; langsung belanja
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <span class="grid place-items-center w-6 h-6 rounded-full bg-emerald-400 text-emerald-950">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        </span>
                                        Transaksi COD yang aman
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <span class="grid place-items-center w-6 h-6 rounded-full bg-emerald-400 text-emerald-950">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        </span>
                                        Penjual lokal terverifikasi
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