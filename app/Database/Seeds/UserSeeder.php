<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID'); // Indonesian locale
        
        $db = \Config\Database::connect();
        
        // Check if table exists
        if (!$db->tableExists('users')) {
            echo "Table 'users' tidak ditemukan. Jalankan migrasi terlebih dahulu.\n";
            return;
        }

        // Default admin users (real accounts)
        $defaultUsers = [
            [
                'username'    => 'admin',
                'password'    => password_hash('Admin123!', PASSWORD_DEFAULT),
                'hak_akses'   => 'admin',
                'last_active' => $faker->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s'),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'username'    => 'superadmin',
                'password'    => password_hash('SuperAdmin123@', PASSWORD_DEFAULT),
                'hak_akses'   => 'admin',
                'last_active' => $faker->dateTimeBetween('-3 days', 'now')->format('Y-m-d H:i:s'),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'username'    => 'perpusnas_admin',
                'password'    => password_hash('Perpusnas2024!', PASSWORD_DEFAULT),
                'hak_akses'   => 'admin',
                'last_active' => $faker->dateTimeBetween('-1 day', 'now')->format('Y-m-d H:i:s'),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ]
        ];

        // Generate fake users
        $fakeUsers = [];
        for ($i = 1; $i <= 25; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $username = strtolower($firstName . $lastName . $faker->numberBetween(1, 999));
            
            // Ensure secure password with all required criteria
            $passwords = [
                'User123!@#', 'Admin456$%^', 'Pass789&*(', 'Test012)(!', 'Demo345@#$',
                'Secure678%^&', 'Strong901*()','Complex234!@#', 'Random567$%^', 'Sample890&*('
            ];
            
            $fakeUsers[] = [
                'username'    => $username,
                'password'    => password_hash($faker->randomElement($passwords), PASSWORD_DEFAULT),
                'hak_akses'   => $faker->randomElement(['admin', 'user', 'user', 'user']), // More users than admins
                'last_active' => $faker->optional(0.7)->dateTimeBetween('-30 days', 'now')?->format('Y-m-d H:i:s'),
                'created_at'  => $faker->dateTimeBetween('-6 months', '-1 month')->format('Y-m-d H:i:s'),
                'updated_at'  => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
            ];
        }

        // Combine all users
        $allUsers = array_merge($defaultUsers, $fakeUsers);

        // Insert users (skip existing)
        $insertedCount = 0;
        $skippedCount = 0;
        
        foreach ($allUsers as $user) {
            $existingUser = $db->table('users')
                           ->where('username', $user['username'])
                           ->get()
                           ->getRow();
            
            if (!$existingUser) {
                $db->table('users')->insert($user);
                $insertedCount++;
                echo "✓ User '{$user['username']}' berhasil ditambahkan.\n";
            } else {
                $skippedCount++;
                echo "- User '{$user['username']}' sudah ada, dilewati.\n";
            }
        }

        echo "\n=== RINGKASAN USER SEEDER ===\n";
        echo "User berhasil ditambahkan: {$insertedCount}\n";
        echo "User dilewati (sudah ada): {$skippedCount}\n";
        echo "Total user di database: " . $db->table('users')->countAllResults() . "\n";
        
        echo "\n=== AKUN ADMIN DEFAULT ===\n";
        echo "Username: admin | Password: Admin123!\n";
        echo "Username: superadmin | Password: SuperAdmin123@\n";
        echo "Username: perpusnas_admin | Password: Perpusnas2024!\n";
    }
}
