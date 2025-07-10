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
        <a href="<?= base_url('admin/kerjasama/implementasi/tambah') ?>" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Tambah Implementasi
        </a>
    </div>

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

<!-- Modal Tambah Implementasi -->
<div class="modal fade" id="tambahImplementasiModal" tabindex="-1" aria-labelledby="tambahImplementasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahImplementasiModalLabel">Tambah Implementasi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahImplementasi" method="POST" action="<?= base_url('admin/kerjasama/implementasi/store') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_mitra" class="form-label">Nama Mitra</label>
                            <select class="form-select" id="nama_mitra" name="nama_mitra" required>
                                <option value="">Pilih Mitra Kerjasama</option>
                                <option value="Fulan">Fulan</option>
                                <option value="Fulana">Fulana</option>
                                <option value="Fulani">Fulani</option>
                                <option value="Fulano">Fulano</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lingkup" class="form-label">Lingkup</label>
                            <select class="form-select" id="lingkup" name="lingkup" required>
                                <option value="">Pilih Lingkup</option>
                                <option value="Dokumenter Budaya">Dokumenter Budaya</option>
                                <option value="Digitalisasi Arsip">Digitalisasi Arsip</option>
                                <option value="Pelatihan SDM">Pelatihan SDM</option>
                                <option value="Penelitian">Penelitian</option>
                                <option value="Pengembangan Teknologi">Pengembangan Teknologi</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="implementasi" class="form-label">Deskripsi Implementasi</label>
                        <textarea class="form-control" id="implementasi" name="implementasi" rows="3" placeholder="Masukkan deskripsi implementasi..." required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="masa_berlaku_mulai" class="form-label">Masa Berlaku Mulai</label>
                            <input type="date" class="form-control" id="masa_berlaku_mulai" name="masa_berlaku_mulai" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="masa_berlaku_akhir" class="form-label">Masa Berlaku Berakhir</label>
                            <input type="date" class="form-control" id="masa_berlaku_akhir" name="masa_berlaku_akhir" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="unit_kerja" class="form-label">Unit Kerja</label>
                            <select class="form-select" id="unit_kerja" name="unit_kerja" required>
                                <option value="">Pilih Unit Kerja</option>
                                <option value="Pustakawan">Pustakawan</option>
                                <option value="IT Support">IT Support</option>
                                <option value="HRD">HRD</option>
                                <option value="Research">Research</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="pending">Pending</option>
                                <option value="berjalan">Sedang Berjalan</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditunda">Ditunda</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pic_implementasi" class="form-label">PIC Implementasi</label>
                            <input type="text" class="form-control" id="pic_implementasi" name="pic_implementasi" placeholder="Nama PIC yang bertanggung jawab" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="target_selesai" class="form-label">Target Selesai</label>
                            <input type="date" class="form-control" id="target_selesai" name="target_selesai" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="catatan_implementasi" class="form-label">Catatan</label>
                        <textarea class="form-control" id="catatan_implementasi" name="catatan_implementasi" rows="2" placeholder="Catatan implementasi (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Implementasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Select All Checkbox
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach(row => {
        const namaMitra = row.cells[1].textContent.toLowerCase();
        const implementasi = row.cells[3].textContent.toLowerCase();
        const unitKerja = row.cells[5].textContent.toLowerCase();
        
        if (namaMitra.includes(searchTerm) || implementasi.includes(searchTerm) || unitKerja.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filter functionality
document.querySelectorAll('[data-filter]').forEach(filterBtn => {
    filterBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const filter = this.dataset.filter;
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            if (filter === 'all') {
                row.style.display = '';
            } else {
                // Filter berdasarkan status (contoh implementasi filter)
                const rowData = row.getAttribute('data-status') || 'berjalan';
                if (rowData === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
        
        // Update filter button text
        document.getElementById('filterDropdown').innerHTML = `<i class="fas fa-filter me-2"></i>${this.textContent}`;
    });
});

// Edit function
function editImplementasi(id) {
    window.location.href = `<?= base_url('admin/kerjasama/implementasi/edit/') ?>${id}`;
}

// Delete function
function deleteImplementasi(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data implementasi ini?')) {
        // Add AJAX delete request here
        console.log('Deleting implementasi with ID:', id);
        showAlert('success', 'Data implementasi berhasil dihapus');
    }
}
</script>
<?= $this->endSection() ?>
