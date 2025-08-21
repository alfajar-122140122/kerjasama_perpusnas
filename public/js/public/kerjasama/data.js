class CooperationDataManager {
    constructor() {
        this.currentPage = 1;
        this.itemsPerPage = 20;
        this.searchTerm = '';
        this.allData = [];
        this.filteredData = [];
        
        this.init();
    }
    
    init() {
        this.loadInitialData();
        this.bindEvents();
        this.renderTable();
        this.renderPagination();
    }
    
    loadInitialData() {
        // Use data from PHP server
        this.allData = window.cooperationInitialData || [];
        this.filteredData = [...this.allData];
    }
    
    bindEvents() {
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        
        // Search functionality
        searchInput.addEventListener('input', (e) => {
            this.searchTerm = e.target.value.toLowerCase();
            this.filterData();
        });
        
        searchBtn.addEventListener('click', () => {
            this.filterData();
        });
        
        // Enter key search
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.filterData();
            }
        });
    }
    
    filterData() {
        this.showLoading();
        
        setTimeout(() => {
            this.filteredData = this.allData.filter(item => {
                if (!this.searchTerm) return true;
                
                return (
                    item.partner.toLowerCase().includes(this.searchTerm) ||
                    item.scope.toLowerCase().includes(this.searchTerm)
                );
            });
            
            this.currentPage = 1;
            this.renderTable();
            this.renderPagination();
            this.hideLoading();
        }, 500);
    }
    
    renderTable() {
        const tbody = document.getElementById('cooperationTableBody');
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        const pageData = this.filteredData.slice(startIndex, endIndex);
        
        if (pageData.length === 0) {
            this.showEmptyState();
            return;
        }
        
        this.hideEmptyState();
        
        tbody.innerHTML = pageData.map(item => `
            <tr>
                <td>
                    <div class="partner-name">${item.partner}</div>
                </td>
                <td>
                    <div class="scope-text">${item.scope}</div>
                </td>
                <td>
                    <div class="date-cell">${this.formatDate(item.startDate)}</div>
                </td>
                <td>
                    <div class="date-cell">${this.formatDate(item.endDate)}</div>
                </td>
            </tr>
        `).join('');
    }
    
    renderPagination() {
        const totalPages = Math.ceil(this.filteredData.length / this.itemsPerPage);
        const paginationList = document.getElementById('paginationList');
        
        if (totalPages <= 1) {
            paginationList.innerHTML = '';
            return;
        }
        
        let paginationHTML = '';
        
        // Previous button
        if (this.currentPage > 1) {
            paginationHTML += `
                <li>
                    <a href="#" data-page="${this.currentPage - 1}" aria-label="Previous">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            `;
        } else {
            paginationHTML += `
                <li class="disabled">
                    <span aria-label="Previous">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            `;
        }
        
        // Page numbers
        const startPage = Math.max(1, this.currentPage - 2);
        const endPage = Math.min(totalPages, this.currentPage + 2);
        
        if (startPage > 1) {
            paginationHTML += `<li><a href="#" data-page="1">1</a></li>`;
            if (startPage > 2) {
                paginationHTML += `<li class="disabled"><span>...</span></li>`;
            }
        }
        
        for (let i = startPage; i <= endPage; i++) {
            if (i === this.currentPage) {
                paginationHTML += `<li class="active"><span>${i}</span></li>`;
            } else {
                paginationHTML += `<li><a href="#" data-page="${i}">${i}</a></li>`;
            }
        }
        
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationHTML += `<li class="disabled"><span>...</span></li>`;
            }
            paginationHTML += `<li><a href="#" data-page="${totalPages}">${totalPages}</a></li>`;
        }
        
        // Next button
        if (this.currentPage < totalPages) {
            paginationHTML += `
                <li>
                    <a href="#" data-page="${this.currentPage + 1}" aria-label="Next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            `;
        } else {
            paginationHTML += `
                <li class="disabled">
                    <span aria-label="Next">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            `;
        }
        
        paginationList.innerHTML = paginationHTML;
        
        // Bind pagination events
        paginationList.querySelectorAll('a[data-page]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                this.currentPage = parseInt(e.target.closest('a').dataset.page);
                this.renderTable();
                this.renderPagination();
                this.scrollToTop();
            });
        });
    }
    
    formatDate(dateString) {
        // Use global formatDate function if it exists, or use our own implementation
        if (window.formatDate) {
            return window.formatDate(dateString);
        }
        
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
    }
    
    showLoading() {
        document.getElementById('loadingState').style.display = 'block';
        document.getElementById('cooperationTable').style.display = 'none';
        document.getElementById('emptyState').style.display = 'none';
    }
    
    hideLoading() {
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('cooperationTable').style.display = 'table';
    }
    
    showEmptyState() {
        document.getElementById('emptyState').style.display = 'block';
        document.getElementById('cooperationTable').style.display = 'none';
    }
    
    hideEmptyState() {
        document.getElementById('emptyState').style.display = 'none';
        document.getElementById('cooperationTable').style.display = 'table';
    }
    
    scrollToTop() {
        document.querySelector('.data-table-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new CooperationDataManager();
});

// Tambahan untuk fitur filter khusus Data Kerjasama
document.addEventListener('DOMContentLoaded', function() {
    // Wait for table filter to be initialized
    setTimeout(() => {
        addCustomFiltersForDataKerjasama();
        setupCustomFilterEvents();
    }, 1000);
});

function addCustomFiltersForDataKerjasama() {
    const filterControls = document.getElementById('dataKerjasamaTable-filter-controls');
    if (!filterControls) return;
    
    // Add Jenis Identitas filter
    const jenisIdentitasFilter = createCustomSelectFilter('jenisIdentitas', 'Jenis Identitas', 
        ['', 'PTN', 'PTS', 'K/L', 'Swasta', 'Luar Negeri']);
    filterControls.appendChild(jenisIdentitasFilter);
    
    // Add Jenis Kerjasama filter
    const jenisKerjasamaFilter = createCustomSelectFilter('jenisKerjasama', 'Jenis Kerjasama', 
        ['', 'MOU', 'MOA', 'PKS']);
    filterControls.appendChild(jenisKerjasamaFilter);
    
    // Add Status filter
    const statusFilter = createCustomSelectFilter('status', 'Status', 
        ['', 'Aktif', 'Berakhir', 'Draft']);
    filterControls.appendChild(statusFilter);
    
    // Add Tahun filter
    const tahunFilter = createCustomSelectFilter('tahun', 'Tahun', 
        ['', '2024', '2023', '2022', '2021', '2020']);
    filterControls.appendChild(tahunFilter);
}

function createCustomSelectFilter(id, label, options) {
    const filterGroup = document.createElement('div');
    filterGroup.className = 'filter-group';
    
    const optionsHTML = options.map(option => 
        `<option value="${option}">${option || 'Semua'}</option>`
    ).join('');
    
    filterGroup.innerHTML = `
        <label class="filter-label">${label}</label>
        <select class="filter-input" id="filter-${id}">
            ${optionsHTML}
        </select>
    `;
    
    return filterGroup;
}

function setupCustomFilterEvents() {
    const filterIds = ['jenisIdentitas', 'jenisKerjasama', 'status', 'tahun'];
    
    filterIds.forEach(filterId => {
        const filterElement = document.getElementById(`filter-${filterId}`);
        if (filterElement) {
            filterElement.addEventListener('change', function() {
                applyAllCustomFiltersForData();
            });
        }
    });
}

function applyAllCustomFiltersForData() {
    const tableFilter = window.tableFilters['dataKerjasamaTable'];
    if (!tableFilter) return;
    
    // Get all filter values
    const filters = {
        jenisIdentitas: document.getElementById('filter-jenisIdentitas')?.value || '',
        jenisKerjasama: document.getElementById('filter-jenisKerjasama')?.value || '',
        status: document.getElementById('filter-status')?.value || '',
        tahun: document.getElementById('filter-tahun')?.value || ''
    };
    
    // Start with original data
    let filtered = [...tableFilter.originalData];
    
    // Apply global search first
    const globalSearch = document.getElementById('dataKerjasamaTable-global-search');
    const globalTerm = globalSearch ? globalSearch.value.trim() : '';
    
    if (globalTerm) {
        const term = globalTerm.toLowerCase();
        filtered = filtered.filter(row => {
            return row.data.some(cell => 
                cell.toLowerCase().includes(term)
            );
        });
    }
    
    // Apply Jenis Identitas filter (column 2)
    if (filters.jenisIdentitas) {
        filtered = filtered.filter(row => 
            row.data[2].includes(filters.jenisIdentitas)
        );
    }
    
    // Apply Jenis Kerjasama filter (column 3)
    if (filters.jenisKerjasama) {
        filtered = filtered.filter(row => 
            row.data[3].includes(filters.jenisKerjasama)
        );
    }
    
    // Apply Status filter (column 7)
    if (filters.status) {
        filtered = filtered.filter(row => 
            row.data[7].includes(filters.status)
        );
    }
    
    // Apply Tahun filter (column 5 - Tanggal Mulai)
    if (filters.tahun) {
        filtered = filtered.filter(row => {
            const tanggalMulai = row.data[5];
            return tanggalMulai.includes(filters.tahun);
        });
    }
    
    // Update table with filtered data
    tableFilter.filteredData = filtered;
    tableFilter.currentPage = 1;
    tableFilter.updateTable();
    tableFilter.updateInfoBar();
}