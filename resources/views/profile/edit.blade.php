<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- RATING & REVIEWS --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Rating & Review</h2>
                    <p class="mt-1 text-sm text-gray-600">Rata-rata penilaian yang kamu terima dari transaksi selesai.</p>

                    <div class="mt-4 flex items-center gap-3">
                        <span class="text-4xl font-extrabold text-gray-900">
                            {{ number_format((float) $user->rating, 1) }}
                        </span>
                        <div>
                            <div class="flex items-center gap-0.5">
                                @php $avg = (int) round((float) $user->rating); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         class="w-5 h-5 {{ $i <= $avg ? 'fill-amber-400 text-amber-400' : 'fill-gray-200 text-gray-200' }}"
                                         stroke="currentColor" stroke-width="1">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="mt-0.5 text-xs text-gray-500">
                                {{ $receivedReviews->count() }} review diterima
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 space-y-3">
                        @forelse($receivedReviews as $review)
                            <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <img src="{{ $review->reviewer->avatar ?? 'https://i.pravatar.cc/150?u=' . $review->reviewer_id }}"
                                             alt="{{ $review->reviewer->name }}"
                                             class="w-8 h-8 rounded-full object-cover shrink-0">
                                        <span class="text-sm font-bold text-gray-900 truncate">{{ $review->reviewer->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 shrink-0">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 class="w-4 h-4 {{ $i <= $review->rating ? 'fill-amber-400 text-amber-400' : 'fill-gray-200 text-gray-200' }}"
                                                 stroke="currentColor" stroke-width="1">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                    {{ $review->comment ? $review->comment : '(Tanpa komentar)' }}
                                </p>
                                <p class="mt-1.5 text-xs text-gray-400">{{ $review->created_at->format('d M Y') }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Belum ada review.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
