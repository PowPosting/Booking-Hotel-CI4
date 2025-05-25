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
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Kamar Standard</h5>
                                <span class="badge bg-accent">Rp 800.000/malam</span>
                            </div>
                            <p class="card-text text-muted">Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.</p>
                            <div class="d-flex justify-content-between mb-3">
                                <small><i class="fas fa-users me-1"></i> Maks 2 orang</small>
                                <small><i class="fas fa-bed me-1"></i> 1 Queen Bed</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button
                                    class="btn btn-outline-primary btn-sm"
                                    onclick="showRoomDetail(
                                        'Kamar Standard',
                                        '<?= base_url('images/Kamarstandar.jpg') ?>',
                                        '<?= base_url('images/kamarstandar2.jpg') ?>',
                                        '<?= base_url('images/kamarmandistandar.jpg') ?>',
                                        'Nikmati kenyamanan maksimal di Kamar Standard kami, dilengkapi dengan fasilitas esensial yang dirancang untuk memberikan pengalaman menginap yang tenang dan menyenangkan. Cocok untuk pelancong solo maupun pasangan, kamar ini menghadirkan suasana hangat dan fungsional untuk istirahat yang berkualitas.',
                                        'Rp 800.000/malam'
                                    )"
                                    >Detail</button>
                                <button class="btn btn-primary btn-sm" onclick="showChooseRoomModal('Kamar Standard')">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Deluxe Room -->
                <div class="col-md-4">
                    <div class="card room-card h-100">
                        <img src="<?= base_url('images/kamardeluxe.jpg') ?>" class="card-img-top" alt="Deluxe Room">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Kamar Deluxe</h5>
                                <span class="badge bg-accent">Rp 1.200.000/malam</span>
                            </div>
                            <p class="card-text text-muted">Kamar luas dengan pemandangan kota dan fasilitas lengkap.</p>
                            <div class="d-flex justify-content-between mb-3">
                                <small><i class="fas fa-users me-1"></i> Maks 2 orang</small>
                                <small><i class="fas fa-bed me-1"></i> 1 King Bed</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail(
                                    'Kamar Deluxe',
                                    '/app/Views/src/images/kamardeluxe.jpg',
                                    'Kamar luas dengan pemandangan kota dan fasilitas lengkap.',
                                    'Rp 1.200.000/malam'
                                )">Detail</button>
                                <button class="btn btn-primary btn-sm" onclick="showChooseRoomModal('Kamar Deluxe')">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Suite Room -->
                <div class="col-md-4">
                    <div class="card room-card h-100">
                        <img src="<?= base_url('images/kamarsuite.jpg') ?>" class="card-img-top" alt="Suite Room">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Suite Room</h5>
                                <span class="badge bg-accent">Rp 2.000.000/malam</span>
                            </div>
                            <p class="card-text text-muted">Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.</p>
                            <div class="d-flex justify-content-between mb-3">
                                <small><i class="fas fa-users me-1"></i> Maks 4 orang</small>
                                <small><i class="fas fa-bed me-1"></i> 1 King Bed + Sofa Bed</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Suite Room')">Detail</button>
                                <button class="btn btn-primary btn-sm" onclick="showChooseRoomModal('Suite Room')">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Family Room -->
                <div class="col-md-4">
                    <div class="card room-card h-100">
                        <img src="<?= base_url('images/kamarfamilyroom.jpg') ?>" class="card-img-top" alt="Family Room">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Kamar Keluarga</h5>
                                <span class="badge bg-accent">Rp 1.800.000/malam</span>
                            </div>
                            <p class="card-text text-muted">Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.</p>
                            <div class="d-flex justify-content-between mb-3">
                                <small><i class="fas fa-users me-1"></i> Maks 5 orang</small>
                                <small><i class="fas fa-bed me-1"></i> 2 Queen Beds</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Kamar Keluarga')">Detail</button>
                                <button class="btn btn-primary btn-sm" onclick="showChooseRoomModal('Kamar Keluarga')">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Executive Room -->
                <div class="col-md-4">
                    <div class="card room-card h-100">
                        <img src="<?= base_url('images/kamareksekutif.jpg') ?>" class="card-img-top" alt="Executive Room">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Kamar Eksekutif</h5>
                                <span class="badge bg-accent">Rp 1.500.000/malam</span>
                            </div>
                            <p class="card-text text-muted">Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.</p>
                            <div class="d-flex justify-content-between mb-3">
                                <small><i class="fas fa-users me-1"></i> Maks 2 orang</small>
                                <small><i class="fas fa-bed me-1"></i> 1 King Bed</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Kamar Eksekutif')">Detail</button>
                                <button class="btn btn-primary btn-sm" onclick="showChooseRoomModal('Kamar Eksekutif')">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Penthouse -->
                <div class="col-md-4">
                    <div class="card room-card h-100">
                        <img src="<?= base_url('images/kamarpenthouse.jpg') ?>" class="card-img-top" alt="Penthouse">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Penthouse</h5>
                                <span class="badge bg-accent">Rp 3.500.000/malam</span>
                            </div>
                            <p class="card-text text-muted">Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.</p>
                            <div class="d-flex justify-content-between mb-3">
                                <small><i class="fas fa-users me-1"></i> Maks 6 orang</small>
                                <small><i class="fas fa-bed me-1"></i> 2 King Beds</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-primary btn-sm" onclick="showRoomDetail('Penthouse')">Detail</button>
                                <button class="btn btn-primary btn-sm" onclick="showChooseRoomModal('Penthouse')">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?= $this->include('partials/modals/choose_room_modal') ?>

    <script>
        // JavaScript code to filter available rooms by type
        let kamarTipeIni = kamarTersedia.filter(r => r.room_type === roomType);
    </script>
