<?php
?>

<!-- Room Types Section -->
<section id="rooms" class="py-5">
    <div class="container">
        <h2 class="section-title">Tipe Kamar</h2>
        <p class="text-muted mb-5">Pilih kamar yang sesuai dengan kebutuhan Anda</p>
        <div class="row g-4">
            <!-- Standard Room -->
            <div class="col-md-4">
                <div class="card room-card h-100">
                    <img src="<?= base_url('images/Kamarstandar.jpg') ?>" class="card-img-top" alt="Standard Room">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0 flex-grow-1">Kamar Standard</h5>
                            <span class="badge bg-accent price-badge">Rp 800.000/malam</span>
                        </div>
                        <p class="card-text text-muted">Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.</p>
                        <div class="d-flex justify-content-between mb-3">
                            <small><i class="fas fa-users me-1"></i> Maks 2 orang</small>
                            <small><i class="fas fa-bed me-1"></i> 1 Queen Bed</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Kamar Standard', '<?= base_url('images/Kamarstandar.jpg') ?>', '<?= base_url('images/kamarstandar2.jpg') ?>', '<?= base_url('images/kamarmandistandar.jpg') ?>', 'Nikmati kenyamanan maksimal di Kamar Standard kami, dilengkapi dengan fasilitas esensial yang dirancang untuk memberikan pengalaman menginap yang tenang dan menyenangkan.', 'Rp 800.000/malam')">Detail</button>
                            <button class="btn btn-primary btn-sm" onclick="addToCartQuick('Kamar Standard', 800000, 'Kamarstandar.jpg')">
                                <i class="fas fa-cart-plus me-1"></i>Pesan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Deluxe Room -->
            <div class="col-md-4">
                <div class="card room-card h-100">
                    <img src="<?= base_url('images/kamardeluxe.jpg') ?>" class="card-img-top" alt="Deluxe Room">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0 flex-grow-1">Kamar Deluxe</h5>
                            <span class="badge bg-accent price-badge">Rp 1.200.000/malam</span>
                        </div>
                        <p class="card-text text-muted">Kamar luas dengan pemandangan kota dan fasilitas lengkap.</p>
                        <div class="d-flex justify-content-between mb-3">
                            <small><i class="fas fa-users me-1"></i> Maks 2 orang</small>
                            <small><i class="fas fa-bed me-1"></i> 1 King Bed</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Kamar Deluxe', '<?= base_url('images/kamardeluxe.jpg') ?>', '<?= base_url('images/kamardeluxe2.jpg') ?>', '<?= base_url('images/kamarmandideluxe.jpg') ?>', 'Rasakan kemewahan dan kenyamanan di Kamar Deluxe kami dengan pemandangan kota yang menakjubkan.', 'Rp 1.200.000/malam')">Detail</button>
                            <button class="btn btn-primary btn-sm" onclick="addToCartQuick('Kamar Deluxe', 1200000, 'kamardeluxe.jpg')">
                                <i class="fas fa-cart-plus me-1"></i>Pesan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Suite Room -->
            <div class="col-md-4">
                <div class="card room-card h-100">
                    <img src="<?= base_url('images/kamarsuite.jpg') ?>" class="card-img-top" alt="Suite Room">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0 flex-grow-1">Suite Room</h5>
                            <span class="badge bg-accent price-badge">Rp 2.000.000/malam</span>
                        </div>
                        <p class="card-text text-muted">Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.</p>
                        <div class="d-flex justify-content-between mb-3">
                            <small><i class="fas fa-users me-1"></i> Maks 4 orang</small>
                            <small><i class="fas fa-bed me-1"></i> 1 King Bed + Sofa Bed</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Suite Room', '<?= base_url('images/kamarsuite.jpg') ?>', '<?= base_url('images/kamarsuite2.jpg') ?>', '<?= base_url('images/kamarmandisuite.jpg') ?>', 'Nikmati kemewahan tingkat suite dengan ruang tamu terpisah dan fasilitas premium.', 'Rp 2.000.000/malam')">Detail</button>
                            <button class="btn btn-primary btn-sm" onclick="addToCartQuick('Suite Room', 2000000, 'kamarsuite.jpg')">
                                <i class="fas fa-cart-plus me-1"></i>Pesan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Family Room -->
            <div class="col-md-4">
                <div class="card room-card h-100">
                    <img src="<?= base_url('images/kamarfamilyroom.jpg') ?>" class="card-img-top" alt="Family Room">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0 flex-grow-1">Kamar Keluarga</h5>
                            <span class="badge bg-accent price-badge">Rp 1.800.000/malam</span>
                        </div>
                        <p class="card-text text-muted">Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.</p>
                        <div class="d-flex justify-content-between mb-3">
                            <small><i class="fas fa-users me-1"></i> Maks 5 orang</small>
                            <small><i class="fas fa-bed me-1"></i> 2 Queen Beds</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Kamar Keluarga', '<?= base_url('images/kamarfamilyroom.jpg') ?>', '<?= base_url('images/kamarfamily2.jpg') ?>', '<?= base_url('images/kamarmandifamily.jpg') ?>', 'Kamar yang sempurna untuk liburan keluarga dengan ruang yang luas dan fasilitas ramah anak.', 'Rp 1.800.000/malam')">Detail</button>
                            <button class="btn btn-primary btn-sm" onclick="addToCartQuick('Kamar Keluarga', 1800000, 'kamarfamilyroom.jpg')">
                                <i class="fas fa-cart-plus me-1"></i>Pesan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Executive Room -->
            <div class="col-md-4">
                <div class="card room-card h-100">
                    <img src="<?= base_url('images/kamareksekutif.jpg') ?>" class="card-img-top" alt="Executive Room">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0 flex-grow-1">Kamar Eksekutif</h5>
                            <span class="badge bg-accent price-badge">Rp 1.500.000/malam</span>
                        </div>
                        <p class="card-text text-muted">Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.</p>
                        <div class="d-flex justify-content-between mb-3">
                            <small><i class="fas fa-users me-1"></i> Maks 2 orang</small>
                            <small><i class="fas fa-bed me-1"></i> 1 King Bed</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Kamar Eksekutif', '<?= base_url('images/kamareksekutif.jpg') ?>', '<?= base_url('images/kamareksekutif2.jpg') ?>', '<?= base_url('images/kamarmandieksekutif.jpg') ?>', 'Rasakan pengalaman menginap eksklusif dengan akses lounge eksekutif dan layanan butler premium.', 'Rp 1.500.000/malam')">Detail</button>
                            <button class="btn btn-primary btn-sm" onclick="addToCartQuick('Kamar Eksekutif', 1500000, 'kamareksekutif.jpg')">
                                <i class="fas fa-cart-plus me-1"></i>Pesan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Penthouse -->
            <div class="col-md-4">
                <div class="card room-card h-100">
                    <img src="<?= base_url('images/kamarpenthouse.jpg') ?>" class="card-img-top" alt="Penthouse">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0 flex-grow-1">Penthouse</h5>
                            <span class="badge bg-accent price-badge">Rp 3.500.000/malam</span>
                        </div>
                        <p class="card-text text-muted">Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.</p>
                        <div class="d-flex justify-content-between mb-3">
                            <small><i class="fas fa-users me-1"></i> Maks 6 orang</small>
                            <small><i class="fas fa-bed me-1"></i> 2 King Beds</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Penthouse', '<?= base_url('images/kamarpenthouse.jpg') ?>', '<?= base_url('images/kamarpenthouse2.jpg') ?>', '<?= base_url('images/kamarmandipenthouse.jpg') ?>', 'Pengalaman menginap tak terlupakan di puncak kemewahan dengan pemandangan panorama 360°.', 'Rp 3.500.000/malam')">Detail</button>
                            <button class="btn btn-primary btn-sm" onclick="addToCartQuick('Penthouse', 3500000, 'kamarpenthouse.jpg')">
                                <i class="fas fa-cart-plus me-1"></i>Pesan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('partials/modals/choose_room_modal') ?>
<?= $this->include('partials/modals/room_detail_modal') ?>

<script>
function addToCartQuick(roomName, price, image) {
    <?php if (!session()->get('logged_in')): ?>
        showAlert('error', 'Silakan login terlebih dahulu untuk melakukan booking!');
        return;
    <?php endif; ?>

    if (typeof showBookingModal === 'function') {
        showBookingModal(roomName, price, image);
    } else {
        showAlert('error', 'Sistem booking sedang loading, silakan coba lagi');
    }
}

function showRoomDetail(roomName, mainImage, image2, image3, description, price) {
    document.getElementById('modalRoomTitle').textContent = roomName;
    document.getElementById('modalRoomImg1').src = mainImage;
    document.getElementById('modalRoomImg2').src = image2;
    document.getElementById('modalRoomImg3').src = image3;
    document.getElementById('modalRoomDesc').textContent = description;
    document.getElementById('modalRoomPrice').textContent = price;
    
    const modal = new bootstrap.Modal(document.getElementById('roomDetailModal'));
    modal.show();
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}
</script>

<style>
.price-badge {
    font-size: 0.875rem !important;
    font-weight: 600 !important;
    white-space: nowrap !important;
    padding: 6px 12px !important;
    
    transform: none !important;
    transition: none !important;
    animation: none !important;
    scale: 1 !important;
    
    position: relative !important;
    z-index: 999 !important;
    will-change: unset !important;
    backface-visibility: visible !important;
    transform-origin: center !important;
    transform-style: flat !important;
}

.room-card:hover .price-badge,
.card:hover .price-badge,
.card-body:hover .price-badge,
*:hover .price-badge {
    transform: none !important;
    transition: none !important;
    animation: none !important;
    scale: 1 !important;
}

.badge.bg-accent {
    transform: none !important;
    transition: none !important;
    animation: none !important;
}

.d-flex.justify-content-between.align-items-start {
    align-items: flex-start !important;
    position: relative;
}

.d-flex.justify-content-between.align-items-start .price-badge {
    flex-shrink: 0 !important;
    margin-left: auto !important;
    transform: none !important;
}
.room-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.room-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.price-badge {
    isolation: isolate !important;
    contain: layout style paint !important;
}

.price-badge,
.price-badge::before,
.price-badge::after,
.badge.price-badge,
.bg-accent.price-badge,
span.price-badge {
    transform: none !important;
    transition: none !important;
    animation: none !important;
    scale: none !important;
    rotate: none !important;
    translate: none !important;
    filter: none !important;
    backdrop-filter: none !important;
}
</style>
