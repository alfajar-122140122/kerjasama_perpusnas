<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang diizinkan untuk diisi
    protected $allowedFields    = ['username', 'password', 'hak_akses'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation Rules
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id_user,{id_user}]',
        'password' => 'required|min_length[8]',
        'hak_akses' => 'required|in_list[admin,user]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username harus diisi',
            'min_length' => 'Username minimal 3 karakter',
            'max_length' => 'Username maksimal 50 karakter',
            'is_unique' => 'Username sudah digunakan'
        ],
        'password' => [
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 8 karakter'
        ],
        'hak_akses' => [
            'required' => 'Hak akses harus dipilih',
            'in_list' => 'Hak akses tidak valid'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks untuk hashing password secara otomatis
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    public function __construct()
    {
        parent::__construct();
        
        // Load helper at constructor
        helper('password_helper');
    }

    /**
     * Hash password menggunakan algoritma yang aman
     */
    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        // Ensure helper is loaded
        if (!function_exists('hashPasswordSecure')) {
            helper('password_helper');
        }
        
        // If still not available, use fallback
        if (function_exists('hashPasswordSecure')) {
            $data['data']['password'] = hashPasswordSecure($data['data']['password']);
        } else {
            // Fallback to PHP's password_hash with strong options
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_ARGON2ID, [
                'memory_cost' => 65536, // 64 MB
                'time_cost' => 4,       // 4 iterations
                'threads' => 3,         // 3 threads
            ]);
        }
        
        return $data;
    }

    /**
     * Verifikasi login user
     */
    public function verifyLogin($username, $password)
    {
        $user = $this->where('username', $username)->first();
        
        if (!$user) {
            return false;
        }

        // Ensure helper is loaded
        if (!function_exists('verifyPasswordSecure')) {
            helper('password_helper');
        }
        
        // Verify password
        $isValid = false;
        if (function_exists('verifyPasswordSecure')) {
            $isValid = verifyPasswordSecure($password, $user['password']);
        } else {
            // Fallback to PHP's password_verify
            $isValid = password_verify($password, $user['password']);
        }
        
        if ($isValid) {
            // Jangan return password untuk keamanan
            unset($user['password']);
            return $user;
        }

        return false;
    }

    /**
     * Buat user admin default jika belum ada
     */
    public function createDefaultAdmin()
    {
        $adminExists = $this->where('hak_akses', 'admin')->first();
        
        if (!$adminExists) {
            $this->insert([
                'username' => 'admin',
                'password' => 'Admin123@',
                'hak_akses' => 'admin'
            ]);
        }
    }

    /**
     * Validasi kekuatan password
     */
    public function validatePasswordStrength($password)
    {
        if (!function_exists('validatePasswordStrength')) {
            helper('password_helper');
        }
        
        if (function_exists('validatePasswordStrength')) {
            return validatePasswordStrength($password);
        }
        
        // Fallback basic validation
        return [
            'valid' => strlen($password) >= 8,
            'score' => strlen($password) >= 8 ? 3 : 1,
            'strength' => strlen($password) >= 8 ? 'Sedang' : 'Lemah',
            'requirements' => [
                'length' => strlen($password) >= 8,
                'lowercase' => true,
                'uppercase' => true,
                'numbers' => true,
                'special' => true
            ],
            'messages' => strlen($password) >= 8 ? [] : ['Password minimal 8 karakter']
        ];
    }

    /**
     * Update password user
     */
    public function updatePassword($userId, $newPassword)
    {
        // Validasi kekuatan password
        $validation = $this->validatePasswordStrength($newPassword);
        
        if (!$validation['valid']) {
            return [
                'success' => false,
                'errors' => $validation['messages']
            ];
        }

        // Update password
        $result = $this->update($userId, ['password' => $newPassword]);
        
        return [
            'success' => $result,
            'message' => $result ? 'Password berhasil diupdate' : 'Gagal mengupdate password'
        ];
    }
}
