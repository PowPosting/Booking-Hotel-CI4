<?php
// filepath: d:\laragon\www\Hotel\app\Controllers\Room.php

namespace App\Controllers;

use App\Models\RoomModel;

class Room extends BaseController
{
    protected $roomModel;

    public function __construct()
    {
        $this->roomModel = new RoomModel();
    }

    /**
     * Show all rooms
     */
    public function index()
    {
        $rooms = $this->roomModel->where('is_available', 1)->findAll();
        
        $data = [
            'title' => 'Daftar Kamar',
            'rooms' => $rooms
        ];

        return view('rooms/index', $data);
    }

    /**
     * Show room detail
     */
    public function detail($id)
    {
        $checkIn = $this->request->getGet('check_in');
        $checkOut = $this->request->getGet('check_out');
        
        $room = $this->roomModel->getRoomWithAvailability($id, $checkIn, $checkOut);
        
        if (!$room) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kamar tidak ditemukan');
        }

        $data = [
            'title' => $room['room_name'],
            'room' => $room,
            'check_in' => $checkIn,
            'check_out' => $checkOut
        ];

        return view('rooms/detail', $data);
    }

    /**
     * Get available rooms (AJAX)
     */
    public function getAvailable()
    {
        $checkIn = $this->request->getPost('check_in') ?? $this->request->getGet('check_in');
        $checkOut = $this->request->getPost('check_out') ?? $this->request->getGet('check_out');
        $guests = $this->request->getPost('guests') ?? $this->request->getGet('guests') ?? 1;

        if (!$checkIn || !$checkOut) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tanggal check-in dan check-out harus diisi'
            ]);
        }

        try {
            $availableRooms = $this->roomModel->getAvailableRooms($checkIn, $checkOut, $guests);
            
            return $this->response->setJSON([
                'success' => true,
                'rooms' => $availableRooms,
                'count' => count($availableRooms),
                'message' => count($availableRooms) . ' kamar tersedia'
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Search available rooms
     */
    public function search()
    {
        $checkIn = $this->request->getPost('check_in');
        $checkOut = $this->request->getPost('check_out');
        $guests = $this->request->getPost('guests') ?? 1;
        $roomType = $this->request->getPost('room_type');

        if (!$checkIn || !$checkOut) {
            return redirect()->back()->with('error', 'Tanggal check-in dan check-out harus diisi');
        }

        $availableRooms = $this->roomModel->getAvailableRooms($checkIn, $checkOut, $guests);
        
        // Filter by room type if specified
        if ($roomType) {
            $availableRooms = array_filter($availableRooms, function($room) use ($roomType) {
                return $room['room_type'] === $roomType;
            });
        }

        $data = [
            'title' => 'Hasil Pencarian Kamar',
            'rooms' => $availableRooms,
            'search_params' => [
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'guests' => $guests,
                'room_type' => $roomType
            ]
        ];

        return view('rooms/search', $data);
    }
}