<x-admin-layout>
    <div class="p-6">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">About Page CMS</h1>
                <p class="text-gray-600">Manage the content for the About page</p>
            </div>
            <a href="{{ route('about') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                View About Page
            </a>
        </div>

        <div class="space-y-6">
            <!-- Hero Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Hero Section</h2>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500">Status:</span>
                        <button id="about-hero-toggle" 
                                class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ isset($content['about_hero']) && $content['about_hero']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                data-section="about_hero">
                            {{ isset($content['about_hero']) && $content['about_hero']->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>

                <form id="about-hero-form" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hero Title</label>
                            <input type="text" name="hero_title" value="{{ isset($content['about_hero']) ? $content['about_hero']->title : 'About CrwdCtrl' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hero Subtitle</label>
                            <input type="text" name="hero_subtitle" value="{{ isset($content['about_hero']) ? $content['about_hero']->subtitle : 'Creating unforgettable moments, one event at a time' }}" 
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

            <!-- Our Story Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Our Story Section</h2>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500">Status:</span>
                        <button id="about-story-toggle" 
                                class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ isset($content['about_story']) && $content['about_story']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                data-section="about_story">
                            {{ isset($content['about_story']) && $content['about_story']->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>

                <form id="about-story-form" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Story Title</label>
                        <input type="text" name="story_title" value="{{ isset($content['about_story']) ? $content['about_story']->title : 'Our Story' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Story Content</label>
                        <textarea name="story_content" rows="6" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ isset($content['about_story']) ? $content['about_story']->description : 'Founded with a passion for creating extraordinary experiences, CrwdCtrl began as a small team of event enthusiasts who believed that every celebration deserves to be perfect. What started as a dream to make events more memorable has grown into a trusted name in event management across Bataan and beyond.

Over the years, we\'ve had the privilege of being part of countless special moments - from intimate family gatherings to grand celebrations. Each event has taught us something new, and every client has become part of our extended family.

Today, we continue to innovate and push the boundaries of what\'s possible in event planning, always keeping our core values of creativity, reliability, and personal touch at the heart of everything we do.' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Story Image</label>
                        <div class="flex items-center space-x-4">
                            @if(isset($content['about_story']) && isset($content['about_story']->image_path))
                                <img src="/public{{ str_replace('/public', '', $content['about_story']->image_path) }}" 
                                     alt="Our Story" 
                                     class="w-20 h-20 object-cover rounded-lg border">
                            @else
                                <div class="w-20 h-20 bg-gray-200 flex items-center justify-center rounded-lg border">
                                    <span class="text-gray-500 text-xs">No Image</span>
                                </div>
                            @endif
                            <input type="file" name="story_image" accept="image/*" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                            Update Story Section
                        </button>
                    </div>
                </form>
            </div>

            <!-- Mission & Vision Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Mission & Vision Section</h2>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500">Status:</span>
                        <button id="about-mission-vision-toggle" 
                                class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ isset($content['about_mission_vision']) && $content['about_mission_vision']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                data-section="about_mission_vision">
                            {{ isset($content['about_mission_vision']) && $content['about_mission_vision']->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>

                <form id="about-mission-vision-form" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Mission -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Mission</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mission Title</label>
                                    <input type="text" name="mission_title" value="{{ isset($content['about_mission_vision']) && $content['about_mission_vision']->service_cards && isset($content['about_mission_vision']->service_cards['mission_title']) ? $content['about_mission_vision']->service_cards['mission_title'] : 'Our Mission' }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mission Content</label>
                                    <textarea name="mission_content" rows="4" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ isset($content['about_mission_vision']) && $content['about_mission_vision']->service_cards && isset($content['about_mission_vision']->service_cards['mission_content']) ? $content['about_mission_vision']->service_cards['mission_content'] : 'To transform ordinary moments into extraordinary memories by providing innovative, personalized, and seamless event planning services that exceed expectations and create lasting impressions for our clients and their guests.' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Vision -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Vision</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Vision Title</label>
                                    <input type="text" name="vision_title" value="{{ isset($content['about_mission_vision']) && $content['about_mission_vision']->service_cards && isset($content['about_mission_vision']->service_cards['vision_title']) ? $content['about_mission_vision']->service_cards['vision_title'] : 'Our Vision' }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Vision Content</label>
                                    <textarea name="vision_content" rows="4" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ isset($content['about_mission_vision']) && $content['about_mission_vision']->service_cards && isset($content['about_mission_vision']->service_cards['vision_content']) ? $content['about_mission_vision']->service_cards['vision_content'] : 'To be the leading event management company in the region, known for our creativity, reliability, and commitment to excellence. We aspire to set new standards in the industry while building lasting relationships with our clients and partners.' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                            Update Mission & Vision
                        </button>
                    </div>
                </form>
            </div>

            <!-- Core Values Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Core Values Section</h2>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500">Status:</span>
                        <button id="about-values-toggle" 
                                class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ isset($content['about_values']) && $content['about_values']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                data-section="about_values">
                            {{ isset($content['about_values']) && $content['about_values']->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>

                <form id="about-values-form" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Values Section Title</label>
                        <input type="text" name="values_title" value="{{ isset($content['about_values']) ? $content['about_values']->title : 'Our Core Values' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div id="values-container">
                        @php
                            $defaultValues = [
                                ['title' => 'Passion', 'description' => 'We pour our hearts into every event, treating each celebration as if it were our own.'],
                                ['title' => 'Excellence', 'description' => 'We strive for perfection in every detail, ensuring flawless execution of your vision.'],
                                ['title' => 'Trust', 'description' => 'We build lasting relationships based on transparency, honesty, and mutual respect.'],
                                ['title' => 'Innovation', 'description' => 'We embrace new ideas and technologies to create unique and memorable experiences.']
                            ];
                            $values = isset($content['about_values']) && $content['about_values']->service_cards ? $content['about_values']->service_cards : $defaultValues;
                        @endphp
                        
                        @foreach($values as $index => $value)
                            <div class="value-card border border-gray-200 rounded-lg p-4" data-index="{{ $index }}">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Value {{ $index + 1 }}</h3>
                                    <button type="button" class="remove-value text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Value Title</label>
                                        <input type="text" name="values[{{ $index }}][title]" value="{{ $value['title'] }}" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Value Description</label>
                                        <textarea name="values[{{ $index }}][description]" rows="3" 
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $value['description'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between">
                        <button type="button" id="add-value" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                            Add Value
                        </button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                            Update Values
                        </button>
                    </div>
                </form>
            </div>

            <!-- Stats Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Statistics Section</h2>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500">Status:</span>
                        <button id="about-stats-toggle" 
                                class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ isset($content['about_stats']) && $content['about_stats']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                data-section="about_stats">
                            {{ isset($content['about_stats']) && $content['about_stats']->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>

                <form id="about-stats-form" class="space-y-4">
                    @csrf
                    <div id="stats-container">
                        @php
                            $defaultStats = [
                                ['number' => '500+', 'label' => 'Events Successfully Planned'],
                                ['number' => '5+', 'label' => 'Years of Experience'],
                                ['number' => '98%', 'label' => 'Client Satisfaction Rate'],
                                ['number' => '50+', 'label' => 'Venue Partnerships']
                            ];
                            $stats = isset($content['about_stats']) && $content['about_stats']->service_cards ? $content['about_stats']->service_cards : $defaultStats;
                        @endphp
                        
                        @foreach($stats as $index => $stat)
                            <div class="stat-card border border-gray-200 rounded-lg p-4" data-index="{{ $index }}">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Stat {{ $index + 1 }}</h3>
                                    <button type="button" class="remove-stat text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Number</label>
                                        <input type="text" name="stats[{{ $index }}][number]" value="{{ $stat['number'] }}" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
                                        <input type="text" name="stats[{{ $index }}][label]" value="{{ $stat['label'] }}" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between">
                        <button type="button" id="add-stat" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                            Add Statistic
                        </button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                            Update Statistics
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
                        <button id="about-cta-toggle" 
                                class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ isset($content['about_cta']) && $content['about_cta']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                data-section="about_cta">
                            {{ isset($content['about_cta']) && $content['about_cta']->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>

                <form id="about-cta-form" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CTA Title</label>
                            <input type="text" name="cta_title" value="{{ isset($content['about_cta']) ? $content['about_cta']->title : 'Ready to Create Something Amazing?' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CTA Subtitle</label>
                            <input type="text" name="cta_subtitle" value="{{ isset($content['about_cta']) ? $content['about_cta']->subtitle : 'Let\'s work together to make your next event unforgettable' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Primary Button Text</label>
                            <input type="text" name="cta_primary_button_text" value="{{ isset($content['about_cta']) ? $content['about_cta']->button_text : 'Start Planning' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Primary Button Link</label>
                            <input type="text" name="cta_primary_button_link" value="{{ isset($content['about_cta']) ? $content['about_cta']->button_link : route('book-now') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Button Text</label>
                            <input type="text" name="cta_secondary_button_text" value="{{ isset($content['about_cta']) && $content['about_cta']->service_cards && isset($content['about_cta']->service_cards['secondary_button_text']) ? $content['about_cta']->service_cards['secondary_button_text'] : 'Get in Touch' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Button Link</label>
                            <input type="text" name="cta_secondary_button_link" value="{{ isset($content['about_cta']) && $content['about_cta']->service_cards && isset($content['about_cta']->service_cards['secondary_button_link']) ? $content['about_cta']->service_cards['secondary_button_link'] : route('home') . '#contact' }}" 
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
            document.getElementById('about-hero-form').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(this, '{{ route("admin.cms.about-page.hero.update") }}', 'Hero section updated successfully!');
            });

            document.getElementById('about-story-form').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(this, '{{ route("admin.cms.about-page.story.update") }}', 'Story section updated successfully!');
            });

            document.getElementById('about-mission-vision-form').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(this, '{{ route("admin.cms.about-page.mission-vision.update") }}', 'Mission & Vision updated successfully!');
            });

            document.getElementById('about-values-form').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(this, '{{ route("admin.cms.about-page.values.update") }}', 'Values updated successfully!');
            });

            document.getElementById('about-stats-form').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(this, '{{ route("admin.cms.about-page.stats.update") }}', 'Statistics updated successfully!');
            });

            document.getElementById('about-cta-form').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(this, '{{ route("admin.cms.about-page.cta.update") }}', 'CTA section updated successfully!');
            });

            // Add value functionality
            document.getElementById('add-value').addEventListener('click', function() {
                const container = document.getElementById('values-container');
                const index = container.children.length;
                
                const newValueCard = document.createElement('div');
                newValueCard.className = 'value-card border border-gray-200 rounded-lg p-4';
                newValueCard.setAttribute('data-index', index);
                
                newValueCard.innerHTML = `
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Value ${index + 1}</h3>
                        <button type="button" class="remove-value text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Value Title</label>
                            <input type="text" name="values[${index}][title]" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Value Description</label>
                            <textarea name="values[${index}][description]" rows="3" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>
                `;
                
                container.appendChild(newValueCard);
            });

            // Add stat functionality
            document.getElementById('add-stat').addEventListener('click', function() {
                const container = document.getElementById('stats-container');
                const index = container.children.length;
                
                const newStatCard = document.createElement('div');
                newStatCard.className = 'stat-card border border-gray-200 rounded-lg p-4';
                newStatCard.setAttribute('data-index', index);
                
                newStatCard.innerHTML = `
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Stat ${index + 1}</h3>
                        <button type="button" class="remove-stat text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Number</label>
                            <input type="text" name="stats[${index}][number]" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
                            <input type="text" name="stats[${index}][label]" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                `;
                
                container.appendChild(newStatCard);
            });

            // Remove value functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-value')) {
                    const card = e.target.closest('.value-card');
                    card.remove();
                    
                    // Reindex remaining cards
                    const cards = document.querySelectorAll('.value-card');
                    cards.forEach((card, index) => {
                        card.setAttribute('data-index', index);
                        card.querySelector('h3').textContent = `Value ${index + 1}`;
                        
                        // Update input names
                        const inputs = card.querySelectorAll('input, textarea');
                        inputs.forEach(input => {
                            const name = input.getAttribute('name');
                            if (name) {
                                input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                            }
                        });
                    });
                }
            });

            // Remove stat functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-stat')) {
                    const card = e.target.closest('.stat-card');
                    card.remove();
                    
                    // Reindex remaining cards
                    const cards = document.querySelectorAll('.stat-card');
                    cards.forEach((card, index) => {
                        card.setAttribute('data-index', index);
                        card.querySelector('h3').textContent = `Stat ${index + 1}`;
                        
                        // Update input names
                        const inputs = card.querySelectorAll('input');
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
                            button.classList.remove('bg-red-100', 'text-red-800');
                            button.classList.add('bg-green-100', 'text-green-800');
                            button.textContent = 'Active';
                        } else {
                            button.classList.remove('bg-green-100', 'text-green-800');
                            button.classList.add('bg-red-100', 'text-red-800');
                            button.textContent = 'Inactive';
                        }
                        showMessage('success', data.message);
                    } else {
                        showMessage('error', data.message || 'An error occurred');
                    }
                })
                .catch(error => {
                    showMessage('error', 'An error occurred while toggling section');
                });
            }

            // Message display function
            function showMessage(type, message) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${
                    type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                }`;
                messageDiv.textContent = message;
                
                document.body.appendChild(messageDiv);
                
                setTimeout(() => {
                    messageDiv.remove();
                }, 3000);
            }
        </script>
    </div>
</x-admin-layout> 