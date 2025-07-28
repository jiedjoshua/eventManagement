<x-manager-layout title="Refund History" :active-page="'refund-history'">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Refund History</h1>
                <p class="text-gray-600 mt-1">View all refund transactions</p>
            </div>

            <!-- Stats Cards -->
            <div class="flex gap-4">
                <div class="flex items-center bg-gradient-to-r from-red-100 to-red-50 px-6 py-4 rounded-xl shadow border border-red-200 min-w-[140px]">
                    <div class="bg-red-500 text-white rounded-full p-2 mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-red-700">{{ $refunds->total() }}</div>
                        <div class="text-sm text-gray-600">Total Refunds</div>
                    </div>
                </div>
                <div class="flex items-center bg-gradient-to-r from-green-100 to-green-50 px-6 py-4 rounded-xl shadow border border-green-200 min-w-[140px]">
                    <div class="bg-green-500 text-white rounded-full p-2 mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-700">₱{{ number_format($totalRefundAmount, 2) }}</div>
                        <div class="text-sm text-gray-600">Total Refunded</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Refunds Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Refund Transactions</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($refunds as $refund)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $refund->reference }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $refund->booking->event_name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">{{ $refund->booking->event_type ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $refund->user->first_name ?? '' }} {{ $refund->user->last_name ?? '' }}
                            </div>
                            <div class="text-sm text-gray-500">{{ $refund->user->email ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-red-600">
                                -₱{{ number_format(abs($refund->amount), 2) }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">
                                {{ $refund->refund_reason ?? 'Event cancellation' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($refund->paid_at)->format('M d, Y') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($refund->paid_at)->format('g:i A') }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Refunds Yet</h3>
                                <p class="text-gray-600">Refund transactions will appear here when events are cancelled.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($refunds->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $refunds->links() }}
        </div>
        @endif
    </div>
</x-manager-layout> 