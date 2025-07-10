<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Progress Kerjasama
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0 text-gray-800">Admin / Kelola Progress Kerja Sama</h2>
        </div>
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
                            <li><a class="dropdown-item" href="#" data-filter="Baru">Baru</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="Perpanjangan">Perpanjangan</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="Dokumentasi">Dokumentasi</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="Finishing">Finishing</a></li>
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
                            <th>Tanggal Pengajuan</th>
                            <th>Nama Mitra</th>
                            <th>Jenis</th>
                            <th>Progress</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Sample data - nanti diganti dengan data dari database
                        $progressData = [
                            [
                                'id' => 1,
                                'tanggal_pengajuan' => '14 Juli 2025',
                                'nama_mitra' => 'Fulan',
                                'jenis' => 'Baru',
                                'progress' => 'Dokumentasi',
                                'status' => 'progress'
                            ],
                            [
                                'id' => 2,
                                'tanggal_pengajuan' => '16 Juli 2025',
                                'nama_mitra' => 'Fulan',
                                'jenis' => 'Perpanjangan',
                                'progress' => 'Finishing',
                                'status' => 'progress'
                            ]
                        ];
                        ?>
                        
                        <?php foreach ($progressData as $progress): ?>
                        <tr data-jenis="<?= $progress['jenis'] ?>">
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox" value="<?= $progress['id'] ?>">
                            </td>
                            <td><?= $progress['tanggal_pengajuan'] ?></td>
                            <td><?= $progress['nama_mitra'] ?></td>
                            <td>
                                <?php
                                $badgeClass = '';
                                switch($progress['jenis']) {
                                    case 'Baru':
                                        $badgeClass = 'bg-success';
                                        break;
                                    case 'Perpanjangan':
                                        $badgeClass = 'bg-info';
                                        break;
                                    case 'Dokumentasi':
                                        $badgeClass = 'bg-warning';
                                        break;
                                    case 'Finishing':
                                        $badgeClass = 'bg-primary';
                                        break;
                                    default:
                                        $badgeClass = 'bg-secondary';
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= $progress['jenis'] ?></span>
                            </td>
                            <td>
                                <?php
                                $progressBadgeClass = '';
                                switch($progress['progress']) {
                                    case 'Dokumentasi':
                                        $progressBadgeClass = 'bg-warning text-dark';
                                        break;
                                    case 'Finishing':
                                        $progressBadgeClass = 'bg-success';
                                        break;
                                    case 'Review':
                                        $progressBadgeClass = 'bg-info';
                                        break;
                                    case 'Approval':
                                        $progressBadgeClass = 'bg-primary';
                                        break;
                                    default:
                                        $progressBadgeClass = 'bg-secondary';
                                }
                                ?>
                                <span class="badge <?= $progressBadgeClass ?>"><?= $progress['progress'] ?></span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Edit" onclick="editProgress(<?= $progress['id'] ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="deleteProgress(<?= $progress['id'] ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Empty State (jika tidak ada data) -->
            <?php if (empty($progressData)): ?>
            <div class="text-center py-5">
                <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada data progress</h5>
                <p class="text-muted">Belum ada progress kerjasama yang tercatat.</p>
            </div>
            <?php endif; ?>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan 1-2 dari 2 data
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
        const namaMitra = row.cells[2].textContent.toLowerCase();
        const jenis = row.cells[3].textContent.toLowerCase();
        const progress = row.cells[4].textContent.toLowerCase();
        
        if (namaMitra.includes(searchTerm) || jenis.includes(searchTerm) || progress.includes(searchTerm)) {
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
                const jenis = row.dataset.jenis;
                if (jenis === filter) {
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
function editProgress(id) {
    window.location.href = `<?= base_url('admin/kerjasama/progress/edit/') ?>${id}`;
}

// Delete function
function deleteProgress(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data progress ini?')) {
        // Add AJAX delete request here
        console.log('Deleting progress with ID:', id);
        showAlert('success', 'Data progress berhasil dihapus');
    }
}
</script>
<?= $this->endSection() ?>