<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // 1. Tampilkan Halaman Checkout
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('home');
        }

        return view('checkout.index', compact('carts'));
    }

    // 2. Proses Simpan Order
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'payment_method' => 'required',
        ]);

        $carts = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('home');
        }

        // ==============================================================
        // [BARU] VALIDASI STOK: CEK APAKAH STOK CUKUP?
        // ==============================================================
        // [VALIDASI KETAT]
        foreach ($carts as $cart) {
            // Ambil data produk TERBARU dari database (bukan data cache di cart)
            $freshProduct = Product::find($cart->product_id);

            // Jika produk sudah dihapus admin atau stoknya tiba-tiba 0
            if (!$freshProduct || $freshProduct->stock < $cart->quantity) {
                return redirect()->route('cart.index')->with('error', "Stok berubah! Produk '{$freshProduct->name}' sisa: {$freshProduct->stock}");
            }
        }

        // Hitung Total Harga
        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->quantity;
        }

        // Gunakan Database Transaction
        $order = DB::transaction(function () use ($request, $carts, $totalPrice) {

            // A. Buat Order Utama
            $order = Order::create([
                'user_id' => Auth::id(),
                'address' => $request->address,
                'status' => 'pending',
                'total_price' => $totalPrice,
                'payment_method' => $request->payment_method,
            ]);

            // B. Pindahkan Item Cart ke OrderItems & Kurangi Stok
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                ]);

                // Kurangi Stok Produk
                $product = Product::find($cart->product_id);
                $product->decrement('stock', $cart->quantity);
            }

            // C. Kosongkan Keranjang
            Cart::where('user_id', Auth::id())->delete();

            return $order;
        });

        // 3. Redirect ke halaman simulasi pembayaran
        return redirect()->route('payment.simulation', $order->id);
    }
}
