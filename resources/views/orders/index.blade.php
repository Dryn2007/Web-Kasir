<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if($orders->isEmpty())
                    <p class="text-center text-gray-500">Anda belum memiliki pesanan.</p>
                @else
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="px-4 py-2">ID Order</th>
                                <th class="px-4 py-2">Tanggal</th>
                                <th class="px-4 py-2">Total Harga</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">#{{ $order->id }}</td>
                                    <td class="px-4 py-3">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3 font-bold">Rp {{ number_format($order->total_price) }}</td>
                                    <td class="px-4 py-3">
                                        @if($order->status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded">
                                                Belum Dibayar
                                            </span>
                                        @elseif($order->status == 'paid')
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">
                                                Lunas
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($order->status == 'pending')
                                            <a href="{{ route('payment.simulation', $order->id) }}"
                                                class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition">
                                                Bayar Sekarang
                                            </a>
                                        @else
                                            <a href="{{ route('orders.show', $order->id) }}"
                                                class="text-gray-600 hover:text-gray-900 border border-gray-300 px-4 py-2 rounded text-sm">
                                                Lihat Detail
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>