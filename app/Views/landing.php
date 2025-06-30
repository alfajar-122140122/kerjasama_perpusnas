<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kerjasama Perpustakaan Nasional</title>
    <!-- Menggunakan base_url() untuk mengambil dari public -->
    <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">Kerjasama Perpusnas</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="<?= base_url('auth/login') ?>">Login</a>
            </div>
        </div>
    </nav>

    <div class="hero-section bg-light py-5">
        <div class="container text-center">
            <h1 class="display-4">Sistem Kerjasama</h1>
            <h2 class="display-5">Perpustakaan Nasional RI</h2>
            <p class="lead">Platform untuk mengelola kerjasama dengan berbagai lembaga</p>
            <a href="<?= base_url('kerjasama') ?>" class="btn btn-primary btn-lg">Lihat Kerjasama</a>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Berita Terbaru</h5>
                        <p class="card-text">Informasi terkini seputar kerjasama perpustakaan</p>
                        <a href="<?= base_url('berita') ?>" class="btn btn-outline-primary">Lihat Berita</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Permohonan Kerjasama</h5>
                        <p class="card-text">Ajukan permohonan kerjasama baru</p>
                        <a href="<?= base_url('permohonan') ?>" class="btn btn-outline-primary">Ajukan Permohonan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Implementasi</h5>
                        <p class="card-text">Pantau implementasi kerjasama yang berjalan</p>
                        <a href="<?= base_url('implementasi') ?>" class="btn btn-outline-primary">Lihat Implementasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; <?= date('Y') ?> Perpustakaan Nasional RI. All rights reserved.</p>
        </div>
    </footer>

    <!-- Menggunakan base_url() untuk JS -->
    <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>