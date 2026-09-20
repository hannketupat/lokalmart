<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'sender_id',
        'message',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    // Relasi: Pesan milik satu chat
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    // Relasi: Pengirim pesan
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Scope: Pesan belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}