<?php

namespace App\Models;

use CodeIgniter\Model;

class KerjasamaModel extends Model
{
    protected $table            = 'kerjasama';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang diizinkan untuk diisi, disesuaikan dengan migrasi
    protected $allowedFields    = [
        'nama_mitra',
        'ruang_lingkup',
        'tanggal_mulai',
        'tanggal_berakhir'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    // Helper method to get consistent masa berlaku format
    public function getMasaBerlaku($id)
    {
        $kerjasama = $this->find($id);
        if (!$kerjasama) {
            return null;
        }
        
        $tanggalMulai = new \DateTime($kerjasama['tanggal_mulai']);
        $tanggalBerakhir = new \DateTime($kerjasama['tanggal_berakhir']);
        
        return $tanggalMulai->format('d-m-Y') . ' s/d ' . $tanggalBerakhir->format('d-m-Y');
    }
}
