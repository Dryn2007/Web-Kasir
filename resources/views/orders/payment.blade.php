<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">

                <h2 class="text-2xl font-bold mb-4">Selesaikan Pembayaran</h2>
                <p class="text-gray-600 mb-8">Total Tagihan: <span class="text-blue-600 font-bold text-xl">Rp
                        {{ number_format($order->total_price) }}</span></p>

                @if($order->payment_method == 'qris')
                    <div class="bg-gray-100 p-6 rounded-lg inline-block mb-6">
                        <p class="mb-2 font-bold text-gray-700">Scan QRIS Ini</p>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=TagihanOrder-{{ $order->id }}"
                            alt="QRIS Dummy" class="mx-auto border-4 border-white shadow-md">
                        <p class="text-xs text-gray-500 mt-2">NMID: ID123456789 (Dummy)</p>
                    </div>
                    <p class="text-sm text-gray-500 mb-6">Buka aplikasi Gojek/OVO/Dana Anda lalu scan kode di atas.</p>

                @else
                    <div class="mb-8">
                        <div class="w-24 h-24 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold">Pembayaran via {{ strtoupper($order->payment_method) }}</h3>
                        <p class="text-gray-600">Silakan konfirmasi pembayaran di aplikasi Anda.</p>
                    </div>
                @endif

                <form action="{{ route('payment.success', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-green-700 transition shadow-lg w-full sm:w-auto">
                        ✅ Saya Sudah Bayar
                    </button>
                </form>

                <div class="mt-4">
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:underline">Bayar Nanti</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>