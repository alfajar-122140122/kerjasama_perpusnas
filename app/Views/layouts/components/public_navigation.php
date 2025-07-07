<?php
// Load navigation helper
helper('navigation');
?>

<!-- Header dengan style baru -->
<header class="new-header">
    <div class="container">
        <div class="row align-items-center">
            <!-- Logo Section -->
            <div class="col-md-3">
                <div class="d-flex align-items-center">
                    <div class="logo-container me-3">
                        <img src="<?= base_url('assets/images/logo-perpusnas.png') ?>" alt="Logo Perpustakaan Nasional" class="logo-img">
                    </div>
                    <div class="logo-text">
                        <h4 class="logo-title">KERJASAMA PERPUSTAKAAN</h4>
                        <p class="logo-subtitle">PERPUSTAKAAN NASIONAL<br>REPUBLIK INDONESIA</p>
                    </div>
                </div>
            </div>
            
            <!-- Header Controls -->
            <div class="col-md-9">
                <div class="d-flex justify-content-end align-items-center gap-3">
                    <!-- Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Situs ini
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('/') ?>">Portal Kerjasama</a></li>
                            <li><a class="dropdown-item" href="https://perpusnas.go.id" target="_blank">Website Utama</a></li>
                            <li><a class="dropdown-item" href="https://e-resources.perpusnas.go.id" target="_blank">E-Resources</a></li>
                            <li><a class="dropdown-item" href="https://koleksi.perpusnas.go.id" target="_blank">Koleksi Digital</a></li>
                        </ul>
                    </div>
                    
                    <!-- Search -->
                    <div class="search-container">
                        <div class="input-group">
                            <input type="text" class="form-control search-input" placeholder="Cari" id="headerSearchInput">
                            <button class="btn btn-outline-light search-btn" type="button" onclick="performHeaderSearch()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Login -->
                    <a href="<?= base_url('auth/login') ?>" class="btn btn-light login-btn">Login</a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Navigation dengan Home icon -->
<nav class="new-navigation">
    <div class="container">
        <div class="nav-wrapper">
            <!-- Home Icon dengan background hijau -->
            <div class="home-icon-container">
                <a href="<?= base_url('/') ?>" class="home-icon-link <?= (uri_string() == '' || uri_string() == '/') ? 'active' : '' ?>">
                    <i class="fas fa-home"></i>
                </a>
            </div>
            
            <!-- Navigation Links -->
            <ul class="nav-list">
                <li class="nav-item">
                    <a class="nav-link <?= (uri_string() == 'tentang') ? 'active' : '' ?>" href="<?= base_url('tentang') ?>">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (strpos(uri_string(), 'aktivitas') !== false) ? 'active' : '' ?>" href="<?= base_url('aktivitas') ?>">Aktivitas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (strpos(uri_string(), 'kerja-sama') !== false) ? 'active' : '' ?>" href="<?= base_url('kerja-sama') ?>">Kerja Sama</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (strpos(uri_string(), 'peta-kerja-sama') !== false) ? 'active' : '' ?>" href="<?= base_url('peta-kerja-sama') ?>">Peta Kerja Sama</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (uri_string() == 'kontak' || strpos(uri_string(), 'kontak') !== false) ? 'active' : '' ?>" href="<?= base_url('kontak') ?>">Kontak</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
// Header search functionality
function performHeaderSearch() {
    const searchInput = document.getElementById('headerSearchInput');
    const query = searchInput.value.trim();
    
    if (query) {
        window.location.href = `${window.location.origin}/pencarian?q=${encodeURIComponent(query)}`;
    }
}

// Enter key search
document.getElementById('headerSearchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        performHeaderSearch();
    }
});

// Enhanced navigation interaction
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const homeIcon = document.querySelector('.home-icon-link');
    
    // Add smooth hover effects
    navLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateY(-1px)';
                this.style.transition = 'transform 0.2s ease';
            }
        });
        
        link.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateY(0)';
            }
        });
    });
    
    // Home icon hover effect
    if (homeIcon) {
        homeIcon.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        homeIcon.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    }
    
    // Debug current page detection
    console.log('Current URI:', '<?= uri_string() ?>');
    console.log('Active nav detected for:', 
        document.querySelector('.nav-link.active')?.textContent.trim() || 'Home');
});
</script>