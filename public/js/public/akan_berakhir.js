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
        // Data sesuai dengan gambar yang diberikan
        this.allData = [
            {
                id: 1,
                partner: "ECOLE FRANCAISE D'EXTREME-ORIENT",
                scope: "Pelestarian warisan dokumenter budaya Nusantara. Penyediaan akses warisan dokumenter budaya Nusantara. Peningkatan kualitas sumber daya manusia dalam pengelolaan warisan dokumenter budaya Nusantara. Penerbitan hasil penelitian warisan dokumenter budaya Nusantara.",
                startDate: "2013-10-25",
                endDate: "2016-10-25",
                isExpired: true
            },
            {
                id: 2,
                partner: "The National Library and Archives of the Islamic Republic of Iran",
                scope: "Sharing Information and Experiences; Exchange of Experts; Library resources and services; Arrangement of Courses, Workshops, Exhibitions, Seminars and Conferences; Research Collaborations.",
                startDate: "2015-09-30",
                endDate: "2020-09-30",
                isExpired: true
            },
            {
                id: 3,
                partner: "THE NATIONAL LIBRARY OF KOREA",
                scope: "Pertukaran informasi dan pengalaman. Pertukaran staf dan kunjungan. Pertukaran bahan perpustakaan. Kerja sama timbal balik.",
                startDate: "2015-12-03",
                endDate: "2018-12-03",
                isExpired: true
            },
            {
                id: 4,
                partner: "TNI ANGKATAN LAUT",
                scope: "Saling menunjang dalam pelaksanaan tugas kedua belah pihak sesuai dengan fungsi dan kewenangan masing-masing terkait dengan bidang pengembangan perpustakaan.",
                startDate: "2012-01-26",
                endDate: "2017-01-26",
                isExpired: true
            },
            {
                id: 5,
                partner: "DEWAT KELAUTAN INDONESIA",
                scope: "Pengembagan perpustakaan di lingkungan Dewan Kelautan, untuk menunjang tugas fungsi; Pengembangan repository, informasi, kajian/penelitian bidang kelautan dan perikanan; Tukar menukar data bidang kelautan dan perikanan.",
                startDate: "2013-07-02",
                endDate: "2018-07-02",
                isExpired: true
            }
        ];
        
        // Sort by end date (earliest expiration first)
        this.allData.sort((a, b) => new Date(a.endDate) - new Date(b.endDate));
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
        
        tbody.innerHTML = pageData.map(item => `
            <tr>
                <td>
                    <div class="akan-berakhir-partner-name">${item.partner}</div>
                </td>
                <td>
                    <div class="akan-berakhir-scope-text">${item.scope}</div>
                </td>
                <td>
                    <div class="akan-berakhir-date-cell">${this.formatDate(item.startDate)}</div>
                </td>
                <td>
                    <div class="akan-berakhir-date-cell">${this.formatDate(item.endDate)}</div>
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
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new AkanBerakhirManager();
});