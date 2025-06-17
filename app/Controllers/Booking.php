<?php
// filepath: d:\laragon\www\Hotel\app\Controllers\Booking.php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\RoomModel;
use App\Models\UserModel;

class Booking extends BaseController
{
    protected $bookingModel;
    protected $roomModel;
    protected $userModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->roomModel = new RoomModel();
        $this->userModel = new UserModel();
        helper(['url', 'form']);
    }

    /**
     * Process booking from checkout
     */
    public function process()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu!'
            ]);
        }

        // Get cart items
        $cartItems = session()->get('cart_items') ?? [];
        
        if (empty($cartItems)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Keranjang kosong!'
            ]);
        }

        // Set default values
        $userId = session()->get('user_id');
        $guestName = session()->get('username') ?? 'Guest User';
        $guestEmail = session()->get('email') ?? 'guest@hotel.com';
        $guestPhone = '08123456789';
        $specialRequests = '';

        // Get payment method
        $paymentMethod = $this->request->getPost('payment_method');
        $bankCode = $this->request->getPost('bank_code');

        if (!$paymentMethod) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Pilih metode pembayaran!'
            ]);
        }

        if ($paymentMethod === 'bank_va' && !$bankCode) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Pilih bank untuk Virtual Account!'
            ]);
        }

        try {
            $db = \Config\Database::connect();
            $db->transStart();

            $lastBookingCode = '';
            $lastBookingId = 0;
            $lastTotalAmount = 0;
            $lastBookingData = [];

            // Process each cart item
            foreach ($cartItems as $item) {
                // Generate booking code
                $bookingCode = $this->generateBookingCode();

                // Calculate tax
                $subtotal = $item['total_price'];
                $tax = round($subtotal * 0.1);
                $totalAmount = $subtotal + $tax;

                // Prepare booking data
                $bookingData = [
                    'booking_code' => $bookingCode,
                    'user_id' => (int)$userId,
                    'room_id' => (int)$item['room_id'],
                    'guest_name' => $guestName,
                    'guest_email' => $guestEmail,
                    'guest_phone' => $guestPhone,
                    'check_in' => $item['check_in'],
                    'check_out' => $item['check_out'],
                    'nights' => (int)$item['nights'],
                    'guests' => (int)$item['guests'],
                    'room_price' => (float)$item['price'],
                    'total_amount' => (float)$totalAmount,
                    'special_requests' => $specialRequests,
                    'booking_status' => 'pending',
                    'payment_status' => 'pending',
                    'payment_method' => $paymentMethod
                ];

                // Add payment-specific data
                if ($paymentMethod === 'bank_va') {
                    $bookingData['bank_code'] = $bankCode;
                    $bookingData['virtual_account'] = $this->generateVirtualAccount($bankCode);
                    $bookingData['expired_at'] = date('Y-m-d H:i:s', strtotime('+24 hours'));
                } elseif ($paymentMethod === 'qris') {
                    $bookingData['qr_code_url'] = $this->generateQRCode($bookingCode, $totalAmount);
                    $bookingData['expired_at'] = date('Y-m-d H:i:s', strtotime('+30 minutes'));
                }

                // Save booking
                $bookingId = $this->bookingModel->insert($bookingData);
                
                if (!$bookingId) {
                    $errors = $this->bookingModel->errors();
                    log_message('error', 'Booking insert failed: ' . json_encode($errors));
                    throw new \Exception('Gagal menyimpan booking: ' . implode(', ', $errors));
                }

                // Store last booking data for response
                $lastBookingCode = $bookingCode;
                $lastBookingId = $bookingId;
                $lastTotalAmount = $totalAmount;
                $lastBookingData = $bookingData;
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Transaksi database gagal!'
                ]);
            }

            // Clear cart
            session()->remove('cart_items');

            // Return response based on payment method
            if ($paymentMethod === 'cod') {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Booking berhasil! Silakan bayar di hotel saat check-in.',
                    'booking_code' => $lastBookingCode,
                    'booking_id' => $lastBookingId,
                    'payment_method' => 'cod',
                    'total_amount' => number_format($lastTotalAmount, 0, ',', '.')
                ]);
            } elseif ($paymentMethod === 'bank_va') {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Booking berhasil! Silakan lakukan pembayaran melalui Virtual Account.',
                    'booking_code' => $lastBookingCode,
                    'booking_id' => $lastBookingId,
                    'payment_method' => 'bank_va',
                    'bank_code' => $bankCode,
                    'virtual_account' => $lastBookingData['virtual_account'],
                    'expired_at' => date('d/m/Y H:i', strtotime($lastBookingData['expired_at'])),
                    'total_amount' => number_format($lastTotalAmount, 0, ',', '.')
                ]);
            } elseif ($paymentMethod === 'qris') {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Booking berhasil! Silakan scan QR Code untuk pembayaran.',
                    'booking_code' => $lastBookingCode,
                    'booking_id' => $lastBookingId,
                    'payment_method' => 'qris',
                    'qr_code_url' => $lastBookingData['qr_code_url'],
                    'expired_at' => date('d/m/Y H:i', strtotime($lastBookingData['expired_at'])),
                    'total_amount' => number_format($lastTotalAmount, 0, ',', '.')
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Booking process error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show user bookings
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $bookings = $this->bookingModel->where('user_id', session()->get('user_id'))
                                      ->orderBy('created_at', 'DESC')
                                      ->findAll();

        $data = [
            'title' => 'My Bookings',
            'bookings' => $bookings
        ];

        return view('booking/index', $data);
    }

    /**
     * Get notifications for current user
     */
    public function getNotifications()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'notifications' => [],
                'count' => 0
            ]);
        }

        $userId = session()->get('user_id');
        
        try {
            // Get recent bookings
            $bookings = $this->bookingModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->limit(5)->findAll();

            $notifications = [];
            foreach ($bookings as $booking) {
                // **TAMBAH: Generate status dan message berdasarkan booking & payment status**
                $statusInfo = $this->getBookingStatusInfo($booking['booking_status'], $booking['payment_status']);
                
                $notifications[] = [
                    'id' => $booking['id'],
                    'title' => 'Booking ' . $booking['booking_code'],
                    'booking_status' => $booking['booking_status'], 
                    'payment_status' => $booking['payment_status'], 
                    'status_text' => $statusInfo['status_text'], 
                    'status_color' => $statusInfo['status_color'], 
                    'status_icon' => $statusInfo['status_icon'], 
                    'message' => $statusInfo['message'] . ' - Rp ' . number_format($booking['total_amount'], 0, ',', '.'),
                    'time' => $this->timeAgo($booking['created_at']), 
                    'url' => base_url('booking/detail/' . $booking['id'])
                ];
            }

            return $this->response->setJSON([
                'success' => true,
                'notifications' => $notifications,
                'count' => count($notifications)
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Notification error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'error' => $e->getMessage(),
                'notifications' => [],
                'count' => 0
            ]);
        }
    }

    //pembayaran
    public function payment($bookingId)
    {
        $booking = $this->bookingModel->getBookingDetails($bookingId);
        
        if (!$booking || $booking['user_id'] != session()->get('user_id')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booking not found');
        }

        $data = [
            'title' => 'Payment - ' . $booking['booking_code'],
            'booking' => $booking
        ];

        return view('booking/payment', $data);
    }

    public function success()
    {
        $data = [
            'title' => 'Booking Success'
        ];

        return view('booking/success', $data);
    }

    //generate booking code
    private function generateBookingCode()
    {
        $prefix = 'HTL';
        $date = date('ymd');
        
        do {
            $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $bookingCode = $prefix . $date . $random;
            
            // Check if booking code already exists
            $exists = $this->bookingModel->where('booking_code', $bookingCode)->first();
        } while ($exists);
        
        return $bookingCode;
    }

    // Generate virtual account dari bank
    private function generateVirtualAccount($bankCode)
    {
        $prefix = [
            'BCA' => '77777',
            'BNI' => '88888',
            'BRI' => '99999',
            'MANDIRI' => '70012'
        ];

        $bankPrefix = $prefix[$bankCode] ?? '12345';
        $randomNumber = str_pad(mt_rand(1, 99999999999), 11, '0', STR_PAD_LEFT);
        
        return $bankPrefix . $randomNumber;
    }

    // Generate QR Code URL
    private function generateQRCode($bookingCode, $amount)
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='.urlencode("BOOKING:{$bookingCode}|AMOUNT:{$amount}");
    }

    /**
     * **TAMBAH: Method untuk generate status info**
     */
    private function getBookingStatusInfo($bookingStatus, $paymentStatus)
    {
        // Kombinasi booking status dan payment status
        if ($bookingStatus === 'confirmed' && $paymentStatus === 'paid') {
            return [
                'status_text' => 'Terkonfirmasi & Lunas',
                'status_color' => 'success',
                'status_icon' => 'fas fa-check-circle',
                'message' => 'Booking terkonfirmasi dan pembayaran lunas'
            ];
        }
        
        if ($bookingStatus === 'confirmed' && $paymentStatus === 'pending') {
            return [
                'status_text' => 'Terkonfirmasi - Menunggu Bayar',
                'status_color' => 'warning',
                'status_icon' => 'fas fa-clock',
                'message' => 'Booking terkonfirmasi, menunggu pembayaran'
            ];
        }
        
        if ($bookingStatus === 'pending' && $paymentStatus === 'paid') {
            return [
                'status_text' => 'Dibayar - Menunggu Konfirmasi',
                'status_color' => 'info',
                'status_icon' => 'fas fa-hourglass-half',
                'message' => 'Pembayaran berhasil, menunggu konfirmasi'
            ];
        }
        
        if ($bookingStatus === 'pending' && $paymentStatus === 'pending') {
            return [
                'status_text' => 'Menunggu Pembayaran',
                'status_color' => 'warning',
                'status_icon' => 'fas fa-exclamation-triangle',
                'message' => 'Booking berhasil, silakan lakukan pembayaran'
            ];
        }
        
        if ($bookingStatus === 'cancelled') {
            return [
                'status_text' => 'Dibatalkan',
                'status_color' => 'danger',
                'status_icon' => 'fas fa-times-circle',
                'message' => 'Booking telah dibatalkan'
            ];
        }
        
        if ($paymentStatus === 'failed') {
            return [
                'status_text' => 'Pembayaran Gagal',
                'status_color' => 'danger',
                'status_icon' => 'fas fa-times-circle',
                'message' => 'Pembayaran gagal diproses'
            ];
        }
        
        if ($paymentStatus === 'expired') {
            return [
                'status_text' => 'Kadaluarsa',
                'status_color' => 'secondary',
                'status_icon' => 'fas fa-clock',
                'message' => 'Waktu pembayaran telah habis'
            ];
        }
        
        // Default status
        return [
            'status_text' => 'Booking Baru',
            'status_color' => 'primary',
            'status_icon' => 'fas fa-info-circle',
            'message' => 'Booking berhasil dibuat'
        ];
    }

    /**
     * **TAMBAH: Method untuk waktu relatif**
     */
    private function timeAgo($datetime)
    {
        $time = time() - strtotime($datetime);
        
        if ($time < 60) {
            return 'Baru saja';
        } elseif ($time < 3600) {
            return floor($time / 60) . ' menit lalu';
        } elseif ($time < 86400) {
            return floor($time / 3600) . ' jam lalu';
        } elseif ($time < 2592000) {
            return floor($time / 86400) . ' hari lalu';
        } else {
            return date('d/m/Y', strtotime($datetime));
        }
    }
}