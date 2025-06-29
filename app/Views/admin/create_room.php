<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Tambah Kamar' ?> - LuxStay Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Poppins', sans-serif; }
        .card { border: none; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .card-header { border-radius: 16px 16px 0 0; }
        .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25); }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; }
        .btn-primary:hover { background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%); }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Kamar Baru
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Back Button -->
                        <div class="mb-3">
                            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                            </a>
                        </div>

                        <!-- Alert Messages -->
                        <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Validation Errors:</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <!-- Form -->
                        <form action="<?= base_url('admin/rooms/create') ?>" method="POST">
                            <?= csrf_field() ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="room_type" class="form-label">
                                            <i class="fas fa-bed me-1"></i>Tipe Kamar <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="room_type" name="room_type" required>
                                            <option value="">Pilih Tipe Kamar</option>
                                            <option value="Kamar Standard" <?= old('room_type') == 'Kamar Standard' ? 'selected' : '' ?>>Kamar Standard</option>
                                            <option value="Kamar Deluxe" <?= old('room_type') == 'Kamar Deluxe' ? 'selected' : '' ?>>Kamar Deluxe</option>
                                            <option value="Suite Room" <?= old('room_type') == 'Suite Room' ? 'selected' : '' ?>>Suite Room</option>
                                            <option value="Executive Suite" <?= old('room_type') == 'Executive Suite' ? 'selected' : '' ?>>Executive Suite</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="room_number" class="form-label">
                                            <i class="fas fa-door-open me-1"></i>Nomor Kamar <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="room_number" name="room_number" 
                                               value="<?= old('room_number') ?>" placeholder="e.g., S101, D201" required>
                                        <div class="form-text">Format: S101 (Standard), D201 (Deluxe), SU301 (Suite)</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">
                                    <i class="fas fa-money-bill me-1"></i>Harga per Malam <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="price" name="price" 
                                           value="<?= old('price') ?>" placeholder="800000" min="0" step="1000" required>
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    <i class="fas fa-edit me-1"></i>Deskripsi Kamar
                                </label>
                                <textarea class="form-control" id="description" name="description" rows="4" 
                                          placeholder="Deskripsikan fasilitas dan keunggulan kamar..."><?= old('description') ?></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-secondary me-md-2">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Kamar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto format price input
        document.getElementById('price').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            if (value) {
                // Round to nearest thousand
                value = Math.round(value / 1000) * 1000;
                e.target.value = value;
            }
        });

        // Auto generate room number suggestion
        document.getElementById('room_type').addEventListener('change', function(e) {
            const roomNumberField = document.getElementById('room_number');
            const type = e.target.value;
            
            if (type && !roomNumberField.value) {
                let prefix = '';
                switch(type) {
                    case 'Kamar Standard': prefix = 'S1'; break;
                    case 'Kamar Deluxe': prefix = 'D2'; break;
                    case 'Suite Room': prefix = 'SU3'; break;
                    case 'Executive Suite': prefix = 'EX4'; break;
                }
                
                if (prefix) {
                    roomNumberField.placeholder = `e.g., ${prefix}01, ${prefix}02`;
                }
            }
        });
    </script>
</body>
</html>
