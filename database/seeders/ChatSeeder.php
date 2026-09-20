<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::limit(5)->get();
        $users = User::where('role', 'user')->get();

        $chatMessages = [
            'Halo, barang masih ada?',
            'Masih ready kak, silakan diorder',
            'Bisa nego tidak?',
            'Harga sudah pas kak, tapi kalau ambil banyak bisa kurang',
            'Kondisi barang bagaimana?',
            'Kondisi 90% mulus kak, minus pemakaian wajar',
            'Bisa COD dimana?',
            'Bisa COD di alun-alun atau stasiun kak',
            'Oke, saya ambil ya',
            'Siap kak, ditunggu orderannya',
            'Sudah saya transfer',
            'Baik kak, akan segera diproses',
        ];

        foreach ($products as $product) {
            $buyer = $users->where('id', '!=', $product->user_id)->random();
            $seller = $product->user;

            // Buat chat
            $chat = Chat::create([
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
                'product_id' => $product->id,
                'last_message_at' => now()->subHours(rand(1, 48)),
            ]);

            // Buat 4-8 pesan per chat
            $messageCount = rand(4, 8);
            for ($i = 0; $i < $messageCount; $i++) {
                $sender = $i % 2 === 0 ? $buyer : $seller;
                
                Message::create([
                    'chat_id' => $chat->id,
                    'sender_id' => $sender->id,
                    'message' => $chatMessages[array_rand($chatMessages)],
                    'is_read' => $i < $messageCount - 2, // Pesan terakhir belum dibaca
                    'created_at' => now()->subHours($messageCount - $i),
                ]);
            }
        }
    }
}