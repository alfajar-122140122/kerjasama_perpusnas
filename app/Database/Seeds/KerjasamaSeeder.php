<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;
use DateTime;

class KerjasamaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        $db = \Config\Database::connect();
        
        if (!$db->tableExists('kerjasama')) {
            echo "Table 'kerjasama' tidak ditemukan. Jalankan migrasi terlebih dahulu.\n";
            return;
        }

        // Get user IDs for foreign key reference
        $users = $db->table('users')->select('id_user')->get()->getResultArray();
        if (empty($users)) {
            echo "Tidak ada user ditemukan. Jalankan UserSeeder terlebih dahulu.\n";
            return;
        }
        
        $userIds = array_column($users, 'id_user');

        // Indonesia regions for coordinates
        $indonesiaRegions = [
            ['name' => 'Jakarta', 'lat' => -6.2088, 'lng' => 106.8456],
            ['name' => 'Surabaya', 'lat' => -7.2575, 'lng' => 112.7521],
            ['name' => 'Bandung', 'lat' => -6.9175, 'lng' => 107.6191],
            ['name' => 'Medan', 'lat' => 3.5952, 'lng' => 98.6722],
            ['name' => 'Semarang', 'lat' => -6.9667, 'lng' => 110.4167],
            ['name' => 'Makassar', 'lat' => -5.1477, 'lng' => 119.4327],
            ['name' => 'Palembang', 'lat' => -2.9761, 'lng' => 104.7754],
            ['name' => 'Yogyakarta', 'lat' => -7.7956, 'lng' => 110.3695],
            ['name' => 'Denpasar', 'lat' => -8.6705, 'lng' => 115.2126],
            ['name' => 'Banjarmasin', 'lat' => -3.3194, 'lng' => 114.5906]
        ];

        // Partner types
        $partnerTypes = [
            'Universitas', 'Perpustakaan Daerah', 'Lembaga Penelitian', 'Instansi Pemerintah',
            'Organisasi Internasional', 'Perusahaan Swasta', 'Yayasan', 'NGO',
            'Perpustakaan Umum', 'Sekolah Tinggi', 'Institut', 'Akademi'
        ];

        // Cooperation scopes
        $cooperationScopes = [
            'Pengembangan koleksi digital',
            'Pertukaran pustakawan',
            'Digitalisasi naskah kuno',
            'Pengembangan sistem informasi',
            'Pelatihan dan workshop',
            'Penelitian bersama',
            'Pengembangan aplikasi',
            'Konservasi bahan pustaka',
            'Pengembangan metadata',
            'Program literasi digital',
            'Standardisasi katalog',
            'Pengembangan repositori',
            'Kerjasama publikasi',
            'Pengembangan database',
            'Transfer teknologi'
        ];

        // Create realistic partner names
        $partnerNames = [
            "Universitas {$faker->city}",
            "Perpustakaan Daerah {$faker->city}",
            "Institut Teknologi {$faker->city}",
            "Dinas Perpustakaan {$faker->state}",
            "Lembaga Penelitian {$faker->company}",
            "Yayasan {$faker->lastName} Foundation",
            "Perpustakaan Umum {$faker->city}",
            "Sekolah Tinggi {$faker->jobTitle}",
            "{$faker->company} Research Center",
            "Akademi {$faker->jobTitle} {$faker->city}"
        ];

        // Generate fake kerjasama data
        $kerjasamaData = [];
        for ($i = 1; $i <= 50; $i++) {
            $partnerType = $faker->randomElement($partnerTypes);
            $region = $faker->randomElement($indonesiaRegions);
            
            // Generate dates with proper logic
            $startDate = $faker->dateTimeBetween('-2 years', '+6 months');
            $endDate = $faker->dateTimeBetween($startDate, $startDate->format('Y-m-d') . ' +3 years');
            
            $createdDate = $faker->dateTimeBetween('-1 year', 'now');

            $kerjasamaData[] = [
                'nama_mitra' => $faker->randomElement($partnerNames),
                'ruang_lingkup' => implode(', ', $faker->randomElements($cooperationScopes, $faker->numberBetween(1, 3))),
                'tanggal_mulai' => $startDate->format('Y-m-d H:i:s'),
                'tanggal_selesai' => $endDate->format('Y-m-d H:i:s'),
                'jenis' => $faker->randomElement(['Bilateral', 'Multilateral', 'Tripartit', 'Konsorsium']),
                'progress' => $faker->randomElement(['Perencanaan', 'Berjalan', 'Selesai', 'Tertunda', 'Evaluasi']),
                'latitude' => $region['lat'] + $faker->randomFloat(4, -0.1, 0.1),
                'longitude' => $region['lng'] + $faker->randomFloat(4, -0.1, 0.1),
                'created_by_user_id' => $faker->randomElement($userIds),
                'created_at' => $createdDate->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTimeBetween($createdDate, 'now')->format('Y-m-d H:i:s'),
            ];
        }

        // Insert data
        $insertedCount = 0;
        foreach ($kerjasamaData as $kerjasama) {
            try {
                $db->table('kerjasama')->insert($kerjasama);
                $insertedCount++;
                echo "✓ Kerjasama dengan '{$kerjasama['nama_mitra']}' berhasil ditambahkan.\n";
            } catch (\Exception $e) {
                echo "✗ Gagal menambahkan kerjasama: " . $e->getMessage() . "\n";
            }
        }

        echo "\n=== RINGKASAN KERJASAMA SEEDER ===\n";
        echo "Kerjasama berhasil ditambahkan: {$insertedCount}\n";
        echo "Total kerjasama di database: " . $db->table('kerjasama')->countAllResults() . "\n";
    }
}
