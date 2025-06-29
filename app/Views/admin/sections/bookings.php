<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-check me-2"></i>Booking Management
                </h5>
                <div class="d-flex gap-2">
                    <input type="text" id="bookingSearchInput" class="form-control form-control-sm" placeholder="Search bookings..." style="width: 200px;">
                    <select id="bookingStatusFilter" class="form-select form-select-sm" style="width: 120px;">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <button class="btn btn-primary btn-sm" onclick="loadBookings()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="bookingsTableContainer">
                    <div class="text-center p-4">
                        <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                        <p class="mt-2 text-muted">Loading bookings...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Load bookings data using AJAX
function loadBookings() {
    if (window.adminDashboard) {
        window.adminDashboard.loadBookingsData();
    }
}

// Update bookings table
function updateBookingsTable(bookings) {
    const container = document.getElementById('bookingsTableContainer');
    
    if (bookings.length === 0) {
        container.innerHTML = '<div class="text-center p-4 text-muted">No bookings found</div>';
        return;
    }

    let html = '<div class="table-responsive"><table class="table table-enhanced"><thead><tr>';
    html += '<th>ID</th><th>Guest Name</th><th>Booking Code</th><th>Room</th>';
    html += '<th>Check In</th><th>Check Out</th><th>Total</th><th>Status</th><th>Actions</th>';
    html += '</tr></thead><tbody>';

    bookings.forEach(booking => {
        const statusClass = booking.booking_status === 'confirmed' ? 'success' : 
                          booking.booking_status === 'cancelled' ? 'danger' : 'warning';
        const amount = new Intl.NumberFormat('id-ID').format(booking.total_amount || 0);
        const checkIn = new Date(booking.check_in).toLocaleDateString('id-ID');
        const checkOut = new Date(booking.check_out).toLocaleDateString('id-ID');

        html += `<tr>
            <td>${booking.id}</td>
            <td>${booking.guest_name || '-'}</td>
            <td><strong>${booking.booking_code || '-'}</strong></td>
            <td>Room ${booking.room_id}</td>
            <td>${checkIn}</td>
            <td>${checkOut}</td>
            <td>Rp ${amount}</td>
            <td>
                <span class="badge bg-${statusClass}">${booking.booking_status || 'pending'}</span>
                <br><small class="text-muted">Payment: ${booking.payment_status || 'pending'}</small>
            </td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="updateBookingStatus(${booking.id}, 'confirmed')">
                            <i class="fas fa-check me-2"></i>Confirm
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="updateBookingStatus(${booking.id}, 'cancelled')">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteBooking(${booking.id})">
                            <i class="fas fa-trash me-2"></i>Delete
                        </a></li>
                    </ul>
                </div>
            </td>
        </tr>`;
    });

    html += '</tbody></table></div>';
    container.innerHTML = html;
    
    // Setup search and filter
    setupBookingSearchAndFilter();
}

// Setup search and filter for bookings
function setupBookingSearchAndFilter() {
    const searchInput = document.getElementById('bookingSearchInput');
    const statusFilter = document.getElementById('bookingStatusFilter');
    const table = document.querySelector('#bookingsTableContainer table tbody');
    
    if (!searchInput || !table) return;
    
    function filterBookings() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value.toLowerCase();
        const rows = table.querySelectorAll('tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 0) {
                const guestName = cells[1].textContent.toLowerCase();
                const bookingCode = cells[2].textContent.toLowerCase();
                const status = cells[7].textContent.toLowerCase();
                
                const matchesSearch = guestName.includes(searchTerm) || bookingCode.includes(searchTerm);
                const matchesStatus = !statusTerm || status.includes(statusTerm);
                
                row.style.display = matchesSearch && matchesStatus ? '' : 'none';
            }
        });
    }
    
    searchInput.addEventListener('input', filterBookings);
    statusFilter.addEventListener('change', filterBookings);
}

// Update booking status
async function updateBookingStatus(bookingId, status) {
    try {
        const response = await fetch(`<?= base_url('admin/bookings/update-status/') ?>${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ booking_status: status })
        });
        
        const result = await response.json();
        
        if (result.success) {
            showAlert('success', result.message);
            loadBookings(); // Reload bookings
        } else {
            showAlert('danger', result.message);
        }
    } catch (error) {
        console.error('Error updating booking status:', error);
        showAlert('danger', 'Error updating booking status');
    }
}

// Delete booking
function deleteBooking(bookingId) {
    if (confirm('Are you sure you want to delete this booking?')) {
        window.location.href = `<?= base_url('admin/bookings/delete/') ?>${bookingId}`;
    }
}

// Show alert
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Insert at the top of the container
    const container = document.querySelector('.main-content .container-fluid');
    container.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Auto dismiss after 5 seconds
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}

// Initialize when section is shown
document.addEventListener('DOMContentLoaded', function() {
    // Load bookings when this section becomes visible
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const section = document.getElementById('bookings');
                if (section && section.style.display !== 'none') {
                    loadBookings();
                }
            }
        });
    });
    
    const bookingsSection = document.getElementById('bookings');
    if (bookingsSection) {
        observer.observe(bookingsSection, { attributes: true });
    }
});
</script>
