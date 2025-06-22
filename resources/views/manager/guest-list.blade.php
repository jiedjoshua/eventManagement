<x-manager-layout title="Guest Lists" :active-page="'guest-lists'">
    <h1 class="text-3xl font-bold mb-8">Guest Lists</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
        <div x-data="{ showModal: false, guests: [], pagination: {}, loading: false, loadGuests(page = 1) {
            this.loading = true;
            fetch(`{{ url('/manager/events') }}/{{ $event->id }}/guests?page=${page}`)
                .then(res => res.json())
                .then(data => {
                    this.guests = data.guests;
                    this.pagination = data.pagination;
                    this.loading = false;
                    this.showModal = true;
                });
        } }" class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-indigo-700">{{ ucwords($event->event_name) }}</h2>
                    <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}</p>
                    <p class="text-gray-500 text-sm">Type: {{ ucwords($event->event_type) }}</p>
                    <p class="text-sm font-medium text-indigo-600">Total Guests: {{ $event->guests_count ?? 0 }}</p>
                </div>
                <button @click="loadGuests()" class="ml-4 px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    View Guests
                </button>
            </div>

            <!-- Modal -->
            <div x-show="showModal" style="display: none" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg mx-auto p-6 relative">
                    <button @click="showModal = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                    <h3 class="text-xl font-bold mb-4 text-indigo-700">Guest List</h3>
                    <template x-if="loading">
                        <div class="text-center py-8 text-gray-500">Loading...</div>
                    </template>
                    <template x-if="!loading">
                        <div>
                            <ul class="divide-y divide-gray-200 max-h-80 overflow-y-auto">
                                <template x-for="guest in guests" :key="guest.id">
                                    <li class="py-2 flex justify-between items-center">
                                        <span x-text="guest.first_name + ' ' + guest.last_name"></span>
                                        <template x-if="guest.pivot && guest.pivot.rsvp_status">
                                            <span class="text-xs px-2 py-1 rounded"
                                                :class="guest.pivot.rsvp_status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600'">
                                                <span x-text="guest.pivot.rsvp_status.charAt(0).toUpperCase() + guest.pivot.rsvp_status.slice(1)"></span>
                                            </span>
                                        </template>
                                    </li>
                                </template>
                            </ul>
                            <!-- Pagination Controls -->
                            <div class="flex justify-between items-center mt-4" x-show="pagination.last_page > 1">
                                <button
                                    class="px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300"
                                    :disabled="!pagination.prev_page_url"
                                    @click="loadGuests(pagination.current_page - 1)">
                                    Previous
                                </button>
                                <span class="text-sm text-gray-500">Page <span x-text="pagination.current_page"></span> of <span x-text="pagination.last_page"></span></span>
                                <button
                                    class="px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300"
                                    :disabled="!pagination.next_page_url"
                                    @click="loadGuests(pagination.current_page + 1)">
                                    Next
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center text-gray-500">
            No events found.
        </div>
        @endforelse
    </div>

    @push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    @endpush
</x-manager-layout> 