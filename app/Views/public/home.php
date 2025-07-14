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
                <?php foreach ($recent_activities as $activity): ?>
                <div class="col-lg-4 col-md-6">
                    <article class="activity-card">
                        <a href="<?= base_url('aktivitas/detail/' . $activity['id_berita']) ?>" class="activity-image d-block" style="text-decoration:none;">
                            <?php
                                $image = !empty($activity['gambar']) ? $activity['gambar'] : 'placeholder-activity.jpg';
                                $imagePath = FCPATH . 'assets/images/' . $image;
                                $imageExists = file_exists($imagePath) && is_file($imagePath);
                            ?>
                            <img src="<?= base_url('assets/images/' . ($imageExists ? $image : 'placeholder-activity.jpg')) ?>"
                                 alt="<?= esc($activity['judul'] ?? $activity['title'] ?? 'Aktivitas') ?>"
                                 class="img-fluid w-100 h-100"
                                 style="object-fit: cover;">
                        </a>
                        <div class="p-3">
                            <div class="activity-meta">
                                <i class="fas fa-calendar"></i>
                                <time datetime="<?= esc($activity['tanggal_publikasi'] ?? $activity['created_at']) ?>">
                                    <?= date('d F Y', strtotime($activity['tanggal_publikasi'] ?? $activity['created_at'])) ?>
                                </time>
                            </div>
                            <h3 class="activity-title mb-2">
                                <a href="<?= base_url('aktivitas/detail/' . $activity['id_berita']) ?>" style="text-decoration:none; color:inherit;">
                                    <?= esc($activity['judul'] ?? $activity['title']) ?>
                                </a>
                            </h3>
                            <p class="activity-excerpt">
                                <?= isset($activity['isi_berita']) ? substr(strip_tags($activity['isi_berita']), 0, 120) . '...' : '' ?>
                            </p>
                        </div>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Services Grid using CSS Grid + Bootstrap responsive -->
        <section>
            <div class="services-grid">
                <a href="<?= base_url('kerja-sama/pengajuan') ?>" class="service-card text-decoration-none">
                    <i class="fas fa-file-alt service-icon"></i>
                    <span class="service-title">Ajukan Kerjasama</span>
                </a>
                <a href="<?= base_url('kerja-sama/data') ?>" class="service-card text-decoration-none">
                    <i class="fas fa-search service-icon"></i>
                    <span class="service-title">Data Kerja Sama</span>
                </a>
                <a href="<?= base_url('kerja-sama/implementasi') ?>" class="service-card text-decoration-none">
                    <i class="fas fa-chart-line service-icon"></i>
                    <span class="service-title">Implementasi Kerja Sama</span>
                </a>
                <a href="<?= base_url('kerja-sama/akan-berakhir') ?>" class="service-card text-decoration-none">
                    <i class="fas fa-users service-icon"></i>
                    <span class="service-title">Kerja Sama yang Akan Berakhir</span>
                </a>
                <a href="<?= base_url('kerja-sama/progress') ?>" class="service-card text-decoration-none">
                    <i class="fas fa-tasks service-icon"></i>
                    <span class="service-title">Progress Kerja Sama</span>
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
    const statistikBulanan = <?= json_encode($statistikBulanan ?? ($stats['statistikBulanan'] ?? [])) ?>;
    const statistikTahunan = <?= json_encode($statistikTahunan ?? ($stats['statistikTahunan'] ?? [])) ?>;
    const distribusiMitra = <?= json_encode($distribusiMitra ?? ($stats['distribusiMitra'] ?? [])) ?>;
</script>
<script src="<?= base_url('js/public/home.js') ?>"></script>
<?= $this->endSection() ?>