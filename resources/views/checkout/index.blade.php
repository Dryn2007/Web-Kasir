<x-app-layout>
   

    <div class="py-12 bg-[#0b0c15] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div
                        class="bg-[#1a1b26] p-6 rounded-lg border border-gray-800 shadow-[0_0_20px_rgba(79,70,229,0.1)]">
                        <h3 class="text-lg font-bold mb-6 text-white brand-font border-b border-gray-700 pb-2">PLAYER
                            INFO</h3>

                        <div
                            class="bg-indigo-900/30 border border-indigo-500/30 text-indigo-300 px-4 py-3 rounded-md mb-6 flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-bold text-sm text-white">INSTANT DIGITAL DELIVERY</p>
                                <p class="text-xs mt-1 text-gray-400">Game key/voucher will appear in your Order History
                                    immediately after payment.</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-400 mb-2 font-medium text-xs uppercase tracking-wider">Account
                                Name</label>
                            <input type="text" value="{{ Auth::user()->name }}"
                                class="w-full bg-[#0f1016] border border-gray-700 rounded p-3 text-gray-300 focus:outline-none focus:border-indigo-500"
                                readonly>
                        </div>

                        <div class="mb-8">
                            <label class="block text-gray-400 mb-2 font-medium text-xs uppercase tracking-wider">Email
                                Address</label>
                            <input type="email" value="{{ Auth::user()->email }}"
                                class="w-full bg-[#0f1016] border border-gray-700 rounded p-3 text-gray-300 focus:outline-none focus:border-indigo-500"
                                readonly>
                            <p class="text-xs text-gray-500 mt-2">
                                <svg class="w-3 h-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Your digital product will be linked to this account.
                            </p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-400 mb-3 font-bold text-xs uppercase tracking-wider">Select
                                Payment Method</label>

                            <div class="grid grid-cols-1 gap-3">

                                <label
                                    class="payment-label flex items-center justify-between p-4 border rounded cursor-pointer transition group"
                                    id="label-qris">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="qris"
                                            class="mr-4 text-indigo-600 focus:ring-indigo-500 bg-gray-900 border-gray-600"
                                            checked onchange="updatePaymentUI()">
                                        <div>
                                            <span
                                                class="font-bold block text-sm text-white group-hover:text-indigo-400">QRIS
                                                (Instant)</span>
                                            <span class="text-xs text-gray-500">Scan via GoPay, OVO, Dana</span>
                                        </div>
                                    </div>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/1200px-Logo_QRIS.svg.png"
                                        alt="QRIS" class="h-6 opacity-80 group-hover:opacity-100 bg-white px-1 rounded">
                                </label>

                                <label
                                    class="payment-label flex items-center justify-between p-4 border rounded cursor-pointer transition group"
                                    id="label-gopay">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="gopay"
                                            class="mr-4 text-indigo-600 focus:ring-indigo-500 bg-gray-900 border-gray-600"
                                            onchange="updatePaymentUI()">
                                        <span
                                            class="font-bold text-sm text-gray-300 group-hover:text-white">GoPay</span>
                                    </div>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/2560px-Gopay_logo.svg.png"
                                        alt="GoPay" class="h-5 opacity-100 group-hover:opacity-100">
                                </label>

                                <label
                                    class="payment-label flex items-center justify-between p-4 border rounded cursor-pointer transition group"
                                    id="label-dana">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="dana"
                                            class="mr-4 text-indigo-600 focus:ring-indigo-500 bg-gray-900 border-gray-600"
                                            onchange="updatePaymentUI()">
                                        <span class="font-bold text-sm text-gray-300 group-hover:text-white">Dana</span>
                                    </div>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/2560px-Logo_dana_blue.svg.png"
                                        alt="Dana" class="h-5 opacity-100 group-hover:opacity-100">
                                </label>

                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-[#1a1b26] p-6 rounded-lg border border-gray-800 shadow-[0_0_20px_rgba(79,70,229,0.1)] h-fit sticky top-24">
                        <h3 class="text-lg font-bold mb-6 text-white brand-font border-b border-gray-700 pb-2">ORDER
                            SUMMARY</h3>

                        <div class="border-b border-gray-700 pb-4 mb-4">
                            @php $total = 0; @endphp
                            @foreach($carts as $cart)
                                @php $subtotal = $cart->product->price * $cart->quantity;
                                $total += $subtotal; @endphp
                                <div class="flex justify-between items-start mb-4">
                                    <div class="text-sm">
                                        <div class="font-bold text-gray-200">{{ $cart->product->name }}</div>
                                        <div class="text-indigo-400 text-xs mt-1">Digital License x {{ $cart->quantity }}
                                        </div>
                                    </div>
                                    <div class="text-sm font-bold text-white">Rp {{ number_format($subtotal) }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-center text-xl font-black mb-8">
                            <span class="text-gray-400 text-base font-normal">TOTAL</span>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">Rp
                                {{ number_format($total) }}</span>
                        </div>

                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-sm skew-x-[-5deg] transition shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-[0_0_25px_rgba(79,70,229,0.6)]">
                            <span class="skew-x-[5deg]">PAY NOW & GET ACCESS</span>
                        </button>

                        <div class="mt-6 flex justify-center text-gray-600 gap-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5z" />
                            </svg>
                            <p class="text-[10px] text-center w-full">
                                By continuing, you agree to our Digital Product Terms & Conditions. No refund for
                                redeemed keys.
                            </p>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <script>
        // Style untuk kartu yang DIPILIH (Active)
        const activeClasses = ['border-indigo-500/50', 'bg-indigo-900/10'];
        // Style untuk kartu yang TIDAK DIPILIH (Inactive)
        const inactiveClasses = ['border-gray-700', 'bg-[#0f1016]'];

        function updatePaymentUI() {
            // 1. Ambil semua label
            const labels = document.querySelectorAll('.payment-label');

            // 2. Loop semua label untuk reset ke style 'inactive'
            labels.forEach(label => {
                const radio = label.querySelector('input[type="radio"]');

                if (radio.checked) {
                    // Jika ini yang dipilih, kasih style Active
                    label.classList.remove(...inactiveClasses);
                    label.classList.add(...activeClasses);
                } else {
                    // Jika bukan ini, kasih style Inactive
                    label.classList.remove(...activeClasses);
                    label.classList.add(...inactiveClasses);
                }
            });
        }

        // Jalankan sekali saat halaman dimuat agar QRIS (default) langsung berwarna
        document.addEventListener('DOMContentLoaded', () => {
            updatePaymentUI();
        });
    </script>
</x-app-layout>