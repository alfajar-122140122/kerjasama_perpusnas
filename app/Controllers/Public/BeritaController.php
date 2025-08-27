<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Models\BeritaModel;

class BeritaController extends BaseController
{
    protected $beritaModel;
    
    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
    }
    
    public function index()
    {
        try {
            // Set pagination
            $perPage = 9; // Number of items per page
            
            // Current date and time for comparison
            $currentDateTime = date('Y-m-d H:i:s');
            
            // Build the query for published berita
            $this->beritaModel->where('status', 'published');
            
            // We want to show berita where:
            // 1. Publication date is in the past or current, OR
            // 2. Publication date is NULL (immediately show)
            $this->beritaModel->groupStart()
                ->where('tanggal_publikasi <=', $currentDateTime)
                ->orWhere('tanggal_publikasi IS NULL', null, false)
            ->groupEnd();
            
            // Get results with pagination
            $berita = $this->beritaModel->orderBy('tanggal_publikasi', 'DESC')
                ->paginate($perPage);
                
            // Get pager instance
            $pager = $this->beritaModel->pager;
            
            $data = [
                'title' => 'Berita dan Aktivitas',
                'berita' => $berita,
                'pager' => $pager
            ];
            
            // Determine which view to use based on the route being called
            $uriString = uri_string();
            
            // Check if this is aktivitas route by checking the actual route
            if (strpos($uriString, 'aktivitas') === 0) {
                // This is aktivitas route
                return view('public/aktivitas', $data);
            } else {
                // This is berita route  
                return view('public/berita/index', $data);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data berita: ' . $e->getMessage());
        }
    }
    
    public function detail($id)
    {
        try {
            // Get the requested berita
            $berita = $this->beritaModel->find($id);
            
            // If berita not found or not published, show 404
            if (!$berita || $berita['status'] !== 'published') {
                // Determine which path to redirect to based on the current URL
                if (strpos(current_url(), '/aktivitas/') !== false) {
                    return redirect()->to('/aktivitas')->with('error', 'Berita tidak ditemukan');
                } else {
                    return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan');
                }
            }
            
            // Check if it's a future publication date (only if publication date exists)
            if (!empty($berita['tanggal_publikasi']) && strtotime($berita['tanggal_publikasi']) > time()) {
                if (strpos(current_url(), '/aktivitas/') !== false) {
                    return redirect()->to('/aktivitas')->with('error', 'Berita belum dipublikasikan');
                } else {
                    return redirect()->to('/berita')->with('error', 'Berita belum dipublikasikan');
                }
            }
            
            // Get related news (excluding the current one)
            $relatedBerita = $this->beritaModel
                ->where('status', 'published')
                ->where('tanggal_publikasi <=', date('Y-m-d H:i:s'))
                ->where('id !=', $id) // Changed from id_berita to id
                ->orderBy('tanggal_publikasi', 'DESC')
                ->limit(3)
                ->findAll();
            
            // Create excerpt for meta description
            $excerpt = substr(strip_tags($berita['isi_berita']), 0, 160);
            
            // Determine the source page (aktivitas or berita) based on the current URL
            $currentURL = current_url();
            $sourcePage = (strpos($currentURL, '/aktivitas/') !== false) ? 'aktivitas' : 'berita';
            
            $data = [
                'title' => $berita['judul'],
                'excerpt' => $excerpt,
                'berita' => $berita,
                'related' => $relatedBerita,
                'sourcePage' => $sourcePage
            ];
            
            return view('public/berita/detail', $data);
        } catch (\Exception $e) {
            // Determine which path to redirect to based on the current URL
            if (strpos(current_url(), '/aktivitas/') !== false) {
                return redirect()->to('/aktivitas')->with('error', 'Gagal memuat detail berita: ' . $e->getMessage());
            } else {
                return redirect()->to('/berita')->with('error', 'Gagal memuat detail berita: ' . $e->getMessage());
            }
        }
    }
}
