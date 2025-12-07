<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12 bg-[#0b0c15] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-[#1a1b26] overflow-hidden shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-800 mb-8">
                <div class="p-6 text-gray-100">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <div class="h-96 bg-gray-900 rounded-lg overflow-hidden flex items-center justify-center border border-gray-700 relative group">
                            @php
                                $imageSrc = null;
                                if ($product->image) {
                                    if (str_starts_with($product->image, 'http')) {
                                        $imageSrc = $product->image;
                                    } else {
                                        $imageSrc = asset('storage/' . $product->image);
                                    }
                                }
                            @endphp

                            @if($imageSrc)
                                <img src="{{ $imageSrc }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                                     onerror="this.onerror=null; this.src='https://placehold.co/600x400/1a1b26/FFF?text=No+Image';">
                            @else
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm font-bold tracking-wider">NO IMAGE</span>
                                </div>
                            @endif

                            @if($product->stock <= 0)
                                <div class="absolute inset-0 bg-black/70 flex items-center justify-center backdrop-blur-sm">
                                    <span class="text-red-500 font-bold border-2 border-red-500 px-6 py-2 rounded rotate-[-10deg] tracking-widest text-2xl shadow-[0_0_15px_rgba(239,68,68,0.5)] brand-font">SOLD OUT</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col justify-between">
                            <div>
                                <h1 class="text-4xl font-black text-white mb-2 brand-font tracking-wide leading-tight">{{ $product->name }}</h1>
                                
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="flex text-yellow-500">
                                        @for($i=1; $i<=5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= round($product->average_rating) ? 'fill-current' : 'text-gray-600 fill-current' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        @endfor
                                    </div>
                                    <span class="text-gray-400 text-sm">({{ $product->reviews->count() }} Reviews)</span>
                                    <span class="text-gray-600 text-sm">•</span>
                                    <span class="text-gray-400 text-sm">{{ $product->total_sold }} Sold</span>
                                </div>

                                <div class="flex items-center gap-4 mb-6">
                                    <p class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 brand-font">
                                        Rp {{ number_format($product->price) }}
                                    </p>
                                    @if($product->stock > 0)
                                        <span class="bg-indigo-900/50 text-indigo-300 px-3 py-1 rounded border border-indigo-500/30 text-[10px] font-bold tracking-wider">
                                            INSTANT DELIVERY
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="mb-6">
                                    <h3 class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-widest">Description</h3>
                                    <p class="text-gray-300 leading-relaxed font-light border-l-2 border-indigo-500 pl-4 py-1">
                                        {{ $product->description }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2 mb-8">
                                    <div class="w-2 h-2 rounded-full {{ $product->stock > 0 ? 'bg-green-500 shadow-[0_0_10px_#22c55e]' : 'bg-red-500' }}"></div>
                                    <span class="text-gray-400 text-sm">Stock Available: <span class="text-white font-bold">{{ $product->stock }}</span></span>
                                </div>
                            </div>

                            <div class="mt-4">
                                @if($product->stock > 0)
                                    <div class="flex gap-4">
                                        <form action="{{ route('buy.now', $product->id) }}" method="POST" class="flex-1" onsubmit="return checkAuth(event)">
                                            @csrf
                                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-sm skew-x-[-10deg] transition shadow-[0_0_20px_rgba(79,70,229,0.3)] hover:shadow-[0_0_30px_rgba(79,70,229,0.6)] group">
                                                <span class="skew-x-[10deg] inline-block flex items-center justify-center gap-2">
                                                    BELI SEKARANG
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </form>

                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" onsubmit="return checkAuth(event)">
                                            @csrf
                                            <button type="submit" class="bg-[#252630] text-gray-300 font-bold py-4 px-6 rounded-sm skew-x-[-10deg] hover:bg-gray-700 hover:text-white border border-gray-600 transition flex items-center justify-center group" title="Masukkan Keranjang">
                                                <span class="skew-x-[10deg] inline-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <button disabled class="w-full bg-gray-800 text-gray-500 font-bold py-4 px-6 rounded-sm skew-x-[-10deg] cursor-not-allowed border border-gray-700">
                                        <span class="skew-x-[10deg]">STOK HABIS</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="bg-[#1a1b26] rounded-lg border border-gray-800 shadow-lg p-6">
                <h3 class="text-2xl font-bold text-white brand-font mb-6 border-b border-gray-700 pb-4 flex items-center gap-3">
                    PLAYER REVIEWS 
                    <span class="text-sm font-normal bg-indigo-900/30 text-indigo-300 px-3 py-1 rounded-full border border-indigo-500/30">
                        {{ $product->average_rating }} / 5.0 ({{ $product->reviews->count() }})
                    </span>
                </h3>

                <div class="md:grid-cols-3 gap-8">
                    <div class="md:col-span-2 space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                        @if($product->reviews->isEmpty())
                            <div class="text-center py-12 border border-dashed border-gray-700 rounded bg-[#0f1016]/50">
                                <p class="text-gray-500 text-sm">No reviews yet.</p>
                                <p class="text-gray-600 text-xs mt-1">Be the first to review this game!</p>
                            </div>
                        @else
                            @foreach($product->reviews->sortByDesc('created_at') as $review)
                                <div class="bg-[#0f1016] p-4 rounded border border-gray-800 flex gap-4 hover:border-gray-700 transition">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-purple-700 flex items-center justify-center text-white font-bold border border-gray-600 shadow-md">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-center mb-1">
                                            <h5 class="text-white font-bold text-sm">{{ $review->user->name }}</h5>
                                            <span class="text-gray-600 text-xs">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <div class="flex items-center gap-0.5 mb-2">
                                            @for($i=1; $i<=5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-800' }} fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            @endfor
                                        </div>

                                        <p class="text-gray-400 text-sm leading-relaxed">
                                            {{ $review->comment ?? 'No comment provided.' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        function checkAuth(e) {
            const isGuest = {{ auth()->guest() ? 'true' : 'false' }};

            if (isGuest) {
                e.preventDefault(); 

                // Popup Tema Gaming (Gelap)
                Swal.fire({
                    title: 'LOGIN DULU, BRO!',
                    text: "Kamu harus login untuk membeli produk ini.",
                    icon: 'warning',
                    background: '#1a1b26',
                    color: '#fff',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#374151',
                    confirmButtonText: '🚀 GAS LOGIN',
                    cancelButtonText: 'Nanti Aja'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
                
                return false;
            }
            return true; 
        }
    </script>
</x-app-layout>