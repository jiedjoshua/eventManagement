let currentStep = 1;
const totalSteps = 4;

const nextBtn = document.getElementById('nextBtn');
const prevBtn = document.getElementById('prevBtn');
const progressFill = document.getElementById('progressFill');
const form = document.getElementById('bookingForm');
const confirmation = document.getElementById('confirmation');

// First declare all the variables and constants
let selectedVenue = null;
let selectedVenueType = null;
let modal = null;
let modalClose = null;
const venueStep1 = document.getElementById('venueStep1');
const venueStep2 = document.getElementById('venueStep2');
const nextVenueStep = document.getElementById('nextVenueStep');
const backToVenueType = document.getElementById('backToVenueType');

// Add variables for church selection
let selectedChurch = null;
const churchStep = document.getElementById('churchStep');
const nextChurchStep = document.getElementById('nextChurchStep');
const churchGrid = document.querySelector('.church-grid');

// --- Venue Availability Calendar Modal Logic ---
let calendarVenueId = null;
let calendarVenueName = '';
let calendarYear = null;
let calendarMonth = null; // 0-based
let calendarUnavailableDates = [];
let calendarBookedDates = [];
let calendarSelected = null;
let calendarSelectedTime = null;
let calendarDataCache = {}; // Cache for calendar data
let calendarMinDate = null; // Minimum selectable date

window.openAvailabilityCalendar = function(venueId, venueName) {
    calendarVenueId = venueId;
    calendarVenueName = venueName;
    const today = new Date();
    // Determine minimum date based on event type
    const eventType = document.getElementById('eventType')?.value;
    let min;
    if (eventType === 'wedding') {
        min = new Date(today);
        min.setMonth(min.getMonth() + 3);
    } else if (eventType === 'birthday') {
        // 2 full weeks from today, rounded up to the next Monday
        min = new Date(today);
        min.setDate(min.getDate() + 14); // 2 weeks ahead
        // Find next Monday
        const dayOfWeek = min.getDay();
        const daysUntilMonday = (8 - dayOfWeek) % 7;
        if (daysUntilMonday !== 0) {
            min.setDate(min.getDate() + daysUntilMonday);
        }
    } else if (eventType === 'debut' || eventType === 'baptism') {
        min = new Date(today);
        min.setMonth(min.getMonth() + 1);
    } else {
        min = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    }
    calendarMinDate = new Date(min.getFullYear(), min.getMonth(), min.getDate());
    console.log('Event type:', eventType, 'Minimum allowed date:', calendarMinDate.toISOString().slice(0,10));
    // Set calendar to minimum allowed month/year
    calendarYear = calendarMinDate.getFullYear();
    calendarMonth = calendarMinDate.getMonth();
    calendarSelected = null;
    calendarSelectedTime = null;
    document.getElementById('calendarVenueName').textContent = venueName;
    document.getElementById('calendarSelectedDate').textContent = '';
    document.getElementById('calendarConfirmBtn').disabled = true;
    document.getElementById('timeSelection').style.display = 'none';
    document.getElementById('timeConflictWarning').style.display = 'none';
    document.getElementById('availabilityCalendarModal').style.display = 'flex';
    fetchAndRenderCalendar();
}

function closeAvailabilityCalendar() {
    document.getElementById('availabilityCalendarModal').style.display = 'none';
}

document.querySelector('.calendar-modal-close').onclick = closeAvailabilityCalendar;
document.getElementById('calendarPrev').onclick = function() {
    // Only allow going back if not at minimum month/year
    if (calendarYear > calendarMinDate.getFullYear() || (calendarYear === calendarMinDate.getFullYear() && calendarMonth > calendarMinDate.getMonth())) {
        calendarMonth--;
        if (calendarMonth < 0) {
            calendarMonth = 11;
            calendarYear--;
        }
        fetchAndRenderCalendar();
    }
};
document.getElementById('calendarNext').onclick = function() {
    calendarMonth++;
    if (calendarMonth > 11) {
        calendarMonth = 0;
        calendarYear++;
    }
    fetchAndRenderCalendar();
};

document.getElementById('calendarConfirmBtn').onclick = function() {
    if (calendarSelected) {
        document.getElementById('eventDate').value = calendarSelected;
        if (calendarSelectedTime) {
            document.getElementById('startTime').value = calendarSelectedTime.start;
            document.getElementById('endTime').value = calendarSelectedTime.end;
        }
        closeAvailabilityCalendar();
        document.getElementById('eventDate').dispatchEvent(new Event('change'));
    }
};

document.getElementById('calendarStartTime').onchange = validateTimeSelection;
document.getElementById('calendarEndTime').onchange = validateTimeSelection;

function validateTimeSelection() {
    const startTime = document.getElementById('calendarStartTime').value;
    const endTime = document.getElementById('calendarEndTime').value;
    const warning = document.getElementById('timeConflictWarning');
    const confirmBtn = document.getElementById('calendarConfirmBtn');
    if (!startTime || !endTime) {
        warning.style.display = 'none';
        confirmBtn.disabled = true;
        return;
    }
    if (startTime >= endTime) {
        warning.textContent = '⚠️ End time must be after start time';
        warning.style.display = 'block';
        confirmBtn.disabled = true;
        return;
    }
    const selectedDateBookings = calendarBookedDates.filter(b => b.date === calendarSelected);
    const hasConflict = selectedDateBookings.some(booking => {
        return (startTime < booking.end_time && endTime > booking.start_time);
    });
    if (hasConflict) {
        warning.textContent = '⚠️ This time conflicts with existing bookings';
        warning.style.display = 'block';
        confirmBtn.disabled = true;
    } else {
        warning.style.display = 'none';
        confirmBtn.disabled = false;
        calendarSelectedTime = { start: startTime, end: endTime };
    }
}

async function fetchAndRenderCalendar() {
    const grid = document.getElementById('calendarGrid');
    grid.innerHTML = '<div style="grid-column: span 7; text-align:center; padding: 32px 0; color: #888; font-size: 1.2rem;">Loading...</div>';
    const cacheKey = `${calendarVenueId}-${calendarYear}-${calendarMonth+1}`;
    if (calendarDataCache[cacheKey]) {
        const { unavailable, bookings } = calendarDataCache[cacheKey];
        calendarUnavailableDates = unavailable;
        calendarBookedDates = bookings;
        renderCalendarGrid();
        return;
    }
    const unavailableUrl = `/api/venues/unavailabilities?venue_id=${calendarVenueId}&year=${calendarYear}&month=${calendarMonth+1}`;
    const bookingsUrl = `/api/venues/bookings?venue_id=${calendarVenueId}&year=${calendarYear}&month=${calendarMonth+1}`;
    let unavailable = [];
    let bookings = [];
    try {
        const unavailableRes = await fetch(unavailableUrl);
        const unavailableData = await unavailableRes.json();
        if (unavailableData.success && Array.isArray(unavailableData.data)) {
            unavailable = unavailableData.data.map(u => u.date);
        }
        const bookingsRes = await fetch(bookingsUrl);
        const bookingsData = await bookingsRes.json();
        if (bookingsData.success && Array.isArray(bookingsData.data)) {
            bookings = bookingsData.data;
        }
    } catch (e) {
        console.error('Error fetching calendar data:', e);
        unavailable = [];
        bookings = [];
    }
    calendarDataCache[cacheKey] = { unavailable, bookings };
    calendarUnavailableDates = unavailable;
    calendarBookedDates = bookings;
    renderCalendarGrid();
}

function renderCalendarGrid() {
    const grid = document.getElementById('calendarGrid');
    grid.innerHTML = '';
    const monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    document.getElementById('calendarMonth').textContent = `${monthNames[calendarMonth]} ${calendarYear}`;
    // Disable prev button if at min month/year
    const prevBtn = document.getElementById('calendarPrev');
    if (calendarYear < calendarMinDate.getFullYear() || (calendarYear === calendarMinDate.getFullYear() && calendarMonth === calendarMinDate.getMonth())) {
        prevBtn.disabled = true;
    } else {
        prevBtn.disabled = false;
    }
    const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
    for (let d of days) {
        const el = document.createElement('div');
        el.textContent = d;
        el.style.fontWeight = 'bold';
        el.style.background = '#f3f3f3';
        el.style.borderRadius = '6px';
        el.style.padding = '6px 0';
        grid.appendChild(el);
    }
    const first = new Date(calendarYear, calendarMonth, 1);
    const startDay = first.getDay();
    const daysInMonth = new Date(calendarYear, calendarMonth+1, 0).getDate();
    for (let i=0; i<startDay; i++) {
        const blank = document.createElement('div');
        grid.appendChild(blank);
    }
    const today = new Date();
    for (let d=1; d<=daysInMonth; d++) {
        const date = new Date(calendarYear, calendarMonth, d);
        const ymd = `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2,'0')}-${String(date.getDate()).padStart(2,'0')}`;
        const dayEl = document.createElement('div');
        dayEl.className = 'calendar-day';
        dayEl.textContent = d;
        // Disable if before min date
        if (calendarMinDate && date < calendarMinDate) {
            dayEl.classList.add('unavailable');
        } else {
            // Check if date is unavailable (either marked unavailable or fully booked)
            const isUnavailable = calendarUnavailableDates.includes(ymd);
            const dateBookings = calendarBookedDates.filter(b => b.date === ymd);
            const isFullyBooked = dateBookings.length > 0 && dateBookings.every(b => 
                b.start_time === '00:00' && b.end_time === '23:59'
            );
            if (isUnavailable || isFullyBooked) {
                dayEl.classList.add('unavailable');
            } else {
                dayEl.onclick = function() {
                    grid.querySelectorAll('.calendar-day.selected').forEach(el => el.classList.remove('selected'));
                    dayEl.classList.add('selected');
                    calendarSelected = ymd;
                    const timeSelection = document.getElementById('timeSelection');
                    if (dateBookings.length > 0) {
                        timeSelection.style.display = 'block';
                        document.getElementById('calendarStartTime').value = '';
                        document.getElementById('calendarEndTime').value = '';
                        document.getElementById('timeConflictWarning').style.display = 'none';
                        document.getElementById('calendarConfirmBtn').disabled = true;
                        calendarSelectedTime = null;
                    } else {
                        timeSelection.style.display = 'none';
                        document.getElementById('calendarConfirmBtn').disabled = false;
                        calendarSelectedTime = null;
                    }
                    document.getElementById('calendarSelectedDate').textContent = `Selected: ${ymd}`;
                };
            }
        }
        if (date.toDateString() === today.toDateString() && calendarMonth === today.getMonth() && calendarYear === today.getFullYear()) {
            dayEl.classList.add('today');
        }
        if (calendarSelected === ymd) {
            dayEl.classList.add('selected');
        }
        grid.appendChild(dayEl);
    }
}

// Function to update church availability when event details change
async function updateChurchAvailability() {
    if (!churchGrid || churchGrid.children.length === 0) return;
    setChurchCardsLoadingState(true);
    const eventDate = document.getElementById('eventDate').value;
    const startTime = document.getElementById('startTime').value;
    const endTime = document.getElementById('endTime').value;
    if (!eventDate || !startTime || !endTime) { setChurchCardsLoadingState(false); return; }
    const churchCards = churchGrid.querySelectorAll('.venue-card');
    for (const card of churchCards) {
        const venueId = card.dataset.venueId;
        const isAvailable = await checkVenueAvailability(venueId, eventDate, startTime, endTime);
        card.classList.toggle('unavailable', !isAvailable);
        const availabilityStatus = card.querySelector('.availability-status');
        const availabilityText = card.querySelector('.availability-text');
        const checkAvailabilityBtn = availabilityStatus?.querySelector('.check-availability-btn');
        if (availabilityStatus && availabilityText) {
            availabilityStatus.style.display = 'block';
            if (!isAvailable) {
                availabilityText.textContent = 'Unavailable for selected date/time';
                availabilityText.style.color = '#dc3545';
                if (checkAvailabilityBtn) {
                    checkAvailabilityBtn.style.display = 'inline-block';
                    checkAvailabilityBtn.onclick = (e) => {
                        e.stopPropagation();
                        openAvailabilityCalendar(venueId, card.querySelector('.venue-title')?.textContent || 'Venue');
                    };
                }
            } else {
                availabilityText.textContent = 'Available';
                availabilityText.style.color = '#28a745';
                if (checkAvailabilityBtn) {
                    checkAvailabilityBtn.style.display = 'none';
                }
            }
        }
        card.classList.remove('loading');
        const overlay = card.querySelector('.venue-loading-overlay');
        if (overlay) overlay.style.display = 'none';
    }
}

// Add back button for church step
const backToEventType = document.getElementById('backToEventType');
if (backToEventType) {
    backToEventType.addEventListener('click', function() {
        // Hide church step, show event details step
        churchStep.style.display = 'none';
        // Go back to step 1
        currentStep = 1;
        updateStep();
    });
}

// Define the selectVenue function immediately and expose it globally
function selectVenue() {
    console.log('selectVenue function called'); // Debug log
    
    // Check if modal exists and has the venue ID
    if (!modal || !modal.dataset.currentVenueId) {
        console.error('Modal not found or no venue ID stored');
        console.log('Modal:', modal); // Debug log
        console.log('Modal dataset:', modal ? modal.dataset : 'Modal not found'); // Debug log
        showFormError('Unable to select venue. Please try again.');
        return;
    }
    
    // Get the venue ID from the modal
    const venueId = modal.dataset.currentVenueId;
    console.log('Venue ID from modal:', venueId); // Debug log
    
    if (venueId) {
        // Find the venue card and select it
        const venueCard = document.querySelector(`.venue-card[data-venue-id="${venueId}"]`);
        console.log('Found venue card:', venueCard); // Debug log
        
        if (venueCard) {
            // Remove selection from other cards
            document.querySelectorAll('.venue-card').forEach(c => c.classList.remove('selected'));
            
            // Select this venue card
            venueCard.classList.add('selected');
            selectedVenue = venueId;
            console.log('Venue selected successfully:', selectedVenue); // Debug log
            
            // Update pricing
            if (typeof calculateAndDisplayPricing === 'function') {
                calculateAndDisplayPricing();
            }
            
            // Close the modal
            closeModal();
            
            // Show success message
            showFormError('Venue selected successfully!');
        } else {
            console.error('Venue card not found for ID:', venueId);
            console.log('Available venue cards:', document.querySelectorAll('.venue-card')); // Debug log
            showFormError('Venue not found. Please try again.');
        }
    } else {
        console.error('No venue ID found in modal');
        showFormError('Unable to select venue. Please try again.');
    }
}

// Immediately expose selectVenue to global scope
window.selectVenue = selectVenue;

// Also add a fallback mechanism for when the function might not be available
if (typeof window.selectVenue === 'undefined') {
    window.selectVenue = function() {
        console.error('selectVenue function not properly loaded');
        showFormError('Please refresh the page and try again.');
    };
}

// Define other functions that need to be global
function getDirections() {
    if (!venueMapData) {
        showFormError('Venue location not available');
        return;
    }
    
    const { latitude, longitude, name } = venueMapData;
    
    // Create Google Maps directions URL
    const directionsUrl = `https://www.google.com/maps/dir/?api=1&destination=${latitude},${longitude}`;
    
    // Open in new tab
    window.open(directionsUrl, '_blank');
}

function closePackageModal() {
    const packageModal = document.getElementById('packageModal');
    if (packageModal) {
        packageModal.classList.remove('active');
        document.body.classList.remove('modal-open');
    }
}

function openPackageModal(packageId) {
    // Package modal functionality
    const packageModal = document.getElementById('packageModal');
    
    if (!packageModal) {
        console.error('Package modal not found');
        return;
    }
    
    (async () => {
        try {
            const response = await fetch(`/api/packages/${packageId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (!data.success) {
                throw new Error('Failed to fetch package details');
            }

            const package = data.data;

            // Update modal content
            const titleElement = document.querySelector('.package-modal-title');
            if (titleElement) {
                titleElement.textContent = package.title || 'Untitled Package';
            }
            
            const priceElement = document.querySelector('.package-modal-price');
            if (priceElement) {
                priceElement.textContent = `From ₱${new Intl.NumberFormat('en-PH').format(package.price || 0)}`;
            }

            const featuresHtml = package.features.map(feature => `
                <div class="package-modal-feature">
                    <span class="feature-icon">${feature.icon || '✓'}</span>
                    <div class="feature-content">
                        <div class="feature-title">${feature.title || 'Unnamed Feature'}</div>
                    </div>
                </div>
            `).join('');

            const featuresElement = document.querySelector('.package-modal-features');
            if (featuresElement) {
                featuresElement.innerHTML = featuresHtml;
            }

            // Show modal
            packageModal.classList.add('active');
            document.body.classList.add('modal-open');
        } catch (error) {
            console.error('Error loading package details:', error);
            showFormError('Failed to load package details. Please try again.');
        }
    })();
}

function selectPackage(packageId) {
    document.querySelectorAll('.package-card').forEach(card => {
        card.classList.remove('selected');
        if (card.dataset.package === packageId.toString()) {
            card.classList.add('selected');
            card.querySelector('input[type="radio"]').checked = true;
        }
    });
    
    // Update summary and pricing if functions exist
    if (typeof populateBookingSummary === 'function') {
        populateBookingSummary();
    }
    if (typeof calculateAndDisplayPricing === 'function') {
        calculateAndDisplayPricing();
    }
}

// Expose functions to global scope immediately
window.getDirections = getDirections;
window.closePackageModal = closePackageModal;
window.openPackageModal = openPackageModal;
window.selectPackage = selectPackage;

// Google Maps functionality
let venueMapData = null;

// Package selection
document.querySelectorAll('.package-card').forEach(card => {
    card.addEventListener('click', function () {
        document.querySelectorAll('.package-card').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
        this.querySelector('input[type="radio"]').checked = true;
    });
});

// Radio button styling
document.querySelectorAll('.radio-option').forEach(option => {
    option.addEventListener('click', function () {
        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;

        // Remove active class from siblings
        this.parentNode.querySelectorAll('.radio-option').forEach(opt => {
            opt.style.borderColor = '#e1e5e9';
            opt.style.background = 'white';
        });

        // Add active styling
        this.style.borderColor = '#667eea';
        this.style.background = 'rgba(102, 126, 234, 0.1)';
    });
});

// Step navigation
nextBtn.addEventListener('click', function() {
    // Remove the comments around the validation check
    if (validateCurrentStep()) {  // Add this validation check
        if (currentStep < totalSteps) {
            currentStep++;
            updateStep();
            
            // Reset venue steps when moving to next main step
            if (currentStep !== 2) {
                venueStep1.style.display = 'block';
                venueStep2.style.display = 'none';
            }
        } else {
            submitForm();
        }
    }  // Add this closing bracket
});

prevBtn.addEventListener('click', function () {
    if (currentStep > 1) {
        currentStep--;
        updateStep();

        // Reset venue steps when moving back to venue step
        if (currentStep === 2) {
            if (selectedVenueType) {
                venueStep1.style.display = 'none';
                venueStep2.style.display = 'block';
            } else {
                venueStep1.style.display = 'block';
                venueStep2.style.display = 'none';
            }
        }
    }
});

function updateStep() {
    // Update step indicators
    document.querySelectorAll('.step').forEach((step, index) => {
        const stepNum = index + 1;
        step.classList.remove('active', 'completed');

        if (stepNum === currentStep) {
            step.classList.add('active');
        } else if (stepNum < currentStep) {
            step.classList.add('completed');
        }
    });

    // Update step content
    document.querySelectorAll('.step-content').forEach((content, index) => {
        content.classList.remove('active');
        if (index + 1 === currentStep) {
            content.classList.add('active');

            // If this is the confirmation step, populate the summary
            if (index + 1 === 4) {
                populateBookingSummary();
            }
        }
    });

    // Update progress bar
    const progress = (currentStep / totalSteps) * 100;
    progressFill.style.width = progress + '%';

    // Update buttons
    prevBtn.disabled = currentStep === 1;
    nextBtn.textContent = currentStep === totalSteps ? 'Submit Booking' : 'Next Step';
}

function showFormError(message) {
    const errorDiv = document.getElementById('formError');
    if (errorDiv) {
        errorDiv.textContent = message;
        errorDiv.style.display = '';
        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

function hideFormError() {
    const errorDiv = document.getElementById('formError');
    if (errorDiv) {
        errorDiv.textContent = '';
        errorDiv.style.display = 'none';
    }
}

//Validation function commented out for testing
function validateCurrentStep() {
    hideFormError();
    const currentStepContent = document.querySelector(`.step-content[data-step="${currentStep}"]`);
    const requiredFields = currentStepContent.querySelectorAll('input[required], select[required], textarea[required]');
    
    let isValid = true;
    let firstInvalidField = null;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.style.borderColor = '#dc3545';
            field.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
            isValid = false;
            
            if (!firstInvalidField) {
                firstInvalidField = field;
            }
            
            field.addEventListener('input', function() {
                this.style.borderColor = '#e1e5e9';
                this.style.boxShadow = 'none';
            }, { once: true });
        }
    });

    // Special validation for venue selection in step 2
    if (currentStep === 2) {
        const eventType = document.getElementById('eventType').value;
        if ((eventType === 'wedding' || eventType === 'baptism')) {
            // Require church selection (by id, not by .selected class)
            let hasChurch = false;
            if (selectedChurch) {
                // Check if a card with this id exists in churchGrid
                const churchCard = churchGrid ? churchGrid.querySelector(`.venue-card[data-venue-id="${selectedChurch}"]`) : null;
                if (churchCard) hasChurch = true;
            }
            if (!hasChurch) {
                document.querySelectorAll('.venue-card', churchGrid).forEach(card => card.style.borderColor = '#dc3545');
                showFormError('Please select a church before proceeding');
                return false;
            }
            // Require reception selection
            const selectedReceptionCard = document.querySelector('.venue-card.selected') && venueStep2 && venueStep2.contains(document.querySelector('.venue-card.selected'))
                ? document.querySelector('.venue-card.selected')
                : null;
            if (!selectedReceptionCard) {
                document.querySelectorAll('.venue-card', document.querySelector('.venue-grid')).forEach(card => card.style.borderColor = '#dc3545');
                showFormError('Please select a reception venue before proceeding');
                return false;
            }
        }
        const venueTypeChecked = document.querySelector('input[name="venueType"]:checked');
        if (!venueTypeChecked) {
            document.querySelectorAll('.venue-type-btn').forEach(btn => {
                btn.style.borderColor = '#dc3545';
            });
            isValid = false;
            showFormError('Please select a venue type');
        }

        if (!selectedVenue) {
            document.querySelectorAll('.venue-card').forEach(card => {
                card.style.borderColor = '#dc3545';
            });
            isValid = false;

            // Show error message if on venue selection page
            if (venueStep2.style.display !== 'none') {
                showFormError('Please select a venue before proceeding');
            }
        }

        // If on first venue step, move to second step instead of next main step
        if (venueStep1.style.display !== 'none' && venueTypeChecked) {
            nextVenueStep.click();
            return false;
        }
    }

    // Special validation for package selection in step 3
    if (currentStep === 3) {
        const packageSelected = document.querySelector('input[name="package"]:checked');
        if (!packageSelected) {
            document.querySelectorAll('.package-card').forEach(card => {
                card.style.borderColor = '#dc3545';
            });
            isValid = false;
            showFormError('Please select a package before proceeding');
        }
    }

    // Additional validation for guest count in step 1
    if (currentStep === 1) {
        const guestCountInput = document.getElementById('guestCount');
        const guestCount = parseInt(guestCountInput.value, 10);
        if (isNaN(guestCount) || guestCount < 30) {
            guestCountInput.style.borderColor = '#dc3545';
            guestCountInput.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
            showFormError('Expected number of guests must be at least 30.');
            guestCountInput.focus();
            return false;
        }

        // Get event type before time validation!
        const eventType = document.getElementById('eventType').value;

        // Time validation
        const startTimeInput = document.getElementById('startTime');
        const endTimeInput = document.getElementById('endTime');
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;
        if (startTime && endTime) {
            // Parse times as minutes since midnight
            const [startHour, startMin] = startTime.split(':').map(Number);
            const [endHour, endMin] = endTime.split(':').map(Number);
            const startTotal = startHour * 60 + startMin;
            const endTotal = endHour * 60 + endMin;
            // No event can start or end between 12:00AM and 7:59AM
            if (startTotal < 480 || endTotal < 480) { // 480 = 8*60
                showFormError('No event can start or end before 8:00 AM.');
                startTimeInput.focus();
                return false;
            }
            // No event can end after 11:59PM
            if (endTotal > 1439) { // 1439 = 23*60+59
                showFormError('No event can end after 11:59 PM.');
                endTimeInput.focus();
                return false;
            }
            // End time must be after start time
            if (endTotal <= startTotal) {
                showFormError('End time must be after start time.');
                endTimeInput.focus();
                return false;
            }
            // Minimum duration by event type
            let minDuration = 180; // default 3 hours
            if (eventType === 'debut' || eventType === 'baptism') {
                minDuration = 120;
            } else if (eventType === 'birthday') {
                minDuration = 60;
            } else if (eventType === 'wedding') {
                minDuration = 180;
            }
            if (endTotal - startTotal < minDuration) {
                let minHourMsg = minDuration === 180 ? '3 hours' : minDuration === 120 ? '2 hours' : '1 hour';
                showFormError(`The minimum event duration for this event type is ${minHourMsg}.`);
                endTimeInput.focus();
                return false;
            }
        }

        // Date validation
        const eventDate = document.getElementById('eventDate').value;
        let minDate = '';
        const today = new Date();
        if (eventType === 'wedding') {
            const minWedding = new Date(today.getFullYear(), today.getMonth() + 3, today.getDate());
            minDate = minWedding.toISOString().split('T')[0];
        } else if (eventType === 'birthday') {
            const dayOfWeek = today.getDay();
            const daysUntilNextMonday = (8 - dayOfWeek) % 7;
            const nextMonday = new Date(today);
            nextMonday.setDate(today.getDate() + daysUntilNextMonday);
            const minBirthday = new Date(nextMonday);
            minBirthday.setDate(nextMonday.getDate() + 14);
            minDate = minBirthday.toISOString().split('T')[0];
        } else if (eventType === 'baptism' || eventType === 'debut') {
            const minOther = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
            minDate = minOther.toISOString().split('T')[0];
        }
        if (minDate && eventDate && eventDate < minDate) {
            const eventDateInput = document.getElementById('eventDate');
            eventDateInput.style.borderColor = '#dc3545';
            eventDateInput.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
            showFormError('Selected event date is too soon for this event type.');
            eventDateInput.focus();
            return false;
        }
    }

    // If validation failed, scroll to and focus the first invalid field
    if (!isValid && firstInvalidField) {
        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstInvalidField.focus();
        
        // Show general validation message
        if (currentStep === 1) {
            showFormError('Please fill in all required fields before proceeding');
        }
    }

    return isValid;
}


function submitForm() {
    const formData = {
        eventName: document.getElementById('eventName').value,
        eventType: document.getElementById('eventType').value,
        eventDate: document.getElementById('eventDate').value,
        startTime: document.getElementById('startTime').value,
        endTime: document.getElementById('endTime').value,
        guestCount: document.getElementById('guestCount').value,
        venueId: document.querySelector('.venue-card.selected')?.dataset.venueId,
        packageId: document.querySelector('input[name="package"]:checked')?.value,
        addons: Array.from(document.querySelectorAll('input[name="addons[]"]:checked')).map(cb => cb.value),
        venueNotes: document.getElementById('venueNotes').value,
        additionalNotes: document.getElementById('additionalNotes').value,
    };

    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]').content;

    // Send booking request
    fetch('/bookings', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hide form and show confirmation
            document.getElementById('bookingForm').style.display = 'none';
            const confirmation = document.getElementById('confirmation');
            confirmation.classList.remove('hidden');
            
            // Set booking reference
            document.getElementById('bookingRef').textContent = data.booking.reference;
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
             setTimeout(() => {
            window.location.href = '/';
        }, 5000);
        } else {
            showFormError(data.message || 'An error occurred while submitting your booking.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showFormError('An error occurred while submitting your booking. Please try again.');
    });
}


function populateBookingSummary() {
    // Event Details
    const eventTypeSummary = document.getElementById('eventType').value;
    document.getElementById('summaryEventType').textContent = eventTypeSummary ? eventTypeSummary.charAt(0).toUpperCase() + eventTypeSummary.slice(1) : 'Not selected';
    document.getElementById('summaryEventName').textContent = document.getElementById('eventName').value || 'Not specified';
    document.getElementById('summaryEventDate').textContent = document.getElementById('eventDate').value || 'Not selected';
    
    const startTime = document.getElementById('startTime').value;
    const endTime = document.getElementById('endTime').value;
    document.getElementById('summaryEventTime').textContent = startTime && endTime ? `${startTime} - ${endTime}` : 'Not specified';
    
    document.getElementById('summaryGuestCount').textContent = document.getElementById('guestCount').value || 'Not specified';

    // Venue Details
    const venueType = document.querySelector('input[name="venueType"]:checked');
    document.getElementById('summaryVenueType').textContent = venueType ? 
        venueType.parentElement.querySelector('.venue-type-label').textContent : 'Not selected';
    
    // Update Venue Name - Fix
    const selectedVenueCard = document.querySelector('.venue-card.selected');
    let summaryVenueName = '';
    if (eventTypeSummary === 'wedding' || eventTypeSummary === 'baptism') {
        // Find selected church and reception cards
        const selectedChurchCard = churchGrid && selectedChurch ? churchGrid.querySelector(`.venue-card[data-venue-id="${selectedChurch}"]`) : null;
        const selectedReceptionCard = selectedVenueCard && venueStep2 && venueStep2.contains(selectedVenueCard)
            ? selectedVenueCard
            : null;
        summaryVenueName += `<strong>Church:</strong> ${selectedChurchCard ? selectedChurchCard.querySelector('.venue-title').textContent : 'Not selected'}<br>`;
        summaryVenueName += `<strong>Reception:</strong> ${selectedReceptionCard ? selectedReceptionCard.querySelector('.venue-title').textContent : 'Not selected'}`;
    } else if (eventTypeSummary === 'birthday' || eventType === 'debut') {
        summaryVenueName += `<strong>Church:</strong> N/A<br>`;
        summaryVenueName += `<strong>Reception:</strong> ${selectedVenueCard ? selectedVenueCard.querySelector('.venue-title').textContent : 'Not selected'}`;
    } else {
        summaryVenueName = selectedVenueCard ? selectedVenueCard.querySelector('.venue-title').textContent : 'Not selected';
    }
    document.getElementById('summaryVenueType').innerHTML = '';
    document.getElementById('summaryVenueName').innerHTML = summaryVenueName || 'Not selected';
    
    const venueNotes = document.getElementById('venueNotes').value;
    document.getElementById('summaryVenueNotes').textContent = venueNotes || 'None';

    // Package & Services - Fix
    let selectedPackageCard = document.querySelector('.package-card.selected');
    if (!selectedPackageCard) {
        const checkedRadio = document.querySelector('input[name="package"]:checked');
        if (checkedRadio) {
            selectedPackageCard = checkedRadio.closest('.package-card');
        }
    }
    let packageTitle = '';
if (selectedPackageCard) {
        // Try to find .package-title anywhere inside
        const titleEl = selectedPackageCard.querySelector('.package-title');
        if (titleEl) {
            packageTitle = titleEl.textContent;
        }
    }
    document.getElementById('summaryPackage').textContent = packageTitle || 'Not selected';

    // Add-on Services
    const addonsList = document.getElementById('summaryAddons');
    addonsList.innerHTML = '';
    document.querySelectorAll('input[name="addons[]"]:checked').forEach(addon => {
        const li = document.createElement('li');
        // Robust: find the span inside the .addon-item parent
        const label = addon.closest('.addon-item');
        if (label) {
            const span = label.querySelector('span');
            if (span) li.textContent = span.textContent;
            else li.textContent = 'Add-on';
        } else {
            li.textContent = 'Add-on';
        }
        addonsList.appendChild(li);
    });
    if (addonsList.children.length === 0) {
        addonsList.innerHTML = '<li>No add-on services selected</li>';
    }

    // Dietary Requirements
    const dietary = document.getElementById('foodPreferences').value;
    document.getElementById('summaryDietary').textContent = dietary || 'None specified';

    // Calculate and display pricing
    calculateAndDisplayPricing();

    // Update summary to include church and reception as separate lines for wedding/baptism
    if ((eventTypeSummary === 'wedding' || eventTypeSummary === 'baptism') && selectedChurch) {
        let summaryVenueType = '';
        let totalVenue = 0;
        if (selectedChurchCard && churchPrice) {
            venueBreakdown += `<strong>Church:</strong> ₱${churchPrice.toLocaleString()}`;
            totalVenue += churchPrice;
        }
        if (selectedReceptionCard && receptionPrice) {
            if (venueBreakdown) venueBreakdown += '<br>';
            venueBreakdown += `<strong>Reception:</strong> ₱${receptionPrice.toLocaleString()}`;
            totalVenue += receptionPrice;
        }
        if (venueBreakdown) {
            venueBreakdown += `<br><strong>Total Venue Cost:</strong> ₱${totalVenue.toLocaleString()}`;
        }
        document.getElementById('summaryVenuePrice').innerHTML = venueBreakdown || '₱0';
    }
}

// Calculate and display pricing information
function calculateAndDisplayPricing() {
    let packagePrice = 0;
    let addonsPrice = 0;
    let venuePrice = 0;
    let churchPrice = 0;
    let receptionPrice = 0;

    // Get package price
    const selectedPackageCard = document.querySelector('.package-card.selected');
    if (selectedPackageCard) {
        const packagePriceText = selectedPackageCard.querySelector('.package-price').textContent;
        // Extract price from "From ₱X" format
        const priceMatch = packagePriceText.match(/₱([\d,]+)/);
        if (priceMatch) {
            packagePrice = parseInt(priceMatch[1].replace(/,/g, ''));
        }
    }

    // Get add-ons price from database
    const selectedAddons = document.querySelectorAll('input[name="addons[]"]:checked');
    addonsPrice = 0;
    selectedAddons.forEach(addon => {
        // Get addon price from the data attribute or use default
        const addonId = addon.value;
        const addonElement = addon.closest('.addon-item');
        if (addonElement && addonElement.dataset.price) {
            addonsPrice += parseFloat(addonElement.dataset.price);
        } else {
            // Fallback to default price if not available
            addonsPrice += 50;
        }
    });

    // Get venue prices for wedding/baptism (church + reception)
    const eventTypeSummary = document.getElementById('eventType').value;
    let selectedChurchCard = null;
    let selectedReceptionCard = null;
    if ((eventTypeSummary === 'wedding' || eventTypeSummary === 'baptism')) {
        // Find selected church card in churchGrid by selectedChurch variable
        selectedChurchCard = churchGrid && selectedChurch ? churchGrid.querySelector(`.venue-card[data-venue-id="${selectedChurch}"]`) : null;
        // Find selected reception card in venueStep2
        selectedReceptionCard = document.querySelector('.venue-card.selected') && venueStep2 && venueStep2.contains(document.querySelector('.venue-card.selected'))
            ? document.querySelector('.venue-card.selected')
            : null;
        if (selectedChurchCard && selectedChurchCard.dataset.venuePrice) {
            churchPrice = parseFloat(selectedChurchCard.dataset.venuePrice);
        }
        if (selectedReceptionCard && selectedReceptionCard.dataset.venuePrice) {
            receptionPrice = parseFloat(selectedReceptionCard.dataset.venuePrice);
        }
        venuePrice = churchPrice + receptionPrice;
    } else {
        // Get venue price from selected venue card (normal case)
        const selectedVenueCard = document.querySelector('.venue-card.selected');
        if (selectedVenueCard && selectedVenueCard.dataset.venuePrice) {
            venuePrice = parseFloat(selectedVenueCard.dataset.venuePrice);
        }
    }

    // Calculate total
    const totalPrice = packagePrice + addonsPrice + (eventTypeSummary === 'wedding' || eventTypeSummary === 'baptism' ? (churchPrice + receptionPrice) : venuePrice);

    // Display prices
    document.getElementById('summaryPackagePrice').textContent = `₱${packagePrice.toLocaleString()}`;
    document.getElementById('summaryAddonsPrice').textContent = `₱${addonsPrice.toLocaleString()}`;
    // Venue price breakdown for wedding/baptism
    if ((eventTypeSummary === 'wedding' || eventTypeSummary === 'baptism')) {
        let venueBreakdown = '';
        let totalVenue = 0;
        if (selectedChurchCard && churchPrice) {
            venueBreakdown += `<strong>Church:</strong> ₱${churchPrice.toLocaleString()}`;
            totalVenue += churchPrice;
        }
        if (selectedReceptionCard && receptionPrice) {
            if (venueBreakdown) venueBreakdown += '<br>';
            venueBreakdown += `<strong>Reception:</strong> ₱${receptionPrice.toLocaleString()}`;
            totalVenue += receptionPrice;
        }
        if (venueBreakdown) {
            venueBreakdown += `<br><strong>Total Venue Cost:</strong> ₱${totalVenue.toLocaleString()}`;
        }
        document.getElementById('summaryVenuePrice').innerHTML = venueBreakdown || '₱0';
    } else {
        document.getElementById('summaryVenuePrice').textContent = `₱${venuePrice.toLocaleString()}`;
    }
    document.getElementById('summaryTotalPrice').textContent = `₱${totalPrice.toLocaleString()}`;
}

// Initialize modal elements when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    modal = document.getElementById('venueModal');
    if (modal) {
        modalClose = modal.querySelector('.modal-close');
        
        // Add event listeners for modal
        if (modalClose) {
            modalClose.addEventListener('click', closeModal);
        }
        
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
        
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeModal();
            }
        });

        // Add event listener for venue selection button using event delegation
        modal.addEventListener('click', function(e) {
            console.log('Modal click event:', e.target); // Debug log
            console.log('Data action:', e.target.getAttribute('data-action')); // Debug log
            
            if (e.target && e.target.getAttribute('data-action') === 'select-venue') {
                console.log('Select venue button clicked!'); // Debug log
                e.preventDefault();
                e.stopPropagation();
                if (typeof selectVenue === 'function') {
                    selectVenue();
                } else {
                    console.error('selectVenue function not available');
                    showFormError('Please refresh the page and try again.');
                }
            }
        });
    }

    // Attach click handlers to static church cards (Blade-rendered)
    document.querySelectorAll('.church-grid .venue-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.classList.contains('view-more-btn')) {
                // Open modal for this church
                openVenueModal(card.dataset.venueId);
            } else {
                // Select this church
                document.querySelectorAll('.church-grid .venue-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                selectedChurch = card.dataset.venueId;
                nextChurchStep.disabled = false;
            }
        });
    });
});

// Define the functions first
// 1. Fetch venues function
async function fetchVenues(type) {
    try {
        console.log('Fetching venues for type:', type); // Debug log
        const response = await fetch(`/venues?type=${type}`);
        console.log('API Response status:', response.status); // Debug log

        const data = await response.json();
        console.log('Received data:', data); // Debug log

        if (!data.success) {
            throw new Error('Failed to fetch venues');
        }
        return data.data;
    } catch (error) {
        console.error('Error fetching venues:', error);
        return [];
    }
}

// 2. Populate venues function
async function populateVenues(type) {
    const venueGrid = document.querySelector('.venue-grid');
    console.log('Found venue grid:', venueGrid); // Debug log

    venueGrid.innerHTML = '<div class="loading">Loading venues...</div>';

    try {
        const venues = await fetchVenues(type);
        console.log('Venues to display:', venues); // Debug log

        if (!venues || venues.length === 0) {
            venueGrid.innerHTML = '<div class="error">No venues found for this type.</div>';
            return;
        }

        venueGrid.innerHTML = '';
        
        // Get current event details for availability checking
        const eventDate = document.getElementById('eventDate').value;
        const startTime = document.getElementById('startTime').value;
        const endTime = document.getElementById('endTime').value;

        // Check if we have all the required event details
        if (eventDate && startTime && endTime) {
            // Check availability for each venue
            for (const venue of venues) {
                const card = createVenueCard(venue);
                venueGrid.appendChild(card);
                
                // Show loading overlay
                card.classList.add('loading');
                const overlay = card.querySelector('.venue-loading-overlay');
                if (overlay) overlay.style.display = 'flex';
                // Check availability
                const isAvailable = await checkVenueAvailability(venue.id, eventDate, startTime, endTime);
                card.classList.toggle('unavailable', !isAvailable);
                const availabilityStatus = card.querySelector('.availability-status');
                const availabilityText = card.querySelector('.availability-text');
                const checkAvailabilityBtn = availabilityStatus?.querySelector('.check-availability-btn');
                
                if (availabilityStatus && availabilityText) {
                    availabilityStatus.style.display = 'block';
                    if (!isAvailable) {
                        availabilityText.textContent = 'Unavailable for selected date/time';
                        availabilityText.style.color = '#dc3545';
                        if (checkAvailabilityBtn) {
                            checkAvailabilityBtn.style.display = 'inline-block';
                            checkAvailabilityBtn.onclick = (e) => {
                                e.stopPropagation();
                                openAvailabilityCalendar(venue.id, venue.name);
                            };
                        }
                    } else {
                        availabilityText.textContent = 'Available';
                        availabilityText.style.color = '#28a745';
                        if (checkAvailabilityBtn) {
                            checkAvailabilityBtn.style.display = 'none';
                        }
                    }
                }
                card.classList.remove('loading');
                if (overlay) overlay.style.display = 'none';
            }
        } else {
            // If event details are not complete, just show venues without availability
        venues.forEach(venue => {
            const card = createVenueCard(venue);
            venueGrid.appendChild(card);
        });
        }
    } catch (error) {
        console.error('Error in populateVenues:', error);
        venueGrid.innerHTML = '<div class="error">Failed to load venues. Please try again.</div>';
    }
}

// Function to check venue availability
async function checkVenueAvailability(venueId, date, startTime, endTime) {
    try {
        const response = await fetch('/api/venues/check-availability', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                venue_id: venueId,
                date: date,
                start_time: startTime,
                end_time: endTime
            })
        });

        const data = await response.json();
        return data.success ? data.data.is_available : false;
    } catch (error) {
        console.error('Error checking venue availability:', error);
        return false;
    }
}

// 3. Create venue card function
function createVenueCard(venue, type = null) {
    const card = document.createElement('div');
    card.className = 'venue-card loading'; // Add loading class initially
    card.dataset.venueId = venue.id;
    card.dataset.venuePrice = venue.price_range;
    card.style.position = 'relative';

    const venueTypeDisplay = {
        'indoor': 'Indoor Venue',
        'outdoor': 'Outdoor Venue',
        'both': 'Indoor & Outdoor Venue',
        'church': 'Church'
    }[venue.type];

    // Format price for display
    const price = parseFloat(venue.price_range);
    const formattedPrice = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    }).format(price);

    card.innerHTML = `
        <img src="${venue.main_image}" alt="${venue.name}" class="venue-image">
        <span class="venue-tag">${venueTypeDisplay || ''}</span>
        <div class="venue-content">
            <h3 class="venue-title">${venue.name}</h3>
            <p class="venue-description">${venue.description}</p>
            <div class="venue-actions">
                <div class="venue-info">
                    <span>Capacity: ${venue.capacity}</span>
                    <span class="venue-price">${formattedPrice}</span>
                </div>
                <button type="button" class="view-more-btn">View Details</button>
            </div>
            <div class="availability-status" style="display: none;">
                <span class="availability-text"></span>
                <button type="button" class="check-availability-btn" style="display: none; margin-top: 8px; padding: 6px 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                    📅 Check Availability
                </button>
            </div>
        </div>
    `;
    // Add loading overlay as a direct child of the card
    const overlay = document.createElement('div');
    overlay.className = 'venue-loading-overlay';
    overlay.style = 'display: none; position: absolute; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.7); z-index:2; align-items:center; justify-content:center;';
    overlay.innerHTML = '<div class="spinner" style="border: 3px solid #eee; border-top: 3px solid #1976d2; border-radius: 50%; width: 28px; height: 28px; animation: spin 1s linear infinite;"></div>';
    card.appendChild(overlay);

    // Add click handlers
    card.addEventListener('click', function (e) {
        if (card.classList.contains('loading')) return; // Prevent selection while loading
        if (e.target.classList.contains('view-more-btn')) {
            openVenueModal(venue.id);
        } else {
            if (this.classList.contains('unavailable')) {
                showFormError('This venue is not available for the selected date and time. Please choose a different date/time or venue.');
                return;
            }
            if (churchStep && churchStep.style.display !== 'none' && churchGrid && churchGrid.contains(this)) {
                document.querySelectorAll('.venue-card', churchGrid).forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedChurch = venue.id;
                nextChurchStep.disabled = false;
            } else {
                document.querySelectorAll('.venue-card', document.querySelector('.venue-grid')).forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedVenue = venue.id;
                calculateAndDisplayPricing();
            }
        }
    });

    return card;
}

// Patch for static church cards (Blade): add loading overlay as direct child of card
function setChurchCardsLoadingState(loading) {
    document.querySelectorAll('.church-grid .venue-card').forEach(card => {
        if (loading) {
            card.classList.add('loading');
            let overlay = card.querySelector('.venue-loading-overlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.className = 'venue-loading-overlay';
                overlay.style = 'position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(255,255,255,0.7);z-index:2;display:flex;align-items:center;justify-content:center;';
                overlay.innerHTML = '<div class="spinner" style="border: 3px solid #eee; border-top: 3px solid #1976d2; border-radius: 50%; width: 28px; height: 28px; animation: spin 1s linear infinite;"></div>';
                card.appendChild(overlay);
            } else {
                overlay.style.display = 'flex';
            }
        } else {
            card.classList.remove('loading');
            const overlay = card.querySelector('.venue-loading-overlay');
            if (overlay) overlay.style.display = 'none';
        }
    });
}

// Function to update venue availability when event details change
async function updateVenueAvailability() {
    const venueGrid = document.querySelector('.venue-grid');
    if (!venueGrid || venueGrid.children.length === 0) return;

    const eventDate = document.getElementById('eventDate').value;
    const startTime = document.getElementById('startTime').value;
    const endTime = document.getElementById('endTime').value;

    if (!eventDate || !startTime || !endTime) return;

    const venueCards = venueGrid.querySelectorAll('.venue-card');
    
    for (const card of venueCards) {
        const venueId = card.dataset.venueId;
        const isAvailable = await checkVenueAvailability(venueId, eventDate, startTime, endTime);
        
        // Update styling
        card.classList.toggle('unavailable', !isAvailable);
        
        const availabilityStatus = card.querySelector('.availability-status');
        const availabilityText = card.querySelector('.availability-text');
        
        if (availabilityStatus && availabilityText) {
            availabilityStatus.style.display = 'block';
            const checkAvailabilityBtn = availabilityStatus.querySelector('.check-availability-btn');
            
            if (!isAvailable) {
                availabilityText.textContent = 'Unavailable for selected date/time';
                availabilityText.style.color = '#dc3545';
                if (checkAvailabilityBtn) {
                    checkAvailabilityBtn.style.display = 'inline-block';
                    checkAvailabilityBtn.onclick = (e) => {
                        e.stopPropagation();
                        openAvailabilityCalendar(venueId, card.querySelector('.venue-title')?.textContent || 'Venue');
                    };
                }
            } else {
                availabilityText.textContent = 'Available';
                availabilityText.style.color = '#28a745';
                if (checkAvailabilityBtn) {
                    checkAvailabilityBtn.style.display = 'none';
                }
            }
        }
    }
}

// Then add the event listeners
// 1. Venue type selection
document.querySelectorAll('.venue-type-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        console.log('Venue type selected:', this.dataset.venueType); // Debug log
        document.querySelectorAll('.venue-type-btn').forEach(b => b.classList.remove('selected'));
        this.classList.add('selected');
        this.querySelector('input[type="radio"]').checked = true;
        selectedVenueType = this.dataset.venueType;
        nextVenueStep.disabled = false;
    });
     populateBookingSummary();
});

// 2. Next step button
nextVenueStep.addEventListener('click', () => {
    console.log('Next step clicked, selectedVenueType:', selectedVenueType); // Debug log
    if (selectedVenueType) {
        venueStep1.style.display = 'none';
        venueStep2.style.display = 'block';
        populateVenues(selectedVenueType);
    }
});

// 3. Back button
backToVenueType.addEventListener('click', () => {
    venueStep2.style.display = 'none';
    venueStep1.style.display = 'block';
});

// Modal related functions and event listeners
async function openVenueModal(venueId) {
    // Check if modal is properly initialized
    if (!modal) {
        console.error('Modal not initialized');
        showFormError('Unable to open venue details. Please refresh the page and try again.');
        return;
    }

    try {
        const response = await fetch(`/venues/${venueId}`);
        const data = await response.json();
        if (!data.success) {
            throw new Error('Failed to fetch venue details');
        }
        const venue = data.data;

        // Store the venue ID in the modal's dataset for the selectVenue function
        modal.dataset.currentVenueId = venueId;

        // Update modal content
        const modalImage = document.getElementById('modalVenueImage');
        if (modalImage) {
            modalImage.src = venue.main_image; // Use the same logic as venue grid
            modalImage.alt = venue.name || 'Venue Image'; // Add fallback alt text
        }

        const modalTitle = document.getElementById('modalVenueTitle');
        if (modalTitle) {
            modalTitle.textContent = venue.name;
        }

        const modalType = document.getElementById('modalVenueType');
        if (modalType) {
            modalType.textContent = venue.type.charAt(0).toUpperCase() + venue.type.slice(1);
        }

        const modalCapacity = document.getElementById('modalVenueCapacity');
        if (modalCapacity) {
            modalCapacity.textContent = venue.capacity;
        }
        
        // Format and display actual price
        const price = parseFloat(venue.price_range);
        const formattedPrice = new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP'
        }).format(price);
        
        const modalPrice = document.getElementById('modalVenuePrice');
        if (modalPrice) {
            modalPrice.textContent = formattedPrice;
        }

        // Update spaces with proper null checks
        const spacesContainer = document.getElementById('modalVenueSpaces');
        if (spacesContainer) {
            if (venue.spaces && venue.spaces.length > 0) {
                spacesContainer.innerHTML = venue.spaces.map(space => `
                    <div class="space-item">
                        <div class="space-item-type">${space.type || 'Unknown'}</div>
                        <div class="space-item-name">${space.name || 'Unnamed Space'}</div>
                        <div class="space-item-capacity">Up to ${space.capacity || 0} guests</div>
                    </div>
                `).join('');
            } else {
                spacesContainer.innerHTML = '<p>No specific spaces available</p>';
            }
        }

        // Update gallery with proper path handling
        const galleryContainer = document.querySelector('.venue-gallery');
        if (galleryContainer) {
            if (venue.gallery && venue.gallery.length > 0) {
                galleryContainer.innerHTML = venue.gallery.map(item => `
                    <img src="${item.image_path}" class="gallery-img" alt="Venue Image">
                `).join('');
            } else {
                galleryContainer.innerHTML = '<p>No gallery images available</p>';
            }
        }

        // Initialize map if venue has coordinates
        const mapContainer = document.getElementById('modalVenueMap');
        if (mapContainer) {
            if (venue.latitude && venue.longitude) {
                showVenueMap(venue.latitude, venue.longitude, venue.name);
            } else {
                mapContainer.innerHTML = '<p>Location map not available</p>';
            }
        }

        // Show modal
        modal.classList.add('active');
        document.body.classList.add('modal-open');
      
    } catch (error) {
        console.error('Error loading venue details:', error);
        showFormError('Failed to load venue details. Please try again.');
    }
}

function closeModal() {
    if (modal) {
        modal.classList.remove('active');
        document.body.classList.remove('modal-open');
    }
}

// Show venue location with iframe map (no API key required)
function showVenueMap(latitude, longitude, venueName) {
    const mapContainer = document.getElementById('modalVenueMap');
    
    // Clear existing content
    mapContainer.innerHTML = '';
    
    // Create iframe for OpenStreetMap (no API key required)
    const iframe = document.createElement('iframe');
    // Fix coordinate formatting - ensure proper decimal places and separation
    const lat = parseFloat(latitude).toFixed(6);
    const lng = parseFloat(longitude).toFixed(6);
    const bboxWest = (parseFloat(longitude) - 0.01).toFixed(6);
    const bboxSouth = (parseFloat(latitude) - 0.01).toFixed(6);
    const bboxEast = (parseFloat(longitude) + 0.01).toFixed(6);
    const bboxNorth = (parseFloat(latitude) + 0.01).toFixed(6);
    
    iframe.src = `https://www.openstreetmap.org/export/embed.html?bbox=${bboxWest},${bboxSouth},${bboxEast},${bboxNorth}&layer=mapnik&marker=${lat},${lng}`;
    iframe.style.width = '100%';
    iframe.style.height = '300px';
    iframe.style.border = '0';
    iframe.style.borderRadius = '12px';
    iframe.allowFullscreen = true;
    iframe.loading = 'lazy';
    iframe.referrerPolicy = 'no-referrer-when-downgrade';
    
    // Add fallback content if iframe fails to load
    iframe.onerror = () => {
        showFallbackLocation(latitude, longitude, venueName);
    };
    
    mapContainer.appendChild(iframe);
    
    // Store venue data for directions
    venueMapData = { latitude, longitude, name: venueName };
}

// Fallback location display
function showFallbackLocation(latitude, longitude, venueName) {
    const mapContainer = document.getElementById('modalVenueMap');
    mapContainer.innerHTML = `
        <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 12px; border: 2px dashed #dee2e6;">
            <h4 style="margin-bottom: 15px; color: #333;">📍 Venue Location</h4>
            <p style="margin-bottom: 10px; font-weight: 600; color: #555;">${venueName}</p>
            <p style="margin-bottom: 8px; color: #666;">Coordinates: ${latitude}, ${longitude}</p>
            <div style="margin: 15px 0; padding: 15px; background: #fff; border-radius: 8px; border: 1px solid #e1e5e9;">
                <p style="margin: 0; color: #666; font-size: 14px;">
                    <strong>📍 Location Details:</strong><br>
                    Latitude: ${latitude}<br>
                    Longitude: ${longitude}
                </p>
            </div>
            <button type="button" class="btn btn-primary" onclick="getDirections()" style="margin-top: 10px;">
                🗺️ Get Directions
            </button>
        </div>
    `;
    
    // Store venue data for directions
    venueMapData = { latitude, longitude, name: venueName };
}

// Update packages when event type changes
const eventDateInput = document.getElementById('eventDate');
document.getElementById('eventType').addEventListener('change', function () {
    const eventType = this.value;
    loadPackagesForEventType(eventType);

    // Set minimum event date based on event type
    let minDate = '';
    const today = new Date();
    if (eventType === 'wedding') {
        // 3 months from today
        const minWedding = new Date(today.getFullYear(), today.getMonth() + 3, today.getDate());
        minDate = minWedding.toISOString().split('T')[0];
    } else if (eventType === 'birthday') {
        // 2 full weeks from next Monday
        const dayOfWeek = today.getDay();
        const daysUntilNextMonday = (8 - dayOfWeek) % 7;
        const nextMonday = new Date(today);
        nextMonday.setDate(today.getDate() + daysUntilNextMonday);
        const minBirthday = new Date(nextMonday);
        minBirthday.setDate(nextMonday.getDate() + 14);
        minDate = minBirthday.toISOString().split('T')[0];
    } else if (eventType === 'baptism' || eventType === 'debut') {
        // 1 month from today
        const minOther = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
        minDate = minOther.toISOString().split('T')[0];
    } else {
        minDate = '';
    }
    if (eventDateInput) {
        eventDateInput.min = minDate;
        if (eventDateInput.value && eventDateInput.value < minDate) {
            eventDateInput.value = '';
        }
    }

    // Clear any selected package when event type changes
    document.querySelectorAll('.package-card').forEach(c => c.classList.remove('selected'));
    document.querySelectorAll('input[name="package"]').forEach(input => input.checked = false);
    
    // Update pricing
    calculateAndDisplayPricing();

    // Show/hide church step based on event type
    handleEventTypeChange();
});

// Add event listeners for addon changes
document.addEventListener('change', function(e) {
    if (e.target.name === 'addons[]') {
        calculateAndDisplayPricing();
    }
});

// Close modal on escape key
window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && packageModal.classList.contains('active')) {
        closePackageModal();
    }
});

// Close modal on outside click
packageModal.addEventListener('click', (e) => {
    if (e.target === packageModal) {
        closePackageModal();
    }
});

// Add fetchPackages function
async function fetchPackages(eventType) {
    try {
        const response = await fetch(`/api/packages?type=${eventType}`);
        const data = await response.json();
        if (!data.success) throw new Error('Failed to fetch packages');
        return data.data;
    } catch (error) {
        console.error('Error fetching packages:', error);
        return [];
    }
}

async function loadPackagesForEventType(eventType) {
    const packagesContainer = document.querySelector('.packages');

    if (!eventType) {
        packagesContainer.innerHTML = `
            <div class="no-packages-message" style="text-align: center; padding: 20px;">
                Please select an event type to view available packages
            </div>`;
        return;
    }

    try {
        // Show loading state
        packagesContainer.innerHTML = `
            <div class="loading">Loading packages...</div>
        `;

        // FIX: Use fetchPackages instead of fetchVenues
        const packages = await fetchPackages(eventType);

        if (!packages || packages.length === 0) {
            packagesContainer.innerHTML = '<div class="error">No packages found for this type.</div>';
            return;
        }

        packagesContainer.innerHTML = '';
        packages.forEach(package => {
            const card = createPackageCard(package);
            packagesContainer.appendChild(card);
        });

        // Add click and change handler for package selection
        document.querySelectorAll('.package-card').forEach(card => {
            // Card click
            card.addEventListener('click', function () {
                document.querySelectorAll('.package-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input[type="radio"]').checked = true;
                if (typeof populateBookingSummary === 'function') {
                    populateBookingSummary();
                }
            });
            // Radio change
            const radio = card.querySelector('input[type="radio"]');
            if (radio) {
                radio.addEventListener('change', function(e) {
                    document.querySelectorAll('.package-card').forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                    if (typeof populateBookingSummary === 'function') {
                        populateBookingSummary();
                    }
                });
            }
        });

        // After creating package cards in loadPackagesForEventType, add this:
        document.querySelectorAll('.package-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.package-card').forEach(c => c.classList.remove('selected'));
                const card = this.closest('.package-card');
                if (card) card.classList.add('selected');
                if (typeof populateBookingSummary === 'function') {
                    populateBookingSummary();
                }
            });
        });
    } catch (error) {
        console.error('Error in loadPackagesForEventType:', error);
        packagesContainer.innerHTML = '<div class="error">Failed to load packages. Please try again.</div>';
    }
}

function createPackageCard(package) {
    const card = document.createElement('div');
    card.className = 'venue-card package-card';
    card.dataset.package = package.id;

    card.innerHTML = `
        <label style="width:100%;height:100%;display:block;cursor:pointer;">
            <input type="radio" name="package" value="${package.id}" class="package-radio" style="position:absolute;opacity:0;width:0;height:0;">
            <span class="venue-tag">Package</span>
            <div class="venue-content">
                <h3 class="package-title">${package.title || 'Untitled Package'}</h3>
                <p class="venue-description">${package.description || 'No description available'}</p>
                <div class="venue-actions">
                    <div class="venue-info">
                        <span class="package-price">From ₱${new Intl.NumberFormat('en-PH').format(package.price || 0)}</span>
                    </div>
                    <button type="button" class="view-more-btn">View Details</button>
                </div>
            </div>
        </label>
    `;

    // Add click handler for view details
    card.querySelector('.view-more-btn').addEventListener('click', function(e) {
        e.stopPropagation();
        e.preventDefault();
        openPackageModal(package.id);
    });

    return card;
}

function handleEventTypeChange() {
    const eventType = document.getElementById('eventType').value;
    if (eventType === 'wedding' || eventType === 'baptism') {
        churchStep.style.display = 'block';
        venueStep1.style.display = 'none';
        venueStep2.style.display = 'none';
    } else {
        churchStep.style.display = 'none';
        venueStep1.style.display = 'block';
        venueStep2.style.display = 'none';
    }
}

// When clicking 'Continue to Reception Selection' after church selection
if (nextChurchStep) {
    nextChurchStep.addEventListener('click', function() {
        churchStep.style.display = 'none';
        venueStep1.style.display = 'block';
        venueStep2.style.display = 'none';
    });
}

// When clicking 'Back to Church Selection' from venue type
const backToChurchFromVenueType = document.getElementById('backToChurchFromVenueType');
if (backToChurchFromVenueType) {
    backToChurchFromVenueType.addEventListener('click', function() {
        venueStep1.style.display = 'none';
        venueStep2.style.display = 'none';
        churchStep.style.display = 'block';
    });
}

// Add event listeners for date and time changes to update venue availability
document.addEventListener('DOMContentLoaded', function() {
    const eventDateInput = document.getElementById('eventDate');
    const startTimeInput = document.getElementById('startTime');
    const endTimeInput = document.getElementById('endTime');

    if (eventDateInput) {
        eventDateInput.addEventListener('change', function() {
            updateVenueAvailability();
            updateChurchAvailability();
        });
    }
    if (startTimeInput) {
        startTimeInput.addEventListener('change', function() {
            updateVenueAvailability();
            updateChurchAvailability();
        });
    }
    if (endTimeInput) {
        endTimeInput.addEventListener('change', function() {
            updateVenueAvailability();
            updateChurchAvailability();
        });
    }

    // Initialize availability checking for churches if event details are already filled
    setTimeout(() => {
        const eventDate = eventDateInput?.value;
        const startTime = startTimeInput?.value;
        const endTime = endTimeInput?.value;
        
        if (eventDate && startTime && endTime) {
            updateChurchAvailability();
        }
    }, 1000);
});

// Add spinner keyframes
const style = document.createElement('style');
style.innerHTML = `@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }`;
document.head.appendChild(style);