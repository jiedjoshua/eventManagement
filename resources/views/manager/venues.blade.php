<x-manager-layout title="Venue Management" active-page="venues">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Venue Management</h1>
                <p class="text-gray-600 mt-1">View all venues in the system</p>
            </div>

            <!-- Stats Cards -->
            <div class="flex gap-4">
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-2xl font-bold text-indigo-600">{{ $venues->total() }}</div>
                    <div class="text-sm text-gray-600">Total Venues</div>
                </div>
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-2xl font-bold text-green-600">{{ $venues->where('is_active', 1)->count() }}</div>
                    <div class="text-sm text-gray-600">Active Venues</div>
                </div>
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-2xl font-bold text-blue-600">{{ $venues->where('type', 'indoor')->count() }}</div>
                    <div class="text-sm text-gray-600">Indoor Venues</div>
                </div>
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-2xl font-bold text-purple-600">{{ $venues->where('type', 'outdoor')->count() }}</div>
                    <div class="text-sm text-gray-600">Outdoor Venues</div>
                </div>
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-2xl font-bold text-orange-600">{{ $venues->where('type', 'both')->count() }}</div>
                    <div class="text-sm text-gray-600">Both Types</div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex gap-4">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search venues..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <select id="typeFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Types</option>
                    <option value="indoor">Indoor</option>
                    <option value="outdoor">Outdoor</option>
                    <option value="both">Both</option>
                </select>
                <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Venues Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($venues as $venue)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
            <!-- Venue Image -->
            <div class="relative h-48 bg-gray-200">
                @if($venue->main_image)
                <img src="{{ asset($venue->main_image) }}"
                    alt="{{ $venue->name }}"
                    class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif

                <!-- Status Badge -->
                <div class="absolute top-2 right-2">
                    @if($venue->is_active)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Active
                    </span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Inactive
                    </span>
                    @endif
                </div>

                <!-- Type Badge -->
                <div class="absolute top-2 left-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        {{ ucfirst($venue->type) }}
                    </span>
                </div>
            </div>

            <!-- Venue Info -->
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $venue->name }}</h3>
                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $venue->description }}</p>

                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $venue->address }}
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Capacity: {{ number_format($venue->capacity) }}
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        {{ $venue->price_range }}
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    <button onclick="viewVenue('{{ $venue->id }}')"
                        class="flex-1 bg-indigo-100 text-indigo-700 px-3 py-2 rounded-lg text-sm font-medium hover:bg-indigo-200 transition-colors">
                        View Details
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No venues</h3>
            <p class="mt-1 text-sm text-gray-500">No venues available at the moment.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($venues->hasPages())
    <div class="mt-8 flex justify-center">
        <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
            {{ $venues->appends(request()->query())->links() }}
        </div>
    </div>
    @endif

    @push('modals')
    <!-- View Venue Modal -->
    <div id="viewVenueModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Venue Details</h3>
                <button onclick="closeViewModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="venueDetails" class="space-y-4">
                <!-- Venue details will be loaded here -->
            </div>
        </div>
    </div>
    @endpush

    @push('scripts')
    <script>
        // Search and filter functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const venueCards = document.querySelectorAll('.grid > div');

            venueCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        document.getElementById('typeFilter').addEventListener('change', function() {
            filterVenues();
        });

        document.getElementById('statusFilter').addEventListener('change', function() {
            filterVenues();
        });

        function filterVenues() {
            const typeFilter = document.getElementById('typeFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const venueCards = document.querySelectorAll('.grid > div');

            venueCards.forEach(card => {
                const typeBadge = card.querySelector('.bg-indigo-100');
                const statusBadge = card.querySelector('.bg-green-100, .bg-red-100');

                const venueType = typeBadge ? typeBadge.textContent.toLowerCase() : '';
                const venueStatus = statusBadge ? (statusBadge.textContent === 'Active' ? 'active' : 'inactive') : '';

                const typeMatch = !typeFilter || venueType.includes(typeFilter);
                const statusMatch = !statusFilter || venueStatus === statusFilter;

                card.style.display = (typeMatch && statusMatch) ? '' : 'none';
            });
        }

        function viewVenue(venueId) {
            fetch(`/manager/venues/${venueId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const venue = data.venue;
                        const detailsHtml = `
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <img src="/${venue.main_image}" alt="${venue.name}" class="w-full h-64 object-cover rounded-lg">
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">${venue.name}</h4>
                                        <p class="text-sm text-gray-600">${venue.description}</p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Type:</span>
                                            <p class="text-sm text-gray-900">${venue.type}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Capacity:</span>
                                            <p class="text-sm text-gray-900">${venue.capacity.toLocaleString()}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Price Range:</span>
                                            <p class="text-sm text-gray-900">${venue.price_range}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Status:</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${venue.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                                ${venue.is_active ? 'Active' : 'Inactive'}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Address:</span>
                                        <p class="text-sm text-gray-900">${venue.address}</p>
                                    </div>
                                    ${venue.latitude && venue.longitude ? `
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Coordinates:</span>
                                        <p class="text-sm text-gray-900">${venue.latitude}, ${venue.longitude}</p>
                                    </div>
                                    ` : ''}
                                    ${venue.spaces && venue.spaces.length > 0 ? `
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Spaces:</span>
                                        <div class="mt-2 space-y-2">
                                            ${venue.spaces.map(space => `
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-sm font-medium text-gray-900">${space.name}</span>
                                                        <span class="text-xs text-gray-500">${space.type}</span>
                                                    </div>
                                                    <p class="text-xs text-gray-600">Capacity: ${space.capacity}</p>
                                                </div>
                                            `).join('')}
                                        </div>
                                    </div>
                                    ` : ''}
                                    ${venue.gallery && venue.gallery.length > 0 ? `
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Gallery:</span>
                                        <div class="mt-2 grid grid-cols-3 gap-2">
                                            ${venue.gallery.map(image => `
                                                <img src="/${image.image_path}" alt="Gallery" class="w-full h-20 object-cover rounded-lg">
                                            `).join('')}
                                        </div>
                                    </div>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                        document.getElementById('venueDetails').innerHTML = detailsHtml;
                        document.getElementById('viewVenueModal').classList.remove('hidden');
                    } else {
                        alert('Failed to load venue details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load venue details');
                });
        }

        function closeViewModal() {
            document.getElementById('viewVenueModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('viewVenueModal');
            if (e.target === modal) {
                closeViewModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeViewModal();
            }
        });
    </script>
    @endpush
</x-manager-layout> 