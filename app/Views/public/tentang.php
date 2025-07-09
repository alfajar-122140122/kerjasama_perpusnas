<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Tentang<?= $this->endSection() ?>

<?= $this->section('description') ?>Portal Kerjasama Perpustakaan Nasional - Penyiapan bahan dan melakukan kerja sama perpustakaan dalam dan luar negeri sesuai dengan petunjuk dan pedoman yang berlaku.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>tentang, perpustakaan nasional, kerjasama, tugas, fungsi, mou, moa<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/tentang.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="page-title">Tentang</h1>
    </div>
</div>

<!-- Main Content -->
<section class="content-section">
    <div class="container">
        <div class="about-container">
            <!-- About Image -->
            <div class="about-image">
                <img src="<?= base_url('assets/images/public/about-kerjasama.jpg') ?>" 
                     alt="Kegiatan Kerjasama Perpustakaan Nasional" 
                     loading="lazy">
            </div>
            
            <!-- About Content -->
            <div class="about-content">
                <h2 class="section-title">Tugas</h2>
                <p class="about-text">
                    Penyiapan bahan dan melakukan kerja sama perpustakaan dalam dan luar negeri sesuai dengan petunjuk dan pedoman yang berlaku.
                </p>
                
                <h3 class="section-title">Fungsi:</h3>
                <ul class="functions-list">
                    <li class="function-item">
                        <span class="function-letter">a)</span> Pelaksanaan kerja sama perpustakaan dalam dan luar negeri
                    </li>
                    <li class="function-item">
                        <span class="function-letter">b)</span> Penerima dan mengelola permohonan inisiasi kerja sama
                    </li>
                    <li class="function-item">
                        <span class="function-letter">c)</span> Pelaksanaan penanda tanganan naskah Kesepahaman Bersama atau Memorandum of Understanding (MoU)
                    </li>
                    <li class="function-item">
                        <span class="function-letter">d)</span> Mengelola dan mengevaluasi implementasi kerja sama.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/public/tentang.js') ?>"></script>
<?= $this->endSection() ?>