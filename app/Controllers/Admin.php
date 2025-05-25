<?php
namespace App\Controllers;

use App\Models\BookingModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        $userModel = new \App\Models\UserModel();
        $bookingModel = new \App\Models\BookingModel();
        $roomModel = new \App\Models\RoomModel();

        $data = [
            'users' => $userModel->findAll(),
            'bookings' => $bookingModel->findAll(),
            'rooms' => $roomModel->findAll()
        ];

        return view('admin/dashboard', $data);
    }

    public function booking()
    {
        $userModel = new \App\Models\UserModel();
        $bookingModel = new \App\Models\BookingModel();
        $roomModel = new \App\Models\RoomModel();

        $data = [
            'users' => $userModel->findAll(),
            'bookings' => $bookingModel->findAll(),
            'rooms' => $roomModel->findAll()
        ];

        return view('partials/rooms', $data); // atau view utama lain
    }
}