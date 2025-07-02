<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Kerjasama<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen Kerjasama<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <h2 class="page-title">Manajemen Kerjasama</h2>
            <p class="text-muted mb-4">Kelola program kerjasama Perpustakaan Nasional</p>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Kerjasama</div>
                            <div class="h5 mb-0" id="totalKerjasama">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-handshake fa-2x"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Progress Aktif</div>
                            <div class="h5 mb-0" id="progressAktif">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-check-circle fa-2x"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Implementasi</div>
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
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Mitra</div>
                            <div class="h5 mb-0" id="totalMitra">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Kerjasama</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKerjasamaModal">
                <i class="fas fa-plus me-2"></i>Tambah Kerjasama
            </button>
        </div>
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchKerjasama" placeholder="Cari kerjasama...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterJenis">
                        <option value="">Semua Jenis</option>
                        <option value="Pertukaran Koleksi">Pertukaran Koleksi</option>
                        <option value="Penelitian">Penelitian</option>
                        <option value="Pelatihan">Pelatihan</option>
                        <option value="Digitalisasi">Digitalisasi</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="selesai">Selesai</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                        <i class="fas fa-redo me-1"></i>Reset
                    </button>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-bordered" id="kerjasamaTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Nama Mitra</th>
                            <th width="20%">Ruang Lingkup</th>
                            <th width="12%">Jenis</th>
                            <th width="10%">Progress</th>
                            <th width="12%">Tanggal</th>
                            <th width="12%">Lokasi</th>
                            <th width="4%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($kerjasama as $item): ?>
                        <tr class="kerjasama-row" data-kerjasama-id="<?= $item['id'] ?>">
                            <td><?= $no++ ?></td>
                            <td class="kerjasama-judul">
                                <strong><?= esc($item['judul']) ?></strong>
                                <br><small class="text-muted"><?= esc(substr($item['deskripsi'], 0, 80)) ?>...</small>
                            </td>
                            <td class="kerjasama-instansi"><?= esc($item['instansi']) ?></td>
                            <td class="kerjasama-jenis">
                                <span class="badge bg-info"><?= esc($item['jenis']) ?></span>
                            </td>
                            <td class="kerjasama-status">
                                <?php 
                                $statusClass = '';
                                switch($item['status']) {
                                    case 'aktif': $statusClass = 'success'; break;
                                    case 'selesai': $statusClass = 'primary'; break;
                                    case 'pending': $statusClass = 'warning'; break;
                                }
                                ?>
                                <span class="badge bg-<?= $statusClass ?>"><?= ucfirst($item['status']) ?></span>
                            </td>
                            <td>
                                <small>
                                    <strong>Mulai:</strong> <?= date('d/m/Y', strtotime($item['tanggal_mulai'])) ?><br>
                                    <strong>Berakhir:</strong> <?= date('d/m/Y', strtotime($item['tanggal_berakhir'])) ?>
                                </small>
                            </td>
                            <td><?= esc($item['pic']) ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-info btn-sm" onclick="viewKerjasama(<?= $item['id'] ?>)" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm" onclick="editKerjasama(<?= $item['id'] ?>)" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteKerjasama(<?= $item['id'] ?>)" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Kerjasama Modal -->
<div class="modal fade" id="addKerjasamaModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kerjasama Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addKerjasamaForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_mitra" class="form-label">Nama Mitra <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_mitra" name="nama_mitra" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jenis" class="form-label">Jenis Kerjasama <span class="text-danger">*</span></label>
                                        <select class="form-select" id="jenis" name="jenis" required>
                                            <option value="">Pilih Jenis</option>
                                            <option value="Pertukaran Koleksi">Pertukaran Koleksi</option>
                                            <option value="Penelitian">Penelitian</option>
                                            <option value="Pelatihan">Pelatihan</option>
                                            <option value="Digitalisasi">Digitalisasi</option>
                                            <option value="Konsultasi">Konsultasi</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ruang_lingkup" class="form-label">Ruang Lingkup <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="ruang_lingkup" name="ruang_lingkup" rows="3" required></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="dasar_kerjasama" class="form-label">Dasar Kerjasama</label>
                                <textarea class="form-control" id="dasar_kerjasama" name="dasar_kerjasama" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tanggal_ttd" class="form-label">Tanggal TTD <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_ttd" name="tanggal_ttd" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="progress" class="form-label">Progress</label>
                                <select class="form-select" id="progress" name="progress">
                                    <option value="draft">Draft</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi">
                            </div>
                            <div class="mb-3">
                                <label for="dokumen" class="form-label">Dokumen</label>
                                <input type="file" class="form-control" id="dokumen" name="dokumen" accept=".pdf,.doc,.docx">
                                <small class="form-text text-muted">Format: PDF, DOC, DOCX (Max: 5MB)</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Kerjasama Modal -->
<div class="modal fade" id="editKerjasamaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editKerjasamaForm">
                <input type="hidden" id="edit_kerjasama_id" name="kerjasama_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="edit_judul" class="form-label">Judul Kerjasama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_judul" name="judul" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_instansi" class="form-label">Instansi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_instansi" name="instansi" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_jenis" class="form-label">Jenis Kerjasama <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_jenis" name="jenis" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="Pertukaran Koleksi">Pertukaran Koleksi</option>
                                    <option value="Penelitian">Penelitian</option>
                                    <option value="Pelatihan">Pelatihan</option>
                                    <option value="Digitalisasi">Digitalisasi</option>
                                    <option value="Konsultasi">Konsultasi</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_tanggal_mulai" name="tanggal_mulai" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_tanggal_berakhir" class="form-label">Tanggal Berakhir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_tanggal_berakhir" name="tanggal_berakhir" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_pic" class="form-label">PIC <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_pic" name="pic" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select class="form-select" id="edit_status" name="status">
                                    <option value="pending">Pending</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Kerjasama Modal -->
<div class="modal fade" id="viewImplementasiModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Implementasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="implementasiDetail">
                <!-- Content will be loaded by JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Data kerjasama dari server
const kerjasamaData = <?= json_encode($kerjasama) ?>;

// View Kerjasama Function
function viewKerjasama(kerjasamaId) {
    const kerjasama = kerjasamaData.find(k => k.id == kerjasamaId);
    if (!kerjasama) {
        alert('Data kerjasama tidak ditemukan');
        return;
    }
    
    const detailHtml = `
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-primary mb-3">${kerjasama.judul}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><i class="fas fa-building text-muted me-2"></i><strong>Instansi:</strong></td>
                        <td>${kerjasama.instansi}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-tags text-muted me-2"></i><strong>Jenis:</strong></td>
                        <td><span class="badge bg-info">${kerjasama.jenis}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-info-circle text-muted me-2"></i><strong>Status:</strong></td>
                        <td><span class="badge bg-${kerjasama.status === 'aktif' ? 'success' : (kerjasama.status === 'selesai' ? 'primary' : 'warning')}">${kerjasama.status.toUpperCase()}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-user-tie text-muted me-2"></i><strong>PIC:</strong></td>
                        <td>${kerjasama.pic}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><i class="fas fa-calendar-alt text-muted me-2"></i><strong>Tanggal Mulai:</strong></td>
                        <td>${new Date(kerjasama.tanggal_mulai).toLocaleDateString('id-ID')}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-calendar-check text-muted me-2"></i><strong>Tanggal Berakhir:</strong></td>
                        <td>${new Date(kerjasama.tanggal_berakhir).toLocaleDateString('id-ID')}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-file-pdf text-muted me-2"></i><strong>Dokumen:</strong></td>
                        <td><a href="#" class="text-decoration-none">${kerjasama.dokumen || 'Tidak ada'}</a></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-clock text-muted me-2"></i><strong>Dibuat:</strong></td>
                        <td>${new Date(kerjasama.created_at).toLocaleDateString('id-ID')}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <h6><i class="fas fa-align-left text-muted me-2"></i>Deskripsi:</h6>
                <p class="text-muted">${kerjasama.deskripsi || 'Tidak ada deskripsi'}</p>
            </div>
        </div>
    `;
    
    document.getElementById('kerjasamaDetail').innerHTML = detailHtml;
    const modal = new bootstrap.Modal(document.getElementById('viewKerjasamaModal'));
    modal.show();
}

// Edit Kerjasama Function
function editKerjasama(kerjasamaId) {
    const kerjasama = kerjasamaData.find(k => k.id == kerjasamaId);
    if (!kerjasama) {
        alert('Data kerjasama tidak ditemukan');
        return;
    }
    
    // Populate form
    document.getElementById('edit_kerjasama_id').value = kerjasama.id;
    document.getElementById('edit_judul').value = kerjasama.judul;
    document.getElementById('edit_instansi').value = kerjasama.instansi;
    document.getElementById('edit_jenis').value = kerjasama.jenis;
    document.getElementById('edit_tanggal_mulai').value = kerjasama.tanggal_mulai;
    document.getElementById('edit_tanggal_berakhir').value = kerjasama.tanggal_berakhir;
    document.getElementById('edit_pic').value = kerjasama.pic;
    document.getElementById('edit_status').value = kerjasama.status;
    document.getElementById('edit_deskripsi').value = kerjasama.deskripsi || '';
    
    // Clear previous errors
    clearFormErrors(document.getElementById('editKerjasamaForm'));
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editKerjasamaModal'));
    modal.show();
}

// Delete Kerjasama Function
function deleteKerjasama(kerjasamaId) {
    const kerjasama = kerjasamaData.find(k => k.id == kerjasamaId);
    if (!kerjasama) return;
    
    if (confirm(`Apakah Anda yakin ingin menghapus kerjasama "${kerjasama.judul}"?`)) {
        fetch(`<?= base_url('admin/kerjasama/delete') ?>/${kerjasamaId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                const row = document.querySelector(`[data-kerjasama-id="${kerjasamaId}"]`);
                if (row) {
                    row.remove();
                }
            } else {
                showAlert('danger', data.message || 'Gagal menghapus kerjasama');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat menghapus kerjasama');
        });
    }
}

// Add Kerjasama Form Handler
document.getElementById('addKerjasamaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;
    
    // Show loading
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Clear previous errors
    clearFormErrors(this);
    
    // Make API call
    fetch('<?= base_url('admin/kerjasama/create') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            const modal = bootstrap.Modal.getInstance(document.getElementById('addKerjasamaModal'));
            modal.hide();
            this.reset();
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showAlert('danger', data.message || 'Gagal menambahkan kerjasama');
            if (data.errors) {
                showFormErrors(this, data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat menambahkan kerjasama');
    })
    .finally(() => {
        submitBtn.innerHTML = originalContent;
        submitBtn.disabled = false;
    });
});

// Edit Kerjasama Form Handler
document.getElementById('editKerjasamaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const kerjasamaId = document.getElementById('edit_kerjasama_id').value;
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;
    
    // Show loading
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...';
    submitBtn.disabled = true;
    
    // Clear previous errors
    clearFormErrors(this);
    
    // Make API call
    fetch(`<?= base_url('admin/kerjasama/update') ?>/${kerjasamaId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            const modal = bootstrap.Modal.getInstance(document.getElementById('editKerjasamaModal'));
            modal.hide();
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showAlert('danger', data.message || 'Gagal memperbarui kerjasama');
            if (data.errors) {
                showFormErrors(this, data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat memperbarui kerjasama');
    })
    .finally(() => {
        submitBtn.innerHTML = originalContent;
        submitBtn.disabled = false;
    });
});

// Search and Filter Functions
document.getElementById('searchKerjasama').addEventListener('input', filterTable);
document.getElementById('filterJenis').addEventListener('change', filterTable);
document.getElementById('filterStatus').addEventListener('change', filterTable);

function filterTable() {
    const searchTerm = document.getElementById('searchKerjasama').value.toLowerCase();
    const jenisFilter = document.getElementById('filterJenis').value;
    const statusFilter = document.getElementById('filterStatus').value;
    
    const rows = document.querySelectorAll('.kerjasama-row');
    
    rows.forEach(row => {
        const judul = row.querySelector('.kerjasama-judul').textContent.toLowerCase();
        const instansi = row.querySelector('.kerjasama-instansi').textContent.toLowerCase();
        const jenis = row.querySelector('.kerjasama-jenis').textContent;
        const status = row.querySelector('.kerjasama-status').textContent.toLowerCase();
        
        const matchesSearch = judul.includes(searchTerm) || instansi.includes(searchTerm);
        const matchesJenis = !jenisFilter || jenis === jenisFilter;
        const matchesStatus = !statusFilter || status.includes(statusFilter);
        
        if (matchesSearch && matchesJenis && matchesStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function resetFilters() {
    document.getElementById('searchKerjasama').value = '';
    document.getElementById('filterJenis').value = '';
    document.getElementById('filterStatus').value = '';
    filterTable();
}

// Utility Functions
function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    alertContainer.appendChild(alert);
    
    setTimeout(() => {
        if (alert.parentNode) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}

function showFormErrors(form, errors) {
    Object.keys(errors).forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            const feedback = input.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.textContent = errors[field];
            }
        }
    });
}

function clearFormErrors(form) {
    const inputs = form.querySelectorAll('.is-invalid');
    inputs.forEach(input => {
        input.classList.remove('is-invalid');
    });
}

// Date validation
document.getElementById('tanggal_berakhir').addEventListener('change', function() {
    const startDate = document.getElementById('tanggal_mulai').value;
    const endDate = this.value;
    
    if (startDate && endDate && new Date(endDate) <= new Date(startDate)) {
        alert('Tanggal berakhir harus setelah tanggal mulai');
        this.value = '';
    }
});

document.getElementById('edit_tanggal_berakhir').addEventListener('change', function() {
    const startDate = document.getElementById('edit_tanggal_mulai').value;
    const endDate = this.value;
    
    if (startDate && endDate && new Date(endDate) <= new Date(startDate)) {
        alert('Tanggal berakhir harus setelah tanggal mulai');
        this.value = '';
    }
});
</script>
<?= $this->endSection() ?>