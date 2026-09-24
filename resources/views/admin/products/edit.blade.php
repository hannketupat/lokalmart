@extends('layouts.admin')

@section('title', 'Edit Produk - Admin Panel')

@section('page-title', 'Edit Produk')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Produk: {{ $product->name }}</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" name="name" value="{{ $product->name }}" required
                       class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="4" required
                          class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ $product->description }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                <input type="number" name="price" value="{{ $product->price }}" required min="0"
                       class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" required
                            class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="sold" {{ $product->status === 'sold' ? 'selected' : '' }}>Terjual</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>
                    <select name="condition" required
                            class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="baru" {{ $product->condition === 'baru' ? 'selected' : '' }}>Baru</option>
                        <option value="bekas" {{ $product->condition === 'bekas' ? 'selected' : '' }}>Bekas</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                    <input type="text" name="city" value="{{ $product->city }}" required
                           class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                    <input type="text" name="province" value="{{ $product->province }}" required
                           class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition">Simpan</button>
                <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection