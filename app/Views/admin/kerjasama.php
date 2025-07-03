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
                            <div class="h5 mb-0" id="totalKerjasama"><?= $total_kerjasama ?? 0 ?></div>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Kerjasama Aktif</div>
                            <div class="h5 mb-0" id="progressAktif"><?= $aktif ?? 0 ?></div>
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
                            <div class="h5 mb-0" id="totalImplementasi"><?= $totalImplementasi ?? 0 ?></div>
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
                            <div class="h5 mb-0" id="totalMitra"><?= $totalMitra ?? 0 ?></div>
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
                            <th width="23%">Nama Mitra</th>
                            <th width="18%">Ruang Lingkup</th>
                            <th width="10%">Jenis</th>
                            <th width="8%">Status</th>
                            <th width="12%">Tanggal</th>
                            <th width="8%">Dokumen</th>
                            <th width="4%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($kerjasama as $item): ?>
                        <tr class="kerjasama-row" data-kerjasama-id="<?= $item['id_kerjasama'] ?>">
                            <td><?= $no++ ?></td>
                            <td class="kerjasama-judul">
                                <strong><?= esc($item['nama_mitra']) ?></strong>
                                <br><small class="text-muted"><?= esc(substr($item['ruang_lingkup'], 0, 80)) ?>...</small>
                            </td>
                            <td class="kerjasama-ruang-lingkup"><?= esc(substr($item['ruang_lingkup'], 0, 100)) ?></td>
                            <td class="kerjasama-jenis">
                                <?php if(!empty($item['jenis'])): ?>
                                <span class="badge bg-info"><?= esc($item['jenis']) ?></span>
                                <?php else: ?>
                                <span class="badge bg-secondary">Tidak Ada</span>
                                <?php endif; ?>
                            </td>
                            <td class="kerjasama-status">
                                <?php 
                                $statusClass = '';
                                switch($item['status']) {
                                    case 'aktif': $statusClass = 'success'; break;
                                    case 'selesai': $statusClass = 'primary'; break;
                                    case 'pending': $statusClass = 'warning'; break;
                                    case 'dibatalkan': $statusClass = 'danger'; break;
                                    default: $statusClass = 'secondary'; break;
                                }
                                ?>
                                <span class="badge bg-<?= $statusClass ?>"><?= ucfirst($item['status']) ?></span>
                            </td>
                            <td>
                                <small>
                                    <strong>Mulai:</strong> <?= $item['tanggal_mulai_formatted'] ?><br>
                                    <strong>Berakhir:</strong> <?= $item['tanggal_selesai_formatted'] ?>
                                </small>
                            </td>
                            <td>
                                <?php if(!empty($item['dokumen'])): ?>
                                <a href="<?= base_url('public/uploads/kerjasama') ?>/<?= $item['dokumen'] ?>" class="btn btn-sm btn-outline-info" target="_blank">
                                    <i class="fas fa-file-download me-1"></i>Lihat
                                </a>
                                <?php else: ?>
                                <span class="badge bg-secondary">Tidak Ada</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-info btn-sm" onclick="viewKerjasama(<?= $item['id_kerjasama'] ?>)" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm" onclick="editKerjasama(<?= $item['id_kerjasama'] ?>)" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteKerjasama(<?= $item['id_kerjasama'] ?>)" title="Hapus">
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
            <form id="addKerjasamaForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="nama_mitra" class="form-label">Nama Mitra <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_mitra" name="nama_mitra" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jenis" class="form-label">Jenis Kerjasama</label>
                                        <select class="form-select" id="jenis" name="jenis">
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
                                        <label for="progress" class="form-label">Status</label>
                                        <select class="form-select" id="progress" name="progress">
                                            <option value="draft">Draft</option>
                                            <option value="aktif">Aktif</option>
                                            <option value="selesai">Selesai</option>
                                            <option value="dibatalkan">Dibatalkan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ruang_lingkup" class="form-label">Ruang Lingkup <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="ruang_lingkup" name="ruang_lingkup" rows="3" required></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                                <div class="invalid-feedback"></div>
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
            <form id="editKerjasamaForm" enctype="multipart/form-data">
                <input type="hidden" id="edit_kerjasama_id" name="kerjasama_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_nama_mitra" class="form-label">Nama Mitra <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama_mitra" name="nama_mitra" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_jenis" class="form-label">Jenis Kerjasama</label>
                                <select class="form-select" id="edit_jenis" name="jenis">
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
                                <label for="edit_tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="edit_tanggal_mulai" name="tanggal_mulai">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="edit_tanggal_selesai" name="tanggal_selesai">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_progress" class="form-label">Status</label>
                                <select class="form-select" id="edit_progress" name="progress">
                                    <option value="draft">Draft</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="dibatalkan">Dibatalkan</option>
                                </select>
                                <!-- Name is still 'progress' for form compatibility, but will be mapped to 'status' in controller -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_dokumen" class="form-label">Dokumen Baru</label>
                                <input type="file" class="form-control" id="edit_dokumen" name="dokumen" accept=".pdf,.doc,.docx">
                                <small class="form-text text-muted">Format: PDF, DOC, DOCX (Max: 5MB)</small>
                                <div id="dokumen_saat_ini"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="edit_ruang_lingkup" class="form-label">Ruang Lingkup <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_ruang_lingkup" name="ruang_lingkup" rows="3" required></textarea>
                                <div class="invalid-feedback"></div>
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
<div class="modal fade" id="viewKerjasamaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="kerjasamaDetail">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Nama Mitra</th>
                                <td width="70%" id="detail_nama_mitra"></td>
                            </tr>
                            <tr>
                                <th>Jenis Kerjasama</th>
                                <td id="detail_jenis"></td>
                            </tr>
                            <tr>
                                <th>Ruang Lingkup</th>
                                <td id="detail_ruang_lingkup"></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><span id="detail_status" class="badge"></span></td>
                            </tr>
                            <tr>
                                <th>Tanggal Mulai</th>
                                <td id="detail_tanggal_mulai"></td>
                            </tr>
                            <tr>
                                <th>Tanggal Selesai</th>
                                <td id="detail_tanggal_selesai"></td>
                            </tr>
                            <tr>
                                <th>Dokumen</th>
                                <td id="detail_dokumen"></td>
                            </tr>
                            <tr>
                                <th>Tanggal Dibuat</th>
                                <td id="detail_created_at"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Implementasi</h5>
                            </div>
                            <div class="card-body">
                                <h3 id="detail_implementasi_count" class="text-center mb-3"></h3>
                                <div id="detail_implementasi_list" class="list-group">
                                    <!-- Implementasi list will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btnTambahImplementasi" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Tambah Implementasi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Implementasi Modal -->
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus kerjasama ini? Semua data terkait akan ikut terhapus.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Data kerjasama dari server
const kerjasamaData = <?= json_encode($kerjasama) ?>;
let deleteId = null;

// Format date for display
function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
}

// Show success or error alert
function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alertContainer');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    
    alertContainer.innerHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        const alert = alertContainer.querySelector('.alert');
        if (alert) {
            alert.classList.remove('show');
            setTimeout(() => alertContainer.innerHTML = '', 150);
        }
    }, 5000);
}

// Reset filters
function resetFilters() {
    document.getElementById('searchKerjasama').value = '';
    document.getElementById('filterJenis').value = '';
    document.getElementById('filterStatus').value = '';
    
    // Reload page to reset filters
    window.location.reload();
}

// View Kerjasama Function
function viewKerjasama(kerjasamaId) {
    fetch(`<?= base_url('admin/kerjasama/detail') ?>/${kerjasamaId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const kerjasama = data.data;
                
                // Set detail values
                document.getElementById('detail_nama_mitra').textContent = kerjasama.nama_mitra || '-';
                document.getElementById('detail_jenis').textContent = kerjasama.jenis || '-';
                document.getElementById('detail_ruang_lingkup').textContent = kerjasama.ruang_lingkup || '-';
                
                // Set status with appropriate badge color
                const statusBadge = document.getElementById('detail_status');
                let statusClass = '';
                switch(kerjasama.status) {
                    case 'aktif': statusClass = 'bg-success'; break;
                    case 'selesai': statusClass = 'bg-primary'; break;
                    case 'pending': statusClass = 'bg-warning'; break;
                    case 'dibatalkan': statusClass = 'bg-danger'; break;
                    default: statusClass = 'bg-secondary'; break;
                }
                statusBadge.className = `badge ${statusClass}`;
                statusBadge.textContent = kerjasama.status ? kerjasama.status.charAt(0).toUpperCase() + kerjasama.status.slice(1) : '-';
                
                // Format dates
                document.getElementById('detail_tanggal_mulai').textContent = kerjasama.tanggal_mulai_formatted || '-';
                document.getElementById('detail_tanggal_selesai').textContent = kerjasama.tanggal_selesai_formatted || '-';
                
                // Document download link if exists
                const detailDokumen = document.getElementById('detail_dokumen');
                if (kerjasama.dokumen) {
                    detailDokumen.innerHTML = `<a href="<?= base_url('public/uploads/kerjasama') ?>/${kerjasama.dokumen}" target="_blank">${kerjasama.dokumen} <i class="fas fa-download ms-1"></i></a>`;
                } else {
                    detailDokumen.textContent = 'Tidak ada dokumen';
                }
                
                // Format created date
                document.getElementById('detail_created_at').textContent = kerjasama.created_at ? formatDate(kerjasama.created_at) : '-';
                
                // Implementasi list
                const implementasiCount = document.getElementById('detail_implementasi_count');
                const implementasiList = document.getElementById('detail_implementasi_list');
                
                implementasiCount.textContent = `${data.implementasi_count} Implementasi`;
                implementasiList.innerHTML = '';
                
                if (data.implementasi && data.implementasi.length > 0) {
                    data.implementasi.forEach(impl => {
                        implementasiList.innerHTML += `
                            <a href="#" class="list-group-item list-group-item-action" onclick="viewImplementasi(${impl.id_implementasi})">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${impl.nama_kegiatan}</h5>
                                </div>
                                <small>${impl.tanggal_mulai ? formatDate(impl.tanggal_mulai) : ''} - ${impl.tanggal_selesai ? formatDate(impl.tanggal_selesai) : ''}</small>
                            </a>
                        `;
                    });
                } else {
                    implementasiList.innerHTML = '<div class="text-center p-3">Belum ada implementasi</div>';
                }
                
                // Set button for adding implementasi
                document.getElementById('btnTambahImplementasi').onclick = () => {
                    // Close current modal
                    const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewKerjasamaModal'));
                    viewModal.hide();
                    
                    // TODO: Open add implementasi modal
                    // This can be implemented separately when needed
                };
                
                // Show the modal
                const viewModal = new bootstrap.Modal(document.getElementById('viewKerjasamaModal'));
                viewModal.show();
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error fetching kerjasama details:', error);
            showAlert('Gagal memuat detail kerjasama', 'error');
        });
}

// Edit Kerjasama Function
function editKerjasama(kerjasamaId) {
    fetch(`<?= base_url('admin/kerjasama/detail') ?>/${kerjasamaId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const kerjasama = data.data;
                
                // Populate edit form
                document.getElementById('edit_kerjasama_id').value = kerjasamaId;
                document.getElementById('edit_nama_mitra').value = kerjasama.nama_mitra || '';
                document.getElementById('edit_jenis').value = kerjasama.jenis || '';
                document.getElementById('edit_tanggal_mulai').value = kerjasama.tanggal_mulai ? kerjasama.tanggal_mulai.split(' ')[0] : '';
                document.getElementById('edit_tanggal_selesai').value = kerjasama.tanggal_berakhir ? kerjasama.tanggal_berakhir.split(' ')[0] : '';
                document.getElementById('edit_progress').value = kerjasama.status || 'draft'; // Using status field from database
                document.getElementById('edit_ruang_lingkup').value = kerjasama.ruang_lingkup || '';
                
                // Show current document if exists
                const dokumenSaatIni = document.getElementById('dokumen_saat_ini');
                if (kerjasama.dokumen) {
                    dokumenSaatIni.innerHTML = `
                        <small class="text-muted mt-2 d-block">
                            Dokumen saat ini: <a href="<?= base_url('public/uploads/kerjasama') ?>/${kerjasama.dokumen}" target="_blank">${kerjasama.dokumen}</a>
                        </small>
                    `;
                } else {
                    dokumenSaatIni.innerHTML = '<small class="text-muted mt-2 d-block">Belum ada dokumen</small>';
                }
                
                // Show the edit modal
                const editModal = new bootstrap.Modal(document.getElementById('editKerjasamaModal'));
                editModal.show();
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error fetching kerjasama details:', error);
            showAlert('Gagal memuat data kerjasama untuk diedit', 'error');
        });
}

// Delete Kerjasama Function
function deleteKerjasama(kerjasamaId) {
    deleteId = kerjasamaId;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Form submission for add kerjasama
document.getElementById('addKerjasamaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('<?= base_url('admin/kerjasama/create') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message);
            
            // Hide modal
            const addModal = bootstrap.Modal.getInstance(document.getElementById('addKerjasamaModal'));
            addModal.hide();
            
            // Reset form
            this.reset();
            
            // Reload page to show new data
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showAlert(data.message, 'error');
            
            // Show validation errors if any
            if (data.errors) {
                for (const field in data.errors) {
                    const inputElement = document.querySelector(`[name="${field}"]`);
                    if (inputElement) {
                        inputElement.classList.add('is-invalid');
                        const feedback = inputElement.nextElementSibling;
                        if (feedback && feedback.classList.contains('invalid-feedback')) {
                            feedback.textContent = data.errors[field];
                        }
                    }
                }
            }
        }
    })
    .catch(error => {
        console.error('Error adding kerjasama:', error);
        showAlert('Terjadi kesalahan saat menambah kerjasama', 'error');
    });
});

// Form submission for edit kerjasama
document.getElementById('editKerjasamaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const kerjasamaId = document.getElementById('edit_kerjasama_id').value;
    
    fetch(`<?= base_url('admin/kerjasama/update') ?>/${kerjasamaId}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message);
            
            // Hide modal
            const editModal = bootstrap.Modal.getInstance(document.getElementById('editKerjasamaModal'));
            editModal.hide();
            
            // Reload page to show updated data
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showAlert(data.message, 'error');
            
            // Show validation errors if any
            if (data.errors) {
                for (const field in data.errors) {
                    const inputElement = document.querySelector(`[name="${field}"]`);
                    if (inputElement) {
                        inputElement.classList.add('is-invalid');
                        const feedback = inputElement.nextElementSibling;
                        if (feedback && feedback.classList.contains('invalid-feedback')) {
                            feedback.textContent = data.errors[field];
                        }
                    }
                }
            }
        }
    })
    .catch(error => {
        console.error('Error updating kerjasama:', error);
        showAlert('Terjadi kesalahan saat memperbarui kerjasama', 'error');
    });
});

// Confirm delete kerjasama
document.getElementById('confirmDelete').addEventListener('click', function() {
    if (!deleteId) return;
    
    fetch(`<?= base_url('admin/kerjasama/delete') ?>/${deleteId}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message);
            
            // Hide modal
            const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            deleteModal.hide();
            
            // Reload page to update data
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error deleting kerjasama:', error);
        showAlert('Terjadi kesalahan saat menghapus kerjasama', 'error');
    });
});

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    // Set statistics cards
    document.getElementById('totalKerjasama').textContent = <?= $total_kerjasama ?? 0 ?>;
    document.getElementById('progressAktif').textContent = <?= $aktif ?? 0 ?>;
    document.getElementById('totalImplementasi').textContent = <?= $totalImplementasi ?? 0 ?>;
    document.getElementById('totalMitra').textContent = <?= $totalMitra ?? 0 ?>;
    
    // Add event listeners for search and filter
    document.getElementById('searchKerjasama').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        filterTable(searchValue);
    });
    
    document.getElementById('filterJenis').addEventListener('change', function() {
        filterTable();
    });
    
    document.getElementById('filterStatus').addEventListener('change', function() {
        filterTable();
    });
    
});

// Filter table function
function filterTable() {
    const searchValue = document.getElementById('searchKerjasama').value.toLowerCase();
    const jenisFilter = document.getElementById('filterJenis').value;
    const statusFilter = document.getElementById('filterStatus').value;
    
    const rows = document.querySelectorAll('#kerjasamaTable tbody tr');
    
    rows.forEach(row => {
        const namaMitra = row.querySelector('.kerjasama-judul').textContent.toLowerCase();
        const jenis = row.querySelector('.kerjasama-jenis').textContent.toLowerCase();
        const status = row.querySelector('.kerjasama-status').textContent.toLowerCase();
        
        const matchSearch = searchValue === '' || namaMitra.includes(searchValue);
        const matchJenis = jenisFilter === '' || jenis.includes(jenisFilter.toLowerCase());
        const matchStatus = statusFilter === '' || status.includes(statusFilter.toLowerCase());
        
        if (matchSearch && matchJenis && matchStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// View implementasi function
function viewImplementasi(implementasiId) {
    fetch(`<?= base_url('admin/kerjasama/implementasi/detail') ?>/${implementasiId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Display implementasi details in the modal
                const implementasiModal = document.getElementById('implementasiDetail');
                const implementasi = data.data;
                
                let content = `
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5>${implementasi.nama_kegiatan}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Tanggal Mulai</th>
                                    <td>${implementasi.tanggal_mulai_formatted}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>${implementasi.tanggal_selesai_formatted}</td>
                                </tr>
                                <tr>
                                    <th>Lingkup Implementasi</th>
                                    <td>${implementasi.lingkup_implementasi || '-'}</td>
                                </tr>
                                <tr>
                                    <th>Hasil Kegiatan</th>
                                    <td>${implementasi.hasil_kegiatan || '-'}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `;
                
                implementasiModal.innerHTML = content;
                
                // Show the modal
                const viewModal = new bootstrap.Modal(document.getElementById('viewImplementasiModal'));
                viewModal.show();
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error fetching implementasi details:', error);
            showAlert('Gagal memuat detail implementasi', 'error');
        });
}
</script>


<?= $this->endSection() ?>