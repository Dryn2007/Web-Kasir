<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // --- RELASI PENTING YANG HILANG ---

    // 1. Relasi ke Induk Order (Untuk cek status bayar)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // 2. Relasi ke Produk (Untuk ambil nama/gambar)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
