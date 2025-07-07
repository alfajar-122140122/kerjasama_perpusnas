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

<!-- Navigation dengan Home icon dan dropdown Kerja Sama -->
<nav class="new-navigation">
    <div class="container">
        <div class="nav-wrapper">
            <!-- Home Icon dengan background hijau -->
            <div class="home-icon-container">
                <a href="<?= base_url('/') ?>" class="<?= get_nav_class('', 'home-icon-link', 'active', true) ?>">
                    <i class="fas fa-home"></i>
                </a>
            </div>
            
            <!-- Navigation Links dengan dropdown Kerja Sama -->
            <ul class="nav-list">
                <li class="nav-item">
                    <a class="<?= get_nav_class('tentang', 'nav-link', 'active', true) ?>" href="<?= base_url('tentang') ?>">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="<?= get_nav_class('aktivitas', 'nav-link', 'active', false) ?>" href="<?= base_url('aktivitas') ?>">Aktivitas</a>
                </li>
                
                <!-- Dropdown Kerja Sama -->
                <li class="nav-item nav-dropdown">
                    <a class="<?= get_nav_class('kerja-sama', 'nav-link nav-dropdown-toggle', 'active', false) ?>" 
                       href="#" 
                       data-bs-toggle="dropdown" 
                       aria-expanded="false">
                        Kerja Sama 
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown-menu">
                        <li><a class="nav-dropdown-item <?= get_nav_class('kerja-sama/data', 'nav-dropdown-link', 'active', true) ?>" href="<?= base_url('kerja-sama/data') ?>">Data Kerja Sama</a></li>
                        <li><a class="nav-dropdown-item <?= get_nav_class('kerja-sama/implementasi', 'nav-dropdown-link', 'active', true) ?>" href="<?= base_url('kerja-sama/implementasi') ?>">Implementasi Kerja Sama</a></li>
                        <li><a class="nav-dropdown-item <?= get_nav_class('kerja-sama/akan-berakhir', 'nav-dropdown-link', 'active', true) ?>" href="<?= base_url('kerja-sama/akan-berakhir') ?>">Kerja Sama yang Akan Berakhir</a></li>
                        <li><a class="nav-dropdown-item <?= get_nav_class('kerja-sama/progress', 'nav-dropdown-link', 'active', true) ?>" href="<?= base_url('kerja-sama/progress') ?>">Progress</a></li>
                        <li><a class="nav-dropdown-item <?= get_nav_class('kerja-sama/pengajuan', 'nav-dropdown-link', 'active', true) ?>" href="<?= base_url('kerja-sama/pengajuan') ?>">Pengajuan</a></li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="<?= get_nav_class('peta-kerja-sama', 'nav-link', 'active', false) ?>" href="<?= base_url('peta-kerja-sama') ?>">Peta Kerja Sama</a>
                </li>
                <li class="nav-item">
                    <a class="<?= get_nav_class('kontak', 'nav-link', 'active', false) ?>" href="<?= base_url('kontak') ?>">Kontak</a>
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

// Enhanced navigation with dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const homeIcon = document.querySelector('.home-icon-link');
    const dropdownToggles = document.querySelectorAll('.nav-dropdown-toggle');
    
    // Initialize dropdown functionality
    initializeDropdowns();
    
    // Add smooth hover effects
    navLinks.forEach(link => {
        if (!link.classList.contains('nav-dropdown-toggle')) {
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
        }
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
    
    function initializeDropdowns() {
        dropdownToggles.forEach(toggle => {
            const dropdown = toggle.closest('.nav-dropdown');
            const menu = dropdown.querySelector('.nav-dropdown-menu');
            let hoverTimeout;
            
            // Prevent default link behavior
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleDropdown(dropdown);
            });
            
            // Show dropdown on hover (desktop)
            dropdown.addEventListener('mouseenter', function() {
                clearTimeout(hoverTimeout);
                if (window.innerWidth > 768) {
                    showDropdown(dropdown);
                }
            });
            
            // Hide dropdown on mouse leave with delay
            dropdown.addEventListener('mouseleave', function() {
                if (window.innerWidth > 768) {
                    hoverTimeout = setTimeout(() => {
                        hideDropdown(dropdown);
                    }, 200);
                }
            });
            
            // Handle dropdown item clicks
            const dropdownItems = dropdown.querySelectorAll('.nav-dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function() {
                    hideDropdown(dropdown);
                });
            });
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.nav-dropdown')) {
                closeAllDropdowns();
            }
        });
    }
    
    function toggleDropdown(dropdown) {
        const isOpen = dropdown.classList.contains('show');
        closeAllDropdowns();
        
        if (!isOpen) {
            showDropdown(dropdown);
        }
    }
    
    function showDropdown(dropdown) {
        const menu = dropdown.querySelector('.nav-dropdown-menu');
        const arrow = dropdown.querySelector('.dropdown-arrow');
        
        dropdown.classList.add('show');
        menu.style.display = 'block';
        
        setTimeout(() => {
            menu.style.opacity = '1';
            menu.style.transform = 'translateY(0)';
            if (arrow) {
                arrow.style.transform = 'rotate(180deg)';
            }
        }, 10);
    }
    
    function hideDropdown(dropdown) {
        const menu = dropdown.querySelector('.nav-dropdown-menu');
        const arrow = dropdown.querySelector('.dropdown-arrow');
        
        menu.style.opacity = '0';
        menu.style.transform = 'translateY(-10px)';
        if (arrow) {
            arrow.style.transform = 'rotate(0deg)';
        }
        
        setTimeout(() => {
            dropdown.classList.remove('show');
            menu.style.display = 'none';
        }, 300);
    }
    
    function closeAllDropdowns() {
        document.querySelectorAll('.nav-dropdown.show').forEach(dropdown => {
            hideDropdown(dropdown);
        });
    }
    
    // Debug current page detection
    console.log('Current URI:', '<?= uri_string() ?>');
    console.log('Active nav detected for:', 
        document.querySelector('.nav-link.active')?.textContent.trim() || 'Home');
});
</script>