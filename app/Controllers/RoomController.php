<?php
// filepath: d:\laragon\www\Hotel\app\Controllers\RoomController.php

namespace App\Controllers;

use App\Models\RoomModel;

class RoomController extends BaseController
{
    protected $roomModel;

    public function __construct()
    {
        $this->roomModel = new RoomModel();
        helper(['url', 'form']);
    }

    /**
     * Get available rooms for AJAX request
     */
    public function getAvailable()
    {
        try {
            $roomType = $this->request->getVar('room_type');
            
            if (empty($roomType)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Room type is required'
                ]);
            }

            // Get ALL rooms by type (both available and occupied)
            $allRooms = $this->roomModel->where('room_type', $roomType)
                                      ->orderBy('room_number', 'ASC')
                                      ->findAll();

            if (empty($allRooms)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No rooms found for type: ' . $roomType,
                    'available_room_types' => $this->getAvailableRoomTypes()
                ]);
            }

            // Separate available and occupied rooms
            $availableRooms = [];
            $occupiedRooms = [];
            $maintenanceRooms = [];

            foreach ($allRooms as $room) {
                switch ($room['status']) {
                    case 'available':
                        $availableRooms[] = $room;
                        break;
                    case 'occupied':
                        $occupiedRooms[] = $room;
                        break;
                    case 'maintenance':
                        $maintenanceRooms[] = $room;
                        break;
                }
            }

            // Group ALL rooms by floor
            $roomsByFloor = [];
            foreach ($allRooms as $room) {
                $floor = substr($room['room_number'], 0, 1);
                if (empty($floor) || !is_numeric($floor)) {
                    $floor = '1';
                }
                
                if (!isset($roomsByFloor[$floor])) {
                    $roomsByFloor[$floor] = [];
                }
                $roomsByFloor[$floor][] = $room;
            }

            return $this->response->setJSON([
                'success' => true,
                'rooms_by_floor' => $roomsByFloor,
                'statistics' => [
                    'total_rooms' => count($allRooms),
                    'available_count' => count($availableRooms),
                    'occupied_count' => count($occupiedRooms),
                    'maintenance_count' => count($maintenanceRooms)
                ],
                'room_type' => $roomType
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Validate room selection
     */
    public function validateRoom()
    {
        $roomId = $this->request->getPost('room_id');
        $roomNumber = $this->request->getPost('room_number');
        $roomType = $this->request->getPost('room_type');

        if (!$roomId || !$roomNumber || !$roomType) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room data incomplete'
            ]);
        }

        // Validate room exists and is available
        $room = $this->roomModel->find($roomId);
        
        if (!$room) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room not found'
            ]);
        }

        if ($room['status'] !== 'available') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room is not available'
            ]);
        }

        if ($room['room_type'] !== $roomType || $room['room_number'] !== $roomNumber) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room data mismatch'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'room' => $room,
            'message' => 'Room is available'
        ]);
    }

    /**
     * Helper method to get available room types
     */
    private function getAvailableRoomTypes()
    {
        try {
            $roomTypes = $this->roomModel->select('room_type')
                                       ->distinct()
                                       ->findAll();
            return array_column($roomTypes, 'room_type');
        } catch (\Exception $e) {
            return [];
        }
    }
}