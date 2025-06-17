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
                                <?php foreach (array_slice($notifications, 0, 3) as $notif): ?>
                                <a href="#" class="dropdown-item px-3 py-2 border-bottom">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-<?= ($notif['type'] ?? 'info') === 'success' ? 'success' : (($notif['type'] ?? 'info') === 'info' ? 'info' : 'warning') ?> rounded-circle me-3 mt-1" style="width: 8px; height: 8px;"></div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fs-6"><?= htmlspecialchars($notif['title'] ?? 'Notification') ?></h6>
                                            <p class="mb-1 small text-muted"><?= htmlspecialchars($notif['message'] ?? '') ?></p>
                                            <small class="text-muted"><?= time_elapsed_string($notif['created_at'] ?? date('Y-m-d H:i:s')) ?></small>
                                        </div>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                                
                                <div class="p-3">
                                    <div class="d-grid">
                                        <a href="<?= site_url('notifications') ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-2"></i>Lihat Semua Notifikasi
                                        </a>
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
</style>

<script>
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

function updateCartCount(count) {
    const badge = document.getElementById('cart-count');
    if (count > 0) {
        badge.textContent = count;
        badge.style.display = 'inline';
    } else {
        badge.style.display = 'none';
    }
}

// Ganti function updateNotifications yang ada dengan ini:
function updateNotifications() {
    console.log(' Fetching notifications...');
    
    fetch('<?= site_url('booking/notifications') ?>')
    .then(r => r.json())
    .then(data => {
        console.log(' Notification data:', data);
        
        if (data.success) {
            // Update badge
            const badge = document.getElementById('notification-count');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'inline-block';
                    console.log(' Badge updated:', data.count);
                } else {
                    badge.style.display = 'none';
                }
            }
            
            // Update dropdown content
            const dropdown = document.querySelector('#notificationDropdown + .dropdown-menu');
            if (dropdown && data.notifications.length > 0) {
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
</script>

<?php
// Helper function untuk time elapsed
if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false) {
        try {
            $now = new DateTime();
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = array(
                'y' => 'tahun',
                'm' => 'bulan',
                'w' => 'minggu', 
                'd' => 'hari',
                'h' => 'jam',
                'i' => 'menit',
                's' => 'detik',
            );
            
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v;
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
        } catch (Exception $e) {
            return 'baru saja';
        }
    }
}
?>

<?php
// Include checkout modal
include APPPATH . 'Views/partials/modals/checkout.php';
?>