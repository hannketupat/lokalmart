<?php

if (! function_exists('formatRupiah')) {
    function formatRupiah($angka): string
    {
        return 'Rp' . number_format((float) $angka, 0, ',', '.');
    }
}

if (! function_exists('timeAgo')) {
    function timeAgo($timestamp): string
    {
        $time = $timestamp instanceof DateTimeInterface
            ? $timestamp
            : Carbon\Carbon::parse($timestamp);

        $seconds = max(0, (int) $time->diffInSeconds());

        $units = [
            31536000 => 'tahun',
            2592000 => 'bulan',
            604800 => 'minggu',
            86400 => 'hari',
            3600 => 'jam',
            60 => 'menit',
        ];

        foreach ($units as $divisor => $label) {
            if ($seconds >= $divisor) {
                return (int) floor($seconds / $divisor) . ' ' . $label . ' lalu';
            }
        }

        return 'baru saja';
    }
}

if (! function_exists('productImageUrl')) {
    function productImageUrl($product): string
    {
        $image = $product->image ?? 'https://picsum.photos/seed/' . $product->slug . '/600/600';

        if (! empty($image) && ! str_starts_with($image, 'http')) {
            return asset('storage/' . $image);
        }

        return $image;
    }
}

if (! function_exists('normalizePhone')) {
    function normalizePhone($phone): string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        return $digits;
    }
}

if (! function_exists('waLink')) {
    function waLink($phone, ?string $message = null): string
    {
        $number = normalizePhone($phone);

        $url = 'https://wa.me/' . $number;

        if (! empty($message)) {
            $url .= '?text=' . urlencode($message);
        }

        return $url;
    }
}

if (! function_exists('waProductMessage')) {
    function waProductMessage($product): string
    {
        return 'Halo, saya tertarik dengan produk "' . $product->name . '" ('
            . formatRupiah($product->price) . ') di LokalMart. Apakah masih tersedia?';
    }
}