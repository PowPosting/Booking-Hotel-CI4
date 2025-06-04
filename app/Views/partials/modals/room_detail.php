<?php
?>
<div class="modal fade" id="roomDetailModal" tabindex="-1" aria-labelledby="roomDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-0 bg-gradient-primary text-white">
        <h4 class="modal-title fw-bold" id="modalRoomTitle">
          <i class="fas fa-bed me-2"></i>Detail Kamar
        </h4>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <!-- Image Gallery Section -->
        <div class="position-relative">
          <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img id="modalRoomImg1" src="" alt="Room Image 1" class="d-block w-100" style="height: 350px; object-fit: cover;">
              </div>
              <div class="carousel-item">
                <img id="modalRoomImg2" src="" alt="Room Image 2" class="d-block w-100" style="height: 350px; object-fit: cover;">
              </div>
              <div class="carousel-item">
                <img id="modalRoomImg3" src="" alt="Room Image 3" class="d-block w-100" style="height: 350px; object-fit: cover;">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          <!-- Price Badge -->
          <div class="position-absolute top-0 end-0 m-3">
            <span id="modalRoomPrice" class="badge bg-accent fs-5 px-3 py-2 rounded-pill shadow"></span>
          </div>
        </div>

        <!-- Content Section -->
        <div class="p-4">
          <div class="row">
            <div class="col-lg-8">
              <!-- Description -->
              <div class="mb-4">
                <h5 class="fw-bold text-primary mb-3">
                  <i class="fas fa-info-circle me-2"></i>Deskripsi Kamar
                </h5>
                <p id="modalRoomDesc" class="text-muted lh-lg"></p>
              </div>

              <!-- Facilities -->
              <div class="mb-4">
                <h6 class="fw-bold text-primary mb-3">
                  <i class="fas fa-star me-2"></i>Fasilitas Kamar
                </h6>
                <div class="row g-2">
                  <div class="col-6 col-md-4">
                    <div class="d-flex align-items-center mb-2">
                      <i class="fas fa-wifi text-success me-2"></i>
                      <small>WiFi Gratis</small>
                    </div>
                  </div>
                  <div class="col-6 col-md-4">
                    <div class="d-flex align-items-center mb-2">
                      <i class="fas fa-tv text-success me-2"></i>
                      <small>Smart TV</small>
                    </div>
                  </div>
                  <div class="col-6 col-md-4">
                    <div class="d-flex align-items-center mb-2">
                      <i class="fas fa-snowflake text-success me-2"></i>
                      <small>AC</small>
                    </div>
                  </div>
                  <div class="col-6 col-md-4">
                    <div class="d-flex align-items-center mb-2">
                      <i class="fas fa-coffee text-success me-2"></i>
                      <small>Minibar</small>
                    </div>
                  </div>
                  <div class="col-6 col-md-4">
                    <div class="d-flex align-items-center mb-2">
                      <i class="fas fa-bath text-success me-2"></i>
                      <small>Bathtub</small>
                    </div>
                  </div>
                  <div class="col-6 col-md-4">
                    <div class="d-flex align-items-center mb-2">
                      <i class="fas fa-concierge-bell text-success me-2"></i>
                      <small>Room Service</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <!-- Room Info Card -->
              <div class="card border-0 bg-light h-100">
                <div class="card-body">
                  <h6 class="fw-bold text-primary mb-3">
                    <i class="fas fa-clipboard-list me-2"></i>Informasi Kamar
                  </h6>
                  
                  <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                      <small class="text-muted">Kapasitas:</small>
                      <small class="fw-bold" id="modalRoomCapacity">2 Orang</small>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <small class="text-muted">Tipe Tempat Tidur:</small>
                      <small class="fw-bold" id="modalRoomBed">1 King Bed</small>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <small class="text-muted">Ukuran Kamar:</small>
                      <small class="fw-bold">35 m²</small>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <small class="text-muted">Pemandangan:</small>
                      <small class="fw-bold">Kota/Taman</small>
                    </div>
                  </div>

                  <!-- Rating -->
                  <div class="mb-3">
                    <small class="text-muted d-block mb-1">Rating Tamu:</small>
                    <div class="d-flex align-items-center">
                      <div class="text-warning me-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                      </div>
                      <small class="fw-bold">4.8/5</small>
                    </div>
                  </div>

                  <!-- Action Buttons -->
                  <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-sm" onclick="document.querySelector('.modal .btn-close').click(); showChooseRoomModal(document.getElementById('modalRoomTitle').textContent);">
                      <i class="fas fa-calendar-check me-2"></i>Pesan Sekarang
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                      <i class="fas fa-heart me-2"></i>Simpan ke Favorit
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.text-accent {
    color: #667eea !important;
}

.bg-accent {
    background-color: #667eea !important;
}

.carousel-control-prev, .carousel-control-next {
    width: 5%;
}

.carousel-control-prev-icon, .carousel-control-next-icon {
    background-size: 20px 20px;
}

.modal-xl {
    max-width: 1140px;
}

@media (max-width: 768px) {
    .modal-xl {
        max-width: 95%;
        margin: 1rem;
    }
}
</style>