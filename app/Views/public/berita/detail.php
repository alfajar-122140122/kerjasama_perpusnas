<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?><?= $berita['judul'] ?? 'Detail Berita' ?><?= $this->endSection() ?>

<?= $this->section('description') ?><?= substr(strip_tags($berita['isi_berita'] ?? ''), 0, 160) ?><?= $this->endSection() ?>

<?= $this->section('keywords') ?>berita perpustakaan, aktivitas, kerjasama, perpustakaan nasional<?= $this->endSection() ?>

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
    
    .berita-content img {
        max-width: 100%;
        height: auto;
        margin: 20px 0;
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
    
    .related-section {
        padding: 50px 0;
        background-color: #f8f9fa;
    }
    
    .related-title {
        font-size: 1.5rem;
        margin-bottom: 30px;
        color: #1a3066;
        text-align: center;
    }
    
    .related-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        background-color: #fff;
    }
    
    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .related-image {
        height: 160px;
        overflow: hidden;
    }
    
    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .related-content {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .related-date {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 5px;
    }
    
    .related-title {
        font-size: 1rem;
        margin-bottom: 10px;
        line-height: 1.4;
        color: #333;
        text-align: left;
    }
    
    .related-link {
        margin-top: auto;
        font-size: 0.9rem;
        color: #1a3066;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .related-link i {
        transition: transform 0.3s ease;
    }
    
    .related-link:hover i {
        transform: translateX(3px);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container berita-detail-section">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($berita)): ?>
    <div class="berita-header">
        <h1 class="berita-title"><?= esc($berita['judul']) ?></h1>
        <div class="berita-meta">
            <div class="berita-date">
                <i class="fas fa-calendar-alt"></i>
                <?= date('d F Y', strtotime($berita['tanggal_publikasi'] ?? $berita['created_at'])) ?>
            </div>
            <div class="berita-category">
                <i class="fas fa-tag"></i>
                <span>Berita</span>
            </div>
        </div>
    </div>
    
    <div class="berita-image">
        <?php
            $imageExists = false;
            if (!empty($berita['gambar'])) {
                $imagePath = FCPATH . 'uploads/berita/' . $berita['gambar'];
                $imageExists = file_exists($imagePath) && is_file($imagePath);
            }
        ?>
        <?php if ($imageExists): ?>
            <img src="<?= base_url('uploads/berita/' . $berita['gambar']) ?>" alt="<?= esc($berita['judul']) ?>">
        <?php else: ?>
            <div class="berita-image-placeholder">
                <i class="fas fa-image fa-3x"></i>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="berita-content">
        <?= $berita['isi_berita'] ?>
    </div>
    
    <?php
    // Use the sourcePage passed from the controller
    $backUrl = isset($sourcePage) ? $sourcePage : 'berita';
    $backLabel = ($backUrl == 'aktivitas') ? 'Kembali ke Aktivitas' : 'Kembali ke Daftar Berita';
    ?>
    <a href="<?= base_url($backUrl) ?>" class="berita-back">
        <i class="fas fa-arrow-left"></i> <?= $backLabel ?>
    </a>
    <?php else: ?>
    <div class="alert alert-info">
        <h4>Berita tidak ditemukan</h4>
        <p>Berita yang Anda cari tidak tersedia atau telah dihapus.</p>
        <a href="<?= base_url(isset($sourcePage) ? $sourcePage : 'berita') ?>" class="btn btn-primary mt-3">
            Kembali ke <?= (isset($sourcePage) && $sourcePage == 'aktivitas') ? 'Aktivitas' : 'Daftar Berita' ?>
        </a>
    </div>
    <?php endif; ?>
</div>

<?php if (isset($related) && !empty($related)): ?>
<div class="related-section">
    <div class="container">
        <h2 class="related-title">Berita Terkait</h2>
        
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($related as $item): ?>
            <div class="col">
                <div class="related-card">
                    <div class="related-image">
                        <?php
                            $relatedImageExists = false;
                            if (!empty($item['gambar'])) {
                                $relatedImagePath = FCPATH . 'uploads/berita/' . $item['gambar'];
                                $relatedImageExists = file_exists($relatedImagePath) && is_file($relatedImagePath);
                            }
                        ?>
                        <?php if ($relatedImageExists): ?>
                            <img src="<?= base_url('uploads/berita/' . $item['gambar']) ?>" alt="<?= esc($item['judul']) ?>">
                        <?php else: ?>
                            <div class="related-image-placeholder" style="height:100%;display:flex;align-items:center;justify-content:center;background:#f1f1f1;">
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="related-content">
                        <div class="related-date"><?= date('d F Y', strtotime($item['tanggal_publikasi'] ?? $item['created_at'])) ?></div>
                        <h3 class="related-title"><?= esc($item['judul']) ?></h3>
                        <a href="<?= base_url((isset($sourcePage) && $sourcePage == 'aktivitas' ? 'aktivitas' : 'berita') . '/detail/' . $item['id']) ?>" class="related-link">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Any additional JavaScript can be added here
    });
</script>
<?= $this->endSection() ?>
