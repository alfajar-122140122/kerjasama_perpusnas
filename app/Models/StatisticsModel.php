<?php

namespace App\Models;

use CodeIgniter\Model;

class StatisticsModel extends Model
{
    protected $table = 'statistics';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['label', 'value', 'icon', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'label' => 'required',
        'value' => 'required|numeric',
        'icon' => 'required'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
