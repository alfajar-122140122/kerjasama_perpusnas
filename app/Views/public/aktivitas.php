<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Aktivitas<?= $this->endSection() ?>

<?= $this->section('description') ?>Berita dan aktivitas terkini dari Sub Bidang Kerja Sama Perpustakaan, Perpustakaan Nasional RI. Informasi kegiatan, kerjasama, dan perkembangan perpustakaan.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>aktivitas, berita, kerjasama, perpustakaan nasional, kegiatan, jakarta, mou<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/aktivitas.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Main Content -->
<section class="aktivitas-section">
    <div class="container">
        <h1 class="page-title">Aktivitas</h1>
        
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>
        
        <!-- News Grid -->
        <div class="news-grid">
            <?php if (is_array($berita) && count($berita) > 0): ?>
                <?php foreach ($berita as $item): ?>
                <article class="news-card">
                    <div class="news-image">
                        <?php
                            $imageExists = false;
                            if (!empty($item['gambar'])) {
                                $imagePath = FCPATH . 'uploads/berita/' . $item['gambar'];
                                $imageExists = file_exists($imagePath) && is_file($imagePath);
                            }
                        ?>
                        <?php if ($imageExists): ?>
                            <img src="<?= base_url('uploads/berita/' . $item['gambar']) ?>" alt="<?= esc($item['judul']) ?>" class="news-img">
                        <?php else: ?>
                            <div class="news-image-placeholder">
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date">
                                <i class="fas fa-calendar"></i> 
                                <?= date('d-m-Y', strtotime($item['tanggal_publikasi'] ?? $item['created_at'])) ?>
                            </span>
                            <span class="news-category"><i class="fas fa-tag"></i> Berita</span>
                        </div>
                        <h3 class="news-title"><?= esc($item['judul']) ?></h3>
                        <p class="news-excerpt"><?= substr(strip_tags($item['isi_berita']), 0, 200) ?>...</p>
                        <a href="<?= base_url('aktivitas/detail/' . $item['id_berita']) ?>" class="btn-read-more">Baca Selengkapnya</a>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- No News Available -->
                <div class="no-news">
                    <h3>Belum ada berita yang dipublikasikan</h3>
                    <p>Silakan kunjungi kembali nanti untuk informasi terbaru.</p>
                </div>
            <?php endif; ?>

        </div>

        <!-- Pagination - to be added if needed -->
        <?php if (isset($pager)): ?>
        <div class="pagination-wrapper">
            <?= $pager->links() ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/public/aktivitas.js') ?>"></script>
<?= $this->endSection() ?>