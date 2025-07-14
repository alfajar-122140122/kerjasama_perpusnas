<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Dashboard Overview<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/admin/dashboard.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Welcome Alert -->
<div class="alert alert-primary border-0 shadow-sm mb-4" role="alert">
    <div class="d-flex align-items-center">
        <div class="flex-shrink-0">
            <i class="fas fa-tachometer-alt fa-2x"></i>
        </div>
        <div class="flex-grow-1 ms-3">
            <h4 class="alert-heading mb-1">Selamat Datang, <?= session()->get('name') ?? session()->get('username') ?>!</h4>
            <p class="mb-0">Dashboard Admin Sistem Kerjasama Perpustakaan Nasional</p>
            <small class="text-muted">
                <i class="fas fa-calendar-alt me-1"></i>
                <?= date('l, d F Y - H:i:s') ?>
            </small>
        </div>
    </div>
</div>

<!-- Success Flash Message -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm h-100 stats-card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-body">
                <div class="text-center">
                    <div class="stats-label text-primary text-uppercase fw-bold small">Total Users</div>
                    <div class="stats-number h3 fw-bold text-dark mb-1"><?= $totalUsers ?></div>
                    <div class="stats-change">
                        <span class="badge bg-success">
                            <i class="fas fa-arrow-up"></i> <?= ($userChange >= 0 ? '+' : '') . $userChange ?>%
                        </span>
                        <small class="text-muted ms-1">dari bulan lalu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm h-100 stats-card" data-aos="fade-up" data-aos-delay="200">
            <div class="card-body">
                <div class="text-center">
                    <div class="stats-label text-success text-uppercase fw-bold small">Total Kerjasama</div>
                    <div class="stats-number h3 fw-bold text-dark mb-1"><?= $totalKerjasama ?></div>
                    <div class="stats-change">
                        <span class="badge bg-success">
                            <i class="fas fa-arrow-up"></i> <?= ($kerjasamaChange >= 0 ? '+' : '') . $kerjasamaChange ?>%
                        </span>
                        <small class="text-muted ms-1">dari bulan lalu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm h-100 stats-card" data-aos="fade-up" data-aos-delay="300">
            <div class="card-body">
                <div class="text-center">
                    <div class="stats-label text-info text-uppercase fw-bold small">Total Berita</div>
                    <div class="stats-number h3 fw-bold text-dark mb-1"><?= $totalBerita ?></div>
                    <div class="stats-change">
                        <span class="badge bg-info">
                            <i class="fas fa-arrow-up"></i> <?= ($beritaChange >= 0 ? '+' : '') . $beritaChange ?>%
                        </span>
                        <small class="text-muted ms-1">dari bulan lalu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-chart-line me-2"></i>Statistik Kerjasama Bulanan
                    </h6>
                </div>
            </div>
            <div class="card-body">
                <canvas id="lineChart" height="100"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0 fw-bold text-dark">
                    Status Kerjasama
                </h6>
            </div>
            <div class="card-body">
                <!-- Status List dengan Indikator Warna -->
                <div class="status-list">
                    <div class="status-item">
                        <div class="status-indicator bg-success"></div>
                        <div class="status-content">
                            <div class="status-number"><?= $statusAktif ?></div>
                            <div class="status-label">Kerjasama Aktif</div>
                        </div>
                    </div>
                    
                    <div class="status-item">
                        <div class="status-indicator bg-primary"></div>
                        <div class="status-content">
                            <div class="status-number"><?= $statusSelesai ?></div>
                            <div class="status-label">Kerjasama Selesai</div>
                        </div>
                    </div>
                    
                    <div class="status-item">
                        <div class="status-indicator bg-warning"></div>
                        <div class="status-content">
                            <div class="status-number"><?= $statusPending ?></div>
                            <div class="status-label">Kerjasama Pending</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data for statistik bulanan
    const statistikBulanan = <?= json_encode($statistikBulanan) ?>;
</script>
<script src="<?= base_url('js/admin/dashboard.js') ?>"></script>
<?= $this->endSection() ?>