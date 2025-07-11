<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class KerjasamaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        // Prepare data
        $data = [];
        
        // Generate 10 random kerjasama
        for ($i = 0; $i < 10; $i++) {
            // Generate random start date between 1-3 years ago
            $tanggalMulai = $faker->dateTimeBetween('-3 years', '-1 month');
            
            // End date between 1-5 years from start date
            $tanggalBerakhir = clone $tanggalMulai;
            $tanggalBerakhir->add(new \DateInterval('P' . mt_rand(12, 60) . 'M')); // 12-60 months later
            
            // Generate nama mitra
            $namaJenisInstitusi = ['Universitas', 'Perpustakaan', 'Dinas', 'PT', 'Yayasan', 'Pusat', 'Institut', 'Balai'];
            $namaMitra = $faker->randomElement($namaJenisInstitusi) . ' ' . $faker->company;
            
            // Generate random ruang lingkup
            $ruangLingkupOptions = [
                'Pelestarian warisan dokumenter budaya Nusantara dan pengembangan sistem informasi perpustakaan digital untuk mendukung akses informasi yang lebih luas',
                'Digitalisasi koleksi naskah kuno untuk kepentingan penelitian dan edukasi',
                'Pengembangan program literasi masyarakat melalui inovasi teknologi informasi',
                'Kolaborasi dalam pengembangan repository digital untuk arsip nasional',
                'Pertukaran tenaga ahli dalam bidang kepustakaan dan kearsipan',
                'Pengembangan SDM bidang perpustakaan digital dan preservasi',
                'Pemanfaatan koleksi langka untuk penelitian dan publikasi ilmiah',
                'Pengembangan infrastruktur TIK untuk mendukung layanan perpustakaan modern',
                'Pembinaan perpustakaan desa dan peningkatan minat baca masyarakat',
                'Diseminasi informasi pustaka dan arsip melalui platform digital'
            ];
            
            $ruangLingkup = $faker->randomElement($ruangLingkupOptions);
            
            $data[] = [
                'nama_mitra'       => $namaMitra,
                'ruang_lingkup'    => $ruangLingkup,
                'tanggal_mulai'    => $tanggalMulai->format('Y-m-d'),
                'tanggal_berakhir' => $tanggalBerakhir->format('Y-m-d'),
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ];
        }
        
        // Insert data to table
        $this->db->table('kerjasama')->insertBatch($data);
        
        echo "Kerjasama seeder: " . count($data) . " data inserted.\n";
    }
}
