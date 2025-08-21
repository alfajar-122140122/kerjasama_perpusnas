<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateImplementasiKerjasamaTable extends Migration
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
            'masa_berlaku' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'implementasi' => [
                'type' => 'TEXT',
            ],
            'lingkup' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kerjasama_id', 'kerjasama', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('implementasi_kerjasama', true);
    }

    public function down()
    {
        $this->forge->dropTable('implementasi_kerjasama');
    }
}
