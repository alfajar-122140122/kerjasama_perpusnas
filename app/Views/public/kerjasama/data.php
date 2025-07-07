<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?><?= $page_title ?> - Perpustakaan Nasional RI<?= $this->endSection() ?>

<?= $this->section('description') ?><?= $meta_description ?><?= $this->endSection() ?>

<?= $this->section('keywords') ?>data kerja sama, mou, moa, pks, perpustakaan nasional, mitra, kerjasama perpustakaan, institusi<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/navigation.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/kerjasama_data.css') ?>" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Include Navigation Component -->
<?= $this->include('layouts/components/public_navigation') ?>

<!-- Main Content Wrapper -->
<div class="kerjasama-data-wrapper">
    <div class="container">
        
        <!-- Page Header with Breadcrumb -->
        <div class="page-header-section" data-aos="fade-down">
            <div class="page-header-content">
                <div class="breadcrumb-section">
                    <nav class="breadcrumb-nav" aria-label="breadcrumb">
                        <a href="<?= base_url('/') ?>" class="breadcrumb-link">
                            <i class="fas fa-home"></i>
                            Beranda
                        </a>
                        <span class="breadcrumb-separator">/</span>
                        <div class="breadcrumb-dropdown">
                            <button class="breadcrumb-dropdown-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                Kerja Sama
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu breadcrumb-dropdown-menu">
                                <?php foreach (get_kerja_sama_submenu() as $item): ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $item['url'] ?>">
                                        <i class="<?= $item['icon'] ?>"></i>
                                        <span><?= $item['title'] ?></span>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <span class="breadcrumb-separator">/</span>
                        <span class="breadcrumb-current">Data Kerja Sama</span>
                    </nav>
                </div>
                <h1 class="page-main-title">Data Kerja Sama</h1>
                <p class="page-subtitle">Kelola dan monitor seluruh data kerja sama Perpustakaan Nasional RI dengan mitra institusi</p>
            </div>
        </div>

        <!-- Statistics Dashboard -->
        <div class="stats-dashboard-section" data-aos="fade-up" data-aos-delay="100">
            <div class="stats-grid">
                <div class="stat-card primary" data-aos="zoom-in" data-aos-delay="150">
                    <div class="stat-content">
                        <div class="stat-number" data-count="<?= $cooperation_stats['total_partners'] ?>">0</div>
                        <div class="stat-label">Total Mitra</div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i>
                            <span>+12% dari tahun lalu</span>
                        </div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                
                <div class="stat-card success" data-aos="zoom-in" data-aos-delay="200">
                    <div class="stat-content">
                        <div class="stat-number" data-count="<?= $cooperation_stats['active_agreements'] ?>">0</div>
                        <div class="stat-label">Perjanjian Aktif</div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i>
                            <span>+8% dari bulan lalu</span>
                        </div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                </div>
                
                <div class="stat-card warning" data-aos="zoom-in" data-aos-delay="250">
                    <div class="stat-content">
                        <div class="stat-number" data-count="<?= $cooperation_stats['pending_renewal'] ?>">0</div>
                        <div class="stat-label">Menunggu Perpanjangan</div>
                        <div class="stat-trend neutral">
                            <i class="fas fa-clock"></i>
                            <span>Perlu perhatian</span>
                        </div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
                
                <div class="stat-card info" data-aos="zoom-in" data-aos-delay="300">
                    <div class="stat-content">
                        <div class="stat-number" data-count="<?= $cooperation_stats['new_this_year'] ?>">0</div>
                        <div class="stat-label">Baru Tahun Ini</div>
                        <div class="stat-trend positive">
                            <i class="fas fa-calendar"></i>
                            <span><?= date('Y') ?></span>
                        </div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Search Section -->
        <div class="filter-search-section" data-aos="fade-up" data-aos-delay="200">
            <div class="filter-search-header">
                <h3 class="section-title">
                    <i class="fas fa-filter"></i>
                    Filter & Pencarian
                </h3>
                <button class="btn btn-outline-primary btn-sm" id="resetFiltersBtn">
                    <i class="fas fa-undo"></i>
                    Reset Filter
                </button>
            </div>
            
            <div class="filter-search-content">
                <form class="search-filter-form" id="cooperationFilterForm">
                    <div class="row">
                        <!-- Search Input -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-search"></i>
                                Pencarian
                            </label>
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control search-input" 
                                       id="searchInput" 
                                       placeholder="Cari nama mitra, lokasi, atau kontak..."
                                       autocomplete="off">
                                <button class="btn btn-primary search-btn" type="button" id="searchBtn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Status Filter -->
                        <div class="col-lg-2 col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-info-circle"></i>
                                Status
                            </label>
                            <select class="form-select filter-select" id="statusFilter">
                                <option value="">Semua Status</option>
                                <?php foreach ($filter_options['status'] as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Scope Filter -->
                        <div class="col-lg-2 col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-globe"></i>
                                Lingkup
                            </label>
                            <select class="form-select filter-select" id="scopeFilter">
                                <option value="">Semua Lingkup</option>
                                <?php foreach ($filter_options['scope'] as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Type Filter -->
                        <div class="col-lg-2 col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-file-contract"></i>
                                Jenis
                            </label>
                            <select class="form-select filter-select" id="typeFilter">
                                <option value="">Semua Jenis</option>
                                <?php foreach ($filter_options['type'] as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Year Filter -->
                        <div class="col-lg-2 col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-calendar-alt"></i>
                                Tahun
                            </label>
                            <select class="form-select filter-select" id="yearFilter">
                                <option value="">Semua Tahun</option>
                                <?php foreach ($filter_options['year'] as $year): ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Quick Filters -->
                    <div class="quick-filters">
                        <span class="quick-filter-label">
                            <i class="fas fa-bolt"></i>
                            Filter Cepat:
                        </span>
                        <button type="button" class="btn btn-outline-success btn-sm quick-filter-btn" data-filter="active">
                            <i class="fas fa-check-circle"></i>
                            Aktif
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-sm quick-filter-btn" data-filter="expiring">
                            <i class="fas fa-clock"></i>
                            Akan Berakhir
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm quick-filter-btn" data-filter="international">
                            <i class="fas fa-globe"></i>
                            Internasional
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm quick-filter-btn" data-filter="this-year">
                            <i class="fas fa-calendar"></i>
                            Tahun Ini
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="data-table-section" data-aos="fade-up" data-aos-delay="300">
            <div class="table-header">
                <div class="table-title-section">
                    <h3 class="table-title">
                        <i class="fas fa-table"></i>
                        Data Kerja Sama
                    </h3>
                    <div class="table-actions">
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-secondary btn-sm" id="exportBtn" title="Export Data">
                                <i class="fas fa-download"></i>
                                Export
                            </button>
                            <button class="btn btn-outline-info btn-sm" id="printBtn" title="Print Data">
                                <i class="fas fa-print"></i>
                                Print
                            </button>
                        </div>
                        <button class="btn btn-primary btn-sm" id="addNewBtn">
                            <i class="fas fa-plus"></i>
                            Tambah Baru
                        </button>
                    </div>
                </div>
                <div class="table-info">
                    <span class="results-count">
                        Menampilkan <strong id="showingStart">1</strong>-<strong id="showingEnd">20</strong> 
                        dari <strong id="totalItems"><?= $total_items ?></strong> data
                    </span>
                    <div class="view-options">
                        <div class="btn-group" role="group" aria-label="View options">
                            <button class="btn btn-sm view-option-btn active" data-view="table" title="Tampilan Tabel">
                                <i class="fas fa-table"></i>
                            </button>
                            <button class="btn btn-sm view-option-btn" data-view="grid" title="Tampilan Grid">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="btn btn-sm view-option-btn" data-view="list" title="Tampilan List">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table cooperation-table" id="cooperationTable">
                        <thead>
                            <tr>
                                <th class="sortable" data-sort="partner" tabindex="0">
                                    <span>Mitra Kerja Sama</span>
                                    <i class="fas fa-sort sort-icon"></i>
                                </th>
                                <th class="sortable" data-sort="type" tabindex="0">
                                    <span>Jenis & Status</span>
                                    <i class="fas fa-sort sort-icon"></i>
                                </th>
                                <th class="sortable" data-sort="period" tabindex="0">
                                    <span>Periode</span>
                                    <i class="fas fa-sort sort-icon"></i>
                                </th>
                                <th class="sortable" data-sort="scope" tabindex="0">
                                    <span>Lingkup</span>
                                    <i class="fas fa-sort sort-icon"></i>
                                </th>
                                <th class="sortable" data-sort="progress" tabindex="0">
                                    <span>Progress</span>
                                    <i class="fas fa-sort sort-icon"></i>
                                </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="cooperationTableBody">
                            <!-- Data will be loaded here by JavaScript -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Loading State -->
                <div class="loading-state" id="loadingState" style="display: none;">
                    <div class="loading-spinner">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <p>Memuat data kerja sama...</p>
                </div>
                
                <!-- Empty State -->
                <div class="empty-state" id="emptyState" style="display: none;">
                    <div class="empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4>Tidak ada data ditemukan</h4>
                    <p>Coba ubah kriteria pencarian atau filter Anda</p>
                    <button class="btn btn-primary" onclick="resetFilters()">
                        <i class="fas fa-undo"></i>
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Pagination Section -->
        <div class="pagination-section" data-aos="fade-up" data-aos-delay="400">
            <div class="pagination-info">
                <label for="pageSizeSelect" class="form-label">Tampilkan:</label>
                <select class="form-select page-size-select" id="pageSizeSelect">
                    <option value="10">10 per halaman</option>
                    <option value="20" selected>20 per halaman</option>
                    <option value="50">50 per halaman</option>
                    <option value="100">100 per halaman</option>
                </select>
            </div>
            <nav class="pagination-nav" aria-label="Navigation halaman">
                <ul class="pagination" id="paginationList">
                    <!-- Pagination will be generated by JavaScript -->
                </ul>
            </nav>
        </div>

    </div>
</div>

<!-- Toast Notification Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer">
    <!-- Toast notifications will be added here -->
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });
    
    // Pass PHP data to JavaScript
    window.cooperationInitialData = <?= json_encode($cooperation_data) ?>;
    window.cooperationStats = <?= json_encode($cooperation_stats) ?>;
    window.filterOptions = <?= json_encode($filter_options) ?>;
</script>
<script src="<?= base_url('js/public/kerjasama_data.js') ?>"></script>
<?= $this->endSection() ?>