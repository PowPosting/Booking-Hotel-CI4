<?php
namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\RoomModel;

class Booking extends BaseController
{
    public function create()
    {
        $model = new BookingModel();
        $data = [
            'user_id'    => session()->get('user_id'),
            'room_type'  => $this->request->getPost('room_type'),
            'check_in'   => $this->request->getPost('check_in'),
            'check_out'  => $this->request->getPost('check_out'),
            'total_price'=> $this->request->getPost('total_price'),
            'status'     => 'pending'
        ];
        $model->insert($data);
        return redirect()->to('/dashboard');
    }

    public function showRooms()
    {
        $roomModel = new \App\Models\RoomModel();
        $data = [
            'rooms' => $roomModel->findAll()
        ];
        return view('partials/rooms', $data);
    }

    public function pesan()
    {
        $roomNumber = $this->request->getPost('room_number');
        // Ambil data lain sesuai kebutuhan (user_id, check_in, check_out, dst)
        $userId = session('user_id') ?? 1; // contoh, sesuaikan dengan sistem loginmu
        $roomType = $this->request->getPost('room_type') ?? ''; // jika perlu
        $checkIn = $this->request->getPost('check_in') ?? date('Y-m-d');
        $checkOut = $this->request->getPost('check_out') ?? date('Y-m-d', strtotime('+1 day'));
        $totalPrice = 0; // hitung sesuai kebutuhan

        // 1. Simpan ke tabel bookings
        $bookingModel = new BookingModel();
        $bookingModel->insert([
            'user_id' => $userId,
            'room_type' => $roomType,
            'room_number' => $roomNumber,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'total_price' => $totalPrice,
            'status' => 'booked'
        ]);

        // 2. Update status kamar jadi 'occupied'
        $roomModel = new RoomModel();
        $roomModel->where('room_number', $roomNumber)
                  ->set(['status' => 'occupied'])
                  ->update();

        return redirect()->to('/')->with('success', 'Pemesanan berhasil!');
    }
}