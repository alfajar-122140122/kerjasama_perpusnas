<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PermohonanKerjasamaModel;
use App\Models\UserModel;

class PermohonanController extends BaseController
{
    protected $session;
    protected $permohonanModel;
    protected $userModel;
    
    public function __construct()
    {
        $this->session = session();
        $this->permohonanModel = new PermohonanKerjasamaModel();
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
        
        // Check if this is an AJAX request
        if ($this->request->isAJAX()) {
            $data = [
                'status' => true,
                'data' => $this->permohonanModel->orderBy('tanggal_pengajuan', 'DESC')->findAll(),
                'summary' => $this->permohonanModel->getStatusSummary()
            ];
            
            return $this->response->setJSON($data);
        }
        
        $data = [
            'title' => 'Permohonan Kerja Sama',
            'summary' => $this->permohonanModel->getStatusSummary(),
            'permohonan' => $this->permohonanModel->orderBy('tanggal_pengajuan', 'DESC')->findAll()
        ];
        
        return view('admin/permohonan/index', $data);
    }
    
    public function pending()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $data = [
            'title' => 'Permohonan Kerja Sama - Pending',
            'summary' => $this->permohonanModel->getStatusSummary(),
            'permohonan' => $this->permohonanModel->where('status', 'pending')->orderBy('tanggal_pengajuan', 'DESC')->findAll()
        ];
        
        return view('admin/permohonan/index', $data);
    }
    
    public function review()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $data = [
            'title' => 'Permohonan Kerja Sama - Review',
            'summary' => $this->permohonanModel->getStatusSummary(),
            'permohonan' => $this->permohonanModel->where('status', 'review')->orderBy('tanggal_pengajuan', 'DESC')->findAll()
        ];
        
        return view('admin/permohonan/index', $data);
    }
    
    public function approved()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $data = [
            'title' => 'Permohonan Kerja Sama - Disetujui',
            'summary' => $this->permohonanModel->getStatusSummary(),
            'permohonan' => $this->permohonanModel->where('status', 'approved')->orderBy('tanggal_pengajuan', 'DESC')->findAll()
        ];
        
        return view('admin/permohonan/index', $data);
    }
    
    public function rejected()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $data = [
            'title' => 'Permohonan Kerja Sama - Ditolak',
            'summary' => $this->permohonanModel->getStatusSummary(),
            'permohonan' => $this->permohonanModel->where('status', 'rejected')->orderBy('tanggal_pengajuan', 'DESC')->findAll()
        ];
        
        return view('admin/permohonan/index', $data);
    }
    
    public function view($id)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $permohonan = $this->permohonanModel->find($id);
        
        if (!$permohonan) {
            return redirect()->to('admin/permohonan')->with('error', 'Permohonan tidak ditemukan');
        }
        
        // Get reviewer name if exists
        if (!empty($permohonan['reviewed_by'])) {
            $reviewer = $this->userModel->find($permohonan['reviewed_by']);
            $permohonan['reviewer_name'] = $reviewer ? $reviewer['name'] : 'Unknown';
        } else {
            $permohonan['reviewer_name'] = '-';
        }
        
        $data = [
            'title' => 'Detail Permohonan',
            'permohonan' => $permohonan
        ];
        
        return view('admin/permohonan/view', $data);
    }
    
    public function updateStatus()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Check if this is an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Invalid request method'
            ]);
        }
        
        // Validate input
        $rules = [
            'id' => 'required|numeric',
            'status' => 'required|in_list[pending,review,approved,rejected]',
            'catatan' => 'permit_empty'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');
        $reviewedBy = $this->session->get('user_id');
        
        // Check if permohonan exists
        $permohonan = $this->permohonanModel->find($id);
        if (!$permohonan) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Permohonan tidak ditemukan'
            ]);
        }
        
        // Update status
        try {
            $this->permohonanModel->updateStatus($id, $status, $catatan, $reviewedBy);
            
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Status permohonan berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal memperbarui status permohonan: ' . $e->getMessage()
            ]);
        }
    }
    
    public function delete()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Check if this is an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Invalid request method'
            ]);
        }
        
        $id = $this->request->getPost('id');
        
        // Check if permohonan exists
        $permohonan = $this->permohonanModel->find($id);
        if (!$permohonan) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Permohonan tidak ditemukan'
            ]);
        }
        
        // Delete formulir file if exists
        if (!empty($permohonan['file_formulir'])) {
            $filePath = FCPATH . 'uploads/formulir/' . $permohonan['file_formulir'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Delete permohonan
        try {
            $this->permohonanModel->delete($id);
            
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Permohonan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal menghapus permohonan: ' . $e->getMessage()
            ]);
        }
    }
}
