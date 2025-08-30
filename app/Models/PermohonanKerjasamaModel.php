<?php

namespace App\Models;

use CodeIgniter\Model;

class PermohonanKerjasamaModel extends Model
{
    protected $table            = 'permohonan_kerjasama';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'jenis_permohonan',
        'lembaga',
        'alamat',
        'telepon',
        'email',
        'kontak_dapat_dihubungi',
        'file_formulir',
        'tanggal_pengajuan',
        'status',
        'reviewed_by',
        'reviewed_at',
        'created_at',
        'updated_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // No soft deletes, so deletedField is not used

    // Validation
    protected $validationRules      = [
        'jenis_permohonan'     => 'required|in_list[baru,perpanjangan]',
        'lembaga'              => 'required|max_length[255]',
        'alamat'               => 'required',
        'telepon'              => 'required|max_length[50]',
        'email'                => 'required|valid_email|max_length[255]',
        'kontak_dapat_dihubungi' => 'required',
        'file_formulir'        => 'permit_empty|max_length[255]',
        'tanggal_pengajuan'    => 'permit_empty|valid_date',
        'status'               => 'permit_empty|in_list[pending,review,approved,rejected]',
        'reviewed_by'          => 'permit_empty|integer',
        'reviewed_at'          => 'permit_empty|valid_date',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get permohonan by status
     * 
     * @param string $status The status to filter by
     * @return array
     */
    public function getByStatus($status)
    {
        return $this->where('status', $status)->findAll();
    }
    
    /**
     * Count permohonan by status
     * 
     * @param string $status The status to count
     * @return int
     */
    public function countByStatus($status)
    {
        return $this->where('status', $status)->countAllResults();
    }
    
    /**
     * Get summary count for dashboard
     * 
     * @return array
     */
    public function getStatusSummary()
    {
        return [
            'pending'  => $this->countByStatus('pending'),
            'review'   => $this->countByStatus('review'),
            'approved' => $this->countByStatus('approved'),
            'rejected' => $this->countByStatus('rejected'),
            'total'    => $this->countAll(),
        ];
    }
    
    /**
     * Update status with reviewer information
     * 
     * @param int $id The permohonan ID
     * @param string $status The new status
     * @param string|null $catatan Optional notes
     * @param int|null $reviewedBy ID of the reviewer
     * @return bool
     */
    public function updateStatus($id, $status, $catatan = null, $reviewedBy = null)
    {
        // Update status permohonan
        $data = [
            'status'      => $status,
            'reviewed_by' => $reviewedBy,
            'reviewed_at' => date('Y-m-d H:i:s'),
        ];
        $result = $this->update($id, $data);

        // Ambil data permohonan untuk di-insert ke progress_kerjasama
        $permohonan = $this->find($id);
        if ($permohonan && $result) {
            try {
                $progressModel = new \App\Models\ProgressKerjasamaModel();
                
                // Prepare data untuk progress_kerjasama sesuai dengan schema migration
                $progressData = [
                    'permohonan_id'     => (int)$id,
                    'tanggal_pengajuan' => !empty($permohonan['tanggal_pengajuan']) ? date('Y-m-d', strtotime($permohonan['tanggal_pengajuan'])) : date('Y-m-d'),
                    'lembaga'           => $permohonan['lembaga'],
                    'jenis'             => ucfirst($permohonan['jenis_permohonan']),
                    'status'            => $status,
                    'catatan'           => $catatan,
                    'created_by'        => $reviewedBy ? (int)$reviewedBy : 1, // default to admin user id 1
                    'created_at'        => date('Y-m-d H:i:s'),
                ];
                
                log_message('info', 'Attempting to insert progress data: ' . json_encode($progressData));
                
                // Hapus data progress lama untuk permohonan yang sama (jika ada)
                $progressModel->where('permohonan_id', $id)->delete();
                
                // Insert data baru
                $insertResult = $progressModel->insert($progressData);
                
                if ($insertResult) {
                    log_message('info', 'Progress data inserted successfully for permohonan ID: ' . $id);
                } else {
                    log_message('error', 'Progress insert failed. Validation errors: ' . json_encode($progressModel->errors()));
                    log_message('error', 'Data that failed to insert: ' . json_encode($progressData));
                }
                
            } catch (\Exception $e) {
                log_message('error', 'Exception during progress insert: ' . $e->getMessage());
                log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            }
        } else {
            log_message('error', 'Failed to update permohonan status or permohonan not found. ID: ' . $id);
        }

        return $result;
    }
}
