<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk') }}
        </h2>
    </x-slot>

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

                    <div class="mb-4">
                        <label class="block text-gray-700">Gambar</label>
                        <input type="file" name="image" class="w-full border p-2 rounded">  
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>