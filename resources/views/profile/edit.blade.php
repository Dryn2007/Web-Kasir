<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight brand-font tracking-wider">
                PROFILE <span class="text-indigo-600 dark:text-indigo-500">SETTINGS</span>
            </h2>
            <a href="{{ route('home') }}"
                class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                &larr; BACK TO HOME
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0b0c15] min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (config('features.auth.edit_profile'))
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-[#1a1b26] border border-gray-200 dark:border-gray-800 shadow-lg dark:shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg transition-colors duration-300">
                    <div class="max-w-xl">
                        <h3
                            class="text-lg font-bold text-gray-900 dark:text-white mb-4 brand-font border-b border-gray-200 dark:border-gray-700 pb-2">
                            ACCOUNT <span class="text-indigo-600 dark:text-indigo-400">DETAILS</span>
                        </h3>

                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            @endif

            @if (config('features.auth.change_password'))
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-[#1a1b26] border border-gray-200 dark:border-gray-800 shadow-lg dark:shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg transition-colors duration-300">
                    <div class="max-w-xl">
                        <h3
                            class="text-lg font-bold text-gray-900 dark:text-white mb-4 brand-font border-b border-gray-200 dark:border-gray-700 pb-2">
                            SECURITY <span class="text-indigo-600 dark:text-indigo-400">SETTINGS</span>
                        </h3>

                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            @endif

            @if (config('features.auth.delete_account'))
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-[#1a1b26] border border-red-200 dark:border-red-900/30 shadow-lg dark:shadow-[0_0_20px_rgba(239,68,68,0.1)] sm:rounded-lg transition-colors duration-300">
                    <div class="max-w-xl">
                        <h3
                            class="text-lg font-bold text-red-600 dark:text-red-500 mb-4 brand-font border-b border-red-200 dark:border-red-900/30 pb-2">
                            DANGER <span class="text-gray-900 dark:text-white">ZONE</span>
                        </h3>

                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>