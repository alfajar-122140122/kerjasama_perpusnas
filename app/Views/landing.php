<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerjasama Perpustakaan - Perpustakaan Nasional Republik Indonesia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('css/landing.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Header Top -->
    <div class="header-top">
        <div class="container">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="logo-text">
                    <h1>KERJASAMA PERPUSTAKAAN</h1>
                    <p>PERPUSTAKAAN NASIONAL REPUBLIK INDONESIA</p>
                </div>
            </div>
            <div class="header-controls">
                <select class="language-select">
                    <option>Situs ini</option>
                    <option>Bahasa Indonesia</option>
                    <option>English</option>
                </select>
                <div class="search-box">
                    <input type="text" placeholder="Cari..." class="form-control">
                    <button type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <a href="<?= base_url('auth/login') ?>" class="login-btn">Login</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg main-nav">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('/') ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('tentang') ?>">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('aktivitas') ?>">Aktivitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('kerja-sama') ?>">Kerja Sama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('peta-kerja-sama') ?>">Peta Kerja Sama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('kontak') ?>">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero/Stats Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stats-card loading">
                        <div class="stats-number">103</div>
                        <div class="stats-label">x 36</div>
                        <div class="mt-2">
                            <small>Statistik Kerja Sama</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="chart-container loading">
                                <div class="chart-placeholder">
                                    <i class="fas fa-chart-bar fa-3x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="chart-container loading">
                                <div class="chart-placeholder">
                                    <i class="fas fa-chart-line fa-3x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="chart-container loading">
                                <div class="chart-placeholder">
                                    <i class="fas fa-chart-pie fa-3x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Activities Section -->
    <section class="activities-section">
        <div class="container">
            <h2 class="section-title">Aktivitas Terbaru</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="activity-card loading">
                        <div class="activity-image">
                            <div class="activity-date">Berita 17 Juni 2025</div>
                        </div>
                        <div class="activity-content">
                            <h5 class="activity-title">Berita Bersama Kegiatan Lokal Diluncurkan Sebagai Bagian Perpustakaan Digital</h5>
                            <p class="activity-description">JAKARTA - Perpustakaan Nasional Republik Indonesia (Perpusnas) memanjurkan seberapa sambilan buku yang menggunakan temu kegiatan Lokal untuk Warisan...</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="activity-card loading">
                        <div class="activity-image">
                            <div class="activity-date">Berita 09 Februari 2025</div>
                        </div>
                        <div class="activity-content">
                            <h5 class="activity-title">Sebuah Bangunan Perpusnas 2025, Hari Untuk di Luncurkan</h5>
                            <p class="activity-description">JAKARTA - dengan operasional Perpusnas memulai layanan dengan semua ulagan biasa dengan wilayah anggaran, layanan operasional yang tembal normal...</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="activity-card loading">
                        <div class="activity-image">
                            <div class="activity-date">Berita 21 November 2024</div>
                        </div>
                        <div class="activity-content">
                            <h5 class="activity-title">Perpustakaan Gunungkawi Inisiasi Sosial di Ajang Ternua</h5>
                            <p class="activity-description">JAKARTA - Perpustakaan begins (PN) Yayasan Perpustakaan Nasional Republik Indonesia ( Perpusnas ) E. Aminudin Asia menyampaikan hal ini merupakan...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="<?= base_url('agenda-kerjasama') ?>" class="service-card loading">
                        <div class="service-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h6 class="service-title">Agenda Kerjasama</h6>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="<?= base_url('data-kerja-sama') ?>" class="service-card loading">
                        <div class="service-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h6 class="service-title">Data Kerja Sama</h6>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="<?= base_url('implementasi-kerja-sama') ?>" class="service-card loading">
                        <div class="service-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h6 class="service-title">Implementasi Kerja Sama</h6>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="<?= base_url('kerja-sama-yang-akan-berakhir') ?>" class="service-card loading">
                        <div class="service-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h6 class="service-title">Kerja Sama yang Akan Berakhir</h6>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="<?= base_url('progress-kerja-sama') ?>" class="service-card loading">
                        <div class="service-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h6 class="service-title">Progress Kerja Sama</h6>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="<?= base_url('peta-kerja-sama') ?>" class="service-card loading">
                        <div class="service-icon">
                            <i class="fas fa-map"></i>
                        </div>
                        <h6 class="service-title">Peta Kerja Sama</h6>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5>Tentang Kami</h5>
                    <ul>
                        <li><a href="#">Profil Perpusnas</a></li>
                        <li><a href="#">Visi & Misi</a></li>
                        <li><a href="#">Struktur Organisasi</a></li>
                        <li><a href="#">Sejarah</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h5>Layanan</h5>
                    <ul>
                        <li><a href="#">Kerjasama Perpustakaan</a></li>
                        <li><a href="#">Koleksi Digital</a></li>
                        <li><a href="#">Pelatihan</a></li>
                        <li><a href="#">Konsultasi</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h5>Kontak</h5>
                    <ul>
                        <li><a href="#">Alamat: Jl. Salemba Raya 28A</a></li>
                        <li><a href="#">Jakarta Pusat 10440</a></li>
                        <li><a href="#">Telp: (021) 3192 3119</a></li>
                        <li><a href="#">Email: info@perpusnas.go.id</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> Perpustakaan Nasional Republik Indonesia. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Loading animation
        document.addEventListener('DOMContentLoaded', function() {
            const loadingElements = document.querySelectorAll('.loading');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('loaded');
                        }, Math.random() * 300);
                    }
                });
            });
            
            loadingElements.forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>