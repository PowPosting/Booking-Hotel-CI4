<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Booking Analytics
                </h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="bookingAnalyticsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Revenue Distribution
                </h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="revenueDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-download me-2"></i>Export Reports
                </h5>
                <div class="d-flex gap-2">
                    <select id="reportType" class="form-select form-select-sm" style="width: 150px;">
                        <option value="bookings">Bookings</option>
                        <option value="rooms">Rooms</option>
                        <option value="users">Users</option>
                        <option value="revenue">Revenue</option>
                    </select>
                    <select id="reportPeriod" class="form-select form-select-sm" style="width: 150px;">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="year">This Year</option>
                    </select>
                    <button class="btn btn-success btn-sm" onclick="exportReport()">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-card bg-primary text-white">
                            <div class="stat-number" id="analyticsBookings">0</div>
                            <div class="stat-label">Total Bookings</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-success text-white">
                            <div class="stat-number" id="analyticsRevenue">Rp 0</div>
                            <div class="stat-label">Total Revenue</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-warning text-white">
                            <div class="stat-number" id="analyticsOccupancy">0%</div>
                            <div class="stat-label">Occupancy Rate</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-info text-white">
                            <div class="stat-number" id="analyticsCustomers">0</div>
                            <div class="stat-label">Unique Customers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-table me-2"></i>Detailed Analytics
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-enhanced">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Today</th>
                                <th>This Week</th>
                                <th>This Month</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>New Bookings</strong></td>
                                <td>12</td>
                                <td>85</td>
                                <td>340</td>
                                <td><span class="badge bg-success"><i class="fas fa-arrow-up"></i> +15%</span></td>
                            </tr>
                            <tr>
                                <td><strong>Revenue</strong></td>
                                <td>Rp 15,000,000</td>
                                <td>Rp 105,000,000</td>
                                <td>Rp 420,000,000</td>
                                <td><span class="badge bg-success"><i class="fas fa-arrow-up"></i> +22%</span></td>
                            </tr>
                            <tr>
                                <td><strong>Occupancy Rate</strong></td>
                                <td>78%</td>
                                <td>82%</td>
                                <td>75%</td>
                                <td><span class="badge bg-warning"><i class="fas fa-arrow-down"></i> -3%</span></td>
                            </tr>
                            <tr>
                                <td><strong>Cancellation Rate</strong></td>
                                <td>2%</td>
                                <td>3%</td>
                                <td>5%</td>
                                <td><span class="badge bg-danger"><i class="fas fa-arrow-up"></i> +2%</span></td>
                            </tr>
                            <tr>
                                <td><strong>Customer Satisfaction</strong></td>
                                <td>4.8/5</td>
                                <td>4.7/5</td>
                                <td>4.6/5</td>
                                <td><span class="badge bg-success"><i class="fas fa-arrow-up"></i> +0.2</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let bookingAnalyticsChart = null;
let revenueDistributionChart = null;

// Initialize analytics when section is shown
function initializeAnalytics() {
    console.log('Initializing analytics...');
    loadAnalyticsData();
    initializeAnalyticsCharts();
}

// Load analytics data
async function loadAnalyticsData() {
    try {
        const response = await fetch('<?= base_url('admin/api/stats') ?>');
        const data = await response.json();
        
        if (data.success) {
            updateAnalyticsStats(data.stats);
        }
    } catch (error) {
        console.error('Error loading analytics data:', error);
    }
}

// Update analytics statistics
function updateAnalyticsStats(stats) {
    document.getElementById('analyticsBookings').textContent = stats.total_bookings || 0;
    document.getElementById('analyticsRevenue').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(stats.total_revenue || 0);
    document.getElementById('analyticsOccupancy').textContent = (stats.occupancy_rate || 0) + '%';
    document.getElementById('analyticsCustomers').textContent = stats.total_users || 0;
}

// Initialize analytics charts
function initializeAnalyticsCharts() {
    // Booking Analytics Chart
    const bookingCtx = document.getElementById('bookingAnalyticsChart');
    if (bookingCtx) {
        bookingAnalyticsChart = new Chart(bookingCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Confirmed Bookings',
                    data: [65, 78, 90, 81, 95, 102],
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }, {
                    label: 'Cancelled Bookings',
                    data: [5, 8, 12, 7, 9, 11],
                    backgroundColor: 'rgba(239, 68, 68, 0.8)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Revenue Distribution Chart
    const revenueCtx = document.getElementById('revenueDistributionChart');
    if (revenueCtx) {
        revenueDistributionChart = new Chart(revenueCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Standard Rooms', 'Deluxe Rooms', 'Suite Rooms', 'Additional Services'],
                datasets: [{
                    data: [45, 30, 20, 5],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(139, 92, 246, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
}

// Export report
function exportReport() {
    const reportType = document.getElementById('reportType').value;
    const reportPeriod = document.getElementById('reportPeriod').value;
    
    // Show loading
    const button = event.target.closest('button');
    const originalHtml = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Exporting...';
    button.disabled = true;
    
    // Simulate export delay
    setTimeout(() => {
        // In a real application, this would trigger a download
        window.open(`<?= base_url('admin/api/export/') ?>${reportType}?period=${reportPeriod}`, '_blank');
        
        button.innerHTML = originalHtml;
        button.disabled = false;
        
        showAlert('success', `${reportType.charAt(0).toUpperCase() + reportType.slice(1)} report exported successfully!`);
    }, 2000);
}

// Show alert
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const container = document.querySelector('.main-content .container-fluid');
    container.insertAdjacentHTML('afterbegin', alertHtml);
    
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}

// Initialize when section is shown
document.addEventListener('DOMContentLoaded', function() {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const section = document.getElementById('analytics');
                if (section && section.style.display !== 'none') {
                    initializeAnalytics();
                }
            }
        });
    });
    
    const analyticsSection = document.getElementById('analytics');
    if (analyticsSection) {
        observer.observe(analyticsSection, { attributes: true });
    }
});
</script>
