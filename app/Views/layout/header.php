<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Sistem Kerjasama Perpustakaan Nasional</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/css/style.css" rel="stylesheet">
    
    <!-- Additional CSS -->
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/images/logo.png" alt="Logo Perpusnas" height="40">
                Kerjasama Perpusnas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= isset($active) && $active == 'home' ? 'active' : '' ?>" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= isset($active) && $active == 'about' ? 'active' : '' ?>" href="/about">Tentang Kami</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= isset($active) && in_array($active, ['cooperation', 'data_cooperation', 'implementation', 'expiring', 'progress', 'submission']) ? 'active' : '' ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kerjasama
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item <?= isset($active) && $active == 'data_cooperation' ? 'active' : '' ?>" href="/cooperation/data-cooperation">Data Kerjasama</a></li>
                            <li><a class="dropdown-item <?= isset($active) && $active == 'implementation' ? 'active' : '' ?>" href="/cooperation/implementation">Implementasi Kerjasama</a></li>
                            <li><a class="dropdown-item <?= isset($active) && $active == 'expiring' ? 'active' : '' ?>" href="/cooperation/expiring">Kerjasama Yang Akan Berakhir</a></li>
                            <li><a class="dropdown-item <?= isset($active) && $active == 'progress' ? 'active' : '' ?>" href="/cooperation/progress">Progress Kerjasama</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item <?= isset($active) && $active == 'submission' ? 'active' : '' ?>" href="/cooperation/submission">Permohonan Kerjasama</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= isset($active) && $active == 'map' ? 'active' : '' ?>" href="/map">Peta Kerjasama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= isset($active) && $active == 'contact' ? 'active' : '' ?>" href="/contact">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-sm btn-outline-light ms-2" href="/auth/login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Perpustakaan Nasional RI</h5>
                    <p>Jl. Salemba Raya No. 28A<br>Jakarta Pusat 10430</p>
                    <p>Telepon: +62 21 3154864<br>Email: kerjasama@perpusnas.go.id</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Link Terkait</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://www.perpusnas.go.id" class="text-white">Perpustakaan Nasional</a></li>
                        <li><a href="https://inlis.perpusnas.go.id" class="text-white">INLIS Perpusnas</a></li>
                        <li><a href="https://e-resources.perpusnas.go.id" class="text-white">E-Resources Perpusnas</a></li>
                        <li><a href="https://indonesiana.perpusnas.go.id" class="text-white">Indonesiana</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Ikuti Kami</h5>
                    <div class="social-icons">
                        <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-2"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white me-2"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; <?= date('Y') ?> Perpustakaan Nasional Republik Indonesia. Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="/js/script.js"></script>
    
    <!-- Additional Scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>
