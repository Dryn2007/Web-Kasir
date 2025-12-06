<x-app-layout>
    <div class="py-12 bg-[#0b0c15] min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div
                    class="mb-4 bg-green-900/30 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg text-sm font-bold text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div
                class="bg-[#1a1b26] overflow-hidden shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-800 p-8">

                <div class="text-center mb-8 border-b border-gray-700 pb-6">
                    <h2 class="text-2xl font-black text-white brand-font tracking-wider">COMPLETE <span
                            class="text-indigo-500">PAYMENT</span></h2>
                    <p class="text-gray-400 mt-2 text-xs uppercase tracking-widest">Total Amount</p>
                    <p
                        class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 mt-2 brand-font">
                        Rp {{ number_format($order->total_price) }}
                    </p>

                    <div class="mt-4 flex justify-center">
                        <span
                            class="inline-flex items-center gap-2 bg-indigo-900/30 text-indigo-300 text-xs px-4 py-1.5 rounded border border-indigo-500/30 uppercase font-bold tracking-wide">
                            Current Method:
                            @if($order->payment_method == 'qris')
                                QRIS
                            @else
                                {{ strtoupper($order->payment_method) }}
                            @endif
                        </span>
                    </div>
                </div>

                <div class="py-2 mb-6">

                    @if($order->payment_method == 'qris')
                        <div class="text-center">
                            <p class="mb-6 font-bold text-gray-300 text-sm uppercase tracking-wide">Scan QR Code Below</p>

                            <div
                                class="bg-white p-4 rounded-lg inline-block shadow-[0_0_20px_rgba(255,255,255,0.1)] border-4 border-indigo-500 relative group">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg blur opacity-20 group-hover:opacity-40 transition duration-1000">
                                </div>
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=BayarOrder-{{ $order->id }}-Nominal-{{ $order->total_price }}"
                                    alt="QRIS" class="mx-auto relative z-10">
                            </div>

                            <div class="mt-6 space-y-3">
                                <div
                                    class="text-xs text-gray-500 font-mono bg-black/30 py-2 px-4 rounded inline-block border border-gray-700">
                                    NMID: ID{{ rand(100000000, 999999999) }}
                                </div>
                                <p class="text-xs text-gray-400 max-w-xs mx-auto">Open any E-Wallet app (GoPay, OVO, Dana,
                                    ShopeePay) and scan the code above.</p>
                            </div>
                        </div>

                    @else
                        <div class="text-center mb-8">
                            <div
                                class="w-20 h-20 mx-auto bg-[#0f1016] border border-gray-700 rounded-full flex items-center justify-center mb-4 shadow-lg">
                                @if($order->payment_method == 'gopay')
                                    <img src="https://pbs.twimg.com/profile_images/1841317083633823744/UTMJokUt_400x400.jpg"
                                        class="w-20 rounded-full ">
                                @elseif($order->payment_method == 'dana')
                                    <img src="https://downloadr2.apkmirror.com/wp-content/uploads/2023/02/41/63ecca00b12e5.png"
                                        class="w-20 rounded-full">
                                @endif
                            </div>

                            <h3 class="font-bold text-white text-lg brand-font">LOGIN TO
                                {{ strtoupper($order->payment_method) }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Enter your phone number and PIN to confirm payment.</p>
                        </div>

                        <div class="space-y-5 px-2">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Phone
                                    Number</label>
                                <input type="text" id="dummy_phone" placeholder="08xxxxxxxxxx"
                                    class="w-full bg-[#0f1016] border border-gray-700 text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-600 transition font-mono">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">PIN (6
                                    Digit)</label>
                                <input type="password" id="dummy_pin" placeholder="••••••" maxlength="6"
                                    class="w-full bg-[#0f1016] border border-gray-700 text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-600 transition tracking-[0.5em] text-center font-bold">
                            </div>
                        </div>
                    @endif

                </div>

                <div class="space-y-4 pt-6 border-t border-gray-700">

                    <form action="{{ route('payment.success', $order->id) }}" method="POST" id="payment-form">
                        @csrf
                        <button type="button" onclick="validatePayment()"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-4 rounded-sm skew-x-[-5deg] transition shadow-[0_0_20px_rgba(79,70,229,0.3)] hover:shadow-[0_0_30px_rgba(79,70,229,0.6)] flex justify-center items-center gap-2 group">
                            <span class="skew-x-[5deg] tracking-wide flex items-center gap-2">
                                CONFIRM PAYMENT
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                        </button>
                    </form>

                    <div class="mt-6 pt-4 border-t border-gray-800">
                        <p class="text-center text-gray-500 text-xs font-bold mb-3 uppercase tracking-wider">Change
                            Payment Method</p>

                        <div class="flex justify-center gap-3">
                            <form action="{{ route('payment.change', $order->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="payment_method" value="qris">
                                <button type="submit"
                                    class="px-3 py-2 rounded bg-[#0f1016] border {{ $order->payment_method == 'qris' ? 'border-indigo-500 text-indigo-400' : 'border-gray-700 text-gray-500 hover:border-gray-500 hover:text-gray-300' }} transition text-xs font-bold flex items-center gap-2"
                                    {{ $order->payment_method == 'qris' ? 'disabled' : '' }}>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/1200px-Logo_QRIS.svg.png"
                                        class="h-3 bg-white px-0.5 rounded">
                                    QRIS
                                </button>
                            </form>

                            <form action="{{ route('payment.change', $order->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="payment_method" value="gopay">
                                <button type="submit"
                                    class="px-3 py-2 rounded bg-[#0f1016] border {{ $order->payment_method == 'gopay' ? 'border-green-500 text-green-400' : 'border-gray-700 text-gray-500 hover:border-gray-500 hover:text-gray-300' }} transition text-xs font-bold flex items-center gap-2"
                                    {{ $order->payment_method == 'gopay' ? 'disabled' : '' }}>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/2560px-Gopay_logo.svg.png"
                                        class="h-3">
                                    GoPay
                                </button>
                            </form>

                            <form action="{{ route('payment.change', $order->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="payment_method" value="dana">
                                <button type="submit"
                                    class="px-3 py-2 rounded bg-[#0f1016] border {{ $order->payment_method == 'dana' ? 'border-blue-500 text-blue-400' : 'border-gray-700 text-gray-500 hover:border-gray-500 hover:text-gray-300' }} transition text-xs font-bold flex items-center gap-2"
                                    {{ $order->payment_method == 'dana' ? 'disabled' : '' }}>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/2560px-Logo_dana_blue.svg.png"
                                        class="h-3">
                                    Dana
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('orders.index') }}"
                            class="text-xs text-gray-500 hover:text-gray-300 transition underline">Pay Later / Back to
                            History</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function validatePayment() {
            let method = "{{ $order->payment_method }}";
            let btn = document.querySelector('#payment-form button');
            let btnText = btn.querySelector('span');

            // 1. QRIS: Langsung Proses
            if (method === 'qris') {
                setLoading(btn, btnText);
                setTimeout(() => document.getElementById('payment-form').submit(), 1500);
                return;
            }

            // 2. E-Wallet: Cek Input
            let phone = document.getElementById('dummy_phone').value;
            let pin = document.getElementById('dummy_pin').value;

            if (phone.length < 10) {
                Swal.fire({ icon: 'error', title: 'Invalid Phone', text: 'Please enter a valid phone number.', background: '#1a1b26', color: '#fff', confirmButtonColor: '#4f46e5' });
                return;
            }
            if (pin.length < 6) {
                Swal.fire({ icon: 'error', title: 'Invalid PIN', text: 'PIN must be 6 digits.', background: '#1a1b26', color: '#fff', confirmButtonColor: '#4f46e5' });
                return;
            }

            setLoading(btn, btnText);
            setTimeout(() => document.getElementById('payment-form').submit(), 2000);
        }

        function setLoading(btn, textSpan) {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            textSpan.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> PROCESSING...';
        }
    </script>
</x-app-layout>