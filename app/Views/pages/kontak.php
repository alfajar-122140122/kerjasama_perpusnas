<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Kerjasama Perpustakaan Nasional Republik Indonesia</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('images/favicon-perpusnas.png') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('css/landing.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/kontak.css') ?>" rel="stylesheet">
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
                        <a class="nav-link active" href="<?= base_url('kontak') ?>">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content py-5">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kontak</li>
                </ol>
            </nav>

            <h1 class="page-title mb-4">Kontak</h1>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <!-- Google Maps Embed -->
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8342581!3d-6.19751!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0xa3d9d81c42d7a55!2sPerpustakaan%20Nasional%20Republik%20Indonesia!5e0!3m2!1sen!2sid!4v1641234567890!5m2!1sen!2sid" 
                            width="100%" 
                            height="400" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-info">
                        <h2 class="contact-title">Sub Bidang Kerja Sama Perpustakaan</h2>
                        <h3 class="contact-subtitle">Perpustakaan Nasional RI</h3>
                        
                        <div class="contact-details mt-4">
                            <div class="contact-item">
                                <strong>Gedung Layanan, Lantai 5</strong>
                            </div>
                            <div class="contact-item">
                                <strong>Jl. Medan Merdeka Selatan No. 11</strong>
                            </div>
                            <div class="contact-item">
                                <strong>Jakarta Pusat 10110</strong>
                            </div>
                            <div class="contact-item">
                                <strong>Telp. 021-80664603</strong>
                            </div>
                            <div class="contact-item">
                                Email: <a href="mailto:kerjasama@perpusnas.go.id" class="email-link">kerjasama@perpusnas.go.id</a>
                            </div>
                            <div class="contact-item">
                                <a href="mailto:kerjasama@gmail.com" class="email-link">kerjasama@gmail.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
