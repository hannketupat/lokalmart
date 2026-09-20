<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil transaksi yang selesai
        $completedTransactions = Transaction::where('status', 'selesai')->get();

        $positiveComments = [
            'Barang sesuai deskripsi, seller ramah dan responsif. Recommended!',
            'Packing rapi, barang berkualitas. Terima kasih!',
            'Pengiriman cepat, produk original. Puas banget!',
            'Seller sangat kooperatif, barang sesuai foto. Mantap!',
            'Kualitas bagus untuk harga segini. Pasti repeat order!',
            'Barang sampai dengan selamat, kondisi sesuai ekspektasi.',
        ];

        $neutralComments = [
            'Barang oke, tapi pengiriman agak lama.',
            'Sesuai deskripsi, cukup memuaskan.',
            'Lumayan untuk harga segini.',
        ];

        foreach ($completedTransactions as $transaction) {
            // Buyer review seller (80% kemungkinan)
            if (rand(1, 100) <= 80) {
                $rating = rand(4, 5);
                $comment = $positiveComments[array_rand($positiveComments)];

                Review::create([
                    'transaction_id' => $transaction->id,
                    'reviewer_id' => $transaction->buyer_id,
                    'reviewed_id' => $transaction->seller_id,
                    'rating' => $rating,
                    'comment' => $comment,
                ]);
            }

            // Seller review buyer (50% kemungkinan)
            if (rand(1, 100) <= 50) {
                $rating = rand(4, 5);
                $comment = $positiveComments[array_rand($positiveComments)];

                Review::create([
                    'transaction_id' => $transaction->id,
                    'reviewer_id' => $transaction->seller_id,
                    'reviewed_id' => $transaction->buyer_id,
                    'rating' => $rating,
                    'comment' => 'Pembeli ramah dan cepat transaksi. Recommended!',
                ]);
            }
        }

        // Update rating semua user
        $users = User::where('role', 'user')->get();
        foreach ($users as $user) {
            $user->updateRating();
        }
    }
}