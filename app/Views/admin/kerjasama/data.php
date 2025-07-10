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
        <a href="<?= base_url('admin/kerjasama/tambah') ?>" class="btn btn-success">
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
                                'lingkup' => 'Pelestarian warisan dokumenter budaya Nusantara....',
                                'tanggal_mulai' => '14/08/2025',
                                'tanggal_berakhir' => '14/08/2026',
                                'status' => 'aktif'
                            ],
                            [
                                'id' => 2,
                                'nama_mitra' => 'Fulana',
                                'lingkup' => 'Pelestarian warisan dokumenter budaya Nusantara....',
                                'tanggal_mulai' => '13/08/2025',
                                'tanggal_berakhir' => '13/08/2026',
                                'status' => 'aktif'
                            ],
                            [
                                'id' => 3,
                                'nama_mitra' => 'Fulani',
                                'lingkup' => 'Pelestarian warisan dokumenter budaya Nusantara....',
                                'tanggal_mulai' => '10/08/2025',
                                'tanggal_berakhir' => '10/08/2026',
                                'status' => 'aktif'
                            ],
                            [
                                'id' => 4,
                                'nama_mitra' => 'Fulano',
                                'lingkup' => 'Pelestarian warisan dokumenter budaya Nusantara....',
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
        const tableRows = document.querySelectorAll('tbody tr');
        
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

// Edit function
function editKerjasama(id) {
    window.location.href = `<?= base_url('admin/kerjasama/edit/') ?>${id}`;
}

// Delete function
function deleteKerjasama(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data kerjasama ini?')) {
        // Add AJAX delete request here
        console.log('Deleting kerjasama with ID:', id);
        showAlert('success', 'Data kerjasama berhasil dihapus');
    }
}
</script>
<?= $this->endSection() ?>