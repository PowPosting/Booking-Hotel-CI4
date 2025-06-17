<?php
// filepath: d:\laragon\www\Hotel\app\Views\partials\modals\choose_room_modal.php

// Load room model
$roomModel = new \App\Models\RoomModel();
?>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 bg-gradient-primary text-white">
                <h4 class="modal-title fw-bold" id="bookingModalLabel">
                    <i class="fas fa-calendar-check me-2"></i>Booking Kamar
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="bookingForm" method="POST" action="<?= site_url('cart/add') ?>">
                <div class="modal-body p-0">
                    <!-- Room Info Header -->
                    <div class="bg-light p-4 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <img id="bookingRoomImage" src="" alt="Room" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;">
                            </div>
                            <div class="col-md-6">
                                <h5 id="bookingRoomName" class="mb-1 text-primary fw-bold"></h5>
                                <p id="bookingRoomPrice" class="mb-0 text-muted"></p>
                            </div>
                            <div class="col-md-3 text-end">
                                <div class="bg-white rounded p-2 shadow-sm">
                                    <small class="text-muted d-block">Total:</small>
                                    <span id="totalNights" class="d-block fw-bold text-primary">1 malam</span>
                                    <span id="totalPrice" class="fw-bold text-dark">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Form Content -->
                    <div class="p-4">
                        <!-- Hidden fields -->
                        <input type="hidden" id="roomType" name="room_type" value="">
                        <input type="hidden" id="roomPrice" name="price" value="">
                        <input type="hidden" id="roomImage" name="image" value="">
                        <input type="hidden" id="selectedRoomId" name="room_id" value="">
                        <input type="hidden" name="room_name" id="roomName" value="">

                        <!-- Date Selection -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-calendar me-2"></i>Tanggal Menginap
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="checkInDate" class="form-label">Check-in *</label>
                                <input type="date" class="form-control" id="checkInDate" name="check_in" 
                                       onchange="updateTotalPrice()" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="checkOutDate" class="form-label">Check-out *</label>
                                <input type="date" class="form-control" id="checkOutDate" name="check_out" 
                                       onchange="updateTotalPrice()" required>
                            </div>
                        </div>

                        <!-- Room Selection -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-door-open me-2"></i>Pilih Nomor Kamar
                                </h6>
                                
                                <!-- Room Grid Container -->
                                <div id="roomGridContainer">
                                    <div class="text-center py-3 text-muted">
                                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                        <p class="mb-0">Pilih tipe kamar untuk melihat nomor kamar yang tersedia</p>
                                    </div>
                                </div>
                                
                                <!-- Selected room info -->
                                <div id="selectedRoomInfo" class="alert alert-info d-none mt-3">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Kamar Terpilih:</strong> <span id="selectedRoomNumber"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Guest Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>Informasi Tamu
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="guestName" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="guestName" name="guest_name" 
                                       value="<?= session()->get('fullname') ?? '' ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="guestEmail" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="guestEmail" name="guest_email" 
                                       value="<?= session()->get('email') ?? '' ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="guestPhone" class="form-label">Nomor Telepon *</label>
                                <input type="tel" class="form-control" id="guestPhone" name="guest_phone" required
                                       value="<?= session()->get('phone') ?? '' ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="guests" class="form-label">Jumlah Tamu</label>
                                <select class="form-select" id="guests" name="guests" onchange="updateTotalPrice()">
                                    <option value="1">1 Orang</option>
                                    <option value="2" selected>2 Orang</option>
                                    <option value="3">3 Orang</option>
                                    <option value="4">4 Orang</option>
                                    <option value="5">5 Orang</option>
                                    <option value="6">6 Orang</option>
                                </select>
                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                    <label class="form-check-label" for="agreeTerms">
                                        Saya menyetujui 
                                        <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#termsModal">
                                            syarat dan ketentuan
                                        </a> 
                                        yang berlaku
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Current booking data
let currentBookingData = {};
let selectedRoomData = {};

// Show booking modal with pre-selected room (Pure CI4 approach)
function showBookingModal(roomName, price, image) {
    console.log('showBookingModal called with:', roomName, price, image);
    
    // Set room data to modal
    document.getElementById('bookingRoomName').textContent = roomName;
    document.getElementById('bookingRoomPrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(price) + '/malam';
    document.getElementById('bookingRoomImage').src = '<?= base_url('images/') ?>' + image;
    
    // Set hidden form fields
    document.getElementById('roomType').value = roomName;
    document.getElementById('roomPrice').value = price;
    document.getElementById('roomImage').value = image;
    document.getElementById('roomName').value = roomName;
    
    // Set default dates
    const today = new Date();
    const checkIn = new Date(today);
    checkIn.setDate(today.getDate() + 1);
    const checkOut = new Date(today);
    checkOut.setDate(today.getDate() + 2);
    
    document.getElementById('checkInDate').value = checkIn.toISOString().split('T')[0];
    document.getElementById('checkOutDate').value = checkOut.toISOString().split('T')[0];
    
    // Store room data
    currentBookingData = {
        roomName: roomName,
        price: price,
        image: image
    };
    
    // Load available rooms for this type
    loadAvailableRooms(roomName);
    
    // Calculate initial total
    updateTotalPrice();
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
    modal.show();
}

// Load available rooms using CI4 AJAX
function loadAvailableRooms(roomType) {
    const container = document.getElementById('roomGridContainer');
    container.innerHTML = '<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary"></div><p class="mt-2 text-muted">Mengambil data kamar...</p></div>';
    
    console.log('Loading rooms for type:', roomType);
    
    // Use proper AJAX headers
    fetch('<?= site_url('room/get-available') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: 'room_type=' + encodeURIComponent(roomType)
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            displayRoomGrid(data.rooms_by_floor, data.statistics);
        } else {
            container.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        container.innerHTML = '<div class="alert alert-danger">Gagal mengambil data kamar: ' + error.message + '</div>';
    });
}

// Display room grid (PHP-generated content)
function displayRoomGrid(roomsByFloor, statistics = null) {
    const container = document.getElementById('roomGridContainer');
    let html = '<div class="row g-2">';
    
    if (Object.keys(roomsByFloor).length === 0) {
        html += '<div class="col-12 text-center py-4 text-muted">';
        html += '<i class="fas fa-bed fa-3x mb-3"></i>';
        html += '<p>Tidak ada kamar untuk tipe ini</p>';
        html += '</div>';
    } else {
        Object.keys(roomsByFloor).forEach(floor => {
            // Floor header
            html += '<div class="col-12 mt-3 mb-2">';
            html += '<h6 class="mb-0 text-muted">';
            html += '<i class="fas fa-building me-2"></i>Lantai ' + floor;
            html += '</h6>';
            html += '</div>';
            
            // Rooms for this floor
            roomsByFloor[floor].forEach(room => {
                let statusClass = '';
                let statusIcon = '';
                let isClickable = false;
                let tooltip = '';
                
                switch(room.status) {
                    case 'available':
                        statusClass = 'available';
                        statusIcon = '<i class="fas fa-check-circle text-success"></i>';
                        isClickable = true;
                        tooltip = 'Tersedia - Rp ' + new Intl.NumberFormat('id-ID').format(room.price) + '/malam';
                        break;
                    case 'occupied':
                        statusClass = 'occupied';
                        statusIcon = '<i class="fas fa-user text-white"></i>';
                        isClickable = false;
                        tooltip = 'Sedang Ditempati';
                        break;
                    case 'maintenance':
                        statusClass = 'maintenance';
                        statusIcon = '<i class="fas fa-tools text-white"></i>';
                        isClickable = false;
                        tooltip = 'Sedang Maintenance';
                        break;
                    default:
                        statusClass = 'unavailable';
                        statusIcon = '<i class="fas fa-times text-white"></i>';
                        isClickable = false;
                        tooltip = 'Tidak Tersedia';
                }
                
                const disabled = !isClickable ? 'disabled' : '';
                const clickHandler = isClickable ? 
                    'onclick="selectRoom(' + room.id + ', \'' + room.room_number + '\', ' + room.price + ')"' : '';
                
                html += '<div class="col-2 col-md-1 mb-2">';
                html += '<div class="room-container position-relative">';
                html += '<button type="button" class="btn room-number-btn ' + statusClass + '" ';
                html += 'title="' + tooltip + '" ';
                html += clickHandler + ' ';
                html += disabled + '>';
                html += '<div class="room-number">' + room.room_number + '</div>';
                html += '<div class="room-status-icon">' + statusIcon + '</div>';
                html += '</button>';
                html += '</div>';
                html += '</div>';
            });
        });
        
        // Add legend
        html += '<div class="col-12 mt-4">';
        html += '<div class="card border-0 bg-light">';
        html += '<div class="card-body py-2">';
        html += '<div class="d-flex align-items-center justify-content-center gap-4 small">';
        html += '<div class="d-flex align-items-center">';
        html += '<div class="room-status-indicator available me-2"></div>';
        html += '<span><i class="fas fa-check-circle text-success me-1"></i>Tersedia</span>';
        html += '</div>';
        html += '<div class="d-flex align-items-center">';
        html += '<div class="room-status-indicator occupied me-2"></div>';
        html += '<span><i class="fas fa-user text-danger me-1"></i>Terisi</span>';
        html += '</div>';
        html += '<div class="d-flex align-items-center">';
        html += '<div class="room-status-indicator maintenance me-2"></div>';
        html += '<span><i class="fas fa-tools text-warning me-1"></i>Maintenance</span>';
        html += '</div>';
        html += '<div class="d-flex align-items-center">';
        html += '<div class="room-status-indicator selected me-2"></div>';
        html += '<span><i class="fas fa-star text-primary me-1"></i>Dipilih</span>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
    }
    
    html += '</div>';
    container.innerHTML = html;
}

// Select room (Pure JavaScript with CI4 validation)
function selectRoom(roomId, roomNumber, roomPrice) {
    // Remove previous selection
    document.querySelectorAll('.room-number-btn.selected').forEach(btn => {
        btn.classList.remove('selected');
    });
    
    // Add selection to clicked room
    event.target.classList.add('selected');
    
    // Store selected room
    selectedRoomData = {
        id: roomId,
        number: roomNumber,
        price: roomPrice
    };
    
    // Update form fields
    document.getElementById('selectedRoomId').value = roomId;
    document.getElementById('selectedRoomNumber').textContent = 'Nomor ' + roomNumber;
    document.getElementById('selectedRoomInfo').classList.remove('d-none');
    
    // Update price if different
    if (roomPrice !== currentBookingData.price) {
        currentBookingData.price = roomPrice;
        document.getElementById('roomPrice').value = roomPrice;
        updateTotalPrice();
    }
}

// Calculate total price
function updateTotalPrice() {
    const checkIn = document.getElementById('checkInDate').value;
    const checkOut = document.getElementById('checkOutDate').value;
    
    if (checkIn && checkOut && currentBookingData.price) {
        const nights = (new Date(checkOut) - new Date(checkIn)) / (1000 * 60 * 60 * 24);
        
        if (nights > 0) {
            const totalPrice = currentBookingData.price * nights;
            document.getElementById('totalNights').textContent = nights + ' malam';
            document.getElementById('totalPrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalPrice);
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            
            // Validate form
            if (!validateBookingForm()) {
                return false;
            }
            
            // Submit via AJAX
            submitBookingForm();
        });
    }
});

// Validate booking form
function validateBookingForm() {
    const roomId = document.getElementById('selectedRoomId').value;
    const checkIn = document.getElementById('checkInDate').value;
    const checkOut = document.getElementById('checkOutDate').value;
    const guestName = document.getElementById('guestName').value;
    const guestEmail = document.getElementById('guestEmail').value;
    const guestPhone = document.getElementById('guestPhone').value;
    const agreeTerms = document.getElementById('agreeTerms').checked;
    
    // Check if room is selected
    if (!roomId) {
        alert('Silakan pilih nomor kamar terlebih dahulu!');
        return false;
    }
    
    // Check dates
    if (!checkIn || !checkOut) {
        alert('Silakan pilih tanggal check-in dan check-out!');
        return false;
    }
    
    if (new Date(checkIn) >= new Date(checkOut)) {
        alert('Tanggal check-out harus setelah check-in!');
        return false;
    }
    
    if (new Date(checkIn) < new Date()) {
        alert('Tanggal check-in tidak boleh di masa lalu!');
        return false;
    }
    
    // Check guest information
    if (!guestName.trim()) {
        alert('Nama lengkap harus diisi!');
        return false;
    }
    
    if (!guestEmail.trim()) {
        alert('Email harus diisi!');
        return false;
    }
    
    if (!guestPhone.trim()) {
        alert('Nomor telepon harus diisi!');
        return false;
    }
    
    // Check terms agreement
    if (!agreeTerms) {
        alert('Anda harus menyetujui syarat dan ketentuan!');
        return false;
    }
    
    return true;
}

// Submit booking form via AJAX
function submitBookingForm() {
    const form = document.getElementById('bookingForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menambahkan...';
    
    // Create FormData
    const formData = new FormData(form);
    
    // Add special requests if any
    const specialRequests = document.getElementById('specialRequests');
    if (specialRequests && specialRequests.value) {
        formData.append('special_requests', specialRequests.value);
    }

    console.log('Submitting booking form...');

    // Submit via fetch
    fetch('<?= site_url('cart/add') ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status); 
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);

        if (data.success) {
            // Show success message
            showNotification('success', data.message || 'Booking berhasil ditambahkan ke keranjang!');
            
            // Update cart count in navbar
            if (typeof updateCartCount === 'function') {
                updateCartCount(data.cart_count);
            }
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('bookingModal'));
            if (modal) {
                modal.hide();
            }
            
            // Reset form
            form.reset();
            resetModalState();
            
        } else {
            // Show error message
            showNotification('error', data.message || 'Gagal menambahkan booking ke keranjang!');
        }
    })
    .catch(error => {
        console.error('Submit error:', error);
        showNotification('error', 'Terjadi kesalahan saat menambahkan booking: ' + error.message);
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

// Reset modal state
function resetModalState() {
    // Clear selected room
    document.querySelectorAll('.room-number-btn.selected').forEach(btn => {
        btn.classList.remove('selected');
    });
    
    // Hide selected room info
    document.getElementById('selectedRoomInfo').classList.add('d-none');
    
    // Clear hidden fields
    document.getElementById('selectedRoomId').value = '';
    document.getElementById('selectedRoomNumber').textContent = '';
    
    // Reset room grid
    document.getElementById('roomGridContainer').innerHTML = `
        <div class="text-center py-3 text-muted">
            <i class="fas fa-calendar-times fa-2x mb-2"></i>
            <p class="mb-0">Pilih tipe kamar untuk melihat nomor kamar yang tersedia</p>
        </div>
    `;
    
    // Clear booking data
    currentBookingData = {};
    selectedRoomData = {};
}

// Show notification function
function showNotification(type, message) {
    // Remove existing notifications
    document.querySelectorAll('.booking-notification').forEach(notif => {
        notif.remove();
    });
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed booking-notification`;
    notification.style.cssText = 'top: 80px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>

<!-- CSS tetap sama seperti sebelumnya -->
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #4a6cfa 0%, #3a5ce4 100%);
}

/* Room container */
.room-container {
    position: relative;
}

/* Room number buttons */
.room-number-btn {
    width: 100%;
    height: 50px;
    border: 2px solid #ddd;
    background: white;
    color: #333;
    font-size: 11px;
    font-weight: bold;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 4px;
}

.room-number {
    font-size: 12px;
    font-weight: bold;
    line-height: 1;
}

.room-status-icon {
    font-size: 10px;
    margin-top: 2px;
}

/* Available rooms */
.room-number-btn.available {
    background: #e8f5e8;
    border-color: #28a745;
    color: #155724;
}

.room-number-btn.available:hover {
    background: #28a745;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}

/* Occupied rooms */
.room-number-btn.occupied {
    background: #f8d7da;
    border-color: #dc3545;
    color: #721c24;
    cursor: not-allowed;
}

.room-number-btn.occupied .room-status-icon {
    color: #dc3545 !important;
}

/* Maintenance rooms */
.room-number-btn.maintenance {
    background: #fff3cd;
    border-color: #ffc107;
    color: #856404;
    cursor: not-allowed;
}

.room-number-btn.maintenance .room-status-icon {
    color: #ffc107 !important;
}

/* Selected room */
.room-number-btn.selected {
    background: #4a6cfa;
    color: white;
    border-color: #3a5ce4;
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(74, 108, 250, 0.4);
}

/* Room status indicators for legend */
.room-status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
}

.room-status-indicator.available {
    background-color: #28a745;
}

.room-status-indicator.occupied {
    background-color: #dc3545;
}

.room-status-indicator.maintenance {
    background-color: #ffc107;
}

.room-status-indicator.selected {
    background-color: #4a6cfa;
}

/* Disabled state */
.room-number-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.room-number-btn:disabled:hover {
    transform: none;
    box-shadow: none;
}

/* Statistics card */
.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}

/* Terms & Conditions Modal */
.modal-dialog-scrollable {
    max-height: calc(100vh - 100px);
    overflow-y: auto;
}

.modal-header {
    padding: 1rem 1.5rem;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 500;
}

/* **TAMBAH: CSS untuk terms modal** */

.terms-content {
    font-size: 0.9rem;
    line-height: 1.6;
}

.terms-content section {
    border-bottom: 1px solid #eee;
    padding-bottom: 1rem;
}

.terms-content section:last-child {
    border-bottom: none;
}

.terms-content h6 {
    color: #4a6cfa;
    border-left: 4px solid #4a6cfa;
    padding-left: 10px;
}

.terms-content .card {
    transition: transform 0.2s ease;
}

.terms-content .card:hover {
    transform: translateY(-2px);
}

.terms-content .table th {
    font-size: 0.85rem;
    font-weight: 600;
}

.terms-content .table td {
    font-size: 0.85rem;
}

.terms-content .alert {
    font-size: 0.85rem;
}

.terms-content ul li {
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
}

/* Modal scrollable content */
.modal-dialog-scrollable .modal-body {
    max-height: 70vh;
    overflow-y: auto;
}

/* Terms modal specific */
#termsModal .modal-body {
    padding: 0;
}

#termsModal .terms-content {
    padding: 1.5rem;
}

/* Terms modal specific */
#termsModal .modal-body {
    padding: 0;
}

#termsModal .terms-content {
    padding: 1.5rem;
}
</style>

<!-- Terms & Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="termsModalLabel">
                    <i class="fas fa-file-contract me-2"></i>Syarat dan Ketentuan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="terms-content">
                    
                    <!-- 1. Pemesanan -->
                    <section class="mb-4">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="fas fa-calendar-check me-2"></i>1. Ketentuan Pemesanan
                        </h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Pemesanan kamar dapat dilakukan minimal 1 hari sebelum tanggal check-in
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Konfirmasi pemesanan akan dikirim melalui email dalam 24 jam
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Tamu wajib menunjukkan identitas yang valid saat check-in
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Nomor kamar dapat berubah sesuai ketersediaan tanpa mengurangi kualitas layanan
                            </li>
                        </ul>
                    </section>

                    <!-- 2. Pembayaran -->
                    <section class="mb-4">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="fas fa-credit-card me-2"></i>2. Ketentuan Pembayaran
                        </h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Pembayaran dapat dilakukan melalui transfer bank atau tunai
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Booking akan otomatis dibatalkan jika tidak ada pembayaran dalam 24 jam
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Harga kamar sudah termasuk pajak dan layanan
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                Biaya tambahan berlaku untuk fasilitas extra (minibar, laundry, dll)
                            </li>
                        </ul>
                    </section>

                    <!-- 3. Check-in & Check-out -->
                    <section class="mb-4">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="fas fa-door-open me-2"></i>3. Check-in & Check-out
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-success">
                                    <div class="card-body text-center">
                                        <i class="fas fa-clock text-success fa-2x mb-2"></i>
                                        <h6 class="text-success">Check-in</h6>
                                        <p class="mb-0"><strong>14:00 WIB</strong></p>
                                        <small class="text-muted">Kamar tersedia mulai jam 14:00</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-danger">
                                    <div class="card-body text-center">
                                        <i class="fas fa-clock text-danger fa-2x mb-2"></i>
                                        <h6 class="text-danger">Check-out</h6>
                                        <p class="mb-0"><strong>12:00 WIB</strong></p>
                                        <small class="text-muted">Kamar harus dikosongkan sebelum jam 12:00</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Late Check-out:</strong> Tersedia dengan biaya tambahan Rp 100.000/jam (tergantung ketersediaan)
                        </div>
                    </section>

                    <!-- 4. Pembatalan -->
                    <section class="mb-4">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="fas fa-ban me-2"></i>4. Kebijakan Pembatalan
                        </h6>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Waktu Pembatalan</th>
                                                <th>Biaya Pembatalan</th>
                                                <th>Refund</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-success">
                                                <td>Lebih dari 7 hari sebelum check-in</td>
                                                <td>Gratis</td>
                                                <td>100%</td>
                                            </tr>
                                            <tr class="table-warning">
                                                <td>3-7 hari sebelum check-in</td>
                                                <td>25% dari total biaya</td>
                                                <td>75%</td>
                                            </tr>
                                            <tr class="table-warning">
                                                <td>1-3 hari sebelum check-in</td>
                                                <td>50% dari total biaya</td>
                                                <td>50%</td>
                                            </tr>
                                            <tr class="table-danger">
                                                <td>Kurang dari 24 jam</td>
                                                <td>100% dari total biaya</td>
                                                <td>0%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- 5. Fasilitas -->
                    <section class="mb-4">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="fas fa-concierge-bell me-2"></i>5. Fasilitas Hotel
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-success">
                                    <i class="fas fa-check-circle me-2"></i>Fasilitas Gratis
                                </h6>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-wifi text-primary me-2"></i>WiFi gratis</li>
                                    <li><i class="fas fa-car text-primary me-2"></i>Parkir gratis</li>
                                    <li><i class="fas fa-coffee text-primary me-2"></i>Welcome drink</li>
                                    <li><i class="fas fa-dumbbell text-primary me-2"></i>Gym 24 jam</li>
                                    <li><i class="fas fa-swimming-pool text-primary me-2"></i>Kolam renang</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-warning">
                                    <i class="fas fa-dollar-sign me-2"></i>Fasilitas Berbayar
                                </h6>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-utensils text-warning me-2"></i>Room service</li>
                                    <li><i class="fas fa-tshirt text-warning me-2"></i>Laundry</li>
                                    <li><i class="fas fa-glass-cheers text-warning me-2"></i>Minibar</li>
                                    <li><i class="fas fa-spa text-warning me-2"></i>Spa & massage</li>
                                    <li><i class="fas fa-taxi text-warning me-2"></i>Airport shuttle</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- 6. Peraturan -->
                    <section class="mb-4">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>6. Peraturan Hotel
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <h6 class="text-success mb-2">
                                        <i class="fas fa-thumbs-up me-2"></i>Diperbolehkan
                                    </h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><i class="fas fa-child text-success me-2"></i>Anak-anak welcome</li>
                                        <li><i class="fas fa-users text-success me-2"></i>Tamu tambahan (biaya extra)</li>
                                        <li><i class="fas fa-birthday-cake text-success me-2"></i>Acara kecil di kamar</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-danger">
                                    <h6 class="text-danger mb-2">
                                        <i class="fas fa-ban me-2"></i>Tidak Diperbolehkan
                                    </h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><i class="fas fa-smoking-ban text-danger me-2"></i>Merokok di dalam kamar</li>
                                        <li><i class="fas fa-paw text-danger me-2"></i>Membawa hewan peliharaan</li>
                                        <li><i class="fas fa-volume-up text-danger me-2"></i>Suara keras setelah jam 22:00</li>
                                        <li><i class="fas fa-glass-martini text-danger me-2"></i>Alkohol berlebihan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- 7. Kontak -->
                    <section class="mb-4">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="fas fa-phone me-2"></i>7. Kontak & Bantuan
                        </h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center p-3 border rounded">
                                    <i class="fas fa-phone fa-2x text-primary mb-2"></i>
                                    <h6>Telepon</h6>
                                    <p class="mb-0"><strong>(021) 555-0123</strong></p>
                                    <small class="text-muted">24 jam</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 border rounded">
                                    <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                                    <h6>Email</h6>
                                    <p class="mb-0"><strong>info@luxstay.com</strong></p>
                                    <small class="text-muted">Respon 2-4 jam</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 border rounded">
                                    <i class="fab fa-whatsapp fa-2x text-success mb-2"></i>
                                    <h6>WhatsApp</h6>
                                    <p class="mb-0"><strong>+62 812-3456-7890</strong></p>
                                    <small class="text-muted">Chat langsung</small>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- 8. Force Majeure -->
                    <section class="mb-4">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="fas fa-shield-alt me-2"></i>8. Force Majeure
                        </h6>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Catatan Penting:</strong> Hotel tidak bertanggung jawab atas keterlambatan atau pembatalan layanan yang disebabkan oleh bencana alam, kondisi cuaca ekstrem, kerusuhan, atau situasi di luar kendali hotel. Dalam kondisi tersebut, hotel akan memberikan alternatif terbaik atau pengembalian dana sesuai kebijakan yang berlaku.
                        </div>
                    </section>

                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="acceptTerms()">
                    <i class="fas fa-check me-2"></i>Saya Setuju
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// **TAMBAH: Function untuk accept terms**
function acceptTerms() {
    // Set checkbox as checked
    document.getElementById('agreeTerms').checked = true;
    
    // Close terms modal
    const termsModal = bootstrap.Modal.getInstance(document.getElementById('termsModal'));
    if (termsModal) {
        termsModal.hide();
    }
    
    // Show success notification
    showNotification('success', 'Syarat dan ketentuan telah disetujui!');
}
</script>