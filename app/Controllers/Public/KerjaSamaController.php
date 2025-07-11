<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Models\KerjasamaModel;
use App\Models\ImplementasiKerjasamaModel;

class KerjaSamaController extends BaseController
{
    protected $kerjasamaModel;
    protected $implementasiModel;
    
    public function __construct()
    {
        $this->kerjasamaModel = new KerjasamaModel();
        $this->implementasiModel = new ImplementasiKerjasamaModel();
    }
    
    public function data()
    {
        // Hitung data statistik dari database
        $totalKerjasama = $this->kerjasamaModel->countAllResults();
        $activeKerjasama = $this->countActiveKerjasama();
        $expiredKerjasama = $totalKerjasama - $activeKerjasama;
        
        $data = [
            'page_title' => 'Data Kerja Sama',
            'meta_description' => 'Data lengkap kerja sama Perpustakaan Nasional RI dengan berbagai mitra institusi.',
            'current_section' => 'data',
            'cooperation_stats' => [
                'total_partners' => $totalKerjasama,
                'active_agreements' => $activeKerjasama,
                'expired_agreements' => $expiredKerjasama,
                'national_scope' => $totalKerjasama,
                'pending_renewal' => $this->countPendingRenewalKerjasama(),
                'new_this_year' => $this->countNewThisYearKerjasama()
            ],
            'cooperation_data' => $this->getCooperationData(),
            'filter_options' => $this->getFilterOptions(),
            'total_items' => $totalKerjasama
        ];
        
        return view('public/kerjasama/data', $data);
    }
    
    public function implementasi()
    {
        $data = [
            'page_title' => 'Implementasi Kerja Sama',
            'meta_description' => 'Data implementasi kerja sama Perpustakaan Nasional RI dengan berbagai mitra institusi.',
            'current_section' => 'implementasi',
            'implementasi_data' => $this->getImplementasiData(),
            'implementasi_stats' => [
                'total_implementations' => $this->implementasiModel->countAllResults()
            ],
            'filter_options' => $this->getFilterOptions()
        ];
        
        return view('public/kerjasama/implementasi', $data);
    }
    
    // Helper methods for data calculations
    private function countActiveKerjasama()
    {
        $today = date('Y-m-d');
        return $this->kerjasamaModel
            ->where('tanggal_berakhir >=', $today)
            ->countAllResults();
    }
    
    private function countPendingRenewalKerjasama()
    {
        $today = date('Y-m-d');
        $threeMonthsLater = date('Y-m-d', strtotime('+3 months'));
        
        return $this->kerjasamaModel
            ->where('tanggal_berakhir >=', $today)
            ->where('tanggal_berakhir <=', $threeMonthsLater)
            ->countAllResults();
    }
    
    private function countNewThisYearKerjasama()
    {
        $startOfYear = date('Y-01-01');
        $today = date('Y-m-d');
        
        return $this->kerjasamaModel
            ->where('tanggal_mulai >=', $startOfYear)
            ->where('tanggal_mulai <=', $today)
            ->countAllResults();
    }
    
    private function getFilterOptions()
    {
        return [
            'status' => [
                'active' => 'Aktif',
                'expired' => 'Berakhir',
                'pending' => 'Menunggu Perpanjangan'
            ],
            'year' => range(date('Y'), 2015)
        ];
    }
    
    private function getImplementasiData()
    {
        // Ambil data implementasi kerjasama dari database dengan data tambahan
        $implementasiData = $this->implementasiModel->getImplementasiForPublic();
        
        // Transform data ke format yang dibutuhkan oleh view
        $transformedData = [];
        foreach ($implementasiData as $item) {
            // Gunakan masa_berlaku dari database jika ada, atau hitung dari tanggal jika diperlukan
            $period = !empty($item['masa_berlaku']) ? $item['masa_berlaku'] : '';
            
            // Jika masa_berlaku kosong tetapi tanggal ada, format seperti admin view
            if (empty($period) && !empty($item['tanggal_mulai']) && !empty($item['tanggal_berakhir'])) {
                $startDate = new \DateTime($item['tanggal_mulai']);
                $endDate = new \DateTime($item['tanggal_berakhir']);
                $interval = $endDate->diff($startDate);
                
                $duration = '';
                if ($interval->y > 0) $duration .= $interval->y . ' tahun ';
                if ($interval->m > 0 || $interval->y > 0) $duration .= $interval->m . ' bulan ';
                $duration .= $interval->d . ' hari';
                
                $period = $duration;
            }
            
            $transformedData[] = [
                'id' => $item['id'],
                'partner' => $item['nama_mitra'],
                'period' => $period,
                'implementation' => $item['implementasi'],
                'scope' => $item['lingkup'],
                'unit' => $item['unit_kerja_terkait'] ?: 'null'
            ];
        }
        
        return $transformedData;
    }
    
    private function getCooperationData()
    {
        // Ambil data dari database
        $kerjasamaData = $this->kerjasamaModel->orderBy('tanggal_berakhir', 'DESC')->findAll();
        
        // Transform data ke format yang dibutuhkan oleh view
        $transformedData = [];
        foreach ($kerjasamaData as $kerjasama) {
            $transformedData[] = [
                'id' => $kerjasama['id'],
                'partner' => $kerjasama['nama_mitra'],
                'scope' => $kerjasama['ruang_lingkup'],
                'startDate' => $kerjasama['tanggal_mulai'],
                'endDate' => $kerjasama['tanggal_berakhir'],
                'status' => $this->getStatusKerjasama($kerjasama['tanggal_berakhir']),
            ];
        }
        
        return $transformedData;
    }
    
    /**
     * Menentukan status kerjasama berdasarkan tanggal berakhir
     */
    private function getStatusKerjasama($endDate)
    {
        $now = time();
        $end = strtotime($endDate);
        
        if ($end < $now) {
            return 'expired';
        } else if (($end - $now) < (90 * 24 * 60 * 60)) { // 90 days
            return 'pending';
        } else {
            return 'active';
        }
    }
}
