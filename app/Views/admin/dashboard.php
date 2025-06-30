<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Dashboard Overview<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <h2 class="page-title">Selamat Datang, <?= session()->get('username') ?>!</h2>
        <p class="text-muted mb-4">Dashboard Admin Sistem Kerjasama Perpustakaan Nasional</p>
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
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 stats-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 stats-label">
                            Total Users
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 stats-number">
                            <?= $total_users ?? 150 ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stats-icon text-primary">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 stats-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1 stats-label">
                            Kerjasama Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 stats-number">
                            <?= $total_kerjasama ?? 25 ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stats-icon text-success">
                            <i class="fas fa-handshake fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 stats-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 stats-label">
                            Total Berita
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 stats-number">
                            <?= $total_berita ?? 48 ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stats-icon text-info">
                            <i class="fas fa-newspaper fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 stats-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 stats-label">
                            Users Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 stats-number">
                            <?= $active_users ?? 142 ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stats-icon text-warning">
                            <i class="fas fa-user-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Quick Actions Card -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: var(--primary-blue); color: white;">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-primary btn-block">
                            <i class="fas fa-users me-2"></i>Kelola Users
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="<?= base_url('admin/kerjasama') ?>" class="btn btn-outline-success btn-block">
                            <i class="fas fa-handshake me-2"></i>Kelola Kerjasama
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="<?= base_url('admin/berita') ?>" class="btn btn-outline-info btn-block">
                            <i class="fas fa-newspaper me-2"></i>Kelola Berita
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="<?= base_url('admin/pengaturan') ?>" class="btn btn-outline-secondary btn-block">
                            <i class="fas fa-cog me-2"></i>Pengaturan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activities Card -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: var(--primary-green); color: white;">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-chart-line me-2"></i>
                    Aktivitas Terbaru
                </h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <h6 class="mb-1">User baru mendaftar</h6>
                            <small class="text-muted">5 menit yang lalu</small>
                        </div>
                        <span class="badge bg-success rounded-pill">Baru</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <h6 class="mb-1">Kerjasama baru diajukan</h6>
                            <small class="text-muted">1 jam yang lalu</small>
                        </div>
                        <span class="badge bg-warning rounded-pill">Pending</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <h6 class="mb-1">Berita baru dipublikasi</h6>
                            <small class="text-muted">2 jam yang lalu</small>
                        </div>
                        <span class="badge bg-info rounded-pill">Published</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                        <div>
                            <h6 class="mb-1">Backup database berhasil</h6>
                            <small class="text-muted">3 jam yang lalu</small>
                        </div>
                        <span class="badge bg-success rounded-pill">Success</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Kerjasama Bulanan</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart" height="320"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Status Kerjasama</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Aktif
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Selesai
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-info"></i> Pending
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Style untuk dashboard -->
<style>
.border-left-primary {
    border-left: .25rem solid #4e73df!important;
}
.border-left-success {
    border-left: .25rem solid #1cc88a!important;
}
.border-left-info {
    border-left: .25rem solid #36b9cc!important;
}
.border-left-warning {
    border-left: .25rem solid #f6c23e!important;
}

.stats-card {
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15)!important;
}

.btn-block {
    display: block;
    width: 100%;
}

.text-xs {
    font-size: .7rem;
}

.text-gray-800 {
    color: #5a5c69!important;
}

.font-weight-bold {
    font-weight: 700!important;
}

#myAreaChart, #myPieChart {
    width: 100%;
    height: 200px;
    background: linear-gradient(45deg, #f8f9fc, #e3e6f0);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#myAreaChart::before {
    content: "📊 Chart Area";
    font-size: 16px;
    color: #858796;
}

#myPieChart::before {
    content: "🥧 Pie Chart";
    font-size: 16px;
    color: #858796;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Dashboard animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate stats cards
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Simulate chart data loading
    setTimeout(() => {
        console.log('Charts would be loaded here with real data');
    }, 1000);
});
</script>
<?= $this->endSection() ?>