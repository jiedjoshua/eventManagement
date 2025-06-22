<x-admin-layout title="Venue Map" active-page="venue-map">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Venue Map</h1>
                <p class="text-gray-600 mt-1">View all venue locations on the map</p>
            </div>

            <!-- Stats Cards -->
            <div class="flex gap-4">
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-2xl font-bold text-indigo-600">{{ $venues->count() }}</div>
                    <div class="text-sm text-gray-600">Venues on Map</div>
                </div>
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-2xl font-bold text-green-600">{{ $venues->where('type', 'indoor')->count() }}</div>
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

        <!-- Filter Controls -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex gap-4">
                <select id="typeFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Types</option>
                    <option value="indoor">Indoor</option>
                    <option value="outdoor">Outdoor</option>
                    <option value="both">Both</option>
                </select>
                <button onclick="fitMapToVenues()" 
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Fit to Venues
                </button>
            </div>

            <div class="text-sm text-gray-600">
                Showing venues with location data
            </div>
        </div>
    </div>

    <!-- Map Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="relative h-[600px] rounded-lg overflow-hidden">
            <div id="venueMap" class="w-full h-full"></div>
            <div id="mapLoading" class="absolute inset-0 bg-gray-100 flex items-center justify-center">
                <div class="text-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto"></div>
                    <p class="mt-2 text-sm text-gray-600">Loading map...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Venue List Sidebar (Optional) -->
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Venues on Map</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($venues as $venue)
                <div class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50 cursor-pointer" 
                     onclick="focusOnVenue({{ $venue->latitude }}, {{ $venue->longitude }}, '{{ $venue->name }}')">
                    <div class="flex items-center space-x-3">
                        @if($venue->main_image)
                        <img src="{{ asset($venue->main_image) }}" alt="{{ $venue->name }}" 
                             class="w-12 h-12 object-cover rounded">
                        @else
                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $venue->name }}</h4>
                            <p class="text-xs text-gray-600 truncate">{{ $venue->address }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ ucfirst($venue->type) }}
                            </span>
                        </div>
                        <div class="flex space-x-1">
                            <button onclick="event.stopPropagation(); viewVenueDetails('{{ $venue->id }}')" 
                                class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded hover:bg-indigo-200">
                                View
                            </button>
                            <button onclick="event.stopPropagation(); editVenueDetails('{{ $venue->id }}')" 
                                class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded hover:bg-yellow-200">
                                Edit
                            </button>
                            <button onclick="event.stopPropagation(); deleteVenue('{{ $venue->id }}', '{{ $venue->name }}')" 
                                class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No venues with location data</h3>
                    <p class="mt-1 text-sm text-gray-500">Add venues with coordinates to see them on the map.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Mapbox API -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />

    <script>
        // Global variables
        let venueMap = null;
        let venueMarkers = [];
        const MAPBOX_ACCESS_TOKEN = 'pk.eyJ1IjoiamllZGpvc2h1YSIsImEiOiJjbWM3OTljd3UwdmVnMmtwd2hhdXVqcng4In0.g77PfgWIOdlCt0sBijQgLg';
        const venues = @json($venues);

        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeVenueMap();
        });

        function initializeVenueMap() {
            // Initialize Mapbox map
            mapboxgl.accessToken = MAPBOX_ACCESS_TOKEN;
            
            venueMap = new mapboxgl.Map({
                container: 'venueMap',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [120.5, 14.6], // Bataan center
                zoom: 10,
                maxBounds: [
                    [120.2, 14.4], // Southwest coordinates
                    [120.8, 15.0]  // Northeast coordinates
                ]
            });

            // Add navigation controls
            venueMap.addControl(new mapboxgl.NavigationControl(), 'top-right');

            // Add venue markers when map loads
            venueMap.on('load', function() {
                addVenueMarkers();
                document.getElementById('mapLoading').style.display = 'none';
            });

            // Handle map errors
            venueMap.on('error', function(e) {
                console.error('Map error:', e);
                document.getElementById('mapLoading').innerHTML = `
                    <div class="text-center">
                        <p class="text-sm text-red-600">Failed to load map</p>
                        <button onclick="initializeVenueMap()" class="mt-2 text-indigo-600 hover:text-indigo-700">Retry</button>
                    </div>
                `;
            });
        }

        function addVenueMarkers() {
            // Clear existing markers
            venueMarkers.forEach(marker => marker.remove());
            venueMarkers = [];

            // Add markers for each venue
            venues.forEach((venue, index) => {
                if (venue.latitude && venue.longitude) {
                    // Create marker element
                    const markerEl = document.createElement('div');
                    markerEl.className = 'venue-marker';
                    markerEl.innerHTML = `
                        <div class="w-8 h-8 bg-indigo-600 rounded-full border-2 border-white shadow-lg flex items-center justify-center cursor-pointer">
                            <span class="text-white text-xs font-bold">${index + 1}</span>
                        </div>
                    `;

                    // Create popup
                    const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(`
                        <div class="venue-popup">
                            <div class="flex items-center space-x-3">
                                ${venue.main_image ? `<img src="/${venue.main_image}" alt="${venue.name}" class="w-12 h-12 object-cover rounded">` : ''}
                                <div>
                                    <h4 class="font-semibold text-gray-900">${venue.name}</h4>
                                    <p class="text-sm text-gray-600">${venue.address}</p>
                                    <p class="text-xs text-gray-500">${venue.type} • Capacity: ${venue.capacity.toLocaleString()}</p>
                                    <p class="text-xs text-gray-500">${venue.price_range}</p>
                                </div>
                            </div>
                            <div class="mt-2 flex space-x-2">
                                <button onclick="viewVenueDetails('${venue.id}')" 
                                    class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded hover:bg-indigo-200">
                                    View Details
                                </button>
                                <button onclick="editVenueDetails('${venue.id}')" 
                                    class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded hover:bg-yellow-200">
                                    Edit
                                </button>
                            </div>
                        </div>
                    `);

                    // Add marker to map
                    const marker = new mapboxgl.Marker(markerEl)
                        .setLngLat([parseFloat(venue.longitude), parseFloat(venue.latitude)])
                        .setPopup(popup)
                        .addTo(venueMap);

                    venueMarkers.push(marker);
                }
            });

            // Show message if no venues are found
            if (venueMarkers.length === 0) {
                const mapContainer = document.getElementById('venueMap');
                const noVenuesMessage = document.createElement('div');
                noVenuesMessage.className = 'absolute inset-0 bg-gray-100 flex items-center justify-center';
                noVenuesMessage.innerHTML = `
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No venues on map</h3>
                        <p class="mt-1 text-sm text-gray-500">Add venues with location data to see them on the map.</p>
                    </div>
                `;
                mapContainer.appendChild(noVenuesMessage);
            }
        }

        function focusOnVenue(lat, lng, venueName) {
            if (venueMap) {
                venueMap.flyTo({
                    center: [parseFloat(lng), parseFloat(lat)],
                    zoom: 15,
                    essential: true
                });

                // Find and open the popup for this venue
                venueMarkers.forEach((marker, index) => {
                    const venue = venues[index];
                    if (venue.name === venueName) {
                        marker.getPopup().addTo(venueMap);
                    }
                });
            }
        }

        function fitMapToVenues() {
            if (venueMap && venues.length > 0) {
                const bounds = new mapboxgl.LngLatBounds();
                
                venues.forEach(venue => {
                    if (venue.latitude && venue.longitude) {
                        bounds.extend([parseFloat(venue.longitude), parseFloat(venue.latitude)]);
                    }
                });

                if (!bounds.isEmpty()) {
                    venueMap.fitBounds(bounds, {
                        padding: 50,
                        maxZoom: 15
                    });
                }
            }
        }

        function viewVenueDetails(venueId) {
            // Load venue details and show modal
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
                        showError('Failed to load venue details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Failed to load venue details');
                });
        }

        function editVenueDetails(venueId) {
            // Load venue details and show edit modal
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
                        <input type="text" id="editVenuePriceRange" name="price_range" value="${venue.price_range}" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="editVenueDescription" class="block text-sm font-medium text-gray-700">Description *</label>
                    <textarea id="editVenueDescription" name="description" rows="4" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">${venue.description}</textarea>
                </div>

                <!-- Address -->
                <div>
                    <label for="editVenueAddress" class="block text-sm font-medium text-gray-700">Address *</label>
                    <input type="text" id="editVenueAddress" name="address" value="${venue.address}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
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

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" ${venue.is_active ? 'checked' : ''}
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>
            `;
            
            document.getElementById('editVenueFields').innerHTML = fieldsHtml;
        }

        // Filter functionality
        document.getElementById('typeFilter').addEventListener('change', function() {
            const selectedType = this.value;
            
            venueMarkers.forEach((marker, index) => {
                const venue = venues[index];
                if (!selectedType || venue.type === selectedType) {
                    marker.getElement().style.display = 'block';
                } else {
                    marker.getElement().style.display = 'none';
                }
            });
        });

        // Modal functions
        function closeViewModal() {
            document.getElementById('viewVenueModal').classList.add('hidden');
        }

        function closeEditModal() {
            document.getElementById('editVenueModal').classList.add('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteVenueModal').classList.add('hidden');
        }

        function deleteVenue(venueId, venueName) {
            document.getElementById('deleteVenueName').textContent = venueName;
            document.getElementById('deleteVenueModal').classList.remove('hidden');
            
            // Store venue ID for deletion
            document.getElementById('confirmDeleteBtn').onclick = function() {
                performDeleteVenue(venueId);
            };
        }

        function performDeleteVenue(venueId) {
            fetch(`/admin/venues/${venueId}`, {
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
        }

        // Form submissions
        document.getElementById('editVenueForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const venueId = document.getElementById('editVenueId').value;

            fetch(`/admin/venues/${venueId}`, {
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
            const viewModal = document.getElementById('viewVenueModal');
            const editModal = document.getElementById('editVenueModal');
            const deleteModal = document.getElementById('deleteVenueModal');

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
                closeViewModal();
                closeEditModal();
                closeDeleteModal();
            }
        });
    </script>
    @endpush

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
</x-admin-layout> 