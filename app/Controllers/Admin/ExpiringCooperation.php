<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CooperationModel;

class ExpiringCooperation extends BaseController
{
    protected $session;
    protected $cooperationModel;
    
    public function __construct()
    {
        $this->session = session();
        $this->cooperationModel = new CooperationModel();
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
            'title' => 'Kerjasama Yang Akan Berakhir',
            'expiring' => $this->cooperationModel->getExpiringCooperation()
        ];
        
        return view('admin/expiring_cooperation_edit', $data);
    }
    
    public function edit($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/expiring-cooperation')->with('error', 'ID Kerjasama tidak ditemukan');
        }
        
        $kerjasama = $this->cooperationModel->find($id);
        if (!$kerjasama) {
            return redirect()->to('/admin/expiring-cooperation')->with('error', 'Data Kerjasama tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Kerjasama Yang Akan Berakhir',
            'kerjasama' => $kerjasama
        ];
        
        return view('admin/expiring_cooperation_edit', $data);
    }
    
    public function update($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/expiring-cooperation')->with('error', 'ID Kerjasama tidak ditemukan');
        }
        
        // Validate input
        $rules = [
            'status' => 'required|in_list[aktif,tidak aktif,akan berakhir]',
            'tanggal_berakhir' => 'required|valid_date'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Update kerjasama data for expiring
        $data = [
            'status' => $this->request->getPost('status'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir'),
            'updated_by' => $this->session->get('user_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Handle perpanjangan
        if ($this->request->getPost('perpanjangan') === 'ya') {
            $data['tanggal_berakhir'] = date('Y-m-d', strtotime($this->request->getPost('tanggal_perpanjangan')));
            $data['status'] = 'aktif';
            $data['catatan_perpanjangan'] = $this->request->getPost('catatan_perpanjangan');
        }
        
        // Update kerjasama data
        $this->cooperationModel->update($id, $data);
        
        return redirect()->to('/admin/expiring-cooperation')->with('success', 'Status Kerjasama berhasil diperbarui');
    }
}
