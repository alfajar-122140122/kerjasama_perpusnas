<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Implementasi Kerjasama<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Implementasi Kerjasama<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="page-title">Implementasi Kerjasama</h2>
            <p class="text-muted mb-4">Kelola kegiatan implementasi dari kerjasama yang sedang berjalan</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Implementasi</div>
                            <div class="h5 mb-0" id="totalImplementasi">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-tasks fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Sedang Berjalan</div>
                            <div class="h5 mb-0" id="implementasiBerjalan">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-play-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Selesai</div>
                            <div class="h5 mb-0" id="implementasiSelesai">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Bulan Ini</div>
                            <div class="h5 mb-0" id="implementasiBulanIni">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-calendar-week fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Implementasi</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addImplementasiModal">
                <i class="fas fa-plus me-2"></i>Tambah Implementasi
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="implementasiTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Kegiatan</th>
                            <th width="20%">Kerjasama</th>
                            <th width="15%">Tanggal Mulai</th>
                            <th width="15%">Tanggal Selesai</th>
                            <th width="15%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>