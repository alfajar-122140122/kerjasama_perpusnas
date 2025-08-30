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
        'permohonan_id',
        'tanggal_pengajuan',
        'lembaga',
        'jenis',
        'status',
        'catatan',
        'created_by',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false; // We handle created_at manually
    protected $dateFormat    = 'datetime';
    
    // Get progress kerjasama with filtering options
    public function getProgressData($filter = null)
    {
        $builder = $this->select('progress_kerjasama.*');
        
        if ($filter) {
            if (isset($filter['jenis']) && $filter['jenis'] != 'all') {
                $builder->where('jenis', $filter['jenis']);
            }
            
            if (isset($filter['status']) && $filter['status'] != 'all') {
                $builder->where('status', $filter['status']);
            }
            
            if (isset($filter['search']) && !empty($filter['search'])) {
                $builder->groupStart()
                    ->like('lembaga', $filter['search'])
                    ->orLike('jenis', $filter['search'])
                    ->orLike('status', $filter['search'])
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
            
            if (isset($filter['status']) && $filter['status'] != 'all') {
                $builder->where('status', $filter['status']);
            }
            
            if (isset($filter['search']) && !empty($filter['search'])) {
                $builder->groupStart()
                    ->like('lembaga', $filter['search'])
                    ->orLike('jenis', $filter['search'])
                    ->orLike('status', $filter['search'])
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
        $reviewProgress = $this->where('status', 'review')->countAllResults();
        $approvedProgress = $this->where('status', 'approved')->countAllResults();
        $rejectedProgress = $this->where('status', 'rejected')->countAllResults();
        
        return [
            'total' => $totalProgress,
            'new' => $newProgress,
            'extension' => $extensionProgress,
            'review' => $reviewProgress,
            'approved' => $approvedProgress,
            'rejected' => $rejectedProgress
        ];
    }
}
