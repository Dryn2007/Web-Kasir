<x-app-layout>
    <div class="py-12 bg-[#0b0c15] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1a1b26] overflow-hidden shadow-[0_0_20px_rgba(79,70,229,0.1)] sm:rounded-lg border border-gray-800 p-6">

                <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-4">
                    @if(request('user_id'))
                        <div>
                            <h3 class="text-lg font-bold text-gray-300">
                                Transactions by: 
                                <span class="text-indigo-400 font-black">
                                    {{ $orders->first()->user->name ?? 'Unknown User' }}
                                </span>
                            </h3>
                            <a href="{{ route('admin.orders.index') }}" class="text-xs text-gray-500 hover:text-white underline mt-1 block">
                                &laquo; View All Transactions
                            </a>
                        </div>
                    @else
                        <div>
                            <h3 class="text-lg font-bold text-white uppercase tracking-widest text-xs">All Incoming Transactions</h3>
                            <p class="text-gray-500 text-xs">Total: {{ $orders->total() }} Records</p>
                        </div>
                    @endif
                </div>

                @if($orders->isEmpty())
                    <div class="text-center py-20 bg-[#0f1016] rounded-lg border border-dashed border-gray-700">
                        <p class="text-gray-500">No transactions found.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#0f1016] border-b border-gray-700 text-gray-400 uppercase text-xs tracking-wider">
                                    <th class="px-6 py-4 rounded-tl-lg">ID</th>
                                    <th class="px-6 py-4">Customer</th>
                                    <th class="px-6 py-4">Total</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Method</th>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4 rounded-tr-lg text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-300 text-sm">
                                @foreach($orders as $order)
                                    <tr class="border-b border-gray-800 hover:bg-[#20222c] transition duration-200 group">
                                        
                                        <td class="px-6 py-4 font-mono text-gray-500 font-bold">
                                            #{{ $order->id }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="font-bold text-white">{{ $order->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                        </td>

                                        <td class="px-6 py-4 font-bold text-indigo-300 font-mono">
                                            Rp {{ number_format($order->total_price) }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if($order->status == 'paid')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900/30 text-green-300 border border-green-500/30">
                                                    Paid
                                                </span>
                                            @elseif($order->status == 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900/30 text-yellow-300 border border-yellow-500/30 animate-pulse">
                                                    Pending
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900/30 text-red-300 border border-red-500/30">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 uppercase text-xs font-bold text-gray-400">
                                            {{ $order->payment_method }}
                                        </td>

                                        <td class="px-6 py-4 text-xs text-gray-500">
                                            {{ $order->created_at->format('d M Y') }}
                                            <span class="block text-[10px]">{{ $order->created_at->format('H:i') }}</span>
                                        </td>

                                        <td class="px-6 py-4 text-right flex justify-end gap-2 items-center">
                                            
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-blue-900/20 text-blue-400 hover:text-blue-300 hover:bg-blue-900/40 p-2 rounded transition border border-blue-900/30" title="View Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            @if($order->status == 'pending')
                                                <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" onsubmit="return confirm('Manually approve this payment?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-green-900/20 text-green-400 hover:text-green-300 hover:bg-green-900/40 p-2 rounded transition border border-green-900/30" title="Approve Payment">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>