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
        
        // Indonesia's coordinates boundaries (approximate)
        $minLat = -11.0;
        $maxLat = 6.0;
        $minLng = 95.0;
        $maxLng = 141.0;
        
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
        
        // Generate 5 random locations
        $randomCities = $faker->randomElements($indonesianCities, 5);
        $selectedKerjasamaIds = array_slice($kerjasamaIds, 0, 5);
        
        foreach (array_keys($selectedKerjasamaIds) as $i) {
            $city = $randomCities[$i];
            
            // Add some randomization to the coordinates
            $latitude = $city[1] + $faker->randomFloat(6, -0.05, 0.05);
            $longitude = $city[2] + $faker->randomFloat(6, -0.05, 0.05);
            
            $data[] = [
                'kerjasama_id'     => $selectedKerjasamaIds[$i]['id'],
                'latitude'         => $latitude,
                'longitude'        => $longitude,
                'deskripsi_lokasi' => 'Lokasi Kerjasama di ' . $city[0] . ', ' . $faker->streetAddress,
                'created_at'       => date('Y-m-d H:i:s'),
            ];
        }
        
        // Insert data to table
        $this->db->table('peta_kerjasama')->insertBatch($data);
        
        echo "Peta Kerjasama seeder: " . count($data) . " data inserted.\n";
    }
}
