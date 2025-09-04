<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Pengajuan Kerjasama
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/components/pagination.css') ?>" rel="stylesheet">
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
                            <div class="h5" id="pendingCount"><?= isset($summary) ? $summary['pending'] : 0 ?></div>
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
                            <div class="h5" id="reviewCount"><?= isset($summary) ? $summary['review'] : 0 ?></div>
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
                            <div class="h5" id="approvedCount"><?= isset($summary) ? $summary['approved'] : 0 ?></div>
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
                            <div class="h5" id="rejectedCount"><?= isset($summary) ? $summary['rejected'] : 0 ?></div>
                        </div>
                        <div><i class="fas fa-times fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <ul class="nav nav-tabs card-header-tabs" id="statusTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" href="#" data-filter="all">
                        <i class="fas fa-list me-2"></i>Semua
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="#" data-filter="pending">
                        <i class="fas fa-clock me-2"></i>Pending
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="#" data-filter="review">
                        <i class="fas fa-search me-2"></i>Review
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="#" data-filter="approved">
                        <i class="fas fa-check me-2"></i>Approved
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="#" data-filter="rejected">
                        <i class="fas fa-times me-2"></i>Rejected
                    </a>
                </li>
            </ul>
        </div>
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
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover table-paginate">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Jenis Permohonan</th>
                            <th>Lembaga</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                            <th width="200" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="permohonanTableBody">
                        <?php if (isset($pengajuanData) && !empty($pengajuanData)): ?>
                            <?php foreach ($pengajuanData as $index => $permohonan): ?>
                            <tr data-status="<?= esc($permohonan['status']) ?>">
                                <td><?= isset($pagination) ? (($pagination['currentPage'] - 1) * $pagination['perPage']) + $index + 1 : $index + 1 ?></td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?= ucfirst(esc($permohonan['jenis_permohonan'])) ?>
                                    </span>
                                </td>
                                <td><?= esc($permohonan['lembaga']) ?></td>
                                <td>
                                    <div>
                                        <div><i class="fas fa-phone me-1"></i><?= esc($permohonan['telepon']) ?></div>
                                        <div><i class="fas fa-envelope me-1"></i><?= esc($permohonan['email']) ?></div>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $statusClass = match($permohonan['status']) {
                                        'pending' => 'bg-warning text-dark',
                                        'review' => 'bg-info',
                                        'approved' => 'bg-success',
                                        'rejected' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    $statusIcon = match($permohonan['status']) {
                                        'pending' => 'clock',
                                        'review' => 'search',
                                        'approved' => 'check',
                                        'rejected' => 'times',
                                        default => 'question'
                                    };
                                    ?>
                                    <span class="badge <?= $statusClass ?>">
                                        <i class="fas fa-<?= $statusIcon ?> me-1"></i>
                                        <?= ucfirst($permohonan['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($permohonan['tanggal_pengajuan'])) ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                                        <!-- View Detail Button - Always visible -->
                                        <button type="button" class="btn btn-info btn-sm" title="Lihat Detail" 
                                                onclick="showDetail(<?= $permohonan['id'] ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <!-- Status-based buttons -->
                                        <?php if ($permohonan['status'] === 'pending'): ?>
                                            <button type="button" class="btn btn-warning btn-sm" title="Set Review" 
                                                    onclick="changeStatus(<?= $permohonan['id'] ?>, 'review')">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        <?php elseif ($permohonan['status'] === 'review'): ?>
                                            <button type="button" class="btn btn-success btn-sm" title="Approve" 
                                                    onclick="changeStatus(<?= $permohonan['id'] ?>, 'approved')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" title="Reject" 
                                                    onclick="changeStatus(<?= $permohonan['id'] ?>, 'rejected')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <!-- Delete button - Always visible -->
                                        <button type="button" class="btn btn-danger btn-sm" title="Hapus" 
                                                onclick="confirmDelete(<?= $permohonan['id'] ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-3">Tidak ada data pengajuan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="pagination-container"></div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-5" style="display: none;">
                <i class="fas fa-file-signature fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada pengajuan</h5>
                <p class="text-muted">Belum ada pengajuan kerjasama yang masuk.</p>
            </div>
        </div>
    </div>
</div>

<!-- View File Modal -->
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

<!-- Detail Permohonan Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Permohonan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Update Status Permohonan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="statusForm">
                    <input type="hidden" id="permohonanId" name="id">
                    <input type="hidden" id="newStatus" name="status">
                    <!-- Hapus field catatan -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitStatusUpdate()">Update Status</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Pagination variables
let currentPage = 1;
let currentFilter = 'all';
let currentSearch = '';
const itemsPerPage = 10;

// Load data from PHP
let permohonanData = <?= json_encode($pengajuanData ?? []) ?>;

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    setupEventListeners();
    // Don't auto-call displayPage to preserve server pagination
    // setTimeout(() => {
    //     displayPage(1);
    // }, 100);
});

function setupEventListeners() {
    // Search functionality with pagination
    document.getElementById('searchInput').addEventListener('keyup', function() {
        currentSearch = this.value.toLowerCase();
        currentPage = 1; // Reset to first page
        displayPage(currentPage);
    });

    // Filter tabs with pagination
    document.querySelectorAll('[data-filter]').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            currentFilter = this.dataset.filter;
            currentPage = 1; // Reset to first page
            
            // Update active tab
            document.querySelectorAll('[data-filter]').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            displayPage(currentPage);
        });
    });
}

// Function to get all visible rows based on current search and filter
function getFilteredRows() {
    const tableRows = document.querySelectorAll('#permohonanTableBody tr');
    const filteredRows = [];
    
    tableRows.forEach(row => {
        let showRow = true;
        
        // Skip empty message row
        if (row.cells.length < 7) {
            return;
        }
        
        // Apply search filter
        if (currentSearch) {
            const lembaga = row.cells[2].textContent.toLowerCase();
            const kontak = row.cells[3].textContent.toLowerCase();
            
            if (!lembaga.includes(currentSearch) && !kontak.includes(currentSearch)) {
                showRow = false;
            }
        }
        
        // Apply status filter
        if (currentFilter !== 'all' && showRow) {
            const status = row.dataset.status;
            if (status !== currentFilter) {
                showRow = false;
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
    const allRows = document.querySelectorAll('#permohonanTableBody tr');
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

// Function to update pagination controls - disabled to preserve server pagination
function updatePaginationControls(totalPages, totalItems) {
    // Keep server-side pagination intact
    return;
}

// Helper functions
function getStatusClass(status) {
    switch(status) {
        case 'pending': return 'bg-warning text-dark';
        case 'review': return 'bg-info';
        case 'approved': return 'bg-success';
        case 'rejected': return 'bg-danger';
        default: return 'bg-secondary';
    }
}

function getStatusIcon(status) {
    switch(status) {
        case 'pending': return 'clock';
        case 'review': return 'search';
        case 'approved': return 'check';
        case 'rejected': return 'times';
        default: return 'question';
    }
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID') + ' ' + date.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// View File function
function viewFile(filename) {
    const fileUrl = `<?= base_url('uploads/formulir/') ?>${filename}`;
    document.getElementById('fileViewer').src = fileUrl;
    document.getElementById('downloadLink').href = fileUrl;
    
    const modal = new bootstrap.Modal(document.getElementById('viewFileModal'));
    modal.show();
}

// Download File function
function downloadFile(filename) {
    const fileUrl = `<?= base_url('uploads/formulir/') ?>${filename}`;
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

// View Detail - Fixed function name
function showDetail(id) {
    const permohonan = permohonanData.find(item => item.id == id);
    if (!permohonan) return;
    
    const modalBody = document.getElementById('detailModalBody');
    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <h6>Informasi Permohonan</h6>
                <table class="table table-sm">
                    <tr><td>Jenis Permohonan</td><td>: ${permohonan.jenis_permohonan.charAt(0).toUpperCase() + permohonan.jenis_permohonan.slice(1)}</td></tr>
                    <tr><td>Lembaga</td><td>: ${escapeHtml(permohonan.lembaga)}</td></tr>
                    <tr><td>Status</td><td>: <span class="badge ${getStatusClass(permohonan.status)}">${permohonan.status.charAt(0).toUpperCase() + permohonan.status.slice(1)}</span></td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6>Informasi Kontak</h6>
                <table class="table table-sm">
                    <tr><td>Telepon</td><td>: ${escapeHtml(permohonan.telepon)}</td></tr>
                    <tr><td>Email</td><td>: ${escapeHtml(permohonan.email)}</td></tr>
                    <tr><td>Alamat</td><td>: ${escapeHtml(permohonan.alamat)}</td></tr>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h6>Kontak yang dapat dihubungi</h6>
                <p>${escapeHtml(permohonan.kontak_dapat_dihubungi)}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h6>Formulir</h6>
                ${permohonan.file_formulir ? `
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="viewFile('${permohonan.file_formulir}')">
                            <i class="fas fa-file-alt"></i> Lihat File
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="downloadFile('${permohonan.file_formulir}')">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                ` : '<p class="text-muted">Tidak ada file yang diupload</p>'}
            </div>
        </div>
        ${permohonan.catatan ? `
        <div class="row mt-3">
            <div class="col-12">
                <h6>Catatan</h6>
                <p class="text-muted">${escapeHtml(permohonan.catatan)}</p>
            </div>
        </div>
        ` : ''}
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}

// Change Status - Simple implementation
function changeStatus(id, status) {
    const confirmMessage = `Apakah Anda yakin ingin mengubah status menjadi ${status}?`;
    if (confirm(confirmMessage)) {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('status', status);
        
        fetch('<?= base_url('admin/permohonan/update-status') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.status) {
                showAlert('success', result.message);
                location.reload(); // Reload page to show updated data
            } else {
                showAlert('danger', result.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat memperbarui status');
        });
    }
}

// Confirm Delete
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus permohonan ini?')) {
        const formData = new FormData();
        formData.append('id', id);
        
        fetch('<?= base_url('admin/permohonan/delete') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.status) {
                showAlert('success', result.message);
                location.reload(); // Reload page to show updated data
            } else {
                showAlert('danger', result.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat menghapus permohonan');
        });
    }
}

// View Detail - Keep old function for compatibility
function viewDetail(id) {
    showDetail(id);
}

// Update Status
function updateStatus(id, status) {
    document.getElementById('permohonanId').value = id;
    document.getElementById('newStatus').value = status;
    
    let modalTitle = '';
    switch(status) {
        case 'review':
            modalTitle = 'Set Status Review';
            break;
        case 'approved':
            modalTitle = 'Approve Permohonan';
            break;
        case 'rejected':
            modalTitle = 'Reject Permohonan';
            break;
    }
    
    document.getElementById('statusModalLabel').textContent = modalTitle;
    
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
}

// Submit Status Update
function submitStatusUpdate() {
    const formData = new FormData(document.getElementById('statusForm'));
    
    fetch('<?= base_url('admin/permohonan/update-status') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.status) {
            showAlert('success', result.message);
            loadPermohonanData(); // Reload data
            bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
        } else {
            showAlert('danger', result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat memperbarui status');
    });
}

// Delete Permohonan
function deletePermohonan(id) {
    if (confirm('Apakah Anda yakin ingin menghapus permohonan ini?')) {
        const formData = new FormData();
        formData.append('id', id);
        
        fetch('<?= base_url('admin/permohonan/delete') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.status) {
                showAlert('success', result.message);
                loadPermohonanData(); // Reload data
            } else {
                showAlert('danger', result.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat menghapus permohonan');
        });
    }
}

// Show Alert Function
function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.container-fluid').firstChild);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>
<script src="<?= base_url('js/components/pagination.js') ?>"></script>
<?= $this->endSection() ?>