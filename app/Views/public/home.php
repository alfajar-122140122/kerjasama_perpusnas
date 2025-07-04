<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Beranda<?= $this->endSection() ?>

<?= $this->section('description') ?>Portal resmi kerjasama Perpustakaan Nasional Republik Indonesia. Membangun sinergi untuk kemajuan literasi bangsa.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>perpustakaan nasional, kerjasama, literasi, perpustakaan, indonesia, mou, pks<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<style>
/* Minimal custom styles using existing CSS variables */
.home-header {
    background: var(--primary-green);
    padding: 1rem 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.home-nav {
    background: var(--primary-blue);
    padding: 0;
}

.home-nav .nav-link {
    color: white !important;
    padding: 15px 20px;
    font-size: 14px;
    font-weight: 500;
    transition: background 0.3s;
}

.home-nav .nav-link:hover,
.home-nav .nav-link.active {
    background: rgba(255,255,255,0.1);
}

/* Reuse existing chart and activity styles with Bootstrap grid */
.chart-container {
    height: 250px;
    background: var(--bg-light, #f8f9fa);
    border-radius: 8px;
    position: relative;
}

/* Optimize service grid with CSS Grid + Bootstrap */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.service-card {
    background: var(--primary-green);
    border-radius: 10px;
    padding: 1.5rem 1rem;
    text-align: center;
    color: white;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 120px;
    transition: all 0.3s ease;
}

.service-card:hover {
    background: #45a817;
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
}

.service-icon {
    font-size: 2rem;
    margin-bottom: 10px;
    opacity: 0.9;
}

.service-title {
    font-size: 12px;
    font-weight: 500;
    line-height: 1.3;
    margin: 0;
}

/* Use existing activity-card styles from landing.css */
.activity-card {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    margin-bottom: 1rem;
}

.activity-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.activity-image {
    height: 180px;
    background: var(--bg-light, #f0f0f0);
    position: relative;
    overflow: hidden;
}

.activity-meta {
    color: var(--text-light, #666);
    font-size: 12px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.activity-title {
    color: var(--text-dark, #333);
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
    color: var(--text-light, #666);
    font-size: 13px;
    line-height: 1.5;
    margin-bottom: 0;
    height: 60px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

/* Responsive using Bootstrap breakpoints */
@media (max-width: 1200px) {
    .services-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .services-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .home-nav .nav-link {
        padding: 12px 15px;
        font-size: 13px;
    }
    
    .activity-image {
        height: 150px;
    }
}

@media (max-width: 576px) {
    .services-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Include Navigation Component - Same as Home -->
<?= $this->include('layouts/components/public_navigation') ?>

<!-- Main Content using Bootstrap containers and utilities -->
<main class="py-4" style="background: #F5F5F5; min-height: calc(100vh - 200px);">
    <div class="container">
        <!-- Statistics Section using Bootstrap cards -->
        <section class="bg-white rounded-3 p-4 shadow-sm mb-4">
            <h2 class="fs-5 fw-semibold text-dark mb-4">Statistik Kerja Sama</h2>
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="chart-container d-flex align-items-center justify-content-center">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="chart-container d-flex align-items-center justify-content-center">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="chart-container d-flex align-items-center justify-content-center">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <!-- Activities Section using Bootstrap grid -->
        <section class="bg-white rounded-3 p-4 shadow-sm mb-4">
            <h2 class="fs-5 fw-semibold text-dark mb-4">Aktivitas Terbaru</h2>
            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <article class="activity-card">
                        <div class="activity-image">
                            <img src="<?= base_url('assets/images/placeholder-activity.jpg') ?>" alt="Webinar" class="img-fluid w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="p-3">
                            <div class="activity-meta">
                                <i class="fas fa-calendar"></i>
                                <time datetime="2025-06-17">17 Juni 2025</time>
                            </div>
                            <h3 class="activity-title">Webinar Kualitas, Akreditasi, Evaluasi, Digitalisasi</h3>
                            <p class="activity-excerpt">
                                JAKARTA - Perpustakaan Nasional Republik Indonesia (Perpusnas) menyelenggarakan kegiatan webinar tentang evaluasi untuk Webinar Masa Depan Buku dan Literasi Digital di Indonesia...
                            </p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6">
                    <article class="activity-card">
                        <div class="activity-image">
                            <img src="<?= base_url('assets/images/placeholder-activity.jpg') ?>" alt="Implementasi" class="img-fluid w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="p-3">
                            <div class="activity-meta">
                                <i class="fas fa-calendar"></i>
                                <time datetime="2025-02-09">09 Februari 2025</time>
                            </div>
                            <h3 class="activity-title">Implementasi Operasional Perpustakaan 2025, Hari Masa Depan</h3>
                            <p class="activity-excerpt">
                                JAKARTA - Sebagai organisasi perpustakaan terbesar dengan standar internasional yang sistematis, Perpusnas mengorganisasikan kegiatan sistem operasional perpustakaan...
                            </p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6">
                    <article class="activity-card">
                        <div class="activity-image">
                            <img src="<?= base_url('assets/images/placeholder-activity.jpg') ?>" alt="Inklusi Sosial" class="img-fluid w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="p-3">
                            <div class="activity-meta">
                                <i class="fas fa-calendar"></i>
                                <time datetime="2024-11-21">21 November 2024</time>
                            </div>
                            <h3 class="activity-title">Perpustakaan Nasional Inklusi Sosial di Alang Lawas</h3>
                            <p class="activity-excerpt">
                                JAKARTA - Perpustakaan dapat (PI) Kantor Perpustakaan Nasional berserta mahasiswa di Provinsi 31 provinsi yang mengimprimis program perpustakaan harus mengintegrasikan hingga pusat yang memastikan perpustakaan...
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Services Grid using CSS Grid + Bootstrap responsive -->
        <section>
            <div class="services-grid">
                <a href="<?= base_url('permohonan-kerjasama') ?>" class="service-card text-decoration-none">
                    <i class="fas fa-file-alt service-icon"></i>
                    <span class="service-title">Ajukan Kerjasama</span>
                </a>
                <a href="<?= base_url('data-kerja-sama') ?>" class="service-card text-decoration-none">
                    <i class="fas fa-search service-icon"></i>
                    <span class="service-title">Data Kerja Sama</span>
                </a>
                <a href="<?= base_url('implementasi-kerja-sama') ?>" class="service-card text-decoration-none">
                    <i class="fas fa-chart-line service-icon"></i>
                    <span class="service-title">Implementasi Kerja Sama</span>
                </a>
                <a href="<?= base_url('kerjasama-dalam-luar-negeri') ?>" class="service-card text-decoration-none">
                    <i class="fas fa-users service-icon"></i>
                    <span class="service-title">Kerjasama Dalam dan Luar Negeri</span>
                </a>
                <a href="<?= base_url('program-kerja-sama') ?>" class="service-card text-decoration-none">
                    <i class="fas fa-tasks service-icon"></i>
                    <span class="service-title">Program Kerja Sama</span>
                </a>
                <a href="<?= base_url('peta-kerja-sama') ?>" class="service-card text-decoration-none">
                    <i class="fas fa-map service-icon"></i>
                    <span class="service-title">Peta Kerja Sama</span>
                </a>
            </div>
        </section>
    </div>
</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Optimized vanilla JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Optimized chart options
    const defaultOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } }
    };

    // Bar Chart
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                data: [12, 19, 15, 25, 22, 30],
                backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#E91E63', '#9C27B0', '#FF5722'],
                borderWidth: 1
            }]
        },
        options: {
            ...defaultOptions,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.1)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Line Chart
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: ['2019', '2020', '2021', '2022', '2023', '2024'],
            datasets: [{
                data: [65, 78, 85, 95, 110, 125],
                borderColor: '#2196F3',
                backgroundColor: 'rgba(33, 150, 243, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            ...defaultOptions,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.1)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Pie Chart
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Universitas', 'Pemerintah', 'Swasta', 'Internasional', 'Lainnya'],
            datasets: [{
                data: [40, 25, 15, 12, 8],
                backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#E91E63', '#9C27B0']
            }]
        },
        options: {
            ...defaultOptions,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { fontSize: 12, padding: 10 }
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>