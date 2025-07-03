<?php

namespace App\Models;

use CodeIgniter\Model;

class KerjasamaModel extends Model
{
    protected $table            = 'kerjasama';
    protected $primaryKey       = 'id_kerjasama';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang diizinkan untuk diisi, disesuaikan dengan tabel aktual
    protected $allowedFields    = [
        'nama_mitra',
        'ruang_lingkup',
        'tanggal_mulai',
        'tanggal_berakhir', // Menggunakan nama kolom yang sesuai dengan database
        'jenis',
        'status', // Menggunakan nama kolom yang sesuai dengan database
        'dokumen', // Menambahkan field dokumen yang ada di database
        'created_by_user_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
