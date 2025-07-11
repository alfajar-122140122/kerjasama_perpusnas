<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KerjasamaModel;

class KerjasamaController extends BaseController
{
    protected $kerjasamaModel;
    
    public function __construct()
    {
        $this->kerjasamaModel = new KerjasamaModel();
    }
    
    public function data()
    {
        $kerjasamaData = $this->kerjasamaModel->orderBy('id', 'DESC')->findAll();
        
        $data = [
            'title' => 'Data Kerjasama',
            'kerjasamaData' => $kerjasamaData
        ];
        
        return view('admin/kerjasama/data', $data);
    }
    
    public function implementasi()
    {
        $data = [
            'title' => 'Implementasi Kerjasama'
        ];
        
        return view('admin/kerjasama/implementasi', $data);
    }
    
    public function tambahImplementasi()
    {
        $data = [
            'title' => 'Tambah Implementasi'
        ];
        
        return view('admin/kerjasama/tambah_implementasi', $data);
    }
    
    public function editImplementasi($id)
    {
        $data = [
            'title' => 'Edit Implementasi',
            'id' => $id
        ];
        
        return view('admin/kerjasama/edit_implementasi', $data);
    }
    
    public function akanBerakhir()
    {
        $data = [
            'title' => 'Kerjasama Akan Berakhir'
        ];
        
        return view('admin/kerjasama/akan_berakhir', $data);
    }
    
    public function progress()
    {
        $data = [
            'title' => 'Progress Kerjasama'
        ];
        
        return view('admin/kerjasama/progress', $data);
    }
    
    public function pengajuan()
    {
        $data = [
            'title' => 'Pengajuan Kerjasama'
        ];
        
        return view('admin/kerjasama/pengajuan', $data);
    }
    
    public function tambah()
    {
        $data = [
            'title' => 'Tambah Kerjasama'
        ];
        
        return view('admin/kerjasama/tambah', $data);
    }
    
    public function edit($id)
    {
        $kerjasama = $this->kerjasamaModel->find($id);
        
        if (!$kerjasama) {
            return redirect()->to('/admin/kerjasama/data')->with('error', 'Data kerjasama tidak ditemukan.');
        }
        
        $data = [
            'title' => 'Edit Kerjasama',
            'kerjasama' => $kerjasama
        ];
        
        return view('admin/kerjasama/edit', $data);
    }
    
    public function store()
    {
        // Validasi input sesuai skema database
        $rules = [
            'nama_mitra' => 'required',
            'lingkup' => 'required',
            'tanggal_mulai' => 'required|valid_date',
            'tanggal_berakhir' => 'required|valid_date'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        // Prepare data untuk disimpan, sesuaikan dengan skema database
        $data = [
            'nama_mitra' => $this->request->getPost('nama_mitra'),
            'ruang_lingkup' => $this->request->getPost('lingkup'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir')
        ];
        
        try {
            // Simpan data
            if ($this->kerjasamaModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data kerjasama berhasil ditambahkan'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menambahkan data kerjasama'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function update($id)
    {
        // Validasi input sesuai skema database
        $rules = [
            'nama_mitra' => 'required',
            'lingkup' => 'required',
            'tanggal_mulai' => 'required|valid_date',
            'tanggal_berakhir' => 'required|valid_date'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        // Check if record exists
        $kerjasama = $this->kerjasamaModel->find($id);
        if (!$kerjasama) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data kerjasama tidak ditemukan'
            ]);
        }
        
        // Prepare data untuk update
        $data = [
            'nama_mitra' => $this->request->getPost('nama_mitra'),
            'ruang_lingkup' => $this->request->getPost('lingkup'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir')
        ];
        
        try {
            // Update data
            if ($this->kerjasamaModel->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data kerjasama berhasil diperbarui'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal memperbarui data kerjasama'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function delete($id)
    {
        try {
            // Check if record exists
            $kerjasama = $this->kerjasamaModel->find($id);
            if (!$kerjasama) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data kerjasama tidak ditemukan'
                ]);
            }
            
            // Delete data
            if ($this->kerjasamaModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data kerjasama berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menghapus data kerjasama'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}