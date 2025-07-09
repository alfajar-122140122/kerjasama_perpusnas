<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ImplementasiKerjasamaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        $db = \Config\Database::connect();
        
        if (!$db->tableExists('implementasi_kerjasama')) {
            echo "Table 'implementasi_kerjasama' tidak ditemukan. Jalankan migrasi terlebih dahulu.\n";
            return;
        }

        // Get kerjasama IDs for foreign key reference
        $kerjasamaList = $db->table('kerjasama')->select('id_kerjasama')->get()->getResultArray();
        if (empty($kerjasamaList)) {
            echo "Tidak ada kerjasama ditemukan. Jalankan KerjasamaSeeder terlebih dahulu.\n";
            return;
        }
        
        $kerjasamaIds = array_column($kerjasamaList, 'id_kerjasama');

        // Get user IDs for foreign key reference
        $users = $db->table('users')->select('id_user')->get()->getResultArray();
        if (empty($users)) {
            echo "Tidak ada user ditemukan. Jalankan UserSeeder terlebih dahulu.\n";
            return;
        }
        
        $userIds = array_column($users, 'id_user');

        // Implementation activity names
        $implementationActivities = [
            'Workshop Digitalisasi Koleksi',
            'Pelatihan Sistem Katalog Digital',
            'Seminar Konservasi Bahan Pustaka',
            'Program Pertukaran Pustakawan',
            'Pengembangan Database Kolaboratif',
            'Training Metadata Standards',
            'Implementasi Sistem Repositori',
            'Workshop Literasi Digital',
            'Pengembangan Aplikasi Mobile',
            'Standardisasi Format Data',
            'Program Magang Pustakawan',
            'Konferensi Teknologi Perpustakaan',
            'Pelatihan Preservasi Digital',
            'Workshop User Experience Design',
            'Program Sertifikasi Pustakawan',
            'Implementasi Open Access Policy',
            'Training Information Literacy',
            'Pengembangan Discovery System',
            'Workshop Data Management',
            'Program Mentoring Pustakawan'
        ];

        // Implementation scopes
        $implementationScopes = [
            'Institusi Internal',
            'Kerjasama Bilateral',
            'Jaringan Perpustakaan',
            'Konsorsium Regional',
            'Program Nasional',
            'Kerjasama Internasional',
            'Komunitas Lokal',
            'Sektor Pendidikan',
            'Industri Swasta',
            'Organisasi Non-Profit'
        ];

        // Results and outcomes
        $implementationResults = [
            'Peningkatan kapasitas SDM pustakawan sebesar 40%',
            'Berhasil mendigitalkan 1,500 koleksi naskah kuno',
            'Implementasi sistem katalog baru dengan 95% tingkat kepuasan',
            'Pengembangan 3 modul pelatihan standar internasional',
            'Peningkatan akses koleksi digital hingga 200%',
            'Sertifikasi 25 pustakawan dengan standar internasional',
            'Peluncuran platform digital dengan 10,000+ pengguna aktif',
            'Peningkatan kolaborasi antar perpustakaan sebesar 60%',
            'Pengembangan metadata standard untuk 5,000+ item koleksi',
            'Implementasi sistem preservasi digital untuk koleksi langka',
            'Pelatihan 100+ pustakawan dalam teknologi terbaru',
            'Pengembangan aplikasi mobile dengan rating 4.8/5',
            'Standarisasi proses kerja di 15 perpustakaan mitra',
            'Peningkatan literasi digital masyarakat sebesar 45%',
            'Pengembangan repository institusi dengan 50,000+ dokumen'
        ];

        // Generate fake implementation data
        $implementasiData = [];
        foreach ($kerjasamaIds as $kerjasamaId) {
            // Each kerjasama has 1-4 implementations
            $numImplementations = $faker->numberBetween(1, 4);
            
            for ($i = 0; $i < $numImplementations; $i++) {
                $startDate = $faker->dateTimeBetween('-1 year', '+3 months');
                $endDate = $faker->dateTimeBetween($startDate, $startDate->format('Y-m-d') . ' +6 months');
                
                $implementasiData[] = [
                    'id_kerjasama' => $kerjasamaId,
                    'nama_kegiatan' => $faker->randomElement($implementationActivities),
                    'tanggal_mulai' => $startDate->format('Y-m-d H:i:s'),
                    'tanggal_selesai' => $endDate->format('Y-m-d H:i:s'),
                    'lingkup_implementasi' => $faker->randomElement($implementationScopes),
                    'hasil_kegiatan' => $faker->randomElement($implementationResults),
                    'created_by_user_id' => $faker->randomElement($userIds),
                    'created_at' => $faker->dateTimeBetween('-8 months', 'now')->format('Y-m-d H:i:s'),
                    'updated_at' => $faker->dateTimeBetween('-4 months', 'now')->format('Y-m-d H:i:s'),
                ];
            }
        }

        // Insert data
        $insertedCount = 0;
        foreach ($implementasiData as $implementasi) {
            try {
                $db->table('implementasi_kerjasama')->insert($implementasi);
                $insertedCount++;
                echo "✓ Implementasi '{$implementasi['nama_kegiatan']}' berhasil ditambahkan.\n";
            } catch (\Exception $e) {
                echo "✗ Gagal menambahkan implementasi: " . $e->getMessage() . "\n";
            }
        }

        echo "\n=== RINGKASAN IMPLEMENTASI KERJASAMA SEEDER ===\n";
        echo "Implementasi berhasil ditambahkan: {$insertedCount}\n";
        echo "Total implementasi di database: " . $db->table('implementasi_kerjasama')->countAllResults() . "\n";
    }
}
