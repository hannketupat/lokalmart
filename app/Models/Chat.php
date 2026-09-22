<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'product_id',
        'last_message_at',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
        ];
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

    // Relasi: Produk yang dibahas
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Pesan-pesan dalam chat
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Relasi: Pesan terakhir
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    // Helper: Lawan bicara dari sudut pandang user tertentu
    public function otherUser($userId)
    {
        return $this->buyer_id === (int) $userId ? $this->seller : $this->buyer;
    }
}