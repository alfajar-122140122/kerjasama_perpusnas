<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ContentManagement extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = session();
        helper(['form', 'url']);
    }
    
    // Middleware check untuk semua method admin
    private function checkAuth()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        if ($this->session->get('hak_akses') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki hak akses ke halaman ini.');
        }
        
        return null;
    }
    
    public function index()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $data = [
            'title' => 'Manajemen Konten'
        ];
        
        return view('admin/edit_content', $data);
    }
    
    public function editAbout()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Load the AboutModel
        $aboutModel = new \App\Models\AboutModel();
        $about = $aboutModel->first();
        
        $data = [
            'title' => 'Edit Halaman Tentang Kami',
            'about' => $about
        ];
        
        return view('admin/edit_content', $data);
    }
    
    public function updateAbout()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Validate input
        $rules = [
            'content' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Update about content
        $aboutModel = new \App\Models\AboutModel();
        $aboutModel->update(1, [
            'content' => $this->request->getPost('content'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->get('user_id')
        ]);
        
        return redirect()->to('/admin/content/about')->with('success', 'Konten Tentang Kami berhasil diperbarui');
    }
    
    public function editStatistics()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Load the StatisticsModel
        $statsModel = new \App\Models\StatisticsModel();
        $stats = $statsModel->findAll();
        
        $data = [
            'title' => 'Edit Statistik Kerja Sama',
            'statistics' => $stats
        ];
        
        return view('admin/edit_content', $data);
    }
    
    public function updateStatistics()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Update statistics
        $statsModel = new \App\Models\StatisticsModel();
        
        // Process each statistic item
        $ids = $this->request->getPost('id');
        $labels = $this->request->getPost('label');
        $values = $this->request->getPost('value');
        $icons = $this->request->getPost('icon');
        
        for ($i = 0; $i < count($ids); $i++) {
            $statsModel->update($ids[$i], [
                'label' => $labels[$i],
                'value' => $values[$i],
                'icon' => $icons[$i],
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        return redirect()->to('/admin/content/statistics')->with('success', 'Statistik Kerja Sama berhasil diperbarui');
    }
    
    public function editActivities()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Load the ActivityModel
        $activityModel = new \App\Models\ActivityModel();
        $activities = $activityModel->orderBy('date', 'DESC')->findAll();
        
        $data = [
            'title' => 'Edit Aktivitas Terbaru',
            'activities' => $activities
        ];
        
        return view('admin/edit_content', $data);
    }
    
    public function addActivity()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Validate input
        $rules = [
            'title' => 'required|min_length[5]',
            'description' => 'required',
            'date' => 'required|valid_date',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,2048]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Upload image
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move(WRITEPATH . 'uploads/activities', $imageName);
        
        // Save activity
        $activityModel = new \App\Models\ActivityModel();
        $activityModel->save([
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'date' => $this->request->getPost('date'),
            'image' => $imageName,
            'created_by' => $this->session->get('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('/admin/content/activities')->with('success', 'Aktivitas baru berhasil ditambahkan');
    }
    
    public function updateActivity($id)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Validate input
        $rules = [
            'title' => 'required|min_length[5]',
            'description' => 'required',
            'date' => 'required|valid_date'
        ];
        
        // Check if image is being updated
        if ($this->request->getFile('image')->isValid()) {
            $rules['image'] = 'uploaded[image]|is_image[image]|max_size[image,2048]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Prepare update data
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'date' => $this->request->getPost('date'),
            'updated_by' => $this->session->get('user_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Handle image upload if provided
        if ($this->request->getFile('image')->isValid()) {
            $image = $this->request->getFile('image');
            $imageName = $image->getRandomName();
            $image->move(WRITEPATH . 'uploads/activities', $imageName);
            $data['image'] = $imageName;
            
            // Delete old image
            $activityModel = new \App\Models\ActivityModel();
            $oldActivity = $activityModel->find($id);
            if ($oldActivity && !empty($oldActivity['image'])) {
                $oldImagePath = WRITEPATH . 'uploads/activities/' . $oldActivity['image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }
        
        // Update activity
        $activityModel = new \App\Models\ActivityModel();
        $activityModel->update($id, $data);
        
        return redirect()->to('/admin/content/activities')->with('success', 'Aktivitas berhasil diperbarui');
    }
    
    public function deleteActivity($id)
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Delete activity
        $activityModel = new \App\Models\ActivityModel();
        
        // Get activity data to delete image
        $activity = $activityModel->find($id);
        if ($activity && !empty($activity['image'])) {
            $imagePath = WRITEPATH . 'uploads/activities/' . $activity['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $activityModel->delete($id);
        
        return redirect()->to('/admin/content/activities')->with('success', 'Aktivitas berhasil dihapus');
    }
    
    public function editContact()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Assume we have contact info stored in a settings table or similar
        $db = \Config\Database::connect();
        $contactInfo = $db->table('settings')->where('category', 'contact')->get()->getResultArray();
        
        $data = [
            'title' => 'Edit Informasi Kontak',
            'contact' => $contactInfo
        ];
        
        return view('admin/edit_content', $data);
    }
    
    public function updateContact()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // Update contact information
        $db = \Config\Database::connect();
        
        $contactData = [
            'address' => $this->request->getPost('address'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'working_hours' => $this->request->getPost('working_hours'),
            'map_link' => $this->request->getPost('map_link')
        ];
        
        foreach ($contactData as $key => $value) {
            $db->table('settings')->where('category', 'contact')->where('key', $key)->update(['value' => $value]);
        }
        
        return redirect()->to('/admin/content/contact')->with('success', 'Informasi kontak berhasil diperbarui');
    }
}
