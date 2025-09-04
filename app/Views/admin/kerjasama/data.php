<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Data Kerjasama
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/components/pagination.css') ?>" rel="stylesheet">
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
                <table class="table table-hover table-paginate">
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
                                        <button type="button" class="btn btn-success btn-sm" title="Lihat" onclick="viewKerjasama(<?= $kerjasama['id'] ?>)">
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
                <div class="pagination-container"></div>
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

<!-- Modal Lihat Kerjasama -->
<div class="modal fade" id="lihatKerjasamaModal" tabindex="-1" aria-labelledby="lihatKerjasamaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lihatKerjasamaModalLabel">Detail Kerjasama</h5>
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
                        <label class="form-label fw-bold">Lingkup Kerjasama</label>
                        <p id="view_lingkup" class="border-bottom pb-2"></p>
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
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Pembuatan</label>
                        <p id="view_created_at" class="border-bottom pb-2"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Terakhir Diperbarui</label>
                        <p id="view_updated_at" class="border-bottom pb-2"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Kerjasama -->
<div class="modal fade" id="editKerjasamaModal" tabindex="-1" aria-labelledby="editKerjasamaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKerjasamaModalLabel">Edit Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditKerjasama" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_nama_mitra" class="form-label">Nama Mitra</label>
                            <input type="text" class="form-control" id="edit_nama_mitra" name="nama_mitra" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_lingkup" class="form-label">Lingkup Kerjasama</label>
                        <textarea class="form-control" id="edit_lingkup" name="lingkup" rows="3" placeholder="Masukkan lingkup kerjasama..." required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="edit_tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                            <input type="date" class="form-control" id="edit_tanggal_berakhir" name="tanggal_berakhir" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="alert alert-info">
                            <small><i class="fas fa-info-circle me-2"></i>Perbarui data kerjasama sesuai dengan formulir ini.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui Kerjasama</button>
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

// Pagination variables
let currentPage = 1;
let currentFilter = 'all';
let currentSearch = '';
const itemsPerPage = 10;

// Function to get all visible rows based on current search and filter
function getFilteredRows() {
    const tableRows = document.querySelectorAll('tbody tr');
    const filteredRows = [];
    
    tableRows.forEach(row => {
        let showRow = true;
        
        // Skip empty message row
        if (row.cells.length < 6) {
            return;
        }
        
        // Apply search filter
        if (currentSearch) {
            const namaMitra = row.cells[1].textContent.toLowerCase();
            const lingkup = row.cells[2].textContent.toLowerCase();
            
            if (!namaMitra.includes(currentSearch) && !lingkup.includes(currentSearch)) {
                showRow = false;
            }
        }
        
        // Apply category filter
        if (currentFilter !== 'all' && showRow) {
            // Add status-based filtering logic
            const tanggalBerakhir = row.cells[4].textContent;
            const today = new Date();
            const endDate = new Date(tanggalBerakhir.split('/').reverse().join('-'));
            const threeMonthsFromNow = new Date();
            threeMonthsFromNow.setMonth(threeMonthsFromNow.getMonth() + 3);
            
            if (currentFilter === 'aktif') {
                if (endDate <= threeMonthsFromNow) {
                    showRow = false;
                }
            } else if (currentFilter === 'berakhir') {
                if (endDate > threeMonthsFromNow) {
                    showRow = false;
                }
            }
        }
        
        if (showRow) {
            filteredRows.push(row);
        }
    });
    
    return filteredRows;
}

// Function to display current page
function displayPage(page) {
    const filteredRows = getFilteredRows();
    const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
    
    // Validate page number
    if (page < 1) page = 1;
    if (page > totalPages && totalPages > 0) page = totalPages;
    if (totalPages === 0) page = 1;
    
    currentPage = page;
    
    // Hide all rows first
    const allRows = document.querySelectorAll('tbody tr');
    allRows.forEach(row => row.style.display = 'none');
    
    // Show rows for current page
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageRows = filteredRows.slice(startIndex, endIndex);
    
    pageRows.forEach(row => row.style.display = '');
    
    // Update pagination controls
    updatePaginationControls(totalPages, filteredRows.length);
    
    return totalPages;
}

// Function to update pagination controls
function updatePaginationControls(totalPages, totalItems) {
    const paginationContainer = document.querySelector('.pagination');
    if (!paginationContainer) return;
    
    paginationContainer.innerHTML = '';
    
    if (totalPages <= 1) {
        paginationContainer.style.display = 'none';
        return;
    }
    
    paginationContainer.style.display = 'flex';
    
    // Previous button
    const prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>`;
    paginationContainer.appendChild(prevLi);
    
    // Page numbers
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, currentPage + 2);
    
    if (startPage > 1) {
        const firstLi = document.createElement('li');
        firstLi.className = 'page-item';
        firstLi.innerHTML = `<a class="page-link" href="#" data-page="1">1</a>`;
        paginationContainer.appendChild(firstLi);
        
        if (startPage > 2) {
            const dotsLi = document.createElement('li');
            dotsLi.className = 'page-item disabled';
            dotsLi.innerHTML = `<span class="page-link">...</span>`;
            paginationContainer.appendChild(dotsLi);
        }
    }
    
    for (let i = startPage; i <= endPage; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
        paginationContainer.appendChild(li);
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const dotsLi = document.createElement('li');
            dotsLi.className = 'page-item disabled';
            dotsLi.innerHTML = `<span class="page-link">...</span>`;
            paginationContainer.appendChild(dotsLi);
        }
        
        const lastLi = document.createElement('li');
        lastLi.className = 'page-item';
        lastLi.innerHTML = `<a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>`;
        paginationContainer.appendChild(lastLi);
    }
    
    // Next button
    const nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>`;
    paginationContainer.appendChild(nextLi);
    
    // Add click events to pagination links
    paginationContainer.addEventListener('click', function(e) {
        e.preventDefault();
        if (e.target.classList.contains('page-link') && e.target.hasAttribute('data-page')) {
            const page = parseInt(e.target.getAttribute('data-page'));
            if (page !== currentPage && page >= 1 && page <= totalPages) {
                displayPage(page);
            }
        }
    });
}

// Search functionality with pagination
document.getElementById('searchInput').addEventListener('keyup', function() {
    currentSearch = this.value.toLowerCase();
    currentPage = 1; // Reset to first page
    displayPage(currentPage);
});

// Filter functionality with pagination
document.querySelectorAll('[data-filter]').forEach(filterBtn => {
    filterBtn.addEventListener('click', function(e) {
        e.preventDefault();
        currentFilter = this.dataset.filter;
        currentPage = 1; // Reset to first page
        displayPage(currentPage);
        
        // Update filter button text
        document.getElementById('filterDropdown').innerHTML = `<i class="fas fa-filter me-2"></i>${this.textContent}`;
    });
});

// Initialize pagination on page load
document.addEventListener('DOMContentLoaded', function() {
    // Small delay to ensure all DOM elements are ready
    setTimeout(() => {
        displayPage(1);
    }, 100);
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
    // Show loading
    const viewModal = new bootstrap.Modal(document.getElementById('lihatKerjasamaModal'));
    
    // Fetch data
    fetch(`<?= base_url('admin/kerjasama/get/') ?>${id}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.status) {
            const data = result.data;
            
            // Format dates - handle various date formats
            const formatDate = (dateStr) => {
                if (!dateStr) return '-';
                // Try to parse the date
                const date = new Date(dateStr);
                if (isNaN(date.getTime())) return dateStr; // Return original if invalid
                
                // Format date options
                const options = { 
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric' 
                };
                
                return date.toLocaleDateString('id-ID', options);
            };
            
            const formatDateTime = (dateStr) => {
                if (!dateStr) return '-';
                // Try to parse the date
                const date = new Date(dateStr);
                if (isNaN(date.getTime())) return dateStr; // Return original if invalid
                
                // Format date options
                const options = { 
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric' 
                };
                
                return date.toLocaleDateString('id-ID', options) + ' ' + date.toLocaleTimeString('id-ID');
            };
            
            // Set values
            document.getElementById('view_nama_mitra').textContent = data.nama_mitra;
            document.getElementById('view_lingkup').textContent = data.ruang_lingkup;
            document.getElementById('view_tanggal_mulai').textContent = formatDate(data.tanggal_mulai);
            document.getElementById('view_tanggal_berakhir').textContent = formatDate(data.tanggal_berakhir);
            document.getElementById('view_created_at').textContent = formatDateTime(data.created_at);
            document.getElementById('view_updated_at').textContent = formatDateTime(data.updated_at);
            
            // Show modal
            viewModal.show();
        } else {
            showAlert('danger', result.message || 'Gagal mengambil data kerjasama');
        }
    })
    .catch(error => {
        handleApiError(error);
    })
    .catch(error => {
        handleApiError(error);
    });
}

function editKerjasama(id) {
    // Show loading
    const editModal = new bootstrap.Modal(document.getElementById('editKerjasamaModal'));
    
    // Fetch data
    fetch(`<?= base_url('admin/kerjasama/get/') ?>${id}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.status) {
            const data = result.data;
            
            // Format date for input fields (YYYY-MM-DD)
            const formatDateForInput = (dateStr) => {
                if (!dateStr) return '';
                // Try to parse the date
                const date = new Date(dateStr);
                if (isNaN(date.getTime())) {
                    // Try to extract date part if it's a datetime string
                    if (typeof dateStr === 'string' && dateStr.includes(' ')) {
                        return dateStr.split(' ')[0];
                    }
                    return '';
                }
                
                // Format as YYYY-MM-DD
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };
            
            // Populate fields
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_nama_mitra').value = data.nama_mitra;
            document.getElementById('edit_lingkup').value = data.ruang_lingkup;
            document.getElementById('edit_tanggal_mulai').value = formatDateForInput(data.tanggal_mulai);
            document.getElementById('edit_tanggal_berakhir').value = formatDateForInput(data.tanggal_berakhir);
            
            // Set form action
            document.getElementById('formEditKerjasama').setAttribute('action', `<?= base_url('admin/kerjasama/update/') ?>${data.id}`);
            
            // Show modal
            editModal.show();
        } else {
            showAlert('danger', result.message || 'Gagal memuat data kerjasama');
        }
    })
    .catch(error => {
        handleApiError(error);
    });
}

// Delete function with confirmation
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

// Edit form submission handler
document.getElementById('formEditKerjasama').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate dates
    const tanggalMulai = new Date(document.getElementById('edit_tanggal_mulai').value);
    const tanggalBerakhir = new Date(document.getElementById('edit_tanggal_berakhir').value);
    
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
        const modal = bootstrap.Modal.getInstance(document.getElementById('editKerjasamaModal'));
        modal.hide();
        
        // Reset form
        document.getElementById('formEditKerjasama').reset();
        
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        if (data.status) {
            // Show success message
            showAlert('success', data.message || 'Data kerjasama berhasil diperbarui!');
            
            // Reload page to show updated data
            setTimeout(function() {
                location.reload();
            }, 1500);
        } else {
            // Show error message
            showAlert('danger', data.message || 'Gagal memperbarui data kerjasama');
            
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

// Reset edit form when modal is closed
document.getElementById('editKerjasamaModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('formEditKerjasama').reset();
    const submitBtn = this.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.innerHTML = 'Perbarui Kerjasama';
        submitBtn.disabled = false;
    }
});
</script>
<script src="<?= base_url('js/components/pagination.js') ?>"></script>
<?= $this->endSection() ?>