<x-app-layout>
  

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Produk</label>
                        <input type="text" name="name" class="w-full border p-2 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Harga</label>
                        <input type="number" name="price" class="w-full border p-2 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Stok</label>
                        <input type="number" name="stock" class="w-full border p-2 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea name="description" class="w-full border p-2 rounded"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold">Link Download Game / Produk</label>
                        <input type="url" name="download_url" class="w-full border border-gray-300 p-2 rounded"
                            placeholder="https://google.drive.com/..." required>
                        <p class="text-xs text-gray-500">Masukkan link Google Drive, Mediafire, atau akses lainnya.</p>
                    </div>

                    <div class="mb-4 p-4 bg-gray-50 rounded border border-gray-200">
                        <label class="block text-gray-700 font-bold mb-2">Gambar Produk (Pilih Salah Satu)</label>
                    
                        <div class="mb-3">
                            <label class="text-xs font-bold text-gray-500 uppercase">Opsi 1: Upload File</label>
                            <input type="file" name="image" class="w-full border bg-white p-2 rounded text-sm">
                        </div>
                    
                        <div class="text-center text-xs text-gray-400 my-2">- ATAU -</div>
                    
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase">Opsi 2: Link Gambar (URL)</label>
                            <input type="url" name="image_url" class="w-full border p-2 rounded text-sm"
                                placeholder="https://example.com/gambar-game.jpg">
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>