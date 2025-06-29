<x-admin-layout title="Services Page CMS" active-page="services-cms">
    <div class="p-6">
        <!-- Modernized Header -->
        <div class="mb-6 flex justify-between items-center bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-6">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Services Page Content Management</h1>
                <p class="text-purple-100">Manage and customize your services page content</p>
            </div>
            <a href="{{ route('services') }}" target="_blank" class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                <span>View Services Page</span>
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
                            <p class="text-sm text-gray-600">Main banner and call-to-action area for the services page</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="services-hero-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['services_hero']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="services_hero">
                            {{ $content['services_hero']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form id="services-hero-form" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Title</label>
                            <input type="text" name="hero_title" value="{{ $content['services_hero']->title ?? 'Our Event Services' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Button Text</label>
                            <input type="text" name="hero_button_text" value="{{ $content['services_hero']->button_text ?? 'Start Planning Your Event' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Subtitle</label>
                            <input type="text" name="hero_subtitle" value="{{ $content['services_hero']->subtitle ?? 'Comprehensive event planning and management for every special occasion' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Button Link</label>
                            <input type="text" name="hero_button_link" value="{{ $content['services_hero']->button_link ?? '/book-now' }}" 
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

        <!-- Enhanced Main Services Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mt-10">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Main Services Section</h2>
                            <p class="text-sm text-gray-600">Manage the main services displayed on the services page</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="services-page-services-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['services_page_services']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="services_page_services">
                            {{ $content['services_page_services']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form id="services-page-services-form" class="space-y-6">
                    @csrf
                    <div id="services-page-container">
                        @php
                            $defaultServicesPage = [
                                [
                                    'title' => 'Wedding Planning',
                                    'description' => 'Create the wedding of your dreams with our comprehensive planning services. From intimate ceremonies to grand celebrations, we handle every detail.',
                                    'type' => 'wedding',
                                    'image_path' => '/public/img/wedding.webp',
                                    'features' => [
                                        'Venue selection and coordination',
                                        'Catering and menu planning',
                                        'Decoration and floral arrangements',
                                        'Photography and videography',
                                        'Guest list management'
                                    ]
                                ],
                                [
                                    'title' => 'Birthday Celebrations',
                                    'description' => 'Make every birthday unforgettable with our creative and personalized celebration planning. From kids\' parties to milestone birthdays.',
                                    'type' => 'birthday',
                                    'image_path' => '/public/img/birthday.jpg',
                                    'features' => [
                                        'Theme-based party planning',
                                        'Entertainment and activities',
                                        'Custom cake and dessert setup',
                                        'Party favors and decorations',
                                        'Photography and memories'
                                    ]
                                ],
                                [
                                    'title' => 'Debut Planning',
                                    'description' => 'Celebrate the transition to adulthood with an elegant and memorable debut celebration. We create sophisticated events that honor this important milestone.',
                                    'type' => 'debut',
                                    'image_path' => '/public/img/debut.webp',
                                    'features' => [
                                        'Elegant venue selection',
                                        'Formal dinner and reception',
                                        'Traditional 18 roses and 18 candles',
                                        'Professional photography',
                                        'Live entertainment and music'
                                    ]
                                ],
                                [
                                    'title' => 'Baptism Planning',
                                    'description' => 'Celebrate the spiritual journey with a beautiful baptism ceremony and reception. We coordinate with churches and create meaningful celebrations.',
                                    'type' => 'baptism',
                                    'image_path' => '/public/img/baptism.jpg',
                                    'features' => [
                                        'Church coordination',
                                        'Reception venue planning',
                                        'Catering and refreshments',
                                        'Baptism souvenirs and favors',
                                        'Documentation and photography'
                                    ]
                                ]
                            ];
                            $servicesPage = $content['services_page_services']->service_cards ?? $defaultServicesPage;
                        @endphp

                        @foreach($servicesPage as $index => $service)
                            <div class="service-page-card bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-200" data-index="{{ $index }}">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">{{ $index + 1 }}</span>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900">Service {{ $index + 1 }}</h3>
                                    </div>
                                    @if($index > 0)
                                        <button type="button" class="remove-service-page text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Service Title</label>
                                        <input type="text" name="services[{{ $index }}][title]" value="{{ $service['title'] }}" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Service Type</label>
                                        <select name="services[{{ $index }}][type]" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                            <option value="wedding" {{ $service['type'] == 'wedding' ? 'selected' : '' }}>Wedding</option>
                                            <option value="birthday" {{ $service['type'] == 'birthday' ? 'selected' : '' }}>Birthday</option>
                                            <option value="debut" {{ $service['type'] == 'debut' ? 'selected' : '' }}>Debut</option>
                                            <option value="baptism" {{ $service['type'] == 'baptism' ? 'selected' : '' }}>Baptism</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Description</label>
                                    <textarea name="services[{{ $index }}][description]" rows="3" 
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50 resize-none">{{ $service['description'] }}</textarea>
                                </div>
                                <div class="mt-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Service Image</label>
                                    <div class="flex items-center space-x-4">
                                        @if(isset($service['image_path']))
                                            <img src="{{ asset($service['image_path']) }}" alt="Service image" class="w-40 h-24 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                                        @endif
                                        <input type="file" name="services[{{ $index }}][image]" accept="image/*" 
                                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Features</label>
                                    <div class="features-container space-y-2">
                                        @foreach($service['features'] as $featureIndex => $feature)
                                            <div class="flex items-center space-x-2">
                                                <input type="text" name="services[{{ $index }}][features][]" value="{{ $feature }}" 
                                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                                <button type="button" class="remove-feature text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="add-feature mt-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 text-sm font-medium flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        <span>Add Feature</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between">
                        <button type="button" id="add-service-page" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Add Service</span>
                        </button>
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Update Services Section</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Coming Soon Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mt-10">
            <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Coming Soon Section</h2>
                            <p class="text-sm text-gray-600">Showcase upcoming services for your clients</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="services-coming-soon-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['services_coming_soon']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="services_coming_soon">
                            {{ $content['services_coming_soon']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form id="services-coming-soon-form" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Section Title</label>
                            <input type="text" name="coming_soon_title" value="{{ $content['services_coming_soon']->title ?? 'More Services Coming Soon' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Section Subtitle</label>
                            <input type="text" name="coming_soon_subtitle" value="{{ $content['services_coming_soon']->subtitle ?? 'We\'re constantly expanding our service offerings to better serve your event planning needs.' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Update Coming Soon Section</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Why Choose Us Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mt-10">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Why Choose Us Section</h2>
                            <p class="text-sm text-gray-600">Highlight your unique value proposition</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="services-why-choose-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['services_why_choose']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="services_why_choose">
                            {{ $content['services_why_choose']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form id="services-why-choose-form" class="space-y-8">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Section Title</label>
                        <input type="text" name="why_choose_title" value="{{ $content['services_why_choose']->title ?? 'Why Choose CrwdCtrl?' }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Update Why Choose Us Section</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced CTA Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mt-10">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Call to Action Section</h2>
                            <p class="text-sm text-gray-600">Encourage users to take the next step</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="services-cta-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['services_cta']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="services_cta">
                            {{ $content['services_cta']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form id="services-cta-form" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">CTA Title</label>
                            <input type="text" name="cta_title" value="{{ $content['services_cta']->title ?? 'Ready to Start Planning?' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">CTA Subtitle</label>
                            <input type="text" name="cta_subtitle" value="{{ $content['services_cta']->subtitle ?? 'Let\'s create something extraordinary together' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Primary Button Text</label>
                            <input type="text" name="cta_primary_button_text" value="{{ $content['services_cta']->button_text ?? 'Book Your Event' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Primary Button Link</label>
                            <input type="text" name="cta_primary_button_link" value="{{ $content['services_cta']->button_link ?? '/book-now' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Secondary Button Text</label>
                            <input type="text" name="cta_secondary_button_text" value="{{ $content['services_cta']->service_cards['secondary_button_text'] ?? 'Contact Us' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Secondary Button Link</label>
                            <input type="text" name="cta_secondary_button_link" value="{{ $content['services_cta']->service_cards['secondary_button_link'] ?? '/#contact' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Update CTA Section</span>
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

        // Services Hero Form
        document.getElementById('services-hero-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("admin.cms.services-page.hero.update") }}', {
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

        // Services Page Services Form
        document.getElementById('services-page-services-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("admin.cms.services-page.services.update") }}', {
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
                showMessage('An error occurred while updating the services section.', 'error');
            });
        });

        // Coming Soon Form
        document.getElementById('services-coming-soon-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("admin.cms.services-page.coming-soon.update") }}', {
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
                showMessage('An error occurred while updating the coming soon section.', 'error');
            });
        });

        // Why Choose Us Form
        document.getElementById('services-why-choose-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("admin.cms.services-page.why-choose.update") }}', {
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
                showMessage('An error occurred while updating the why choose us section.', 'error');
            });
        });

        // CTA Form
        document.getElementById('services-cta-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("admin.cms.services-page.cta.update") }}', {
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
                showMessage('An error occurred while updating the CTA section.', 'error');
            });
        });

        // Add Service Page Card
        document.getElementById('add-service-page').addEventListener('click', function() {
            const container = document.getElementById('services-page-container');
            const index = container.children.length;
            
            const serviceCard = document.createElement('div');
            serviceCard.className = 'service-page-card bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-200';
            serviceCard.dataset.index = index;
            
            serviceCard.innerHTML = `
                <div class="flex justify-between items-start mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">${index + 1}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Service ${index + 1}</h3>
                    </div>
                    <button type="button" class="remove-service-page text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Service Title</label>
                        <input type="text" name="services[${index}][title]" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Service Type</label>
                        <select name="services[${index}][type]" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                            <option value="wedding">Wedding</option>
                            <option value="birthday">Birthday</option>
                            <option value="debut">Debut</option>
                            <option value="baptism">Baptism</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Description</label>
                    <textarea name="services[${index}][description]" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50 resize-none"></textarea>
                </div>
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Service Image</label>
                    <div class="flex items-center space-x-4">
                        <input type="file" name="services[${index}][image]" accept="image/*" 
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                    </div>
                </div>
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Features</label>
                    <div class="features-container space-y-2">
                        <div class="flex items-center space-x-2">
                            <input type="text" name="services[${index}][features][]" 
                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                            <button type="button" class="remove-feature text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="add-feature mt-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 text-sm font-medium flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Add Feature</span>
                    </button>
                </div>
            `;
            
            container.appendChild(serviceCard);
            
            // Add remove functionality to new card
            serviceCard.querySelector('.remove-service-page').addEventListener('click', function() {
                serviceCard.remove();
                updateServicePageIndices();
            });

            // Add feature functionality
            serviceCard.querySelector('.add-feature').addEventListener('click', function() {
                addFeature(serviceCard.querySelector('.features-container'));
            });

            // Add remove feature functionality
            serviceCard.querySelectorAll('.remove-feature').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.flex').remove();
                });
            });
        });

        // Remove Service Page Card
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-service-page')) {
                const serviceCard = e.target.closest('.service-page-card');
                serviceCard.remove();
                updateServicePageIndices();
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
                <input type="text" name="services[${container.closest('.service-page-card').dataset.index}][features][]" 
                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white hover:bg-gray-50">
                <button type="button" class="remove-feature text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(featureDiv);
        }

        function updateServicePageIndices() {
            document.querySelectorAll('.service-page-card').forEach((card, idx) => {
                card.dataset.index = idx;
                card.querySelector('h3').textContent = `Service ${idx + 1}`;
                card.querySelectorAll('input, select, textarea').forEach(input => {
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