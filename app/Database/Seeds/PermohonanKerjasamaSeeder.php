<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PermohonanKerjasamaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        // Ambil ID user
        $userIds = $this->db->table('users')
                       ->select('id')
                       ->get()
                       ->getResultArray();
        
        // Status options
        $statusOptions = ['pending', 'review', 'approved', 'rejected'];
        
        // Prepare data
        $data = [];
        
        // Generate 20 permohonan kerjasama dengan status bervariasi
        for ($i = 0; $i < 20; $i++) {
            $status = $faker->randomElement($statusOptions);
            $createdDate = $faker->dateTimeBetween('-3 months', 'now');
            
            // Jika status bukan pending, set reviewer
            $reviewedBy = null;
            $reviewedAt = null;
            
            if ($status !== 'pending') {
                $reviewedBy = $faker->randomElement($userIds)['id'];
                $reviewedAt = $faker->dateTimeBetween($createdDate, 'now')->format('Y-m-d H:i:s');
            }
            
            // Institusi
            $institusiTypes = ['Universitas', 'Perpustakaan', 'Dinas', 'PT', 'Yayasan', 'Pusat', 'Institut', 'Balai'];
            $institusiNames = ['Nusantara', 'Indonesia', 'Pendidikan', 'Teknologi', 'Informasi', 'Digital', 'Nasional', 'Merdeka', 'Budaya', 'Karya'];
            
            $lembaga = $faker->randomElement($institusiTypes) . ' ' . $faker->randomElement($institusiNames) . ' ' . $faker->city;
            
            $data[] = [
                'jenis_permohonan'      => $faker->randomElement(['baru', 'perpanjangan']),
                'lembaga'               => $lembaga,
                'alamat'                => $faker->address,
                'telepon'               => $faker->phoneNumber,
                'email'                 => $faker->companyEmail,
                'kontak_dapat_dihubungi'=> $faker->name,
                'file_formulir'         => 'formulir_' . $faker->unique()->numberBetween(1000, 9999) . '.pdf',
                'tanggal_pengajuan'     => $createdDate->format('Y-m-d H:i:s'),
                'status'                => $status,
                'reviewed_by'           => $reviewedBy,
                'reviewed_at'           => $reviewedAt,
                'created_at'            => $createdDate->format('Y-m-d H:i:s'),
                'updated_at'            => $faker->dateTimeBetween($createdDate, 'now')->format('Y-m-d H:i:s'),
            ];
        }
        
        // Insert data to table
        $this->db->table('permohonan_kerjasama')->insertBatch($data);
        
        echo "Permohonan Kerjasama seeder: " . count($data) . " data inserted.\n";
    }
}
