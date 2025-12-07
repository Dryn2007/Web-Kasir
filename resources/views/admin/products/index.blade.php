<x-app-layout>
    @if (config('features.product_management.enabled'))
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight brand-font tracking-wider">
                PRODUCT <span class="text-indigo-600 dark:text-indigo-500">MANAGEMENT</span>
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                &larr; BACK TO DASHBOARD
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0b0c15] min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#1a1b26] overflow-hidden shadow-lg dark:shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-200 dark:border-gray-800 p-6 transition-colors duration-300">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-sm font-bold text-gray-500 dark:text-gray-300 uppercase tracking-widest">
                        Total Database: <span class="text-gray-900 dark:text-white">{{ $products->total() }} Items</span>
                    </h3>
                    
                    @if (config('features.product_management.create'))
                    <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-sm font-bold text-sm shadow-lg dark:shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-xl dark:hover:shadow-[0_0_25px_rgba(79,70,229,0.6)] skew-x-[-10deg] transition flex items-center gap-2">
                        <span class="skew-x-[10deg] flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            ADD PRODUCT
                        </span>
                    </a>
                    @endif
                </div>

                <div class="bg-gray-50 dark:bg-[#0f1016] p-2 rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
                    <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col md:flex-row gap-2">
                        
                        <div class="relative w-full group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500 group-focus-within:text-indigo-500 dark:group-focus-within:text-indigo-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="w-full bg-white dark:bg-[#1a1b26] text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 block pl-10 p-2 text-sm placeholder-gray-400 dark:placeholder-gray-500 transition" 
                                   placeholder="Search product name...">
                        </div>

                        <div class="relative w-full md:w-48 flex-shrink-0">
                            <select name="category_id" onchange="this.form.submit()" class="w-full bg-white dark:bg-[#1a1b26] text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 block p-2 text-sm cursor-pointer">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="relative w-full md:w-48 flex-shrink-0">
                            <select name="sort" onchange="this.form.submit()" class="w-full bg-white dark:bg-[#1a1b26] text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 block p-2 text-sm cursor-pointer">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest Upload</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>🔥 Best Selling</option>
                                <option value="rating_high" {{ request('sort') == 'rating_high' ? 'selected' : '' }}>⭐ Highest Rating</option>
                                <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>Lowest Rating</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            </select>
                        </div>

                        @if(request('search') || request('sort') || request('category_id'))
                            <a href="{{ route('admin.products.index') }}" class="bg-red-100 dark:bg-red-500/10 hover:bg-red-200 dark:hover:bg-red-500/20 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/30 rounded px-4 py-2 flex items-center justify-center gap-2 text-xs font-bold transition" title="Reset Filters">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </a>
                        @endif
                    </form>
                </div>

                @if($products->isEmpty())
                    <div class="text-center py-20 bg-gray-50 dark:bg-[#0f1016] rounded-lg border border-dashed border-gray-300 dark:border-gray-700">
                        <p class="text-gray-500">No products found matching your filter.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-[#0f1016] border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">
                                    <th class="px-6 py-4 rounded-tl-lg">Product Details</th>
                                    <th class="px-6 py-4">Stats</th>
                                    <th class="px-6 py-4">Price</th>
                                    <th class="px-6 py-4">Stock</th>
                                    <th class="px-6 py-4 rounded-tr-lg text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 dark:text-gray-300 text-sm">
                                @foreach($products as $product)
                                    <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-[#20222c] transition duration-200 group">
                                        
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
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
                                                <div class="w-12 h-12 rounded overflow-hidden bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 flex-shrink-0 group-hover:border-indigo-500 transition">
                                                    @if($imageSrc)
                                                        <img src="{{ $imageSrc }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-[8px] text-gray-400 dark:text-gray-500">NO IMG</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">{{ $product->name }}</div>
                                                    
                                                    <span class="inline-block mt-1 text-[10px] uppercase font-bold tracking-wider text-indigo-600 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-900/30 px-1.5 py-0.5 rounded border border-indigo-200 dark:border-indigo-500/30">
                                                        {{ $product->category->name ?? 'Uncategorized' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex flex-col gap-1">
                                                <div class="flex items-center gap-2">
                                                    <div class="flex text-yellow-500">
                                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                    </div>
                                                    <span class="text-gray-900 dark:text-white font-bold text-xs">
                                                        {{ number_format($product->reviews_avg_rating ?? 0, 1) }}
                                                    </span>
                                                    <span class="text-gray-400 dark:text-gray-500 text-[10px]">({{ $product->reviews_count }})</span>
                                                </div>
                                                
                                                <div class="flex items-center gap-1 text-xs">
                                                    <span class="text-gray-600 dark:text-gray-400 font-bold">{{ $product->order_items_sum_quantity ?? 0 }}</span> <span class="text-gray-400 dark:text-gray-600">Sold</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 font-mono text-indigo-600 dark:text-indigo-300">
                                            Rp {{ number_format($product->price) }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if($product->stock > 10)
                                                <span class="text-green-600 dark:text-green-400 font-bold">{{ $product->stock }}</span>
                                            @elseif($product->stock > 0)
                                                <span class="text-yellow-600 dark:text-yellow-400 font-bold">{{ $product->stock }} (Low)</span>
                                            @else
                                                <span class="bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-500 px-2 py-1 rounded border border-red-200 dark:border-red-500/30 text-[10px] font-bold uppercase">Habis</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2 items-center">
                                                @if (config('features.product_management.update'))
                                                <a href="{{ route('admin.products.edit', $product) }}" class="text-yellow-600 dark:text-yellow-500 hover:text-yellow-700 dark:hover:text-yellow-300 bg-yellow-100 dark:bg-yellow-900/20 hover:bg-yellow-200 dark:hover:bg-yellow-900/40 p-2 rounded transition border border-yellow-200 dark:border-yellow-900/30">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                @endif

                                                @if (config('features.product_management.delete'))
                                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 dark:text-red-500 hover:text-red-700 dark:hover:text-red-300 bg-red-100 dark:bg-red-900/20 hover:bg-red-200 dark:hover:bg-red-900/40 p-2 rounded transition border border-red-200 dark:border-red-900/30">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
    @else
    <div class="py-16 bg-gray-50 dark:bg-[#0b0c15] min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Access Denied</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8">Product management is currently disabled.</p>
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded transition">
                Back to Dashboard
            </a>
        </div>
    </div>
    @endif
</x-app-layout>