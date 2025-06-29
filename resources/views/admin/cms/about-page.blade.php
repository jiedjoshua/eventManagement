<x-admin-layout title="About Page CMS" active-page="about-cms">
    <div class="p-6">
        <!-- Modernized Header -->
        <div class="mb-6 flex justify-between items-center bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-6">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">About Page CMS</h1>
                <p class="text-purple-100">Manage the content for the About page</p>
            </div>
            <a href="{{ route('about') }}" target="_blank" class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                <span>View About Page</span>
            </a>
        </div>

        <div class="space-y-6">
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
                                <p class="text-sm text-gray-600">Configure the main about page header</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 font-medium">Status:</span>
                            <button id="about-hero-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ isset($content['about_hero']) && $content['about_hero']->is_active ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="about_hero">
                                {{ isset($content['about_hero']) && $content['about_hero']->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form id="about-hero-form" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Title</label>
                                <input type="text" name="hero_title" value="{{ isset($content['about_hero']) ? $content['about_hero']->title : 'About CrwdCtrl' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Subtitle</label>
                                <input type="text" name="hero_subtitle" value="{{ isset($content['about_hero']) ? $content['about_hero']->subtitle : 'Creating unforgettable moments, one event at a time' }}" 
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

            <!-- Modernized Our Story Section -->
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
                                <h2 class="text-xl font-semibold text-gray-900">Our Story Section</h2>
                                <p class="text-sm text-gray-600">Share your company story and image</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 font-medium">Status:</span>
                            <button id="about-story-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ isset($content['about_story']) && $content['about_story']->is_active ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="about_story">
                                {{ isset($content['about_story']) && $content['about_story']->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form id="about-story-form" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Story Title</label>
                            <input type="text" name="story_title" value="{{ isset($content['about_story']) ? $content['about_story']->title : 'Our Story' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Story Content</label>
                            <textarea name="story_content" rows="6" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">{{ isset($content['about_story']) ? $content['about_story']->description : 'Founded with a passion for creating extraordinary experiences, CrwdCtrl began as a small team of event enthusiasts who believed that every celebration deserves to be perfect. What started as a dream to make events more memorable has grown into a trusted name in event management across Bataan and beyond.\n\nOver the years, we\'ve had the privilege of being part of countless special moments - from intimate family gatherings to grand celebrations. Each event has taught us something new, and every client has become part of our extended family.\n\nToday, we continue to innovate and push the boundaries of what\'s possible in event planning, always keeping our core values of creativity, reliability, and personal touch at the heart of everything we do.' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Story Image</label>
                            <div class="flex items-center space-x-4">
                                @if(isset($content['about_story']) && isset($content['about_story']->image_path))
                                    <img src="/public{{ str_replace('/public', '', $content['about_story']->image_path) }}" 
                                         alt="Our Story" 
                                         class="w-24 h-24 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                                @else
                                    <div class="w-24 h-24 bg-gray-200 flex items-center justify-center rounded-lg border-2 border-gray-200">
                                        <span class="text-gray-500 text-xs">No Image</span>
                                    </div>
                                @endif
                                <input type="file" name="story_image" accept="image/*" 
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Leave empty to keep current image</p>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Update Story Section</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modernized Mission & Vision Section -->
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
                                <h2 class="text-xl font-semibold text-gray-900">Mission & Vision Section</h2>
                                <p class="text-sm text-gray-600">Define your company's mission and vision</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 font-medium">Status:</span>
                            <button id="about-mission-vision-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ isset($content['about_mission_vision']) && $content['about_mission_vision']->is_active ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="about_mission_vision">
                                {{ isset($content['about_mission_vision']) && $content['about_mission_vision']->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form id="about-mission-vision-form" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Mission -->
                            <div class="border border-gray-200 rounded-xl p-6 bg-gray-50 hover:bg-white transition-all duration-200 shadow-sm">
                                <h3 class="text-lg font-semibold text-indigo-700 mb-4 flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6"></path>
                                    </svg>
                                    <span>Mission</span>
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Mission Title</label>
                                        <input type="text" name="mission_title" value="{{ isset($content['about_mission_vision']) && $content['about_mission_vision']->service_cards && isset($content['about_mission_vision']->service_cards['mission_title']) ? $content['about_mission_vision']->service_cards['mission_title'] : 'Our Mission' }}" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Mission Content</label>
                                        <textarea name="mission_content" rows="4" 
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">{{ isset($content['about_mission_vision']) && $content['about_mission_vision']->service_cards && isset($content['about_mission_vision']->service_cards['mission_content']) ? $content['about_mission_vision']->service_cards['mission_content'] : 'To transform ordinary moments into extraordinary memories by providing innovative, personalized, and seamless event planning services that exceed expectations and create lasting impressions for our clients and their guests.' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- Vision -->
                            <div class="border border-gray-200 rounded-xl p-6 bg-gray-50 hover:bg-white transition-all duration-200 shadow-sm">
                                <h3 class="text-lg font-semibold text-indigo-700 mb-4 flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <span>Vision</span>
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Vision Title</label>
                                        <input type="text" name="vision_title" value="{{ isset($content['about_mission_vision']) && $content['about_mission_vision']->service_cards && isset($content['about_mission_vision']->service_cards['vision_title']) ? $content['about_mission_vision']->service_cards['vision_title'] : 'Our Vision' }}" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Vision Content</label>
                                        <textarea name="vision_content" rows="4" 
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">{{ isset($content['about_mission_vision']) && $content['about_mission_vision']->service_cards && isset($content['about_mission_vision']->service_cards['vision_content']) ? $content['about_mission_vision']->service_cards['vision_content'] : 'To be the leading event management company in the region, known for our creativity, reliability, and commitment to excellence. We aspire to set new standards in the industry while building lasting relationships with our clients and partners.' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Update Mission & Vision</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modernized Core Values Section -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 01-8 0M12 3v4m0 0a4 4 0 01-4 4H7a4 4 0 01-4-4V7a4 4 0 014-4h1a4 4 0 014 4z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">Core Values Section</h2>
                                <p class="text-sm text-gray-600">Showcase your company's core values</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 font-medium">Status:</span>
                            <button id="about-values-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ isset($content['about_values']) && $content['about_values']->is_active ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="about_values">
                                {{ isset($content['about_values']) && $content['about_values']->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form id="about-values-form" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Values Section Title</label>
                            <input type="text" name="values_title" value="{{ isset($content['about_values']) ? $content['about_values']->title : 'Our Core Values' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div id="values-container" class="space-y-6">
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
                                <div class="value-card bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-200" data-index="{{ $index }}">
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">{{ $index + 1 }}</span>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900">Value {{ $index + 1 }}</h3>
                                        </div>
                                        <button type="button" class="remove-value text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">Value Title</label>
                                            <input type="text" name="values[{{ $index }}][title]" value="{{ $value['title'] }}" 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">Value Description</label>
                                            <textarea name="values[{{ $index }}][description]" rows="3" 
                                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">{{ $value['description'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <button type="button" id="add-value" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span>Add Value</span>
                            </button>
                            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Update Values</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modernized Statistics Section -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17a2.5 2.5 0 002.5-2.5V7.5A2.5 2.5 0 0011 5m0 0A2.5 2.5 0 008.5 7.5v7A2.5 2.5 0 0011 17z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">Statistics Section</h2>
                                <p class="text-sm text-gray-600">Showcase your company's achievements</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 font-medium">Status:</span>
                            <button id="about-stats-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ isset($content['about_stats']) && $content['about_stats']->is_active ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="about_stats">
                                {{ isset($content['about_stats']) && $content['about_stats']->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form id="about-stats-form" class="space-y-6">
                        @csrf
                        <div id="stats-container" class="space-y-6">
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
                                <div class="stat-card bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-200" data-index="{{ $index }}">
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">{{ $index + 1 }}</span>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900">Stat {{ $index + 1 }}</h3>
                                        </div>
                                        <button type="button" class="remove-stat text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">Number</label>
                                            <input type="text" name="stats[{{ $index }}][number]" value="{{ $stat['number'] }}" 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">Label</label>
                                            <input type="text" name="stats[{{ $index }}][label]" value="{{ $stat['label'] }}" 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <button type="button" id="add-stat" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span>Add Statistic</span>
                            </button>
                            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Update Statistics</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modernized CTA Section -->
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
                            <button id="about-cta-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ isset($content['about_cta']) && $content['about_cta']->is_active ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="about_cta">
                                {{ isset($content['about_cta']) && $content['about_cta']->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form id="about-cta-form" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">CTA Title</label>
                                <input type="text" name="cta_title" value="{{ isset($content['about_cta']) ? $content['about_cta']->title : 'Ready to Create Something Amazing?' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">CTA Subtitle</label>
                                <input type="text" name="cta_subtitle" value="{{ isset($content['about_cta']) ? $content['about_cta']->subtitle : 'Let\'s work together to make your next event unforgettable' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Primary Button Text</label>
                                <input type="text" name="cta_primary_button_text" value="{{ isset($content['about_cta']) ? $content['about_cta']->button_text : 'Start Planning' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Primary Button Link</label>
                                <input type="text" name="cta_primary_button_link" value="{{ isset($content['about_cta']) ? $content['about_cta']->button_link : route('book-now') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Secondary Button Text</label>
                                <input type="text" name="cta_secondary_button_text" value="{{ isset($content['about_cta']) && $content['about_cta']->service_cards && isset($content['about_cta']->service_cards['secondary_button_text']) ? $content['about_cta']->service_cards['secondary_button_text'] : 'Get in Touch' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Secondary Button Link</label>
                                <input type="text" name="cta_secondary_button_link" value="{{ isset($content['about_cta']) && $content['about_cta']->service_cards && isset($content['about_cta']->service_cards['secondary_button_link']) ? $content['about_cta']->service_cards['secondary_button_link'] : route('home') . '#contact' }}" 
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
                newValueCard.className = 'value-card bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-200';
                newValueCard.setAttribute('data-index', index);
                
                newValueCard.innerHTML = `
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">${index + 1}</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Value ${index + 1}</h3>
                        </div>
                        <button type="button" class="remove-value text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Value Title</label>
                            <input type="text" name="values[${index}][title]" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Value Description</label>
                            <textarea name="values[${index}][description]" rows="3" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50"></textarea>
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
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Number</label>
                            <input type="text" name="stats[${index}][number]" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Label</label>
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