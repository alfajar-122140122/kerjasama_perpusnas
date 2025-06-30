<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login - Perpusnas' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('css/auth.css') ?>" rel="stylesheet">
</head>
<body class="auth-body">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Header dengan tombol kembali -->
            <div class="col-12 header-section">
                <a href="<?= base_url('/') ?>" class="btn btn-link text-white">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            
            <!-- Main Content -->
            <div class="col-12 d-flex justify-content-center align-items-center flex-grow-1">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
    
   <!-- Bootstrap JS -->
    <script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
    <!-- Auth JS -->
    <script src="<?= base_url('js/auth.js') ?>"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
</body>
</html>