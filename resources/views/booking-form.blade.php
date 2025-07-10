<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Booking Form</title>
    <link rel="stylesheet" href="{{ asset('/public/css/booking-form.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-authenticated" content="{{ auth()->check() ? 'true' : 'false' }}">
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
                                <option value="debut">Debut</option>
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
                    <!-- Church Selection Step (hidden by default, shown for wedding/baptism) -->
                    <div class="venue-step" id="churchStep" style="display: none;">
                        <div class="venue-step-header">
                            <h2>⛪ Choose a Church</h2>
                            <button type="button" class="btn btn-secondary" id="backToEventType">
                                <span>←</span> Back to Event Details
                            </button>
                        </div>
                        <div class="church-grid horizontal-grid">
                            @foreach($churches as $church)
                                <div class="venue-card" data-venue-id="{{ $church->id }}" data-venue-price="{{ $church->price_range }}">
                                    <img src="{{ $church->main_image }}" alt="{{ $church->name }}" class="venue-image">
                                    <span class="venue-tag">Church</span>
                                    <span class="availability-label" style="display: none; position: absolute; top: 8px; right: 8px; background: rgba(0,0,0,0.7); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600; z-index: 2;"></span>
                                    <div class="venue-content">
                                        <h3 class="venue-title">{{ $church->name }}</h3>
                                        <div class="venue-info">
                                            <span class="venue-price">₱{{ number_format($church->price_range) }}</span>
                                            <span>Capacity: {{ $church->capacity }}</span>
                                        </div>
                                        <div class="venue-actions">
                                            <button type="button" class="view-more-btn">View Details</button>
                                            <button type="button" class="check-availability-btn" style="display: none; width: 100%; margin-top: 8px; padding: 7px 16px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                                                📅 Check Availability
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="venue-navigation">
                            <!-- Navigation handled by main Next/Previous buttons -->
                        </div>
                    </div>
                    <!-- Existing Venue Type Selection Step -->
                    <div class="venue-step" id="venueStep1">
                        <h2>🏠 Choose Venue Type</h2>
                        <button type="button" class="btn btn-secondary" id="backToChurchFromVenueType" style="display: none; margin-bottom: 12px;">
                            <span>←</span> Back to Church Selection
                        </button>
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
                        </div>

                    </div>

                    <div class="venue-step" id="venueStep2" style="display: none;">
                        <div class="venue-step-header">
                            <h2>🏠 Select Your Venue</h2>
                            <button type="button" class="btn btn-secondary" id="backToVenueType">
                                <span>←</span> Back to Venue Type
                            </button>
                        </div>
                        
                        <div class="venue-grid horizontal-grid">
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
                                <button type="button" class="btn btn-primary" onclick="getDirections()">
                                    🗺️ Get Directions
                                </button>
                            </div>
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
                                    <strong>Total Cost: </strong> <span id="summaryTotalPrice">₱0</span>
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
            <p>Thank you for choosing us for your special event. We'll review your request and get back to you within 24 hours.</p>
            <br>
            <p><strong>Booking Reference:</strong><span id="bookingRef"></span></p>
            <br>
            <div class="countdown-container">
                <p class="countdown-text">You will be redirected to home page in <span id="countdown" class="countdown-number">10</span> seconds</p>
                <div class="countdown-progress">
                    <div class="countdown-bar" id="countdownBar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Venue Availability Calendar Modal -->
    <div id="availabilityCalendarModal" class="calendar-modal-overlay" style="display:none;">
      <div class="calendar-modal-content">
        <div class="calendar-modal-header" style="display:flex;align-items:center;justify-content:space-between;padding:12px 20px 8px 20px;border-bottom:1px solid #eee;">
          <span id="calendarVenueName" style="font-weight:600;font-size:1.1rem;"></span>
          <button type="button" class="calendar-modal-close" style="background:none;border:none;font-size:2rem;line-height:1;color:#888;cursor:pointer;">&times;</button>
        </div>
        <div class="calendar-modal-body" style="padding:20px;">
          <div class="calendar-controls" style="display:flex;align-items:center;justify-content:center;gap:16px;margin-bottom:12px;">
            <button id="calendarPrev" style="background:#f3f3f3;border:none;border-radius:6px;padding:6px 12px;font-size:1.2rem;cursor:pointer;">&#8592;</button>
            <span id="calendarMonth" style="font-weight:500;font-size:1rem;"></span>
            <button id="calendarNext" style="background:#f3f3f3;border:none;border-radius:6px;padding:6px 12px;font-size:1.2rem;cursor:pointer;">&#8594;</button>
          </div>
          <div id="calendarGrid" class="calendar-grid" style="display:grid;grid-template-columns:repeat(7,1fr);gap:6px;"></div>
          <div class="calendar-selected-info" id="calendarSelectedDate" style="margin-top:10px;text-align:center;font-size:1rem;font-weight:500;"></div>
          
          <!-- Time Selection for Partial Day Availability -->
          <div id="timeSelection" style="display:none;margin-top:16px;padding:16px;background:#f8f9fa;border-radius:8px;">
            <h4 style="margin:0 0 12px 0;font-weight:600;color:#333;">Select Available Time Slot</h4>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
              <div>
                <label style="display:block;margin-bottom:4px;font-size:0.9rem;color:#666;">Start Time</label>
                <input type="time" id="calendarStartTime" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
              </div>
              <div>
                <label style="display:block;margin-bottom:4px;font-size:0.9rem;color:#666;">End Time</label>
                <input type="time" id="calendarEndTime" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
              </div>
            </div>
            <div id="timeConflictWarning" style="display:none;margin-top:8px;padding:8px;background:#fff3cd;border:1px solid #ffeaa7;border-radius:4px;color:#856404;font-size:0.9rem;">
              ⚠️ This time conflicts with existing bookings
            </div>
          </div>
          
          <!-- Calendar Legend -->
          <div style="margin-top:12px;font-size:0.8rem;color:#666;text-align:center;">
            <span style="display:inline-block;margin-right:12px;">
              <span style="display:inline-block;width:12px;height:12px;background:#f3e6e6;border-radius:2px;margin-right:4px;"></span>
              Unavailable
            </span>
            <span style="display:inline-block;margin-right:12px;">
              <span style="display:inline-block;width:12px;height:12px;background:#1976d2;border-radius:2px;margin-right:4px;"></span>
              Selected
            </span>
            <span style="display:inline-block;">
              <span style="display:inline-block;width:12px;height:12px;border:1.5px solid #1976d2;border-radius:2px;margin-right:4px;"></span>
              Today
            </span>
          </div>
          
          <button id="calendarConfirmBtn" class="btn btn-primary" style="margin-top:16px; width:100%;" disabled>Use This Date</button>
        </div>
      </div>
    </div>

    <style>
    .calendar-modal-overlay {
      position: fixed; z-index: 1000; left: 0; top: 0; width: 100vw; height: 100vh;
      background: rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center;
    }
    .calendar-modal-content {
      background: #fff; border-radius: 14px; box-shadow: 0 8px 32px rgba(0,0,0,0.18);
      max-width: 400px; width: 95vw; overflow: hidden; animation: fadeIn 0.2s;
    }
    .calendar-grid {
      min-height: 220px;
    }
    .calendar-day {
      background: #f9f9f9; border-radius: 6px; padding: 10px 0; text-align: center; font-size: 1rem; cursor: pointer; transition: background 0.15s, color 0.15s, box-shadow 0.15s;
    }
    .calendar-day.unavailable {
      background: #f3e6e6; color: #b71c1c; cursor: not-allowed; text-decoration: line-through;
    }
    .calendar-day.selected {
      background: #1976d2; color: #fff; box-shadow: 0 2px 8px #1976d233;
    }
    .calendar-day.today {
      border: 1.5px solid #1976d2;
    }
    .calendar-controls button:disabled {
      opacity: 0.5; cursor: not-allowed;
    }
    .calendar-modal-header {
      border-bottom: 1px solid #eee;
    }
    .calendar-modal-close:hover {
      color: #1976d2;
    }
    @media (max-width: 600px) {
      .calendar-modal-content { max-width: 98vw; }
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    #modalCheckAvailabilityBtn {
      background: #1976d2 !important;
      color: #fff !important;
      border: none;
      border-radius: 8px;
      font-size: 1.15rem;
      font-weight: 600;
      box-shadow: 0 2px 8px #1976d233;
      cursor: pointer;
      width: 90%;
      margin: 24px 5% 16px 5%;
      padding: 16px 0;
      display: block;
      transition: background 0.15s;
    }
    #modalCheckAvailabilityBtn:hover, #modalCheckAvailabilityBtn:focus {
      background: #1251a3 !important;
      color: #fff !important;
    }
    </style>

    <script src="{{ asset('/public/js/booking-form.js') }}"></script>
    <!-- 
    VENUE MAPS:
    Venue locations are displayed using OpenStreetMap iframe.
    No API key required - completely free and open source.
    -->
</body>
</html>