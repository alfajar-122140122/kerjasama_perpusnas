<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AboutModel;

class About extends BaseController
{
    protected $aboutModel;
    
    public function __construct()
    {
        $this->aboutModel = new AboutModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Tentang Tim Kerjasama',
            'about' => $this->aboutModel->first()
        ];
        
        return view('public/about/index', $data);
    }
}
