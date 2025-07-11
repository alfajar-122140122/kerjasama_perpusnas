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
        
        // Check if users table already has data
        $usersCount = $this->db->table('users')->countAllResults();
        if ($usersCount == 0) {
            echo "1. SEEDING USERS...\n";
            echo "------------------------------------------\n";
            $this->call('UserSeeder');
        } else {
            echo "1. SKIPPING USERS (already seeded)...\n";
            echo "------------------------------------------\n";
        }
        
        // Check if kerjasama table already has data
        $kerjasamaCount = $this->db->table('kerjasama')->countAllResults();
        if ($kerjasamaCount == 0) {
            echo "\n2. SEEDING KERJASAMA...\n";
            echo "------------------------------------------\n";
            $this->call('KerjasamaSeeder');
        } else {
            echo "\n2. SKIPPING KERJASAMA (already seeded)...\n";
            echo "------------------------------------------\n";
        }
        
        // Check if implementasi_kerjasama table already has data
        $implementasiCount = $this->db->table('implementasi_kerjasama')->countAllResults();
        if ($implementasiCount == 0) {
            echo "\n3. SEEDING IMPLEMENTASI KERJASAMA...\n";
            echo "------------------------------------------\n";
            $this->call('ImplementasiKerjasamaSeeder');
        } else {
            echo "\n3. SKIPPING IMPLEMENTASI KERJASAMA (already seeded)...\n";
            echo "------------------------------------------\n";
        }
        
        // Check if progress_kerjasama table already has data
        $progressCount = $this->db->table('progress_kerjasama')->countAllResults();
        if ($progressCount == 0) {
            echo "\n4. SEEDING PROGRESS KERJASAMA...\n";
            echo "------------------------------------------\n";
            $this->call('ProgressKerjasamaSeeder');
        } else {
            echo "\n4. SKIPPING PROGRESS KERJASAMA (already seeded)...\n";
            echo "------------------------------------------\n";
        }
        
        // Check if permohonan_kerjasama table already has data
        $permohonanCount = $this->db->table('permohonan_kerjasama')->countAllResults();
        if ($permohonanCount == 0) {
            echo "\n5. SEEDING PERMOHONAN KERJASAMA...\n";
            echo "------------------------------------------\n";
            $this->call('PermohonanKerjasamaSeeder');
        } else {
            echo "\n5. SKIPPING PERMOHONAN KERJASAMA (already seeded)...\n";
            echo "------------------------------------------\n";
        }
        
        // Check if peta_kerjasama table already has data
        $petaCount = $this->db->table('peta_kerjasama')->countAllResults();
        if ($petaCount == 0) {
            echo "\n6. SEEDING PETA KERJASAMA...\n";
            echo "------------------------------------------\n";
            $this->call('PetaKerjasamaSeeder');
        } else {
            echo "\n6. SKIPPING PETA KERJASAMA (already seeded)...\n";
            echo "------------------------------------------\n";
        }
        
        // Check if log_aktivitas table already has data
        $logCount = $this->db->table('log_aktivitas')->countAllResults();
        if ($logCount == 0) {
            echo "\n7. SEEDING LOG AKTIVITAS...\n";
            echo "------------------------------------------\n";
            $this->call('LogAktivitasSeeder');
        } else {
            echo "\n7. SKIPPING LOG AKTIVITAS (already seeded)...\n";
            echo "------------------------------------------\n";
        }
        
        // Check if berita table already has data
        $beritaCount = $this->db->table('berita')->countAllResults();
        if ($beritaCount == 0) {
            echo "\n8. SEEDING BERITA...\n";
            echo "------------------------------------------\n";
            $this->call('BeritaSeeder');
        } else {
            echo "\n8. SKIPPING BERITA (already seeded)...\n";
            echo "------------------------------------------\n";
        }
        
        echo "\n==========================================\n";
        echo "    DATABASE SEEDING COMPLETED!\n";
        echo "==========================================\n";
        
        // Display final statistics
        $db = \Config\Database::connect();
        
        echo "\n=== RINGKASAN AKHIR DATABASE ===\n";
        echo "Total Users: " . $db->table('users')->countAllResults() . "\n";
        echo "Total Kerjasama: " . $db->table('kerjasama')->countAllResults() . "\n";
        echo "Total Implementasi: " . $db->table('implementasi_kerjasama')->countAllResults() . "\n";
        echo "Total Progress: " . $db->table('progress_kerjasama')->countAllResults() . "\n";
        echo "Total Permohonan: " . $db->table('permohonan_kerjasama')->countAllResults() . "\n";
        echo "Total Peta Kerjasama: " . $db->table('peta_kerjasama')->countAllResults() . "\n";
        echo "Total Log Aktivitas: " . $db->table('log_aktivitas')->countAllResults() . "\n";
        echo "Total Berita: " . $db->table('berita')->countAllResults() . "\n";
    }
}
