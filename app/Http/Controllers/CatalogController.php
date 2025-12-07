<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // <--- PENTING: Import Model Category
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // 1. QUERY DASAR
        // - Load 'category' & 'reviews' biar tidak query berulang (N+1 Problem)
        // - Hitung jumlah terjual (hanya yang statusnya 'paid')
        $query = Product::with(['category', 'reviews'])
            ->withSum(['orderItems' => function ($q) {
                $q->whereHas('order', fn($o) => $o->where('status', 'paid'));
            }], 'quantity');

        // 2. FILTER KATEGORI (Agar Dropdown Kategori Berfungsi)
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 3. LOGIKA PENCARIAN
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 4. LOGIKA SORTIR
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

        $products = $query->paginate(12)->appends($request->all());

        // 5. AMBIL DATA KATEGORI (Untuk Dropdown di View)
        $categories = Category::withCount('products')->get();

        return view('welcome', compact('products', 'categories'));
    }

    public function show(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // 1. DATA STATISTIK UTAMA (TIDAK BOLEH TERPENGARUH FILTER)
        $allReviewsCount = $product->reviews()->count();
        $avgRating = round($product->reviews()->avg('rating'), 1) ?? 0;

        // 2. QUERY UNTUK LIST ULASAN (AKAN DIFILTER)
        $reviewsQuery = $product->reviews()->with('user');

        // Filter Bintang
        if ($request->has('rating') && $request->rating != 'all') {
            $reviewsQuery->where('rating', $request->rating);
        }

        // Sorting Review
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

        $reviews = $reviewsQuery->get();

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

        return view('product.show', compact('product', 'reviews', 'allReviewsCount', 'avgRating', 'canReview', 'reviewMessage'));
    }

    // Method untuk AJAX Search Suggestion
    public function getSuggestions(Request $request)
    {
        $query = $request->get('query');

        if (!$query) {
            return response()->json([]);
        }

        $products = Product::where('name', 'like', '%' . $query . '%')
            ->take(5)
            ->get()
            ->map(function ($product) {
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
