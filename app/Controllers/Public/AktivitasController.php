<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;

class AktivitasController extends BaseController
{
    public function detail($id = null)
    {
        // Di implementasi sebenarnya, data berita akan diambil dari database berdasarkan ID
        // Untuk contoh ini, kita gunakan data statis
        
        // Jika ID tidak ada, redirect ke halaman aktivitas
        if (empty($id)) {
            return redirect()->to(base_url('aktivitas'));
        }
        
        // Data sample untuk berita dengan ID 1
        $berita = [
            'id' => $id,
            'judul' => 'Penguatan Kelembagaan Perpustakaan, Pemkab Asmat Konsultasi ke Perpusnas',
            'tanggal' => '2025-07-03',
            'kategori' => 'Berita',
            'gambar' => '', // Placeholder (kosong jika tidak ada gambar)
            'excerpt' => 'Perpustakaan Nasional Republik Indonesia (Perpusnas) menerima kunjungan konsultasi dari Pemerintah Kabupaten Asmat terkait penguatan kelembagaan perpustakaan daerah.',
            'konten' => '<p>JAKARTA - Perpustakaan Nasional Republik Indonesia (Perpusnas) menerima kunjungan konsultasi dari Pemerintah Kabupaten Asmat terkait penguatan kelembagaan perpustakaan daerah. Kegiatan ini merupakan bagian dari upaya meningkatkan kualitas layanan perpustakaan di daerah.</p>
                    
            <p>Kepala Perpustakaan Nasional RI, Dr. Muhammad Syarif Bando, menyambut baik kunjungan konsultasi ini. Beliau menekankan pentingnya pengembangan perpustakaan di daerah terpencil sebagai pusat informasi dan pengetahuan bagi masyarakat.</p>
            
            <h3>Pentingnya Penguatan Kelembagaan</h3>
            
            <p>Dalam pertemuan tersebut, dibahas berbagai aspek penguatan kelembagaan perpustakaan, mulai dari struktur organisasi, sumber daya manusia, anggaran, hingga pengembangan koleksi dan layanan perpustakaan yang sesuai dengan kebutuhan masyarakat di Kabupaten Asmat.</p>
            
            <p>"Penguatan kelembagaan perpustakaan di daerah merupakan fondasi penting untuk memastikan keberlanjutan layanan perpustakaan yang berkualitas. Perpusnas berkomitmen untuk memberikan pendampingan teknis dalam pengembangan perpustakaan di Kabupaten Asmat," ujar Kepala Perpustakaan Nasional.</p>
            
            <h3>Rencana Tindak Lanjut</h3>
            
            <p>Sebagai tindak lanjut dari kunjungan konsultasi ini, Perpusnas akan mengirimkan tim teknis untuk melakukan asesmen kebutuhan dan memberikan pendampingan dalam pengembangan perpustakaan di Kabupaten Asmat. Selain itu, akan dilakukan pelatihan untuk meningkatkan kapasitas pengelola perpustakaan.</p>
            
            <p>Bupati Kabupaten Asmat, yang hadir dalam kunjungan tersebut, menyatakan apresiasinya atas dukungan Perpusnas. "Kami berharap dengan adanya penguatan kelembagaan perpustakaan, akses masyarakat Asmat terhadap informasi dan pengetahuan dapat meningkat, yang pada akhirnya akan berkontribusi pada peningkatan kualitas pendidikan di daerah kami," ujarnya.</p>
            
            <p>Kunjungan konsultasi ini merupakan implementasi dari Undang-Undang Nomor 43 Tahun 2007 tentang Perpustakaan, di mana Perpusnas memiliki tugas untuk melakukan pembinaan dan pengembangan perpustakaan di seluruh Indonesia.</p>'
        ];
        
        // Data untuk berita lain dapat ditambahkan dengan kondisi switch-case berdasarkan ID
        if ($id != 1) {
            // Jika bukan ID 1, gunakan template yang sama tapi dengan judul yang dimodifikasi
            $berita['judul'] = 'Berita #' . $id . ': ' . $berita['judul'];
        }
        
        $data = [
            'title' => $berita['judul'],
            'berita' => $berita
        ];
        
        return view('public/aktivitas/detail', $data);
    }

}