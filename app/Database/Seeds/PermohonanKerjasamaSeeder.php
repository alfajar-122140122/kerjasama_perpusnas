<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PermohonanKerjasamaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        $db = \Config\Database::connect();
        
        if (!$db->tableExists('permohonan_kerjasama')) {
            echo "Table 'permohonan_kerjasama' tidak ditemukan. Jalankan migrasi terlebih dahulu.\n";
            return;
        }

        // Get existing user IDs
        $userIds = $db->table('users')->select('id_user')->get()->getResultArray();
        $userIds = array_column($userIds, 'id_user');
        
        if (empty($userIds)) {
            echo "Tidak ada user di database. Jalankan UserSeeder terlebih dahulu.\n";
            return;
        }

        // Institution types for applicants
        $institutionTypes = [
            'Universitas Negeri',
            'Universitas Swasta',
            'Institut Teknologi',
            'Sekolah Tinggi',
            'Perpustakaan Daerah',
            'Perpustakaan Kota',
            'Lembaga Penelitian',
            'Yayasan Pendidikan',
            'Organisasi Profesi',
            'Perusahaan Swasta',
            'NGO/LSM',
            'Komunitas Literasi'
        ];

        // Cooperation types being requested
        $cooperationTypes = [
            'Kerjasama Pengembangan Koleksi Digital',
            'Program Pertukaran Pustakawan',
            'Pelatihan dan Workshop',
            'Kerjasama Penelitian',
            'Pengembangan Sistem Informasi',
            'Digitalisasi Koleksi',
            'Konservasi Bahan Pustaka',
            'Pengembangan Database',
            'Standardisasi Metadata',
            'Program Literasi',
            'Kerjasama Publikasi',
            'Transfer Teknologi',
            'Pengembangan Aplikasi',
            'Sertifikasi Pustakawan',
            'Jaringan Perpustakaan'
        ];

        // Request statuses
        $requestStatuses = [
            'pending',
            'under_review',
            'approved',
            'rejected',
            'need_revision',
            'completed'
        ];

        // Generate fake permohonan data
        $permohonanData = [];
        for ($i = 1; $i <= 40; $i++) {
            $institutionType = $faker->randomElement($institutionTypes);
            $requestDate = $faker->dateTimeBetween('-6 months', 'now');
            
            // Create realistic institution names
            $institutionNames = [
                $institutionType . ' ' . $faker->city,
                $institutionType . ' ' . $faker->lastName,
                $institutionType . ' ' . $faker->state,
                'Perpustakaan ' . $faker->company,
                'Yayasan ' . $faker->lastName . ' Foundation',
                'Lembaga ' . $faker->jobTitle . ' ' . $faker->city
            ];
            
            $cooperationType = $faker->randomElement($cooperationTypes);
            $status = $faker->randomElement($requestStatuses);
            
            // Generate proposal description
            $proposalDesc = "Permohonan kerjasama dalam bidang {$cooperationType} antara " . 
                          $faker->randomElement($institutionNames) . 
                          " dengan Perpustakaan Nasional Indonesia. " .
                          "Tujuan utama kerjasama ini adalah " . 
                          strtolower($faker->sentence($faker->numberBetween(8, 15))) . 
                          " Program ini diharapkan dapat memberikan manfaat bagi kedua belah pihak dalam " .
                          "pengembangan layanan perpustakaan yang lebih baik.";

            // Add expected outcomes
            $proposalDesc .= "\n\nLuaran yang diharapkan:\n";
            for ($j = 1; $j <= $faker->numberBetween(3, 6); $j++) {
                $proposalDesc .= "{$j}. " . $faker->sentence($faker->numberBetween(5, 10)) . "\n";
            }

            // Add timeline
            $proposalDesc .= "\nRencana Timeline:\n";
            $proposalDesc .= "- Tahap Persiapan: " . $faker->monthName . " - " . $faker->monthName . "\n";
            $proposalDesc .= "- Tahap Implementasi: " . $faker->monthName . " - " . $faker->monthName . "\n";
            $proposalDesc .= "- Tahap Evaluasi: " . $faker->monthName . "\n";

            $permohonanData[] = [
                'jenis_permohonan' => $cooperationType,
                'lembaga' => $faker->randomElement($institutionNames),
                'alamat' => $faker->address,
                'telepon' => $faker->phoneNumber,
                'email' => $faker->email,
                'unit_terkait' => $faker->randomElement([
                    'Bidang Layanan Perpustakaan',
                    'Bidang Pengembangan Koleksi',
                    'Bidang Teknologi Informasi',
                    'Bidang Kerjasama dan Humas'
                ]),
                'kontak_dapat_dihubungi' => $faker->name,
                'file_formulir' => null, // Optional file upload
                'tanggal_pengajuan' => $requestDate->format('Y-m-d'),
                'kerjasama_id' => null, // Will be linked after kerjasama is created
                'created_by_user_id' => $faker->randomElement($userIds),
            ];
        }

        // Insert data
        $insertedCount = 0;
        foreach ($permohonanData as $permohonan) {
            try {
                $db->table('permohonan_kerjasama')->insert($permohonan);
                $insertedCount++;
                echo "✓ Permohonan dari '{$permohonan['lembaga']}' berhasil ditambahkan.\n";
            } catch (\Exception $e) {
                echo "✗ Gagal menambahkan permohonan: " . $e->getMessage() . "\n";
            }
        }

        echo "\n=== RINGKASAN PERMOHONAN KERJASAMA SEEDER ===\n";
        echo "Permohonan berhasil ditambahkan: {$insertedCount}\n";
        echo "Total permohonan di database: " . $db->table('permohonan_kerjasama')->countAllResults() . "\n";
        
        // Show statistics
        $statusStats = $db->query("SELECT jenis_permohonan, COUNT(*) as jumlah FROM permohonan_kerjasama GROUP BY jenis_permohonan")->getResultArray();
        echo "\n=== STATISTIK JENIS PERMOHONAN ===\n";
        foreach ($statusStats as $stat) {
            echo "- {$stat['jenis_permohonan']}: {$stat['jumlah']} permohonan\n";
        }
    }
}
