<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        // Get existing user IDs
        $userIds = $this->db->table('users')
                         ->select('id')
                         ->get()
                         ->getResultArray();
        
        if (empty($userIds)) {
            echo "No user records found! Please run UserSeeder first.\n";
            return;
        }
        
        // Prepare data
        $data = [];
        
        // Sample berita titles
        $judulOptions = [
            'Perpustakaan Nasional Luncurkan Portal Digital Naskah Kuno Nusantara',
            'Kerjasama Baru: Digitalisasi Arsip Sejarah Dengan Google Indonesia',
            'Seminar Nasional Literasi Digital 2025 Digelar Di Perpustakaan Nasional',
            'Perpustakaan Nasional Raih Penghargaan Pelestarian Warisan Dokumenter',
            'Program Magang Internasional Perpusnas Dibuka Untuk Mahasiswa',
            'Pameran Naskah Kuno Nusantara Hadirkan Koleksi Langka',
            'Aplikasi Mobile Perpusnas: Akses Koleksi Perpustakaan Dalam Genggaman',
            'Workshop Digitalisasi Dan Preservasi Koleksi Langka',
            'Kerjasama Antar Perpustakaan ASEAN Ditandatangani',
            'Katalog Digital Terintegrasi Diluncurkan',
            'Kolaborasi Perpusnas dan Microsoft Kembangkan AI Untuk Penelusuran Arsip',
            'Festival Literasi Nasional 2025 Digelar Di 34 Provinsi',
            'Perpusnas Gelar Pelatihan Pustakawan Digital Era 4.0',
            'Sistem Repositori Digital Berbasis Cloud Diimplementasikan',
            'Koleksi E-Book Perpusnas Bertambah 10.000 Judul'
        ];
        
        // Status options
        $statusOptions = ['draft', 'published', 'archived'];
        
        // Generate 15 random news articles
        for ($i = 0; $i < 15; $i++) {
            $createdDate = $faker->dateTimeBetween('-1 year', 'now');
            $publishedDate = clone $createdDate;
            $publishedDate->modify('+' . $faker->numberBetween(1, 14) . ' days');
            
            // Generate random paragraphs for news content
            $paragraphs = $faker->paragraphs($faker->numberBetween(3, 6));
            $content = '';
            foreach ($paragraphs as $paragraph) {
                $content .= "<p>{$paragraph}</p>\n";
            }
            
            $status = $faker->randomElement($statusOptions);
            // If status is draft, set published date to null
            if ($status === 'draft') {
                $publishedDate = null;
            }
            
            $data[] = [
                'judul'             => $judulOptions[$i] ?? $faker->sentence($faker->numberBetween(6, 12)),
                'isi_berita'        => $content,
                'gambar'            => 'berita_' . $faker->numberBetween(1000, 9999) . '.jpg',
                'tanggal_publikasi' => $publishedDate ? $publishedDate->format('Y-m-d H:i:s') : null,
                'created_by_user_id' => $faker->randomElement($userIds)['id'],
                'created_at'        => $createdDate->format('Y-m-d H:i:s'),
                'updated_at'        => $faker->dateTimeBetween($createdDate, 'now')->format('Y-m-d H:i:s'),
                'status'            => $status,
            ];
        }
        
        // Insert data to table
        $this->db->table('berita')->insertBatch($data);
        
        echo "Berita seeder: " . count($data) . " data inserted.\n";
    }
}
