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
            'progress' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('progress_kerjasama', true);
    }

    public function down()
    {
        $this->forge->dropTable('progress_kerjasama');
    }
}
