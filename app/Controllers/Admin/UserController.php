<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    private function checkSuperAdmin()
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak. Hanya superadmin yang dapat mengelola user.');
        }
        return null;
    }

    private function checkAdmin()
    {
        if (!in_array(session()->get('role'), ['admin', 'superadmin'])) {
            return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses fitur ini.');
        }
        return null;
    }

    // Halaman Hak Akses - hanya superadmin
    public function hakAkses()
    {
        $authCheck = $this->checkSuperAdmin();
        if ($authCheck) return $authCheck;

        // Sample users data dengan permissions
        $users = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@perpusnas.go.id',
                'role' => 'superadmin',
                'permissions' => ['all'],
                'status' => 'active',
                'created_at' => '2024-01-01'
            ],
            [
                'id' => 2,
                'name' => 'Admin Kerjasama',
                'username' => 'admin_kerjasama',
                'email' => 'admin.kerjasama@perpusnas.go.id',
                'role' => 'admin',
                'permissions' => ['kerjasama'],
                'status' => 'active',
                'created_at' => '2024-02-01'
            ],
            [
                'id' => 3,
                'name' => 'Staff Berita',
                'username' => 'staff_berita',
                'email' => 'staff.berita@perpusnas.go.id',
                'role' => 'staff',
                'permissions' => ['berita'],
                'status' => 'active',
                'created_at' => '2024-03-01'
            ],
            [
                'id' => 4,
                'name' => 'Admin Full Access',
                'username' => 'admin_full',
                'email' => 'admin.full@perpusnas.go.id',
                'role' => 'admin',
                'permissions' => ['kerjasama', 'berita'],
                'status' => 'active',
                'created_at' => '2024-04-01'
            ]
        ];
        
        $data = [
            'title' => 'Hak Akses User',
            'users' => $users
        ];
        
        return view('admin/users/hak_akses', $data);
    }

    // Halaman Kelola User - hanya superadmin
    public function kelolaUser()
    {
        $authCheck = $this->checkSuperAdmin();
        if ($authCheck) return $authCheck;

        // Sample users data
        $users = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@perpusnas.go.id',
                'role' => 'superadmin',
                'phone' => '+6281234567890',
                'status' => 'active',
                'last_login' => '2024-07-16 10:30:00',
                'created_at' => '2024-01-01'
            ],
            [
                'id' => 2,
                'name' => 'Admin Kerjasama',
                'username' => 'admin_kerjasama',
                'email' => 'admin.kerjasama@perpusnas.go.id',
                'role' => 'admin',
                'phone' => '+6281234567891',
                'status' => 'active',
                'last_login' => '2024-07-16 09:15:00',
                'created_at' => '2024-02-01'
            ],
            [
                'id' => 3,
                'name' => 'Staff Berita',
                'username' => 'staff_berita',
                'email' => 'staff.berita@perpusnas.go.id',
                'role' => 'staff',
                'phone' => '+6281234567892',
                'status' => 'active',
                'last_login' => '2024-07-15 16:45:00',
                'created_at' => '2024-03-01'
            ]
        ];
        
        $data = [
            'title' => 'Kelola User',
            'users' => $users
        ];
        
        return view('admin/users/kelola_user', $data);
    }

    // Update permissions - hanya superadmin
    public function updatePermissions()
    {
        $authCheck = $this->checkSuperAdmin();
        if ($authCheck) return $authCheck;

        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Method tidak diizinkan'
            ]);
        }

        $userId = $this->request->getPost('user_id');
        $role = $this->request->getPost('role');
        $permissions = $this->request->getPost('permissions') ?? [];

        // Validasi
        if (empty($userId) || empty($role)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap'
            ]);
        }

        // Validasi role
        if (!in_array($role, ['admin', 'staff'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Role tidak valid'
            ]);
        }

        // Validasi permissions
        $validPermissions = ['kerjasama', 'berita'];
        foreach ($permissions as $permission) {
            if (!in_array($permission, $validPermissions)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Permission tidak valid: ' . $permission
                ]);
            }
        }

        // Simulate database update
        // In real implementation, update user permissions in database
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Hak akses berhasil diperbarui'
        ]);
    }

    public function add()
    {
        if ($redirect = $this->checkSuperAdmin()) return $redirect;
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email' => 'required|valid_email|max_length[100]|is_unique[users.email]',
                'name' => 'required|min_length[3]|max_length[100]',
                'password' => 'required|min_length[8]|regex_match[/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])/]',
                'role' => 'required|in_list[admin,staff]',
                'phone' => 'permit_empty|max_length[20]'
            ];

            $messages = [
                'password' => [
                    'regex_match' => 'Password harus mengandung huruf kecil, huruf besar, angka, dan karakter khusus'
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data tidak valid: ' . implode(', ', $this->validator->getErrors()));
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'name' => $this->request->getPost('name'),
                'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => $this->request->getPost('role'),
                'phone' => $this->request->getPost('phone'),
                'status' => 'active'
            ];

            // Simulate success
            return redirect()->to('/admin/users/kelola-user')
                ->with('success', 'User berhasil ditambahkan');
        }

        return redirect()->to('/admin/users/kelola-user');
    }

    public function edit($id)
    {
        if ($redirect = $this->checkSuperAdmin()) return $redirect;
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => "required|min_length[3]|max_length[50]",
                'email' => "required|valid_email|max_length[100]",
                'name' => 'required|min_length[3]|max_length[100]',
                'role' => 'required|in_list[admin,staff]',
                'phone' => 'permit_empty|max_length[20]'
            ];

            // Only validate password if provided
            $password = $this->request->getPost('password');
            if (!empty($password)) {
                $rules['password'] = 'min_length[8]|regex_match[/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])/]';
            }

            $messages = [
                'password' => [
                    'regex_match' => 'Password harus mengandung huruf kecil, huruf besar, angka, dan karakter khusus'
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data tidak valid: ' . implode(', ', $this->validator->getErrors()));
            }

            // Simulate success
            return redirect()->to('/admin/users/kelola-user')
                ->with('success', 'User berhasil diupdate');
        }

        return redirect()->to('/admin/users/kelola-user');
    }

    public function delete($id)
    {
        if ($redirect = $this->checkSuperAdmin()) return $redirect;
        
        // Cegah superadmin menghapus dirinya sendiri
        if (session()->get('user_id') == $id) {
            return redirect()->to('/admin/users/kelola-user')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Simulate success
        return redirect()->to('/admin/users/kelola-user')
            ->with('success', 'User berhasil dihapus');
    }

    public function changePassword($id)
    {
        if ($redirect = $this->checkAdmin()) return $redirect;
        if ($this->request->getMethod() === 'POST') {
            $user = $this->userModel->find($id);
            if (!$user) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ]);
            }

            $rules = [
                'new_password' => 'required|min_length[8]|regex_match[/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])/]',
                'confirm_password' => 'required|matches[new_password]'
            ];

            $messages = [
                'new_password' => [
                    'regex_match' => 'Password harus mengandung huruf kecil, huruf besar, angka, dan karakter khusus'
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Password tidak valid',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $data = [
                'password' => $this->request->getPost('new_password')
            ];

            if ($this->userModel->update($id, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Password berhasil diubah'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengubah password'
                ]);
            }
        }

        return redirect()->to('/admin/users');
    }

    public function resetPassword($id)
    {
        if ($redirect = $this->checkAdmin()) return $redirect;
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // Generate random password
        $newPassword = $this->generateRandomPassword();

        $data = [
            'password' => $newPassword
        ];

        if ($this->userModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Password berhasil direset',
                'new_password' => $newPassword
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mereset password'
            ]);
        }
    }

    private function generateRandomPassword($length = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }
        
        return $randomPassword;
    }

    public function getUserData($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // Remove password from response
        unset($user['password']);

        return $this->response->setJSON([
            'success' => true,
            'data' => $user
        ]);
    }

    // Settings Methods
    public function settings()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            return redirect()->to('/admin/login')
                ->with('error', 'User tidak ditemukan');
        }

        $data = [
            'title' => 'Pengaturan',
            'user' => $user
        ];

        return view('admin/settings', $data);
    }

    public function updateProfile()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Method tidak diizinkan'
            ]);
        }

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        $rules = [
            'name' => 'permit_empty|max_length[100]',
            'email' => "required|valid_email|max_length[100]|is_unique[users.email,id,{$userId}]",
            'phone' => 'permit_empty|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone')
        ];

        if ($this->userModel->updateUserProfile($userId, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Profil berhasil diperbarui'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memperbarui profil'
            ]);
        }
    }

    public function updatePassword()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Method tidak diizinkan'
            ]);
        }

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]|regex_match[/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])/]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        $messages = [
            'new_password' => [
                'regex_match' => 'Password harus mengandung huruf kecil, huruf besar, angka, dan karakter khusus'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Verify current password
        if (!$this->userModel->verifyPassword($this->request->getPost('current_password'), $user['password'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Password saat ini tidak benar'
            ]);
        }

        $data = [
            'password' => $this->request->getPost('new_password')
        ];

        if ($this->userModel->updateUserProfile($userId, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Password berhasil diperbarui'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memperbarui password'
            ]);
        }
    }
}