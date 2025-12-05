<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($carts->isEmpty())
                    <p class="text-center text-gray-500">Keranjang Anda masih kosong.</p>
                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Belanja Dulu Yuk!</a>
                    </div>
                @else
                                                        @if(session('error'))
                                                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                                                <strong class="font-bold">Error!</strong>
                                                                <span class="block sm:inline">{{ session('error') }}</span>
                                                            </div>
                                                        @endif

                                                        @if(session('success'))
                                                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                                                {{ session('success') }}
                                                            </div>
                                                        @endif
                                                                            <table class="w-full table-auto">
                                                                                <thead>
                                                                                    <tr class="border-b text-left">
                                                                                        <th class="py-2">Produk</th>
                                                                                        <th class="py-2">Harga</th>
                                                                                        <th class="py-2 text-center">Jumlah</th>
                                                                                        <th class="py-2 text-right">Total</th>
                                                                                        <th class="py-2 text-center">Aksi</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                            @php $grandTotal = 0;
                    $checkoutDisabled = false
                                                            @endphp
                                                            @foreach($carts as $cart)
                                                                   @php 
                                                                    $subtotal = $cart->product->price * $cart->quantity;
                                                                    $grandTotal += $subtotal;

                                                                    // Cek Stok Real-time
                                                                    $isOutOfStock = $cart->quantity > $cart->product->stock;
                                                                    if ($isOutOfStock) {
                                                                        $checkoutDisabled = true; // Matikan tombol checkout jika ada 1 saja barang bermasalah
                                                                    }
                                                                @endphp
                                                                    <tr class="border-b hover:bg-gray-50">
                                                                       <td class="py-4 flex items-center gap-4">
    @if($cart->product->image)
        <img src="{{ asset('storage/' . $cart->product->image) }}" class="w-12 h-12 object-cover rounded">
    @endif
    <div>
        <div class="font-medium {{ $isOutOfStock ? 'text-red-600' : '' }}">
            {{ $cart->product->name }}
        </div>
        
        @if($isOutOfStock)
            <div class="text-xs text-red-600 font-bold">
                Stok Kurang! Tersedia: {{ $cart->product->stock }}
            </div>
        @else
            <div class="text-xs text-gray-500">Sisa Stok: {{ $cart->product->stock }}</div>
        @endif
    </div>
</td>

                                                                        <td class="py-4">Rp {{ number_format($cart->product->price) }}</td>

                                                                        <td class="py-4 text-center">
                                                                            <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="flex items-center justify-center gap-2">
                                                                                @csrf
                                                                                @method('PATCH')

                                                                                <input type="number" 
                                                                                       name="quantity" 
                                                                                       value="{{ $cart->quantity }}" 
                                                                                       min="1" 
                                                                                       max="{{ $cart->product->stock }}"
                                                                                       class="w-16 text-center border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-1"
                                                                                       onchange="this.form.submit()"> 
                                                                                       </form>
                                                                        </td>

                                                                        <td class="py-4 text-right font-bold">Rp {{ number_format($subtotal) }}</td>

                                                                        <td class="py-4 text-center">
                                                                            <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                            @endforeach
                                                        </tbody>
                                                                            </table>

                                                                            <div class="mt-8 flex justify-between items-center">
                                                                                <a href="{{ route('home') }}" class="text-gray-600 hover:underline">&laquo; Lanjut Belanja</a>

                                                                                <div class="text-right">
    <span class="text-lg font-bold text-gray-700">Total Bayar:</span>
    <span class="text-2xl font-bold text-blue-600 ml-2">Rp {{ number_format($grandTotal) }}</span>
    
    <div class="mt-4">
        @if($checkoutDisabled)
            <button disabled class="bg-gray-400 text-white px-6 py-3 rounded shadow font-bold cursor-not-allowed" title="Ada produk yang stoknya tidak mencukupi">
                Checkout (Perbaiki Stok Dulu)
            </button>
        @else
            <a href="{{ route('checkout.index') }}" class="bg-green-600 text-white px-6 py-3 rounded shadow hover:bg-green-700 font-bold inline-block">
                Checkout Sekarang
            </a>
        @endif
    </div>
</div>
                                                                            </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>