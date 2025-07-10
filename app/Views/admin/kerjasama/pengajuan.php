<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Pengajuan Kerjasama
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0 text-gray-800">Admin / Kelola Pengajuan Kerja Sama</h2>
        </div>
    </div>

    <!-- Status Summary Card -->
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Pending</div>
                            <div class="h5">1</div>
                        </div>
                        <div><i class="fas fa-clock fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Review</div>
                            <div class="h5">1</div>
                        </div>
                        <div><i class="fas fa-search fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Approved</div>
                            <div class="h5">1</div>
                        </div>
                        <div><i class="fas fa-check fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Rejected</div>
                            <div class="h5">0</div>
                        </div>
                        <div><i class="fas fa-times fa-2x"></i></div>
                    </div>
                </div>
            </div>
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
                            <li><a class="dropdown-item" href="#" data-filter="MOU">MOU</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="PKS">PKS</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="IA">IA</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Jenis Permohonan</th>
                            <th>Lembaga</th>
                            <th>Unit Terkait</th>
                            <th>Kontak</th>
                            <th>Upload Formulir</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Sample data - nanti diganti dengan data dari database
                        $pengajuanData = [
                            [
                                'id' => 1,
                                'jenis_permohonan' => 'MOU',
                                'lembaga' => 'Fulan',
                                'unit_terkait' => 'Pusat Data dan Informasi',
                                'kontak' => '+6284021064',
                                'upload_formulir' => 'formulir_pengajuan_001.pdf',
                                'status' => 'pending'
                            ],
                            [
                                'id' => 2,
                                'jenis_permohonan' => 'PKS',
                                'lembaga' => 'Fulana Institute',
                                'unit_terkait' => 'Bagian Kerjasama',
                                'kontak' => '+6281234567890',
                                'upload_formulir' => 'formulir_pengajuan_002.pdf',
                                'status' => 'review'
                            ],
                            [
                                'id' => 3,
                                'jenis_permohonan' => 'IA',
                                'lembaga' => 'Fulani Corporation',
                                'unit_terkait' => 'Divisi Teknologi',
                                'kontak' => '+6287654321098',
                                'upload_formulir' => 'formulir_pengajuan_003.pdf',
                                'status' => 'approved'
                            ]
                        ];
                        ?>
                        
                        <?php foreach ($pengajuanData as $pengajuan): ?>
                        <tr data-jenis="<?= $pengajuan['jenis_permohonan'] ?>">
                            <td>
                                <?php
                                $badgeClass = '';
                                switch($pengajuan['jenis_permohonan']) {
                                    case 'MOU':
                                        $badgeClass = 'bg-primary';
                                        break;
                                    case 'PKS':
                                        $badgeClass = 'bg-success';
                                        break;
                                    case 'IA':
                                        $badgeClass = 'bg-info';
                                        break;
                                    default:
                                        $badgeClass = 'bg-secondary';
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= $pengajuan['jenis_permohonan'] ?></span>
                            </td>
                            <td><?= $pengajuan['lembaga'] ?></td>
                            <td>
                                <small class="text-muted"><?= $pengajuan['unit_terkait'] ?></small>
                            </td>
                            <td>
                                <span class="text-primary"><?= $pengajuan['kontak'] ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" title="Lihat File" onclick="viewFile('<?= $pengajuan['upload_formulir'] ?>')">
                                        <i class="fas fa-file-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" title="Download" onclick="downloadFile('<?= $pengajuan['upload_formulir'] ?>')">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat Detail" onclick="viewPengajuan(<?= $pengajuan['id'] ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Approve" onclick="approvePengajuan(<?= $pengajuan['id'] ?>)">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" title="Reject" onclick="rejectPengajuan(<?= $pengajuan['id'] ?>)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Empty State (jika tidak ada data) -->
            <?php if (empty($pengajuanData)): ?>
            <div class="text-center py-5">
                <i class="fas fa-file-signature fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada pengajuan</h5>
                <p class="text-muted">Belum ada pengajuan kerjasama yang masuk.</p>
            </div>
            <?php endif; ?>

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

<!-- Modal View File -->
<div class="modal fade" id="viewFileModal" tabindex="-1" aria-labelledby="viewFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFileModalLabel">Lihat Formulir Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <iframe id="fileViewer" src="" width="100%" height="500px" frameborder="0">
                        Browser Anda tidak mendukung preview file. 
                        <a href="" id="downloadLink" target="_blank">Download file</a>
                    </iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="downloadCurrentFile()">Download</button>
            </div>
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
        const lembaga = row.cells[1].textContent.toLowerCase();
        const unitTerkait = row.cells[2].textContent.toLowerCase();
        const kontak = row.cells[3].textContent.toLowerCase();
        
        if (lembaga.includes(searchTerm) || unitTerkait.includes(searchTerm) || kontak.includes(searchTerm)) {
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

// View File function
function viewFile(filename) {
    const fileUrl = `<?= base_url('uploads/pengajuan/') ?>${filename}`;
    document.getElementById('fileViewer').src = fileUrl;
    document.getElementById('downloadLink').href = fileUrl;
    
    const modal = new bootstrap.Modal(document.getElementById('viewFileModal'));
    modal.show();
}

// Download File function
function downloadFile(filename) {
    const fileUrl = `<?= base_url('uploads/pengajuan/') ?>${filename}`;
    const link = document.createElement('a');
    link.href = fileUrl;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Download current viewed file
function downloadCurrentFile() {
    const fileUrl = document.getElementById('fileViewer').src;
    const filename = fileUrl.split('/').pop();
    const link = document.createElement('a');
    link.href = fileUrl;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// View Pengajuan Detail
function viewPengajuan(id) {
    window.location.href = `<?= base_url('admin/kerjasama/pengajuan/detail/') ?>${id}`;
}

// Approve Pengajuan
function approvePengajuan(id) {
    if (confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')) {
        // Add AJAX request here
        console.log('Approving pengajuan with ID:', id);
        showAlert('success', 'Pengajuan berhasil disetujui!');
    }
}

// Reject Pengajuan
function rejectPengajuan(id) {
    const reason = prompt('Masukkan alasan penolakan:');
    if (reason && reason.trim() !== '') {
        // Add AJAX request here
        console.log('Rejecting pengajuan with ID:', id, 'Reason:', reason);
        showAlert('warning', 'Pengajuan telah ditolak!');
    }
}
</script>
<?= $this->endSection() ?>