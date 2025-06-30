<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Settings extends Controller
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    public function index()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Get current user data (sample data)
        $currentUser = [
            'id' => session()->get('user_id') ?? 1,
            'name' => session()->get('name') ?? 'Admin User',
            'username' => session()->get('username') ?? 'admin',
            'email' => session()->get('email') ?? 'admin@example.com',
            'role' => session()->get('role') ?? 'Admin',
            'phone' => session()->get('phone') ?? '',
            'created_at' => '2024-01-15',
            'last_login' => date('Y-m-d H:i:s')
        ];

        $data = [
            'user' => $currentUser
        ];

        return view('admin/settings', $data);
    }

    public function updateProfile()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 3 karakter'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_email' => '{field} harus valid'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validation->getErrors()
            ]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone')
        ];

        // Update session data
        session()->set([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone']
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Profil berhasil diperbarui'
        ]);
    }

    public function changePassword()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'current_password' => [
                'label' => 'Password Saat Ini',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'new_password' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 6 karakter'
                ]
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'matches' => '{field} tidak sama dengan password baru'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validation->getErrors()
            ]);
        }

        // Simulate success
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }
}