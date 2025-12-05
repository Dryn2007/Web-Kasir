<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-bold">Status:
                        @if($order->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Belum Dibayar</span>
                        @elseif($order->status == 'paid')
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Lunas</span>
                        @else
                            <span
                                class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">{{ ucfirst($order->status) }}</span>
                        @endif
                    </h3>
                    <p class="mt-2 text-gray-600">Metode Bayar: <span
                            class="font-bold uppercase">{{ $order->payment_method }}</span></p>
                    <p class="text-gray-600">Alamat: {{ $order->address }}</p>
                </div>

                <h4 class="font-bold mb-4">Rincian Barang</h4>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <div class="flex items-center gap-4">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        class="w-12 h-12 object-cover rounded">
                                @endif
                                <div>
                                    <div class="font-bold">{{ $item->product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->quantity }} x Rp
                                        {{ number_format($item->price) }}</div>
                                </div>
                            </div>
                            <div class="font-bold text-gray-700">
                                Rp {{ number_format($item->price * $item->quantity) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 text-right">
                    <span class="text-xl font-bold">Total Bayar: Rp {{ number_format($order->total_price) }}</span>
                </div>

                <div class="mt-8">
                    <a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline">&laquo; Kembali ke
                        Riwayat</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>