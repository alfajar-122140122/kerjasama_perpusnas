<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Models\PermohonanKerjasamaModel;

class PermohonanController extends BaseController
{
    protected $permohonanModel;
    
    public function __construct()
    {
        $this->permohonanModel = new PermohonanKerjasamaModel();
    }
    
    public function index()
    {
        $data = [
            'page_title' => 'Permohonan Kerja Sama',
            'meta_description' => 'Form pengajuan permohonan kerja sama dengan Perpustakaan Nasional Republik Indonesia'
        ];
        
        return view('public/kerjasama/pengajuan', $data);
    }
    
    public function submit()
    {
        // Check if this is an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Invalid request method'
            ]);
        }
        
        // Validate the form
        $rules = [
            'jenis_permohonan' => 'required|in_list[baru,perpanjangan]',
            'lembaga' => 'required|max_length[255]',
            'alamat' => 'required',
            'telp' => 'required|max_length[50]',
            'email' => 'required|valid_email|max_length[255]',
            'kontak' => 'required',
            'formulir' => 'uploaded[formulir]|max_size[formulir,5120]|ext_in[formulir,pdf,doc,docx]',
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        // Handle file upload
        $file = $this->request->getFile('formulir');
        $newName = $file->getRandomName();
        
        // Create the uploads directory if it doesn't exist
        $uploadPath = FCPATH . 'uploads/formulir';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        if (!$file->move($uploadPath, $newName)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Failed to upload file'
            ]);
        }
        
        // Prepare data for insert
        $data = [
            'jenis_permohonan' => $this->request->getPost('jenis_permohonan'),
            'lembaga' => $this->request->getPost('lembaga'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telp'),
            'email' => $this->request->getPost('email'),
            'kontak_dapat_dihubungi' => $this->request->getPost('kontak'),
            'file_formulir' => $newName,
            'tanggal_pengajuan' => date('Y-m-d H:i:s'),
            'status' => 'pending' // Set initial status to pending
        ];
        
        // Save to database
        try {
            $this->permohonanModel->insert($data);
            
            // Return success response
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Permohonan kerja sama telah berhasil dikirim'
            ]);
        } catch (\Exception $e) {
            // Log the error
            log_message('error', 'Error submitting permohonan: ' . $e->getMessage());
            
            // Return error response
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal menyimpan permohonan: ' . $e->getMessage()
            ]);
        }
    }
}
