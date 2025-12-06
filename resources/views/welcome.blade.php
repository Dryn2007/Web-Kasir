<x-app-layout>
    <div class="bg-gray-900 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl md:text-6xl">
                Selamat Datang di Toko Kami
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-300">
                Temukan produk terbaik dengan harga terjangkau. Kualitas terjamin dan pengiriman cepat.
            </p>
            <div class="mt-8 flex justify-center">
                <a href="#produk-terbaru"
                    class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-white hover:bg-gray-100 md:py-4 md:text-lg md:px-10">
                    Belanja Sekarang
                </a>
            </div>
        </div>
    </div>

    <div id="produk-terbaru" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 px-4 sm:px-0">Produk Terbaru</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-4 sm:px-0">

                @foreach($products as $product)
                    <a href="{{ route('product.show', $product->id) }}" class="group">
                        <div
                            class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow duration-300 flex flex-col h-full border border-gray-100">

                            <div class="h-48 w-full bg-gray-200 overflow-hidden relative">
                                @if($product->stock <= 0)
                                    <div
                                        class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-2 py-1 m-2 rounded z-10">
                                        HABIS
                                    </div>
                                @endif

                                

                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 {{ $product->stock <= 0 ? 'grayscale opacity-60' : '' }}">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-500">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 flex flex-col justify-between flex-grow">
                                <div>
                                    <h3
                                        class="text-lg font-bold text-gray-800 mb-1 truncate group-hover:text-blue-600 transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                </div>

                                <div class="mt-2">
                                    <p class="text-blue-600 font-bold text-lg">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Stok: {{ $product->stock }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
            <div class="mt-8 px-4 sm:px-0">
                {{ $products->links() }}
            </div>

            @if($products->isEmpty())
                <div class="text-center text-gray-500 mt-10 py-10 bg-white rounded-lg shadow-sm">
                    <p>Belum ada produk yang ditampilkan.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>