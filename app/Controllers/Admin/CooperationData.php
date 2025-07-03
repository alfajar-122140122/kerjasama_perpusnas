<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KerjasamaModel;

class CooperationData extends BaseController
{
    protected $session;
    protected $kerjasamaModel;
    
    public function __construct()
    {
        $this->session = session();
        $this->kerjasamaModel = new KerjasamaModel();
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
            'title' => 'Data Kerjasama',
            'kerjasama' => $this->kerjasamaModel->findAll()
        ];
        
        return view('admin/cooperation_data_edit', $data);
    }
    
    public function add()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $data = [
            'title' => 'Tambah Data Kerjasama Baru'
        ];
        
        return view('admin/cooperation_data_edit', $data);
    }
    
    public function save()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Validate input
        $rules = [
            'judul' => 'required|min_length[5]',
            'instansi' => 'required',
            'jenis' => 'required',
            'status' => 'required|in_list[aktif,tidak aktif,akan berakhir]',
            'tanggal_mulai' => 'required|valid_date',
            'tanggal_berakhir' => 'required|valid_date',
            'pic' => 'required',
            'file_kerjasama' => 'uploaded[file_kerjasama]|max_size[file_kerjasama,10240]|ext_in[file_kerjasama,pdf]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Upload file
        $file = $this->request->getFile('file_kerjasama');
        $fileName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/kerjasama', $fileName);
        
        // Save data kerjasama
        $this->kerjasamaModel->save([
            'judul' => $this->request->getPost('judul'),
            'instansi' => $this->request->getPost('instansi'),
            'jenis' => $this->request->getPost('jenis'),
            'status' => $this->request->getPost('status'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir'),
            'pic' => $this->request->getPost('pic'),
            'file_kerjasama' => $fileName,
            'deskripsi' => $this->request->getPost('deskripsi'),
            'created_by' => $this->session->get('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('/admin/cooperation-data')->with('success', 'Data Kerjasama berhasil ditambahkan');
    }
    
    public function edit($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/cooperation-data')->with('error', 'ID Kerjasama tidak ditemukan');
        }
        
        $kerjasama = $this->kerjasamaModel->find($id);
        if (!$kerjasama) {
            return redirect()->to('/admin/cooperation-data')->with('error', 'Data Kerjasama tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Data Kerjasama',
            'kerjasama' => $kerjasama
        ];
        
        return view('admin/cooperation_data_edit', $data);
    }
    
    public function update($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/cooperation-data')->with('error', 'ID Kerjasama tidak ditemukan');
        }
        
        // Validate input
        $rules = [
            'judul' => 'required|min_length[5]',
            'instansi' => 'required',
            'jenis' => 'required',
            'status' => 'required|in_list[aktif,tidak aktif,akan berakhir]',
            'tanggal_mulai' => 'required|valid_date',
            'tanggal_berakhir' => 'required|valid_date',
            'pic' => 'required'
        ];
        
        // Check if file is being updated
        if ($this->request->getFile('file_kerjasama')->isValid()) {
            $rules['file_kerjasama'] = 'uploaded[file_kerjasama]|max_size[file_kerjasama,10240]|ext_in[file_kerjasama,pdf]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Prepare update data
        $data = [
            'judul' => $this->request->getPost('judul'),
            'instansi' => $this->request->getPost('instansi'),
            'jenis' => $this->request->getPost('jenis'),
            'status' => $this->request->getPost('status'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir'),
            'pic' => $this->request->getPost('pic'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'updated_by' => $this->session->get('user_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Handle file upload if provided
        if ($this->request->getFile('file_kerjasama')->isValid()) {
            $file = $this->request->getFile('file_kerjasama');
            $fileName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/kerjasama', $fileName);
            $data['file_kerjasama'] = $fileName;
            
            // Delete old file
            $oldKerjasama = $this->kerjasamaModel->find($id);
            if ($oldKerjasama && !empty($oldKerjasama['file_kerjasama'])) {
                $oldFilePath = WRITEPATH . 'uploads/kerjasama/' . $oldKerjasama['file_kerjasama'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
        }
        
        // Update kerjasama data
        $this->kerjasamaModel->update($id, $data);
        
        return redirect()->to('/admin/cooperation-data')->with('success', 'Data Kerjasama berhasil diperbarui');
    }
    
    public function delete($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/cooperation-data')->with('error', 'ID Kerjasama tidak ditemukan');
        }
        
        // Get kerjasama data to delete file
        $kerjasama = $this->kerjasamaModel->find($id);
        if ($kerjasama && !empty($kerjasama['file_kerjasama'])) {
            $filePath = WRITEPATH . 'uploads/kerjasama/' . $kerjasama['file_kerjasama'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Delete kerjasama data
        $this->kerjasamaModel->delete($id);
        
        return redirect()->to('/admin/cooperation-data')->with('success', 'Data Kerjasama berhasil dihapus');
    }
}
