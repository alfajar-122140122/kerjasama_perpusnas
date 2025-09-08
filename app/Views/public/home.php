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
        
        <!-- Hero Slider Section - Berita Terbaru -->
        <section class="hero-slider-section mb-5">
            <div class="hero-slider-container">
                <div class="hero-slider" id="heroSlider">
                    
                    <!-- Slide 1 -->
                    <div class="hero-slide active">
                        <div class="hero-slide-image">
                            <img src="<?= base_url('assets/berita/berita1.jpeg') ?>" alt="Berita Terbaru 1" class="img-fluid">
                            <div class="hero-slide-overlay"></div>
                        </div>
                        <div class="hero-slide-content">
                            <div class="hero-slide-category">
                                <span class="badge bg-primary">Kerjasama Internasional</span>
                            </div>
                            <h2 class="hero-slide-title">Perpustakaan Nasional Tandatangani MOU dengan Universitas Terkemuka di Asia</h2>
                            <p class="hero-slide-description">Kerjasama strategis ini akan membuka peluang pertukaran koleksi digital dan program literasi lintas negara untuk mendukung perkembangan pendidikan di Indonesia.</p>
                            <div class="hero-slide-meta">
                                <span class="hero-slide-date">
                                    <i class="fas fa-calendar"></i>
                                    15 Desember 2024
                                </span>
                                <a href="#" class="btn btn-light btn-sm hero-slide-btn">
                                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="hero-slide">
                        <div class="hero-slide-image">
                            <img src="<?= base_url('assets/berita/berita2.jpeg') ?>" alt="Berita Terbaru 2" class="img-fluid">
                            <div class="hero-slide-overlay"></div>
                        </div>
                        <div class="hero-slide-content">
                            <div class="hero-slide-category">
                                <span class="badge bg-success">Digitalisasi</span>
                            </div>
                            <h2 class="hero-slide-title">Peluncuran Platform Digital Baru untuk Akses Koleksi Perpustakaan</h2>
                            <p class="hero-slide-description">Inovasi terbaru dalam layanan perpustakaan digital yang memungkinkan akses koleksi dari seluruh nusantara dengan teknologi AI dan machine learning.</p>
                            <div class="hero-slide-meta">
                                <span class="hero-slide-date">
                                    <i class="fas fa-calendar"></i>
                                    12 Desember 2024
                                </span>
                                <a href="#" class="btn btn-light btn-sm hero-slide-btn">
                                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="hero-slide">
                        <div class="hero-slide-image">
                            <img src="<?= base_url('assets/berita/berita3.jpg') ?>" alt="Berita Terbaru 3" class="img-fluid">
                            <div class="hero-slide-overlay"></div>
                        </div>
                        <div class="hero-slide-content">
                            <div class="hero-slide-category">
                                <span class="badge bg-warning">Program Literasi</span>
                            </div>
                            <h2 class="hero-slide-title">Gerakan Literasi Nasional Mencapai 1000 Perpustakaan Desa</h2>
                            <p class="hero-slide-description">Program kerjasama dengan pemerintah daerah berhasil mendirikan dan mengembangkan perpustakaan desa di seluruh Indonesia sebagai upaya peningkatan literasi masyarakat.</p>
                            <div class="hero-slide-meta">
                                <span class="hero-slide-date">
                                    <i class="fas fa-calendar"></i>
                                    10 Desember 2024
                                </span>
                                <a href="#" class="btn btn-light btn-sm hero-slide-btn">
                                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Slider Navigation -->
                <div class="hero-slider-nav">
                    <button class="hero-slider-btn hero-slider-prev" onclick="changeSlide(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="hero-slider-btn hero-slider-next" onclick="changeSlide(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Slider Indicators -->
                <div class="hero-slider-indicators">
                    <button class="hero-indicator active" onclick="currentSlide(1)"></button>
                    <button class="hero-indicator" onclick="currentSlide(2)"></button>
                    <button class="hero-indicator" onclick="currentSlide(3)"></button>
                </div>
            </div>
        </section>

        <!-- Statistics Section using Bootstrap cards -->
        <section class="bg-white rounded-3 p-4 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fs-5 fw-semibold text-dark mb-0">Statistik Kerja Sama</h2>
            </div>
            
            <div class="row g-4">
                <!-- Panel 1: Pie Chart Jenis Identitas Mitra -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="chart-title mb-0">Jenis Identitas Mitra</h3>
                                <!-- Mini filter untuk pie chart -->
                                <div class="pie-chart-filter">
                                    <select class="form-select form-select-sm" id="mitraFilter" onchange="updatePieChart()" style="width: 100px; font-size: 0.8rem;">
                                        <option value="">Semua</option>
                                        <option value="PTS">PTS</option>
                                        <option value="PTN">PTN</option>
                                        <option value="Swasta">Swasta</option>
                                        <option value="Pemerintah">Pemerintah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="chart-container" style="height: 180px; position: relative;">
                                <canvas id="pieChart"></canvas>
                            </div>
                            <!-- Legend Table untuk Jenis Identitas Mitra -->
                            <div class="chart-legend mt-auto">
                                <div class="legend-header">
                                    <span>Jenis Identitas Mitra</span>
                                    <span>Jumlah</span>
                                </div>
                                <div class="legend-item">
                                    <span><span class="legend-color legend-color-pts">●</span> PTS</span>
                                    <span id="pieChart_ptsCount"><?= $statistik['jenis_mitra']['PTS'] ?? 0 ?></span>
                                </div>
                                <div class="legend-item">
                                    <span><span class="legend-color legend-color-kl">●</span> K/L</span>
                                    <span id="pieChart_klCount"><?= $statistik['jenis_mitra']['K/L'] ?? 0 ?></span>
                                </div>
                                <div class="legend-item">
                                    <span><span class="legend-color legend-color-ptn">●</span> PTN</span>
                                    <span id="pieChart_ptnCount"><?= $statistik['jenis_mitra']['PTN'] ?? 0 ?></span>
                                </div>
                                <div class="legend-item">
                                    <span><span class="legend-color legend-color-swasta">●</span> Swasta</span>
                                    <span id="pieChart_swastaCount"><?= $statistik['jenis_mitra']['Swasta'] ?? 0 ?></span>
                                </div>
                                <div class="legend-item">
                                    <span><span class="legend-color legend-color-luar-negeri">●</span> Luar Negeri</span>
                                    <span id="pieChart_luarNegeriCount"><?= $statistik['jenis_mitra']['Luar Negeri'] ?? 0 ?></span>
                                </div>
                                <div class="legend-item legend-total">
                                    <span>Total</span>
                                    <span id="pieChart_totalLembaga"><?= $statistik['total_mitra'] ?? 0 ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Panel 2: Bar Chart Pertahun -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="chart-title mb-0">Pertahun</h3>
                                <!-- Dummy filter untuk menyeimbangkan tinggi header -->
                                <div class="yearly-chart-filter">
                                    <select class="form-select form-select-sm invisible" style="width: 100px; height: 31px; font-size: 0.8rem;">
                                        <option value="">Dummy</option>
                                    </select>
                                </div>
                            </div>
                            <div class="chart-container" style="height: 180px; position: relative;">
                                <canvas id="yearlyChart"></canvas>
                            </div>
                            <!-- Legend Table untuk Data Tahunan -->
                            <div class="chart-legend mt-auto">
                                <div class="legend-header">
                                    <span>Tahun</span>
                                    <span>Jumlah</span>
                                </div>
                                <?php if (!empty($statistik['per_tahun'])): ?>
                                    <?php foreach ($statistik['per_tahun'] as $tahun): ?>
                                    <div class="legend-item">
                                        <span><?= $tahun['tahun'] ?></span>
                                        <span id="year_<?= $tahun['tahun'] ?>"><?= $tahun['jumlah'] ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                    <div class="legend-item legend-total">
                                        <span>Total</span>
                                        <span id="yearly_total"><?= $statistik['total_mitra'] ?? 0 ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="legend-item">
                                        <span colspan="2">Tidak ada data</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Panel 3: Bar Chart Bulanan (untuk tahun tertentu) -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="chart-title mb-0" id="monthlyChartTitle">Bulanan</h3>
                                <!-- Mini filter untuk tahun -->
                                <div class="monthly-chart-filter">
                                    <select class="form-select form-select-sm" id="yearFilter" onchange="updateMonthlyChart()" 
                                            style="width: 100px; font-size: 0.8rem; border: 1px solid #e3e6f0; border-radius: 0.35rem;">
                                        <option value="(2019)">2019</option>
                                        <option value="(2020)">2020</option>
                                        <option value="(2021)">2021</option>
                                        <option value="(2022)">2022</option>
                                        <option value="(2023)">2023</option>
                                        <option value="(2024)">2024</option>
                                        <option value="(2025)" selected>2025</option>
                                    </select>
                                </div>
                            </div>
                            <div class="chart-container" style="height: 180px; position: relative;">
                                <canvas id="monthlyChart"></canvas>
                            </div>
                            <!-- Legend Table untuk Data Bulanan -->
                            <div class="chart-legend mt-auto">
                                <div class="legend-header">
                                    <span>Bulan</span>
                                    <span>Jumlah</span>
                                </div>
                                <div class="legend-content" style="max-height: 180px; overflow-y: auto;">
                                    <div class="legend-item">
                                        <span>January</span>
                                        <span id="month_january"><?= $statistik['per_bulan']['January'] ?? 0 ?></span>
                                    </div>
                                    <div class="legend-item">
                                        <span>February</span>
                                        <span id="month_february"><?= $statistik['per_bulan']['February'] ?? 0 ?></span>
                                    </div>
                                    <div class="legend-item">
                                        <span>March</span>
                                        <span id="month_march"><?= $statistik['per_bulan']['March'] ?? 0 ?></span>
                                    </div>
                                    <div class="legend-item">
                                        <span>April</span>
                                        <span id="month_april"><?= $statistik['per_bulan']['April'] ?? 0 ?></span>
                                    </div>
                                    <div class="legend-item">
                                        <span>May</span>
                                        <span id="month_may"><?= $statistik['per_bulan']['May'] ?? 0 ?></span>
                                    </div>
                                    <div class="legend-item">
                                        <span>June</span>
                                        <span id="month_june"><?= $statistik['per_bulan']['June'] ?? 0 ?></span>
                                    </div>
                                    <div class="legend-item">
                                        <span>July</span>
                                        <span id="month_july"><?= $statistik['per_bulan']['July'] ?? 0 ?></span>
                                    </div>
                                    <div class="legend-item">
                                        <span>August</span>
                                        <span id="month_august"><?= $statistik['per_bulan']['August'] ?? 0 ?></span>
                                    </div>
                                    <div class="legend-item">
                                        <span>September</span>
                                        <span id="month_september"><?= $statistik['per_bulan']['September'] ?? 0 ?></span>
                                    </div>
                                    <div class="legend-item">
                                        <span>October</span>
                                        <span id="month_october"><?= $statistik['per_bulan']['October'] ?? 0 ?></span>
                                    </div>
                                    <div class="legend-item">
                                        <span>November</span>
                                        <span id="month_november"><?= $statistik['per_bulan']['November'] ?? 0 ?></span>
                                    </div>
                                    <div class="legend-item">
                                        <span>December</span>
                                        <span id="month_december"><?= $statistik['per_bulan']['December'] ?? 0 ?></span>
                                    </div>
                                </div>
                                <div class="legend-item legend-total">
                                    <span>Total</span>
                                    <span id="monthly_total"><?= $statistik['total_bulan'] ?? 0 ?></span>
                                </div>
                            </div>
                        </div>
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
                        <a href="<?= base_url('aktivitas/detail/' . $activity['id']) ?>" class="activity-image d-block" style="text-decoration:none;">
                            <?php
                                $image = !empty($activity['gambar']) ? $activity['gambar'] : null;
                                $imagePath = FCPATH . 'uploads/berita/' . $image;
                                $imageExists = $image && file_exists($imagePath) && is_file($imagePath);
                            ?>
                            <img src="<?= $imageExists ? base_url('uploads/berita/' . $image) : base_url('assets/images/placeholder-activity.jpg') ?>"
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
                                <a href="<?= base_url('aktivitas/detail/' . $activity['id']) ?>" style="text-decoration:none; color:inherit;">
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
    // Pass data from PHP to JavaScript
    window.statistikData = <?= json_encode($statistik) ?>;
</script>
<script src="<?= base_url('js/public/home.js') ?>"></script>
<?= $this->endSection() ?>