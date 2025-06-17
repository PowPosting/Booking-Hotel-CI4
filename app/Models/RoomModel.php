<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table = 'rooms'; // pastikan nama tabel sesuai dengan database Anda
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'room_number',    // Nomor kamar (S101, S102, dll)
        'room_type',      // Tipe kamar (Kamar Standard, dll)
        'status',         // Status (available, occupied, maintenance)
        'price',          // Harga
        'description',    // Deskripsi
        'created_at', 
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get available rooms for specific dates
     */
    public function getAvailableRooms($checkIn, $checkOut, $guests = 1)
    {
        // Get rooms that are not booked for the given dates
        $bookedRoomIds = $this->getBookedRoomIds($checkIn, $checkOut);
        
        $query = $this->where('is_available', 1)
                      ->where('capacity >=', $guests);
        
        if (!empty($bookedRoomIds)) {
            $query->whereNotIn('id', $bookedRoomIds);
        }
        
        return $query->findAll();
    }

    /**
     * Get room IDs that are booked for specific dates
     */
    private function getBookedRoomIds($checkIn, $checkOut)
    {
        $bookingModel = new \App\Models\BookingModel();
        
        // Find bookings that overlap with requested dates
        $bookings = $bookingModel->where('booking_status !=', 'cancelled')
                                 ->where('payment_status !=', 'failed')
                                 ->groupStart()
                                     ->where('check_in <=', $checkOut)
                                     ->where('check_out >=', $checkIn)
                                 ->groupEnd()
                                 ->findAll();
        
        $bookedRoomIds = [];
        foreach ($bookings as $booking) {
            $bookedRoomIds[] = $booking['room_id'];
        }
        
        return array_unique($bookedRoomIds);
    }

    /**
     * Check if specific room is available for dates
     */
    public function isRoomAvailable($roomId, $checkIn, $checkOut)
    {
        $bookedRoomIds = $this->getBookedRoomIds($checkIn, $checkOut);
        return !in_array($roomId, $bookedRoomIds);
    }

    /**
     * Get room with availability status
     */
    public function getRoomWithAvailability($roomId, $checkIn = null, $checkOut = null)
    {
        $room = $this->find($roomId);
        
        if ($room && $checkIn && $checkOut) {
            $room['is_available_for_dates'] = $this->isRoomAvailable($roomId, $checkIn, $checkOut);
        }
        
        return $room;
    }

    // Tambah method untuk handle status
    public function updateStatus($roomId, $status)
    {
        $data = [
            'is_available' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->update($roomId, $data);
    }
}