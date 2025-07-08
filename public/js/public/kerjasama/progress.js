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
        // Data sesuai dengan gambar yang diberikan
        this.allData = [
            {
                id: 1,
                date: "8 Jan 2021",
                institution: "Yayasan Perpustakaan Nurul Hasanah",
                type: "baru",
                progress: "Pembahasan MOU/PKS"
            },
            {
                id: 2,
                date: "14 Jan 2021",
                institution: "Yayasan IQRO Semesta",
                type: "baru",
                progress: "Pembahasan MOU/PKS"
            },
            {
                id: 3,
                date: "23 Jan 2021",
                institution: "LEMBAGA SWADAYA MASYARAKAT PUSAT KEGIATAN BELAJAR MASYARAKAT ELANG MUDA TEMBARA'I",
                type: "baru",
                progress: "Pembahasan MOU/PKS"
            },
            {
                id: 4,
                date: "4 Feb 2021",
                institution: "PT Infiniti Digital Indonesia",
                type: "baru",
                progress: "Pembahasan MOU/PKS"
            },
            {
                id: 5,
                date: "26 Feb 2021",
                institution: "UNIVERSITAS MEGA BUANA PALOPO",
                type: "baru",
                progress: "Pembahasan MOU/PKS"
            }
        ];
        
        // Sort by date (newest first)
        this.allData.sort((a, b) => new Date(b.date) - new Date(a.date));
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
        
        tbody.innerHTML = pageData.map(item => `
            <tr>
                <td>
                    <div class="progress-date-text">${item.date}</div>
                </td>
                <td>
                    <div class="progress-institution-name">${item.institution}</div>
                </td>
                <td>
                    <span class="progress-type-badge">${item.type}</span>
                </td>
                <td>
                    <div class="progress-status-text">${item.progress}</div>
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