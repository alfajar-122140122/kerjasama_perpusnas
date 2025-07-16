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
        $data = [
            [
                'tanggal_pengajuan' => date('Y-m-d', strtotime('-10 days')),
                'lembaga'           => 'PT Sumber Jaya',
                'jenis'             => 'Baru',
                'progress'          => 'Review',
            ],
            [
                'tanggal_pengajuan' => date('Y-m-d', strtotime('-8 days')),
                'lembaga'           => 'CV Maju Bersama',
                'jenis'             => 'Baru',
                'progress'          => 'Approved',
            ],
            [
                'tanggal_pengajuan' => date('Y-m-d', strtotime('-6 days')),
                'lembaga'           => 'Yayasan Cerdas Bangsa',
                'jenis'             => 'Baru',
                'progress'          => 'Rejected',
            ],
            [
                'tanggal_pengajuan' => date('Y-m-d', strtotime('-4 days')),
                'lembaga'           => 'Universitas Nusantara',
                'jenis'             => 'Perpanjangan',
                'progress'          => 'Review',
            ],
            [
                'tanggal_pengajuan' => date('Y-m-d', strtotime('-2 days')),
                'lembaga'           => 'SMK Negeri 1',
                'jenis'             => 'Perpanjangan',
                'progress'          => 'Approved',
            ],
        ];
        
        // Insert data to table
        $this->db->table('progress_kerjasama')->insertBatch($data);
        
        echo "Progress Kerjasama seeder: " . count($data) . " data inserted.\n";
    }
}
