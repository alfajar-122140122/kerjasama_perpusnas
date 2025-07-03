<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PermohonanKerjasamaModel;

class SubmissionManagement extends BaseController
{
    protected $session;
    protected $permohonanModel;
    
    public function __construct()
    {
        $this->session = session();
        $this->permohonanModel = new PermohonanKerjasamaModel();
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
            'title' => 'Manajemen Permohonan Kerjasama',
            'permohonan' => $this->permohonanModel->orderBy('created_at', 'DESC')->findAll()
        ];
        
        return view('admin/submission_view', $data);
    }
    
    public function view($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/submission-management')->with('error', 'ID Permohonan tidak ditemukan');
        }
        
        $permohonan = $this->permohonanModel->find($id);
        if (!$permohonan) {
            return redirect()->to('/admin/submission-management')->with('error', 'Data Permohonan tidak ditemukan');
        }
        
        $data = [
            'title' => 'Detail Permohonan Kerjasama',
            'permohonan' => $permohonan
        ];
        
        return view('admin/submission_view', $data);
    }
    
    public function updateStatus($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/submission-management')->with('error', 'ID Permohonan tidak ditemukan');
        }
        
        // Validate input
        $rules = [
            'status' => 'required|in_list[baru,diproses,diterima,ditolak]',
            'catatan' => 'permit_empty'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Update permohonan status
        $data = [
            'status' => $this->request->getPost('status'),
            'catatan_admin' => $this->request->getPost('catatan'),
            'updated_by' => $this->session->get('user_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->permohonanModel->update($id, $data);
        
        // If status is diterima (accepted), we could automatically create a new cooperation entry
        if ($this->request->getPost('status') === 'diterima' && $this->request->getPost('create_kerjasama') === 'yes') {
            $permohonan = $this->permohonanModel->find($id);
            
            // Create new kerjasama entry
            $kerjasamaModel = new \App\Models\CooperationModel();
            $kerjasamaModel->save([
                'judul' => 'Kerjasama dengan ' . $permohonan['nama_instansi'],
                'instansi' => $permohonan['nama_instansi'],
                'jenis' => $permohonan['jenis_kerjasama'],
                'status' => 'aktif',
                'tanggal_mulai' => date('Y-m-d'),
                'tanggal_berakhir' => date('Y-m-d', strtotime('+1 year')),
                'pic' => $permohonan['nama_pengaju'],
                'deskripsi' => $permohonan['deskripsi_kerjasama'],
                'file_kerjasama' => $permohonan['file_proposal'], // Use the uploaded proposal as initial document
                'created_from_submission' => $id,
                'created_by' => $this->session->get('user_id'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            // Update permohonan with the created kerjasama ID
            $this->permohonanModel->update($id, [
                'converted_to_kerjasama' => 1,
                'kerjasama_id' => $kerjasamaModel->getInsertID()
            ]);
            
            return redirect()->to('/admin/submission-management')->with('success', 'Status permohonan diperbarui dan data kerjasama baru berhasil dibuat');
        }
        
        return redirect()->to('/admin/submission-management')->with('success', 'Status permohonan berhasil diperbarui');
    }
    
    public function delete($id = null)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        if ($id === null) {
            return redirect()->to('/admin/submission-management')->with('error', 'ID Permohonan tidak ditemukan');
        }
        
        // Get permohonan data to delete file
        $permohonan = $this->permohonanModel->find($id);
        if ($permohonan && !empty($permohonan['file_proposal'])) {
            $filePath = WRITEPATH . 'uploads/permohonan/' . $permohonan['file_proposal'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Delete permohonan data
        $this->permohonanModel->delete($id);
        
        return redirect()->to('/admin/submission-management')->with('success', 'Permohonan Kerjasama berhasil dihapus');
    }
}
