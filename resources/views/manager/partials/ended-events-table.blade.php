<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Feedback Count</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg. Rating</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($events as $event)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                    {{ $event->event_name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-700 font-bold">
                    {{ $event->feedbacks_count }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if($event->feedbacks_count > 0 && $event->average_rating)
                        <span class="text-yellow-500 mr-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($event->average_rating))
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star text-gray-300"></i>
                                @endif
                            @endfor
                        </span>
                        <span class="text-gray-700 font-semibold">{{ number_format($event->average_rating, 1) }}</span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right">
                    <a href="{{ route('manager.eventFeedbacks', $event) }}"
                       class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">View Feedbacks</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                    No ended events found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div> 