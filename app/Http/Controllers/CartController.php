<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. Tampilkan halaman keranjang
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart.index', compact('carts'));
    }

    // 2. Tambah produk ke keranjang (Add to Cart)
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // CEK 1: Apakah stok habis total?
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Stok produk habis!');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cart) {
            // CEK 2: Jika ditambah 1, apakah melebihi stok?
            if (($cart->quantity + 1) > $product->stock) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk menambah lagi.');
            }
            $cart->increment('quantity');
        } else {
            // Produk belum ada di keranjang, aman karena stok > 0
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Produk masuk keranjang!');
    }

    // 3. Tombol Beli Sekarang (Buy Now)
    public function buyNow($productId)
    {
        $product = Product::findOrFail($productId);

        // CEK 1: Stok habis?
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Stok produk habis!');
        }

        // --- PERBAIKAN DISINI ---
        // Jangan simpan ke Database Cart, tapi simpan ke SESSION
        // Agar item di keranjang belanja user tidak ikut ter-checkout
        session(['direct_checkout_product_id' => $productId]);
        session(['direct_checkout_quantity' => 1]);

        // Langsung lempar ke halaman checkout
        return redirect()->route('checkout.index');
    }

    // 4. Update jumlah di halaman keranjang
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->with('product')->firstOrFail();

        // CEK 3: Validasi Keras saat update angka
        if ($request->quantity > $cart->product->stock) {
            return redirect()->back()->with('error', 'Maksimal stok tersedia: ' . $cart->product->stock);
        }

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->back()->with('success', 'Jumlah berhasil diubah.');
    }

    // 5. Hapus item
    public function destroy($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item dihapus');
    }
}
