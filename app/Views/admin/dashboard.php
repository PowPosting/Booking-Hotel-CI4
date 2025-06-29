<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - LuxStay Hotel Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/admin-dashboard-simple.css') ?>" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>
<body>
    <!-- Update Indicator -->
    <div id="updateIndicator" class="update-indicator">
        <i class="fas fa-sync-alt fa-spin me-2"></i>
        Data updated
    </div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?= base_url('admin/dashboard') ?>" class="logo">
                <i class="fas fa-hotel me-2"></i>
                <span>LuxStay</span>
            </a>
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#bookings" class="nav-link" onclick="showSection('bookings')">
                    <i class="fas fa-calendar-check"></i>
                    <span>Bookings</span>
                    <span id="bookingBadge" class="notification-badge" style="display: none;">0</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#rooms" class="nav-link" onclick="showSection('rooms')">
                    <i class="fas fa-bed"></i>
                    <span>Rooms</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#users" class="nav-link" onclick="showSection('users')">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#analytics" class="nav-link" onclick="showSection('analytics')">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#settings" class="nav-link" onclick="showSection('settings')">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-footer p-3">
            <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-sm w-100">
                <i class="fas fa-sign-out-alt me-2"></i>
                <span>Logout</span>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <h1><i class="fas fa-tachometer-alt me-2"></i>Dashboard Overview</h1>
                <small class="text-muted">Real-time hotel management system</small>
            </div>
            <div class="header-right">
                <div class="dropdown me-2">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell me-2"></i>
                        Notifications
                        <span id="notificationCount" class="notification-badge" style="display: none;">0</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" id="notificationDropdown" style="width: 300px;">
                        <div class="dropdown-header">Recent Notifications</div>
                        <div id="notificationList">
                            <div class="dropdown-item text-center">
                                <i class="fas fa-spinner fa-spin me-2"></i>Loading...
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-outline-secondary me-2" onclick="toggleTheme()" title="Toggle Theme">
                    <i class="fas fa-moon"></i>
                </button>
                <button class="btn btn-success btn-enhanced" onclick="refreshDashboard()">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
                </button>
            </div>
        </header>

        <!-- Content -->
        <div class="p-4">
            <!-- Statistics Cards -->
            <div class="row mb-4" id="statsRow">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-number" id="totalBookings">0</div>
                        <div class="stat-label">Total Bookings</div>
                        <div class="mt-2">
                            <small><span id="pendingBookings">0</span> Pending | <span id="confirmedBookings">0</span> Confirmed</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="stat-number" id="totalRooms">0</div>
                        <div class="stat-label">Total Rooms</div>
                        <div class="mt-2">
                            <small><span id="availableRooms">0</span> Available | <span id="occupiedRooms">0</span> Occupied</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-number" id="totalRevenue">Rp 0</div>
                        <div class="stat-label">Total Revenue</div>
                        <div class="mt-2">
                            <small>Payment Rate: <span id="paymentRate">0</span>%</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="stat-number" id="occupancyRate">0%</div>
                        <div class="stat-label">Occupancy Rate</div>
                        <div class="mt-2">
                            <small><span id="maintenanceRooms">0</span> Under Maintenance</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-chart-line me-2"></i>Revenue & Bookings Trend
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-chart-pie me-2"></i>Room Status
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="roomChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Sections -->
            <div id="contentSections">
                <!-- Dashboard Overview (Default) -->
                <div id="overview" class="content-section">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-history me-2"></i>Recent Bookings
                                    </h5>
                                    <button class="btn btn-outline-primary btn-sm" onclick="loadRecentBookings()">
                                        <i class="fas fa-sync-alt me-2"></i>Refresh
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div id="recentBookingsContainer">
                                            <div class="text-center p-4">
                                                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                                <p class="mt-2 text-muted">Loading recent bookings...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-server me-2"></i>System Monitor
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="systemMonitor">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <small class="text-muted">Database</small>
                                                <span id="dbStatus" class="badge bg-success">Online</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div id="dbProgress" class="progress-bar bg-success" style="width: 100%"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <small class="text-muted">CPU Usage</small>
                                                <span id="cpuUsage">0%</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div id="cpuProgress" class="progress-bar" style="width: 0%"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <small class="text-muted">Memory Usage</small>
                                                <span id="memoryUsage">0%</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div id="memoryProgress" class="progress-bar bg-warning" style="width: 0%"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <small class="text-muted">Active Sessions</small>
                                                <span id="activeSessions">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bookings Section -->
                <div id="bookings" class="content-section" style="display: none;">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-check me-2"></i>Booking Management
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" id="bookingSearch" class="form-control form-control-sm" placeholder="Search bookings..." style="width: 200px;">
                                <select id="bookingStatusFilter" class="form-select form-select-sm" style="width: 120px;">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                <button class="btn btn-primary btn-sm" onclick="loadBookingsData()">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="bookingsTableContainer">
                                <div class="text-center p-4">
                                    <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                    <p class="mt-2 text-muted">Loading bookings...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rooms Section -->
                <div id="rooms" class="content-section" style="display: none;">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-bed me-2"></i>Room Management
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" id="roomSearch" class="form-control form-control-sm" placeholder="Search rooms..." style="width: 200px;">
                                <select id="roomStatusFilter" class="form-select form-select-sm" style="width: 120px;">
                                    <option value="">All Status</option>
                                    <option value="available">Available</option>
                                    <option value="occupied">Occupied</option>
                                    <option value="maintenance">Maintenance</option>
                                </select>
                                <button class="btn btn-success btn-sm" onclick="addRoom()">
                                    <i class="fas fa-plus me-2"></i>Add Room
                                </button>
                                <button class="btn btn-primary btn-sm" onclick="loadRoomsData()">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="roomsTableContainer">
                                <div class="text-center p-4">
                                    <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                    <p class="mt-2 text-muted">Loading rooms...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Section -->
                <div id="users" class="content-section" style="display: none;">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-users me-2"></i>User Management
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" id="userSearch" class="form-control form-control-sm" placeholder="Search users..." style="width: 200px;">
                                <select id="userRoleFilter" class="form-select form-select-sm" style="width: 120px;">
                                    <option value="">All Roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <button class="btn btn-success btn-sm" onclick="addUser()">
                                    <i class="fas fa-plus me-2"></i>Add User
                                </button>
                                <button class="btn btn-primary btn-sm" onclick="loadUsersData()">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="usersTableContainer">
                                <div class="text-center p-4">
                                    <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                    <p class="mt-2 text-muted">Loading users...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="analytics" class="content-section" style="display: none;">
                    <div id="analyticsContent">Loading...</div>
                </div>

                <div id="settings" class="content-section" style="display: none;">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-cog me-2"></i>System Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Application Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="autoRefresh" checked>
                                        <label class="form-check-label" for="autoRefresh">
                                            Auto-refresh data
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="notifications" checked>
                                        <label class="form-check-label" for="notifications">
                                            Enable notifications
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="darkMode">
                                        <label class="form-check-label" for="darkMode">
                                            Dark mode
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>System Information</h6>
                                    <p><strong>Version:</strong> 2.0.0</p>
                                    <p><strong>PHP Version:</strong> <?= phpversion() ?></p>
                                    <p><strong>Server:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></p>
                                    <p><strong>Last Update:</strong> <?= date('Y-m-d H:i:s') ?></p>
                                    <div class="mt-3">
                                        <button class="btn btn-warning btn-sm" onclick="clearCache()">
                                            <i class="fas fa-trash me-2"></i>Clear Cache
                                        </button>
                                        <button class="btn btn-success btn-sm" onclick="checkUpdates()">
                                            <i class="fas fa-sync me-2"></i>Check Updates
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        </div>
    </div>

    <!-- Room Modal -->
    <div class="modal fade" id="roomModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-bed me-2"></i>
                        <span id="roomModalTitle">Add Room</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="roomForm">
                    <div class="modal-body">
                        <input type="hidden" id="roomId" name="roomId">
                        <div class="mb-3">
                            <label for="roomNumber" class="form-label">Room Number *</label>
                            <input type="text" class="form-control" id="roomNumber" name="room_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="roomType" class="form-label">Room Type *</label>
                            <select class="form-select" id="roomType" name="room_type" required>
                                <option value="">Select Type</option>
                                <option value="standard">Standard</option>
                                <option value="deluxe">Deluxe</option>
                                <option value="suite">Suite</option>
                                <option value="premium">Premium</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="roomPrice" class="form-label">Price per Night *</label>
                            <input type="number" class="form-control" id="roomPrice" name="price" required min="0">
                        </div>
                        <div class="mb-3">
                            <label for="roomStatus" class="form-label">Status</label>
                            <select class="form-select" id="roomStatus" name="status">
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="roomDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="roomDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Save Room
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user me-2"></i>
                        <span id="userModalTitle">Add User</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="userForm">
                    <div class="modal-body">
                        <input type="hidden" id="userId" name="userId">
                        <div class="mb-3">
                            <label for="userFullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="userFullname" name="fullname">
                        </div>
                        <div class="mb-3">
                            <label for="userUsername" class="form-label">Username *</label>
                            <input type="text" class="form-control" id="userUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="userEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Role</label>
                            <select class="form-select" id="userRole" name="role">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="userPassword" class="form-label">
                                Password <span id="passwordRequired">*</span>
                            </label>
                            <input type="password" class="form-control" id="userPassword" name="password">
                            <div class="form-text">Leave blank to keep current password (when editing)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Booking Edit Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-check me-2"></i>
                        Edit Booking
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="bookingForm">
                    <div class="modal-body">
                        <input type="hidden" id="bookingId" name="bookingId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bookingGuestName" class="form-label">Guest Name</label>
                                    <input type="text" class="form-control" id="bookingGuestName" name="guest_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bookingCode" class="form-label">Booking Code</label>
                                    <input type="text" class="form-control" id="bookingCode" name="booking_code" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bookingCheckIn" class="form-label">Check In</label>
                                    <input type="date" class="form-control" id="bookingCheckIn" name="check_in">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bookingCheckOut" class="form-label">Check Out</label>
                                    <input type="date" class="form-control" id="bookingCheckOut" name="check_out">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bookingStatus" class="form-label">Booking Status</label>
                                    <select class="form-select" id="bookingStatus" name="booking_status">
                                        <option value="pending">Pending</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="paymentStatus" class="form-label">Payment Status</label>
                                    <select class="form-select" id="paymentStatus" name="payment_status">
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="bookingTotal" class="form-label">Total Amount</label>
                            <input type="number" class="form-control" id="bookingTotal" name="total_amount" min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/admin-dashboard-fixed.js') ?>"></script>
    <script>
        // Pass PHP data to JavaScript
        window.adminData = {
            baseUrl: '<?= base_url() ?>',
            bookings: <?= json_encode($bookings ?? []) ?>,
            rooms: <?= json_encode($rooms ?? []) ?>,
            users: <?= json_encode($users ?? []) ?>,
            stats: <?= json_encode($stats ?? []) ?>
        };
    </script>
</body>
</html>
