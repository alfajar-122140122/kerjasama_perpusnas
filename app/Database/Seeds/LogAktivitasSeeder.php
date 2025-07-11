<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class LogAktivitasSeeder extends Seeder
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
        
        // Activity options
        $aktivitasOptions = [
            'Login sistem',
            'Menambahkan data kerjasama baru',
            'Mengedit data kerjasama ID: {id}',
            'Menghapus data kerjasama ID: {id}',
            'Mengubah status kerjasama ID: {id}',
            'Membuat laporan kerjasama',
            'Mengupload dokumen kerjasama',
            'Mengedit profil',
            'Mengunduh dokumen',
            'Melihat detail kerjasama ID: {id}',
            'Menambahkan implementasi kerjasama',
            'Melihat dashboard',
            'Logout sistem'
        ];
        
        // Generate 10 random log entries
        for ($i = 0; $i < 10; $i++) {
            $aktivitas = $faker->randomElement($aktivitasOptions);
            $aktivitas = str_replace('{id}', $faker->numberBetween(1, 10), $aktivitas);
            
            $data[] = [
                'user_id'     => $faker->randomElement($userIds)['id'],
                'aktivitas'   => $aktivitas,
                'tanggal_log' => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d H:i:s'),
            ];
        }
        
        // Insert data to table
        $this->db->table('log_aktivitas')->insertBatch($data);
        
        echo "Log Aktivitas seeder: " . count($data) . " data inserted.\n";
    }
}
