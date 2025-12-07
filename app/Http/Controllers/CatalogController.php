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

    public function show(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // 1. DATA STATISTIK UTAMA (TIDAK BOLEH TERPENGARUH FILTER)
        // Kita hitung langsung dari database murni
        $allReviewsCount = $product->reviews()->count();
        $avgRating = round($product->reviews()->avg('rating'), 1) ?? 0;

        // 2. QUERY UNTUK LIST ULASAN (AKAN DIFILTER)
        $reviewsQuery = $product->reviews()->with('user');

        // Filter Bintang
        if ($request->has('rating') && $request->rating != 'all') {
            $reviewsQuery->where('rating', $request->rating);
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'rating_high':
                    $reviewsQuery->orderBy('rating', 'desc');
                    break;
                case 'rating_low':
                    $reviewsQuery->orderBy('rating', 'asc');
                    break;
                case 'oldest':
                    $reviewsQuery->orderBy('created_at', 'asc');
                    break;
                default: // latest
                    $reviewsQuery->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $reviewsQuery->latest();
        }

        $reviews = $reviewsQuery->get(); // Hasil yang sudah difilter

        // 3. LOGIKA CEK PEMBELIAN (Untuk Form)
        $canReview = false;
        $reviewMessage = 'Silakan login untuk mereview.';

        if (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $hasPurchased = \App\Models\OrderItem::where('product_id', $product->id)
                ->whereHas('order', function ($query) use ($user) {
                    $query->where('user_id', $user->id)->where('status', 'paid');
                })->exists();
            $hasReviewed = \App\Models\Review::where('user_id', $user->id)
                ->where('product_id', $product->id)->exists();

            if (!$hasPurchased) {
                $reviewMessage = 'Anda belum membeli produk ini.';
            } elseif ($hasReviewed) {
                $reviewMessage = 'Anda sudah memberikan ulasan.';
            } else {
                $canReview = true;
            }
        }

        // Kirim semua variabel ke view
        return view('product.show', compact('product', 'reviews', 'allReviewsCount', 'avgRating', 'canReview', 'reviewMessage'));
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
