@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
            @if($unreadCount > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-700 bg-indigo-50 rounded-lg border border-indigo-200 hover:bg-indigo-100 transition">
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex gap-1" aria-label="Filter notifikasi">
            <a href="{{ route('notifications.index') }}"
               class="px-4 py-2.5 text-sm font-medium rounded-t-lg {{ request()->query('type', 'all') === 'all' ? 'bg-indigo-50 text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                Semua <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">{{ $counts['all'] }}</span>
            </a>
            <a href="{{ route('notifications.index', ['type' => 'transaksi']) }}"
               class="px-4 py-2.5 text-sm font-medium rounded-t-lg {{ request()->query('type') === 'transaksi' ? 'bg-indigo-50 text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                Transaksi <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">{{ $counts['transaksi'] }}</span>
            </a>
            <a href="{{ route('notifications.index', ['type' => 'chat']) }}"
               class="px-4 py-2.5 text-sm font-medium rounded-t-lg {{ request()->query('type') === 'chat' ? 'bg-indigo-50 text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                Chat <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">{{ $counts['chat'] }}</span>
            </a>
            <a href="{{ route('notifications.index', ['type' => 'sistem']) }}"
               class="px-4 py-2.5 text-sm font-medium rounded-t-lg {{ request()->query('type') === 'sistem' ? 'bg-indigo-50 text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                Sistem <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">{{ $counts['sistem'] }}</span>
            </a>
        </nav>
    </div>

    <!-- Notification List -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($notifications->isEmpty())
            <div class="py-16 text-center">
                <svg class="mx-auto w-16 h-16 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada notifikasi</h3>
                <p class="mt-2 text-sm text-gray-500">
                    Notifikasi akan muncul di sini saat ada aktivitas baru
                </p>
            </div>
        @else
            <div class="divide-y divide-gray-100">
                @foreach($notifications as $notification)
                    <div class="p-4 hover:bg-gray-50 transition {{ !$notification->is_read ? 'bg-indigo-50' : 'bg-white' }}">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center
                                @switch($notification->type)
                                    @case('transaksi')
                                        bg-indigo-100 text-indigo-600
                                        @break
                                    @case('chat')
                                        bg-green-100 text-green-600
                                        @break
                                    @case('sistem')
                                        bg-sky-100 text-sky-600
                                        @break
                                    @default
                                        bg-gray-100 text-gray-600
                                @endswitch">
                                @switch($notification->type)
                                    @case('transaksi')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                        @break
                                    @case('chat')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        @break
                                    @case('sistem')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        @break
                                    @default
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                @endswitch
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <h4 class="font-medium text-gray-900">{{ $notification->title }}</h4>
                                    @if(!$notification->is_read)
                                        <span class="flex-shrink-0 w-2 h-2 rounded-full bg-indigo-600 mt-1.5" aria-label="Belum dibaca"></span>
                                    @endif
                                </div>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $notification->message }}</p>
                                <p class="mt-2 text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>

                            @if(!$notification->is_read)
                                <form action="{{ route('notifications.read', $notification) }}" method="POST" class="flex-shrink-0">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                            aria-label="Tandai dibaca">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            {{ $notifications->links() }}
        @endif
    </div>
</div>
@endsection