<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Permohonan Kerjasama<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Permohonan Kerjasama<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="page-title">Permohonan Kerjasama</h2>
            <p class="text-muted mb-4">Kelola permohonan kerjasama yang masuk dari berbagai lembaga</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Permohonan</div>
                            <div class="h5 mb-0" id="totalPermohonan">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-file-alt fa-2x"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Menunggu Review</div>
                            <div class="h5 mb-0" id="permohonanPending">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-clock fa-2x"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0" id="permohonanDisetujui">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0" id="permohonanDitolak">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Permohonan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="permohonanTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Jenis Permohonan</th>
                            <th width="20%">Lembaga</th>
                            <th width="15%">Kontak</th>
                            <th width="12%">Tanggal Pengajuan</th>
                            <th width="10%">Status</th>
                            <th width="13%">Unit Terkait</th>
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

<!-- View Permohonan Modal -->
<div class="modal fade" id="viewPermohonanModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Permohonan Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="permohonanDetail">
                <!-- Content will be loaded by JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="approveBtn" onclick="updateStatusPermohonan('disetujui')">
                    <i class="fas fa-check me-2"></i>Setujui
                </button>
                <button type="button" class="btn btn-danger" id="rejectBtn" onclick="updateStatusPermohonan('ditolak')">
                    <i class="fas fa-times me-2"></i>Tolak
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalTitle">Update Status Permohonan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusForm">
                <div class="modal-body">
                    <input type="hidden" id="permohonan_id" name="permohonan_id">
                    <input type="hidden" id="new_status" name="status">
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3" id="unitTerkaitDiv" style="display: none;">
                        <label for="unit_terkait" class="form-label">Unit Terkait</label>
                        <select class="form-select" id="unit_terkait" name="unit_terkait">
                            <option value="">Pilih Unit</option>
                            <option value="Deputi Bidang Pengembangan Sumber Daya Perpustakaan">Deputi Bidang Pengembangan Sumber Daya Perpustakaan</option>
                            <option value="Deputi Bidang Layanan Perpustakaan">Deputi Bidang Layanan Perpustakaan</option>
                            <option value="Deputi Bidang Pelestarian dan Konservasi Koleksi">Deputi Bidang Pelestarian dan Konservasi Koleksi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitStatusBtn">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>