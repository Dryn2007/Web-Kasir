<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'stock',
        'image',
        'download_url',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relasi ke Order Item (Untuk hitung terjual)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper: Hitung Rata-rata Bintang
    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating'), 1) ?? 0;
    }

    // Helper: Hitung Total Terjual (Hanya yang status ordernya 'paid')
    public function getTotalSoldAttribute()
    {
        return $this->orderItems()
            ->whereHas('order', function ($q) {
                $q->where('status', 'paid');
            })
            ->sum('quantity');
    }
}
