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
                    <a class="<?= get_nav_class('aktivitas', 'nav-link', 'active', true) ?>" href="<?= base_url('aktivitas') ?>">Aktivitas</a>
                </li>
                
                <!-- Dropdown Kerja Sama -->
                <li class="dropdown">
                    <a class="<?= get_nav_class('kerja-sama', 'nav-link nav-dropdown-toggle', 'active', false) ?>" 
                       href="#" 
                       data-bs-toggle="dropdown" 
                       aria-expanded="false">
                        Kerja Sama 
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?= get_nav_class('kerja-sama/data', 'nav-dropdown-link', 'active', true) ?>" href="<?= base_url('kerja-sama/data') ?>">Data Kerja Sama</a></li>
                        <li><a class="dropdown-item <?= get_nav_class('kerja-sama/implementasi', 'nav-dropdown-link', 'active', true) ?>" href="<?= base_url('kerja-sama/implementasi') ?>">Implementasi Kerja Sama</a></li>
                        <li><a class="dropdown-item <?= get_nav_class('kerja-sama/akan-berakhir', 'nav-dropdown-link', 'active', true) ?>" href="<?= base_url('kerja-sama/akan-berakhir') ?>">Kerja Sama yang Akan Berakhir</a></li>
                        <li><a class="dropdown-item <?= get_nav_class('kerja-sama/progress', 'nav-dropdown-link', 'active', true) ?>" href="<?= base_url('kerja-sama/progress') ?>">Progress</a></li>
                        <li><a class="dropdown-item <?= get_nav_class('kerja-sama/pengajuan', 'nav-dropdown-link', 'active', true) ?>" href="<?= base_url('kerja-sama/pengajuan') ?>">Pengajuan</a></li>
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

<script src="<?= base_url('js/public/components/navigation.js') ?>"></script>