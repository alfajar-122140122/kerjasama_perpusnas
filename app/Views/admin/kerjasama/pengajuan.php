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
                            <div class="h5" id="pendingCount">0</div>
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
                            <div class="h5" id="reviewCount">0</div>
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
                            <div class="h5" id="approvedCount">0</div>
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
                            <div class="h5" id="rejectedCount">0</div>
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
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Jenis Permohonan</th>
                            <th>Lembaga</th>
                            <th>Unit Terkait</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="permohonanTableBody">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
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
                    
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3" 
                                  placeholder="Masukkan catatan jika diperlukan..."></textarea>
                    </div>
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
let currentFilter = 'all';
let permohonanData = [];

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadPermohonanData();
    setupEventListeners();
});

function setupEventListeners() {
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        filterTable();
    });

    // Filter tabs
    document.querySelectorAll('[data-filter]').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            currentFilter = this.dataset.filter;
            
            // Update active tab
            document.querySelectorAll('[data-filter]').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            filterTable();
        });
    });
}

function loadPermohonanData() {
    fetch('<?= base_url('admin/permohonan') ?>', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.status) {
            permohonanData = result.data;
            updateSummary(result.summary);
            renderTable();
        } else {
            showAlert('danger', 'Gagal memuat data permohonan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat memuat data');
    });
}

function updateSummary(summary) {
    document.getElementById('pendingCount').textContent = summary.pending;
    document.getElementById('reviewCount').textContent = summary.review;
    document.getElementById('approvedCount').textContent = summary.approved;
    document.getElementById('rejectedCount').textContent = summary.rejected;
}

function renderTable() {
    const tbody = document.getElementById('permohonanTableBody');
    const emptyState = document.getElementById('emptyState');
    
    if (permohonanData.length === 0) {
        tbody.innerHTML = '';
        emptyState.style.display = 'block';
        return;
    }
    
    emptyState.style.display = 'none';
    
    let html = '';
    permohonanData.forEach((item, index) => {
        const statusClass = getStatusClass(item.status);
        const statusIcon = getStatusIcon(item.status);
        
        html += `
            <tr data-status="${item.status}">
                <td>${index + 1}</td>
                <td>
                    <span class="badge bg-primary">
                        ${item.jenis_permohonan.charAt(0).toUpperCase() + item.jenis_permohonan.slice(1)}
                    </span>
                </td>
                <td>${escapeHtml(item.lembaga)}</td>
                <td><small class="text-muted">${escapeHtml(item.unit_terkait)}</small></td>
                <td>
                    <div>
                        <div><i class="fas fa-phone me-1"></i>${escapeHtml(item.telepon)}</div>
                        <div><i class="fas fa-envelope me-1"></i>${escapeHtml(item.email)}</div>
                    </div>
                </td>
                <td>
                    <span class="badge ${statusClass}">
                        <i class="fas fa-${statusIcon} me-1"></i>
                        ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                    </span>
                </td>
                <td>
                    <small class="text-muted">
                        ${formatDate(item.tanggal_pengajuan)}
                    </small>
                </td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-info btn-sm" title="Lihat Detail" 
                                onclick="viewDetail(${item.id})">
                            <i class="fas fa-eye"></i>
                        </button>
                        ${item.status === 'pending' ? `
                        <button type="button" class="btn btn-warning btn-sm" title="Set Review" 
                                onclick="updateStatus(${item.id}, 'review')">
                            <i class="fas fa-search"></i>
                        </button>
                        ` : ''}
                        ${['pending', 'review'].includes(item.status) ? `
                        <button type="button" class="btn btn-success btn-sm" title="Approve" 
                                onclick="updateStatus(${item.id}, 'approved')">
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" title="Reject" 
                                onclick="updateStatus(${item.id}, 'rejected')">
                            <i class="fas fa-times"></i>
                        </button>
                        ` : ''}
                        <button type="button" class="btn btn-outline-danger btn-sm" title="Delete" 
                                onclick="deletePermohonan(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function filterTable() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#permohonanTableBody tr');
    
    rows.forEach(row => {
        const status = row.dataset.status;
        const lembaga = row.cells[2]?.textContent.toLowerCase() || '';
        const unitTerkait = row.cells[3]?.textContent.toLowerCase() || '';
        const kontak = row.cells[4]?.textContent.toLowerCase() || '';
        
        const matchesFilter = currentFilter === 'all' || status === currentFilter;
        const matchesSearch = lembaga.includes(searchTerm) || unitTerkait.includes(searchTerm) || kontak.includes(searchTerm);
        
        row.style.display = matchesFilter && matchesSearch ? '' : 'none';
    });
}

function getStatusClass(status) {
    switch(status) {
        case 'pending': return 'bg-warning';
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

// View Detail
function viewDetail(id) {
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
                    <tr><td>Unit Terkait</td><td>: ${escapeHtml(permohonan.unit_terkait)}</td></tr>
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
<?= $this->endSection() ?>