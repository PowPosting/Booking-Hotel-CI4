<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>User Management
                </h5>
                <div class="d-flex gap-2">
                    <input type="text" id="userSearchInput" class="form-control form-control-sm" placeholder="Search users..." style="width: 200px;">
                    <button class="btn btn-success btn-sm" onclick="addUser()">
                        <i class="fas fa-plus me-2"></i>Add User
                    </button>
                    <button class="btn btn-primary btn-sm" onclick="loadUsers()">
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
</div>

<script>
// Load users data using AJAX
function loadUsers() {
    if (window.adminDashboard) {
        window.adminDashboard.loadUsersData();
    } else {
        // Fallback for standalone usage
        const container = document.getElementById('usersTableContainer');
        container.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x text-muted"></i><p class="mt-2 text-muted">Loading users...</p></div>';
        
        setTimeout(() => {
            container.innerHTML = '<div class="text-center p-4 text-muted">Admin dashboard not loaded</div>';
        }, 1000);
    }
}

// Note: updateUsersTable function is now handled by admin-dashboard.js
// This keeps the section view clean and uses centralized AJAX functionality

// Setup search for users
function setupUserSearch() {
    const searchInput = document.getElementById('userSearchInput');
    const table = document.querySelector('#usersTableContainer table tbody');
    
    if (!searchInput || !table) return;
    
    function filterUsers() {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = table.querySelectorAll('tr');
        
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
    
    searchInput.addEventListener('input', filterUsers);
}

// View user details
function viewUserDetails(userId) {
    // Create modal for user details
    const modalHtml = `
        <div class="modal fade" id="userDetailsModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-user me-2"></i>User Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center p-4">
                            <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                            <p class="mt-2 text-muted">Loading user details...</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal
    const existingModal = document.getElementById('userDetailsModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
    modal.show();
    
    // Load user data (simulation)
    setTimeout(() => {
        const modalBody = document.querySelector('#userDetailsModal .modal-body');
        modalBody.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <strong>User ID:</strong> ${userId}
                </div>
                <div class="col-md-6">
                    <strong>Status:</strong> <span class="badge bg-success">Active</span>
                </div>
            </div>
            <hr>
            <p class="text-muted">Full user details would be loaded from the server in a real implementation.</p>
        `;
    }, 1000);
}

// Reset user password
function resetUserPassword(userId) {
    if (confirm('Are you sure you want to reset this user\'s password?')) {
        showAlert('info', 'Password reset email has been sent to the user.');
    }
}

// Delete user - now uses AJAX
function deleteUser(userId) {
    if (window.adminDashboard) {
        window.adminDashboard.deleteUser(userId);
    } else {
        // Fallback to old method
        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            window.location.href = `<?= base_url('admin/users/delete/') ?>${userId}`;
        }
    }
}

// Show alert (reuse from previous sections)
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
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
                const section = document.getElementById('users');
                if (section && section.style.display !== 'none') {
                    loadUsers();
                }
            }
        });
    });
    
    const usersSection = document.getElementById('users');
    if (usersSection) {
        observer.observe(usersSection, { attributes: true });
    }
});
</script>
