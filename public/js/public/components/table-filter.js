class TableFilter {
    constructor(tableId, options = {}) {
        this.tableId = tableId;
        this.table = document.getElementById(tableId);
        this.options = {
            searchable: true,
            sortable: true,
            pagination: true,
            itemsPerPage: 10,
            ...options
        };
        
        this.currentPage = 1;
        this.totalPages = 1;
        this.filteredData = [];
        this.originalData = [];
        this.activeFilters = {};
        
        this.init();
    }
    
    init() {
        if (!this.table) return;
        
        this.extractTableData();
        this.createFilterInterface();
        this.setupEventListeners();
        this.updateTable();
    }
    
    extractTableData() {
        const rows = this.table.querySelectorAll('tbody tr');
        this.originalData = [];
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowData = {
                element: row,
                data: Array.from(cells).map(cell => cell.textContent.trim())
            };
            this.originalData.push(rowData);
        });
        
        this.filteredData = [...this.originalData];
    }
    
    createFilterInterface() {
        const filterContainer = document.createElement('div');
        filterContainer.className = 'filter-container';
        filterContainer.innerHTML = this.getFilterHTML();
        
        // Insert before table
        this.table.parentNode.insertBefore(filterContainer, this.table);
        
        // Create info bar
        const infoBar = document.createElement('div');
        infoBar.className = 'table-info-bar';
        infoBar.id = `${this.tableId}-info-bar`;
        this.table.parentNode.insertBefore(infoBar, this.table);
        
        // Create pagination if enabled
        if (this.options.pagination) {
            const paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination-container mt-3';
            paginationContainer.id = `${this.tableId}-pagination`;
            this.table.parentNode.appendChild(paginationContainer);
        }
    }
    
    getFilterHTML() {
        const headers = this.table.querySelectorAll('thead th');
        const filterInputs = Array.from(headers).map((header, index) => {
            if (header.textContent.trim() === '' || header.textContent.includes('Aksi') || header.textContent.includes('No')) return '';
            
            return `
                <div class="filter-group">
                    <label class="filter-label">${header.textContent}</label>
                    <input type="text" class="filter-input" data-column="${index}" 
                           placeholder="Filter ${header.textContent.toLowerCase()}...">
                </div>
            `;
        }).filter(html => html !== '').join('');
        
        return `
            <div class="filter-header">
                <h5 class="filter-title">
                    <i class="fas fa-filter"></i>
                    Filter & Pencarian
                </h5>
                <button type="button" class="filter-toggle" onclick="toggleFilterControls('${this.tableId}')">
                    <i class="fas fa-chevron-up"></i> Sembunyikan Filter
                </button>
            </div>
            
            <div class="filter-controls" id="${this.tableId}-filter-controls">
                <div class="filter-group">
                    <label class="filter-label">Pencarian Global</label>
                    <div class="search-container">
                        <input type="text" class="search-input" id="${this.tableId}-global-search" 
                               placeholder="Cari di semua kolom...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>
                
                ${filterInputs}
                
                <div class="filter-group">
                    <label class="filter-label">Entries per Page</label>
                    <select class="filter-input" id="${this.tableId}-per-page">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="button" class="filter-btn filter-btn-primary" onclick="applyTableFilters('${this.tableId}')">
                    <i class="fas fa-search"></i> Terapkan Filter
                </button>
                <button type="button" class="filter-btn filter-btn-secondary" onclick="resetTableFilters('${this.tableId}')">
                    <i class="fas fa-refresh"></i> Reset Filter
                </button>
                <button type="button" class="filter-btn filter-btn-outline" onclick="exportTableData('${this.tableId}')">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        `;
    }
    
    setupEventListeners() {
        // Global search
        const globalSearch = document.getElementById(`${this.tableId}-global-search`);
        if (globalSearch) {
            globalSearch.addEventListener('input', (e) => {
                this.applyGlobalSearch(e.target.value);
            });
        }
        
        // Column filters
        const filterInputs = document.querySelectorAll(`#${this.tableId}-filter-controls .filter-input[data-column]`);
        filterInputs.forEach(input => {
            input.addEventListener('input', () => {
                this.applyColumnFilters();
            });
        });
        
        // Per page selector
        const perPageSelect = document.getElementById(`${this.tableId}-per-page`);
        if (perPageSelect) {
            perPageSelect.addEventListener('change', (e) => {
                this.options.itemsPerPage = parseInt(e.target.value);
                this.currentPage = 1;
                this.updateTable();
            });
        }
    }
    
    applyGlobalSearch(searchTerm) {
        if (!searchTerm.trim()) {
            this.filteredData = [...this.originalData];
        } else {
            const term = searchTerm.toLowerCase();
            this.filteredData = this.originalData.filter(row => {
                return row.data.some(cell => 
                    cell.toLowerCase().includes(term)
                );
            });
        }
        this.currentPage = 1;
        this.updateTable();
        this.updateInfoBar();
    }
    
    applyColumnFilters() {
        const filterInputs = document.querySelectorAll(`#${this.tableId}-filter-controls .filter-input[data-column]`);
        const filters = {};
        
        filterInputs.forEach(input => {
            const column = parseInt(input.dataset.column);
            const value = input.value.trim();
            if (value) {
                filters[column] = value.toLowerCase();
            }
        });
        
        this.activeFilters = filters;
        
        if (Object.keys(filters).length === 0) {
            this.filteredData = [...this.originalData];
        } else {
            this.filteredData = this.originalData.filter(row => {
                return Object.entries(filters).every(([column, filterValue]) => {
                    const cellValue = row.data[column] || '';
                    return cellValue.toLowerCase().includes(filterValue);
                });
            });
        }
        
        this.currentPage = 1;
        this.updateTable();
        this.updateInfoBar();
    }
    
    updateTable() {
        if (!this.options.pagination) {
            this.showAllRows();
            return;
        }
        
        const startIndex = (this.currentPage - 1) * this.options.itemsPerPage;
        const endIndex = startIndex + this.options.itemsPerPage;
        const pageData = this.filteredData.slice(startIndex, endIndex);
        
        // Hide all rows
        this.originalData.forEach(row => {
            row.element.style.display = 'none';
        });
        
        // Show current page rows
        pageData.forEach(row => {
            row.element.style.display = '';
        });
        
        this.updatePagination();
    }
    
    showAllRows() {
        // Hide all rows first
        this.originalData.forEach(row => {
            row.element.style.display = 'none';
        });
        
        // Show filtered rows
        this.filteredData.forEach(row => {
            row.element.style.display = '';
        });
    }
    
    updatePagination() {
        this.totalPages = Math.ceil(this.filteredData.length / this.options.itemsPerPage);
        const paginationContainer = document.getElementById(`${this.tableId}-pagination`);
        
        if (!paginationContainer) return;
        
        let paginationHTML = '<nav aria-label="Table pagination"><ul class="pagination justify-content-center">';
        
        // Previous button
        paginationHTML += `
            <li class="page-item ${this.currentPage === 1 ? 'disabled' : ''}">
                <button class="page-link" onclick="tableFilters['${this.tableId}'].goToPage(${this.currentPage - 1})">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </li>
        `;
        
        // Page numbers
        for (let i = 1; i <= this.totalPages; i++) {
            if (i === 1 || i === this.totalPages || (i >= this.currentPage - 2 && i <= this.currentPage + 2)) {
                paginationHTML += `
                    <li class="page-item ${i === this.currentPage ? 'active' : ''}">
                        <button class="page-link" onclick="tableFilters['${this.tableId}'].goToPage(${i})">${i}</button>
                    </li>
                `;
            } else if (i === this.currentPage - 3 || i === this.currentPage + 3) {
                paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }
        
        // Next button
        paginationHTML += `
            <li class="page-item ${this.currentPage === this.totalPages ? 'disabled' : ''}">
                <button class="page-link" onclick="tableFilters['${this.tableId}'].goToPage(${this.currentPage + 1})">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </li>
        `;
        
        paginationHTML += '</ul></nav>';
        paginationContainer.innerHTML = paginationHTML;
    }
    
    updateInfoBar() {
        const infoBar = document.getElementById(`${this.tableId}-info-bar`);
        if (!infoBar) return;
        
        const start = this.options.pagination ? 
            ((this.currentPage - 1) * this.options.itemsPerPage) + 1 : 1;
        const end = this.options.pagination ? 
            Math.min(this.currentPage * this.options.itemsPerPage, this.filteredData.length) : 
            this.filteredData.length;
        
        infoBar.innerHTML = `
            <div class="table-info-text">
                Menampilkan ${start} - ${end} dari ${this.filteredData.length} entries
                ${this.filteredData.length !== this.originalData.length ? 
                    `(difilter dari ${this.originalData.length} total entries)` : ''}
            </div>
        `;
    }
    
    goToPage(page) {
        if (page < 1 || page > this.totalPages) return;
        this.currentPage = page;
        this.updateTable();
        this.updateInfoBar();
    }
    
    exportData() {
        const headers = Array.from(this.table.querySelectorAll('thead th')).map(th => th.textContent.trim());
        const data = this.filteredData.map(row => row.data);
        
        let csv = headers.join(',') + '\n';
        data.forEach(row => {
            csv += row.map(cell => `"${cell.replace(/"/g, '""')}"`).join(',') + '\n';
        });
        
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${this.tableId}-export.csv`;
        a.click();
        window.URL.revokeObjectURL(url);
    }
    
    reset() {
        // Clear all filters
        document.querySelectorAll(`#${this.tableId}-filter-controls .filter-input`).forEach(input => {
            input.value = '';
        });
        
        const globalSearch = document.getElementById(`${this.tableId}-global-search`);
        if (globalSearch) globalSearch.value = '';
        
        this.activeFilters = {};
        this.filteredData = [...this.originalData];
        this.currentPage = 1;
        this.updateTable();
        this.updateInfoBar();
    }
}

// Global instances storage
window.tableFilters = {};

// Global helper functions
function initializeTableFilter(tableId, options = {}) {
    window.tableFilters[tableId] = new TableFilter(tableId, options);
}

function toggleFilterControls(tableId) {
    const controls = document.getElementById(`${tableId}-filter-controls`);
    const toggle = document.querySelector(`.filter-container .filter-toggle`);
    
    if (controls.classList.contains('collapsed')) {
        controls.classList.remove('collapsed');
        toggle.innerHTML = '<i class="fas fa-chevron-up"></i> Sembunyikan Filter';
    } else {
        controls.classList.add('collapsed');
        toggle.innerHTML = '<i class="fas fa-chevron-down"></i> Tampilkan Filter';
    }
}

function applyTableFilters(tableId) {
    if (window.tableFilters[tableId]) {
        window.tableFilters[tableId].applyAllFilters();
    }
}

function resetTableFilters(tableId) {
    if (window.tableFilters[tableId]) {
        window.tableFilters[tableId].reset();
    }
}

function exportTableData(tableId) {
    if (window.tableFilters[tableId]) {
        window.tableFilters[tableId].exportData();
    }
}