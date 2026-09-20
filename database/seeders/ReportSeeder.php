<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        $reasons = [
            'Produk tidak sesuai deskripsi',
            'Harga tidak wajar / mark up terlalu tinggi',
            'Foto produk tidak asli',
            'Diduga penipuan',
            'Produk ilegal atau dilarang',
        ];

        $statuses = ['pending', 'diproses', 'selesai', 'ditolak'];

        // Buat 5 laporan random
        for ($i = 0; $i < 5; $i++) {
            $product = $products->random();
            $reporter = $users->where('id', '!=', $product->user_id)->random();

            Report::create([
                'product_id' => $product->id,
                'reporter_id' => $reporter->id,
                'reason' => $reasons[array_rand($reasons)],
                'status' => $statuses[array_rand($statuses)],
            ]);
        }
    }
}