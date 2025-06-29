<x-admin-layout title="Contact Page CMS" active-page="contact-cms">
    <div class="p-6">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Contact Page CMS</h1>
                <p class="text-gray-600">Manage the content for the Contact page</p>
            </div>
            <a href="{{ route('contact') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                View Contact Page
            </a>
        </div>

        <div class="space-y-6">
            <!-- Hero Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Hero Section</h2>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500">Status:</span>
                        <button id="contact-hero-toggle" 
                                class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ isset($content['contact_hero']) && $content['contact_hero']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                data-section="contact_hero">
                            {{ isset($content['contact_hero']) && $content['contact_hero']->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>

                <form id="contact-hero-form" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hero Title</label>
                            <input type="text" name="hero_title" value="{{ isset($content['contact_hero']) ? $content['contact_hero']->title : 'Get in Touch' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hero Subtitle</label>
                            <input type="text" name="hero_subtitle" value="{{ isset($content['contact_hero']) ? $content['contact_hero']->subtitle : 'Ready to start planning your perfect event? We\'d love to hear from you!' }}" 
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

            <!-- Contact Information Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Contact Information Section</h2>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500">Status:</span>
                        <button id="contact-info-toggle" 
                                class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ isset($content['contact_info']) && $content['contact_info']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                data-section="contact_info">
                            {{ isset($content['contact_info']) && $content['contact_info']->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>

                <form id="contact-info-form" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                        <input type="text" name="info_title" value="{{ isset($content['contact_info']) ? $content['contact_info']->title : 'Let\'s Start Planning Together' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="info_description" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ isset($content['contact_info']) ? $content['contact_info']->description : 'Whether you\'re planning a wedding, birthday celebration, or any special event, our team is here to help bring your vision to life. Reach out to us and let\'s create something extraordinary together.' }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="text" name="contact_phone" value="{{ isset($content['contact_info']) ? $content['contact_info']->contact_phone : '+63 912 345 6789' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="contact_email" value="{{ isset($content['contact_info']) ? $content['contact_info']->contact_email : 'hello@crwdctrl.ph' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <input type="text" name="contact_address" value="{{ isset($content['contact_info']) ? $content['contact_info']->contact_address : 'Bataan, Philippines' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Business Hours</label>
                            <textarea name="business_hours" rows="2" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ isset($content['contact_info']) && $content['contact_info']->service_cards && isset($content['contact_info']->service_cards['business_hours']) ? $content['contact_info']->service_cards['business_hours'] : 'Monday - Friday: 9:00 AM - 6:00 PM\nSaturday: 9:00 AM - 4:00 PM' }}</textarea>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                            Update Contact Information
                        </button>
                    </div>
                </form>
            </div>

            <!-- FAQ Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">FAQ Section</h2>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500">Status:</span>
                        <button id="contact-faq-toggle" 
                                class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ isset($content['contact_faq']) && $content['contact_faq']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                data-section="contact_faq">
                            {{ isset($content['contact_faq']) && $content['contact_faq']->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>

                <form id="contact-faq-form" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">FAQ Section Title</label>
                        <input type="text" name="faq_title" value="{{ isset($content['contact_faq']) ? $content['contact_faq']->title : 'Frequently Asked Questions' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div id="faq-container">
                        @php
                            $defaultFAQs = [
                                ['question' => 'How far in advance should I book my event?', 'answer' => 'We recommend booking at least 3-6 months in advance for weddings and large events, and 1-2 months for smaller celebrations. However, we can accommodate last-minute requests depending on availability.'],
                                ['question' => 'What\'s included in your event planning packages?', 'answer' => 'Our packages include venue coordination, vendor management, timeline planning, day-of coordination, and ongoing support throughout the planning process. Specific inclusions vary by package - contact us for details!'],
                                ['question' => 'Can I customize a package to fit my specific needs?', 'answer' => 'Absolutely! We believe every event is unique. We offer customizable packages and can work with you to create a plan that perfectly fits your vision and budget.']
                            ];
                            $faqs = isset($content['contact_faq']) && $content['contact_faq']->service_cards ? $content['contact_faq']->service_cards : $defaultFAQs;
                        @endphp
                        
                        @foreach($faqs as $index => $faq)
                            <div class="faq-card border border-gray-200 rounded-lg p-4" data-index="{{ $index }}">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">FAQ {{ $index + 1 }}</h3>
                                    <button type="button" class="remove-faq text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Question</label>
                                        <input type="text" name="faqs[{{ $index }}][question]" value="{{ $faq['question'] }}" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Answer</label>
                                        <textarea name="faqs[{{ $index }}][answer]" rows="3" 
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $faq['answer'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between">
                        <button type="button" id="add-faq" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                            Add FAQ
                        </button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                            Update FAQ Section
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
                        <button id="contact-cta-toggle" 
                                class="toggle-btn px-3 py-1 rounded-full text-sm font-medium {{ isset($content['contact_cta']) && $content['contact_cta']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                data-section="contact_cta">
                            {{ isset($content['contact_cta']) && $content['contact_cta']->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                </div>

                <form id="contact-cta-form" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CTA Title</label>
                            <input type="text" name="cta_title" value="{{ isset($content['contact_cta']) ? $content['contact_cta']->title : 'Ready to Start Planning?' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CTA Subtitle</label>
                            <input type="text" name="cta_subtitle" value="{{ isset($content['contact_cta']) ? $content['contact_cta']->subtitle : 'Let\'s turn your dream event into reality' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                            <input type="text" name="cta_button_text" value="{{ isset($content['contact_cta']) ? $content['contact_cta']->button_text : 'Book Your Event Now' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Button Link</label>
                            <input type="text" name="cta_button_link" value="{{ isset($content['contact_cta']) ? $content['contact_cta']->button_link : route('book-now') }}" 
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
                newFaqCard.className = 'faq-card border border-gray-200 rounded-lg p-4';
                newFaqCard.setAttribute('data-index', index);
                
                newFaqCard.innerHTML = `
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-medium text-gray-900">FAQ ${index + 1}</h3>
                        <button type="button" class="remove-faq text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Question</label>
                            <input type="text" name="faqs[${index}][question]" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Answer</label>
                            <textarea name="faqs[${index}][answer]" rows="3" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
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