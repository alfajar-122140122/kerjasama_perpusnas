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

    private function checkAdmin()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak. Hanya admin yang dapat mengelola user.');
        }
    }

    public function index()
    {
        // Get pagination parameters
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10; // 10 items per page
        
        // Get total count for pagination
        $totalUsers = $this->userModel->countAllResults();
        
        // Calculate total pages
        $totalPages = ceil($totalUsers / $perPage);
        
        // Ensure valid page number
        $page = max(1, min($page, $totalPages));
        
        // Calculate offset
        $offset = ($page - 1) * $perPage;
        
        // Get users data with pagination
        $users = $this->userModel->orderBy('id', 'DESC')
                                 ->limit($perPage, $offset)
                                 ->findAll();
        
        // Calculate pagination info
        $paginationInfo = [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
            'totalItems' => $totalUsers,
            'startItem' => $totalUsers > 0 ? $offset + 1 : 0,
            'endItem' => min($offset + $perPage, $totalUsers)
        ];
        
        $data = [
            'title' => 'Manajemen User',
            'users' => $users,
            'pagination' => $paginationInfo
        ];
        return view('admin/users', $data);
    }

    public function add()
    {
        if ($redirect = $this->checkAdmin()) return $redirect;
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email' => 'required|valid_email|max_length[100]|is_unique[users.email]',
                'password' => 'required|min_length[8]|regex_match[/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])/]',
                'hak_akses' => 'required|in_list[admin,staff]'
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
                'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => $this->request->getPost('hak_akses')
            ];

            if ($this->userModel->insert($data)) {
                return redirect()->to('/admin/users')
                    ->with('success', 'User berhasil ditambahkan');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menambahkan user');
            }
        }

        return redirect()->to('/admin/users');
    }

    public function edit($id)
    {
        if ($redirect = $this->checkAdmin()) return $redirect;
        if ($this->request->getMethod() === 'POST') {
            $user = $this->userModel->find($id);
            if (!$user) {
                return redirect()->to('/admin/users')
                    ->with('error', 'User tidak ditemukan');
            }

            $rules = [
                'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
                'email' => "required|valid_email|max_length[100]|is_unique[users.email,id,{$id}]",
                'hak_akses' => 'required|in_list[admin,staff]'
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

            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'role' => $this->request->getPost('hak_akses')
            ];

            // Only update password if provided
            if (!empty($password)) {
                $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
            }

            if ($this->userModel->update($id, $data)) {
                return redirect()->to('/admin/users')
                    ->with('success', 'User berhasil diupdate');
            } else {
                $errorMsg = 'Gagal mengupdate user';
                $modelErrors = $this->userModel->errors();
                if (!empty($modelErrors)) {
                    $errorMsg .= ': ' . implode(', ', $modelErrors);
                }
                return redirect()->back()
                    ->withInput()
                    ->with('error', $errorMsg);
            }
        }

        return redirect()->to('/admin/users');
    }

    public function delete($id)
    {
        if ($redirect = $this->checkAdmin()) return $redirect;
        // Cegah user menghapus dirinya sendiri
        if (session()->get('user_id') == $id) {
            return redirect()->to('/admin/users')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')
                ->with('error', 'User tidak ditemukan');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/users')
                ->with('success', 'User berhasil dihapus');
        } else {
            return redirect()->to('/admin/users')
                ->with('error', 'Gagal menghapus user');
        }
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