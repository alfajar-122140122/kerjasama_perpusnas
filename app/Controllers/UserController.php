<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $session;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
        helper(['form', 'url']);
    }
    
    /**
     * Check if user is authenticated and has admin access
     */
    private function checkAuth()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }
        
        if ($this->session->get('hak_akses') !== 'admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        return null;
    }
    
    /**
     * Display users management page
     */
    public function index()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $data = [
            'title' => 'Manajemen Users',
            'page_title' => 'Manajemen Users'
        ];
        
        return view('admin/users', $data);
    }
    
    /**
     * Get users data for DataTable (AJAX)
     */
    public function getData()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }
        
        try {
            $users = $this->userModel->findAll();
            
            // Remove passwords for security
            foreach ($users as &$user) {
                unset($user['password']);
                
                // Format created_at
                $user['created_at_formatted'] = date('d/m/Y H:i', strtotime($user['created_at']));
                
                // Add profile picture URL
                $user['profile_picture_url'] = $user['profile_picture'] ? 
                    base_url('uploads/users/' . $user['profile_picture']) : null;
            }
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $users
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Get user statistics
     */
    public function getStatistics()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }
        
        try {
            $users = $this->userModel->findAll();
            
            $stats = [
                'total_users' => count($users),
                'admin_users' => count(array_filter($users, fn($u) => $u['hak_akses'] === 'admin')),
                'regular_users' => count(array_filter($users, fn($u) => $u['hak_akses'] === 'user')),
                'active_users' => count(array_filter($users, fn($u) => $u['status'] === 'active')),
                'inactive_users' => count(array_filter($users, fn($u) => $u['status'] === 'inactive')),
                'users_bulan_ini' => count(array_filter($users, function($u) {
                    $created = new \DateTime($u['created_at']);
                    $now = new \DateTime();
                    return $created->format('Y-m') === $now->format('Y-m');
                }))
            ];
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $stats
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Create new user
     */
    public function create()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }
        
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[4]|max_length[50]|is_unique[users.username]|alpha_numeric',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'min_length' => 'Username minimal 4 karakter',
                    'max_length' => 'Username maksimal 50 karakter',
                    'is_unique' => 'Username sudah digunakan',
                    'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Format email tidak valid',
                    'is_unique' => 'Email sudah digunakan'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Password minimal 8 karakter'
                ]
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Konfirmasi password tidak cocok'
                ]
            ],
            'name' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi',
                    'min_length' => 'Nama minimal 3 karakter',
                    'max_length' => 'Nama maksimal 100 karakter'
                ]
            ],
            'hak_akses' => [
                'label' => 'Hak Akses',
                'rules' => 'required|in_list[admin,user]',
                'errors' => [
                    'required' => 'Hak akses harus dipilih',
                    'in_list' => 'Hak akses tidak valid'
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
        
        try {
            // Handle file upload if exists
            $profilePicture = null;
            $file = $this->request->getFile('profile_picture');
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $profilePicture = $this->handleFileUpload($file);
                if (!$profilePicture) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal mengupload foto profil'
                    ]);
                }
            }
            
            $userData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'name' => $this->request->getPost('name'),
                'hak_akses' => $this->request->getPost('hak_akses'),
                'status' => 'active',
                'profile_picture' => $profilePicture,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $userId = $this->userModel->insert($userData);
            
            if ($userId) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User berhasil ditambahkan',
                    'user_id' => $userId
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan user'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Show user detail
     */
    public function show($id)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }
        
        try {
            $user = $this->userModel->find($id);
            
            if (!$user) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ]);
            }
            
            // Remove password for security
            unset($user['password']);
            
            // Format dates
            $user['created_at_formatted'] = date('d F Y H:i', strtotime($user['created_at']));
            $user['updated_at_formatted'] = date('d F Y H:i', strtotime($user['updated_at']));
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $user
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Update user
     */
    public function update($id)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }
        
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }
        
        $rules = [
            'username' => "required|min_length[4]|alpha_numeric|is_unique[users.username,id_user,{$id}]",
            'email' => "required|valid_email|is_unique[users.email,id_user,{$id}]",
            'name' => 'required|min_length[3]|max_length[100]',
            'hak_akses' => 'required|in_list[admin,user]'
        ];
        
        // Add password validation if changing password
        if ($this->request->getPost('change_password')) {
            $rules['password'] = 'required|min_length[8]';
            $rules['confirm_password'] = 'required|matches[password]';
        }
        
        $validation = \Config\Services::validation();
        $validation->setRules($rules);
        
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validation->getErrors()
            ]);
        }
        
        try {
            $updateData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'name' => $this->request->getPost('name'),
                'hak_akses' => $this->request->getPost('hak_akses'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Update password if changing
            if ($this->request->getPost('change_password')) {
                $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }
            
            // Handle file upload if exists
            $file = $this->request->getFile('profile_picture');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newProfilePicture = $this->handleFileUpload($file);
                if ($newProfilePicture) {
                    // Delete old file if exists
                    if ($user['profile_picture']) {
                        $oldFile = WRITEPATH . '../uploads/users/' . $user['profile_picture'];
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }
                    $updateData['profile_picture'] = $newProfilePicture;
                }
            }
            
            $result = $this->userModel->update($id, $updateData);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User berhasil diperbarui'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui user'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Delete user
     */
    public function delete($id)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }
        
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }
        
        // Prevent deleting current user
        if ($id == $this->session->get('user_id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak dapat menghapus akun sendiri'
            ]);
        }
        
        // Prevent deleting the last admin
        $adminCount = $this->userModel->where('hak_akses', 'admin')->countAllResults();
        if ($user['hak_akses'] === 'admin' && $adminCount <= 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak dapat menghapus admin terakhir'
            ]);
        }
        
        try {
            // Delete profile picture if exists
            if ($user['profile_picture']) {
                $filePath = WRITEPATH . '../uploads/users/' . $user['profile_picture'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            $result = $this->userModel->delete($id);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus user'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Toggle user status
     */
    public function toggleStatus($id)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }
        
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }
        
        // Prevent deactivating current user
        if ($id == $this->session->get('user_id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak dapat menonaktifkan akun sendiri'
            ]);
        }
        
        $newStatus = $user['status'] === 'active' ? 'inactive' : 'active';
        
        try {
            $result = $this->userModel->update($id, [
                'status' => $newStatus,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            if ($result) {
                $statusText = $newStatus === 'active' ? 'diaktifkan' : 'dinonaktifkan';
                return $this->response->setJSON([
                    'success' => true,
                    'message' => "User berhasil {$statusText}",
                    'new_status' => $newStatus
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengubah status user'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Generate secure password
     */
    public function generatePassword()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }
        
        $length = $this->request->getPost('length') ?? 12;
        $length = max(8, min(32, (int)$length)); // Ensure length is between 8-32
        
        $password = $this->generateSecurePassword($length);
        
        return $this->response->setJSON([
            'success' => true,
            'password' => $password,
            'strength' => $this->checkPasswordStrength($password)
        ]);
    }
    
    /**
     * Check username availability
     */
    public function checkUsername()
    {
        $username = $this->request->getPost('username');
        $userId = $this->request->getPost('user_id'); // For edit mode
        
        if (!$username) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Username harus diisi'
            ]);
        }
        
        $query = $this->userModel->where('username', $username);
        if ($userId) {
            $query->where('id_user !=', $userId);
        }
        
        $exists = $query->countAllResults() > 0;
        
        return $this->response->setJSON([
            'success' => true,
            'available' => !$exists,
            'message' => $exists ? 'Username sudah digunakan' : 'Username tersedia'
        ]);
    }
    
    /**
     * Check email availability
     */
    public function checkEmail()
    {
        $email = $this->request->getPost('email');
        $userId = $this->request->getPost('user_id'); // For edit mode
        
        if (!$email) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email harus diisi'
            ]);
        }
        
        $query = $this->userModel->where('email', $email);
        if ($userId) {
            $query->where('id_user !=', $userId);
        }
        
        $exists = $query->countAllResults() > 0;
        
        return $this->response->setJSON([
            'success' => true,
            'available' => !$exists,
            'message' => $exists ? 'Email sudah digunakan' : 'Email tersedia'
        ]);
    }
    
    /**
     * Handle file upload
     */
    private function handleFileUpload($file)
    {
        // Validate file
        if (!$file->isValid()) {
            return false;
        }
        
        // Check file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return false;
        }
        
        // Check file size (max 2MB)
        if ($file->getSize() > 2 * 1024 * 1024) {
            return false;
        }
        
        // Create upload directory if not exists
        $uploadPath = WRITEPATH . '../uploads/users/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Generate unique filename
        $extension = $file->getClientExtension();
        $filename = 'user_' . time() . '_' . random_int(1000, 9999) . '.' . $extension;
        
        // Move file
        if ($file->move($uploadPath, $filename)) {
            return $filename;
        }
        
        return false;
    }
    
    /**
     * Generate secure password
     */
    private function generateSecurePassword($length = 12)
    {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';
        
        $all = $lowercase . $uppercase . $numbers . $symbols;
        
        $password = '';
        
        // Ensure at least one character from each set
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];
        
        // Fill the rest randomly
        for ($i = 4; $i < $length; $i++) {
            $password .= $all[random_int(0, strlen($all) - 1)];
        }
        
        // Shuffle the password
        return str_shuffle($password);
    }
    
    /**
     * Check password strength
     */
    private function checkPasswordStrength($password)
    {
        $score = 0;
        $checks = [];
        
        // Length check
        if (strlen($password) >= 8) {
            $score += 25;
            $checks[] = 'Minimal 8 karakter';
        }
        
        // Lowercase check
        if (preg_match('/[a-z]/', $password)) {
            $score += 25;
            $checks[] = 'Huruf kecil';
        }
        
        // Uppercase check
        if (preg_match('/[A-Z]/', $password)) {
            $score += 25;
            $checks[] = 'Huruf besar';
        }
        
        // Number check
        if (preg_match('/[0-9]/', $password)) {
            $score += 25;
            $checks[] = 'Angka';
        }
        
        // Symbol check (bonus)
        if (preg_match('/[^a-zA-Z0-9]/', $password)) {
            $score += 25;
            $checks[] = 'Simbol';
        }
        
        // Determine strength level
        if ($score < 50) {
            $level = 'Lemah';
            $color = 'danger';
        } elseif ($score < 75) {
            $level = 'Sedang';
            $color = 'warning';
        } elseif ($score < 100) {
            $level = 'Kuat';
            $color = 'info';
        } else {
            $level = 'Sangat Kuat';
            $color = 'success';
        }
        
        return [
            'score' => min(100, $score),
            'level' => $level,
            'color' => $color,
            'checks' => $checks
        ];
    }
}