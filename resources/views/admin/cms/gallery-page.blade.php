<x-admin-layout title="Gallery Page CMS" active-page="gallery-cms">
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Gallery Page Content Management</h1>
            <div class="flex space-x-3">
                <a href="{{ route('gallery') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    View Gallery Page
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <div id="message-container" class="fixed top-4 right-4 z-50 hidden">
            <div id="success-message" class="hidden bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium"></span>
                </div>
            </div>
            <div id="error-message" class="hidden bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="font-medium"></span>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Hero Section</h2>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">Status:</span>
                    <button id="gallery-hero-toggle" 
                            class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ $content['gallery_hero']->is_active ?? false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                            data-section="gallery_hero">
                        {{ $content['gallery_hero']->is_active ?? false ? 'Active' : 'Inactive' }}
                    </button>
                </div>
            </div>

            <form id="gallery-hero-form" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hero Title</label>
                        <input type="text" name="hero_title" value="{{ $content['gallery_hero']->title ?? 'Our Event Gallery' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hero Subtitle</label>
                        <input type="text" name="hero_subtitle" value="{{ $content['gallery_hero']->subtitle ?? 'Explore our collection of beautiful events and celebrations we\'ve helped create' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                        Update Hero Section
                    </button>
                </div>
            </form>
        </div>

        <!-- Gallery Images Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Gallery Images</h2>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">Status:</span>
                    <button id="gallery-images-toggle" 
                            class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ $content['gallery_images']->is_active ?? false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                            data-section="gallery_images">
                        {{ $content['gallery_images']->is_active ?? false ? 'Active' : 'Inactive' }}
                    </button>
                </div>
            </div>

            <form id="gallery-images-form" class="space-y-6">
                @csrf
                <div id="gallery-images-container">
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
                        <div class="gallery-image-card border border-gray-200 rounded-lg p-4" data-index="{{ $index }}">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Image {{ $index + 1 }}</h3>
                                <button type="button" class="remove-gallery-image text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Image Title</label>
                                    <input type="text" name="images[{{ $index }}][title]" value="{{ $image['title'] }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                    <select name="images[{{ $index }}][category]" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="wedding" {{ $image['category'] === 'wedding' ? 'selected' : '' }}>Wedding</option>
                                        <option value="birthday" {{ $image['category'] === 'birthday' ? 'selected' : '' }}>Birthday</option>
                                        <option value="debut" {{ $image['category'] === 'debut' ? 'selected' : '' }}>Debut</option>
                                        <option value="baptism" {{ $image['category'] === 'baptism' ? 'selected' : '' }}>Baptism</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <input type="text" name="images[{{ $index }}][description]" value="{{ $image['description'] }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alt Text</label>
                                <input type="text" name="images[{{ $index }}][alt_text]" value="{{ $image['alt_text'] }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                                <div class="flex items-center space-x-4">
                                    @if(isset($image['image_path']))
                                        <img src="{{ asset($image['image_path']) }}" 
                                             alt="{{ $image['alt_text'] }}" 
                                             class="w-20 h-20 object-cover rounded-lg border">
                                    @endif
                                    <input type="file" name="images[{{ $index }}][image]" accept="image/*" 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between">
                    <button type="button" id="add-gallery-image" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                        Add Image
                    </button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                        Update Gallery Images
                    </button>
                </div>
            </form>
        </div>

        <!-- CTA Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Call to Action Section</h2>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">Status:</span>
                    <button id="gallery-cta-toggle" 
                            class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ $content['gallery_cta']->is_active ?? false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                            data-section="gallery_cta">
                        {{ $content['gallery_cta']->is_active ?? false ? 'Active' : 'Inactive' }}
                    </button>
                </div>
            </div>

            <form id="gallery-cta-form" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">CTA Title</label>
                        <input type="text" name="cta_title" value="{{ $content['gallery_cta']->title ?? 'Inspired by Our Work?' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">CTA Subtitle</label>
                        <input type="text" name="cta_subtitle" value="{{ $content['gallery_cta']->subtitle ?? 'Let\'s create your own beautiful memories together' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Primary Button Text</label>
                        <input type="text" name="cta_primary_button_text" value="{{ $content['gallery_cta']->button_text ?? 'Start Planning Your Event' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Primary Button Link</label>
                        <input type="text" name="cta_primary_button_link" value="{{ $content['gallery_cta']->button_link ?? route('book-now') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Button Text</label>
                        <input type="text" name="cta_secondary_button_text" value="{{ $content['gallery_cta'] && $content['gallery_cta']->service_cards && isset($content['gallery_cta']->service_cards['secondary_button_text']) ? $content['gallery_cta']->service_cards['secondary_button_text'] : 'Contact Us' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Button Link</label>
                        <input type="text" name="cta_secondary_button_link" value="{{ $content['gallery_cta'] && $content['gallery_cta']->service_cards && isset($content['gallery_cta']->service_cards['secondary_button_link']) ? $content['gallery_cta']->service_cards['secondary_button_link'] : route('home') . '#contact' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                        Update CTA Section
                    </button>
                </div>
            </form>
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
            newImageCard.className = 'gallery-image-card border border-gray-200 rounded-lg p-4';
            newImageCard.setAttribute('data-index', index);
            
            newImageCard.innerHTML = `
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Image ${index + 1}</h3>
                    <button type="button" class="remove-gallery-image text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Image Title</label>
                        <input type="text" name="images[${index}][title]" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="images[${index}][category]" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="wedding">Wedding</option>
                            <option value="birthday">Birthday</option>
                            <option value="debut">Debut</option>
                            <option value="baptism">Baptism</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <input type="text" name="images[${index}][description]" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alt Text</label>
                    <input type="text" name="images[${index}][alt_text]" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                    <input type="file" name="images[${index}][image]" accept="image/*" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
                        button.className = 'toggle-btn px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800';
                    } else {
                        button.textContent = 'Inactive';
                        button.className = 'toggle-btn px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800';
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