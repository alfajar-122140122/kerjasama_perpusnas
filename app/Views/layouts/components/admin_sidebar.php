<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin/dashboard') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Perpusnas <sup>Admin</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= (uri_string() == 'admin/dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen Data
    </div>

    <!-- Nav Item - Users -->
    <li class="nav-item <?= (strpos(uri_string(), 'admin/users') !== false) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/users') ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Manajemen Users</span>
        </a>
    </li>

    <!-- Nav Item - Kerjasama -->
    <li class="nav-item <?= (strpos(uri_string(), 'admin/kerjasama') !== false) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseKerjasama">
            <i class="fas fa-fw fa-handshake"></i>
            <span>Kerjasama</span>
        </a>
        <div id="collapseKerjasama" class="collapse <?= (strpos(uri_string(), 'admin/kerjasama') !== false) ? 'show' : '' ?>" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Kelola Kerjasama:</h6>
                <a class="collapse-item <?= (uri_string() == 'admin/kerjasama') ? 'active' : '' ?>" href="<?= base_url('admin/kerjasama') ?>">Data Kerjasama</a>
                <a class="collapse-item <?= (uri_string() == 'admin/kerjasama/dashboard') ? 'active' : '' ?>" href="<?= base_url('admin/kerjasama/dashboard') ?>">Dashboard Kerjasama</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Permohonan -->
    <li class="nav-item <?= (strpos(uri_string(), 'admin/permohonan') !== false) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/permohonan') ?>">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Permohonan</span>
            <?php if (isset($pending_submissions) && $pending_submissions > 0): ?>
                <span class="badge badge-danger badge-counter"><?= $pending_submissions ?></span>
            <?php endif; ?>
        </a>
    </li>

    <!-- Nav Item - Berita -->
    <li class="nav-item <?= (strpos(uri_string(), 'admin/berita') !== false) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/berita') ?>">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Berita & Artikel</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Sistem
    </div>

    <!-- Nav Item - Settings -->
    <li class="nav-item <?= (strpos(uri_string(), 'admin/pengaturan') !== false) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSettings">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaturan</span>
        </a>
        <div id="collapseSettings" class="collapse <?= (strpos(uri_string(), 'admin/pengaturan') !== false) ? 'show' : '' ?>" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pengaturan Sistem:</h6>
                <a class="collapse-item <?= (uri_string() == 'admin/pengaturan/profile') ? 'active' : '' ?>" href="<?= base_url('admin/pengaturan/profile') ?>">Profil</a>
                <a class="collapse-item <?= (uri_string() == 'admin/pengaturan/sistem') ? 'active' : '' ?>" href="<?= base_url('admin/pengaturan/sistem') ?>">Sistem</a>
                <a class="collapse-item <?= (uri_string() == 'admin/pengaturan/backup') ? 'active' : '' ?>" href="<?= base_url('admin/pengaturan/backup') ?>">Backup</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Logs -->
    <li class="nav-item <?= (strpos(uri_string(), 'admin/logs') !== false) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/logs') ?>">
            <i class="fas fa-fw fa-list"></i>
            <span>System Logs</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Public Site -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('/') ?>" target="_blank">
            <i class="fas fa-fw fa-external-link-alt"></i>
            <span>Lihat Website</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->