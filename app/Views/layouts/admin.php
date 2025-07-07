<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title', true) ?> - Admin Perpusnas</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/icon-perpusnas.png') ?>">
    
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
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <img src="<?= base_url('assets/images/logo-perpusnas.png') ?>" alt="Logo" class="sidebar-logo">
                <h4>Admin Panel</h4>
            </div>
            
            <ul class="list-unstyled components">
                <li class="<?= (current_url() == base_url('admin/dashboard')) ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/dashboard') ?>">
                        <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="<?= (strpos(current_url(), 'admin/users') !== false) ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/users') ?>">
                        <i class="fas fa-users"></i> <span>Kelola Users</span>
                    </a>
                </li>
                <li class="<?= (strpos(current_url(), 'admin/kerjasama') !== false) ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/kerjasama') ?>">
                        <i class="fas fa-handshake"></i> <span>Kerjasama</span>
                    </a>
                </li>
                <li class="<?= (strpos(current_url(), 'admin/berita') !== false) ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/berita') ?>">
                        <i class="fas fa-newspaper"></i> <span>Berita</span>
                    </a>
                </li>
                <li class="<?= (strpos(current_url(), 'admin/pengaturan') !== false) ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/pengaturan') ?>">
                        <i class="fas fa-cog"></i> <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-footer">
                <a href="<?= base_url('auth/logout') ?>" class="btn btn-danger btn-sm w-100">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </nav>

        <!-- Content -->
        <div id="content" class="content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-outline-primary">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle fa-lg me-2"></i>
                                <span><?= session()->get('name') ?? session()->get('username') ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= base_url('admin/profile') ?>">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a></li>
                                <li><a class="dropdown-item" href="<?= base_url('admin/settings') ?>">
                                    <i class="fas fa-cog me-2"></i>Settings
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.min.js"></script>
    <!-- Custom Admin JS -->
    <script src="<?= base_url('js/admin.js') ?>"></script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>