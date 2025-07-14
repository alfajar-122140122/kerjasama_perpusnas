<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang diizinkan untuk diisi
    protected $allowedFields    = ['username', 'email', 'password_hash', 'role', 'last_active', 'name', 'phone'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'username'  => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]',
        'email'     => 'required|valid_email|max_length[100]|is_unique[users.email,id,{id}]',
        'password'  => 'permit_empty|min_length[8]|regex_match[/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])/]',
        'role'      => 'required|in_list[admin,staff]',
        'name'      => 'permit_empty|max_length[100]',
        'phone'     => 'permit_empty|max_length[20]'
    ];

    protected $validationMessages = [
        'username' => [
            'required'    => 'Username harus diisi',
            'min_length'  => 'Username minimal 3 karakter',
            'max_length'  => 'Username maksimal 50 karakter',
            'is_unique'   => 'Username sudah digunakan'
        ],
        'email' => [
            'required'    => 'Email harus diisi',
            'valid_email' => 'Format email tidak valid',
            'max_length'  => 'Email maksimal 100 karakter',
            'is_unique'   => 'Email sudah digunakan'
        ],
        'password' => [
            'min_length'    => 'Password minimal 8 karakter',
            'regex_match'   => 'Password harus mengandung huruf kecil, huruf besar, angka, dan karakter khusus'
        ],
        'role' => [
            'required'    => 'Hak akses harus dipilih',
            'in_list'     => 'Hak akses tidak valid'
        ],
        'name' => [
            'max_length'  => 'Nama maksimal 100 karakter'
        ],
        'phone' => [
            'max_length'  => 'Nomor telepon maksimal 20 karakter'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks untuk hashing password secara otomatis
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!empty($data['data']['password'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);
        }
        return $data;
    }

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function updateLastActive($userId)
    {
        return $this->update($userId, ['last_active' => date('Y-m-d H:i:s')]);
    }

    public function getActiveUsers()
    {
        return $this->orderBy('last_active', 'DESC')->findAll();
    }

    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function updateUserProfile($userId, $data)
    {
        // Remove password from data if it's empty
        if (empty($data['password'])) {
            unset($data['password']);
        }
        
        return $this->update($userId, $data);
    }
}