<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ImplementasiKerjasamaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        // Get existing kerjasama dengan tanggal mulai dan berakhir
        $kerjasamaData = $this->db->table('kerjasama')
                               ->select('id, tanggal_mulai, tanggal_berakhir')
                               ->where('status', 'aktif')
                               ->get()
                               ->getResultArray();
        
        if (empty($kerjasamaData)) {
            echo "No active kerjasama records found! Please run KerjasamaSeeder first.\n";
            return;
        }
        
        // Prepare data
        $data = [];
        
        // Generate 1-3 implementasi for each active kerjasama
        foreach ($kerjasamaData as $kerjasama) {
            $numImplementasi = $faker->numberBetween(1, 3);
            
            for ($i = 0; $i < $numImplementasi; $i++) {
                // Gunakan tanggal mulai dan berakhir dari kerjasama
                $tanggalMulai = new \DateTime($kerjasama['tanggal_mulai']);
                $tanggalBerakhir = new \DateTime($kerjasama['tanggal_berakhir']);
                $masaBerlaku = $tanggalMulai->format('d-m-Y') . ' s/d ' . $tanggalBerakhir->format('d-m-Y');
                
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
                
                $createdDate = $faker->dateTimeBetween('-1 year', 'now');
                
                $data[] = [
                    'kerjasama_id'  => $kerjasama['id'],
                    'masa_berlaku'  => $masaBerlaku,
                    'implementasi'  => $faker->randomElement($implementasiOptions),
                    'lingkup'       => $faker->randomElement($lingkupOptions),
                    'created_at'    => $createdDate->format('Y-m-d H:i:s'),
                    'updated_at'    => $faker->dateTimeBetween($createdDate, 'now')->format('Y-m-d H:i:s'),
                ];
            }
        }
        
        // Insert data to table
        $this->db->table('implementasi_kerjasama')->insertBatch($data);
        
        echo "Implementasi Kerjasama seeder: " . count($data) . " data inserted.\n";
    }
}
