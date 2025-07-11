class ImplementasiKerjasamaManager {
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
        if (window.implementasiInitialData && Array.isArray(window.implementasiInitialData)) {
            this.allData = window.implementasiInitialData;
        } else {
            // Fallback to empty array if no data available
            this.allData = [];
        }
        
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
        
        // Delegate event for "read more" links
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('implementasi-read-more')) {
                e.preventDefault();
                const itemId = parseInt(e.target.dataset.id);
                this.showImplementasiDetail(itemId);
            }
        });
    }
    
    showImplementasiDetail(id) {
        const item = this.allData.find(item => item.id === id);
        if (!item) return;
        
        // Create modal for displaying full details
        const modalHtml = `
        <div class="implementasi-detail-modal" id="implementasiDetailModal">
            <div class="implementasi-modal-content">
                <span class="implementasi-modal-close">&times;</span>
                <h3>${item.partner}</h3>
                <div class="implementasi-modal-section">
                    <h4>Masa Berlaku</h4>
                    <p>${item.period || '-'}</p>
                </div>
                <div class="implementasi-modal-section">
                    <h4>Implementasi Kerja Sama</h4>
                    <p>${item.implementation || 'Belum ada implementasi'}</p>
                </div>
                <div class="implementasi-modal-section">
                    <h4>Lingkup</h4>
                    <p>${item.scope}</p>
                </div>
                <div class="implementasi-modal-section">
                    <h4>Unit Kerja</h4>
                    <p>${item.unit === 'null' ? '-' : item.unit}</p>
                </div>
            </div>
        </div>`;
        
        // Append modal to body
        const modalWrapper = document.createElement('div');
        modalWrapper.innerHTML = modalHtml;
        document.body.appendChild(modalWrapper.firstElementChild);
        
        // Add modal functionality
        const modal = document.getElementById('implementasiDetailModal');
        const closeBtn = modal.querySelector('.implementasi-modal-close');
        
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
                    item.implementation.toLowerCase().includes(this.searchTerm) ||
                    item.scope.toLowerCase().includes(this.searchTerm) ||
                    (item.unit && item.unit.toLowerCase().includes(this.searchTerm))
                );
            });
            
            this.currentPage = 1;
            this.renderTable();
            this.renderPagination();
            this.hideLoading();
        }, 200);
    }
    
    renderTable() {
        const tbody = document.getElementById('implementasiTableBody');
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
                    <div class="implementasi-partner-name">${item.partner}</div>
                </td>
                <td>
                    <div class="implementasi-period-text">${item.period ? item.period : '<span class="implementasi-null-value">-</span>'}</div>
                </td>
                <td>
                    <div class="implementasi-detail-text">${item.implementation ? 
                        (item.implementation.length > 100 ? 
                            `${item.implementation.substring(0, 100)}... <a href="#" class="implementasi-read-more" data-id="${item.id}">Selengkapnya</a>` : 
                            item.implementation) : 
                        '<span class="implementasi-null-value">Belum ada implementasi</span>'}</div>
                </td>
                <td>
                    <div class="implementasi-scope-text">${item.scope}</div>
                </td>
                <td>
                    <div class="implementasi-unit-text">${item.unit === 'null' || !item.unit ? '<span class="implementasi-null-value">null</span>' : item.unit}</div>
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
    
    showLoading() {
        document.getElementById('loadingState').style.display = 'block';
        document.getElementById('implementasiTable').style.display = 'none';
        document.getElementById('emptyState').style.display = 'none';
    }
    
    hideLoading() {
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('implementasiTable').style.display = 'table';
    }
    
    showEmptyState() {
        document.getElementById('emptyState').style.display = 'block';
        document.getElementById('implementasiTable').style.display = 'none';
    }
    
    hideEmptyState() {
        document.getElementById('emptyState').style.display = 'none';
        document.getElementById('implementasiTable').style.display = 'table';
    }
    
    scrollToTop() {
        document.querySelector('.implementasi-table-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new ImplementasiKerjasamaManager();
});