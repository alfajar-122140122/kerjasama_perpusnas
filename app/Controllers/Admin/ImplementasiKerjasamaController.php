<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ImplementasiKerjasamaModel;
use App\Models\KerjasamaModel;

class ImplementasiKerjasamaController extends BaseController
{
    protected $implementasiModel;
    protected $kerjasamaModel;

    public function __construct()
    {
        $this->implementasiModel = new ImplementasiKerjasamaModel();
        $this->kerjasamaModel = new KerjasamaModel();
    }

    public function index()
    {
        // Mendapatkan data implementasi dengan join ke tabel kerjasama
        $implementasiData = $this->implementasiModel->getImplementasiWithKerjasama();

        $data = [
            'title' => 'Implementasi Kerjasama',
            'implementasiData' => $implementasiData
        ];

        return view('admin/kerjasama/implementasi', $data);
    }

    public function store()
    {
        // Validation rules
        $rules = [
            'kerjasama_id' => 'required|integer|is_not_unique[kerjasama.id]',
            'implementasi' => 'required|min_length[10]|max_length[1000]',
            'lingkup' => 'required|min_length[3]|max_length[100]'
        ];

        $messages = [
            'kerjasama_id' => [
                'required' => 'Silakan pilih mitra kerjasama',
                'integer' => 'ID kerjasama tidak valid',
                'is_not_unique' => 'Mitra kerjasama tidak ditemukan'
            ],
            'implementasi' => [
                'required' => 'Deskripsi implementasi harus diisi',
                'min_length' => 'Deskripsi implementasi minimal 10 karakter',
                'max_length' => 'Deskripsi implementasi maksimal 1000 karakter'
            ],
            'lingkup' => [
                'required' => 'Lingkup implementasi harus diisi',
                'min_length' => 'Lingkup implementasi minimal 3 karakter',
                'max_length' => 'Lingkup implementasi maksimal 100 karakter'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $this->validator->getErrors()
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            // Get kerjasama data to ensure consistency of masa_berlaku
            $kerjasamaId = $this->request->getPost('kerjasama_id');
            $masaBerlaku = $this->kerjasamaModel->getMasaBerlaku($kerjasamaId);
            
            if (!$masaBerlaku) {
                throw new \Exception('Data kerjasama tidak ditemukan atau tidak valid');
            }
            
            // Data to be inserted
            $insertData = [
                'kerjasama_id' => $kerjasamaId,
                'implementasi' => $this->request->getPost('implementasi'),
                'lingkup' => $this->request->getPost('lingkup'),
                'masa_berlaku' => $masaBerlaku, // Use calculated value from kerjasama data
                'created_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->implementasiModel->insert($insertData);

            if ($result) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'status' => true,
                        'message' => 'Data implementasi berhasil ditambahkan'
                    ]);
                }
                return redirect()->to('/admin/kerjasama/implementasi')->with('success', 'Data implementasi berhasil ditambahkan');
            } else {
                throw new \Exception('Gagal menyimpan data');
            }
        } catch (\Exception $e) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menyimpan data: ' . $e->getMessage()
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function get($id)
    {
        try {
            $implementasi = $this->implementasiModel->getImplementasiWithKerjasama($id);

            if (!$implementasi) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data implementasi tidak ditemukan'
                ]);
            }

            return $this->response->setJSON([
                'status' => true,
                'data' => $implementasi
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ]);
        }
    }

    public function update($id)
    {
        // Validation rules
        $rules = [
            'kerjasama_id' => 'required|integer|is_not_unique[kerjasama.id]',
            'implementasi' => 'required|min_length[10]|max_length[1000]',
            'lingkup' => 'required|min_length[3]|max_length[100]'
        ];

        $messages = [
            'kerjasama_id' => [
                'required' => 'Silakan pilih mitra kerjasama',
                'integer' => 'ID kerjasama tidak valid',
                'is_not_unique' => 'Mitra kerjasama tidak ditemukan'
            ],
            'implementasi' => [
                'required' => 'Deskripsi implementasi harus diisi',
                'min_length' => 'Deskripsi implementasi minimal 10 karakter',
                'max_length' => 'Deskripsi implementasi maksimal 1000 karakter'
            ],
            'lingkup' => [
                'required' => 'Lingkup implementasi harus diisi',
                'min_length' => 'Lingkup implementasi minimal 3 karakter',
                'max_length' => 'Lingkup implementasi maksimal 100 karakter'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $this->validator->getErrors()
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            // Check if data exists
            $existingData = $this->implementasiModel->find($id);
            if (!$existingData) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'status' => false,
                        'message' => 'Data implementasi tidak ditemukan'
                    ]);
                }
                return redirect()->back()->with('error', 'Data implementasi tidak ditemukan');
            }

            // Get kerjasama data to ensure consistency of masa_berlaku
            $kerjasamaId = $this->request->getPost('kerjasama_id');
            $masaBerlaku = $this->kerjasamaModel->getMasaBerlaku($kerjasamaId);
            
            if (!$masaBerlaku) {
                throw new \Exception('Data kerjasama tidak ditemukan atau tidak valid');
            }

            // Data to be updated
            $updateData = [
                'kerjasama_id' => $kerjasamaId,
                'implementasi' => $this->request->getPost('implementasi'),
                'lingkup' => $this->request->getPost('lingkup'),
                'masa_berlaku' => $masaBerlaku, // Use calculated value from kerjasama data
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->implementasiModel->update($id, $updateData);

            if ($result) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'status' => true,
                        'message' => 'Data implementasi berhasil diperbarui'
                    ]);
                }
                return redirect()->to('/admin/kerjasama/implementasi')->with('success', 'Data implementasi berhasil diperbarui');
            } else {
                throw new \Exception('Gagal memperbarui data');
            }
        } catch (\Exception $e) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal memperbarui data: ' . $e->getMessage()
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Check if data exists
            $existingData = $this->implementasiModel->find($id);
            if (!$existingData) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'status' => false,
                        'message' => 'Data implementasi tidak ditemukan'
                    ]);
                }
                return redirect()->back()->with('error', 'Data implementasi tidak ditemukan');
            }

            $result = $this->implementasiModel->delete($id);

            if ($result) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'status' => true,
                        'message' => 'Data implementasi berhasil dihapus'
                    ]);
                }
                return redirect()->to('/admin/kerjasama/implementasi')->with('success', 'Data implementasi berhasil dihapus');
            } else {
                throw new \Exception('Gagal menghapus data');
            }
        } catch (\Exception $e) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ]);
            }
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
