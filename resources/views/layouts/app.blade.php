<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'LokalMart'))</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                },
            },
        };
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <nav x-data="{ menuOpen: false, open: false }" class="sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">

                <div class="flex items-center gap-2">
                    <button @click="menuOpen = !menuOpen" class="lg:hidden p-2 -ml-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100" aria-label="Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <a href="{{ route('landing') }}" class="flex items-center gap-2">
                        <span class="grid place-items-center w-9 h-9 rounded-xl bg-indigo-600 text-white">
                            <i data-lucide="store" class="w-5 h-5"></i>
                        </span>
                        <span class="text-xl font-extrabold tracking-tight text-gray-900">
                            Lokal<span class="text-indigo-600">Mart</span>
                        </span>
                    </a>
                </div>

                @auth
                    <form action="{{ route('explore') }}" method="GET" class="hidden lg:flex flex-1 max-w-xl mx-auto">
                        <div class="relative flex-1">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i data-lucide="search" class="w-4 h-4"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang di sekitar kamu..."
                                   class="w-full rounded-full border border-gray-200 bg-gray-50 py-2.5 pl-11 pr-20 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <button class="absolute right-1.5 top-1/2 -translate-y-1/2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full px-4 py-1.5 text-xs font-semibold">Cari</button>
                        </div>
                    </form>

                    <div class="hidden lg:flex items-center gap-1">
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-full text-sm font-medium {{ request()->routeIs('home') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-100' }}">Home</a>
                        <a href="{{ route('explore') }}" class="px-3 py-2 rounded-full text-sm font-medium {{ request()->routeIs('explore') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-100' }}">Jelajahi</a>
                    </div>

                    <div class="flex items-center gap-0.5 sm:gap-1">
                        <a href="{{ route('favorites.index') }}" title="Favorit" class="relative p-2.5 rounded-full text-gray-600 hover:bg-gray-100 {{ request()->routeIs('favorites.index') ? 'text-rose-500' : '' }}">
                            <span class="text-lg leading-none">❤️</span>
                            @php $favCount = auth()->user()->favorites()->count(); @endphp
                            @if($favCount > 0)
                                <span class="absolute top-1 right-1 min-w-4 h-4 px-1 grid place-items-center rounded-full bg-rose-500 text-white text-[10px] font-bold">{{ $favCount > 99 ? '99+' : $favCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('notifications.index') }}" title="Notifikasi" class="relative p-2.5 rounded-full text-gray-600 hover:bg-gray-100">
                            <span class="text-lg leading-none">🔔</span>
                            @php $notifCount = auth()->user()->unreadNotificationsCount(); @endphp
                            @if($notifCount > 0)
                                <span class="absolute top-1 right-1 min-w-4 h-4 px-1 grid place-items-center rounded-full bg-rose-500 text-white text-[10px] font-bold">{{ $notifCount > 99 ? '99+' : $notifCount }}</span>
                            @endif
                        </a>

                        <div class="relative ms-1 sm:ms-2" @click.outside="open = false">
                            <button @click="open = !open" class="flex items-center gap-2 p-1.5 rounded-full hover:bg-gray-100">
                                <img src="{{ Auth::user()->avatar ?? 'https://i.pravatar.cc/150?u=' . Auth::id() }}"
                                     alt="{{ Auth::user()->name }}"
                                     class="w-9 h-9 rounded-full object-cover ring-2 ring-indigo-100">
                                <span class="hidden md:block text-sm font-semibold max-w-24 truncate">{{ Auth::user()->name }}</span>
                                <svg class="hidden md:block w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" x-transition x-cloak @click="open = false"
                                 class="absolute right-0 mt-3 w-56 rounded-2xl border border-gray-100 bg-white shadow-xl p-1.5">
                                <div class="px-3 py-2 border-b border-gray-100 mb-1">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.show', auth()->user()) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-50">
                                    <i data-lucide="user" class="w-5 h-5 text-gray-400"></i> Profil
                                </a>
                                <a href="{{ route('products.my') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-50">
                                    <i data-lucide="package" class="w-5 h-5 text-gray-400"></i> Barang Saya
                                </a>
                                <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-50">
                                    <i data-lucide="receipt-text" class="w-5 h-5 text-gray-400"></i> Transaksi
                                </a>
                                <a href="{{ route('favorites.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-50">
                                    <i data-lucide="heart" class="w-5 h-5 text-gray-400"></i> Favorit
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="pt-1 mt-1 border-t border-gray-100">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-rose-600 hover:bg-rose-50">
                                        <i data-lucide="log-out" class="w-5 h-5"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden md:flex items-center gap-1">
                        <a href="{{ route('landing') }}" class="px-3 py-2 rounded-full text-sm font-medium {{ request()->routeIs('landing') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-100' }}">Home</a>
                        <a href="#kategori" class="px-3 py-2 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-100">Jelajahi Barang</a>
                        <a href="#cara-kerja" class="px-3 py-2 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-100">Cara Kerja</a>
                    </div>
                    <div class="hidden md:flex items-center gap-3">
                        <a href="{{ route('login') }}" class="px-5 py-2 rounded-full text-sm font-semibold text-indigo-600 border border-indigo-600 hover:bg-indigo-50">Login</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 rounded-full text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm">Register</a>
                    </div>
                @endauth
            </div>
        </div>

        <div x-show="menuOpen" x-transition x-cloak class="lg:hidden border-t border-gray-100">
            <div class="px-4 py-4 space-y-3 max-w-7xl mx-auto">
                @auth
                    <form action="{{ route('explore') }}" method="GET" class="flex gap-2">
                        <div class="relative flex-1">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i data-lucide="search" class="w-4 h-4"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang di sekitar kamu..."
                                   class="w-full rounded-full border border-gray-200 bg-gray-50 pl-11 pr-4 py-2.5 text-sm outline-none placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                        <button class="px-5 rounded-full bg-indigo-600 text-white text-sm font-semibold">Cari</button>
                    </form>

                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('home') }}" class="text-center px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('home') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 border border-gray-200' }}">Home</a>
                        <a href="{{ route('explore') }}" class="text-center px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('explore') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 border border-gray-200' }}">Jelajahi</a>
                        <a href="{{ route('favorites.index') }}" class="text-center px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('favorites.index') ? 'text-rose-500 bg-rose-50' : 'text-gray-700 border border-gray-200' }}">❤️ Favorit</a>
                    </div>
                @else
                    <a href="#kategori" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100">Jelajahi Barang</a>
                    <a href="#cara-kerja" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100">Cara Kerja</a>
                @endauth

                @guest
                    <div class="flex gap-3 pt-2 border-t border-gray-100">
                        <a href="{{ route('login') }}" class="flex-1 text-center px-4 py-2.5 rounded-full text-sm font-semibold text-indigo-600 border border-indigo-600">Login</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center px-4 py-2.5 rounded-full text-sm font-semibold text-white bg-indigo-600">Register</a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    @isset($header)
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {!! $header !!}
            </div>
        </header>
    @endisset

    <main class="pb-20 md:pb-0">
        @yield('content')
        {!! $slot ?? '' !!}
    </main>

    @auth
        <x-bottom-nav />
    @endauth

    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-10">
                <div class="col-span-2 lg:col-span-2">
                    <a href="{{ route('landing') }}" class="flex items-center gap-2">
                        <span class="grid place-items-center w-9 h-9 rounded-xl bg-indigo-600 text-white">
                            <i data-lucide="store" class="w-5 h-5"></i>
                        </span>
                        <span class="text-xl font-extrabold tracking-tight text-gray-900">
                            Lokal<span class="text-indigo-600">Mart</span>
                        </span>
                    </a>
                    <p class="mt-4 text-sm text-gray-500 max-w-sm leading-relaxed">
                        Marketplace lokal untuk jual beli barang dengan mudah dan aman melalui COD.
                        Temukan, Chat via WhatsApp, dan bertransaksi langsung dengan penjual di sekitarmu.
                    </p>
                    <div class="flex items-center gap-2 mt-5">
                        <a href="#" class="grid place-items-center w-10 h-10 rounded-full bg-gray-100 text-gray-500 hover:bg-indigo-600 hover:text-white transition">
                            <i data-lucide="instagram" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="grid place-items-center w-10 h-10 rounded-full bg-gray-100 text-gray-500 hover:bg-indigo-600 hover:text-white transition">
                            <i data-lucide="facebook" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="grid place-items-center w-10 h-10 rounded-full bg-gray-100 text-gray-500 hover:bg-indigo-600 hover:text-white transition">
                            <i data-lucide="twitter" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Tentang Kami</h4>
                    <ul class="mt-4 space-y-2.5 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-indigo-600">Tentang LokalMart</a></li>
                        <li><a href="#cara-kerja" class="hover:text-indigo-600">Cara Kerja</a></li>
                        <li><a href="#" class="hover:text-indigo-600">Jadi Penjual</a></li>
                        <li><a href="#" class="hover:text-indigo-600">Karier</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Bantuan</h4>
                    <ul class="mt-4 space-y-2.5 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-indigo-600">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-indigo-600">Panduan COD</a></li>
                        <li><a href="#" class="hover:text-indigo-600">Keamanan Transaksi</a></li>
                        <li><a href="#" class="hover:text-indigo-600">Lapor Masalah</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Kebijakan & Kontak</h4>
                    <ul class="mt-4 space-y-2.5 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-indigo-600">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-indigo-600">Syarat & Ketentuan</a></li>
                        <li><a href="mailto:halo@lokalmart.id" class="hover:text-indigo-600">halo@lokalmart.id</a></li>
                        <li><a href="#" class="hover:text-indigo-600">+62 812-3456-7890</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-gray-400">© {{ date('Y') }} LokalMart. Semua hak dilindungi.</p>
                <p class="text-xs text-gray-400">Dibuat dengan <span class="text-rose-500">♥</span> untuk komunitas lokal Indonesia</p>
            </div>
        </div>
    </footer>

    @if(session('success') || session('error') || session('info'))
        <div id="toast-container" class="fixed top-20 right-5 z-50 w-80 max-w-[calc(100vw-2.5rem)] space-y-3">
            @if(session('success'))
                <div class="toast flex items-start gap-3 rounded-2xl bg-white border border-emerald-100 p-4 shadow-xl">
                    <span class="grid place-items-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 shrink-0">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                    </span>
                    <p class="text-sm text-gray-700 pt-0.5">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="toast flex items-start gap-3 rounded-2xl bg-white border border-rose-100 p-4 shadow-xl">
                    <span class="grid place-items-center w-8 h-8 rounded-full bg-rose-100 text-rose-600 shrink-0">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    </span>
                    <p class="text-sm text-gray-700 pt-0.5">{{ session('error') }}</p>
                </div>
            @endif
            @if(session('info'))
                <div class="toast flex items-start gap-3 rounded-2xl bg-white border border-sky-100 p-4 shadow-xl">
                    <span class="grid place-items-center w-8 h-8 rounded-full bg-sky-100 text-sky-600 shrink-0">
                        <i data-lucide="info" class="w-4 h-4"></i>
                    </span>
                    <p class="text-sm text-gray-700 pt-0.5">{{ session('info') }}</p>
                </div>
            @endif
        </div>
        <script>
            (function () {
                var dismiss = function (el) {
                    el.style.transition = 'opacity .3s ease';
                    el.style.opacity = '0';
                    setTimeout(function () { el.remove(); }, 300);
                };
                document.querySelectorAll('#toast-container .toast').forEach(function (el) {
                    setTimeout(function () { dismiss(el); }, 4000);
                });
            })();
        </script>
    @endif

    <script>
        lucide.createIcons();
    </script>
    <style>
        .favorited-heart svg { fill: currentColor; }
    </style>
</body>
</html>