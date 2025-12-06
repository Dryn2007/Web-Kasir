<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Transaksi Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
<div class="flex justify-between items-center mb-6">
    @if(request('user_id'))
        <div>
            <h3 class="text-lg font-bold text-gray-800">
                Transaksi oleh:
                <span class="text-blue-600">
                    {{ $orders->first()->user->name ?? 'User Tidak Ditemukan' }}
                </span>
            </h3>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">
                &laquo; Kembali lihat semua transaksi
            </a>
        </div>
    @else
        <h3 class="text-lg font-bold text-gray-800">Semua Transaksi Masuk</h3>
    @endif
</div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="p-3">ID</th>
                            <th class="p-3">Pembeli</th>
                            <th class="p-3">Total</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Metode</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">#{{ $order->id }}</td>
                                <td class="p-3">
                                    <div class="font-bold">{{ $order->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                </td>
                                <td class="p-3 font-mono">Rp {{ number_format($order->total_price) }}</td>
                                <td class="p-3">
                                    @if($order->status == 'paid')
                                        <span
                                            class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold">Lunas</span>
                                    @elseif($order->status == 'pending')
                                        <span
                                            class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold">Pending</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-bold">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td class="p-3 uppercase text-sm">{{ $order->payment_method }}</td>
                                <td class="p-3 text-sm">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="p-3 flex gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="text-blue-600 hover:underline text-sm">Detail</a>

                                    @if($order->status == 'pending')
                                        <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST"
                                            onsubmit="return confirm('ACC Pesanan ini manual?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-green-600 hover:text-green-800 text-sm ml-2">Approve</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>