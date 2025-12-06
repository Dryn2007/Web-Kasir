<x-app-layout>
   

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <a href="{{ route('admin.products.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Produk</a>

                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Gambar</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Harga</th>
                            <th class="px-4 py-2">Stok</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="border px-4 py-2">
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
                                        <img src="{{ $imageSrc }}" alt="{{ $product->name }}" class="w-[200px] h-full object-cover">
                                    @else
                                        <span class="text-gray-400">No Image</span>
                                    @endif
                                </td>
                                <td class="border px-4 py-2">{{ $product->name }}</td>
                                <td class="border px-4 py-2">Rp {{ number_format($product->price) }}</td>
                                <td class="border px-4 py-2">{{ $product->stock }}</td>
                                <td class="border px-4 py-2 flex gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-yellow-600">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>