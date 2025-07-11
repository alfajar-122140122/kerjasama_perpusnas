<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKerjasamaTable extends Migration
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
            'nama_mitra' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'ruang_lingkup' => [
                'type' => 'TEXT',
            ],
            'tanggal_mulai' => [
                'type' => 'DATE',
            ],
            'tanggal_berakhir' => [
                'type' => 'DATE',
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

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('kerjasama', true);
    }

    public function down()
    {
        $this->forge->dropTable('kerjasama');
    }
}
