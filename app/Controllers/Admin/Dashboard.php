<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\KerjasamaModel;
use App\Models\BeritaModel;

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
    
    public function dashboard()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $userModel = new UserModel();
        $kerjasamaModel = new KerjasamaModel();
        $beritaModel = new BeritaModel();

        // Total Users
        $totalUsers = $userModel->countAllResults();
        $usersLastMonth = $userModel
            ->where('created_at >=', date('Y-m-01 00:00:00', strtotime('-1 month')))
            ->where('created_at <', date('Y-m-01 00:00:00'))
            ->countAllResults();

        // Total Kerjasama
        $totalKerjasama = $kerjasamaModel->countAllResults();
        $kerjasamaLastMonth = $kerjasamaModel
            ->where('created_at >=', date('Y-m-01 00:00:00', strtotime('-1 month')))
            ->where('created_at <', date('Y-m-01 00:00:00'))
            ->countAllResults();

        // Total Berita
        $totalBerita = $beritaModel->countAllResults();
        $beritaLastMonth = $beritaModel
            ->where('created_at >=', date('Y-m-01 00:00:00', strtotime('-1 month')))
            ->where('created_at <', date('Y-m-01 00:00:00'))
            ->countAllResults();

        // Status Kerjasama (dummy, since no status field in model)
        $statusAktif = $kerjasamaModel
            ->where('tanggal_berakhir >=', date('Y-m-d'))
            ->countAllResults();
        $statusSelesai = $kerjasamaModel
            ->where('tanggal_berakhir <', date('Y-m-d'))
            ->countAllResults();
        $statusPending = 0; // Adjust if you have a pending status

        // Statistik Kerjasama Bulanan (12 bulan terakhir)
        $statistikBulanan = [];
        for ($i = 11; $i >= 0; $i--) {
            $start = date('Y-m-01 00:00:00', strtotime("-$i months"));
            $end = date('Y-m-t 23:59:59', strtotime("-$i months"));
            $count = $kerjasamaModel
                ->where('created_at >=', $start)
                ->where('created_at <=', $end)
                ->countAllResults();
            $statistikBulanan[] = [
                'bulan' => date('Y-m', strtotime($start)),
                'total' => $count
            ];
        }

        // Persentase perubahan
        $userChange = $usersLastMonth ? round((($totalUsers - $usersLastMonth) / max($usersLastMonth,1)) * 100) : 0;
        $kerjasamaChange = $kerjasamaLastMonth ? round((($totalKerjasama - $kerjasamaLastMonth) / max($kerjasamaLastMonth,1)) * 100) : 0;
        $beritaChange = $beritaLastMonth ? round((($totalBerita - $beritaLastMonth) / max($beritaLastMonth,1)) * 100) : 0;

        return view('admin/dashboard', [
            'totalUsers' => $totalUsers,
            'userChange' => $userChange,
            'totalKerjasama' => $totalKerjasama,
            'kerjasamaChange' => $kerjasamaChange,
            'totalBerita' => $totalBerita,
            'beritaChange' => $beritaChange,
            'statusAktif' => $statusAktif,
            'statusSelesai' => $statusSelesai,
            'statusPending' => $statusPending,
            'statistikBulanan' => $statistikBulanan
        ]);
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

    public function changePassword($userId = null)
    {
        // Check if user is logged in and is admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Admin') {
            return redirect()->to('/auth/login')->with('error', 'Akses ditolak');
        }

        if ($this->request->getMethod() === 'POST') {
            return $this->updatePassword($userId);
        }

        // If it's a GET request, redirect back to users page
        return redirect()->to('/admin/users');
    }

    private function updatePassword($userId)
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
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

        $newPassword = $this->request->getPost('new_password');
        
        // Hash password (in real app, update database)
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Simulate database update
        // In real application:
        // $userModel = new UserModel();
        // $result = $userModel->update($userId, ['password' => $hashedPassword]);
        
        $result = true; // Simulate success
        
        if ($result) {
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

    public function resetPassword($userId = null)
    {
        // Check if user is logged in and is admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Admin') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        // Generate random password
        $newPassword = $this->generateRandomPassword();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Simulate database update
        // In real application:
        // $userModel = new UserModel();
        // $result = $userModel->update($userId, ['password' => $hashedPassword]);
        
        $result = true; // Simulate success
        
        if ($result) {
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

    private function generateRandomPassword($length = 8)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%';
        $password = '';
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $password;
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