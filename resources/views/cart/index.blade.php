<x-app-layout>
    @if (config('features.cart.enabled'))
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight brand-font tracking-wider">
                SHOPPING <span class="text-indigo-600 dark:text-indigo-500">CART</span>
            </h2>
            <a href="{{ route('home') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                &larr; CONTINUE SHOPPING
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0b0c15] min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#1a1b26] overflow-hidden shadow-lg dark:shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-200 dark:border-gray-800 p-6 transition-colors duration-300">
                
                @if($carts->isEmpty())
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-300 mb-2">Your Cart is Empty</h3>
                        <p class="text-gray-500 dark:text-gray-500 mb-8">Looks like you haven't added any game yet.</p>
                        <a href="{{ route('home') }}" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-sm skew-x-[-10deg] transition shadow-lg inline-block">
                            <span class="skew-x-[10deg]">BROWSE GAMES</span>
                        </a>
                    </div>
                @else
                    
                    @if(session('error'))
                        <div class="bg-red-100 dark:bg-red-900/20 border border-red-200 dark:border-red-500/50 text-red-700 dark:text-red-400 px-4 py-3 rounded mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="bg-green-100 dark:bg-green-900/20 border border-green-200 dark:border-green-500/50 text-green-700 dark:text-green-400 px-4 py-3 rounded mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="hidden md:grid grid-cols-12 gap-4 text-xs font-bold text-gray-500 dark:text-gray-500 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
                        <div class="col-span-6">Product</div>
                        <div class="col-span-2 text-center">Price</div>
                        <div class="col-span-2 text-center">Quantity</div>
                        <div class="col-span-2 text-right">Total</div>
                    </div>

                    <div class="space-y-4">
                        @php 
                            $grandTotal = 0;
                            $checkoutDisabled = false;
                        @endphp

                        @foreach($carts as $cart)
                            @php 
                                $subtotal = $cart->product->price * $cart->quantity;
                                $grandTotal += $subtotal;
                                
                                // Logic Stok
                                $isOutOfStock = $cart->quantity > $cart->product->stock;
                                if ($isOutOfStock) $checkoutDisabled = true;

                                // Logic Gambar
                                $imageSrc = null;
                                if ($cart->product->image) {
                                    if (str_starts_with($cart->product->image, 'http')) {
                                        $imageSrc = $cart->product->image;
                                    } else {
                                        $imageSrc = asset('storage/' . $cart->product->image);
                                    }
                                }
                            @endphp

                            <div class="bg-gray-50 dark:bg-[#0f1016] rounded-lg p-4 border border-gray-200 dark:border-gray-800 hover:border-gray-300 dark:hover:border-gray-600 transition group flex flex-col md:grid md:grid-cols-12 gap-4 items-center">
                                
                                <div class="col-span-6 w-full flex items-center gap-4">
                                    <div class="w-16 h-16 flex-shrink-0 bg-gray-200 dark:bg-gray-900 rounded overflow-hidden border border-gray-300 dark:border-gray-700">
                                        @if($imageSrc)
                                            <img src="{{ $imageSrc }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://placehold.co/100x100/1a1b26/FFF?text=IMG';">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-500 font-bold">NO IMG</div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white text-lg brand-font {{ $isOutOfStock ? 'text-red-500 line-through' : '' }}">
                                            {{ $cart->product->name }}
                                        </h4>
                                        @if($isOutOfStock)
                                            <p class="text-xs text-red-500 font-bold mt-1">⚠️ STOCK ISSUE! Available: {{ $cart->product->stock }}</p>
                                        @else
                                            <p class="text-xs text-green-600 dark:text-green-500 mt-1">In Stock</p>
                                        @endif
                                        
                                        @if (config('features.cart.remove_item'))
                                        <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="inline-block mt-2 md:hidden">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 underline">Remove</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-span-2 text-center text-gray-600 dark:text-gray-400 font-mono text-sm hidden md:block">
                                    Rp {{ number_format($cart->product->price) }}
                                </div>

                                <div class="col-span-2 flex justify-center w-full">
                                    @if (config('features.cart.update_quantity'))
                                    <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="flex items-center">
                                        @csrf @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}"
                                               class="w-16 bg-white dark:bg-[#1a1b26] border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-center rounded focus:ring-indigo-500 focus:border-indigo-500 p-1"
                                               onchange="this.form.submit()">
                                    </form>
                                    @else
                                    <span class="text-gray-600 dark:text-gray-400 font-mono">{{ $cart->quantity }}</span>
                                    @endif
                                </div>

                                <div class="col-span-2 w-full flex justify-between md:justify-end items-center gap-4">
                                    <span class="font-bold text-indigo-600 dark:text-indigo-400 font-mono text-lg">
                                        Rp {{ number_format($subtotal) }}
                                    </span>
                                    
                                    @if (config('features.cart.remove_item'))
                                    <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="hidden md:block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition p-2" title="Remove Item">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6 flex flex-col md:flex-row justify-between items-center gap-6">
                        <a href="{{ route('home') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-bold flex items-center gap-2 transition">
                            &laquo; CONTINUE SHOPPING
                        </a>

                        <div class="text-right w-full md:w-auto">
                            <div class="flex justify-between md:justify-end items-center gap-8 mb-4">
                                <span class="text-gray-500 dark:text-gray-400 text-sm uppercase tracking-wider">Grand Total</span>
                                <span class="text-3xl font-black text-gray-900 dark:text-white brand-font">Rp {{ number_format($grandTotal) }}</span>
                            </div>
                            
                            @if($checkoutDisabled)
                                <button disabled class="w-full md:w-auto bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-bold py-3 px-8 rounded-sm cursor-not-allowed border border-gray-400 dark:border-gray-600">
                                    FIX STOCK ISSUE TO CHECKOUT
                                </button>
                            @else
                                @if (config('features.checkout.enabled'))
                                    <a href="{{ route('checkout.index') }}" class="inline-block w-full md:w-auto text-center bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-sm skew-x-[-10deg] transition shadow-lg hover:shadow-xl">
                                        <span class="skew-x-[10deg]">PROCEED TO CHECKOUT</span>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>

                @endif

            </div>
        </div>
    </div>
    @else
    <div class="py-16 bg-gray-50 dark:bg-[#0b0c15] min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Cart Not Available</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8">This feature is currently disabled.</p>
            <a href="{{ route('home') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded transition">
                Back to Home
            </a>
        </div>
    </div>
    @endif
</x-app-layout>