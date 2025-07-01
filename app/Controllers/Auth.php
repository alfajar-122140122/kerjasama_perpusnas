<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $maxLoginAttempts = 5;
    protected $lockoutTime = 900; // 15 menit

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['password_helper', 'form']);
    }

    /**
     * Tampilkan halaman login
     */
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }

        // Cek apakah akun terkunci karena terlalu banyak percobaan login
        if ($this->isAccountLocked()) {
            $lockoutTime = $this->getRemainingLockoutTime();
            return view('auth/login', [
                'error' => "Akun terkunci karena terlalu banyak percobaan login. Coba lagi dalam {$lockoutTime} menit."
            ]);
        }
        
        return view('auth/login');
    }

    /**
     * Proses login
     */
    public function attemptLogin()
    {
        // Validasi input
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'password' => 'required|min_length[6]'
        ];

        $messages = [
            'username' => [
                'required' => 'Username harus diisi',
                'min_length' => 'Username minimal 3 karakter',
                'max_length' => 'Username maksimal 50 karakter'
            ],
            'password' => [
                'required' => 'Password harus diisi',
                'min_length' => 'Password minimal 6 karakter'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return view('auth/login', [
                'validation' => $this->validator
            ]);
        }

        // Cek apakah akun terkunci
        if ($this->isAccountLocked()) {
            $lockoutTime = $this->getRemainingLockoutTime();
            return redirect()->back()->with('error', "Akun terkunci karena terlalu banyak percobaan login. Coba lagi dalam {$lockoutTime} menit.");
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        // Sanitasi input
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        // Coba verifikasi login
        $user = $this->userModel->verifyLogin($username, $password);

        if ($user) {
            // Reset counter login attempts
            $this->resetLoginAttempts();

            // Set session data
            $sessionData = [
                'user_id' => $user['id_user'],
                'username' => $user['username'],
                'hak_akses' => $user['hak_akses'],
                'isLoggedIn' => true,
                'login_time' => time()
            ];

            session()->set($sessionData);

            // Set remember me cookie jika dipilih
            if ($remember) {
                $this->setRememberMeCookie($user['id_user']);
            }

            // Log aktivitas login
            log_message('info', "User {$username} berhasil login dari IP: " . $this->request->getIPAddress());

            return redirect()->to('/admin/dashboard')->with('success', 'Login berhasil!');
        } else {
            // Increment login attempts
            $this->incrementLoginAttempts();
            
            // Log percobaan login gagal
            log_message('warning', "Percobaan login gagal untuk username: {$username} dari IP: " . $this->request->getIPAddress());

            $attempts = $this->getLoginAttempts();
            $remaining = $this->maxLoginAttempts - $attempts;

            if ($remaining <= 0) {
                $this->lockAccount();
                return redirect()->back()->with('error', 'Terlalu banyak percobaan login gagal. Akun dikunci selama 15 menit.');
            }

            return redirect()->back()
                           ->withInput()
                           ->with('error', "Username atau password salah! Sisa percobaan: {$remaining}");
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $username = session()->get('username');
        
        // Log aktivitas logout
        if ($username) {
            log_message('info', "User {$username} logout dari IP: " . $this->request->getIPAddress());
        }

        // Hapus remember me cookie
        $this->deleteRememberMeCookie();

        // Destroy session
        session()->destroy();
        
        return redirect()->to('/')->with('success', 'Logout berhasil!');
    }

    /**
     * Cek validasi password secara real-time (untuk AJAX)
     */
    public function checkPasswordStrength()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $password = $this->request->getPost('password');
        $validation = validatePasswordStrength($password);

        return $this->response->setJSON($validation);
    }

    /**
     * Increment login attempts
     */
    private function incrementLoginAttempts()
    {
        $ip = $this->request->getIPAddress();
        $key = "login_attempts_{$ip}";
        
        $attempts = session()->get($key) ?? 0;
        session()->set($key, $attempts + 1);
        session()->set("last_attempt_{$ip}", time());
    }

    /**
     * Get current login attempts
     */
    private function getLoginAttempts()
    {
        $ip = $this->request->getIPAddress();
        $key = "login_attempts_{$ip}";
        
        return session()->get($key) ?? 0;
    }

    /**
     * Reset login attempts
     */
    private function resetLoginAttempts()
    {
        $ip = $this->request->getIPAddress();
        session()->remove("login_attempts_{$ip}");
        session()->remove("last_attempt_{$ip}");
        session()->remove("locked_until_{$ip}");
    }

    /**
     * Lock account
     */
    private function lockAccount()
    {
        $ip = $this->request->getIPAddress();
        $lockUntil = time() + $this->lockoutTime;
        session()->set("locked_until_{$ip}", $lockUntil);
    }

    /**
     * Check if account is locked
     */
    private function isAccountLocked()
    {
        $ip = $this->request->getIPAddress();
        $lockedUntil = session()->get("locked_until_{$ip}");
        
        if ($lockedUntil && time() < $lockedUntil) {
            return true;
        }
        
        // Jika waktu lockout sudah habis, reset attempts
        if ($lockedUntil && time() >= $lockedUntil) {
            $this->resetLoginAttempts();
        }
        
        return false;
    }

    /**
     * Get remaining lockout time in minutes
     */
    private function getRemainingLockoutTime()
    {
        $ip = $this->request->getIPAddress();
        $lockedUntil = session()->get("locked_until_{$ip}");
        
        if ($lockedUntil) {
            $remaining = $lockedUntil - time();
            return ceil($remaining / 60);
        }
        
        return 0;
    }

    /**
     * Set remember me cookie
     */
    private function setRememberMeCookie($userId)
    {
        $token = bin2hex(random_bytes(32));
        $hashedToken = hash('sha256', $token);
        
        // Simpan token di database atau session (implementasi tergantung kebutuhan)
        session()->set('remember_token', $hashedToken);
        
        // Set cookie untuk 30 hari
        setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true);
    }

    /**
     * Delete remember me cookie
     */
    private function deleteRememberMeCookie()
    {
        session()->remove('remember_token');
        setcookie('remember_token', '', time() - 3600, '/');
    }
}