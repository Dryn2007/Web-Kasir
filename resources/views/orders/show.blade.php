<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white leading-tight brand-font tracking-wider">
            ORDER <span class="text-indigo-500">DETAILS</span> #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0b0c15] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1a1b26] overflow-hidden shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-800 p-6">
                
                <div class="mb-8 border-b border-gray-700 pb-6 flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-gray-300 uppercase tracking-widest text-xs mb-2">Order Status</h3>
                        <div class="mt-1">
                            @if($order->status == 'pending')
                                <span class="bg-yellow-900/30 text-yellow-300 border border-yellow-500/50 px-3 py-1.5 rounded text-sm font-bold animate-pulse">PENDING PAYMENT</span>
                            @elseif($order->status == 'paid')
                                <span class="bg-green-900/30 text-green-300 border border-green-500/50 px-3 py-1.5 rounded text-sm font-bold">COMPLETED / PAID</span>
                            @else
                                <span class="bg-gray-700 text-gray-300 px-3 py-1.5 rounded text-sm font-bold uppercase">{{ $order->status }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right text-gray-400 text-sm">
                        <p class="mb-1"><span class="text-gray-600 uppercase text-xs font-bold mr-2">Date:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
                        <p><span class="text-gray-600 uppercase text-xs font-bold mr-2">Method:</span> <span class="uppercase font-bold text-indigo-400">{{ $order->payment_method }}</span></p>
                    </div>
                </div>

                <h4 class="font-black text-xl mb-6 text-white brand-font flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                    DIGITAL ITEMS
                </h4>
                
                <div class="bg-[#0f1016] rounded-lg border border-gray-800 overflow-hidden mb-8">
                    
                    @foreach($order->items as $item)
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-800 last:border-0 hover:bg-[#15161e] transition duration-300">
                        
                        <div class="flex items-center gap-5 w-full sm:w-1/2 mb-6 sm:mb-0">
                            @php
                                $imageSrc = null;
                                if ($item->product->image) {
                                    if (str_starts_with($item->product->image, 'http')) {
                                        $imageSrc = $item->product->image;
                                    } else {
                                        $imageSrc = asset('storage/' . $item->product->image);
                                    }
                                }
                            @endphp

                            <div class="relative w-20 h-20 rounded-md overflow-hidden bg-gray-800 flex-shrink-0 border border-gray-700">
                                @if($imageSrc)
                                    <img src="{{ $imageSrc }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-500 font-bold">NO IMG</div>
                                @endif
                            </div>
                            
                            <div>
                                <h5 class="font-bold text-white text-lg brand-font tracking-wide">{{ $item->product->name }}</h5>
                                <p class="text-sm text-indigo-400 font-mono mt-1">Rp {{ number_format($item->price) }}</p>
                            </div>
                        </div>

                        <div class="w-full sm:w-1/2 text-left sm:text-right">
                            
                            @if($order->status == 'paid')
                                <div class="flex flex-col items-end gap-3">
                                    
                                    <a href="{{ $item->product->download_url }}" target="_blank" class="inline-flex items-center justify-center w-full sm:w-auto px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-sm skew-x-[-10deg] transition shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-[0_0_25px_rgba(79,70,229,0.6)] text-sm group">
                                        <span class="skew-x-[10deg] flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            OPEN GAME LINK
                                        </span>
                                    </a>

                                    <div class="w-full sm:max-w-xs bg-[#252630] p-3 rounded border border-gray-700 text-left">
                                        
                                        <div class="flex items-start gap-2 mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-[10px] text-gray-400 leading-tight">
                                                <strong class="text-gray-300">Alternative:</strong> Copy link below manually if button fails.
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-2 w-full">
                                            <input type="text" 
                                                   id="link-{{ $item->id }}" 
                                                   value="{{ $item->product->download_url }}" 
                                                   readonly 
                                                   onclick="this.select()" 
                                                   class="text-xs border border-gray-600 rounded px-2 py-2 text-gray-300 w-full bg-[#0f1016] focus:outline-none focus:border-indigo-500 cursor-default font-mono"
                                            >
                                            
                                            <button onclick="copyToClipboard('link-{{ $item->id }}')" class="bg-gray-700 hover:bg-gray-600 text-white text-xs px-3 py-2 rounded font-bold transition flex items-center gap-1 shrink-0 border border-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                </svg>
                                                COPY
                                            </button>
                                        </div>
                                        
                                        <div id="msg-{{ $item->id }}" class="text-[10px] text-green-400 font-bold mt-1 opacity-0 transition-opacity duration-500 h-4">
                                            Copied to clipboard!
                                        </div>
                                    </div>
                                </div>

                            @elseif($order->status == 'pending')
                                <span class="inline-flex items-center text-yellow-300 text-xs font-bold bg-yellow-900/20 px-4 py-2 rounded border border-yellow-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    LOCKED (PAY TO UNLOCK)
                                </span>
                            
                            @else
                                <span class="text-red-400 text-sm font-bold uppercase tracking-wider">Order Cancelled</span>
                            @endif
                        </div>

                    </div>
                    @endforeach

                </div>

                <div class="mt-8 flex justify-between items-center border-t border-gray-700 pt-6">
                    <a href="{{ route('orders.index') }}" class="text-gray-400 hover:text-white font-bold text-sm transition flex items-center gap-1">
                        &laquo; BACK TO HISTORY
                    </a>
                    
                    <div class="text-right">
                        <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Total Amount</p>
                        <p class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 brand-font">
                            Rp {{ number_format($order->total_price) }}
                        </p>
                    </div>
                </div>

                @if($order->status == 'pending')
                <div class="mt-6 text-right">
                    <a href="{{ route('payment.simulation', $order->id) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-sm skew-x-[-10deg] transition shadow-[0_0_20px_rgba(79,70,229,0.4)] hover:shadow-[0_0_30px_rgba(79,70,229,0.6)] animate-pulse">
                        <span class="skew-x-[10deg] flex items-center gap-2">
                            PAY NOW <span class="text-xl">&rarr;</span>
                        </span>
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(elementId) {
            var copyText = document.getElementById(elementId);
            
            copyText.select();
            copyText.setSelectionRange(0, 99999); 

            navigator.clipboard.writeText(copyText.value).then(function() {
                var msgId = 'msg-' + elementId.replace('link-', '');
                var msg = document.getElementById(msgId);
                
                msg.classList.remove('opacity-0');
                setTimeout(function() {
                    msg.classList.add('opacity-0');
                }, 2000);
            }, function(err) {
                alert('Failed to copy. Please copy manually.');
            });
        }
    </script>
</x-app-layout>