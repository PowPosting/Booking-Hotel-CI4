<?php
namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\RoomModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $bookingModel;
    protected $roomModel;
    protected $userModel;

    public function __construct()
    {
        // **FIX: Load models**
        $this->bookingModel = new \App\Models\BookingModel();
        $this->roomModel = new \App\Models\RoomModel();
        $this->userModel = new \App\Models\UserModel();
        
    }

    public function dashboard()
    {
        // Get all data
        $bookings = $this->bookingModel->findAll();
        $rooms = $this->roomModel->findAll();
        $users = $this->userModel->findAll();
        
        // Calculate statistics
        $stats = [
            'total_bookings' => count($bookings),
            'total_rooms' => count($rooms),
            'total_users' => count($users),
            'pending_bookings' => count(array_filter($bookings, function($b) { 
                return isset($b['booking_status']) && $b['booking_status'] === 'pending'; 
            })),
            'confirmed_bookings' => count(array_filter($bookings, function($b) { 
                return isset($b['booking_status']) && $b['booking_status'] === 'confirmed'; 
            })),
            'cancelled_bookings' => count(array_filter($bookings, function($b) { 
                return isset($b['booking_status']) && $b['booking_status'] === 'cancelled'; 
            })),
            'available_rooms' => count(array_filter($rooms, function($r) { 
                return isset($r['status']) && $r['status'] === 'available'; 
            })),
            'occupied_rooms' => count(array_filter($rooms, function($r) { 
                return isset($r['status']) && $r['status'] === 'occupied'; 
            })),
            'maintenance_rooms' => count(array_filter($rooms, function($r) { 
                return isset($r['status']) && $r['status'] === 'maintenance'; 
            })),
            'paid_bookings' => count(array_filter($bookings, function($b) { 
                return isset($b['payment_status']) && $b['payment_status'] === 'paid'; 
            })),
            'pending_payments' => count(array_filter($bookings, function($b) { 
                return isset($b['payment_status']) && $b['payment_status'] === 'pending'; 
            }))
        ];
        
        // Calculate revenue
        $total_revenue = 0;
        $pending_revenue = 0;
        foreach ($bookings as $booking) {
            if (isset($booking['payment_status']) && isset($booking['total_amount'])) {
                if ($booking['payment_status'] === 'paid') {
                    $total_revenue += $booking['total_amount'];
                } elseif ($booking['payment_status'] === 'pending') {
                    $pending_revenue += $booking['total_amount'];
                }
            }
        }
        
        // Get recent bookings (last 5)
        usort($bookings, function($a, $b) {
            return strtotime($b['created_at'] ?? '0') <=> strtotime($a['created_at'] ?? '0');
        });
        $recent_bookings = array_slice($bookings, 0, 5);
        
        $data = [
            'title' => 'Dashboard Admin',
            'bookings' => $bookings,
            'rooms' => $rooms,
            'users' => $users,
            'stats' => $stats,
            'total_revenue' => $total_revenue,
            'pending_revenue' => $pending_revenue,
            'recent_bookings' => $recent_bookings
        ];
        
        return view('admin/dashboard', $data);
    }

    // **TAMBAH: Method bookings untuk route GET /admin/bookings**
    public function bookings()
    {
        $data = [
            'title' => 'Data Bookings',
            'bookings' => $this->bookingModel->findAll()
        ];
        
        return view('admin/bookings', $data);
    }

    // **TAMBAH: Method rooms untuk route GET /admin/rooms**
    public function rooms()
    {
        $data = [
            'title' => 'Data Rooms',
            'rooms' => $this->roomModel->findAll()
        ];
        
        return view('admin/rooms', $data);
    }

    // **TAMBAH: Method users untuk route GET /admin/users**
    public function users()
    {
        $data = [
            'title' => 'Data Users',
            'users' => $this->userModel->findAll()
        ];
        
        return view('admin/users', $data);
    }

    public function updateRoomStatus()
    {
        // Debug: Log request data
        log_message('info', 'Update room status request: ' . $this->request->getBody());
        
        $json = $this->request->getJSON();
        $roomId = $json->room_id ?? null;
        $status = $json->status ?? null;

        // Debug: Log parsed data
        log_message('info', 'Room ID: ' . $roomId . ', Status: ' . $status);

        if (!$roomId || !$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap - Room ID: ' . $roomId . ', Status: ' . $status
            ]);
        }

        try {
            // **DEBUG: Cek apakah room exist**
            $existingRoom = $this->roomModel->find($roomId);
            log_message('info', 'Existing room: ' . json_encode($existingRoom));
            
            if (!$existingRoom) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Room dengan ID ' . $roomId . ' tidak ditemukan'
                ]);
            }

            // **FIX: Update ke column 'status'**
            $updateData = ['status' => $status];
            log_message('info', 'Update data: ' . json_encode($updateData));

            // **DEBUG: Cek apakah ada perubahan data**
            if ($existingRoom['status'] === $status) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Status sudah sama, tidak ada perubahan'
                ]);
            }

            // **FIX: Update dengan validasi**
            $updated = $this->roomModel->update($roomId, $updateData);
            log_message('info', 'Update result: ' . ($updated ? 'success' : 'failed'));

            // **DEBUG: Cek data setelah update**
            $updatedRoom = $this->roomModel->find($roomId);
            log_message('info', 'Room after update: ' . json_encode($updatedRoom));

            if ($updated) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Status kamar berhasil diupdate ke: ' . ucfirst($status)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal update status kamar'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Update room status error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function updateBookingStatus($bookingId = null)
    {
        // Get booking ID from URL parameter or POST data
        if (!$bookingId) {
            $bookingId = $this->request->getPost('booking_id');
        }
        
        if (!$bookingId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Booking ID tidak ditemukan'
            ]);
        }

        $json = $this->request->getJSON();
        $status = $json->booking_status ?? null;

        if (!$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Status tidak ditemukan'
            ]);
        }

        try {
            $updateData = ['booking_status' => $status];
            $updated = $this->bookingModel->update($bookingId, $updateData);

            if ($updated) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Status pemesanan berhasil diupdate ke: ' . ucfirst($status)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal update status pemesanan'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Update booking status error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function updatePaymentStatus($bookingId = null)
    {
        // Get booking ID from URL parameter
        if (!$bookingId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Booking ID tidak ditemukan'
            ]);
        }

        $json = $this->request->getJSON();
        $status = $json->payment_status ?? null;

        if (!$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Status tidak ditemukan'
            ]);
        }

        try {
            $updateData = ['payment_status' => $status];
            $updated = $this->bookingModel->update($bookingId, $updateData);

            if ($updated) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Status pembayaran berhasil diupdate ke: ' . ucfirst($status)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal update status pembayaran'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Update payment status error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // **TAMBAH: Method delete untuk rooms**
    public function deleteRoom($roomId = null)
    {
        if (!$roomId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID kamar tidak ditemukan'
            ]);
        }

        try {
            // Cek apakah room exist
            $room = $this->roomModel->find($roomId);
            if (!$room) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Kamar tidak ditemukan'
                ]);
            }

            // Cek apakah room sedang digunakan untuk booking aktif
            $activeBookings = $this->bookingModel->where('room_id', $roomId)
                                                 ->whereIn('booking_status', ['pending', 'confirmed'])
                                                 ->findAll();
            
            if (!empty($activeBookings)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus kamar yang sedang digunakan untuk booking aktif'
                ]);
            }

            // Delete room
            $deleted = $this->roomModel->delete($roomId);
            
            if ($deleted) {
                return redirect()->to('admin/dashboard')->with('success', 'Kamar berhasil dihapus');
            } else {
                return redirect()->to('admin/dashboard')->with('error', 'Gagal menghapus kamar');
            }

        } catch (\Exception $e) {
            log_message('error', 'Delete room error: ' . $e->getMessage());
            return redirect()->to('admin/dashboard')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // **TAMBAH: Method delete untuk bookings**
    public function deleteBooking($bookingId = null)
    {
        if (!$bookingId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID booking tidak ditemukan'
            ]);
        }

        try {
            // Cek apakah booking exist
            $booking = $this->bookingModel->find($bookingId);
            if (!$booking) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Booking tidak ditemukan'
                ]);
            }

            // Hanya bisa hapus booking yang cancelled atau completed
            if (!in_array($booking['booking_status'], ['cancelled', 'completed'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Hanya booking yang cancelled atau completed yang bisa dihapus'
                ]);
            }

            // Delete booking
            $deleted = $this->bookingModel->delete($bookingId);
            
            if ($deleted) {
                return redirect()->to('admin/dashboard')->with('success', 'Booking berhasil dihapus');
            } else {
                return redirect()->to('admin/dashboard')->with('error', 'Gagal menghapus booking');
            }

        } catch (\Exception $e) {
            log_message('error', 'Delete booking error: ' . $e->getMessage());
            return redirect()->to('admin/dashboard')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // **TAMBAH: Method delete untuk users**
    public function deleteUser($userId = null)
    {
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID user tidak ditemukan'
            ]);
        }

        try {
            // Cek apakah user exist
            $user = $this->userModel->find($userId);
            if (!$user) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ]);
            }

            // Cek apakah user memiliki booking aktif
            $activeBookings = $this->bookingModel->where('user_id', $userId)
                                                 ->whereIn('booking_status', ['pending', 'confirmed'])
                                                 ->findAll();
            
            if (!empty($activeBookings)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus user yang memiliki booking aktif'
                ]);
            }

            // Delete user
            $deleted = $this->userModel->delete($userId);
            
            if ($deleted) {
                return redirect()->to('admin/dashboard')->with('success', 'User berhasil dihapus');
            } else {
                return redirect()->to('admin/dashboard')->with('error', 'Gagal menghapus user');
            }

        } catch (\Exception $e) {
            log_message('error', 'Delete user error: ' . $e->getMessage());
            return redirect()->to('admin/dashboard')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // **TAMBAH: Method untuk create room (jika diperlukan)**
    public function createRoom()
    {
        if ($this->request->getMethod() === 'POST') {
            // Handle POST request untuk create room
            $validation = \Config\Services::validation();
            $validation->setRules([
                'room_type' => 'required|max_length[100]',
                'room_number' => 'required|max_length[20]|is_unique[rooms.room_number]',
                'price' => 'required|numeric|greater_than[0]',
                'description' => 'permit_empty|max_length[1000]'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $data = [
                'room_type' => $this->request->getPost('room_type'),
                'room_number' => $this->request->getPost('room_number'),
                'price' => $this->request->getPost('price'),
                'description' => $this->request->getPost('description'),
                'status' => 'available'
            ];

            try {
                $inserted = $this->roomModel->insert($data);
                if ($inserted) {
                    return redirect()->to('admin/dashboard')->with('success', 'Kamar berhasil ditambahkan');
                } else {
                    return redirect()->back()->with('error', 'Gagal menambahkan kamar');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }

        // GET request - show form
        return view('admin/create_room', ['title' => 'Tambah Kamar Baru']);
    }

    // **TAMBAH: AJAX endpoint untuk mendapatkan statistik real-time**
    public function getStats()
    {
        // Get all data
        $bookings = $this->bookingModel->findAll();
        $rooms = $this->roomModel->findAll();
        $users = $this->userModel->findAll();
        
        // Calculate statistics
        $stats = [
            'total_bookings' => count($bookings),
            'total_rooms' => count($rooms),
            'total_users' => count($users),
            'pending_bookings' => count(array_filter($bookings, function($b) { 
                return isset($b['booking_status']) && $b['booking_status'] === 'pending'; 
            })),
            'confirmed_bookings' => count(array_filter($bookings, function($b) { 
                return isset($b['booking_status']) && $b['booking_status'] === 'confirmed'; 
            })),
            'cancelled_bookings' => count(array_filter($bookings, function($b) { 
                return isset($b['booking_status']) && $b['booking_status'] === 'cancelled'; 
            })),
            'available_rooms' => count(array_filter($rooms, function($r) { 
                return isset($r['status']) && $r['status'] === 'available'; 
            })),
            'occupied_rooms' => count(array_filter($rooms, function($r) { 
                return isset($r['status']) && $r['status'] === 'occupied'; 
            })),
            'maintenance_rooms' => count(array_filter($rooms, function($r) { 
                return isset($r['status']) && $r['status'] === 'maintenance'; 
            })),
            'paid_bookings' => count(array_filter($bookings, function($b) { 
                return isset($b['payment_status']) && $b['payment_status'] === 'paid'; 
            })),
            'pending_payments' => count(array_filter($bookings, function($b) { 
                return isset($b['payment_status']) && $b['payment_status'] === 'pending'; 
            }))
        ];
        
        // Calculate revenue
        $total_revenue = 0;
        $pending_revenue = 0;
        foreach ($bookings as $booking) {
            if (isset($booking['payment_status']) && isset($booking['total_amount'])) {
                if ($booking['payment_status'] === 'paid') {
                    $total_revenue += $booking['total_amount'];
                } elseif ($booking['payment_status'] === 'pending') {
                    $pending_revenue += $booking['total_amount'];
                }
            }
        }
        
        $stats['total_revenue'] = $total_revenue;
        $stats['pending_revenue'] = $pending_revenue;
        $stats['occupancy_rate'] = $stats['total_rooms'] > 0 ? round(($stats['occupied_rooms'] / $stats['total_rooms']) * 100, 1) : 0;
        $stats['payment_rate'] = $stats['total_bookings'] > 0 ? round(($stats['paid_bookings'] / $stats['total_bookings']) * 100, 1) : 0;
        
        return $this->response->setJSON([
            'success' => true,
            'stats' => $stats,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    // **TAMBAH: AJAX endpoint untuk mendapatkan recent bookings**
    public function getRecentBookings()
    {
        $bookings = $this->bookingModel->findAll();
        
        // Get recent bookings (last 10)
        usort($bookings, function($a, $b) {
            return strtotime($b['created_at'] ?? '0') <=> strtotime($a['created_at'] ?? '0');
        });
        $recent_bookings = array_slice($bookings, 0, 10);
        
        return $this->response->setJSON([
            'success' => true,
            'bookings' => $recent_bookings,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    // **TAMBAH: AJAX endpoint untuk mendapatkan system info**
    public function getSystemInfo()
    {
        // Simulate system monitoring data
        $systemInfo = [
            'database' => [
                'status' => 'online',
                'connections' => rand(5, 20),
                'response_time' => rand(10, 50) . 'ms'
            ],
            'server' => [
                'cpu_usage' => rand(15, 95),
                'memory_usage' => rand(40, 85),
                'disk_usage' => rand(50, 80),
                'uptime' => '7 days 12 hours'
            ],
            'application' => [
                'active_sessions' => rand(10, 100),
                'cache_status' => 'enabled',
                'last_backup' => date('Y-m-d H:i:s', strtotime('-2 hours'))
            ]
        ];
        
        return $this->response->setJSON([
            'success' => true,
            'system' => $systemInfo,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    // **TAMBAH: AJAX endpoint untuk notifikasi real-time**
    public function getNotifications()
    {
        // Dalam implementasi real, ini akan mengambil dari database
        $notifications = [];
        
        // Check for new bookings in last hour
        $recentBookings = $this->bookingModel->where('created_at >', date('Y-m-d H:i:s', strtotime('-1 hour')))->findAll();
        foreach ($recentBookings as $booking) {
            $notifications[] = [
                'type' => 'success',
                'title' => 'New Booking',
                'message' => 'New booking from ' . ($booking['guest_name'] ?? 'Guest'),
                'time' => $booking['created_at'],
                'action_url' => base_url('admin/bookings')
            ];
        }
        
        // Check for pending payments
        $pendingPayments = $this->bookingModel->where('payment_status', 'pending')->findAll();
        if (count($pendingPayments) > 0) {
            $notifications[] = [
                'type' => 'warning',
                'title' => 'Pending Payments',
                'message' => count($pendingPayments) . ' bookings with pending payments',
                'time' => date('Y-m-d H:i:s'),
                'action_url' => base_url('admin/bookings')
            ];
        }
        
        // Check for maintenance rooms
        $maintenanceRooms = $this->roomModel->where('status', 'maintenance')->findAll();
        if (count($maintenanceRooms) > 0) {
            $notifications[] = [
                'type' => 'info',
                'title' => 'Maintenance Rooms',
                'message' => count($maintenanceRooms) . ' rooms under maintenance',
                'time' => date('Y-m-d H:i:s'),
                'action_url' => base_url('admin/rooms')
            ];
        }
        
        return $this->response->setJSON([
            'success' => true,
            'notifications' => $notifications,
            'count' => count($notifications),
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    // **TAMBAH: Method untuk export data**
    public function exportData($type = 'bookings')
    {
        $filename = $type . '_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        switch ($type) {
            case 'bookings':
                fputcsv($output, ['ID', 'Guest Name', 'Booking Code', 'Room ID', 'Check In', 'Check Out', 'Total Amount', 'Booking Status', 'Payment Status', 'Created At']);
                $data = $this->bookingModel->findAll();
                foreach ($data as $row) {
                    fputcsv($output, [
                        $row['id'],
                        $row['guest_name'] ?? '',
                        $row['booking_code'] ?? '',
                        $row['room_id'],
                        $row['check_in'],
                        $row['check_out'],
                        $row['total_amount'],
                        $row['booking_status'] ?? 'pending',
                        $row['payment_status'] ?? 'pending',
                        $row['created_at'] ?? ''
                    ]);
                }
                break;
                
            case 'rooms':
                fputcsv($output, ['ID', 'Room Type', 'Room Number', 'Price', 'Status', 'Description']);
                $data = $this->roomModel->findAll();
                foreach ($data as $row) {
                    fputcsv($output, [
                        $row['id'],
                        $row['room_type'],
                        $row['room_number'],
                        $row['price'],
                        $row['status'] ?? 'available',
                        $row['description'] ?? ''
                    ]);
                }
                break;
                
            case 'users':
                fputcsv($output, ['ID', 'Full Name', 'Username', 'Email', 'Created At']);
                $data = $this->userModel->findAll();
                foreach ($data as $row) {
                    fputcsv($output, [
                        $row['id'],
                        $row['fullname'] ?? '',
                        $row['username'],
                        $row['email'],
                        $row['created_at'] ?? ''
                    ]);
                }
                break;
        }
        
        fclose($output);
        exit;
    }

    // ============================================
    // AJAX CRUD ENDPOINTS
    // ============================================

    /**
     * Get bookings data for AJAX
     */
    public function getBookings()
    {
        try {
            $bookings = $this->bookingModel->findAll();
            
            // Add additional information
            foreach ($bookings as &$booking) {
                $room = $this->roomModel->find($booking['room_id']);
                $booking['room_name'] = $room ? "Room " . $room['room_number'] : "Unknown Room";
                $booking['formatted_total'] = number_format($booking['total_amount'] ?? 0, 0, ',', '.');
                $booking['formatted_check_in'] = date('d/m/Y', strtotime($booking['check_in']));
                $booking['formatted_check_out'] = date('d/m/Y', strtotime($booking['check_out']));
            }
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $bookings
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error loading bookings: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update booking via AJAX
     */
    public function updateBookingAjax($bookingId = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        try {
            $data = $this->request->getJSON(true);
            
            if (!$bookingId) {
                $bookingId = $data['id'] ?? null;
            }

            if (!$bookingId) {
                return $this->response->setJSON(['success' => false, 'message' => 'Booking ID is required']);
            }

            $updateData = [];
            if (isset($data['booking_status'])) {
                $updateData['booking_status'] = $data['booking_status'];
            }
            if (isset($data['payment_status'])) {
                $updateData['payment_status'] = $data['payment_status'];
            }
            if (isset($data['guest_name'])) {
                $updateData['guest_name'] = $data['guest_name'];
            }
            if (isset($data['check_in'])) {
                $updateData['check_in'] = $data['check_in'];
            }
            if (isset($data['check_out'])) {
                $updateData['check_out'] = $data['check_out'];
            }
            if (isset($data['total_amount'])) {
                $updateData['total_amount'] = $data['total_amount'];
            }

            if (empty($updateData)) {
                return $this->response->setJSON(['success' => false, 'message' => 'No data to update']);
            }

            $result = $this->bookingModel->update($bookingId, $updateData);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Booking updated successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update booking'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error updating booking: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete booking via AJAX
     */
    public function deleteBookingAjax($bookingId = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        try {
            if (!$bookingId) {
                $data = $this->request->getJSON(true);
                $bookingId = $data['id'] ?? null;
            }

            if (!$bookingId) {
                return $this->response->setJSON(['success' => false, 'message' => 'Booking ID is required']);
            }

            $result = $this->bookingModel->delete($bookingId);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Booking deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to delete booking'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error deleting booking: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get rooms data for AJAX
     */
    public function getRooms()
    {
        try {
            $rooms = $this->roomModel->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $rooms
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error loading rooms: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Create/Update room via AJAX
     */
    public function saveRoomAjax($roomId = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        try {
            $data = $this->request->getJSON(true);
            
            $roomData = [
                'room_number' => $data['room_number'] ?? '',
                'room_type' => $data['room_type'] ?? '',
                'price' => $data['price'] ?? 0,
                'status' => $data['status'] ?? 'available',
                'description' => $data['description'] ?? ''
            ];

            // Validation
            if (empty($roomData['room_number']) || empty($roomData['room_type'])) {
                return $this->response->setJSON(['success' => false, 'message' => 'Room number and type are required']);
            }

            if ($roomId) {
                // Update existing room
                $result = $this->roomModel->update($roomId, $roomData);
                $message = 'Room updated successfully';
            } else {
                // Create new room
                $result = $this->roomModel->insert($roomData);
                $message = 'Room created successfully';
            }
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $message
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save room'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error saving room: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete room via AJAX
     */
    public function deleteRoomAjax($roomId = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        try {
            if (!$roomId) {
                $data = $this->request->getJSON(true);
                $roomId = $data['id'] ?? null;
            }

            if (!$roomId) {
                return $this->response->setJSON(['success' => false, 'message' => 'Room ID is required']);
            }

            // Check if room has active bookings
            $activeBookings = $this->bookingModel->where('room_id', $roomId)
                                                  ->where('booking_status', 'confirmed')
                                                  ->findAll();
            
            if (!empty($activeBookings)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Cannot delete room with active bookings'
                ]);
            }

            $result = $this->roomModel->delete($roomId);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Room deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to delete room'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error deleting room: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get users data for AJAX
     */
    public function getUsers()
    {
        try {
            $users = $this->userModel->findAll();
            
            // Remove sensitive information
            foreach ($users as &$user) {
                unset($user['password']);
                $user['formatted_created_at'] = isset($user['created_at']) ? 
                    date('d/m/Y H:i', strtotime($user['created_at'])) : '-';
            }
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error loading users: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Create/Update user via AJAX
     */
    public function saveUserAjax($userId = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        try {
            $data = $this->request->getJSON(true);
            
            $userData = [
                'fullname' => $data['fullname'] ?? '',
                'username' => $data['username'] ?? '',
                'email' => $data['email'] ?? '',
                'role' => $data['role'] ?? 'user'
            ];

            // Validation
            if (empty($userData['username']) || empty($userData['email'])) {
                return $this->response->setJSON(['success' => false, 'message' => 'Username and email are required']);
            }

            // Add password if provided (for new users or password updates)
            if (!empty($data['password'])) {
                $userData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            if ($userId) {
                // Update existing user
                $result = $this->userModel->update($userId, $userData);
                $message = 'User updated successfully';
            } else {
                // Create new user - password is required
                if (empty($data['password'])) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Password is required for new users']);
                }
                $result = $this->userModel->insert($userData);
                $message = 'User created successfully';
            }
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $message
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save user'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error saving user: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete user via AJAX
     */
    public function deleteUserAjax($userId = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        try {
            if (!$userId) {
                $data = $this->request->getJSON(true);
                $userId = $data['id'] ?? null;
            }

            if (!$userId) {
                return $this->response->setJSON(['success' => false, 'message' => 'User ID is required']);
            }

            // Prevent deletion of admin users or current user
            $user = $this->userModel->find($userId);
            if ($user && isset($user['role']) && $user['role'] === 'admin') {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Cannot delete admin users'
                ]);
            }

            $result = $this->userModel->delete($userId);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to delete user'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ]);
        }
    }
}