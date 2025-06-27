<x-manager-layout title="Feedback Analytics" :active-page="'feedback-analytics'">
    <h1 class="text-3xl font-bold mb-8">Feedback Analytics</h1>

    <div class="bg-white rounded-lg shadow-md p-6 mb-10">
        <h2 class="text-xl font-semibold mb-4">Average Rating per Event</h2>
        <div class="h-96">
            <canvas id="avgRatingChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Feedback Summary Table</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Average Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Feedback Count</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($feedbacks as $feedback)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('manager.event.feedbacks', ['event' => $feedback->event_id]) }}" class="text-indigo-600 hover:underline">
                                    {{ $events[$feedback->event_id]->event_name ?? 'Unknown' }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($feedback->avg_rating, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $feedback->feedback_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('avgRatingChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($feedbacks->map(fn($f) => $events[$f->event_id]->event_name ?? 'Unknown')),
                datasets: [{
                    label: 'Average Rating',
                    data: @json($feedbacks->map(fn($f) => round($f->avg_rating, 2))),
                    backgroundColor: 'rgba(99, 102, 241, 0.7)',
                    borderColor: 'rgb(99, 102, 241)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, max: 5 }
                }
            }
        });
    </script>
    @endpush
</x-manager-layout> 