<x-manager-layout title="Ended Events" :active-page="'ended-events'">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Ended Events</h1>
        <p class="text-gray-600">View all ended events and their feedbacks</p>
    </div>

    <!-- Search Form -->
    <form method="GET" action="" class="mb-6 flex items-center space-x-2">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search event name..." class="border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 w-64">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Search</button>
        @if(!empty($search))
            <a href="{{ route('manager.endedEvents') }}" class="text-gray-500 hover:underline ml-2">Clear</a>
        @endif
    </form>

    <div class="bg-white rounded-lg shadow-md">
        <div id="ended-events-table">
            @include('manager.partials.ended-events-table', ['events' => $events])
        </div>
    </div>

    <script>
    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    const searchInput = document.querySelector('input[name="search"]');
    const tableDiv = document.getElementById('ended-events-table');
    let lastValue = searchInput ? searchInput.value : '';

    function showLoading() {
        tableDiv.innerHTML = `<div class='flex justify-center items-center py-12'><svg class='animate-spin h-8 w-8 text-indigo-600' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'><circle class='opacity-25' cx='12' cy='12' r='10' stroke='currentColor' stroke-width='4'></circle><path class='opacity-75' fill='currentColor' d='M4 12a8 8 0 018-8v8z'></path></svg></div>`;
    }

    async function fetchTable(value) {
        showLoading();
        const params = new URLSearchParams();
        if (value) params.append('search', value);
        const response = await fetch(`{{ route('manager.endedEvents.ajax') }}?${params.toString()}`);
        const html = await response.text();
        tableDiv.innerHTML = html;
    }

    if (searchInput) {
        searchInput.addEventListener('input', debounce(function(e) {
            const value = e.target.value;
            if (value !== lastValue) {
                lastValue = value;
                fetchTable(value);
            }
        }, 300));
    }
    </script>
</x-manager-layout> 