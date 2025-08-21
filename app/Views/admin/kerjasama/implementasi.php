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
        <div>
            <a href="<?= base_url('admin/kerjasama/implementasi/tambah') ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahImplementasiModal">
                <i class="fas fa-plus me-2"></i>Tambah Implementasi
            </a>
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
                            <li><a class="dropdown-item" href="#" data-filter="dokumen">Dokumen</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="arsip">Arsip</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="pelatihan">Pelatihan</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="penelitian">Penelitian</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="teknologi">Teknologi</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="pengembangan">Pengembangan</a></li>
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
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Data from database via controller
                        if (empty($implementasiData)) {
                            $implementasiData = [];
                        }
                        
                        if (count($implementasiData) > 0): ?>
                            <?php foreach ($implementasiData as $implementasi): ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox" value="<?= $implementasi['id'] ?>">
                            </td>
                            <td><?= esc($implementasi['nama_mitra']) ?></td>
                            <td>
                                <small class="text-muted">
                                    <?php 
                                    // Display masa_berlaku directly if it exists
                                    if (!empty($implementasi['masa_berlaku'])) {
                                        echo esc($implementasi['masa_berlaku']);
                                    }
                                    // Otherwise calculate from dates if available
                                    else if (!empty($implementasi['tanggal_mulai']) && !empty($implementasi['tanggal_berakhir'])) {
                                        $startDate = new DateTime($implementasi['tanggal_mulai']);
                                        $endDate = new DateTime($implementasi['tanggal_berakhir']);
                                        $interval = $endDate->diff($startDate);
                                        
                                        $duration = '';
                                        if ($interval->y > 0) $duration .= $interval->y . ' tahun ';
                                        if ($interval->m > 0 || $interval->y > 0) $duration .= $interval->m . ' bulan ';
                                        $duration .= $interval->d . ' hari';
                                        
                                        echo esc($duration);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </small>
                            </td>
                            <td>
                                <span class="text-muted"><?= substr(esc($implementasi['implementasi']), 0, 35) ?>...</span>
                            </td>
                            <td>
                                <span class="badge bg-info"><?= esc($implementasi['lingkup']) ?></span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat" onclick="viewImplementasi(<?= $implementasi['id'] ?>)">
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
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-3">Tidak ada data implementasi kerjasama</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    <?php
                    $count = count($implementasiData);
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
                            <label for="kerjasama_id" class="form-label">Nama Mitra</label>
                            <select class="form-select" id="kerjasama_id" name="kerjasama_id" required>
                                <option value="">Pilih Mitra Kerjasama</option>
                                <?php 
                                // Load kerjasama data
                                $kerjasamaModel = new \App\Models\KerjasamaModel();
                                $kerjasamaList = $kerjasamaModel->orderBy('nama_mitra', 'ASC')->findAll();
                                
                                foreach ($kerjasamaList as $kerjasama): ?>
                                    <option value="<?= $kerjasama['id'] ?>"><?= esc($kerjasama['nama_mitra']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lingkup" class="form-label">Lingkup</label>
                            <input type="text" class="form-control" id="lingkup" name="lingkup" placeholder="Masukkan lingkup implementasi" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="implementasi" class="form-label">Deskripsi Implementasi</label>
                        <textarea class="form-control" id="implementasi" name="implementasi" rows="3" placeholder="Masukkan deskripsi implementasi..." required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                            <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" required>
                            <small class="text-muted">Masa berlaku akan otomatis dihitung</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="duration_preview_container" style="display: none;">
                            <label class="form-label">Durasi Masa Berlaku:</label>
                            <p class="text-primary fw-bold" id="duration_preview"></p>
                        </div>
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

<!-- Modal Lihat Implementasi -->
<div class="modal fade" id="lihatImplementasiModal" tabindex="-1" aria-labelledby="lihatImplementasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lihatImplementasiModalLabel">Detail Implementasi Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Nama Mitra</label>
                        <p id="view_nama_mitra" class="border-bottom pb-2"></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Masa Berlaku</label>
                        <p id="view_masa_berlaku" class="border-bottom pb-2"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Mulai</label>
                        <p id="view_tanggal_mulai" class="border-bottom pb-2"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Berakhir</label>
                        <p id="view_tanggal_berakhir" class="border-bottom pb-2"></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Implementasi</label>
                        <p id="view_implementasi" class="border-bottom pb-2"></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Lingkup</label>
                        <p id="view_lingkup" class="border-bottom pb-2"></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Tanggal Pembuatan</label>
                        <p id="view_created_at" class="border-bottom pb-2"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Implementasi -->
<div class="modal fade" id="editImplementasiModal" tabindex="-1" aria-labelledby="editImplementasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editImplementasiModalLabel">Edit Implementasi Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditImplementasi" method="POST">
                <input type="hidden" id="edit_implementasi_id" name="implementasi_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_kerjasama_id" class="form-label">Nama Mitra</label>
                            <select class="form-select" id="edit_kerjasama_id" name="kerjasama_id" required>
                                <option value="">Pilih Mitra Kerjasama</option>
                                <?php 
                                // Load kerjasama data
                                $kerjasamaModel = new \App\Models\KerjasamaModel();
                                $kerjasamaList = $kerjasamaModel->orderBy('nama_mitra', 'ASC')->findAll();
                                
                                foreach ($kerjasamaList as $kerjasama): ?>
                                    <option value="<?= $kerjasama['id'] ?>"><?= esc($kerjasama['nama_mitra']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_lingkup" class="form-label">Lingkup</label>
                            <input type="text" class="form-control" id="edit_lingkup" name="lingkup" placeholder="Masukkan lingkup implementasi" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_implementasi" class="form-label">Deskripsi Implementasi</label>
                        <textarea class="form-control" id="edit_implementasi" name="implementasi" rows="3" placeholder="Masukkan deskripsi implementasi..." required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="edit_tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                            <input type="date" class="form-control" id="edit_tanggal_berakhir" name="tanggal_berakhir" required>
                            <small class="text-muted">Masa berlaku akan otomatis dihitung</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="edit_duration_preview_container" style="display: none;">
                            <label class="form-label">Durasi Masa Berlaku:</label>
                            <p class="text-primary fw-bold" id="edit_duration_preview"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Function to calculate duration between two dates in years, months, days format
function calculateDuration(startDate, endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);
    
    // Return empty string if invalid dates
    if (isNaN(start.getTime()) || isNaN(end.getTime())) {
        return '';
    }
    
    // Calculate the difference in milliseconds
    let diff = end - start;
    
    // Check if end date is before start date
    if (diff < 0) {
        return 'Tanggal tidak valid';
    }
    
    // Convert to days
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    
    // Calculate years, months and remaining days
    const years = Math.floor(days / 365);
    let remainingDays = days % 365;
    const months = Math.floor(remainingDays / 30);
    remainingDays = remainingDays % 30;
    
    // Build the duration string
    let duration = '';
    if (years > 0) {
        duration += years + ' tahun ';
    }
    if (months > 0 || years > 0) {
        duration += months + ' bulan ';
    }
    duration += remainingDays + ' hari';
    
    return duration.trim();
}

// Function to update the duration preview
function updateDurationPreview(startId, endId, previewId) {
    const startDate = document.getElementById(startId).value;
    const endDate = document.getElementById(endId).value;
    
    if (startDate && endDate) {
        const duration = calculateDuration(startDate, endDate);
        if (document.getElementById(previewId)) {
            document.getElementById(previewId).textContent = duration;
            document.getElementById(previewId + '_container').style.display = '';
        }
    }
}

// Add event listeners for date changes
document.addEventListener('DOMContentLoaded', function() {
    // For Add form
    const startDateInput = document.getElementById('tanggal_mulai');
    const endDateInput = document.getElementById('tanggal_berakhir');
    
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            if (endDateInput.value) {
                updateDurationPreview('tanggal_mulai', 'tanggal_berakhir', 'duration_preview');
            }
        });
        
        endDateInput.addEventListener('change', function() {
            if (startDateInput.value) {
                updateDurationPreview('tanggal_mulai', 'tanggal_berakhir', 'duration_preview');
            }
        });
    }
    
    // For Edit form
    const editStartDateInput = document.getElementById('edit_tanggal_mulai');
    const editEndDateInput = document.getElementById('edit_tanggal_berakhir');
    
    if (editStartDateInput && editEndDateInput) {
        editStartDateInput.addEventListener('change', function() {
            if (editEndDateInput.value) {
                updateDurationPreview('edit_tanggal_mulai', 'edit_tanggal_berakhir', 'edit_duration_preview');
            }
        });
        
        editEndDateInput.addEventListener('change', function() {
            if (editStartDateInput.value) {
                updateDurationPreview('edit_tanggal_mulai', 'edit_tanggal_berakhir', 'edit_duration_preview');
            }
        });
    }
    
    // Initialize modal events
    const tambahModal = document.getElementById('tambahImplementasiModal');
    if (tambahModal) {
        tambahModal.addEventListener('shown.bs.modal', function() {
            // Reset fields
            document.getElementById('tanggal_mulai').value = '';
            document.getElementById('tanggal_berakhir').value = '';
            document.getElementById('duration_preview_container').style.display = 'none';
        });
    }
    
    // Initialize edit modal events
    const editModal = document.getElementById('editImplementasiModal');
    if (editModal) {
        editModal.addEventListener('shown.bs.modal', function() {
            const startDate = document.getElementById('edit_tanggal_mulai').value;
            const endDate = document.getElementById('edit_tanggal_berakhir').value;
            
            if (startDate && endDate) {
                updateDurationPreview('edit_tanggal_mulai', 'edit_tanggal_berakhir', 'edit_duration_preview');
            } else {
                document.getElementById('edit_duration_preview_container').style.display = 'none';
            }
        });
    }
});

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
        const implementasi = row.cells[3].textContent.toLowerCase();
        const lingkup = row.cells[4].textContent.toLowerCase();
        
        if (namaMitra.includes(searchTerm) || implementasi.includes(searchTerm) || lingkup.includes(searchTerm)) {
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
                // Filter berdasarkan lingkup (lebih fleksibel untuk text input)
                const lingkupElement = row.querySelector('td:nth-child(5) .badge');
                if (lingkupElement && lingkupElement.textContent.toLowerCase().includes(filter.toLowerCase())) {
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

// Error handling function for debugging
function handleApiError(error) {
    console.error('API Error:', error);
    showAlert('danger', 'Terjadi kesalahan pada server. Silakan cek konsol untuk detail.');
}

// Form submission handler
document.getElementById('formTambahImplementasi').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Get form data
    const formData = new FormData(this);
    
    // Calculate and add masa_berlaku from date inputs
    const startDate = document.getElementById('tanggal_mulai').value;
    const endDate = document.getElementById('tanggal_berakhir').value;
    if (startDate && endDate) {
        const duration = calculateDuration(startDate, endDate);
        formData.set('masa_berlaku', duration);
    }
    
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
        const modal = bootstrap.Modal.getInstance(document.getElementById('tambahImplementasiModal'));
        modal.hide();
        
        // Reset form
        document.getElementById('formTambahImplementasi').reset();
        
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        if (data.status) {
            // Show success message
            showAlert('success', data.message || 'Data implementasi berhasil ditambahkan!');
            
            // Reload page to show new data
            setTimeout(function() {
                location.reload();
            }, 1500);
        } else {
            // Show error message
            showAlert('danger', data.message || 'Gagal menyimpan data implementasi');
            
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

// View Implementasi function
function viewImplementasi(id) {
    // Fetch implementasi data by ID
    fetch(`<?= base_url('admin/kerjasama/implementasi/get/') ?>${id}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            // Populate modal fields
            document.getElementById('view_nama_mitra').textContent = data.data.nama_mitra;
            
            // Format dates and calculate duration
            const startDate = data.data.tanggal_mulai ? new Date(data.data.tanggal_mulai) : null;
            const endDate = data.data.tanggal_berakhir ? new Date(data.data.tanggal_berakhir) : null;
            
            // Display formatted dates
            document.getElementById('view_tanggal_mulai').textContent = startDate ? startDate.toLocaleDateString('id-ID') : '-';
            document.getElementById('view_tanggal_berakhir').textContent = endDate ? endDate.toLocaleDateString('id-ID') : '-';
            
            // Display masa_berlaku (prioritize stored value)
            if (data.data.masa_berlaku) {
                document.getElementById('view_masa_berlaku').textContent = data.data.masa_berlaku;
            } else if (startDate && endDate) {
                const duration = calculateDuration(startDate, endDate);
                document.getElementById('view_masa_berlaku').textContent = duration;
            } else {
                document.getElementById('view_masa_berlaku').textContent = '-';
            }
            
            document.getElementById('view_implementasi').textContent = data.data.implementasi;
            document.getElementById('view_lingkup').textContent = data.data.lingkup;
            document.getElementById('view_created_at').textContent = new Date(data.data.created_at).toLocaleString('id-ID');
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('lihatImplementasiModal'));
            modal.show();
        } else {
            showAlert('danger', data.message || 'Gagal memuat data implementasi');
        }
    })
    .catch(error => {
        handleApiError(error);
    });
}

// Edit Implementasi function
function editImplementasi(id) {
    // Fetch implementasi data by ID
    fetch(`<?= base_url('admin/kerjasama/implementasi/get/') ?>${id}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            // Populate edit form fields
            document.getElementById('edit_implementasi_id').value = data.data.id;
            document.getElementById('edit_kerjasama_id').value = data.data.kerjasama_id;
            document.getElementById('edit_lingkup').value = data.data.lingkup;
            document.getElementById('edit_implementasi').value = data.data.implementasi;
            document.getElementById('edit_tanggal_mulai').value = data.data.tanggal_mulai || '';
            document.getElementById('edit_tanggal_berakhir').value = data.data.tanggal_berakhir || '';
            
            // Show edit modal
            const modal = new bootstrap.Modal(document.getElementById('editImplementasiModal'));
            modal.show();
        } else {
            showAlert('danger', data.message || 'Gagal memuat data implementasi untuk diedit');
        }
    })
    .catch(error => {
        handleApiError(error);
    });
}

// Delete Implementasi function
function deleteImplementasi(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data implementasi ini?')) {
        fetch(`<?= base_url('admin/kerjasama/implementasi/delete/') ?>${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                showAlert('success', data.message || 'Data implementasi berhasil dihapus');
                // Reload page to update table
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showAlert('danger', data.message || 'Gagal menghapus data implementasi');
            }
        })
        .catch(error => {
            handleApiError(error);
        });
    }
}

// Edit Implementasi form submission handler
document.getElementById('formEditImplementasi').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Get form data
    const formData = new FormData(this);
    
    // Calculate and add masa_berlaku from date inputs
    const startDate = document.getElementById('edit_tanggal_mulai').value;
    const endDate = document.getElementById('edit_tanggal_berakhir').value;
    if (startDate && endDate) {
        const duration = calculateDuration(startDate, endDate);
        formData.set('masa_berlaku', duration);
    }
    
    // Get the implementasi ID from the hidden field
    const implementasiId = document.getElementById('edit_implementasi_id').value;
    
    // Submit via AJAX
    fetch(`<?= base_url('admin/kerjasama/implementasi/update') ?>/${implementasiId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('editImplementasiModal'));
        modal.hide();
        
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        if (data.status) {
            // Show success message
            showAlert('success', data.message || 'Data implementasi berhasil diperbarui!');
            
            // Reload page to show updated data
            setTimeout(function() {
                location.reload();
            }, 1500);
        } else {
            // Show error message
            showAlert('danger', data.message || 'Gagal memperbarui data implementasi');
            
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
</script>
<?= $this->endSection() ?>