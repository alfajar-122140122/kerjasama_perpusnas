<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title', true) ?> - Admin Perpusnas</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/icon-perpusnas.png') ?>">
    
    <!-- Base URL for JavaScript -->
    <meta name="base-url" content="<?= base_url() ?>">
    
    <!-- Cache control - prevent browser from caching admin pages -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <link href="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.min.css" rel="stylesheet">
    <!-- Custom Admin CSS -->
    <link href="<?= base_url('css/admin.css') ?>" rel="stylesheet">
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?= $this->include('layouts/components/admin_sidebar') ?>

        <!-- Content -->
        <div id="content" class="content">
            <!-- Top Navbar -->
            <?= $this->include('layouts/components/admin_navbar') ?>

            <!-- Page Content -->
            <div class="container-fluid py-4">
                <!-- Page Title -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h1 class="h3 mb-0 text-gray-800"><?= $this->renderSection('page-title', true) ?></h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active"><?= $this->renderSection('title', true) ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                
                <!-- Main Content -->
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.min.js"></script>
    <!-- Custom Admin JS -->
    <script src="<?= base_url('js/admin.js') ?>"></script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>