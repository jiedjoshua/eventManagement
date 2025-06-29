<x-admin-layout title="Package Management" :active-page="$activePage">
    <!-- Enhanced Header (Dashboard Style) -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Package Management</h1>
                <p class="text-gray-600 mt-2">Manage all event packages and add-ons</p>
            </div>
            <div class="flex gap-3">
                <button onclick="openCreateAddonModal()" 
                        class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-5 py-2.5 rounded-2xl flex items-center space-x-2 shadow-lg font-semibold transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Add Add-on</span>
                </button>
                <button onclick="openCreateModal()" 
                        class="bg-gradient-to-r from-violet-500 to-violet-600 hover:from-violet-600 hover:to-violet-700 text-white px-5 py-2.5 rounded-2xl flex items-center space-x-2 shadow-lg font-semibold transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Add Package</span>
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-4 py-3 rounded-2xl mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Enhanced Filter Section (Dashboard Style) -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-10 flex flex-col md:flex-row md:space-x-8 gap-6">
        <div class="flex-1">
            <label for="typeFilter" class="block text-sm font-semibold text-gray-800 mb-2">Filter by Type</label>
            <select id="typeFilter" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-violet-500 bg-gray-50 text-gray-800">
                <option value="">All Types</option>
                <option value="Wedding">Wedding</option>
                <option value="Birthday">Birthday</option>
                <option value="Baptism">Baptism</option>
            </select>
        </div>
        <div class="flex-1">
            <label for="statusFilter" class="block text-sm font-semibold text-gray-800 mb-2">Filter by Status</label>
            <select id="statusFilter" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-violet-500 bg-gray-50 text-gray-800">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="flex-1">
            <label for="searchInput" class="block text-sm font-semibold text-gray-800 mb-2">Search</label>
            <input type="text" id="searchInput" placeholder="Search packages..." 
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-violet-500 bg-gray-50 text-gray-800">
        </div>
    </div>

    <!-- Enhanced Packages Grid (Dashboard Style) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($packages as $package)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden package-card transition-all duration-300 hover:shadow-xl hover:-translate-y-1" 
                 data-type="{{ strtolower($package->type) }}" 
                 data-status="{{ $package->is_active ? 'active' : 'inactive' }}"
                 data-name="{{ strtolower($package->name) }}">
                <!-- Package Header -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $package->name }}</h3>
                            <p class="text-sm font-medium text-gray-600">{{ $package->title }}</p>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <!-- Status Toggle -->
                            <button onclick="toggleStatus({{ $package->id }}, this)" 
                                    class="status-toggle p-2 rounded-full transition-colors {{ $package->is_active ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border-green-200' : 'bg-gradient-to-r from-gray-100 to-slate-100 text-gray-500 border-gray-200' }} border shadow-sm hover:shadow-md"
                                    data-package-id="{{ $package->id }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                            <!-- Type Badge -->
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold 
                                       {{ $package->type === 'Wedding' ? 'bg-gradient-to-r from-purple-100 to-violet-100 text-purple-800 border border-purple-200' : 
                                          ($package->type === 'Birthday' ? 'bg-gradient-to-r from-pink-100 to-rose-100 text-pink-800 border border-pink-200' : 'bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 border border-blue-200') }}">
                                {{ $package->type }}
                            </span>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4 line-clamp-2 font-medium">{{ $package->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">₱{{ number_format($package->price) }}</span>
                        <span class="text-sm text-gray-500 font-medium">{{ $package->features->count() }} features</span>
                    </div>
                </div>
                <!-- Package Features Preview -->
                <div class="p-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Features:</h4>
                    <div class="space-y-2">
                        @foreach($package->features->take(1) as $feature)
                            <div class="flex items-center text-sm text-gray-700 font-medium">
                                <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $feature->title }}
                            </div>
                        @endforeach
                        @if($package->features->count() > 1)
                            <div class="text-sm text-gray-500 italic font-medium">
                                +{{ $package->features->count() - 1 }} more features
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Actions -->
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-slate-50 border-t border-gray-100 rounded-b-2xl">
                    <div class="flex space-x-2">
                        <button onclick="openEditModal({{ $package->id }})" 
                                class="flex-1 bg-gradient-to-r from-violet-100 to-purple-100 text-violet-700 px-3 py-2 rounded-xl text-sm font-semibold hover:from-violet-200 hover:to-purple-200 transition-all duration-300 text-center shadow-sm border border-violet-200">
                            Edit
                        </button>
                        <button onclick="deletePackage({{ $package->id }}, '{{ $package->name }}')" 
                                class="flex-1 bg-gradient-to-r from-red-100 to-rose-100 text-red-700 px-3 py-2 rounded-xl text-sm font-semibold hover:from-red-200 hover:to-rose-200 transition-all duration-300 shadow-sm border border-red-200">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <svg class="mx-auto h-14 w-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-800">No packages</h3>
                <p class="mt-2 text-base text-gray-500">Get started by creating a new package.</p>
                <div class="mt-8">
                    <a href="{{ route('admin.packages.create') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent shadow-lg text-base font-bold rounded-2xl text-white bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Package
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Add-ons Section -->
    <div class="mt-10">
        <h2 class="text-2xl font-bold mb-4 text-gray-900">Add-ons</h2>
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($addons as $addon)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">{{ $addon->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 font-semibold">₱{{ number_format($addon->price) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button onclick="openEditAddonModal({{ $addon->id }})" class="text-violet-600 hover:text-violet-800 font-medium mr-3 transition-colors">Edit</button>
                                <button onclick="deleteAddon({{ $addon->id }}, '{{ $addon->name }}')" class="text-red-600 hover:text-red-800 font-medium transition-colors">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No add-ons found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-r from-red-100 to-rose-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mt-4">Delete Package</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-600">
                        Are you sure you want to delete "<span id="packageName" class="font-semibold text-gray-800"></span>"? This action cannot be undone.
                    </p>
                </div>
                <div class="flex justify-center space-x-4 mt-4">
                    <button onclick="closeDeleteModal()" 
                            class="px-4 py-2 bg-gradient-to-r from-gray-100 to-slate-100 text-gray-700 rounded-xl hover:from-gray-200 hover:to-slate-200 transition-all duration-300 font-medium">
                        Cancel
                    </button>
                    <button onclick="confirmDelete()" 
                            class="px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-xl hover:from-red-600 hover:to-rose-700 transition-all duration-300 font-medium shadow-lg">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Package Modal -->
    <div id="packageModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-2xl bg-white max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900" id="modalTitle">Create Package</h3>
                <button onclick="closePackageModal()" class="text-gray-500 hover:text-gray-700 transition-colors">
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
                <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl p-6 border border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="modalName" class="block text-sm font-semibold text-gray-800 mb-2">Package Name *</label>
                            <input type="text" id="modalName" name="name" required
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 text-gray-800"
                                   placeholder="e.g., Premium Wedding Package">
                        </div>

                        <div>
                            <label for="modalType" class="block text-sm font-semibold text-gray-800 mb-2">Event Type *</label>
                            <select id="modalType" name="type" required
                                    class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 text-gray-800">
                                <option value="">Select Event Type</option>
                                <option value="Wedding">Wedding</option>
                                <option value="Birthday">Birthday</option>
                                <option value="Baptism">Baptism</option>
                            </select>
                        </div>

                        <div>
                            <label for="modalTitle" class="block text-sm font-semibold text-gray-800 mb-2">Display Title *</label>
                            <input type="text" id="modalDisplayTitle" name="title" required
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 text-gray-800"
                                   placeholder="e.g., Premium Wedding Experience">
                        </div>

                        <div>
                            <label for="modalPrice" class="block text-sm font-semibold text-gray-800 mb-2">Price (₱) *</label>
                            <input type="number" id="modalPrice" name="price" required min="0" step="0.01"
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 text-gray-800"
                                   placeholder="0.00">
                        </div>

                        <div class="md:col-span-2">
                            <label for="modalDescription" class="block text-sm font-semibold text-gray-800 mb-2">Description *</label>
                            <textarea id="modalDescription" name="description" rows="3" required
                                      class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 text-gray-800"
                                      placeholder="Describe what's included in this package..."></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" id="modalIsActive" name="is_active" value="1"
                                       class="rounded border-gray-300 text-violet-600 shadow-sm focus:border-violet-300 focus:ring focus:ring-violet-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-medium text-gray-800">Active Package</span>
                            </label>
                            <p class="text-xs text-gray-600 mt-1">Active packages will be available for booking</p>
                        </div>
                    </div>
                </div>

                <!-- Package Features -->
                <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl p-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-semibold text-gray-900">Package Features</h4>
                        <button type="button" onclick="addModalFeature()" 
                                class="bg-gradient-to-r from-violet-500 to-purple-600 text-white px-3 py-1.5 rounded-xl hover:from-violet-600 hover:to-purple-700 transition-all duration-300 text-sm flex items-center space-x-1 shadow-lg">
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
                            class="bg-gradient-to-r from-gray-100 to-slate-100 text-gray-700 px-6 py-2.5 rounded-xl hover:from-gray-200 hover:to-slate-200 transition-all duration-300 font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="bg-gradient-to-r from-violet-500 to-purple-600 text-white px-6 py-2.5 rounded-xl hover:from-violet-600 hover:to-purple-700 transition-all duration-300 font-medium shadow-lg">
                        <span id="submitButtonText">Create Package</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add-on Create/Edit Modal -->
    <div id="addonModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-2xl bg-white max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900" id="addonModalTitle">Create Add-on</h3>
                <button onclick="closeAddonModal()" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="addonForm" class="space-y-6">
                @csrf
                <input type="hidden" id="addonId" name="addon_id">
                <input type="hidden" id="addon_method" name="_method" value="POST">
                <div>
                    <label for="addonName" class="block text-sm font-semibold text-gray-800 mb-2">Display Name *</label>
                    <input type="text" id="addonName" name="name" required
                           class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-gray-800"
                           placeholder="e.g., Extra Photography">
                </div>
                <div>
                    <label for="addonPrice" class="block text-sm font-semibold text-gray-800 mb-2">Price (₱) *</label>
                    <input type="number" id="addonPrice" name="price" required min="0" step="0.01"
                           class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-gray-800"
                           placeholder="0.00">
                </div>
                <div>
                    <label for="addonDescription" class="block text-sm font-semibold text-gray-800 mb-2">Description</label>
                    <textarea id="addonDescription" name="description" rows="3"
                              class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-gray-800"
                              placeholder="Describe this add-on..."></textarea>
                </div>
                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeAddonModal()" 
                            class="bg-gradient-to-r from-gray-100 to-slate-100 text-gray-700 px-6 py-2.5 rounded-xl hover:from-gray-200 hover:to-slate-200 transition-all duration-300 font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-2.5 rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 font-medium shadow-lg">
                        <span id="addonSubmitButtonText">Create Add-on</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add-on Delete Confirmation Modal -->
    <div id="addonDeleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-r from-red-100 to-rose-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mt-4">Delete Add-on</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-600">
                        Are you sure you want to delete "<span id="addonName" class="font-semibold text-gray-800"></span>"? This action cannot be undone.
                    </p>
                </div>
                <div class="flex justify-center space-x-4 mt-4">
                    <button onclick="closeAddonDeleteModal()" 
                            class="px-4 py-2 bg-gradient-to-r from-gray-100 to-slate-100 text-gray-700 rounded-xl hover:from-gray-200 hover:to-slate-200 transition-all duration-300 font-medium">
                        Cancel
                    </button>
                    <button onclick="confirmAddonDelete()" 
                            class="px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-xl hover:from-red-600 hover:to-rose-700 transition-all duration-300 font-medium shadow-lg">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Notification -->
    <div id="successNotification" class="hidden fixed top-4 right-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl z-50 shadow-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="successMessage"></span>
        </div>
    </div>

    @push('scripts')
    <script>
        let packageToDelete = null;
        let modalFeatureCount = 0;
        let isEditMode = false;
        let addonToDelete = null;

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
                        button.className = 'status-toggle p-2 rounded-full transition-colors bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border-green-200';
                        card.dataset.status = 'active';
                    } else {
                        button.className = 'status-toggle p-2 rounded-full transition-colors bg-gradient-to-r from-gray-100 to-slate-100 text-gray-500 border-gray-200';
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
                        // Normalize event type value to match select options
                        const typeValue = package.type
                            ? package.type.charAt(0).toUpperCase() + package.type.slice(1).toLowerCase()
                            : '';
                        document.getElementById('modalType').value = typeValue;
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
            const addonModal = document.getElementById('addonModal');
            const addonDeleteModal = document.getElementById('addonDeleteModal');
            
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
            if (e.target === packageModal) {
                closePackageModal();
            }
            if (e.target === addonModal) {
                closeAddonModal();
            }
            if (e.target === addonDeleteModal) {
                closeAddonDeleteModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
                closePackageModal();
                closeAddonModal();
                closeAddonDeleteModal();
            }
        });

        // Add-on Modal Functions
        function openCreateAddonModal() {
            document.getElementById('addonModalTitle').textContent = 'Create Add-on';
            document.getElementById('addonSubmitButtonText').textContent = 'Create Add-on';
            document.getElementById('addon_method').value = 'POST';
            document.getElementById('addonForm').action = '/admin/addons'; // Adjust route as needed
            document.getElementById('addonForm').reset();
            document.getElementById('addonId').value = '';
            document.getElementById('addonModal').classList.remove('hidden');
        }

        function openEditAddonModal(addonId) {
            document.getElementById('addonModalTitle').textContent = 'Edit Add-on';
            document.getElementById('addonSubmitButtonText').textContent = 'Update Add-on';
            document.getElementById('addon_method').value = 'PUT';
            document.getElementById('addonForm').action = `/admin/addons/${addonId}`; // Adjust route as needed
            document.getElementById('addonId').value = addonId;
            // Fetch add-on data (AJAX)
            fetch(`/admin/addons/${addonId}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const addon = data.addon;
                        document.getElementById('addonName').value = addon.name;
                        document.getElementById('addonPrice').value = addon.price;
                        document.getElementById('addonDescription').value = addon.description || '';
                        document.getElementById('addonModal').classList.remove('hidden');
                    } else {
                        alert('Failed to load add-on data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load add-on data');
                });
        }

        function closeAddonModal() {
            document.getElementById('addonModal').classList.add('hidden');
        }

        // Add-on AJAX form submission
        const addonForm = document.getElementById('addonForm');
        if (addonForm) {
            addonForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                let url = this.action;
                fetch(url, {
                    method: 'POST', // Always use POST
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeAddonModal();
                        showSuccessNotification(data.message);
                        // Reload page to show updated data
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        alert(data.message || 'Failed to save add-on');
                    }
                })
                .catch(error => {
                    alert('Failed to save add-on. Please check your input and try again.');
                });
            });
        }

        // Success notification function
        function showSuccessNotification(message) {
            const notification = document.getElementById('successNotification');
            const messageElement = document.getElementById('successMessage');
            messageElement.textContent = message;
            notification.classList.remove('hidden');
            
            // Auto-hide after 3 seconds
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }

        // Add-on delete functions
        function deleteAddon(addonId, addonName) {
            addonToDelete = addonId;
            document.getElementById('addonName').textContent = addonName;
            document.getElementById('addonDeleteModal').classList.remove('hidden');
        }

        function closeAddonDeleteModal() {
            document.getElementById('addonDeleteModal').classList.add('hidden');
            addonToDelete = null;
        }

        function confirmAddonDelete() {
            if (addonToDelete) {
                fetch(`/admin/addons/${addonToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    closeAddonDeleteModal();
                    if (data.success) {
                        showSuccessNotification(data.message);
                        // Reload page to show updated data
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        alert(data.message || 'Failed to delete add-on');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to delete add-on. Please try again.');
                });
            }
        }
    </script>
    @endpush
</x-admin-layout> 