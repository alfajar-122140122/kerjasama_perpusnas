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
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted" id="paginationInfo">
        <?php if (isset($pagination)): ?>
            Menampilkan <?= $pagination['startItem'] ?>-<?= $pagination['endItem'] ?> dari <?= $pagination['totalItems'] ?> data
        <?php else: ?>
            Menampilkan 0 dari 0 data
        <?php endif; ?>
    </div>
    <nav aria-label="Progress Pagination Navigation">
        <ul class="pagination pagination-sm mb-0" id="paginationControls">
            <?php if (isset($pagination) && $pagination['totalPages'] > 1): ?>
                <!-- Previous Button -->
                <li class="page-item <?= $pagination['currentPage'] == 1 ? 'disabled' : '' ?>">
                    <?php if ($pagination['currentPage'] == 1): ?>
                        <span class="page-link">Previous</span>
                    <?php else: ?>
                        <a class="page-link" href="<?= current_url() ?>?page=<?= $pagination['currentPage'] - 1 ?>">Previous</a>
                    <?php endif; ?>
                </li>
                
                <?php
                $startPage = max(1, $pagination['currentPage'] - 2);
                $endPage = min($pagination['totalPages'], $pagination['currentPage'] + 2);
                
                // Show first page if not in range
                if ($startPage > 1):
                ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= current_url() ?>?page=1">1</a>
                    </li>
                    <?php if ($startPage > 2): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                
                <!-- Page Numbers -->
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?= $i == $pagination['currentPage'] ? 'active' : '' ?>">
                        <?php if ($i == $pagination['currentPage']): ?>
                            <span class="page-link"><?= $i ?></span>
                        <?php else: ?>
                            <a class="page-link" href="<?= current_url() ?>?page=<?= $i ?>"><?= $i ?></a>
                        <?php endif; ?>
                    </li>
                <?php endfor; ?>
                
                <!-- Show last page if not in range -->
                <?php if ($endPage < $pagination['totalPages']): ?>
                    <?php if ($endPage < $pagination['totalPages'] - 1): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= current_url() ?>?page=<?= $pagination['totalPages'] ?>"><?= $pagination['totalPages'] ?></a>
                    </li>
                <?php endif; ?>
                
                <!-- Next Button -->
                <li class="page-item <?= $pagination['currentPage'] == $pagination['totalPages'] ? 'disabled' : '' ?>">
                    <?php if ($pagination['currentPage'] == $pagination['totalPages']): ?>
                        <span class="page-link">Next</span>
                    <?php else: ?>
                        <a class="page-link" href="<?= current_url() ?>?page=<?= $pagination['currentPage'] + 1 ?>">Next</a>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Global variables for pagination
let allData = [];
let filteredData = [];
let currentPage = 1;
let itemsPerPage = 10;
let currentFilter = 'all';
let currentSearch = '';

// Initialize data from PHP
document.addEventListener('DOMContentLoaded', function() {
    // Store all table rows as data
    const tableRows = document.querySelectorAll('tbody tr');
    allData = Array.from(tableRows).map(row => ({
        element: row,
        lembaga: row.cells[2].textContent.toLowerCase(),
        jenis: row.cells[3].textContent.toLowerCase(),
        status: row.cells[4].textContent.toLowerCase(),
        jenisData: row.dataset.jenis,
        statusData: row.dataset.status,
        id: row.querySelector('.row-checkbox')?.value
    }));
    
    filteredData = [...allData];
});

// Select All Checkbox
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Search functionality with pagination
document.getElementById('searchInput').addEventListener('keyup', function() {
    currentSearch = this.value.toLowerCase();
    filterAndPaginate();
});

// Filter functionality with pagination
document.querySelectorAll('[data-filter]').forEach(filterBtn => {
    filterBtn.addEventListener('click', function(e) {
        e.preventDefault();
        currentFilter = this.dataset.filter;
        
        // Update filter button text
        document.getElementById('filterDropdown').innerHTML = `<i class="fas fa-filter me-2"></i>${this.textContent}`;
        
        filterAndPaginate();
    });
});

function filterAndPaginate() {
    // Filter data based on search and filter criteria
    filteredData = allData.filter(item => {
        // Search filter
        const matchesSearch = !currentSearch || 
            item.lembaga.includes(currentSearch) || 
            item.jenis.includes(currentSearch) || 
            item.status.includes(currentSearch);
        
        // Category filter
        let matchesFilter = true;
        if (currentFilter !== 'all') {
            matchesFilter = item.jenisData === currentFilter || item.statusData === currentFilter;
        }
        
        return matchesSearch && matchesFilter;
    });
    
    // Reset to first page
    currentPage = 1;
    
    // Update display
    updateClientPagination();
    renderFilteredData();
}

function renderFilteredData() {
    const tbody = document.querySelector('tbody');
    
    // Hide all rows first
    allData.forEach(item => {
        item.element.style.display = 'none';
    });
    
    // Calculate which items to show
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageData = filteredData.slice(startIndex, endIndex);
    
    // Show filtered rows
    pageData.forEach(item => {
        item.element.style.display = '';
    });
    
    // Update pagination info
    updatePaginationInfo();
}

function updateClientPagination() {
    const totalItems = filteredData.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    
    // Only show pagination if there's filtering/searching happening
    if (currentSearch || currentFilter !== 'all') {
        renderClientPaginationControls(totalPages);
        renderFilteredData();
    } else {
        // Remove client pagination controls if no filtering
        const existingClientPagination = document.getElementById('clientPaginationControls');
        if (existingClientPagination) {
            existingClientPagination.remove();
        }
    }
}

function renderClientPaginationControls(totalPages) {
    if (totalPages <= 1) return;
    
    // Remove existing client pagination
    const existingClientPagination = document.getElementById('clientPaginationControls');
    if (existingClientPagination) {
        existingClientPagination.remove();
    }
    
    // Create new pagination controls
    const paginationContainer = document.querySelector('.mt-4');
    const clientPaginationDiv = document.createElement('div');
    clientPaginationDiv.id = 'clientPaginationControls';
    clientPaginationDiv.className = 'd-flex justify-content-between align-items-center mt-2 border-top pt-2';
    
    const startItem = filteredData.length > 0 ? (currentPage - 1) * itemsPerPage + 1 : 0;
    const endItem = Math.min(currentPage * itemsPerPage, filteredData.length);
    
    clientPaginationDiv.innerHTML = `
        <div class="text-muted">
            <small>Hasil filter: ${startItem}-${endItem} dari ${filteredData.length} data</small>
        </div>
        <nav aria-label="Client Pagination">
            <ul class="pagination pagination-sm mb-0" id="clientPagination">
                ${generateClientPaginationHTML(totalPages)}
            </ul>
        </nav>
    `;
    
    paginationContainer.appendChild(clientPaginationDiv);
    
    // Bind pagination events
    bindClientPaginationEvents();
}

function generateClientPaginationHTML(totalPages) {
    let html = '';
    
    // Previous button
    html += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link client-page-link" href="#" data-page="${currentPage - 1}" ${currentPage === 1 ? 'tabindex="-1"' : ''}>
                Previous
            </a>
        </li>
    `;
    
    // Page numbers
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, currentPage + 2);
    
    if (startPage > 1) {
        html += `<li class="page-item"><a class="page-link client-page-link" href="#" data-page="1">1</a></li>`;
        if (startPage > 2) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }
    
    for (let i = startPage; i <= endPage; i++) {
        html += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link client-page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `;
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
        html += `<li class="page-item"><a class="page-link client-page-link" href="#" data-page="${totalPages}">${totalPages}</a></li>`;
    }
    
    // Next button
    html += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link client-page-link" href="#" data-page="${currentPage + 1}" ${currentPage === totalPages ? 'tabindex="-1"' : ''}>
                Next
            </a>
        </li>
    `;
    
    return html;
}

function bindClientPaginationEvents() {
    document.querySelectorAll('.client-page-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            if (this.parentElement.classList.contains('disabled')) return;
            
            const page = parseInt(this.dataset.page);
            if (page > 0 && page <= Math.ceil(filteredData.length / itemsPerPage)) {
                currentPage = page;
                updateClientPagination();
            }
        });
    });
}

function updatePaginationInfo() {
    const totalItems = filteredData.length;
    const startItem = totalItems > 0 ? (currentPage - 1) * itemsPerPage + 1 : 0;
    const endItem = Math.min(currentPage * itemsPerPage, totalItems);
    
    const infoElement = document.getElementById('paginationInfo');
    if (currentSearch || currentFilter !== 'all') {
        infoElement.innerHTML = `Menampilkan ${startItem}-${endItem} dari ${totalItems} data yang difilter`;
    }
}

// View function
function viewProgress(id) {
    // Fetch progress data by ID
    fetch(`<?= base_url('admin/kerjasama/progress/get/') ?>${id}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.status) {
            const data = result.data;
            
            // Format the date
            const date = new Date(data.tanggal_pengajuan);
            const formattedDate = date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            
            // Create and show modal
            let modalHtml = `
                <div class="modal fade" id="viewProgressModal" tabindex="-1" aria-labelledby="viewProgressModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewProgressModalLabel">Detail Progress Kerjasama</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Lembaga</label>
                                        <p class="border-bottom pb-2">${data.lembaga}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Tanggal Pengajuan</label>
                                        <p class="border-bottom pb-2">${formattedDate}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Jenis</label>
                                        <p class="border-bottom pb-2">
                                            <span class="badge ${getJenisBadgeClass(data.jenis)}">${data.jenis}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Status Progress</label>
                                        <p class="border-bottom pb-2">
                                            <span class="badge ${getProgressBadgeClass(data.status)}">${data.status}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Progress</label>
                                        <p class="border-bottom pb-2">${data.progress || '-'}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if present
            const existingModal = document.getElementById('viewProgressModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('viewProgressModal'));
            modal.show();
            
        } else {
            alert('Data tidak ditemukan');
        }
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        alert('Terjadi kesalahan saat mengambil data');
    });
}

function getJenisBadgeClass(jenis) {
    switch(jenis) {
        case 'Baru': return 'bg-success';
        case 'Perpanjangan': return 'bg-info';
        case 'Dokumentasi': return 'bg-warning';
        case 'Finishing': return 'bg-primary';
        default: return 'bg-secondary';
    }
}

function getProgressBadgeClass(status) {
    switch(status) {
        case 'review': return 'bg-info';
        case 'approved': return 'bg-success';
        case 'rejected': return 'bg-danger';
        default: return 'bg-secondary';
    }
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
    
    const container = document.querySelector('.container-fluid');
    container.insertBefore(
        document.createRange().createContextualFragment(alertHtml).firstChild,
        container.firstChild
    );
    
    // Auto hide after 3 seconds
    setTimeout(function() {
        const alert = document.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 3000);
}
</script>
<?= $this->endSection() ?>