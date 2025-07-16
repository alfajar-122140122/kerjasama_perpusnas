<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PermohonanKerjasamaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        // Prepare data
        $data = [
            [
                'jenis_permohonan'      => 'baru',
                'lembaga'               => 'PT Sumber Jaya',
                'alamat'                => 'Jl. Mawar No. 1',
                'telepon'               => '08123456789',
                'email'                 => 'info@sumberjaya.com',
                'kontak_dapat_dihubungi'=> 'Budi Santoso',
                'file_formulir'         => 'formulir_1001.pdf',
                'tanggal_pengajuan'     => date('Y-m-d', strtotime('-10 days')),
                'status'                => 'pending',
                'reviewed_by'           => null,
                'reviewed_at'           => null,
                'created_at'            => date('Y-m-d H:i:s', strtotime('-10 days')),
                'updated_at'            => date('Y-m-d H:i:s', strtotime('-10 days')),
            ],
            [
                'jenis_permohonan'      => 'baru',
                'lembaga'               => 'CV Maju Bersama',
                'alamat'                => 'Jl. Melati No. 2',
                'telepon'               => '08129876543',
                'email'                 => 'admin@majubersama.com',
                'kontak_dapat_dihubungi'=> 'Siti Aminah',
                'file_formulir'         => 'formulir_1002.pdf',
                'tanggal_pengajuan'     => date('Y-m-d', strtotime('-8 days')),
                'status'                => 'pending',
                'reviewed_by'           => null,
                'reviewed_at'           => null,
                'created_at'            => date('Y-m-d H:i:s', strtotime('-8 days')),
                'updated_at'            => date('Y-m-d H:i:s', strtotime('-8 days')),
            ],
            [
                'jenis_permohonan'      => 'baru',
                'lembaga'               => 'Yayasan Cerdas Bangsa',
                'alamat'                => 'Jl. Kenanga No. 3',
                'telepon'               => '08121234567',
                'email'                 => 'contact@cerdasbangsa.org',
                'kontak_dapat_dihubungi'=> 'Andi Wijaya',
                'file_formulir'         => 'formulir_1003.pdf',
                'tanggal_pengajuan'     => date('Y-m-d', strtotime('-6 days')),
                'status'                => 'pending',
                'reviewed_by'           => null,
                'reviewed_at'           => null,
                'created_at'            => date('Y-m-d H:i:s', strtotime('-6 days')),
                'updated_at'            => date('Y-m-d H:i:s', strtotime('-6 days')),
            ],
            [
                'jenis_permohonan'      => 'perpanjangan',
                'lembaga'               => 'Universitas Nusantara',
                'alamat'                => 'Jl. Anggrek No. 4',
                'telepon'               => '08122334455',
                'email'                 => 'kerjasama@unusantara.ac.id',
                'kontak_dapat_dihubungi'=> 'Rina Dewi',
                'file_formulir'         => 'formulir_1004.pdf',
                'tanggal_pengajuan'     => date('Y-m-d', strtotime('-4 days')),
                'status'                => 'pending',
                'reviewed_by'           => null,
                'reviewed_at'           => null,
                'created_at'            => date('Y-m-d H:i:s', strtotime('-4 days')),
                'updated_at'            => date('Y-m-d H:i:s', strtotime('-4 days')),
            ],
            [
                'jenis_permohonan'      => 'perpanjangan',
                'lembaga'               => 'SMK Negeri 1',
                'alamat'                => 'Jl. Dahlia No. 5',
                'telepon'               => '08125556677',
                'email'                 => 'info@smkn1.sch.id',
                'kontak_dapat_dihubungi'=> 'Dewi Lestari',
                'file_formulir'         => 'formulir_1005.pdf',
                'tanggal_pengajuan'     => date('Y-m-d', strtotime('-2 days')),
                'status'                => 'pending',
                'reviewed_by'           => null,
                'reviewed_at'           => null,
                'created_at'            => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at'            => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
        ];
        
        // Insert data to table
        $this->db->table('permohonan_kerjasama')->insertBatch($data);
        
        echo "Permohonan Kerjasama seeder: " . count($data) . " data inserted.\n";
    }
}
