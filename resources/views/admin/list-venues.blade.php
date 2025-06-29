<x-admin-layout title="Venue Management" active-page="venues">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Venue Management</h1>
                <p class="text-gray-600 mt-1">Manage all venues in the system</p>
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

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex gap-3">
                <button onclick="createVenue()"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Venue
                </button>
            </div>

            <!-- Search and Filter -->
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
                @php
                    $imagePath = $venue->main_image;
                    if (strpos($imagePath, 'public/') === 0) {
                        $imagePath = '/' . $imagePath; // Add leading slash instead of removing public/
                    }
                @endphp
                <img src="{{ asset($imagePath) }}"
                    alt="{{ $venue->name }}"
                    class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2z"></path>
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
                        View
                    </button>
                    <button onclick="editVenue('{{ $venue->id }}')"
                        class="flex-1 bg-yellow-100 text-yellow-700 px-3 py-2 rounded-lg text-sm font-medium hover:bg-yellow-200 transition-colors">
                        Edit
                    </button>
                    <button onclick="deleteVenue('{{ $venue->id }}', '{{ $venue->name }}')"
                        class="flex-1 bg-red-100 text-red-700 px-3 py-2 rounded-lg text-sm font-medium hover:bg-red-200 transition-colors">
                        Delete
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
            <p class="mt-1 text-sm text-gray-500">Get started by creating a new venue.</p>
            <div class="mt-6">
                <button onclick="createVenue()"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Venue
                </button>
            </div>
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
    <!-- Create Venue Modal -->
    <div id="createVenueModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Create New Venue</h3>
                <button onclick="closeCreateModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="createVenueForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="venueName" class="block text-sm font-medium text-gray-700">Venue Name *</label>
                        <input type="text" id="venueName" name="name" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="venueType" class="block text-sm font-medium text-gray-700">Venue Type *</label>
                        <select id="venueType" name="type" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select Type</option>
                            <option value="indoor">Indoor</option>
                            <option value="outdoor">Outdoor</option>
                            <option value="both">Both (Indoor & Outdoor)</option>
                        </select>
                    </div>

                    <div>
                        <label for="venueCapacity" class="block text-sm font-medium text-gray-700">Capacity *</label>
                        <input type="number" id="venueCapacity" name="capacity" required min="1"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="venuePriceRange" class="block text-sm font-medium text-gray-700">Price Range *</label>
                        <input type="text" id="venuePriceRange" name="price_range" required placeholder="e.g., ₱1,000 - ₱5,000"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">Enter price range in Philippine Pesos (₱)</p>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="venueDescription" class="block text-sm font-medium text-gray-700">Description *</label>
                    <textarea id="venueDescription" name="description" rows="4" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <!-- Address and Location Search -->
                <div>
                    <label for="venueLocationSearch" class="block text-sm font-medium text-gray-700">Search Location *</label>
                    <div class="relative">
                        <input type="text" id="venueLocationSearch" placeholder="Search for a location..."
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <div id="locationSearchResults" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto">
                            <!-- Search results will appear here -->
                </div>
                    </div>
                    </div>

                <!-- Address (auto-filled) -->
                    <div>
                    <label for="venueAddress" class="block text-sm font-medium text-gray-700">Address *</label>
                    <input type="text" id="venueAddress" name="address" required readonly
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Hidden coordinates for form submission -->
                <input type="hidden" id="venueLatitude" name="latitude">
                <input type="hidden" id="venueLongitude" name="longitude">

                <!-- Main Image -->
                <div>
                    <label for="venueMainImage" class="block text-sm font-medium text-gray-700">Main Image *</label>
                    <input type="file" id="venueMainImage" name="main_image" required accept="image/*"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Gallery Images -->
                <div>
                    <label for="venueGalleryImages" class="block text-sm font-medium text-gray-700">Gallery Images</label>
                    <input type="file" id="venueGalleryImages" name="gallery_images[]" multiple accept="image/*"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Venue Spaces -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Venue Spaces</label>
                    <div id="venueSpaces" class="space-y-3">
                        <!-- Dynamic spaces will be added here -->
                    </div>
                    <button type="button" onclick="addVenueSpace()"
                        class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Space
                    </button>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeCreateModal()"
                        class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                        Create Venue
                    </button>
                </div>
            </form>
        </div>
    </div>

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

    <!-- Edit Venue Modal -->
    <div id="editVenueModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Edit Venue</h3>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="editVenueForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="editVenueId" name="venue_id">

                <!-- Form fields will be populated dynamically -->
                <div id="editVenueFields">
                    <!-- Dynamic fields will be added here -->
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                        Update Venue
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteVenueModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Delete Venue</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to delete "<span id="deleteVenueName"></span>"? This action cannot be undone.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmDeleteBtn"
                        class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Delete
                    </button>
                    <button onclick="closeDeleteModal()"
                        class="mt-3 px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endpush

    @push('notifications')
    <!-- Success Notification -->
    <div id="successNotification" class="hidden fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out z-50">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="notificationMessage"></span>
        </div>
    </div>

    <!-- Error Notification -->
    <div id="errorNotification" class="hidden fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out z-50">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span id="errorMessage"></span>
        </div>
    </div>
    @endpush

    @push('scripts')
    <!-- Mapbox API -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />

    <script>
        // Global variables
        let currentVenueId = null;
        let spaceCounter = 0;
        let locationSearchTimeout = null;
        const MAPBOX_ACCESS_TOKEN = 'pk.eyJ1IjoiamllZGpvc2h1YSIsImEiOiJjbWM3OTljd3UwdmVnMmtwd2hhdXVqcng4In0.g77PfgWIOdlCt0sBijQgLg';

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

        // Mapbox Search API Functions
        function initializeLocationSearch(searchInputId, resultsId, addressInputId, latInputId, lngInputId) {
            const searchInput = document.getElementById(searchInputId);
            const resultsContainer = document.getElementById(resultsId);
            const addressInput = document.getElementById(addressInputId);
            const latInput = document.getElementById(latInputId);
            const lngInput = document.getElementById(lngInputId);

            if (!searchInput) return;

            // Generate session token for this search session
            const sessionToken = generateSessionToken();

            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                if (query.length < 2) {
                    resultsContainer.classList.add('hidden');
                    return;
                }

                // Clear previous timeout
                if (locationSearchTimeout) {
                    clearTimeout(locationSearchTimeout);
                }

                // Set new timeout for search
                locationSearchTimeout = setTimeout(() => {
                    searchLocationsWithMapboxAPI(query, sessionToken, resultsContainer, addressInput, latInput, lngInput);
                }, 300);
            });

            // Hide results when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                    resultsContainer.classList.add('hidden');
                }
            });
        }

        function generateSessionToken() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                const r = Math.random() * 16 | 0;
                const v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        function searchLocationsWithMapboxAPI(query, sessionToken, resultsContainer, addressInput, latInput, lngInput) {
            // Use Mapbox Search API - Bataan only with improved parameters
            const searchUrl = `https://api.mapbox.com/search/searchbox/v1/suggest?q=${encodeURIComponent(query)}&session_token=${sessionToken}&proximity=120.5,14.6&access_token=${MAPBOX_ACCESS_TOKEN}&limit=10&types=poi,address&country=ph&language=en`;

            fetch(searchUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.suggestions && data.suggestions.length > 0) {
                        // Filter results to Bataan only and prioritize more specific results
                        const bataanResults = data.suggestions.filter(suggestion => {
                            const placeName = suggestion.context?.place?.name?.toLowerCase() || '';
                            const fullAddress = suggestion.full_address?.toLowerCase() || '';
                            const regionName = suggestion.context?.region?.name?.toLowerCase() || '';
                            
                            return placeName.includes('bataan') || 
                                   fullAddress.includes('bataan') ||
                                   regionName.includes('bataan') ||
                                   isInBataanBoundingBox(suggestion);
                        });

                        if (bataanResults.length > 0) {
                            // Sort results by relevance (more specific addresses first)
                            bataanResults.sort((a, b) => {
                                const aSpecificity = (a.full_address || '').split(',').length;
                                const bSpecificity = (b.full_address || '').split(',').length;
                                return bSpecificity - aSpecificity; // More specific first
                            });
                            
                            displayMapboxSearchResults(bataanResults, resultsContainer, addressInput, latInput, lngInput);
                        } else {
                            // Fallback to Bataan-specific mock results
                            displayBataanMockResults(query, resultsContainer, addressInput, latInput, lngInput);
                        }
                    } else {
                        // Fallback to Bataan-specific mock results
                        displayBataanMockResults(query, resultsContainer, addressInput, latInput, lngInput);
                    }
                })
                .catch(error => {
                    console.error('Mapbox Search API error:', error);
                    // Fallback to Bataan-specific mock results
                    displayBataanMockResults(query, resultsContainer, addressInput, latInput, lngInput);
                });
        }

        function isInBataanBoundingBox(suggestion) {
            // Bataan bounding box: [120.2, 14.4, 120.8, 15.0]
            // This is a simple check - in a real implementation, you'd need coordinates
            // For now, we'll rely on the place name and address filtering
            return true; // Placeholder - would need actual coordinate checking
        }

        function displayMapboxSearchResults(suggestions, resultsContainer, addressInput, latInput, lngInput) {
            if (suggestions.length === 0) {
                resultsContainer.innerHTML = '<div class="p-3 text-sm text-gray-500">No locations found in Bataan</div>';
            } else {
                resultsContainer.innerHTML = suggestions.map(suggestion => {
                    // Extract venue name from properties or use the name field
                    const venueName = suggestion.properties?.name || suggestion.name || suggestion.name_preferred || 'Unknown Location';
                    const address = suggestion.full_address || suggestion.address || '';
                    const placeFormatted = suggestion.place_formatted || '';
                    const category = suggestion.poi_category?.[0] || 'location';
                    const maki = suggestion.maki || 'marker';
                    
                    // Use the venue name for display and search field
                    const displayName = venueName;
                    
                    return `
                        <div class="p-3 hover:bg-gray-100 cursor-pointer border-b border-gray-200 last:border-b-0" 
                             onclick="selectMapboxLocation('${displayName}', '${address}', '${suggestion.mapbox_id}', '${addressInput.id}', '${latInput.id}', '${lngInput.id}', '${resultsContainer.id}')">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <span class="text-indigo-600 text-sm font-medium">${maki.charAt(0).toUpperCase()}</span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-gray-900">${displayName}</div>
                                    <div class="text-sm text-gray-600">${address}</div>
                                    <div class="text-xs text-gray-500">${placeFormatted} • ${category}</div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            }
            
            resultsContainer.classList.remove('hidden');
        }

        function displayBataanMockResults(query, resultsContainer, addressInput, latInput, lngInput) {
            const mockResults = [
                {
                    name: `${query}`,
                    full_address: `${query}, Balanga, Bataan, Philippines`,
                    place_formatted: 'Balanga, Bataan, Philippines',
                    mapbox_id: 'mock-balanga-' + Date.now(),
                    poi_category: ['venue'],
                    maki: 'marker'
                },
                {
                    name: `${query}`,
                    full_address: `${query}, Mariveles, Bataan, Philippines`,
                    place_formatted: 'Mariveles, Bataan, Philippines',
                    mapbox_id: 'mock-mariveles-' + Date.now(),
                    poi_category: ['venue'],
                    maki: 'marker'
                },
                {
                    name: `${query}`,
                    full_address: `${query}, Orani, Bataan, Philippines`,
                    place_formatted: 'Orani, Bataan, Philippines',
                    mapbox_id: 'mock-orani-' + Date.now(),
                    poi_category: ['venue'],
                    maki: 'marker'
                },
                {
                    name: `${query}`,
                    full_address: `${query}, Hermosa, Bataan, Philippines`,
                    place_formatted: 'Hermosa, Bataan, Philippines',
                    mapbox_id: 'mock-hermosa-' + Date.now(),
                    poi_category: ['venue'],
                    maki: 'marker'
                },
                {
                    name: `${query}`,
                    full_address: `${query}, Dinalupihan, Bataan, Philippines`,
                    place_formatted: 'Dinalupihan, Bataan, Philippines',
                    mapbox_id: 'mock-dinalupihan-' + Date.now(),
                    poi_category: ['venue'],
                    maki: 'marker'
                }
            ];
            displayMapboxSearchResults(mockResults, resultsContainer, addressInput, latInput, lngInput);
        }

        function selectMapboxLocation(name, address, mapboxId, addressInputId, latInputId, lngInputId, resultsContainerId) {
            // Set the address field with the full address
            document.getElementById(addressInputId).value = address;
            
            // Auto-fill the venue name field with the venue name
            const venueNameInput = document.getElementById('venueName');
            if (venueNameInput) {
                venueNameInput.value = name;
            }
            
            // Show loading indicator for coordinates
            const latInput = document.getElementById(latInputId);
            const lngInput = document.getElementById(lngInputId);
            latInput.value = 'Loading...';
            lngInput.value = 'Loading...';
            
            // Get exact coordinates from Mapbox API
            getExactCoordinates(mapboxId, latInputId, lngInputId, name);
            
            document.getElementById(resultsContainerId).classList.add('hidden');
            
            // Update the search input with the location name (not the address)
            const searchInput = document.getElementById(addressInputId.replace('Address', 'LocationSearch'));
            if (searchInput) {
                searchInput.value = name;
            }
        }

        function getExactCoordinates(mapboxId, latInputId, lngInputId, name) {
            // For mock results, use approximate coordinates
            if (mapboxId.includes('mock-')) {
                const bataanCoordinates = {
                    'balanga': { lat: 14.6760, lng: 120.5361 },
                    'mariveles': { lat: 14.4336, lng: 120.4853 },
                    'orani': { lat: 14.8006, lng: 120.5372 },
                    'hermosa': { lat: 14.8314, lng: 120.5083 },
                    'dinalupihan': { lat: 14.8783, lng: 120.4644 }
                };
                
                const location = mapboxId.split('-')[1];
                const coordinates = bataanCoordinates[location] || { lat: 14.6760, lng: 120.5361 };
                
                document.getElementById(latInputId).value = coordinates.lat;
                document.getElementById(lngInputId).value = coordinates.lng;
                console.log('Using mock coordinates for:', location, coordinates);
                return;
            }

            // For real Mapbox results, get exact coordinates
            const sessionToken = generateSessionToken();
            const retrieveUrl = `https://api.mapbox.com/search/searchbox/v1/retrieve/${mapboxId}?session_token=${sessionToken}&access_token=${MAPBOX_ACCESS_TOKEN}`;

            console.log('Retrieving exact coordinates for:', mapboxId);
            console.log('API URL:', retrieveUrl);

            fetch(retrieveUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Mapbox retrieve response:', data);
                    
                    if (data.features && data.features.length > 0) {
                        const feature = data.features[0];
                        const coordinates = feature.geometry.coordinates;
                        
                        // Mapbox returns [longitude, latitude], so we need to swap them
                        const longitude = coordinates[0];
                        const latitude = coordinates[1];
                        
                        document.getElementById(latInputId).value = latitude;
                        document.getElementById(lngInputId).value = longitude;
                        
                        // Extract venue name from properties and update search field
                        const venueName = feature.properties?.name || feature.properties?.full_address?.split(',')[0] || 'Unknown Venue';
                        const searchInput = document.getElementById(latInputId.replace('Latitude', 'LocationSearch'));
                        if (searchInput) {
                            searchInput.value = venueName;
                        }
                        
                        // Update the venue name field with the venue name from properties
                        const venueNameInput = document.getElementById('venueName');
                        if (venueNameInput) {
                            venueNameInput.value = venueName;
                        }
                        
                        // Also update the edit venue name field if it exists
                        const editVenueNameInput = document.getElementById('editVenueName');
                        if (editVenueNameInput) {
                            editVenueNameInput.value = venueName;
                        }
                        
                        console.log('Exact coordinates retrieved:', { latitude, longitude, venueName, address: feature.properties.full_address });
                    } else {
                        // Fallback to default Bataan coordinates
                        document.getElementById(latInputId).value = 14.6760;
                        document.getElementById(lngInputId).value = 120.5361;
                        console.warn('No coordinates found in response, using default Bataan coordinates');
                    }
                })
                .catch(error => {
                    console.error('Error retrieving coordinates:', error);
                    // Fallback to default Bataan coordinates
                    document.getElementById(latInputId).value = 14.6760;
                    document.getElementById(lngInputId).value = 120.5361;
                });
        }

        // Initialize location search when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize for create form
            initializeLocationSearch('venueLocationSearch', 'locationSearchResults', 'venueAddress', 'venueLatitude', 'venueLongitude');
        });

        // Modal functions
        function createVenue() {
            document.getElementById('createVenueModal').classList.remove('hidden');
            resetCreateForm();
            
            // Initialize location search for create form
            setTimeout(() => {
                initializeLocationSearch('venueLocationSearch', 'locationSearchResults', 'venueAddress', 'venueLatitude', 'venueLongitude');
            }, 100);
        }

        function closeCreateModal() {
            document.getElementById('createVenueModal').classList.add('hidden');
            resetCreateForm();
        }

        function resetCreateForm() {
            document.getElementById('createVenueForm').reset();
            document.getElementById('venueSpaces').innerHTML = '';
            spaceCounter = 0;
            
            // Clear location fields
            document.getElementById('venueAddress').value = '';
            document.getElementById('venueLatitude').value = '';
            document.getElementById('venueLongitude').value = '';
        }

        function addVenueSpace() {
            spaceCounter++;
            const spaceHtml = `
                <div class="border border-gray-300 rounded-lg p-4 space-y-3" id="space-${spaceCounter}">
                    <div class="flex justify-between items-center">
                        <h4 class="text-sm font-medium text-gray-700">Space ${spaceCounter}</h4>
                        <button type="button" onclick="removeVenueSpace(${spaceCounter})" class="text-red-500 hover:text-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="spaces[${spaceCounter}][name]" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="spaces[${spaceCounter}][type]" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select Type</option>
                                <option value="indoor">Indoor</option>
                                <option value="outdoor">Outdoor</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Capacity</label>
                            <input type="number" name="spaces[${spaceCounter}][capacity]" required min="1"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('venueSpaces').insertAdjacentHTML('beforeend', spaceHtml);
        }

        function removeVenueSpace(spaceId) {
            document.getElementById(`space-${spaceId}`).remove();
        }

        function viewVenue(venueId) {
            fetch(`/admin/venues/${venueId}`)
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
                                                <div class="relative">
                                                    <img src="/${image.image_path}" alt="Gallery" class="w-full h-20 object-cover rounded-lg">
                                                    <button type="button" onclick="removeGalleryImage('${image.id}')" 
                                                        class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600">
                                                        ×
                                                    </button>
                                                </div>
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
                        showError('Failed to load venue details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Failed to load venue details');
                });
        }

        function closeViewModal() {
            document.getElementById('viewVenueModal').classList.add('hidden');
        }

        function editVenue(venueId) {
            currentVenueId = venueId;
            fetch(`/admin/venues/${venueId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const venue = data.venue;
                        populateEditForm(venue);
                        document.getElementById('editVenueModal').classList.remove('hidden');
                    } else {
                        showError('Failed to load venue details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Failed to load venue details');
                });
        }

        function populateEditForm(venue) {
            document.getElementById('editVenueId').value = venue.id;
            
            const fieldsHtml = `
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="editVenueName" class="block text-sm font-medium text-gray-700">Venue Name *</label>
                        <input type="text" id="editVenueName" name="name" value="${venue.name}" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="editVenueType" class="block text-sm font-medium text-gray-700">Venue Type *</label>
                        <select id="editVenueType" name="type" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select Type</option>
                            <option value="indoor" ${venue.type === 'indoor' ? 'selected' : ''}>Indoor</option>
                            <option value="outdoor" ${venue.type === 'outdoor' ? 'selected' : ''}>Outdoor</option>
                            <option value="both" ${venue.type === 'both' ? 'selected' : ''}>Both (Indoor & Outdoor)</option>
                        </select>
                    </div>

                    <div>
                        <label for="editVenueCapacity" class="block text-sm font-medium text-gray-700">Capacity *</label>
                        <input type="number" id="editVenueCapacity" name="capacity" value="${venue.capacity}" required min="1"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="editVenuePriceRange" class="block text-sm font-medium text-gray-700">Price Range *</label>
                        <input type="text" id="editVenuePriceRange" name="price_range" value="${venue.price_range}" required placeholder="e.g., ₱1,000 - ₱5,000"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">Enter price range in Philippine Pesos (₱)</p>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="editVenueDescription" class="block text-sm font-medium text-gray-700">Description *</label>
                    <textarea id="editVenueDescription" name="description" rows="4" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">${venue.description}</textarea>
                </div>

                <!-- Address and Location Search -->
                <div>
                    <label for="editVenueLocationSearch" class="block text-sm font-medium text-gray-700">Search Location *</label>
                    <div class="relative">
                        <input type="text" id="editVenueLocationSearch" placeholder="Search for a location..." value="${venue.address}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <div id="editLocationSearchResults" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto">
                            <!-- Search results will appear here -->
                        </div>
                    </div>
                </div>

                <!-- Address (auto-filled) -->
                <div>
                    <label for="editVenueAddress" class="block text-sm font-medium text-gray-700">Address *</label>
                    <input type="text" id="editVenueAddress" name="address" value="${venue.address}" required readonly
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Hidden coordinates for form submission -->
                <input type="hidden" id="editVenueLatitude" name="latitude" value="${venue.latitude || ''}">
                <input type="hidden" id="editVenueLongitude" name="longitude" value="${venue.longitude || ''}">

                <!-- Main Image -->
                <div>
                    <label for="editVenueMainImage" class="block text-sm font-medium text-gray-700">Main Image</label>
                    <input type="file" id="editVenueMainImage" name="main_image" accept="image/*"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="mt-1 text-sm text-gray-500">Leave empty to keep current image</p>
                    ${venue.main_image ? `<img src="/${venue.main_image}" alt="Current" class="mt-2 w-32 h-24 object-cover rounded-lg">` : ''}
                </div>

                <!-- Gallery Images -->
                <div>
                    <label for="editVenueGalleryImages" class="block text-sm font-medium text-gray-700">Gallery Images</label>
                    <input type="file" id="editVenueGalleryImages" name="gallery_images[]" multiple accept="image/*"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="mt-1 text-sm text-gray-500">Select new images to add to the gallery. Leave empty to keep current gallery.</p>
                    ${venue.gallery && venue.gallery.length > 0 ? `
                    <div class="mt-3">
                        <p class="text-sm font-medium text-gray-700 mb-2">Current Gallery Images:</p>
                        <div class="grid grid-cols-3 gap-2">
                            ${venue.gallery.map(image => `
                                <div class="relative">
                                    <img src="/${image.image_path}" alt="Gallery" class="w-full h-20 object-cover rounded-lg">
                                    <button type="button" onclick="removeGalleryImage('${image.id}')" 
                                        class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600">
                                        ×
                                    </button>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    ` : ''}
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" ${venue.is_active ? 'checked' : ''}
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>

                <!-- Venue Spaces -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Venue Spaces</label>
                    <div id="editVenueSpaces" class="space-y-3">
                        ${venue.spaces && venue.spaces.length > 0 ? venue.spaces.map((space, index) => `
                            <div class="border border-gray-300 rounded-lg p-4 space-y-3" id="edit-space-${space.id}">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-sm font-medium text-gray-700">Space ${index + 1}</h4>
                                    <button type="button" onclick="removeEditVenueSpace(${space.id})" class="text-red-500 hover:text-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" name="edit_spaces[${space.id}][name]" value="${space.name}" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Type</label>
                                        <select name="edit_spaces[${space.id}][type]" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="">Select Type</option>
                                            <option value="indoor" ${space.type === 'indoor' ? 'selected' : ''}>Indoor</option>
                                            <option value="outdoor" ${space.type === 'outdoor' ? 'selected' : ''}>Outdoor</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Capacity</label>
                                        <input type="number" name="edit_spaces[${space.id}][capacity]" value="${space.capacity}" required min="1"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                </div>
                            </div>
                        `).join('') : ''}
                    </div>
                    <button type="button" onclick="addEditVenueSpace()"
                        class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Space
                    </button>
                </div>
            `;
            
            document.getElementById('editVenueFields').innerHTML = fieldsHtml;
            
            // Initialize location search for edit form
            setTimeout(() => {
                initializeLocationSearch('editVenueLocationSearch', 'editLocationSearchResults', 'editVenueAddress', 'editVenueLatitude', 'editVenueLongitude');
            }, 100);
        }

        function closeEditModal() {
            document.getElementById('editVenueModal').classList.add('hidden');
            currentVenueId = null;
        }

        function deleteVenue(venueId, venueName) {
            currentVenueId = venueId;
            document.getElementById('deleteVenueName').textContent = venueName;
            document.getElementById('deleteVenueModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteVenueModal').classList.add('hidden');
            currentVenueId = null;
        }

        function removeGalleryImage(imageId) {
            if (confirm('Are you sure you want to remove this image from the gallery?')) {
                // Add the image ID to a hidden field for deletion
                let removedImages = document.getElementById('removedGalleryImages');
                if (!removedImages) {
                    removedImages = document.createElement('input');
                    removedImages.type = 'hidden';
                    removedImages.id = 'removedGalleryImages';
                    removedImages.name = 'removed_gallery_images[]';
                    document.getElementById('editVenueForm').appendChild(removedImages);
                }
                
                // Add the image ID to the removed images list
                const currentValue = removedImages.value;
                const newValue = currentValue ? currentValue + ',' + imageId : imageId;
                removedImages.value = newValue;
                
                // Remove the image from the UI
                const imageElement = document.querySelector(`[onclick="removeGalleryImage('${imageId}')"]`).parentElement;
                imageElement.remove();
                
                console.log('Image marked for removal:', imageId);
            }
        }

        let editSpaceCounter = 0;

        function addEditVenueSpace() {
            editSpaceCounter++;
            const spaceHtml = `
                <div class="border border-gray-300 rounded-lg p-4 space-y-3" id="edit-new-space-${editSpaceCounter}">
                    <div class="flex justify-between items-center">
                        <h4 class="text-sm font-medium text-gray-700">New Space ${editSpaceCounter}</h4>
                        <button type="button" onclick="removeEditVenueSpace('new-${editSpaceCounter}')" class="text-red-500 hover:text-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="new_spaces[${editSpaceCounter}][name]" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="new_spaces[${editSpaceCounter}][type]" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select Type</option>
                                <option value="indoor">Indoor</option>
                                <option value="outdoor">Outdoor</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Capacity</label>
                            <input type="number" name="new_spaces[${editSpaceCounter}][capacity]" required min="1"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('editVenueSpaces').insertAdjacentHTML('beforeend', spaceHtml);
        }

        function removeEditVenueSpace(spaceId) {
            if (confirm('Are you sure you want to remove this space?')) {
                const spaceElement = document.getElementById(`edit-space-${spaceId}`) || document.getElementById(`edit-new-space-${spaceId}`);
                if (spaceElement) {
                    spaceElement.remove();
                }
                
                // If it's an existing space, mark it for deletion
                if (!spaceId.toString().startsWith('new-')) {
                    let removedSpaces = document.getElementById('removedVenueSpaces');
                    if (!removedSpaces) {
                        removedSpaces = document.createElement('input');
                        removedSpaces.type = 'hidden';
                        removedSpaces.id = 'removedVenueSpaces';
                        removedSpaces.name = 'removed_venue_spaces[]';
                        document.getElementById('editVenueForm').appendChild(removedSpaces);
                    }
                    
                    const currentValue = removedSpaces.value;
                    const newValue = currentValue ? currentValue + ',' + spaceId : spaceId;
                    removedSpaces.value = newValue;
                    
                    console.log('Space marked for removal:', spaceId);
                }
            }
        }

        // Form submissions
        document.getElementById('createVenueForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/admin/venues', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess(data.message);
                        closeCreateModal();
                        // Reload the page to show the new venue
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showError(data.message || 'Failed to create venue');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Failed to create venue');
                });
        });

        document.getElementById('editVenueForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(`/admin/venues/${currentVenueId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess(data.message);
                        closeEditModal();
                        // Reload the page to show the updated venue
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showError(data.message || 'Failed to update venue');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Failed to update venue');
                });
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            fetch(`/admin/venues/${currentVenueId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess(data.message);
                        closeDeleteModal();
                        // Reload the page to reflect the deletion
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showError(data.message || 'Failed to delete venue');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Failed to delete venue');
                });
        });

        // Notification functions
        function showSuccess(message) {
            const notification = document.getElementById('successNotification');
            const messageElement = document.getElementById('notificationMessage');
            messageElement.textContent = message;

            notification.classList.remove('hidden');
            notification.classList.add('transform', 'translate-x-0');

            setTimeout(() => {
                notification.classList.add('hidden');
                notification.classList.remove('transform', 'translate-x-0');
            }, 5000);
        }

        function showError(message) {
            const notification = document.getElementById('errorNotification');
            const messageElement = document.getElementById('errorMessage');
            messageElement.textContent = message;

            notification.classList.remove('hidden');
            notification.classList.add('transform', 'translate-x-0');

            setTimeout(() => {
                notification.classList.add('hidden');
                notification.classList.remove('transform', 'translate-x-0');
            }, 5000);
        }

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            const createModal = document.getElementById('createVenueModal');
            const viewModal = document.getElementById('viewVenueModal');
            const editModal = document.getElementById('editVenueModal');
            const deleteModal = document.getElementById('deleteVenueModal');

            if (e.target === createModal) {
                closeCreateModal();
            }
            if (e.target === viewModal) {
                closeViewModal();
            }
            if (e.target === editModal) {
                closeEditModal();
            }
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCreateModal();
                closeViewModal();
                closeEditModal();
                closeDeleteModal();
            }
        });
    </script>
    @endpush
</x-admin-layout>