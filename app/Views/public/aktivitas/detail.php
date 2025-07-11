<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?><?= $berita['judul'] ?? 'Detail Berita' ?><?= $this->endSection() ?>

<?= $this->section('description') ?><?= $berita['excerpt'] ?? 'Detail berita dan aktivitas dari Perpustakaan Nasional RI' ?><?= $this->endSection() ?>

<?= $this->section('keywords') ?>berita perpustakaan, aktivitas, kerjasama, perpustakaan nasional, detail berita<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/aktivitas.css') ?>" rel="stylesheet">
<style>
    .berita-detail-section {
        padding: 50px 0;
    }
    
    .berita-header {
        margin-bottom: 30px;
    }
    
    .berita-title {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: #1a3066;
    }
    
    .berita-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        color: #6c757d;
    }
    
    .berita-date, .berita-category {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .berita-image {
        width: 100%;
        border-radius: 10px;
        margin-bottom: 30px;
        overflow: hidden;
        max-height: 400px;
    }
    
    .berita-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
    
    .berita-image-placeholder {
        background-color: #f1f1f1;
        height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #aaa;
    }
    
    .berita-content {
        line-height: 1.8;
        font-size: 1.1rem;
        color: #333;
    }
    
    .berita-content p {
        margin-bottom: 20px;
    }
    
    .berita-content h2, .berita-content h3 {
        margin-top: 30px;
        margin-bottom: 15px;
        color: #1a3066;
    }
    
    .berita-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 40px;
        padding: 10px 20px;
        background-color: #1a3066;
        color: white;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .berita-back:hover {
        background-color: #0d1b38;
        transform: translateY(-2px);
    }
    
    .berita-tags {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    
    .tag-badge {
        display: inline-block;
        background-color: #e9ecef;
        color: #495057;
        padding: 5px 12px;
        border-radius: 20px;
        margin-right: 8px;
        margin-bottom: 8px;
        font-size: 0.85rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Main Content -->
<section class="berita-detail-section">
    <div class="container">
        <div class="berita-header">
            <h1 class="berita-title"><?= $berita['judul'] ?? 'Penguatan Kelembagaan Perpustakaan, Pemkab Asmat Konsultasi ke Perpusnas' ?></h1>
            
            <div class="berita-meta">
                <div class="berita-date">
                    <i class="fas fa-calendar"></i>
                    <span><?= $berita['tanggal'] ?? '2025-07-03' ?></span>
                </div>
                <div class="berita-category">
                    <i class="fas fa-tag"></i>
                    <span><?= $berita['kategori'] ?? 'Berita' ?></span>
                </div>
            </div>
        </div>
        
        <div class="berita-image">
            <?php if(!empty($berita['gambar'])): ?>
                <img src="<?= base_url('uploads/berita/' . $berita['gambar']) ?>" alt="<?= $berita['judul'] ?>">
            <?php else: ?>
                <div class="berita-image-placeholder">
                    <i class="fas fa-image fa-3x"></i>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="berita-content">
            <?php if(!empty($berita['konten'])): ?>
                <?= $berita['konten'] ?>
            <?php else: ?>
                <p>JAKARTA - Perpustakaan Nasional Republik Indonesia (Perpusnas) menerima kunjungan konsultasi dari Pemerintah Kabupaten Asmat terkait penguatan kelembagaan perpustakaan daerah. Kegiatan ini merupakan bagian dari upaya meningkatkan kualitas layanan perpustakaan di daerah.</p>
                
                <p>Kepala Perpustakaan Nasional RI, Dr. Muhammad Syarif Bando, menyambut baik kunjungan konsultasi ini. Beliau menekankan pentingnya pengembangan perpustakaan di daerah terpencil sebagai pusat informasi dan pengetahuan bagi masyarakat.</p>
                
                <h3>Pentingnya Penguatan Kelembagaan</h3>
                
                <p>Dalam pertemuan tersebut, dibahas berbagai aspek penguatan kelembagaan perpustakaan, mulai dari struktur organisasi, sumber daya manusia, anggaran, hingga pengembangan koleksi dan layanan perpustakaan yang sesuai dengan kebutuhan masyarakat di Kabupaten Asmat.</p>
                
                <p>"Penguatan kelembagaan perpustakaan di daerah merupakan fondasi penting untuk memastikan keberlanjutan layanan perpustakaan yang berkualitas. Perpusnas berkomitmen untuk memberikan pendampingan teknis dalam pengembangan perpustakaan di Kabupaten Asmat," ujar Kepala Perpustakaan Nasional.</p>
                
                <h3>Rencana Tindak Lanjut</h3>
                
                <p>Sebagai tindak lanjut dari kunjungan konsultasi ini, Perpusnas akan mengirimkan tim teknis untuk melakukan asesmen kebutuhan dan memberikan pendampingan dalam pengembangan perpustakaan di Kabupaten Asmat. Selain itu, akan dilakukan pelatihan untuk meningkatkan kapasitas pengelola perpustakaan.</p>
                
                <p>Bupati Kabupaten Asmat, yang hadir dalam kunjungan tersebut, menyatakan apresiasinya atas dukungan Perpusnas. "Kami berharap dengan adanya penguatan kelembagaan perpustakaan, akses masyarakat Asmat terhadap informasi dan pengetahuan dapat meningkat, yang pada akhirnya akan berkontribusi pada peningkatan kualitas pendidikan di daerah kami," ujarnya.</p>
                
                <p>Kunjungan konsultasi ini merupakan implementasi dari Undang-Undang Nomor 43 Tahun 2007 tentang Perpustakaan, di mana Perpusnas memiliki tugas untuk melakukan pembinaan dan pengembangan perpustakaan di seluruh Indonesia.</p>
            <?php endif; ?>
        </div>
        
        <div class="berita-tags">
            <span class="tag-badge">Perpustakaan Nasional</span>
            <span class="tag-badge">Kabupaten Asmat</span>
            <span class="tag-badge">Kelembagaan</span>
            <span class="tag-badge">Pengembangan Perpustakaan</span>
        </div>
        
        <a href="<?= base_url('aktivitas') ?>" class="berita-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Aktivitas
        </a>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate content on load
    const elements = [
        document.querySelector('.berita-title'),
        document.querySelector('.berita-meta'),
        document.querySelector('.berita-image'),
        document.querySelector('.berita-content'),
        document.querySelector('.berita-tags'),
        document.querySelector('.berita-back')
    ];
    
    elements.forEach((element, index) => {
        if (element) {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, 100 + (index * 150));
        }
    });
});
</script>
<?= $this->endSection() ?>