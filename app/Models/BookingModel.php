<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'booking_code', 'user_id', 'room_id', 'guest_name', 'guest_email', 
        'guest_phone', 'check_in', 'check_out', 'nights', 'guests', 
        'room_price', 'total_amount', 'special_requests', 'booking_status', 
        'payment_status', 'payment_method', 'bank_code', 'virtual_account',
        'qr_code_url', 'payment_proof', 'paid_at', 'expired_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // GANTI validation rules yang ketat ini:
    protected $validationRules = [
        'booking_code' => 'required',
        'user_id' => 'required|integer',
        'room_id' => 'required|integer',
        'guest_name' => 'required',
        'check_in' => 'required',
        'check_out' => 'required',
        'payment_method' => 'required'
    ];

    // Get booking with room details
    public function getBookingDetails($bookingId)
    {
        return $this->select('bookings.*, rooms.name as room_name, rooms.type as room_type, users.name as user_name')
                    ->join('rooms', 'rooms.id = bookings.room_id')
                    ->join('users', 'users.id = bookings.user_id')
                    ->where('bookings.id', $bookingId)
                    ->first();
    }

    // Update payment status
    public function updatePaymentStatus($bookingId, $status, $additionalData = [])
    {
        $data = ['payment_status' => $status];
        
        if ($status === 'paid') {
            $data['paid_at'] = date('Y-m-d H:i:s');
            $data['booking_status'] = 'confirmed';
        }
        
        $data = array_merge($data, $additionalData);
        
        return $this->update($bookingId, $data);
    }
}