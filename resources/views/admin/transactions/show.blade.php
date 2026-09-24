@extends('layouts.admin')

@section('title', 'Detail Transaksi - Admin Panel')

@section('page-title', 'Detail Transaksi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Transaksi #{{ $transaction->id }}</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
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
            <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d F Y H:i') }}</p>
        </div>

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="border-r border-gray-100 pr-6 sm:pr-0 sm:border-r sm:border-b-0 sm:pb-6">
                    <h3 class="text-sm font-medium text-gray-500">Pembeli</h3>
                    <div class="mt-2 flex items-center gap-3">
                        <img src="{{ $transaction->buyer->avatar ?? 'https://i.pravatar.cc/40?u=' . $transaction->buyer->id }}" alt="{{ $transaction->buyer->name }}" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-medium text-gray-900">{{ $transaction->buyer->name }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction->buyer->email }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction->buyer->phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Penjual</h3>
                    <div class="mt-2 flex items-center gap-3">
                        <img src="{{ $transaction->seller->avatar ?? 'https://i.pravatar.cc/40?u=' . $transaction->seller->id }}" alt="{{ $transaction->seller->name }}" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-medium text-gray-900">{{ $transaction->seller->name }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction->seller->email }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction->seller->phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk</h3>
                <div class="flex items-center gap-4">
                    @if($transaction->product->image)
                        <img src="{{ productImageUrl($transaction->product) }}" alt="{{ $transaction->product->name }}" class="w-20 h-20 rounded-xl object-cover">
                    @endif
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">{{ $transaction->product->name }}</p>
                        <p class="text-sm text-gray-500">{{ $transaction->product->city }}, {{ $transaction->product->province }}</p>
                    </div>
                    <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($transaction->price, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pembayaran</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500">Harga Produk</dt>
                        <dd class="font-medium text-gray-900">Rp {{ number_format($transaction->price, 0, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Lokasi COD</dt>
                        <dd class="font-medium text-gray-900">{{ $transaction->cod_location }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Tanggal COD</dt>
                        <dd class="font-medium text-gray-900">{{ optional($transaction->cod_date)->format('d F Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Waktu COD</dt>
                        <dd class="font-medium text-gray-900">{{ $transaction->cod_time }}</dd>
                    </div>
                    @if($transaction->note)
                        <div class="sm:col-span-2">
                            <dt class="text-gray-500">Catatan</dt>
                            <dd class="font-medium text-gray-900">{{ $transaction->note }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            @if($transaction->reviews->isNotEmpty())
                <div class="border-t border-gray-100 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Review</h3>
                    @foreach($transaction->reviews as $review)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <p class="font-medium text-gray-900">{{ $review->reviewer->name }}</p>
                                <div class="flex gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-gray-700">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection