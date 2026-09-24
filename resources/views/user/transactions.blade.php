@extends('layouts.app')

@section('title', 'Transaksi | LokalMart')

@section('content')
    @php
        $tabs = [
            ['key' => 'menunggu', 'label' => 'Menunggu Persetujuan'],
            ['key' => 'disetujui', 'label' => 'Disetujui'],
            ['key' => 'menunggu_cod', 'label' => 'Menunggu COD'],
            ['key' => 'selesai', 'label' => 'Selesai'],
            ['key' => 'ditolak', 'label' => 'Ditolak'],
        ];
    @endphp

    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-8"
         x-data="{ tab: '{{ request('tab', 'menunggu') }}' }">
        <div class="flex items-end justify-between mb-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-600">Transaksi</span>
                <h2 class="mt-2 text-xl md:text-2xl lg:text-3xl font-extrabold text-gray-900">Daftar Transaksi</h2>
            </div>
        </div>

        {{-- TABS --}}
        <div class="border-b border-gray-200 mb-6 overflow-x-auto">
            <nav class="flex gap-1 min-w-max" aria-label="Tabs">
                @foreach($tabs as $item)
                    @php
                        $count = $transactions->where('status', $item['key'])->count();
                    @endphp
                    <button type="button"
                            @click="tab = '{{ $item['key'] }}'"
                            :class="tab === '{{ $item['key'] }}'
                                ? 'border-indigo-600 text-indigo-600 bg-indigo-50/60'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="px-4 py-2.5 text-sm font-bold border-b-2 rounded-t-lg transition -mb-px">
                        {{ $item['label'] }}
                        <span class="ml-1.5 inline-flex items-center justify-center min-w-5 h-5 px-1.5 rounded-full text-[11px] font-bold"
                              :class="tab === '{{ $item['key'] }}' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500'">
                            {{ $count }}
                        </span>
                    </button>
                @endforeach
            </nav>
        </div>

        @foreach($tabs as $item)
            <div x-show="tab === '{{ $item['key'] }}'" x-cloak class="space-y-4">
                @php
                    $list = $transactions->where('status', $item['key']);
                @endphp

                @if($list->isEmpty())
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                        <i data-lucide="receipt-text" class="w-12 h-12 text-gray-300 mx-auto"></i>
                        <p class="mt-4 text-sm text-gray-500 font-medium">
                            Tidak ada transaksi pada tab ini.
                        </p>
                    </div>
                @else
                    @foreach($list as $transaction)
                        @php
                            $isSeller = auth()->id() === $transaction->seller_id;
                            $isBuyer = auth()->id() === $transaction->buyer_id;
                            $counterparty = $isSeller ? $transaction->buyer : $transaction->seller;
                            $counterLabel = $isSeller ? 'Pembeli' : 'Penjual';
                        @endphp

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5 hover:shadow-md transition">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                <a href="{{ route('transactions.show', $transaction) }}" class="flex items-center gap-3.5 min-w-0 flex-1">
                                    <img src="{{ productImageUrl($transaction->product) }}"
                                         alt="{{ $transaction->product->name }}"
                                         class="w-16 h-16 rounded-xl object-cover bg-gray-100 shrink-0">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="font-bold text-sm text-gray-900 truncate">{{ $transaction->product->name }}</h3>
                                            <x-status-badge :status="$transaction->status" />
                                        </div>
                                        <p class="mt-1 text-base font-extrabold text-indigo-600">{{ formatRupiah($transaction->price) }}</p>
                                        <p class="mt-0.5 text-xs text-gray-400">
                                            {{ $counterLabel }}: {{ $counterparty->name }}
                                            • COD {{ $transaction->cod_date->format('d M Y') }} {{ $transaction->cod_time }}
                                        </p>
                                    </div>
                                </a>

                                <div class="flex flex-wrap items-center gap-2 sm:justify-end shrink-0">
                                    <a href="{{ route('transactions.show', $transaction) }}"
                                       class="px-4 py-2 rounded-xl border border-gray-200 text-xs font-bold text-gray-700 hover:border-indigo-300 hover:text-indigo-600 transition">
                                        Detail
                                    </a>

                                    @if($transaction->status === 'menunggu')
                                        @if($isSeller)
                                            <form action="{{ route('transactions.approve', $transaction) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('transactions.reject', $transaction) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 text-xs font-bold transition">
                                                    Tolak
                                                </button>
                                            </form>
                                        @elseif($isBuyer)
                                            <form action="{{ route('transactions.cancel', $transaction) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="px-4 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-bold transition">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    @elseif($transaction->status === 'menunggu_cod')
                                        <form action="{{ route('transactions.complete', $transaction) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition">
                                                Selesai
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
@endsection
