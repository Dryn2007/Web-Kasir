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
