<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Seed users table
        $this->db->table('users')->insertBatch([
            [
                'username' => 'admin',
                'email' => 'admin@perpusnas.go.id',
                'password' => password_hash('Admin123!', PASSWORD_DEFAULT),
                'hak_akses' => 'admin',
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'user',
                'email' => 'user@perpusnas.go.id',
                'password' => password_hash('User123!', PASSWORD_DEFAULT),
                'hak_akses' => 'user',
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);

        // Seed about table
        $this->db->table('about')->insert([
            'content' => '<h3>Tugas Pokok</h3>
            <p>Tim Kerjasama Perpustakaan Nasional memiliki tugas pokok untuk mengkoordinasikan, mengembangkan, dan mengevaluasi seluruh aktivitas kerjasama Perpustakaan Nasional dengan berbagai pihak, baik institusi pemerintah, swasta, maupun perguruan tinggi, baik dalam lingkup nasional maupun internasional.</p>
            
            <h3>Fungsi</h3>
            <ul>
                <li>Menyusun dan mengembangkan kebijakan dan strategi kerjasama Perpustakaan Nasional</li>
                <li>Mengidentifikasi dan menganalisis potensi kerjasama yang dapat dijalin dengan berbagai pihak</li>
                <li>Memfasilitasi proses pengusulan, perancangan, dan penandatanganan dokumen kerjasama</li>
                <li>Melakukan monitoring dan evaluasi terhadap implementasi kerjasama yang telah disepakati</li>
                <li>Menyelenggarakan kegiatan dalam rangka pengembangan kerjasama perpustakaan</li>
                <li>Menyusun laporan perkembangan kerjasama secara berkala</li>
                <li>Menjaga hubungan baik dengan seluruh mitra kerjasama Perpustakaan Nasional</li>
            </ul>
            
            <h3>Bentuk Kerjasama</h3>
            <p>Bentuk kerjasama yang dikelola oleh Tim Kerjasama meliputi:</p>
            <ol>
                <li>Kerjasama pengembangan koleksi perpustakaan</li>
                <li>Kerjasama pertukaran tenaga ahli dan pustakawan</li>
                <li>Kerjasama pengembangan sistem otomasi perpustakaan</li>
                <li>Kerjasama pelestarian bahan pustaka</li>
                <li>Kerjasama penelitian dan publikasi</li>
                <li>Kerjasama pelatihan dan pengembangan SDM perpustakaan</li>
                <li>Kerjasama promosi dan sosialisasi kegiatan perpustakaan</li>
            </ol>',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Seed statistics table
        $this->db->table('statistics')->insertBatch([
            [
                'label' => 'Total Kerjasama',
                'value' => 120,
                'icon' => 'bi bi-file-earmark-text',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'label' => 'Kerjasama Aktif',
                'value' => 98,
                'icon' => 'bi bi-check-circle',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'label' => 'Instansi Mitra',
                'value' => 45,
                'icon' => 'bi bi-buildings',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'label' => 'Kerjasama Tahun Ini',
                'value' => 15,
                'icon' => 'bi bi-calendar-check',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);

        // Seed activities table
        $this->db->table('activities')->insertBatch([
            [
                'title' => 'Penandatanganan MoU dengan Universitas Indonesia',
                'description' => 'Perpustakaan Nasional menjalin kerjasama dengan Universitas Indonesia dalam pengembangan koleksi digital.',
                'date' => '2025-06-25',
                'image' => 'activity1.jpg',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Webinar Kerjasama Perpustakaan Digital',
                'description' => 'Webinar membahas potensi kerjasama dalam pengembangan perpustakaan digital di era modern.',
                'date' => '2025-06-18',
                'image' => 'activity2.jpg',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Workshop Pemanfaatan Koleksi Bersama',
                'description' => 'Workshop yang membahas standar pemanfaatan koleksi bersama antar perpustakaan mitra.',
                'date' => '2025-06-05',
                'image' => 'activity3.jpg',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);

        // Seed settings table
        $this->db->table('settings')->insertBatch([
            [
                'category' => 'contact',
                'key' => 'address',
                'value' => 'Jl. Salemba Raya No. 28A, Jakarta Pusat 10430',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'contact',
                'key' => 'phone',
                'value' => '+62 21 3154864',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'contact',
                'key' => 'email',
                'value' => 'kerjasama@perpusnas.go.id',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'contact',
                'key' => 'working_hours',
                'value' => 'Senin - Jumat: 08.00 - 16.00 WIB',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'contact',
                'key' => 'map_link',
                'value' => 'https://goo.gl/maps/UqYYQjB1qFn1aKKt9',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'chart',
                'key' => 'show_progress_chart',
                'value' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'chart',
                'key' => 'chart_type',
                'value' => 'bar',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
