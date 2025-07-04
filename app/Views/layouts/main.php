<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title', true) ?> - Kerjasama Perpustakaan Nasional</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('images/favicon-perpusnas.png') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('css/main.css') ?>" rel="stylesheet">
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <div class="main-container" id="mainContainer">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="<?= base_url('images/LOGO-PERPUSNAS.png') ?>" alt="Perpusnas Logo" class="perpusnas-logo mb-2" width="100">
                <div class="site-info">
                    <h6 class="text-white">KERJASAMA PERPUSTAKAAN</h6>
                    <small class="text-light">PERPUSNAS RI</small>
                </div>
            </div>
            <div class="sidebar-menu">
                <a href="<?= base_url('/') ?>" class="menu-item <?= (uri_string() == '' || uri_string() == '/') ? 'active' : '' ?>">
                    <i class="fas fa-home"></i>
                    Beranda
                </a>
                <a href="<?= base_url('tentang') ?>" class="menu-item <?= (uri_string() == 'tentang') ? 'active' : '' ?>">
                    <i class="fas fa-info-circle"></i>
                    Tentang
                </a>
                <a href="<?= base_url('aktivitas') ?>" class="menu-item <?= (uri_string() == 'aktivitas') ? 'active' : '' ?>">
                    <i class="fas fa-calendar-alt"></i>
                    Aktivitas
                </a>
                <a href="<?= base_url('kerja-sama') ?>" class="menu-item <?= (uri_string() == 'kerja-sama') ? 'active' : '' ?>">
                    <i class="fas fa-handshake"></i>
                    Kerja Sama
                </a>
                <a href="<?= base_url('peta-kerja-sama') ?>" class="menu-item <?= (uri_string() == 'peta-kerja-sama') ? 'active' : '' ?>">
                    <i class="fas fa-map"></i>
                    Peta Kerja Sama
                </a>
                <a href="<?= base_url('kontak') ?>" class="menu-item <?= (uri_string() == 'kontak') ? 'active' : '' ?>">
                    <i class="fas fa-envelope"></i>
                    Kontak
                </a>
            </div>
        </nav>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="d-flex align-items-center">
                    <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <img src="<?= base_url('images/LOGO-PERPUSNAS.png') ?>" alt="Perpusnas Logo" class="perpusnas-logo-sm mx-2" height="30">
                    <span class="ms-2"><?= $this->renderSection('page-title', true) ?></span>
                </div>
                <div class="header-controls">
                    <div class="search-box me-3">
                        <input type="text" placeholder="Cari..." class="form-control form-control-sm">
                        <button type="button" class="btn btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <a href="<?= base_url('auth/login') ?>" class="login-btn">
                        <i class="fas fa-sign-in-alt me-1"></i>
                        Login
                    </a>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="content-area">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Inline JavaScript -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContainer = document.getElementById('mainContainer');
            
            if (window.innerWidth <= 768) {
                // Mobile behavior - toggle sidebar visibility
                sidebar.classList.toggle('show');
            } else {
                // Desktop behavior - collapse/expand sidebar
                mainContainer.classList.toggle('sidebar-collapsed');
            }
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Auto-collapse sidebar on window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
            }
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
