<?php

namespace App\Models;

use CodeIgniter\Model;

class PetaKerjasamaModel extends Model
{
    protected $table = 'peta_kerjasama';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'kerjasama_id',
        'latitude',
        'longitude',
        'deskripsi_lokasi',
        'created_at',
    ];
    protected $useTimestamps = false;
} 