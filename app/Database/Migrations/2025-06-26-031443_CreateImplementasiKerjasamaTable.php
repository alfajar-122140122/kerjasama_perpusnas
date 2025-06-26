<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateImplementasiKerjasamaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_implementasi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_kerjasama' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'nama_kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
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
            'lingkup_implementasi' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'hasil_kegiatan' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_by_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_implementasi');
        $this->forge->addForeignKey('id_kerjasama', 'kerjasama', 'id_kerjasama', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by_user_id', 'users', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->createTable('implementasi_kerjasama');
    }

    public function down()
    {
        $this->forge->dropTable('implementasi_kerjasama', true);
    }
}
