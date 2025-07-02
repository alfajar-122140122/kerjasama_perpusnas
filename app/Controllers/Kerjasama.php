<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Kerjasama extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = session();
        helper(['url', 'form']);
    }
    
    // Middleware check untuk semua method kerjasama
    private function checkAuth()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        if ($this->session->get('role') !== 'Admin') {
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

        // Sample kerjasama data
        $kerjasama = [
            [
                'id' => 1,
                'judul' => 'Kerjasama dengan Perpustakaan Nasional Singapura',
                'instansi' => 'National Library of Singapore',
                'jenis' => 'Pertukaran Koleksi',
                'status' => 'aktif',
                'tanggal_mulai' => '2024-01-15',
                'tanggal_berakhir' => '2025-01-15',
                'pic' => 'Dr. Ahmad Susanto',
                'deskripsi' => 'Program pertukaran buku dan publikasi ilmiah antara Indonesia dan Singapura.',
                'dokumen' => 'mou_singapore_2024.pdf',
                'created_at' => '2024-01-10'
            ],
            [
                'id' => 2,
                'judul' => 'Digitalisasi Naskah Kuno Nusantara',
                'instansi' => 'Universitas Indonesia',
                'jenis' => 'Penelitian',
                'status' => 'aktif',
                'tanggal_mulai' => '2024-03-01',
                'tanggal_berakhir' => '2024-12-31',
                'pic' => 'Prof. Dr. Siti Nurhaliza',
                'deskripsi' => 'Proyek digitalisasi naskah kuno Nusantara untuk preservasi budaya.',
                'dokumen' => 'kontrak_ui_2024.pdf',
                'created_at' => '2024-02-25'
            ],
            [
                'id' => 3,
                'judul' => 'Program Literasi Digital ASEAN',
                'instansi' => 'ASEAN Foundation',
                'jenis' => 'Pelatihan',
                'status' => 'selesai',
                'tanggal_mulai' => '2023-06-01',
                'tanggal_berakhir' => '2023-12-31',
                'pic' => 'Drs. Bambang Wijaya',
                'deskripsi' => 'Program pelatihan literasi digital untuk pustakawan ASEAN.',
                'dokumen' => 'laporan_asean_2023.pdf',
                'created_at' => '2023-05-15'
            ],
            [
                'id' => 4,
                'judul' => 'Kerjasama Perpustakaan Digital ASEAN',
                'instansi' => 'Perpustakaan Nasional Malaysia',
                'jenis' => 'Digitalisasi',
                'status' => 'pending',
                'tanggal_mulai' => '2024-08-01',
                'tanggal_berakhir' => '2025-07-31',
                'pic' => 'Dr. Rina Sari',
                'deskripsi' => 'Pengembangan perpustakaan digital bersama negara-negara ASEAN.',
                'dokumen' => 'proposal_malaysia_2024.pdf',
                'created_at' => '2024-06-20'
            ]
        ];

        $data = [
            'kerjasama' => $kerjasama,
            'total_kerjasama' => count($kerjasama),
            'aktif' => count(array_filter($kerjasama, fn($k) => $k['status'] === 'aktif')),
            'selesai' => count(array_filter($kerjasama, fn($k) => $k['status'] === 'selesai')),
            'pending' => count(array_filter($kerjasama, fn($k) => $k['status'] === 'pending'))
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
            'judul' => [
                'label' => 'Judul Kerjasama',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 5 karakter'
                ]
            ],
            'instansi' => [
                'label' => 'Instansi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'jenis' => [
                'label' => 'Jenis Kerjasama',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus dipilih'
                ]
            ],
            'tanggal_mulai' => [
                'label' => 'Tanggal Mulai',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_date' => '{field} harus berupa tanggal yang valid'
                ]
            ],
            'tanggal_berakhir' => [
                'label' => 'Tanggal Berakhir',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_date' => '{field} harus berupa tanggal yang valid'
                ]
            ],
            'pic' => [
                'label' => 'PIC',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
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

        // Validate date range
        $tanggalMulai = $this->request->getPost('tanggal_mulai');
        $tanggalBerakhir = $this->request->getPost('tanggal_berakhir');
        
        if (strtotime($tanggalBerakhir) <= strtotime($tanggalMulai)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tanggal berakhir harus setelah tanggal mulai'
            ]);
        }

        // Handle file upload if exists
        $dokumen = $this->request->getFile('dokumen');
        $namaDokumen = null;

        if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
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
                $namaDokumen = null;
            }
        }

        // Get form data
        $data = [
            'judul' => $this->request->getPost('judul'),
            'instansi' => $this->request->getPost('instansi'),
            'jenis' => $this->request->getPost('jenis'),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_berakhir' => $tanggalBerakhir,
            'pic' => $this->request->getPost('pic'),
            'status' => $this->request->getPost('status') ?: 'pending',
            'deskripsi' => $this->request->getPost('deskripsi'),
            'dokumen' => $namaDokumen,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => session()->get('username')
        ];

        // In real implementation, save to database
        // $kerjasamaModel = new KerjasamaModel();
        // $kerjasamaModel->insert($data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Kerjasama berhasil ditambahkan'
        ]);
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

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'judul' => [
                'label' => 'Judul Kerjasama',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 5 karakter'
                ]
            ],
            'instansi' => [
                'label' => 'Instansi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'jenis' => [
                'label' => 'Jenis Kerjasama',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus dipilih'
                ]
            ],
            'tanggal_mulai' => [
                'label' => 'Tanggal Mulai',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_date' => '{field} harus berupa tanggal yang valid'
                ]
            ],
            'tanggal_berakhir' => [
                'label' => 'Tanggal Berakhir',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_date' => '{field} harus berupa tanggal yang valid'
                ]
            ],
            'pic' => [
                'label' => 'PIC',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
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

        // Validate date range
        $tanggalMulai = $this->request->getPost('tanggal_mulai');
        $tanggalBerakhir = $this->request->getPost('tanggal_berakhir');
        
        if (strtotime($tanggalBerakhir) <= strtotime($tanggalMulai)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tanggal berakhir harus setelah tanggal mulai'
            ]);
        }

        // Get form data
        $data = [
            'judul' => $this->request->getPost('judul'),
            'instansi' => $this->request->getPost('instansi'),
            'jenis' => $this->request->getPost('jenis'),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_berakhir' => $tanggalBerakhir,
            'pic' => $this->request->getPost('pic'),
            'status' => $this->request->getPost('status'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => session()->get('username')
        ];

        // In real implementation, update database
        // $kerjasamaModel = new KerjasamaModel();
        // $kerjasamaModel->update($id, $data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Kerjasama berhasil diperbarui'
        ]);
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

        // In real implementation, check if kerjasama exists and delete
        // $kerjasamaModel = new KerjasamaModel();
        // $kerjasama = $kerjasamaModel->find($id);
        // 
        // if (!$kerjasama) {
        //     return $this->response->setJSON([
        //         'success' => false,
        //         'message' => 'Kerjasama tidak ditemukan'
        //     ]);
        // }
        // 
        // // Delete file if exists
        // if ($kerjasama['dokumen']) {
        //     $filePath = ROOTPATH . 'public/uploads/kerjasama/' . $kerjasama['dokumen'];
        //     if (file_exists($filePath)) {
        //         unlink($filePath);
        //     }
        // }
        // 
        // $kerjasamaModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Kerjasama berhasil dihapus'
        ]);
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

        // Sample data for demo - in real implementation, get from database
        $kerjasama = [
            'id' => $id,
            'judul' => 'Kerjasama dengan Perpustakaan Nasional Singapura',
            'instansi' => 'National Library of Singapore',
            'jenis' => 'Pertukaran Koleksi',
            'status' => 'aktif',
            'tanggal_mulai' => '2024-01-15',
            'tanggal_berakhir' => '2025-01-15',
            'pic' => 'Dr. Ahmad Susanto',
            'deskripsi' => 'Program pertukaran buku dan publikasi ilmiah antara Indonesia dan Singapura.',
            'dokumen' => 'mou_singapore_2024.pdf',
            'created_at' => '2024-01-10'
        ];

        return $this->response->setJSON([
            'success' => true,
            'data' => $kerjasama
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

        // In real implementation, get data from database and export
        // $kerjasamaModel = new KerjasamaModel();
        // $builder = $kerjasamaModel->builder();
        // 
        // if ($status) {
        //     $builder->where('status', $status);
        // }
        // 
        // $data = $builder->get()->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'message' => "Data kerjasama berhasil diekspor dalam format {$format}",
            'download_url' => base_url("exports/kerjasama_" . date('Y-m-d') . ".{$format}")
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

        // Sample statistics data
        $stats = [
            'total_kerjasama' => 15,
            'aktif' => 8,
            'selesai' => 5,
            'pending' => 2,
            'kerjasama_bulan_ini' => 3,
            'kerjasama_berakhir_bulan_ini' => 1
        ];

        // Sample chart data
        $chartData = [
            'monthly_progress' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'datasets' => [
                    [
                        'label' => 'Kerjasama Baru',
                        'data' => [2, 1, 3, 2, 4, 3],
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'borderColor' => 'rgba(54, 162, 235, 1)'
                    ],
                    [
                        'label' => 'Kerjasama Selesai',
                        'data' => [1, 2, 1, 3, 2, 1],
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderColor' => 'rgba(255, 99, 132, 1)'
                    ]
                ]
            ],
            'status_distribution' => [
                'labels' => ['Aktif', 'Selesai', 'Pending'],
                'datasets' => [
                    [
                        'data' => [8, 5, 2],
                        'backgroundColor' => ['#28a745', '#007bff', '#ffc107']
                    ]
                ]
            ]
        ];

        $data = [
            'stats' => $stats,
            'chartData' => $chartData,
            'recent_kerjasama' => [
                [
                    'judul' => 'Kerjasama Digital Library ASEAN',
                    'instansi' => 'ASEAN Foundation',
                    'status' => 'aktif',
                    'tanggal_mulai' => '2024-06-01'
                ],
                [
                    'judul' => 'Program Literasi Indonesia',
                    'instansi' => 'Kemendikbud',
                    'status' => 'pending',
                    'tanggal_mulai' => '2024-07-15'
                ]
            ]
        ];

        return view('admin/kerjasama_dashboard', $data);
    }
}