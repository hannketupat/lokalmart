<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - LokalMart')</title>
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
<body class="font-sans antialiased bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false, collapsed: false }">
    <div class="flex h-screen overflow-hidden" x-cloak>
        <!-- Sidebar -->
        <aside 
            class="fixed inset-y-0 left-0 z-50 bg-white border-r border-gray-200 transform transition-all duration-200 ease-in-out lg:static lg:z-auto"
            :class="[collapsed ? 'w-16' : 'w-64', sidebarOpen ? 'translate-x-0' : '-translate-x-full', 'lg:translate-x-0']"
            x-transition:enter="transition ease-in-out duration-200"
            x-transition:enter-start="opacity-0 -translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 -translate-x-full"
            aria-label="Sidebar">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2" :class="collapsed ? 'justify-center w-full' : ''">
                        <span class="grid place-items-center w-9 h-9 rounded-xl bg-indigo-600 text-white shrink-0">
                            <i data-lucide="shield" class="w-5 h-5"></i>
                        </span>
                        <span class="text-xl font-extrabold tracking-tight text-gray-900 whitespace-nowrap" x-show="!collapsed">
                            Admin<span class="text-indigo-600">Panel</span>
                        </span>
                    </a>
                    <button @click="collapsed = !collapsed" class="hidden lg:flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100" aria-label="Collapse sidebar">
                        <i data-lucide="chevron-left" class="w-5 h-5" x-show="!collapsed"></i>
                        <i data-lucide="chevron-right" class="w-5 h-5" x-show="collapsed"></i>
                    </button>
                    <button @click="sidebarOpen = false" class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100" aria-label="Tutup sidebar">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto" aria-label="Menu admin">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-100' }}" :class="collapsed ? 'justify-center' : ''">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0"></i> 
                        <span x-show="!collapsed">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.users*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-100' }}" :class="collapsed ? 'justify-center' : ''">
                        <i data-lucide="users" class="w-5 h-5 shrink-0"></i>
                        <span x-show="!collapsed">Pengguna</span>
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.products*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-100' }}" :class="collapsed ? 'justify-center' : ''">
                        <i data-lucide="package" class="w-5 h-5 shrink-0"></i>
                        <span x-show="!collapsed">Produk</span>
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.transactions*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-100' }}" :class="collapsed ? 'justify-center' : ''">
                        <i data-lucide="receipt-text" class="w-5 h-5 shrink-0"></i>
                        <span x-show="!collapsed">Transaksi</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.reports*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-100' }}" :class="collapsed ? 'justify-center' : ''">
                        <i data-lucide="flag" class="w-5 h-5 shrink-0"></i>
                        <span x-show="!collapsed">Laporan</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.settings*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-100' }}" :class="collapsed ? 'justify-center' : ''">
                        <i data-lucide="settings" class="w-5 h-5 shrink-0"></i>
                        <span x-show="!collapsed">Pengaturan</span>
                    </a>
                </nav>

                <div class="p-3 border-t border-gray-200" :class="collapsed ? 'px-1' : ''">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100" :class="collapsed ? 'justify-center' : ''">
                        <i data-lucide="arrow-left" class="w-5 h-5 shrink-0"></i>
                        <span x-show="!collapsed">Kembali ke Situs</span>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-black/50 lg:hidden" @click="sidebarOpen = false" aria-hidden="true"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-200" :class="collapsed ? 'lg:pl-16' : 'lg:pl-64'">
            <!-- Top Bar -->
            <header class="sticky top-0 z-30 bg-white/95 backdrop-blur shadow-sm border-b border-gray-100">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100" aria-label="Buka menu">
                            <i data-lucide="menu" class="w-6 h-6"></i>
                        </button>
                        <h1 class="text-lg font-semibold text-gray-900 hidden sm:block">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden sm:block text-sm text-gray-500">
                            <span class="font-medium">{{ auth()->user()->name }}</span>
                            <span class="text-indigo-600 ml-2">(Admin)</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="hidden sm:block">
                            @csrf
                            <button type="submit" class="p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100" aria-label="Logout">
                                <i data-lucide="log-out" class="w-5 h-5"></i>
                            </button>
                        </form>
                        <div class="sm:hidden">
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 w-full">
                                    <i data-lucide="log-out" class="w-5 h-5"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                @if(session('success') || session('error') || session('info'))
                    <div class="mb-6">
                        @if(session('success'))
                            <div class="flex items-start gap-3 rounded-2xl bg-white border border-emerald-100 p-4 shadow-sm">
                                <span class="grid place-items-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 shrink-0">
                                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                                </span>
                                <p class="text-sm text-gray-700 pt-0.5">{{ session('success') }}</p>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="flex items-start gap-3 rounded-2xl bg-white border border-rose-100 p-4 shadow-sm">
                                <span class="grid place-items-center w-8 h-8 rounded-full bg-rose-100 text-rose-600 shrink-0">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                </span>
                                <p class="text-sm text-gray-700 pt-0.5">{{ session('error') }}</p>
                            </div>
                        @endif
                        @if(session('info'))
                            <div class="flex items-start gap-3 rounded-2xl bg-white border border-sky-100 p-4 shadow-sm">
                                <span class="grid place-items-center w-8 h-8 rounded-full bg-sky-100 text-sky-600 shrink-0">
                                    <i data-lucide="info" class="w-4 h-4"></i>
                                </span>
                                <p class="text-sm text-gray-700 pt-0.5">{{ session('info') }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>