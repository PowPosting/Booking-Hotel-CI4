<?php

namespace App\Controllers;

use App\Models\RoomModel;

class Home extends BaseController
{
    public function index()
    {
        // Redirect admin to dashboard if they try to access home
        if (session()->get('admin_only')) {
            return redirect()->to('/admin/dashboard');
        }

        // Normal home page for users/guests
        $data = [
            'title' => 'LuxStay Hotel'
        ];
        
        return view('index', $data);
    }
}
