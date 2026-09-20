<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            TransactionSeeder::class,
            ChatSeeder::class,
            ReviewSeeder::class,
            FavoriteSeeder::class,
            ReportSeeder::class,
        ]);
    }
}