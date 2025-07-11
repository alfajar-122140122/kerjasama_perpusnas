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
        $implementasiKerjasamaModel = new \App\Models\ImplementasiKerjasamaModel();
        $implementasiData = $implementasiKerjasamaModel->getImplementasiWithKerjasama();
        
        $data = [
            'title' => 'Implementasi Kerjasama',
            'implementasiData' => $implementasiData
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
        $today = date('Y-m-d');
        $threeMonthsLater = date('Y-m-d', strtotime('+3 months'));
        
        // Ambil kerjasama yang akan berakhir dalam 90 hari ke depan
        $akanBerakhirData = $this->kerjasamaModel
            ->where('tanggal_berakhir >=', $today)
            ->where('tanggal_berakhir <=', $threeMonthsLater)
            ->orderBy('tanggal_berakhir', 'ASC')
            ->findAll();
        
        // Hitung sisa hari untuk setiap kerjasama
        foreach ($akanBerakhirData as &$kerjasama) {
            $endDate = new \DateTime($kerjasama['tanggal_berakhir']);
            $currentDate = new \DateTime($today);
            $interval = $currentDate->diff($endDate);
            $kerjasama['sisa_hari'] = $interval->days;
            
            // Format tanggal untuk tampilan
            $kerjasama['tanggal_mulai_formatted'] = date('d/m/Y', strtotime($kerjasama['tanggal_mulai']));
            $kerjasama['tanggal_berakhir_formatted'] = date('d/m/Y', strtotime($kerjasama['tanggal_berakhir']));
        }
        
        $data = [
            'title' => 'Kerjasama Akan Berakhir',
            'akanBerakhirData' => $akanBerakhirData
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
    
    public function get($id)
    {
        $kerjasama = $this->kerjasamaModel->find($id);
        
        if (!$kerjasama) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data kerjasama tidak ditemukan'
            ]);
        }
        
        // No need to modify dates - just return as is
        return $this->response->setJSON([
            'status' => true,
            'data' => $kerjasama
        ]);
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
    
    public function storeImplementasi()
    {
        // Validasi input sesuai skema database
        $rules = [
            'kerjasama_id' => 'required|numeric',
            'implementasi' => 'required',
            'lingkup' => 'required',
            'masa_berlaku' => 'required',
            'unit_kerja_terkait' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        // Prepare data untuk disimpan
        $data = [
            'kerjasama_id' => $this->request->getPost('kerjasama_id'),
            'implementasi' => $this->request->getPost('implementasi'),
            'lingkup' => $this->request->getPost('lingkup'),
            'masa_berlaku' => $this->request->getPost('masa_berlaku'),
            'unit_kerja_terkait' => $this->request->getPost('unit_kerja_terkait'),
            'created_at' => date('Y-m-d H:i:s') // Set created_at manually
        ];
        
        try {
            $implementasiKerjasamaModel = new \App\Models\ImplementasiKerjasamaModel();
            
            // Simpan data
            if ($implementasiKerjasamaModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data implementasi berhasil ditambahkan'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menambahkan data implementasi'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function updateImplementasi($id)
    {
        // Validasi input sesuai skema database
        $rules = [
            'kerjasama_id' => 'required|numeric',
            'implementasi' => 'required',
            'lingkup' => 'required',
            'masa_berlaku' => 'required',
            'unit_kerja_terkait' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        // Check if record exists
        $implementasiKerjasamaModel = new \App\Models\ImplementasiKerjasamaModel();
        $implementasi = $implementasiKerjasamaModel->find($id);
        
        if (!$implementasi) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data implementasi tidak ditemukan'
            ]);
        }
        
        // Prepare data untuk update
        $data = [
            'kerjasama_id' => $this->request->getPost('kerjasama_id'),
            'implementasi' => $this->request->getPost('implementasi'),
            'lingkup' => $this->request->getPost('lingkup'),
            'masa_berlaku' => $this->request->getPost('masa_berlaku'),
            'unit_kerja_terkait' => $this->request->getPost('unit_kerja_terkait')
        ];
        
        try {
            // Update data
            if ($implementasiKerjasamaModel->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data implementasi berhasil diperbarui'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal memperbarui data implementasi'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getImplementasi($id)
    {
        $implementasiKerjasamaModel = new \App\Models\ImplementasiKerjasamaModel();
        $implementasi = $implementasiKerjasamaModel->getImplementasiWithKerjasama($id);
        
        if (!$implementasi) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data implementasi tidak ditemukan'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => true,
            'data' => $implementasi
        ]);
    }
    
    public function deleteImplementasi($id)
    {
        try {
            $implementasiKerjasamaModel = new \App\Models\ImplementasiKerjasamaModel();
            
            // Check if record exists
            $implementasi = $implementasiKerjasamaModel->find($id);
            if (!$implementasi) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data implementasi tidak ditemukan'
                ]);
            }
            
            // Delete data
            if ($implementasiKerjasamaModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data implementasi berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menghapus data implementasi'
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