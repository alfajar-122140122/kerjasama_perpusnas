<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Beranda<?= $this->endSection() ?>

<?= $this->section('description') ?>Portal resmi kerjasama Perpustakaan Nasional Republik Indonesia. Membangun sinergi untuk kemajuan literasi bangsa.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>perpustakaan nasional, kerjasama, literasi, perpustakaan, indonesia, mou, pks<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/home.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

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
<script src="<?= base_url('js/public/home.js') ?>"></script>
<?= $this->endSection() ?>