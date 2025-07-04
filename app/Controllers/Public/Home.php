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
            'about_content' => [
                'title' => 'Portal Kerjasama Perpustakaan Nasional',
                'description' => 'Penyiapan bahan dan melakukan kerja sama perpustakaan dalam dan luar negeri sesuai dengan petunjuk dan pedoman yang berlaku.',
                'functions' => [
                    'Pelaksanaan kerja sama perpustakaan dalam dan luar negeri',
                    'Penerima dan mengelola permohonan inisiasi kerja sama',
                    'Pelaksanaan penanda tanganan naskah Kesepahaman Bersama atau Memorandum of Understanding (MoU)',
                    'Mengelola dan mengevaluasi implementasi kerja sama.'
                ],
                'mission' => 'Membangun ekosistem kerjasama perpustakaan yang kuat untuk kemajuan literasi bangsa',
                'vision' => 'Menjadi pusat koordinasi kerjasama perpustakaan terdepan di Asia Tenggara'
            ]
        ];
        
        return view('public/tentang', $data);
    }
    
    public function kontak()
    {
        $data = [
            'page_title' => 'Kontak Kami',
            'contact_info' => [
                'name' => 'Sub Bidang Kerja Sama Perpustakaan',
                'organization' => 'Perpustakaan Nasional RI',
                'address' => [
                    'building' => 'Gedung Layanan, Lantai 5',
                    'street' => 'Jl. Medan Merdeka Selatan No. 11',
                    'city' => 'Jakarta Pusat 10110'
                ],
                'phone' => '021-80664603',
                'emails' => [
                    'kerjasama@perpusnas.go.id',
                    'kerjasama@gmail.com'
                ],
                'operating_hours' => [
                    'weekdays' => 'Senin - Jumat: 08:00 - 16:00 WIB',
                    'weekend' => 'Sabtu - Minggu: Tutup'
                ],
                'coordinates' => [
                    'lat' => -6.2034188,
                    'lng' => 106.8302461
                ]
            ]
        ];
        
        return view('public/kontak', $data);
    }
    
    public function aktivitas()
    {
        $data = [
            'page_title' => 'Aktivitas Kami',
            'activities' => [
                [
                    'title' => 'Pelatihan Pustakawan',
                    'date' => '2024-07-01',
                    'description' => 'Pelatihan pustakawan untuk meningkatkan kompetensi dalam layanan perpustakaan digital.',
                    'image' => 'activity-1.jpg'
                ],
                [
                    'title' => 'Kerjasama Internasional',
                    'date' => '2024-06-20',
                    'description' => 'Penandatanganan MoU dengan perpustakaan internasional untuk pertukaran koleksi.',
                    'image' => 'activity-2.jpg'
                ]
            ]
        ];
        
        return view('public/aktivitas', $data);
    }

    public function petaKerjaSama()
    {
        $data = [
            'page_title' => 'Peta Kerja Sama',
            'map_data' => [
                'title' => 'Peta Kerja Sama Perpustakaan Nasional',
                'description' => 'Visualisasi kerja sama perpustakaan di seluruh Indonesia dan internasional.',
                'locations' => [
                    ['name' => 'Perpustakaan Nasional', 'lat' => -6.2034188, 'lng' => 106.8302461],
                    ['name' => 'Perpustakaan Daerah Jakarta', 'lat' => -6.2087634, 'lng' => 106.845599],
                    ['name' => 'Perpustakaan Universitas Indonesia', 'lat' => -6.360000, 'lng' => 106.820000]
                ]
            ]
        ];
        
        return view('public/peta_kerjasama', $data);
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