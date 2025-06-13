<div class="booking-trace-form">
    <h2>Trace Booking</h2>
    <form id="traceForm">
        <div class="form-group">
            <label for="reference">Booking Reference</label>
            <input type="text" 
                   id="reference" 
                   name="reference" 
                   placeholder="e.g., EVT-2024-BK-000001"
                   required>
        </div>
        <button type="submit">Search</button>
    </form>

    <div id="bookingResult" class="hidden">
        <!-- Results will be displayed here -->
    </div>
</div>

<script>
document.getElementById('traceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const reference = document.getElementById('reference').value;
    
    fetch(`/bookings/trace?reference=${encodeURIComponent(reference)}`)
        .then(response => response.json())
        .then(data => {
            const resultDiv = document.getElementById('bookingResult');
            if (data.success) {
                resultDiv.innerHTML = `
                    <div class="booking-details">
                        <h3>Booking Found</h3>
                        <p><strong>Reference:</strong> ${data.booking.reference}</p>
                        <p><strong>Status:</strong> ${data.booking.status}</p>
                        <p><strong>Event:</strong> ${data.booking.event_name}</p>
                        <p><strong>Date:</strong> ${data.booking.event_date}</p>
                        <p><strong>Venue:</strong> ${data.booking.venue}</p>
                        <p><strong>Package:</strong> ${data.booking.package}</p>
                        <p><strong>Total Price:</strong> $${data.booking.total_price}</p>
                        <p><strong>Customer:</strong> ${data.booking.customer_name}</p>
                        <p><strong>Booked On:</strong> ${data.booking.created_at}</p>
                        <a href="/bookings/${data.booking.reference}" class="btn">View Details</a>
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div class="error-message">
                        <p>Booking not found</p>
                    </div>
                `;
            }
            resultDiv.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while searching for the booking');
        });
});
</script>