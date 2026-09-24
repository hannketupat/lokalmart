<nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 safe-area-pb">
    <div class="flex items-center justify-around h-16 max-w-md mx-auto px-4">
        <!-- Home -->
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center gap-0.5 w-16">
            <i data-lucide="home" class="w-5 h-5 {{ request()->routeIs('home') ? 'text-indigo-600' : 'text-gray-400' }}"></i>
            <span class="text-[10px] font-medium {{ request()->routeIs('home') ? 'text-indigo-600' : 'text-gray-400' }}">Home</span>
        </a>

        <!-- Explore -->
        <a href="{{ route('explore') }}" class="flex flex-col items-center justify-center gap-0.5 w-16">
            <i data-lucide="compass" class="w-5 h-5 {{ request()->routeIs('explore', 'explore.*') ? 'text-indigo-600' : 'text-gray-400' }}"></i>
            <span class="text-[10px] font-medium {{ request()->routeIs('explore', 'explore.*') ? 'text-indigo-600' : 'text-gray-400' }}">Explore</span>
        </a>

        <!-- Jual (Bulat indigo tengah) -->
        <a href="{{ route('products.create') }}" class="flex flex-col items-center justify-center -mt-8">
            <div class="grid place-items-center w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 shadow-lg shadow-indigo-300 text-white">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m-7.5-7.5h15"/>
                </svg>
            </div>
        </a>

        <!-- Favorit -->
        <a href="{{ route('favorites.index') }}" class="flex flex-col items-center justify-center gap-0.5 w-16">
            <i data-lucide="heart" class="w-5 h-5 {{ request()->routeIs('favorites.*') ? 'text-rose-500' : 'text-gray-400' }}"></i>
            <span class="text-[10px] font-medium {{ request()->routeIs('favorites.*') ? 'text-rose-500' : 'text-gray-400' }}">Favorit</span>
        </a>

        <!-- Profil -->
        <a href="{{ route('profile.show') }}" class="flex flex-col items-center justify-center gap-0.5 w-16">
            <i data-lucide="user" class="w-5 h-5 {{ request()->routeIs('profile.*') ? 'text-indigo-600' : 'text-gray-400' }}"></i>
            <span class="text-[10px] font-medium {{ request()->routeIs('profile.*') ? 'text-indigo-600' : 'text-gray-400' }}">Profil</span>
        </a>
    </div>

    <style>
        .safe-area-pb { padding-bottom: env(safe-area-inset-bottom, 0); }
    </style>
</nav>
