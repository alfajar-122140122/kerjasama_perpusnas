<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PetaKerjasamaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        // Get existing kerjasama IDs
        $kerjasamaIds = $this->db->table('kerjasama')
                               ->select('id')
                               ->get()
                               ->getResultArray();
        
        if (empty($kerjasamaIds)) {
            echo "No kerjasama records found! Please run KerjasamaSeeder first.\n";
            return;
        }
        
        // Prepare data
        $data = [];
        
        // Major cities in Indonesia with coordinates
        $indonesianCities = [
            ['Jakarta', -6.2088, 106.8456],
            ['Surabaya', -7.2575, 112.7521],
            ['Medan', 3.5952, 98.6722],
            ['Bandung', -6.9175, 107.6191],
            ['Makassar', -5.1477, 119.4327],
            ['Semarang', -6.9932, 110.4203],
            ['Palembang', -2.9761, 104.7754],
            ['Yogyakarta', -7.7971, 110.3688],
            ['Denpasar', -8.6705, 115.2126],
            ['Balikpapan', -1.2379, 116.8529],
            ['Padang', -0.9471, 100.4172],
            ['Pontianak', 0.0263, 109.3425]
        ];
        
        // Create one map entry for each kerjasama
        foreach ($kerjasamaIds as $index => $kerjasama) {
            // Cycle through cities or pick random if more kerjasama than cities
            $cityIndex = $index % count($indonesianCities);
            $city = $indonesianCities[$cityIndex];
            
            // Add some randomization to the coordinates
            $latitude = $city[1] + $faker->randomFloat(6, -0.05, 0.05);
            $longitude = $city[2] + $faker->randomFloat(6, -0.05, 0.05);
            
            $createdDate = $faker->dateTimeBetween('-1 year', 'now');
            
            $data[] = [
                'kerjasama_id'     => $kerjasama['id'],
                'latitude'         => $latitude,
                'longitude'        => $longitude,
                'deskripsi_lokasi' => 'Lokasi Kerjasama di ' . $city[0] . ', ' . $faker->streetAddress,
                'created_at'       => $createdDate->format('Y-m-d H:i:s'),
                'updated_at'       => $faker->dateTimeBetween($createdDate, 'now')->format('Y-m-d H:i:s'),
            ];
        }
        
        // Insert data to table
        $this->db->table('peta_kerjasama')->insertBatch($data);
        
        echo "Peta Kerjasama seeder: " . count($data) . " data inserted.\n";
    }
}
