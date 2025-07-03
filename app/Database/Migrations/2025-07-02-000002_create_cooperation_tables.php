<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCooperationTables extends Migration
{
    public function up()
    {
        // Table: kerjasama
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'instansi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'jenis' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'tidak aktif', 'akan berakhir'],
                'default' => 'aktif',
            ],
            'tanggal_mulai' => [
                'type' => 'DATE',
            ],
            'tanggal_berakhir' => [
                'type' => 'DATE',
            ],
            'pic' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'file_kerjasama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'catatan_perpanjangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_from_submission' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('kerjasama');
        
        // Table: implementasi_kerjasama
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kerjasama_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'judul_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_kegiatan' => [
                'type' => 'DATE',
            ],
            'lokasi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'bukti' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kerjasama_id', 'kerjasama', 'id', '', 'CASCADE');
        $this->forge->createTable('implementasi_kerjasama');
        
        // Table: permohonan_kerjasama
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_pengaju' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_instansi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'alamat_instansi' => [
                'type' => 'TEXT',
            ],
            'jenis_kerjasama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'deskripsi_kerjasama' => [
                'type' => 'TEXT',
            ],
            'file_proposal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['baru', 'diproses', 'diterima', 'ditolak'],
                'default' => 'baru',
            ],
            'catatan_admin' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'converted_to_kerjasama' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'kerjasama_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('permohonan_kerjasama');
        
        // Table: activities
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'date' => [
                'type' => 'DATE',
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('activities');
        
        // Table: statistics
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'label' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'value' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('statistics');
        
        // Table: about
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'content' => [
                'type' => 'TEXT',
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('about');
        
        // Table: settings
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'value' => [
                'type' => 'TEXT',
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['category', 'key']);
        $this->forge->createTable('settings');
        
        // Table: contact_messages
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'subject' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'message' => [
                'type' => 'TEXT',
            ],
            'is_read' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('contact_messages');
    }

    public function down()
    {
        $this->forge->dropTable('contact_messages');
        $this->forge->dropTable('settings');
        $this->forge->dropTable('about');
        $this->forge->dropTable('statistics');
        $this->forge->dropTable('activities');
        $this->forge->dropTable('permohonan_kerjasama');
        $this->forge->dropTable('implementasi_kerjasama');
        $this->forge->dropTable('kerjasama');
    }
}
