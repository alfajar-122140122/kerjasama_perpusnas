class AkanBerakhirManager {
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
        // Check if there's data passed from PHP
        if (window.akanBerakhirInitialData && Array.isArray(window.akanBerakhirInitialData)) {
            this.allData = window.akanBerakhirInitialData;
        } else {
            // Fallback to empty array if no data available
            this.allData = [];
        }
        
        // Data is already sorted by tanggal_berakhir ASC from the controller
        this.filteredData = [...this.allData];
    }
    
    bindEvents() {
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        
        // Search functionality
        searchInput.addEventListener('input', (e) => {
            this.searchTerm = e.target.value.toLowerCase().trim();
            this.debounceSearch();
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
        
        // Add click event for table rows to show details
        document.addEventListener('click', (e) => {
            const row = e.target.closest('.akan-berakhir-row');
            if (row) {
                const id = parseInt(row.dataset.id);
                this.showKerjasamaDetail(id);
            }
        });
    }
    
    debounceSearch() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            this.filterData();
        }, 300);
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
        }, 200);
    }
    
    renderTable() {
        const tbody = document.getElementById('akanBerakhirTableBody');
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        const pageData = this.filteredData.slice(startIndex, endIndex);
        
        if (pageData.length === 0) {
            this.showEmptyState();
            return;
        }
        
        this.hideEmptyState();
        
        tbody.innerHTML = pageData.map(item => {
            let rowClass = '';
            if (item.remainingDays <= 30) {
                rowClass = 'akan-berakhir-urgent';
            } else if (item.remainingDays <= 60) {
                rowClass = 'akan-berakhir-warning';
            }
            
            return `
                <tr class="akan-berakhir-row ${rowClass}" data-id="${item.id}">
                    <td>
                        <div class="akan-berakhir-partner-name">${item.partner}</div>
                    </td>
                    <td>
                        <div class="akan-berakhir-scope-text">${item.scope.length > 50 ? item.scope.substring(0, 50) + '...' : item.scope}</div>
                    </td>
                    <td>
                        <div class="akan-berakhir-date-text">${item.startDate}</div>
                    </td>
                    <td>
                        <div class="akan-berakhir-end-date">
                            <span class="akan-berakhir-date-text text-danger fw-bold">${item.endDate}</span>
                            <br>
                            <small class="akan-berakhir-countdown text-warning">
                                <i class="fas fa-clock me-1"></i>${item.remainingDays} hari lagi
                            </small>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
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
        
        for (let i = startPage; i <= endPage; i++) {
            if (i === this.currentPage) {
                paginationHTML += `<li class="active"><span>${i}</span></li>`;
            } else {
                paginationHTML += `<li><a href="#" data-page="${i}">${i}</a></li>`;
            }
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
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
    }
    
    showLoading() {
        document.getElementById('loadingState').style.display = 'block';
        document.getElementById('akanBerakhirTable').style.display = 'none';
        document.getElementById('emptyState').style.display = 'none';
    }
    
    hideLoading() {
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('akanBerakhirTable').style.display = 'table';
    }
    
    showEmptyState() {
        document.getElementById('emptyState').style.display = 'block';
        document.getElementById('akanBerakhirTable').style.display = 'none';
    }
    
    hideEmptyState() {
        document.getElementById('emptyState').style.display = 'none';
        document.getElementById('akanBerakhirTable').style.display = 'table';
    }
    
    scrollToTop() {
        document.querySelector('.akan-berakhir-table-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
    
    showKerjasamaDetail(id) {
        const item = this.allData.find(item => item.id === id);
        if (!item) return;
        
        // Create modal for displaying full details
        const modalHtml = `
        <div class="akan-berakhir-detail-modal" id="akanBerakhirDetailModal">
            <div class="akan-berakhir-modal-content">
                <span class="akan-berakhir-modal-close">&times;</span>
                <h3>${item.partner}</h3>
                <div class="akan-berakhir-modal-section">
                    <h4>Periode</h4>
                    <p>${item.startDate} - ${item.endDate}</p>
                </div>
                <div class="akan-berakhir-modal-section">
                    <h4>Sisa Waktu</h4>
                    <p class="text-danger"><i class="fas fa-clock me-1"></i> ${item.remainingDays} hari lagi</p>
                </div>
                <div class="akan-berakhir-modal-section">
                    <h4>Ruang Lingkup</h4>
                    <p>${item.scope}</p>
                </div>
                <div class="akan-berakhir-modal-section">
                    <h4>Status</h4>
                    <p><span class="badge bg-warning">Akan Berakhir</span></p>
                </div>
            </div>
        </div>`;
        
        // Append modal to body
        const modalWrapper = document.createElement('div');
        modalWrapper.innerHTML = modalHtml;
        document.body.appendChild(modalWrapper.firstElementChild);
        
        // Add modal functionality
        const modal = document.getElementById('akanBerakhirDetailModal');
        const closeBtn = modal.querySelector('.akan-berakhir-modal-close');
        
        modal.style.display = 'block';
        
        closeBtn.onclick = function() {
            modal.style.display = 'none';
            setTimeout(() => {
                modal.remove();
            }, 300);
        };
        
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
                setTimeout(() => {
                    modal.remove();
                }, 300);
            }
        };
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new AkanBerakhirManager();
});