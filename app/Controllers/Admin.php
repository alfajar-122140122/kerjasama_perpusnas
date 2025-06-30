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
                'name' => 'Fulan',
                'username' => 'fulan',
                'role' => 'Admin',
                'status' => 'active'
            ],
            [
                'id' => 2,
                'name' => 'Fulana',
                'username' => 'fulana',
                'role' => 'User',
                'status' => 'active'
            ],
            [
                'id' => 3,
                'name' => 'Fulani',
                'username' => 'fulani',
                'role' => 'Admin',
                'status' => 'active'
            ],
            [
                'id' => 4,
                'name' => 'Fulano',
                'username' => 'fulano',
                'role' => 'User',
                'status' => 'active'
            ]
        ];
        
        $data = [
            'title' => 'Manajemen User',
            'users' => $users
        ];
        
        return view('admin/users', $data);
    }
    
    public function addUser()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // TODO: Implement add user functionality
        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }
    
    public function editUser($id)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // TODO: Implement edit user functionality
        return redirect()->back()->with('success', 'User berhasil diupdate!');
    }
    
    public function deleteUser($id)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // TODO: Implement delete user functionality
        return $this->response->setJSON([
            'success' => true,
            'message' => 'User berhasil dihapus!'
        ]);
    }
}