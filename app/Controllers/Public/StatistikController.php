<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Models\KerjasamaModel;

class StatistikController extends BaseController
{
    protected $kerjasamaModel;
    
    public function __construct()
    {
        $this->kerjasamaModel = new KerjasamaModel();
    }
    
    public function index()
    {
        try {
            // Get statistik data
            $statistikData = $this->getStatistikData();
            
            $data = [
                'title' => 'Statistik Kerja Sama',
                'statistik' => $statistikData
            ];
            
            return view('public/statistik/index', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data statistik: ' . $e->getMessage());
        }
    }
    
    private function getStatistikData()
    {
        // 1. Statistik Jenis Identitas Mitra
        $jenisMitra = $this->kerjasamaModel
            ->select('jenis_mitra, COUNT(*) as jumlah')
            ->where('status', 'aktif')
            ->groupBy('jenis_mitra')
            ->findAll();
        
        // 2. Statistik Per Tahun
        $perTahun = $this->kerjasamaModel
            ->select('YEAR(tanggal_mulai) as tahun, COUNT(*) as jumlah')
            ->groupBy('YEAR(tanggal_mulai)')
            ->orderBy('tahun', 'ASC')
            ->findAll();
        
        // 3. Statistik Per Bulan untuk tahun terbaru
        $tahunTerbaru = date('Y');
        $perBulan = $this->kerjasamaModel
            ->select('MONTH(tanggal_mulai) as bulan, COUNT(*) as jumlah')
            ->where('YEAR(tanggal_mulai)', $tahunTerbaru)
            ->groupBy('MONTH(tanggal_mulai)')
            ->orderBy('bulan', 'ASC')
            ->findAll();
        
        // 4. Total keseluruhan
        $totalKerjasama = $this->kerjasamaModel->countAllResults();
        $totalAktif = $this->kerjasamaModel->where('status', 'aktif')->countAllResults();
        
        return [
            'jenis_mitra' => $jenisMitra,
            'per_tahun' => $perTahun,
            'per_bulan' => $perBulan,
            'tahun_terbaru' => $tahunTerbaru,
            'total_kerjasama' => $totalKerjasama,
            'total_aktif' => $totalAktif
        ];
    }
    
    /**
     * API endpoint untuk mendapatkan data chart
     */
    public function apiStatistik()
    {
        try {
            $statistikData = $this->getStatistikData();
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $statistikData
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
