<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-white brand-font tracking-wide">PLAYER <span
                class="text-indigo-500">LOGIN</span></h2>
        <p class="text-gray-500 text-xs">Enter your credentials to access library</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="block font-medium text-sm text-gray-400">Email Address</label>
            <input id="email"
                class="block mt-1 w-full bg-[#0b0c15] border border-gray-700 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm placeholder-gray-600"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="user@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-400">Password</label>
            <input id="password"
                class="block mt-1 w-full bg-[#0b0c15] border border-gray-700 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm placeholder-gray-600"
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded bg-[#0b0c15] border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-gray-900"
                    name="remember">
                <span class="ms-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-500 hover:text-indigo-400 transition"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif

            <button type="submit"
                class="ms-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-sm skew-x-[-10deg] transition shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-[0_0_25px_rgba(79,70,229,0.6)]">
                <span class="skew-x-[10deg] inline-block tracking-wide">{{ __('LOG IN') }}</span>
            </button>
        </div>
    </form>
</x-guest-layout>