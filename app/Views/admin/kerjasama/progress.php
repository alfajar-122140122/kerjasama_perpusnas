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
        <!-- Hapus tombol tambah data -->
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
                            <li><a class="dropdown-item" href="#" data-filter="review">Review</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="approved">Approved</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="rejected">Rejected</a></li>
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
                            <th>Lembaga</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="progressTableBody">
                        <?php foreach ($progressData as $progress): ?>
                        <tr data-jenis="<?= $progress['jenis'] ?>" data-status="<?= $progress['status'] ?>">
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox" value="<?= $progress['id'] ?>">
                            </td>
                            <td><?= date('d F Y', strtotime($progress['tanggal_pengajuan'])) ?></td>
                            <td><?= $progress['lembaga'] ?></td>
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
                                switch($progress['status']) {
                                    case 'review':
                                        $progressBadgeClass = 'bg-info';
                                        break;
                                    case 'approved':
                                        $progressBadgeClass = 'bg-success';
                                        break;
                                    case 'rejected':
                                        $progressBadgeClass = 'bg-danger';
                                        break;
                                    default:
                                        $progressBadgeClass = 'bg-secondary';
                                }
                                ?>
                                <span class="badge <?= $progressBadgeClass ?>"><?= $progress['status'] ?></span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat" onclick="viewProgress(<?= $progress['id'] ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <!-- Hapus tombol Edit dan Hapus -->
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
                    <?php
                    $count = count($progressData);
                    $start = $count > 0 ? 1 : 0;
                    echo "Menampilkan {$start}-{$count} dari {$count} data";
                    ?>
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
        const lembaga = row.cells[2].textContent.toLowerCase();
        const jenis = row.cells[3].textContent.toLowerCase();
        const status = row.cells[4].textContent.toLowerCase();
        
        if (lembaga.includes(searchTerm) || jenis.includes(searchTerm) || status.includes(searchTerm)) {
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
                const status = row.dataset.status;
                if (jenis === filter || status === filter) {
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

// View function
function viewProgress(id) {
    // Reset form and clear validation errors
    $('#viewProgressModal').find('.is-invalid').removeClass('is-invalid');
    $('#viewProgressModal').find('.invalid-feedback').html('');
    
    // Get progress data
    $.ajax({
        url: `<?= base_url('admin/kerjasama/progress/get/') ?>/${id}`,
        method: 'GET',
        success: function(response) {
            if (response.status) {
                const data = response.data;
                // Format the date
                const date = new Date(data.tanggal_pengajuan);
                const formattedDate = date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                
                // Set data in the modal
                $('#view-lembaga').text(data.lembaga);
                $('#view-tanggal').text(formattedDate);
                $('#view-jenis').text(data.jenis);
                $('#view-progress').text(data.status);
                
                // Set badge colors
                let jenisBadgeClass = 'bg-secondary';
                switch(data.jenis) {
                    case 'Baru': jenisBadgeClass = 'bg-success'; break;
                    case 'Perpanjangan': jenisBadgeClass = 'bg-info'; break;
                    case 'Dokumentasi': jenisBadgeClass = 'bg-warning'; break;
                    case 'Finishing': jenisBadgeClass = 'bg-primary'; break;
                }
                
                let progressBadgeClass = 'bg-secondary';
                switch(data.status) {
                    case 'review': progressBadgeClass = 'bg-info'; break;
                    case 'approved': progressBadgeClass = 'bg-success'; break;
                    case 'rejected': progressBadgeClass = 'bg-danger'; break;
                }
                
                $('#view-jenis-badge').removeClass().addClass(`badge ${jenisBadgeClass}`).text(data.jenis);
                $('#view-progress-badge').removeClass().addClass(`badge ${progressBadgeClass}`).text(data.status);
                
                // Show the modal
                $('#viewProgressModal').modal('show');
            } else {
                showAlert('error', response.message || 'Terjadi kesalahan saat mengambil data');
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Terjadi kesalahan saat mengambil data');
        }
    });
}

// Show alert function
function showAlert(type, message) {
    let alertClass = 'alert-info';
    if (type === 'success') alertClass = 'alert-success';
    if (type === 'error') alertClass = 'alert-danger';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    $('#alertContainer').html(alertHtml);
    
    // Auto hide after 3 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 3000);
}
</script>
<?= $this->endSection() ?>