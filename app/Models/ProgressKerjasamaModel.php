<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressKerjasamaModel extends Model
{
    protected $table            = 'progress_kerjasama';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Allowed fields for mass assignment
    protected $allowedFields    = [
        'tanggal_pengajuan',
        'lembaga',
        'jenis',
        'progress'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = null;
    
    // Get progress kerjasama with filtering options
    public function getProgressData($filter = null)
    {
        $builder = $this->select('progress_kerjasama.*');
        
        if ($filter) {
            if (isset($filter['jenis']) && $filter['jenis'] != 'all') {
                $builder->where('jenis', $filter['jenis']);
            }
            
            if (isset($filter['progress']) && $filter['progress'] != 'all') {
                $builder->where('progress', $filter['progress']);
            }
            
            if (isset($filter['search']) && !empty($filter['search'])) {
                $builder->groupStart()
                    ->like('lembaga', $filter['search'])
                    ->orLike('jenis', $filter['search'])
                    ->orLike('progress', $filter['search'])
                    ->groupEnd();
            }
        }
        
        return $builder->orderBy('tanggal_pengajuan', 'DESC')->findAll();
    }
    
    // Get progress kerjasama for public display
    public function getProgressForPublic($filter = null)
    {
        $builder = $this->select('progress_kerjasama.*');
        
        if ($filter) {
            if (isset($filter['jenis']) && $filter['jenis'] != 'all') {
                $builder->where('jenis', $filter['jenis']);
            }
            
            if (isset($filter['progress']) && $filter['progress'] != 'all') {
                $builder->where('progress', $filter['progress']);
            }
            
            if (isset($filter['search']) && !empty($filter['search'])) {
                $builder->groupStart()
                    ->like('lembaga', $filter['search'])
                    ->orLike('jenis', $filter['search'])
                    ->orLike('progress', $filter['search'])
                    ->groupEnd();
            }
        }
        
        return $builder->orderBy('tanggal_pengajuan', 'DESC')->findAll();
    }
    
    // Get progress statistics
    public function getProgressStats()
    {
        $totalProgress = $this->countAllResults();
        $newProgress = $this->where('jenis', 'Baru')->countAllResults();
        $extensionProgress = $this->where('jenis', 'Perpanjangan')->countAllResults();
        $documentationProgress = $this->where('progress', 'Dokumentasi')->countAllResults();
        $finishingProgress = $this->where('progress', 'Finishing')->countAllResults();
        
        return [
            'total' => $totalProgress,
            'new' => $newProgress,
            'extension' => $extensionProgress,
            'documentation' => $documentationProgress,
            'finishing' => $finishingProgress
        ];
    }
}
