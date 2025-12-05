<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-8">

                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Selesaikan Pembayaran</h2>
                    <p class="text-gray-500 mt-2">Total Tagihan</p>
                    <p class="text-3xl font-extrabold text-blue-600 mt-1">Rp {{ number_format($order->total_price) }}
                    </p>
                    <div
                        class="mt-2 inline-block bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full uppercase font-bold tracking-wide">
                        Metode: {{ $order->payment_method }}
                    </div>
                </div>

                <div class="border-t border-b border-gray-100 py-6 mb-6">

                    @if($order->payment_method == 'qris')
                        <div class="text-center">
                            <p class="mb-4 font-bold text-gray-700">Scan QR Code di bawah ini:</p>
                            <div class="bg-white p-4 border rounded-lg inline-block shadow-sm">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=BayarOrder-{{ $order->id }}-Nominal-{{ $order->total_price }}"
                                    alt="QRIS" class="mx-auto">
                            </div>
                            <p class="text-xs text-gray-400 mt-3">NMID: ID{{ rand(100000000, 999999999) }} (Simulasi)</p>
                            <p class="text-sm text-gray-600 mt-4">Buka aplikasi E-Wallet apa saja (GoPay, OVO, Dana,
                                ShopeePay) lalu scan kode di atas.</p>
                        </div>

                    @else
                        <div class="text-center mb-6">
                            <div
                                class="w-16 h-16 mx-auto bg-{{ $order->payment_method == 'gopay' ? 'green' : 'blue' }}-100 rounded-full flex items-center justify-center mb-4">
                                <span
                                    class="font-bold text-{{ $order->payment_method == 'gopay' ? 'green' : 'blue' }}-600 uppercase text-xs">
                                    {{ $order->payment_method }}
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-800">Login ke Akun {{ ucfirst($order->payment_method) }}</h3>
                            <p class="text-sm text-gray-500">Masukkan nomor HP dan PIN untuk konfirmasi.</p>
                        </div>

                        <div class="space-y-4 px-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Handphone</label>
                                <input type="text" id="dummy_phone" placeholder="08xxxxxxxxxx"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">PIN (6 Digit)</label>
                                <input type="password" id="dummy_pin" placeholder="••••••" maxlength="6"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    @endif

                </div>

                <div class="space-y-3">

                    <form action="{{ route('payment.success', $order->id) }}" method="POST" id="payment-form">
                        @csrf
                        <button type="button" onclick="validatePayment()"
                            class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition shadow-md flex justify-center items-center gap-2">
                            <span>Konfirmasi & Bayar</span>
                        </button>
                    </form>

                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                        @csrf
                        <button type="submit"
                            class="w-full bg-white border border-red-500 text-red-500 font-bold py-3 px-4 rounded-lg hover:bg-red-50 transition">
                            Batalkan Transaksi
                        </button>
                    </form>

                    <div class="text-center mt-2">
                        <a href="{{ route('orders.index') }}" class="text-sm text-gray-400 hover:text-gray-600">Bayar
                            Nanti</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function validatePayment() {
            let method = "{{ $order->payment_method }}";

            // Jika metode QRIS, langsung submit (karena ceritanya scan di HP lain)
            if (method === 'qris') {
                document.getElementById('payment-form').submit();
                return;
            }

            // Jika E-Wallet, cek input dulu
            let phone = document.getElementById('dummy_phone').value;
            let pin = document.getElementById('dummy_pin').value;

            if (phone.length < 10) {
                alert('Mohon masukkan nomor HP yang valid!');
                return;
            }
            if (pin.length < 6) {
                alert('Mohon masukkan PIN 6 digit!');
                return;
            }

            // Simulasi Loading biar keren
            let btn = document.querySelector('#payment-form button');
            btn.innerHTML = 'Memproses...';
            btn.disabled = true;
            btn.classList.add('opacity-50');

            setTimeout(() => {
                document.getElementById('payment-form').submit();
            }, 1500); // Delay 1.5 detik
        }
    </script>
</x-app-layout>