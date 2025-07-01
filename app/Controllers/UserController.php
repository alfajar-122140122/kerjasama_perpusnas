<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['password_helper', 'form']);
    }

    /**
     * Tampilkan daftar user (hanya untuk admin)
     */
    public function index()
    {
        // Cek apakah user adalah admin
        if (session()->get('hak_akses') !== 'admin') {
            return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak. Hanya admin yang dapat mengelola user.');
        }

        $users = $this->userModel->findAll();
        
        // Hapus password dari hasil untuk keamanan
        foreach ($users as &$user) {
            unset($user['password']);
        }

        return view('admin/users/index', [
            'users' => $users
        ]);
    }

    /**
     * Tampilkan form tambah user
     */
    public function create()
    {
        // Cek apakah user adalah admin
        if (session()->get('hak_akses') !== 'admin') {
            return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak. Hanya admin yang dapat mengelola user.');
        }

        return view('admin/users/create');
    }

    /**
     * Proses tambah user baru
     */
    public function store()
    {
        // Cek apakah user adalah admin
        if (session()->get('hak_akses') !== 'admin') {
            return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak. Hanya admin yang dapat mengelola user.');
        }

        // Validasi input
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
            'hak_akses' => 'required|in_list[admin,user]'
        ];

        $messages = [
            'username' => [
                'required' => 'Username harus diisi',
                'min_length' => 'Username minimal 3 karakter',
                'max_length' => 'Username maksimal 50 karakter',
                'is_unique' => 'Username sudah digunakan'
            ],
            'password' => [
                'required' => 'Password harus diisi',
                'min_length' => 'Password minimal 8 karakter'
            ],
            'password_confirm' => [
                'required' => 'Konfirmasi password harus diisi',
                'matches' => 'Konfirmasi password tidak cocok'
            ],
            'hak_akses' => [
                'required' => 'Hak akses harus dipilih',
                'in_list' => 'Hak akses tidak valid'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return view('admin/users/create', [
                'validation' => $this->validator,
                'old_input' => $this->request->getPost()
            ]);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $hakAkses = $this->request->getPost('hak_akses');

        // Validasi kekuatan password
        $passwordValidation = validatePasswordStrength($password);
        if (!$passwordValidation['valid']) {
            return view('admin/users/create', [
                'validation' => $this->validator,
                'password_errors' => $passwordValidation['messages'],
                'old_input' => $this->request->getPost()
            ]);
        }

        // Simpan user baru
        try {
            $userId = $this->userModel->insert([
                'username' => $username,
                'password' => $password,
                'hak_akses' => $hakAkses
            ]);

            if ($userId) {
                // Log aktivitas
                log_message('info', "Admin " . session()->get('username') . " menambahkan user baru: {$username}");
                
                return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan');
            } else {
                return view('admin/users/create', [
                    'error' => 'Gagal menambahkan user',
                    'old_input' => $this->request->getPost()
                ]);
            }
        } catch (\Exception $e) {
            return view('admin/users/create', [
                'error' => 'Error: ' . $e->getMessage(),
                'old_input' => $this->request->getPost()
            ]);
        }
    }

    /**
     * Tampilkan form edit user
     */
    public function edit($id)
    {
        // Cek apakah user adalah admin
        if (session()->get('hak_akses') !== 'admin') {
            return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak. Hanya admin yang dapat mengelola user.');
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        // Hapus password untuk keamanan
        unset($user['password']);

        return view('admin/users/edit', [
            'user' => $user
        ]);
    }

    /**
     * Proses update user
     */
    public function update($id)
    {
        // Cek apakah user adalah admin
        if (session()->get('hak_akses') !== 'admin') {
            return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak. Hanya admin yang dapat mengelola user.');
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        // Validasi input
        $rules = [
            'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,id_user,{$id}]",
            'hak_akses' => 'required|in_list[admin,user]'
        ];

        $messages = [
            'username' => [
                'required' => 'Username harus diisi',
                'min_length' => 'Username minimal 3 karakter',
                'max_length' => 'Username maksimal 50 karakter',
                'is_unique' => 'Username sudah digunakan'
            ],
            'hak_akses' => [
                'required' => 'Hak akses harus dipilih',
                'in_list' => 'Hak akses tidak valid'
            ]
        ];

        // Jika password diisi, validasi juga
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[8]';
            $rules['password_confirm'] = 'matches[password]';
            
            $messages['password'] = [
                'min_length' => 'Password minimal 8 karakter'
            ];
            $messages['password_confirm'] = [
                'matches' => 'Konfirmasi password tidak cocok'
            ];
        }

        if (!$this->validate($rules, $messages)) {
            return view('admin/users/edit', [
                'user' => $user,
                'validation' => $this->validator,
                'old_input' => $this->request->getPost()
            ]);
        }

        $updateData = [
            'username' => $this->request->getPost('username'),
            'hak_akses' => $this->request->getPost('hak_akses')
        ];

        // Jika password diisi, validasi dan update
        if (!empty($password)) {
            $passwordValidation = validatePasswordStrength($password);
            if (!$passwordValidation['valid']) {
                return view('admin/users/edit', [
                    'user' => $user,
                    'password_errors' => $passwordValidation['messages'],
                    'old_input' => $this->request->getPost()
                ]);
            }
            $updateData['password'] = $password;
        }

        // Update user
        try {
            $result = $this->userModel->update($id, $updateData);

            if ($result) {
                // Log aktivitas
                log_message('info', "Admin " . session()->get('username') . " mengupdate user: " . $updateData['username']);
                
                return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate');
            } else {
                return view('admin/users/edit', [
                    'user' => $user,
                    'error' => 'Gagal mengupdate user',
                    'old_input' => $this->request->getPost()
                ]);
            }
        } catch (\Exception $e) {
            return view('admin/users/edit', [
                'user' => $user,
                'error' => 'Error: ' . $e->getMessage(),
                'old_input' => $this->request->getPost()
            ]);
        }
    }

    /**
     * Hapus user
     */
    public function delete($id)
    {
        // Cek apakah user adalah admin
        if (session()->get('hak_akses') !== 'admin') {
            return redirect()->to('/admin/users')->with('error', 'Akses ditolak. Hanya admin yang dapat mengelola user.');
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        // Tidak bisa menghapus diri sendiri
        if ($user['id_user'] == session()->get('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        try {
            $result = $this->userModel->delete($id);

            if ($result) {
                // Log aktivitas
                log_message('info', "Admin " . session()->get('username') . " menghapus user: " . $user['username']);
                
                return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus');
            } else {
                return redirect()->to('/admin/users')->with('error', 'Gagal menghapus user');
            }
        } catch (\Exception $e) {
            return redirect()->to('/admin/users')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Generate password otomatis
     */
    public function generatePassword()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $password = generateSecurePassword(12);
        $validation = validatePasswordStrength($password);

        return $this->response->setJSON([
            'password' => $password,
            'validation' => $validation
        ]);
    }
}
