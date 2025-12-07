<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight brand-font tracking-wider">
                USER <span class="text-indigo-600 dark:text-indigo-500">MANAGEMENT</span>
            </h2>
            <a href="{{ route('admin.dashboard') }}"
                class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                &larr; BACK TO DASHBOARD
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0b0c15] min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-[#1a1b26] overflow-hidden shadow-lg dark:shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-200 dark:border-gray-800 p-6 transition-colors duration-300">

                <div class="mb-6 flex justify-between items-end border-b border-gray-200 dark:border-gray-700 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-500 dark:text-gray-300 uppercase tracking-widest">Total
                            Customers
                        </h3>
                        <p class="text-3xl font-black text-gray-900 dark:text-white brand-font">{{ $users->total() }}
                        </p>
                    </div>
                </div>

                @if($users->isEmpty())
                    <div
                        class="text-center py-20 bg-gray-50 dark:bg-[#0f1016] rounded-lg border border-dashed border-gray-300 dark:border-gray-700">
                        <p class="text-gray-500">No users found.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-gray-100 dark:bg-[#0f1016] border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">
                                    <th class="px-6 py-4 rounded-tl-lg">User Name</th>
                                    <th class="px-6 py-4">Email Address</th>
                                    <th class="px-6 py-4">Joined Date</th>
                                    <th class="px-6 py-4 text-center">Stats</th>
                                    <th class="px-6 py-4 rounded-tr-lg text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 dark:text-gray-300 text-sm">
                                @foreach($users as $user)
                                    <tr
                                        class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-[#20222c] transition duration-200 group">

                                        <td
                                            class="px-6 py-4 font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-300 font-bold border border-indigo-200 dark:border-indigo-500/30">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            {{ $user->name }}
                                        </td>

                                        <td class="px-6 py-4 font-mono text-gray-500 dark:text-gray-400">
                                            {{ $user->email }}
                                        </td>

                                        <td class="px-6 py-4 text-gray-500 text-xs uppercase tracking-wider font-bold">
                                            {{ $user->created_at->format('d M Y') }}
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            @if($user->orders_count > 0)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-500/30">
                                                    {{ $user->orders_count }} Orders
                                                </span>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-600 text-xs">-</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-right flex justify-end gap-2">

                                            <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}"
                                                class="bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-900/40 p-2 rounded transition border border-blue-200 dark:border-blue-900/30"
                                                title="View Transaction History">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('WARNING: Deleting this user will erase all their order history permanently. Continue?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-500 hover:text-red-700 dark:hover:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/40 p-2 rounded transition border border-red-200 dark:border-red-900/30"
                                                    title="Delete User Account">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>