<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterImplementasiKerjasamaTable extends Migration
{
    public function up()
    {
        // Tambahkan kolom baru ke tabel implementasi_kerjasama
        $fields = [
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at',
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'unit_kerja_terkait',
            ],
            'pic_implementasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'status',
            ],
            'target_selesai' => [
                'type'       => 'DATE',
                'null'       => true,
                'after'      => 'pic_implementasi',
            ],
            'catatan_implementasi' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'target_selesai',
            ],
        ];

        $this->forge->addColumn('implementasi_kerjasama', $fields);
    }

    public function down()
    {
        // Hapus kolom jika migrasi di-rollback
        $this->forge->dropColumn('implementasi_kerjasama', 'updated_at');
        $this->forge->dropColumn('implementasi_kerjasama', 'status');
        $this->forge->dropColumn('implementasi_kerjasama', 'pic_implementasi');
        $this->forge->dropColumn('implementasi_kerjasama', 'target_selesai');
        $this->forge->dropColumn('implementasi_kerjasama', 'catatan_implementasi');
    }
}
