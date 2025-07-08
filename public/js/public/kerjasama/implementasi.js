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
        // Sample data based on the UI design
        this.allData = [
            {
                id: 1,
                partner: "Akademi Kebidanan Nusantara Lubuklinggau",
                period: "30 Mar 2016 - 30 Mar 2021",
                implementation: "Telah menerima bantuan buku sap layan tahun 2017 sebanyak 500 judul, 1000 eks.",
                scope: "a. Pengembangan SDM bidang Perpustakaan; b. Perteman ilmiah, penelitian dan publikasi bersama koleksi perpustakaan; c. Pertukaran data katalog induk perpustakaan; d. Pengembangan dan pemanfaatan bersama koleksi perpustakaan; e. Penghimpunan dan pelestarian karya cetak Karya Rekam (KCKR); f. Pertukaran jejaring perpustakaan lingkup nasional dan internasional.",
                unit: "null"
            },
            {
                id: 2,
                partner: "Akademi Kebidanan Nusantara Palembang",
                period: "30 Mar 2016 - 30 Mar 2021",
                implementation: "",
                scope: "a. Pengembangan SDM bidang Perpustakaan; b. Perteman ilmiah, penelitian dan publikasi bersama koleksi perpustakaan; c. Pertukaran data katalog induk perpustakaan; d. Pengembangan dan pemanfaatan bersama koleksi perpustakaan; e. Penghimpunan dan pelestarian karya cetak Karya Rekam (KCKR); f. Pertukaran jejaring perpustakaan lingkup nasional dan internasional.",
                unit: "null"
            },
            {
                id: 3,
                partner: "ARSIP NASIONAL",
                period: "null",
                implementation: "Workshop kearsipaer di lingkungan Perpustakaan Nasional RI, 5 Maret 2018",
                scope: "a. Perteman ilmiah mengenai kearsipar dan perpustakaan; b. Perteman ilmiah dan pelestarian arsip dan bahan perpustakaan; c. Pengembangan sumber daya manusia kearsipar dan perpustakaan; d. Pengembangan sistem preservasi; e. Penyusunan dan pengembangan jabatan fungsional konservator.",
                unit: "Inspektorat, Pusat Jasa Informasi perpustakaan dan Pengelolaan Naskah Nusantara, Pusat Pendidikan dan Pelatihan"
            },
            {
                id: 4,
                partner: "Badan Informasi Geospasial (BIG)",
                period: "null",
                implementation: "Belum terimplementasikan",
                scope: "a. Pengembangan informasi geospasial tentang bidang kepustakawanan; b. Perteman ilmiah berbasis sumber informasi dan koleksi perpustakaan; c. Pengembangan koleksi perpustakaan; d. Pemeliharaan informasi geospasial tentang bidang kepustakawanan dan jamasi geospasial pada masyarakat; e. Kajian, publikasi, dan penelitian bidang informasi geospasial; f. Peningkatan sumber daya manusia di bidang kepustakawanan dan informasi geospasial; g. Penggunaan bersama data koleksi elektronik nasional dan internasional; h. Penghimpunan dan pelestarian Karya Cetak Karya Rekam (KCKR); i. Penyerahan duplikat informasi geospasiatistik berupa peta dan atlas; j. Pengembangan Simplurlingan Informasi Geospasial Nasional; k. Pertukaran Karya Katalog Induk Nasional Perpustakaan.",
                unit: "Biro SDM dan Umum, Pusat Bibliografi dan Pengolahan Bahan Perpustakaan, Pusat Pengembangan Koleksi Perpustakaan"
            }
        ];
        
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
                    <div class="implementasi-period-text">${item.period === 'null' || !item.period ? '<span class="implementasi-null-value">null</span>' : item.period}</div>
                </td>
                <td>
                    <div class="implementasi-detail-text">${item.implementation || '<span class="implementasi-null-value">Belum ada implementasi</span>'}</div>
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