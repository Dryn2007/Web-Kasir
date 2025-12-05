<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        // Ambil semua produk, urutkan dari yang terbaru
        $products = Product::latest()->get();
        return view('welcome', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Kita return ke view baru khusus detail
        return view('product.show', compact('product'));
    }
}
