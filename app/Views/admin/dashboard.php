<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Dashboard Admin<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Dashboard Admin<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <h2 class="page-title">Dashboard Admin</h2>
            <p class="text-muted mb-4">Sistem Manajemen Kerjasama Perpustakaan Nasional</p>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Main Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0" id="totalUsers">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= base_url('admin/users') ?>">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Kerjasama</div>
                            <div class="h5 mb-0" id="totalKerjasama">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-handshake fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= base_url('admin/kerjasama') ?>">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Berita</div>
                            <div class="h5 mb-0" id="totalBerita">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-newspaper fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= base_url('admin/berita') ?>">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Permohonan</div>
                            <div class="h5 mb-0" id="totalPermohonan">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= base_url('admin/permohonan') ?>">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Admin Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="adminUsers">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kerjasama Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="kerjasamaAktif">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Implementasi Kegiatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalImplementasi">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Berita Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="beritaBulanIni">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
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
                    <h6 class="m-0 font-weight-bold text-primary">Progress Kerjasama per Bulan</h6>
                    <div class="dropdown no-arrow">
                        <select class="form-select form-select-sm" id="chartYearFilter">
                            <option value="2024">2024</option>
                            <option value="2025" selected>2025</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="kerjasamaProgressChart"></canvas>
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
                        <canvas id="kerjasamaStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Activities -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6>
                </div>
                <div class="card-body">
                    <div id="recentActivities">
                        <div class="text-center p-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted">Memuat aktivitas...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="<?= base_url('admin/kerjasama') ?>" class="btn btn-primary btn-block">
                                <i class="fas fa-plus me-2"></i>Tambah Kerjasama
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="<?= base_url('admin/berita') ?>" class="btn btn-success btn-block">
                                <i class="fas fa-newspaper me-2"></i>Buat Berita
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-info btn-block">
                                <i class="fas fa-user-plus me-2"></i>Tambah User
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="<?= base_url('admin/implementasi') ?>" class="btn btn-warning btn-block">
                                <i class="fas fa-tasks me-2"></i>Kelola Implementasi
                            </a>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6 class="text-muted mb-3">Ringkasan Hari Ini</h6>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                            <span class="small">Permohonan Baru</span>
                            <span class="badge bg-warning" id="permohonanHariIni">0</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                            <span class="small">Kerjasama Berakhir Minggu Ini</span>
                            <span class="badge bg-danger" id="kerjasamaBerakhir">0</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                            <span class="small">Implementasi Berjalan</span>
                            <span class="badge bg-success" id="implementasiBerjalan">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data Tables -->
    <div class="row">
        <!-- Recent Kerjasama -->
        <div class="col-xl-4 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Kerjasama Terbaru</h6>
                    <a href="<?= base_url('admin/kerjasama') ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div id="recentKerjasama">
                        <div class="text-center p-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                            <p class="small text-muted mt-2">Memuat data...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Berita -->
        <div class="col-xl-4 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Berita Terbaru</h6>
                    <a href="<?= base_url('admin/berita') ?>" class="btn btn-sm btn-success">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div id="recentBerita">
                        <div class="text-center p-3">
                            <div class="spinner-border spinner-border-sm text-success" role="status"></div>
                            <p class="small text-muted mt-2">Memuat data...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Permohonan -->
        <div class="col-xl-4 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Permohonan Terbaru</h6>
                    <a href="<?= base_url('admin/permohonan') ?>" class="btn btn-sm btn-warning">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div id="recentPermohonan">
                        <div class="text-center p-3">
                            <div class="spinner-border spinner-border-sm text-warning" role="status"></div>
                            <p class="small text-muted mt-2">Memuat data...</p>
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
// Dashboard Data Loading
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
    loadCharts();
    loadRecentData();
});

// Load Main Dashboard Statistics
function loadDashboardData() {
    // Simulate API calls - in real implementation, these would be actual AJAX calls
    setTimeout(() => {
        // Update main statistics
        document.getElementById('totalUsers').textContent = '45';
        document.getElementById('totalKerjasama').textContent = '23';
        document.getElementById('totalBerita').textContent = '67';
        document.getElementById('totalPermohonan').textContent = '12';
        
        // Update secondary statistics
        document.getElementById('adminUsers').textContent = '8';
        document.getElementById('kerjasamaAktif').textContent = '15';
        document.getElementById('totalImplementasi').textContent = '34';
        document.getElementById('beritaBulanIni').textContent = '9';
        
        // Update today's summary
        document.getElementById('permohonanHariIni').textContent = '3';
        document.getElementById('kerjasamaBerakhir').textContent = '2';
        document.getElementById('implementasiBerjalan').textContent = '8';
    }, 500);
}

// Load Chart Data
function loadCharts() {
    // Kerjasama Progress Chart
    const progressCtx = document.getElementById('kerjasamaProgressChart').getContext('2d');
    new Chart(progressCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Kerjasama Baru',
                data: [2, 3, 1, 4, 2, 5, 3, 4, 2, 3, 1, 2],
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.4
            }, {
                label: 'Implementasi',
                data: [1, 2, 2, 3, 4, 3, 5, 3, 4, 2, 3, 1],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Kerjasama Status Chart
    const statusCtx = document.getElementById('kerjasamaStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Selesai', 'Pending', 'Dibatalkan'],
            datasets: [{
                data: [15, 8, 3, 2],
                backgroundColor: [
                    'rgb(40, 167, 69)',
                    'rgb(0, 123, 255)',
                    'rgb(255, 193, 7)',
                    'rgb(220, 53, 69)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

// Load Recent Data
function loadRecentData() {
    setTimeout(() => {
        // Load Recent Activities
        const activitiesHtml = `
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-marker bg-success"></div>
                    <div class="timeline-content">
                        <p class="mb-1"><strong>Kerjasama Baru</strong></p>
                        <p class="small text-muted mb-1">Kerjasama dengan Universitas Indonesia telah dimulai</p>
                        <small class="text-muted">2 jam yang lalu</small>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-marker bg-info"></div>
                    <div class="timeline-content">
                        <p class="mb-1"><strong>Berita Dipublikasi</strong></p>
                        <p class="small text-muted mb-1">"Program Digitalisasi Koleksi" telah dipublikasi</p>
                        <small class="text-muted">5 jam yang lalu</small>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-marker bg-warning"></div>
                    <div class="timeline-content">
                        <p class="mb-1"><strong>Permohonan Baru</strong></p>
                        <p class="small text-muted mb-1">Permohonan kerjasama dari Institut Teknologi Bandung</p>
                        <small class="text-muted">1 hari yang lalu</small>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('recentActivities').innerHTML = activitiesHtml;

        // Load Recent Kerjasama
        const kerjasamaHtml = `
            <div class="list-group list-group-flush">
                <div class="list-group-item px-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Universitas Indonesia</h6>
                            <p class="mb-1 small text-muted">Digitalisasi Naskah Kuno</p>
                        </div>
                        <small class="text-success">Aktif</small>
                    </div>
                </div>
                <div class="list-group-item px-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">National Library Singapore</h6>
                            <p class="mb-1 small text-muted">Pertukaran Koleksi</p>
                        </div>
                        <small class="text-success">Aktif</small>
                    </div>
                </div>
                <div class="list-group-item px-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Institut Teknologi Bandung</h6>
                            <p class="mb-1 small text-muted">Penelitian Bersama</p>
                        </div>
                        <small class="text-warning">Pending</small>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('recentKerjasama').innerHTML = kerjasamaHtml;

        // Load Recent Berita
        const beritaHtml = `
            <div class="list-group list-group-flush">
                <div class="list-group-item px-0">
                    <h6 class="mb-1">Program Digitalisasi Massal</h6>
                    <p class="mb-1 small text-muted">Perpustakaan Nasional meluncurkan program...</p>
                    <small class="text-muted">15 Jun 2024</small>
                </div>
                <div class="list-group-item px-0">
                    <h6 class="mb-1">Kerjasama Internasional</h6>
                    <p class="mb-1 small text-muted">Penandatanganan MoU dengan...</p>
                    <small class="text-muted">10 Jun 2024</small>
                </div>
                <div class="list-group-item px-0">
                    <h6 class="mb-1">Workshop Literasi Digital</h6>
                    <p class="mb-1 small text-muted">Pelatihan untuk pustakawan...</p>
                    <small class="text-muted">5 Jun 2024</small>
                </div>
            </div>
        `;
        document.getElementById('recentBerita').innerHTML = beritaHtml;

        // Load Recent Permohonan
        const permohonanHtml = `
            <div class="list-group list-group-flush">
                <div class="list-group-item px-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Institut Teknologi Bandung</h6>
                            <p class="mb-1 small text-muted">Penelitian Teknologi</p>
                        </div>
                        <small class="text-warning">Baru</small>
                    </div>
                </div>
                <div class="list-group-item px-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Universitas Gadjah Mada</h6>
                            <p class="mb-1 small text-muted">Program Literasi</p>
                        </div>
                        <small class="text-info">Review</small>
                    </div>
                </div>
                <div class="list-group-item px-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">BPPT</h6>
                            <p class="mb-1 small text-muted">Teknologi Informasi</p>
                        </div>
                        <small class="text-success">Disetujui</small>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('recentPermohonan').innerHTML = permohonanHtml;
    }, 1000);
}

// Chart Filter Handler
document.getElementById('chartYearFilter').addEventListener('change', function() {
    // Reload chart with new year data
    console.log('Filter tahun:', this.value);
    // In real implementation, reload chart with filtered data
});
</script>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e3e6f0;
}

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
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Dashboard Data Loading dengan error handling
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
    loadCharts();
    loadRecentData();
    
    // Auto refresh every 5 minutes
    setInterval(loadDashboardData, 300000);
});

// Load Dashboard Statistics with API calls
async function loadDashboardData() {
    try {
        // Show loading state
        showLoadingState();
        
        // Simulate API calls - replace with actual endpoints
        const responses = await Promise.all([
            fetch('<?= base_url('api/dashboard/users-stats') ?>'),
            fetch('<?= base_url('api/dashboard/kerjasama-stats') ?>'),
            fetch('<?= base_url('api/dashboard/berita-stats') ?>'),
            fetch('<?= base_url('api/dashboard/permohonan-stats') ?>')
        ]);
        
        // For demo purposes, use mock data
        updateStatistics({
            totalUsers: 45,
            totalKerjasama: 23,
            totalBerita: 67,
            totalPermohonan: 12,
            adminUsers: 8,
            kerjasamaAktif: 15,
            totalImplementasi: 34,
            beritaBulanIni: 9,
            permohonanHariIni: 3,
            kerjasamaBerakhir: 2,
            implementasiBerjalan: 8
        });
        
    } catch (error) {
        console.error('Error loading dashboard data:', error);
        showErrorState();
    }
}

function updateStatistics(data) {
    // Update main cards
    document.getElementById('totalUsers').textContent = data.totalUsers || '-';
    document.getElementById('totalKerjasama').textContent = data.totalKerjasama || '-';
    document.getElementById('totalBerita').textContent = data.totalBerita || '-';
    document.getElementById('totalPermohonan').textContent = data.totalPermohonan || '-';
    
    // Update secondary stats
    document.getElementById('adminUsers').textContent = data.adminUsers || '-';
    document.getElementById('kerjasamaAktif').textContent = data.kerjasamaAktif || '-';
    document.getElementById('totalImplementasi').textContent = data.totalImplementasi || '-';
    document.getElementById('beritaBulanIni').textContent = data.beritaBulanIni || '-';
    
    // Update today's summary
    document.getElementById('permohonanHariIni').textContent = data.permohonanHariIni || '0';
    document.getElementById('kerjasamaBerakhir').textContent = data.kerjasamaBerakhir || '0';
    document.getElementById('implementasiBerjalan').textContent = data.implementasiBerjalan || '0';
    
    // Animate numbers
    animateNumbers();
}

function animateNumbers() {
    const numbers = document.querySelectorAll('.h5, .badge');
    numbers.forEach(num => {
        if (num.textContent !== '-' && !isNaN(num.textContent)) {
            num.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                num.classList.remove('animate__animated', 'animate__pulse');
            }, 1000);
        }
    });
}

function showLoadingState() {
    const elements = ['totalUsers', 'totalKerjasama', 'totalBerita', 'totalPermohonan'];
    elements.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        }
    });
}

function showErrorState() {
    const elements = ['totalUsers', 'totalKerjasama', 'totalBerita', 'totalPermohonan'];
    elements.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = 'Error';
            el.classList.add('text-danger');
        }
    });
}

// Enhanced Charts with more data points
function loadCharts() {
    // Kerjasama Progress Chart dengan data yang lebih detail
    const progressCtx = document.getElementById('kerjasamaProgressChart').getContext('2d');
    const progressChart = new Chart(progressCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Kerjasama Baru',
                data: [2, 3, 1, 4, 2, 5, 3, 4, 2, 3, 1, 2],
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Implementasi',
                data: [1, 2, 2, 3, 4, 3, 5, 3, 4, 2, 3, 1],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Permohonan Masuk',
                data: [3, 1, 4, 2, 3, 2, 4, 5, 3, 4, 2, 3],
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Kerjasama Status Chart dengan animasi
    const statusCtx = document.getElementById('kerjasamaStatusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Selesai', 'Draft', 'Dibatalkan'],
            datasets: [{
                data: [15, 8, 3, 2],
                backgroundColor: [
                    'rgb(40, 167, 69)',
                    'rgb(0, 123, 255)', 
                    'rgb(255, 193, 7)',
                    'rgb(220, 53, 69)'
                ],
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed * 100) / total).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true
            }
        }
    });
    
    // Store chart instances for later updates
    window.dashboardCharts = {
        progress: progressChart,
        status: statusChart
    };
}

// Enhanced Recent Data Loading with better UI
async function loadRecentData() {
    try {
        // Load all recent data in parallel
        await Promise.all([
            loadRecentActivities(),
            loadRecentKerjasama(),
            loadRecentBerita(),
            loadRecentPermohonan()
        ]);
    } catch (error) {
        console.error('Error loading recent data:', error);
    }
}

async function loadRecentActivities() {
    const activitiesHtml = `
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-marker bg-success">
                    <i class="fas fa-handshake text-white" style="font-size: 8px;"></i>
                </div>
                <div class="timeline-content">
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><strong>Kerjasama Baru</strong></p>
                        <small class="text-muted">2 jam lalu</small>
                    </div>
                    <p class="small text-muted mb-0">Kerjasama dengan Universitas Indonesia telah dimulai</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-marker bg-info">
                    <i class="fas fa-newspaper text-white" style="font-size: 8px;"></i>
                </div>
                <div class="timeline-content">
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><strong>Berita Dipublikasi</strong></p>
                        <small class="text-muted">5 jam lalu</small>
                    </div>
                    <p class="small text-muted mb-0">"Program Digitalisasi Koleksi" telah dipublikasi</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-marker bg-warning">
                    <i class="fas fa-file-alt text-white" style="font-size: 8px;"></i>
                </div>
                <div class="timeline-content">
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><strong>Permohonan Baru</strong></p>
                        <small class="text-muted">1 hari lalu</small>
                    </div>
                    <p class="small text-muted mb-0">Permohonan kerjasama dari Institut Teknologi Bandung</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-marker bg-primary">
                    <i class="fas fa-tasks text-white" style="font-size: 8px;"></i>
                </div>
                <div class="timeline-content">
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><strong>Implementasi Selesai</strong></p>
                        <small class="text-muted">2 hari lalu</small>
                    </div>
                    <p class="small text-muted mb-0">Kegiatan "Workshop Literasi" telah selesai dilaksanakan</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            <a href="<?= base_url('admin/activities') ?>" class="btn btn-sm btn-outline-primary">
                Lihat Semua Aktivitas
            </a>
        </div>
    `;
    document.getElementById('recentActivities').innerHTML = activitiesHtml;
}

// Chart Filter Handler dengan animasi
document.getElementById('chartYearFilter').addEventListener('change', function() {
    const year = this.value;
    updateChartData(year);
});

function updateChartData(year) {
    if (window.dashboardCharts && window.dashboardCharts.progress) {
        // Show loading on chart
        const chart = window.dashboardCharts.progress;
        chart.data.datasets.forEach(dataset => {
            dataset.data = new Array(12).fill(0);
        });
        chart.update();
        
        // Simulate API call for new data
        setTimeout(() => {
            const newData = generateRandomData(year);
            chart.data.datasets.forEach((dataset, index) => {
                dataset.data = newData[index];
            });
            chart.update('active');
        }, 500);
    }
}

function generateRandomData(year) {
    // Generate different data based on year
    const baseData = year === '2024' ? 
        [[2, 3, 1, 4, 2, 5, 3, 4, 2, 3, 1, 2], [1, 2, 2, 3, 4, 3, 5, 3, 4, 2, 3, 1], [3, 1, 4, 2, 3, 2, 4, 5, 3, 4, 2, 3]] :
        [[3, 2, 4, 3, 5, 2, 4, 3, 5, 2, 4, 1], [2, 3, 1, 4, 2, 5, 3, 2, 3, 4, 2, 3], [4, 2, 3, 4, 2, 3, 5, 3, 2, 4, 3, 2]];
    
    return baseData;
}

// Refresh Dashboard Data
function refreshDashboard() {
    showAlert('info', 'Memperbarui data dashboard...');
    loadDashboardData();
    loadRecentData();
}

// Add refresh button functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add refresh button to header if not exists
    const pageHeader = document.querySelector('.page-title').parentElement;
    if (!document.getElementById('refreshBtn')) {
        const refreshBtn = document.createElement('button');
        refreshBtn.id = 'refreshBtn';
        refreshBtn.className = 'btn btn-outline-primary btn-sm ms-3';
        refreshBtn.innerHTML = '<i class="fas fa-sync-alt me-1"></i>Refresh';
        refreshBtn.onclick = refreshDashboard;
        pageHeader.appendChild(refreshBtn);
    }
});

// Utility function for alerts
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const container = document.getElementById('alertContainer');
    container.innerHTML = alertHtml;
    
    // Auto dismiss after 3 seconds
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 3000);
}
</script>
<?= $this->endSection() ?>