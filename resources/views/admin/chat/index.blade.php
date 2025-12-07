<x-app-layout>
    @if (config('features.admin_chat.enabled'))
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight brand-font tracking-wider">
                    CUSTOMER <span class="text-indigo-600 dark:text-indigo-500">SUPPORT</span>
                </h2>
                <a href="{{ route('admin.dashboard') }}"
                    class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                    &larr; BACK TO DASHBOARD
                </a>
            </div>
        </x-slot>

        <div class="h-[calc(100vh-65px)] bg-gray-50 dark:bg-[#0b0c15] flex overflow-hidden transition-colors duration-300">

            <div
                class="w-1/3 bg-indigo-400 dark:bg-[#1a1b26] border-r border-gray-200 dark:border-gray-800 flex flex-col transition-colors duration-300">
                <div class="p-4 border-b border-gray-200 dark:border-gray-800">
                    <h2 class="text-white dark:text-white font-bold brand-font text-lg">INBOX</h2>
                </div>
                <div class="overflow-y-auto flex-1 custom-scrollbar">
                    @foreach($users as $user)
                        <a href="{{ route('admin.chat.show', $user->id) }}"
                            class="group flex items-center gap-3 p-4 border-b border-gray-200 dark:border-gray-800 hover:bg-indigo-200 dark:hover:bg-[#252630] transition {{ isset($activeUser) && $activeUser->id == $user->id ? 'bg-gray-100 dark:bg-[#252630] border-l-4 border-l-indigo-500' : '' }}">
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-white font-bold shrink-0">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="overflow-hidden">
                                <div class="flex justify-between items-center mb-1">
                                    <h4
                                        class="text-white group-hover:text-black dark:text-white dark:group-hover:text-white font-bold text-sm truncate">
                                        {{ $user->name }}
                                    </h4>
                                    @if($user->chats->last())
                                        <span
                                            class="text-[10px] text-white group-hover:text-black dark:text-gray-500 dark:group-hover:text-gray-500">{{ $user->chats->last()->created_at->format('H:i') }}</span>
                                    @endif
                                </div>
                                <p
                                    class="text-white group-hover:text-black dark:text-gray-400 dark:group-hover:text-gray-400 text-xs truncate">
                                    {{ $user->chats->last()->message ?? 'No messages' }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="w-2/3 flex flex-col bg-gray-50 dark:bg-[#0f1016] transition-colors duration-300">
                @if(isset($activeUser))
                    <div
                        class="p-4 bg-white dark:bg-[#1a1b26] border-b border-gray-200 dark:border-gray-800 flex items-center gap-3 transition-colors duration-300">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                            {{ substr($activeUser->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-gray-900 dark:text-white font-bold">{{ $activeUser->name }}</h3>
                            <p class="text-gray-500 text-xs">{{ $activeUser->email }}</p>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar bg-gray-50 dark:bg-[#0f1016]"
                        id="chatContainer">
                        @foreach($chats as $chat)
                            <div class="flex {{ $chat->is_admin ? 'justify-end' : 'justify-start' }}">
                                <div
                                    class="max-w-[70%] {{ $chat->is_admin ? 'bg-indigo-600 text-white rounded-l-lg rounded-br-lg' : 'bg-white dark:bg-[#252630] text-gray-800 dark:text-gray-200 rounded-r-lg rounded-bl-lg border border-gray-200 dark:border-gray-700' }} p-3 shadow-md">
                                    <p class="text-sm">{{ $chat->message }}</p>
                                    <span
                                        class="text-[10px] {{ $chat->is_admin ? 'text-indigo-200' : 'text-gray-400 dark:text-gray-500' }} block text-right mt-1">
                                        {{ $chat->created_at->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div
                        class="p-4 bg-white dark:bg-[#1a1b26] border-t border-gray-200 dark:border-gray-800 transition-colors duration-300">
                        <form action="{{ route('admin.chat.reply', $activeUser->id) }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="message" placeholder="Type a reply..."
                                class="flex-1 bg-gray-100 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-colors"
                                autocomplete="off" autofocus>
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <script>
                        // Auto scroll ke bawah
                        var chatContainer = document.getElementById("chatContainer");
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                    </script>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center text-gray-400 dark:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mb-4 opacity-20" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p>Select a user to start chatting</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="py-16 bg-gray-50 dark:bg-[#0b0c15] min-h-screen flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Access Denied</h1>
                <p class="text-gray-500 dark:text-gray-400 mb-8">Admin chat is currently disabled.</p>
                <a href="{{ route('admin.dashboard') }}"
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded transition">
                    Back to Dashboard
                </a>
            </div>
        </div>
    @endif
</x-app-layout>