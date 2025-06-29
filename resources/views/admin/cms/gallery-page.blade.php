<x-admin-layout title="Gallery Page CMS" active-page="gallery-cms">
    <div class="space-y-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Gallery Page Content Management</h1>
                    <p class="text-purple-100">Manage your gallery page content, images, and call-to-action sections</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('gallery') }}" target="_blank" 
                       class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 backdrop-blur-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        <span>View Gallery Page</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <div id="message-container" class="fixed top-4 right-4 z-50 hidden">
            <div id="success-message" class="hidden bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-xl shadow-xl transform transition-all duration-300 ease-in-out border border-green-400">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium"></span>
                </div>
            </div>
            <div id="error-message" class="hidden bg-gradient-to-r from-red-500 to-pink-500 text-white px-6 py-4 rounded-xl shadow-xl transform transition-all duration-300 ease-in-out border border-red-400">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="font-medium"></span>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
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
                            <p class="text-sm text-gray-600">Configure the main gallery page header</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="gallery-hero-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['gallery_hero']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="gallery_hero">
                            {{ $content['gallery_hero']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form id="gallery-hero-form" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Title</label>
                            <input type="text" name="hero_title" value="{{ $content['gallery_hero']->title ?? 'Our Event Gallery' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Subtitle</label>
                            <input type="text" name="hero_subtitle" value="{{ $content['gallery_hero']->subtitle ?? 'Explore our collection of beautiful events and celebrations we\'ve helped create' }}" 
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

        <!-- Gallery Images Section -->
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
                            <h2 class="text-xl font-semibold text-gray-900">Gallery Images</h2>
                            <p class="text-sm text-gray-600">Manage your gallery images and categories</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="gallery-images-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['gallery_images']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="gallery_images">
                            {{ $content['gallery_images']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form id="gallery-images-form" class="space-y-6">
                    @csrf
                    <div id="gallery-images-container" class="space-y-6">
                        @php
                            $defaultGalleryImages = [
                                [
                                    'title' => 'Elegant Wedding',
                                    'description' => 'Beautiful outdoor ceremony',
                                    'category' => 'wedding',
                                    'alt_text' => 'Wedding Celebration',
                                    'image_path' => '/public/img/wedding.webp'
                                ],
                                [
                                    'title' => 'Wedding Reception',
                                    'description' => 'Magical evening celebration',
                                    'category' => 'wedding',
                                    'alt_text' => 'Wedding Reception',
                                    'image_path' => '/public/img/wedding.png'
                                ],
                                [
                                    'title' => 'Birthday Celebration',
                                    'description' => 'Fun and colorful party',
                                    'category' => 'birthday',
                                    'alt_text' => 'Birthday Party',
                                    'image_path' => '/public/img/birthday.jpg'
                                ],
                                [
                                    'title' => '18th Debut',
                                    'description' => 'Elegant coming-of-age celebration',
                                    'category' => 'debut',
                                    'alt_text' => 'Debut Celebration',
                                    'image_path' => '/public/img/debut.webp'
                                ],
                                [
                                    'title' => 'Baptism Ceremony',
                                    'description' => 'Sacred family celebration',
                                    'category' => 'baptism',
                                    'alt_text' => 'Baptism Ceremony',
                                    'image_path' => '/public/img/baptism.jpg'
                                ],
                                [
                                    'title' => 'Wedding Transportation',
                                    'description' => 'Luxury wedding car service',
                                    'category' => 'wedding',
                                    'alt_text' => 'Wedding Transportation',
                                    'image_path' => '/public/img/car1.jpg'
                                ]
                            ];
                            $galleryImages = $content['gallery_images']->service_cards ?? $defaultGalleryImages;
                        @endphp

                        @foreach($galleryImages as $index => $image)
                            <div class="gallery-image-card bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-200" data-index="{{ $index }}">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">{{ $index + 1 }}</span>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900">Image {{ $index + 1 }}</h3>
                                    </div>
                                    <button type="button" class="remove-gallery-image text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Image Title</label>
                                        <input type="text" name="images[{{ $index }}][title]" value="{{ $image['title'] }}" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Category</label>
                                        <select name="images[{{ $index }}][category]" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                            <option value="wedding" {{ $image['category'] === 'wedding' ? 'selected' : '' }}>Wedding</option>
                                            <option value="birthday" {{ $image['category'] === 'birthday' ? 'selected' : '' }}>Birthday</option>
                                            <option value="debut" {{ $image['category'] === 'debut' ? 'selected' : '' }}>Debut</option>
                                            <option value="baptism" {{ $image['category'] === 'baptism' ? 'selected' : '' }}>Baptism</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Description</label>
                                    <input type="text" name="images[{{ $index }}][description]" value="{{ $image['description'] }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                </div>
                                
                                <div class="mt-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Alt Text</label>
                                    <input type="text" name="images[{{ $index }}][alt_text]" value="{{ $image['alt_text'] }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                </div>
                                
                                <div class="mt-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Image</label>
                                    <div class="flex items-center space-x-4">
                                        @if(isset($image['image_path']))
                                            <img src="/public{{ str_replace('/public', '', $image['image_path']) }}" 
                                                 alt="{{ $image['alt_text'] }}" 
                                                 class="w-24 h-24 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                                        @else
                                            <div class="w-24 h-24 bg-gray-200 flex items-center justify-center rounded-lg border-2 border-gray-200">
                                                <span class="text-gray-500 text-xs">No Image</span>
                                            </div>
                                        @endif
                                        <input type="file" name="images[{{ $index }}][image]" accept="image/*" 
                                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Leave empty to keep current image</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                        <button type="button" id="add-gallery-image" 
                                class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Add Image</span>
                        </button>
                        <button type="submit" 
                                class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Update Gallery Images</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Call to Action Section</h2>
                            <p class="text-sm text-gray-600">Configure the call-to-action area</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">Status:</span>
                        <button id="gallery-cta-toggle" 
                                class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $content['gallery_cta']->is_active ?? false ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                data-section="gallery_cta">
                            {{ $content['gallery_cta']->is_active ?? false ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form id="gallery-cta-form" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">CTA Title</label>
                            <input type="text" name="cta_title" value="{{ $content['gallery_cta']->title ?? 'Inspired by Our Work?' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">CTA Subtitle</label>
                            <input type="text" name="cta_subtitle" value="{{ $content['gallery_cta']->subtitle ?? 'Let\'s create your own beautiful memories together' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Primary Button Text</label>
                            <input type="text" name="cta_primary_button_text" value="{{ $content['gallery_cta']->button_text ?? 'Start Planning Your Event' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Primary Button Link</label>
                            <input type="text" name="cta_primary_button_link" value="{{ $content['gallery_cta']->button_link ?? route('book-now') }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Secondary Button Text</label>
                            <input type="text" name="cta_secondary_button_text" value="{{ $content['gallery_cta'] && $content['gallery_cta']->service_cards && isset($content['gallery_cta']->service_cards['secondary_button_text']) ? $content['gallery_cta']->service_cards['secondary_button_text'] : 'Contact Us' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Secondary Button Link</label>
                            <input type="text" name="cta_secondary_button_link" value="{{ $content['gallery_cta'] && $content['gallery_cta']->service_cards && isset($content['gallery_cta']->service_cards['secondary_button_link']) ? $content['gallery_cta']->service_cards['secondary_button_link'] : route('home') . '#contact' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
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

    <script>
        // Form submission handlers
        document.getElementById('gallery-hero-form').addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm(this, '{{ route("admin.cms.gallery-page.hero.update") }}', 'Hero section updated successfully!');
        });

        document.getElementById('gallery-images-form').addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm(this, '{{ route("admin.cms.gallery-page.images.update") }}', 'Gallery images updated successfully!');
        });

        document.getElementById('gallery-cta-form').addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm(this, '{{ route("admin.cms.gallery-page.cta.update") }}', 'CTA section updated successfully!');
        });

        // Add gallery image functionality
        document.getElementById('add-gallery-image').addEventListener('click', function() {
            const container = document.getElementById('gallery-images-container');
            const index = container.children.length;
            
            const newImageCard = document.createElement('div');
            newImageCard.className = 'gallery-image-card bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-200';
            newImageCard.setAttribute('data-index', index);
            
            newImageCard.innerHTML = `
                <div class="flex justify-between items-start mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">${index + 1}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Image ${index + 1}</h3>
                    </div>
                    <button type="button" class="remove-gallery-image text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Image Title</label>
                        <input type="text" name="images[${index}][title]" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Category</label>
                        <select name="images[${index}][category]" required
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
                    <input type="text" name="images[${index}][description]" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Alt Text</label>
                    <input type="text" name="images[${index}][alt_text]" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Image</label>
                    <div class="flex items-center space-x-4">
                        <div class="w-24 h-24 bg-gray-200 flex items-center justify-center rounded-lg border-2 border-gray-200">
                            <span class="text-gray-500 text-xs">No Image</span>
                        </div>
                        <input type="file" name="images[${index}][image]" accept="image/*" required
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                    </div>
                </div>
            `;
            
            container.appendChild(newImageCard);
        });

        // Remove gallery image functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-gallery-image')) {
                const card = e.target.closest('.gallery-image-card');
                card.remove();
                
                // Reindex remaining cards
                const cards = document.querySelectorAll('.gallery-image-card');
                cards.forEach((card, index) => {
                    card.setAttribute('data-index', index);
                    card.querySelector('h3').textContent = `Image ${index + 1}`;
                    card.querySelector('.w-8.h-8 span').textContent = index + 1;
                    
                    // Update input names
                    const inputs = card.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        const name = input.getAttribute('name');
                        if (name) {
                            input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                        }
                    });
                });
            }
        });

        // Toggle functionality
        document.querySelectorAll('.toggle-btn').forEach(button => {
            button.addEventListener('click', function() {
                const section = this.getAttribute('data-section');
                toggleSection(section, this);
            });
        });

        // Form submission function
        function submitForm(form, url, successMessage) {
            const formData = new FormData(form);
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', successMessage);
                } else {
                    showMessage('error', data.message || 'An error occurred');
                }
            })
            .catch(error => {
                showMessage('error', 'An error occurred while updating');
            });
        }

        // Toggle section function
        function toggleSection(section, button) {
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
                    if (data.is_active) {
                        button.textContent = 'Active';
                        button.className = 'toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg';
                    } else {
                        button.textContent = 'Inactive';
                        button.className = 'toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg';
                    }
                    showMessage('success', data.message);
                } else {
                    showMessage('error', data.message);
                }
            })
            .catch(error => {
                showMessage('error', 'An error occurred while toggling section');
            });
        }

        // Show message function
        function showMessage(type, message) {
            const container = document.getElementById('message-container');
            const successMsg = document.getElementById('success-message');
            const errorMsg = document.getElementById('error-message');
            
            container.classList.remove('hidden');
            
            if (type === 'success') {
                successMsg.classList.remove('hidden');
                errorMsg.classList.add('hidden');
                successMsg.querySelector('span').textContent = message;
            } else {
                errorMsg.classList.remove('hidden');
                successMsg.classList.add('hidden');
                errorMsg.querySelector('span').textContent = message;
            }
            
            setTimeout(() => {
                container.classList.add('hidden');
            }, 3000);
        }
    </script>
</x-admin-layout> 