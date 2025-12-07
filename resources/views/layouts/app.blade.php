<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // 1. Auth Check
        function checkAuth(e) {
            const isGuest = {{ auth()->guest() ? 'true' : 'false' }};
            if (isGuest) {
                e.preventDefault();
                Swal.fire({
                    title: 'Login Dulu, Bro!',
                    text: "Kamu harus login untuk membeli produk ini.",
                    icon: 'warning',
                    background: '#1a1b26', color: '#fff',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5', cancelButtonColor: '#374151',
                    confirmButtonText: 'Login Sekarang', cancelButtonText: 'Nanti'
                }).then((result) => {
                    if (result.isConfirmed) { window.location.href = "{{ route('login') }}"; }
                });
                return false;
            }
            return true;
        }

        // 2. Search Suggestion
        let timeout = null;
        function fetchSuggestions(query) {
            const list = document.getElementById('suggestion-list');
            const container = document.getElementById('search-suggestions');
            if (query.length < 2) { container.classList.add('hidden'); return; }

            clearTimeout(timeout);
            timeout = setTimeout(async () => {
                try {
                    const response = await fetch(`{{ route('search.suggestions') }}?query=${query}`);
                    const products = await response.json();
                    list.innerHTML = '';
                    if (products.length > 0) {
                        container.classList.remove('hidden');
                        const isDark = document.documentElement.classList.contains('dark');
                        products.forEach(product => {
                            const li = document.createElement('li');
                            li.innerHTML = `<a href="${product.url}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-white transition flex items-center gap-3"><img src="${product.image}" class="w-10 h-10 object-cover rounded bg-gray-200 dark:bg-gray-800"><div><div class="font-bold" style="color: ${isDark ? '#ffffff' : '#000000'};">${product.name}</div><div class="text-xs text-gray-500 dark:text-indigo-400 font-mono">Rp ${product.price}</div></div></a>`;
                            list.appendChild(li);
                        });
                    } else {
                        container.classList.remove('hidden');
                        list.innerHTML = `<li class="px-4 py-3 text-gray-500 text-center italic">No games found.</li>`;
                    }
                } catch (error) { console.error('Error:', error); }
            }, 300);
        }
        document.addEventListener('click', function (e) {
            const container = document.getElementById('search-suggestions');
            const input = document.getElementById('search-input');
            if (container && input && !container.contains(e.target) && e.target !== input) {
                container.classList.add('hidden');
            }
        });
    </script>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-[#0b0c15] text-gray-300">

    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white dark:bg-[#1a1b26] shadow border-b border-gray-800">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <footer class="bg-[#0a0a0f] border-t border-gray-800 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">

                    <div class="col-span-1 md:col-span-1">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <span
                                class="text-xl font-black text-white tracking-wider brand-font">{{ config('app.name') }}</span>
                        </a>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4">
                            Platform distribusi game digital terpercaya #1 di Indonesia.
                        </p>
                        <div class="flex gap-4">
                            <a href="#" class="text-gray-500 hover:text-white transition"><svg class="w-5 h-5"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                </svg></a>
                            <a href="#" class="text-gray-500 hover:text-white transition"><svg class="w-5 h-5"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg></a>
                        </div>
                    </div>

                    <div class="col-span-1">
                        <h4
                            class="text-white font-bold mb-4 uppercase tracking-wider text-xs border-l-2 border-indigo-500 pl-2">
                            Explore</h4>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li><a href="{{ route('home') }}" class="hover:text-indigo-400 transition">Store Home</a>
                            </li>
                            <li><a href="{{ route('home', ['sort' => 'popular']) }}"
                                    class="hover:text-indigo-400 transition">Best Sellers</a></li>
                            <li><a href="{{ route('home', ['sort' => 'latest']) }}"
                                    class="hover:text-indigo-400 transition">New Arrivals</a></li>
                            <li><a href="{{ route('about') }}" class="hover:text-indigo-400 transition">About Us</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-span-1">
                        <h4
                            class="text-white font-bold mb-4 uppercase tracking-wider text-xs border-l-2 border-green-500 pl-2">
                            Customer Service</h4>
                        <ul class="space-y-3 text-sm text-gray-500">
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 shrink-0"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>
                                    <span class="block text-gray-300 font-bold">WhatsApp Support</span>
                                    <a href="https://wa.me/6281234567890" target="_blank"
                                        class="hover:text-green-400 transition">+62 812-3456-7890</a>
                                </span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 shrink-0"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>
                                    <span class="block text-gray-300 font-bold">Email Us</span>
                                    <a href="mailto:support@gamestore.id"
                                        class="hover:text-indigo-400 transition">support@gamestore.id</a>
                                </span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 shrink-0"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>
                                    <span class="block text-gray-300 font-bold">Operating Hours</span>
                                    <span class="flex items-center gap-2 text-green-400 font-bold text-xs mt-0.5">
                                        <span class="relative flex h-2 w-2">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                        </span>
                                        24 Jam / 7 Hari
                                    </span>
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div class="col-span-1">
                        <h4
                            class="text-white font-bold mb-4 uppercase tracking-wider text-xs border-l-2 border-indigo-500 pl-2">
                            Accepted Payment</h4>
                        <div class="flex flex-wrap gap-2">
                            <div
                                class="bg-white p-1 rounded w-12 h-8 flex items-center justify-center opacity-80 hover:opacity-100 transition">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/1200px-Logo_QRIS.svg.png"
                                    class="h-4">
                            </div>
                            <div
                                class="bg-white p-1 rounded w-12 h-8 flex items-center justify-center opacity-80 hover:opacity-100 transition">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/2560px-Gopay_logo.svg.png"
                                    class="h-3">
                            </div>
                            <div
                                class="bg-white p-1 rounded w-12 h-8 flex items-center justify-center opacity-80 hover:opacity-100 transition">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/2560px-Logo_dana_blue.svg.png"
                                    class="h-3">
                            </div>
                        </div>
                    </div>

                </div>

                <div
                    class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-600">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                    <div class="flex gap-4 mt-4 md:mt-0">
                        <a href="#" class="hover:text-gray-400">Privacy Policy</a>
                        <a href="#" class="hover:text-gray-400">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @auth
        @if(Auth::user()->role !== 'admin')
            <div x-data="{ 
                                        chatOpen: false, 
                                        message: '', 
                                        messages: [],
                                        unreadCount: 0, 
                                        init() {
                                            setInterval(() => {
                                                fetch('{{ route('chat.get') }}')
                                                .then(res => res.json())
                                                .then(data => { 
                                                    this.messages = data; 
                                                    if (!this.chatOpen) {
                                                        this.unreadCount = this.messages.filter(m => m.is_admin == 1 && m.is_read == 0).length;
                                                    }
                                                });
                                            }, 3000);
                                        },
                                        toggleChat() {
                                            this.chatOpen = !this.chatOpen;
                                            if (this.chatOpen) {
                                                this.unreadCount = 0;
                                                fetch('{{ route('chat.read') }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                                                setTimeout(() => { const box = document.getElementById('userChatBox'); box.scrollTop = box.scrollHeight; }, 100);
                                            }
                                        }
                                     }" class="fixed bottom-6 right-6 z-50">

                <div x-show="chatOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-10 scale-95"
                    class="bg-[#1a1b26] border border-gray-700 w-80 h-96 rounded-2xl shadow-2xl flex flex-col overflow-hidden mb-4">

                    <div class="bg-indigo-600 p-4 flex justify-between items-center shadow-md">
                        <h3 class="text-white font-bold flex items-center gap-2 text-sm">
                            <span class="relative flex h-2 w-2"><span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span><span
                                    class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span></span> Live Support
                        </h3>
                        <button @click="toggleChat()" class="text-white hover:text-gray-200 transition"><svg class="w-5 h-5"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg></button>
                    </div>

                    <div class="flex-1 p-4 overflow-y-auto space-y-3 bg-[#0f1016]" id="userChatBox">
                        <template x-for="msg in messages" :key="msg.id">
                            <div class="flex" :class="msg.is_admin ? 'justify-start' : 'justify-end'">
                                <div class="max-w-[85%] p-2.5 rounded-xl text-xs shadow-sm"
                                    :class="msg.is_admin ? 'bg-gray-800 text-gray-200 rounded-tl-none border border-gray-700' : 'bg-indigo-600 text-white rounded-tr-none'">
                                    <p x-text="msg.message" class="leading-relaxed"></p>
                                </div>
                            </div>
                        </template>
                        <div x-show="messages.length === 0"
                            class="flex flex-col items-center justify-center h-full text-gray-500 space-y-2 opacity-50"><svg
                                xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <p class="text-xs">Start a conversation...</p>
                        </div>
                    </div>

                    <div class="p-3 bg-[#1a1b26] border-t border-gray-700">
                        <form
                            @submit.prevent="if(message.trim() === '') return; fetch('{{ route('chat.send') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ message: message }) }).then(() => { message = ''; fetch('{{ route('chat.get') }}').then(res => res.json()).then(data => { messages = data; setTimeout(() => { const box = document.getElementById('userChatBox'); box.scrollTop = box.scrollHeight; }, 100); }); });"
                            class="flex gap-2 items-center">
                            <input x-model="message" type="text" placeholder="Type a message..."
                                class="w-full bg-[#0f1016] text-white text-xs rounded-lg border border-gray-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 p-2.5 placeholder-gray-500">
                            <button type="submit"
                                class="bg-indigo-600 text-white p-2.5 rounded-lg hover:bg-indigo-700 transition shadow-lg flex-shrink-0"><svg
                                    class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg></button>
                        </form>
                    </div>
                </div>

                <button @click="toggleChat()"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white p-4 rounded-full shadow-[0_0_20px_rgba(79,70,229,0.6)] transition transform hover:scale-110 flex items-center justify-center relative group">
                    <div x-show="unreadCount > 0" class="absolute -top-1 -right-1 flex h-5 w-5 z-20"><span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span
                            class="relative inline-flex rounded-full h-5 w-5 bg-red-600 text-white text-[10px] font-bold items-center justify-center border-2 border-[#0b0c15]"
                            x-text="unreadCount"></span></div>
                    <svg x-show="!chatOpen" xmlns="http://www.w3.org/2000/svg"
                        class="h-7 w-7 transition-transform duration-300 group-hover:rotate-12" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <svg x-show="chatOpen" xmlns="http://www.w3.org/2000/svg"
                        class="h-7 w-7 transition-transform duration-300 group-hover:rotate-90" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif
    @endauth

</body>

</html>