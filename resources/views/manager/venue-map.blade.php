<x-manager-layout title="Venue Map" active-page="venue-map">
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

    <!-- Venue List Sidebar -->
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
                    <p class="mt-1 text-sm text-gray-500">No venues with coordinates available to display on the map.</p>
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
                        <p class="mt-1 text-sm text-gray-500">No venues with location data available.</p>
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
                        alert('Failed to load venue details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load venue details');
                });
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
</x-manager-layout> 