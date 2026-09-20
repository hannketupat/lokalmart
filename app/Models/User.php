<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'province',
        'city',
        'district',
        'avatar',
        'rating',
        'total_transactions',
        'joined_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'joined_at' => 'datetime',
            'password' => 'hashed',
            'rating' => 'decimal:2',
        ];
    }

    // Relasi: User punya banyak produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Relasi: User sebagai pembeli
    public function buyerTransactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    // Relasi: User sebagai penjual
    public function sellerTransactions()
    {
        return $this->hasMany(Transaction::class, 'seller_id');
    }

    // Relasi: Chat sebagai pembeli
    public function buyerChats()
    {
        return $this->hasMany(Chat::class, 'buyer_id');
    }

    // Relasi: Chat sebagai penjual
    public function sellerChats()
    {
        return $this->hasMany(Chat::class, 'seller_id');
    }

    // Relasi: Messages yang dikirim
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Relasi: Reports yang dibuat
    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    // Relasi: Reviews yang diberikan
    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    // Relasi: Reviews yang diterima
    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'reviewed_id');
    }

    // Relasi: Favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Relasi: Produk yang di-favorite
    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorites');
    }

    // Helper: Cek apakah admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Helper: Update rating rata-rata
    public function updateRating(): void
    {
        $avgRating = $this->receivedReviews()->avg('rating') ?? 0;
        $this->update(['rating' => round($avgRating, 2)]);
    }
}