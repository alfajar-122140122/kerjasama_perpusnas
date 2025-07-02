<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = session();
    }
    
    // Middleware check untuk semua method admin
    private function checkAuth()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu');
        }
        return null;
    }

    public function dashboard()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $data = [
            'title' => 'Dashboard',
            'total_users' => 150,
            'total_kerjasama' => 25,
            'total_berita' => 48,
            'active_users' => 142
        ];

        return view('admin/dashboard', $data);
    }

    public function users()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Sample users data
        $users = [
            [
                'id' => 1,
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@perpusnas.go.id',
                'role' => 'Admin',
                'status' => 'active',
                'phone' => '081234567890',
                'created_at' => '2024-01-15',
                'last_login' => '2024-07-02 08:30:00'
            ],
            [
                'id' => 2,
                'name' => 'Siti Nurhaliza',
                'username' => 'siti.nur',
                'email' => 'siti.nurhaliza@perpusnas.go.id',
                'role' => 'User',
                'status' => 'active',
                'phone' => '081234567891',
                'created_at' => '2024-02-10',
                'last_login' => '2024-07-01 16:45:00'
            ],
            [
                'id' => 3,
                'name' => 'Bambang Wijaya',
                'username' => 'bambang.w',
                'email' => 'bambang.wijaya@perpusnas.go.id',
                'role' => 'User',
                'status' => 'active',
                'phone' => '081234567892',
                'created_at' => '2024-03-05',
                'last_login' => '2024-06-30 14:20:00'
            ],
            [
                'id' => 4,
                'name' => 'Rina Sari',
                'username' => 'rina.sari',
                'email' => 'rina.sari@perpusnas.go.id',
                'role' => 'User',
                'status' => 'inactive',
                'phone' => '081234567893',
                'created_at' => '2024-01-20',
                'last_login' => '2024-06-25 10:15:00'
            ]
        ];

        $data = [
            'users' => $users,
            'total_users' => count($users),
            'active_users' => count(array_filter($users, fn($u) => $u['status'] === 'active')),
            'inactive_users' => count(array_filter($users, fn($u) => $u['status'] === 'inactive')),
            'admin_users' => count(array_filter($users, fn($u) => $u['role'] === 'Admin'))
        ];

        return view('admin/users', $data);
    }

    public function addUser()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Admin') {
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
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|alpha_numeric',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 3 karakter',
                    'alpha_numeric' => '{field} hanya boleh berisi huruf dan angka'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_email' => '{field} harus valid'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 6 karakter'
                ]
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required|in_list[Admin,User]',
                'errors' => [
                    'required' => '{field} harus dipilih',
                    'in_list' => '{field} harus Admin atau User'
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

        // Simulate save to database
        return $this->response->setJSON([
            'success' => true,
            'message' => 'User berhasil ditambahkan'
        ]);
    }

    public function editUser($id = null)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Admin') {
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

        return $this->response->setJSON([
            'success' => true,
            'message' => 'User berhasil diperbarui'
        ]);
    }

    public function deleteUser($id = null)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Admin') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }

    /**
     * Settings Management Methods
     */
    public function pengaturan()
    {
        // Check if user is logged in and is admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'user' => [
                'name' => session()->get('name'),
                'username' => session()->get('username'),
                'email' => 'admin@perpusnas.go.id',
                'phone' => '021-3863000',
                'role' => session()->get('role'),
                'last_login' => date('Y-m-d H:i:s')
            ],
            'site_settings' => [
                'site_name' => 'Kerjasama Perpustakaan Nasional',
                'site_description' => 'Portal resmi kerjasama Perpustakaan Nasional RI',
                'admin_email' => 'admin@perpusnas.go.id',
                'maintenance_mode' => false
            ]
        ];

        return view('admin/pengaturan', $data);
    }

    public function updateProfile()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Admin') {
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
            ],
            'phone' => [
                'label' => 'No. Telepon',
                'rules' => 'permit_empty|numeric|min_length[10]',
                'errors' => [
                    'numeric' => '{field} harus berupa angka',
                    'min_length' => '{field} minimal 10 digit'
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

        // Update session with new name
        session()->set('name', $this->request->getPost('name'));

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Profile berhasil diperbarui'
        ]);
    }

    public function changePassword()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Admin') {
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
                    'matches' => '{field} harus sama dengan password baru'
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

        // In real implementation, verify current password against database
        $currentPassword = $this->request->getPost('current_password');
        if ($currentPassword !== 'admin123') { // Replace with actual verification
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Password saat ini tidak sesuai'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }

    /**
     * Report Methods
     */
    public function laporan()
    {
        // Check if user is logged in and is admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'stats' => [
                'total_users' => 15,
                'total_kerjasama' => 8,
                'total_berita' => 12,
                'kerjasama_aktif' => 5,
                'kerjasama_selesai' => 3,
                'berita_published' => 10,
                'berita_draft' => 2
            ],
            'recent_activities' => [
                [
                    'action' => 'Tambah User',
                    'description' => 'User "Siti Nurhaliza" ditambahkan',
                    'timestamp' => '2024-07-01 14:30:00',
                    'type' => 'user'
                ],
                [
                    'action' => 'Update Kerjasama',
                    'description' => 'Kerjasama dengan UI diperbarui',
                    'timestamp' => '2024-07-01 10:15:00',
                    'type' => 'kerjasama'
                ],
                [
                    'action' => 'Publish Berita',
                    'description' => 'Berita "Program Literasi Digital" dipublish',
                    'timestamp' => '2024-06-30 16:45:00',
                    'type' => 'berita'
                ]
            ]
        ];

        return view('admin/laporan', $data);
    }

    public function exportData()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Admin') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        $type = $this->request->getPost('type');
        $format = $this->request->getPost('format');

        // Simulate export functionality
        return $this->response->setJSON([
            'success' => true,
            'message' => "Data {$type} berhasil diekspor dalam format {$format}",
            'download_url' => base_url("exports/{$type}_" . date('Y-m-d') . ".{$format}")
        ]);
    }
}