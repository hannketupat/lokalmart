<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan & Minuman', 'icon' => 'utensils'],
            ['name' => 'Fashion & Pakaian', 'icon' => 'shirt'],
            ['name' => 'Kerajinan Tangan', 'icon' => 'palette'],
            ['name' => 'Pertanian & Hasil Bumi', 'icon' => 'leaf'],
            ['name' => 'Elektronik', 'icon' => 'smartphone'],
            ['name' => 'Rumah Tangga', 'icon' => 'home'],
            ['name' => 'Kecantikan & Perawatan', 'icon' => 'sparkles'],
            ['name' => 'Otomotif', 'icon' => 'car'],
            ['name' => 'Buku & Media', 'icon' => 'book'],
            ['name' => 'Jasa & Layanan', 'icon' => 'wrench'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
            ]);
        }
    }
}