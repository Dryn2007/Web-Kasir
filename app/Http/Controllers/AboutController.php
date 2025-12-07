<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use App\Models\Product;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::first();

        // 1. Ambil 4 Produk Terbaru (Latest)
        $latestProducts = Product::latest()
            ->take(4)
            ->get();

        // 2. Ambil 4 Produk Terlaris (Best Seller)
        // Hitung total quantity dari order yang statusnya 'paid'
        $bestSellingProducts = Product::withSum(['orderItems' => function ($query) {
            $query->whereHas('order', function ($q) {
                $q->where('status', 'paid');
            });
        }], 'quantity')
            ->orderByDesc('order_items_sum_quantity') // Urutkan dari terbanyak
            ->take(4)
            ->get();

        return view('about', compact('about', 'latestProducts', 'bestSellingProducts'));
    }
}
