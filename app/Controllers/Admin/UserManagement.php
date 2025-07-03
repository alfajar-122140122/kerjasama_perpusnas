<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserManagement extends BaseController
{
    protected $session;
    protected $userModel;
    
    public function __construct()
    {
        $this->session = session();
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }
    
    // Middleware check untuk semua method admin
    private function checkAuth()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        if ($this->session->get('hak_akses') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki hak akses ke halaman ini.');
        }
        
        return null;
    }
    
    public function index()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $data = [
            'title' => 'Manajemen Users',
            'users' => $this->userModel->findAll()
        ];
        
        return view('admin/users', $data);
    }
    
    public function add()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $data = [
            'title' => 'Tambah Pengguna Baru'
        ];
        
        return view('admin/add_user', $data);
    }
    
    public function save()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Validate input
        $rules = [
            'username' => 'required|min_length[4]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|passwordStrength[1,1,1]',
            'password_confirm' => 'required|matches[password]',
            'hak_akses' => 'required|in_list[admin,user]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Save user to database
        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'hak_akses' => $this->request->getPost('hak_akses'),
            'active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('/admin/user-management')->with('success', 'Pengguna berhasil ditambahkan');
    }
    
    public function edit($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/user-management')->with('error', 'ID pengguna tidak ditemukan');
        }
        
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/user-management')->with('error', 'Pengguna tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Pengguna',
            'user' => $user
        ];
        
        return view('admin/edit_user', $data);
    }
    
    public function update($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/user-management')->with('error', 'ID pengguna tidak ditemukan');
        }
        
        // Validate input
        $rules = [
            'username' => "required|min_length[4]|is_unique[users.username,id,$id]",
            'email' => "required|valid_email|is_unique[users.email,id,$id]",
            'hak_akses' => 'required|in_list[admin,user]'
        ];
        
        // Only validate password if it's being changed
        if ($this->request->getPost('password') != '') {
            $rules['password'] = 'required|min_length[8]|passwordStrength[1,1,1]';
            $rules['password_confirm'] = 'required|matches[password]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Update user data
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'hak_akses' => $this->request->getPost('hak_akses'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Add password to data only if it was provided
        if ($this->request->getPost('password') != '') {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }
        
        $this->userModel->update($id, $data);
        
        return redirect()->to('/admin/user-management')->with('success', 'Pengguna berhasil diperbarui');
    }
    
    public function delete($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/user-management')->with('error', 'ID pengguna tidak ditemukan');
        }
        
        // Prevent deletion of own account
        if ($id == $this->session->get('user_id')) {
            return redirect()->to('/admin/user-management')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        }
        
        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/user-management')->with('success', 'Pengguna berhasil dihapus');
        } else {
            return redirect()->to('/admin/user-management')->with('error', 'Gagal menghapus pengguna');
        }
    }
    
    public function getUsers()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        try {
            $users = $this->userModel->findAll();
            
            // Format users data
            $formattedUsers = [];
            foreach ($users as $index => $user) {
                $formattedUsers[] = [
                    'no' => $index + 1,                'id' => $user['id_user'],
                'username' => $user['username'],
                'hak_akses' => $user['hak_akses'],
                    'created_at' => $user['created_at'],
                    'updated_at' => $user['updated_at'],
                    'last_login' => $user['last_login'] ?? '-',
                ];
            }
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $formattedUsers
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat data users: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getUserStatistics()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        try {
            $totalUsers = $this->userModel->countAll();
            $adminUsers = $this->userModel->where('hak_akses', 'admin')->countAllResults();
            $regularUsers = $this->userModel->where('hak_akses', 'user')->countAllResults();
            $newUsersThisMonth = $this->userModel->where('created_at >=', date('Y-m-01 00:00:00'))->countAllResults();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'total_users' => $totalUsers,
                    'admin_users' => $adminUsers,
                    'regular_users' => $regularUsers,
                    'users_bulan_ini' => $newUsersThisMonth
                ]
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat statistik users: ' . $e->getMessage()
            ]);
        }
    }
}
