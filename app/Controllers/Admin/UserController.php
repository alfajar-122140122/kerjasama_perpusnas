<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/users', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[255]|is_unique[users.username]',
                'password' => 'required|min_length[8]',
                'hak_akses' => 'required|in_list[admin,user]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data tidak valid: ' . implode(', ', $this->validator->getErrors()));
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'password' => $this->request->getPost('password'),
                'hak_akses' => $this->request->getPost('hak_akses')
            ];

            if ($this->userModel->insert($data)) {
                return redirect()->to('/admin/users')
                    ->with('success', 'User berhasil ditambahkan');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menambahkan user');
            }
        }

        return redirect()->to('/admin/users');
    }

    public function edit($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $user = $this->userModel->find($id);
            if (!$user) {
                return redirect()->to('/admin/users')
                    ->with('error', 'User tidak ditemukan');
            }

            $rules = [
                'username' => "required|min_length[3]|max_length[255]|is_unique[users.username,id_user,{$id}]",
                'hak_akses' => 'required|in_list[admin,user]'
            ];

            // Only validate password if provided
            $password = $this->request->getPost('password');
            if (!empty($password)) {
                $rules['password'] = 'min_length[8]';
            }

            if (!$this->validate($rules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data tidak valid: ' . implode(', ', $this->validator->getErrors()));
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'hak_akses' => $this->request->getPost('hak_akses')
            ];

            // Only update password if provided
            if (!empty($password)) {
                $data['password'] = $password;
            }

            if ($this->userModel->update($id, $data)) {
                return redirect()->to('/admin/users')
                    ->with('success', 'User berhasil diupdate');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengupdate user');
            }
        }

        return redirect()->to('/admin/users');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')
                ->with('error', 'User tidak ditemukan');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/users')
                ->with('success', 'User berhasil dihapus');
        } else {
            return redirect()->to('/admin/users')
                ->with('error', 'Gagal menghapus user');
        }
    }

    public function changePassword($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $user = $this->userModel->find($id);
            if (!$user) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ]);
            }

            $rules = [
                'new_password' => 'required|min_length[8]',
                'confirm_password' => 'required|matches[new_password]'
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Password tidak valid',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $data = [
                'password' => $this->request->getPost('new_password')
            ];

            if ($this->userModel->update($id, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Password berhasil diubah'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengubah password'
                ]);
            }
        }

        return redirect()->to('/admin/users');
    }

    public function resetPassword($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // Generate random password
        $newPassword = $this->generateRandomPassword();

        $data = [
            'password' => $newPassword
        ];

        if ($this->userModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Password berhasil direset',
                'new_password' => $newPassword
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mereset password'
            ]);
        }
    }

    private function generateRandomPassword($length = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }
        
        return $randomPassword;
    }

    public function getUserData($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // Remove password from response
        unset($user['password']);

        return $this->response->setJSON([
            'success' => true,
            'data' => $user
        ]);
    }
}