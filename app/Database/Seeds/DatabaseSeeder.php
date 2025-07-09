<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        echo "==========================================\n";
        echo "    PERPUSTAKAAN NASIONAL DATABASE SEEDER\n";
        echo "==========================================\n\n";
        
        // Run seeders in proper order (considering foreign key dependencies)
        
        echo "1. SEEDING USERS...\n";
        echo "------------------------------------------\n";
        $this->call('UserSeeder');
        
        echo "\n2. SEEDING KERJASAMA...\n";
        echo "------------------------------------------\n";
        $this->call('KerjasamaSeeder');
        
        echo "\n3. SEEDING IMPLEMENTASI KERJASAMA...\n";
        echo "------------------------------------------\n";
        $this->call('ImplementasiKerjasamaSeeder');
        
        echo "\n4. SEEDING BERITA...\n";
        echo "------------------------------------------\n";
        $this->call('BeritaSeeder');
        
        echo "\n5. SEEDING PERMOHONAN KERJASAMA...\n";
        echo "------------------------------------------\n";
        $this->call('PermohonanKerjasamaSeeder');
        
        echo "\n==========================================\n";
        echo "    DATABASE SEEDING COMPLETED!\n";
        echo "==========================================\n";
        
        // Display final statistics
        $db = \Config\Database::connect();
        
        echo "\n=== RINGKASAN AKHIR DATABASE ===\n";
        echo "Total Users: " . $db->table('users')->countAllResults() . "\n";
        echo "Total Kerjasama: " . $db->table('kerjasama')->countAllResults() . "\n";
        echo "Total Implementasi: " . $db->table('implementasi_kerjasama')->countAllResults() . "\n";
        echo "Total Berita: " . $db->table('berita')->countAllResults() . "\n";
        echo "Total Permohonan: " . $db->table('permohonan_kerjasama')->countAllResults() . "\n";
        
        echo "\n=== AKUN TESTING ===\n";
        echo "Admin Account:\n";
        echo "- Username: admin | Password: Admin123!\n";
        echo "- Username: superadmin | Password: SuperAdmin123@\n";
        echo "- Username: perpusnas_admin | Password: Perpusnas2024!\n";
        
        echo "\nNOTE: Semua password memenuhi kriteria keamanan\n";
        echo "(Huruf besar, kecil, angka, karakter khusus)\n";
        
        echo "\n==========================================\n";
    }
}
