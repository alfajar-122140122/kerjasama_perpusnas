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
        
        // 1. Users (base table)
        $this->call('UserSeeder');
        echo "1. Users seeded successfully\n";
        
        // 2. Permohonan Kerjasama (depends on users)
        $this->call('PermohonanKerjasamaSeeder');
        echo "2. Permohonan Kerjasama seeded successfully\n";
        
        // 3. Progress Kerjasama (depends on permohonan and users)
        // $this->call('ProgressKerjasamaSeeder');
        // echo "3. Progress Kerjasama seeded successfully\n";
        
        // 4. Kerjasama (depends on permohonan and users)
        $this->call('KerjasamaSeeder');
        echo "4. Kerjasama seeded successfully\n";
        
        // 5. Implementasi Kerjasama (depends on kerjasama)
        $this->call('ImplementasiKerjasamaSeeder');
        echo "5. Implementasi Kerjasama seeded successfully\n";
        
        // 6. Peta Kerjasama (depends on kerjasama)
        $this->call('PetaKerjasamaSeeder');
        echo "6. Peta Kerjasama seeded successfully\n";
        
        // 7. Log Aktivitas (depends on users)
        $this->call('LogAktivitasSeeder');
        echo "7. Log Aktivitas seeded successfully\n";
        
        // 8. Berita (depends on users)
        $this->call('BeritaSeeder');
        echo "8. Berita seeded successfully\n";
        
        echo "\n==========================================\n";
        echo "    DATABASE SEEDING COMPLETED!\n";
        echo "==========================================\n";
    }
}
