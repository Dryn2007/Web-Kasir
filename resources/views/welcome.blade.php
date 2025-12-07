<x-app-layout>
    <div class="relative overflow-hidden bg-[#0f1016]">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-7xl pointer-events-none">
            <div
                class="absolute top-20 left-20 w-96 h-96 bg-indigo-600 rounded-full mix-blend-screen filter blur-[100px] opacity-20">
            </div>
            <div
                class="absolute top-40 right-20 w-72 h-72 bg-purple-600 rounded-full mix-blend-screen filter blur-[100px] opacity-20">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter mb-6 brand-font drop-shadow-lg">
                LEVEL UP YOUR <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">DIGITAL
                    LIBRARY</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-400 font-light">
                Dapatkan Game Key, Software Original, dan Voucher Game termurah dengan pengiriman instan otomatis.
            </p>
            <div class="mt-10 flex justify-center gap-4">
                <a href="#browse-games"
                    class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-sm skew-x-[-10deg] transition shadow-[0_0_20px_rgba(79,70,229,0.3)] hover:shadow-[0_0_30px_rgba(79,70,229,0.6)]">
                    <span class="skew-x-[10deg] inline-block">BROWSE GAMES</span>
                </a>
            </div>
        </div>
    </div>

    <div id="browse-games" class="py-16 bg-[#0b0c15]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-center mb-10 px-4 sm:px-0 gap-6">

                <h2 class="text-2xl md:text-3xl font-bold text-white flex items-center gap-3 brand-font">
                    <span class="w-1 h-8 bg-indigo-500 rounded-full shadow-[0_0_10px_#6366f1]"></span>
                    TRENDING NOW
                </h2>

                <div class="w-full md:w-96 relative group z-30">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-600 rounded opacity-50 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 blur">
                    </div>

                    <form action="{{ route('home') }}" method="GET" class="relative">
                        <input type="hidden" name="ref" value="search">

                        <div class="flex items-center bg-[#1a1b26] rounded leading-none relative z-10">
                            <span class="absolute left-4 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>

                            <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                                class="w-full bg-transparent text-gray-200 py-3 pl-12 pr-4 focus:outline-none placeholder-gray-500 font-bold border-none focus:ring-0"
                                placeholder="Search games (e.g. Elden Ring)..." autocomplete="off"
                                onkeyup="fetchSuggestions(this.value)" onfocus="fetchSuggestions(this.value)">
                        </div>
                    </form>

                    <div id="search-suggestions"
                        class="absolute w-full bg-[#1a1b26] border border-gray-700 rounded-b-lg shadow-2xl mt-1 hidden overflow-hidden z-50">
                        <ul id="suggestion-list" class="divide-y divide-gray-800 text-sm text-gray-300"></ul>
                    </div>
                </div>

            </div>

            @if(request('search'))
                <div
                    class="mb-6 px-4 sm:px-0 flex items-center justify-between bg-indigo-900/20 p-4 rounded border border-indigo-500/30">
                    <p class="text-gray-300">
                        Showing results for: <span class="text-white font-bold text-lg">"{{ request('search') }}"</span>
                        <span class="text-gray-500 text-sm ml-2">({{ $products->total() }} items found)</span>
                    </p>
                    <a href="{{ route('home') }}"
                        class="text-xs bg-red-500/20 text-red-400 px-3 py-1.5 rounded hover:bg-red-500/40 border border-red-500/30 transition flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Clear Search
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 px-4 sm:px-0">
            
                @foreach($products as $product)
                    <a href="{{ route('product.show', $product->id) }}"
                        class="group relative flex flex-col bg-[#1a1b26] rounded-2xl overflow-hidden border border-gray-800 hover:border-indigo-500/50 transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_-10px_rgba(79,70,229,0.3)]">

                        <div class="relative h-64 w-full overflow-hidden bg-gray-900">

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
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 {{ $product->stock <= 0 ? 'grayscale opacity-40' : '' }}"
                                    onerror="this.onerror=null; this.src='https://placehold.co/600x800/1a1b26/FFF?text=No+Image';">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-600 bg-[#15161c]">
                                    <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-xs font-bold">NO PREVIEW</span>
                                </div>
                            @endif

                            <div class="absolute top-3 left-3">
                                <span
                                    class="bg-black/60 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded border border-white/10 shadow-sm">
                                    KEY
                                </span>
                            </div>

                            @if($product->stock <= 0)
                                <div class="absolute inset-0 flex items-center justify-center bg-black/60 backdrop-blur-[2px] z-10">
                                    <span
                                        class="bg-red-600 text-white text-xs font-black px-4 py-2 rounded-sm -rotate-3 tracking-widest shadow-lg border-2 border-red-500/50">
                                        SOLD OUT
                                    </span>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-[#1a1b26] via-transparent to-transparent opacity-90">
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-grow relative -mt-8 z-10">

                            <div class="flex justify-between items-center mb-2">
                                <div
                                    class="flex items-center gap-1 bg-black/40 backdrop-blur-md px-2 py-1 rounded-full border border-white/5">
                                    <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                    <span class="text-xs font-bold text-white">{{ $product->average_rating }}</span>
                                </div>
                                <span
                                    class="text-[10px] font-medium text-gray-400 bg-black/40 px-2 py-1 rounded-full border border-white/5">
                                    {{ $product->total_sold }} Sold
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-white mb-1 leading-snug group-hover:text-indigo-400 transition-colors line-clamp-1"
                                title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>

                            <div class="flex-grow"></div>

                            <div class="flex justify-between items-end mt-4 pt-4 border-t border-gray-800">
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-gray-500 uppercase tracking-wider font-bold">Price</span>
                                    <span
                                        class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-300">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div
                                    class="w-10 h-10 rounded-xl bg-[#252630] text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-lg group-hover:shadow-indigo-500/30">
                                    @if($product->stock > 0)
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 transform group-hover:scale-110 transition-transform" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
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
                <div class="text-center mt-20 py-16 bg-[#1a1b26] rounded-xl border border-dashed border-gray-700">
                    <svg class="mx-auto h-12 w-12 text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-300">No Games Found for "{{ request('search') }}"</h3>
                    <p class="mt-1 text-gray-500">Coba kata kunci lain atau reset pencarian.</p>
                    <a href="{{ route('home') }}"
                        class="mt-4 inline-block text-indigo-400 hover:text-indigo-300 underline">View All Games</a>
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
                            li.innerHTML = `
                                <a href="${product.url}" class="block px-4 py-3 hover:bg-indigo-900/30 hover:text-white transition flex items-center gap-3">
                                    <img src="${product.image}" class="w-10 h-10 object-cover rounded bg-gray-800">
                                    <div>
                                        <div class="font-bold text-gray-100">${product.name}</div>
                                        <div class="text-xs text-indigo-400 font-mono">Rp ${product.price}</div>
                                    </div>
                                </a>
                            `;
                            list.appendChild(li);
                        });
                    } else {
                        container.classList.remove('hidden');
                        list.innerHTML = `<li class="px-4 py-3 text-gray-500 text-center italic">No games found.</li>`;
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }, 300);
        }

        document.addEventListener('click', function (e) {
            const container = document.getElementById('search-suggestions');
            const input = document.getElementById('search-input');
            if (!container.contains(e.target) && e.target !== input) {
                container.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>