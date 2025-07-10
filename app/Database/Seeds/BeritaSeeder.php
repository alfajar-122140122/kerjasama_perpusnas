<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        $db = \Config\Database::connect();
        
        if (!$db->tableExists('berita')) {
            echo "Table 'berita' tidak ditemukan. Jalankan migrasi terlebih dahulu.\n";
            return;
        }

        // Get user IDs for foreign key reference
        $users = $db->table('users')->select('id_user')->get()->getResultArray();
        if (empty($users)) {
            echo "Tidak ada user ditemukan. Jalankan UserSeeder terlebih dahulu.\n";
            return;
        }
        
        $userIds = array_column($users, 'id_user');

        // News categories and topics related to library cooperation
        $newsTopics = [
            'Kerjasama Perpustakaan Nasional dengan Universitas Terkemuka',
            'Digitalisasi Koleksi Naskah Kuno Melalui Kerjasama Internasional',
            'Program Pertukaran Pustakawan Antar Negara',
            'Pengembangan Sistem Informasi Perpustakaan Digital',
            'Workshop Konservasi Bahan Pustaka Bersejarah',
            'Peluncuran Database Kolaboratif Perpustakaan',
            'Seminar Internasional tentang Literasi Digital',
            'Kerjasama Pengembangan Repositori Institusi',
            'Program Pelatihan Teknologi Perpustakaan',
            'Standardisasi Metadata Koleksi Digital',
            'Inisiasi Jaringan Perpustakaan Nasional',
            'Pengembangan Aplikasi Mobile untuk Layanan Perpustakaan',
            'Kerjasama Penelitian Bidang Ilmu Perpustakaan',
            'Implementasi Sistem Katalog Terpadu',
            'Program Literasi Informasi untuk Masyarakat'
        ];

        $newsContent = [
            "Perpustakaan Nasional Indonesia resmi menjalin kerjasama strategis dengan berbagai institusi pendidikan dan penelitian dalam rangka pengembangan layanan perpustakaan yang lebih komprehensif dan modern.",
            "Dalam upaya melestarikan khazanah budaya bangsa, Perpustakaan Nasional melakukan digitalisasi koleksi naskah kuno melalui kerjasama dengan lembaga internasional yang memiliki teknologi canggih.",
            "Program pertukaran pustakawan merupakan bagian dari upaya peningkatan kapasitas sumber daya manusia di bidang perpustakaan dan informasi melalui transfer pengetahuan antar negara.",
            "Pengembangan sistem informasi perpustakaan digital dilakukan untuk meningkatkan aksesibilitas informasi bagi masyarakat luas dengan memanfaatkan teknologi terkini.",
            "Workshop konservasi bahan pustaka bersejarah diselenggarakan sebagai bentuk komitmen dalam melestarikan warisan budaya bangsa untuk generasi mendatang.",
            "Peluncuran database kolaboratif perpustakaan memungkinkan sharing resources antar perpustakaan untuk memberikan layanan yang lebih optimal kepada pengguna.",
            "Seminar internasional tentang literasi digital bertujuan untuk meningkatkan kemampuan masyarakat dalam mengakses, mengevaluasi, dan menggunakan informasi digital secara efektif.",
            "Kerjasama pengembangan repositori institusi dilakukan untuk menciptakan sistem penyimpanan dan akses karya ilmiah yang terstandarisasi dan mudah diakses.",
            "Program pelatihan teknologi perpustakaan dirancang untuk meningkatkan kompetensi pustakawan dalam menghadapi era digital dan perkembangan teknologi informasi.",
            "Standardisasi metadata koleksi digital sangat penting untuk memastikan interoperabilitas sistem dan kemudahan pencarian informasi di berbagai platform."
        ];

        // Generate fake news data
        $beritaData = [];
        for ($i = 1; $i <= 30; $i++) {
            $publishDate = $faker->dateTimeBetween('-1 year', 'now');
            $createdDate = $faker->dateTimeBetween('-1 year', $publishDate);
            
            // Create realistic news content
            $title = $faker->randomElement($newsTopics);
            $content = $faker->randomElement($newsContent);
            
            // Add more paragraphs to make it realistic
            for ($j = 0; $j < $faker->numberBetween(2, 5); $j++) {
                $content .= "\n\n" . $faker->paragraph($faker->numberBetween(3, 8));
            }
            
            // Add quote or additional information
            $content .= "\n\n\"" . $faker->sentence($faker->numberBetween(8, 15)) . "\", ujar " . $faker->name . ", " . $faker->jobTitle . " Perpustakaan Nasional.";
            
            // Add closing paragraph
            $content .= "\n\n" . $faker->paragraph($faker->numberBetween(2, 4));

            // Generate image filename (simulated)
            $imageTypes = ['jpg', 'jpeg', 'png'];
            $imageName = 'berita_' . $i . '.' . $faker->randomElement($imageTypes);

            $beritaData[] = [
                'judul' => $title,
                'isi_berita' => $content,
                'gambar' => $imageName,
                'tanggal_publikasi' => $publishDate->format('Y-m-d H:i:s'),
                'status' => $faker->randomElement(['draft', 'published']),
                'created_by_user_id' => $faker->randomElement($userIds),
                'created_at' => $createdDate->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTimeBetween($createdDate, 'now')->format('Y-m-d H:i:s'),
            ];
        }

        // Insert data
        $insertedCount = 0;
        foreach ($beritaData as $berita) {
            try {
                $db->table('berita')->insert($berita);
                $insertedCount++;
                echo "✓ Berita '{$berita['judul']}' berhasil ditambahkan.\n";
            } catch (\Exception $e) {
                echo "✗ Gagal menambahkan berita: " . $e->getMessage() . "\n";
            }
        }

        echo "\n=== RINGKASAN BERITA SEEDER ===\n";
        echo "Berita berhasil ditambahkan: {$insertedCount}\n";
        echo "Total berita di database: " . $db->table('berita')->countAllResults() . "\n";
    }
}
