<?php

namespace App\Validation;

class CustomRules
{
    /**
     * Validasi kekuatan password
     * 
     * @param string $str
     * @param string $fields
     * @param array $data
     * @return bool
     */
    public function strong_password(string $str, string $fields, array $data): bool
    {
        helper('password_helper');
        
        $validation = validatePasswordStrength($str);
        return $validation['valid'];
    }

    /**
     * Error message untuk strong_password
     * 
     * @return string
     */
    public function strong_password_errors(): string
    {
        return 'Password harus memenuhi kriteria keamanan: minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan karakter khusus.';
    }

    /**
     * Validasi username tidak mengandung karakter khusus berbahaya
     * 
     * @param string $str
     * @param string $fields
     * @param array $data
     * @return bool
     */
    public function safe_username(string $str, string $fields, array $data): bool
    {
        // Hanya mengizinkan huruf, angka, underscore, dan dash
        return preg_match('/^[a-zA-Z0-9_-]+$/', $str);
    }

    /**
     * Error message untuk safe_username
     * 
     * @return string
     */
    public function safe_username_errors(): string
    {
        return 'Username hanya boleh mengandung huruf, angka, underscore (_), dan dash (-).';
    }

    /**
     * Validasi password tidak sama dengan username
     * 
     * @param string $str
     * @param string $fields
     * @param array $data
     * @return bool
     */
    public function password_not_username(string $str, string $fields, array $data): bool
    {
        $username = $data['username'] ?? '';
        return strtolower($str) !== strtolower($username);
    }

    /**
     * Error message untuk password_not_username
     * 
     * @return string
     */
    public function password_not_username_errors(): string
    {
        return 'Password tidak boleh sama dengan username.';
    }

    /**
     * Validasi tidak menggunakan password umum
     * 
     * @param string $str
     * @param string $fields  
     * @param array $data
     * @return bool
     */
    public function not_common_password(string $str, string $fields, array $data): bool
    {
        $commonPasswords = [
            '123456', 'password', '123456789', 'qwerty', 'abc123',
            'password123', 'admin', 'letmein', 'welcome', 'monkey',
            'dragon', 'master', 'sunshine', 'iloveyou', 'princess',
            '654321', '123123', 'superman', 'qazwsx', 'michael',
            'football', 'batman', 'trustno1', 'tigger', 'charlie'
        ];
        
        return !in_array(strtolower($str), $commonPasswords);
    }

    /**
     * Error message untuk not_common_password
     * 
     * @return string
     */
    public function not_common_password_errors(): string
    {
        return 'Password yang dipilih terlalu umum dan mudah ditebak. Gunakan password yang lebih unik.';
    }

    /**
     * Validasi email dengan domain yang diizinkan (opsional)
     * 
     * @param string $str
     * @param string $fields
     * @param array $data
     * @return bool
     */
    public function allowed_email_domain(string $str, string $fields, array $data): bool
    {
        // Jika tidak ada email, skip validasi
        if (empty($str)) {
            return true;
        }

        // Daftar domain yang diizinkan (opsional, bisa dikonfigurasi)
        $allowedDomains = [
            'gmail.com', 
            'yahoo.com', 
            'outlook.com', 
            'perpusnas.go.id'
        ];

        $domain = substr(strrchr($str, "@"), 1);
        return in_array(strtolower($domain), $allowedDomains);
    }

    /**
     * Error message untuk allowed_email_domain
     * 
     * @return string
     */
    public function allowed_email_domain_errors(): string
    {
        return 'Domain email tidak diizinkan. Gunakan email dengan domain yang valid.';
    }
}
