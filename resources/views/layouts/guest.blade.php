<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'LokalMart') }}</title>

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
    </head>
    <body class="font-sans antialiased bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 text-gray-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            <div>
                <a href="{{ route('landing') }}" class="flex items-center gap-2">
                    <span class="grid place-items-center w-11 h-11 rounded-2xl bg-indigo-600 text-white shadow-md">
                        <i data-lucide="store" class="w-6 h-6"></i>
                    </span>
                    <span class="text-2xl font-extrabold tracking-tight text-gray-900">
                        Lokal<span class="text-indigo-600">Mart</span>
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 bg-white rounded-3xl shadow-lg border border-gray-100 p-8 overflow-hidden">
                {{ $slot }}
            </div>

            <p class="mt-8 text-xs text-gray-400">© {{ date('Y') }} LokalMart. Belanja lokal, transaksi aman dengan COD.</p>
        </div>

        <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
        <script>lucide.createIcons();</script>
    </body>
</html>