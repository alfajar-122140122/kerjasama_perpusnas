class ProgressKerjasamaManager {
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
        if (window.progressInitialData && Array.isArray(window.progressInitialData)) {
            this.allData = window.progressInitialData;
        } else {
            // Fallback to empty array if no data available
            this.allData = [];
        }
        
        // Sort by date (newest first)
        this.allData.sort((a, b) => {
            const dateA = this.parseDate(a.date);
            const dateB = this.parseDate(b.date);
            return dateB - dateA;
        });
        
        this.filteredData = [...this.allData];
    }
    
    parseDate(dateStr) {
        // Parse date in format "d M Y" (e.g. "14 Jan 2021")
        const parts = dateStr.split(' ');
        const months = {
            'Jan': 0, 'Feb': 1, 'Mar': 2, 'Apr': 3, 'May': 4, 'Jun': 5,
            'Jul': 6, 'Aug': 7, 'Sep': 8, 'Oct': 9, 'Nov': 10, 'Dec': 11
        };
        
        return new Date(parts[2], months[parts[1]], parseInt(parts[0]));
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
                    item.institution.toLowerCase().includes(this.searchTerm) ||
                    item.progress.toLowerCase().includes(this.searchTerm) ||
                    item.type.toLowerCase().includes(this.searchTerm) ||
                    item.date.toLowerCase().includes(this.searchTerm)
                );
            });
            
            this.currentPage = 1;
            this.renderTable();
            this.renderPagination();
            this.hideLoading();
        }, 200);
    }
    
    renderTable() {
        const tbody = document.getElementById('progressTableBody');
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        const pageData = this.filteredData.slice(startIndex, endIndex);
        
        if (pageData.length === 0) {
            this.showEmptyState();
            return;
        }
        
        this.hideEmptyState();
        
        tbody.innerHTML = pageData.map(item => {
            // Set badge class based on type
            let typeBadgeClass = '';
            switch(item.type.toLowerCase()) {
                case 'baru':
                    typeBadgeClass = 'progress-type-badge-new';
                    break;
                case 'perpanjangan':
                    typeBadgeClass = 'progress-type-badge-extension';
                    break;
                case 'dokumentasi':
                    typeBadgeClass = 'progress-type-badge-documentation';
                    break;
                case 'finishing':
                    typeBadgeClass = 'progress-type-badge-finishing';
                    break;
                default:
                    typeBadgeClass = 'progress-type-badge-default';
            }
            
            // Set badge class based on progress
            let progressBadgeClass = '';
            switch(item.progress.toLowerCase()) {
                case 'dokumentasi':
                    progressBadgeClass = 'progress-status-badge-documentation';
                    break;
                case 'finishing':
                    progressBadgeClass = 'progress-status-badge-finishing';
                    break;
                case 'review':
                    progressBadgeClass = 'progress-status-badge-review';
                    break;
                case 'approval':
                    progressBadgeClass = 'progress-status-badge-approval';
                    break;
                default:
                    progressBadgeClass = 'progress-status-badge-default';
            }
            
            return `
            <tr>
                <td>
                    <div class="progress-date-text">${item.date}</div>
                </td>
                <td>
                    <div class="progress-institution-name">${item.institution}</div>
                </td>
                <td>
                    <span class="progress-type-badge ${typeBadgeClass}">${item.type}</span>
                </td>
                <td>
                    <span class="progress-status-badge ${progressBadgeClass}">${item.progress}</span>
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
    
    showLoading() {
        document.getElementById('loadingState').style.display = 'block';
        document.getElementById('progressTable').style.display = 'none';
        document.getElementById('emptyState').style.display = 'none';
    }
    
    hideLoading() {
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('progressTable').style.display = 'table';
    }
    
    showEmptyState() {
        document.getElementById('emptyState').style.display = 'block';
        document.getElementById('progressTable').style.display = 'none';
    }
    
    hideEmptyState() {
        document.getElementById('emptyState').style.display = 'none';
        document.getElementById('progressTable').style.display = 'table';
    }
    
    scrollToTop() {
        document.querySelector('.progress-table-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new ProgressKerjasamaManager();
});