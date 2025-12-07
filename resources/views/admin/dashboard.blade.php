<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white leading-tight brand-font tracking-wider">
            ADMIN <span class="text-indigo-500">CONSOLE</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0b0c15] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div
                class="bg-[#1a1b26] overflow-hidden shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-800 p-8 mb-8 relative">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-indigo-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Welcome back, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-400">System is ready. Select a module to manage.</p>
            </div>

            <h3 class="font-bold text-lg mb-4 text-gray-300 brand-font border-l-4 border-indigo-500 pl-3">MANAGEMENT
                MODULES</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <a href="{{ route('admin.products.index') }}"
                    class="group relative bg-[#1a1b26] p-6 rounded-xl border border-gray-800 hover:border-indigo-500 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(79,70,229,0.3)]">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-indigo-600/10 to-transparent opacity-0 group-hover:opacity-100 transition rounded-xl">
                    </div>
                    <div class="relative flex items-center gap-4">
                        <div
                            class="p-3 bg-[#0f1016] rounded-lg border border-gray-700 group-hover:border-indigo-500/50 group-hover:text-indigo-400 text-gray-400 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-lg group-hover:text-indigo-400 transition brand-font">
                                PRODUCTS</h4>
                            <p class="text-gray-500 text-xs mt-1">Catalog & Stock</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="group relative bg-[#1a1b26] p-6 rounded-xl border border-gray-800 hover:border-yellow-500 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(234,179,8,0.3)]">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-yellow-600/10 to-transparent opacity-0 group-hover:opacity-100 transition rounded-xl">
                    </div>
                    <div class="relative flex items-center gap-4">
                        <div
                            class="p-3 bg-[#0f1016] rounded-lg border border-gray-700 group-hover:border-yellow-500/50 group-hover:text-yellow-400 text-gray-400 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-lg group-hover:text-yellow-400 transition brand-font">
                                ORDERS</h4>
                            <p class="text-gray-500 text-xs mt-1">Payments & Status</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.reviews.index') }}"
                    class="group relative bg-[#1a1b26] p-6 rounded-xl border border-gray-800 hover:border-pink-500 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(236,72,153,0.3)]">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-pink-600/10 to-transparent opacity-0 group-hover:opacity-100 transition rounded-xl">
                    </div>
                    <div class="relative flex items-center gap-4">
                        <div
                            class="p-3 bg-[#0f1016] rounded-lg border border-gray-700 group-hover:border-pink-500/50 group-hover:text-pink-400 text-gray-400 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-lg group-hover:text-pink-400 transition brand-font">
                                REVIEWS</h4>
                            <p class="text-gray-500 text-xs mt-1">Feedback & Replies</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="group relative bg-[#1a1b26] p-6 rounded-xl border border-gray-800 hover:border-green-500 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(34,197,94,0.3)]">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-600/10 to-transparent opacity-0 group-hover:opacity-100 transition rounded-xl">
                    </div>
                    <div class="relative flex items-center gap-4">
                        <div
                            class="p-3 bg-[#0f1016] rounded-lg border border-gray-700 group-hover:border-green-500/50 group-hover:text-green-400 text-gray-400 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-lg group-hover:text-green-400 transition brand-font">
                                USERS</h4>
                            <p class="text-gray-500 text-xs mt-1">Manage Customers</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.about.edit') }}"
                    class="group relative bg-[#1a1b26] p-6 rounded-xl border border-gray-800 hover:border-cyan-500 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(34,211,238,0.3)]">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-cyan-600/10 to-transparent opacity-0 group-hover:opacity-100 transition rounded-xl">
                    </div>
                    <div class="relative flex items-center gap-4">
                        <div
                            class="p-3 bg-[#0f1016] rounded-lg border border-gray-700 group-hover:border-cyan-500/50 group-hover:text-cyan-400 text-gray-400 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-lg group-hover:text-cyan-400 transition brand-font">
                                ABOUT PAGE</h4>
                            <p class="text-gray-500 text-xs mt-1">Edit Content & Image</p>
                        </div>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>