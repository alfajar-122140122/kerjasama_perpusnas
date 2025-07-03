<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
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

    public function index()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $data = [
            'title' => 'Dashboard Admin',
            'total_users' => 150,
            'total_kerjasama' => 25,
            'total_berita' => 48,
            'active_users' => 142
        ];

        return view('admin/dashboard', $data);
    }
}
