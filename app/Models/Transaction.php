<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buyer_id',
        'seller_id',
        'price',
        'cod_location',
        'cod_date',
        'cod_time',
        'note',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'cod_date' => 'date',
        ];
    }

    // Relasi: Transaksi milik satu produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Pembeli
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // Relasi: Penjual
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // Relasi: Reviews untuk transaksi ini
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}