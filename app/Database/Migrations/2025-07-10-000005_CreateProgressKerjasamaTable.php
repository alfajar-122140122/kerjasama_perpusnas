<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgressKerjasamaTable extends Migration
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
            'permohonan_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'tanggal_pengajuan' => [
                'type' => 'DATE',
            ],
            'lembaga' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'jenis' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['approved', 'review', 'rejected'],
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('permohonan_id', 'permohonan_kerjasama', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('progress_kerjasama', true);
    }

    public function down()
    {
        $this->forge->dropTable('progress_kerjasama');
    }
}
