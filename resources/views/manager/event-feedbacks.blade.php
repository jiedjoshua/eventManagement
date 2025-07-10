<x-manager-layout title="Event Feedbacks" :active-page="'ended-events'">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Feedbacks for: {{ $event->event_name }}</h1>
        <p class="text-gray-600 mb-2">Event Date: {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</p>
        <a href="{{ route('manager.endedEvents') }}" class="text-indigo-600 hover:underline text-sm">&larr; Back to Ended Events</a>
    </div>

    <!-- Star Filter -->
    <form method="GET" action="" class="mb-6 flex items-center space-x-2">
        <label for="rating" class="text-sm font-medium text-gray-700">Filter by Rating:</label>
        <select name="rating" id="rating" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1 focus:ring-indigo-500 focus:border-indigo-500">
            <option value="" {{ empty($selectedRating) ? 'selected' : '' }}>All</option>
            @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ $selectedRating == $i ? 'selected' : '' }}>{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
            @endfor
        </select>
    </form>

    <div class="bg-white rounded-lg shadow-md p-6">
        @if($feedbacks->isEmpty())
            <div class="text-gray-500 text-center py-8">
                No feedbacks submitted for this event{{ $selectedRating ? ' with ' . $selectedRating . ' star' . ($selectedRating > 1 ? 's' : '') : '' }}.
            </div>
        @else
            <div class="space-y-6">
                @foreach($feedbacks as $feedback)
                    <div class="border-b pb-4">
                        <div class="flex items-center mb-2">
                            <span class="font-semibold text-gray-800 mr-2">{{ $feedback->user->first_name }} {{ $feedback->user->last_name }}</span>
                            <span class="ml-2 text-yellow-500">
                                @for($i = 0; $i < $feedback->rating; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                @for($i = $feedback->rating; $i < 5; $i++)
                                    <i class="far fa-star text-gray-300"></i>
                                @endfor
                            </span>
                            <span class="ml-auto text-xs text-gray-500">{{ $feedback->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        @if($feedback->title)
                            <div class="font-bold text-indigo-700 mb-1">{{ $feedback->title }}</div>
                        @endif
                        <div class="text-gray-700">{{ $feedback->comments }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-manager-layout> 