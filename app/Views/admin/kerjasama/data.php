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
                // Data from database via controller
                if (empty($kerjasamaData)) {
                    $kerjasamaData = [];
                }
                        ?>
                        
                        <?php if(count($kerjasamaData) > 0): ?>
                            <?php foreach ($kerjasamaData as $kerjasama): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input row-checkbox" value="<?= $kerjasama['id'] ?>">
                                </td>
                                <td><?= esc($kerjasama['nama_mitra']) ?></td>
                                <td>
                                    <span class="text-muted"><?= substr(esc($kerjasama['ruang_lingkup'] ?? ''), 0, 50) ?>...</span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($kerjasama['tanggal_mulai'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($kerjasama['tanggal_berakhir'])) ?></td>
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
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-3">Tidak ada data kerjasama</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    <?php
                    $count = count($kerjasamaData);
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
                        <div class="col-md-12 mb-3">
                            <label for="nama_mitra" class="form-label">Nama Mitra</label>
                            <input type="text" class="form-control" id="nama_mitra" name="nama_mitra" required>
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
                    
                    <!-- Hanya gunakan field yang ada dalam database -->
                    <div class="mb-3">
                        <div class="alert alert-info">
                            <small><i class="fas fa-info-circle me-2"></i>Lengkapi data kerjasama sesuai dengan formulir ini.</small>
                        </div>
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
// Function to show alerts
function showAlert(type, message) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    // Append to body
    document.body.appendChild(alertDiv);
    
    // Auto dismiss after 5 seconds
    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alertDiv);
        bsAlert.close();
    }, 5000);
}
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
    
    // Get form data
    const formData = new FormData(this);
    
    // Submit via AJAX
    fetch(this.getAttribute('action'), {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('tambahKerjasamaModal'));
        modal.hide();
        
        // Reset form
        document.getElementById('formTambahKerjasama').reset();
        
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        if (data.status) {
            // Show success message
            showAlert('success', data.message || 'Data kerjasama berhasil ditambahkan!');
            
            // Reload page to show new data
            setTimeout(function() {
                location.reload();
            }, 1500);
        } else {
            // Show error message
            showAlert('danger', data.message || 'Gagal menyimpan data kerjasama');
            
            // Display validation errors if available
            if (data.errors) {
                const errorMessages = Object.values(data.errors).join('<br>');
                showAlert('danger', errorMessages);
            }
        }
    })
    .catch(error => {
        handleApiError(error);
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// Reset form when modal is closed
document.getElementById('tambahKerjasamaModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('formTambahKerjasama').reset();
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = 'Simpan Kerjasama';
    submitBtn.disabled = false;
});

// Error handling function for debugging
function handleApiError(error) {
    console.error('API Error:', error);
    showAlert('danger', 'Terjadi kesalahan pada server. Silakan cek konsol untuk detail.');
}

// Functions for table actions
function viewKerjasama(id) {
    window.location.href = `<?= base_url('admin/kerjasama/view/') ?>${id}`;
}

function editKerjasama(id) {
    window.location.href = `<?= base_url('admin/kerjasama/edit/') ?>${id}`;
}

function deleteKerjasama(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data kerjasama ini?')) {
        fetch(`<?= base_url('admin/kerjasama/delete/') ?>${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                showAlert('success', data.message || 'Data kerjasama berhasil dihapus');
                // Reload page to update table
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showAlert('danger', data.message || 'Gagal menghapus data kerjasama');
            }
        })
        .catch(error => {
            handleApiError(error);
        });
    }
}
</script>
<?= $this->endSection() ?>