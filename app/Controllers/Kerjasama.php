<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Kerjasama extends BaseController
{
    protected $session;
    protected $kerjasamaModel;
    protected $implementasiModel;
    protected $permohonanModel;
    
    public function __construct()
    {
        $this->session = session();
        $this->kerjasamaModel = new \App\Models\KerjasamaModel();
        $this->implementasiModel = new \App\Models\ImplementasiKerjasamaModel();
        $this->permohonanModel = new \App\Models\PermohonanKerjasamaModel();
        helper(['url', 'form']);
    }
    
    // Middleware check untuk semua method kerjasama
    private function checkAuth()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        if ($this->session->get('hak_akses') !== 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini');
        }
        
        return null;
    }

    /**
     * Halaman utama manajemen kerjasama
     */
    public function index()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        // Get real kerjasama data from database
        $kerjasama = $this->kerjasamaModel->findAll();
        
        // Get implementation count for each kerjasama
        $implementasiCount = [];
        foreach ($kerjasama as &$k) {
            $implementasiCount[$k['id_kerjasama']] = $this->implementasiModel
                ->where('id_kerjasama', $k['id_kerjasama'])
                ->countAllResults();
                
            // Convert dates for display
            if (!empty($k['tanggal_mulai'])) {
                $k['tanggal_mulai_formatted'] = date('d-m-Y', strtotime($k['tanggal_mulai']));
            } else {
                $k['tanggal_mulai_formatted'] = '-';
            }
            
            // Handle tanggal_berakhir field (yang tersimpan di database)
            if (!empty($k['tanggal_berakhir'])) {
                $k['tanggal_selesai_formatted'] = date('d-m-Y', strtotime($k['tanggal_berakhir']));
            } else {
                $k['tanggal_selesai_formatted'] = '-';
            }
            
            // Determine status based on dates or status field
            $today = date('Y-m-d');
            
            // Gunakan field status jika sudah ada
            if (!empty($k['status'])) {
                // Status field sudah ada, tidak perlu mengubah
            } 
            // Jika tidak ada status, tentukan berdasarkan tanggal
            else if (!empty($k['tanggal_mulai']) && !empty($k['tanggal_berakhir'])) {
                if ($today < $k['tanggal_mulai']) {
                    $k['status'] = 'pending';
                } elseif ($today > $k['tanggal_berakhir']) {
                    $k['status'] = 'selesai';
                } else {
                    $k['status'] = 'aktif';
                }
            } else {
                // Default to pending jika tidak ada informasi status maupun tanggal
                $k['status'] = 'pending';
            }
        }
        
        // Calculate statistics
        $aktif = count(array_filter($kerjasama, fn($k) => $k['status'] === 'aktif'));
        $selesai = count(array_filter($kerjasama, fn($k) => $k['status'] === 'selesai'));
        $pending = count(array_filter($kerjasama, fn($k) => $k['status'] === 'pending'));
        $totalImplementasi = $this->implementasiModel->countAllResults();
        $uniqueMitras = count(array_unique(array_column($kerjasama, 'nama_mitra')));

        $data = [
            'kerjasama' => $kerjasama,
            'implementasiCount' => $implementasiCount,
            'total_kerjasama' => count($kerjasama),
            'aktif' => $aktif,
            'selesai' => $selesai,
            'pending' => $pending,
            'totalImplementasi' => $totalImplementasi,
            'totalMitra' => $uniqueMitras
        ];

        return view('admin/kerjasama', $data);
    }

    /**
     * Tambah kerjasama baru
     */
    public function create()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'nama_mitra' => [
                'label' => 'Nama Mitra',
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 3 karakter'
                ]
            ],
            'ruang_lingkup' => [
                'label' => 'Ruang Lingkup',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'jenis' => [
                'label' => 'Jenis Kerjasama',
                'rules' => 'permit_empty',
                'errors' => []
            ],
            'tanggal_mulai' => [
                'label' => 'Tanggal Mulai',
                'rules' => 'permit_empty|valid_date',
                'errors' => [
                    'valid_date' => '{field} harus berupa tanggal yang valid'
                ]
            ],
            'tanggal_selesai' => [
                'label' => 'Tanggal Selesai',
                'rules' => 'permit_empty|valid_date',
                'errors' => [
                    'valid_date' => '{field} harus berupa tanggal yang valid'
                ]
            ],
            'progress' => [
                'label' => 'Progress',
                'rules' => 'permit_empty|in_list[draft,aktif,selesai,dibatalkan]',
                'errors' => [
                    'in_list' => '{field} harus salah satu dari: draft, aktif, selesai, dibatalkan'
                ]
            ],
            'dokumen' => [
                'label' => 'Dokumen',
                'rules' => 'permit_empty',
                'errors' => []
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validation->getErrors()
            ]);
        }

        // Validate date range if both dates are provided
        $tanggalMulai = $this->request->getPost('tanggal_mulai');
        $tanggalSelesai = $this->request->getPost('tanggal_selesai');
        
        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            if (strtotime($tanggalSelesai) <= strtotime($tanggalMulai)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tanggal selesai harus setelah tanggal mulai'
                ]);
            }
        }            // Handle file upload if exists
        $dokumen = $this->request->getFile('dokumen');
        $namaDokumen = null;

        if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
            // Check file size (max 5MB)
            if ($dokumen->getSize() > 5242880) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ukuran file terlalu besar (maksimal 5MB)'
                ]);
            }
            
            // Check file type
            $fileType = $dokumen->getClientMimeType();
            $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            
            if (!in_array($fileType, $allowedTypes)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tipe file tidak diizinkan (hanya PDF, DOC, DOCX)'
                ]);
            }
            
            $namaDokumen = $dokumen->getRandomName();
            
            // Create directory if not exists
            $uploadPath = ROOTPATH . 'public/uploads/kerjasama/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Move file
            try {
                $dokumen->move($uploadPath, $namaDokumen);
            } catch (\Exception $e) {
                log_message('error', 'File upload error: ' . $e->getMessage());
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengunggah file: ' . $e->getMessage()
                ]);
            }
        }

        // Get form data
        $data = [
            'nama_mitra' => $this->request->getPost('nama_mitra'),
            'ruang_lingkup' => $this->request->getPost('ruang_lingkup'),
            'jenis' => $this->request->getPost('jenis'),
            'tanggal_mulai' => $tanggalMulai ?: null,
            'tanggal_berakhir' => $tanggalSelesai ?: null, // Menggunakan nama field yang benar
            'status' => $this->request->getPost('progress') ?: 'draft', // Menggunakan nama field yang benar
            'created_by_user_id' => session()->get('id_user')
        ];
        
        // Add document name if uploaded
        if ($namaDokumen) {
            $data['dokumen'] = $namaDokumen;
        }

        try {
            $this->kerjasamaModel->insert($data);
            $insertId = $this->kerjasamaModel->getInsertID();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kerjasama berhasil ditambahkan',
                'id' => $insertId
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Database error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update kerjasama
     */
    public function update($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID kerjasama tidak valid'
            ]);
        }

        // Check if kerjasama exists
        $kerjasama = $this->kerjasamaModel->find($id);
        if (!$kerjasama) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kerjasama tidak ditemukan'
            ]);
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'nama_mitra' => [
                'label' => 'Nama Mitra',
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 3 karakter'
                ]
            ],
            'ruang_lingkup' => [
                'label' => 'Ruang Lingkup',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'jenis' => [
                'label' => 'Jenis Kerjasama',
                'rules' => 'permit_empty',
                'errors' => []
            ],
            'tanggal_mulai' => [
                'label' => 'Tanggal Mulai',
                'rules' => 'permit_empty|valid_date',
                'errors' => [
                    'valid_date' => '{field} harus berupa tanggal yang valid'
                ]
            ],
            'tanggal_selesai' => [
                'label' => 'Tanggal Selesai',
                'rules' => 'permit_empty|valid_date',
                'errors' => [
                    'valid_date' => '{field} harus berupa tanggal yang valid'
                ]
            ],
            'progress' => [
                'label' => 'Progress',
                'rules' => 'permit_empty|in_list[draft,aktif,selesai,dibatalkan]',
                'errors' => [
                    'in_list' => '{field} harus salah satu dari: draft, aktif, selesai, dibatalkan'
                ]
            ],
            'dokumen' => [
                'label' => 'Dokumen',
                'rules' => 'permit_empty',
                'errors' => []
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validation->getErrors()
            ]);
        }

        // Validate date range if both dates are provided
        $tanggalMulai = $this->request->getPost('tanggal_mulai');
        $tanggalSelesai = $this->request->getPost('tanggal_selesai');
        
        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            if (strtotime($tanggalSelesai) <= strtotime($tanggalMulai)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tanggal selesai harus setelah tanggal mulai'
                ]);
            }
        }

        // Handle file upload if exists
        $dokumen = $this->request->getFile('dokumen');
        $namaDokumen = null;

        if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
            // Check file size (max 5MB)
            if ($dokumen->getSize() > 5242880) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ukuran file terlalu besar (maksimal 5MB)'
                ]);
            }
            
            // Check file type
            $fileType = $dokumen->getClientMimeType();
            $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            
            if (!in_array($fileType, $allowedTypes)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tipe file tidak diizinkan (hanya PDF, DOC, DOCX)'
                ]);
            }
            
            $namaDokumen = $dokumen->getRandomName();
            
            // Create directory if not exists
            $uploadPath = ROOTPATH . 'public/uploads/kerjasama/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Move file
            try {
                $dokumen->move($uploadPath, $namaDokumen);
                
                // Delete old file if exists
                if (!empty($kerjasama['dokumen'])) {
                    $oldFilePath = ROOTPATH . 'public/uploads/kerjasama/' . $kerjasama['dokumen'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
            } catch (\Exception $e) {
                log_message('error', 'File upload error: ' . $e->getMessage());
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengunggah file: ' . $e->getMessage()
                ]);
            }
        }

        // Get form data
        $data = [
            'nama_mitra' => $this->request->getPost('nama_mitra'),
            'ruang_lingkup' => $this->request->getPost('ruang_lingkup'),
            'jenis' => $this->request->getPost('jenis'),
            'tanggal_mulai' => $tanggalMulai ?: null,
            'tanggal_berakhir' => $tanggalSelesai ?: null, // Menggunakan nama field yang benar
            'status' => $this->request->getPost('progress') ?: null // Menggunakan nama field yang benar
        ];

        // Add document name if uploaded
        if ($namaDokumen) {
            $data['dokumen'] = $namaDokumen;
        }

        try {
            $this->kerjasamaModel->update($id, $data);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kerjasama berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Database error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Hapus kerjasama
     */
    public function delete($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID kerjasama tidak valid'
            ]);
        }

        // Check if kerjasama exists
        $kerjasama = $this->kerjasamaModel->find($id);
        if (!$kerjasama) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kerjasama tidak ditemukan'
            ]);
        }
        
        // Check if there are related implementations
        $implementasi = $this->implementasiModel->where('id_kerjasama', $id)->countAllResults();
        if ($implementasi > 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak dapat menghapus. Kerjasama ini memiliki ' . $implementasi . ' data implementasi terkait'
            ]);
        }

        // Delete file if exists
        if (!empty($kerjasama['dokumen'])) {
            $filePath = ROOTPATH . 'public/uploads/kerjasama/' . $kerjasama['dokumen'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        try {
            $this->kerjasamaModel->delete($id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kerjasama berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Database error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get detail kerjasama untuk modal view
     */
    public function detail($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID kerjasama tidak valid'
            ]);
        }

        // Get kerjasama detail
        $kerjasama = $this->kerjasamaModel->find($id);
        
        if (!$kerjasama) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kerjasama tidak ditemukan'
            ]);
        }
        
        // Get implementation count
        $implementasi = $this->implementasiModel->where('id_kerjasama', $id)->findAll();
        
        // Format dates
        if (!empty($kerjasama['tanggal_mulai'])) {
            $kerjasama['tanggal_mulai_formatted'] = date('d-m-Y', strtotime($kerjasama['tanggal_mulai']));
        }
        
        // Handle tanggal_berakhir field (yang tersimpan di database)
        if (!empty($kerjasama['tanggal_berakhir'])) {
            $kerjasama['tanggal_selesai_formatted'] = date('d-m-Y', strtotime($kerjasama['tanggal_berakhir']));
        }
        
        // Status field sudah ada di database, tidak perlu menentukan secara manual
        // Jika tidak ada status, tentukan berdasarkan tanggal
        if (empty($kerjasama['status'])) {
            $today = date('Y-m-d');
            if (!empty($kerjasama['tanggal_mulai']) && !empty($kerjasama['tanggal_berakhir'])) {
                if ($today < $kerjasama['tanggal_mulai']) {
                    $kerjasama['status'] = 'pending';
                } elseif ($today > $kerjasama['tanggal_berakhir']) {
                    $kerjasama['status'] = 'selesai';
                } else {
                    $kerjasama['status'] = 'aktif';
                }
            } else {
                $kerjasama['status'] = 'pending';
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $kerjasama,
            'implementasi' => $implementasi,
            'implementasi_count' => count($implementasi)
        ]);
    }

    /**
     * Export data kerjasama
     */
    public function export()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        $format = $this->request->getGet('format') ?: 'excel';
        $status = $this->request->getGet('status');
        $jenis = $this->request->getGet('jenis');

        // Build query
        $builder = $this->kerjasamaModel->builder();
        
        if ($status) {
            // For status filtering we need to determine from dates
            $today = date('Y-m-d');
            
            switch($status) {
                case 'aktif':
                    $builder->where('tanggal_mulai <=', $today);
                    $builder->where('tanggal_selesai >=', $today);
                    break;
                case 'selesai':
                    $builder->where('tanggal_selesai <', $today);
                    break;
                case 'pending':
                    $builder->where('tanggal_mulai >', $today);
                    break;
            }
        }
        
        if ($jenis) {
            $builder->where('jenis', $jenis);
        }
        
        $data = $builder->get()->getResultArray();
        
        // This is a placeholder for the actual export functionality
        // In a real application, you would generate Excel/PDF here
        
        return $this->response->setJSON([
            'success' => true,
            'message' => "Data kerjasama berhasil diekspor dalam format {$format}",
            'download_url' => base_url("exports/kerjasama_" . date('Y-m-d') . ".{$format}"),
            'count' => count($data)
        ]);
    }

    /**
     * Dashboard kerjasama - statistik dan grafik
     */
    public function dashboard()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        // Get data for statistics
        $kerjasama = $this->kerjasamaModel->findAll();
        $implementasi = $this->implementasiModel->findAll();
        
        $today = date('Y-m-d');
        $startOfMonth = date('Y-m-01');
        $endOfMonth = date('Y-m-t');
        
        // Calculate actual statistics
        $aktif = 0;
        $selesai = 0;
        $pending = 0;
        $kerjasamaBulanIni = 0;
        $kerjasamaBerakhirBulanIni = 0;
        
        foreach ($kerjasama as $k) {
            // Determine status based on dates
            if (!empty($k['tanggal_mulai']) && !empty($k['tanggal_selesai'])) {
                if ($today < $k['tanggal_mulai']) {
                    $pending++;
                } elseif ($today > $k['tanggal_selesai']) {
                    $selesai++;
                } else {
                    $aktif++;
                }
            } else {
                // Use progress field if dates aren't set
                switch ($k['progress']) {
                    case 'aktif': $aktif++; break;
                    case 'selesai': $selesai++; break;
                    default: $pending++; break;
                }
            }
            
            // Count kerjasama created this month
            if (!empty($k['created_at'])) {
                $createDate = date('Y-m-d', strtotime($k['created_at']));
                if ($createDate >= $startOfMonth && $createDate <= $endOfMonth) {
                    $kerjasamaBulanIni++;
                }
            }
            
            // Count kerjasama ending this month
            if (!empty($k['tanggal_selesai'])) {
                $endDate = date('Y-m-d', strtotime($k['tanggal_selesai']));
                if ($endDate >= $startOfMonth && $endDate <= $endOfMonth) {
                    $kerjasamaBerakhirBulanIni++;
                }
            }
        }

        // Statistics data
        $stats = [
            'total_kerjasama' => count($kerjasama),
            'aktif' => $aktif,
            'selesai' => $selesai,
            'pending' => $pending,
            'kerjasama_bulan_ini' => $kerjasamaBulanIni,
            'kerjasama_berakhir_bulan_ini' => $kerjasamaBerakhirBulanIni,
            'total_implementasi' => count($implementasi)
        ];

        // Get monthly data for charts
        $monthlyKerjasama = [];
        $monthlySelesai = [];
        
        // Get last 6 months
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $labels[] = date('M Y', strtotime("-$i months"));
            $monthStart = $month . '-01';
            $monthEnd = date('Y-m-t', strtotime($monthStart));
            
            // Count new kerjasama
            $newCount = 0;
            foreach ($kerjasama as $k) {
                if (!empty($k['created_at'])) {
                    $createDate = date('Y-m-d', strtotime($k['created_at']));
                    if ($createDate >= $monthStart && $createDate <= $monthEnd) {
                        $newCount++;
                    }
                }
            }
            
            // Count finished kerjasama
            $finishedCount = 0;
            foreach ($kerjasama as $k) {
                if (!empty($k['tanggal_selesai'])) {
                    $endDate = date('Y-m-d', strtotime($k['tanggal_selesai']));
                    if ($endDate >= $monthStart && $endDate <= $monthEnd) {
                        $finishedCount++;
                    }
                }
            }
            
            $monthlyKerjasama[] = $newCount;
            $monthlySelesai[] = $finishedCount;
        }

        // Chart data
        $chartData = [
            'monthly_progress' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Kerjasama Baru',
                        'data' => $monthlyKerjasama,
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'borderColor' => 'rgba(54, 162, 235, 1)'
                    ],
                    [
                        'label' => 'Kerjasama Selesai',
                        'data' => $monthlySelesai,
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderColor' => 'rgba(255, 99, 132, 1)'
                    ]
                ]
            ],
            'status_distribution' => [
                'labels' => ['Aktif', 'Selesai', 'Pending'],
                'datasets' => [
                    [
                        'data' => [$aktif, $selesai, $pending],
                        'backgroundColor' => ['#28a745', '#007bff', '#ffc107']
                    ]
                ]
            ]
        ];

        // Get recent kerjasama (last 5)
        $recentKerjasama = $this->kerjasamaModel->orderBy('created_at', 'DESC')->limit(5)->findAll();
        foreach ($recentKerjasama as &$k) {
            // Determine status for display
            if (!empty($k['tanggal_mulai']) && !empty($k['tanggal_selesai'])) {
                if ($today < $k['tanggal_mulai']) {
                    $k['status'] = 'pending';
                } elseif ($today > $k['tanggal_selesai']) {
                    $k['status'] = 'selesai';
                } else {
                    $k['status'] = 'aktif';
                }
            } else {
                $k['status'] = $k['progress'] ?? 'pending';
            }
            
            // Format date for display
            if (!empty($k['tanggal_mulai'])) {
                $k['tanggal_mulai_formatted'] = date('d/m/Y', strtotime($k['tanggal_mulai']));
            } else {
                $k['tanggal_mulai_formatted'] = '-';
            }
        }

        $data = [
            'stats' => $stats,
            'chartData' => $chartData,
            'recent_kerjasama' => $recentKerjasama
        ];

        return view('admin/kerjasama_dashboard', $data);
    }

    /**
     * View implementasi detail
     */
    public function implementasiDetail($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID implementasi tidak valid'
            ]);
        }

        // Get implementasi detail
        $implementasi = $this->implementasiModel->find($id);
        
        if (!$implementasi) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Implementasi tidak ditemukan'
            ]);
        }
        
        // Get kerjasama detail
        $kerjasama = $this->kerjasamaModel->find($implementasi['id_kerjasama']);
        
        // Format dates
        if (!empty($implementasi['tanggal_mulai'])) {
            $implementasi['tanggal_mulai_formatted'] = date('d-m-Y', strtotime($implementasi['tanggal_mulai']));
        } else {
            $implementasi['tanggal_mulai_formatted'] = '-';
        }
        
        if (!empty($implementasi['tanggal_selesai'])) {
            $implementasi['tanggal_selesai_formatted'] = date('d-m-Y', strtotime($implementasi['tanggal_selesai']));
        } else {
            $implementasi['tanggal_selesai_formatted'] = '-';
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $implementasi,
            'kerjasama' => $kerjasama
        ]);
    }

    /**
     * Add new implementasi
     */
    public function addImplementasi()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'id_kerjasama' => [
                'label' => 'ID Kerjasama',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'numeric' => '{field} harus berupa angka'
                ]
            ],
            'nama_kegiatan' => [
                'label' => 'Nama Kegiatan',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 5 karakter'
                ]
            ],
            'lingkup_implementasi' => [
                'label' => 'Lingkup Implementasi',
                'rules' => 'permit_empty',
                'errors' => []
            ],
            'tanggal_mulai' => [
                'label' => 'Tanggal Mulai',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_date' => '{field} harus berupa tanggal yang valid'
                ]
            ],
            'tanggal_selesai' => [
                'label' => 'Tanggal Selesai',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_date' => '{field} harus berupa tanggal yang valid'
                ]
            ],
            'hasil_kegiatan' => [
                'label' => 'Hasil Kegiatan',
                'rules' => 'permit_empty',
                'errors' => []
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validation->getErrors()
            ]);
        }

        // Validate date range
        $tanggalMulai = $this->request->getPost('tanggal_mulai');
        $tanggalSelesai = $this->request->getPost('tanggal_selesai');
        
        if (strtotime($tanggalSelesai) <= strtotime($tanggalMulai)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tanggal selesai harus setelah tanggal mulai'
            ]);
        }

        // Check if kerjasama exists
        $idKerjasama = $this->request->getPost('id_kerjasama');
        $kerjasama = $this->kerjasamaModel->find($idKerjasama);
        
        if (!$kerjasama) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kerjasama tidak ditemukan'
            ]);
        }

        // Get form data
        $data = [
            'id_kerjasama' => $idKerjasama,
            'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
            'lingkup_implementasi' => $this->request->getPost('lingkup_implementasi'),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'hasil_kegiatan' => $this->request->getPost('hasil_kegiatan'),
            'created_by_user_id' => session()->get('id_user')
        ];

        try {
            $this->implementasiModel->insert($data);
            $insertId = $this->implementasiModel->getInsertID();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Implementasi kerjasama berhasil ditambahkan',
                'id' => $insertId
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Database error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update implementasi
     */
    public function updateImplementasi($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID implementasi tidak valid'
            ]);
        }

        // Check if implementasi exists
        $implementasi = $this->implementasiModel->find($id);
        if (!$implementasi) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Implementasi tidak ditemukan'
            ]);
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'nama_kegiatan' => [
                'label' => 'Nama Kegiatan',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 5 karakter'
                ]
            ],
            'lingkup_implementasi' => [
                'label' => 'Lingkup Implementasi',
                'rules' => 'permit_empty',
                'errors' => []
            ],
            'tanggal_mulai' => [
                'label' => 'Tanggal Mulai',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_date' => '{field} harus berupa tanggal yang valid'
                ]
            ],
            'tanggal_selesai' => [
                'label' => 'Tanggal Selesai',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_date' => '{field} harus berupa tanggal yang valid'
                ]
            ],
            'hasil_kegiatan' => [
                'label' => 'Hasil Kegiatan',
                'rules' => 'permit_empty',
                'errors' => []
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validation->getErrors()
            ]);
        }

        // Validate date range
        $tanggalMulai = $this->request->getPost('tanggal_mulai');
        $tanggalSelesai = $this->request->getPost('tanggal_selesai');
        
        if (strtotime($tanggalSelesai) <= strtotime($tanggalMulai)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tanggal selesai harus setelah tanggal mulai'
            ]);
        }

        // Get form data
        $data = [
            'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
            'lingkup_implementasi' => $this->request->getPost('lingkup_implementasi'),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'hasil_kegiatan' => $this->request->getPost('hasil_kegiatan')
        ];

        try {
            $this->implementasiModel->update($id, $data);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Implementasi kerjasama berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Database error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete implementasi
     */
    public function deleteImplementasi($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID implementasi tidak valid'
            ]);
        }

        // Check if implementasi exists
        $implementasi = $this->implementasiModel->find($id);
        if (!$implementasi) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Implementasi tidak ditemukan'
            ]);
        }

        try {
            $this->implementasiModel->delete($id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Implementasi kerjasama berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Database error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ]);
        }
    }
}