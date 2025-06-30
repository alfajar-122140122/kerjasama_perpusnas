<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('landing');
    }
    
    public function tentang(): string
    {
        return view('pages/tentang');
    }
    
    public function aktivitas(): string
    {
        return view('pages/aktivitas');
    }
    
    public function kerjaSama(): string
    {
        return view('pages/kerja-sama');
    }
    
    public function petaKerjaSama(): string
    {
        return view('pages/peta-kerja-sama');
    }
    
    public function kontak(): string
    {
        return view('pages/kontak');
    }
}