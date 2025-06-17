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
        // **SILENT VALIDATION untuk register juga**
        $validation = $this->validate([
            'fullname' => 'required|min_length[3]|max_length[100]',
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'phone' => 'required|min_length[10]|max_length[15]',
            'password' => 'required|min_length[6]|regex_match[/^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/]',
            'confirm_password' => 'required|matches[password]'
        ]);

        
        if (!$validation) {
            return redirect()->to('/login')->with('error', 'Username atau password salah!');
        }

        $userModel = new UserModel();
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        
        if ($password !== $confirmPassword) {
            return redirect()->to('/login')->with('error', 'Username atau password salah!');
        }
        
        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');

        if ($userModel->where('username', $username)->first()) {
            return redirect()->to('/login')->with('error', 'Username atau password salah!');
        }
        if ($userModel->where('email', $email)->first()) {
            return redirect()->to('/login')->with('error', 'Username atau password salah!');
        }

        $data = [
            'fullname' => $this->request->getPost('fullname'),
            'username' => $username,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'phone'    => $this->request->getPost('phone'),
            'security_question' => $this->request->getPost('security_question'),
            'security_answer' => strtolower(trim($this->request->getPost('security_answer')))
        ];

        $userModel->insert($data);
        return redirect()->to('/login')->with('success', 'Registrasi berhasil, silakan login!');
    }

    public function login()
    {
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Admin login (special case - bypass validation)
        if ($username === 'admin' && $password === 'admin1') {
            session()->set([
                'user_id' => 0,
                'username' => 'admin',
                'fullname' => 'Administrator',
                'email' => 'admin@hotel.com',
                'is_admin' => true,
                'logged_in' => true,
                'admin_only' => true 
            ]);
            return redirect()->to('/admin/dashboard');
        }

        // **SILENT VALIDATION - semua error jadi "Username atau password salah"**
        $validation = $this->validate([
            'username' => 'required|min_length[3]|max_length[50]',
            'password' => 'required|min_length[6]|regex_match[/^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/]'
        ]);

        // **JIKA VALIDATION GAGAL - return error umum**
        if (!$validation) {
            return redirect()->to('/login')->with('error', 'Username atau password salah!');
        }

        $user = $userModel->where('username', $username)->first();
        
        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'fullname' => $user['fullname'],
                'email' => $user['email'],
                'is_admin' => false,
                'logged_in' => true,
                'admin_only' => false 
            ]);
            return redirect()->to('/');
        } else {
            return redirect()->to('/login')->with('error', 'Username atau password salah!');
        }
    }

    public function forgotPassword()
    {
        $username = $this->request->getPost('username');
        $securityAnswer = strtolower(trim($this->request->getPost('security_answer')));
        $userModel = new UserModel();
        
        $user = $userModel->where('username', $username)->first();
        
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Username tidak ditemukan!');
        }
        
        // Cek jawaban security question
        if ($user['security_answer'] !== $securityAnswer) {
            return redirect()->to('/login')->with('error', 'Jawaban pertanyaan keamanan salah!');
        }
        
        // Generate reset token dan simpan di session
        $resetToken = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+30 minutes'));
        
        session()->set('reset_token_' . $user['id'], [
            'token' => $resetToken,
            'expires_at' => $expiry,
            'username' => $username
        ]);
        
        // Redirect ke halaman reset password
        return redirect()->to('/reset-password/' . $resetToken);
    }

    public function resetPassword($token = null)
    {
        if (!$token) {
            return redirect()->to('/login')->with('error', 'Token reset tidak valid!');
        }
        
        // Validasi token (cek di session)
        $userModel = new UserModel();
        $users = $userModel->findAll();
        $validToken = false;
        $userId = null;
        
        foreach ($users as $user) {
            $resetData = session()->get('reset_token_' . $user['id']);
            if ($resetData && $resetData['token'] === $token) {
                if (strtotime($resetData['expires_at']) > time()) {
                    $validToken = true;
                    $userId = $user['id'];
                    break;
                }
            }
        }
        
        if (!$validToken) {
            return redirect()->to('/login')->with('error', 'Token reset tidak valid atau sudah expired!');
        }
        
        $data = [
            'token' => $token,
            'user_id' => $userId
        ];
        
        return view('Auth/password_ressets', $data);
    }

    public function updatePassword()
    {
        $token = $this->request->getPost('token');
        $userId = $this->request->getPost('user_id');
        $newPassword = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        
        // Validasi password
        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Password dan konfirmasi password tidak cocok!');
        }
        
        if (strlen($newPassword) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter!');
        }
        
        // Validasi token lagi
        $resetData = session()->get('reset_token_' . $userId);
        if (!$resetData || $resetData['token'] !== $token || strtotime($resetData['expires_at']) <= time()) {
            return redirect()->to('/login')->with('error', 'Token reset tidak valid atau sudah expired!');
        }
        
        // Update password
        $userModel = new UserModel();
        $userModel->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);
        
        // Hapus token dari session
        session()->remove('reset_token_' . $userId);
        
        return redirect()->to('/login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }

    // Method untuk AJAX check username dan ambil security question
    public function checkUsername()
    {
        $username = $this->request->getPost('username');
        $userModel = new UserModel();
        
        $user = $userModel->where('username', $username)->first();
        
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Username tidak ditemukan!'
            ]);
        }
        
        // Mapping pertanyaan
        $questions = [
            'pet_name' => 'Apa nama hewan peliharaan pertama Anda?',
            'birth_city' => 'Di kota mana Anda dilahirkan?',
            'school_name' => 'Apa nama sekolah dasar Anda?',
            'mother_maiden' => 'Apa nama gadis ibu Anda?',
            'favorite_food' => 'Apa makanan favorit Anda?',
            'favorite_color' => 'Apa warna favorit Anda?',
            'best_friend' => 'Apa nama sahabat terbaik Anda?'
        ];
        
        return $this->response->setJSON([
            'status' => 'success',
            'question' => $questions[$user['security_question']] ?? 'Pertanyaan tidak ditemukan'
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}