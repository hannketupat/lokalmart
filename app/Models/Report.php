<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'reporter_id',
        'reason',
        'status',
    ];

    // Relasi: Produk yang dilaporkan
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Pelapor
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    // Scope: Laporan pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}   