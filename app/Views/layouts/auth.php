<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title', true) ?> - Sistem Kerjasama Perpusnas</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/icon-perpusnas.png') ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom Auth CSS -->
    <link href="<?= base_url('css/auth.css') ?>" rel="stylesheet">
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-header text-center mb-4">
            <img src="<?= base_url('assets/images/logo-perpusnas.png') ?>" alt="Perpusnas Logo" class="auth-logo">
            <h3 class="auth-title">PERPUSTAKAAN NASIONAL REPUBLIK INDONESIA</h3>
            <p class="auth-subtitle">Portal Kerjasama Perpusnas</p>
        </div>
        
        <div class="auth-container">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= base_url('js/auth.js') ?>"></script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>