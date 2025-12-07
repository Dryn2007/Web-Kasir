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
        // 1. Auth Check untuk Tombol Beli
        function checkAuth(e) {
            const isGuest = {{ auth()->guest() ? 'true' : 'false' }};

            if (isGuest) {
                e.preventDefault();
                Swal.fire({
                    title: 'Login Dulu, Bro!',
                    text: "Kamu harus login untuk membeli produk ini.",
                    icon: 'warning',
                    background: '#1a1b26',
                    color: '#fff',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#374151',
                    confirmButtonText: 'Login Sekarang',
                    cancelButtonText: 'Nanti'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('login') }}";
                    }
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

            if (query.length < 2) {
                container.classList.add('hidden');
                return;
            }

            clearTimeout(timeout);
            timeout = setTimeout(async () => {
                try {
                    const response = await fetch(`{{ route('search.suggestions') }}?query=${query}`);
                    const products = await response.json();

                    list.innerHTML = '';

                    if (products.length > 0) {
                        container.classList.remove('hidden');
                        products.forEach(product => {
                            const li = document.createElement('li');
                            li.innerHTML = `
                                    <a href="${product.url}" class="block px-4 py-3 hover:bg-indigo-900/30 hover:text-white transition flex items-center gap-3">
                                        <img src="${product.image}" class="w-10 h-10 object-cover rounded bg-gray-800">
                                        <div>
                                            <div class="font-bold text-gray-100">${product.name}</div>
                                            <div class="text-xs text-indigo-400 font-mono">Rp ${product.price}</div>
                                        </div>
                                    </a>
                                `;
                            list.appendChild(li);
                        });
                    } else {
                        container.classList.remove('hidden');
                        list.innerHTML = `<li class="px-4 py-3 text-gray-500 text-center italic">No games found.</li>`;
                    }
                } catch (error) {
                    console.error('Error fetching suggestions:', error);
                }
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

<body class="font-sans antialiased bg-gray-100 dark:bg-[#0b0c15]">

    <div class="min-h-screen">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white dark:bg-[#1a1b26] shadow border-b border-gray-800">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    @auth
        @if(Auth::user()->role !== 'admin')
            <div x-data="{ 
                                chatOpen: false, 
                                message: '', 
                                messages: [],
                                unreadCount: 0, // [BARU] Variabel hitung pesan belum dibaca

                                init() {
                                    // Polling pesan setiap 3 detik
                                    setInterval(() => {
                                        fetch('{{ route('chat.get') }}')
                                        .then(res => res.json())
                                        .then(data => { 
                                            this.messages = data; 

                                            // Hitung unread hanya jika chat SEDANG TUTUP
                                            if (!this.chatOpen) {
                                                // Hitung pesan dari admin (is_admin=1) yang belum dibaca (is_read=0)
                                                this.unreadCount = this.messages.filter(m => m.is_admin == 1 && m.is_read == 0).length;
                                            }
                                        });
                                    }, 3000);
                                },

                                toggleChat() {
                                    this.chatOpen = !this.chatOpen;

                                    if (this.chatOpen) {
                                        // Saat dibuka: Reset badge & Tandai sudah dibaca di database
                                        this.unreadCount = 0;
                                        fetch('{{ route('chat.read') }}', {
                                            method: 'POST',
                                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                        });
                                        // Scroll ke bawah
                                        setTimeout(() => {
                                            const box = document.getElementById('userChatBox');
                                            box.scrollTop = box.scrollHeight;
                                        }, 100);
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
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            Live Support
                        </h3>
                        <button @click="toggleChat()" class="text-white hover:text-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </button>
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
                            class="flex flex-col items-center justify-center h-full text-gray-500 space-y-2 opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <p class="text-xs">Start a conversation...</p>
                        </div>
                    </div>

                    <div class="p-3 bg-[#1a1b26] border-t border-gray-700">
                        <form @submit.prevent="
                                        if(message.trim() === '') return;
                                        fetch('{{ route('chat.send') }}', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                            body: JSON.stringify({ message: message })
                                        }).then(() => {
                                            message = ''; 
                                            fetch('{{ route('chat.get') }}').then(res => res.json()).then(data => { 
                                                messages = data;
                                                setTimeout(() => {
                                                    const box = document.getElementById('userChatBox');
                                                    box.scrollTop = box.scrollHeight;
                                                }, 100);
                                            });
                                        });
                                    " class="flex gap-2 items-center">
                            <input x-model="message" type="text" placeholder="Type a message..."
                                class="w-full bg-[#0f1016] text-white text-xs rounded-lg border border-gray-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 p-2.5 placeholder-gray-500">
                            <button type="submit"
                                class="bg-indigo-600 text-white p-2.5 rounded-lg hover:bg-indigo-700 transition shadow-lg flex-shrink-0">
                                <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <button @click="toggleChat()"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white p-4 rounded-full shadow-[0_0_20px_rgba(79,70,229,0.6)] transition transform hover:scale-110 flex items-center justify-center relative group">

                    <div x-show="unreadCount > 0" class="absolute -top-1 -right-1 flex h-5 w-5 z-20">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span
                            class="relative inline-flex rounded-full h-5 w-5 bg-red-600 text-white text-[10px] font-bold items-center justify-center border-2 border-[#0b0c15]"
                            x-text="unreadCount"></span>
                    </div>

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