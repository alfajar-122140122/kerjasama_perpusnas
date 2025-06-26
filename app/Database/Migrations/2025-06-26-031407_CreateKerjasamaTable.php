<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKerjasamaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kerjasama' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_mitra'        => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'ruang_lingkup'   => [
                'type'       => 'TEXT',
                'null'       => false,
            ],
            'tanggal_mulai' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'tanggal_selesai' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'jenis' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'progress' => [
                'type'       => 'VaRCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'latitude' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,8',
                'null'       => true,
            ],
            'longitude' => [
                'type'       => 'DECIMAL',
                'constraint' => '11,8',
                'null'       => true,
            ],
            'created_by_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_kerjasama');
        $this->forge->addForeignKey('created_by_user_id', 'users', 'id_user', 'SET NULL', 'SET NULL');
        $this->forge->createTable('kerjasama');
    }

    public function down()
    {
        $this->forge->dropTable('kerjasama', true);
    }
}
