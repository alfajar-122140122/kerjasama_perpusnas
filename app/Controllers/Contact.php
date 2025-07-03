<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Contact extends BaseController
{
    public function index()
    {
        // Get contact information from settings table
        $db = \Config\Database::connect();
        $contactInfo = $db->table('settings')->where('category', 'contact')->get()->getResultArray();
        
        // Reformat into associative array
        $contact = [];
        foreach ($contactInfo as $info) {
            $contact[$info['key']] = $info['value'];
        }
        
        $data = [
            'title' => 'Kontak Kami',
            'active' => 'contact',
            'contact' => $contact
        ];
        
        return view('public/contact/index', $data);
    }
    
    public function sendMessage()
    {
        // Validate input
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'subject' => 'required|min_length[5]',
            'message' => 'required|min_length[10]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Save contact message to database or send email
        $db = \Config\Database::connect();
        $db->table('contact_messages')->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        // Could also send an email notification here
        
        return redirect()->to('/contact')->with('success', 'Pesan Anda telah berhasil dikirim. Kami akan menghubungi Anda segera.');
    }
}
