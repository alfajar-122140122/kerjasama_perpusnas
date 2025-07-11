<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ProgressKerjasamaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        // Prepare data
        $data = [];
        
        // Lembaga options
        $lembagaOptions = [
            'Universitas Indonesia',
            'Perpustakaan Nasional Malaysia',
            'Dinas Kearsipan dan Perpustakaan DKI Jakarta',
            'PT Telkom Indonesia',
            'Yayasan Sastra Digital Nusantara',
            'Pusat Dokumentasi Sejarah Indonesia',
            'Institut Kearsipan Modern',
            'Balai Pelestarian Cagar Budaya',
            'Perpustakaan British Council',
            'Museum Nasional Indonesia',
            'Google Indonesia',
            'Kementerian Pendidikan dan Kebudayaan'
        ];
        
        // Progress options
        $progressOptions = [
            'Pembahasan MOU',
            'Revisi PKS',
            'Tanda tangan',
            'Penyusunan draft perjanjian',
            'Konsultasi dengan biro hukum',
            'Klarifikasi lingkup kerjasama',
            'Penandatanganan naskah final',
            'Presentasi program kerjasama',
            'Evaluasi implementasi',
            'Persiapan perpanjangan'
        ];
        
        // Generate 10 random progress
        for ($i = 0; $i < 10; $i++) {
            $jenisOptions = ['baru', 'lanjutan'];
            
            $data[] = [
                'tanggal_pengajuan' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'lembaga'           => $faker->randomElement($lembagaOptions),
                'jenis'             => $faker->randomElement($jenisOptions),
                'progress'          => $faker->randomElement($progressOptions),
                'created_at'        => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d H:i:s'),
            ];
        }
        
        // Insert data to table
        $this->db->table('progress_kerjasama')->insertBatch($data);
        
        echo "Progress Kerjasama seeder: " . count($data) . " data inserted.\n";
    }
}
