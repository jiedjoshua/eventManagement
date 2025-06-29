<x-admin-layout title="Home Page CMS" active-page="cms">
    <div class="p-6">
        <!-- Modernized Header -->
        <div class="mb-6 flex justify-between items-center bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-6">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Home Page Content Management</h1>
                <p class="text-purple-100">Manage and customize your home page content</p>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                <span>View Home Page</span>
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

        <div class="space-y-6">
            <!-- Enhanced Hero Section -->
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
                                <p class="text-sm text-gray-600">Main banner and call-to-action area</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 font-medium">Status:</span>
                            <button id="hero-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['hero']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="hero">
                                {{ $content['hero']->is_active ?? false ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <form id="hero-form" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Title</label>
                                <input type="text" name="title" value="{{ $content['hero']->title ?? 'Celebrate Life\'s Special Moments' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Button Text</label>
                                <input type="text" name="button_text" value="{{ $content['hero']->button_text ?? 'Book Now' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Subtitle</label>
                            <textarea name="subtitle" rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white resize-none">{{ $content['hero']->subtitle ?? 'We make your dream events come true — weddings, birthdays, and more!' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Background Image</label>
                            <div class="flex items-center space-x-4">
                                @if($content['hero']->image_path ?? false)
                                    <img src="{{ asset($content['hero']->image_path) }}" alt="Current hero image" class="w-40 h-24 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                                @endif
                                <input type="file" name="hero_image" accept="image/*" 
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                            <p class="text-sm text-gray-500 mt-2">Recommended size: 1920x1080px, Max size: 2MB</p>
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

            <!-- Enhanced Services Section -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">Services Section</h2>
                                <p class="text-sm text-gray-600">Featured services displayed on home page</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 font-medium">Status:</span>
                            <button id="services-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['services']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="services">
                                {{ $content['services']->is_active ?? false ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <form id="services-form" class="space-y-8">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Section Title</label>
                            <input type="text" name="section_title" value="{{ $content['services']->title ?? 'Our Event Services' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>

                        <div id="services-container" class="space-y-6">
                            @php
                                $defaultServices = [
                                    ['title' => 'Weddings', 'description' => 'Beautiful and memorable wedding event planning tailored to your dreams.', 'type' => 'wedding', 'image' => 'wedding.webp'],
                                    ['title' => 'Birthdays', 'description' => 'Fun and exciting birthday celebrations customized for all ages.', 'type' => 'birthday', 'image' => 'birthday.jpg'],
                                    ['title' => 'Debuts', 'description' => 'Elegant debut parties that mark this special milestone with style.', 'type' => 'debut', 'image' => 'debut.webp'],
                                    ['title' => 'Baptisms', 'description' => 'Graceful baptism events that celebrate faith and family.', 'type' => 'baptism', 'image' => 'baptism.jpg']
                                ];
                                $services = $content['services']->service_cards ?? $defaultServices;
                            @endphp

                            @foreach($services as $index => $service)
                                <div class="service-card bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-200" data-index="{{ $index }}">
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">{{ $index + 1 }}</span>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900">Service {{ $index + 1 }}</h3>
                                        </div>
                                        @if($index > 0)
                                            <button type="button" class="remove-service text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
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
                                            @elseif(isset($service['image']))
                                                <img src="{{ asset('img/' . $service['image']) }}" alt="Service image" class="w-40 h-24 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                                            @endif
                                            <input type="file" name="services[{{ $index }}][image]" accept="image/*" 
                                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between">
                            <button type="button" id="add-service" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
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

            <!-- Enhanced About Section -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3s3-1.343 3-3c0-1.657-1.343-3-3-3zm0 0V4m0 7v7"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">About Section</h2>
                                <p class="text-sm text-gray-600">Company information and description</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 font-medium">Status:</span>
                            <button id="about-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['about']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="about">
                                {{ $content['about']->is_active ?? false ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <form id="about-form" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Section Title</label>
                            <input type="text" name="section_title" value="{{ $content['about']->title ?? 'Who We Are' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Description</label>
                            <textarea name="description" rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white resize-none">{{ $content['about']->description ?? 'We\'re passionate about delivering the best service to our customers with honesty and integrity.' }}</textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Update About Section</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Enhanced Contact Section -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">Contact Section</h2>
                                <p class="text-sm text-gray-600">Contact information and details</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 font-medium">Status:</span>
                            <button id="contact-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['contact']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="contact">
                                {{ $content['contact']->is_active ?? false ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <form id="contact-form" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Section Title</label>
                            <input type="text" name="section_title" value="{{ $content['contact']->title ?? 'Get in Touch' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Phone Number</label>
                                <input type="text" name="contact_phone" value="{{ $content['contact']->contact_phone ?? '+63 912 345 6789' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Email Address</label>
                                <input type="email" name="contact_email" value="{{ $content['contact']->contact_email ?? 'hello@crwdctrl.space' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Address</label>
                                <input type="text" name="contact_address" value="{{ $content['contact']->contact_address ?? 'Bataan, Philippines' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Update Contact Section</span>
                            </button>
                        </div>
                    </form>
                </div>
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

        // Hero Section Form
        document.getElementById('hero-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("admin.cms.hero.update") }}', {
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

        // Services Section Form
        document.getElementById('services-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("admin.cms.services.update") }}', {
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

        // About Section Form
        document.getElementById('about-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("admin.cms.about.update") }}', {
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
                showMessage('An error occurred while updating the about section.', 'error');
            });
        });

        // Contact Section Form
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("admin.cms.contact.update") }}', {
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
                showMessage('An error occurred while updating the contact section.', 'error');
            });
        });

        // Toggle Section Visibility
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
                            this.classList.remove('bg-gradient-to-r', 'from-red-500', 'to-pink-500');
                            this.classList.add('bg-gradient-to-r', 'from-green-500', 'to-emerald-500');
                            this.textContent = 'Active';
                        } else {
                            this.classList.remove('bg-gradient-to-r', 'from-green-500', 'to-emerald-500');
                            this.classList.add('bg-gradient-to-r', 'from-red-500', 'to-pink-500');
                            this.textContent = 'Inactive';
                        }
                    } else {
                        showMessage(data.message, 'error');
                    }
                })
                .catch(error => {
                    showMessage('An error occurred while toggling section visibility.', 'error');
                });
            });
        });

        // Add Service Card
        document.getElementById('add-service').addEventListener('click', function() {
            const container = document.getElementById('services-container');
            const index = container.children.length;
            
            const serviceCard = document.createElement('div');
            serviceCard.className = 'service-card bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-200';
            serviceCard.dataset.index = index;
            
            serviceCard.innerHTML = `
                <div class="flex justify-between items-start mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">${index + 1}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Service ${index + 1}</h3>
                    </div>
                    <button type="button" class="remove-service text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
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
                    <input type="file" name="services[${index}][image]" accept="image/*" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                </div>
            `;
            
            container.appendChild(serviceCard);
            
            // Add remove functionality to new card
            serviceCard.querySelector('.remove-service').addEventListener('click', function() {
                serviceCard.remove();
                // Update indices
                document.querySelectorAll('.service-card').forEach((card, idx) => {
                    card.dataset.index = idx;
                    card.querySelector('h3').textContent = `Service ${idx + 1}`;
                    card.querySelector('.w-8.h-8 span').textContent = idx + 1;
                    card.querySelectorAll('input, select, textarea').forEach(input => {
                        const name = input.name;
                        if (name) {
                            input.name = name.replace(/\[\d+\]/, `[${idx}]`);
                        }
                    });
                });
            });
        });

        // Remove Service Card
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-service')) {
                const serviceCard = e.target.closest('.service-card');
                serviceCard.remove();
                
                // Update indices
                document.querySelectorAll('.service-card').forEach((card, idx) => {
                    card.dataset.index = idx;
                    card.querySelector('h3').textContent = `Service ${idx + 1}`;
                    card.querySelector('.w-8.h-8 span').textContent = idx + 1;
                    card.querySelectorAll('input, select, textarea').forEach(input => {
                        const name = input.name;
                        if (name) {
                            input.name = name.replace(/\[\d+\]/, `[${idx}]`);
                        }
                    });
                });
            }
        });
    </script>
    @endpush
</x-admin-layout> 