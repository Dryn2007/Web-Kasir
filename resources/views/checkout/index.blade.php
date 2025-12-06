<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h3 class="text-lg font-bold mb-4">Informasi Penerima</h3>
                        
                        <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg mb-6 flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-bold text-sm">Produk Digital (Instan)</p>
                                <p class="text-xs mt-1">Tidak ada pengiriman fisik. Link akses game akan langsung muncul di halaman Riwayat Pesanan setelah pembayaran berhasil.</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">Nama Akun</label>
                            <input type="text" value="{{ Auth::user()->name }}" class="w-full bg-gray-100 border border-gray-300 rounded p-2 text-gray-600" readonly>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 mb-2 font-medium">Email Penerima</label>
                            <input type="email" value="{{ Auth::user()->email }}" class="w-full bg-gray-100 border border-gray-300 rounded p-2 text-gray-600" readonly>
                            <p class="text-xs text-gray-500 mt-1">Akses produk akan disimpan secara permanen di akun ini.</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-bold">Metode Pembayaran</label>
                            
                            <div class="grid grid-cols-1 gap-3">
                                <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-gray-50 border-blue-200 bg-blue-50 transition">
                                    <input type="radio" name="payment_method" value="qris" class="mr-3" checked>
                                    <div>
                                        <span class="font-bold block text-sm">QRIS (Instan)</span>
                                        <span class="text-xs text-gray-500">Scan pakai GoPay, OVO, Dana, ShopeePay</span>
                                    </div>
                                </label>

                                <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="payment_method" value="gopay" class="mr-3">
                                    <span class="font-bold text-sm">GoPay</span>
                                </label>

                                <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="payment_method" value="dana" class="mr-3">
                                    <span class="font-bold text-sm">Dana</span>
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
                                <div class="flex justify-between items-center mb-3">
                                    <div class="text-sm">
                                        <div class="font-bold text-gray-800">{{ $cart->product->name }}</div> 
                                        <div class="text-gray-500 text-xs mt-0.5">Digital License x {{ $cart->quantity }}</div>
                                    </div>
                                    <div class="text-sm font-semibold">Rp {{ number_format($subtotal) }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-center text-xl font-bold mb-6">
                            <span>Total Bayar</span>
                            <span class="text-blue-600">Rp {{ number_format($total) }}</span>
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition shadow-md">
                            Bayar & Dapatkan Akses
                        </button>
                        
                        <p class="text-xs text-center text-gray-400 mt-4">
                            Dengan melanjutkan, Anda menyetujui S&K Produk Digital.
                        </p>
                    </div>

                </div>
            </form>

        </div>
    </div>
</x-app-layout>