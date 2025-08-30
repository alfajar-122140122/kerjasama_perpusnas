<?php

namespace App\Models;

use CodeIgniter\Model;

class ImplementasiKerjasamaModel extends Model
{
    protected $table            = 'implementasi_kerjasama';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang diizinkan untuk diisi, disesuaikan dengan migrasi
    protected $allowedFields    = [
        'kerjasama_id',
        'masa_berlaku',
        'implementasi',
        'lingkup',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = false; // No timestamps in DB schema, we handle created_at manually
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    
    // Mendapatkan data implementasi kerjasama dengan informasi mitra
    public function getImplementasiWithKerjasama($limit = null, $offset = null, $id = null)
    {
        if ($id === null) {
            $builder = $this->select('
                implementasi_kerjasama.id, 
                implementasi_kerjasama.kerjasama_id,
                implementasi_kerjasama.masa_berlaku,
                implementasi_kerjasama.implementasi,
                implementasi_kerjasama.lingkup,
                implementasi_kerjasama.created_at,
                kerjasama.nama_mitra,
                kerjasama.tanggal_mulai,
                kerjasama.tanggal_berakhir,
                kerjasama.ruang_lingkup
            ')
                ->join('kerjasama', 'kerjasama.id = implementasi_kerjasama.kerjasama_id')
                ->orderBy('implementasi_kerjasama.id', 'DESC');
            
            // Apply pagination if provided
            if ($limit !== null && $offset !== null) {
                $builder->limit($limit, $offset);
            }
                
            return $builder->findAll();
        }
        
        return $this->select('
            implementasi_kerjasama.id, 
            implementasi_kerjasama.kerjasama_id,
            implementasi_kerjasama.masa_berlaku,
            implementasi_kerjasama.implementasi,
            implementasi_kerjasama.lingkup,
            implementasi_kerjasama.created_at,
            kerjasama.nama_mitra,
            kerjasama.tanggal_mulai,
            kerjasama.tanggal_berakhir,
            kerjasama.ruang_lingkup
        ')
            ->join('kerjasama', 'kerjasama.id = implementasi_kerjasama.kerjasama_id')
            ->where('implementasi_kerjasama.id', $id)
            ->first();
    }
    
    // Mendapatkan data implementasi kerjasama untuk tampilan publik
    public function getImplementasiForPublic($id = null)
    {
        if ($id === null) {
            return $this->select('
                implementasi_kerjasama.id, 
                implementasi_kerjasama.masa_berlaku,
                implementasi_kerjasama.implementasi,
                implementasi_kerjasama.lingkup,
                kerjasama.nama_mitra,
                kerjasama.tanggal_mulai,
                kerjasama.tanggal_berakhir
            ')
            ->join('kerjasama', 'kerjasama.id = implementasi_kerjasama.kerjasama_id')
            ->orderBy('implementasi_kerjasama.id', 'DESC')
            ->findAll();
        }
        
        return $this->select('
            implementasi_kerjasama.id, 
            implementasi_kerjasama.masa_berlaku,
            implementasi_kerjasama.implementasi,
            implementasi_kerjasama.lingkup,
            kerjasama.nama_mitra,
            kerjasama.tanggal_mulai,
            kerjasama.tanggal_berakhir
        ')
        ->join('kerjasama', 'kerjasama.id = implementasi_kerjasama.kerjasama_id')
        ->where('implementasi_kerjasama.id', $id)
        ->first();
    }
}
