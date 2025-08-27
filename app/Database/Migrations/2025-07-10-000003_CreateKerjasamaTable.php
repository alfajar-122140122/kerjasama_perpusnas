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
            'permohonan_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'nomor_kerjasama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'nama_mitra' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'jenis_mitra' => [
                'type'       => 'ENUM',
                'constraint' => ['PTS', 'PTN', 'K/L', 'Swasta', 'Luar Negeri'],
                'null'       => true,
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
            'file_kerjasama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'berakhir'],
                'default'    => 'aktif',
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
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
        $this->forge->addForeignKey('permohonan_id', 'permohonan_kerjasama', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('kerjasama', true);

    }

    public function down()
    {
        $this->forge->dropTable('kerjasama');
    }
}
