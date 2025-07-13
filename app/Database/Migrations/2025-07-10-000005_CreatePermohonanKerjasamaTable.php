<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermohonanKerjasamaTable extends Migration
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
            'jenis_permohonan' => [
                'type'       => 'ENUM',
                'constraint' => ['Baru', 'Perpanjangan'],
                'default'    => 'Baru',
            ],
            'nama_instansi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'telp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'unit_terkait' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'kontak_dihubungi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'upload_formulir' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            // Kolom status workflow
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'review', 'approved', 'rejected'],
                'default'    => 'pending',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'reviewed_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'reviewed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('permohonan_kerjasama', true);
    }

    public function down()
    {
        $this->forge->dropTable('permohonan_kerjasama');
    }
}
