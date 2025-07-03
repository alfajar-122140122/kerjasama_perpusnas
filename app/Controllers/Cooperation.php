<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CooperationModel;
use App\Models\PermohonanKerjasamaModel;
use App\Models\ImplementasiKerjasamaModel;

class Cooperation extends BaseController
{
    protected $cooperationModel;
    protected $permohonanModel;
    protected $implementasiModel;
    
    public function __construct()
    {
        $this->cooperationModel = new CooperationModel();
        $this->permohonanModel = new PermohonanKerjasamaModel();
        $this->implementasiModel = new ImplementasiKerjasamaModel();
        helper(['form', 'url']);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Kerja Sama',
            'active' => 'cooperation'
        ];
        
        return view('public/cooperation/index', $data);
    }
    
    public function dataCooperation()
    {
        $data = [
            'title' => 'Data Kerja Sama',
            'active' => 'data_cooperation',
            'kerjasama' => $this->cooperationModel->where('status', 'aktif')->findAll()
        ];
        
        return view('public/cooperation/data_cooperation', $data);
    }
    
    public function implementation()
    {
        $data = [
            'title' => 'Implementasi Kerja Sama',
            'active' => 'implementation',
            'implementasi' => $this->implementasiModel->orderBy('tanggal_kegiatan', 'DESC')->findAll()
        ];
        
        return view('public/cooperation/implementation_cooperation', $data);
    }
    
    public function expiring()
    {
        $data = [
            'title' => 'Kerja Sama Yang Akan Berakhir',
            'active' => 'expiring',
            'expiring' => $this->cooperationModel->getExpiringCooperation()
        ];
        
        return view('public/cooperation/expiring_cooperation', $data);
    }
    
    public function progress()
    {
        $data = [
            'title' => 'Progress Kerja Sama',
            'active' => 'progress',
            'progress' => $this->cooperationModel->getProgressData()
        ];
        
        return view('public/cooperation/progress_cooperation', $data);
    }
    
    public function submission()
    {
        $data = [
            'title' => 'Permohonan Kerja Sama',
            'active' => 'submission',
            'validation' => \Config\Services::validation()
        ];
        
        return view('public/cooperation/submission_form', $data);
    }
    
    public function submitProposal()
    {
        // Validate input
        $rules = [
            'nama_pengaju' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'telepon' => 'required|numeric',
            'nama_instansi' => 'required|min_length[3]',
            'alamat_instansi' => 'required',
            'jenis_kerjasama' => 'required',
            'deskripsi_kerjasama' => 'required|min_length[10]',
            'file_proposal' => 'uploaded[file_proposal]|max_size[file_proposal,10240]|ext_in[file_proposal,pdf]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Upload file proposal
        $file = $this->request->getFile('file_proposal');
        $fileName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/permohonan', $fileName);
        
        // Save permohonan data
        $this->permohonanModel->save([
            'nama_pengaju' => $this->request->getPost('nama_pengaju'),
            'email' => $this->request->getPost('email'),
            'telepon' => $this->request->getPost('telepon'),
            'nama_instansi' => $this->request->getPost('nama_instansi'),
            'alamat_instansi' => $this->request->getPost('alamat_instansi'),
            'jenis_kerjasama' => $this->request->getPost('jenis_kerjasama'),
            'deskripsi_kerjasama' => $this->request->getPost('deskripsi_kerjasama'),
            'file_proposal' => $fileName,
            'status' => 'baru',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('/cooperation/submission')->with('success', 'Permohonan Kerja Sama berhasil dikirim. Kami akan meninjau permohonan Anda segera.');
    }
}
