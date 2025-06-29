<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - LuxStay Hotel Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --light-color: #f8fafc;
            --dark-color: #1f2937;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-color);
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .sidebar-header .logo {
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            color: white;
        }

        .sidebar-header .toggle-btn {
            position: absolute;
            right: 15px;
            top: 20px;
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .sidebar-header .toggle-btn:hover {
            transform: scale(1.1);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.5rem 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0 25px 25px 0;
            margin-right: 15px;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }

        .nav-link i {
            margin-right: 1rem;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            margin-right: 0;
            border-radius: 10px;
            margin: 0.5rem 0.5rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* Header */
        .header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .header-left h1 {
            color: var(--primary-color);
            font-weight: 600;
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            text-align: center;
            padding: 2rem;
        }

        .stat-card.success {
            background: linear-gradient(135deg, var(--success-color), #059669);
        }

        .stat-card.warning {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
        }

        .stat-card.danger {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
        }

        .stat-card .stat-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        .stat-card .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-card .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Charts */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Real-time updates */
        .update-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--success-color);
            color: white;
            padding: 10px 15px;
            border-radius: 25px;
            font-size: 0.9rem;
            z-index: 1001;
            transform: translateX(300px);
            transition: transform 0.3s ease;
        }

        .update-indicator.show {
            transform: translateX(0);
        }

        /* Loading states */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            to { left: 100%; }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .header {
                padding: 1rem;
            }
        }

        /* Table enhancements */
        .table-enhanced {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .table-enhanced thead th {
            background: var(--primary-color);
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem;
        }

        .table-enhanced tbody tr {
            transition: all 0.2s ease;
        }

        .table-enhanced tbody tr:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: scale(1.01);
        }

        /* Notification styles */
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 0.75rem;
            font-weight: 600;
            min-width: 20px;
            text-align: center;
        }

        /* Button enhancements */
        .btn-enhanced {
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-enhanced:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn-enhanced:active {
            transform: translateY(0);
        }
    </style>
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
                <div class="dropdown">
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
                <button class="btn btn-success btn-enhanced" onclick="refreshDashboard()">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
                </button>
            </div>
        </header>

        <!-- Content -->
        <div class="container-fluid p-4">
            <!-- Statistics Cards -->
            <div class="row mb-4" id="statsRow">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card fade-in-up">
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
                    <div class="card stat-card success fade-in-up">
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
                    <div class="card stat-card warning fade-in-up">
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
                    <div class="card stat-card danger fade-in-up">
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

                <!-- Other sections will be loaded dynamically -->
                <div id="bookings" class="content-section" style="display: none;">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Booking Management</h5>
                        </div>
                        <div class="card-body">
                            <p>Booking management content will be loaded here...</p>
                        </div>
                    </div>
                </div>

                <div id="rooms" class="content-section" style="display: none;">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Room Management</h5>
                        </div>
                        <div class="card-body">
                            <p>Room management content will be loaded here...</p>
                        </div>
                    </div>
                </div>

                <div id="users" class="content-section" style="display: none;">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">User Management</h5>
                        </div>
                        <div class="card-body">
                            <p>User management content will be loaded here...</p>
                        </div>
                    </div>
                </div>

                <div id="analytics" class="content-section" style="display: none;">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Analytics & Reports</h5>
                        </div>
                        <div class="card-body">
                            <p>Analytics content will be loaded here...</p>
                        </div>
                    </div>
                </div>

                <div id="settings" class="content-section" style="display: none;">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">System Settings</h5>
                        </div>
                        <div class="card-body">
                            <p>Settings content will be loaded here...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Global variables
        let revenueChart = null;
        let roomChart = null;
        let autoRefreshInterval = null;
        let lastUpdateTime = null;

        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            initializeDashboard();
            setupAutoRefresh();
            loadInitialData();
        });

        // Dashboard initialization
        function initializeDashboard() {
            console.log('Initializing dashboard...');
            initializeCharts();
            setupEventListeners();
        }

        // Setup auto refresh
        function setupAutoRefresh() {
            // Refresh data every 30 seconds
            autoRefreshInterval = setInterval(() => {
                loadStats();
                loadSystemInfo();
                loadNotifications();
            }, 30000);
        }

        // Load initial data
        function loadInitialData() {
            loadStats();
            loadRecentBookings();
            loadSystemInfo();
            loadNotifications();
        }

        // Initialize charts
        function initializeCharts() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Revenue',
                        data: [120000000, 150000000, 180000000, 200000000, 220000000, 250000000],
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4
                    }, {
                        label: 'Bookings',
                        data: [45, 55, 65, 70, 75, 85],
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: {
                                drawOnChartArea: false,
                            },
                        }
                    }
                }
            });

            // Room Status Chart
            const roomCtx = document.getElementById('roomChart').getContext('2d');
            roomChart = new Chart(roomCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Available', 'Occupied', 'Maintenance'],
                    datasets: [{
                        data: [0, 0, 0],
                        backgroundColor: [
                            'rgb(16, 185, 129)',
                            'rgb(59, 130, 246)',
                            'rgb(245, 158, 11)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        // Load statistics
        async function loadStats() {
            try {
                const response = await fetch('<?= base_url('admin/api/stats') ?>');
                const data = await response.json();
                
                if (data.success) {
                    updateStatsUI(data.stats);
                    updateCharts(data.stats);
                    showUpdateIndicator();
                }
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        // Update statistics UI
        function updateStatsUI(stats) {
            document.getElementById('totalBookings').textContent = stats.total_bookings;
            document.getElementById('pendingBookings').textContent = stats.pending_bookings;
            document.getElementById('confirmedBookings').textContent = stats.confirmed_bookings;
            document.getElementById('totalRooms').textContent = stats.total_rooms;
            document.getElementById('availableRooms').textContent = stats.available_rooms;
            document.getElementById('occupiedRooms').textContent = stats.occupied_rooms;
            document.getElementById('maintenanceRooms').textContent = stats.maintenance_rooms;
            document.getElementById('totalRevenue').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(stats.total_revenue);
            document.getElementById('occupancyRate').textContent = stats.occupancy_rate + '%';
            document.getElementById('paymentRate').textContent = stats.payment_rate + '%';
        }

        // Update charts
        function updateCharts(stats) {
            // Update room chart
            roomChart.data.datasets[0].data = [
                stats.available_rooms,
                stats.occupied_rooms,
                stats.maintenance_rooms
            ];
            roomChart.update();
        }

        // Load recent bookings
        async function loadRecentBookings() {
            try {
                const response = await fetch('<?= base_url('admin/api/recent-bookings') ?>');
                const data = await response.json();
                
                if (data.success) {
                    updateRecentBookingsUI(data.bookings);
                }
            } catch (error) {
                console.error('Error loading recent bookings:', error);
                document.getElementById('recentBookingsContainer').innerHTML = 
                    '<div class="text-center p-4 text-danger">Error loading bookings</div>';
            }
        }

        // Update recent bookings UI
        function updateRecentBookingsUI(bookings) {
            const container = document.getElementById('recentBookingsContainer');
            
            if (bookings.length === 0) {
                container.innerHTML = '<div class="text-center p-4 text-muted">No recent bookings</div>';
                return;
            }

            let html = '<table class="table table-enhanced"><thead><tr>';
            html += '<th>Code</th><th>Guest</th><th>Room</th><th>Amount</th><th>Status</th><th>Date</th>';
            html += '</tr></thead><tbody>';

            bookings.forEach(booking => {
                const statusClass = booking.booking_status === 'confirmed' ? 'success' : 
                                  booking.booking_status === 'cancelled' ? 'danger' : 'warning';
                const amount = new Intl.NumberFormat('id-ID').format(booking.total_amount || 0);
                const date = new Date(booking.created_at || Date.now()).toLocaleDateString('id-ID');

                html += `<tr>
                    <td><strong>${booking.booking_code || '-'}</strong></td>
                    <td>${booking.guest_name || '-'}</td>
                    <td>Room ${booking.room_id || '-'}</td>
                    <td>Rp ${amount}</td>
                    <td><span class="badge bg-${statusClass}">${booking.booking_status || 'pending'}</span></td>
                    <td>${date}</td>
                </tr>`;
            });

            html += '</tbody></table>';
            container.innerHTML = html;
        }

        // Load system info
        async function loadSystemInfo() {
            try {
                const response = await fetch('<?= base_url('admin/api/system-info') ?>');
                const data = await response.json();
                
                if (data.success) {
                    updateSystemInfoUI(data.system);
                }
            } catch (error) {
                console.error('Error loading system info:', error);
            }
        }

        // Update system info UI
        function updateSystemInfoUI(system) {
            // Database status
            document.getElementById('dbStatus').textContent = system.database.status;
            document.getElementById('dbProgress').style.width = '100%';

            // CPU usage
            const cpuUsage = system.server.cpu_usage;
            document.getElementById('cpuUsage').textContent = cpuUsage + '%';
            document.getElementById('cpuProgress').style.width = cpuUsage + '%';
            document.getElementById('cpuProgress').className = 'progress-bar ' + 
                (cpuUsage > 80 ? 'bg-danger' : cpuUsage > 60 ? 'bg-warning' : 'bg-success');

            // Memory usage
            const memoryUsage = system.server.memory_usage;
            document.getElementById('memoryUsage').textContent = memoryUsage + '%';
            document.getElementById('memoryProgress').style.width = memoryUsage + '%';

            // Active sessions
            document.getElementById('activeSessions').textContent = system.application.active_sessions;
        }

        // Load notifications
        async function loadNotifications() {
            try {
                const response = await fetch('<?= base_url('admin/api/notifications') ?>');
                const data = await response.json();
                
                if (data.success) {
                    updateNotificationsUI(data.notifications, data.count);
                }
            } catch (error) {
                console.error('Error loading notifications:', error);
            }
        }

        // Update notifications UI
        function updateNotificationsUI(notifications, count) {
            const countElement = document.getElementById('notificationCount');
            const listElement = document.getElementById('notificationList');

            if (count > 0) {
                countElement.textContent = count;
                countElement.style.display = 'block';
            } else {
                countElement.style.display = 'none';
            }

            if (notifications.length === 0) {
                listElement.innerHTML = '<div class="dropdown-item text-center text-muted">No new notifications</div>';
                return;
            }

            let html = '';
            notifications.forEach(notif => {
                const iconClass = notif.type === 'success' ? 'check-circle' : 
                                notif.type === 'warning' ? 'exclamation-triangle' : 'info-circle';
                const timeAgo = getTimeAgo(notif.time);

                html += `<div class="dropdown-item">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-${iconClass} text-${notif.type} me-2 mt-1"></i>
                        <div class="flex-grow-1">
                            <div class="fw-bold">${notif.title}</div>
                            <div class="small text-muted">${notif.message}</div>
                            <div class="small text-muted">${timeAgo}</div>
                        </div>
                    </div>
                </div>`;
            });

            listElement.innerHTML = html;
        }

        // Get time ago string
        function getTimeAgo(dateString) {
            const now = new Date();
            const date = new Date(dateString);
            const diff = now - date;
            const minutes = Math.floor(diff / 60000);
            
            if (minutes < 1) return 'Just now';
            if (minutes < 60) return minutes + ' minutes ago';
            
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return hours + ' hours ago';
            
            const days = Math.floor(hours / 24);
            return days + ' days ago';
        }

        // Show update indicator
        function showUpdateIndicator() {
            const indicator = document.getElementById('updateIndicator');
            indicator.classList.add('show');
            setTimeout(() => {
                indicator.classList.remove('show');
            }, 2000);
        }

        // Refresh dashboard
        function refreshDashboard() {
            const btn = event.target.closest('button');
            const originalHtml = btn.innerHTML;
            
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Refreshing...';
            btn.disabled = true;
            
            loadInitialData();
            
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }, 2000);
        }

        // Toggle sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }

        // Show section
        function showSection(sectionName) {
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.style.display = 'none';
            });
            
            // Remove active class from all nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(sectionName).style.display = 'block';
            
            // Add active class to selected nav link
            event.target.closest('.nav-link').classList.add('active');
            
            // Update header title
            const headerTitle = document.querySelector('.header-left h1');
            headerTitle.innerHTML = `<i class="fas fa-${getSectionIcon(sectionName)} me-2"></i>${getSectionTitle(sectionName)}`;
        }

        // Get section icon
        function getSectionIcon(section) {
            const icons = {
                overview: 'tachometer-alt',
                bookings: 'calendar-check',
                rooms: 'bed',
                users: 'users',
                analytics: 'chart-line',
                settings: 'cog'
            };
            return icons[section] || 'tachometer-alt';
        }

        // Get section title
        function getSectionTitle(section) {
            const titles = {
                overview: 'Dashboard Overview',
                bookings: 'Booking Management',
                rooms: 'Room Management',
                users: 'User Management',
                analytics: 'Analytics & Reports',
                settings: 'System Settings'
            };
            return titles[section] || 'Dashboard';
        }

        // Setup event listeners
        function setupEventListeners() {
            // Mobile menu toggle
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    document.getElementById('sidebar').classList.add('collapsed');
                    document.getElementById('mainContent').classList.add('expanded');
                }
            });
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
            }
        });
    </script>
</body>
</html>
