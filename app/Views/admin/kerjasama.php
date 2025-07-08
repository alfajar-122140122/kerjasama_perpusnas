<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Kerjasama<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen Kerjasama<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" rel="stylesheet">
<link href="<?= base_url('css/kerjasama-management.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Alert Container -->
    <div id="alertContainer"></div>
    
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kerjasama</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalKerjasama">0</div>
                        </div>
                        <div>
                            <i class="fas fa-handshake fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kerjasama Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="activeKerjasama">0</div>
                        </div>
                        <div>
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Kerjasama Berakhir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="expiredKerjasama">0</div>
                        </div>
                        <div>
                            <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="thisMonthKerjasama">0</div>
                        </div>
                        <div>
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Kerjasama</h6>
            <button type="button" class="btn btn-primary" id="addKerjasamaBtn" data-bs-toggle="modal" data-bs-target="#kerjasamaModal">
                <i class="fas fa-plus me-1"></i> Tambah Kerjasama
            </button>
        </div>
        <div class="card-body">
            <!-- View Tabs -->
            <ul class="nav nav-tabs mb-4" id="viewTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-view="all" href="#">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-view="akan-berakhir" href="#">Akan Berakhir</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-view="implementasi" href="#">Implementasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-view="progress" href="#">Progress</a>
                </li>
            </ul>
            
            <!-- Filter Section -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light py-2">
                    <button class="btn btn-sm btn-link text-decoration-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                        <i class="fas fa-filter me-1"></i> Filter Data <i class="fas fa-chevron-down ms-1 small"></i>
                    </button>
                    
                    <div class="float-end">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Cari..." style="max-width: 200px;">
                            <button class="btn btn-primary btn-sm" id="searchBtn">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-secondary btn-sm" id="resetFilterBtn">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="filterCollapse">
                    <div class="card-body py-3">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="filterJenis" class="form-label small">Jenis Kerjasama</label>
                                <select class="form-select form-select-sm" id="filterJenis">
                                    <option value="">Semua Jenis</option>
                                    <option value="MOU">MOU</option>
                                    <option value="PKS">PKS</option>
                                    <option value="MoA">MoA</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterLingkup" class="form-label small">Lingkup</label>
                                <select class="form-select form-select-sm" id="filterLingkup">
                                    <option value="">Semua Lingkup</option>
                                    <option value="nasional">Nasional</option>
                                    <option value="internasional">Internasional</option>
                                </select>
                            </div>
                            <div class="col-md-3" id="filterRegionContainer" style="display:none;">
                                <label for="filterRegion" class="form-label small">Region</label>
                                <select class="form-select form-select-sm" id="filterRegion">
                                    <option value="">Semua Region</option>
                                    <option value="asia">Asia</option>
                                    <option value="europe">Eropa</option>
                                    <option value="america">Amerika</option>
                                    <option value="africa">Afrika</option>
                                    <option value="oceania">Oseania</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterStatus" class="form-label small">Status</label>
                                <select class="form-select form-select-sm" id="filterStatus">
                                    <option value="">Semua Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="berakhir">Berakhir</option>
                                    <option value="menunggu_perpanjangan">Menunggu Perpanjangan</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row g-3 mt-1">
                            <div class="col-md-3">
                                <label for="filterStartDate" class="form-label small">Tanggal Mulai</label>
                                <input type="date" class="form-control form-control-sm" id="filterStartDate">
                            </div>
                            <div class="col-md-3">
                                <label for="filterEndDate" class="form-label small">Tanggal Selesai</label>
                                <input type="date" class="form-control form-control-sm" id="filterEndDate">
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button class="btn btn-primary btn-sm me-2" id="applyFilterBtn">
                                    <i class="fas fa-check me-1"></i> Terapkan Filter
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" id="clearFilterBtn">
                                    <i class="fas fa-times me-1"></i> Hapus Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <!-- Default Table (All & Akan Berakhir View) -->
                <table class="table table-bordered view-table" id="kerjasamaTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mitra</th>
                            <th>Ruang Lingkup</th>
                            <th>Jenis</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Lingkup</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="kerjasamaTableBody">
                        <!-- Data will be populated by JavaScript -->
                    </tbody>
                </table>
                
                <!-- Implementasi View Table -->
                <table class="table table-bordered view-table" id="implementasiTable" style="display:none" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mitra</th>
                            <th>Masa Berlaku</th>
                            <th>Implementasi</th>
                            <th>Lingkup</th>
                            <th>Unit Kerja</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="implementasiTableBody">
                        <!-- Data will be populated by JavaScript -->
                    </tbody>
                </table>
                
                <!-- Progress View Table -->
                <table class="table table-bordered view-table" id="progressTable" style="display:none" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Nama Mitra</th>
                            <th>Jenis</th>
                            <th>Progress</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="progressTableBody">
                        <!-- Data will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <p class="pagination-info">
                        Menampilkan <span id="showingStart">0</span> sampai <span id="showingEnd">0</span> dari <span id="totalItems">0</span> data
                    </p>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation" class="float-end">
                        <ul class="pagination" id="pagination">
                            <!-- Pagination will be populated by JavaScript -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Kerjasama Modal -->
<div class="modal fade" id="kerjasamaModal" tabindex="-1" aria-labelledby="kerjasamaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kerjasamaModalLabel">Tambah Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="kerjasamaForm">
                    <?= csrf_field() ?>
                    <input type="hidden" id="id_kerjasama" name="id_kerjasama">
                    
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs mb-3" id="formTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-tab-pane" type="button">Informasi Dasar</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail-tab-pane" type="button">Detail & Status</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="kontak-tab" data-bs-toggle="tab" data-bs-target="#kontak-tab-pane" type="button">Kontak & Lokasi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="implementasi-tab" data-bs-toggle="tab" data-bs-target="#implementasi-tab-pane" type="button">Implementasi</button>
                        </li>
                    </ul>
                    
                    <!-- Tab Content -->
                    <div class="tab-content" id="formTabContent">
                        <!-- Tab 1: Informasi Dasar -->
                        <div class="tab-pane fade show active" id="info-tab-pane" role="tabpanel" aria-labelledby="info-tab">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_mitra" class="form-label">Nama Mitra <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_mitra" name="nama_mitra" required>
                                    <div class="invalid-feedback" id="nama_mitra_feedback"></div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="jenis" class="form-label">Jenis Kerjasama <span class="text-danger">*</span></label>
                                    <select class="form-select" id="jenis" name="jenis" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="MOU">MOU</option>
                                        <option value="PKS">PKS</option>
                                        <option value="MoA">MoA</option>
                                    </select>
                                    <div class="invalid-feedback" id="jenis_feedback"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="ruang_lingkup" class="form-label">Ruang Lingkup <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="ruang_lingkup" name="ruang_lingkup" rows="3" required></textarea>
                                <div class="invalid-feedback" id="ruang_lingkup_feedback"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                                    <div class="invalid-feedback" id="tanggal_mulai_feedback"></div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                                    <div class="invalid-feedback" id="tanggal_selesai_feedback"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="unit_kerja" class="form-label">Unit Kerja</label>
                                <input type="text" class="form-control" id="unit_kerja" name="unit_kerja" placeholder="Contoh: Pusat Pengembangan Koleksi">
                                <div class="invalid-feedback" id="unit_kerja_feedback"></div>
                            </div>
                        </div>
                        
                        <!-- Tab 2: Detail & Status -->
                        <div class="tab-pane fade" id="detail-tab-pane" role="tabpanel" aria-labelledby="detail-tab">
                            <div class="mb-3">
                                <label for="progress" class="form-label">Progress (%)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="progress" name="progress" min="0" max="100" value="0">
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="progress mt-2" style="height: 10px;">
                                    <div class="progress-bar" role="progressbar" id="progressBar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="invalid-feedback" id="progress_feedback"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="lingkup" class="form-label">Lingkup</label>
                                    <select class="form-select" id="lingkup" name="lingkup">
                                        <option value="">Pilih Lingkup</option>
                                        <option value="nasional">Nasional</option>
                                        <option value="internasional">Internasional</option>
                                    </select>
                                    <div class="invalid-feedback" id="lingkup_feedback"></div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="aktif">Aktif</option>
                                        <option value="berakhir">Berakhir</option>
                                        <option value="menunggu_perpanjangan">Menunggu Perpanjangan</option>
                                    </select>
                                    <div class="invalid-feedback" id="status_feedback"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3" id="regionContainer" style="display:none;">
                                <label for="region" class="form-label">Region</label>
                                <select class="form-select" id="region" name="region">
                                    <option value="">Pilih Region</option>
                                    <option value="asia">Asia</option>
                                    <option value="europe">Eropa</option>
                                    <option value="america">Amerika</option>
                                    <option value="africa">Afrika</option>
                                    <option value="oceania">Oseania</option>
                                </select>
                                <div class="invalid-feedback" id="region_feedback"></div>
                            </div>
                        </div>
                        
                        <!-- Tab 3: Kontak & Lokasi -->
                        <div class="tab-pane fade" id="kontak-tab-pane" role="tabpanel" aria-labelledby="kontak-tab">
                            <div class="mb-3">
                                <label for="kontak_nama" class="form-label">Nama Kontak</label>
                                <input type="text" class="form-control" id="kontak_nama" name="kontak_nama" placeholder="Nama lengkap kontak">
                                <div class="invalid-feedback" id="kontak_nama_feedback"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kontak_email" class="form-label">Email Kontak</label>
                                    <input type="email" class="form-control" id="kontak_email" name="kontak_email" placeholder="email@example.com">
                                    <div class="invalid-feedback" id="kontak_email_feedback"></div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="kontak_telepon" class="form-label">Telepon Kontak</label>
                                    <input type="text" class="form-control" id="kontak_telepon" name="kontak_telepon" placeholder="+62xxxxxxxxxx">
                                    <div class="invalid-feedback" id="kontak_telepon_feedback"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="lokasi_mitra" class="form-label">Lokasi Mitra</label>
                                <input type="text" class="form-control" id="lokasi_mitra" name="lokasi_mitra" placeholder="Contoh: Jakarta">
                                <div class="invalid-feedback" id="lokasi_mitra_feedback"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Contoh: -6.1751">
                                    <div class="invalid-feedback" id="latitude_feedback"></div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Contoh: 106.8650">
                                    <div class="invalid-feedback" id="longitude_feedback"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tab 4: Implementasi -->
                        <div class="tab-pane fade" id="implementasi-tab-pane" role="tabpanel" aria-labelledby="implementasi-tab">
                            <div class="mb-3">
                                <label for="implementasi" class="form-label">Implementasi Kerjasama</label>
                                <textarea class="form-control" id="implementasi" name="implementasi" rows="5" placeholder="Masukkan implementasi kerja sama (pisahkan dengan baris baru)"></textarea>
                                <small class="text-muted">Pisahkan setiap implementasi dengan baris baru</small>
                                <div class="invalid-feedback" id="implementasi_feedback"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveKerjasamaBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Kerjasama Modal -->
<div class="modal fade" id="detailKerjasamaModal" tabindex="-1" aria-labelledby="detailKerjasamaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailKerjasamaModalLabel">Detail Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="fw-bold">Nama Mitra</h6>
                            <p id="detail_nama_mitra" class="border-bottom pb-2">-</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold">Jenis Kerjasama</h6>
                            <p id="detail_jenis" class="border-bottom pb-2">-</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold">Progress</h6>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar" role="progressbar" id="detail_progress_bar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p id="detail_progress" class="mt-1 border-bottom pb-2">0%</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="fw-bold">Tanggal Mulai</h6>
                            <p id="detail_tanggal_mulai" class="border-bottom pb-2">-</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold">Tanggal Selesai</h6>
                            <p id="detail_tanggal_selesai" class="border-bottom pb-2">-</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold">Status</h6>
                            <p id="detail_status" class="border-bottom pb-2">-</p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6 class="fw-bold">Ruang Lingkup</h6>
                    <div class="p-3 bg-light rounded" id="detail_ruang_lingkup">-</div>
                </div>

                <!-- Lingkup dan Region -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="fw-bold">Lingkup</h6>
                            <p id="detail_lingkup" class="border-bottom pb-2">-</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3" id="detail_region_container">
                            <h6 class="fw-bold">Region</h6>
                            <p id="detail_region" class="border-bottom pb-2">-</p>
                        </div>
                    </div>
                </div>
                
                <!-- Unit Kerja -->
                <div class="mb-3">
                    <h6 class="fw-bold">Unit Kerja</h6>
                    <p id="detail_unit_kerja" class="border-bottom pb-2">-</p>
                </div>
                
                <!-- Implementasi -->
                <div class="mb-3">
                    <h6 class="fw-bold">Implementasi Kerjasama</h6>
                    <ul id="detail_implementasi" class="list-group">
                        <li class="list-group-item">Tidak ada data implementasi</li>
                    </ul>
                </div>
                
                <!-- Informasi Kontak -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h6 class="fw-bold mb-0">Informasi Kontak</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1 fw-bold">Nama:</p>
                                <p id="detail_kontak_nama">-</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1 fw-bold">Email:</p>
                                <p id="detail_kontak_email">-</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1 fw-bold">Telepon:</p>
                                <p id="detail_kontak_telepon">-</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3" id="locationSection">
                    <h6 class="fw-bold">Lokasi</h6>
                    <p id="detail_lokasi_mitra" class="mb-2">-</p>
                    <p id="detail_location" class="mb-2">-</p>
                    <div id="mapContainer" class="border rounded" style="height: 200px;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="editFromDetailBtn">Edit</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus data kerjasama dengan <strong id="delete_nama_mitra">-</strong>?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                <input type="hidden" id="delete_id_kerjasama">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/kerjasama-management.js') ?>"></script>
<?= $this->endSection() ?>
