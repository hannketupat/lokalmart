@extends('layouts.admin')

@section('title', 'Detail Laporan - Admin Panel')

@section('page-title', 'Detail Laporan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Laporan #{{ $report->id }}</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                @switch($report->status)
                    @case('pending') bg-yellow-100 text-yellow-700 @break
                    @case('diproses') bg-indigo-100 text-indigo-700 @break
                    @case('selesai') bg-emerald-100 text-emerald-700 @break
                    @case('ditolak') bg-gray-100 text-gray-700 @break
                    @default bg-gray-100 text-gray-700
                @endswitch">
                {{ ucfirst($report->status) }}
            </span>
            <p class="text-sm text-gray-500">{{ $report->created_at->format('d F Y H:i') }}</p>
        </div>

        <div class="p-6 space-y-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Alasan</h3>
                <p class="mt-1 text-gray-900 whitespace-pre-line">{{ $report->reason }}</p>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pelapor</h3>
                <div class="flex items-center gap-3">
                    <img src="{{ $report->reporter->avatar ?? 'https://i.pravatar.cc/50?u=' . $report->reporter->id }}" alt="{{ $report->reporter->name }}" class="w-12 h-12 rounded-full">
                    <div>
                        <p class="font-medium text-gray-900">{{ $report->reporter->name }}</p>
                        <p class="text-sm text-gray-500">{{ $report->reporter->email }}</p>
                        <p class="text-sm text-gray-500">{{ $report->reporter->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk Dilaporkan</h3>
                @if($report->product)
                    <div class="flex items-center gap-4">
                        @if($report->product->image)
                            <img src="{{ productImageUrl($report->product) }}" alt="{{ $report->product->name }}" class="w-16 h-16 rounded-xl object-cover">
                        @endif
                        <div>
                            <p class="font-medium text-gray-900">{{ $report->product->name }}</p>
                            <p class="text-sm text-gray-500">Harga: Rp {{ number_format($report->product->price, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">Penjual: {{ $report->product->user->name ?? '-' }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Produk telah dihapus</p>
                @endif
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h3>
                <form action="{{ route('admin.reports.update', $report) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" required
                                class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $report->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $report->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ $report->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
