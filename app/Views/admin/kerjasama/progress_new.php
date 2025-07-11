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
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProgressModal">
                <i class="fas fa-plus me-2"></i>Tambah Data
            </button>
        </div>
    </div>

    <!-- Alert container for messages -->
    <div id="alertContainer" class="mb-4"></div>

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
                            <th>Lembaga</th>
                            <th>Jenis</th>
                            <th>Progress</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Check if progressData is passed from controller
                        if (!isset($progressData) || empty($progressData)) {
                            // Sample data for preview only if no data from database
                            $progressData = [
                                [
                                    'id' => 1,
                                    'tanggal_pengajuan' => '2025-07-14',
                                    'lembaga' => 'Perpustakaan Nasional',
                                    'jenis' => 'Baru',
                                    'progress' => 'Dokumentasi',
                                    'created_at' => '2025-07-10 08:30:00'
                                ],
                                [
                                    'id' => 2,
                                    'tanggal_pengajuan' => '2025-07-16',
                                    'lembaga' => 'Dinas Kearsipan',
                                    'jenis' => 'Perpanjangan',
                                    'progress' => 'Finishing',
                                    'created_at' => '2025-07-11 10:15:00'
                                ]
                            ];
                        }
                        ?>
                        
                        <?php foreach ($progressData as $progress): ?>
                        <tr data-jenis="<?= $progress['jenis'] ?>">
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
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat" onclick="viewProgress(<?= $progress['id'] ?>)">
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
            <?php if (!empty($progressData)): ?>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan <?= count($progressData) ?> data
                </div>
                <?php if (isset($pager)): ?>
                <nav>
                    <?= $pager->links() ?>
                </nav>
                <?php else: ?>
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
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Progress Modal -->
<div class="modal fade" id="addProgressModal" tabindex="-1" aria-labelledby="addProgressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProgressModalLabel">Tambah Progress Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addProgressForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add-lembaga" class="form-label">Lembaga</label>
                        <input type="text" class="form-control" id="add-lembaga" name="lembaga" placeholder="Masukkan nama lembaga">
                        <div id="add-lembaga-error" class="invalid-feedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="add-tanggal-pengajuan" class="form-label">Tanggal Pengajuan</label>
                        <input type="date" class="form-control" id="add-tanggal-pengajuan" name="tanggal_pengajuan">
                        <div id="add-tanggal-pengajuan-error" class="invalid-feedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="add-jenis" class="form-label">Jenis</label>
                        <select class="form-select" id="add-jenis" name="jenis">
                            <option value="" disabled selected>Pilih jenis</option>
                            <option value="Baru">Baru</option>
                            <option value="Perpanjangan">Perpanjangan</option>
                            <option value="Dokumentasi">Dokumentasi</option>
                            <option value="Finishing">Finishing</option>
                        </select>
                        <div id="add-jenis-error" class="invalid-feedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="add-progress" class="form-label">Progress</label>
                        <select class="form-select" id="add-progress" name="progress">
                            <option value="" disabled selected>Pilih progress</option>
                            <option value="Dokumentasi">Dokumentasi</option>
                            <option value="Review">Review</option>
                            <option value="Approval">Approval</option>
                            <option value="Finishing">Finishing</option>
                        </select>
                        <div id="add-progress-error" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Progress Modal -->
<div class="modal fade" id="editProgressModal" tabindex="-1" aria-labelledby="editProgressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProgressModalLabel">Edit Progress Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProgressForm">
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    
                    <div class="mb-3">
                        <label for="edit-lembaga" class="form-label">Lembaga</label>
                        <input type="text" class="form-control" id="edit-lembaga" name="lembaga" placeholder="Masukkan nama lembaga">
                        <div id="edit-lembaga-error" class="invalid-feedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit-tanggal-pengajuan" class="form-label">Tanggal Pengajuan</label>
                        <input type="date" class="form-control" id="edit-tanggal-pengajuan" name="tanggal_pengajuan">
                        <div id="edit-tanggal-pengajuan-error" class="invalid-feedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit-jenis" class="form-label">Jenis</label>
                        <select class="form-select" id="edit-jenis" name="jenis">
                            <option value="" disabled>Pilih jenis</option>
                            <option value="Baru">Baru</option>
                            <option value="Perpanjangan">Perpanjangan</option>
                            <option value="Dokumentasi">Dokumentasi</option>
                            <option value="Finishing">Finishing</option>
                        </select>
                        <div id="edit-jenis-error" class="invalid-feedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit-progress" class="form-label">Progress</label>
                        <select class="form-select" id="edit-progress" name="progress">
                            <option value="" disabled>Pilih progress</option>
                            <option value="Dokumentasi">Dokumentasi</option>
                            <option value="Review">Review</option>
                            <option value="Approval">Approval</option>
                            <option value="Finishing">Finishing</option>
                        </select>
                        <div id="edit-progress-error" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Progress Modal -->
<div class="modal fade" id="viewProgressModal" tabindex="-1" aria-labelledby="viewProgressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProgressModalLabel">Detail Progress Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h6 class="fw-bold">Lembaga</h6>
                    <p id="view-lembaga"></p>
                </div>
                
                <div class="mb-3">
                    <h6 class="fw-bold">Tanggal Pengajuan</h6>
                    <p id="view-tanggal"></p>
                </div>
                
                <div class="mb-3">
                    <h6 class="fw-bold">Jenis</h6>
                    <span id="view-jenis-badge" class="badge"></span>
                </div>
                
                <div class="mb-3">
                    <h6 class="fw-bold">Progress</h6>
                    <span id="view-progress-badge" class="badge"></span>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold">Tanggal Dibuat</h6>
                    <p id="view-created-at"></p>
                </div>
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
        const progress = row.cells[4].textContent.toLowerCase();
        
        if (lembaga.includes(searchTerm) || jenis.includes(searchTerm) || progress.includes(searchTerm)) {
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

// View function
function viewProgress(id) {
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
                
                const createdDate = new Date(data.created_at);
                const formattedCreatedDate = createdDate.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                // Set data in the modal
                $('#view-lembaga').text(data.lembaga);
                $('#view-tanggal').text(formattedDate);
                $('#view-created-at').text(formattedCreatedDate);
                
                // Set badge colors
                let jenisBadgeClass = 'bg-secondary';
                switch(data.jenis) {
                    case 'Baru': jenisBadgeClass = 'bg-success'; break;
                    case 'Perpanjangan': jenisBadgeClass = 'bg-info'; break;
                    case 'Dokumentasi': jenisBadgeClass = 'bg-warning'; break;
                    case 'Finishing': jenisBadgeClass = 'bg-primary'; break;
                }
                
                let progressBadgeClass = 'bg-secondary';
                switch(data.progress) {
                    case 'Dokumentasi': progressBadgeClass = 'bg-warning text-dark'; break;
                    case 'Finishing': progressBadgeClass = 'bg-success'; break;
                    case 'Review': progressBadgeClass = 'bg-info'; break;
                    case 'Approval': progressBadgeClass = 'bg-primary'; break;
                }
                
                $('#view-jenis-badge').removeClass().addClass(`badge ${jenisBadgeClass}`).text(data.jenis);
                $('#view-progress-badge').removeClass().addClass(`badge ${progressBadgeClass}`).text(data.progress);
                
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

// Edit function
function editProgress(id) {
    // Reset form and clear validation errors
    $('#editProgressForm')[0].reset();
    $('#editProgressForm').find('.is-invalid').removeClass('is-invalid');
    $('#editProgressForm').find('.invalid-feedback').html('');
    
    // Get progress data
    $.ajax({
        url: `<?= base_url('admin/kerjasama/progress/get/') ?>/${id}`,
        method: 'GET',
        success: function(response) {
            if (response.status) {
                const data = response.data;
                
                // Set data in the form
                $('#edit-id').val(data.id);
                $('#edit-lembaga').val(data.lembaga);
                $('#edit-tanggal-pengajuan').val(data.tanggal_pengajuan);
                $('#edit-jenis').val(data.jenis);
                $('#edit-progress').val(data.progress);
                
                // Show the modal
                $('#editProgressModal').modal('show');
            } else {
                showAlert('error', response.message || 'Terjadi kesalahan saat mengambil data');
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Terjadi kesalahan saat mengambil data');
        }
    });
}

// Delete function
function deleteProgress(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data progress ini?')) {
        $.ajax({
            url: `<?= base_url('admin/kerjasama/progress/delete/') ?>/${id}`,
            method: 'DELETE',
            success: function(response) {
                if (response.status) {
                    showAlert('success', response.message || 'Data progress berhasil dihapus');
                    // Refresh the page to update the table
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert('error', response.message || 'Terjadi kesalahan saat menghapus data');
                }
            },
            error: function(xhr, status, error) {
                showAlert('error', 'Terjadi kesalahan saat menghapus data');
            }
        });
    }
}

// Add Progress Form Submit
$('#addProgressForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = $(this).serialize();
    
    $.ajax({
        url: '<?= base_url('admin/kerjasama/progress/store') ?>',
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                $('#addProgressModal').modal('hide');
                showAlert('success', response.message || 'Data progress berhasil ditambahkan');
                
                // Refresh the page to update the table
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                // Show validation errors
                if (response.errors) {
                    $.each(response.errors, function(field, message) {
                        $(`#add-${field.replace('_', '-')}`).addClass('is-invalid');
                        $(`#add-${field.replace('_', '-')}-error`).html(message);
                    });
                } else {
                    showAlert('error', response.message || 'Terjadi kesalahan saat menyimpan data');
                }
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Terjadi kesalahan saat menyimpan data');
        }
    });
});

// Edit Progress Form Submit
$('#editProgressForm').on('submit', function(e) {
    e.preventDefault();
    
    const id = $('#edit-id').val();
    const formData = $(this).serialize();
    
    $.ajax({
        url: `<?= base_url('admin/kerjasama/progress/update/') ?>/${id}`,
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                $('#editProgressModal').modal('hide');
                showAlert('success', response.message || 'Data progress berhasil diperbarui');
                
                // Refresh the page to update the table
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                // Show validation errors
                if (response.errors) {
                    $.each(response.errors, function(field, message) {
                        $(`#edit-${field.replace('_', '-')}`).addClass('is-invalid');
                        $(`#edit-${field.replace('_', '-')}-error`).html(message);
                    });
                } else {
                    showAlert('error', response.message || 'Terjadi kesalahan saat memperbarui data');
                }
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Terjadi kesalahan saat memperbarui data');
        }
    });
});

// Reset forms when modals are closed
$('.modal').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $(this).find('.is-invalid').removeClass('is-invalid');
    $(this).find('.invalid-feedback').html('');
});

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
