<x-admin-layout title="Contact Page CMS" active-page="contact-cms">
    <div class="p-6">
        <!-- Modernized Header -->
        <div class="mb-6 flex justify-between items-center bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-6">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Contact Page CMS</h1>
                <p class="text-purple-100">Manage the content for the Contact page</p>
            </div>
            <a href="{{ route('contact') }}" target="_blank" class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                <span>View Contact Page</span>
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
                                <p class="text-sm text-gray-600">Configure the main contact page header</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 font-medium">Status:</span>
                            <button id="contact-hero-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ isset($content['contact_hero']) && $content['contact_hero']->is_active ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="contact_hero">
                                {{ isset($content['contact_hero']) && $content['contact_hero']->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form id="contact-hero-form" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Title</label>
                                <input type="text" name="hero_title" value="{{ isset($content['contact_hero']) ? $content['contact_hero']->title : 'Get in Touch' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Hero Subtitle</label>
                                <input type="text" name="hero_subtitle" value="{{ isset($content['contact_hero']) ? $content['contact_hero']->subtitle : 'Ready to start planning your perfect event? We\'d love to hear from you!' }}" 
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

            <!-- Modernized Contact Information Section -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">Contact Information Section</h2>
                                <p class="text-sm text-gray-600">Edit your business contact details</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 font-medium">Status:</span>
                            <button id="contact-info-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ isset($content['contact_info']) && $content['contact_info']->is_active ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="contact_info">
                                {{ isset($content['contact_info']) && $content['contact_info']->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form id="contact-info-form" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Section Title</label>
                            <input type="text" name="info_title" value="{{ isset($content['contact_info']) ? $content['contact_info']->title : 'Let\'s Start Planning Together' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Description</label>
                            <textarea name="info_description" rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">{{ isset($content['contact_info']) ? $content['contact_info']->description : 'Whether you\'re planning a wedding, birthday celebration, or any special event, our team is here to help bring your vision to life. Reach out to us and let\'s create something extraordinary together.' }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Phone Number</label>
                                <input type="text" name="contact_phone" value="{{ isset($content['contact_info']) ? $content['contact_info']->contact_phone : '+63 912 345 6789' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Email Address</label>
                                <input type="email" name="contact_email" value="{{ isset($content['contact_info']) ? $content['contact_info']->contact_email : 'hello@crwdctrl.ph' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Address</label>
                                <input type="text" name="contact_address" value="{{ isset($content['contact_info']) ? $content['contact_info']->contact_address : 'Bataan, Philippines' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Business Hours</label>
                                <textarea name="business_hours" rows="2" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">{{ isset($content['contact_info']) && $content['contact_info']->service_cards && isset($content['contact_info']->service_cards['business_hours']) ? $content['contact_info']->service_cards['business_hours'] : 'Monday - Friday: 9:00 AM - 6:00 PM\nSaturday: 9:00 AM - 4:00 PM' }}</textarea>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Update Contact Information</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modernized FAQ Section -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">FAQ Section</h2>
                                <p class="text-sm text-gray-600">Frequently asked questions</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 font-medium">Status:</span>
                            <button id="contact-faq-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ isset($content['contact_faq']) && $content['contact_faq']->is_active ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="contact_faq">
                                {{ isset($content['contact_faq']) && $content['contact_faq']->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form id="contact-faq-form" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">FAQ Section Title</label>
                            <input type="text" name="faq_title" value="{{ isset($content['contact_faq']) ? $content['contact_faq']->title : 'Frequently Asked Questions' }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        </div>
                        <div id="faq-container" class="space-y-6">
                            @php
                                $defaultFAQs = [
                                    ['question' => 'How far in advance should I book my event?', 'answer' => 'We recommend booking at least 3-6 months in advance for weddings and large events, and 1-2 months for smaller celebrations. However, we can accommodate last-minute requests depending on availability.'],
                                    ['question' => 'What\'s included in your event planning packages?', 'answer' => 'Our packages include venue coordination, vendor management, timeline planning, day-of coordination, and ongoing support throughout the planning process. Specific inclusions vary by package - contact us for details!'],
                                    ['question' => 'Can I customize a package to fit my specific needs?', 'answer' => 'Absolutely! We believe every event is unique. We offer customizable packages and can work with you to create a plan that perfectly fits your vision and budget.']
                                ];
                                $faqs = isset($content['contact_faq']) && $content['contact_faq']->service_cards ? $content['contact_faq']->service_cards : $defaultFAQs;
                            @endphp
                            
                            @foreach($faqs as $index => $faq)
                                <div class="faq-card bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-200" data-index="{{ $index }}">
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">{{ $index + 1 }}</span>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900">FAQ {{ $index + 1 }}</h3>
                                        </div>
                                        <button type="button" class="remove-faq text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">Question</label>
                                            <input type="text" name="faqs[{{ $index }}][question]" value="{{ $faq['question'] }}" 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">Answer</label>
                                            <textarea name="faqs[{{ $index }}][answer]" rows="3" 
                                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">{{ $faq['answer'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <button type="button" id="add-faq" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span>Add FAQ</span>
                            </button>
                            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Update FAQ Section</span>
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
                            <button id="contact-cta-toggle" 
                                    class="toggle-btn px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ isset($content['contact_cta']) && $content['contact_cta']->is_active ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' }}"
                                    data-section="contact_cta">
                                {{ isset($content['contact_cta']) && $content['contact_cta']->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form id="contact-cta-form" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">CTA Title</label>
                                <input type="text" name="cta_title" value="{{ isset($content['contact_cta']) ? $content['contact_cta']->title : 'Ready to Start Planning?' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">CTA Subtitle</label>
                                <input type="text" name="cta_subtitle" value="{{ isset($content['contact_cta']) ? $content['contact_cta']->subtitle : 'Let\'s turn your dream event into reality' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Button Text</label>
                                <input type="text" name="cta_button_text" value="{{ isset($content['contact_cta']) ? $content['contact_cta']->button_text : 'Book Your Event Now' }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Button Link</label>
                                <input type="text" name="cta_button_link" value="{{ isset($content['contact_cta']) ? $content['contact_cta']->button_link : route('book-now') }}" 
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
            document.getElementById('contact-hero-form').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(this, '{{ route("admin.cms.contact-page.hero.update") }}', 'Hero section updated successfully!');
            });

            document.getElementById('contact-info-form').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(this, '{{ route("admin.cms.contact-page.info.update") }}', 'Contact information updated successfully!');
            });

            document.getElementById('contact-faq-form').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(this, '{{ route("admin.cms.contact-page.faq.update") }}', 'FAQ section updated successfully!');
            });

            document.getElementById('contact-cta-form').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(this, '{{ route("admin.cms.contact-page.cta.update") }}', 'CTA section updated successfully!');
            });

            // Add FAQ functionality
            document.getElementById('add-faq').addEventListener('click', function() {
                const container = document.getElementById('faq-container');
                const index = container.children.length;
                
                const newFaqCard = document.createElement('div');
                newFaqCard.className = 'faq-card bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-200';
                newFaqCard.setAttribute('data-index', index);
                
                newFaqCard.innerHTML = `
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">${index + 1}</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">FAQ ${index + 1}</h3>
                        </div>
                        <button type="button" class="remove-faq text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Question</label>
                            <input type="text" name="faqs[${index}][question]" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Answer</label>
                            <textarea name="faqs[${index}][answer]" rows="3" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white hover:bg-gray-50"></textarea>
                        </div>
                    </div>
                `;
                
                container.appendChild(newFaqCard);
            });

            // Remove FAQ functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-faq')) {
                    const card = e.target.closest('.faq-card');
                    card.remove();
                    
                    // Reindex remaining cards
                    const cards = document.querySelectorAll('.faq-card');
                    cards.forEach((card, index) => {
                        card.setAttribute('data-index', index);
                        card.querySelector('h3').textContent = `FAQ ${index + 1}`;
                        
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