<?php
namespace App\Controllers;

use App\Models\BookingModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        $userModel = new \App\Models\UserModel();
        $roomModel = new \App\Models\RoomModel();

        $data = [
            'users' => $userModel->findAll(),
            'rooms' => $roomModel->findAll()
        ];

        return view('admin/dashboard', $data);
    }
}