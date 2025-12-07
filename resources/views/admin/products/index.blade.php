<x-app-layout>
<div class="py-12 bg-[#0b0c15] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1a1b26] overflow-hidden shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-800 p-6">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-300 uppercase tracking-widest text-xs">Total Products: <span class="text-white">{{ $products->count() }}</span></h3>
                    
                    <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-sm font-bold text-sm shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-[0_0_25px_rgba(79,70,229,0.6)] skew-x-[-10deg] transition flex items-center gap-2">
                        <span class="skew-x-[10deg] flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            ADD NEW PRODUCT
                        </span>
                    </a>
                </div>

                @if($products->isEmpty())
                    <div class="text-center py-20 bg-[#0f1016] rounded-lg border border-dashed border-gray-700">
                        <p class="text-gray-500">No products available yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#0f1016] border-b border-gray-700 text-gray-400 uppercase text-xs tracking-wider">
                                    <th class="px-6 py-4 rounded-tl-lg">Image</th>
                                    <th class="px-6 py-4">Product Name</th>
                                    <th class="px-6 py-4">Price</th>
                                    <th class="px-6 py-4">Stock</th>
                                    <th class="px-6 py-4 rounded-tr-lg text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-300 text-sm">
                                @foreach($products as $product)
                                    <tr class="border-b border-gray-800 hover:bg-[#20222c] transition duration-200 group">
                                        <td class="px-6 py-4">
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

                                            <div class="w-16 h-16 rounded overflow-hidden bg-gray-900 border border-gray-700 relative group-hover:border-indigo-500 transition">
                                                @if($imageSrc)
                                                    <img src="{{ $imageSrc }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-500">NO IMG</div>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 font-bold text-white group-hover:text-indigo-400 transition">
                                            {{ $product->name }}
                                        </td>

                                        <td class="px-6 py-4 font-mono text-indigo-300">
                                            Rp {{ number_format($product->price) }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if($product->stock > 0)
                                                <span class="text-green-400 font-bold">{{ $product->stock }}</span>
                                            @else
                                                <span class="text-red-500 font-bold text-xs uppercase bg-red-900/20 px-2 py-1 rounded border border-red-900/50">Out of Stock</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-right flex justify-end gap-2 items-center h-full pt-8">
                                            
                                            <a href="{{ route('admin.products.edit', $product) }}" class="text-yellow-500 hover:text-yellow-300 bg-yellow-900/20 hover:bg-yellow-900/40 p-2 rounded transition border border-yellow-900/30" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-300 bg-red-900/20 hover:bg-red-900/40 p-2 rounded transition border border-red-900/30" title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>