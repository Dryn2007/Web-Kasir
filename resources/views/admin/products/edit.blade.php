<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Produk</label>
                        <input type="text" name="name" class="w-full border p-2 rounded" required value="{{ $product->name }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Harga</label>
                        <input type="number" name="price" class="w-full border p-2 rounded" required value="{{ $product->price }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Stok</label>
                        <input type="number" name="stock" class="w-full border p-2 rounded" required value="{{ $product->stock }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea name="description" class="w-full border p-2 rounded">{{ $product->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold">Link Download Game / Produk</label>
                        <input type="url" name="download_url" class="w-full border border-gray-300 p-2 rounded"
                            placeholder="https://google.drive.com/..." required value="{{ $product->download_url }}">
                        
                    </div>

                    <div class="mb-4 p-4 bg-gray-50 rounded border border-gray-200">
                        <label class="block text-gray-700 font-bold mb-2">Ganti Gambar (Opsional)</label>
                    
                        @if($product->image)
                            <div class="mb-3">
                                <p class="text-xs text-gray-500 mb-1">Gambar Saat Ini:</p>
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}"
                                    class="h-20 w-auto rounded border">
                            </div>
                        @endif
                    
                        <div class="mb-3">
                            <label class="text-xs font-bold text-gray-500 uppercase">Opsi 1: Upload Baru</label>
                            <input type="file" name="image" class="w-full border bg-white p-2 rounded text-sm">
                        </div>
                    
                        <div class="text-center text-xs text-gray-400 my-2">- ATAU -</div>
                    
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase">Opsi 2: Link Gambar Baru</label>
                            <input type="url" name="image_url" class="w-full border p-2 rounded text-sm" placeholder="https://..."
                                value="{{ Str::startsWith($product->image, 'http') ? $product->image : '' }}">
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>