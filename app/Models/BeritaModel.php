<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'berita';
    protected $primaryKey       = 'id'; // Changed from id_berita to id
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom ini sudah sesuai dengan migrasi Anda
    protected $allowedFields    = [
        'judul',
        'isi_berita',
        'gambar',
        'tanggal_publikasi',
        'created_by_user_id',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
