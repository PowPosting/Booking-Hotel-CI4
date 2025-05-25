<?php

namespace App\Controllers;

use App\Models\RoomModel;

class Home extends BaseController
{
    public function index()
    {
        $roomModel = new RoomModel();
        $data = [
            'rooms' => $roomModel->findAll()
        ];
        return view('index', $data);
    }
}
