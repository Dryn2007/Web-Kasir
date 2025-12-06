<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product; // Jangan lupa import Product
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10); // <--- JANGAN GUNAKAN GET()

        return view('orders.index', compact('orders'));
    }

    // Method Baru: Ganti Metode Pembayaran
    public function updatePaymentMethod(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,gopay,dana',
        ]);

        $order = Order::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // Hanya boleh ganti jika status masih pending
        if ($order->status == 'pending') {
            $order->update([
                'payment_method' => $request->payment_method
            ]);

            return redirect()->back()->with('success', 'Metode pembayaran berhasil diubah!');
        }

        return redirect()->back()->with('error', 'Tidak bisa mengganti metode untuk pesanan ini.');
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->with('items.product')->firstOrFail();
        return view('orders.show', compact('order'));
    }

    public function paymentSimulation($id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        if ($order->status != 'pending') {
            return redirect()->route('orders.show', $id);
        }

        return view('orders.payment', compact('order'));
    }

    public function paymentSuccess($id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        $order->update(['status' => 'paid']);

        return redirect()->route('orders.show', $id)->with('success', 'Pembayaran Berhasil Dikonfirmasi!');
    }

    // --- FITUR BARU: BATALKAN PESANAN ---
    public function cancelOrder($id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // Cek: Hanya boleh batal jika status masih pending
        if ($order->status == 'pending') {

            // Gunakan Transaction untuk update status & kembalikan stok
            DB::transaction(function () use ($order) {

                // 1. Ubah status jadi 'cancelled'
                $order->update(['status' => 'cancelled']);

                // 2. KEMBALIKAN STOK BARANG (Restock)
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            });

            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
        }

        return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
    }
}
