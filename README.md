# 🛒 LokalMart

Local marketplace for buying and selling with Cash on Delivery (COD). Focus: help users find items nearby and transact safely.

## ✨ Features

- 🔐 Custom Auth — Login & register with cascading location dropdown
- 🏠 Personalized Homepage — Recommendations based on user's city
- 🔍 Explore with Filters — Search by category, location, price, condition
- 📍 Location-Based — Location filter as a core feature
- 📱 Responsive — Desktop, tablet, mobile
- 🎨 Modern UI — Tailwind CSS, rounded corners, soft shadows

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 11 |
| Database | MySQL |
| Frontend | Blade + Tailwind CSS (CDN) |
| Interactivity | Alpine.js + Vanilla JS |
| Icons | Lucide Icons |
| Font | Plus Jakarta Sans |

## 🚧 Development Status

| Step | Feature | Status |
|------|---------|--------|
| 1 | Laravel setup + Breeze + Tailwind CDN | ✅ |
| 2 | Migration, Model, Seeder | ✅ |
| 3 | Layout + Landing Page | ✅ |
| 4 | Custom Auth (Login & Register) | ✅ |
| 5 | Homepage + Explore | ✅ |
| 6 | Product Detail + Sell Item | ✅ |
| 7 | Chat + COD Request | ✅ |
| 8 | Transaction + Review | ✅ |
| 9 | Favorites + Notifications + Profile | ✅ |
| 10 | Admin Panel | ✅ |
| 11 | Responsive Polish | ✅ |

## 🚀 Installation

### Prerequisites

- PHP 8.2+
- Composer
- MySQL (or Laragon)
- Git

### Steps

```bash
git clone https://github.com/hannketupat/lokalmart.git
cd lokalmart
composer install
cp .env.example .env
php artisan key:generate
# Setup database in .env (DB_DATABASE=lokalmart)
php artisan migrate --seed
php artisan serve
```

## 📸 Screenshots

- Landing Page — hero dengan pencarian lokasi & produk unggulan
- Homepage — rekomendasi produk berdasarkan kota pengguna
- Explore — filter kategori, lokasi, harga, dan kondisi
- Product Detail — galeri foto, info penjual, tombol Chat WhatsApp & COD
- Sell Item — form unggah produk dengan drag & drop foto
- Favorites & Notifications — simpan produk favorit dan pantau aktivitas
- Admin Panel — dashboard, produk, pengguna, transaksi, laporan, pengaturan

## 🎬 Demo

Akses aplikasi pada `http://localhost/lokalmart/public` (Laragon) atau `php artisan serve`.

Akun demo:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@lokalmart.test | password |
| User | user@lokalmart.test | password |