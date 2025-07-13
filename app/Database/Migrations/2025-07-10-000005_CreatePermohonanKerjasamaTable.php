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
                'constraint' => ['baru', 'perpanjangan'],
                'default'    => 'baru',
            ],
            'lembaga' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'unit_terkait' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'kontak_dapat_dihubungi' => [
                'type' => 'TEXT',
            ],
            'file_formulir' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'tanggal_pengajuan' => [
                'type' => 'DATETIME',
                'null' => true,
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
        $this->forge->createTable('permohonan_kerjasama', true);
    }

    public function down()
    {
        $this->forge->dropTable('permohonan_kerjasama');
    }
}
