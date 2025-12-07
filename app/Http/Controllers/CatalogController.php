<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // 1. MULAI QUERY DENGAN LOGIKA BEST SELLER YANG BENAR
        // Hitung jumlah quantity, TAPI hanya dari order yang statusnya 'paid'
        $query = Product::withSum(['orderItems' => function ($query) {
            $query->whereHas('order', function ($q) {
                $q->where('status', 'paid');
            });
        }], 'quantity');

        // 2. LOGIKA PENCARIAN
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. LOGIKA SORTIR
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popular':
                    // Urutkan dari jumlah terbanyak (desc), nilai null dianggap 0
                    $query->orderByRaw('COALESCE(order_items_sum_quantity, 0) DESC');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default: // latest
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Default: Terbaru dulu
            $query->orderBy('created_at', 'desc');
        }

        // Secondary Sort: Jika jumlah terjual sama/harga sama, urutkan berdasarkan terbaru
        // Ini penting agar urutan tidak acak-acakan jika angkanya sama
        if ($request->sort !== 'latest') {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->appends($request->all());

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
