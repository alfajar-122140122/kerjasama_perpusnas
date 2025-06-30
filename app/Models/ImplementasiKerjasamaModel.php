<?php

namespace App\Models;

use CodeIgniter\Model;

class ImplementasiKerjasama extends Model
{
    protected $table            = 'implementasi_kerjasama';
    protected $primaryKey       = 'id_implementasi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang diizinkan untuk diisi, disesuaikan dengan migrasi
    protected $allowedFields    = [
        'id_kerjasama',
        'nama_kegiatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'lingkup_implementasi',
        'hasil_kegiatan',
        'created_by_user_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
