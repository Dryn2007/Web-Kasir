<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            // Cari berdasarkan nama produk (case insensitive)
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Ambil semua produk, urutkan dari yang terbaru
        $products = $query->paginate(8)->appends(['search' => $request->search]);
        return view('welcome', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Kita return ke view baru khusus detail
        return view('product.show', compact('product'));
    }

    // Method baru untuk AJAX Search
    public function getSuggestions(Request $request)
    {
        $query = $request->get('query');

        if (!$query) {
            return response()->json([]);
        }

        $products = Product::where('name', 'like', '%' . $query . '%')
            ->take(5) // Batasi cuma 5 hasil biar rapi
            ->get()
            ->map(function ($product) {
                // Format URL gambar agar siap pakai di JS
                if ($product->image) {
                    $img = str_starts_with($product->image, 'http')
                        ? $product->image
                        : asset('storage/' . $product->image);
                } else {
                    $img = 'https://placehold.co/100x100/1a1b26/FFF?text=No+Img';
                }

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => number_format($product->price, 0, ',', '.'),
                    'image' => $img,
                    'url' => route('product.show', $product->id)
                ];
            });

        return response()->json($products);
    }
}
