<x-admin-layout title="Package Management" active-page="packages">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Package Management</h1>
        <button onclick="openCreateModal()" 
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Add Package</span>
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="typeFilter" class="block text-sm font-medium text-gray-700 mb-2">Filter by Type</label>
                <select id="typeFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Types</option>
                    <option value="Wedding">Wedding</option>
                    <option value="Birthday">Birthday</option>
                    <option value="Baptism">Baptism</option>
                </select>
            </div>
            <div>
                <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-2">Filter by Status</label>
                <select id="statusFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div>
                <label for="searchInput" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" id="searchInput" placeholder="Search packages..." 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>
    </div>

    <!-- Packages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($packages as $package)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden package-card" 
                 data-type="{{ strtolower($package->type) }}" 
                 data-status="{{ $package->is_active ? 'active' : 'inactive' }}"
                 data-name="{{ strtolower($package->name) }}">
                
                <!-- Package Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $package->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $package->title }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <!-- Status Toggle -->
                            <button onclick="toggleStatus({{ $package->id }}, this)" 
                                    class="status-toggle p-2 rounded-full transition-colors {{ $package->is_active ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600' }}"
                                    data-package-id="{{ $package->id }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                            
                            <!-- Type Badge -->
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                       {{ $package->type === 'Wedding' ? 'bg-purple-100 text-purple-800' : 
                                          ($package->type === 'Birthday' ? 'bg-pink-100 text-pink-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ $package->type }}
                            </span>
                        </div>
                    </div>
                    
                    <p class="text-gray-700 mb-4 line-clamp-2">{{ $package->description }}</p>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-indigo-600">₱{{ number_format($package->price) }}</span>
                        <span class="text-sm text-gray-500">{{ $package->features->count() }} features</span>
                    </div>
                </div>

                <!-- Package Features Preview -->
                <div class="p-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Features:</h4>
                    <div class="space-y-2">
                        @foreach($package->features->take(3) as $feature)
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $feature->title }}
                            </div>
                        @endforeach
                        @if($package->features->count() > 3)
                            <div class="text-sm text-gray-500 italic">
                                +{{ $package->features->count() - 3 }} more features
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex space-x-2">
                        <button onclick="openEditModal({{ $package->id }})" 
                                class="flex-1 bg-indigo-100 text-indigo-700 px-3 py-2 rounded-lg text-sm font-medium hover:bg-indigo-200 transition-colors text-center">
                            Edit
                        </button>
                        <button onclick="deletePackage({{ $package->id }}, '{{ $package->name }}')" 
                                class="flex-1 bg-red-100 text-red-700 px-3 py-2 rounded-lg text-sm font-medium hover:bg-red-200 transition-colors">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No packages</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new package.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.packages.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Add Package
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Package</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to delete "<span id="packageName"></span>"? This action cannot be undone.
                    </p>
                </div>
                <div class="flex justify-center space-x-4 mt-4">
                    <button onclick="closeDeleteModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                    <button onclick="confirmDelete()" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Package Modal -->
    <div id="packageModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900" id="modalTitle">Create Package</h3>
                <button onclick="closePackageModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="packageForm" class="space-y-6">
                @csrf
                <input type="hidden" id="packageId" name="package_id">
                <input type="hidden" id="_method" name="_method" value="POST">

                <!-- Package Basic Information -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="modalName" class="block text-sm font-medium text-gray-700 mb-2">Package Name *</label>
                            <input type="text" id="modalName" name="name" required
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   placeholder="e.g., Premium Wedding Package">
                        </div>

                        <div>
                            <label for="modalType" class="block text-sm font-medium text-gray-700 mb-2">Event Type *</label>
                            <select id="modalType" name="type" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select Event Type</option>
                                <option value="Wedding">Wedding</option>
                                <option value="Birthday">Birthday</option>
                                <option value="Baptism">Baptism</option>
                            </select>
                        </div>

                        <div>
                            <label for="modalTitle" class="block text-sm font-medium text-gray-700 mb-2">Display Title *</label>
                            <input type="text" id="modalDisplayTitle" name="title" required
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   placeholder="e.g., Premium Wedding Experience">
                        </div>

                        <div>
                            <label for="modalPrice" class="block text-sm font-medium text-gray-700 mb-2">Price (₱) *</label>
                            <input type="number" id="modalPrice" name="price" required min="0" step="0.01"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   placeholder="0.00">
                        </div>

                        <div class="md:col-span-2">
                            <label for="modalDescription" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea id="modalDescription" name="description" rows="3" required
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                      placeholder="Describe what's included in this package..."></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" id="modalIsActive" name="is_active" value="1"
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Active Package</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1">Active packages will be available for booking</p>
                        </div>
                    </div>
                </div>

                <!-- Package Features -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-semibold text-gray-900">Package Features</h4>
                        <button type="button" onclick="addModalFeature()" 
                                class="bg-indigo-600 text-white px-3 py-1 rounded-lg hover:bg-indigo-700 transition-colors text-sm flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Add Feature</span>
                        </button>
                    </div>

                    <div id="modalFeaturesContainer" class="space-y-4">
                        <!-- Features will be added here dynamically -->
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closePackageModal()" 
                            class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                        <span id="submitButtonText">Create Package</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let packageToDelete = null;
        let modalFeatureCount = 0;
        let isEditMode = false;

        // Filter functionality
        document.getElementById('typeFilter').addEventListener('change', filterPackages);
        document.getElementById('statusFilter').addEventListener('change', filterPackages);
        document.getElementById('searchInput').addEventListener('input', filterPackages);

        function filterPackages() {
            const typeFilter = document.getElementById('typeFilter').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            const packageCards = document.querySelectorAll('.package-card');
            
            packageCards.forEach(card => {
                const type = card.dataset.type;
                const status = card.dataset.status;
                const name = card.dataset.name;
                
                const typeMatch = !typeFilter || type === typeFilter;
                const statusMatch = !statusFilter || status === statusFilter;
                const searchMatch = !searchTerm || name.includes(searchTerm);
                
                card.style.display = (typeMatch && statusMatch && searchMatch) ? 'block' : 'none';
            });
        }

        function toggleStatus(packageId, button) {
            fetch(`/admin/packages/${packageId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const card = button.closest('.package-card');
                    if (data.is_active) {
                        button.className = 'status-toggle p-2 rounded-full transition-colors bg-green-100 text-green-600';
                        card.dataset.status = 'active';
                    } else {
                        button.className = 'status-toggle p-2 rounded-full transition-colors bg-gray-100 text-gray-600';
                        card.dataset.status = 'inactive';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update package status');
            });
        }

        function deletePackage(packageId, packageName) {
            packageToDelete = packageId;
            document.getElementById('packageName').textContent = packageName;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            packageToDelete = null;
        }

        function confirmDelete() {
            if (packageToDelete) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/packages/${packageToDelete}`;
                form.innerHTML = `
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Package Modal Functions
        function openCreateModal() {
            isEditMode = false;
            document.getElementById('modalTitle').textContent = 'Create Package';
            document.getElementById('submitButtonText').textContent = 'Create Package';
            document.getElementById('_method').value = 'POST';
            document.getElementById('packageForm').action = '{{ route("admin.packages.store") }}';
            
            // Clear form
            document.getElementById('packageForm').reset();
            document.getElementById('packageId').value = '';
            clearModalFeatures();
            addModalFeature(); // Add initial feature
            
            document.getElementById('packageModal').classList.remove('hidden');
        }

        function openEditModal(packageId) {
            isEditMode = true;
            document.getElementById('modalTitle').textContent = 'Edit Package';
            document.getElementById('submitButtonText').textContent = 'Update Package';
            document.getElementById('_method').value = 'PUT';
            document.getElementById('packageForm').action = `/admin/packages/${packageId}`;
            document.getElementById('packageId').value = packageId;
            
            // Load package data
            fetch(`/admin/packages/${packageId}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const package = data.package;
                        
                        document.getElementById('modalName').value = package.name;
                        document.getElementById('modalType').value = package.type;
                        document.getElementById('modalDisplayTitle').value = package.title;
                        document.getElementById('modalPrice').value = package.price;
                        document.getElementById('modalDescription').value = package.description;
                        document.getElementById('modalIsActive').checked = package.is_active;
                        
                        // Load features
                        clearModalFeatures();
                        if (package.features && package.features.length > 0) {
                            package.features.forEach(feature => {
                                addModalFeature(feature);
                            });
                        } else {
                            addModalFeature(); // Add initial feature if none exist
                        }
                        
                        document.getElementById('packageModal').classList.remove('hidden');
                    } else {
                        alert('Failed to load package data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load package data');
                });
        }

        function closePackageModal() {
            document.getElementById('packageModal').classList.add('hidden');
            isEditMode = false;
        }

        function addModalFeature(feature = null) {
            modalFeatureCount++;
            const container = document.getElementById('modalFeaturesContainer');
            
            const featureHtml = `
                <div class="modal-feature-item border border-gray-200 rounded-lg p-4" data-feature="${modalFeatureCount}">
                    <div class="flex justify-between items-start mb-4">
                        <h5 class="text-md font-medium text-gray-900">Feature ${modalFeatureCount}</h5>
                        <button type="button" onclick="removeModalFeature(${modalFeatureCount})" 
                                class="text-red-600 hover:text-red-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Feature Title *</label>
                            <input type="text" name="features[${modalFeatureCount}][title]" required
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   placeholder="e.g., Professional Photography"
                                   value="${feature ? feature.title : ''}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order *</label>
                            <input type="number" name="features[${modalFeatureCount}][sort_order]" value="${feature ? feature.sort_order : modalFeatureCount}" required min="1"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                        <textarea name="features[${modalFeatureCount}][description]" rows="3" required
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                  placeholder="Describe this feature...">${feature ? feature.description : ''}</textarea>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', featureHtml);
        }

        function removeModalFeature(featureNumber) {
            const featureElement = document.querySelector(`[data-feature="${featureNumber}"]`);
            if (featureElement) {
                featureElement.remove();
            }
        }

        function clearModalFeatures() {
            document.getElementById('modalFeaturesContainer').innerHTML = '';
            modalFeatureCount = 0;
        }

        // Form submission
        document.getElementById('packageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Add CSRF token
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            fetch(this.action, {
                method: 'POST', // Always use POST
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closePackageModal();
                    // Reload page to show updated data
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to save package');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to save package. Please check your input and try again.');
            });
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            const deleteModal = document.getElementById('deleteModal');
            const packageModal = document.getElementById('packageModal');
            
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
            if (e.target === packageModal) {
                closePackageModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
                closePackageModal();
            }
        });
    </script>
    @endpush
</x-admin-layout> 