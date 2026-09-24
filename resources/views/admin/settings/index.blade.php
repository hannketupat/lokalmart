@extends('layouts.admin')

@section('title', 'Pengaturan - Admin Panel')

@section('page-title', 'Pengaturan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 px-4 md:px-0">
        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Pengaturan Aplikasi</h1>
        <p class="mt-1 text-sm text-gray-500">Kelola pengaturan umum aplikasi LokalMart.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Situs</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Situs</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}"
                               class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="site_description" rows="3"
                                  class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ $settings['site_description'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Kontak</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}"
                               class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}"
                               class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Produk</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Maksimal Gambar per Produk</label>
                        <input type="number" name="max_images_per_product" value="{{ $settings['max_images_per_product'] ?? 5 }}" min="1" max="10"
                               class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Maksimal Ukuran File (KB)</label>
                        <input type="number" name="max_file_size" value="{{ $settings['max_file_size'] ?? 2048 }}" min="100"
                               class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="auto_approve_products" {{ ($settings['auto_approve_products'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label class="text-sm text-gray-700">Auto-approve produk baru</label>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Mode Pemeliharaan</h2>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="maintenance_mode" {{ ($settings['maintenance_mode'] ?? false) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label class="text-sm text-gray-700">Aktifkan mode pemeliharaan</label>
                </div>
                <p class="mt-2 text-xs text-gray-500">Saat aktif, pengguna non-admin tidak dapat mengakses situs.</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>
@endsection