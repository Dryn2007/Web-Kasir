<x-app-layout>
    <div class="py-12 bg-[#0b0c15] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-[#1a1b26] overflow-hidden shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-800 p-8">

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="mb-4 col-span-2">
                            <label class="block text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Product
                                Name</label>
                            <input type="text" name="name"
                                class="w-full bg-[#0f1016] border border-gray-700 text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-600 transition"
                                placeholder="e.g. Elden Ring" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Price
                                (IDR)</label>
                            <input type="number" name="price"
                                class="w-full bg-[#0f1016] border border-gray-700 text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-600 transition"
                                placeholder="e.g. 599000" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Stock
                                Quantity</label>
                            <input type="number" name="stock"
                                class="w-full bg-[#0f1016] border border-gray-700 text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-600 transition"
                                placeholder="e.g. 100" required>
                        </div>

                    </div>

                    <div class="mb-6">
                        <label
                            class="block text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full bg-[#0f1016] border border-gray-700 text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-600 transition"
                            placeholder="Enter product description here..."></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Download Link
                            / Access Key</label>
                        <input type="url" name="download_url"
                            class="w-full bg-[#0f1016] border border-gray-700 text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-600 transition font-mono text-sm"
                            placeholder="https://store.steampowered.com/app/..." required>
                        <p class="text-xs text-gray-500 mt-2">Enter the direct download link, Steam Store link, or
                            Google Drive URL.</p>
                    </div>

                    <div class="mb-8 p-6 bg-[#0f1016] rounded border border-gray-700">
                        <label class="block text-gray-300 font-bold mb-4 border-b border-gray-700 pb-2">PRODUCT
                            IMAGE</label>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <div>
                                <label class="text-xs font-bold text-indigo-400 uppercase mb-2 block">Option 1: Upload
                                    File</label>
                                <input type="file" name="image" class="block w-full text-sm text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-sm file:border-0
                                file:text-xs file:font-semibold
                                file:bg-indigo-600 file:text-white
                                hover:file:bg-indigo-700
                                cursor-pointer bg-[#1a1b26] border border-gray-700 rounded p-1">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-indigo-400 uppercase mb-2 block">Option 2: Image
                                    URL</label>
                                <input type="url" name="image_url"
                                    class="w-full bg-[#1a1b26] border border-gray-700 text-white rounded p-2 text-sm focus:outline-none focus:border-indigo-500 placeholder-gray-600"
                                    placeholder="https://example.com/image.jpg">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('admin.products.index') }}"
                            class="px-6 py-3 border border-gray-600 text-gray-400 font-bold rounded hover:bg-gray-800 transition text-sm">CANCEL</a>

                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded font-bold shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-[0_0_25px_rgba(79,70,229,0.6)] transition text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            SAVE PRODUCT
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>