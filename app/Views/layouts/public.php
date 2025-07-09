<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Kerjasama Perpustakaan Nasional</title>
    
    <!-- Meta Tags for SEO -->
    <meta name="description" content="<?= $this->renderSection('description') ?: 'Portal Kerjasama Perpustakaan Nasional Republik Indonesia' ?>">
    <meta name="keywords" content="<?= $this->renderSection('keywords') ?: 'perpustakaan, kerjasama, perpustakaan nasional, indonesia' ?>">
    <meta name="author" content="Perpustakaan Nasional Republik Indonesia">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.ico') ?>">
    
    <!-- Bootstrap CSS (dari existing structure) -->
    <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Main CSS Files -->
    <link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/public-enhanced.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/public/components/navigation.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/public/components/footer.css') ?>" rel="stylesheet">

    <!-- Page Level CSS -->
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Navigation -->
    <?= $this->include('layouts/components/public_navigation') ?>

    <!-- Main Content -->
    <main id="main-content">
        <?= $this->renderSection('content') ?>
    </main>
    
    <!-- Footer -->
    <?= $this->include('layouts/components/public_footer') ?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Component JS Files -->
    <script src="<?= base_url('assets/js/public/components/navigation.js') ?>"></script>
    <script src="<?= base_url('assets/js/public/components/footer.js') ?>"></script>
    
    <!-- Custom Public JS -->
    <script src="<?= base_url('assets/js/public.js') ?>"></script>
    
    <!-- Page Level Scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>