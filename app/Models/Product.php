<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'condition',
        'province',
        'city',
        'district',
        'image',
        'status',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    // Relasi: Produk milik user (penjual)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Produk punya kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Produk punya banyak transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Relasi: Produk punya banyak chat
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    // Relasi: Produk punya banyak report
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Relasi: Produk di-favorite oleh banyak user
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    // Relasi: Favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Helper: Cek apakah produk di-favorite user tertentu
    public function isFavoritedBy(?int $userId): bool
    {
        if (! $userId) {
            return false;
        }

        return Favorite::where('user_id', $userId)
            ->where('product_id', $this->id)
            ->exists();
    }

    // Scope: Produk aktif saja
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope: Produk tersedia (belum terjual)
    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')->where('status', '!=', 'sold');
    }

    // Helper: Format harga
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}