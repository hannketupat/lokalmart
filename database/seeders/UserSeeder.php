<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin LokalMart',
            'email' => 'admin@lokalmart.id',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'role' => 'admin',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Kebayoran Baru',
            'avatar' => 'https://i.pravatar.cc/150?img=1',
            'rating' => 5.00,
            'total_transactions' => 0,
            'joined_at' => now(),
        ]);

        // Users realistis Indonesia
        $users = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'phone' => '081234567801',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'district' => 'Coblong',
                'avatar' => 'https://i.pravatar.cc/150?img=12',
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti@example.com',
                'phone' => '081234567802',
                'province' => 'Jawa Tengah',
                'city' => 'Semarang',
                'district' => 'Tembalang',
                'avatar' => 'https://i.pravatar.cc/150?img=47',
            ],
            [
                'name' => 'Ahmad Wijaya',
                'email' => 'ahmad@example.com',
                'phone' => '081234567803',
                'province' => 'Jawa Timur',
                'city' => 'Surabaya',
                'district' => 'Gubeng',
                'avatar' => 'https://i.pravatar.cc/150?img=33',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'phone' => '081234567804',
                'province' => 'Bali',
                'city' => 'Denpasar',
                'district' => 'Denpasar Selatan',
                'avatar' => 'https://i.pravatar.cc/150?img=45',
            ],
            [
                'name' => 'Rizky Pratama',
                'email' => 'rizky@example.com',
                'phone' => '081234567805',
                'province' => 'Sumatera Utara',
                'city' => 'Medan',
                'district' => 'Medan Kota',
                'avatar' => 'https://i.pravatar.cc/150?img=15',
            ],
            [
                'name' => 'Maya Putri',
                'email' => 'maya@example.com',
                'phone' => '081234567806',
                'province' => 'Yogyakarta',
                'city' => 'Yogyakarta',
                'district' => 'Mergangsan',
                'avatar' => 'https://i.pravatar.cc/150?img=44',
            ],
            [
                'name' => 'Andi Kurniawan',
                'email' => 'andi@example.com',
                'phone' => '081234567807',
                'province' => 'Sulawesi Selatan',
                'city' => 'Makassar',
                'district' => 'Mamajang',
                'avatar' => 'https://i.pravatar.cc/150?img=53',
            ],
            [
                'name' => 'Rina Marlina',
                'email' => 'rina@example.com',
                'phone' => '081234567808',
                'province' => 'Jawa Barat',
                'city' => 'Bogor',
                'district' => 'Bogor Tengah',
                'avatar' => 'https://i.pravatar.cc/150?img=26',
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar@example.com',
                'phone' => '081234567809',
                'province' => 'Jawa Timur',
                'city' => 'Malang',
                'district' => 'Klojen',
                'avatar' => 'https://i.pravatar.cc/150?img=61',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password'),
                'phone' => $user['phone'],
                'role' => 'user',
                'province' => $user['province'],
                'city' => $user['city'],
                'district' => $user['district'],
                'avatar' => $user['avatar'],
                'rating' => 0,
                'total_transactions' => 0,
                'joined_at' => now()->subDays(rand(30, 365)),
            ]);
        }
    }
}