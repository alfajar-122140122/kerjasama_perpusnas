<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FixUserSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah sudah ada user di database
        $userCount = $this->db->table('users')->countAll();
        
        // Jika belum ada users sama sekali, tambahkan admin default
        if ($userCount === 0) {
            // Insert admin default
            $this->db->table('users')->insert([
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'hak_akses' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            echo "Admin default ditambahkan dengan username 'admin' dan password 'admin123'.\n";
            
            // Insert beberapa user biasa untuk testing
            $users = [
                [
                    'username' => 'user1',
                    'password' => password_hash('user123', PASSWORD_DEFAULT),
                    'hak_akses' => 'user',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'username' => 'user2',
                    'password' => password_hash('user123', PASSWORD_DEFAULT),
                    'hak_akses' => 'user',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'username' => 'perpusnas',
                    'password' => password_hash('perpusnas123', PASSWORD_DEFAULT),
                    'hak_akses' => 'user',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ];
            
            $this->db->table('users')->insertBatch($users);
            echo "3 user testing ditambahkan.\n";
        } else {
            echo "Users sudah tersedia di database. Tidak perlu menambahkan data.\n";
        }
    }
}
