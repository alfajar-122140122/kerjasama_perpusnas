<!-- Top Header Bar -->
<div class="top-header bg-primary text-white py-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex flex-wrap">
                    <div class="me-4">
                        <i class="fas fa-phone me-2"></i>
                        <span>+62 21 3928 8221</span>
                    </div>
                    <div class="me-4">
                        <i class="fas fa-envelope me-2"></i>
                        <span>kerjasama@perpusnas.go.id</span>
                    </div>
                    <div class="me-4">
                        <i class="fas fa-clock me-2"></i>
                        <span>Senin - Jumat, 08:00 - 16:00 WIB</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <div class="social-links">
                    <a href="https://facebook.com/perpusnas" class="text-white me-3" target="_blank" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/perpusnas" class="text-white me-3" target="_blank" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://instagram.com/perpusnas" class="text-white me-3" target="_blank" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://youtube.com/perpusnas" class="text-white me-3" target="_blank" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://linkedin.com/company/perpusnas" class="text-white" target="_blank" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="main-header bg-white shadow-sm sticky-top">
    <div class="container">
        <div class="row align-items-center py-3">
            <!-- Logo -->
            <div class="col-lg-3 col-md-4">
                <div class="logo d-flex align-items-center">
                    <img src="<?= base_url('assets/images/public/logo-perpusnas.png') ?>" alt="Logo Perpustakaan Nasional" class="logo-img me-3">
                    <div class="logo-text">
                        <h4 class="mb-0 text-primary fw-bold">PERPUSNAS RI</h4>
                        <small class="text-muted">Kerjasama Perpustakaan</small>
                    </div>
                </div>
            </div>

            <!-- Search Box & Quick Actions -->
            <div class="col-lg-6 col-md-4 d-none d-md-block">
                <div class="header-search">
                    <form class="search-form" action="<?= base_url('pencarian') ?>" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Cari informasi kerjasama..." aria-label="Search">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Links & Language -->
            <div class="col-lg-3 col-md-4">
                <div class="header-actions d-flex justify-content-end align-items-center">
                    <!-- Quick Access Buttons -->
                    <div class="quick-access me-3">
                        <button class="btn btn-outline-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#searchModal" title="Pencarian">
                            <i class="fas fa-search d-md-none"></i>
                            <span class="d-none d-lg-inline">Cari</span>
                        </button>
                        <a href="<?= base_url('permohonan-kerjasama') ?>" class="btn btn-primary btn-sm" title="Ajukan Kerjasama">
                            <i class="fas fa-plus me-1"></i>
                            <span class="d-none d-lg-inline">Ajukan Kerjasama</span>
                        </a>
                    </div>

                    <!-- Language Selector -->
                    <div class="language-selector dropdown">
                        <button class="btn btn-link dropdown-toggle text-decoration-none p-0" type="button" data-bs-toggle="dropdown">
                            <img src="<?= base_url('assets/images/flags/id.png') ?>" alt="Indonesia" class="flag-icon me-1">
                            <span class="d-none d-lg-inline">ID</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item active" href="<?= current_url() ?>">
                                    <img src="<?= base_url('assets/images/flags/id.png') ?>" alt="Indonesia" class="flag-icon me-2">
                                    Bahasa Indonesia
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= current_url() ?>?lang=en">
                                    <img src="<?= base_url('assets/images/flags/us.png') ?>" alt="English" class="flag-icon me-2">
                                    English
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Breadcrumb (if not homepage) -->
<?php if (uri_string() !== ''): ?>
<div class="breadcrumb-section bg-light py-2">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url('/') ?>">
                        <i class="fas fa-home me-1"></i>Beranda
                    </a>
                </li>
                <?php
                $segments = explode('/', uri_string());
                $url = '';
                foreach ($segments as $segment):
                    $url .= '/' . $segment;
                    $isLast = ($segment === end($segments));
                ?>
                    <li class="breadcrumb-item <?= $isLast ? 'active' : '' ?>" <?= $isLast ? 'aria-current="page"' : '' ?>>
                        <?php if ($isLast): ?>
                            <?= ucfirst(str_replace('-', ' ', $segment)) ?>
                        <?php else: ?>
                            <a href="<?= base_url($url) ?>"><?= ucfirst(str_replace('-', ' ', $segment)) ?></a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>
    </div>
</div>
<?php endif; ?>