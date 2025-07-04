<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Beranda<?= $this->endSection() ?>

<?= $this->section('description') ?>Portal resmi kerjasama Perpustakaan Nasional Republik Indonesia. Membangun sinergi untuk kemajuan literasi bangsa.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>perpustakaan nasional, kerjasama, literasi, perpustakaan, indonesia, mou, pks<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
/* Custom Styles to match Hi-Fi Design */
:root {
    --green-primary: #4CAF50;
    --green-dark: #388E3C;
    --blue-primary: #2196F3;
    --blue-dark: #1976D2;
    --text-dark: #333333;
    --text-gray: #666666;
    --bg-light: #F5F5F5;
}

/* Override public layout header for this specific design */
.custom-header {
    background: var(--green-primary);
    padding: 15px 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.custom-header .logo-section {
    display: flex;
    align-items: center;
}

.custom-header .logo-icon {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.custom-header .logo-icon i {
    color: var(--green-primary);
    font-size: 1.5rem;
}

.custom-header .logo-text {
    color: white;
}

.custom-header .logo-text h4 {
    margin: 0;
    font-size: 14px;
    font-weight: bold;
    line-height: 1.2;
}

.custom-header .logo-text p {
    margin: 0;
    font-size: 12px;
    opacity: 0.9;
}

.custom-header .header-controls {
    display: flex;
    align-items: center;
    gap: 15px;
}

.custom-header .dropdown-toggle {
    background: white;
    border: none;
    border-radius: 20px;
    padding: 8px 15px;
    font-size: 14px;
    color: var(--text-dark);
}

.custom-header .search-box {
    position: relative;
}

.custom-header .search-box input {
    border-radius: 20px;
    border: none;
    padding: 8px 40px 8px 15px;
    width: 250px;
    font-size: 14px;
}

.custom-header .search-box button {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-gray);
}

.custom-header .login-btn {
    background: white;
    color: var(--green-primary);
    border: none;
    border-radius: 20px;
    padding: 8px 20px;
    font-weight: 500;
    font-size: 14px;
}

/* Custom Navigation */
.custom-nav {
    background: var(--blue-primary);
    padding: 0;
}

.custom-nav .nav-link {
    color: white !important;
    padding: 15px 20px;
    border-radius: 0;
    font-size: 14px;
    font-weight: 500;
    transition: background 0.3s;
}

.custom-nav .nav-link:hover,
.custom-nav .nav-link.active {
    background: var(--blue-dark);
}

/* Main Content */
.main-content {
    background: var(--bg-light);
    min-height: calc(100vh - 200px);
    padding: 30px 0;
}

/* Statistics Section */
.stats-section {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.stats-title {
    color: var(--text-dark);
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 25px;
}

.chart-container {
    height: 250px;
    background: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: 15px;
}

.chart-placeholder {
    color: var(--text-gray);
    font-size: 14px;
}

/* Activities Section */
.activities-section {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.activities-title {
    color: var(--text-dark);
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 25px;
}

.activity-card {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
    height: 100%;
}

.activity-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.activity-image {
    height: 180px;
    background: #f0f0f0;
    position: relative;
    overflow: hidden;
}

.activity-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.activity-content {
    padding: 20px;
}

.activity-meta {
    color: var(--text-gray);
    font-size: 12px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.activity-title {
    color: var(--text-dark);
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;
    margin-bottom: 10px;
    height: 40px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.activity-excerpt {
    color: var(--text-gray);
    font-size: 13px;
    line-height: 1.5;
    margin-bottom: 0;
    height: 60px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

/* Service Buttons */
.services-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 20px;
    margin-top: 20px;
}

.service-btn {
    background: var(--green-primary);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 25px 15px;
    text-decoration: none;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 120px;
    text-align: center;
}

.service-btn:hover {
    background: var(--green-dark);
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
}

.service-btn i {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

.service-btn span {
    font-size: 12px;
    font-weight: 500;
    line-height: 1.3;
}

/* Responsive */
@media (max-width: 1200px) {
    .services-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .custom-header .search-box input {
        width: 200px;
    }
    
    .services-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .custom-nav .nav-link {
        padding: 12px 15px;
        font-size: 13px;
    }
}

@media (max-width: 576px) {
    .services-grid {
        grid-template-columns: 1fr;
    }
    
    .custom-header .header-controls {
        flex-direction: column;
        gap: 10px;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <!-- Statistics Section -->
        <div class="stats-section">
            <h2 class="stats-title">Statistik Kerja Sama</h2>
            <div class="row">
                <div class="col-lg-4 col-md-4 mb-3">
                    <div class="chart-container">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 mb-3">
                    <div class="chart-container">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 mb-3">
                    <div class="chart-container">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activities Section -->
        <div class="activities-section">
            <h2 class="activities-title">Aktivitas Terbaru</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="activity-card">
                        <div class="activity-image">
                            <img src="<?= base_url('assets/images/public/activities/activity1.jpg') ?>" alt="Berita" loading="lazy">
                        </div>
                        <div class="activity-content">
                            <div class="activity-meta">
                                <i class="fas fa-calendar"></i>
                                <span>17 Juni 2025</span>
                            </div>
                            <h5 class="activity-title">Webinar Kualitas, Akreditasi, Evaluasi, Digitalisasi</h5>
                            <p class="activity-excerpt">
                                JAKARTA - Perpustakaan Nasional Republik Indonesia (Perpusnas) menyelenggarakan kegiatan webinar tentang evaluasi untuk Webinar Masa Depan Buku dan Literasi Digital di Indonesia...
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="activity-card">
                        <div class="activity-image">
                            <img src="<?= base_url('assets/images/public/activities/activity2.jpg') ?>" alt="Berita" loading="lazy">
                        </div>
                        <div class="activity-content">
                            <div class="activity-meta">
                                <i class="fas fa-calendar"></i>
                                <span>09 Februari 2025</span>
                            </div>
                            <h5 class="activity-title">Implementasi Operasional Perpustakaan 2025, Hari Masa Depan</h5>
                            <p class="activity-excerpt">
                                JAKARTA - Sebagai organisasi perpustakaan terbesar dengan standar internasional yang sistematis, Perpusnas mengorganisasikan kegiatan sistem operasional perpustakaan...
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="activity-card">
                        <div class="activity-image">
                            <img src="<?= base_url('assets/images/public/activities/activity3.jpg') ?>" alt="Berita" loading="lazy">
                        </div>
                        <div class="activity-content">
                            <div class="activity-meta">
                                <i class="fas fa-calendar"></i>
                                <span>21 November 2024</span>
                            </div>
                            <h5 class="activity-title">Perpustakaan Nasional Inklusi Sosial di Alang Lawas</h5>
                            <p class="activity-excerpt">
                                JAKARTA - Perpustakaan dapat (PI) Kantor Perpustakaan Nasional berserta mahasiswa di Provinsi 31 provinsi yang mengimprimis program perpustakaan harus mengintegrasikan hingga pusat yang memastikan perpustakaan...
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Grid -->
        <div class="services-grid">
            <a href="<?= base_url('permohonan-kerjasama') ?>" class="service-btn">
                <i class="fas fa-file-alt"></i>
                <span>Ajukan Kerjasama</span>
            </a>
            <a href="<?= base_url('data-kerja-sama') ?>" class="service-btn">
                <i class="fas fa-search"></i>
                <span>Data Kerja Sama</span>
            </a>
            <a href="<?= base_url('implementasi-kerja-sama') ?>" class="service-btn">
                <i class="fas fa-chart-line"></i>
                <span>Implementasi Kerja Sama</span>
            </a>
            <a href="<?= base_url('kerjasama-dalam-luar-negeri') ?>" class="service-btn">
                <i class="fas fa-users"></i>
                <span>Kerjasama Dalam dan Luar Negeri</span>
            </a>
            <a href="<?= base_url('program-kerja-sama') ?>" class="service-btn">
                <i class="fas fa-tasks"></i>
                <span>Program Kerja Sama</span>
            </a>
            <a href="<?= base_url('peta-kerja-sama') ?>" class="service-btn">
                <i class="fas fa-map"></i>
                <span>Peta Kerja Sama</span>
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Initialize Charts
    initializeCharts();
    
    function initializeCharts() {
        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Kerjasama Baru',
                    data: [12, 19, 15, 25, 22, 30],
                    backgroundColor: [
                        'rgba(76, 175, 80, 0.8)',
                        'rgba(33, 150, 243, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(233, 30, 99, 0.8)',
                        'rgba(156, 39, 176, 0.8)',
                        'rgba(255, 87, 34, 0.8)'
                    ],
                    borderColor: [
                        'rgba(76, 175, 80, 1)',
                        'rgba(33, 150, 243, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(233, 30, 99, 1)',
                        'rgba(156, 39, 176, 1)',
                        'rgba(255, 87, 34, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
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

        // Line Chart
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['2019', '2020', '2021', '2022', '2023', '2024'],
                datasets: [{
                    label: 'Total Kerjasama',
                    data: [65, 78, 85, 95, 110, 125],
                    borderColor: 'rgba(33, 150, 243, 1)',
                    backgroundColor: 'rgba(33, 150, 243, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
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

        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Universitas', 'Pemerintah', 'Swasta', 'Internasional', 'Lainnya'],
                datasets: [{
                    data: [40, 25, 15, 12, 8],
                    backgroundColor: [
                        'rgba(76, 175, 80, 0.8)',
                        'rgba(33, 150, 243, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(233, 30, 99, 0.8)',
                        'rgba(156, 39, 176, 0.8)'
                    ],
                    borderColor: [
                        'rgba(76, 175, 80, 1)',
                        'rgba(33, 150, 243, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(233, 30, 99, 1)',
                        'rgba(156, 39, 176, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            fontSize: 12,
                            padding: 10
                        }
                    }
                }
            }
        });
    }

    // Smooth scroll for service buttons
    $('.service-btn').on('click', function(e) {
        const href = $(this).attr('href');
        if (href.startsWith('#')) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $(href).offset().top - 100
            }, 500);
        }
    });
});
</script>
<?= $this->endSection() ?>