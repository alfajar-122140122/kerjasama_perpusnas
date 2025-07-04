<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - Kerjasama Perpustakaan Nasional Republik Indonesia</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('images/favicon-perpusnas.png') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('css/landing.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/tentang.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Header Top -->
    <div class="header-top">
        <div class="container">
            <div class="logo-section">
                <img src="<?= base_url('images/LOGO-PERPUSNAS.png') ?>" alt="Perpusnas Logo" class="logo-img me-3" height="80">
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
                        <a class="nav-link" href="<?= base_url('/') ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('tentang') ?>">Tentang</a>
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

    <!-- Main Content -->
    <div class="main-content py-5">
        <div class="container">
            <h1 class="page-title mb-4">Tentang</h1>
            
            <div class="row mt-4">
                <div class="col-md-5 mb-4">
                    <!-- Placeholder for kerjasama image -->
                    <div class="kerjasama-image rounded">
                        <img src="<?= base_url('images/kerjasama.jpg') ?>" alt="Kerjasama Perpustakaan Nasional" class="img-fluid rounded shadow" onerror="this.src='<?= base_url('images/LOGO-PERPUSNAS.png') ?>';this.style.padding='30px';this.style.background='#f8f9fa';">
                    </div>
                </div>
                <div class="col-md-7">
                    <h2 class="section-title">Tugas</h2>
                    <p class="section-text">
                        Penyiapan bahan dan melakukan kerja sama perpustakaan dalam dan luar negeri sesuai dengan petunjuk dan 
                        pedoman yang berlaku.
                    </p>
                    
                    <h3 class="mt-4">Fungsi:</h3>
                    <ul class="function-list">
                        <li>
                            a) Pelaksanaan kerja sama perpustakaan dalam dan luar negeri
                        </li>
                        <li>
                            b) Penerima dan mengelola permohonan inisiasi kerja sama
                        </li>
                        <li>
                            c) Pelaksanaan penanda tanganan naskah Kesepahaman Bersama atau Memorandum of Understanding (MoU)
                        </li>
                        <li>
                            d) Mengelola dan mengevaluasi implementasi kerja sama.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
