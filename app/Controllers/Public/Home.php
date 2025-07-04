<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        // Data statistik untuk homepage
        $data = [
            'stats' => [
                'total_kerjasama' => 150,
                'mitra_aktif' => 85,
                'provinsi' => 34,
                'negara' => 12
            ],
            'recent_activities' => [
                [
                    'id' => 1,
                    'title' => 'Penandatanganan MoU dengan 15 Perpustakaan Daerah',
                    'excerpt' => 'Perpustakaan Nasional menandatangani memorandum of understanding dengan 15 perpustakaan daerah untuk program digitalisasi koleksi bersama.',
                    'date' => '2024-06-15',
                    'image' => 'activity-1.jpg',
                    'slug' => 'penandatanganan-mou-15-perpustakaan-daerah'
                ],
                [
                    'id' => 2,
                    'title' => 'Workshop Literasi Digital untuk Pustakawan',
                    'excerpt' => 'Kegiatan pelatihan literasi digital yang diikuti 200 pustakawan dari berbagai daerah sebagai bentuk implementasi kerjasama.',
                    'date' => '2024-06-10',
                    'image' => 'activity-2.jpg',
                    'slug' => 'workshop-literasi-digital-pustakawan'
                ],
                [
                    'id' => 3,
                    'title' => 'Kerjasama Internasional dengan Library of Congress',
                    'excerpt' => 'Perpustakaan Nasional memperluas jaringan internasional dengan menjalin kerjasama strategis bersama Library of Congress Amerika Serikat.',
                    'date' => '2024-06-05',
                    'image' => 'activity-3.jpg',
                    'slug' => 'kerjasama-internasional-library-congress'
                ]
            ],
            'partners' => [
                ['name' => 'Universitas Indonesia', 'logo' => 'ui.png'],
                ['name' => 'Universitas Gadjah Mada', 'logo' => 'ugm.png'],
                ['name' => 'Institut Teknologi Bandung', 'logo' => 'itb.png'],
                ['name' => 'Institut Teknologi Sepuluh Nopember', 'logo' => 'its.png'],
                ['name' => 'Institut Pertanian Bogor', 'logo' => 'ipb.png'],
                ['name' => 'Universitas Bina Nusantara', 'logo' => 'binus.png']
            ]
        ];
        
        return view('public/home', $data);
    }
    
    public function tentang()
    {
        $data = [
            'page_title' => 'Tentang Kami',
            'about_content' => $this->getAboutContent()
        ];
        
        return view('public/about', $data);
    }
    
    public function kontak()
    {
        $data = [
            'page_title' => 'Kontak Kami',
            'contact_info' => [
                'address' => 'Jl. Salemba Raya No. 28A, Jakarta Pusat 10440',
                'phone' => '+62 21 3928 8221',
                'email' => 'kerjasama@perpusnas.go.id',
                'working_hours' => 'Senin - Jumat, 08:00 - 16:00 WIB'
            ]
        ];
        
        return view('public/contact', $data);
    }
    
    private function getAboutContent()
    {
        return [
            'mission' => 'Membangun ekosistem kerjasama perpustakaan yang kuat untuk kemajuan literasi bangsa',
            'vision' => 'Menjadi pusat koordinasi kerjasama perpustakaan terdepan di Asia Tenggara',
            'functions' => [
                'Menyusun dan mengembangkan kebijakan kerjasama perpustakaan',
                'Memfasilitasi proses kerjasama dengan berbagai pihak',
                'Melakukan monitoring dan evaluasi implementasi kerjasama',
                'Menyelenggarakan kegiatan pengembangan kerjasama',
                'Menyusun laporan perkembangan kerjasama secara berkala'
            ]
        ];
    }
}