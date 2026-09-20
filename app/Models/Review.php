<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'reviewer_id',
        'reviewed_id',
        'rating',
        'comment',
    ];

    // Relasi: Review untuk transaksi
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relasi: Pemberi review
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    // Relasi: Penerima review
    public function reviewed()
    {
        return $this->belongsTo(User::class, 'reviewed_id');
    }

    // Helper: Rating dalam bentuk bintang
    public function getStarsAttribute(): string
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}