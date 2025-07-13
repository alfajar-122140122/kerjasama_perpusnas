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
        $data = [];
        
        // Unit terkait options
        $unitTerkaitOptions = [
            'Pusat Pengembangan Koleksi',
            'Direktorat Layanan dan Diseminasi',
            'Pusat Preservasi Bahan Pustaka',
            'Bidang TIK',
            'Pusat Pengembangan Perpustakaan Umum',
            'Direktorat Deposit dan Pengembangan Koleksi',
            'Pusat Data dan Informasi',
            'Bidang Katalogisasi',
            'Pusat Pengembangan SDM',
            'Bidang Pengolahan Bahan Pustaka'
        ];
        
        // Generate 5 random permohonan
        for ($i = 0; $i < 5; $i++) {
            $jenisPermohonanOptions = ['Baru', 'Perpanjangan'];
            $statusOptions = ['pending', 'review', 'approved', 'rejected'];
            $status = $faker->randomElement($statusOptions);
            $reviewedBy = in_array($status, ['review', 'approved', 'rejected']) ? $faker->numberBetween(1, 3) : null;
            $reviewedAt = in_array($status, ['review', 'approved', 'rejected']) ? $faker->dateTimeBetween('-5 months', 'now')->format('Y-m-d H:i:s') : null;
            $catatan = $status === 'review' ? 'Perlu dokumen tambahan' : ($status === 'rejected' ? 'Dokumen tidak lengkap' : ($status === 'approved' ? 'Disetujui tanpa catatan' : null));
            $updatedAt = $reviewedAt;
            $data[] = [
                'jenis_permohonan'  => $faker->randomElement($jenisPermohonanOptions),
                'nama_instansi'     => $faker->company,
                'alamat'            => $faker->address,
                'telp'              => $faker->phoneNumber,
                'email'             => $faker->companyEmail,
                'unit_terkait'      => $faker->randomElement($unitTerkaitOptions),
                'kontak_dihubungi'  => $faker->name,
                'upload_formulir'   => 'formulir_' . $faker->numberBetween(1000, 9999) . '.pdf',
                'status'            => $status,
                'catatan'           => $catatan,
                'reviewed_by'       => $reviewedBy,
                'reviewed_at'       => $reviewedAt,
                'created_at'        => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s'),
                'updated_at'        => $updatedAt,
            ];
        }
        
        // Insert data to table
        $this->db->table('permohonan_kerjasama')->insertBatch($data);
        
        echo "Permohonan Kerjasama seeder: " . count($data) . " data inserted.\n";
    }
}
