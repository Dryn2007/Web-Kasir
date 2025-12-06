<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">Selamat datang, Admin! Ini area khusus Anda.</p>

                    <hr class="my-4 border-gray-200">

                    <h3 class="font-bold text-lg mb-4">Manajemen Produk</h3>

                   

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('admin.products.index') }}"
                            class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition">
                            📦 Kelola Produk
                        </a>
                    
                        <a href="{{ route('admin.users.index') }}"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition">
                            👥 Data Pelanggan
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>