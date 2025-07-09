<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user'; // Disesuaikan dengan migrasi
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang diizinkan untuk diisi, disesuaikan dengan migrasi dan menambahkan last_active
    protected $allowedFields    = ['username', 'password', 'hak_akses', 'last_active'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'username'  => 'required|min_length[3]|max_length[255]|is_unique[users.username,id_user,{id_user}]',
        'password'  => 'required|min_length[8]',
        'hak_akses' => 'required|in_list[admin,user]'
    ];

    protected $validationMessages = [
        'username' => [
            'required'    => 'Username harus diisi',
            'min_length'  => 'Username minimal 3 karakter',
            'max_length'  => 'Username maksimal 255 karakter',
            'is_unique'   => 'Username sudah digunakan'
        ],
        'password' => [
            'required'    => 'Password harus diisi',
            'min_length'  => 'Password minimal 8 karakter'
        ],
        'hak_akses' => [
            'required'    => 'Hak akses harus dipilih',
            'in_list'     => 'Hak akses tidak valid'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks untuk hashing password secara otomatis
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (! isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function updateLastActive($userId)
    {
        return $this->update($userId, ['last_active' => date('Y-m-d H:i:s')]);
    }

    public function getActiveUsers()
    {
        return $this->orderBy('last_active', 'DESC')->findAll();
    }
}