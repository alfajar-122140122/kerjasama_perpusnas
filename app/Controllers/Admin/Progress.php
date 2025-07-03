<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CooperationModel;

class Progress extends BaseController
{
    protected $session;
    protected $cooperationModel;
    
    public function __construct()
    {
        $this->session = session();
        $this->cooperationModel = new CooperationModel();
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
            'title' => 'Progress Kerjasama',
            'progress' => $this->cooperationModel->getProgressData()
        ];
        
        return view('admin/progress_edit', $data);
    }
    
    public function updateChart()
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        // This method would update chart settings or data if needed
        // For example, setting visibility or display options
        
        $db = \Config\Database::connect();
        $settings = [
            'show_progress_chart' => $this->request->getPost('show_chart') ? 1 : 0,
            'chart_type' => $this->request->getPost('chart_type'),
            'updated_by' => $this->session->get('user_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $db->table('settings')->where('category', 'chart')->update($settings);
        
        return redirect()->to('/admin/progress')->with('success', 'Pengaturan chart berhasil diperbarui');
    }
    
    public function exportData($format = 'pdf')
    {
        // Check authentication
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $progress = $this->cooperationModel->getProgressData();
        
        if ($format === 'excel') {
            // Export as Excel
            return $this->exportToExcel($progress);
        } else {
            // Export as PDF
            return $this->exportToPdf($progress);
        }
    }
    
    private function exportToPdf($data)
    {
        // Implementation for PDF export would go here
        // This is a placeholder for the actual implementation
        
        // Example of using TCPDF or similar library
        $html = view('admin/exports/progress_pdf', ['progress' => $data]);
        
        // Generate PDF code would go here
        
        return redirect()->to('/admin/progress')->with('success', 'Data progress berhasil diekspor ke PDF');
    }
    
    private function exportToExcel($data)
    {
        // Implementation for Excel export would go here
        // This is a placeholder for the actual implementation
        
        // Example of using PhpSpreadsheet or similar library
        
        return redirect()->to('/admin/progress')->with('success', 'Data progress berhasil diekspor ke Excel');
    }
}
