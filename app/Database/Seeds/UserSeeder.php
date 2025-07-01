<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        helper('password_helper');
        
        // Cek apakah sudah ada admin
        $userModel = model('UserModel');
        $existingAdmin = $userModel->where('hak_akses', 'admin')->first();
        
        if (!$existingAdmin) {
            // Buat user admin default
            $data = [
                'username' => 'admin', 
                'password' => 'Admin123@', // Password akan di-hash otomatis oleh model
                'hak_akses' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $userModel->insert($data);
            
            echo "Admin user berhasil dibuat:\n";
            echo "Username: admin\n"; 
            echo "Password: Admin123@\n";
            echo "Pastikan untuk mengubah password default setelah login pertama!\n";
        } else {
            echo "User admin sudah ada, skip membuat user admin default.\n";
        }
        
        // Buat beberapa user demo (opsional)
        $demoUsers = [
            [
                'username' => 'user1',
                'password' => 'User123@',
                'hak_akses' => 'user'
            ],
            [
                'username' => 'user2', 
                'password' => 'User456#',
                'hak_akses' => 'user'
            ]
        ];
        
        foreach ($demoUsers as $demoUser) {
            // Cek apakah user sudah ada
            $existingUser = $userModel->where('username', $demoUser['username'])->first();
            
            if (!$existingUser) {
                $demoUser['created_at'] = date('Y-m-d H:i:s');
                $demoUser['updated_at'] = date('Y-m-d H:i:s');
                
                $userModel->insert($demoUser);
                echo "Demo user '{$demoUser['username']}' berhasil dibuat.\n";
            }
        }
    }
}
