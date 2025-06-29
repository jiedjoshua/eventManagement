<x-admin-layout title="Packages Page CMS" active-page="packages-cms">
    <div class="p-6">
        <!-- Modernized Header -->
        <div class="mb-6 flex justify-between items-center bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-6">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Packages Page Content Management</h1>
                <p class="text-purple-100">Manage and customize your packages page content</p>
            </div>
            <a href="{{ route('packages') }}" target="_blank" class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                <span>View Packages Page</span>
            </a>
        </div>

        <!-- Enhanced Success/Error Messages -->
        <div id="message-container" class="fixed top-4 right-4 z-50 hidden">
            <div id="success-message" class="hidden bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl transform transition-all duration-300 ease-in-out border border-emerald-400">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium"></span>
                </div>
            </div>
            <div id="error-message" class="hidden bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-xl shadow-2xl transform transition-all duration-300 ease-in-out border border-red-400">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="font-medium"></span>
                </div>
            </div>
        </div>

        <!-- Modernized Hero Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Hero Section</h2>
                            <p class="text-sm text-gray-600">Main banner and call-to-action area for the packages page</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="packages-hero-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['packages_hero']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="packages_hero">
                            {{ $content['packages_hero']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form id="packages-hero-form" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Title</label>
                            <input type="text" name="hero_title" value="{{ $content['packages_hero']->title ?? 'Event Packages' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Subtitle</label>
                            <input type="text" name="hero_subtitle" value="{{ $content['packages_hero']->subtitle ?? 'Choose the perfect package for your special occasion' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Update Hero Section</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Wedding Packages Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mt-10">
            <div class="bg-gradient-to-r from-pink-50 to-rose-50 px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Wedding Packages</h2>
                            <p class="text-sm text-gray-600">Manage all wedding packages and their features</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="packages-wedding-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['packages_wedding']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="packages_wedding">
                            {{ $content['packages_wedding']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form id="packages-wedding-form" class="space-y-8">
                    @csrf
                    <div id="wedding-packages-container">
                        @php
                            $defaultWeddingPackages = [
                                ['name' => 'Classic Wedding', 'price' => '₱50,000', 'features' => ['Venue coordination', 'Basic decor', 'On-the-day coordination']],
                                ['name' => 'Elegant Wedding', 'price' => '₱100,000', 'features' => ['Premium venue', 'Full floral design', 'Photo & video coverage']],
                                ['name' => 'Luxury Wedding', 'price' => '₱200,000', 'features' => ['5-star venue', 'Luxury styling', 'Live band & emcee']],
                            ];
                            $weddingPackages = $content['packages_wedding']->service_cards ?? $defaultWeddingPackages;
                        @endphp

                        @foreach($weddingPackages as $index => $package)
                            <div class="package-card bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-all duration-200" data-index="{{ $index }}">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900">Package {{ $index + 1 }}</h3>
                                    </div>
                                    @if($index > 0)
                                        <button type="button" class="remove-package text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Package Name</label>
                                        <input type="text" name="packages[{{ $index }}][name]" value="{{ $package['name'] }}" 
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Price</label>
                                        <input type="text" name="packages[{{ $index }}][price]" value="{{ $package['price'] }}" 
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Features</label>
                                    <div class="features-container space-y-2">
                                        @foreach($package['features'] as $featureIndex => $feature)
                                            <div class="flex items-center space-x-2">
                                                <input type="text" name="packages[{{ $index }}][features][]" value="{{ $feature }}" 
                                                       class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                                <button type="button" class="remove-feature text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="add-feature mt-2 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-4 py-2 rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-sm font-medium">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Feature
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between">
                        <button type="button" id="add-wedding-package" class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-medium">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Package
                        </button>
                        <button type="submit" class="bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white px-8 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-medium">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Wedding Packages
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Birthday Packages Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mt-10">
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Birthday Packages</h2>
                            <p class="text-sm text-gray-600">Manage all birthday packages and their features</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="packages-birthday-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['packages_birthday']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="packages_birthday">
                            {{ $content['packages_birthday']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form id="packages-birthday-form" class="space-y-8">
                    @csrf
                    <div id="birthday-packages-container">
                        @php
                            $defaultBirthdayPackages = [
                                ['name' => 'Kids Party', 'price' => '₱15,000', 'features' => ['Theme decor', 'Party host', 'Games & prizes']],
                                ['name' => 'Teen Bash', 'price' => '₱25,000', 'features' => ['DJ & lights', 'Photo booth', 'Custom cake']],
                                ['name' => 'Milestone Birthday', 'price' => '₱40,000', 'features' => ['Venue rental', 'Catering', 'Live entertainment']],
                            ];
                            $birthdayPackages = $content['packages_birthday']->service_cards ?? $defaultBirthdayPackages;
                        @endphp

                        @foreach($birthdayPackages as $index => $package)
                            <div class="package-card bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-all duration-200" data-index="{{ $index }}">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900">Package {{ $index + 1 }}</h3>
                                    </div>
                                    @if($index > 0)
                                        <button type="button" class="remove-package text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Package Name</label>
                                        <input type="text" name="packages[{{ $index }}][name]" value="{{ $package['name'] }}" 
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Price</label>
                                        <input type="text" name="packages[{{ $index }}][price]" value="{{ $package['price'] }}" 
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Features</label>
                                    <div class="features-container space-y-2">
                                        @foreach($package['features'] as $featureIndex => $feature)
                                            <div class="flex items-center space-x-2">
                                                <input type="text" name="packages[{{ $index }}][features][]" value="{{ $feature }}" 
                                                       class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                                <button type="button" class="remove-feature text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="add-feature mt-2 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-4 py-2 rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-sm font-medium">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Feature
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between">
                        <button type="button" id="add-birthday-package" class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-medium">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Package
                        </button>
                        <button type="submit" class="bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white px-8 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-medium">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Birthday Packages
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Debut Packages Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mt-10">
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Debut Packages</h2>
                            <p class="text-sm text-gray-600">Manage all debut packages and their features</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="packages-debut-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['packages_debut']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="packages_debut">
                            {{ $content['packages_debut']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form id="packages-debut-form" class="space-y-8">
                    @csrf
                    <div id="debut-packages-container">
                        @php
                            $defaultDebutPackages = [
                                ['name' => 'Simple Debut', 'price' => '₱30,000', 'features' => ['Venue setup', '18 roses/candles', 'Basic program']],
                                ['name' => 'Glam Debut', 'price' => '₱60,000', 'features' => ['Photo & video', 'Full program', 'Host & DJ']],
                                ['name' => 'Grand Debut', 'price' => '₱120,000', 'features' => ['Luxury venue', 'Live band', 'Full event styling']],
                            ];
                            $debutPackages = $content['packages_debut']->service_cards ?? $defaultDebutPackages;
                        @endphp

                        @foreach($debutPackages as $index => $package)
                            <div class="package-card bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-all duration-200" data-index="{{ $index }}">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900">Package {{ $index + 1 }}</h3>
                                    </div>
                                    @if($index > 0)
                                        <button type="button" class="remove-package text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Package Name</label>
                                        <input type="text" name="packages[{{ $index }}][name]" value="{{ $package['name'] }}" 
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Price</label>
                                        <input type="text" name="packages[{{ $index }}][price]" value="{{ $package['price'] }}" 
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Features</label>
                                    <div class="features-container space-y-2">
                                        @foreach($package['features'] as $featureIndex => $feature)
                                            <div class="flex items-center space-x-2">
                                                <input type="text" name="packages[{{ $index }}][features][]" value="{{ $feature }}" 
                                                       class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                                <button type="button" class="remove-feature text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="add-feature mt-2 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-4 py-2 rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-sm font-medium">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Feature
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between">
                        <button type="button" id="add-debut-package" class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-medium">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Package
                        </button>
                        <button type="submit" class="bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white px-8 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-medium">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Debut Packages
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Baptism Packages Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mt-10">
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Baptism Packages</h2>
                            <p class="text-sm text-gray-600">Manage all baptism packages and their features</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="packages-baptism-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['packages_baptism']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="packages_baptism">
                            {{ $content['packages_baptism']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form id="packages-baptism-form" class="space-y-8">
                    @csrf
                    <div id="baptism-packages-container">
                        @php
                            $defaultBaptismPackages = [
                                ['name' => 'Simple Baptism', 'price' => '₱20,000', 'features' => ['Church coordination', 'Basic reception', 'Simple decor']],
                                ['name' => 'Traditional Baptism', 'price' => '₱35,000', 'features' => ['Full reception', 'Photo & video', 'Catering']],
                                ['name' => 'Grand Baptism', 'price' => '₱60,000', 'features' => ['Luxury venue', 'Live entertainment', 'Full event styling']],
                            ];
                            $baptismPackages = $content['packages_baptism']->service_cards ?? $defaultBaptismPackages;
                        @endphp

                        @foreach($baptismPackages as $index => $package)
                            <div class="package-card bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-all duration-200" data-index="{{ $index }}">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900">Package {{ $index + 1 }}</h3>
                                    </div>
                                    @if($index > 0)
                                        <button type="button" class="remove-package text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Package Name</label>
                                        <input type="text" name="packages[{{ $index }}][name]" value="{{ $package['name'] }}" 
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Price</label>
                                        <input type="text" name="packages[{{ $index }}][price]" value="{{ $package['price'] }}" 
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Features</label>
                                    <div class="features-container space-y-2">
                                        @foreach($package['features'] as $featureIndex => $feature)
                                            <div class="flex items-center space-x-2">
                                                <input type="text" name="packages[{{ $index }}][features][]" value="{{ $feature }}" 
                                                       class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                                <button type="button" class="remove-feature text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="add-feature mt-2 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-4 py-2 rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-sm font-medium">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Feature
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between">
                        <button type="button" id="add-baptism-package" class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-medium">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Package
                        </button>
                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white px-8 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-medium">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Baptism Packages
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Utility functions
        function showMessage(message, type = 'success') {
            const container = document.getElementById('message-container');
            const successMsg = document.getElementById('success-message');
            const errorMsg = document.getElementById('error-message');
            
            // Hide any existing messages first
            successMsg.classList.add('hidden');
            errorMsg.classList.add('hidden');
            
            // Show container and add slide-in animation
            container.classList.remove('hidden');
            container.style.transform = 'translateX(100%)';
            
            // Force reflow
            container.offsetHeight;
            
            // Slide in
            container.style.transform = 'translateX(0)';
            
            if (type === 'success') {
                successMsg.querySelector('span').textContent = message;
                successMsg.classList.remove('hidden');
            } else {
                errorMsg.querySelector('span').textContent = message;
                errorMsg.classList.remove('hidden');
            }
            
            // Auto hide after 4 seconds
            setTimeout(() => {
                container.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    container.classList.add('hidden');
                }, 300);
            }, 4000);
        }

        // Toggle section visibility
        document.querySelectorAll('.toggle-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const section = this.dataset.section;
                
                fetch('{{ route("admin.cms.section.toggle") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ section: section })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage(data.message, 'success');
                        // Update button appearance
                        if (data.is_active) {
                            this.classList.remove('bg-red-100', 'text-red-800');
                            this.classList.add('bg-green-100', 'text-green-800');
                            this.textContent = 'Active';
                        } else {
                            this.classList.remove('bg-green-100', 'text-green-800');
                            this.classList.add('bg-red-100', 'text-red-800');
                            this.textContent = 'Inactive';
                        }
                    } else {
                        showMessage(data.message, 'error');
                    }
                })
                .catch(error => {
                    showMessage('An error occurred while toggling section.', 'error');
                });
            });
        });

        // Hero Form
        document.getElementById('packages-hero-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("admin.cms.packages-page.hero.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(error => {
                showMessage('An error occurred while updating the hero section.', 'error');
            });
        });

        // Package Forms
        const packageTypes = ['wedding', 'birthday', 'debut', 'baptism'];
        
        packageTypes.forEach(type => {
            const form = document.getElementById(`packages-${type}-form`);
            const addBtn = document.getElementById(`add-${type}-package`);
            const container = document.getElementById(`${type}-packages-container`);
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    
                    fetch(`/admin/cms/packages-page/${type}/update`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showMessage(data.message, 'success');
                        } else {
                            showMessage(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showMessage(`An error occurred while updating ${type} packages.`, 'error');
                    });
                });
            }
            
            if (addBtn) {
                addBtn.addEventListener('click', function() {
                    addPackage(container, type);
                });
            }
        });

        // Add Package functionality
        function addPackage(container, type) {
            const index = container.children.length;
            
            const packageCard = document.createElement('div');
            packageCard.className = 'package-card border border-gray-200 rounded-lg p-4';
            packageCard.dataset.index = index;
            
            packageCard.innerHTML = `
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Package ${index + 1}</h3>
                    <button type="button" class="remove-package text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Package Name</label>
                        <input type="text" name="packages[${index}][name]" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Price</label>
                        <input type="text" name="packages[${index}][price]" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Features</label>
                    <div class="features-container space-y-2">
                        <div class="flex items-center space-x-2">
                            <input type="text" name="packages[${index}][features][]" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <button type="button" class="remove-feature text-red-600 hover:text-red-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="add-feature mt-2 text-indigo-600 hover:text-indigo-800 text-sm">
                        + Add Feature
                    </button>
                </div>
            `;
            
            container.appendChild(packageCard);
            
            // Add remove functionality to new card
            packageCard.querySelector('.remove-package').addEventListener('click', function() {
                packageCard.remove();
                updatePackageIndices(container);
            });

            // Add feature functionality
            packageCard.querySelector('.add-feature').addEventListener('click', function() {
                addFeature(packageCard.querySelector('.features-container'));
            });

            // Add remove feature functionality
            packageCard.querySelectorAll('.remove-feature').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.flex').remove();
                });
            });
        }

        // Remove Package functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-package')) {
                const packageCard = e.target.closest('.package-card');
                const container = packageCard.parentElement;
                packageCard.remove();
                updatePackageIndices(container);
            }
        });

        // Add Feature functionality
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-feature')) {
                const container = e.target.previousElementSibling;
                addFeature(container);
            }
        });

        // Remove Feature functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-feature')) {
                e.target.closest('.flex').remove();
            }
        });

        function addFeature(container) {
            const featureDiv = document.createElement('div');
            featureDiv.className = 'flex items-center space-x-2';
            featureDiv.innerHTML = `
                <input type="text" name="packages[${container.closest('.package-card').dataset.index}][features][]" 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="button" class="remove-feature text-red-600 hover:text-red-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(featureDiv);
        }

        function updatePackageIndices(container) {
            container.querySelectorAll('.package-card').forEach((card, idx) => {
                card.dataset.index = idx;
                card.querySelector('h3').textContent = `Package ${idx + 1}`;
                card.querySelectorAll('input').forEach(input => {
                    const name = input.name;
                    if (name) {
                        input.name = name.replace(/\[\d+\]/, `[${idx}]`);
                    }
                });
            });
        }
    </script>
    @endpush
</x-admin-layout>
 