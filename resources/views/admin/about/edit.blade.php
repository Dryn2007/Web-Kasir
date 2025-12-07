<x-app-layout>
    @if (config('features.about_management.enabled'))
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight brand-font tracking-wider">
                    ABOUT <span class="text-indigo-600 dark:text-indigo-500">SETTINGS</span>
                </h2>
                <a href="{{ route('admin.dashboard') }}"
                    class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                    &larr; BACK TO DASHBOARD
                </a>
            </div>
        </x-slot>

        <div class="py-12 bg-gray-50 dark:bg-[#0b0c15] min-h-screen transition-colors duration-300">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-[#1a1b26] overflow-hidden shadow-lg dark:shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-200 dark:border-gray-800 p-8 transition-colors duration-300">

                    @if(session('success'))
                        <div
                            class="mb-6 p-4 bg-green-100 dark:bg-green-900/20 border border-green-200 dark:border-green-500/50 text-green-700 dark:text-green-400 rounded-lg font-bold text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if (config('features.about_management.edit_title'))
                            <div class="mb-6">
                                <label
                                    class="block text-gray-500 dark:text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Page
                                    Title (Headline)</label>
                                <input type="text" name="title" value="{{ $about->title }}"
                                    class="w-full bg-gray-50 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-400 dark:placeholder-gray-600 transition font-bold text-lg">
                            </div>
                        @else
                            <input type="hidden" name="title" value="{{ $about->title }}">
                        @endif

                        @if (config('features.about_management.edit_content'))
                            <div class="mb-6">
                                <label
                                    class="block text-gray-500 dark:text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Content
                                    / Story</label>
                                <textarea name="content" rows="10"
                                    class="w-full bg-gray-50 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-400 dark:placeholder-gray-600 transition leading-relaxed">{{ $about->content }}</textarea>
                                <p class="text-xs text-gray-500 mt-2">Tips: Gunakan Enter untuk membuat paragraf baru.</p>
                            </div>
                        @else
                            <input type="hidden" name="content" value="{{ $about->content }}">
                        @endif

                        @if (config('features.about_management.edit_image'))
                            <div
                                class="mb-8 p-6 bg-gray-50 dark:bg-[#0f1016] rounded border border-gray-200 dark:border-gray-700 transition-colors">
                                <label
                                    class="block text-gray-700 dark:text-gray-300 font-bold mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">HERO
                                    IMAGE</label>

                                @if($about->image)
                                    <div class="mb-4">
                                        <p class="text-xs text-gray-500 mb-2">Current Image:</p>
                                        <img src="{{ asset('storage/' . $about->image) }}"
                                            class="h-40 w-auto rounded border border-gray-300 dark:border-gray-600 object-cover shadow-sm">
                                    </div>
                                @endif

                                <label class="block text-gray-500 dark:text-gray-400 text-xs font-bold mb-2 uppercase">Upload
                                    New Image (Optional)</label>
                                <input type="file" name="image"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-sm file:border-0
                                        file:text-xs file:font-semibold
                                        file:bg-indigo-600 file:text-white
                                        hover:file:bg-indigo-700
                                        cursor-pointer bg-white dark:bg-[#1a1b26] border border-gray-300 dark:border-gray-700 rounded p-1 transition-colors">
                            </div>
                        @endif

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded font-bold shadow-lg hover:shadow-xl transition text-sm flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                UPDATE PAGE
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @else
        <div class="py-16 bg-gray-50 dark:bg-[#0b0c15] min-h-screen flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Access Denied</h1>
                <p class="text-gray-500 dark:text-gray-400 mb-8">About management is currently disabled.</p>
                <a href="{{ route('admin.dashboard') }}"
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded transition">
                    Back to Dashboard
                </a>
            </div>
        </div>
    @endif
</x-app-layout>