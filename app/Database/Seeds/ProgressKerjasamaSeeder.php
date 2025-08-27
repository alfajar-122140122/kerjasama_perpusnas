<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ProgressKerjasamaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        // Ambil ID permohonan yang ada
        $permohonanIds = $this->db->table('permohonan_kerjasama')
                               ->select('id')
                               ->get()
                               ->getResultArray();
                               
        // Ambil ID user yang ada
        $userIds = $this->db->table('users')
                         ->select('id')
                         ->get()
                         ->getResultArray();
        
        if (empty($permohonanIds)) {
            echo "No permohonan records found! Please run PermohonanKerjasamaSeeder first.\n";
            return;
        }
        
        if (empty($userIds)) {
            echo "No user records found! Please run UserSeeder first.\n";
            return;
        }
        
        // Status options
        $statusOptions = ['approved', 'review', 'rejected'];
        
        // Prepare data
        $data = [];
        
        // Buat 2-3 progress untuk setiap permohonan
        foreach ($permohonanIds as $permohonan) {
            $numProgress = $faker->numberBetween(2, 3);
            
            for ($i = 0; $i < $numProgress; $i++) {
                $data[] = [
                    'permohonan_id' => $permohonan['id'],
                    'status'        => $statusOptions[$i % count($statusOptions)],
                    'catatan'       => $faker->paragraph(),
                    'created_by'    => $faker->randomElement($userIds)['id'],
                    'created_at'    => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d H:i:s'),
                ];
            }
        }
        
        // Insert data to table
        $this->db->table('progress_kerjasama')->insertBatch($data);
        
        echo "Progress Kerjasama seeder: " . count($data) . " data inserted.\n";
    }
}
