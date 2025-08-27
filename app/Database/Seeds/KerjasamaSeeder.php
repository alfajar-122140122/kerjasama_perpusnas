<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class KerjasamaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        // Ambil ID permohonan yang ada
        $permohonanIds = $this->db->table('permohonan_kerjasama')
                             ->select('id, lembaga')
                             ->where('status', 'approved')
                             ->get()
                             ->getResultArray();
        
        // Ambil ID user
        $userIds = $this->db->table('users')
                       ->select('id')
                       ->get()
                       ->getResultArray();
        
        if (empty($userIds)) {
            echo "No user records found! Please run UserSeeder first.\n";
            return;
        }
        
        // Jenis Mitra
        $jenisMitra = ['PTS', 'PTN', 'K/L', 'Swasta', 'Luar Negeri'];
        
        // Data kerjasama
        $data = [];
        
        // 1. Kerjasama dari permohonan yang disetujui
        foreach ($permohonanIds as $permohonan) {
            // Generate random start date between now and 1 month later
            $tanggalMulai = $faker->dateTimeBetween('now', '+1 month');
            
            // End date between 1-5 years from start date
            $tanggalBerakhir = clone $tanggalMulai;
            $tanggalBerakhir->add(new \DateInterval('P' . mt_rand(12, 60) . 'M')); // 12-60 months later
            
            // Generate random ruang lingkup
            $ruangLingkupOptions = [
                'Pelestarian warisan dokumenter budaya Nusantara',
                'Digitalisasi koleksi naskah kuno',
                'Pengembangan program literasi masyarakat',
                'Kolaborasi dalam pengembangan repository digital',
                'Pertukaran tenaga ahli dalam bidang kepustakaan',
                'Pengembangan SDM bidang perpustakaan digital',
                'Pemanfaatan koleksi langka untuk penelitian',
                'Pengembangan infrastruktur TIK untuk perpustakaan',
                'Pembinaan perpustakaan desa dan minat baca',
                'Diseminasi informasi pustaka dan arsip'
            ];
            
            $data[] = [
                'permohonan_id'   => $permohonan['id'],
                'nomor_kerjasama' => 'KS-' . date('Y') . '-' . $faker->unique()->numberBetween(1001, 9999),
                'nama_mitra'      => $permohonan['lembaga'],
                'jenis_mitra'     => $faker->randomElement($jenisMitra),
                'ruang_lingkup'   => $faker->randomElement($ruangLingkupOptions),
                'tanggal_mulai'   => $tanggalMulai->format('Y-m-d'),
                'tanggal_berakhir' => $tanggalBerakhir->format('Y-m-d'),
                'file_kerjasama'  => 'kerjasama_' . $faker->unique()->numberBetween(1000, 9999) . '.pdf',
                'status'          => 'aktif',
                'created_by'      => $faker->randomElement($userIds)['id'],
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ];
        }
        
        // 2. Kerjasama tambahan (tidak dari permohonan)
        $numAdditional = 5;
        
        // Generate nama mitra
        $namaJenisInstitusi = ['Universitas', 'Perpustakaan', 'Dinas', 'PT', 'Yayasan', 'Pusat', 'Institut', 'Balai'];
        
        for ($i = 0; $i < $numAdditional; $i++) {
            // Generate random start date between 1-3 years ago
            $tanggalMulai = $faker->dateTimeBetween('-3 years', '-1 month');
            
            // End date between 1-5 years from start date
            $tanggalBerakhir = clone $tanggalMulai;
            $tanggalBerakhir->add(new \DateInterval('P' . mt_rand(12, 60) . 'M')); // 12-60 months later
            
            $namaMitra = $faker->randomElement($namaJenisInstitusi) . ' ' . $faker->company;
            
            // Generate random ruang lingkup
            $ruangLingkupOptions = [
                'Pelestarian warisan dokumenter budaya Nusantara',
                'Digitalisasi koleksi naskah kuno',
                'Pengembangan program literasi masyarakat',
                'Kolaborasi dalam pengembangan repository digital',
                'Pertukaran tenaga ahli dalam bidang kepustakaan',
                'Pengembangan SDM bidang perpustakaan digital',
                'Pemanfaatan koleksi langka untuk penelitian',
                'Pengembangan infrastruktur TIK untuk perpustakaan',
                'Pembinaan perpustakaan desa dan minat baca',
                'Diseminasi informasi pustaka dan arsip'
            ];
            
            // Determine status based on end date
            $status = ($tanggalBerakhir < new \DateTime()) ? 'berakhir' : 'aktif';
            
            $data[] = [
                'permohonan_id'   => null,
                'nomor_kerjasama' => 'KS-' . date('Y', $tanggalMulai->getTimestamp()) . '-' . $faker->unique()->numberBetween(1001, 9999),
                'nama_mitra'      => $namaMitra,
                'jenis_mitra'     => $faker->randomElement($jenisMitra),
                'ruang_lingkup'   => $faker->randomElement($ruangLingkupOptions),
                'tanggal_mulai'   => $tanggalMulai->format('Y-m-d'),
                'tanggal_berakhir' => $tanggalBerakhir->format('Y-m-d'),
                'file_kerjasama'  => 'kerjasama_' . $faker->unique()->numberBetween(1000, 9999) . '.pdf',
                'status'          => $status,
                'created_by'      => $faker->randomElement($userIds)['id'],
                'created_at'      => $tanggalMulai->format('Y-m-d H:i:s'),
                'updated_at'      => $faker->dateTimeBetween($tanggalMulai, 'now')->format('Y-m-d H:i:s'),
            ];
        }
        
        // Insert data to table
        $this->db->table('kerjasama')->insertBatch($data);
        
        echo "Kerjasama seeder: " . count($data) . " data inserted.\n";
    }
}
