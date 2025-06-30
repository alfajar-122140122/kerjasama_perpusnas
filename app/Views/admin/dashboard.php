<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Dashboard Overview<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <h2 class="page-title">Selamat Datang, <?= session()->get('username') ?>!</h2>
        <p class="text-muted">Dashboard Admin Sistem Kerjasama Perpustakaan Nasional</p>
    </div>
</div>

<!-- Success Alert -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm stats-card">
            <div class="card-body text-center">
                <div class="stats-icon text-primary mb-2">
                    <i class="fas fa-users fa-3x"></i>
                </div>
                <h3 class="stats-number"><?= $total_users ?></h3>
                <p class="stats-label text-muted">Total Users</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm stats-card">
            <div class="card-body text-center">
                <div class="stats-icon text-success mb-2">
                    <i class="fas fa-handshake fa-3x"></i>
                </div>
                <h3 class="stats-number"><?= $total_kerjasama ?></h3>
                <p class="stats-label text-muted">Kerjasama Aktif</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm stats-card">
            <div class="card-body text-center">
                <div class="stats-icon text-info mb-2">
                    <i class="fas fa-newspaper fa-3x"></i>
                </div>
                <h3 class="stats-number"><?= $total_berita ?></h3>
                <p class="stats-label text-muted">Total Berita</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm stats-card">
            <div class="card-body text-center">
                <div class="stats-icon text-warning mb-2">
                    <i class="fas fa-user-check fa-3x"></i>
                </div>
                <h3 class="stats-number"><?= $active_users ?></h3>
                <p class="stats-label text-muted">Users Aktif</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-users me-2"></i>Kelola Users
                    </a>
                    <a href="<?= base_url('admin/kerjasama') ?>" class="btn btn-outline-success">
                        <i class="fas fa-handshake me-2"></i>Kelola Kerjasama
                    </a>
                    <a href="<?= base_url('admin/berita') ?>" class="btn btn-outline-info">
                        <i class="fas fa-newspaper me-2"></i>Kelola Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Aktivitas Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 px-0">
                        <small class="text-muted">5 menit yang lalu</small>
                        <p class="mb-0">User baru mendaftar</p>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <small class="text-muted">1 jam yang lalu</small>
                        <p class="mb-0">Kerjasama baru diajukan</p>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <small class="text-muted">2 jam yang lalu</small>
                        <p class