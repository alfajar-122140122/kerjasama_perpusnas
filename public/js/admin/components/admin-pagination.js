// Universal Admin Pagination Class
class AdminPagination {
    constructor(tableId, options = {}) {
        this.tableId = tableId;
        this.table = document.getElementById(tableId);
        this.options = {
            itemsPerPage: 10,
            showInfo: true,
            showControls: true,
            responsive: true,
            rowSelector: 'tbody tr',
            excludeSelector: '.no-data-row, .empty-row, .admin-empty-pagination-row',
            onPageChange: null,
            onPageSizeChange: null,
            ...options
        };
        
        this.currentPage = 1;
        this.totalPages = 1;
        this.totalItems = 0;
        this.allRows = [];
        
        this.init();
    }
    
    init() {
        if (!this.table) {
            console.warn(`Table with ID "${this.tableId}" not found`);
            return;
        }
        
        this.extractTableData();
        this.createPaginationInterface();
        this.setupEventListeners();
        this.updateDisplay();
    }
    
    extractTableData() {
        const rows = this.table.querySelectorAll(this.options.rowSelector);
        this.allRows = [];
        
        rows.forEach(row => {
            // Skip rows that should be excluded
            let shouldExclude = false;
            if (this.options.excludeSelector) {
                const excludeSelectors = this.options.excludeSelector.split(',');
                shouldExclude = excludeSelectors.some(selector => 
                    row.matches(selector.trim())
                );
            }
            
            if (!shouldExclude) {
                this.allRows.push(row);
            }
        });
        
        this.totalItems = this.allRows.length;
        this.calculateTotalPages();
    }
    
    calculateTotalPages() {
        this.totalPages = Math.ceil(this.totalItems / this.options.itemsPerPage);
        if (this.totalPages === 0) this.totalPages = 1;
    }
    
    createPaginationInterface() {
        // Find the table container (usually a card-body)
        let container = this.table.closest('.card-body');
        if (!container) {
            container = this.table.parentNode;
        }
        
        // Create pagination container
        const paginationContainer = document.createElement('div');
        paginationContainer.className = 'admin-pagination-container';
        paginationContainer.id = `${this.tableId}-pagination-container`;
        
        // Create the pagination HTML
        paginationContainer.innerHTML = this.getPaginationHTML();
        
        // Append to container
        container.appendChild(paginationContainer);
    }
    
    getPaginationHTML() {
        let html = '';
        
        // Info section
        if (this.options.showInfo) {
            html += `
                <div class="admin-pagination-info">
                    <div class="admin-pagination-info-text" id="${this.tableId}-pagination-info">
                        ${this.getInfoText()}
                    </div>
                    ${this.options.showControls ? this.getControlsHTML() : ''}
                </div>
            `;
        }
        
        // Pagination navigation
        html += `
            <nav aria-label="Table pagination for ${this.tableId}">
                <ul class="pagination justify-content-center mb-0" id="${this.tableId}-pagination-nav">
                    ${this.getPaginationButtonsHTML()}
                </ul>
            </nav>
        `;
        
        return html;
    }
    
    getControlsHTML() {
        return `
            <div class="admin-pagination-controls">
                <label class="admin-pagination-label me-2">Tampilkan:</label>
                <select class="admin-pagination-select" id="${this.tableId}-page-size">
                    <option value="5" ${this.options.itemsPerPage === 5 ? 'selected' : ''}>5</option>
                    <option value="10" ${this.options.itemsPerPage === 10 ? 'selected' : ''}>10</option>
                    <option value="25" ${this.options.itemsPerPage === 25 ? 'selected' : ''}>25</option>
                    <option value="50" ${this.options.itemsPerPage === 50 ? 'selected' : ''}>50</option>
                    <option value="100" ${this.options.itemsPerPage === 100 ? 'selected' : ''}>100</option>
                </select>
                <span class="admin-pagination-label ms-2">per halaman</span>
            </div>
        `;
    }
    
    getPaginationButtonsHTML() {
        let html = '';
        
        // Previous button
        html += `
            <li class="page-item ${this.currentPage === 1 ? 'disabled' : ''}">
                <button class="page-link" onclick="adminPaginations['${this.tableId}'].goToPage(${this.currentPage - 1})" ${this.currentPage === 1 ? 'disabled' : ''}>
                    <i class="fas fa-chevron-left"></i>
                </button>
            </li>
        `;
        
        // Page numbers
        const maxVisiblePages = this.options.responsive && window.innerWidth <= 576 ? 3 : 7;
        let startPage = Math.max(1, this.currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(this.totalPages, startPage + maxVisiblePages - 1);
        
        // Adjust start page if we're near the end
        if (endPage - startPage < maxVisiblePages - 1) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        // First page (if not in range)
        if (startPage > 1) {
            html += `
                <li class="page-item">
                    <button class="page-link" onclick="adminPaginations['${this.tableId}'].goToPage(1)">1</button>
                </li>
            `;
            if (startPage > 2) {
                html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }
        
        // Page numbers in range
        for (let i = startPage; i <= endPage; i++) {
            html += `
                <li class="page-item ${i === this.currentPage ? 'active' : ''}">
                    <button class="page-link" onclick="adminPaginations['${this.tableId}'].goToPage(${i})">${i}</button>
                </li>
            `;
        }
        
        // Last page (if not in range)
        if (endPage < this.totalPages) {
            if (endPage < this.totalPages - 1) {
                html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
            html += `
                <li class="page-item">
                    <button class="page-link" onclick="adminPaginations['${this.tableId}'].goToPage(${this.totalPages})">${this.totalPages}</button>
                </li>
            `;
        }
        
        // Next button
        html += `
            <li class="page-item ${this.currentPage === this.totalPages ? 'disabled' : ''}">
                <button class="page-link" onclick="adminPaginations['${this.tableId}'].goToPage(${this.currentPage + 1})" ${this.currentPage === this.totalPages ? 'disabled' : ''}>
                    <i class="fas fa-chevron-right"></i>
                </button>
            </li>
        `;
        
        return html;
    }
    
    setupEventListeners() {
        // Page size selector
        const pageSizeSelect = document.getElementById(`${this.tableId}-page-size`);
        if (pageSizeSelect) {
            pageSizeSelect.addEventListener('change', (e) => {
                this.changePageSize(parseInt(e.target.value));
            });
        }
        
        // Window resize for responsive pagination
        if (this.options.responsive) {
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    this.updatePaginationButtons();
                }, 250);
            });
        }
    }
    
    updateDisplay() {
        this.showCurrentPageRows();
        this.updatePaginationButtons();
        this.updateInfoText();
    }
    
    showCurrentPageRows() {
        const startIndex = (this.currentPage - 1) * this.options.itemsPerPage;
        const endIndex = startIndex + this.options.itemsPerPage;
        
        // Hide all rows first
        this.allRows.forEach(row => {
            row.style.display = 'none';
        });
        
        // Show current page rows
        const currentPageRows = this.allRows.slice(startIndex, endIndex);
        currentPageRows.forEach(row => {
            row.style.display = '';
        });
        
        // Handle empty state
        this.handleEmptyState(currentPageRows.length === 0 && this.totalItems > 0);
    }
    
    handleEmptyState(isEmpty) {
        const tbody = this.table.querySelector('tbody');
        if (!tbody) return;
        
        let emptyRow = tbody.querySelector('.admin-empty-pagination-row');
        
        if (isEmpty) {
            if (!emptyRow) {
                emptyRow = document.createElement('tr');
                emptyRow.className = 'admin-empty-pagination-row';
                
                // Count columns for colspan
                const headerCols = this.table.querySelectorAll('thead th').length;
                
                emptyRow.innerHTML = `
                    <td colspan="${headerCols}" class="text-center py-4 text-muted">
                        <i class="fas fa-info-circle"></i>
                        Tidak ada data pada halaman ini
                    </td>
                `;
                tbody.appendChild(emptyRow);
            }
        } else {
            if (emptyRow) {
                emptyRow.remove();
            }
        }
    }
    
    updatePaginationButtons() {
        const navContainer = document.getElementById(`${this.tableId}-pagination-nav`);
        if (navContainer) {
            navContainer.innerHTML = this.getPaginationButtonsHTML();
        }
    }
    
    updateInfoText() {
        const infoElement = document.getElementById(`${this.tableId}-pagination-info`);
        if (infoElement) {
            infoElement.textContent = this.getInfoText();
        }
    }
    
    getInfoText() {
        if (this.totalItems === 0) {
            return 'Tidak ada data';
        }
        
        const startIndex = (this.currentPage - 1) * this.options.itemsPerPage + 1;
        const endIndex = Math.min(this.currentPage * this.options.itemsPerPage, this.totalItems);
        
        return `Menampilkan ${startIndex} - ${endIndex} dari ${this.totalItems} data`;
    }
    
    goToPage(page) {
        if (page < 1 || page > this.totalPages || page === this.currentPage) return;
        
        this.currentPage = page;
        this.updateDisplay();
        
        // Scroll to top of table smoothly
        this.table.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
        
        // Callback
        if (this.options.onPageChange) {
            this.options.onPageChange(page, this.totalPages);
        }
    }
    
    changePageSize(newSize) {
        this.options.itemsPerPage = newSize;
        this.currentPage = 1; // Reset to first page
        this.calculateTotalPages();
        this.updateDisplay();
        
        // Callback
        if (this.options.onPageSizeChange) {
            this.options.onPageSizeChange(newSize);
        }
    }
    
    refresh() {
        // Re-extract table data
        this.extractTableData();
        
        // Adjust current page if necessary
        if (this.currentPage > this.totalPages) {
            this.currentPage = Math.max(1, this.totalPages);
        }
        
        this.calculateTotalPages();
        this.updateDisplay();
    }
    
    addRow(rowElement) {
        // Add new row to the list
        this.allRows.push(rowElement);
        this.totalItems++;
        this.calculateTotalPages();
        
        // Go to the page where the new row would be
        const newRowPage = Math.ceil(this.totalItems / this.options.itemsPerPage);
        this.goToPage(newRowPage);
    }
    
    removeRow(rowElement) {
        // Remove row from the list
        const index = this.allRows.indexOf(rowElement);
        if (index > -1) {
            this.allRows.splice(index, 1);
            this.totalItems--;
            this.calculateTotalPages();
            
            // Adjust current page if necessary
            if (this.currentPage > this.totalPages) {
                this.currentPage = Math.max(1, this.totalPages);
            }
            
            this.updateDisplay();
        }
    }
    
    destroy() {
        // Remove pagination container
        const container = document.getElementById(`${this.tableId}-pagination-container`);
        if (container) {
            container.remove();
        }
        
        // Show all rows
        this.allRows.forEach(row => {
            row.style.display = '';
        });
        
        // Remove from global registry
        delete window.adminPaginations[this.tableId];
    }
}

// Global instances storage
window.adminPaginations = {};

// Global helper functions
function initializeAdminPagination(tableId, options = {}) {
    // Destroy existing pagination if exists
    if (window.adminPaginations[tableId]) {
        window.adminPaginations[tableId].destroy();
    }
    
    // Create new pagination
    window.adminPaginations[tableId] = new AdminPagination(tableId, options);
    return window.adminPaginations[tableId];
}

function getAdminPagination(tableId) {
    return window.adminPaginations[tableId] || null;
}

function refreshAdminPagination(tableId) {
    const pagination = window.adminPaginations[tableId];
    if (pagination) {
        pagination.refresh();
    }
}

function destroyAdminPagination(tableId) {
    const pagination = window.adminPaginations[tableId];
    if (pagination) {
        pagination.destroy();
    }
}

// Auto-initialize pagination on tables with specific class
document.addEventListener('DOMContentLoaded', function() {
    // Look for tables with 'admin-paginated-table' class
    const tables = document.querySelectorAll('table.admin-paginated-table');
    tables.forEach(table => {
        if (table.id) {
            initializeAdminPagination(table.id, {
                itemsPerPage: parseInt(table.dataset.itemsPerPage) || 10
            });
        }
    });
});