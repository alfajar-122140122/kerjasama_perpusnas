<!-- Custom Header (Override default) -->
<div class="custom-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="logo-text">
                        <h4>KERJASAMA PERPUSTAKAAN</h4>
                        <p>PERPUSTAKAAN NASIONAL REPUBLIK INDONESIA</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="header-controls justify-content-end">
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Situs ini
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('/') ?>">Portal Kerjasama</a></li>
                            <li><a class="dropdown-item" href="https://perpusnas.go.id" target="_blank">Website Utama</a></li>
                            <li><a class="dropdown-item" href="https://e-resources.perpusnas.go.id" target="_blank">E-Resources</a></li>
                        </ul>
                    </div>
                    <div class="search-box">
                        <input type="text" class="form-control" placeholder="Cari">
                        <button type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <button class="login-btn" onclick="window.location.href='<?= base_url('auth/login') ?>'">
                        Login
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Navigation -->
<nav class="custom-nav">
    <div class="container">
        <ul class="nav nav-pills">
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
</nav>