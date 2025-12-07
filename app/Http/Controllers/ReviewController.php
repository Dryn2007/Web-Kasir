<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => config('features.review.rating_stars') ? 'required|integer|min:1|max:5' : 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        // 1. CEK: Apakah user sudah beli produk ini DAN statusnya 'paid'? (jika require_purchase aktif)
        if (config('features.review.require_purchase')) {
            $hasPurchased = OrderItem::where('product_id', $productId)
                ->whereHas('order', function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('status', 'paid'); // Wajib PAID
                })->exists();

            if (!$hasPurchased) {
                return redirect()->back()->with('error', 'Anda harus membeli produk ini dulu sebelum memberi ulasan.');
            }
        }

        // 2. CEK: Apakah user sudah pernah review sebelumnya? (Agar tidak spam)
        $existingReview = Review::where('user_id', $user->id)->where('product_id', $productId)->exists();
        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        // 3. Simpan Review
        Review::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'rating' => $request->rating ?? 5, // Default 5 jika rating_stars disabled
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Review berhasil dikirim!');
    }
}
