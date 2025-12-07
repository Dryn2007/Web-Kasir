<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight brand-font tracking-wider">
                SECURE <span class="text-indigo-600 dark:text-indigo-500">CHECKOUT</span>
            </h2>
            <a href="{{ route('cart.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                &larr; BACK TO CART
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0b0c15] min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div
                        class="bg-white dark:bg-[#1a1b26] p-6 rounded-lg border border-gray-200 dark:border-gray-800 shadow-lg dark:shadow-[0_0_20px_rgba(79,70,229,0.1)] transition-colors duration-300">
                        <h3
                            class="text-lg font-bold mb-6 text-gray-900 dark:text-white brand-font border-b border-gray-200 dark:border-gray-700 pb-2">
                            PLAYER INFO
                        </h3>

                        <div
                            class="bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-500/30 text-indigo-700 dark:text-indigo-300 px-4 py-3 rounded-md mb-6 flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-bold text-sm text-gray-900 dark:text-white">INSTANT DIGITAL DELIVERY</p>
                                <p class="text-xs mt-1 text-gray-600 dark:text-gray-400">Game key/voucher will appear in
                                    your Order History immediately after payment.</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-gray-500 dark:text-gray-400 mb-2 font-medium text-xs uppercase tracking-wider">Account
                                Name</label>
                            <input type="text" value="{{ Auth::user()->name }}"
                                class="w-full bg-gray-100 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 rounded p-3 text-gray-800 dark:text-gray-300 focus:outline-none focus:border-indigo-500 transition-colors"
                                readonly>
                        </div>

                        <div class="mb-8">
                            <label
                                class="block text-gray-500 dark:text-gray-400 mb-2 font-medium text-xs uppercase tracking-wider">Email
                                Address</label>
                            <input type="email" value="{{ Auth::user()->email }}"
                                class="w-full bg-gray-100 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 rounded p-3 text-gray-800 dark:text-gray-300 focus:outline-none focus:border-indigo-500 transition-colors"
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
                            <label
                                class="block text-gray-500 dark:text-gray-400 mb-3 font-bold text-xs uppercase tracking-wider">Select
                                Payment Method</label>

                            <div class="grid grid-cols-1 gap-3">
                                <label
                                    class="payment-label flex items-center justify-between p-4 border rounded cursor-pointer transition group"
                                    id="label-qris">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="qris"
                                            class="mr-4 text-indigo-600 focus:ring-indigo-500 bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-600"
                                            checked onchange="updatePaymentUI()">
                                        <div>
                                            <span
                                                class="font-bold block text-sm text-gray-800 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400">QRIS
                                                (Instant)</span>
                                            <span class="text-xs text-gray-500">Scan via GoPay, OVO, Dana</span>
                                        </div>
                                    </div>
                                    <div
                                        class="bg-white p-1 rounded h-8 w-12 flex items-center justify-center border border-gray-200">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/1200px-Logo_QRIS.svg.png"
                                            alt="QRIS" class="h-full object-contain">
                                    </div>
                                </label>

                                <label
                                    class="payment-label flex items-center justify-between p-4 border rounded cursor-pointer transition group"
                                    id="label-gopay">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="gopay"
                                            class="mr-4 text-indigo-600 focus:ring-indigo-500 bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-600"
                                            onchange="updatePaymentUI()">
                                        <span
                                            class="font-bold text-sm text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white">GoPay</span>
                                    </div>
                                    <div
                                        class="bg-white p-1 rounded h-8 w-12 flex items-center justify-center border border-gray-200">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/2560px-Gopay_logo.svg.png"
                                            alt="GoPay" class="h-full object-contain">
                                    </div>
                                </label>

                                <label
                                    class="payment-label flex items-center justify-between p-4 border rounded cursor-pointer transition group"
                                    id="label-dana">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="dana"
                                            class="mr-4 text-indigo-600 focus:ring-indigo-500 bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-600"
                                            onchange="updatePaymentUI()">
                                        <span
                                            class="font-bold text-sm text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white">Dana</span>
                                    </div>
                                    <div
                                        class="bg-white p-1 rounded h-8 w-12 flex items-center justify-center border border-gray-200">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/2560px-Logo_dana_blue.svg.png"
                                            alt="Dana" class="h-full object-contain">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-[#1a1b26] p-6 rounded-lg border border-gray-200 dark:border-gray-800 shadow-lg dark:shadow-[0_0_20px_rgba(79,70,229,0.1)] h-fit sticky top-24 transition-colors duration-300">
                        <h3
                            class="text-lg font-bold mb-6 text-gray-900 dark:text-white brand-font border-b border-gray-200 dark:border-gray-700 pb-2">
                            ORDER SUMMARY</h3>

                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                            @php $total = 0; @endphp
                            @foreach($carts as $cart)
                                @php $subtotal = $cart->product->price * $cart->quantity;
                                $total += $subtotal; @endphp
                                <div class="flex justify-between items-start mb-4">
                                    <div class="text-sm">
                                        <div class="font-bold text-gray-800 dark:text-gray-200">{{ $cart->product->name }}
                                        </div>
                                        <div class="text-indigo-600 dark:text-indigo-400 text-xs mt-1">Digital License x
                                            {{ $cart->quantity }}</div>
                                    </div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">Rp
                                        {{ number_format($subtotal) }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-center text-xl font-black mb-8">
                            <span class="text-gray-500 dark:text-gray-400 text-base font-normal">TOTAL</span>
                            <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-cyan-500 dark:from-indigo-400 dark:to-cyan-400">Rp
                                {{ number_format($total) }}</span>
                        </div>

                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-sm skew-x-[-5deg] transition shadow-lg hover:shadow-xl">
                            <span class="skew-x-[5deg]">PAY NOW & GET ACCESS</span>
                        </button>

                        <div class="mt-6 flex justify-center text-gray-500 dark:text-gray-600 gap-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5z" />
                            </svg>
                            <p class="text-[10px] text-center w-full">By continuing, you agree to our Digital Product
                                Terms & Conditions. No refund for redeemed keys.</p>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <script>
        // Style Active (Light & Dark)
        const activeClassList = [
            'border-indigo-500/50',
            'bg-indigo-50', // Light mode bg
            'dark:bg-indigo-900/10' // Dark mode bg
        ];

        // Style Inactive (Light & Dark)
        const inactiveClassList = [
            'border-gray-200', 'dark:border-gray-700', // Border
            'bg-gray-50', 'dark:bg-[#0f1016]' // Bg
        ];

        function updatePaymentUI() {
            const labels = document.querySelectorAll('.payment-label');

            labels.forEach(label => {
                const radio = label.querySelector('input[type="radio"]');

                // Bersihkan class dulu agar tidak numpuk
                label.classList.remove('border-indigo-500/50', 'bg-indigo-50', 'dark:bg-indigo-900/10');
                label.classList.remove('border-gray-200', 'dark:border-gray-700', 'bg-gray-50', 'dark:bg-[#0f1016]');

                if (radio.checked) {
                    // Tambahkan class ACTIVE
                    label.classList.add('border-indigo-500/50', 'bg-indigo-50', 'dark:bg-indigo-900/10');
                } else {
                    // Tambahkan class INACTIVE
                    label.classList.add('border-gray-200', 'dark:border-gray-700', 'bg-gray-50', 'dark:bg-[#0f1016]');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            updatePaymentUI();
        });
    </script>
</x-app-layout>