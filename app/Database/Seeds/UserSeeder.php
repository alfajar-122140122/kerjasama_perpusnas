<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        // Define users (2 admin, 3 staff)
        $users = [
            // Admin users
            [
                'username'      => 'admin1',
                'email'         => 'admin1@perpusnas.go.id',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'          => 'admin',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'admin2',
                'email'         => 'admin2@perpusnas.go.id',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'          => 'admin',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            // Staff users
            [
                'username'      => 'staff1',
                'email'         => $faker->unique()->email,
                'password_hash' => password_hash('staff123', PASSWORD_DEFAULT),
                'role'          => 'staff',
                'created_at'    => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'updated_at'    => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'staff2',
                'email'         => $faker->unique()->email,
                'password_hash' => password_hash('staff123', PASSWORD_DEFAULT),
                'role'          => 'staff',
                'created_at'    => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'updated_at'    => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'staff3',
                'email'         => $faker->unique()->email,
                'password_hash' => password_hash('staff123', PASSWORD_DEFAULT),
                'role'          => 'staff',
                'created_at'    => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'updated_at'    => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s'),
            ],
        ];

        // Insert data to table
        $this->db->table('users')->insertBatch($users);
        
        echo "User seeder: " . count($users) . " data inserted.\n";
    }
}
