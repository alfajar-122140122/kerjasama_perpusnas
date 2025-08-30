<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProgressKerjasamaModel;

class ProgressKerjasamaController extends BaseController
{
    protected $progressKerjasamaModel;
    protected $helpers = ['form', 'security'];
    
    public function __construct()
    {
        $this->progressKerjasamaModel = new ProgressKerjasamaModel();
    }
    
    public function index()
    {
        $progressData = $this->progressKerjasamaModel->orderBy('tanggal_pengajuan', 'DESC')->findAll();
        
        $data = [
            'title' => 'Progress Kerjasama',
            'progressData' => $progressData
        ];
        
        return view('admin/kerjasama/progress', $data);
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
    
    public function store()
    {
        // Batasi akses tambah progress manual
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Tambah progress kerjasama hanya bisa dilakukan melalui validasi permohonan oleh admin.'
        ]);
    }
    
    public function update($id)
    {
        // Log the raw input for debugging
        log_message('debug', 'Update Progress ID: ' . $id);
        log_message('debug', 'Update Progress Input: ' . json_encode($this->request->getPost()));
        
        // Validasi input sesuai skema database
        $rules = [
            'lembaga' => 'required',
            'tanggal_pengajuan' => 'required|valid_date',
            'jenis' => 'required',
            'status' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            log_message('error', 'Validation Failed: ' . json_encode($this->validator->getErrors()));
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        // Check if record exists
        $progress = $this->progressKerjasamaModel->find($id);
        if (!$progress) {
            log_message('error', 'Record not found with ID: ' . $id);
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data progress kerjasama tidak ditemukan'
            ]);
        }
        
        // Prepare data untuk update
        $data = [
            'tanggal_pengajuan' => $this->request->getPost('tanggal_pengajuan'),
            'lembaga' => $this->request->getPost('lembaga'),
            'jenis' => $this->request->getPost('jenis'),
            'status' => $this->request->getPost('status')
        ];
        
        try {
            // Update data directly in database
            $result = $this->progressKerjasamaModel->db->table('progress_kerjasama')
                ->where('id', $id)
                ->update($data);
            
            if ($result) {
                // Get updated data for response
                $updatedData = $this->progressKerjasamaModel->find($id);
                
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data progress kerjasama berhasil diperbarui',
                    'data' => $updatedData
                ]);
            } else {
                log_message('error', 'Update Failed: Database error');
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal memperbarui data progress kerjasama',
                    'errors' => $this->progressKerjasamaModel->db->error()
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function delete($id)
    {
        try {
            log_message('debug', 'Delete Progress ID: ' . $id);
            
            // Check if record exists
            $progress = $this->progressKerjasamaModel->find($id);
            if (!$progress) {
                log_message('error', 'Delete Failed: Record not found with ID: ' . $id);
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data progress kerjasama tidak ditemukan'
                ]);
            }
            
            // Delete data directly from database
            $result = $this->progressKerjasamaModel->db->table('progress_kerjasama')
                ->where('id', $id)
                ->delete();
            
            if ($result) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data progress kerjasama berhasil dihapus',
                    'id' => $id
                ]);
            } else {
                log_message('error', 'Delete Failed: Database error');
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menghapus data progress kerjasama',
                    'errors' => $this->progressKerjasamaModel->db->error()
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in delete: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
