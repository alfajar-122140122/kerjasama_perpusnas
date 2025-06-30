<?php

namespace App\Models;

use CodeIgniter\Model;

class Kerjasama extends Model
{
    protected $table            = 'kerjasama';
    protected $primaryKey       = 'id_kerjasama';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang diizinkan untuk diisi, disesuaikan dengan migrasi
    protected $allowedFields    = [
        'nama_mitra',
        'ruang_lingkup',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis',
        'progress',
        'latitude',
        'longitude',
        'created_by_user_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
