<x-app-layout>
    @if (config('features.landing_page.enabled'))
        @if (config('features.landing_page.hero_section'))
            <div class="relative overflow-hidden bg-gray-50 dark:bg-[#0f1016] transition-colors duration-300">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-7xl pointer-events-none">
                    <div class="absolute top-20 left-20 w-96 h-96 bg-indigo-400 dark:bg-indigo-600 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[100px] opacity-20"></div>
                    <div class="absolute top-40 right-20 w-72 h-72 bg-purple-400 dark:bg-purple-600 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[100px] opacity-20"></div>
                </div>

                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
                    <h1 class="text-5xl md:text-7xl font-black text-gray-900 dark:text-white tracking-tighter mb-6 brand-font drop-shadow-sm dark:drop-shadow-lg transition-colors duration-300">
                        LEVEL UP YOUR <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-cyan-500 dark:from-indigo-400 dark:to-cyan-400">DIGITAL LIBRARY</span>
                    </h1>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600 dark:text-gray-400 font-light transition-colors duration-300">
                        Dapatkan Game Key, Software Original, dan Voucher Game termurah dengan pengiriman instan otomatis.
                    </p>
                    <div class="mt-10 flex justify-center gap-4">
                        <a href="#browse-games" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-sm skew-x-[-10deg] transition shadow-lg hover:shadow-xl">
                            <span class="skew-x-[10deg] inline-block">BROWSE GAMES</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <div id="browse-games" class="py-16 bg-white dark:bg-[#0b0c15] transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (config('features.landing_page.trending_now'))
                <div class="mb-8 px-4 sm:px-0">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 brand-font transition-colors duration-300">
                        <span class="w-1 h-8 bg-indigo-500 rounded-full shadow-[0_0_10px_#6366f1]"></span>
                        TRENDING NOW
                    </h2>
                </div>
            @endif

            @if (config('features.search_filter.enabled'))
                <div class="sticky top-20 z-40 px-4 sm:px-0 mb-10">
                    <form action="{{ route('home') }}" method="GET">
                        <input type="hidden" name="ref" value="filter">
                        
                        <div class="bg-white/90 dark:bg-[#1a1b26]/95 backdrop-blur-md border border-gray-200 dark:border-gray-700/50 rounded-xl p-1.5 flex flex-col md:flex-row gap-2 shadow-lg dark:shadow-[0_10px_40px_-10px_rgba(0,0,0,0.5)] transition-colors duration-300">
                            
                            @if (config('features.search_filter.sorting'))
                                <div class="relative w-full md:w-48 flex-shrink-0 group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <svg class="w-4 h-4 text-gray-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                        </svg>
                                    </div>
                                    <select name="sort" onchange="this.form.submit()" 
                                            class="w-full bg-gray-50 dark:bg-[#0f1016] text-gray-900 dark:text-gray-300 border border-gray-200 dark:border-gray-700/50 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block pl-10 pr-8 p-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-900 transition appearance-none font-bold">
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }} class="text-orange-600 dark:text-yellow-400">🔥 Popular</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            @endif

                            @if (config('features.search_filter.category_filter'))
                                <div class="relative w-full md:w-48 flex-shrink-0 group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <svg class="w-4 h-4 text-gray-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                        </svg>
                                    </div>
                                    <select name="category" onchange="this.form.submit()" 
                                            class="w-full bg-gray-50 dark:bg-[#0f1016] text-gray-900 dark:text-gray-300 border border-gray-200 dark:border-gray-700/50 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block pl-10 pr-8 p-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-900 transition appearance-none font-bold">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                                {{ $cat->name }} ({{ $cat->products_count }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            @endif

                            @if (config('features.search_filter.live_search'))
                                <div class="relative w-full group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-focus-within:text-indigo-600 dark:group-focus-within:text-indigo-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                                        class="w-full bg-gray-50 dark:bg-[#0f1016]/50 hover:bg-gray-100 dark:hover:bg-[#0f1016] focus:bg-white dark:focus:bg-[#0f1016] text-gray-900 dark:text-white border-transparent focus:border-indigo-500 text-sm rounded-lg focus:ring-0 block pl-10 p-3 placeholder:text-black dark:placeholder:text-white font-medium transition"
                                        placeholder="Search games..." autocomplete="off"
                                        onkeyup="fetchSuggestions(this.value)" onfocus="fetchSuggestions(this.value)">
                                    
                                    <div id="search-suggestions" class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-[#1a1b26] border border-gray-200 dark:border-gray-700 rounded-lg shadow-2xl hidden overflow-hidden z-50">
                                        <ul id="suggestion-list" class="divide-y divide-gray-100 dark:divide-gray-800 text-sm"></ul>
                                    </div>
                                </div>
                            @endif

                            @if(request('search') || request('sort') || request('category'))
                                <a href="{{ route('home') }}" class="flex-shrink-0 bg-red-100 dark:bg-red-500/10 hover:bg-red-200 dark:hover:bg-red-500/20 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/30 rounded-lg w-10 flex items-center justify-center transition" title="Reset Filters">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            @endif

            @if(request('search'))
                <div class="mb-6 px-4 sm:px-0">
                    <p class="text-gray-600 dark:text-gray-400">
                        Found <span class="text-gray-900 dark:text-white font-bold">{{ $products->total() }}</span> results for "<span class="text-indigo-600 dark:text-indigo-400">{{ request('search') }}</span>"
                    </p>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 px-4 sm:px-0">
                @foreach($products as $product)
                <a href="{{ route('product.show', $product->id) }}" class="group relative flex flex-col bg-white dark:bg-[#1a1b26] rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-800 hover:border-indigo-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl dark:hover:shadow-[0_10px_30px_-10px_rgba(79,70,229,0.3)] shadow-sm">
                    
                    <div class="relative h-64 w-full overflow-hidden bg-gray-100 dark:bg-gray-900">
                        @php
                            $imageSrc = ($product->image && str_starts_with($product->image, 'http')) ? $product->image : asset('storage/' . $product->image);
                        @endphp

                        @if($product->image)
                            <img src="{{ $imageSrc }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 {{ $product->stock <= 0 ? 'grayscale opacity-40' : '' }}" onerror="this.onerror=null; this.src='https://placehold.co/600x800/1a1b26/FFF?text=No+Image';">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 dark:text-gray-600 bg-gray-200 dark:bg-[#15161c]">
                                <span class="text-xs font-bold">NO PREVIEW</span>
                            </div>
                        @endif

                        <div class="absolute top-3 left-3">
                            <span class="bg-white/90 dark:bg-black/60 backdrop-blur-sm text-gray-900 dark:text-white text-[10px] font-bold px-2 py-1 rounded border border-gray-200 dark:border-white/10 shadow-sm">
                                KEY
                            </span>
                        </div>

                        @if($product->stock <= 0)
                            <div class="absolute inset-0 flex items-center justify-center bg-white/80 dark:bg-black/60 backdrop-blur-[2px] z-10">
                                <span class="bg-red-600 text-white text-xs font-black px-4 py-2 rounded-sm -rotate-3 tracking-widest shadow-lg border-2 border-red-500/50">SOLD OUT</span>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-gray-100 dark:from-[#1a1b26] via-transparent to-transparent opacity-90"></div>
                    </div>

                    <div class="p-5 flex flex-col flex-grow relative -mt-8 z-10">
                        
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-2 py-0.5 rounded border border-indigo-200 dark:border-indigo-500/30">
                                {{ $product->category->name ?? 'GAME' }}
                            </span>

                            @if (config('features.show_rating_stars'))
                            <div class="flex items-center gap-1 bg-white/80 dark:bg-black/40 backdrop-blur-md px-2 py-1 rounded-full border border-gray-200 dark:border-white/5 shadow-sm dark:shadow-none">
                                <svg class="w-3 h-3 text-yellow-500 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <span class="text-xs font-bold text-gray-800 dark:text-white">{{ $product->average_rating }}</span>
                            </div>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold text-black dark:text-white mb-1 leading-snug group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-1" title="{{ $product->name }}">
                            {{ $product->name }}
                        </h3>
                        
                        <div class="flex items-center gap-1 mb-3">
                             <span class="text-[10px] font-medium text-gray-500 dark:text-gray-500 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                {{ $product->total_sold }} Sold
                            </span>
                        </div>

                        <div class="flex-grow"></div> 

                        <div class="flex justify-between items-end mt-4 pt-4 border-t border-gray-200 dark:border-gray-800">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-500 dark:text-gray-500 uppercase tracking-wider font-bold">Price</span>
                                <span class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-cyan-500 dark:from-indigo-400 dark:to-cyan-300">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-[#252630] text-indigo-600 dark:text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm dark:shadow-lg group-hover:shadow-indigo-500/30">
                                @if($product->stock > 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                @endif
                            </div>
                        </div>

                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-12 px-4 sm:px-0">
                {{ $products->links() }}
            </div>

            @if($products->isEmpty())
                <div class="text-center mt-20 py-16 bg-white dark:bg-[#1a1b26] rounded-xl border border-dashed border-gray-300 dark:border-gray-700 shadow-sm">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-black dark:text-gray-300">No Games Found</h3>
                    <p class="mt-1 text-gray-500">Coba kata kunci lain atau reset filter.</p>
                    <a href="{{ route('home') }}" class="mt-4 inline-block text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 underline">Reset All</a>
                </div>
            @endif

        </div>
    </div>

    <script>
        let timeout = null;

        function fetchSuggestions(query) {
            const list = document.getElementById('suggestion-list');
            const container = document.getElementById('search-suggestions');

            if (query.length < 2) {
                container.classList.add('hidden');
                return;
            }

            clearTimeout(timeout);
            timeout = setTimeout(async () => {
                try {
                    const response = await fetch(`{{ route('search.suggestions') }}?query=${query}`);
                    const products = await response.json();

                    list.innerHTML = '';

                    if (products.length > 0) {
                        container.classList.remove('hidden');
                        products.forEach(product => {
                            const li = document.createElement('li');
                            const isDark = document.documentElement.classList.contains('dark');
                            const textColor = isDark ? '#ffffff' : '#000000';
                            const hoverColor = isDark ? '#818cf8' : '#4f46e5';
                            
                            // PERBAIKAN: Warna teks JUDUL GAME dipaksa HITAM saat Light Mode
                            li.innerHTML = `
                                <a href="${product.url}" class="block px-4 py-3 bg-white dark:bg-[#1a1b26] hover:bg-gray-100 dark:hover:bg-indigo-900/30 transition flex items-center gap-3 group border-b border-gray-100 dark:border-gray-800 last:border-0">
                                    <img src="${product.image}" class="w-10 h-10 object-cover rounded bg-gray-200 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                    <div>
                                        <div class="font-bold text-sm transition-colors game-title" style="color: ${textColor};">${product.name}</div>
                                        <div class="text-xs text-gray-500 dark:text-indigo-400 font-mono mt-0.5">Rp ${product.price}</div>
                                    </div>
                                </a>
                            `;
                            list.appendChild(li);
                        });
                    } else {
                        container.classList.remove('hidden');
                        list.innerHTML = `<li class="px-4 py-3 bg-white dark:bg-[#1a1b26] text-gray-500 dark:text-gray-400 text-center italic text-sm">No games found.</li>`;
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }, 300);
        }

        document.addEventListener('click', function (e) {
            const container = document.getElementById('search-suggestions');
            const input = document.getElementById('search-input');
            if (container && input && !container.contains(e.target) && e.target !== input) {
                container.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>