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
                        // Data from controller (real database data)
                        if (empty($akanBerakhirData)) {
                            $akanBerakhirData = [];
                        }
                        ?>
                        
                        <?php foreach ($akanBerakhirData as $kerjasama): ?>
                        <tr data-sisa-hari="<?= $kerjasama['sisa_hari'] ?>" data-id="<?= $kerjasama['id'] ?>">
                            <td><?= esc($kerjasama['nama_mitra']) ?></td>
                            <td>
                                <span class="text-muted"><?= substr(esc($kerjasama['ruang_lingkup']), 0, 50) ?>...</span>
                            </td>
                            <td><?= $kerjasama['tanggal_mulai_formatted'] ?></td>
                            <td>
                                <span class="text-danger fw-bold"><?= $kerjasama['tanggal_berakhir_formatted'] ?></span>
                                <br>
                                <small class="text-warning">
                                    <i class="fas fa-clock me-1"></i><?= $kerjasama['sisa_hari'] ?> hari lagi
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat" onclick="viewKerjasama(<?= $kerjasama['id'] ?>)">
                                        <i class="fas fa-eye"></i>
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
                <h5 class="text-muted">Tidak ada kerjasama yang akan berakhir dalam 90 hari ke depan</h5>
                <p class="text-muted">Semua kerjasama masih dalam masa berlaku yang aman.</p>
            </div>
            <?php endif; ?>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted" id="paginationInfo">
                    <?php if (isset($pagination)): ?>
                        Menampilkan <?= $pagination['startItem'] ?>-<?= $pagination['endItem'] ?> dari <?= $pagination['totalItems'] ?> data
                    <?php else: ?>
                        Menampilkan 0 dari 0 data
                    <?php endif; ?>
                </div>
                <nav aria-label="Pagination Navigation">
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
                        <label class="form-label fw-bold">Sisa Waktu</label>
                        <p id="view_sisa_waktu" class="border-bottom pb-2 text-danger"></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Ruang Lingkup</label>
                        <p id="view_ruang_lingkup" class="border-bottom pb-2"></p>
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
        namaMitra: row.cells[0].textContent.toLowerCase(),
        lingkup: row.cells[1].textContent.toLowerCase(),
        sisaHari: parseInt(row.dataset.sisaHari || 0),
        id: row.dataset.id
    }));
    
    filteredData = [...allData];
    
    // Only add client-side pagination if there are more than 10 items on current server page
    if (allData.length === 10) {
        // This might be a full page, check if there are more pages from server
        updateClientPagination();
    }
    
    // Auto highlight rows based on remaining days
    highlightRowsByDays();
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
            item.namaMitra.includes(currentSearch) || 
            item.lingkup.includes(currentSearch);
        
        // Category filter
        let matchesFilter = true;
        if (currentFilter === '30-hari') {
            matchesFilter = item.sisaHari <= 30;
        } else if (currentFilter === '60-hari') {
            matchesFilter = item.sisaHari <= 60;
        } else if (currentFilter === '90-hari') {
            matchesFilter = item.sisaHari <= 90;
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

function highlightRowsByDays() {
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach(row => {
        const sisaHari = parseInt(row.dataset.sisaHari);
        
        if (sisaHari <= 30) {
            row.classList.add('table-danger');
        } else if (sisaHari <= 60) {
            row.classList.add('table-warning');
        }
    });
}

// View function
function viewKerjasama(id) {
    // Fetch data via AJAX
    fetch(`<?= base_url('admin/kerjasama/get/') ?>${id}`)
        .then(response => response.json())
        .then(result => {
            if (result.status) {
                const kerjasama = result.data;
                
                // Format dates for display
                const tanggalMulai = new Date(kerjasama.tanggal_mulai);
                const tanggalBerakhir = new Date(kerjasama.tanggal_berakhir);
                const formattedTanggalMulai = tanggalMulai.toLocaleDateString('id-ID', { 
                    day: '2-digit', month: '2-digit', year: 'numeric' 
                });
                const formattedTanggalBerakhir = tanggalBerakhir.toLocaleDateString('id-ID', { 
                    day: '2-digit', month: '2-digit', year: 'numeric' 
                });
                
                // Calculate days remaining
                const today = new Date();
                const diffTime = tanggalBerakhir - today;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                // Populate modal
                document.getElementById('view_nama_mitra').textContent = kerjasama.nama_mitra;
                document.getElementById('view_tanggal_mulai').textContent = formattedTanggalMulai;
                document.getElementById('view_tanggal_berakhir').textContent = formattedTanggalBerakhir;
                document.getElementById('view_sisa_waktu').textContent = `${diffDays} hari lagi`;
                document.getElementById('view_ruang_lingkup').textContent = kerjasama.ruang_lingkup;
                
                // Format created_at if available
                if (kerjasama.created_at) {
                    const createdAt = new Date(kerjasama.created_at);
                    document.getElementById('view_created_at').textContent = createdAt.toLocaleDateString('id-ID', { 
                        day: '2-digit', month: '2-digit', year: 'numeric', 
                        hour: '2-digit', minute: '2-digit' 
                    });
                } else {
                    document.getElementById('view_created_at').textContent = '-';
                }
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('lihatKerjasamaModal'));
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

// Edit function
function editKerjasama(id) {
    window.location.href = `<?= base_url('admin/kerjasama/edit/') ?>${id}`;
}

// Delete function
function deleteKerjasama(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data kerjasama ini?')) {
        // Perform AJAX delete request
        fetch(`<?= base_url('admin/kerjasama/delete/') ?>${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.status) {
                // Remove row from table
                document.querySelector(`tr[data-id="${id}"]`)?.remove();
                alert('Data kerjasama berhasil dihapus');
                // Reload page to show updated data
                window.location.reload();
            } else {
                alert(result.message || 'Gagal menghapus data');
            }
        })
        .catch(error => {
            console.error('Error deleting data:', error);
            alert('Terjadi kesalahan saat menghapus data');
        });
    }
}
</script>
<?= $this->endSection() ?>