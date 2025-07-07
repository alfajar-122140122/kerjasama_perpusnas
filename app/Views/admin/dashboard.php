<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Dashboard Overview<?= $this->endSection() ?>

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
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 stats-card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-body">
                <div class="text-center">
                    <div class="stats-label text-primary text-uppercase fw-bold small">Total Users</div>
                    <div class="stats-number h3 fw-bold text-dark mb-1"><?= $total_users ?? 150 ?></div>
                    <div class="stats-change">
                        <span class="badge bg-success">
                            <i class="fas fa-arrow-up"></i> +12%
                        </span>
                        <small class="text-muted ms-1">dari bulan lalu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 stats-card" data-aos="fade-up" data-aos-delay="200">
            <div class="card-body">
                <div class="text-center">
                    <div class="stats-label text-success text-uppercase fw-bold small">Kerjasama Aktif</div>
                    <div class="stats-number h3 fw-bold text-dark mb-1"><?= $total_kerjasama ?? 25 ?></div>
                    <div class="stats-change">
                        <span class="badge bg-success">
                            <i class="fas fa-arrow-up"></i> +8%
                        </span>
                        <small class="text-muted ms-1">dari bulan lalu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 stats-card" data-aos="fade-up" data-aos-delay="300">
            <div class="card-body">
                <div class="text-center">
                    <div class="stats-label text-info text-uppercase fw-bold small">Total Berita</div>
                    <div class="stats-number h3 fw-bold text-dark mb-1"><?= $total_berita ?? 48 ?></div>
                    <div class="stats-change">
                        <span class="badge bg-info">
                            <i class="fas fa-arrow-up"></i> +15%
                        </span>
                        <small class="text-muted ms-1">dari bulan lalu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 stats-card" data-aos="fade-up" data-aos-delay="400">
            <div class="card-body">
                <div class="text-center">
                    <div class="stats-label text-warning text-uppercase fw-bold small">Users Aktif</div>
                    <div class="stats-number h3 fw-bold text-dark mb-1"><?= $active_users ?? 142 ?></div>
                    <div class="stats-change">
                        <span class="badge bg-warning">
                            <i class="fas fa-arrow-up"></i> +5%
                        </span>
                        <small class="text-muted ms-1">dari bulan lalu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row g-4 mb-4">
    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-primary text-white border-0">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-primary btn-lg">
                        Kelola Users
                    </a>
                    <a href="<?= base_url('admin/kerjasama') ?>" class="btn btn-outline-success btn-lg">
                        Kelola Kerjasama
                    </a>
                    <a href="<?= base_url('admin/berita') ?>" class="btn btn-outline-info btn-lg">
                        Kelola Berita
                    </a>
                    <a href="<?= base_url('admin/pengaturan') ?>" class="btn btn-outline-secondary btn-lg">
                        Pengaturan
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-success text-white border-0">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-clock me-2"></i>Aktivitas Terbaru
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success rounded-circle p-2">
                                    <i class="fas fa-user-plus text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">User baru mendaftar</h6>
                                <p class="mb-1 text-muted">Ahmad Fauzi telah mendaftar sebagai anggota baru</p>
                                <small class="text-muted">5 menit yang lalu</small>
                            </div>
                            <span class="badge bg-success">Baru</span>
                        </div>
                    </div>
                    
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning rounded-circle p-2">
                                    <i class="fas fa-handshake text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Kerjasama baru diajukan</h6>
                                <p class="mb-1 text-muted">Proposal kerjasama dari Universitas Indonesia</p>
                                <small class="text-muted">1 jam yang lalu</small>
                            </div>
                            <span class="badge bg-warning">Pending</span>
                        </div>
                    </div>
                    
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-info rounded-circle p-2">
                                    <i class="fas fa-newspaper text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Berita baru dipublikasi</h6>
                                <p class="mb-1 text-muted">Artikel tentang digitalisasi perpustakaan</p>
                                <small class="text-muted">2 jam yang lalu</small>
                            </div>
                            <span class="badge bg-info">Published</span>
                        </div>
                    </div>
                    
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary rounded-circle p-2">
                                    <i class="fas fa-database text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Backup database berhasil</h6>
                                <p class="mb-1 text-muted">Backup otomatis sistem berhasil dilakukan</p>
                                <small class="text-muted">3 jam yang lalu</small>
                            </div>
                            <span class="badge bg-primary">Success</span>
                        </div>
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
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            2024
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">2024</a></li>
                            <li><a class="dropdown-item" href="#">2023</a></li>
                        </ul>
                    </div>
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
                    <i class="fas fa-chart-pie me-2"></i>Status Kerjasama
                </h6>
            </div>
            <div class="card-body">
                <canvas id="pieChart" height="150"></canvas>
                <div class="mt-4">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="legend-item">
                                <div class="legend-color bg-primary rounded-circle mx-auto mb-2"></div>
                                <span class="legend-text small">Aktif</span>
                                <div class="legend-value fw-bold">15</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="legend-item">
                                <div class="legend-color bg-success rounded-circle mx-auto mb-2"></div>
                                <span class="legend-text small">Selesai</span>
                                <div class="legend-value fw-bold">8</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="legend-item">
                                <div class="legend-color bg-warning rounded-circle mx-auto mb-2"></div>
                                <span class="legend-text small">Pending</span>
                                <div class="legend-value fw-bold">2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Line Chart
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Kerjasama Baru',
                data: [12, 19, 3, 5, 2, 3],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Selesai', 'Pending'],
            datasets: [{
                data: [15, 8, 2],
                backgroundColor: [
                    'rgb(13, 110, 253)',
                    'rgb(25, 135, 84)',
                    'rgb(255, 193, 7)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Animate numbers
    function animateNumbers() {
        const numbers = document.querySelectorAll('.stats-number');
        numbers.forEach(number => {
            const target = parseInt(number.textContent);
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                number.textContent = Math.floor(current);
            }, 30);
        });
    }

    // Start animations
    setTimeout(animateNumbers, 500);
});
</script>
<?= $this->endSection() ?>