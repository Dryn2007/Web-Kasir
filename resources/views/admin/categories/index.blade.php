<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight brand-font tracking-wider">
                CATEGORY <span class="text-indigo-600 dark:text-indigo-500">MANAGEMENT</span>
            </h2>
            <a href="{{ route('admin.dashboard') }}"
                class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                &larr; BACK TO DASHBOARD
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0b0c15] min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="col-span-1">
                    <div
                        class="bg-white dark:bg-[#1a1b26] p-6 rounded-lg border border-gray-200 dark:border-gray-800 shadow-lg transition-colors">
                        <h3
                            class="text-gray-900 dark:text-white font-bold mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            Add New Category</h3>

                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-500 dark:text-gray-400 text-xs font-bold mb-2">CATEGORY
                                    NAME</label>
                                <input type="text" name="name"
                                    class="w-full bg-gray-100 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded p-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    placeholder="e.g. RPG, Action..." required>
                            </div>
                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded transition shadow-md">
                                SAVE CATEGORY
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <div
                        class="bg-white dark:bg-[#1a1b26] overflow-hidden rounded-lg border border-gray-200 dark:border-gray-800 shadow-lg transition-colors">
                        <table class="w-full text-left text-sm text-gray-600 dark:text-gray-400">
                            <thead
                                class="bg-gray-100 dark:bg-[#0f1016] text-xs uppercase text-gray-500 font-bold border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">Slug</th>
                                    <th class="px-6 py-3 text-center">Total Products</th>
                                    <th class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach($categories as $cat)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-[#20222c] transition-colors">
                                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $cat->name }}</td>
                                        <td class="px-6 py-4 font-mono text-xs text-gray-500 dark:text-gray-400">
                                            {{ $cat->slug }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 px-2 py-1 rounded text-xs font-bold border border-indigo-200 dark:border-indigo-500/30">
                                                {{ $cat->products_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this category?');">
                                                @csrf @method('DELETE')
                                                <button
                                                    class="text-red-600 dark:text-red-500 hover:text-red-800 dark:hover:text-red-400 hover:underline font-medium transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>