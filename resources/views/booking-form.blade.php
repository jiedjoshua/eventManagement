<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Booking Form</title>
    <link rel="stylesheet" href="{{ asset('public/css/booking-form.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✨ Event Booking</h1>
            <p>Let's create something amazing together</p>
        </div>
        
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill"></div>
        </div>

        <div class="step-indicators">
            <div class="step active" data-step="1">
                <div class="step-number">1</div>
                <span>Event Details</span>
            </div>
            <div class="step" data-step="2">
                <div class="step-number">2</div>
                <span>Venue</span>
            </div>
            <div class="step" data-step="3">
                <div class="step-number">3</div>
                <span>Services</span>
            </div>
            <div class="step" data-step="4">
                <div class="step-number">4</div>
                <span>Confirmation</span>
            </div>
        </div>

        <form id="bookingForm">
           
            <div class="form-content">
                 <!-- Step 1: Event Details -->
                <div class="step-content active" data-step="1">
                    <h2>🎉 Tell us about your event</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="eventType">Event Type</label>
                            <select id="eventType" name="eventType" required>
                                <option value="">Select event type</option>
                                <option value="wedding">Wedding</option>
                                <option value="birthday">Birthday Party</option>
                                <option value="corporate">Debut</option>
                                <option value="baptism">Baptism</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="eventName">Event Name / Title</label>
                            <input type="text" id="eventName" name="eventName" placeholder="e.g., John & Jane's Wedding" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="eventDate">Event Date</label>
                            <input type="date" id="eventDate" name="eventDate" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="guestCount">Expected Number of Guests</label>
                            <input type="number" id="guestCount" name="guestCount" placeholder="e.g., 150" min="1" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="startTime">Start Time</label>
                            <input type="time" id="startTime" name="startTime" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="endTime">End Time</label>
                            <input type="time" id="endTime" name="endTime" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="eventTheme">Event Theme / Style (Optional)</label>
                        <input type="text" id="eventTheme" name="eventTheme" placeholder="e.g., Vintage, Modern, Garden Party">
                    </div>
                </div>

                <!-- Step 2: Venue Details -->
                <div class="step-content" data-step="2">
                    <div class="venue-step" id="venueStep1">
                        <h2>🏠 Choose Venue Type</h2>
                        <div class="venue-type-selection">
                            <div class="venue-type-btn" data-venue-type="indoor">
                                <span class="venue-type-icon">🏢</span>
                                <span class="venue-type-label">Indoor</span>
                                <p class="venue-type-desc">Perfect for events that need climate control and protection from weather</p>
                                <input type="radio" name="venueType" value="indoor" required style="display: none;">
                            </div>
                            <div class="venue-type-btn" data-venue-type="outdoor">
                                <span class="venue-type-icon">🌳</span>
                                <span class="venue-type-label">Outdoor</span>
                                <p class="venue-type-desc">Ideal for natural lighting and open-air celebrations</p>
                                <input type="radio" name="venueType" value="outdoor" required style="display: none;">
                            </div>
                            <div class="venue-type-btn" data-venue-type="both">
                                <span class="venue-type-icon">🏢🌳</span>
                                <span class="venue-type-label">Indoor & Outdoor</span>
                                <p class="venue-type-desc">Flexible venues with both indoor and outdoor spaces available</p>
                                <input type="radio" name="venueType" value="both" required style="display: none;">
                            </div>
                        </div>
                        <div class="venue-navigation">
                            <button type="button" class="btn btn-primary" id="nextVenueStep" disabled>Continue to Venue Selection</button>
                        </div>
                    </div>

                    <div class="venue-step" id="venueStep2" style="display: none;">
                        <div class="venue-step-header">
                            <h2>🏠 Select Your Venue</h2>
                            <button type="button" class="btn btn-secondary" id="backToVenueType">
                                <span>←</span> Back to Venue Type
                            </button>
                        </div>
                        
                        <div class="venue-grid">
                            <!-- Venue cards will be dynamically populated based on selection -->
                        </div>

                        <div class="form-group">
                            <label for="venueNotes">Special Requirements (Optional)</label>
                            <textarea id="venueNotes" name="venueNotes" rows="4" placeholder="Any special requirements or additional venue information"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Venue Details Modal -->
                <div class="venue-modal" id="venueModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <img src="" alt="" id="modalVenueImage">
                            <button type="button" class="modal-close">&times;</button>
                        </div>
                        <div class="modal-body">
                            <h2 class="modal-title" id="modalVenueTitle"></h2>
                            
                            <div class="venue-details">
                                <div class="detail-item">
                                    <span>🎭 Type:</span>
                                    <span id="modalVenueType"></span>
                                </div>
                                <div class="detail-item">
                                    <span>👥 Capacity:</span>
                                    <span id="modalVenueCapacity"></span>
                                </div>
                                <div class="detail-item">
                                    <span>💰 Price:</span>
                                    <span id="modalVenuePrice"></span>
                                </div>
                            </div>

                            <div class="venue-features">
                                <h3>Available Spaces</h3>
                                <div id="modalVenueSpaces"></div>
                            </div>

                            <h3>Gallery</h3>
                            <div class="venue-gallery">
                                <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3" class="gallery-img" alt="Venue Image 1">
                                <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3" class="gallery-img" alt="Venue Image 2">
                                <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3" class="gallery-img" alt="Venue Image 3">
                            </div>

                            <h3>Location</h3>
                            <div class="venue-map" id="modalVenueMap">
                                <!-- Map will be loaded here -->
                            </div>
                            <div class="venue-directions">
                                <button type="button" class="btn btn-primary" id="getDirectionsBtn" onclick="getDirections()">
                                    🗺️ Get Directions
                                </button>
                            </div>

                            <button type="button" class="btn btn-primary" onclick="selectVenue()">Select This Venue</button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Services Selection -->
               <!-- Step 3: Services Selection -->
<div class="step-content" data-step="3">
    <h2>📦 Choose Your Services</h2>
    
    <div class="form-group">
        <label>Select a Package</label>
        <div class="packages">
            <!-- Packages will be dynamically loaded here when event type is selected -->
            <div class="no-packages-message" style="text-align: center; padding: 20px;">
                Please select an event type to view available packages
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Add-on Services</label>
        <div class="addons">
            @foreach($addons as $addon)
            <div class="addon-item" data-price="{{ $addon->price }}">
                <input type="checkbox" id="addon_{{ $addon->id }}" name="addons[]" value="{{ $addon->id }}">
                <span>{{ $addon->display_name }} - ₱{{ number_format($addon->price, 2) }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="package-modal" id="packageModal">
    <div class="package-modal-content">
        <button type="button" class="package-modal-close" onclick="closePackageModal()">&times;</button>
        <div class="modal-body">
            <h2 class="package-modal-title"></h2>
            <div class="package-modal-price"></div>
            <div class="package-details">
                <h3>Package Features</h3>
                <div class="package-modal-features"></div>
            </div>
        </div>
    </div>
</div>

    <div class="form-group">
        <label for="foodPreferences">Food Preferences / Dietary Restrictions (Optional)</label>
        <textarea id="foodPreferences" name="foodPreferences" rows="3" placeholder="Any dietary restrictions, allergies, or food preferences we should know about"></textarea>
    </div>
</div>

                <!-- Step 4: Confirmation -->
                <div class="step-content" data-step="4">
                    <h2>📅 Final Details & Confirmation</h2>
                    
                    <div class="booking-summary">
                        <div class="form-group">
                            <h3>Event Details</h3>
                            <div class="summary-item">
                                <strong>Event Type:</strong> <span id="summaryEventType"></span>
                            </div>
                            <div class="summary-item">
                                <strong>Event Name:</strong> <span id="summaryEventName"></span>
                            </div>
                            <div class="summary-item">
                                <strong>Date:</strong> <span id="summaryEventDate"></span>
                            </div>
                            <div class="summary-item">
                                <strong>Time:</strong> <span id="summaryEventTime"></span>
                            </div>
                            <div class="summary-item">
                                <strong>Guest Count:</strong> <span id="summaryGuestCount"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <h3>Selected Venue</h3>
                            <div class="summary-item">
                                <strong>Venue Type:</strong> <span id="summaryVenueType"></span>
                            </div>
                            <div class="summary-item">
                                <strong>Venue Name:</strong> <span id="summaryVenueName"></span>
                            </div>
                            <div class="summary-item">
                                <strong>Special Requirements:</strong> <span id="summaryVenueNotes"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <h3>Selected Package & Services</h3>
                            <div class="summary-item">
                                <strong>Package:</strong> <span id="summaryPackage"></span>
                            </div>
                            <div class="summary-item">
                                <strong>Add-on Services:</strong>
                                <ul id="summaryAddons" class="addon-list"></ul>
                            </div>
                            <div class="summary-item">
                                <strong>Dietary Requirements:</strong> <span id="summaryDietary"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <h3>Pricing Summary</h3>
                            <div class="pricing-breakdown">
                                <div class="summary-item">
                                    <strong>Package Cost:</strong> <span id="summaryPackagePrice">₱0</span>
                                </div>
                                <div class="summary-item">
                                    <strong>Add-on Services:</strong> <span id="summaryAddonsPrice">₱0</span>
                                </div>
                                <div class="summary-item">
                                    <strong>Venue Cost:</strong> <span id="summaryVenuePrice">₱0</span>
                                </div>
                                <div class="summary-item total-price">
                                    <strong>Total Estimated Cost: </strong> <span id="summaryTotalPrice">₱0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="additionalNotes">Additional Notes or Requests (Optional)</label>
                        <textarea id="additionalNotes" name="additionalNotes" rows="4" placeholder="Any other details you'd like us to know about your event"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="addon-item">
                            <input type="checkbox" id="terms" name="terms" required>
                            <span>I agree to the <a href="/terms" target="_blank" style="color: #3498db; text-decoration: underline;"><strong>terms and conditions</strong></a> and <a href="/privacy" target="_blank" style="color: #3498db; text-decoration: underline;"><strong>privacy policy</strong></a></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="navigation">
                <button type="button" class="btn btn-secondary" id="prevBtn" disabled>Previous</button>
                <button type="button" class="btn btn-primary" id="nextBtn">Next Step</button>
            </div>
        </form>

        <div class="confirmation hidden" id="confirmation">
            <div class="success-icon">✓</div>
            <h2>🎉 Booking Request Submitted!</h2>
            <p>Thank you for choosing us for your special event. We'll review your request and get back to you within 24 hours with a detailed quote and next steps.</p>
            <br>
            <p><strong>Booking Reference:</strong><span id="bookingRef"></span></p>
        </div>
    </div>

    <script src="{{ asset('public/js/booking-form.js') }}"></script>
    <!-- 
    VENUE MAPS:
    Venue locations are displayed using OpenStreetMap iframe.
    No API key required - completely free and open source.
    -->
</body>
</html>