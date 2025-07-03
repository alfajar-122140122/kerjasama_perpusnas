<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Perpustakaan Nasional RI</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="<?= base_url('css/all.min.css') ?>" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    
    <!-- Additional styles -->
    <?= $this->renderSection('styles') ?>
    
    <!-- OpenStreetMap -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="">
    
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-XXXXXXXXXX');
    </script>
</head>
<body>
    <!-- Header -->
    <header>
        <!-- Top Bar -->
        <div class="top-bar bg-primary text-white py-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><i class="fas fa-envelope me-2"></i> info@perpusnas.go.id</li>
                            <li class="list-inline-item ms-3"><i class="fas fa-phone me-2"></i> (021) 3812-1111</li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-end">
                        <ul class="list-inline mb-0 social-links">
                            <li class="list-inline-item"><a href="https://facebook.com/ayokeperpusnas" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li class="list-inline-item"><a href="https://twitter.com/perpusnas1" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="https://instagram.com/perpusnas.go.id" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="https://youtube.com/@perpusnas" target="_blank"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="<?= base_url() ?>">
                    <img src="<?= base_url('images/logo-perpusnas.png') ?>" alt="Logo Perpustakaan Nasional RI" height="60">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= (current_url() == site_url('')) ? 'active' : '' ?>" href="<?= base_url() ?>">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (strpos(current_url(), '/about') !== false) ? 'active' : '' ?>" href="<?= site_url('about') ?>">Tentang Kami</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= (strpos(current_url(), '/cooperation') !== false) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Kerjasama
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= site_url('cooperation') ?>">Informasi Kerjasama</a></li>
                                <li><a class="dropdown-item" href="<?= site_url('cooperation/data') ?>">Data Kerjasama</a></li>
                                <li><a class="dropdown-item" href="<?= site_url('cooperation/expiring') ?>">Kerjasama Kedaluwarsa</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= site_url('cooperation/submission') ?>">Form Permohonan</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (strpos(current_url(), '/map') !== false) ? 'active' : '' ?>" href="<?= site_url('map') ?>">Peta Kerjasama</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (strpos(current_url(), '/contact') !== false) ? 'active' : '' ?>" href="<?= site_url('contact') ?>">Kontak</a>
                        </li>
                        <?php if (session()->get('isLoggedIn')): ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-sm btn-outline-primary ms-2" href="<?= site_url('admin/dashboard') ?>">Dashboard Admin</a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-sm btn-outline-primary ms-2" href="<?= site_url('auth/login') ?>">Login</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>
    
    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Perpustakaan Nasional RI</h5>
                    <p>Perpustakaan Nasional adalah Lembaga Pemerintah Non Kementerian yang melaksanakan tugas pemerintahan dalam bidang perpustakaan.</p>
                    <div class="mt-4">
                        <img src="<?= base_url('images/logo-perpusnas-white.png') ?>" alt="Logo Perpustakaan Nasional RI" height="70">
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Tautan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="<?= base_url() ?>" class="text-white text-decoration-none">Beranda</a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= site_url('about') ?>" class="text-white text-decoration-none">Tentang Kami</a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= site_url('cooperation') ?>" class="text-white text-decoration-none">Kerjasama</a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= site_url('map') ?>" class="text-white text-decoration-none">Peta Kerjasama</a>
                        </li>
                        <li>
                            <a href="<?= site_url('contact') ?>" class="text-white text-decoration-none">Kontak</a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Situs Terkait</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="https://perpusnas.go.id" target="_blank" class="text-white text-decoration-none">Website Resmi</a>
                        </li>
                        <li class="mb-2">
                            <a href="https://e-resources.perpusnas.go.id" target="_blank" class="text-white text-decoration-none">E-Resources</a>
                        </li>
                        <li class="mb-2">
                            <a href="https://onesearch.id" target="_blank" class="text-white text-decoration-none">Indonesia OneSearch</a>
                        </li>
                        <li class="mb-2">
                            <a href="https://inlis.perpusnas.go.id" target="_blank" class="text-white text-decoration-none">INLIS Lite</a>
                        </li>
                        <li>
                            <a href="https://isbn.perpusnas.go.id" target="_blank" class="text-white text-decoration-none">ISBN</a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-home me-2"></i> Jl. Salemba Raya No. 28A, Jakarta Pusat, DKI Jakarta 10430
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope me-2"></i> info@perpusnas.go.id
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone me-2"></i> (021) 3812-1111
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-fax me-2"></i> (021) 3812-2222
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="text-center py-3 mt-3 border-top border-secondary">
            <p class="mb-0">© <?= date('Y') ?> Perpustakaan Nasional Republik Indonesia. Hak Cipta Dilindungi Undang-Undang.</p>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <button id="back-to-top" class="btn btn-primary btn-sm" title="Back to Top">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>
    
    <!-- jQuery -->
    <script src="<?= base_url('js/jquery-3.6.0.min.js') ?>"></script>
    
    <!-- OpenStreetMap JS -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    
    <!-- Custom JS -->
    <script src="<?= base_url('js/script.js') ?>"></script>
    
    <!-- Back to Top Script -->
    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('#back-to-top').fadeIn();
                } else {
                    $('#back-to-top').fadeOut();
                }
            });
            
            $('#back-to-top').click(function() {
                $('html, body').animate({scrollTop: 0}, 800);
                return false;
            });
        });
    </script>
    
    <!-- Additional scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>
