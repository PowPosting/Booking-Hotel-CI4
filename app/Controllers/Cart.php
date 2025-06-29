<?php

namespace App\Controllers;

use App\Models\RoomModel;

class Cart extends BaseController
{
    protected $roomModel;

    public function __construct()
    {
        $this->roomModel = new RoomModel();
        helper(['url', 'form']);
    }

    /**
     * Add item to cart
     */
    public function add()
    {
        // Debug: Log all received POST data
        log_message('info', 'Cart add - POST data: ' . var_export($this->request->getPost(), true));
        
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu!'
            ]);
        }

        // Get POST data
        $roomId = $this->request->getPost('room_id');
        $roomName = $this->request->getPost('room_name');
        $roomType = $this->request->getPost('room_type');
        $price = $this->request->getPost('price');
        $checkIn = $this->request->getPost('check_in');
        $checkOut = $this->request->getPost('check_out');
        $image = $this->request->getPost('image');
        $guests = $this->request->getPost('guests') ?? 2;
        
        // Guest information
        $guestName = $this->request->getPost('guest_name');
        $guestEmail = $this->request->getPost('guest_email');
        $guestPhone = $this->request->getPost('guest_phone');
        $specialRequests = $this->request->getPost('special_requests');
        
        // Debug: Log critical fields
        log_message('info', "Cart add - Critical fields: roomId=$roomId, roomName=$roomName, price=$price, checkIn=$checkIn, checkOut=$checkOut");
        
        // Extra facilities
        $selectedFacilities = $this->request->getPost('selected_facilities');
        $facilitiesData = [];
        $facilitiesTotal = 0;
        
        // Process selected facilities
        if ($selectedFacilities) {
            $facilitiesArray = json_decode($selectedFacilities, true);
            if (is_array($facilitiesArray)) {
                foreach ($facilitiesArray as $facility) {
                    if (isset($facility['name']) && isset($facility['price'])) {
                        $facilitiesData[] = [
                            'name' => $facility['name'],
                            'price' => (int)$facility['price'],
                            'display_name' => $this->getFacilityDisplayName($facility['name'])
                        ];
                        $facilitiesTotal += (int)$facility['price'];
                    }
                }
            }
        }

        // Basic validation
        if (!$roomId || !$roomName || !$price || !$checkIn || !$checkOut) {
            log_message('error', 'Cart add - Missing required fields');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data kamar tidak lengkap!'
            ]);
        }
        
        if (!$guestName || !$guestEmail || !$guestPhone) {
            log_message('error', 'Cart add - Missing guest information');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tamu tidak lengkap!'
            ]);
        }

        // **CHECK AVAILABILITY FIRST**
        $roomModel = new \App\Models\RoomModel();
        $isAvailable = $roomModel->isRoomAvailable($roomId, $checkIn, $checkOut);
        
        if (!$isAvailable) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Maaf, kamar tidak tersedia untuk tanggal yang dipilih!'
            ]);
        }

        // Get room details
        $room = $roomModel->find($roomId);
        if (!$room) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kamar tidak ditemukan!'
            ]);
        }

        // Debug room data
        log_message('info', 'Room data type: ' . gettype($room));
        log_message('info', 'Room data: ' . var_export($room, true));

        // Convert to array if it's an object
        if (is_object($room)) {
            $room = (array) $room;
        }

        // Debug after conversion
        log_message('info', 'Room data after conversion: ' . var_export($room, true));

        // Calculate nights and total price
        $checkInDate = new \DateTime($checkIn);
        $checkOutDate = new \DateTime($checkOut);
        $nights = $checkInDate->diff($checkOutDate)->days;
        
        // Use safe array access
        $roomPrice = isset($room['price']) ? $room['price'] : (isset($room['room_price']) ? $room['room_price'] : $price);
        $roomTotal = $roomPrice * $nights;
        $totalPrice = $roomTotal + $facilitiesTotal;

        // Add to cart
        $cartItem = [
            'id' => uniqid(), // **TAMBAH UNIQUE ID**
            'room_id' => $roomId,
            'room_name' => $room['room_number'] ?? ('Room ' . $roomId),
            'room_type' => $room['room_type'] ?? $roomType ?? 'Standard',
            'price' => $roomPrice,
            'image' => $image ?? 'default-room.jpg', // **Image dari POST**
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'nights' => $nights,
            'guests' => $guests,
            'room_total' => $roomTotal,
            'facilities' => $facilitiesData,
            'facilities_total' => $facilitiesTotal,
            'total_price' => $totalPrice,
            'guest_name' => $guestName, // **TAMBAH GUEST INFO**
            'guest_email' => $guestEmail,
            'guest_phone' => $guestPhone,
            'special_requests' => $specialRequests,
            'added_at' => date('Y-m-d H:i:s')
        ];

        // Get existing cart
        $cartItems = session()->get('cart_items') ?? [];
        
        // Check if same room and dates already in cart
        $existingKey = null;
        foreach ($cartItems as $key => $item) {
            if ($item['room_id'] == $roomId && 
                $item['check_in'] == $checkIn && 
                $item['check_out'] == $checkOut) {
                $existingKey = $key;
                break;
            }
        }

        if ($existingKey !== null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kamar untuk tanggal ini sudah ada di keranjang!'
            ]);
        }

        // Add to cart
        $cartItems[] = $cartItem;
        session()->set('cart_items', $cartItems);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Kamar berhasil ditambahkan ke keranjang!',
            'cart_count' => count($cartItems)
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove()
    {
        $index = $this->request->getPost('index');
        
        // **DEBUG: Log received data**
        log_message('info', 'Remove cart - received index: ' . var_export($index, true));
        
        // Convert to integer
        $index = (int) $index;
        
        if ($index < 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Index tidak valid!'
            ]);
        }

        $cartItems = session()->get('cart_items') ?? [];
        
        // **DEBUG: Log cart items**
        log_message('info', 'Cart items count: ' . count($cartItems));
        
        if (!isset($cartItems[$index])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "Item dengan index $index tidak ditemukan! Total items: " . count($cartItems)
            ]);
        }

        // Remove by index
        unset($cartItems[$index]);
        $cartItems = array_values($cartItems); // Reindex
        session()->set('cart_items', $cartItems);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Item berhasil dihapus!',
            'cart_count' => count($cartItems)
        ]);
    }

    /**
     * Get all cart items
     */
    public function getItems()
    {
        $cartItems = session()->get('cart_items') ?? [];
        
        if (empty($cartItems)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cart is empty',
                'items' => [],
                'count' => 0
            ]);
        }
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['total_price'] ?? 0;
        }

        return $this->response->setJSON([
            'success' => true,
            'items' => $cartItems,
            'count' => count($cartItems),
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'formatted_subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
            'formatted_total' => 'Rp ' . number_format($subtotal, 0, ',', '.')
        ]);
    }

    /**
     * Get facility display name
     */
    private function getFacilityDisplayName($facilityKey)
    {
        $facilityNames = [
            'breakfast' => 'Paket Sarapan',
            'spa' => 'Spa Package',
            'private_gym' => 'Private Gym',
            'airport_transfer' => 'Airport Transfer',
            'late_checkout' => 'Late Check-out',
            'minibar' => 'Minibar Package'
        ];

        return $facilityNames[$facilityKey] ?? ucfirst(str_replace('_', ' ', $facilityKey));
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        session()->remove('cart_items');
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Keranjang dikosongkan!'
        ]);
    }
}