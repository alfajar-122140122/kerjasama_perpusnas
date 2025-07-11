<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Models\KerjasamaModel;
use App\Models\ImplementasiKerjasamaModel;
use App\Models\ProgressKerjasamaModel;

class KerjaSamaController extends BaseController
{
    protected $kerjasamaModel;
    protected $implementasiModel;
    protected $progressModel; // Add this line
    
    public function __construct()
    {
        $this->kerjasamaModel = new KerjasamaModel();
        $this->implementasiModel = new ImplementasiKerjasamaModel();
        $this->progressModel = new \App\Models\ProgressKerjasamaModel(); // Add this line
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
    
    public function akanBerakhir()
    {
        // Get kerjasama data that will expire in the next 90 days
        $today = date('Y-m-d');
        $threeMonthsLater = date('Y-m-d', strtotime('+3 months'));
        
        // Get kerjasama that will expire in 90 days
        $akanBerakhirData = $this->kerjasamaModel
            ->where('tanggal_berakhir >=', $today)
            ->where('tanggal_berakhir <=', $threeMonthsLater)
            ->orderBy('tanggal_berakhir', 'ASC')
            ->findAll();
        
        // Calculate remaining days and format dates
        $formattedData = [];
        foreach ($akanBerakhirData as $kerjasama) {
            $endDate = new \DateTime($kerjasama['tanggal_berakhir']);
            $currentDate = new \DateTime($today);
            $interval = $currentDate->diff($endDate);
            
            // Format dates for display
            $startDate = new \DateTime($kerjasama['tanggal_mulai']);
            
            $formattedData[] = [
                'id' => $kerjasama['id'],
                'partner' => $kerjasama['nama_mitra'],
                'scope' => $kerjasama['ruang_lingkup'],
                'startDate' => $startDate->format('d/m/Y'),
                'endDate' => $endDate->format('d/m/Y'),
                'remainingDays' => $interval->days,
                'status' => $this->getStatusKerjasama($kerjasama['tanggal_berakhir'])
            ];
        }
        
        // Statistics for akan berakhir
        $stats = [
            'total_ending_soon' => count($akanBerakhirData),
            'ending_in_30_days' => $this->countEndingSoon(30),
            'ending_in_60_days' => $this->countEndingSoon(60),
            'ending_in_90_days' => $this->countEndingSoon(90),
        ];
        
        $data = [
            'page_title' => 'Kerja Sama yang Akan Berakhir',
            'meta_description' => 'Daftar kerja sama Perpustakaan Nasional RI yang akan berakhir dalam waktu dekat.',
            'current_section' => 'akan_berakhir',
            'akan_berakhir_data' => $formattedData,
            'akan_berakhir_stats' => $stats,
            'filter_options' => $this->getFilterOptions()
        ];
        
        return view('public/kerjasama/akan_berakhir', $data);
    }
    
    public function progress()
    {
        // Get progress data from database
        $progressData = $this->progressModel->getProgressForPublic();
        
        // Format data for the view
        $formattedData = [];
        foreach ($progressData as $item) {
            // Format date from YYYY-MM-DD to d/m/Y
            $date = new \DateTime($item['tanggal_pengajuan']);
            
            $formattedData[] = [
                'id' => $item['id'],
                'date' => $date->format('d M Y'),
                'institution' => $item['lembaga'],
                'type' => strtolower($item['jenis']),
                'progress' => $item['progress']
            ];
        }
        
        // Statistics for progress
        $stats = $this->progressModel->getProgressStats();
        
        $data = [
            'page_title' => 'Progress Kerja Sama',
            'meta_description' => 'Informasi terkini mengenai progres kerja sama Perpustakaan Nasional RI dengan berbagai mitra.',
            'current_section' => 'progress',
            'progress_data' => $formattedData,
            'progress_stats' => $stats,
            'filter_options' => $this->getFilterOptions()
        ];
        
        return view('public/kerjasama/progress', $data);
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
    
    private function countEndingSoon($days)
    {
        $today = date('Y-m-d');
        $futureDate = date('Y-m-d', strtotime("+$days days"));
        
        return $this->kerjasamaModel
            ->where('tanggal_berakhir >=', $today)
            ->where('tanggal_berakhir <=', $futureDate)
            ->countAllResults();
    }
}
