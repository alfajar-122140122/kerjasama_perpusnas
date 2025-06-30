<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title', true) ?> - Dashboard Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom Admin CSS -->
    <link href="<?= base_url('css/admin.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="user-profile">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span><?= session()->get('username') ?? 'Admin' ?></span>
                </div>
            </div>
            
            <div class="sidebar-menu">
                <a href="<?= base_url('admin/dashboard') ?>" class="menu-item <?= (uri_string() == 'admin/dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
                <a href="<?= base_url('admin/users') ?>" class="menu-item <?= (strpos(uri_string(), 'admin/users') !== false) ? 'active' : '' ?>">
                    <i class="fas fa-users"></i>
                    Manajemen User
                </a>
                <a href="<?= base_url('admin/kerjasama') ?>" class="menu-item">
                    <i class="fas fa-handshake"></i>
                    Kerjasama
                </a>
                <a href="<?= base_url('admin/berita') ?>" class="menu-item">
                    <i class="fas fa-newspaper"></i>
                    Berita
                </a>
                <a href="<?= base_url('admin/pengaturan') ?>" class="menu-item">
                    <i class="fas fa-cog"></i>
                    Pengaturan
                </a>
            </div>
        </nav>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="d-flex align-items-center">
                    <button class="mobile-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="ms-2"><?= $this->renderSection('page-title', true) ?></span>
                </div>
                <a href="<?= base_url('auth/logout') ?>" class="logout-btn">
                    <i class="fas fa-sign-out-alt me-1"></i>
                    Log Out
                </a>
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
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Dashboard Animation
        document.addEventListener('DOMContentLoaded', function() {
            const statsCards = document.querySelectorAll('.stats-card');
            
            statsCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.5s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100 + 200);
            });
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>