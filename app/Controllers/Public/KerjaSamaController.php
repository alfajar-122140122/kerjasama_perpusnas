<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Models\KerjasamaModel;

class KerjaSamaController extends BaseController
{
    protected $kerjasamaModel;
    
    public function __construct()
    {
        $this->kerjasamaModel = new KerjasamaModel();
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
