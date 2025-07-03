<?php

namespace App\Models;

use CodeIgniter\Model;

class CooperationModel extends Model
{
    protected $table = 'kerjasama';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'judul', 
        'instansi', 
        'jenis', 
        'status', 
        'tanggal_mulai', 
        'tanggal_berakhir', 
        'pic', 
        'file_kerjasama', 
        'deskripsi', 
        'created_by', 
        'updated_by', 
        'created_at', 
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'judul' => 'required|min_length[5]',
        'instansi' => 'required',
        'jenis' => 'required',
        'status' => 'required|in_list[aktif,tidak aktif,akan berakhir]',
        'tanggal_mulai' => 'required|valid_date',
        'tanggal_berakhir' => 'required|valid_date',
        'pic' => 'required'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    
    /**
     * Get kerjasama yang akan berakhir
     */
    public function getExpiringCooperation($limit = null)
    {
        $today = date('Y-m-d');
        $threeMonthsFromNow = date('Y-m-d', strtotime('+3 months'));
        
        $query = $this->where('status', 'aktif')
                      ->where('tanggal_berakhir >=', $today)
                      ->where('tanggal_berakhir <=', $threeMonthsFromNow)
                      ->orderBy('tanggal_berakhir', 'ASC');
        
        if ($limit !== null) {
            $query->limit($limit);
        }
        
        return $query->findAll();
    }
    
    /**
     * Get data progress kerjasama
     */
    public function getProgressData()
    {
        $db = \Config\Database::connect();
        
        $query = $db->query("
            SELECT 
                jenis,
                COUNT(*) as total,
                SUM(CASE WHEN status = 'aktif' THEN 1 ELSE 0 END) as aktif,
                SUM(CASE WHEN status = 'tidak aktif' THEN 1 ELSE 0 END) as tidak_aktif
            FROM kerjasama
            GROUP BY jenis
        ");
        
        return $query->getResultArray();
    }
}
