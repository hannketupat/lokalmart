@extends('layouts.admin')

@section('title', 'Kelola Laporan - Admin Panel')

@section('page-title', 'Laporan')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6 px-4 md:px-0">
        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Laporan</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alasan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelapor</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900 truncate max-w-xs">{{ $report->reason }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700">{{ $report->product->name ?? 'Produk terhapus' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700">{{ $report->reporter->name }}</p>
                                <p class="text-xs text-gray-500">{{ $report->reporter->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @switch($report->status)
                                        @case('pending') bg-yellow-100 text-yellow-700 @break
                                        @case('diproses') bg-indigo-100 text-indigo-700 @break
                                        @case('selesai') bg-emerald-100 text-emerald-700 @break
                                        @case('ditolak') bg-gray-100 text-gray-700 @break
                                        @default bg-gray-100 text-gray-700
                                    @endswitch">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $report->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.reports.show', $report) }}" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg" title="Lihat">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada laporan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARD LIST --}}
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($reports as $report)
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2">
                        <p class="font-medium text-gray-900">{{ $report->reason }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium shrink-0
                            @switch($report->status)
                                @case('pending') bg-yellow-100 text-yellow-700 @break
                                @case('diproses') bg-indigo-100 text-indigo-700 @break
                                @case('selesai') bg-emerald-100 text-emerald-700 @break
                                @case('ditolak') bg-gray-100 text-gray-700 @break
                                @default bg-gray-100 text-gray-700
                            @endswitch">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Produk: {{ $report->product->name ?? 'Produk terhapus' }}</p>
                    <p class="text-xs text-gray-500">Pelapor: {{ $report->reporter->name }}</p>
                    <p class="mt-1 text-xs text-gray-400">{{ $report->created_at->format('d M Y H:i') }}</p>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('admin.reports.show', $report) }}" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-xs font-semibold transition">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-500">Belum ada laporan</div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection
