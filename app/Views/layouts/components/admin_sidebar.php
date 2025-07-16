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
        
        <?php if (session()->get('role') === 'admin'): ?>
        <li class="<?= (strpos(current_url(), 'admin/users') !== false) ? 'active' : '' ?>">
            <a href="#" class="dropdown-toggle" data-target="usersSubmenu">
                <i class="fas fa-users"></i> <span>Users</span>
            </a>
            <ul class="submenu" id="usersSubmenu">
                <li><a href="<?= base_url('admin/users/hak-akses') ?>"><i class="fas fa-key"></i> Hak Akses</a></li>
                <li><a href="<?= base_url('admin/users/kelola-user') ?>"><i class="fas fa-users-cog"></i> Kelola User</a></li>
            </ul>
        </li>
        <?php endif; ?>
        
        <li class="<?= (strpos(current_url(), 'admin/kerjasama') !== false) ? 'active' : '' ?>">
            <a href="#" class="dropdown-toggle" data-target="kerjasamaSubmenu">
                <i class="fas fa-handshake"></i> <span>Kerjasama</span>
            </a>
            <ul class="submenu" id="kerjasamaSubmenu">
                <li><a href="<?= base_url('admin/kerjasama/data') ?>"><i class="fas fa-folder"></i> Data</a></li>
                <li><a href="<?= base_url('admin/kerjasama/implementasi') ?>"><i class="fas fa-cogs"></i> Implementasi</a></li>
                <li><a href="<?= base_url('admin/kerjasama/akan-berakhir') ?>"><i class="fas fa-clock"></i> Akan Berakhir</a></li>
                <li><a href="<?= base_url('admin/kerjasama/progress') ?>"><i class="fas fa-chart-line"></i> Progress</a></li>
                <li><a href="<?= base_url('admin/kerjasama/pengajuan') ?>"><i class="fas fa-edit"></i> Pengajuan</a></li>
            </ul>
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