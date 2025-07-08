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
        // Sample data structure matching the UI
        this.allData = [
            {
                id: 1,
                partner: "ECOLE FRANCAISE D'EXTREME-ORIENT",
                scope: "Pelestarian warisan dokumenter budaya Nusantara. Penyediaan akses warisan dokumenter budaya Nusantara. Peningkatan kualitas sumber daya manusia dalam pengelolaan dan pengembangan warisan dokumenter budaya Nusantara. Penelitian hasil penelitian warisan dokumenter budaya Nusantara.",
                startDate: "2013-10-25",
                endDate: "2016-10-25"
            },
            {
                id: 2,
                partner: "The National Library and Archives of the Islamic Republic of Iran",
                scope: "Sharing Information and Experiences; Exchange of Experts; Library resources and services; Arrangement of Courses, Workshops, Exhibitions, Seminars and Conferences; Research Collaboration.",
                startDate: "2015-09-30",
                endDate: "2020-09-30"
            },
            {
                id: 3,
                partner: "THE NATIONAL LIBRARY OF KOREA",
                scope: "Pertukaran informasi dan pengalaman. Pertukaran staf dan kunjungan. Pertukaran bahan perpustakaan. Kerja sama timbal balik.",
                startDate: "2015-12-03",
                endDate: "2018-12-03"
            },
            {
                id: 4,
                partner: "TNI ANGKATAN LAUT",
                scope: "Saling menukar/memberikan pelayanan kedua belah pihak sesuai dengan fungsi dan kewenangan masing-masing terkait dengan bidang pengembangan perpustakaan.",
                startDate: "2012-01-26",
                endDate: "2017-01-26"
            },
            {
                id: 5,
                partner: "DEWAN KELAUTAN INDONESIA",
                scope: "Pengembangan perpustakaan di lingkungan Dewan Kelautan, untuk menunjang tugas fungsi; Pengembangan repository, informasi, kajian/penelitian bidang kelautan dan perikanan.",
                startDate: "2013-07-02",
                endDate: "2018-07-02"
            }
        ];
        
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