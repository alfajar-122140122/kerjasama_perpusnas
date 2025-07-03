<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddActiveToUsers extends Migration
{
    public function up()
    {
        // Add active field to users table if it doesn't exist
        $db = \Config\Database::connect();
        $fields = $db->getFieldData('users');
        
        // Check if active field already exists
        $activeExists = false;
        foreach ($fields as $field) {
            if ($field->name === 'active') {
                $activeExists = true;
                break;
            }
        }
        
        if (!$activeExists) {
            $this->forge->addColumn('users', [
                'active' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 1, // Default to active
                    'after' => 'hak_akses'
                ]
            ]);
            
            // Set all existing users to active
            $this->db->table('users')->update(['active' => 1]);
        }
    }

    public function down()
    {
        // Check if the active field exists in users table
        $db = \Config\Database::connect();
        $fields = $db->getFieldData('users');
        
        $activeExists = false;
        foreach ($fields as $field) {
            if ($field->name === 'active') {
                $activeExists = true;
                break;
            }
        }
        
        // Remove active column if it exists
        if ($activeExists) {
            $this->forge->dropColumn('users', 'active');
        }
    }
}
