<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12 bg-[#0b0c15] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div
                class="bg-[#1a1b26] overflow-hidden shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-800 mb-8">
                <div class="p-6 text-gray-100">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div
                            class="h-96 bg-gray-900 rounded-lg overflow-hidden flex items-center justify-center border border-gray-700 relative group">
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
                                <img src="{{ $imageSrc }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    onerror="this.onerror=null; this.src='https://placehold.co/600x400/1a1b26/FFF?text=No+Image';">
                            @else
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 opacity-50" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm font-bold tracking-wider">NO IMAGE</span>
                                </div>
                            @endif

                            @if($product->stock <= 0)
                                <div class="absolute inset-0 bg-black/70 flex items-center justify-center backdrop-blur-sm">
                                    <span
                                        class="text-red-500 font-bold border-2 border-red-500 px-6 py-2 rounded rotate-[-10deg] tracking-widest text-2xl shadow-[0_0_15px_rgba(239,68,68,0.5)] brand-font">SOLD
                                        OUT</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col justify-between">
                            <div>
                                <h1 class="text-4xl font-black text-white mb-2 brand-font tracking-wide leading-tight">
                                    {{ $product->name }}</h1>

                                <div
                                    class="flex items-center gap-3 mb-4 bg-[#0f1016] px-3 py-1.5 rounded border border-gray-700 w-fit">
                                    <div class="flex text-yellow-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'fill-current' : 'text-gray-700 fill-current' }}"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <div class="h-4 w-px bg-gray-600"></div>
                                    <span class="text-gray-300 text-xs font-bold">{{ $avgRating }} <span
                                            class="text-gray-500 font-normal">/ 5.0</span></span>
                                    <div class="h-4 w-px bg-gray-600"></div>

                                    <span class="text-gray-300 text-xs font-bold">{{ $allReviewsCount }} <span
                                            class="text-gray-500 font-normal">Reviews</span></span>

                                    <div class="h-4 w-px bg-gray-600"></div>
                                    <span class="text-indigo-400 text-xs font-bold">{{ $product->total_sold }} <span
                                            class="text-gray-500 font-normal">Sold</span></span>
                                </div>

                                <div class="flex items-center gap-4 mb-6">
                                    <p
                                        class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 brand-font">
                                        Rp {{ number_format($product->price) }}
                                    </p>
                                    @if($product->stock > 0)
                                        <span
                                            class="bg-indigo-900/50 text-indigo-300 px-3 py-1 rounded border border-indigo-500/30 text-[10px] font-bold tracking-wider">
                                            INSTANT DELIVERY
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-6">
                                    <h3 class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-widest">
                                        Description</h3>
                                    <p
                                        class="text-gray-300 leading-relaxed font-light border-l-2 border-indigo-500 pl-4 py-1">
                                        {{ $product->description }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2 mb-8">
                                    <div
                                        class="w-2 h-2 rounded-full {{ $product->stock > 0 ? 'bg-green-500 shadow-[0_0_10px_#22c55e]' : 'bg-red-500' }}">
                                    </div>
                                    <span class="text-gray-400 text-sm">Stock Available: <span
                                            class="text-white font-bold">{{ $product->stock }}</span></span>
                                </div>
                            </div>

                            <div class="mt-4">
                                @if($product->stock > 0)
                                    <div class="flex gap-4">
                                        <form action="{{ route('buy.now', $product->id) }}" method="POST" class="flex-1"
                                            onsubmit="return checkAuth(event)">
                                            @csrf
                                            <button type="submit"
                                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-sm skew-x-[-10deg] transition shadow-[0_0_20px_rgba(79,70,229,0.3)] hover:shadow-[0_0_30px_rgba(79,70,229,0.6)] group">
                                                <span
                                                    class="skew-x-[10deg] inline-block flex items-center justify-center gap-2">
                                                    BELI SEKARANG
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 group-hover:translate-x-1 transition-transform"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </form>

                                        <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                            onsubmit="return checkAuth(event)">
                                            @csrf
                                            <button type="submit"
                                                class="bg-[#252630] text-gray-300 font-bold py-4 px-6 rounded-sm skew-x-[-10deg] hover:bg-gray-700 hover:text-white border border-gray-600 transition flex items-center justify-center group"
                                                title="Masukkan Keranjang">
                                                <span class="skew-x-[10deg] inline-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-6 w-6 group-hover:scale-110 transition-transform"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <button disabled
                                        class="w-full bg-gray-800 text-gray-500 font-bold py-4 px-6 rounded-sm skew-x-[-10deg] cursor-not-allowed border border-gray-700">
                                        <span class="skew-x-[10deg]">STOK HABIS</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="bg-[#1a1b26] rounded-lg border border-gray-800 shadow-lg p-6">

                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-gray-700 pb-4 gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-white brand-font flex items-center gap-3">
                            PLAYER REVIEWS
                        </h3>
                        <p class="text-gray-500 text-xs mt-1">
                            Showing reviews from <span class="text-white font-bold">{{ $allReviewsCount }}</span> total
                            ratings
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                        <form method="GET" action="{{ route('product.show', $product->id) }}"
                            class="flex items-center gap-2">
                            @if(request('rating'))
                                <input type="hidden" name="rating" value="{{ request('rating') }}">
                            @endif

                            <label for="sort"
                                class="text-xs text-gray-500 font-bold uppercase whitespace-nowrap">Sort:</label>
                            <select name="sort" id="sort" onchange="this.form.submit()"
                                class="bg-[#0f1016] border border-gray-700 text-gray-300 text-xs rounded focus:ring-indigo-500 focus:border-indigo-500 block p-2 w-full sm:w-auto cursor-pointer">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="rating_high" {{ request('sort') == 'rating_high' ? 'selected' : '' }}>
                                    Highest Rating</option>
                                <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>Lowest
                                    Rating</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="mb-8 flex flex-wrap gap-2 items-center">
                    <span class="text-xs text-gray-500 font-bold uppercase mr-2">Filter Stars:</span>

                    <a href="{{ route('product.show', ['id' => $product->id, 'sort' => request('sort')]) }}"
                        class="px-4 py-1.5 rounded-full text-xs font-bold border transition {{ !request('rating') || request('rating') == 'all' ? 'bg-indigo-600 border-indigo-500 text-white shadow-[0_0_10px_#4f46e5]' : 'bg-[#0f1016] border-gray-700 text-gray-400 hover:border-gray-500 hover:text-white' }}">
                        ALL
                    </a>

                    @foreach(range(5, 1) as $star)
                        <a href="{{ route('product.show', ['id' => $product->id, 'rating' => $star, 'sort' => request('sort')]) }}"
                            class="flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold border transition {{ request('rating') == $star ? 'bg-yellow-600/20 border-yellow-500 text-yellow-400 shadow-[0_0_10px_rgba(234,179,8,0.3)]' : 'bg-[#0f1016] border-gray-700 text-gray-400 hover:border-gray-500 hover:text-white' }}">
                            <span>{{ $star }}</span>
                            <svg class="w-3 h-3 {{ request('rating') == $star ? 'fill-current' : 'fill-gray-500' }}"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        </a>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <div class="md:col-span-1">
                        <div class="bg-[#0f1016] p-5 rounded border border-gray-700 sticky top-24">
                            <div class="text-center mb-4">
                                <div class="text-5xl font-black text-white brand-font">{{ $avgRating }}</div>
                                <div class="flex justify-center gap-1 text-yellow-500 my-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= round($avgRating) ? 'fill-current' : 'text-gray-700 fill-current' }}"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-gray-500 text-xs">{{ $allReviewsCount }} total reviews</p>
                            </div>

                            @auth
                                @if($canReview)
                                    <div class="mt-4 pt-4 border-t border-gray-800 text-center">
                                        <p class="text-gray-400 text-xs mb-2">Purchased this game?</p>
                                        <a href="{{ route('orders.index') }}"
                                            class="block w-full bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 border border-yellow-500/50 font-bold py-2 rounded text-sm transition">
                                            Write Review via Orders
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center mt-4 pt-4 border-t border-gray-800">
                                    <a href="{{ route('login') }}"
                                        class="text-indigo-400 hover:text-indigo-300 text-xs font-bold underline">Login to
                                        Review</a>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <div class="md:col-span-2 space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                        @if($reviews->isEmpty())
                            <div class="text-center py-12 border border-dashed border-gray-700 rounded bg-[#0f1016]/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-700 mx-auto mb-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                <p class="text-gray-500 text-sm font-bold">No reviews found.</p>
                                @if(request('rating'))
                                    <p class="text-gray-600 text-xs mt-1">Try clearing the star filter.</p>
                                    <a href="{{ route('product.show', $product->id) }}"
                                        class="text-indigo-400 text-xs hover:underline mt-2 inline-block">Clear Filter</a>
                                @else
                                    <p class="text-gray-600 text-xs mt-1">Be the first to review this game!</p>
                                @endif
                            </div>
                        @else
                            @foreach($reviews as $review)
                                <div
                                    class="bg-[#0f1016] p-4 rounded border border-gray-800 flex gap-4 hover:border-gray-700 transition">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-purple-700 flex items-center justify-center text-white font-bold border border-gray-600 shadow-md">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                    </div>

                                    <div class="flex-grow">
                                        <div class="flex justify-between items-center mb-1">
                                            <h5 class="text-white font-bold text-sm">{{ $review->user->name }}</h5>
                                            <span
                                                class="text-gray-600 text-[10px] uppercase font-bold">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>

                                        <div class="flex items-center gap-0.5 mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-800' }} fill-current"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                </svg>
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
                Swal.fire({
                    title: 'LOGIN REQUIRED',
                    text: "Please login to purchase items.",
                    icon: 'warning',
                    background: '#1a1b26',
                    color: '#fff',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#374151',
                    confirmButtonText: 'LOGIN NOW',
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