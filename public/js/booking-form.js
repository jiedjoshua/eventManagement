
let currentStep = 1;
const totalSteps = 4;

const nextBtn = document.getElementById('nextBtn');
const prevBtn = document.getElementById('prevBtn');
const progressFill = document.getElementById('progressFill');
const form = document.getElementById('bookingForm');
const confirmation = document.getElementById('confirmation');

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

 
 //Validation function commented out for testing
function validateCurrentStep() {
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
        const venueTypeChecked = document.querySelector('input[name="venueType"]:checked');
        if (!venueTypeChecked) {
            document.querySelectorAll('.venue-type-btn').forEach(btn => {
                btn.style.borderColor = '#dc3545';
            });
            isValid = false;
            alert('Please select a venue type');
        }

        if (!selectedVenue) {
            document.querySelectorAll('.venue-card').forEach(card => {
                card.style.borderColor = '#dc3545';
            });
            isValid = false;

            // Show error message if on venue selection page
            if (venueStep2.style.display !== 'none') {
                alert('Please select a venue before proceeding');
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
            alert('Please select a package before proceeding');
        }
    }

    // If validation failed, scroll to and focus the first invalid field
    if (!isValid && firstInvalidField) {
        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstInvalidField.focus();
        
        // Show general validation message
        if (currentStep === 1) {
            alert('Please fill in all required fields before proceeding');
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
            alert(data.message || 'An error occurred while submitting your booking.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting your booking. Please try again.');
    });
}


function populateBookingSummary() {
    // Event Details
    const eventType = document.getElementById('eventType');
    document.getElementById('summaryEventType').textContent = eventType.options[eventType.selectedIndex]?.text || 'Not selected';
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
    document.getElementById('summaryVenueName').textContent = selectedVenueCard ? 
        selectedVenueCard.querySelector('.venue-title').textContent : 'Not selected';
    
    const venueNotes = document.getElementById('venueNotes').value;
    document.getElementById('summaryVenueNotes').textContent = venueNotes || 'None';

    // Package & Services - Fix
   const selectedPackageCard = document.querySelector('.package-card.selected');
if (selectedPackageCard) {
    const packageTitle = selectedPackageCard.querySelector('.package-title').textContent;
    // Remove the price part, just use the title
    document.getElementById('summaryPackage').textContent = packageTitle;
} else {
    document.getElementById('summaryPackage').textContent = 'Not selected';
}

    // Add-on Services
    const addonsList = document.getElementById('summaryAddons');
    addonsList.innerHTML = '';
    document.querySelectorAll('input[name="addons[]"]:checked').forEach(addon => {
        const li = document.createElement('li');
        li.textContent = addon.nextElementSibling.textContent;
        addonsList.appendChild(li);
    });
    if (addonsList.children.length === 0) {
        addonsList.innerHTML = '<li>No add-on services selected</li>';
    }

    // Dietary Requirements
    const dietary = document.getElementById('foodPreferences').value;
    document.getElementById('summaryDietary').textContent = dietary || 'None specified';
}



// First declare all the variables and constants
let selectedVenue = null;
let selectedVenueType = null;
const modal = document.getElementById('venueModal');
const modalClose = modal.querySelector('.modal-close');
const venueStep1 = document.getElementById('venueStep1');
const venueStep2 = document.getElementById('venueStep2');
const nextVenueStep = document.getElementById('nextVenueStep');
const backToVenueType = document.getElementById('backToVenueType');

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
        venues.forEach(venue => {
            const card = createVenueCard(venue);
            venueGrid.appendChild(card);
        });
    } catch (error) {
        console.error('Error in populateVenues:', error);
        venueGrid.innerHTML = '<div class="error">Failed to load venues. Please try again.</div>';
    }
}

// 3. Create venue card function
function createVenueCard(venue) {
    const card = document.createElement('div');
    card.className = 'venue-card';
    card.dataset.venueId = venue.id;

    const venueTypeDisplay = {
        'indoor': 'Indoor Venue',
        'outdoor': 'Outdoor Venue',
        'both': 'Indoor & Outdoor Venue'
    }[venue.type];

    card.innerHTML = `
        <img src="${venue.main_image}" alt="${venue.name}" class="venue-image">
        <span class="venue-tag">${venueTypeDisplay}</span>
        <div class="venue-content">
            <h3 class="venue-title">${venue.name}</h3>
            <p class="venue-description">${venue.description}</p>
            <div class="venue-actions">
                <span>Capacity: ${venue.capacity}</span>
                <button type="button" class="view-more-btn">View Details</button>
            </div>
        </div>
    `;

    // Add click handlers
    card.addEventListener('click', function (e) {
        if (e.target.classList.contains('view-more-btn')) {
            openVenueModal(venue.id);
        } else {
            document.querySelectorAll('.venue-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            selectedVenue = venue.id;
        }
    });

    return card;
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
    try {
        const response = await fetch(`/venues/${venueId}`);
        const data = await response.json();
        if (!data.success) {
            throw new Error('Failed to fetch venue details');
        }
        const venue = data.data;

        // Update modal content
        const modalImage = document.getElementById('modalVenueImage');
        modalImage.src = `/${venue.main_image}`; // Add forward slash to make path relative to root
        modalImage.alt = venue.name || 'Venue Image'; // Add fallback alt text

        document.getElementById('modalVenueTitle').textContent = venue.name;
        document.getElementById('modalVenueType').textContent =
            venue.type.charAt(0).toUpperCase() + venue.type.slice(1);
        document.getElementById('modalVenueCapacity').textContent = venue.capacity;
        document.getElementById('modalVenuePrice').textContent = venue.price_range;
        document.getElementById('modalVenueRating').textContent = venue.rating;

        // Update spaces
        const spacesContainer = document.getElementById('modalVenueSpaces');
        spacesContainer.innerHTML = venue.spaces.map(space => `
            <div class="space-item">
                <div class="space-item-icon">${space.icon}</div>
                <div class="space-item-name">${space.name}</div>
                <div class="space-item-capacity">Up to ${space.capacity} guests</div>
            </div>
        `).join('');

        // Update gallery with proper path handling
        const galleryContainer = document.querySelector('.venue-gallery');
        galleryContainer.innerHTML = venue.gallery.map(item => `
            <img src="/${item.image_path}" class="gallery-img" alt="Venue Image">
        `).join('');

        // Show modal
        modal.classList.add('active');
      
    } catch (error) {
        console.error('Error loading venue details:', error);
        alert('Failed to load venue details. Please try again.');
    }
}

function closeModal() {
    modal.classList.remove('active');
}

modalClose.addEventListener('click', closeModal);

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



// Package modal functionality
const packageModal = document.getElementById('packageModal');

async function openPackageModal(packageId) {
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
        document.querySelector('.package-modal-title').textContent = package.title || 'Untitled Package';
        document.querySelector('.package-modal-price').textContent = `From $${new Intl.NumberFormat('en-US').format(package.price || 0)}`;

        const featuresHtml = package.features.map(feature => `
            <div class="package-modal-feature">
                <span class="feature-icon">${feature.icon || '✓'}</span>
                <div class="feature-content">
                    <div class="feature-title">${feature.title || 'Unnamed Feature'}</div>
                </div>
            </div>
        `).join('');

        document.querySelector('.package-modal-features').innerHTML = featuresHtml;

        // Show modal
        packageModal.classList.add('active');
        document.body.classList.add('modal-open');
    } catch (error) {
        console.error('Error loading package details:', error);
        alert('Failed to load package details. Please try again.');
    }
}

function closePackageModal() {
    packageModal.classList.remove('active');
    document.body.classList.remove('modal-open');
}

function selectPackage(packageId) {
    document.querySelectorAll('.package-card').forEach(card => {
        card.classList.remove('selected');
        if (card.dataset.package === packageId.toString()) {
            card.classList.add('selected');
            card.querySelector('input[type="radio"]').checked = true;
        }
    });
     populateBookingSummary();
}

// Update packages when event type changes
document.getElementById('eventType').addEventListener('change', function () {
    const eventType = this.value;
    loadPackagesForEventType(eventType);

    // Clear any selected package when event type changes
    document.querySelectorAll('.package-card').forEach(c => c.classList.remove('selected'));
    document.querySelectorAll('input[name="package"]').forEach(input => input.checked = false);
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
            <div class="loading-message" style="text-align: center; padding: 20px;">
                Loading packages...
            </div>`;

        const response = await fetch(`/api/packages?type=${eventType}`, {
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
            throw new Error('Failed to fetch packages');
        }

        // Extract packages from the response data
        const packages = data.data || [];

        // Add this debug line
        console.log('Packages received:', packages);

        if (packages.length === 0) {
            packagesContainer.innerHTML = `
                <div class="no-packages-message" style="text-align: center; padding: 20px;">
                    No packages available for this event type
                </div>`;
            return;
        }

        packagesContainer.innerHTML = packages.map(package => `
    <div class="package-card" data-package="${package.id}">
        <div class="package-title">${package.title || 'Untitled Package'}</div>
        <div class="package-price">From $${new Intl.NumberFormat('en-US').format(package.price || 0)}</div>
        <p class="package-description">${package.description || 'No description available'}</p>
        <div class="package-features">
            ${(package.features || []).map(feature => `
                <div class="package-feature">
                    <i>${feature.icon || '✓'}</i>
                    <span>${feature.title || 'Unnamed Feature'}</span>
                </div>
            `).join('')}
        </div>
        <div class="package-actions">
            <button type="button" class="package-btn view-btn" onclick="openPackageModal(${package.id})">View Details</button>
            <button type="button" class="package-btn select-btn" onclick="selectPackage(${package.id})">Select</button>
        </div>
        <input type="radio" name="package" value="${package.id}" style="display: none;">
    </div>
`).join('');


        // Reattach click handlers
        document.querySelectorAll('.package-card').forEach(card => {
            card.addEventListener('click', function (e) {
                if (!e.target.classList.contains('package-btn')) {
                    document.querySelectorAll('.package-card').forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                    this.querySelector('input[type="radio"]').checked = true;
                }
            });
        });
    } catch (error) {
        console.error('Error loading packages:', error);
        packagesContainer.innerHTML = `
            <div class="error-message" style="text-align: center; padding: 20px; color: #dc3545;">
                Failed to load packages. Please try again.
            </div>`;
    }
}

// Make sure the event listener is properly attached
document.addEventListener('DOMContentLoaded', function () {
    // Existing event listeners...

    // Add modal close button listener
    const modalClose = document.querySelector('.package-modal-close');
    if (modalClose) {
        modalClose.addEventListener('click', closePackageModal);
    }

    // Close modal on outside click
    packageModal.addEventListener('click', (e) => {
        if (e.target === packageModal) {
            closePackageModal();
        }
    });

    // Close modal on escape key
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && packageModal.classList.contains('active')) {
            closePackageModal();
        }
    });
});