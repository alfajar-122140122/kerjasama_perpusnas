<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Berita extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = session();
        helper(['url', 'form']);
    }
    
    // Middleware check untuk semua method berita
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
     * Halaman utama manajemen berita
     */
    public function index()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        // Sample berita data
        $berita = [
            [
                'id' => 1,
                'judul' => 'Perpustakaan Nasional Luncurkan Program Digitalisasi Massal',
                'slug' => 'perpustakaan-nasional-luncurkan-program-digitalisasi-massal',
                'kategori' => 'Program',
                'status' => 'published',
                'tanggal_publish' => '2024-06-15',
                'penulis' => 'Admin Perpusnas',
                'ringkasan' => 'Perpustakaan Nasional meluncurkan program digitalisasi massal untuk melestarikan warisan budaya Indonesia dalam bentuk digital.',
                'konten' => 'Jakarta - Perpustakaan Nasional Republik Indonesia resmi meluncurkan program digitalisasi massal yang bertujuan untuk melestarikan warisan budaya bangsa dalam bentuk digital. Program ini merupakan bagian dari upaya modernisasi perpustakaan nasional.',
                'gambar' => 'berita_digitalisasi_2024.jpg',
                'tags' => 'digitalisasi, perpustakaan, warisan budaya',
                'views' => 1250,
                'created_at' => '2024-06-10',
                'updated_at' => '2024-06-15'
            ],
            [
                'id' => 2,
                'judul' => 'Kerjasama Internasional dengan Perpustakaan Nasional Singapura',
                'slug' => 'kerjasama-internasional-dengan-perpustakaan-nasional-singapura',
                'kategori' => 'Kerjasama',
                'status' => 'published',
                'tanggal_publish' => '2024-06-10',
                'penulis' => 'Admin Perpusnas',
                'ringkasan' => 'Penandatanganan MoU kerjasama antara Perpustakaan Nasional RI dengan National Library of Singapore untuk pertukaran koleksi dan program literasi.',
                'konten' => 'Jakarta - Dalam upaya meningkatkan kerjasama regional, Perpustakaan Nasional RI menandatangani Memorandum of Understanding (MoU) dengan National Library of Singapore. Kerjasama ini mencakup pertukaran koleksi, program pelatihan pustakawan, dan pengembangan teknologi informasi perpustakaan.',
                'gambar' => 'berita_singapore_2024.jpg',
                'tags' => 'kerjasama, singapore, MoU',
                'views' => 980,
                'created_at' => '2024-06-08',
                'updated_at' => '2024-06-10'
            ],
            [
                'id' => 3,
                'judul' => 'Workshop Literasi Digital untuk Pustakawan Seluruh Indonesia',
                'slug' => 'workshop-literasi-digital-untuk-pustakawan-seluruh-indonesia',
                'kategori' => 'Pelatihan',
                'status' => 'draft',
                'tanggal_publish' => '2024-07-01',
                'penulis' => 'Admin Perpusnas',
                'ringkasan' => 'Perpustakaan Nasional mengadakan workshop literasi digital untuk meningkatkan kemampuan pustakawan dalam era digital.',
                'konten' => 'Jakarta - Sebagai bagian dari program pengembangan SDM perpustakaan, Perpustakaan Nasional akan mengadakan workshop literasi digital yang diikuti oleh pustakawan dari seluruh Indonesia. Workshop ini bertujuan untuk meningkatkan kemampuan pustakawan dalam mengelola informasi digital.',
                'gambar' => 'berita_workshop_2024.jpg',
                'tags' => 'workshop, literasi digital, pelatihan',
                'views' => 0,
                'created_at' => '2024-06-20',
                'updated_at' => '2024-06-20'
            ],
            [
                'id' => 4,
                'judul' => 'Peluncuran Aplikasi Mobile Perpustakaan Digital',
                'slug' => 'peluncuran-aplikasi-mobile-perpustakaan-digital',
                'kategori' => 'Teknologi',
                'status' => 'published',
                'tanggal_publish' => '2024-05-25',
                'penulis' => 'Admin Perpusnas',
                'ringkasan' => 'Perpustakaan Nasional meluncurkan aplikasi mobile untuk memudahkan akses masyarakat terhadap koleksi digital perpustakaan.',
                'konten' => 'Jakarta - Perpustakaan Nasional meluncurkan aplikasi mobile "PerpusNas Digital" yang memungkinkan masyarakat mengakses ribuan koleksi digital perpustakaan melalui smartphone. Aplikasi ini tersedia gratis di Google Play Store dan App Store.',
                'gambar' => 'berita_mobile_app_2024.jpg',
                'tags' => 'aplikasi mobile, digital, teknologi',
                'views' => 2100,
                'created_at' => '2024-05-20',
                'updated_at' => '2024-05-25'
            ]
        ];

        $data = [
            'berita' => $berita,
            'total_berita' => count($berita),
            'published' => count(array_filter($berita, fn($b) => $b['status'] === 'published')),
            'draft' => count(array_filter($berita, fn($b) => $b['status'] === 'draft')),
            'total_views' => array_sum(array_column($berita, 'views'))
        ];

        return view('admin/berita', $data);
    }

    /**
     * Tambah berita baru
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
                'label' => 'Judul Berita',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 5 karakter'
                ]
            ],
            'kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus dipilih'
                ]
            ],
            'ringkasan' => [
                'label' => 'Ringkasan',
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 10 karakter'
                ]
            ],
            'konten' => [
                'label' => 'Konten',
                'rules' => 'required|min_length[50]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 50 karakter'
                ]
            ],
            'penulis' => [
                'label' => 'Penulis',
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

        // Handle image upload if exists
        $gambar = $this->request->getFile('gambar');
        $namaGambar = null;

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaGambar = $gambar->getRandomName();
            
            // Create directory if not exists
            $uploadPath = ROOTPATH . 'public/uploads/berita/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Move file
            try {
                $gambar->move($uploadPath, $namaGambar);
            } catch (\Exception $e) {
                log_message('error', 'Image upload error: ' . $e->getMessage());
                $namaGambar = null;
            }
        }

        // Generate slug
        $slug = url_title($this->request->getPost('judul'), '-', true);

        // Get form data
        $data = [
            'judul' => $this->request->getPost('judul'),
            'slug' => $slug,
            'kategori' => $this->request->getPost('kategori'),
            'ringkasan' => $this->request->getPost('ringkasan'),
            'konten' => $this->request->getPost('konten'),
            'penulis' => $this->request->getPost('penulis'),
            'status' => $this->request->getPost('status') ?: 'draft',
            'tanggal_publish' => $this->request->getPost('tanggal_publish') ?: date('Y-m-d'),
            'tags' => $this->request->getPost('tags'),
            'gambar' => $namaGambar,
            'views' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => session()->get('username')
        ];

        // In real implementation, save to database
        // $beritaModel = new BeritaModel();
        // $beritaModel->insert($data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berita berhasil ditambahkan'
        ]);
    }

    /**
     * Update berita
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
                'message' => 'ID berita tidak valid'
            ]);
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'judul' => [
                'label' => 'Judul Berita',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 5 karakter'
                ]
            ],
            'kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus dipilih'
                ]
            ],
            'ringkasan' => [
                'label' => 'Ringkasan',
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 10 karakter'
                ]
            ],
            'konten' => [
                'label' => 'Konten',
                'rules' => 'required|min_length[50]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 50 karakter'
                ]
            ],
            'penulis' => [
                'label' => 'Penulis',
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

        // Generate slug
        $slug = url_title($this->request->getPost('judul'), '-', true);

        // Get form data
        $data = [
            'judul' => $this->request->getPost('judul'),
            'slug' => $slug,
            'kategori' => $this->request->getPost('kategori'),
            'ringkasan' => $this->request->getPost('ringkasan'),
            'konten' => $this->request->getPost('konten'),
            'penulis' => $this->request->getPost('penulis'),
            'status' => $this->request->getPost('status'),
            'tanggal_publish' => $this->request->getPost('tanggal_publish'),
            'tags' => $this->request->getPost('tags'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => session()->get('username')
        ];

        // In real implementation, update database
        // $beritaModel = new BeritaModel();
        // $beritaModel->update($id, $data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berita berhasil diperbarui'
        ]);
    }

    /**
     * Hapus berita
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
                'message' => 'ID berita tidak valid'
            ]);
        }

        // In real implementation, check if berita exists and delete
        // $beritaModel = new BeritaModel();
        // $berita = $beritaModel->find($id);
        // 
        // if (!$berita) {
        //     return $this->response->setJSON([
        //         'success' => false,
        //         'message' => 'Berita tidak ditemukan'
        //     ]);
        // }
        // 
        // // Delete image if exists
        // if ($berita['gambar']) {
        //     $filePath = ROOTPATH . 'public/uploads/berita/' . $berita['gambar'];
        //     if (file_exists($filePath)) {
        //         unlink($filePath);
        //     }
        // }
        // 
        // $beritaModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berita berhasil dihapus'
        ]);
    }

    /**
     * Get detail berita untuk modal view
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
                'message' => 'ID berita tidak valid'
            ]);
        }

        // Sample data for demo - in real implementation, get from database
        $berita = [
            'id' => $id,
            'judul' => 'Perpustakaan Nasional Luncurkan Program Digitalisasi Massal',
            'slug' => 'perpustakaan-nasional-luncurkan-program-digitalisasi-massal',
            'kategori' => 'Program',
            'status' => 'published',
            'tanggal_publish' => '2024-06-15',
            'penulis' => 'Admin Perpusnas',
            'ringkasan' => 'Perpustakaan Nasional meluncurkan program digitalisasi massal untuk melestarikan warisan budaya Indonesia dalam bentuk digital.',
            'konten' => 'Jakarta - Perpustakaan Nasional Republik Indonesia resmi meluncurkan program digitalisasi massal yang bertujuan untuk melestarikan warisan budaya bangsa dalam bentuk digital.',
            'gambar' => 'berita_digitalisasi_2024.jpg',
            'tags' => 'digitalisasi, perpustakaan, warisan budaya',
            'views' => 1250,
            'created_at' => '2024-06-10'
        ];

        return $this->response->setJSON([
            'success' => true,
            'data' => $berita
        ]);
    }

    /**
     * Publish/Unpublish berita
     */
    public function toggleStatus($id = null)
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
                'message' => 'ID berita tidak valid'
            ]);
        }

        $newStatus = $this->request->getPost('status');
        
        if (!in_array($newStatus, ['published', 'draft'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Status tidak valid'
            ]);
        }

        // In real implementation, update status in database
        // $beritaModel = new BeritaModel();
        // $beritaModel->update($id, [
        //     'status' => $newStatus,
        //     'tanggal_publish' => $newStatus === 'published' ? date('Y-m-d') : null,
        //     'updated_at' => date('Y-m-d H:i:s')
        // ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status berita berhasil diubah menjadi ' . $newStatus
        ]);
    }
}