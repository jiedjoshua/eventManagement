<x-admin-layout title="Home Page CMS" active-page="cms">
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Home Page Content Management</h1>
            <div class="flex space-x-3">
                <a href="{{ route('home') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    View Home Page
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
                    <button id="hero-toggle" 
                            class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ $content['hero']->is_active ?? false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                            data-section="hero">
                        {{ $content['hero']->is_active ?? false ? 'Active' : 'Inactive' }}
                    </button>
                </div>
            </div>

            <form id="hero-form" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hero Title</label>
                        <input type="text" name="title" value="{{ $content['hero']->title ?? 'Celebrate Life\'s Special Moments' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                        <input type="text" name="button_text" value="{{ $content['hero']->button_text ?? 'Book Now' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hero Subtitle</label>
                    <textarea name="subtitle" rows="2" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $content['hero']->subtitle ?? 'We make your dream events come true — weddings, birthdays, and more!' }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hero Background Image</label>
                    <div class="flex items-center space-x-4">
                        @if($content['hero']->image_path ?? false)
                            <img src="{{ asset($content['hero']->image_path) }}" alt="Current hero image" class="w-32 h-20 object-cover rounded">
                        @endif
                        <input type="file" name="hero_image" accept="image/*" 
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Recommended size: 1920x1080px, Max size: 2MB</p>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                        Update Hero Section
                    </button>
                </div>
            </form>
        </div>

        <!-- Services Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Services Section</h2>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">Status:</span>
                    <button id="services-toggle" 
                            class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ $content['services']->is_active ?? false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                            data-section="services">
                        {{ $content['services']->is_active ?? false ? 'Active' : 'Inactive' }}
                    </button>
                </div>
            </div>

            <form id="services-form" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                    <input type="text" name="section_title" value="{{ $content['services']->title ?? 'Our Event Services' }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div id="services-container">
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
                        <div class="service-card border border-gray-200 rounded-lg p-4" data-index="{{ $index }}">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Service {{ $index + 1 }}</h3>
                                @if($index > 0)
                                    <button type="button" class="remove-service text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Service Title</label>
                                    <input type="text" name="services[{{ $index }}][title]" value="{{ $service['title'] }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Service Type</label>
                                    <select name="services[{{ $index }}][type]" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="wedding" {{ $service['type'] == 'wedding' ? 'selected' : '' }}>Wedding</option>
                                        <option value="birthday" {{ $service['type'] == 'birthday' ? 'selected' : '' }}>Birthday</option>
                                        <option value="debut" {{ $service['type'] == 'debut' ? 'selected' : '' }}>Debut</option>
                                        <option value="baptism" {{ $service['type'] == 'baptism' ? 'selected' : '' }}>Baptism</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea name="services[{{ $index }}][description]" rows="2" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $service['description'] }}</textarea>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Service Image</label>
                                <div class="flex items-center space-x-4">
                                    @if(isset($service['image_path']))
                                        <img src="{{ asset($service['image_path']) }}" alt="Service image" class="w-32 h-20 object-cover rounded">
                                    @elseif(isset($service['image']))
                                        <img src="{{ asset('img/' . $service['image']) }}" alt="Service image" class="w-32 h-20 object-cover rounded">
                                    @endif
                                    <input type="file" name="services[{{ $index }}][image]" accept="image/*" 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between">
                    <button type="button" id="add-service" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                        Add Service
                    </button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                        Update Services Section
                    </button>
                </div>
            </form>
        </div>

        <!-- About Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">About Section</h2>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">Status:</span>
                    <button id="about-toggle" 
                            class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ $content['about']->is_active ?? false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                            data-section="about">
                        {{ $content['about']->is_active ?? false ? 'Active' : 'Inactive' }}
                    </button>
                </div>
            </div>

            <form id="about-form" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                    <input type="text" name="section_title" value="{{ $content['about']->title ?? 'Who We Are' }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $content['about']->description ?? 'We\'re passionate about delivering the best service to our customers with honesty and integrity.' }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                        Update About Section
                    </button>
                </div>
            </form>
        </div>

        <!-- Contact Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Contact Section</h2>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">Status:</span>
                    <button id="contact-toggle" 
                            class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ $content['contact']->is_active ?? false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                            data-section="contact">
                        {{ $content['contact']->is_active ?? false ? 'Active' : 'Inactive' }}
                    </button>
                </div>
            </div>

            <form id="contact-form" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                    <input type="text" name="section_title" value="{{ $content['contact']->title ?? 'Get in Touch' }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="contact_phone" value="{{ $content['contact']->contact_phone ?? '+63 912 345 6789' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="contact_email" value="{{ $content['contact']->contact_email ?? 'hello@crwdctrl.space' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input type="text" name="contact_address" value="{{ $content['contact']->contact_address ?? 'Bataan, Philippines' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                        Update Contact Section
                    </button>
                </div>
            </form>
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
                    showMessage('An error occurred while toggling section visibility.', 'error');
                });
            });
        });

        // Add Service Card
        document.getElementById('add-service').addEventListener('click', function() {
            const container = document.getElementById('services-container');
            const index = container.children.length;
            
            const serviceCard = document.createElement('div');
            serviceCard.className = 'service-card border border-gray-200 rounded-lg p-4';
            serviceCard.dataset.index = index;
            
            serviceCard.innerHTML = `
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Service ${index + 1}</h3>
                    <button type="button" class="remove-service text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Service Title</label>
                        <input type="text" name="services[${index}][title]" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Service Type</label>
                        <select name="services[${index}][type]" 
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
                    <textarea name="services[${index}][description]" rows="2" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Service Image</label>
                    <input type="file" name="services[${index}][image]" accept="image/*" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
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