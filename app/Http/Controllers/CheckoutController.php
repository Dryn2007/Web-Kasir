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
        // SKENARIO A: User klik "Beli Sekarang" (Cek Session)
        if (session()->has('direct_checkout_product_id')) {

            $productId = session('direct_checkout_product_id');
            $quantity = session('direct_checkout_quantity');
            $product = Product::find($productId);

            // Validasi dadakan (kalau produk dihapus admin pas user lagi browsing)
            if (!$product) {
                session()->forget(['direct_checkout_product_id', 'direct_checkout_quantity']);
                return redirect()->route('home');
            }

            // Kita buat struktur data palsu (Mocking) agar mirip dengan struktur Cart
            $fakeCartItem = new \stdClass();
            $fakeCartItem->product = $product;
            $fakeCartItem->product_id = $product->id;
            $fakeCartItem->quantity = $quantity;

            // Masukkan ke collection agar bisa di-looping di view
            $carts = collect([$fakeCartItem]);
        }
        // SKENARIO B: User Checkout dari Keranjang (Normal)
        else {
            $carts = Cart::where('user_id', Auth::id())->with('product')->get();

            if ($carts->isEmpty()) {
                return redirect()->route('home');
            }
        }

        return view('checkout.index', compact('carts'));
    }

    // 2. Proses Simpan Order
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,gopay,dana',
        ]);

        $user = Auth::user();
        $itemsToProcess = [];
        $totalPrice = 0;
        $isDirectBuy = false;

        // --- TENTUKAN SUMBER DATA (SESSION vs CART) ---

        if (session()->has('direct_checkout_product_id')) {
            // KASUS A: BELI SEKARANG
            $isDirectBuy = true;
            $productId = session('direct_checkout_product_id');
            $qty = session('direct_checkout_quantity');
            $product = Product::find($productId);

            if ($product && $product->stock >= $qty) {
                $itemsToProcess[] = [
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $product->price,
                    'model' => $product
                ];
                $totalPrice = $product->price * $qty;
            } else {
                return redirect()->route('home')->with('error', 'Stok berubah atau produk tidak ditemukan.');
            }
        } else {
            // KASUS B: DARI KERANJANG
            $carts = Cart::where('user_id', $user->id)->with('product')->get();

            if ($carts->isEmpty()) {
                return redirect()->route('home');
            }

            foreach ($carts as $cart) {
                if ($cart->quantity > $cart->product->stock) {
                    return redirect()->route('cart.index')->with('error', "Stok {$cart->product->name} tidak cukup.");
                }

                $itemsToProcess[] = [
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                    'model' => $cart->product
                ];
                $totalPrice += $cart->product->price * $cart->quantity;
            }
        }

        // --- EKSEKUSI DATABASE ---
        // PERBAIKAN: Menghapus duplikasi $request di dalam use()
        $order = DB::transaction(function () use ($request, $user, $totalPrice, $itemsToProcess, $isDirectBuy) {

            // 1. Buat Order Header
            $order = Order::create([
                'user_id' => $user->id,
                'address' => 'Digital Delivery (Email)',
                'status' => 'pending',
                'total_price' => $totalPrice,
                'payment_method' => $request->payment_method,
            ]);

            // 2. Buat Order Items & Kurangi Stok
            foreach ($itemsToProcess as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Kurangi Stok
                $item['model']->decrement('stock', $item['quantity']);
            }

            // 3. BERSIH-BERSIH SETELAH ORDER
            if ($isDirectBuy) {
                session()->forget(['direct_checkout_product_id', 'direct_checkout_quantity']);
            } else {
                Cart::where('user_id', $user->id)->delete();
            }

            return $order;
        });

        return redirect()->route('payment.simulation', $order->id);
    }
}
