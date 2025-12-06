<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6 border-b pb-4 flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Status Pesanan</h3>
                        <div class="mt-2">
                            @if($order->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-bold">Menunggu Pembayaran</span>
                            @elseif($order->status == 'paid')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold">Lunas - Akses Terbuka</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-bold">{{ ucfirst($order->status) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right text-gray-600 text-sm">
                        <p>Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
                        <p>Metode: <span class="uppercase font-bold">{{ $order->payment_method }}</span></p>
                    </div>
                </div>

                <h4 class="font-bold text-lg mb-4 text-gray-800">Akses Produk Digital</h4>
                <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                    
                    @foreach($order->items as $item)
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border-b border-gray-200 last:border-0 hover:bg-white transition">
                        
                        <div class="flex items-center gap-4 w-full sm:w-1/2 mb-4 sm:mb-0">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-16 h-16 object-cover rounded-md border">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center text-xs text-gray-500">No IMG</div>
                            @endif
                            
                            <div>
                                <h5 class="font-bold text-gray-900">{{ $item->product->name }}</h5>
                                <p class="text-sm text-gray-500">Harga: Rp {{ number_format($item->price) }}</p>
                            </div>
                        </div>

                        <div class="w-full sm:w-1/2 text-left sm:text-right">
                            
                            @if($order->status == 'paid')
                                <div class="flex flex-col items-end gap-3">
                                    
                                    <a href="{{ $item->product->download_url }}" target="_blank" class="inline-flex items-center justify-center w-full sm:w-auto px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md font-bold text-sm gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Buka Link Game
                                    </a>

                                    <div class="w-full sm:max-w-xs bg-gray-50 p-3 rounded-md border border-gray-200 text-left">
                                        
                                        <div class="flex items-start gap-2 mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-[11px] text-gray-600 leading-tight">
                                                <strong>Alternatif:</strong> Jika tombol di atas tidak berfungsi, salin link di bawah ini dan paste di browser Anda.
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-2 w-full">
                                            <input type="text" 
                                                   id="link-{{ $item->id }}" 
                                                   value="{{ $item->product->download_url }}" 
                                                   readonly 
                                                   onclick="this.select()" 
                                                   class="text-xs border border-gray-300 rounded px-2 py-2 text-gray-500 w-full bg-white cursor-default focus:outline-none focus:ring-1 focus:ring-gray-200"
                                            >
                                            
                                            <button onclick="copyToClipboard('link-{{ $item->id }}')" class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs px-3 py-2 rounded font-bold transition flex items-center gap-1 shrink-0 shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                </svg>
                                                Salin
                                            </button>
                                        </div>
                                        
                                        <div id="msg-{{ $item->id }}" class="text-[10px] text-green-600 font-bold mt-1 opacity-0 transition-opacity duration-500 h-4">
                                            Disalin!
                                        </div>
                                    </div>
                                </div>

                            @elseif($order->status == 'pending')
                                <span class="inline-flex items-center text-yellow-600 text-sm font-medium bg-yellow-50 px-3 py-2 rounded-lg border border-yellow-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Bayar untuk Buka Link
                                </span>
                            
                            @else
                                <span class="text-gray-400 text-sm">Pesanan Dibatalkan</span>
                            @endif
                        </div>

                    </div>
                    @endforeach

                </div>

                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">&laquo; Kembali ke Riwayat</a>
                    
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Total Tagihan</p>
                        <p class="text-2xl font-extrabold text-gray-900">Rp {{ number_format($order->total_price) }}</p>
                    </div>
                </div>

                @if($order->status == 'pending')
                <div class="mt-6 border-t pt-6 text-right">
                    <a href="{{ route('payment.simulation', $order->id) }}" class="inline-block bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition shadow-lg animate-pulse">
                        Bayar Sekarang &rarr;
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
                alert('Gagal menyalin. Silakan copy manual.');
            });
        }
    </script>
</x-app-layout>