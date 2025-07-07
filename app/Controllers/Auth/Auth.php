<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }
        
        return view('auth/login');
    }
    
    public function attemptLogin()
    {
        $rules = [
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[6]'
        ];
        
        if (!$this->validate($rules)) {
            return view('auth/login', [
                'validation' => $this->validator
            ]);
        }
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // TODO: Implementasi autentikasi dengan database
        // Sementara menggunakan hardcode untuk testing
        if ($username === 'admin' && $password === 'password') {
            $sessionData = [
                'user_id' => 1,
                'username' => $username,
                'role' => 'admin',
                'isLoggedIn' => true
            ];
            
            session()->set($sessionData);
            
            return redirect()->to('/admin/dashboard')->with('success', 'Login berhasil!');
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Username atau password salah!');
        }
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Logout berhasil!');
    }
}