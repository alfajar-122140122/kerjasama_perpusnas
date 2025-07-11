<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ImplementasiKerjasamaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        // Get existing kerjasama IDs
        $kerjasamaIds = $this->db->table('kerjasama')
                               ->select('id')
                               ->get()
                               ->getResultArray();
        
        if (empty($kerjasamaIds)) {
            echo "No kerjasama records found! Please run KerjasamaSeeder first.\n";
            return;
        }
        
        // Prepare data
        $data = [];
        
        // Generate 10 random implementasi
        foreach (array_slice($kerjasamaIds, 0, 10) as $kerjasama) {
            // Generate random masa berlaku
            $masaBerlakuOptions = ['1 tahun', '2 tahun', '3 tahun', '4 tahun', '5 tahun'];
            
            // Generate random implementasi
            $implementasiOptions = [
                'Pengembangan sistem perpustakaan digital berbasis open source',
                'Workshop pelatihan digitalisasi naskah kuno',
                'Seminar nasional literasi digital',
                'Pameran naskah kuno Nusantara',
                'Program magang mahasiswa bidang kepustakawanan',
                'Pelatihan preservasi dan konservasi koleksi langka',
                'Pengembangan aplikasi mobile untuk akses koleksi digital',
                'Pembangunan repositori digital bersama',
                'Penerbitan jurnal ilmiah kolaboratif',
                'Penyelenggaraan festival literasi nasional'
            ];
            
            // Generate random lingkup
            $lingkupOptions = [
                'Preservasi dan digitalisasi koleksi',
                'Pengembangan sistem dan aplikasi',
                'Pelatihan dan pengembangan SDM',
                'Penelitian dan publikasi',
                'Layanan pemustaka',
                'Diseminasi informasi',
                'Pengembangan infrastruktur TIK',
                'Pembinaan perpustakaan',
                'Peningkatan budaya literasi',
                'Kolaborasi antar lembaga'
            ];
            
            // Generate random unit kerja
            $unitKerjaOptions = [
                'Pusat Preservasi dan Digitalisasi',
                'Bidang Pengembangan Sistem',
                'Pusat Pengembangan Koleksi',
                'Direktorat Layanan dan Diseminasi',
                'Bidang TIK',
                'Pusat Pembinaan Perpustakaan',
                'Pusat Jasa Teknis',
                'Divisi Katalogisasi',
                'Bidang Kerjasama',
                'Pusat Pengembangan SDM'
            ];
            
            $data[] = [
                'kerjasama_id'       => $kerjasama['id'],
                'masa_berlaku'       => $faker->randomElement($masaBerlakuOptions),
                'implementasi'       => $faker->randomElement($implementasiOptions),
                'lingkup'            => $faker->randomElement($lingkupOptions),
                'unit_kerja_terkait' => $faker->randomElement($unitKerjaOptions),
                'created_at'         => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            ];
        }
        
        // Insert data to table
        $this->db->table('implementasi_kerjasama')->insertBatch($data);
        
        echo "Implementasi Kerjasama seeder: " . count($data) . " data inserted.\n";
    }
}
