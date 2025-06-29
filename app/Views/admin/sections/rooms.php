<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-bed me-2"></i>Room Management
                </h5>
                <div class="d-flex gap-2">
                    <input type="text" id="roomSearchInput" class="form-control form-control-sm" placeholder="Search rooms..." style="width: 200px;">
                    <select id="roomStatusFilter" class="form-select form-select-sm" style="width: 120px;">
                        <option value="">All Status</option>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                    <button class="btn btn-success btn-sm" onclick="addRoom()">
                        <i class="fas fa-plus me-2"></i>Add Room
                    </button>
                    <button class="btn btn-primary btn-sm" onclick="loadRooms()">
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
</div>

<script>
// Load rooms data using AJAX
function loadRooms() {
    if (window.adminDashboard) {
        window.adminDashboard.loadRoomsData();
    } else {
        // Fallback for standalone usage
        const container = document.getElementById('roomsTableContainer');
        container.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x text-muted"></i><p class="mt-2 text-muted">Loading rooms...</p></div>';
        
        setTimeout(() => {
            container.innerHTML = '<div class="text-center p-4 text-muted">Admin dashboard not loaded</div>';
        }, 1000);
    }
}

// Update rooms table
function updateRoomsTable(rooms) {
    const container = document.getElementById('roomsTableContainer');
    
    if (rooms.length === 0) {
        container.innerHTML = '<div class="text-center p-4 text-muted">No rooms found</div>';
        return;
    }

    let html = '<div class="table-responsive"><table class="table table-enhanced"><thead><tr>';
    html += '<th>ID</th><th>Room Type</th><th>Room Number</th><th>Price</th><th>Status</th><th>Description</th><th>Actions</th>';
    html += '</tr></thead><tbody>';

    rooms.forEach(room => {
        const statusClass = room.status === 'available' ? 'success' : 
                          room.status === 'occupied' ? 'primary' : 
                          room.status === 'maintenance' ? 'warning' : 'secondary';
        const price = new Intl.NumberFormat('id-ID').format(room.price || 0);

        html += `<tr>
            <td>${room.id}</td>
            <td>${room.room_type || '-'}</td>
            <td><strong>${room.room_number || '-'}</strong></td>
            <td>Rp ${price}</td>
            <td>
                <span class="badge bg-${statusClass}">${room.status || 'available'}</span>
            </td>
            <td>${room.description || '-'}</td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="updateRoomStatus(${room.id}, 'available')">
                            <i class="fas fa-check me-2"></i>Set Available
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="updateRoomStatus(${room.id}, 'occupied')">
                            <i class="fas fa-user me-2"></i>Set Occupied
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="updateRoomStatus(${room.id}, 'maintenance')">
                            <i class="fas fa-tools me-2"></i>Set Maintenance
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteRoom(${room.id})">
                            <i class="fas fa-trash me-2"></i>Delete
                        </a></li>
                    </ul>
                </div>
            </td>
        </tr>`;
    });

    html += '</tbody></table></div>';
    container.innerHTML = html;
    
    // Setup search and filter
    setupRoomSearchAndFilter();
}

// Setup search and filter for rooms
function setupRoomSearchAndFilter() {
    const searchInput = document.getElementById('roomSearchInput');
    const statusFilter = document.getElementById('roomStatusFilter');
    const table = document.querySelector('#roomsTableContainer table tbody');
    
    if (!searchInput || !table) return;
    
    function filterRooms() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value.toLowerCase();
        const rows = table.querySelectorAll('tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 0) {
                const roomType = cells[1].textContent.toLowerCase();
                const roomNumber = cells[2].textContent.toLowerCase();
                const status = cells[4].textContent.toLowerCase();
                
                const matchesSearch = roomType.includes(searchTerm) || roomNumber.includes(searchTerm);
                const matchesStatus = !statusTerm || status.includes(statusTerm);
                
                row.style.display = matchesSearch && matchesStatus ? '' : 'none';
            }
        });
    }
    
    searchInput.addEventListener('input', filterRooms);
    statusFilter.addEventListener('change', filterRooms);
}

// Update room status
async function updateRoomStatus(roomId, status) {
    try {
        const response = await fetch('<?= base_url('admin/rooms/update-status') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ room_id: roomId, status: status })
        });
        
        const result = await response.json();
        
        if (result.success) {
            showAlert('success', result.message);
            loadRooms(); // Reload rooms
        } else {
            showAlert('danger', result.message);
        }
    } catch (error) {
        console.error('Error updating room status:', error);
        showAlert('danger', 'Error updating room status');
    }
}

// Delete room
function deleteRoom(roomId) {
    if (confirm('Are you sure you want to delete this room?')) {
        window.location.href = `<?= base_url('admin/rooms/delete/') ?>${roomId}`;
    }
}

// Show alert (reuse from bookings)
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
                const section = document.getElementById('rooms');
                if (section && section.style.display !== 'none') {
                    loadRooms();
                }
            }
        });
    });
    
    const roomsSection = document.getElementById('rooms');
    if (roomsSection) {
        observer.observe(roomsSection, { attributes: true });
    }
});
</script>
