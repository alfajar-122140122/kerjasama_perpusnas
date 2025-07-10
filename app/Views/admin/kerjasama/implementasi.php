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
        <a href="<?= base_url('admin/kerjasama/implementasi/tambah') ?>" class="btn btn-success">
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