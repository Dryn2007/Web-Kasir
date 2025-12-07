<x-app-layout>
    @if (config('features.review_management.enabled'))
    @if (config('features.review_management.view_all'))
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight brand-font tracking-wider">
                REVIEW <span class="text-indigo-600 dark:text-indigo-500">MANAGEMENT</span>
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                &larr; BACK TO DASHBOARD
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0b0c15] min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#1a1b26] overflow-hidden shadow-lg dark:shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-200 dark:border-gray-800 p-6 transition-colors duration-300">

                <div class="mb-6">
                    <h3 class="text-sm font-bold text-gray-500 dark:text-gray-300 uppercase tracking-widest">Total Reviews: <span class="text-gray-900 dark:text-white">{{ $reviews->total() }}</span></h3>
                </div>

                @if($reviews->isEmpty())
                    <div class="text-center py-20 bg-gray-50 dark:bg-[#0f1016] rounded-lg border border-dashed border-gray-300 dark:border-gray-700">
                        <p class="text-gray-500">No reviews yet.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($reviews as $review)
                            <div class="bg-gray-50 dark:bg-[#0f1016] p-5 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 transition group">
                                <div class="flex flex-col md:flex-row gap-4">
                                    
                                    <div class="w-full md:w-1/4 border-b md:border-b-0 md:border-r border-gray-200 dark:border-gray-800 pb-4 md:pb-0 md:pr-4">
                                        <div class="flex items-center gap-3 mb-2">
                                            @if($review->product->image)
                                                <img src="{{ Str::startsWith($review->product->image, 'http') ? $review->product->image : asset('storage/' . $review->product->image) }}" class="w-10 h-10 rounded object-cover border border-gray-300 dark:border-gray-600">
                                            @endif
                                            <div>
                                                <div class="text-gray-900 dark:text-white font-bold text-sm line-clamp-1">{{ $review->product->name }}</div>
                                                <div class="text-indigo-600 dark:text-indigo-400 text-xs">by {{ $review->user->name }}</div>
                                            </div>
                                        </div>
                                        @if (config('features.show_rating_stars'))
                                        <div class="flex text-yellow-500 mb-1">
                                            @for($i=1; $i<=5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300 dark:text-gray-800 fill-current' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            @endfor
                                        </div>
                                        @endif
                                        <div class="text-gray-400 dark:text-gray-600 text-[10px]">{{ $review->created_at->format('d M Y, H:i') }}</div>
                                    </div>

                                    <div class="w-full {{ (config('features.review_management.reply') || config('features.review_management.delete')) ? 'md:w-2/4' : 'md:w-3/4' }}">
                                        <p class="text-gray-700 dark:text-gray-300 text-sm italic">"{{ $review->comment }}"</p>
                                        
                                        @if($review->admin_reply)
                                            <div class="mt-3 ml-4 pl-3 border-l-2 border-green-500">
                                                <p class="text-xs text-green-600 dark:text-green-400 font-bold mb-1">ADMIN REPLY:</p>
                                                <p class="text-gray-500 dark:text-gray-400 text-xs">{{ $review->admin_reply }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    @if (config('features.review_management.reply') || config('features.review_management.delete'))
                                    <div class="w-full md:w-1/4 flex flex-col items-end justify-center gap-2">
                                        @if (config('features.review_management.reply'))
                                        <button onclick="openReplyModal('{{ $review->id }}', '{{ $review->user->name }}', `{{ $review->comment }}`)" 
                                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 rounded transition flex items-center justify-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>
                                            {{ $review->admin_reply ? 'Edit Reply' : 'Reply' }}
                                        </button>
                                        @endif

                                        @if (config('features.review_management.delete'))
                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Delete this review?');" class="w-full">
                                            @csrf @method('DELETE')
                                            <button class="w-full bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-500 hover:bg-red-200 dark:hover:bg-red-900/40 text-xs font-bold py-2 rounded transition border border-red-200 dark:border-red-900/30">
                                                Delete
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $reviews->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    @if (config('features.review_management.reply'))
    <div id="replyModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-80 transition-opacity" onclick="closeReplyModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-[#1a1b26] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-200 dark:border-gray-700">
                <form id="replyForm" action="" method="POST" class="p-6">
                    @csrf
                    <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white mb-2">Reply to <span id="replyUser" class="text-indigo-600 dark:text-indigo-400">User</span></h3>
                    <p class="text-gray-500 text-xs mb-4 italic" id="replyCommentPreview">"..."</p>
                    
                    <div class="mb-4">
                        <label class="block text-gray-500 dark:text-gray-400 text-xs font-bold mb-2">Your Reply</label>
                        <textarea name="admin_reply" rows="4" class="w-full bg-gray-50 dark:bg-[#0f1016] border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded p-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-gray-400 dark:placeholder-gray-600 focus:outline-none" placeholder="Type your response here..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeReplyModal()" class="px-4 py-2 bg-transparent border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 rounded hover:text-gray-900 dark:hover:text-white text-sm font-bold">Cancel</button>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded font-bold text-sm shadow-lg">Send Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openReplyModal(id, user, comment) {
            const form = document.getElementById('replyForm');
            form.action = `/admin/reviews/${id}/reply`;
            document.getElementById('replyUser').innerText = user;
            document.getElementById('replyCommentPreview').innerText = `"${comment}"`;
            document.getElementById('replyModal').classList.remove('hidden');
        }
        function closeReplyModal() {
            document.getElementById('replyModal').classList.add('hidden');
        }
    </script>
    @endif
    @else
    <div class="py-16 bg-gray-50 dark:bg-[#0b0c15] min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Access Denied</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8">Viewing reviews is currently disabled.</p>
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded transition">
                Back to Dashboard
            </a>
        </div>
    </div>
    @endif
    @else
    <div class="py-16 bg-gray-50 dark:bg-[#0b0c15] min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Access Denied</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8">Review management is currently disabled.</p>
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded transition">
                Back to Dashboard
            </a>
        </div>
    </div>
    @endif
</x-app-layout>