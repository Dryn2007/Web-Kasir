<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-[#0b0c15] min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#1a1b26] overflow-hidden shadow-lg dark:shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-200 dark:border-gray-800 p-6 relative transition-colors duration-300">
                
                <div class="mb-8 border-b border-gray-200 dark:border-gray-700 pb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-300 uppercase tracking-widest text-xs mb-2">Order Status</h3>
                        <div>
                            @if($order->status == 'pending')
                                <span class="bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 border border-yellow-300 dark:border-yellow-500/50 px-3 py-1.5 rounded text-sm font-bold animate-pulse">PENDING PAYMENT</span>
                            @elseif($order->status == 'paid')
                                <span class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 border border-green-300 dark:border-green-500/50 px-3 py-1.5 rounded text-sm font-bold">COMPLETED / PAID</span>
                            @else
                                <span class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1.5 rounded text-sm font-bold uppercase">{{ $order->status }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-left md:text-right text-gray-600 dark:text-gray-400 text-sm">
                        <p class="mb-1"><span class="text-gray-500 dark:text-gray-600 uppercase text-xs font-bold mr-2">Date:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
                        <p><span class="text-gray-500 dark:text-gray-600 uppercase text-xs font-bold mr-2">Method:</span> <span class="uppercase font-bold text-indigo-600 dark:text-indigo-400">{{ $order->payment_method }}</span></p>
                    </div>
                </div>

                <h4 class="font-black text-xl mb-6 text-gray-900 dark:text-white brand-font flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                    DIGITAL ITEMS & KEYS
                </h4>
                
                <div class="bg-gray-50 dark:bg-[#0f1016] rounded-lg border border-gray-200 dark:border-gray-800 overflow-hidden mb-8 transition-colors duration-300">
                    
                    @foreach($order->items as $item)
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-6 border-b border-gray-200 dark:border-gray-800 last:border-0 hover:bg-gray-100 dark:hover:bg-[#15161e] transition duration-300">
                        
                        <div class="flex items-center gap-5 w-full md:w-1/2 mb-6 md:mb-0">
                            @php
                                // Jika kolom image kosong, pakai placeholder
                                // Jika tidak kosong, langsung pakai isinya (karena sudah berupa URL Cloudinary)
                                $imageSrc = $item->product->image ? $item->product->image : 'https://placehold.co/600x400?text=No+Image';
                            @endphp

                            <div class="relative w-20 h-20 rounded-md overflow-hidden bg-gray-200 dark:bg-gray-800 flex-shrink-0 border border-gray-300 dark:border-gray-700 shadow-md">
                                <img src="{{ $imageSrc }}" class="w-full h-full object-cover">
                            </div>
                            
                            <div>
                                <h5 class="font-bold text-gray-900 dark:text-white text-lg brand-font tracking-wide">{{ $item->product->name }}</h5>
                                <p class="text-sm text-indigo-600 dark:text-indigo-400 font-mono mt-1">Rp {{ number_format($item->price) }}</p>
                            </div>
                        </div>

                        <div class="w-full md:w-1/2 flex flex-col items-start md:items-end gap-3">
                            
                            @if($order->status == 'paid')
                                
                                @if (config('features.order_history.digital_access'))
                                <a href="{{ $item->product->download_url }}" target="_blank" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded text-sm group transition shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    ACCESS KEY / DOWNLOAD
                                </a>

                                @if (config('features.order_history.copy_key_button'))
                                <div class="relative w-full md:w-80 group">
                                    <div class="flex items-center bg-gray-100 dark:bg-[#050507] border border-gray-300 dark:border-gray-700 rounded overflow-hidden">
                                        <div class="pl-3 pr-2 text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                        </div>
                                        <input type="text" id="link-{{ $item->id }}" value="{{ $item->product->download_url }}" readonly 
                                               class="w-full bg-transparent border-none text-gray-600 dark:text-gray-400 text-xs py-2 focus:ring-0 cursor-text font-mono truncate">
                                    
                                    <button onclick="copyToClipboard('link-{{ $item->id }}')" class="bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-bold px-4 py-2.5 transition border-l border-gray-300 dark:border-gray-700 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                                        COPY
                                    </button>
                                    </div>
                                    <div id="msg-{{ $item->id }}" class="absolute right-0 -bottom-5 text-[10px] text-green-600 dark:text-green-400 font-bold opacity-0 transition-opacity duration-300">
                                        Link Copied!
                                    </div>
                                </div>
                                @endif
                                @endif

                                @php
                                    $existingReview = \App\Models\Review::where('user_id', Auth::id())->where('product_id', $item->product_id)->first();
                                @endphp

                                @if (config('features.review.enabled'))
                                    @if($existingReview)
                                        <div class="flex flex-col items-end gap-1 mt-1 w-full">
                                            @if (config('features.show_rating_stars'))
                                            <div class="flex items-center gap-2 bg-gray-100 dark:bg-[#252630] px-3 py-1.5 rounded border border-gray-200 dark:border-gray-700">
                                                <span class="text-[10px] text-gray-600 dark:text-gray-400 font-bold uppercase tracking-wider">Your Rating:</span>
                                                <div class="flex text-yellow-500">
                                                    @for($i=1; $i<=5; $i++)
                                                        <svg class="w-3 h-3 {{ $i <= $existingReview->rating ? 'fill-current' : 'text-gray-400 dark:text-gray-600 fill-current' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            @endif

                                            @if($existingReview->admin_reply)
                                                <div class="mt-2 bg-indigo-50 dark:bg-indigo-900/20 border-l-2 border-indigo-500 p-2 rounded-r w-full md:w-80">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="bg-indigo-600 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">ADMIN REPLY</span>
                                                        <span class="text-gray-500 text-[10px]">{{ \Carbon\Carbon::parse($existingReview->reply_at)->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-gray-700 dark:text-gray-300 text-xs italic">"{{ $existingReview->admin_reply }}"</p>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        @if (config('features.review.write_review'))
                                            <button onclick="openReviewModal('{{ $item->product->id }}', '{{ $item->product->name }}')" 
                                                    class="w-full md:w-auto mt-1 inline-flex items-center justify-center px-4 py-1.5 border border-yellow-500/50 text-yellow-600 dark:text-yellow-500 hover:bg-yellow-50 dark:hover:bg-yellow-600/10 font-bold rounded text-xs transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                </svg>
                                                RATE GAME
                                            </button>
                                        @endif
                                    @endif
                                @endif

                            @elseif($order->status == 'pending')
                                <div class="text-right">
                                    <span class="block text-xs text-yellow-600 dark:text-yellow-500 font-bold bg-yellow-100 dark:bg-yellow-900/20 px-3 py-1.5 rounded border border-yellow-300 dark:border-yellow-500/30 mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                        Locked
                                    </span>
                                    <span class="text-[10px] text-gray-500 dark:text-gray-500">Pay to unlock access</span>
                                </div>
                            @else
                                <span class="text-xs text-red-600 dark:text-red-500 font-bold bg-red-100 dark:bg-red-900/20 px-3 py-1.5 rounded border border-red-300 dark:border-red-500/30">Order Cancelled</span>
                            @endif
                        </div>

                    </div>
                    @endforeach

                </div>

                <div class="mt-8 flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-6">
                    <a href="{{ route('orders.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-bold text-sm transition flex items-center gap-1 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        BACK TO HISTORY
                    </a>
                    
                    <div class="text-right">
                        <p class="text-xs text-gray-500 dark:text-gray-500 uppercase tracking-widest mb-1">Total Amount</p>
                        <p class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-cyan-500 dark:from-indigo-400 dark:to-cyan-400 brand-font">
                            Rp {{ number_format($order->total_price) }}
                        </p>
                    </div>
                </div>

                @if($order->status == 'pending')
                <div class="mt-6 text-right">
                    <a href="{{ route('payment.simulation', $order->id) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-sm skew-x-[-10deg] transition shadow-lg animate-pulse">
                        <span class="skew-x-[10deg] flex items-center gap-2">
                            PAY NOW <span class="text-xl">&rarr;</span>
                        </span>
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>

    <div id="reviewModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900/80 dark:bg-gray-900/80 transition-opacity" onclick="closeReviewModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-[#1a1b26] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-200 dark:border-gray-700">
                <form id="reviewForm" action="" method="POST" class="p-6">
                    @csrf
                    <div class="flex justify-between items-center mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white brand-font" id="modal-title">RATE: <span id="modalProductName" class="text-indigo-600 dark:text-indigo-400">Product</span></h3>
                        <button type="button" onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    <div class="mt-4">
                        @if (config('features.review.rating_stars'))
                        <div class="mb-6 text-center">
                            <label class="block text-gray-500 dark:text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Rating</label>
                            <div class="flex flex-row-reverse justify-center gap-2 group">
                                @for($i=5; $i>=1; $i--)
                                    <input type="radio" id="m_star{{$i}}" name="rating" value="{{$i}}" class="peer hidden" required />
                                    <label for="m_star{{$i}}" class="cursor-pointer text-gray-300 dark:text-gray-700 peer-checked:text-yellow-500 peer-hover:text-yellow-400 hover:text-yellow-400 transition transform hover:scale-125">
                                        <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    </label>
                                @endfor
                            </div>
                        </div>
                        @else
                        <input type="hidden" name="rating" value="5" />
                        @endif
                        @if (config('features.review.comment'))
                        <div class="mb-4">
                            <label class="block text-gray-500 dark:text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Your Review</label>
                            <textarea name="comment" rows="4" class="w-full bg-gray-50 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded p-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-400 dark:placeholder-gray-600 focus:outline-none"></textarea>
                        </div>
                        @endif
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="closeReviewModal()" class="px-4 py-2 bg-transparent border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 rounded hover:text-gray-900 dark:hover:text-white hover:border-gray-400 text-sm font-bold transition">CANCEL</button>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded font-bold text-sm shadow-lg transition">SUBMIT</button>
                    </div>
                </form>
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
                setTimeout(() => msg.classList.add('opacity-0'), 2000);
            });
        }

        function openReviewModal(productId, productName) {
            const form = document.getElementById('reviewForm');
            form.action = `/product/${productId}/review`; 
            document.getElementById('modalProductName').innerText = productName;
            document.getElementById('reviewModal').classList.remove('hidden');
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').classList.add('hidden');
        }
    </script>
</x-app-layout>