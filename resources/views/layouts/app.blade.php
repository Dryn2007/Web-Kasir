<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                function checkAuth(e) {
                    // Cek status login
                    const isGuest = {{ auth()->guest() ? 'true' : 'false' }};

                    if (isGuest) {
                        // STOP! Jangan kirim form dulu
                        e.preventDefault();

                        // Munculkan Pop-up
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

                        // Return false biar form bener-bener berhenti
                        return false;
                    }

                    // Jika user SUDAH login, script ini tidak melakukan apa-apa.
                    // Form akan terkirim secara otomatis karena tombolnya type="submit".
                    return true;
                }
            </script>
            <script>
                let timeout = null;

                function fetchSuggestions(query) {
                    const list = document.getElementById('suggestion-list');
                    const container = document.getElementById('search-suggestions');

                    // Jika kosong, sembunyikan
                    if (query.length < 2) {
                        container.classList.add('hidden');
                        return;
                    }

                    // Debounce (Tunggu user selesai ngetik sebentar biar gak spam server)
                    clearTimeout(timeout);
                    timeout = setTimeout(async () => {
                        try {
                            // Fetch data dari route Laravel
                            const response = await fetch(`{{ route('search.suggestions') }}?query=${query}`);
                            const products = await response.json();

                            // Kosongkan list lama
                            list.innerHTML = '';

                            if (products.length > 0) {
                                container.classList.remove('hidden');

                                // Loop hasil dan buat HTML
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
                                // Jika tidak ada hasil
                                container.classList.remove('hidden');
                                list.innerHTML = `
                                    <li class="px-4 py-3 text-gray-500 text-center italic">
                                        No games found.
                                    </li>
                                `;
                            }
                        } catch (error) {
                            console.error('Error fetching suggestions:', error);
                        }
                    }, 300); // Delay 300ms
                }

                // Klik di luar search bar untuk menutup suggestion
                document.addEventListener('click', function (e) {
                    const container = document.getElementById('search-suggestions');
                    const input = document.getElementById('search-input');

                    if (!container.contains(e.target) && e.target !== input) {
                        container.classList.add('hidden');
                    }
                });
            </script>


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
