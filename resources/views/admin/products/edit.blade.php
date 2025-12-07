<x-app-layout>
    @if (config('features.product_management.enabled') && config('features.product_management.edit'))
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight brand-font tracking-wider">
                    EDIT <span class="text-indigo-600 dark:text-indigo-500">PRODUCT</span>
                </h2>
                <a href="{{ route('admin.products.index') }}"
                    class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                    &larr; BACK TO LIST
                </a>
            </div>
        </x-slot>

        <div class="py-12 bg-gray-50 dark:bg-[#0b0c15] min-h-screen transition-colors duration-300">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-[#1a1b26] overflow-hidden shadow-lg dark:shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-200 dark:border-gray-800 p-8 transition-colors duration-300">

                    <form action="{{ route('admin.products.update', $product) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="mb-4 col-span-2">
                                <label
                                    class="block text-gray-500 dark:text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Product
                                    Name</label>
                                <input type="text" name="name" value="{{ $product->name }}"
                                    class="w-full bg-gray-50 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-400 dark:placeholder-gray-600 transition"
                                    required>
                            </div>

                            @if (config('features.product_management.set_price'))
                                <div class="mb-4">
                                    <label
                                        class="block text-gray-500 dark:text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Price
                                        (IDR)</label>
                                    <input type="number" name="price" value="{{ $product->price }}"
                                        class="w-full bg-gray-50 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-400 dark:placeholder-gray-600 transition"
                                        required>
                                </div>
                            @endif

                            @if (config('features.product_management.set_stock'))
                                <div class="mb-4">
                                    <label
                                        class="block text-gray-500 dark:text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Stock
                                        Quantity</label>
                                    <input type="number" name="stock" value="{{ $product->stock }}"
                                        class="w-full bg-gray-50 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-400 dark:placeholder-gray-600 transition"
                                        required>
                                </div>
                            @endif

                            @if (config('features.product_management.assign_category'))
                                <div class="mb-4">
                                    <label
                                        class="block text-gray-500 dark:text-gray-400 text-xs font-bold mb-2">CATEGORY</label>
                                    <select name="category_id"
                                        class="w-full bg-gray-50 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                        </div>

                        <div class="mb-6">
                            <label
                                class="block text-gray-500 dark:text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Description</label>
                            <textarea name="description" rows="4"
                                class="w-full bg-gray-50 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-400 dark:placeholder-gray-600 transition">{{ $product->description }}</textarea>
                        </div>

                        @if (config('features.product_management.set_download'))
                            <div class="mb-6">
                                <label
                                    class="block text-gray-500 dark:text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Download
                                    Link
                                    / Access Key</label>
                                <input type="url" name="download_url" value="{{ $product->download_url }}"
                                    class="w-full bg-gray-50 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-400 dark:placeholder-gray-600 transition font-mono text-sm"
                                    required>
                            </div>
                        @endif

                        @if (config('features.product_management.upload_image'))
                            <div
                                class="mb-8 p-6 bg-gray-50 dark:bg-[#0f1016] rounded border border-gray-200 dark:border-gray-700">
                                <label
                                    class="block text-gray-700 dark:text-gray-300 font-bold mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">UPDATE
                                    IMAGE</label>

                                @if($product->image)
                                    <div
                                        class="mb-6 flex items-center gap-4 bg-white dark:bg-[#1a1b26] p-3 rounded border border-gray-200 dark:border-gray-700 w-fit">
                                        @php
                                            $imageSrc = str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image);
                                        @endphp
                                        <img src="{{ $imageSrc }}"
                                            class="h-16 w-16 object-cover rounded border border-gray-300 dark:border-gray-600">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-bold">Current Image
                                            </p>
                                            <p class="text-[10px] text-gray-400 dark:text-gray-500 truncate max-w-[200px]">
                                                {{ $product->image }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                                    <div>
                                        <label
                                            class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase mb-2 block">Option
                                            1: Upload
                                            New File</label>
                                        <input type="file" name="image"
                                            class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                    file:mr-4 file:py-2 file:px-4
                                                    file:rounded-sm file:border-0
                                                    file:text-xs file:font-semibold
                                                    file:bg-indigo-600 file:text-white
                                                    hover:file:bg-indigo-700
                                                    cursor-pointer bg-white dark:bg-[#1a1b26] border border-gray-300 dark:border-gray-700 rounded p-1">
                                    </div>
                                    <div>
                                        <label
                                            class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase mb-2 block">Option
                                            2: New
                                            Image URL</label>
                                        <input type="url" name="image_url"
                                            value="{{ str_starts_with($product->image, 'http') ? $product->image : '' }}"
                                            class="w-full bg-white dark:bg-[#1a1b26] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded p-2 text-sm focus:outline-none focus:border-indigo-500 placeholder-gray-400 dark:placeholder-gray-600"
                                            placeholder="https://example.com/image.jpg">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin.products.index') }}"
                                class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 font-bold rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition text-sm">CANCEL</a>

                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded font-bold shadow-lg dark:shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-xl dark:hover:shadow-[0_0_25px_rgba(79,70,229,0.6)] transition text-sm flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                SAVE CHANGES
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    @else
        <div class="py-16 bg-gray-50 dark:bg-[#0b0c15] min-h-screen flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Access Denied</h1>
                <p class="text-gray-500 dark:text-gray-400 mb-8">Editing products is currently disabled.</p>
                <a href="{{ route('admin.products.index') }}"
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded transition">
                    Back to Products
                </a>
            </div>
        </div>
    @endif
</x-app-layout>