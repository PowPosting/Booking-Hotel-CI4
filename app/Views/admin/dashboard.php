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
                                    <th>Fullname</th>
                                    <th>Username</th>
                                    <th>Tipe Kamar</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($bookings)): ?>
                                <?php foreach ($bookings as $b): ?>
                                <tr>
                                    <td><?= $b['id'] ?></td>
                                    <td><?= $b['fullname'] ?? '-' ?></td>
                                    <td><?= $b['username'] ?? '-' ?></td>
                                    <td><?= $b['room_type'] ?></td>
                                    <td><?= $b['check_in'] ?></td>
                                    <td><?= $b['check_out'] ?></td>
                                    <td>Rp<?= number_format($b['total_price'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php if ($b['status'] == 'pending'): ?>
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        <?php elseif ($b['status'] == 'confirmed'): ?>
                                            <span class="badge bg-success">Confirmed</span>
                                        <?php elseif ($b['status'] == 'cancelled'): ?>
                                            <span class="badge bg-danger">Cancelled</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= ucfirst($b['status']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada data pemesanan.</td>
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
                                    <td><?= $room['room_type'] ?></td>
                                    <td><?= $room['room_number'] ?></td>
                                    <td>
                                        <?php if ($room['status'] == 'available'): ?>
                                            <span class="badge bg-success">Tersedia</span>
                                        <?php elseif ($room['status'] == 'occupied'): ?>
                                            <span class="badge bg-danger">Terisi</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= ucfirst($room['status']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/room/edit/'.$room['id']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        <a href="<?= base_url('admin/room/delete/'.$room['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kamar?')"><i class="fas fa-trash"></i></a>
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
                                            <td><?= $user['fullname'] ?></td>
                                            <td><?= $user['username'] ?></td>
                                            <td><?= $user['email'] ?></td>
                                            <td><?= $user['phone'] ?? '-' ?></td>
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
</body>
</html>