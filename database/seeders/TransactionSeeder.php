<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::where('status', 'active')->get();
        $users = User::where('role', 'user')->get();

        $locations = [
            'Pasar Tradisional Kota',
            'Mal Pusat Perbelanjaan',
            'Stasiun Kereta Api',
            'Terminal Bus',
            'Alun-alun Kota',
            'Taman Kota Pusat',
            'Pusat Kuliner Malam',
            'Kampus Universitas',
        ];

        $statuses = ['menunggu', 'disetujui', 'menunggu_cod', 'selesai', 'selesai', 'selesai', 'ditolak'];
        $notes = [
            'Bisa COD hari ini?',
            'Tolong cek kondisi barang dulu ya',
            'Bisa nego tipis?',
            'Saya ambil 2 pcs kalau ada',
            'Lokasi COD bisa diubah?',
            'Barang masih ada?',
            null,
            null,
        ];

        // Buat 10 transaksi
        for ($i = 0; $i < 10; $i++) {
            $product = $products->random();
            $buyer = $users->where('id', '!=', $product->user_id)->random();
            $seller = $product->user;

            $status = $statuses[array_rand($statuses)];
            $createdAt = now()->subDays(rand(1, 30));

            Transaction::create([
                'product_id' => $product->id,
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
                'price' => $product->price,
                'cod_location' => $locations[array_rand($locations)],
                'cod_date' => $createdAt->copy()->addDays(rand(1, 3))->format('Y-m-d'),
                'cod_time' => rand(9, 20) . ':00',
                'note' => $notes[array_rand($notes)],
                'status' => $status,
                'created_at' => $createdAt,
            ]);

            // Update total transaksi user
            if ($status === 'selesai') {
                $seller->increment('total_transactions');
                $buyer->increment('total_transactions');
            }
        }
    }
}