<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Berita<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen Berita<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <h2 class="page-title">Manajemen Berita</h2>
            <p class="text-muted mb-4">Kelola artikel berita dan publikasi Perpustakaan Nasional</p>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Berita</div>
                            <div class="h5 mb-0"><?= $total_berita ?></div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-newspaper fa-2x"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Published</div>
                            <div class="h5 mb-0"><?= $published ?></div>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Draft</div>
                            <div class="h5 mb-0"><?= $draft ?></div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-edit fa-2x"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Views</div>
                            <div class="h5 mb-0"><?= number_format($total_views) ?></div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-eye fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Berita</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBeritaModal">
                <i class="fas fa-plus me-2"></i>Tambah Berita
            </button>
        </div>
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchBerita" placeholder="Cari berita...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterKategori">
                        <option value="">Semua Kategori</option>
                        <option value="Program">Program</option>
                        <option value="Kerjasama">Kerjasama</option>
                        <option value="Pelatihan">Pelatihan</option>
                        <option value="Teknologi">Teknologi</option>
                        <option value="Pengumuman">Pengumuman</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
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
                <table class="table table-bordered" id="beritaTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Judul</th>
                            <th width="15%">Kategori</th>
                            <th width="10%">Status</th>
                            <th width="10%">Tanggal</th>
                            <th width="10%">Penulis</th>
                            <th width="8%">Views</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($berita as $item): ?>
                        <tr class="berita-row" data-berita-id="<?= $item['id'] ?>">
                            <td><?= $no++ ?></td>
                            <td class="berita-judul">
                                <strong><?= esc($item['judul']) ?></strong>
                                <br><small class="text-muted"><?= esc(substr($item['ringkasan'], 0, 60)) ?>...</small>
                            </td>
                            <td class="berita-kategori">
                                <span class="badge bg-secondary"><?= esc($item['kategori']) ?></span>
                            </td>
                            <td class="berita-status">
                                <?php 
                                $statusClass = $item['status'] === 'published' ? 'success' : 'warning';
                                ?>
                                <span class="badge bg-<?= $statusClass ?>"><?= ucfirst($item['status']) ?></span>
                            </td>
                            <td>
                                <small><?= date('d/m/Y', strtotime($item['tanggal_publish'])) ?></small>
                            </td>
                            <td><?= esc($item['penulis']) ?></td>
                            <td>
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i><?= number_format($item['views']) ?>
                                </small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-info btn-sm" onclick="viewBerita(<?= $item['id'] ?>)" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm" onclick="editBerita(<?= $item['id'] ?>)" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-<?= $item['status'] === 'published' ? 'secondary' : 'success' ?> btn-sm" 
                                            onclick="toggleStatus(<?= $item['id'] ?>, '<?= $item['status'] === 'published' ? 'draft' : 'published' ?>')" 
                                            title="<?= $item['status'] === 'published' ? 'Unpublish' : 'Publish' ?>">
                                        <i class="fas fa-<?= $item['status'] === 'published' ? 'eye-slash' : 'check' ?>"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteBerita(<?= $item['id'] ?>)" title="Hapus">
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

<!-- Add Berita Modal -->
<div class="modal fade" id="addBeritaModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Berita Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addBeritaForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="ringkasan" class="form-label">Ringkasan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="ringkasan" name="ringkasan" rows="3" required></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="konten" class="form-label">Konten <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="konten" name="konten" rows="8" required></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Program">Program</option>
                                    <option value="Kerjasama">Kerjasama</option>
                                    <option value="Pelatihan">Pelatihan</option>
                                    <option value="Teknologi">Teknologi</option>
                                    <option value="Pengumuman">Pengumuman</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_publish" class="form-label">Tanggal Publish</label>
                                <input type="date" class="form-control" id="tanggal_publish" name="tanggal_publish" value="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="mb-3">
                                <label for="penulis" class="form-label">Penulis <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="penulis" name="penulis" value="<?= session()->get('name') ?>" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" class="form-control" id="tags" name="tags" placeholder="Pisahkan dengan koma">
                                <small class="form-text text-muted">Contoh: teknologi, digital, perpustakaan</small>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                <small class="form-text text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
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

<!-- Edit Berita Modal -->
<div class="modal fade" id="editBeritaModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editBeritaForm">
                <input type="hidden" id="edit_berita_id" name="berita_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="edit_judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_judul" name="judul" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_ringkasan" class="form-label">Ringkasan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_ringkasan" name="ringkasan" rows="3" required></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_konten" class="form-label">Konten <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_konten" name="konten" rows="8" required></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_kategori" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Program">Program</option>
                                    <option value="Kerjasama">Kerjasama</option>
                                    <option value="Pelatihan">Pelatihan</option>
                                    <option value="Teknologi">Teknologi</option>
                                    <option value="Pengumuman">Pengumuman</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select class="form-select" id="edit_status" name="status">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_tanggal_publish" class="form-label">Tanggal Publish</label>
                                <input type="date" class="form-control" id="edit_tanggal_publish" name="tanggal_publish">
                            </div>
                            <div class="mb-3">
                                <label for="edit_penulis" class="form-label">Penulis <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_penulis" name="penulis" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_tags" class="form-label">Tags</label>
                                <input type="text" class="form-control" id="edit_tags" name="tags" placeholder="Pisahkan dengan koma">
                                <small class="form-text text-muted">Contoh: teknologi, digital, perpustakaan</small>
                            </div>
                            <div class="mb-3">
                                <label for="edit_gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="edit_gambar" name="gambar" accept="image/*">
                                <small class="form-text text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                                <div id="current_image"></div>
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

<!-- View Berita Modal -->
<div class="modal fade" id="viewBeritaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="beritaDetail">
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
// Data berita dari server
const beritaData = <?= json_encode($berita) ?>;

// View Berita Function
function viewBerita(beritaId) {
    const berita = beritaData.find(b => b.id == beritaId);
    if (!berita) {
        alert('Data berita tidak ditemukan');
        return;
    }
    
    const detailHtml = `
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-primary mb-3">${berita.judul}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><i class="fas fa-folder text-muted me-2"></i><strong>Kategori:</strong></td>
                        <td><span class="badge bg-secondary">${berita.kategori}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-info-circle text-muted me-2"></i><strong>Status:</strong></td>
                        <td><span class="badge bg-${berita.status === 'published' ? 'success' : 'warning'}">${berita.status.toUpperCase()}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-user text-muted me-2"></i><strong>Penulis:</strong></td>
                        <td>${berita.penulis}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-eye text-muted me-2"></i><strong>Views:</strong></td>
                        <td>${berita.views.toLocaleString()}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><i class="fas fa-calendar-alt text-muted me-2"></i><strong>Tanggal Publish:</strong></td>
                        <td>${new Date(berita.tanggal_publish).toLocaleDateString('id-ID')}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-clock text-muted me-2"></i><strong>Dibuat:</strong></td>
                        <td>${new Date(berita.created_at).toLocaleDateString('id-ID')}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-tags text-muted me-2"></i><strong>Tags:</strong></td>
                        <td>${berita.tags || 'Tidak ada'}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-link text-muted me-2"></i><strong>Slug:</strong></td>
                        <td><code>${berita.slug}</code></td>
                    </tr>
                </table>
            </div>
        </div>
        ${berita.gambar ? `
        <div class="row">
            <div class="col-md-12">
                <hr>
                <h6><i class="fas fa-image text-muted me-2"></i>Gambar:</h6>
                <img src="<?= base_url('uploads/berita/') ?>${berita.gambar}" class="img-fluid rounded" style="max-height: 300px;">
            </div>
        </div>
        ` : ''}
        <div class="row">
            <div class="col-md-12">
                <hr>
                <h6><i class="fas fa-align-left text-muted me-2"></i>Ringkasan:</h6>
                <p class="text-muted">${berita.ringkasan}</p>
                <h6><i class="fas fa-file-text text-muted me-2"></i>Konten:</h6>
                <div class="border p-3 rounded bg-light">
                    ${berita.konten.replace(/\n/g, '<br>')}
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('beritaDetail').innerHTML = detailHtml;
    const modal = new bootstrap.Modal(document.getElementById('viewBeritaModal'));
    modal.show();
}

// Edit Berita Function
function editBerita(beritaId) {
    const berita = beritaData.find(b => b.id == beritaId);
    if (!berita) {
        alert('Data berita tidak ditemukan');
        return;
    }
    
    // Populate form
    document.getElementById('edit_berita_id').value = berita.id;
    document.getElementById('edit_judul').value = berita.judul;
    document.getElementById('edit_kategori').value = berita.kategori;
    document.getElementById('edit_ringkasan').value = berita.ringkasan;
    document.getElementById('edit_konten').value = berita.konten;
    document.getElementById('edit_status').value = berita.status;
    document.getElementById('edit_tanggal_publish').value = berita.tanggal_publish;
    document.getElementById('edit_penulis').value = berita.penulis;
    document.getElementById('edit_tags').value = berita.tags || '';
    
    // Show current image if exists
    const currentImageDiv = document.getElementById('current_image');
    if (berita.gambar) {
        currentImageDiv.innerHTML = `
            <div class="mt-2">
                <small class="text-muted">Gambar saat ini:</small><br>
                <img src="<?= base_url('uploads/berita/') ?>${berita.gambar}" class="img-thumbnail" style="max-width: 150px;">
            </div>
        `;
    } else {
        currentImageDiv.innerHTML = '';
    }
    
    // Clear previous errors
    clearFormErrors(document.getElementById('editBeritaForm'));
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editBeritaModal'));
    modal.show();
}

// Delete Berita Function
function deleteBerita(beritaId) {
    const berita = beritaData.find(b => b.id == beritaId);
    if (!berita) return;
    
    if (confirm(`Apakah Anda yakin ingin menghapus berita "${berita.judul}"?`)) {
        fetch(`<?= base_url('admin/berita/delete') ?>/${beritaId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                const row = document.querySelector(`[data-berita-id="${beritaId}"]`);
                if (row) {
                    row.remove();
                }
            } else {
                showAlert('danger', data.message || 'Gagal menghapus berita');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat menghapus berita');
        });
    }
}

// Toggle Status Function
function toggleStatus(beritaId, newStatus) {
    const actionText = newStatus === 'published' ? 'mempublish' : 'mengubah ke draft';
    
    if (confirm(`Apakah Anda yakin ingin ${actionText} berita ini?`)) {
        fetch(`<?= base_url('admin/berita/toggle-status') ?>/${beritaId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `status=${newStatus}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showAlert('danger', data.message || 'Gagal mengubah status berita');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat mengubah status berita');
        });
    }
}

// Add Berita Form Handler
document.getElementById('addBeritaForm').addEventListener('submit', function(e) {
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
    fetch('<?= base_url('admin/berita/create') ?>', {
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('addBeritaModal'));
            modal.hide();
            this.reset();
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showAlert('danger', data.message || 'Gagal menambahkan berita');
            if (data.errors) {
                showFormErrors(this, data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat menambahkan berita');
    })
    .finally(() => {
        submitBtn.innerHTML = originalContent;
        submitBtn.disabled = false;
    });
});

// Edit Berita Form Handler
document.getElementById('editBeritaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const beritaId = document.getElementById('edit_berita_id').value;
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;
    
    // Show loading
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...';
    submitBtn.disabled = true;
    
    // Clear previous errors
    clearFormErrors(this);
    
    // Make API call
    fetch(`<?= base_url('admin/berita/update') ?>/${beritaId}`, {
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('editBeritaModal'));
            modal.hide();
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showAlert('danger', data.message || 'Gagal memperbarui berita');
            if (data.errors) {
                showFormErrors(this, data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat memperbarui berita');
    })
    .finally(() => {
        submitBtn.innerHTML = originalContent;
        submitBtn.disabled = false;
    });
});

// Search and Filter Functions
document.getElementById('searchBerita').addEventListener('input', filterTable);
document.getElementById('filterKategori').addEventListener('change', filterTable);
document.getElementById('filterStatus').addEventListener('change', filterTable);

function filterTable() {
    const searchTerm = document.getElementById('searchBerita').value.toLowerCase();
    const kategoriFilter = document.getElementById('filterKategori').value;
    const statusFilter = document.getElementById('filterStatus').value;
    
    const rows = document.querySelectorAll('.berita-row');
    
    rows.forEach(row => {
        const judul = row.querySelector('.berita-judul').textContent.toLowerCase();
        const kategori = row.querySelector('.berita-kategori').textContent;
        const status = row.querySelector('.berita-status').textContent.toLowerCase();
        
        const matchesSearch = judul.includes(searchTerm);
        const matchesKategori = !kategoriFilter || kategori === kategoriFilter;
        const matchesStatus = !statusFilter || status.includes(statusFilter);
        
        if (matchesSearch && matchesKategori && matchesStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function resetFilters() {
    document.getElementById('searchBerita').value = '';
    document.getElementById('filterKategori').value = '';
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
</script>
<?= $this->endSection() ?>