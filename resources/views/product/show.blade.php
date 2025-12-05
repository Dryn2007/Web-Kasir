<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="h-96 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </div>

                        <div class="flex flex-col justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                                <p class="text-2xl text-blue-600 font-bold mb-4">Rp {{ number_format($product->price) }}
                                </p>

                                <div class="mb-6">
                                    <span
                                        class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        Stok: {{ $product->stock }}
                                    </span>
                                </div>

                                <h3 class="text-lg font-semibold mb-2">Deskripsi Produk:</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                            </div>

                            <div class="mt-8">
                                @if($product->stock > 0)
                                    <div class="flex gap-4">
                                        <form action="{{ route('buy.now', $product->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition">
                                                Beli Sekarang
                                            </button>
                                        </form>

                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-gray-100 text-gray-800 font-bold py-3 px-4 rounded-lg hover:bg-gray-200 border border-gray-300 transition flex items-center justify-center"
                                                title="Masukkan Keranjang">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-3 px-6 rounded-lg cursor-not-allowed">
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>