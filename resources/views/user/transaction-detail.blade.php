@extends('layouts.app')

@section('title', 'Detail Transaksi | LokalMart')

@section('content')
    @php
        $isSeller = auth()->id() === $transaction->seller_id;
        $isBuyer = auth()->id() === $transaction->buyer_id;

        $steps = [
            'Menunggu Persetujuan',
            'Disetujui',
            'Menunggu COD',
            'COD',
            'Selesai',
        ];

        $currentStep = match ($transaction->status) {
            'menunggu' => 0,
            'disetujui' => 1,
            'menunggu_cod' => 3,
            'selesai' => 4,
            default => 0,
        };

        $isRejected = $transaction->status === 'ditolak';

        $myReview = $transaction->reviews
            ->firstWhere('reviewer_id', auth()->id());

        $theirReview = $transaction->reviews
            ->firstWhere('reviewer_id', $isSeller ? $transaction->buyer_id : $transaction->seller_id);

        $counterparty = $isSeller ? $transaction->buyer : $transaction->seller;
        $canReview = $transaction->status === 'selesai' && !$myReview;
    @endphp

    <div x-data="{ ratingModalOpen: false }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- BREADCRUMB --}}
        <nav class="flex items-center gap-1.5 text-sm text-gray-500 min-w-0">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 font-medium shrink-0">Home</a>
            <span class="text-gray-300 shrink-0">/</span>
            <a href="{{ route('transactions.index') }}" class="hover:text-indigo-600 font-medium shrink-0">Transaksi</a>
            <span class="text-gray-300 shrink-0">/</span>
            <span class="text-gray-700 font-semibold truncate">#{{ $transaction->id }}</span>
        </nav>

        {{-- HEADER --}}
        <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-indigo-600">Detail Transaksi</p>
                <h1 class="mt-2 text-2xl font-extrabold text-gray-900">
                    {{ $transaction->product->name }}
                </h1>
                <p class="mt-1 text-sm text-gray-400">Transaksi #{{ $transaction->id }} • {{ $transaction->created_at->format('d M Y H:i') }}</p>
            </div>
            <div class="shrink-0">
                @if($isRejected)
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-extrabold bg-red-100 text-red-700">
                        Ditolak
                    </span>
                @else
                    <x-status-badge :status="$transaction->status" />
                    <span class="ml-2 inline-flex items-center px-4 py-2 rounded-full text-sm font-extrabold
                        @switch($transaction->status)
                            @case('menunggu') bg-amber-100 text-amber-700 @break
                            @case('disetujui') bg-blue-100 text-blue-700 @break
                            @case('menunggu_cod') bg-indigo-100 text-indigo-700 @break
                            @case('selesai') bg-green-100 text-green-700 @break
                            @default bg-gray-100 text-gray-700
                        @endswitch">
                        @switch($transaction->status)
                            @case('menunggu') Menunggu Persetujuan @break
                            @case('disetujui') Disetujui @break
                            @case('menunggu_cod') Menunggu COD @break
                            @case('selesai') Selesai @break
                            @default {{ ucfirst($transaction->status) }}
                        @endswitch
                    </span>
                @endif
            </div>
        </div>

        {{-- PROGRESS TRACKER --}}
        <div class="mt-8 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            @if($isRejected)
                <div class="flex items-center gap-3 rounded-xl bg-red-50 border border-red-200 p-4">
                    <span class="grid place-items-center w-9 h-9 rounded-full bg-red-100 text-red-600 shrink-0">
                        <i data-lucide="x-circle" class="w-5 h-5"></i>
                    </span>
                    <div>
                        <p class="text-sm font-bold text-red-700">Transaksi Ditolak</p>
                        <p class="text-xs text-red-500 mt-0.5">Transaksi ini tidak dapat dilanjutkan.</p>
                    </div>
                </div>
            @else
                <div class="flex items-center justify-between gap-2 overflow-x-auto pb-2">
                    @for($i = 0; $i < count($steps); $i++)
                        @php
                            $isDone = $i < $currentStep || ($transaction->status === 'selesai' && $i <= 4);
                            $isCurrent = $i === $currentStep && $transaction->status !== 'selesai';
                            $isFinal = $transaction->status === 'selesai' && $i === 4;
                        @endphp

                        <div class="flex items-center min-w-0 {{ $i < count($steps) - 1 ? 'flex-1' : '' }}">
                            <div class="flex flex-col items-center gap-2 min-w-max">
                                <span class="grid place-items-center w-10 h-10 rounded-full text-xs font-extrabold border-2 transition
                                    @if($isFinal || $isDone && $i === 4)
                                        bg-green-500 border-green-500 text-white
                                    @elseif($isDone)
                                        bg-indigo-600 border-indigo-600 text-white
                                    @elseif($isCurrent)
                                        bg-white border-indigo-600 text-indigo-600 ring-4 ring-indigo-100
                                    @else
                                        bg-white border-gray-200 text-gray-400
                                    @endif">
                                    @if($isDone || $isFinal)
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    @else
                                        {{ $i + 1 }}
                                    @endif
                                </span>
                                <span class="text-[11px] font-bold text-center leading-tight w-20
                                    @if($isCurrent) text-indigo-600
                                    @elseif($isDone || $isFinal) text-gray-700
                                    @else text-gray-400
                                    @endif">
                                    {{ $steps[$i] }}
                                </span>
                            </div>

                            @if($i < count($steps) - 1)
                                <div class="flex-1 h-1 mx-2 rounded-full min-w-6
                                    @if($i < $currentStep || $transaction->status === 'selesai')
                                        bg-indigo-500
                                    @else
                                        bg-gray-200
                                    @endif">
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            @endif
        </div>

        {{-- CONTENT --}}
        <div class="mt-6 lg:grid lg:grid-cols-[1fr_380px] lg:gap-6 items-start">
            {{-- KOLOM KIRI: PRODUK --}}
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                            <i data-lucide="package" class="w-4 h-4 text-indigo-600"></i> Produk
                        </h2>
                    </div>
                    <div class="p-5">
                        <div class="flex items-start gap-4">
                            <a href="{{ route('products.show', $transaction->product->slug) }}" class="shrink-0">
                                <img src="{{ productImageUrl($transaction->product) }}"
                                     alt="{{ $transaction->product->name }}"
                                     class="w-28 h-28 rounded-xl object-cover bg-gray-100">
                            </a>
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('products.show', $transaction->product->slug) }}"
                                   class="font-bold text-gray-900 hover:text-indigo-600 transition">
                                    {{ $transaction->product->name }}
                                </a>
                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $transaction->product->condition === 'bekas' ? 'Bekas' : 'Baru' }}
                                    • {{ $transaction->product->district }}, {{ $transaction->product->city }}
                                </p>
                                <p class="mt-2 text-xl font-extrabold text-indigo-600">{{ formatRupiah($transaction->price) }}</p>
                            </div>
                        </div>
                        @if($transaction->note)
                            <div class="mt-4 rounded-xl bg-amber-50 border border-amber-200 p-3.5">
                                <p class="text-xs font-bold text-amber-700">Catatan Pembeli</p>
                                <p class="mt-1 text-sm text-amber-800 leading-relaxed">{{ $transaction->note }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- REVIEW --}}
                @if($transaction->status === 'selesai')
                    @if($myReview)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="p-5 border-b border-gray-100 flex items-center justify-between gap-3">
                                <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                                    <i data-lucide="star" class="w-4 h-4 text-amber-500"></i> Review Kamu
                                </h2>
                                <span class="text-xs text-gray-400">{{ $myReview->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             class="w-5 h-5 {{ $i <= $myReview->rating ? 'fill-amber-400 text-amber-400' : 'fill-gray-200 text-gray-200' }}"
                                             stroke="currentColor" stroke-width="1">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-sm font-bold text-gray-700">{{ $myReview->rating }}/5</span>
                                </div>
                                <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                                    {{ $myReview->comment ? $myReview->comment : '(Tanpa komentar)' }}
                                </p>
                            </div>
                        </div>
                    @endif

                    @if($theirReview)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="p-5 border-b border-gray-100 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <img src="{{ $theirReview->reviewer->avatar ?? 'https://i.pravatar.cc/150?u=' . $theirReview->reviewer_id }}"
                                         alt="{{ $theirReview->reviewer->name }}"
                                         class="w-9 h-9 rounded-full object-cover ring-2 ring-indigo-100 shrink-0">
                                    <div class="min-w-0">
                                        <h2 class="text-sm font-extrabold text-gray-900 truncate">
                                            Review dari {{ $theirReview->reviewer->name }}
                                        </h2>
                                        <span class="text-xs text-gray-400">{{ $theirReview->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             class="w-5 h-5 {{ $i <= $theirReview->rating ? 'fill-amber-400 text-amber-400' : 'fill-gray-200 text-gray-200' }}"
                                             stroke="currentColor" stroke-width="1">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-sm font-bold text-gray-700">{{ $theirReview->rating }}/5</span>
                                </div>
                                <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                                    {{ $theirReview->comment ? $theirReview->comment : '(Tanpa komentar)' }}
                                </p>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            {{-- KOLOM KANAN --}}
            <aside class="lg:sticky lg:top-20 mt-6 lg:mt-0 space-y-4">
                {{-- PEMBELI --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Pembeli</p>
                    <div class="mt-3 flex items-center gap-3">
                        <img src="{{ $transaction->buyer->avatar ?? 'https://i.pravatar.cc/150?u=' . $transaction->buyer->id }}"
                             alt="{{ $transaction->buyer->name }}"
                             class="w-11 h-11 rounded-full object-cover ring-2 ring-indigo-100">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $transaction->buyer->name }}</p>
                            <p class="text-xs text-gray-400">
                                <span class="text-amber-400">★</span>
                                {{ $transaction->buyer->rating > 0 ? number_format($transaction->buyer->rating, 1) : 'Baru' }}
                            </p>
                        </div>
                    </div>
                    @if(!$isBuyer && $transaction->buyer->phone)
                        <a href="{{ waLink($transaction->buyer->phone, 'Halo, saya pembeli transaksi #' . $transaction->id . ' di LokalMart.') }}"
                           target="_blank" rel="noopener"
                           class="mt-3 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-700 hover:border-emerald-300 hover:text-emerald-600 transition">
                            <i data-lucide="message-circle" class="w-4 h-4"></i> Chat Pembeli
                        </a>
                    @endif
                </div>

                {{-- PENJUAL --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Penjual</p>
                    <div class="mt-3 flex items-center gap-3">
                        <img src="{{ $transaction->seller->avatar ?? 'https://i.pravatar.cc/150?u=' . $transaction->seller->id }}"
                             alt="{{ $transaction->seller->name }}"
                             class="w-11 h-11 rounded-full object-cover ring-2 ring-indigo-100">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $transaction->seller->name }}</p>
                            <p class="text-xs text-gray-400">
                                <span class="text-amber-400">★</span>
                                {{ $transaction->seller->rating > 0 ? number_format($transaction->seller->rating, 1) : 'Baru' }}
                            </p>
                        </div>
                    </div>
                    @if(!$isSeller && $transaction->seller->phone)
                        <a href="{{ waLink($transaction->seller->phone, 'Halo, saya pembeli transaksi #' . $transaction->id . ' di LokalMart.') }}"
                           target="_blank" rel="noopener"
                           class="mt-3 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
                            <i data-lucide="message-circle" class="w-4 h-4"></i> Chat Penjual
                        </a>
                    @endif
                </div>

                {{-- DETAIL COD --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Detail COD</p>
                    <div class="mt-3 space-y-3">
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-indigo-500 mt-0.5 shrink-0"></i>
                            <div>
                                <p class="text-xs text-gray-400">Lokasi</p>
                                <p class="text-sm font-bold text-gray-900">{{ $transaction->cod_location }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="calendar" class="w-4 h-4 text-indigo-500 mt-0.5 shrink-0"></i>
                            <div>
                                <p class="text-xs text-gray-400">Tanggal</p>
                                <p class="text-sm font-bold text-gray-900">{{ $transaction->cod_date->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="clock" class="w-4 h-4 text-indigo-500 mt-0.5 shrink-0"></i>
                            <div>
                                <p class="text-xs text-gray-400">Waktu</p>
                                <p class="text-sm font-bold text-gray-900">{{ $transaction->cod_time }} WIB</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- HARGA --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Harga</p>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Harga barang</span>
                            <span class="font-semibold text-gray-800">{{ formatRupiah($transaction->price) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Biaya platform</span>
                            <span class="font-semibold text-gray-800">Gratis</span>
                        </div>
                        <div class="border-t border-gray-100 pt-2.5 flex items-center justify-between">
                            <span class="text-sm font-bold text-gray-900">Total</span>
                            <span class="text-lg font-extrabold text-indigo-600">{{ formatRupiah($transaction->price) }}</span>
                        </div>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-2.5">
                    @if($transaction->status === 'menunggu')
                        @if($isSeller)
                            <form action="{{ route('transactions.approve', $transaction) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold transition">
                                    <i data-lucide="check" class="w-4 h-4"></i> Setujui Transaksi
                                </button>
                            </form>
                            <form action="{{ route('transactions.reject', $transaction) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-sm font-bold transition">
                                    <i data-lucide="x" class="w-4 h-4"></i> Tolak
                                </button>
                            </form>
                        @elseif($isBuyer)
                            <form action="{{ route('transactions.cancel', $transaction) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-amber-200 text-amber-700 hover:bg-amber-50 text-sm font-bold transition">
                                    <i data-lucide="ban" class="w-4 h-4"></i> Batalkan Transaksi
                                </button>
                            </form>
                        @endif
                    @elseif($transaction->status === 'disetujui')
                        <div class="rounded-xl bg-blue-50 border border-blue-200 p-3.5 text-center">
                            <p class="text-xs font-bold text-blue-700">Menunggu jadwal COD</p>
                            <p class="mt-1 text-xs text-blue-500">Sepakati detail COD melalui WhatsApp.</p>
                        </div>
                    @elseif($transaction->status === 'menunggu_cod')
                        <form action="{{ route('transactions.complete', $transaction) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition">
                                <i data-lucide="check-circle" class="w-4 h-4"></i> Transaksi Selesai
                            </button>
                        </form>
                        <p class="text-[11px] text-gray-400 text-center">Klik setelah barang diterima & pembayaran COD dilakukan.</p>
                    @elseif($transaction->status === 'selesai')
                        <div class="rounded-xl bg-green-50 border border-green-200 p-3.5 text-center">
                            <p class="text-xs font-bold text-green-700">Transaksi Selesai</p>
                            <p class="mt-1 text-xs text-green-600">Terima kasih sudah bertransaksi di LokalMart!</p>
                        </div>
                        @if($canReview)
                            <button type="button" @click="ratingModalOpen = true"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition">
                                ⭐ Beri Rating
                            </button>
                        @elseif($myReview)
                            <div class="rounded-xl bg-amber-50 border border-amber-200 p-3.5">
                                <p class="text-xs font-bold text-amber-700 text-center">Review Kamu</p>
                                <div class="mt-2 flex items-center justify-center gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             class="w-4 h-4 {{ $i <= $myReview->rating ? 'fill-amber-400 text-amber-400' : 'fill-gray-200 text-gray-200' }}"
                                             stroke="currentColor" stroke-width="1">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                        </svg>
                                    @endfor
                                </div>
                                <p class="mt-1.5 text-[11px] text-amber-800 leading-relaxed">
                                    {{ $myReview->comment ? $myReview->comment : '(Tanpa komentar)' }}
                                </p>
                                <p class="mt-1 text-[10px] text-amber-600 text-center">{{ $myReview->created_at->format('d M Y') }}</p>
                            </div>
                        @endif
                    @elseif($transaction->status === 'ditolak')
                        <div class="rounded-xl bg-red-50 border border-red-200 p-3.5 text-center">
                            <p class="text-xs font-bold text-red-700">Transaksi Ditolak / Dibatalkan</p>
                        </div>
                    @endif

                    <a href="{{ route('transactions.index') }}"
                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-700 hover:border-indigo-300 hover:text-indigo-600 transition">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
                    </a>
                </div>
            </aside>
        </div>

        {{-- RATING MODAL --}}
        <x-rating-modal :transaction="$transaction" />
    </div>
@endsection
