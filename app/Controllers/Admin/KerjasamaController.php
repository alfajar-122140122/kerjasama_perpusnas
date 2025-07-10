<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class KerjasamaController extends BaseController
{
    public function data()
    {
        $data = [
            'title' => 'Data Kerjasama'
        ];
        
        return view('admin/kerjasama/data', $data);
    }
    
    public function implementasi()
    {
        $data = [
            'title' => 'Implementasi Kerjasama'
        ];
        
        return view('admin/kerjasama/implementasi', $data);
    }
    
    public function tambahImplementasi()
    {
        $data = [
            'title' => 'Tambah Implementasi'
        ];
        
        return view('admin/kerjasama/tambah_implementasi', $data);
    }
    
    public function editImplementasi($id)
    {
        $data = [
            'title' => 'Edit Implementasi',
            'id' => $id
        ];
        
        return view('admin/kerjasama/edit_implementasi', $data);
    }
    
    public function akanBerakhir()
    {
        $data = [
            'title' => 'Kerjasama Akan Berakhir'
        ];
        
        return view('admin/kerjasama/akan_berakhir', $data);
    }
    
    public function progress()
    {
        $data = [
            'title' => 'Progress Kerjasama'
        ];
        
        return view('admin/kerjasama/progress', $data);
    }
    
    public function pengajuan()
    {
        $data = [
            'title' => 'Pengajuan Kerjasama'
        ];
        
        return view('admin/kerjasama/pengajuan', $data);
    }
    
    public function tambah()
    {
        $data = [
            'title' => 'Tambah Kerjasama'
        ];
        
        return view('admin/kerjasama/tambah', $data);
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Kerjasama',
            'id' => $id
        ];
        
        return view('admin/kerjasama/edit', $data);
    }
}