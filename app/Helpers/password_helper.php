<?php

if (!function_exists('validatePasswordStrength')) {
    /**
     * Validasi kekuatan password berdasarkan kriteria keamanan
     * 
     * @param string $password
     * @return array
     */
    function validatePasswordStrength($password)
    {
        $result = [
            'valid' => false,
            'score' => 0,
            'strength' => 'Sangat Lemah',
            'requirements' => [
                'length' => false,
                'lowercase' => false,
                'uppercase' => false,
                'numbers' => false,
                'special' => false
            ],
            'messages' => []
        ];
        
        // Minimal 8 karakter
        if (strlen($password) >= 8) {
            $result['requirements']['length'] = true;
            $result['score']++;
        } else {
            $result['messages'][] = 'Password minimal harus 8 karakter';
        }
        
        // Mengandung huruf kecil
        if (preg_match('/[a-z]/', $password)) {
            $result['requirements']['lowercase'] = true;
            $result['score']++;
        } else {
            $result['messages'][] = 'Password harus mengandung huruf kecil';
        }
        
        // Mengandung huruf besar
        if (preg_match('/[A-Z]/', $password)) {
            $result['requirements']['uppercase'] = true;
            $result['score']++;
        } else {
            $result['messages'][] = 'Password harus mengandung huruf besar';
        }
        
        // Mengandung angka
        if (preg_match('/[0-9]/', $password)) {
            $result['requirements']['numbers'] = true;
            $result['score']++;
        } else {
            $result['messages'][] = 'Password harus mengandung angka';
        }
        
        // Mengandung karakter khusus
        if (preg_match('/[@#$%^&*()[\]{}]/', $password)) {
            $result['requirements']['special'] = true;
            $result['score']++;
        } else {
            $result['messages'][] = 'Password harus mengandung karakter khusus (@#$%^&*()[]{})';
        }
        
        // Tentukan kekuatan password
        switch ($result['score']) {
            case 5:
                $result['strength'] = 'Sangat Kuat';
                $result['valid'] = true;
                break;
            case 4:
                $result['strength'] = 'Kuat';
                $result['valid'] = true;
                break;
            case 3:
                $result['strength'] = 'Sedang';
                break;
            case 2:
                $result['strength'] = 'Lemah';
                break;
            default:
                $result['strength'] = 'Sangat Lemah';
        }
        
        // Cek untuk password umum yang mudah ditebak
        $commonPasswords = [
            'password', '123456', '123456789', 'qwerty', 'abc123',
            'password123', 'admin', 'letmein', 'welcome', 'monkey',
            'dragon', 'master', 'sunshine', 'iloveyou', 'princess'
        ];
        
        if (in_array(strtolower($password), $commonPasswords)) {
            $result['valid'] = false;
            $result['strength'] = 'Sangat Lemah';
            $result['messages'][] = 'Password terlalu umum dan mudah ditebak';
        }
        
        return $result;
    }
}

if (!function_exists('generateSecurePassword')) {
    /**
     * Generate password yang aman
     * 
     * @param int $length
     * @return string
     */
    function generateSecurePassword($length = 12)
    {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $special = '@#$%^&*()[]{}';
        
        $password = '';
        
        // Pastikan password mengandung setidaknya satu karakter dari setiap kategori
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $special[random_int(0, strlen($special) - 1)];
        
        // Isi sisa panjang password dengan karakter acak
        $allChars = $lowercase . $uppercase . $numbers . $special;
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }
        
        // Acak urutan karakter
        return str_shuffle($password);
    }
}

if (!function_exists('hashPasswordSecure')) {
    /**
     * Hash password dengan algoritma yang aman
     * 
     * @param string $password
     * @return string
     */
    function hashPasswordSecure($password)
    {
        return password_hash($password, PASSWORD_ARGON2ID, [
            'memory_cost' => 65536, // 64 MB
            'time_cost' => 4,       // 4 iterations
            'threads' => 3,         // 3 threads
        ]);
    }
}

if (!function_exists('verifyPasswordSecure')) {
    /**
     * Verifikasi password dengan hash
     * 
     * @param string $password
     * @param string $hash
     * @return bool
     */
    function verifyPasswordSecure($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
