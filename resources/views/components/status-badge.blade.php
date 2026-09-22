@props(['status'])

@php
    $statusClasses = [
        'menunggu' => 'bg-amber-100 text-amber-700',
        'disetujui' => 'bg-blue-100 text-blue-700',
        'menunggu_cod' => 'bg-indigo-100 text-indigo-700',
        'selesai' => 'bg-green-100 text-green-700',
        'ditolak' => 'bg-red-100 text-red-700',
    ];

    $statusLabels = [
        'menunggu' => 'Menunggu Persetujuan',
        'disetujui' => 'Disetujui',
        'menunggu_cod' => 'Menunggu COD',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
    ];

    $class = $statusClasses[$status] ?? 'bg-gray-100 text-gray-700';
    $label = $statusLabels[$status] ?? ucfirst($status);
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $class }}">
    {{ $label }}
</span>