<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $categories = Category::all();

        $products = [
            // Makanan & Minuman
            [
                'name' => 'Kopi Arabika Gayo Premium 250g',
                'description' => 'Kopi arabika asli dari dataran tinggi Gayo, Aceh. Dipetik secara manual dan diolah dengan proses natural. Memiliki cita rasa fruity dengan notes cokelat dan karamel.',
                'price' => 85000,
                'condition' => 'baru',
                'category' => 'Makanan & Minuman',
                'city' => 'Bandung',
            ],
            [
                'name' => 'Rendang Daging Sapi Asli Minang 500g',
                'description' => 'Rendang daging sapi premium dimasak dengan rempah asli Minangkabau selama 8 jam. Daging empuk, bumbu meresap sempurna. Tanpa pengawet.',
                'price' => 120000,
                'condition' => 'baru',
                'category' => 'Makanan & Minuman',
                'city' => 'Medan',
            ],
            [
                'name' => 'Keripik Singkong Balado Pedas 250g',
                'description' => 'Keripik singkong renyah dengan bumbu balado pedas manis khas Minang. Dibuat dari singkong pilihan, digoreng hingga garing sempurna.',
                'price' => 25000,
                'condition' => 'baru',
                'category' => 'Makanan & Minuman',
                'city' => 'Surabaya',
            ],
            [
                'name' => 'Sambal Bawang Merah Homemade',
                'description' => 'Sambal bawang merah pedas dengan level kepedasan bisa request. Dibuat fresh setiap hari tanpa pengawet dan MSG.',
                'price' => 35000,
                'condition' => 'baru',
                'category' => 'Makanan & Minuman',
                'city' => 'Semarang',
            ],
            // Fashion
            [
                'name' => 'Batik Tulis Madura Motif Parang',
                'description' => 'Batik tulis asli Madura dengan motif parang klasik. Dibuat dengan canting dan malam asli, proses pembuatan 2 minggu. Kain katun primisima.',
                'price' => 450000,
                'condition' => 'baru',
                'category' => 'Fashion & Pakaian',
                'city' => 'Yogyakarta',
            ],
            [
                'name' => 'Kaos Polos Katun Combed 30s',
                'description' => 'Kaos polos premium bahan katun combed 30s, adem dan nyaman dipakai. Tersedia berbagai warna dan ukuran S-XXL.',
                'price' => 75000,
                'condition' => 'baru',
                'category' => 'Fashion & Pakaian',
                'city' => 'Bandung',
            ],
            [
                'name' => 'Tas Rajut Handmade Anyaman Pandan',
                'description' => 'Tas rajut handmade dari anyaman pandan asli. Cocok untuk acara kasual maupun formal. Ukuran medium dengan furing kain katun.',
                'price' => 185000,
                'condition' => 'baru',
                'category' => 'Fashion & Pakaian',
                'city' => 'Denpasar',
            ],
            [
                'name' => 'Sepatu Sneakers Lokal Brand',
                'description' => 'Sneakers casual dengan desain minimalis. Bahan canvas premium, sol karet vulkanisir. Nyaman untuk daily wear.',
                'price' => 275000,
                'condition' => 'baru',
                'category' => 'Fashion & Pakaian',
                'city' => 'Jakarta Selatan',
            ],
            // Kerajinan
            [
                'name' => 'Ukiran Kayu Jati Motif Wayang',
                'description' => 'Ukiran kayu jati tua dengan motif wayang kulit. Dikerjakan oleh perajin berpengalaman 20 tahun. Cocok untuk dekorasi rumah.',
                'price' => 750000,
                'condition' => 'baru',
                'category' => 'Kerajinan Tangan',
                'city' => 'Yogyakarta',
            ],
            [
                'name' => 'Gerabah Kasongan Set Teh',
                'description' => 'Set teh dari gerabah kasongan dengan glasir natural. Terdiri dari teko dan 4 cangkir. Setiap piece unik karena handmade.',
                'price' => 220000,
                'condition' => 'baru',
                'category' => 'Kerajinan Tangan',
                'city' => 'Yogyakarta',
            ],
            [
                'name' => 'Anyaman Bambu Keranjang Multifungsi',
                'description' => 'Keranjang anyaman bambu untuk berbagai keperluan. Bisa untuk tempat laundry, mainan anak, atau dekorasi. Tahan lama dan ramah lingkungan.',
                'price' => 95000,
                'condition' => 'baru',
                'category' => 'Kerajinan Tangan',
                'city' => 'Bogor',
            ],
            // Pertanian
            [
                'name' => 'Madu Hutan Sumbawa Murni 500ml',
                'description' => 'Madu hutan murni dari Sumbawa, NTB. Dipanen langsung dari sarang lebah liar di hutan. Kaya akan nutrisi dan enzim alami.',
                'price' => 150000,
                'condition' => 'baru',
                'category' => 'Pertanian & Hasil Bumi',
                'city' => 'Makassar',
            ],
            [
                'name' => 'Gula Aren Asli Organik 1kg',
                'description' => 'Gula aren murni tanpa campuran dari nira aren pilihan. Proses tradisional tanpa bahan kimia. Manis alami dan sehat.',
                'price' => 45000,
                'condition' => 'baru',
                'category' => 'Pertanian & Hasil Bumi',
                'city' => 'Bogor',
            ],
            [
                'name' => 'Teh Hijau Organik Kebun Sendiri',
                'description' => 'Teh hijau organik dari kebun sendiri di pegunungan. Tanpa pestisida, proses pengeringan alami. Kaya antioksidan.',
                'price' => 68000,
                'condition' => 'baru',
                'category' => 'Pertanian & Hasil Bumi',
                'city' => 'Malang',
            ],
            // Elektronik
            [
                'name' => 'Speaker Bluetooth Portable Mini',
                'description' => 'Speaker bluetooth mini dengan suara jernih dan bass mantap. Baterai tahan 8 jam, tahan air IPX5. Cocok untuk outdoor.',
                'price' => 185000,
                'condition' => 'baru',
                'category' => 'Elektronik',
                'city' => 'Jakarta Selatan',
            ],
            [
                'name' => 'Powerbank 20000mAh Fast Charging',
                'description' => 'Powerbank kapasitas besar 20000mAh dengan fast charging 22.5W. Dual output, bisa charge 2 device sekaligus.',
                'price' => 245000,
                'condition' => 'baru',
                'category' => 'Elektronik',
                'city' => 'Surabaya',
            ],
            // Rumah Tangga
            [
                'name' => 'Sarung Bantal Kain Tenun Ikat',
                'description' => 'Sarung bantal dari kain tenun ikat asli NTT. Motif tradisional dengan warna alami. Set isi 2 piece.',
                'price' => 125000,
                'condition' => 'baru',
                'category' => 'Rumah Tangga',
                'city' => 'Denpasar',
            ],
            [
                'name' => 'Lampu Hias Rotan Gantung',
                'description' => 'Lampu hias gantung dari anyaman rotan alami. Memberikan suasana warm dan cozy di ruangan. Include kabel dan fitting.',
                'price' => 165000,
                'condition' => 'baru',
                'category' => 'Rumah Tangga',
                'city' => 'Semarang',
            ],
            // Kecantikan
            [
                'name' => 'Sabun Cuci Muka Herbal Daun Sirih',
                'description' => 'Sabun cuci muka herbal dengan ekstrak daun sirih dan tea tree. Cocok untuk kulit berjerawat, membersihkan hingga ke pori-pori.',
                'price' => 35000,
                'condition' => 'baru',
                'category' => 'Kecantikan & Perawatan',
                'city' => 'Medan',
            ],
            [
                'name' => 'Minyak Kelapa VCO Organik 250ml',
                'description' => 'Virgin Coconut Oil murni dari kelapa segar. Cold pressed, tanpa pemutih dan pem fragrance. Bisa untuk masak dan perawatan.',
                'price' => 55000,
                'condition' => 'baru',
                'category' => 'Kecantikan & Perawatan',
                'city' => 'Makassar',
            ],
            // Otomotif
            [
                'name' => 'Cover Motor Waterproof Premium',
                'description' => 'Cover motor bahan polyester waterproof dengan lapisan silver. Melindungi dari hujan dan panas. Tersedia semua ukuran.',
                'price' => 85000,
                'condition' => 'baru',
                'category' => 'Otomotif',
                'city' => 'Malang',
            ],
            // Buku
            [
                'name' => 'Buku Resep Masakan Nusantara',
                'description' => 'Kumpulan 100 resep masakan tradisional dari seluruh Indonesia. Dilengkapi foto step-by-step dan tips dari chef lokal.',
                'price' => 95000,
                'condition' => 'baru',
                'category' => 'Buku & Media',
                'city' => 'Yogyakarta',
            ],
        ];

        foreach ($products as $index => $productData) {
            $seller = $users->random();
            $category = $categories->where('name', $productData['category'])->first();

            Product::create([
                'user_id' => $seller->id,
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']) . '-' . rand(1000, 9999),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'condition' => $productData['condition'],
                'province' => $seller->province,
                'city' => $productData['city'],
                'district' => $seller->district,
                'image' => 'https://picsum.photos/seed/product' . ($index + 1) . '/600/600',
                'status' => 'active',
                'views' => rand(50, 2000),
                'created_at' => now()->subDays(rand(1, 60)),
            ]);
        }

        $pendingProducts = [
            [
                'name' => 'Kain Tenun Troso Jepara Premium',
                'description' => 'Kain tenun troso asli Jepara dengan motif geometris modern. Bahan katun premium, nyaman dipakai.',
                'price' => 280000,
                'condition' => 'baru',
                'category' => 'Fashion & Pakaian',
                'city' => 'Semarang',
            ],
            [
                'name' => 'Keripik Pisang Coklat Homemade',
                'description' => 'Keripik pisang manis dengan lapisan coklat premium. Renyah dan gurih.',
                'price' => 30000,
                'condition' => 'baru',
                'category' => 'Makanan & Minuman',
                'city' => 'Bandung',
            ],
            [
                'name' => 'Lilin Aromaterapi Sereh Wangi',
                'description' => 'Lilin aromaterapi dengan ekstrak sereh wangi untuk relaksasi.',
                'price' => 65000,
                'condition' => 'baru',
                'category' => 'Rumah Tangga',
                'city' => 'Yogyakarta',
            ],
        ];

        foreach ($pendingProducts as $index => $productData) {
            $seller = $users->random();
            $category = $categories->where('name', $productData['category'])->first();

            Product::create([
                'user_id' => $seller->id,
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']) . '-pending-' . rand(1000, 9999),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'condition' => $productData['condition'],
                'province' => $seller->province,
                'city' => $productData['city'],
                'district' => $seller->district,
                'image' => 'https://picsum.photos/seed/product-pending' . ($index + 1) . '/600/600',
                'status' => 'pending',
                'rejection_reason' => null,
                'views' => 0,
                'created_at' => now(),
            ]);
        }

        $rejectedProducts = [
            [
                'name' => 'Lukisan Akrilik Pemandangan',
                'description' => 'Lukisan akrilik di kanvas.',
                'price' => 500000,
                'condition' => 'baru',
                'category' => 'Kerajinan Tangan',
                'city' => 'Denpasar',
                'rejection_reason' => 'Foto tidak jelas',
            ],
            [
                'name' => 'Sambal Bawang Premium',
                'description' => 'Sambal enak.',
                'price' => 40000,
                'condition' => 'baru',
                'category' => 'Makanan & Minuman',
                'city' => 'Surabaya',
                'rejection_reason' => 'Deskripsi tidak lengkap',
            ],
            [
                'name' => 'Kursi Kayu Jati Antik',
                'description' => 'Kursi kayu jati dengan ukiran klasik, cocok untuk ruang tamu.',
                'price' => 1200000,
                'condition' => 'bekas',
                'category' => 'Elektronik',
                'city' => 'Jakarta Selatan',
                'rejection_reason' => 'Kategori salah',
            ],
        ];

        foreach ($rejectedProducts as $index => $productData) {
            $seller = $users->random();
            $category = $categories->where('name', $productData['category'])->first();

            Product::create([
                'user_id' => $seller->id,
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']) . '-rejected-' . rand(1000, 9999),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'condition' => $productData['condition'],
                'province' => $seller->province,
                'city' => $productData['city'],
                'district' => $seller->district,
                'image' => 'https://picsum.photos/seed/product-rejected' . ($index + 1) . '/600/600',
                'status' => 'rejected',
                'rejection_reason' => $productData['rejection_reason'],
                'views' => 0,
                'created_at' => now(),
            ]);
        }
    }
}