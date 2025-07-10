<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Kelola Implementasi<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Kelola Implementasi<?= $this->endSection() ?>

<?= $this->section('styles') ?>
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

    <!-- Main Content Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kelola Implementasi</h6>
            <button type="button" class="btn btn-success" id="addImplementasiBtn" data-bs-toggle="modal" data-bs-target="#implementasiModal">
                <i class="fas fa-plus me-1"></i> Tambah Implementasi
            </button>
        </div>
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="filter-section mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <button class="btn btn-sm btn-link text-decoration-none collapsed p-0" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                        <i class="fas fa-filter me-1"></i> Filter <i class="fas fa-chevron-down ms-1 small"></i>
                    </button>
                    
                    <div class="d-flex gap-2">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari Data...">
                            <button class="btn btn-primary" id="searchBtn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="filterCollapse">
                    <div class="card-body py-3">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="filterMitra" class="form-label small">Nama Mitra</label>
                                <select class="form-select form-select-sm" id="filterMitra">
                                    <option value="">Semua Mitra</option>
                                    <option value="fulan">Fulan</option>
                                    <option value="fulana">Fulana</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterImplementasi" class="form-label small">Implementasi</label>
                                <select class="form-select form-select-sm" id="filterImplementasi">
                                    <option value="">Semua Implementasi</option>
                                    <option value="dokumenter">Dokumenter Budaya</option>
                                    <option value="perpanjangan">Perpanjangan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterUnitKerja" class="form-label small">Unit Kerja</label>
                                <select class="form-select form-select-sm" id="filterUnitKerja">
                                    <option value="">Semua Unit</option>
                                    <option value="pustakawan">Pustakawan</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-secondary btn-sm" id="resetFilterBtn">
                                    <i class="fas fa-sync-alt me-1"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-bordered" id="implementasiTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th style="width: 15%;">Nama Mitra</th>
                            <th style="width: 15%;">Masa Berlaku</th>
                            <th style="width: 25%;">Implementasi</th>
                            <th style="width: 15%;">Lingkup</th>
                            <th style="width: 15%;">Unit Kerja</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample data row for demonstration -->
                        <tr>
                            <td><input type="checkbox" class="form-check-input row-checkbox"></td>
                            <td>Fulan</td>
                            <td>14/08/2025 - 15/08/2026</td>
                            <td>Pelestarian warisan dokumen budaya Nusantara</td>
                            <td>Dokumenter Budaya</td>
                            <td>Pustakawan</td>
                            <td>
                                <button class="btn btn-sm btn-success btn-action" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-primary btn-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-action" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/admin/kerjasama-implementasi.js') ?>"></script>
<?= $this->endSection() ?>
