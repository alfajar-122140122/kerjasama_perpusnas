<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ImplementasiKerjasamaModel;

class Implementation extends BaseController
{
    protected $session;
    protected $implementasiModel;
    
    public function __construct()
    {
        $this->session = session();
        $this->implementasiModel = new ImplementasiKerjasamaModel();
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
            'title' => 'Implementasi Kerjasama',
            'implementasi' => $this->implementasiModel->findAll()
        ];
        
        return view('admin/implementation_edit', $data);
    }
    
    public function add()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Get all active kerjasama for dropdown
        $kerjasamaModel = new \App\Models\KerjasamaModel();
        $kerjasama = $kerjasamaModel->where('status', 'aktif')->findAll();
        
        $data = [
            'title' => 'Tambah Implementasi Kerjasama',
            'kerjasama' => $kerjasama
        ];
        
        return view('admin/implementation_edit', $data);
    }
    
    public function save()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Validate input
        $rules = [
            'kerjasama_id' => 'required|numeric',
            'judul_kegiatan' => 'required|min_length[5]',
            'tanggal_kegiatan' => 'required|valid_date',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'bukti' => 'uploaded[bukti]|max_size[bukti,10240]|ext_in[bukti,pdf,jpg,jpeg,png]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Upload file bukti
        $file = $this->request->getFile('bukti');
        $fileName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/implementasi', $fileName);
        
        // Save implementasi data
        $this->implementasiModel->save([
            'kerjasama_id' => $this->request->getPost('kerjasama_id'),
            'judul_kegiatan' => $this->request->getPost('judul_kegiatan'),
            'tanggal_kegiatan' => $this->request->getPost('tanggal_kegiatan'),
            'lokasi' => $this->request->getPost('lokasi'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'bukti' => $fileName,
            'created_by' => $this->session->get('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('/admin/implementation')->with('success', 'Implementasi Kerjasama berhasil ditambahkan');
    }
    
    public function edit($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/implementation')->with('error', 'ID Implementasi tidak ditemukan');
        }
        
        $implementasi = $this->implementasiModel->find($id);
        if (!$implementasi) {
            return redirect()->to('/admin/implementation')->with('error', 'Data Implementasi tidak ditemukan');
        }
        
        // Get all active kerjasama for dropdown
        $kerjasamaModel = new \App\Models\KerjasamaModel();
        $kerjasama = $kerjasamaModel->where('status', 'aktif')->findAll();
        
        $data = [
            'title' => 'Edit Implementasi Kerjasama',
            'implementasi' => $implementasi,
            'kerjasama' => $kerjasama
        ];
        
        return view('admin/implementation_edit', $data);
    }
    
    public function update($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/implementation')->with('error', 'ID Implementasi tidak ditemukan');
        }
        
        // Validate input
        $rules = [
            'kerjasama_id' => 'required|numeric',
            'judul_kegiatan' => 'required|min_length[5]',
            'tanggal_kegiatan' => 'required|valid_date',
            'lokasi' => 'required',
            'deskripsi' => 'required'
        ];
        
        // Check if file is being updated
        if ($this->request->getFile('bukti')->isValid()) {
            $rules['bukti'] = 'uploaded[bukti]|max_size[bukti,10240]|ext_in[bukti,pdf,jpg,jpeg,png]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Prepare update data
        $data = [
            'kerjasama_id' => $this->request->getPost('kerjasama_id'),
            'judul_kegiatan' => $this->request->getPost('judul_kegiatan'),
            'tanggal_kegiatan' => $this->request->getPost('tanggal_kegiatan'),
            'lokasi' => $this->request->getPost('lokasi'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'updated_by' => $this->session->get('user_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Handle file upload if provided
        if ($this->request->getFile('bukti')->isValid()) {
            $file = $this->request->getFile('bukti');
            $fileName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/implementasi', $fileName);
            $data['bukti'] = $fileName;
            
            // Delete old file
            $oldImplementasi = $this->implementasiModel->find($id);
            if ($oldImplementasi && !empty($oldImplementasi['bukti'])) {
                $oldFilePath = WRITEPATH . 'uploads/implementasi/' . $oldImplementasi['bukti'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
        }
        
        // Update implementasi data
        $this->implementasiModel->update($id, $data);
        
        return redirect()->to('/admin/implementation')->with('success', 'Implementasi Kerjasama berhasil diperbarui');
    }
    
    public function delete($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/implementation')->with('error', 'ID Implementasi tidak ditemukan');
        }
        
        // Get implementasi data to delete file
        $implementasi = $this->implementasiModel->find($id);
        if ($implementasi && !empty($implementasi['bukti'])) {
            $filePath = WRITEPATH . 'uploads/implementasi/' . $implementasi['bukti'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Delete implementasi data
        $this->implementasiModel->delete($id);
        
        return redirect()->to('/admin/implementation')->with('success', 'Implementasi Kerjasama berhasil dihapus');
    }
}
