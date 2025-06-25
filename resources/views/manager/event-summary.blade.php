<x-manager-layout title="Event Summary" :active-page="'event-summary'">
    <h1 class="text-3xl font-bold mb-8">Event Summary</h1>

    <div x-data="{ showDetails: false, showFeedbacks: false, selectedEventId: null }" class="bg-white rounded-lg shadow-md p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Venue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Guests</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg. Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($events as $event)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $event->event_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $event->event_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $event->event_date->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $event->venue_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($event->status) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $event->guest_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $event->avg_rating ? number_format($event->avg_rating, 2) : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button @click="showDetails = true; selectedEventId = {{ $event->id }}" class="text-indigo-600 hover:underline mr-2">Details</button>
                                <button @click="showFeedbacks = true; selectedEventId = {{ $event->id }}" class="text-indigo-600 hover:underline">Feedbacks</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No events found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Details Modal (single, Blade renders selected event) -->
        <div x-show="showDetails" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                <button @click="showDetails = false; selectedEventId = null" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
                <h2 class="text-2xl font-bold mb-4">Event Details</h2>
                <template x-if="selectedEventId">
                    @foreach ($events as $event)
                        <div x-show="selectedEventId === {{ $event->id }}">
                            <ul class="space-y-2">
                                <li><strong>Name:</strong> {{ $event->event_name }}</li>
                                <li><strong>Type:</strong> {{ $event->event_type }}</li>
                                <li><strong>Date:</strong> {{ $event->event_date->format('Y-m-d') }}</li>
                                <li><strong>Venue:</strong> {{ $event->venue_name }}</li>
                                <li><strong>Status:</strong> {{ ucfirst($event->status) }}</li>
                                <li><strong>Total Guests:</strong> {{ $event->guest_count }}</li>
                                <li><strong>Average Rating:</strong> {{ $event->avg_rating ? number_format($event->avg_rating, 2) : '-' }}</li>
                            </ul>
                        </div>
                    @endforeach
                </template>
            </div>
        </div>

        <!-- Feedbacks Modal (single, Blade renders selected event) -->
        <div x-show="showFeedbacks" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
                <button @click="showFeedbacks = false; selectedEventId = null" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
                <h2 class="text-2xl font-bold mb-4">Feedbacks</h2>
                <template x-if="selectedEventId">
                    @foreach ($events as $event)
                        <div x-show="selectedEventId === {{ $event->id }}">
                            <h3 class="text-lg font-semibold mb-2">{{ $event->event_name }}</h3>
                            <div class="overflow-x-auto max-h-96">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comments</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($event->feedbacks as $feedback)
                                            <tr>
                                                <td class="px-4 py-2 whitespace-nowrap">{{ $feedback->user->first_name ?? 'N/A' }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <svg class="w-4 h-4 {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.46a1 1 0 00-.364 1.118l1.287 3.966c.3.921-.755 1.688-1.54 1.118l-3.388-2.46a1 1 0 00-1.175 0l-3.388 2.46c-.784.57-1.838-.197-1.539-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.045 9.394c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.967z" />
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                </td>
                                                <td class="px-4 py-2 whitespace-nowrap">{{ $feedback->title }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap">{{ $feedback->comments }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap">{{ $feedback->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-4 py-2 text-center text-gray-500">No feedbacks found for this event.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </template>
            </div>
        </div>
    </div>
</x-manager-layout> 