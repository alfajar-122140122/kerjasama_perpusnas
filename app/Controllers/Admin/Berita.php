<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;

class Berita extends BaseController
{
    protected $session;
    protected $beritaModel;
    
    public function __construct()
    {
        $this->session = session();
        $this->beritaModel = new BeritaModel();
    }
    
    // Middleware check untuk semua method admin
    private function checkAuth()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu');
        }
        return null;
    }
    
    public function index()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        try {
            // Get all berita - in development, using sample data
            $berita = $this->getSampleBeritaData();
            
            $data = [
                'title' => 'Manajemen Berita',
                'berita' => $berita
            ];
            
            return view('admin/berita', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data berita: ' . $e->getMessage());
        }
    }
    
    public function create()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required|max_length[255]',
            'isi_berita' => 'required',
            'gambar' => 'permit_empty|uploaded[gambar]|is_image[gambar]|max_size[gambar,2048]',
            'status' => 'required|in_list[draft,published]',
            'tanggal_publikasi' => 'permit_empty|valid_date'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid: ' . implode(', ', $validation->getErrors()));
        }
        
        try {
            $data = [
                'judul' => $this->request->getPost('judul'),
                'isi_berita' => $this->request->getPost('isi_berita'),
                'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi') ?: date('Y-m-d H:i:s'),
                'created_by_user_id' => $this->session->get('user_id') ?? 1
            ];
            
            // Handle file upload
            $imageFile = $this->request->getFile('gambar');
            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                $newName = $imageFile->getRandomName();
                if ($imageFile->move(FCPATH . 'uploads/berita', $newName)) {
                    $data['gambar'] = $newName;
                }
            }
            
            // Save to database
            $this->beritaModel->save($data);
            
            return redirect()->to('/admin/berita')->with('success', 'Berita berhasil ditambahkan');
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan berita: ' . $e->getMessage());
        }
    }
    
    public function update($id)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Check if berita exists
        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->back()->with('error', 'Berita tidak ditemukan');
        }
        
        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required|max_length[255]',
            'isi_berita' => 'required',
            'gambar' => 'permit_empty|uploaded[gambar]|is_image[gambar]|max_size[gambar,2048]',
            'status' => 'required|in_list[draft,published]',
            'tanggal_publikasi' => 'permit_empty|valid_date'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid: ' . implode(', ', $validation->getErrors()));
        }
        
        try {
            $data = [
                'judul' => $this->request->getPost('judul'),
                'isi_berita' => $this->request->getPost('isi_berita'),
                'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi') ?: $berita['tanggal_publikasi']
            ];
            
            // Handle file upload
            $imageFile = $this->request->getFile('gambar');
            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                // Delete old image if exists
                if ($berita['gambar'] && file_exists(FCPATH . 'uploads/berita/' . $berita['gambar'])) {
                    unlink(FCPATH . 'uploads/berita/' . $berita['gambar']);
                }
                
                $newName = $imageFile->getRandomName();
                if ($imageFile->move(FCPATH . 'uploads/berita', $newName)) {
                    $data['gambar'] = $newName;
                }
            }
            
            // Update database
            $this->beritaModel->update($id, $data);
            
            return redirect()->to('/admin/berita')->with('success', 'Berita berhasil diperbarui');
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui berita: ' . $e->getMessage());
        }
    }
    
    public function delete($id)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        try {
            $berita = $this->beritaModel->find($id);
            if (!$berita) {
                return redirect()->back()->with('error', 'Berita tidak ditemukan');
            }
            
            // Delete image file if exists
            if ($berita['gambar'] && file_exists(FCPATH . 'uploads/berita/' . $berita['gambar'])) {
                unlink(FCPATH . 'uploads/berita/' . $berita['gambar']);
            }
            
            // Delete from database
            $this->beritaModel->delete($id);
            
            return redirect()->to('/admin/berita')->with('success', 'Berita berhasil dihapus');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus berita: ' . $e->getMessage());
        }
    }
    
    // Sample data untuk development
    private function getSampleBeritaData()
    {
        return [
            [
                'id_berita' => 1,
                'judul' => 'Peluncuran Program Digitalisasi Perpustakaan Nasional 2025',
                'isi_berita' => 'Perpustakaan Nasional meluncurkan program digitalisasi besar-besaran untuk meningkatkan akses informasi bagi seluruh masyarakat Indonesia. Program ini diharapkan dapat mempermudah akses ke koleksi digital perpustakaan.',
                'gambar' => 'berita1.jpg',
                'tanggal_publikasi' => '2025-01-15 10:00:00',
                'created_by_user_id' => 1,
                'created_at' => '2025-01-15 09:30:00',
                'updated_at' => '2025-01-15 09:30:00',
                'status' => 'published'
            ],
            [
                'id_berita' => 2,
                'judul' => 'Kerjasama Perpustakaan Nasional dengan Universitas Terkemuka',
                'isi_berita' => 'Perpustakaan Nasional menjalin kerjasama strategis dengan berbagai universitas terkemuka untuk meningkatkan literasi dan akses informasi akademik di Indonesia.',
                'gambar' => 'berita2.jpg',
                'tanggal_publikasi' => '2025-01-10 14:30:00',
                'created_by_user_id' => 1,
                'created_at' => '2025-01-10 14:00:00',
                'updated_at' => '2025-01-10 14:00:00',
                'status' => 'published'
            ],
            [
                'id_berita' => 3,
                'judul' => 'Workshop Literasi Digital untuk Masyarakat',
                'isi_berita' => 'Perpustakaan Nasional mengadakan workshop literasi digital gratis untuk meningkatkan kemampuan masyarakat dalam menggunakan teknologi informasi dan komunikasi.',
                'gambar' => null,
                'tanggal_publikasi' => null,
                'created_by_user_id' => 1,
                'created_at' => '2025-01-05 16:00:00',
                'updated_at' => '2025-01-05 16:00:00',
                'status' => 'draft'
            ]
        ];
    }
}
