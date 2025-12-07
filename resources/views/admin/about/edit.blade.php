<x-app-layout>
    <div class="py-12 bg-[#0b0c15] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-[#1a1b26] overflow-hidden shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-800 p-8">

                @if(session('success'))
                    <div
                        class="mb-6 p-4 bg-green-900/20 border border-green-500/50 text-green-400 rounded-lg font-bold text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label class="block text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Page Title
                            (Headline)</label>
                        <input type="text" name="title" value="{{ $about->title }}"
                            class="w-full bg-[#0f1016] border border-gray-700 text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-600 transition font-bold text-lg">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-400 mb-2 font-bold text-xs uppercase tracking-wider">Content /
                            Story</label>
                        <textarea name="content" rows="10"
                            class="w-full bg-[#0f1016] border border-gray-700 text-white rounded p-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-600 transition leading-relaxed">{{ $about->content }}</textarea>
                        <p class="text-xs text-gray-500 mt-2">Tips: Gunakan Enter untuk membuat paragraf baru.</p>
                    </div>

                    <div class="mb-8 p-6 bg-[#0f1016] rounded border border-gray-700">
                        <label class="block text-gray-300 font-bold mb-4 border-b border-gray-700 pb-2">HERO
                            IMAGE</label>

                        @if($about->image)
                            <div class="mb-4">
                                <p class="text-xs text-gray-500 mb-2">Current Image:</p>
                                <img src="{{ asset('storage/' . $about->image) }}"
                                    class="h-40 w-auto rounded border border-gray-600 object-cover">
                            </div>
                        @endif

                        <label class="block text-gray-400 text-xs font-bold mb-2 uppercase">Upload New Image
                            (Optional)</label>
                        <input type="file" name="image" class="block w-full text-sm text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-sm file:border-0
                            file:text-xs file:font-semibold
                            file:bg-indigo-600 file:text-white
                            hover:file:bg-indigo-700
                            cursor-pointer bg-[#1a1b26] border border-gray-700 rounded p-1">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded font-bold shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-[0_0_25px_rgba(79,70,229,0.6)] transition text-sm flex items-center gap-2">
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
</x-app-layout>