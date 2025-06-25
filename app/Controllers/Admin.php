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
        // **FIX: Load data untuk dashboard**
        $data = [
            'title' => 'Dashboard Admin',
            'bookings' => $this->bookingModel->findAll(),
            'rooms' => $this->roomModel->findAll(),
            'users' => $this->userModel->findAll()
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
}