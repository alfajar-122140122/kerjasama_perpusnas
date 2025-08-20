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
                
                <!-- Filter Controls -->
                <div class="filter-section">
                    <div class="d-flex gap-3 align-items-center flex-wrap">
                        <label class="form-label mb-0 fw-semibold">Filter:</label>
                        <select class="form-select form-select-sm" id="yearFilter" onchange="updateStatistics()" style="width: 140px;">
                            <option value="">Semua Tahun</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                        </select>
                        <select class="form-select form-select-sm" id="jenisFilter" onchange="updateStatistics()" style="width: 120px;">
                            <option value="">Semua Jenis</option>
                            <option value="MOU">MOU</option>
                            <option value="MOA">MOA</option>
                            <option value="PKS">PKS</option>
                        </select>
                        <select class="form-select form-select-sm" id="statusFilter" onchange="updateStatistics()" style="width: 130px;">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="berakhir">Berakhir</option>
                            <option value="draft">Draft</option>
                        </select>
                        <button class="btn btn-outline-primary btn-sm" onclick="resetFilters()">
                            <i class="fas fa-refresh"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="row g-4 mb-4">
                <!-- Panel 1: Pie Chart Jenis Identitas Mitra -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
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
                            <div class="chart-container">
                                <canvas id="pieChart"></canvas>
                            </div>
                            <!-- Legend Table untuk Jenis Identitas Mitra -->
                            <div class="chart-legend">
                                <div class="legend-header">
                                    <span>Jenis Identitas Mitra</span>
                                    <span>Jumlah</span>
                                </div>
                                <div class="legend-item">
                                    <span><span class="legend-color legend-color-pts">●</span> PTS</span>
                                    <span id="pieChart_ptsCount">529</span>
                                </div>
                                <div class="legend-item">
                                    <span><span class="legend-color legend-color-kl">●</span> K/L</span>
                                    <span id="pieChart_klCount">38</span>
                                </div>
                                <div class="legend-item">
                                    <span><span class="legend-color legend-color-ptn">●</span> PTN</span>
                                    <span id="pieChart_ptnCount">24</span>
                                </div>
                                <div class="legend-item">
                                    <span><span class="legend-color legend-color-swasta">●</span> Swasta</span>
                                    <span id="pieChart_swastaCount">12</span>
                                </div>
                                <div class="legend-item">
                                    <span><span class="legend-color legend-color-luar-negeri">●</span> Luar Negeri</span>
                                    <span id="pieChart_luarNegeriCount">6</span>
                                </div>
                                <div class="legend-item legend-total">
                                    <span>Total</span>
                                    <span id="pieChart_totalLembaga">609</span>
                                </div>
                                <!-- Filter Info -->
                                <div class="filter-info mt-2">
                                    <small class="text-muted" id="pieChartFilterInfo">Menampilkan: Semua Jenis Identitas Mitra</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Panel 2: Bar Chart Pertahun -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h3 class="chart-title">Pertahun</h3>
                            <div class="chart-container">
                                <canvas id="yearlyChart"></canvas>
                            </div>
                            <!-- Legend Table untuk Data Tahunan -->
                            <div class="chart-legend">
                                <div class="legend-header">
                                    <span>Tahun</span>
                                    <span>Jumlah</span>
                                </div>
                                <div class="legend-item">
                                    <span>2013</span>
                                    <span id="year_2013">5</span>
                                </div>
                                <div class="legend-item">
                                    <span>2014</span>
                                    <span id="year_2014">4</span>
                                </div>
                                <div class="legend-item">
                                    <span>2015</span>
                                    <span id="year_2015">14</span>
                                </div>
                                <div class="legend-item">
                                    <span>2016</span>
                                    <span id="year_2016">47</span>
                                </div>
                                <div class="legend-item">
                                    <span>2017</span>
                                    <span id="year_2017">65</span>
                                </div>
                                <div class="legend-item">
                                    <span>2018</span>
                                    <span id="year_2018">76</span>
                                </div>
                                <div class="legend-item">
                                    <span>2019</span>
                                    <span id="year_2019">267</span>
                                </div>
                                <div class="legend-item">
                                    <span>2020</span>
                                    <span id="year_2020">25</span>
                                </div>
                                <div class="legend-item">
                                    <span>2021</span>
                                    <span id="year_2021">121</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Panel 3: Bar Chart Bulanan (untuk tahun tertentu) -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h3 class="chart-title" id="monthlyChartTitle">Tahun 2022</h3>
                            <div class="chart-container">
                                <canvas id="monthlyChart"></canvas>
                            </div>
                            <!-- Legend Table untuk Data Bulanan -->
                            <div class="chart-legend">
                                <div class="legend-header">
                                    <span>Bulan</span>
                                    <span>Jumlah</span>
                                </div>
                                <div class="legend-item">
                                    <span>January</span>
                                    <span id="month_january">2</span>
                                </div>
                                <div class="legend-item">
                                    <span>February</span>
                                    <span id="month_february">1</span>
                                </div>
                                <div class="legend-item">
                                    <span>March</span>
                                    <span id="month_march">45</span>
                                </div>
                                <div class="legend-item">
                                    <span>May</span>
                                    <span id="month_may">1</span>
                                </div>
                                <div class="legend-item">
                                    <span>September</span>
                                    <span id="month_september">9</span>
                                </div>
                                <div class="legend-item">
                                    <span>October</span>
                                    <span id="month_october">105</span>
                                </div>
                                <div class="legend-item">
                                    <span>November</span>
                                    <span id="month_november">60</span>
                                </div>
                                <div class="legend-item">
                                    <span>December</span>
                                    <span id="month_december">44</span>
                                </div>
                                <div class="legend-item legend-total">
                                    <span>Total</span>
                                    <span id="monthly_total">267</span>
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
                        <a href="<?= base_url('aktivitas/detail/' . $activity['id_berita']) ?>" class="activity-image d-block" style="text-decoration:none;">
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
<script src="<?= base_url('js/public/home.js') ?>"></script>
<?= $this->endSection() ?>