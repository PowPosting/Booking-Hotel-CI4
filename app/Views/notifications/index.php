<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">
                        <i class="fas fa-bell me-2"></i>Notifikasi
                    </h2>
                    <p class="text-muted mb-0">
                        <?= count($notifications ?? []) ?> total notifikasi
                        <?php 
                        $unread_count = $unread_count ?? 0;
                        if ($unread_count > 0): 
                        ?>
                            • <span class="text-warning"><?= $unread_count ?> belum dibaca</span>
                        <?php endif; ?>
                    </p>
                </div>
                
                <?php if (!empty($notifications ?? [])): ?>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-cog me-2"></i>Aksi
                    </button>
                    <ul class="dropdown-menu">
                        <?php if ($unread_count > 0): ?>
                        <li>
                            <a class="dropdown-item" href="#" onclick="markAllAsRead()">
                                <i class="fas fa-check-double me-2"></i>Tandai Semua Sudah Dibaca
                            </a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="clearAllNotifications()">
                                <i class="fas fa-trash me-2"></i>Hapus Semua
                            </a>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>

            <!-- Notifications List -->
            <div id="notificationsList">
                <?php if (empty($notifications ?? [])): ?>
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <i class="fas fa-bell-slash text-muted" style="font-size: 4rem;"></i>
                        <h4 class="text-muted mt-3">Tidak Ada Notifikasi</h4>
                        <p class="text-muted">Notifikasi akan muncul di sini ketika ada aktivitas baru di akun Anda.</p>
                        <a href="<?= site_url('/') ?>" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach ($notifications as $index => $notification): ?>
                    <div class="card mb-3 notification-card <?= !($notification['read'] ?? false) ? 'unread' : '' ?>" 
                         data-index="<?= $index ?>">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <!-- Icon -->
                                <div class="notification-icon me-3">
                                    <?php 
                                    $type = $notification['type'] ?? 'info';
                                    $iconClass = '';
                                    $bgClass = '';
                                    
                                    switch($type) {
                                        case 'success':
                                            $iconClass = 'fas fa-check-circle';
                                            $bgClass = 'bg-success';
                                            break;
                                        case 'warning':
                                            $iconClass = 'fas fa-exclamation-triangle';
                                            $bgClass = 'bg-warning';
                                            break;
                                        case 'danger':
                                            $iconClass = 'fas fa-exclamation-circle';
                                            $bgClass = 'bg-danger';
                                            break;
                                        default:
                                            $iconClass = 'fas fa-info-circle';
                                            $bgClass = 'bg-info';
                                    }
                                    ?>
                                    <div class="rounded-circle <?= $bgClass ?> bg-opacity-10 p-2">
                                        <i class="<?= $iconClass ?> <?= str_replace('bg-', 'text-', $bgClass) ?>"></i>
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="fw-bold mb-0"><?= htmlspecialchars($notification['title'] ?? 'Notifikasi') ?></h6>
                                        <div class="d-flex align-items-center">
                                            <?php if (!($notification['read'] ?? false)): ?>
                                                <span class="badge bg-primary me-2">Baru</span>
                                            <?php endif; ?>
                                            <small class="text-muted">
                                                <?php
                                                $created_at = $notification['created_at'] ?? date('Y-m-d H:i:s');
                                                $time_diff = time() - strtotime($created_at);
                                                
                                                if ($time_diff < 60) {
                                                    echo 'Baru saja';
                                                } elseif ($time_diff < 3600) {
                                                    echo floor($time_diff / 60) . ' menit yang lalu';
                                                } elseif ($time_diff < 86400) {
                                                    echo floor($time_diff / 3600) . ' jam yang lalu';
                                                } else {
                                                    echo floor($time_diff / 86400) . ' hari yang lalu';
                                                }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <p class="text-muted mb-2"><?= htmlspecialchars($notification['message'] ?? '') ?></p>
                                    
                                    <!-- Additional Data -->
                                    <?php if (!empty($notification['data'])): ?>
                                    <div class="additional-data mt-2">
                                        <small class="text-muted d-block mb-1">Detail:</small>
                                        <div class="bg-light rounded p-2">
                                            <?php foreach ($notification['data'] as $key => $value): ?>
                                                <div class="d-flex justify-content-between small">
                                                    <span class="text-muted"><?= ucfirst(str_replace('_', ' ', $key)) ?>:</span>
                                                    <span class="fw-bold">
                                                        <?php if (is_numeric($value) && $value > 1000000): ?>
                                                            Rp <?= number_format($value, 0, ',', '.') ?>
                                                        <?php else: ?>
                                                            <?= htmlspecialchars($value) ?>
                                                        <?php endif; ?>
                                                    </span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <!-- Actions -->
                                    <div class="mt-3">
                                        <?php if (!($notification['read'] ?? false)): ?>
                                            <button class="btn btn-outline-primary btn-sm me-2" 
                                                    onclick="markAsRead(<?= $index ?>)">
                                                <i class="fas fa-check me-1"></i>Tandai Sudah Dibaca
                                            </button>
                                        <?php endif; ?>
                                        <button class="btn btn-outline-danger btn-sm" 
                                                onclick="deleteNotification(<?= $index ?>)">
                                            <i class="fas fa-trash me-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.notification-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.notification-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.notification-card.unread {
    border-left: 4px solid #0d6efd;
    background: rgba(13, 110, 253, 0.02);
}

.notification-icon {
    min-width: 40px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {

// Mark single notification as read
function markAsRead(index) {
    const formData = new FormData();
    formData.append('index', index);
    
    fetch('<?= site_url('notifications/mark-read') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove unread styling
            const card = document.querySelector(`[data-index="${index}"]`);
            if (card) {
                card.classList.remove('unread');
                card.querySelector('.badge.bg-primary')?.remove();
                card.querySelector('.btn-outline-primary')?.remove();
            }
            
            showAlert('success', data.message);
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan');
    });
}

// Delete single notification
function deleteNotification(index) {
    if (!confirm('Yakin ingin menghapus notifikasi ini?')) return;
    
    const formData = new FormData();
    formData.append('index', index);
    
    fetch('<?= site_url('notifications/delete') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove card
            const card = document.querySelector(`[data-index="${index}"]`);
            if (card) {
                card.remove();
            }
            
            showAlert('success', data.message);
            
            // Reload if no notifications left
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan');
    });
}

// Mark all as read
function markAllAsRead() {
    fetch('<?= site_url('notifications/mark-all-read') ?>', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan');
    });
}

// Clear all notifications
function clearAllNotifications() {
    if (!confirm('Yakin ingin menghapus SEMUA notifikasi? Tindakan ini tidak dapat dibatalkan.')) return;
    
    fetch('<?= site_url('notifications/clear-all') ?>', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan');
    });
}

// Make functions global so they can be called from HTML
window.markAsRead = markAsRead;
window.deleteNotification = deleteNotification;
window.markAllAsRead = markAllAsRead;
window.clearAllNotifications = clearAllNotifications;

});
</script>

<?= $this->endSection() ?>
