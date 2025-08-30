<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\UserModel;

class Berita extends BaseController
{
    protected $session;
    protected $beritaModel;
    protected $userModel;
    
    public function __construct()
    {
        $this->session = session();
        $this->beritaModel = new BeritaModel();
        $this->userModel = new UserModel();
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
            // Get pagination parameters
            $page = $this->request->getGet('page') ?? 1;
            $perPage = 10; // 10 items per page
            
            // Get total count for pagination
            $totalBerita = $this->beritaModel->countAllResults();
            
            // Calculate total pages
            $totalPages = ceil($totalBerita / $perPage);
            
            // Ensure valid page number
            $page = max(1, min($page, $totalPages));
            
            // Calculate offset
            $offset = ($page - 1) * $perPage;
            
            // Get berita data with pagination
            $berita = $this->beritaModel->orderBy('created_at', 'DESC')
                                       ->limit($perPage, $offset)
                                       ->findAll();
            
            // Calculate pagination info
            $paginationInfo = [
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'perPage' => $perPage,
                'totalItems' => $totalBerita,
                'startItem' => $totalBerita > 0 ? $offset + 1 : 0,
                'endItem' => min($offset + $perPage, $totalBerita)
            ];
            
            $data = [
                'title' => 'Manajemen Berita',
                'berita' => $berita,
                'pagination' => $paginationInfo
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
            'gambar' => 'permit_empty|is_image[gambar]|max_size[gambar,2048]',
            'status' => 'required|in_list[draft,published]',
            'tanggal_publikasi' => 'permit_empty'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data tidak valid: ' . implode(', ', $validation->getErrors())
            ]);
        }
        
        try {
            $tanggalPublikasi = $this->request->getPost('tanggal_publikasi');
            if (empty($tanggalPublikasi) && $this->request->getPost('status') === 'published') {
                $tanggalPublikasi = date('Y-m-d H:i:s');
            }
            
            $data = [
                'judul' => $this->request->getPost('judul'),
                'isi_berita' => $this->request->getPost('isi_berita'),
                'tanggal_publikasi' => $tanggalPublikasi,
                'created_by_user_id' => $this->session->get('user_id'),
                'status' => $this->request->getPost('status') ?: 'draft'
            ];
            
            // Handle file upload
            $imageFile = $this->request->getFile('gambar');
            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                // Create uploads directory if it doesn't exist
                $uploadPath = FCPATH . 'uploads/berita';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                $newName = $imageFile->getRandomName();
                if ($imageFile->move($uploadPath, $newName)) {
                    $data['gambar'] = $newName;
                }
            }
            
            // Save to database
            $this->beritaModel->save($data);
            
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Berita berhasil ditambahkan'
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal menambahkan berita: ' . $e->getMessage()
            ]);
        }
    }
    
    public function get($id)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        try {
            $berita = $this->beritaModel->find($id);
            if (!$berita) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Berita tidak ditemukan'
                ]);
            }
            
            // Get author name if possible
            $berita['author_name'] = '';
            if (!empty($berita['created_by_user_id'])) {
                $user = $this->userModel->find($berita['created_by_user_id']);
                if ($user) {
                    $berita['author_name'] = $user['name'] ?? $user['username'] ?? '';
                }
            }
            
            // Format dates for display
            $berita['formatted_created_at'] = !empty($berita['created_at']) ? date('d/m/Y H:i', strtotime($berita['created_at'])) : '-';
            $berita['formatted_updated_at'] = !empty($berita['updated_at']) ? date('d/m/Y H:i', strtotime($berita['updated_at'])) : '-';
            $berita['formatted_tanggal_publikasi'] = !empty($berita['tanggal_publikasi']) ? date('d/m/Y H:i', strtotime($berita['tanggal_publikasi'])) : '-';
            
            // ISO format for form inputs
            $berita['iso_tanggal_publikasi'] = !empty($berita['tanggal_publikasi']) ? date('Y-m-d\TH:i', strtotime($berita['tanggal_publikasi'])) : '';
            
            // Check if image exists
            if (!empty($berita['gambar'])) {
                $berita['image_exists'] = file_exists(FCPATH . 'uploads/berita/' . $berita['gambar']);
            } else {
                $berita['image_exists'] = false;
            }
            
            return $this->response->setJSON([
                'status' => true,
                'data' => $berita
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
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
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Berita tidak ditemukan'
            ]);
        }
        
        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required|max_length[255]',
            'isi_berita' => 'required',
            'gambar' => 'permit_empty|is_image[gambar]|max_size[gambar,2048]',
            'status' => 'required|in_list[draft,published]',
            'tanggal_publikasi' => 'permit_empty'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data tidak valid: ' . implode(', ', $validation->getErrors())
            ]);
        }
        
        try {
            // Handle status change: if changing from draft to published and no publication date is set
            $newStatus = $this->request->getPost('status');
            $tanggalPublikasi = $this->request->getPost('tanggal_publikasi');
            
            if ($berita['status'] === 'draft' && $newStatus === 'published' && (empty($tanggalPublikasi) && empty($berita['tanggal_publikasi']))) {
                $tanggalPublikasi = date('Y-m-d H:i:s');
            } else if (empty($tanggalPublikasi) && !empty($berita['tanggal_publikasi'])) {
                $tanggalPublikasi = $berita['tanggal_publikasi'];
            }
            
            $data = [
                'judul' => $this->request->getPost('judul'),
                'isi_berita' => $this->request->getPost('isi_berita'),
                'tanggal_publikasi' => $tanggalPublikasi,
                'status' => $newStatus
            ];
            
            // Handle file upload
            $imageFile = $this->request->getFile('gambar');
            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                // Create uploads directory if it doesn't exist
                $uploadPath = FCPATH . 'uploads/berita';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                // Delete old image if exists
                if ($berita['gambar'] && file_exists(FCPATH . 'uploads/berita/' . $berita['gambar'])) {
                    unlink(FCPATH . 'uploads/berita/' . $berita['gambar']);
                }
                
                $newName = $imageFile->getRandomName();
                if ($imageFile->move($uploadPath, $newName)) {
                    $data['gambar'] = $newName;
                }
            }
            
            // Update database
            $this->beritaModel->update($id, $data);
            
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Berita berhasil diperbarui'
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal memperbarui berita: ' . $e->getMessage()
            ]);
        }
    }
    
    public function delete($id)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        try {
            // Log the request method to help debug
            log_message('debug', 'Delete berita request method: ' . $this->request->getMethod());
            
            $berita = $this->beritaModel->find($id);
            if (!$berita) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Berita tidak ditemukan'
                ]);
            }
            
            // Delete image file if exists
            if ($berita['gambar'] && file_exists(FCPATH . 'uploads/berita/' . $berita['gambar'])) {
                try {
                    unlink(FCPATH . 'uploads/berita/' . $berita['gambar']);
                } catch (\Exception $e) {
                    // Just log the error, don't stop the deletion process
                    log_message('error', 'Error deleting image file: ' . $e->getMessage());
                }
            }
            
            // Delete from database
            if (!$this->beritaModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menghapus berita dari database'
                ]);
            }
            
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Berita berhasil dihapus'
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Error deleting berita: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal menghapus berita: ' . $e->getMessage()
            ]);
        }
    }
    
    public function changeStatus($id)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        try {
            $berita = $this->beritaModel->find($id);
            if (!$berita) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Berita tidak ditemukan'
                ]);
            }
            
            // Toggle status
            $newStatus = ($berita['status'] === 'published') ? 'draft' : 'published';
            
            // If changing to published and no publication date is set, set it to now
            $data = ['status' => $newStatus];
            if ($newStatus === 'published' && empty($berita['tanggal_publikasi'])) {
                $data['tanggal_publikasi'] = date('Y-m-d H:i:s');
            }
            
            // Update database
            $this->beritaModel->update($id, $data);
            
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Status berita berhasil diubah menjadi ' . 
                    ($newStatus === 'published' ? 'Published' : 'Draft')
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal mengubah status berita: ' . $e->getMessage()
            ]);
        }
    }
}
