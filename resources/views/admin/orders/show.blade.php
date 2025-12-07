<x-app-layout>
    @if (config('features.order_management.enabled'))
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight brand-font tracking-wider">
                ORDER <span class="text-indigo-600 dark:text-indigo-500">DETAILS</span> #{{ $order->id }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                &larr; BACK TO LIST
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0b0c15] min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    
                    <div class="bg-white dark:bg-[#1a1b26] overflow-hidden shadow-lg dark:shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-200 dark:border-gray-800 p-6 transition-colors">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2 brand-font">
                            ORDER ITEMS
                        </h3>

                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-4 bg-gray-50 dark:bg-[#0f1016] p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <div class="w-16 h-16 flex-shrink-0 bg-gray-200 dark:bg-gray-800 rounded overflow-hidden border border-gray-300 dark:border-gray-700">
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
                                        @if($imageSrc)
                                            <img src="{{ $imageSrc }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-500 font-bold">NO IMG</div>
                                        @endif
                                    </div>

                                    <div class="flex-grow">
                                        <h4 class="text-gray-900 dark:text-white font-bold text-sm">{{ $item->product->name }}</h4>
                                        <div class="flex justify-between items-center mt-1">
                                            <span class="text-gray-500 dark:text-gray-400 text-xs font-mono">Rp {{ number_format($item->price) }}</span>
                                            
                                            <div class="relative group">
                                                <span class="text-[10px] text-indigo-500 cursor-pointer underline">View Key Source</span>
                                                <div class="absolute bottom-full right-0 mb-2 w-64 bg-black text-white text-[10px] p-2 rounded shadow-lg hidden group-hover:block z-10 break-all">
                                                    {{ $item->product->download_url }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex justify-end items-center gap-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <span class="text-gray-500 dark:text-gray-400 text-sm uppercase tracking-wider font-bold">Grand Total</span>
                            <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400 brand-font">
                                Rp {{ number_format($order->total_price) }}
                            </span>
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-1 space-y-8">

                    <div class="bg-white dark:bg-[#1a1b26] shadow-lg sm:rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                        <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-4">Customer Info</h3>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-white font-bold text-lg">
                                {{ substr($order->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-gray-900 dark:text-white font-bold">{{ $order->user->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 space-y-1">
                            <p><strong>Joined:</strong> {{ $order->user->created_at->format('d M Y') }}</p>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#1a1b26] shadow-lg sm:rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                        <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-4">Payment Status</h3>
                        
                        <div class="mb-6 text-center">
                            @if($order->status == 'paid')
                                <div class="bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-500/50 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span class="font-bold text-lg tracking-wider">PAID</span>
                                </div>
                            @elseif($order->status == 'pending')
                                <div class="bg-yellow-100 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-500/50 text-yellow-700 dark:text-yellow-400 px-4 py-3 rounded-lg animate-pulse">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span class="font-bold text-lg tracking-wider">PENDING</span>
                                </div>
                            @else
                                <div class="bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-500/50 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg">
                                    <span class="font-bold text-lg tracking-wider">CANCELLED</span>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Method</span>
                                <span class="font-bold text-gray-900 dark:text-white uppercase">{{ $order->payment_method }}</span>
                            </div>
                        </div>

                        @if($order->status == 'pending')
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 space-y-3">
                                @if (config('features.order_management.manual_approval'))
                                <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" onsubmit="return confirm('Confirm payment manually?');">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded shadow-lg transition flex justify-center items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        APPROVE PAYMENT
                                    </button>
                                </form>
                                @endif
                                
                                @if (config('features.order_management.cancel_order'))
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Delete/Cancel this order permanently?');">
                                    @csrf @method('DELETE') <button type="submit" class="w-full bg-red-100 dark:bg-red-900/20 hover:bg-red-200 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/30 font-bold py-3 rounded transition flex justify-center items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        CANCEL ORDER
                                    </button>
                                </form>
                                @endif
                            </div>
                        @endif

                    </div>

                </div>

            </div>
        </div>
    </div>
    @else
    <div class="py-16 bg-gray-50 dark:bg-[#0b0c15] min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Access Denied</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8">Order management is currently disabled.</p>
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded transition">
                Back to Dashboard
            </a>
        </div>
    </div>
    @endif
</x-app-layout>