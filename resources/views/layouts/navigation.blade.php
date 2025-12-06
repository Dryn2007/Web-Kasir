<nav x-data="{ open: false }" class="bg-[#0f1016]/90 backdrop-blur-md border-b border-indigo-500/30 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
                                <span
                                    class="text-xl font-black tracking-wider text-white brand-font group-hover:text-indigo-400 transition-colors">ADMIN<span
                                        class="text-indigo-500">PANEL</span></span>
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-8 w-8 text-indigo-500 group-hover:rotate-12 transition-transform duration-300"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                                <span
                                    class="text-2xl font-black tracking-wider text-white brand-font group-hover:text-indigo-400 transition-colors">{{ config('app.name') }}</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-8 w-8 text-indigo-500 group-hover:rotate-12 transition-transform duration-300"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <span
                                class="text-2xl font-black tracking-wider text-white brand-font group-hover:text-indigo-400 transition-colors">{{ config('app.name') }}</span>
                        </a>
                    @endauth
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    @auth
                        @if(Auth::user()->role !== 'admin')
                            <a href="{{ route('orders.index') }}"
                                class="text-gray-300 hover:text-white hover:bg-white/5 px-3 py-2 rounded-md font-bold text-sm transition {{ request()->routeIs('orders.index') ? 'text-indigo-400' : '' }}">
                                {{ __('Riwayat Pesanan') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">

                @if (config('features.darkmode'))
                    <button id="dark-mode-toggle"
                        class="mr-4 text-gray-400 hover:text-white transition p-2 rounded-full hover:bg-white/10">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>
                @endif

                @auth
                    @if(Auth::user()->role !== 'admin')
                        <a href="{{ route('cart.index') }}"
                            class="relative group mr-6 text-gray-400 hover:text-white transition p-2">
                            <div
                                class="absolute inset-0 bg-indigo-500 rounded-full opacity-0 group-hover:opacity-20 transition blur-md">
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 relative" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>

                            @if(Auth::user()->carts->count() > 0)
                                <span
                                    class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded border-2 border-[#0f1016]">
                                    {{ Auth::user()->carts->count() }}
                                </span>
                            @endif
                        </a>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-4 py-2 border border-indigo-500/30 text-sm font-bold rounded text-indigo-300 bg-[#1a1b26] hover:bg-indigo-900/30 hover:text-white hover:border-indigo-400 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-[#1a1b26] border border-gray-700 text-gray-300">
                                <x-dropdown-link :href="route('profile.edit')"
                                    class="hover:bg-indigo-600 hover:text-white transition">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="text-red-400 hover:bg-red-900/30 hover:text-red-300 transition">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}"
                            class="text-gray-300 hover:text-white font-bold transition text-sm">LOGIN</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-sm font-bold skew-x-[-10deg] transition shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-[0_0_25px_rgba(79,70,229,0.6)] text-sm">
                                <span class="skew-x-[10deg] inline-block">JOIN NOW</span>
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#1a1b26] border-t border-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')"
                        class="text-gray-300 hover:text-white hover:bg-indigo-900/50">
                        {{ __('Admin Dashboard') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="text-gray-300 hover:text-white hover:bg-indigo-900/50">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')"
                        class="text-gray-300 hover:text-white hover:bg-indigo-900/50">
                        {{ __('Riwayat Pesanan') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')"
                        class="text-gray-300 hover:text-white hover:bg-indigo-900/50 flex justify-between items-center">
                        <span>{{ __('Keranjang Belanja') }}</span>
                        @if(Auth::user()->carts->count() > 0)
                            <span class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                                {{ Auth::user()->carts->count() }} Item
                            </span>
                        @endif
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-700">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-400 hover:text-white">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-400 hover:text-red-300">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1 p-4">
                    <x-responsive-nav-link :href="route('login')" class="text-gray-300 hover:text-white">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')"
                            class="text-indigo-400 hover:text-indigo-300 font-bold">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>