<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePermohonanKerjasamaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_permohonan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'jenis_permohonan' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'lembaga' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'unit_terkait' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kontak_dapat_dihubungi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'file_formulir' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'tanggal_pengajuan' => [
                'type'    => 'DATE',
                'null'    => true,
                'default' => new RawSql('CURRENT_DATE'),
            ],
            'kerjasama_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_by_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_permohonan');
        $this->forge->addForeignKey('kerjasama_id', 'kerjasama', 'id_kerjasama', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('created_by_user_id', 'users', 'id_user', 'SET NULL', 'CASCADE');
        $this->forge->createTable('permohonan_kerjasama');
    }

    public function down()
    {
        $this->forge->dropTable('permohonan_kerjasama', true);
    }
}
