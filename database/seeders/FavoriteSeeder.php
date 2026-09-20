<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        // Setiap user favorite 2-5 produk random
        foreach ($users as $user) {
            $favoriteCount = rand(2, 5);
            $randomProducts = $products->random($favoriteCount);

            foreach ($randomProducts as $product) {
                // Skip jika produk milik sendiri
                if ($product->user_id !== $user->id) {
                    Favorite::create([
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                    ]);
                }
            }
        }
    }
}