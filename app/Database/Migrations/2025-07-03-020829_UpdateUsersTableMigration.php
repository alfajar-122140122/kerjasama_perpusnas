<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUsersTableMigration extends Migration
{
    public function up()
    {
        // Periksa apakah tabel users sudah ada
        $forge = \Config\Database::forge();
        $db = \Config\Database::connect();
        
        if (!$db->tableExists('users')) {
            // Jika tidak ada id_user, berarti tabel belum sesuai
            $this->forge->addField([
                'id_user' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'username' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'hak_akses' => [
                    'type'       => 'ENUM',
                    'constraint' => ['admin', 'user'],
                    'default'    => 'user',
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            
            $this->forge->addKey('id_user', true);
            $this->forge->createTable('users', true);
            
            // Insert admin default
            $this->db->table('users')->insert([
                'username' => 'admin',
                'password' => password_hash('Admin123@', PASSWORD_DEFAULT),
                'hak_akses' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function down()
    {
        // No action needed for down migration
    }
}
