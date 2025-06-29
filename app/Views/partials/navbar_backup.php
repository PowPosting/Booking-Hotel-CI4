<?php
// Get notifications for this component
$notifications = session()->get('notifications') ?? [];
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('/') ?>"><i class="fas fa-hotel me-2"></i>LuxStay</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#rooms">Kamar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#facilities">Fasilitas</a>
                </li>
            </ul>
            <?php $session = session(); ?>
            <div class="d-flex align-items-center">
                <?php if ($session->get('logged_in')): ?>
                    <!-- Keranjang/Booking Icon -->
                    <div class="dropdown me-3">
                        <button class="btn btn-outline-secondary position-relative" type="button" id="cartDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-shopping-cart"></i>
                            <!-- Badge untuk jumlah booking -->
                            <?php 
                            $cartItems = session()->get('cart_items') ?? [];
                            $cartCount = count($cartItems);
                            ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                                  id="cart-count" style="<?= $cartCount > 0 ? '' : 'display: none;' ?>">
                                <?= $cartCount ?>
                                <span class="visually-hidden">booking items</span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="cartDropdown" style="min-width: 350px;">
                            <div class="dropdown-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Booking Saya</h6>
                                <small class="text-muted" id="cart-item-count"><?= $cartCount ?> item</small>
                            </div>
                            <div class="dropdown-divider"></div>
                            
                            <div id="cart-content">
                                <?php if (empty($cartItems)): ?>
                                    <!-- Empty Cart State -->
                                    <div class="text-center py-4">
                                        <i class="fas fa-shopping-cart text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted mt-2 mb-0">Keranjang booking kosong</p>
                                        <small class="text-muted">Tambahkan kamar untuk booking</small>
                                    </div>
                                <?php else: ?>
                                    <!-- Cart Items -->
                                    <?php 
                                    $total = 0;
                                    foreach ($cartItems as $index => $item): 
                                        // Calculate correct total price (price per night * nights)
                                        $itemTotal = isset($item['total_price']) ? $item['total_price'] : $item['price'];
                                        $total += $itemTotal;
                                        $nights = isset($item['nights']) ? $item['nights'] : 1;
                                    ?>
                                    <div class="cart-item px-3 py-2 border-bottom" data-index="<?= $index ?>">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url('images/' . ($item['image'] ?? 'default-room.jpg')) ?>" 
                                                 alt="Room" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;" class="me-3">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fs-6"><?= htmlspecialchars($item['room_name']) ?></h6>
                                                <small class="text-muted d-block">
                                                    <?= date('d M', strtotime($item['check_in'])) ?> - <?= date('d M Y', strtotime($item['check_out'])) ?>
                                                </small>
                                                <small class="text-muted d-block"><?= $nights ?> malam, <?= $item['guests'] ?? 2 ?> tamu</small>
                                                
                                                <!-- Facilities -->
                                                <?php if (!empty($item['facilities'])): ?>
                                                    <small class="text-success d-block">
                                                        <i class="fas fa-plus-circle me-1"></i>
                                                        <?= count($item['facilities']) ?> fasilitas tambahan
                                                    </small>
                                                <?php endif; ?>
                                                
                                                <div class="fw-bold text-primary">
                                                    Rp <?= number_format($itemTotal, 0, ',', '.') ?>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-outline-danger" 
                                                    onclick="removeFromCart(<?= $index ?>)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    
                                    <div class="p-3">
                                        <?php 
                                        $appliedPromo = session()->get('applied_promo');
                                        $discount = $appliedPromo ? $appliedPromo['discount'] : 0;
                                        $finalTotal = $total - $discount;
                                        ?>
                                        
                                        <?php if ($discount > 0): ?>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Subtotal:</span>
                                            <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2 text-success">
                                            <span>Diskon (<?= $appliedPromo['code'] ?>):</span>
                                            <span>-Rp <?= number_format($discount, 0, ',', '.') ?></span>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="fw-bold">Total:</span>
                                            <span class="fw-bold text-primary">Rp <?= number_format($finalTotal, 0, ',', '.') ?></span>
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-primary btn-sm" onclick="proceedToCheckout()">
                                                <i class="fas fa-credit-card me-2"></i>Checkout
                                            </button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Icon -->
                    <div class="dropdown me-3">
                        <a class="nav-link" href="#" id="notificationDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <?php 
                            $notifications = session()->get('notifications') ?? [];
                            $unreadCount = count(array_filter($notifications, function($notif) { 
                                return isset($notif['read']) ? !$notif['read'] : true; 
                            }));
                            ?>
                            <span class="badge bg-danger" id="notification-count" style="<?= $unreadCount > 0 ? '' : 'display: none;' ?>">
                                <?= $unreadCount ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="notificationDropdown" style="min-width: 320px;">
                            <div class="dropdown-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Notifikasi</h6>
                                <small class="text-muted"><?= $unreadCount ?> baru</small>
                            </div>
                            <div class="dropdown-divider"></div>
                            
                            <?php if (empty($notifications)): ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-bell-slash text-muted" style="font-size: 2rem;"></i>
                                    <p class="text-muted mt-2 mb-0">Tidak ada notifikasi</p>
                                    <small class="text-muted">Notifikasi akan muncul di sini</small>
                                </div>
                            <?php else: ?>
                                <?php foreach (array_slice($notifications, 0, 3) as $index => $notif): ?>
                                <a href="#" class="dropdown-item px-3 py-2 border-bottom notification-item" 
                                   onclick="showNotificationDetail(<?= $index ?>, event)">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-<?= ($notif['type'] ?? 'info') === 'success' ? 'success' : (($notif['type'] ?? 'info') === 'info' ? 'info' : 'warning') ?> rounded-circle me-3 mt-1" style="width: 8px; height: 8px;"></div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fs-6"><?= htmlspecialchars($notif['title'] ?? 'Notification') ?></h6>
                                            <p class="mb-1 small text-muted"><?= htmlspecialchars(substr($notif['message'] ?? '', 0, 60)) ?><?= strlen($notif['message'] ?? '') > 60 ? '...' : '' ?></p>
                                            <small class="text-muted"><?= time_elapsed_string($notif['created_at'] ?? date('Y-m-d H:i:s')) ?></small>
                                        </div>
                                        <?php if (!($notif['read'] ?? false)): ?>
                                        <div class="badge bg-primary rounded-pill" style="font-size: 6px; width: 8px; height: 8px;"></div>
                                        <?php endif; ?>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                                
                                <div class="p-3">
                                    <div class="d-grid gap-2">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <button class="btn btn-outline-secondary btn-sm w-100" onclick="markAllNotificationsAsRead()">
                                                    <i class="fas fa-check-double me-1"></i>
                                                    <small>Tandai Semua</small>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <a href="<?= site_url('notifications') ?>" class="btn btn-outline-primary btn-sm w-100">
                                                    <i class="fas fa-eye me-1"></i>
                                                    <small>Lihat Semua</small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i><?= htmlspecialchars($session->get('username')) ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a href="<?= site_url('logout') ?>" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <button class="btn btn-outline-primary" id="loginButton"><i class="fas fa-user me-2"></i>Akun</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Notification Detail Modal -->
<div class="modal fade" id="notificationDetailModal" tabindex="-1" aria-labelledby="notificationDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0" id="notificationModalHeader">
                <h5 class="modal-title" id="notificationDetailModalLabel">
                    <i class="fas fa-bell me-2"></i>Detail Notifikasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Notification Icon & Type -->
                <div class="text-center mb-4">
                    <div class="notification-icon-container" id="notificationIconContainer">
                        <i class="fas fa-info-circle fa-3x text-info" id="notificationIcon"></i>
                    </div>
                </div>
                
                <!-- Notification Title -->
                <div class="text-center mb-3">
                    <h4 class="fw-bold text-dark" id="notificationTitle">Judul Notifikasi</h4>
                </div>
                
                <!-- Notification Message -->
                <div class="card border-0 bg-light mb-3">
                    <div class="card-body">
                        <p class="mb-0 text-dark" id="notificationMessage">Isi pesan notifikasi akan ditampilkan di sini...</p>
                    </div>
                </div>
                
                <!-- Notification Details -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock text-muted me-2"></i>
                            <div>
                                <small class="text-muted d-block">Waktu</small>
                                <span class="fw-bold" id="notificationTime">-</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-tag text-muted me-2"></i>
                            <div>
                                <small class="text-muted d-block">Tipe</small>
                                <span class="fw-bold" id="notificationType">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Data (if any) -->
                <div id="notificationAdditionalData" class="mt-3" style="display: none;">
                    <div class="card border-primary border-opacity-25">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="mb-0 text-primary">
                                <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="additionalDataContent"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary" id="markAsReadBtn" onclick="markNotificationAsRead()">
                    <i class="fas fa-check me-2"></i>Tandai Sudah Dibaca
                </button>
                <button type="button" class="btn btn-danger" id="deleteNotificationBtn" onclick="deleteNotification()">
                    <i class="fas fa-trash me-2"></i>Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom styling untuk dropdown notification dan cart */
.dropdown-menu {
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    border-radius: 8px;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.badge {
    font-size: 0.7em;
}

/* Animation untuk badge */
.badge {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: translateX(-50%) translateY(-50%) scale(1);
    }
    50% {
        transform: translateX(-50%) translateY(-50%) scale(1.1);
    }
    100% {
        transform: translateX(-50%) translateY(-50%) scale(1);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .dropdown-menu {
        min-width: 280px !important;
    }
    
    .d-flex.align-items-center > .dropdown {
        margin-right: 0.5rem !important;
    }
}

.notification-item {
    padding: 12px 16px;
    border-bottom: 1px solid #eee;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-icon {
    width: 20px;
    text-align: center;
}

.notification-content {
    min-width: 0;
}

.notification-title {
    font-size: 0.9rem;
    margin-bottom: 4px;
}

.notification-message {
    font-size: 0.8rem;
    line-height: 1.3;
}

.notification-time {
    font-size: 0.75rem;
}

.badge {
    font-size: 0.7rem;
}

.notification-icon-container {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(108, 117, 125, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    transition: all 0.3s ease;
}

.notification-icon-container.success {
    background: rgba(25, 135, 84, 0.1);
}

.notification-icon-container.info {
    background: rgba(13, 202, 240, 0.1);
}

.notification-icon-container.warning {
    background: rgba(255, 193, 7, 0.1);
}

.notification-icon-container.danger {
    background: rgba(220, 53, 69, 0.1);
}

.notification-item:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.notification-item.unread {
    background-color: rgba(13, 110, 253, 0.05);
    border-left: 3px solid #0d6efd;
}

.notification-detail-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
// JavaScript untuk menangani cart actions
function removeFromCart(index) {
    console.log('Removing index:', index); // **DEBUG**
    
    const formData = new FormData();
    formData.append('index', index); // Kirim sebagai integer

    fetch('<?= site_url('cart/remove') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response:', data); // **DEBUG**
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menghapus item');
    });
}

function addToCart(roomId, roomName, roomType, price, checkIn, checkOut, image, guests) {
    const formData = new FormData();
    formData.append('room_id', roomId);
    formData.append('room_name', roomName);
    formData.append('room_type', roomType);
    formData.append('price', price);
    formData.append('check_in', checkIn);
    formData.append('check_out', checkOut);
    formData.append('image', image || 'default-room.jpg'); // **PASTIKAN ADA IMAGE**
    formData.append('guests', guests || 2);
    
    // **TAMBAH GUEST INFO (kalau ada form)**
    formData.append('guest_name', document.getElementById('guest_name')?.value || 'Guest');
    formData.append('guest_email', document.getElementById('guest_email')?.value || 'guest@email.com');
    formData.append('guest_phone', document.getElementById('guest_phone')?.value || '08123456789');
    formData.append('special_requests', document.getElementById('special_requests')?.value || '');

    fetch('<?= site_url('cart/add') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount(data.cart_count);
            alert('Kamar berhasil ditambahkan ke keranjang!');
            location.reload();
        } else {
            alert(data.message || 'Gagal menambahkan ke keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menambahkan ke keranjang');
    });
}

function proceedToCheckout() {
    // Check if cart is not empty
    const cartCount = document.getElementById('cart-count');
    if (!cartCount || cartCount.textContent === '0') {
        alert('Keranjang masih kosong!');
        return;
    }
    
    // Close cart dropdown first
    const cartDropdown = bootstrap.Dropdown.getInstance(document.getElementById('cartDropdown'));
    if (cartDropdown) {
        cartDropdown.hide();
    }
    
    // Show checkout modal
    setTimeout(() => {
        showCheckoutModal();
    }, 300);
}

// Ganti function updateNotifications yang ada dengan ini:
function updateNotifications() {
    console.log('🔔 Fetching notifications...');
    
    fetch('<?= site_url('notifications') ?>')
    .then(r => r.json())
    .then(data => {
        console.log('🔔 Notification data:', data);
        
        if (data.success) {
            // Update global notifications data
            allNotifications = data.notifications;
            
            // Update badge
            const badge = document.getElementById('notification-count');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'inline-block';
                    console.log('🔔 Badge updated:', data.count);
                } else {
                    badge.style.display = 'none';
                }
            }
            
            // Update unread count text
            const unreadText = document.querySelector('#notificationDropdown + .dropdown-menu .dropdown-header small');
            if (unreadText) {
                unreadText.textContent = data.count + ' baru';
            }
            
            console.log('🔔 Notifications updated successfully');
        }
    })
    .catch(error => {
        console.error('🔔 Error fetching notifications:', error);
    });
}
                let html = `
                    <div class="dropdown-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Notifikasi</h6>
                        <small class="text-muted">${data.count} baru</small>
                    </div>
                    <div class="dropdown-divider"></div>
                `;
                
                data.notifications.forEach(notif => {
                    html += `
                        <a href="#" class="dropdown-item px-3 py-2 border-bottom">
                            <div class="d-flex align-items-start">
                                <div class="bg-success rounded-circle me-3 mt-1" style="width: 8px; height: 8px;"></div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fs-6">${notif.title}</h6>
                                    <p class="mb-1 small text-muted">${notif.message}</p>
                                    <small class="text-muted">${notif.time}</small>
                                </div>
                            </div>
                        </a>
                    `;
                });
                
                dropdown.innerHTML = html;
                console.log(' Dropdown updated');
            }
        }
    })
    .catch(e => {
        console.error(' Error fetching notifications:', e);
    });
}

// Load saat page ready
document.addEventListener('DOMContentLoaded', updateNotifications);

// Global function
window.updateNotifications = updateNotifications;

function loadNotifications() {
    if (!isLoggedIn) return;

    fetch('<?= base_url('booking/notifications') ?>')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateNotificationBadge(data.count);
                updateNotificationDropdown(data.notifications);
            }
        })
        .catch(error => console.error('Error loading notifications:', error));
}

function updateNotificationDropdown(notifications) {
    const dropdown = document.getElementById('notificationItems');
    if (!dropdown) return;

    if (notifications.length === 0) {
        dropdown.innerHTML = '<li><span class="dropdown-item-text text-muted">Tidak ada notifikasi</span></li>';
        return;
    }

    dropdown.innerHTML = notifications.map(notif => `
        <li>
            <a class="dropdown-item notification-item" href="${notif.url}">
                <div class="d-flex align-items-start">
                    <div class="notification-icon me-3">
                        <i class="${notif.status_icon} text-${notif.status_color}"></i>
                    </div>
                    <div class="notification-content flex-grow-1">
                        <div class="notification-title fw-bold">${notif.title}</div>
                        <div class="notification-status">
                            <span class="badge bg-${notif.status_color} mb-1">${notif.status_text}</span>
                        </div>
                        <div class="notification-message text-muted small">${notif.message}</div>
                        <div class="notification-time text-muted small mt-1">
                            <i class="fas fa-clock me-1"></i>${notif.time}
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
    `).join('');
}

// Global variable to store current notification data
let currentNotificationIndex = null;
let allNotifications = <?= json_encode(session()->get('notifications') ?? []) ?>;

// Show notification detail modal
function showNotificationDetail(index, event) {
    event.preventDefault();
    event.stopPropagation();
    
    currentNotificationIndex = index;
    const notification = allNotifications[index];
    
    if (!notification) {
        console.error('Notification not found:', index);
        return;
    }
    
    // Update modal content
    updateNotificationModal(notification);
    
    // Close dropdown
    const dropdown = bootstrap.Dropdown.getInstance(document.getElementById('notificationDropdown'));
    if (dropdown) {
        dropdown.hide();
    }
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('notificationDetailModal'));
    modal.show();
}

// Update notification modal content
function updateNotificationModal(notification) {
    // Update header color based on type
    const header = document.getElementById('notificationModalHeader');
    const iconContainer = document.getElementById('notificationIconContainer');
    const icon = document.getElementById('notificationIcon');
    
    // Reset classes
    header.className = 'modal-header border-0';
    iconContainer.className = 'notification-icon-container';
    
    // Set type-specific styling
    const type = notification.type || 'info';
    switch(type) {
        case 'success':
            header.classList.add('bg-success', 'text-white');
            iconContainer.classList.add('success');
            icon.className = 'fas fa-check-circle fa-3x text-success';
            break;
        case 'warning':
            header.classList.add('bg-warning', 'text-dark');
            iconContainer.classList.add('warning');
            icon.className = 'fas fa-exclamation-triangle fa-3x text-warning';
            break;
        case 'danger':
            header.classList.add('bg-danger', 'text-white');
            iconContainer.classList.add('danger');
            icon.className = 'fas fa-exclamation-circle fa-3x text-danger';
            break;
        default: // info
            header.classList.add('bg-info', 'text-white');
            iconContainer.classList.add('info');
            icon.className = 'fas fa-info-circle fa-3x text-info';
    }
    
    // Update content
    document.getElementById('notificationTitle').textContent = notification.title || 'Notifikasi';
    document.getElementById('notificationMessage').textContent = notification.message || 'Tidak ada pesan';
    document.getElementById('notificationTime').textContent = formatDateTime(notification.created_at);
    document.getElementById('notificationType').textContent = getTypeDisplayName(type);
    
    // Handle additional data
    const additionalDataDiv = document.getElementById('notificationAdditionalData');
    const additionalDataContent = document.getElementById('additionalDataContent');
    
    if (notification.data && typeof notification.data === 'object') {
        additionalDataDiv.style.display = 'block';
        let dataHtml = '';
        
        for (const [key, value] of Object.entries(notification.data)) {
            dataHtml += `
                <div class="row mb-2">
                    <div class="col-4">
                        <small class="text-muted">${formatDataKey(key)}:</small>
                    </div>
                    <div class="col-8">
                        <span class="fw-bold">${formatDataValue(value)}</span>
                    </div>
                </div>
            `;
        }
        
        additionalDataContent.innerHTML = dataHtml;
    } else {
        additionalDataDiv.style.display = 'none';
    }
    
    // Update buttons based on read status
    const markAsReadBtn = document.getElementById('markAsReadBtn');
    if (notification.read) {
        markAsReadBtn.style.display = 'none';
    } else {
        markAsReadBtn.style.display = 'inline-block';
    }
}

// Format date time for display
function formatDateTime(dateString) {
    if (!dateString) return '-';
    
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMins / 60);
    const diffDays = Math.floor(diffHours / 24);
    
    if (diffMins < 1) {
        return 'Baru saja';
    } else if (diffMins < 60) {
        return `${diffMins} menit yang lalu`;
    } else if (diffHours < 24) {
        return `${diffHours} jam yang lalu`;
    } else if (diffDays < 7) {
        return `${diffDays} hari yang lalu`;
    } else {
        return date.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
}

// Get display name for notification type
function getTypeDisplayName(type) {
    const typeNames = {
        'success': 'Berhasil',
        'info': 'Informasi',
        'warning': 'Peringatan',
        'danger': 'Penting'
    };
    return typeNames[type] || 'Informasi';
}

// Format data key for display
function formatDataKey(key) {
    const keyNames = {
        'booking_id': 'ID Booking',
        'room_number': 'Nomor Kamar',
        'check_in': 'Check-in',
        'check_out': 'Check-out',
        'total_price': 'Total Harga',
        'payment_method': 'Metode Pembayaran',
        'status': 'Status'
    };
    return keyNames[key] || key.replace('_', ' ').toUpperCase();
}

// Format data value for display
function formatDataValue(value) {
    if (typeof value === 'number' && value > 1000000) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
    }
    return value;
}

// Mark notification as read
function markNotificationAsRead() {
    if (currentNotificationIndex === null) return;
    
    fetch('<?= site_url('notifications/mark-read') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            index: currentNotificationIndex
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update local data
            allNotifications[currentNotificationIndex].read = true;
            
            // Hide button
            document.getElementById('markAsReadBtn').style.display = 'none';
            
            // Update notification count
            updateNotifications();
            
            showAlert('success', 'Notifikasi ditandai sebagai sudah dibaca');
        } else {
            showAlert('error', data.message || 'Gagal menandai notifikasi');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan');
    });
}

// Delete notification
function deleteNotification() {
    if (currentNotificationIndex === null) return;
    
    if (!confirm('Yakin ingin menghapus notifikasi ini?')) {
        return;
    }
    
    fetch('<?= site_url('notifications/delete') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            index: currentNotificationIndex
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('notificationDetailModal'));
            modal.hide();
            
            // Update notifications
            updateNotifications();
            
            showAlert('success', 'Notifikasi berhasil dihapus');
        } else {
            showAlert('error', data.message || 'Gagal menghapus notifikasi');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan');
    });
}

// Mark all notifications as read
function markAllNotificationsAsRead() {
    fetch('<?= site_url('notifications/mark-all-read') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update notification count
            updateNotifications();
            
            // Close dropdown
            const dropdown = bootstrap.Dropdown.getInstance(document.getElementById('notificationDropdown'));
            if (dropdown) {
                dropdown.hide();
            }
            
            showAlert('success', data.message || 'Semua notifikasi ditandai sebagai sudah dibaca');
        } else {
            showAlert('error', data.message || 'Gagal menandai notifikasi');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan');
    });
}

// Auto refresh notifications every 30 seconds
setInterval(updateNotifications, 30000);

// Make functions global so they can be called from HTML
window.removeFromCart = removeFromCart;
window.addToCart = addToCart;
window.proceedToCheckout = proceedToCheckout;
window.showNotificationDetail = showNotificationDetail;

});
</script>

<?php
// Helper function untuk time elapsed sudah ada di helper file
// Sample notifications sudah dihapus
?>
            'message' => 'Booking kamar Deluxe untuk tanggal 30 Juni 2025 telah berhasil dikonfirmasi. Silakan lakukan pembayaran dalam 24 jam.',
            'type' => 'success',
            'data' => [
                'booking_id' => 'BK001',
                'room_number' => 'D101',
                'check_in' => '2025-06-30',
                'check_out' => '2025-07-02',
                'total_price' => 1200000
            ],
            'read' => false,
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
        ],
        [
            'id' => uniqid(),
            'title' => 'Pembayaran Menunggu',
            'message' => 'Pembayaran untuk booking BK002 belum diterima. Harap segera lakukan pembayaran untuk menghindari pembatalan otomatis.',
            'type' => 'warning',
            'data' => [
                'booking_id' => 'BK002',
                'payment_method' => 'Bank Transfer',
                'amount' => 800000,
                'due_date' => '2025-06-30 23:59:59'
            ],
            'read' => false,
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ],
        [
            'id' => uniqid(),
            'title' => 'Promo Spesial',
            'message' => 'Dapatkan diskon 25% untuk booking weekend! Gunakan kode WEEKEND25 untuk mendapatkan potongan harga.',
            'type' => 'info',
            'data' => [
                'promo_code' => 'WEEKEND25',
                'discount' => '25%',
                'valid_until' => '2025-07-15'
            ],
            'read' => true,
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
        ],
        [
            'id' => uniqid(),
            'title' => 'Check-in Reminder',
            'message' => 'Pengingat: Check-in Anda untuk kamar Standard dijadwalkan besok pukul 14:00. Jangan lupa membawa kartu identitas.',
            'type' => 'info',
            'data' => [
                'booking_id' => 'BK003',
                'room_type' => 'Standard',
                'check_in_time' => '14:00',
                'check_in_date' => '2025-06-30'
            ],
            'read' => false,
            'created_at' => date('Y-m-d H:i:s', strtotime('-6 hours'))
        ]
    ];
    
    // Set sample notifications to session for testing
    session()->set('notifications', $sampleNotifications);
    $notifications = $sampleNotifications;
}
?>