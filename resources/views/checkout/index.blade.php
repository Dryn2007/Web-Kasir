<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout Pengiriman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h3 class="text-lg font-bold mb-4">Alamat Pengiriman</h3>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Nama Penerima</label>
                            <input type="text" value="{{ Auth::user()->name }}"
                                class="w-full bg-gray-100 border border-gray-300 rounded p-2" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea name="address" rows="4" class="w-full border border-gray-300 rounded p-2"
                                placeholder="Jalan, Nomor Rumah, Kecamatan..." required></textarea>
                        </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-bold">Pilih Metode Pembayaran (Online)</label>
                    
                        <div class="grid grid-cols-1 gap-4">
                            <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-gray-50 border-blue-200 bg-blue-50">
                                <input type="radio" name="payment_method" value="qris" class="mr-3" checked>
                                <div>
                                    <span class="font-bold block">QRIS</span>
                                    <span class="text-xs text-gray-500">Scan pakai GoPay, OVO, Dana, dll</span>
                                </div>
                            </label>
                    
                            <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="gopay" class="mr-3">
                                <span class="font-bold">GoPay</span>
                            </label>
                    
                            <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="dana" class="mr-3">
                                <span class="font-bold">Dana</span>
                            </label>
                    
                        </div>
                    </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm h-fit">
                        <h3 class="text-lg font-bold mb-4">Ringkasan Pesanan</h3>

                        <div class="border-b pb-4 mb-4">
                            @php $total = 0; @endphp
                            @foreach($carts as $cart)
                                @php $subtotal = $cart->product->price * $cart->quantity;
    $total += $subtotal; @endphp
                                <div class="flex justify-between items-center mb-2">
                                    <div class="text-sm">
                                        <span class="font-bold">{{ $cart->product->name }}</span>
                                        <span class="text-gray-500">x {{ $cart->quantity }}</span>
                                    </div>
                                    <div class="text-sm font-semibold">Rp {{ number_format($subtotal) }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-center text-xl font-bold mb-6">
                            <span>Total Bayar</span>
                            <span class="text-blue-600">Rp {{ number_format($total) }}</span>
                        </div>

                        <button type="submit"
                            class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition">
                            Buat Pesanan
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</x-app-layout>