<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Map extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Peta Kerjasama',
            'active' => 'map'
        ];
        
        // Kita bisa mengambil data lokasi kerjasama dari database jika diperlukan
        // Misalnya untuk menampilkan marker di peta
        
        return view('public/map/index', $data);
    }
}
