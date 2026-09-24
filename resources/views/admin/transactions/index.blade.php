@extends('layouts.admin')

@section('title', 'Kelola Transaksi - Admin Panel')

@section('page-title', 'Transaksi')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6 px-4 md:px-0">
        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Transaksi</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pembeli</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Penjual</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-mono text-gray-900">#{{ $transaction->id }}</td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">{{ $transaction->product->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700">{{ $transaction->buyer->name }}</p>
                                <p class="text-xs text-gray-500">{{ $transaction->buyer->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700">{{ $transaction->seller->name }}</p>
                                <p class="text-xs text-gray-500">{{ $transaction->seller->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">Rp {{ number_format($transaction->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @switch($transaction->status)
                                        @case('menunggu') bg-yellow-100 text-yellow-700 @break
                                        @case('disetujui') bg-indigo-100 text-indigo-700 @break
                                        @case('menunggu_cod') bg-sky-100 text-sky-700 @break
                                        @case('selesai') bg-emerald-100 text-emerald-700 @break
                                        @case('ditolak') bg-rose-100 text-rose-700 @break
                                        @default bg-gray-100 text-gray-700
                                    @endswitch">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.transactions.show', $transaction) }}" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg" title="Lihat">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARD LIST --}}
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($transactions as $transaction)
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2">
                        <p class="text-xs font-mono text-gray-400">#{{ $transaction->id }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            @switch($transaction->status)
                                @case('menunggu') bg-yellow-100 text-yellow-700 @break
                                @case('disetujui') bg-indigo-100 text-indigo-700 @break
                                @case('menunggu_cod') bg-sky-100 text-sky-700 @break
                                @case('selesai') bg-emerald-100 text-emerald-700 @break
                                @case('ditolak') bg-rose-100 text-rose-700 @break
                                @default bg-gray-100 text-gray-700
                            @endswitch">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </div>
                    <p class="mt-1 font-medium text-gray-900">{{ $transaction->product->name }}</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900">Rp {{ number_format($transaction->price, 0, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-gray-500">Pembeli: {{ $transaction->buyer->name }}</p>
                    <p class="text-xs text-gray-500">Penjual: {{ $transaction->seller->name }}</p>
                    <p class="mt-1 text-xs text-gray-400">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('admin.transactions.show', $transaction) }}" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-xs font-semibold transition">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-500">Belum ada transaksi</div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection