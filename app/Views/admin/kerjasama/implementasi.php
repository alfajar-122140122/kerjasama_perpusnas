<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Implementasi Kerjasama
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0 text-gray-800">Admin / Kelola Implementasi</h2>
        </div>
        <a href="<?= base_url('admin/kerjasama/implementasi/tambah') ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahImplementasiModal">
            <i class="fas fa-plus me-2"></i>Tambah Implementasi
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
                            <li><a class="dropdown-item" href="#" data-filter="berjalan">Sedang Berjalan</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="selesai">Selesai</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="pending">Pending</a></li>
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
                            <th>Masa Berlaku</th>
                            <th>Implementasi</th>
                            <th>Lingkup</th>
                            <th>Unit Kerja</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Sample data - nanti diganti dengan data dari database
                        $implementasiData = [
                            [
                                'id' => 1,
                                'nama_mitra' => 'Fulan',
                                'masa_berlaku_mulai' => '14/08/2025',
                                'masa_berlaku_akhir' => '15/08/2025',
                                'implementasi' => 'Pelestarian warisan dokumenter budaya Nusantara....',
                                'lingkup' => 'Dokumenter Budaya',
                                'unit_kerja' => 'Pustakawan',
                                'status' => 'berjalan'
                            ],
                            [
                                'id' => 2,
                                'nama_mitra' => 'Fulana',
                                'masa_berlaku_mulai' => '10/08/2025',
                                'masa_berlaku_akhir' => '12/08/2025',
                                'implementasi' => 'Pelestarian warisan dokumenter budaya Nusantara....',
                                'lingkup' => 'Digitalisasi Arsip',
                                'unit_kerja' => 'IT Support',
                                'status' => 'selesai'
                            ],
                            [
                                'id' => 3,
                                'nama_mitra' => 'Fulani',
                                'masa_berlaku_mulai' => '20/08/2025',
                                'masa_berlaku_akhir' => '25/08/2025',
                                'implementasi' => 'Pelestarian warisan dokumenter budaya Nusantara....',
                                'lingkup' => 'Pelatihan SDM',
                                'unit_kerja' => 'HRD',
                                'status' => 'pending'
                            ]
                        ];
                        ?>
                        
                        <?php foreach ($implementasiData as $implementasi): ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox" value="<?= $implementasi['id'] ?>">
                            </td>
                            <td><?= $implementasi['nama_mitra'] ?></td>
                            <td>
                                <small class="text-muted">
                                    <?= $implementasi['masa_berlaku_mulai'] ?> - <?= $implementasi['masa_berlaku_akhir'] ?>
                                </small>
                            </td>
                            <td>
                                <span class="text-muted"><?= substr($implementasi['implementasi'], 0, 35) ?>...</span>
                            </td>
                            <td>
                                <span class="badge bg-info"><?= $implementasi['lingkup'] ?></span>
                            </td>
                            <td>
                                <span class="badge bg-secondary"><?= $implementasi['unit_kerja'] ?></span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Edit" onclick="editImplementasi(<?= $implementasi['id'] ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="deleteImplementasi(<?= $implementasi['id'] ?>)">
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
                    Menampilkan 1-3 dari 3 data
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

// Form submission handler for Implementasi
document.getElementById('formTambahImplementasi').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate dates
    const masaBerlakuMulai = new Date(document.getElementById('masa_berlaku_mulai').value);
    const masaBerlakuAkhir = new Date(document.getElementById('masa_berlaku_akhir').value);
    const targetSelesai = new Date(document.getElementById('target_selesai').value);
    
    if (masaBerlakuAkhir <= masaBerlakuMulai) {
        alert('Masa berlaku berakhir harus lebih besar dari masa berlaku mulai!');
        return;
    }
    
    if (targetSelesai < masaBerlakuMulai) {
        alert('Target selesai tidak boleh lebih kecil dari masa berlaku mulai!');
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
        const modal = bootstrap.Modal.getInstance(document.getElementById('tambahImplementasiModal'));
        modal.hide();
        
        // Reset form
        document.getElementById('formTambahImplementasi').reset();
        
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        // Show success message
        showAlert('success', 'Data implementasi berhasil ditambahkan!');
        
        // Reload page to show new data (or use AJAX to update table)
        setTimeout(function() {
            location.reload();
        }, 1500);
    }, 2000);
});

// Reset form when modal is closed
document.getElementById('tambahImplementasiModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('formTambahImplementasi').reset();
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = 'Simpan Implementasi';
    submitBtn.disabled = false;
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