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
        .card { border: none; border-radius: 16px; }
        .card-header { border-radius: 16px 16px 0 0; }
        .table thead th { background-color: #e0e7ef; color: #1e3a8a; font-weight: 600; }
        .table tbody tr:hover { background-color: #f1f5f9; }
        .badge { font-size: 0.95em; padding: 0.5em 1em; }
        .dashboard-title { font-weight: 700; color: #1e3a8a; }
        .icon-dashboard { color: #3b82f6; }
        .card-header i { color: #f59e0b; }
        .nav-tabs .nav-link.active { background: #1e3a8a; color: #fff; }
    </style>
</head>
<body>
<div class="container my-5">
    <h2 class="mb-4 dashboard-title">
        <i class="fas fa-tachometer-alt me-2 icon-dashboard"></i>Dashboard Admin
    </h2>
    <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger float-end mb-3">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
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
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-bed me-2"></i>Data Pemesanan Hotel</h5>
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
                    <a href="<?= base_url('admin/room/create') ?>" class="btn btn-light btn-sm">
                        <i class="fas fa-plus"></i> Tambah Kamar
                    </a>
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
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>Data User</h5>
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
                                        </tr>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data user.</td>
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
</script>
</body>
</html>