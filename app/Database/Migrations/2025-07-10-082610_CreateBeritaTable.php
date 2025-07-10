<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBeritaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_berita'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'isi_berita'         => [
                'type'       => 'TEXT',
            ],
            'gambar'      => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'tanggal_publikasi' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'created_by_user_id'    => [
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
            'status'      => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'draft',
            ],
        ]);

        $this->forge->addPrimaryKey('id_berita');
        $this->forge->addForeignKey('created_by_user_id', 'users', 'id_user', 'SET NULL', 'SET NULL');
        $this->forge->createTable('berita');
    }

    public function down()
    {
        $this->forge->dropTable('berita', true);
    }
}
