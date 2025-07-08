/**
 * Kerjasama Management JavaScript
 * For admin kerjasama management interface
 */

// Global variables
const baseUrl = window.location.origin;
let map = null;
let marker = null;
let currentPage = 1;
let totalPages = 1;
let itemsPerPage = 10;
let currentView = 'all';

// Document ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize
    loadStats();
    loadKerjasamaData();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize progress bar in form
    document.getElementById('progress').addEventListener('input', updateProgressBar);
    
    // Initialize tabs/views
    setupViews();
    
    // Setup conditional form fields
    setupConditionalFormFields();
    
    // Setup filter functionality
    setupFilters();
});

/**
 * Setup all event listeners
 */
function setupEventListeners() {
    // View tabs
    document.querySelectorAll('#viewTabs .nav-link').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active tab
            document.querySelectorAll('#viewTabs .nav-link').forEach(t => {
                t.classList.remove('active');
            });
            this.classList.add('active');
            
            // Set current view and reload data
            currentView = this.getAttribute('data-view');
            currentPage = 1;
            
            // Show/hide appropriate tables
            switchTableView();
            
            // Load data with the new view
            loadKerjasamaData();
        });
    });
    
    // Setup filter functionality
    setupFilters();
    
    // Add kerjasama button
    document.getElementById('addKerjasamaBtn').addEventListener('click', function() {
        resetForm();
        document.getElementById('kerjasamaModalLabel').textContent = 'Tambah Kerjasama';
        document.getElementById('kerjasamaForm').setAttribute('data-mode', 'add');
    });
    
    // Save kerjasama button
    document.getElementById('saveKerjasamaBtn').addEventListener('click', saveKerjasama);
    
    // Edit from detail button
    document.getElementById('editFromDetailBtn').addEventListener('click', function() {
        const id = document.getElementById('detail_id').textContent;
        getKerjasamaDetail(id, true);
        
        // Hide detail modal and show edit modal
        const detailModal = bootstrap.Modal.getInstance(document.getElementById('detailKerjasamaModal'));
        detailModal.hide();
        
        setTimeout(() => {
            const editModal = new bootstrap.Modal(document.getElementById('kerjasamaModal'));
            editModal.show();
        }, 500);
    });
    
    // Delete confirmation
    document.getElementById('confirmDeleteBtn').addEventListener('click', deleteKerjasama);
    
    // Filter change events
    document.getElementById('filterJenis').addEventListener('change', function() {
        currentPage = 1;
        loadKerjasamaData();
    });
    
    document.getElementById('filterStartDate').addEventListener('change', function() {
        currentPage = 1;
        loadKerjasamaData();
    });
    
    document.getElementById('filterEndDate').addEventListener('change', function() {
        currentPage = 1;
        loadKerjasamaData();
    });
    
    // Search input - on enter key
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            currentPage = 1;
            loadKerjasamaData();
        }
    });
    
    // Add lingkup filter change handler
    document.getElementById('filterLingkup').addEventListener('change', function() {
        if (this.value === 'internasional') {
            document.getElementById('filterRegionContainer').style.display = 'block';
        } else {
            document.getElementById('filterRegionContainer').style.display = 'none';
            document.getElementById('filterRegion').value = '';
        }
        
        currentPage = 1;
        loadKerjasamaData();
    });
    
    // Region filter change
    document.getElementById('filterRegion').addEventListener('change', function() {
        currentPage = 1;
        loadKerjasamaData();
    });
    
    // Setup form tabs
    setupFormTabs();
}

/**
 * Load stats for dashboard cards
 */
function loadStats() {
    fetch(`${baseUrl}/admin/kerjasama/getStats`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            document.getElementById('totalKerjasama').textContent = data.data.total;
            document.getElementById('activeKerjasama').textContent = data.data.active;
            document.getElementById('expiredKerjasama').textContent = data.data.expired;
            document.getElementById('thisMonthKerjasama').textContent = data.data.this_month;
        }
    })
    .catch(error => {
        console.error('Error loading stats:', error);
        showAlert('Gagal memuat data statistik', 'danger');
    });
}

/**
 * Load kerjasama data with filtering and pagination
 */
function loadKerjasamaData() {
    // Get filter values
    const jenis = document.getElementById('filterJenis').value;
    const startDate = document.getElementById('filterStartDate').value;
    const endDate = document.getElementById('filterEndDate').value;
    const searchTerm = document.getElementById('searchInput').value;
    const lingkup = document.getElementById('filterLingkup') ? document.getElementById('filterLingkup').value : '';
    const region = document.getElementById('filterRegion') ? document.getElementById('filterRegion').value : '';
    const status = document.getElementById('filterStatus') ? document.getElementById('filterStatus').value : '';
    
    // Construct query parameters
    const params = new URLSearchParams({
        page: currentPage,
        limit: itemsPerPage,
        view: currentView
    });
    
    if (jenis) params.append('jenis', jenis);
    if (startDate) params.append('startDate', startDate);
    if (endDate) params.append('endDate', endDate);
    if (searchTerm) params.append('search', searchTerm);
    if (lingkup) params.append('lingkup', lingkup);
    if (region && lingkup === 'internasional') params.append('region', region);
    if (status) params.append('status', status);
    
    // Show loading state
    document.getElementById('kerjasamaTableBody').innerHTML = '<tr><td colspan="10" class="text-center">Loading...</td></tr>';
    if (document.getElementById('implementasiTableBody')) {
        document.getElementById('implementasiTableBody').innerHTML = '<tr><td colspan="7" class="text-center">Loading...</td></tr>';
    }
    if (document.getElementById('progressTableBody')) {
        document.getElementById('progressTableBody').innerHTML = '<tr><td colspan="6" class="text-center">Loading...</td></tr>';
    }
    
    fetch(`${baseUrl}/admin/kerjasama/getAll?${params.toString()}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            // Update pagination info
            totalPages = data.pagination.lastPage;
            currentPage = data.pagination.currentPage;
            
            // Update pagination UI
            updatePagination(data.pagination);
            
            // Render table based on current view
            switch (currentView) {
                case 'implementasi':
                    renderImplementasiTable(data.data);
                    break;
                case 'progress':
                    renderProgressTable(data.data);
                    break;
                case 'akan-berakhir':
                case 'all':
                default:
                    renderKerjasamaTable(data.data);
                    break;
            }
        } else {
            showAlert('Gagal memuat data kerjasama', 'danger');
        }
    })
    .catch(error => {
        console.error('Error loading kerjasama data:', error);
        showAlert('Gagal memuat data kerjasama', 'danger');
    });
}

/**
 * Render the implementasi table
 */
function renderImplementasiTable(data) {
    const tableBody = document.getElementById('implementasiTableBody');
    tableBody.innerHTML = '';
    
    if (data.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Tidak ada data implementasi ditemukan</td></tr>';
        return;
    }
    
    data.forEach((item, index) => {
        const row = document.createElement('tr');
        
        // Create lingkup badge
        const lingkupBadge = item.lingkup === 'internasional' 
            ? '<span class="badge bg-info">Internasional</span>' 
            : '<span class="badge bg-primary">Nasional</span>';
        
        // Format implementasi list
        let implementasiHtml = '<ul class="implementasi-list mb-0">';
        
        if (item.implementasi_array && item.implementasi_array.length > 0) {
            item.implementasi_array.forEach(imp => {
                if (imp && imp.trim() !== '') {
                    implementasiHtml += `<li>${imp}</li>`;
                }
            });
        } else {
            implementasiHtml += '<li>Belum ada implementasi</li>';
        }
        
        implementasiHtml += '</ul>';
        
        row.innerHTML = `
            <td>${(currentPage - 1) * itemsPerPage + index + 1}</td>
            <td>${item.nama_mitra}</td>
            <td>${item.masa_berlaku || `${new Date(item.tanggal_mulai).toLocaleDateString('id-ID')} - ${new Date(item.tanggal_selesai).toLocaleDateString('id-ID')}`}</td>
            <td>${implementasiHtml}</td>
            <td>${lingkupBadge}</td>
            <td>${item.unit_kerja || '-'}</td>
            <td>
                <button type="button" class="btn btn-sm btn-info action-btn" onclick="viewKerjasamaDetail('${item.id_kerjasama}')">
                    <i class="fas fa-eye"></i>
                </button>
                <button type="button" class="btn btn-sm btn-warning action-btn" onclick="editKerjasama('${item.id_kerjasama}')">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        `;
        
        tableBody.appendChild(row);
    });
}

/**
 * Render the progress table
 */
function renderProgressTable(data) {
    const tableBody = document.getElementById('progressTableBody');
    tableBody.innerHTML = '';
    
    if (data.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data progress ditemukan</td></tr>';
        return;
    }
    
    data.forEach((item, index) => {
        const row = document.createElement('tr');
        
        // Format date
        const pengajuanDate = item.tanggal_pengajuan 
            ? new Date(item.tanggal_pengajuan).toLocaleDateString('id-ID') 
            : new Date(item.created_at).toLocaleDateString('id-ID');
        
        // Create progress badge and label
        const progress = item.progress || 0;
        let progressClass = 'bg-danger';
        let progressLabel = 'Pembahasan';
        
        if (progress >= 70) {
            progressClass = 'bg-success';
            progressLabel = 'Selesai';
        } else if (progress >= 40) {
            progressClass = 'bg-warning';
            progressLabel = 'Proses';
        }
        
        row.innerHTML = `
            <td>${(currentPage - 1) * itemsPerPage + index + 1}</td>
            <td>${pengajuanDate}</td>
            <td>${item.nama_mitra}</td>
            <td><span class="badge bg-primary">${item.jenis}</span></td>
            <td>
                <div class="progress">
                    <div class="progress-bar ${progressClass}" role="progressbar" style="width: ${progress}%" 
                         aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="mt-1 d-block">${progressLabel} - ${progress}%</small>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-info action-btn" onclick="viewKerjasamaDetail('${item.id_kerjasama}')">
                    <i class="fas fa-eye"></i>
                </button>
                <button type="button" class="btn btn-sm btn-warning action-btn" onclick="editKerjasama('${item.id_kerjasama}')">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        `;
        
        tableBody.appendChild(row);
    });
}

/**
 * Render table with data
 */
function renderKerjasamaTable(data, view = 'all') {
    const tableBody = document.getElementById('kerjasamaTableBody');
    let html = '';
    
    if (data.length === 0) {
        html = '<tr><td colspan="8" class="text-center">Tidak ada data yang ditemukan</td></tr>';
    } else {
        const startNumber = (currentPage - 1) * itemsPerPage + 1;
        
        data.forEach((item, index) => {
            const number = startNumber + index;
            const startDate = formatDate(item.tanggal_mulai);
            const endDate = formatDate(item.tanggal_selesai);
            const progress = item.progress ?? 0;
            
            // Create progress badge with color based on value
            let progressClass = 'bg-danger';
            if (progress >= 75) {
                progressClass = 'bg-success';
            } else if (progress >= 50) {
                progressClass = 'bg-info';
            } else if (progress >= 25) {
                progressClass = 'bg-warning';
            }
            
            // Status badge
            const statusClass = item.status === 'Aktif' ? 'status-active' : 'status-expired';
            
            // Calculate days remaining for "akan berakhir" view
            let daysRemainingDisplay = '';
            if (view === 'akan-berakhir' && item.status === 'Aktif') {
                const today = new Date();
                const endDateObj = new Date(item.tanggal_selesai);
                const daysRemaining = Math.ceil((endDateObj - today) / (1000 * 60 * 60 * 24));
                
                daysRemainingDisplay = `
                <div class="days-remaining mt-1">
                    <span class="badge bg-warning">Berakhir dalam ${daysRemaining} hari</span>
                </div>`;
            }
            
            // Add implementation notes for "implementasi" view
            let implementasiDisplay = '';
            if (view === 'implementasi') {
                implementasiDisplay = `
                <div class="implementasi-status mt-2">
                    <span class="badge ${progress < 50 ? 'bg-warning' : 'bg-info'}">
                        ${progress < 50 ? 'Implementasi Awal' : 'Implementasi Lanjutan'}
                    </span>
                </div>`;
            }
            
            html += `
            <tr>
                <td class="text-center">${number}</td>
                <td>
                    ${item.nama_mitra}
                    ${daysRemainingDisplay}
                </td>
                <td>${item.jenis}</td>
                <td>${startDate}</td>
                <td>${endDate}</td>
                <td>
                    <div class="progress">
                        <div class="progress-bar ${progressClass}" role="progressbar" style="width: ${progress}%;" 
                             aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <small class="d-block mt-1 text-center">${progress}%</small>
                    ${implementasiDisplay}
                </td>
                <td><span class="status-badge ${statusClass}">${item.status}</span></td>
                <td class="text-center">
                    <button type="button" class="btn btn-info btn-sm action-btn" onclick="viewKerjasama(${item.id_kerjasama})">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-warning btn-sm action-btn" onclick="editKerjasama(${item.id_kerjasama})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm action-btn" onclick="confirmDelete(${item.id_kerjasama}, '${item.nama_mitra}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>`;
        });
    }
    
    tableBody.innerHTML = html;
}

/**
 * Render pagination controls
 */
function renderPagination(pagination) {
    const paginationContainer = document.getElementById('pagination');
    const totalItems = pagination.total;
    totalPages = pagination.lastPage;
    currentPage = pagination.currentPage;
    
    let html = '';
    
    // Previous button
    html += `
    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="javascript:void(0);" onclick="changePage(${currentPage - 1})">
            <i class="fas fa-chevron-left"></i>
        </a>
    </li>`;
    
    // Page numbers
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, startPage + 4);
    
    for (let i = startPage; i <= endPage; i++) {
        html += `
        <li class="page-item ${i === currentPage ? 'active' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="changePage(${i})">${i}</a>
        </li>`;
    }
    
    // Next button
    html += `
    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="javascript:void(0);" onclick="changePage(${currentPage + 1})">
            <i class="fas fa-chevron-right"></i>
        </a>
    </li>`;
    
    paginationContainer.innerHTML = html;
    
    // Update showing info
    const start = totalItems === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
    const end = Math.min(start + itemsPerPage - 1, totalItems);
    
    document.getElementById('showingStart').textContent = start;
    document.getElementById('showingEnd').textContent = end;
    document.getElementById('totalItems').textContent = totalItems;
}

/**
 * Change page and reload data
 */
function changePage(page) {
    if (page < 1 || page > totalPages) {
        return;
    }
    
    currentPage = page;
    loadKerjasamaData();
}

/**
 * View kerjasama details
 */
function viewKerjasama(id) {
    getKerjasamaDetail(id, false);
    
    const modal = new bootstrap.Modal(document.getElementById('detailKerjasamaModal'));
    modal.show();
}

/**
 * Edit kerjasama
 */
function editKerjasama(id) {
    resetForm();
    document.getElementById('kerjasamaModalLabel').textContent = 'Edit Kerjasama';
    document.getElementById('kerjasamaForm').setAttribute('data-mode', 'edit');
    
    getKerjasamaDetail(id, true);
    
    const modal = new bootstrap.Modal(document.getElementById('kerjasamaModal'));
    modal.show();
}

/**
 * Get detail data for a specific kerjasama record
 */
function getKerjasamaDetail(id, forEdit = false) {
    fetch(`${baseUrl}/admin/kerjasama/getOne?id=${id}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(response => {
        if (response.status) {
            const data = response.data;
            
            if (forEdit) {
                populateEditForm(data);
            } else {
                populateDetailView(data);
                
                // Initialize map for location
                initializeDetailMap(data);
                
                // Show detail modal
                const detailModal = new bootstrap.Modal(document.getElementById('detailKerjasamaModal'));
                detailModal.show();
            }
        } else {
            showAlert('Gagal memuat detail kerjasama', 'danger');
        }
    })
    .catch(error => {
        console.error('Error fetching kerjasama detail:', error);
        showAlert('Gagal memuat detail kerjasama', 'danger');
    });
}

/**
 * Populate edit form with data
 */
function populateEditForm(data) {
    // Reset form validation
    resetFormValidation();
    
    // Set form mode to edit
    document.getElementById('kerjasamaModalLabel').textContent = 'Edit Kerjasama';
    document.getElementById('kerjasamaForm').setAttribute('data-mode', 'edit');
    
    // Fill form fields
    document.getElementById('id_kerjasama').value = data.id_kerjasama;
    document.getElementById('nama_mitra').value = data.nama_mitra;
    document.getElementById('ruang_lingkup').value = data.ruang_lingkup;
    document.getElementById('tanggal_mulai').value = data.tanggal_mulai;
    document.getElementById('tanggal_selesai').value = data.tanggal_selesai;
    document.getElementById('jenis').value = data.jenis;
    document.getElementById('progress').value = data.progress ?? 0;
    document.getElementById('lingkup').value = data.lingkup || '';
    document.getElementById('status').value = data.status || 'aktif';
    document.getElementById('lokasi_mitra').value = data.lokasi_mitra || '';
    document.getElementById('unit_kerja').value = data.unit_kerja || '';
    document.getElementById('kontak_nama').value = data.kontak_nama || '';
    document.getElementById('kontak_email').value = data.kontak_email || '';
    document.getElementById('kontak_telepon').value = data.kontak_telepon || '';
    
    // Handle implementasi (may be stored as JSON)
    if (data.implementasi) {
        try {
            // Try to parse as JSON first
            let implementasiArray = JSON.parse(data.implementasi);
            if (Array.isArray(implementasiArray)) {
                document.getElementById('implementasi').value = implementasiArray.join('\n');
            } else {
                document.getElementById('implementasi').value = data.implementasi;
            }
        } catch (e) {
            document.getElementById('implementasi').value = data.implementasi;
        }
    } else {
        document.getElementById('implementasi').value = '';
    }
    
    // Map coordinates
    document.getElementById('latitude').value = data.latitude || '';
    document.getElementById('longitude').value = data.longitude || '';
    
    // Handle conditional fields
    if (data.lingkup === 'internasional') {
        document.getElementById('regionContainer').style.display = 'block';
        document.getElementById('region').value = data.region || '';
    } else {
        document.getElementById('regionContainer').style.display = 'none';
        document.getElementById('region').value = '';
    }
    
    // Update progress bar
    updateProgressBar();
}

/**
 * Populate detail view with data
 */
function populateDetailView(data) {
    // Store ID in a hidden element for edit button
    if (!document.getElementById('detail_id')) {
        const idElement = document.createElement('span');
        idElement.id = 'detail_id';
        idElement.style.display = 'none';
        document.getElementById('detailKerjasamaModal').appendChild(idElement);
    }
    document.getElementById('detail_id').textContent = data.id_kerjasama;
    
    // Populate basic data
    document.getElementById('detail_nama_mitra').textContent = data.nama_mitra || '-';
    document.getElementById('detail_jenis').textContent = data.jenis || '-';
    document.getElementById('detail_tanggal_mulai').textContent = formatDate(data.tanggal_mulai);
    document.getElementById('detail_tanggal_selesai').textContent = formatDate(data.tanggal_selesai);
    
    // Status
    const statusText = data.status || (data.tanggal_selesai < new Date().toISOString().split('T')[0] ? 'Berakhir' : 'Aktif');
    document.getElementById('detail_status').textContent = capitalizeFirstLetter(statusText);
    document.getElementById('detail_status').className = 
        statusText === 'aktif' || statusText === 'Aktif' ? 'text-success' : 
        statusText === 'menunggu_perpanjangan' || statusText === 'Menunggu Perpanjangan' ? 'text-warning' : 'text-danger';
    
    // Ruang lingkup
    document.getElementById('detail_ruang_lingkup').textContent = data.ruang_lingkup || '-';
    
    // Lingkup (nasional/internasional)
    const lingkup = data.lingkup || '-';
    document.getElementById('detail_lingkup').textContent = capitalizeFirstLetter(lingkup);
    
    // Region (untuk internasional)
    const regionContainer = document.getElementById('detail_region_container');
    if (lingkup === 'internasional' && data.region) {
        document.getElementById('detail_region').textContent = capitalizeFirstLetter(data.region);
        regionContainer.style.display = 'block';
    } else {
        regionContainer.style.display = 'none';
    }
    
    // Unit kerja
    document.getElementById('detail_unit_kerja').textContent = data.unit_kerja || '-';
    
    // Implementasi
    const implementasiContainer = document.getElementById('detail_implementasi');
    implementasiContainer.innerHTML = '';
    
    if (data.implementasi) {
        // Parse implementasi (either JSON array or newline-separated string)
        let implementasiArray = [];
        
        // Check if we already have implementasi_array from controller
        if (data.implementasi_array && Array.isArray(data.implementasi_array)) {
            implementasiArray = data.implementasi_array;
        } else {
            try {
                // Try parsing as JSON
                const parsed = JSON.parse(data.implementasi);
                if (Array.isArray(parsed)) {
                    implementasiArray = parsed;
                } else {
                    implementasiArray = [data.implementasi];
                }
            } catch (e) {
                // If not valid JSON, split by newline
                implementasiArray = data.implementasi.split('\n').filter(line => line.trim() !== '');
            }
        }
        
        if (implementasiArray.length > 0) {
            implementasiArray.forEach(item => {
                if (item && item.trim() !== '') {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = item;
                    implementasiContainer.appendChild(li);
                }
            });
        } else {
            const li = document.createElement('li');
            li.className = 'list-group-item';
            li.textContent = 'Tidak ada data implementasi';
            implementasiContainer.appendChild(li);
        }
    } else {
        const li = document.createElement('li');
        li.className = 'list-group-item';
        li.textContent = 'Tidak ada data implementasi';
        implementasiContainer.appendChild(li);
    }
    
    // Kontak info
    document.getElementById('detail_kontak_nama').textContent = data.kontak_nama || '-';
    document.getElementById('detail_kontak_email').textContent = data.kontak_email || '-';
    document.getElementById('detail_kontak_telepon').textContent = data.kontak_telepon || '-';
    
    // Lokasi
    document.getElementById('detail_lokasi_mitra').textContent = data.lokasi_mitra || '-';
    
    // Progress
    const progress = data.progress ?? 0;
    document.getElementById('detail_progress').textContent = `${progress}%`;
    document.getElementById('detail_progress_bar').style.width = `${progress}%`;
    
    // Set progress bar color
    let progressClass = 'bg-danger';
    if (progress >= 75) {
        progressClass = 'bg-success';
    } else if (progress >= 50) {
        progressClass = 'bg-info';
    } else if (progress >= 25) {
        progressClass = 'bg-warning';
    }
    document.getElementById('detail_progress_bar').className = `progress-bar ${progressClass}`;
}

/**
 * Helper function to capitalize first letter of a string
 */
function capitalizeFirstLetter(string) {
    if (!string || string === '-') return string;
    
    // Handle special case for status values with underscores
    if (string.includes('_')) {
        return string.split('_')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
            .join(' ');
    }
    
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

/**
 * Show/hide tables based on current view
 */
function switchTableView() {
    // Hide all tables first
    document.querySelectorAll('.view-table').forEach(table => {
        table.style.display = 'none';
    });
    
    // Show the appropriate table
    switch (currentView) {
        case 'implementasi':
            document.getElementById('implementasiTable').style.display = 'table';
            break;
        case 'progress':
            document.getElementById('progressTable').style.display = 'table';
            break;
        case 'akan-berakhir':
        case 'all':
        default:
            document.getElementById('kerjasamaTable').style.display = 'table';
            break;
    }
}

/**
 * Setup view tabs
 */
function setupViews() {
    // Set default view
    currentView = 'all';
    
    // Show default table view
    switchTableView();
}

/**
 * Setup form tabs and validation
 */
function setupFormTabs() {
    // Validate current tab before moving to the next
    document.querySelectorAll('#formTabs .nav-link').forEach(tab => {
        tab.addEventListener('click', function(e) {
            // Don't validate when clicking the current tab
            if (this.classList.contains('active')) {
                return;
            }
            
            // Get current active tab
            const currentActiveTab = document.querySelector('#formTabs .nav-link.active');
            const currentTabPane = document.querySelector(currentActiveTab.getAttribute('data-bs-target'));
            
            // Validate required fields in the current tab
            let isValid = true;
            currentTabPane.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    document.getElementById(`${field.id}_feedback`).textContent = 'Field ini harus diisi';
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            // If current tab is not valid, prevent tab change
            if (!isValid) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        });
    });
    
    // Auto-switch to appropriate tab when opening edit modal
    document.getElementById('kerjasamaModal').addEventListener('shown.bs.modal', function() {
        // Default to first tab
        document.getElementById('info-tab').click();
    });
}

/**
 * Setup filter functionality
 */
function setupFilters() {
    // Show/hide Region filter based on Lingkup filter
    document.getElementById('filterLingkup').addEventListener('change', function() {
        if (this.value === 'internasional') {
            document.getElementById('filterRegionContainer').style.display = 'block';
        } else {
            document.getElementById('filterRegionContainer').style.display = 'none';
            document.getElementById('filterRegion').value = '';
        }
    });
    
    // Apply filter button
    document.getElementById('applyFilterBtn').addEventListener('click', function() {
        currentPage = 1;
        loadKerjasamaData();
    });
    
    // Clear filters
    document.getElementById('clearFilterBtn').addEventListener('click', function() {
        document.getElementById('filterJenis').value = '';
        document.getElementById('filterLingkup').value = '';
        document.getElementById('filterRegion').value = '';
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterStartDate').value = '';
        document.getElementById('filterEndDate').value = '';
        document.getElementById('searchInput').value = '';
        
        // Hide region filter
        document.getElementById('filterRegionContainer').style.display = 'none';
        
        // Reload data
        currentPage = 1;
        loadKerjasamaData();
    });
    
    // Search functionality
    document.getElementById('searchBtn').addEventListener('click', function() {
        currentPage = 1;
        loadKerjasamaData();
    });
    
    // Reset filters
    document.getElementById('resetFilterBtn').addEventListener('click', function() {
        document.getElementById('searchInput').value = '';
        currentPage = 1;
        loadKerjasamaData();
    });
    
    // Enter key for search
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            currentPage = 1;
            loadKerjasamaData();
        }
    });
}