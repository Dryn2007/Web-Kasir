<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">Selamat datang, Admin! Ini area khusus Anda.</p>

                    <hr class="my-4 border-gray-200">

                    <h3 class="font-bold text-lg mb-4">Manajemen Produk</h3>

                    <div class="flex space-x-4">
                        <!-- Tombol Create Produk (Sesuai Request) -->
                        <a href="{{ route('admin.products.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-150 ease-in-out">
                            + Tambah Produk Baru
                        </a>

                        <!-- Tombol Lihat Semua Produk (Opsional, tapi sangat berguna) -->
                        <a href="{{ route('admin.products.index') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-150 ease-in-out">
                            Lihat Semua Produk
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>