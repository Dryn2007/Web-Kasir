<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil order punya user sendiri, urutkan dari yang terbaru
        $orders = Order::where('user_id', Auth::id())->latest()->get();

        return view('orders.index', compact('orders'));
    }

    // Tampilkan Halaman Simulasi Bayar
    public function paymentSimulation($id)
    {
        $order = Order::findOrFail($id);

        // Jika sudah bayar, tendang balik
        if ($order->status != 'pending') {
            return redirect()->route('orders.show', $id);
        }

        return view('orders.payment', compact('order'));
    }

    // Proses "Pura-pura" Bayar Sukses
    public function paymentSuccess($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => 'paid'
        ]);

        return redirect()->route('orders.show', $id)->with('success', 'Pembayaran Berhasil Dikonfirmasi!');
    }
}
