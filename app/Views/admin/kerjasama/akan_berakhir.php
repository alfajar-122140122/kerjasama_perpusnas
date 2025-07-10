<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Kerjasama Akan Berakhir
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0 text-gray-800">Admin / Kelola Kerja Sama yang Akan Berakhir</h2>
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
                            <li><a class="dropdown-item" href="#" data-filter="30-hari">30 Hari Lagi</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="60-hari">60 Hari Lagi</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="90-hari">90 Hari Lagi</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
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
                        $akanBerakhirData = [
                            [
                                'id' => 1,
                                'nama_mitra' => 'Fulan',
                                'lingkup' => 'Pelestarian warisan dokumenter budaya Nusantara....',
                                'tanggal_mulai' => '14/08/2025',
                                'tanggal_berakhir' => '14/08/2026',
                                'status' => 'akan-berakhir',
                                'sisa_hari' => 30
                            ],
                            [
                                'id' => 2,
                                'nama_mitra' => 'Fulana',
                                'lingkup' => 'Pelestarian warisan dokumenter budaya Nusantara....',
                                'tanggal_mulai' => '13/08/2025',
                                'tanggal_berakhir' => '13/08/2026',
                                'status' => 'akan-berakhir',
                                'sisa_hari' => 31
                            ]
                        ];
                        ?>
                        
                        <?php foreach ($akanBerakhirData as $kerjasama): ?>
                        <tr data-sisa-hari="<?= $kerjasama['sisa_hari'] ?>">
                            <td><?= $kerjasama['nama_mitra'] ?></td>
                            <td>
                                <span class="text-muted"><?= substr($kerjasama['lingkup'], 0, 50) ?>...</span>
                            </td>
                            <td><?= $kerjasama['tanggal_mulai'] ?></td>
                            <td>
                                <span class="text-danger fw-bold"><?= $kerjasama['tanggal_berakhir'] ?></span>
                                <br>
                                <small class="text-warning">
                                    <i class="fas fa-clock me-1"></i><?= $kerjasama['sisa_hari'] ?> hari lagi
                                </small>
                            </td>
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

            <!-- Empty State (jika tidak ada data) -->
            <?php if (empty($akanBerakhirData)): ?>
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada kerjasama yang akan berakhir</h5>
                <p class="text-muted">Semua kerjasama masih dalam masa berlaku yang aman.</p>
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

    <!-- Alert Card untuk Notifikasi -->
    <div class="card border-warning mb-4">
        <div class="card-header bg-warning text-dark">
            <h6 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Peringatan Kerjasama</h6>
        </div>
        <div class="card-body">
            <p class="mb-2"><strong>Tindakan yang perlu dilakukan:</strong></p>
            <ul class="mb-0">
                <li>Hubungi mitra untuk perpanjangan kerjasama</li>
                <li>Siapkan dokumen perpanjangan</li>
                <li>Evaluasi kinerja kerjasama yang berjalan</li>
                <li>Tentukan apakah kerjasama akan diperpanjang atau diakhiri</li>
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach(row => {
        const namaMitra = row.cells[0].textContent.toLowerCase();
        const lingkup = row.cells[1].textContent.toLowerCase();
        
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
            const sisaHari = parseInt(row.dataset.sisaHari);
            
            if (filter === 'all') {
                row.style.display = '';
            } else if (filter === '30-hari' && sisaHari <= 30) {
                row.style.display = '';
            } else if (filter === '60-hari' && sisaHari <= 60) {
                row.style.display = '';
            } else if (filter === '90-hari' && sisaHari <= 90) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
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

// Auto highlight rows berdasarkan sisa hari
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach(row => {
        const sisaHari = parseInt(row.dataset.sisaHari);
        
        if (sisaHari <= 30) {
            row.classList.add('table-danger');
        } else if (sisaHari <= 60) {
            row.classList.add('table-warning');
        }
    });
});
</script>
<?= $this->endSection() ?>