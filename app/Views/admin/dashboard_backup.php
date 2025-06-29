<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - LuxStay</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Poppins', sans-serif; }
        .card { border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: transform 0.2s; }
        .card:hover { transform: translateY(-2px); }
        .card-header { border-radius: 16px 16px 0 0; }
        .table thead th { background-color: #e0e7ef; color: #1e3a8a; font-weight: 600; }
        .table tbody tr:hover { background-color: #f1f5f9; }
        .badge { font-size: 0.95em; padding: 0.5em 1em; }
        .dashboard-title { font-weight: 700; color: #1e3a8a; }
        .icon-dashboard { color: #3b82f6; }
        .card-header i { color: #f59e0b; }
        .nav-tabs .nav-link.active { background: #1e3a8a; color: #fff; }
        .border-left-primary { border-left: 0.25rem solid #007bff !important; }
        .border-left-success { border-left: 0.25rem solid #28a745 !important; }
        .border-left-warning { border-left: 0.25rem solid #ffc107 !important; }
        .text-xs { font-size: 0.75rem; }
        .text-gray-300 { color: #d1d5db; }
        .text-gray-800 { color: #1f2937; }
        .progress { height: 8px; border-radius: 4px; }
        .card h-100 { transition: all 0.3s ease; }
        .card h-100:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        .quick-action-btn { transition: all 0.2s ease; }
        .quick-action-btn:hover { transform: scale(1.05); }
        
        /* Animation for statistics cards */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card { animation: fadeInUp 0.6s ease-out; }
        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body>
<div class="container my-5">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home"></i> Admin</li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="dashboard-title mb-0">
            <i class="fas fa-tachometer-alt me-2 icon-dashboard"></i>Dashboard Admin
        </h2>
        <div class="d-flex gap-2">
            <div class="badge bg-success">
                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                <span id="serverStatus">Online</span>
            </div>
            <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
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
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?= $stats['total_bookings'] ?? 0 ?></h4>
                            <p class="card-text">Total Bookings</p>
                            <small>
                                <i class="fas fa-clock"></i> <?= $stats['pending_bookings'] ?? 0 ?> Pending |
                                <i class="fas fa-check"></i> <?= $stats['confirmed_bookings'] ?? 0 ?> Confirmed
                            </small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?= $stats['total_rooms'] ?? 0 ?></h4>
                            <p class="card-text">Total Rooms</p>
                            <small>
                                <i class="fas fa-door-open"></i> <?= $stats['available_rooms'] ?? 0 ?> Available |
                                <i class="fas fa-bed"></i> <?= $stats['occupied_rooms'] ?? 0 ?> Occupied
                            </small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-bed fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?= $stats['total_users'] ?? 0 ?></h4>
                            <p class="card-text">Total Users</p>
                            <small>
                                <i class="fas fa-user-check"></i> Registered Customers
                            </small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Rp <?= number_format($total_revenue ?? 0, 0, ',', '.') ?></h4>
                            <p class="card-text">Total Revenue</p>
                            <small>
                                <i class="fas fa-hourglass-half"></i> Rp <?= number_format($pending_revenue ?? 0, 0, ',', '.') ?> Pending
                            </small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Room Occupancy</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $occupancy_rate = $stats['total_rooms'] > 0 ? round(($stats['occupied_rooms'] / $stats['total_rooms']) * 100, 1) : 0;
                                echo $occupancy_rate . '%';
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Payment Rate</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $payment_rate = $stats['total_bookings'] > 0 ? round(($stats['paid_bookings'] / $stats['total_bookings']) * 100, 1) : 0;
                                echo $payment_rate . '%';
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-warning">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Maintenance Rooms</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['maintenance_rooms'] ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tools fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity & Quick Actions -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Bookings</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recent_bookings)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Guest</th>
                                    <th>Room</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_bookings as $booking): ?>
                                <tr>
                                    <td><strong><?= $booking['booking_code'] ?? '-' ?></strong></td>
                                    <td><?= htmlspecialchars($booking['guest_name'] ?? '-') ?></td>
                                    <td>Room <?= $booking['room_id'] ?? '-' ?></td>
                                    <td>Rp <?= number_format($booking['total_amount'] ?? 0, 0, ',', '.') ?></td>
                                    <td>
                                        <?php 
                                        $status = $booking['booking_status'] ?? 'pending';
                                        $badgeClass = $status == 'confirmed' ? 'success' : ($status == 'cancelled' ? 'danger' : 'warning');
                                        ?>
                                        <span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($booking['created_at'] ?? 'now')) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <p class="text-muted text-center">No recent bookings found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('admin/rooms/create') ?>" class="btn btn-success quick-action-btn">
                            <i class="fas fa-plus me-2"></i>Add New Room
                        </a>
                        <button class="btn btn-primary quick-action-btn" onclick="refreshData()">
                            <i class="fas fa-sync me-2"></i>Refresh Data
                        </button>
                        <button class="btn btn-info quick-action-btn" onclick="showReports()">
                            <i class="fas fa-chart-bar me-2"></i>View Reports
                        </button>
                        <button class="btn btn-warning quick-action-btn" onclick="exportData()">
                            <i class="fas fa-download me-2"></i>Export Data
                        </button>
                        <button class="btn btn-secondary quick-action-btn" onclick="showNotifications()">
                            <i class="fas fa-bell me-2"></i>Notifications
                            <span class="badge bg-danger" id="notificationBadge" style="display: none;">0</span>
                        </button>
                    </div>
                    
                    <!-- System Status -->
                    <hr>
                    <h6><i class="fas fa-server me-2"></i>System Status</h6>
                    <div class="mb-2">
                        <small class="text-muted">Database</small>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                        <small class="text-success">Online</small>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Server</small>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-success" style="width: 95%"></div>
                        </div>
                        <small class="text-success">95% CPU</small>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Storage</small>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-warning" style="width: 70%"></div>
                        </div>
                        <small class="text-warning">70% Used</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <ul class="nav nav-tabs mb-4" id="adminTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="booking-tab" data-bs-toggle="tab" data-bs-target="#booking" type="button" role="tab">Pemesanan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="room-tab" data-bs-toggle="tab" data-bs-target="#room" type="button" role="tab">Kamar</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#user" type="button" role="tab">User</button>
        </li>
    </ul>
    <div class="tab-content" id="adminTabContent">
        <!-- Tab Pemesanan -->
        <div class="tab-pane fade show active" id="booking" role="tabpanel">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-bed me-2"></i>Data Pemesanan Hotel</h5>
                    <div class="d-flex gap-2">
                        <input type="text" id="bookingSearch" class="form-control form-control-sm" placeholder="Search bookings..." style="width: 200px;">
                        <select id="statusFilter" class="form-select form-select-sm" style="width: 120px;">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Guest Name</th>
                                    <th>Booking Code</th>
                                    <th>Room</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($bookings)): ?>
                                <?php foreach ($bookings as $b): ?>
                                <tr>
                                    <td><?= $b['id'] ?></td>
                                    <td><?= htmlspecialchars($b['guest_name'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($b['booking_code'] ?? '-') ?></td>
                                    <td>Room <?= $b['room_id'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($b['check_in'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($b['check_out'])) ?></td>
                                    <td>Rp <?= number_format($b['total_amount'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php 
                                        $status = $b['booking_status'] ?? 'pending';
                                        $badgeClass = $status == 'confirmed' ? 'success' : ($status == 'cancelled' ? 'danger' : 'warning');
                                        ?>
                                        <span class="badge bg-<?= $badgeClass ?>">
                                            <?= ucfirst($status) ?>
                                        </span>
                                        <br><small class="text-muted">
                                            Payment: <?= ucfirst($b['payment_status'] ?? 'pending') ?>
                                        </small>
                                    </td>
                                    <td>
                                        <!-- Dropdown untuk ubah booking status -->
                                        <div class="dropdown me-2 d-inline-block">
                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-edit"></i> Status
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updateBookingStatus(<?= $b['id'] ?>, 'pending')">
                                                        <i class="fas fa-clock text-warning"></i> Pending
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updateBookingStatus(<?= $b['id'] ?>, 'confirmed')">
                                                        <i class="fas fa-check text-success"></i> Confirmed
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updateBookingStatus(<?= $b['id'] ?>, 'cancelled')">
                                                        <i class="fas fa-times text-danger"></i> Cancelled
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        
                                        <!-- Dropdown untuk ubah payment status -->
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-money-bill"></i> Payment
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updatePaymentStatus(<?= $b['id'] ?>, 'pending')">
                                                        <i class="fas fa-clock text-warning"></i> Pending
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updatePaymentStatus(<?= $b['id'] ?>, 'paid')">
                                                        <i class="fas fa-check text-success"></i> Paid
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updatePaymentStatus(<?= $b['id'] ?>, 'refunded')">
                                                        <i class="fas fa-undo text-info"></i> Refunded
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        
                                        <!-- Delete button untuk booking -->
                                        <?php if (in_array($b['booking_status'], ['cancelled', 'completed'])): ?>
                                        <a href="<?= base_url('admin/bookings/delete/'.$b['id']) ?>" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin hapus booking ini? Data tidak dapat dikembalikan.')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <?php else: ?>
                                        <span class="text-muted small">
                                            <i class="fas fa-info-circle"></i> Cancel dulu untuk hapus
                                        </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                        Belum ada data pemesanan.
                                    </td>
                                </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Kamar -->
        <div class="tab-pane fade" id="room" role="tabpanel">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-door-open me-2"></i>Data Kamar</h5>
                    <div class="d-flex gap-2">
                        <input type="text" id="roomSearch" class="form-control form-control-sm" placeholder="Search rooms..." style="width: 200px;">
                        <select id="roomStatusFilter" class="form-select form-select-sm" style="width: 120px;">
                            <option value="">All Status</option>
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                        <a href="<?= base_url('admin/rooms/create') ?>" class="btn btn-light btn-sm">
                            <i class="fas fa-plus me-1"></i>Tambah Kamar
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tipe Kamar</th>
                                    <th>Nomor Kamar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($rooms)): ?>
                                <?php foreach ($rooms as $room): ?>
                                <tr>
                                    <td><?= $room['id'] ?></td>
                                    <td><?= htmlspecialchars($room['room_type'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($room['room_number'] ?? 'Room ' . $room['id']) ?></td> <!-- FIX: room_number -->
                                    <td>
                                        <?php 
                                        $status = $room['status'] ?? 'available'; // Column 'status' ada di DB
                                        
                                        $badges = [
                                            'available' => ['text' => 'Tersedia', 'class' => 'success'],
                                            'occupied' => ['text' => 'Terisi', 'class' => 'danger'], 
                                            'maintenance' => ['text' => 'Maintenance', 'class' => 'warning']
                                        ];
                                        
                                        $badge = $badges[$status] ?? ['text' => ucfirst($status), 'class' => 'secondary'];
                                        ?>
                                        <span class="badge bg-<?= $badge['class'] ?>"><?= $badge['text'] ?></span>
                                    </td>
                                    <td>
                                        <!-- Dropdown untuk ubah status -->
                                        <div class="dropdown me-2 d-inline-block">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-toggle-on"></i> Status
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updateRoomStatus(<?= $room['id'] ?>, 'available')">
                                                        <i class="fas fa-check text-success"></i> Tersedia
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updateRoomStatus(<?= $room['id'] ?>, 'occupied')">
                                                        <i class="fas fa-times text-danger"></i> Terisi
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updateRoomStatus(<?= $room['id'] ?>, 'maintenance')">
                                                        <i class="fas fa-wrench text-warning"></i> Maintenance
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        
                                        <!-- Action buttons -->
                                        <a href="<?= base_url('admin/rooms/delete/'.$room['id']) ?>" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin hapus kamar?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data kamar.</td>
                                </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab User -->
        <div class="tab-pane fade" id="user" role="tabpanel">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>Data User</h5>
                    <input type="text" id="userSearch" class="form-control form-control-sm" placeholder="Search users..." style="width: 200px;">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fullname</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= $user['id'] ?></td>
                                            <td><?= htmlspecialchars($user['name'] ?? $user['fullname'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($user['username'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($user['email'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($user['phone'] ?? '-') ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/users/delete/'.$user['id']) ?>" class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Yakin hapus user ini? Pastikan user tidak memiliki booking aktif.')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada data user.</td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
function updateRoomStatus(roomId, status) {
    console.log('Updating room:', roomId, 'to status:', status);
    
    if (confirm('Yakin mengubah status kamar?')) {
        fetch('<?= base_url('admin/rooms/update-status') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                room_id: parseInt(roomId),
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response:', data);
            if (data.success) {
                alert('Success: ' + data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan sistem');
        });
    }
}

function updateBookingStatus(bookingId, status) {
    console.log('Updating booking:', bookingId, 'to status:', status);
    
    if (confirm('Yakin mengubah status pemesanan?')) {
        fetch(`<?= base_url('admin/bookings/update-status/') ?>${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                booking_status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response:', data);
            if (data.success) {
                alert('Success: ' + data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan sistem');
        });
    }
}

function updatePaymentStatus(bookingId, status) {
    console.log('Updating payment:', bookingId, 'to status:', status);
    
    if (confirm('Yakin mengubah status pembayaran?')) {
        fetch(`<?= base_url('admin/bookings/update-payment/') ?>${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                payment_status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response:', data);
            if (data.success) {
                alert('Success: ' + data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan sistem');
        });
    }
}

// Quick Actions Functions
function refreshData() {
    if (confirm('Refresh dashboard data?')) {
        location.reload();
    }
}

function exportData() {
    // Simple CSV export functionality
    const currentDate = new Date().toISOString().split('T')[0];
    
    // Get booking data for export
    const bookingData = [
        ['Booking Code', 'Guest Name', 'Room ID', 'Check In', 'Check Out', 'Total Amount', 'Booking Status', 'Payment Status', 'Created Date']
    ];
    
    <?php if (!empty($bookings)): ?>
    <?php foreach ($bookings as $booking): ?>
    bookingData.push([
        '<?= $booking['booking_code'] ?? '' ?>',
        '<?= addslashes($booking['guest_name'] ?? '') ?>',
        '<?= $booking['room_id'] ?? '' ?>',
        '<?= $booking['check_in'] ?? '' ?>',
        '<?= $booking['check_out'] ?? '' ?>',
        '<?= $booking['total_amount'] ?? 0 ?>',
        '<?= $booking['booking_status'] ?? '' ?>',
        '<?= $booking['payment_status'] ?? '' ?>',
        '<?= $booking['created_at'] ?? '' ?>'
    ]);
    <?php endforeach; ?>
    <?php endif; ?>
    
    // Convert to CSV
    const csvContent = bookingData.map(row => row.join(',')).join('\n');
    
    // Download file
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `bookings_export_${currentDate}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    alert('Data exported successfully!');
}

function showReports() {
    // Generate simple reports modal
    const reportModal = `
        <div class="modal fade" id="reportModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-chart-bar me-2"></i>System Reports</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Booking Statistics</h6>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between">
                                        Total Bookings <span class="badge bg-primary"><?= $stats['total_bookings'] ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        Pending <span class="badge bg-warning"><?= $stats['pending_bookings'] ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        Confirmed <span class="badge bg-success"><?= $stats['confirmed_bookings'] ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        Cancelled <span class="badge bg-danger"><?= $stats['cancelled_bookings'] ?></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Revenue Statistics</h6>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between">
                                        Total Revenue <span class="badge bg-success">Rp <?= number_format($total_revenue, 0, ',', '.') ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        Pending Revenue <span class="badge bg-warning">Rp <?= number_format($pending_revenue, 0, ',', '.') ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        Room Occupancy <span class="badge bg-info"><?= round(($stats['occupied_rooms'] / max($stats['total_rooms'], 1)) * 100, 1) ?>%</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="exportReports()">Export Report</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('reportModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', reportModal);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('reportModal'));
    modal.show();
}

function showNotifications() {
    // Simple notification system
    const notifications = [
        { type: 'success', message: 'New booking received from John Doe', time: '2 min ago' },
        { type: 'warning', message: 'Room 101 maintenance scheduled', time: '10 min ago' },
        { type: 'info', message: 'Payment confirmed for booking #HTL001', time: '30 min ago' }
    ];
    
    const notificationModal = `
        <div class="modal fade" id="notificationModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-bell me-2"></i>Recent Notifications</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        ${notifications.map(notif => `
                            <div class="alert alert-${notif.type} d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-${notif.type === 'success' ? 'check-circle' : notif.type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                                    ${notif.message}
                                </div>
                                <small class="text-muted">${notif.time}</small>
                            </div>
                        `).join('')}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="markAllAsRead()">Mark All as Read</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('notificationModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', notificationModal);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
    modal.show();
}

function markAllAsRead() {
    const badge = document.getElementById('notificationBadge');
    if (badge) {
        badge.style.display = 'none';
    }
    const modal = bootstrap.Modal.getInstance(document.getElementById('notificationModal'));
    modal.hide();
}

// Auto-refresh data every 5 minutes
setInterval(function() {
    console.log('Auto-refreshing data...');
    // You can add AJAX calls here to refresh specific sections without full page reload
}, 300000); // 5 minutes

// Initialize tooltips if any
document.addEventListener('DOMContentLoaded', function() {
    // Add some interactive features
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
        });
    });
    
    // Add loading states to buttons
    const quickActionBtns = document.querySelectorAll('.quick-action-btn, .btn');
    quickActionBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (!this.classList.contains('no-loading')) {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                this.disabled = true;
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 1000);
            }
        });
    });
});

// Search and Filter Functions
function setupSearchAndFilter() {
    // Booking search and filter
    const bookingSearch = document.getElementById('bookingSearch');
    const statusFilter = document.getElementById('statusFilter');
    const bookingTable = document.querySelector('#booking table tbody');
    
    if (bookingSearch && bookingTable) {
        function filterBookings() {
            const searchTerm = bookingSearch.value.toLowerCase();
            const statusTerm = statusFilter.value.toLowerCase();
            const rows = bookingTable.querySelectorAll('tr');
            
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
        
        bookingSearch.addEventListener('input', filterBookings);
        statusFilter.addEventListener('change', filterBookings);
    }
    
    // Room search and filter
    const roomSearch = document.getElementById('roomSearch');
    const roomStatusFilter = document.getElementById('roomStatusFilter');
    const roomTable = document.querySelector('#room table tbody');
    
    if (roomSearch && roomTable) {
        function filterRooms() {
            const searchTerm = roomSearch.value.toLowerCase();
            const statusTerm = roomStatusFilter.value.toLowerCase();
            const rows = roomTable.querySelectorAll('tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length > 0) {
                    const roomType = cells[1].textContent.toLowerCase();
                    const roomNumber = cells[2].textContent.toLowerCase();
                    const status = cells[3].textContent.toLowerCase();
                    
                    const matchesSearch = roomType.includes(searchTerm) || roomNumber.includes(searchTerm);
                    const matchesStatus = !statusTerm || status.includes(statusTerm);
                    
                    row.style.display = matchesSearch && matchesStatus ? '' : 'none';
                }
            });
        }
        
        roomSearch.addEventListener('input', filterRooms);
        roomStatusFilter.addEventListener('change', filterRooms);
    }
    
    // User search
    const userSearch = document.getElementById('userSearch');
    const userTable = document.querySelector('#user table tbody');
    
    if (userSearch && userTable) {
        function filterUsers() {
            const searchTerm = userSearch.value.toLowerCase();
            const rows = userTable.querySelectorAll('tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length > 0) {
                    const fullname = cells[1].textContent.toLowerCase();
                    const username = cells[2].textContent.toLowerCase();
                    const email = cells[3].textContent.toLowerCase();
                    
                    const matchesSearch = fullname.includes(searchTerm) || 
                                        username.includes(searchTerm) || 
                                        email.includes(searchTerm);
                    
                    row.style.display = matchesSearch ? '' : 'none';
                }
            });
        }
        
        userSearch.addEventListener('input', filterUsers);
    }
}

// Initialize search and filter when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    setupSearchAndFilter();
    
    // Add some interactive features
</body>
</html>