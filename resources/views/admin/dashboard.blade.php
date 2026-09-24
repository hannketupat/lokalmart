@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')

@section('page-title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pengguna</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['users'] ?? 0 }}</p>
                </div>
                <div class="grid place-items-center w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600">
                    <i data-lucide="users" class="w-7 h-7"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Produk</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['products'] ?? 0 }}</p>
                </div>
                <div class="grid place-items-center w-14 h-14 rounded-2xl bg-green-100 text-green-600">
                    <i data-lucide="package" class="w-7 h-7"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['transactions'] ?? 0 }}</p>
                </div>
                <div class="grid place-items-center w-14 h-14 rounded-2xl bg-yellow-100 text-yellow-600">
                    <i data-lucide="receipt-text" class="w-7 h-7"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Laporan Masuk</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['reports'] ?? 0 }}</p>
                </div>
                <div class="grid place-items-center w-14 h-14 rounded-2xl bg-rose-100 text-rose-600">
                    <i data-lucide="flag" class="w-7 h-7"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
                <div class="space-y-2">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        <div class="grid place-items-center w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600">
                            <i data-lucide="user-plus" class="w-5 h-5"></i>
                        </div>
                        Kelola Pengguna
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        <div class="grid place-items-center w-9 h-9 rounded-xl bg-green-100 text-green-600">
                            <i data-lucide="package-plus" class="w-5 h-5"></i>
                        </div>
                        Kelola Produk
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        <div class="grid place-items-center w-9 h-9 rounded-xl bg-yellow-100 text-yellow-600">
                            <i data-lucide="receipt-text" class="w-5 h-5"></i>
                        </div>
                        Kelola Transaksi
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        <div class="grid place-items-center w-9 h-9 rounded-xl bg-rose-100 text-rose-600">
                            <i data-lucide="flag" class="w-5 h-5"></i>
                        </div>
                        Cek Laporan
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        <div class="grid place-items-center w-9 h-9 rounded-xl bg-gray-100 text-gray-600">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                        </div>
                        Pengaturan
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h2>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat semua</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @if($recentActivity->isEmpty())
                        <div class="p-8 text-center text-gray-500">Belum ada aktivitas</div>
                    @else
                        @foreach($recentActivity as $activity)
                            <div class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50">
                                <div class="grid place-items-center w-10 h-10 rounded-xl
                                    @switch($activity['type'])
                                        @case('user') bg-indigo-100 text-indigo-600 @break
                                        @case('product') bg-green-100 text-green-600 @break
                                        @case('transaction') bg-yellow-100 text-yellow-600 @break
                                        @case('report') bg-rose-100 text-rose-600 @break
                                        @default bg-gray-100 text-gray-600
                                    @endswitch">
                                    @switch($activity['type'])
                                        @case('user') <i data-lucide="user" class="w-5 h-5"></i> @break
                                        @case('product') <i data-lucide="package" class="w-5 h-5"></i> @break
                                        @case('transaction') <i data-lucide="receipt-text" class="w-5 h-5"></i> @break
                                        @case('report') <i data-lucide="flag" class="w-5 h-5"></i> @break
                                        @default <i data-lucide="activity" class="w-5 h-5"></i>
                                    @endswitch
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity['description'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                                </div>
                                @if(isset($activity['link']))
                                    <a href="{{ $activity['link'] }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Detail</a>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection