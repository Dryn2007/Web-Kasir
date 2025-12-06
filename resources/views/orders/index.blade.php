<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white leading-tight brand-font tracking-wider">
            MY <span class="text-indigo-500">LIBRARY</span> & HISTORY
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0b0c15] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if($orders->isEmpty())
                <div class="text-center py-20 bg-[#1a1b26] rounded-xl border border-dashed border-gray-700">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-800 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No Transactions Yet</h3>
                    <p class="text-gray-400 mb-6">Your game library is empty. Start your journey now!</p>
                    <a href="{{ route('home') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-sm skew-x-[-10deg] transition inline-block">
                        <span class="skew-x-[10deg]">BROWSE STORE</span>
                    </a>
                </div>
            @else
                
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-[#1a1b26] rounded-xl overflow-hidden border border-gray-800 hover:border-indigo-500/30 transition-all duration-300 shadow-lg relative group">
                            
                            <div class="absolute left-0 top-0 bottom-0 w-1 {{ $order->status == 'pending' ? 'bg-yellow-500 shadow-[0_0_10px_#eab308]' : ($order->status == 'paid' ? 'bg-green-500 shadow-[0_0_10px_#22c55e]' : 'bg-red-500') }}"></div>

                            <div class="p-6">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-4 border-b border-gray-700/50">
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-500 uppercase tracking-widest font-bold mb-1">Transaction Date</span>
                                        <span class="text-gray-300 font-mono text-sm">
                                            {{ $order->created_at->format('d F Y') }} <span class="text-gray-600 px-1">•</span> {{ $order->created_at->format('H:i') }}
                                        </span>
                                    </div>

                                    <div class="mt-4 sm:mt-0">
                                        @if($order->status == 'pending')
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 text-xs font-bold uppercase tracking-wider animate-pulse">
                                                <span class="w-2 h-2 rounded-full bg-yellow-400"></span> Waiting for Payment
                                            </span>
                                        @elseif($order->status == 'paid')
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded bg-green-500/10 border border-green-500/20 text-green-400 text-xs font-bold uppercase tracking-wider">
                                                <span class="w-2 h-2 rounded-full bg-green-400"></span> Completed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-bold uppercase tracking-wider">
                                                Cancelled
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row gap-6 items-center">
                                    
                                    <div class="flex-1 w-full space-y-4">
                                        @foreach($order->items as $item)
                                            <div class="flex items-center gap-4 bg-[#0f1016] p-3 rounded-lg border border-gray-800">
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

                                                <div class="relative w-16 h-16 flex-shrink-0 rounded overflow-hidden bg-gray-900 border border-gray-700">
                                                    @if($imageSrc)
                                                        <img src="{{ $imageSrc }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-500">NO IMG</div>
                                                    @endif
                                                </div>

                                                <div>
                                                    <h4 class="text-white font-bold text-sm line-clamp-1 brand-font">{{ $item->product->name }}</h4>
                                                    <p class="text-indigo-400 text-xs font-mono mt-1">Rp {{ number_format($item->price) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="w-full md:w-48 flex-shrink-0 flex flex-col justify-center items-end border-t md:border-t-0 md:border-l border-gray-700 pt-4 md:pt-0 md:pl-6">
                                        <span class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Amount</span>
                                        <span class="text-2xl font-black text-white brand-font mb-4">
                                            Rp {{ number_format($order->total_price) }}
                                        </span>

                                        @if($order->status == 'pending')
                                            <a href="{{ route('payment.simulation', $order->id) }}" class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded shadow-[0_0_15px_rgba(79,70,229,0.4)] transition text-sm mb-2">
                                                PAY NOW
                                            </a>
                                            
                                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Cancel this order?');" class="w-full">
                                                @csrf
                                                <button type="submit" class="w-full text-center text-red-500 hover:text-red-400 text-xs font-bold py-2 border border-red-900/30 rounded hover:bg-red-900/10 transition">
                                                    CANCEL
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('orders.show', $order->id) }}" class="w-full text-center bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 rounded transition text-sm flex items-center justify-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                ACCESS KEY
                                            </a>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $orders->links() }}
                </div>

            @endif
        </div>
    </div>
</x-app-layout>