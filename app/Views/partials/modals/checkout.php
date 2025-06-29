<?php
// filepath: d:\laragon\www\Hotel\app\Views\partials\modals\checkout.php
?>

<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="checkoutModalLabel">
                    <i class="fas fa-credit-card me-2"></i>Checkout
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="checkoutForm" method="POST" action="<?= site_url('booking/process') ?>">
                    <!-- Order Summary -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Detail Pesanan</h6>
                        <div id="orderSummary" class="border rounded p-3">
                            <div class="text-center py-3">
                                <div class="spinner-border spinner-border-sm"></div>
                                <span class="ms-2">Loading...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Metode Pembayaran</h6>
                        <div class="row g-3">
                            <!-- QRIS -->
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_method" id="qris" value="qris" required>
                                <label class="btn btn-outline-primary w-100 p-3" for="qris">
                                    <i class="fas fa-qrcode fs-3 d-block mb-2"></i>
                                    <small>QRIS</small>
                                </label>
                            </div>
                            
                            <!-- Bank VA -->
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_method" id="bank_va" value="bank_va" required>
                                <label class="btn btn-outline-primary w-100 p-3" for="bank_va">
                                    <i class="fas fa-university fs-3 d-block mb-2"></i>
                                    <small>Bank Transfer</small>
                                </label>
                            </div>
                            
                            <!-- COD -->
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_method" id="cod" value="cod" required>
                                <label class="btn btn-outline-primary w-100 p-3" for="cod">
                                    <i class="fas fa-money-bill-wave fs-3 d-block mb-2"></i>
                                    <small>Bayar di Hotel</small>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Bank Selection (hidden by default) -->
                        <div id="bankSelection" class="mt-3" style="display: none;">
                            <small class="text-muted mb-2 d-block">Pilih Bank:</small>
                            <div class="row g-2">
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="bank_code" id="bca" value="BCA">
                                    <label class="btn btn-outline-secondary w-100" for="bca">BCA</label>
                                </div>
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="bank_code" id="bni" value="BNI">
                                    <label class="btn btn-outline-secondary w-100" for="bni">BNI</label>
                                </div>
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="bank_code" id="bri" value="BRI">
                                    <label class="btn btn-outline-secondary w-100" for="bri">BRI</label>
                                </div>
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="bank_code" id="mandiri" value="MANDIRI">
                                    <label class="btn btn-outline-secondary w-100" for="mandiri">Mandiri</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="border rounded p-3 mb-4 bg-light">
                        <div id="pricingSummary">
                            <div class="text-center">
                                <div class="spinner-border spinner-border-sm"></div>
                                <span class="ms-2">Menghitung total...</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="checkoutForm" class="btn btn-primary" id="processPaymentBtn">
                    <i class="fas fa-lock me-2"></i>Proses Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-5">
                <!-- Success Icon -->
                <div class="success-icon mx-auto mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                
                <!-- Success Message -->
                <h3 class="text-success mb-2">Booking Berhasil!</h3>
                <p class="text-muted mb-4" id="successMessage">Terima kasih telah memilih hotel kami</p>
                
                <!-- Booking Code -->
                <div class="alert alert-info border-0 mb-4">
                    <h6 class="mb-2"><i class="fas fa-receipt me-2"></i>Kode Booking</h6>
                    <h4 class="mb-0 fw-bold" id="bookingCode">-</h4>
                </div>
                
                <!-- Payment Info Container -->
                <div id="paymentInfo" class="mb-4" style="display: none;">
                    <!-- Virtual Account Info -->
                    <div id="vaInfo" style="display: none;">
                        <div class="alert alert-warning border-0">
                            <h6 class="mb-2"><i class="fas fa-university me-2"></i>Virtual Account</h6>
                            <p class="mb-2"><strong id="bankName">-</strong></p>
                            <div class="input-group">
                                <input type="text" class="form-control" id="vaNumber" readonly>
                                <button class="btn btn-outline-primary" onclick="copyVANumber()">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                            <small class="text-danger mt-2 d-block">
                                <i class="fas fa-clock me-1"></i>Berlaku sampai: <span id="vaExpired">-</span>
                            </small>
                        </div>
                    </div>
                    
                    <!-- QRIS Info -->
                    <div id="qrisInfo" style="display: none;">
                        <div class="alert alert-warning border-0">
                            <h6 class="mb-3"><i class="fas fa-qrcode me-2"></i>Scan QR Code</h6>
                            <img id="qrCodeImage" src="" alt="QR Code" class="img-fluid mb-2" style="max-width: 150px;">
                            <small class="text-danger d-block">
                                <i class="fas fa-clock me-1"></i>Berlaku sampai: <span id="qrisExpired">-</span>
                            </small>
                        </div>
                    </div>
                    
                    <!-- COD Info -->
                    <div id="codInfo" style="display: none;">
                        <div class="alert alert-success border-0">
                            <h6 class="mb-2"><i class="fas fa-money-bill me-2"></i>Cash on Delivery</h6>
                            <p class="mb-0">Silakan bayar di hotel saat check-in</p>
                        </div>
                    </div>
                    
                    <!-- Total Amount -->
                    <div class="text-center">
                        <h5 class="text-primary">Total: Rp <span id="totalAmount">-</span></h5>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" onclick="closeSuccessModal()">
                        <i class="fas fa-check me-2"></i>OK, Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.success-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(40, 167, 69, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    animation: bounceIn 0.6s ease-out;
}

@keyframes bounceIn {
    0% {
        transform: scale(0.3);
        opacity: 0;
    }
    50% {
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.modal-content {
    border-radius: 15px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment method change
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const bankSelection = document.getElementById('bankSelection');
            const processBtn = document.getElementById('processPaymentBtn');
            
            if (this.value === 'bank_va') {
                bankSelection.style.display = 'block';
                processBtn.innerHTML = '<i class="fas fa-university me-2"></i>Buat Virtual Account';
            } else {
                bankSelection.style.display = 'none';
                if (this.value === 'qris') {
                    processBtn.innerHTML = '<i class="fas fa-qrcode me-2"></i>Generate QR Code';
                } else if (this.value === 'cod') {
                    processBtn.innerHTML = '<i class="fas fa-calendar-check me-2"></i>Konfirmasi Booking';
                }
            }
        });
    });

    // Form submit
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        e.preventDefault();
        processCheckout();
    });
});

// Show checkout modal
function showCheckoutModal() {
    loadOrderSummary();
    const modal = new bootstrap.Modal(document.getElementById('checkoutModal'));
    modal.show();
}

// Load order summary
function loadOrderSummary() {
    fetch('<?= site_url('cart/getItems') ?>')
    .then(response => response.json())
    .then(data => {
        if (data.success && data.items.length > 0) {
            displayOrderSummary(data.items);
            displayPricingSummary(data);
        } else {
            document.getElementById('orderSummary').innerHTML = 
                '<div class="text-center text-muted">Keranjang kosong</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('orderSummary').innerHTML = 
            '<div class="text-center text-danger">Gagal memuat data</div>';
    });
}

// Display order summary
function displayOrderSummary(items) {
    let html = '';
    items.forEach(item => {
        html += `
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="fw-bold text-primary">${item.room_name}</div>
                            <small class="text-muted">
                                ${new Date(item.check_in).toLocaleDateString('id-ID')} - 
                                ${new Date(item.check_out).toLocaleDateString('id-ID')}
                            </small>
                            <small class="text-muted d-block">${item.nights} malam • ${item.guests} tamu</small>
                            
                            <!-- Room Price Breakdown -->
                            <div class="mt-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Kamar (${item.nights} malam):</span>
                                    <span>Rp ${new Intl.NumberFormat('id-ID').format(item.room_total || item.price * item.nights)}</span>
                                </div>
                                
                                <!-- Facilities -->
                                ${item.facilities && item.facilities.length > 0 ? `
                                    <div class="mt-1">
                                        <span class="text-muted">Fasilitas Tambahan:</span>
                                        ${item.facilities.map(facility => `
                                            <div class="d-flex justify-content-between ps-3">
                                                <span class="text-muted small">• ${facility.display_name}</span>
                                                <span class="small">Rp ${new Intl.NumberFormat('id-ID').format(facility.price)}</span>
                                            </div>
                                        `).join('')}
                                    </div>
                                ` : ''}
                                
                                ${item.special_requests ? `
                                    <div class="mt-1">
                                        <span class="text-muted small">Permintaan Khusus:</span>
                                        <div class="text-muted small ps-3">${item.special_requests}</div>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-primary fs-6">Rp ${new Intl.NumberFormat('id-ID').format(item.total_price)}</div>
                            <small class="text-muted">Total</small>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    document.getElementById('orderSummary').innerHTML = html;
}

// Display pricing summary
function displayPricingSummary(data) {
    const tax = Math.round(data.total * 0.1);
    const finalTotal = data.total + tax;
    
    const html = `
        <div class="d-flex justify-content-between mb-2">
            <span>Subtotal</span>
            <span>${data.formatted_subtotal}</span>
        </div>
        ${data.discount > 0 ? `
        <div class="d-flex justify-content-between mb-2 text-success">
            <span>Diskon</span>
            <span>-${data.formatted_discount}</span>
        </div>
        ` : ''}
        <div class="d-flex justify-content-between mb-2">
            <span>Pajak (10%)</span>
            <span>Rp ${new Intl.NumberFormat('id-ID').format(tax)}</span>
        </div>
        <hr>
        <div class="d-flex justify-content-between fw-bold fs-5">
            <span>Total</span>
            <span class="text-primary">Rp ${new Intl.NumberFormat('id-ID').format(finalTotal)}</span>
        </div>
    `;
    document.getElementById('pricingSummary').innerHTML = html;
}

// Process checkout
function processCheckout() {
    const processBtn = document.getElementById('processPaymentBtn');
    const form = document.getElementById('checkoutForm');
    const formData = new FormData(form);
    
    // Disable button
    const originalText = processBtn.innerHTML;
    processBtn.disabled = true;
    processBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hide checkout modal
            const checkoutModal = bootstrap.Modal.getInstance(document.getElementById('checkoutModal'));
            checkoutModal.hide();
            
            // Show success modal with payment info
            showSuccessModal(data);
            
        } else {
            showAlert('error', data.message || 'Gagal memproses booking');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan sistem');
    })
    .finally(() => {
        processBtn.disabled = false;
        processBtn.innerHTML = originalText;
    });
}

// Function to show success modal with payment info
function showSuccessModal(data) {
    console.log('🎉 Booking success:', data);
    
    // Set booking code
    document.getElementById('bookingCode').textContent = data.booking_code;
    document.getElementById('successMessage').textContent = data.message;
    
    // Set total amount
    document.getElementById('totalAmount').textContent = data.total_amount;
    
    // Hide all payment info first
    document.getElementById('vaInfo').style.display = 'none';
    document.getElementById('qrisInfo').style.display = 'none';
    document.getElementById('codInfo').style.display = 'none';
    
    // Show payment info based on method
    if (data.payment_method === 'bank_va') {
        document.getElementById('paymentInfo').style.display = 'block';
        document.getElementById('vaInfo').style.display = 'block';
        document.getElementById('bankName').textContent = data.bank_code;
        document.getElementById('vaNumber').value = data.virtual_account;
        document.getElementById('vaExpired').textContent = data.expired_at;//waktu
        
    } else if (data.payment_method === 'qris') {
        document.getElementById('paymentInfo').style.display = 'block';
        document.getElementById('qrisInfo').style.display = 'block';
        document.getElementById('qrCodeImage').src = data.qr_code_url;
        document.getElementById('qrisExpired').textContent = data.expired_at;//waktu

    } else if (data.payment_method === 'cod') {
        document.getElementById('paymentInfo').style.display = 'block';
        document.getElementById('codInfo').style.display = 'block';
    }
    
    // **SIMPLE: Update notifikasi setelah 2 detik**
    setTimeout(() => {
        console.log('Attempting to update notifications after checkout...');
        if (window.updateNotifications) {
            console.log('Calling updateNotifications function...');
            window.updateNotifications();
        } else {
            console.error('updateNotifications function not found!');
        }
    }, 2000);
    
    // Show success modal
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
}

// Copy VA number function
function copyVANumber() {
    const vaInput = document.getElementById('vaNumber');
    vaInput.select();
    vaInput.setSelectionRange(0, 99999); // For mobile devices
    
    try {
        document.execCommand('copy');
        showAlert('success', 'Nomor Virtual Account berhasil disalin!');
    } catch (err) {
        // Fallback for modern browsers
        navigator.clipboard.writeText(vaInput.value).then(function() {
            showAlert('success', 'Nomor Virtual Account berhasil disalin!');
        }, function(err) {
            showAlert('error', 'Gagal menyalin nomor VA');
        });
    }
}

// Close success modal
function closeSuccessModal() {
    const successModal = bootstrap.Modal.getInstance(document.getElementById('successModal'));
    successModal.hide();
    
    // **UPDATE NOTIFIKASI LAGI**
    updateNotifications();
    
    // Reload page to refresh cart
    setTimeout(() => {
        location.reload();
    }, 300);
}

// Go to my bookings
function goToMyBookings() {
    location.href = '<?= site_url('booking') ?>';
}

// Make functions global so they can be called from HTML
window.showCheckoutModal = showCheckoutModal;
window.copyVANumber = copyVANumber;
window.closeSuccessModal = closeSuccessModal;
window.goToMyBookings = goToMyBookings;

</script>