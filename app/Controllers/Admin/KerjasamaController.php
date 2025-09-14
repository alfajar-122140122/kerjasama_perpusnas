<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KerjasamaModel;
use App\Models\ProgressKerjasamaModel; // Add this line

class KerjasamaController extends BaseController
{
    protected $kerjasamaModel;
    protected $progressKerjasamaModel; // Add this line
    
    public function __construct()
    {
        $this->kerjasamaModel = new KerjasamaModel();
        $this->progressKerjasamaModel = new ProgressKerjasamaModel(); // Add this line
    }
    
    public function data()
    {
        // Get pagination parameters
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10; // 10 items per page
        
        // Get total count for pagination
        $totalKerjasama = $this->kerjasamaModel->countAllResults();
        
        // Calculate total pages
        $totalPages = ceil($totalKerjasama / $perPage);
        
        // Ensure valid page number
        $page = max(1, min($page, $totalPages));
        
        // Calculate offset
        $offset = ($page - 1) * $perPage;
        
        // Get kerjasama data with pagination
        $kerjasamaData = $this->kerjasamaModel->orderBy('id', 'DESC')
                                             ->limit($perPage, $offset)
                                             ->findAll();
        
        // Calculate pagination info
        $paginationInfo = [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
            'totalItems' => $totalKerjasama,
            'startItem' => $totalKerjasama > 0 ? $offset + 1 : 0,
            'endItem' => min($offset + $perPage, $totalKerjasama)
        ];
        
        $data = [
            'title' => 'Data Kerjasama',
            'kerjasamaData' => $kerjasamaData,
            'pagination' => $paginationInfo
        ];
        
        return view('admin/kerjasama/data', $data);
    }
    
    public function implementasi()
    {
        // Get pagination parameters
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10; // 10 items per page
        
        $implementasiKerjasamaModel = new \App\Models\ImplementasiKerjasamaModel();
        
        // Get total count for pagination
        $totalImplementasi = $implementasiKerjasamaModel->countAllResults();
        
        // Calculate total pages
        $totalPages = ceil($totalImplementasi / $perPage);
        
        // Ensure valid page number
        $page = max(1, min($page, $totalPages));
        
        // Calculate offset
        $offset = ($page - 1) * $perPage;
        
        // Get implementasi data with pagination
        $implementasiData = $implementasiKerjasamaModel->getImplementasiWithKerjasama($perPage, $offset);
        
        // Calculate pagination info
        $paginationInfo = [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
            'totalItems' => $totalImplementasi,
            'startItem' => $totalImplementasi > 0 ? $offset + 1 : 0,
            'endItem' => min($offset + $perPage, $totalImplementasi)
        ];
        
        $data = [
            'title' => 'Implementasi Kerjasama',
            'implementasiData' => $implementasiData,
            'pagination' => $paginationInfo
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
        
        // Get pagination parameters
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10; // 10 items per page
        
        // Get total count for pagination
        $totalKerjasama = $this->kerjasamaModel
            ->where('tanggal_berakhir >=', $today)
            ->where('tanggal_berakhir <=', $threeMonthsLater)
            ->countAllResults();
        
        // Calculate total pages
        $totalPages = ceil($totalKerjasama / $perPage);
        
        // Ensure valid page number
        $page = max(1, min($page, $totalPages));
        
        // Calculate offset
        $offset = ($page - 1) * $perPage;
        
        // Ambil kerjasama yang akan berakhir dalam 90 hari ke depan dengan pagination
        $akanBerakhirData = $this->kerjasamaModel
            ->where('tanggal_berakhir >=', $today)
            ->where('tanggal_berakhir <=', $threeMonthsLater)
            ->orderBy('tanggal_berakhir', 'ASC')
            ->limit($perPage, $offset)
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
        
        // Calculate pagination info
        $paginationInfo = [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
            'totalItems' => $totalKerjasama,
            'startItem' => $totalKerjasama > 0 ? $offset + 1 : 0,
            'endItem' => min($offset + $perPage, $totalKerjasama)
        ];
        
        $data = [
            'title' => 'Kerjasama Akan Berakhir',
            'akanBerakhirData' => $akanBerakhirData,
            'pagination' => $paginationInfo
        ];
        
        return view('admin/kerjasama/akan_berakhir', $data);
    }
    
    public function progress()
    {
        // Redirect to the new Progress Kerjasama Controller
        return redirect()->to(base_url('admin/kerjasama/progress'));
    }
    
    public function pengajuan()
    {
        // Get pagination parameters
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10; // 10 items per page
        
        $permohonanKerjasamaModel = new \App\Models\PermohonanKerjasamaModel();
        
        // Get total count for pagination
        $totalPermohonan = $permohonanKerjasamaModel->countAllResults();
        
        // Calculate total pages
        $totalPages = ceil($totalPermohonan / $perPage);
        
        // Ensure valid page number
        $page = max(1, min($page, $totalPages));
        
        // Calculate offset
        $offset = ($page - 1) * $perPage;
        
        // Get pengajuan data with pagination
        $pengajuanData = $permohonanKerjasamaModel->orderBy('created_at', 'DESC')
                                                  ->limit($perPage, $offset)
                                                  ->findAll();
        
        // Calculate summary counts
        $summary = [
            'pending' => $permohonanKerjasamaModel->where('status', 'pending')->countAllResults(),
            'review' => $permohonanKerjasamaModel->where('status', 'review')->countAllResults(),
            'approved' => $permohonanKerjasamaModel->where('status', 'approved')->countAllResults(),
            'rejected' => $permohonanKerjasamaModel->where('status', 'rejected')->countAllResults()
        ];
        
        // Calculate pagination info
        $paginationInfo = [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
            'totalItems' => $totalPermohonan,
            'startItem' => $totalPermohonan > 0 ? $offset + 1 : 0,
            'endItem' => min($offset + $perPage, $totalPermohonan)
        ];
        
        $data = [
            'title' => 'Pengajuan Kerjasama',
            'pengajuanData' => $pengajuanData,
            'summary' => $summary,
            'pagination' => $paginationInfo
        ];
        
        return view('admin/kerjasama/pengajuan', $data);
    }
    
    public function tambah()
    {
        // AdminAuth filter will handle authentication check
        $data = [
            'title' => 'Tambah Kerjasama'
        ];
        
        return view('admin/kerjasama/tambah', $data);
    }
    
    public function edit($id)
    {
        // AdminAuth filter will handle authentication check
        $kerjasama = $this->kerjasamaModel->find($id);
        
        if (!$kerjasama) {
            // Return 404 for AJAX requests
            if ($this->request->hasHeader('X-Requested-With') && $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return $this->response->setStatusCode(404)->setJSON([
                    'status' => false,
                    'message' => 'Data kerjasama tidak ditemukan.'
                ]);
            }
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
        // AdminAuth filter will handle authentication check
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
        // AdminAuth filter will handle authentication check
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
        // AdminAuth filter will handle authentication check
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
    
    // Progress Kerjasama CRUD operations
    public function storeProgress()
    {
        // Validasi input sesuai skema database
        $rules = [
            'nama_mitra' => 'required', // Field comes from form as nama_mitra but stored as lembaga
            'tanggal_pengajuan' => 'required|valid_date',
            'jenis' => 'required',
            'progress' => 'required'
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
            'tanggal_pengajuan' => $this->request->getPost('tanggal_pengajuan'),
            'lembaga' => $this->request->getPost('nama_mitra'), // Field in DB is 'lembaga'
            'jenis' => $this->request->getPost('jenis'),
            'progress' => $this->request->getPost('progress'),
            'status' => $this->request->getPost('status') ?? 'published',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // If kerjasama_id is provided and not empty
        if ($this->request->getPost('kerjasama_id')) {
            $data['kerjasama_id'] = $this->request->getPost('kerjasama_id');
        }
        
        try {
            // Simpan data
            if ($this->progressKerjasamaModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data progress kerjasama berhasil ditambahkan'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menambahkan data progress kerjasama'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getProgress($id)
    {
        $progress = $this->progressKerjasamaModel->find($id);
        
        if (!$progress) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data progress kerjasama tidak ditemukan'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => true,
            'data' => $progress
        ]);
    }
    
    public function updateProgress($id)
    {
        // Validasi input sesuai skema database
        $rules = [
            'nama_mitra' => 'required', // Field comes from form as nama_mitra but stored as lembaga
            'tanggal_pengajuan' => 'required|valid_date',
            'jenis' => 'required',
            'progress' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        // Check if record exists
        $progress = $this->progressKerjasamaModel->find($id);
        if (!$progress) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data progress kerjasama tidak ditemukan'
            ]);
        }
        
        // Prepare data untuk update
        $data = [
            'tanggal_pengajuan' => $this->request->getPost('tanggal_pengajuan'),
            'lembaga' => $this->request->getPost('nama_mitra'), // Field in DB is 'lembaga'
            'jenis' => $this->request->getPost('jenis'),
            'progress' => $this->request->getPost('progress'),
            'status' => $this->request->getPost('status') ?? 'published',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // If kerjasama_id is provided and not empty
        if ($this->request->getPost('kerjasama_id')) {
            $data['kerjasama_id'] = $this->request->getPost('kerjasama_id');
        }
        
        try {
            // Update data
            if ($this->progressKerjasamaModel->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data progress kerjasama berhasil diperbarui'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal memperbarui data progress kerjasama'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function deleteProgress($id)
    {
        try {
            // Check if record exists
            $progress = $this->progressKerjasamaModel->find($id);
            if (!$progress) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data progress kerjasama tidak ditemukan'
                ]);
            }
            
            // Delete data
            if ($this->progressKerjasamaModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data progress kerjasama berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menghapus data progress kerjasama'
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