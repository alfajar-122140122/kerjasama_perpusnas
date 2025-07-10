<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Data Kerjasama
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0 text-gray-800">Admin / Kelola Kerjasama</h2>
        </div>
        <a href="<?= base_url('admin/kerjasama/tambah') ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahKerjasamaModal">
            <i class="fas fa-plus me-2"></i>Tambah Kerjasama
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Search and Filter -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari Data" id="searchInput">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-filter="all">Semua</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="aktif">Aktif</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="berakhir">Akan Berakhir</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>Nama Mitra</th>
                            <th>Lingkup</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                // Sample data - nanti diganti dengan data dari database
                $kerjasamaData = [
                    [
                        'id' => 1,
                        'nama_mitra' => 'Fulan',
                        'lingkup' => 'Pelestarian warisan dokumenter budaya Nusantara dan pengembangan sistem informasi perpustakaan digital untuk mendukung akses informasi yang lebih luas',
                        'tanggal_mulai' => '14/08/2025',
                        'tanggal_berakhir' => '14/08/2026',
                        'status' => 'aktif'
                    ],
                    [
                        'id' => 2,
                        'nama_mitra' => 'Fulana',
                        'lingkup' => 'Pelestarian warisan dokumenter budaya Nusantara dan digitalisasi koleksi naskah kuno untuk kepentingan penelitian dan edukasi',
                        'tanggal_mulai' => '13/08/2025',
                        'tanggal_berakhir' => '13/08/2026',
                        'status' => 'aktif'
                    ],
                    [
                        'id' => 3,
                        'nama_mitra' => 'Fulani',
                        'lingkup' => 'Pelestarian warisan dokumenter budaya Nusantara dan pengembangan program literasi masyarakat melalui inovasi teknologi informasi',
                        'tanggal_mulai' => '10/08/2025',
                        'tanggal_berakhir' => '10/08/2026',
                        'status' => 'aktif'
                    ],
                    [
                        'id' => 4,
                        'nama_mitra' => 'Fulano',
                        'lingkup' => 'Pelestarian warisan dokumenter budaya Nusantara dan kolaborasi dalam pengembangan repository digital untuk arsip nasional',
                        'tanggal_mulai' => '05/08/2025',
                        'tanggal_berakhir' => '05/08/2026',
                        'status' => 'aktif'
                    ]
                ];
                        ?>
                        
                        <?php foreach ($kerjasamaData as $kerjasama): ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox" value="<?= $kerjasama['id'] ?>">
                            </td>
                            <td><?= $kerjasama['nama_mitra'] ?></td>
                            <td>
                                <span class="text-muted"><?= substr($kerjasama['lingkup'], 0, 50) ?>...</span>
                            </td>
                            <td><?= $kerjasama['tanggal_mulai'] ?></td>
                            <td><?= $kerjasama['tanggal_berakhir'] ?></td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Edit" onclick="editKerjasama(<?= $kerjasama['id'] ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="deleteKerjasama(<?= $kerjasama['id'] ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan 1-4 dari 4 data
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">Next</span>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kerjasama -->
<div class="modal fade" id="tambahKerjasamaModal" tabindex="-1" aria-labelledby="tambahKerjasamaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKerjasamaModalLabel">Tambah Kerjasama Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahKerjasama" method="POST" action="<?= base_url('admin/kerjasama/store') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_mitra" class="form-label">Nama Mitra</label>
                            <input type="text" class="form-control" id="nama_mitra" name="nama_mitra" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kerjasama" class="form-label">Jenis Kerjasama</label>
                            <select class="form-select" id="jenis_kerjasama" name="jenis_kerjasama" required>
                                <option value="">Pilih Jenis Kerjasama</option>
                                <option value="MoU">MoU (Memorandum of Understanding)</option>
                                <option value="PKS">PKS (Perjanjian Kerjasama)</option>
                                <option value="IA">IA (Implementation Agreement)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="lingkup" class="form-label">Lingkup Kerjasama</label>
                        <textarea class="form-control" id="lingkup" name="lingkup" rows="3" placeholder="Masukkan lingkup kerjasama..." required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                            <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pic_internal" class="form-label">PIC Internal</label>
                            <input type="text" class="form-control" id="pic_internal" name="pic_internal" placeholder="Nama PIC dari Perpusnas" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pic_eksternal" class="form-label">PIC Eksternal</label>
                            <input type="text" class="form-control" id="pic_eksternal" name="pic_eksternal" placeholder="Nama PIC dari Mitra" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="draft">Draft</option>
                            <option value="aktif">Aktif</option>
                            <option value="pending">Pending</option>
                            <option value="berakhir">Berakhir</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="2" placeholder="Catatan tambahan (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Kerjasama</button>
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
    const tableRows = document.querySelectorAll('#kerjasamaTableBody tr');
    
    tableRows.forEach(row => {
        const namaMitra = row.cells[1].textContent.toLowerCase();
        const lingkup = row.cells[2].textContent.toLowerCase();
        
        if (namaMitra.includes(searchTerm) || lingkup.includes(searchTerm)) {
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
        const tableRows = document.querySelectorAll('#kerjasamaTableBody tr');
        
        tableRows.forEach(row => {
            if (filter === 'all') {
                row.style.display = '';
            } else {
                // Add filter logic based on your data structure
                row.style.display = '';
            }
        });
        
        // Update filter button text
        document.getElementById('filterDropdown').innerHTML = `<i class="fas fa-filter me-2"></i>${this.textContent}`;
    });
});

// Form submission handler
document.getElementById('formTambahKerjasama').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate dates
    const tanggalMulai = new Date(document.getElementById('tanggal_mulai').value);
    const tanggalBerakhir = new Date(document.getElementById('tanggal_berakhir').value);
    
    if (tanggalBerakhir <= tanggalMulai) {
        alert('Tanggal berakhir harus lebih besar dari tanggal mulai!');
        return;
    }
    
    // Show loading
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Simulate form submission (replace with actual AJAX call)
    setTimeout(function() {
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('tambahKerjasamaModal'));
        modal.hide();
        
        // Reset form
        document.getElementById('formTambahKerjasama').reset();
        
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        // Show success message
        showAlert('success', 'Data kerjasama berhasil ditambahkan!');
        
        // Reload page to show new data (or use AJAX to update table)
        setTimeout(function() {
            location.reload();
        }, 1500);
    }, 2000);
});

// Reset form when modal is closed
document.getElementById('tambahKerjasamaModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('formTambahKerjasama').reset();
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = 'Simpan Kerjasama';
    submitBtn.disabled = false;
});

// Functions for table actions
function viewKerjasama(id) {
    window.location.href = `<?= base_url('admin/kerjasama/view/') ?>${id}`;
}

function editKerjasama(id) {
    window.location.href = `<?= base_url('admin/kerjasama/edit/') ?>${id}`;
}

function deleteKerjasama(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data kerjasama ini?')) {
        // Add AJAX delete request here
        console.log('Deleting kerjasama with ID:', id);
        showAlert('success', 'Data kerjasama berhasil dihapus');
    }
}
</script>
<?= $this->endSection() ?>