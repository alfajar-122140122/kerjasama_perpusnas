<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePetaKerjasamaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kerjasama_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'latitude' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,8',
            ],
            'longitude' => [
                'type'       => 'DECIMAL',
                'constraint' => '11,8',
            ],
            'deskripsi_lokasi' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kerjasama_id', 'kerjasama', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peta_kerjasama', true);
    }

    public function down()
    {
        $this->forge->dropTable('peta_kerjasama');
    }
}
