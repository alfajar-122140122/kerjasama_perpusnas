<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KerjasamaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Kerjasama extends BaseController
{
    protected $kerjasamaModel;
    
    public function __construct()
    {
        $this->kerjasamaModel = new KerjasamaModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Manajemen Kerjasama',
            'kerjasama' => $this->kerjasamaModel->findAll()
        ];
        
        return view('admin/kerjasama', $data);
    }
    
    public function getAll()
    {
        if ($this->request->isAJAX()) {
            // Pagination params
            $page = $this->request->getGet('page') ?? 1;
            $limit = $this->request->getGet('limit') ?? 10;
            $offset = ($page - 1) * $limit;
            
            // Filter params
            $searchTerm = $this->request->getGet('search') ?? '';
            $jenis = $this->request->getGet('jenis') ?? '';
            $startDate = $this->request->getGet('startDate') ?? '';
            $endDate = $this->request->getGet('endDate') ?? '';
            $view = $this->request->getGet('view') ?? 'all';
            $minProgress = $this->request->getGet('minProgress') ?? null;
            $maxProgress = $this->request->getGet('maxProgress') ?? null;
            $lingkup = $this->request->getGet('lingkup') ?? '';
            $region = $this->request->getGet('region') ?? '';
            $status = $this->request->getGet('status') ?? '';
            
            $builder = $this->kerjasamaModel->builder();
            
            // Apply filters
            if (!empty($searchTerm)) {
                $builder->groupStart()
                    ->like('nama_mitra', $searchTerm)
                    ->orLike('ruang_lingkup', $searchTerm)
                    ->orLike('unit_kerja', $searchTerm)
                    ->orLike('lokasi_mitra', $searchTerm)
                    ->groupEnd();
            }
            
            if (!empty($jenis)) {
                $builder->where('jenis', $jenis);
            }
            
            if (!empty($startDate)) {
                $builder->where('tanggal_mulai >=', $startDate);
            }
            
            if (!empty($endDate)) {
                $builder->where('tanggal_selesai <=', $endDate);
            }
            
            if (!empty($lingkup)) {
                $builder->where('lingkup', $lingkup);
            }
            
            if (!empty($region)) {
                $builder->where('region', $region);
            }
            
            if (!empty($status)) {
                $builder->where('status', $status);
            }
            
            // Apply special view filters
            if ($view === 'akan-berakhir') {
                // Default to 90 days from now if no end date is specified
                $threeMonthsFromNow = date('Y-m-d', strtotime('+3 months'));
                $today = date('Y-m-d');
                $builder->where('tanggal_selesai >=', $today);
                $builder->where('tanggal_selesai <=', $threeMonthsFromNow);
                $builder->where('status !=', 'berakhir');
            } else if ($view === 'implementasi') {
                // Show only records with implementasi data
                $builder->where("implementasi IS NOT NULL");
                $builder->where("implementasi != ''");
                
                // Also filter by progress if specified
                if ($minProgress !== null) {
                    $builder->where('progress >=', $minProgress);
                }
                if ($maxProgress !== null) {
                    $builder->where('progress <=', $maxProgress);
                }
            } else if ($view === 'progress') {
                // Sort by tanggal_pengajuan for the progress view
                $builder->orderBy('tanggal_pengajuan', 'DESC');
            }
            
            // Get total count for pagination
            $totalRecords = $builder->countAllResults(false);
            
            // Get data
            if ($view !== 'progress') {
                $builder->orderBy('tanggal_mulai', 'DESC');
            }
            
            $kerjasama = $builder->limit($limit, $offset)
                ->get()
                ->getResultArray();
            
            // Process data for display
            $today = date('Y-m-d');
            foreach ($kerjasama as &$item) {
                // Set status if not already set
                if (empty($item['status'])) {
                    if ($item['tanggal_selesai'] < $today) {
                        $item['status'] = 'berakhir';
                    } else {
                        $item['status'] = 'aktif';
                    }
                }
                
                // Parse implementasi if it's a JSON string
                if (!empty($item['implementasi'])) {
                    if (is_string($item['implementasi'])) {
                        try {
                            $implementasi = json_decode($item['implementasi'], true);
                            if (is_array($implementasi)) {
                                $item['implementasi_array'] = $implementasi;
                            } else {
                                // If not a JSON array, split by new lines
                                $item['implementasi_array'] = explode("\n", $item['implementasi']);
                            }
                        } catch (\Exception $e) {
                            // If JSON decode fails, split by new lines
                            $item['implementasi_array'] = explode("\n", $item['implementasi']);
                        }
                    } else {
                        $item['implementasi_array'] = [];
                    }
                } else {
                    $item['implementasi_array'] = [];
                }
                
                // Format dates for display
                $item['formatted_tanggal_mulai'] = date('d/m/Y', strtotime($item['tanggal_mulai']));
                $item['formatted_tanggal_selesai'] = date('d/m/Y', strtotime($item['tanggal_selesai']));
            }
            
            return $this->response->setJSON([
                'status' => true,
                'data' => $kerjasama,
                'pagination' => [
                    'total' => $totalRecords,
                    'perPage' => $limit,
                    'currentPage' => $page,
                    'lastPage' => ceil($totalRecords / $limit)
                ]
            ]);
        }
        
        return $this->response->setStatusCode(403);
    }
    
    public function getOne()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getGet('id');
            $kerjasama = $this->kerjasamaModel->find($id);
            
            if (!$kerjasama) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data kerjasama tidak ditemukan'
                ]);
            }
            
            return $this->response->setJSON([
                'status' => true,
                'data' => $kerjasama
            ]);
        }
        
        return $this->response->setStatusCode(403);
    }
    
    public function create()
    {
        if ($this->request->isAJAX()) {
            $rules = [
                'nama_mitra' => 'required|min_length[3]',
                'ruang_lingkup' => 'required',
                'tanggal_mulai' => 'required|valid_date',
                'tanggal_selesai' => 'required|valid_date',
                'jenis' => 'required',
                'progress' => 'permit_empty|numeric|less_than_equal_to[100]|greater_than_equal_to[0]',
                'lingkup' => 'permit_empty|in_list[nasional,internasional]',
                'status' => 'permit_empty|in_list[aktif,berakhir,menunggu_perpanjangan]',
                'region' => 'permit_empty|in_list[asia,europe,america,africa,oceania]',
                'kontak_email' => 'permit_empty|valid_email'
            ];
            
            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $this->validator->getErrors()
                ]);
            }
            
            // Prepare implementasi data - convert to JSON
            $implementasi = $this->request->getPost('implementasi');
            if (!empty($implementasi)) {
                // Split by new lines and convert to JSON array
                $implementasiArray = array_filter(array_map('trim', explode("\n", $implementasi)));
                $implementasiJson = json_encode($implementasiArray);
            } else {
                $implementasiJson = null;
            }
            
            $data = [
                'nama_mitra' => $this->request->getPost('nama_mitra'),
                'ruang_lingkup' => $this->request->getPost('ruang_lingkup'),
                'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
                'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
                'jenis' => $this->request->getPost('jenis'),
                'progress' => $this->request->getPost('progress') ?? 0,
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'created_by_user_id' => session()->get('user_id'),
                'lokasi_mitra' => $this->request->getPost('lokasi_mitra'),
                'lingkup' => $this->request->getPost('lingkup'),
                'status' => $this->request->getPost('status') ?? 'aktif',
                'implementasi' => $implementasiJson,
                'unit_kerja' => $this->request->getPost('unit_kerja'),
                'kontak_nama' => $this->request->getPost('kontak_nama'),
                'kontak_email' => $this->request->getPost('kontak_email'),
                'kontak_telepon' => $this->request->getPost('kontak_telepon'),
                'tanggal_pengajuan' => date('Y-m-d')
            ];
            
            // Region hanya diisi jika lingkup internasional
            if ($data['lingkup'] == 'internasional') {
                $data['region'] = $this->request->getPost('region');
            } else {
                $data['region'] = null;
            }
            
            // Set masa berlaku untuk tampilan implementasi
            $startDate = new \DateTime($data['tanggal_mulai']);
            $endDate = new \DateTime($data['tanggal_selesai']);
            $data['masa_berlaku'] = $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y');
            
            if ($this->kerjasamaModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data kerjasama berhasil ditambahkan'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menambahkan data kerjasama'
                ]);
            }
        }
        
        return $this->response->setStatusCode(403);
    }
    
    public function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id_kerjasama');
            
            // Check if data exists
            $kerjasama = $this->kerjasamaModel->find($id);
            if (!$kerjasama) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data kerjasama tidak ditemukan'
                ]);
            }
            
            $rules = [
                'nama_mitra' => 'required|min_length[3]',
                'ruang_lingkup' => 'required',
                'tanggal_mulai' => 'required|valid_date',
                'tanggal_selesai' => 'required|valid_date',
                'jenis' => 'required',
                'progress' => 'permit_empty|numeric|less_than_equal_to[100]|greater_than_equal_to[0]',
                'lingkup' => 'permit_empty|in_list[nasional,internasional]',
                'status' => 'permit_empty|in_list[aktif,berakhir,menunggu_perpanjangan]',
                'region' => 'permit_empty|in_list[asia,europe,america,africa,oceania]',
                'kontak_email' => 'permit_empty|valid_email'
            ];
            
            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $this->validator->getErrors()
                ]);
            }
            
            // Prepare implementasi data - convert to JSON
            $implementasi = $this->request->getPost('implementasi');
            if (!empty($implementasi)) {
                // Split by new lines and convert to JSON array
                $implementasiArray = array_filter(array_map('trim', explode("\n", $implementasi)));
                $implementasiJson = json_encode($implementasiArray);
            } else {
                $implementasiJson = null;
            }
            
            $data = [
                'nama_mitra' => $this->request->getPost('nama_mitra'),
                'ruang_lingkup' => $this->request->getPost('ruang_lingkup'),
                'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
                'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
                'jenis' => $this->request->getPost('jenis'),
                'progress' => $this->request->getPost('progress') ?? 0,
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'lokasi_mitra' => $this->request->getPost('lokasi_mitra'),
                'lingkup' => $this->request->getPost('lingkup'),
                'status' => $this->request->getPost('status') ?? 'aktif',
                'implementasi' => $implementasiJson,
                'unit_kerja' => $this->request->getPost('unit_kerja'),
                'kontak_nama' => $this->request->getPost('kontak_nama'),
                'kontak_email' => $this->request->getPost('kontak_email'),
                'kontak_telepon' => $this->request->getPost('kontak_telepon')
            ];
            
            // Region hanya diisi jika lingkup internasional
            if ($data['lingkup'] == 'internasional') {
                $data['region'] = $this->request->getPost('region');
            } else {
                $data['region'] = null;
            }
            
            // Set masa berlaku untuk tampilan implementasi
            $startDate = new \DateTime($data['tanggal_mulai']);
            $endDate = new \DateTime($data['tanggal_selesai']);
            $data['masa_berlaku'] = $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y');
            
            if ($this->kerjasamaModel->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data kerjasama berhasil diperbarui'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal memperbarui data kerjasama'
                ]);
            }
        }
        
        return $this->response->setStatusCode(403);
    }
    
    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            
            // Check if data exists
            $kerjasama = $this->kerjasamaModel->find($id);
            if (!$kerjasama) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data kerjasama tidak ditemukan'
                ]);
            }
            
            if ($this->kerjasamaModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data kerjasama berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menghapus data kerjasama'
                ]);
            }
        }
        
        return $this->response->setStatusCode(403);
    }
    
    public function getStats()
    {
        if ($this->request->isAJAX()) {
            $today = date('Y-m-d');
            $thisMonth = date('Y-m-01');
            $nextMonth = date('Y-m-d', strtotime('+1 month', strtotime($thisMonth)));
            
            $total = $this->kerjasamaModel->countAllResults();
            $active = $this->kerjasamaModel->where('tanggal_selesai >=', $today)->countAllResults();
            $expired = $this->kerjasamaModel->where('tanggal_selesai <', $today)->countAllResults();
            $thisMonthCount = $this->kerjasamaModel->where('created_at >=', $thisMonth)
                                 ->where('created_at <', $nextMonth)
                                 ->countAllResults();
            
            return $this->response->setJSON([
                'status' => true,
                'data' => [
                    'total' => $total,
                    'active' => $active,
                    'expired' => $expired,
                    'this_month' => $thisMonthCount
                ]
            ]);
        }
        
        return $this->response->setStatusCode(403);
    }
}
