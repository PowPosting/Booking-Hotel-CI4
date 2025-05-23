<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index(): string
    {
        $data = [
            'error'   => session()->getFlashdata('error'),
            'success' => session()->getFlashdata('success')
        ];
        return view('Auth/login', $data);
    }

    public function register()
    {
        $userModel = new UserModel();

        // Cek username/email sudah ada
        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');

        if ($userModel->where('username', $username)->first()) {
            return redirect()->to('/login')->with('error', 'Username sudah terdaftar!');
        }
        if ($userModel->where('email', $email)->first()) {
            return redirect()->to('/login')->with('error', 'Email sudah terdaftar!');
        }

        $data = [
            'fullname' => $this->request->getPost('fullname'),
            'username' => $username,
            'email'    => $email,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'phone'    => $this->request->getPost('phone'),
        ];

        $userModel->insert($data);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil, silakan login!');
    }

    public function login()
    {
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            session()->set([
                'username' => $user['username'],
                'logged_in' => true
            ]);
            return redirect()->to('/');
        } else {
            return redirect()->to('/login')->with('error', 'Username atau password salah!');
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}