class KerjaSamaDataManager {
    constructor() {
        this.currentPage = 1;
        this.itemsPerPage = 20;
        this.currentSort = { field: null, direction: 'asc' };
        this.filters = {
            search: '',
            status: '',
            scope: '',
            type: '',
            year: ''
        };
        this.cooperationData = [];
        this.filteredData = [];
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.loadInitialData();
        this.initializeCounters();
        this.setupTableSorting();
        this.setupPagination();
    }
    
    bindEvents() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        
        if (searchInput) {
            searchInput.addEventListener('input', this.debounce(() => {
                this.filters.search = searchInput.value.trim();
                this.applyFilters();
            }, 300));
            
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.performSearch();
                }
            });
        }
        
        if (searchBtn) {
            searchBtn.addEventListener('click', () => this.performSearch());
        }
        
        // Filter selects
        const filterSelects = document.querySelectorAll('.filter-select');
        filterSelects.forEach(select => {
            select.addEventListener('change', (e) => {
                this.filters[e.target.id.replace('Filter', '')] = e.target.value;
                this.applyFilters();
            });
        });
        
        // Quick filters
        const quickFilterBtns = document.querySelectorAll('.quick-filter-btn');
        quickFilterBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.handleQuickFilter(e.target.dataset.filter);
            });
        });
        
        // Reset filters
        const resetBtn = document.getElementById('resetFiltersBtn');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => this.resetFilters());
        }
        
        // View options
        const viewOptionBtns = document.querySelectorAll('.view-option-btn');
        viewOptionBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.switchView(e.target.dataset.view);
            });
        });
        
        // Page size selector
        const pageSizeSelect = document.getElementById('pageSizeSelect');
        if (pageSizeSelect) {
            pageSizeSelect.addEventListener('change', (e) => {
                this.itemsPerPage = parseInt(e.target.value);
                this.currentPage = 1;
                this.renderTable();
                this.updatePagination();
            });
        }
        
        // Export functionality
        const exportBtn = document.getElementById('exportBtn');
        if (exportBtn) {
            exportBtn.addEventListener('click', () => this.exportData());
        }
        
        // Add new button
        const addNewBtn = document.getElementById('addNewBtn');
        if (addNewBtn) {
            addNewBtn.addEventListener('click', () => this.showAddNewModal());
        }
    }
    
    loadInitialData() {
        // Load cooperation data from server or use sample data
        this.cooperationData = this.getSampleData();
        this.filteredData = [...this.cooperationData];
        this.renderTable();
        this.updatePagination();
    }
    
    getSampleData() {
        return [
            {
                id: 1,
                partner_name: 'Universitas Indonesia',
                partner_location: 'Jakarta',
                agreement_type: 'mou',
                start_date: '2023-01-15',
                end_date: '2028-01-15',
                scope: 'nasional',
                status: 'active',
                progress: 85,
                unit_kerja: 'Pusat Pengembangan Koleksi',
                contact_person: 'Dr. Ahmad Santoso',
                implementation: [
                    'Pengembangan koleksi digital',
                    'Pertukaran mahasiswa pustakawan',
                    'Penelitian bersama bidang informasi'
                ]
            },
            {
                id: 2,
                partner_name: 'Institut Teknologi Bandung',
                partner_location: 'Bandung',
                agreement_type: 'moa',
                start_date: '2022-06-20',
                end_date: '2025-06-20',
                scope: 'nasional',
                status: 'active',
                progress: 92,
                unit_kerja: 'Pusat Teknologi Informasi',
                contact_person: 'Prof. Dr. Siti Rahma',
                implementation: [
                    'Digitalisasi koleksi teknik',
                    'Pengembangan repositori ilmiah'
                ]
            },
            {
                id: 3,
                partner_name: 'National Library of Singapore',
                partner_location: 'Singapore',
                agreement_type: 'mou',
                start_date: '2021-03-10',
                end_date: '2024-03-10',
                scope: 'internasional',
                status: 'pending',
                progress: 78,
                unit_kerja: 'Pusat Kerjasama Internasional',
                contact_person: 'Drs. Bambang Sutrisno',
                implementation: [
                    'Pertukaran pustakawan',
                    'Sharing best practices'
                ]
            },
            {
                id: 4,
                partner_name: 'Universitas Gadjah Mada',
                partner_location: 'Yogyakarta',
                agreement_type: 'pks',
                start_date: '2020-09-05',
                end_date: '2023-09-05',
                scope: 'nasional',
                status: 'expired',
                progress: 100,
                unit_kerja: 'Pusat Koleksi Nusantara',
                contact_person: 'Dr. Retno Handayani',
                implementation: [
                    'Preservasi naskah kuno',
                    'Digitalisasi koleksi langka'
                ]
            },
            {
                id: 5,
                partner_name: 'Library of Congress',
                partner_location: 'Washington D.C.',
                agreement_type: 'mou',
                start_date: '2023-08-12',
                end_date: '2028-08-12',
                scope: 'internasional',
                status: 'active',
                progress: 45,
                unit_kerja: 'Pusat Kerjasama Internasional',
                contact_person: 'Dr. Maria Susanti',
                implementation: [
                    'Digital heritage preservation',
                    'Professional exchange program'
                ]
            }
        ];
    }
    
    initializeCounters() {
        const counters = document.querySelectorAll('.stat-number[data-count]');
        counters.forEach(counter => {
            const target = parseInt(counter.dataset.count);
            this.animateCounter(counter, 0, target, 2000);
        });
    }
    
    animateCounter(element, start, end, duration) {
        const range = end - start;
        const startTime = Date.now();
        
        const timer = setInterval(() => {
            const elapsed = Date.now() - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const current = Math.floor(start + (range * this.easeOutQuart(progress)));
            
            element.textContent = current.toLocaleString();
            
            if (progress === 1) {
                clearInterval(timer);
            }
        }, 16);
    }
    
    easeOutQuart(t) {
        return 1 - Math.pow(1 - t, 4);
    }
    
    setupTableSorting() {
        const sortableHeaders = document.querySelectorAll('.sortable');
        sortableHeaders.forEach(header => {
            header.addEventListener('click', () => {
                const field = header.dataset.sort;
                this.handleSort(field);
            });
        });
    }
    
    handleSort(field) {
        if (this.currentSort.field === field) {
            this.currentSort.direction = this.currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            this.currentSort.field = field;
            this.currentSort.direction = 'asc';
        }
        
        this.updateSortIndicators();
        this.sortData();
        this.renderTable();
    }
    
    updateSortIndicators() {
        // Reset all sort indicators
        document.querySelectorAll('.sortable').forEach(header => {
            header.classList.remove('sort-asc', 'sort-desc');
        });
        
        // Set current sort indicator
        const currentHeader = document.querySelector(`[data-sort="${this.currentSort.field}"]`);
        if (currentHeader) {
            currentHeader.classList.add(`sort-${this.currentSort.direction}`);
        }
    }
    
    sortData() {
        this.filteredData.sort((a, b) => {
            let aVal = a[this.currentSort.field];
            let bVal = b[this.currentSort.field];
            
            // Handle different data types
            if (this.currentSort.field === 'partner') {
                aVal = a.partner_name.toLowerCase();
                bVal = b.partner_name.toLowerCase();
            } else if (this.currentSort.field === 'period') {
                aVal = new Date(a.start_date);
                bVal = new Date(b.start_date);
            } else if (typeof aVal === 'string') {
                aVal = aVal.toLowerCase();
                bVal = bVal.toLowerCase();
            }
            
            if (aVal < bVal) return this.currentSort.direction === 'asc' ? -1 : 1;
            if (aVal > bVal) return this.currentSort.direction === 'asc' ? 1 : -1;
            return 0;
        });
    }
    
    performSearch() {
        const searchInput = document.getElementById('searchInput');
        this.filters.search = searchInput.value.trim();
        this.applyFilters();
    }
    
    applyFilters() {
        this.showLoading();
        
        setTimeout(() => {
            this.filteredData = this.cooperationData.filter(item => {
                // Search filter
                if (this.filters.search) {
                    const searchTerm = this.filters.search.toLowerCase();
                    const searchFields = [
                        item.partner_name,
                        item.partner_location,
                        item.unit_kerja,
                        item.contact_person
                    ].join(' ').toLowerCase();
                    
                    if (!searchFields.includes(searchTerm)) {
                        return false;
                    }
                }
                
                // Status filter
                if (this.filters.status && item.status !== this.filters.status) {
                    return false;
                }
                
                // Scope filter
                if (this.filters.scope && item.scope !== this.filters.scope) {
                    return false;
                }
                
                // Type filter
                if (this.filters.type && item.agreement_type !== this.filters.type) {
                    return false;
                }
                
                // Year filter
                if (this.filters.year) {
                    const itemYear = new Date(item.start_date).getFullYear();
                    if (itemYear != this.filters.year) {
                        return false;
                    }
                }
                
                return true;
            });
            
            this.currentPage = 1;
            this.hideLoading();
            this.renderTable();
            this.updatePagination();
            this.updateResultsCount();
        }, 500);
    }
    
    handleQuickFilter(filterType) {
        // Reset all quick filter buttons
        document.querySelectorAll('.quick-filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Reset all filters first
        this.resetFilters(false);
        
        // Apply specific quick filter
        const activeBtn = document.querySelector(`[data-filter="${filterType}"]`);
        if (activeBtn) {
            activeBtn.classList.add('active');
        }
        
        switch (filterType) {
            case 'active':
                this.filters.status = 'active';
                document.getElementById('statusFilter').value = 'active';
                break;
            case 'expiring':
                this.filters.status = 'pending';
                document.getElementById('statusFilter').value = 'pending';
                break;
            case 'international':
                this.filters.scope = 'internasional';
                document.getElementById('scopeFilter').value = 'internasional';
                break;
            case 'this-year':
                this.filters.year = new Date().getFullYear().toString();
                document.getElementById('yearFilter').value = this.filters.year;
                break;
        }
        
        this.applyFilters();
    }
    
    resetFilters(updateUI = true) {
        this.filters = {
            search: '',
            status: '',
            scope: '',
            type: '',
            year: ''
        };
        
        if (updateUI) {
            // Reset form fields
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('scopeFilter').value = '';
            document.getElementById('typeFilter').value = '';
            document.getElementById('yearFilter').value = '';
            
            // Reset quick filter buttons
            document.querySelectorAll('.quick-filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            this.applyFilters();
        }
    }
    
    renderTable() {
        const tbody = document.getElementById('cooperationTableBody');
        if (!tbody) return;
        
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        const pageData = this.filteredData.slice(startIndex, endIndex);
        
        if (pageData.length === 0) {
            this.showEmptyState();
            return;
        }
        
        this.hideEmptyState();
        
        tbody.innerHTML = pageData.map(item => this.createTableRow(item)).join('');
        
        // Add event listeners to action buttons
        this.bindActionButtons();
    }
    
    createTableRow(item) {
        const startDate = this.formatDate(item.start_date);
        const endDate = this.formatDate(item.end_date);
        const duration = this.calculateDuration(item.start_date, item.end_date);
        
        return `
            <tr data-id="${item.id}">
                <td class="partner-cell">
                    <div class="partner-name">${item.partner_name}</div>
                    <div class="partner-location">
                        <i class="fas fa-map-marker-alt"></i>
                        ${item.partner_location}
                    </div>
                </td>
                <td class="type-status-cell">
                    <div class="agreement-type ${item.agreement_type}">${item.agreement_type.toUpperCase()}</div>
                    <div class="status-badge ${item.status}">${this.getStatusText(item.status)}</div>
                </td>
                <td class="period-cell">
                    <div class="period-start">Mulai: ${startDate}</div>
                    <div class="period-end">Berakhir: ${endDate}</div>
                    <div class="period-duration">${duration}</div>
                </td>
                <td class="scope-cell">
                    <span class="scope-badge ${item.scope}">${this.getScopeText(item.scope)}</span>
                </td>
                <td class="progress-cell">
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: ${item.progress}%"></div>
                    </div>
                    <div class="progress-text">${item.progress}% selesai</div>
                </td>
                <td class="actions-cell">
                    <button class="action-btn view" title="Lihat Detail" data-action="view" data-id="${item.id}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="action-btn edit" title="Edit" data-action="edit" data-id="${item.id}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-btn delete" title="Hapus" data-action="delete" data-id="${item.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    }
    
    bindActionButtons() {
        const actionBtns = document.querySelectorAll('.action-btn');
        actionBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const action = e.target.closest('.action-btn').dataset.action;
                const id = e.target.closest('.action-btn').dataset.id;
                this.handleAction(action, id);
            });
        });
    }
    
    handleAction(action, id) {
        const item = this.cooperationData.find(item => item.id == id);
        if (!item) return;
        
        switch (action) {
            case 'view':
                this.showDetailModal(item);
                break;
            case 'edit':
                this.showEditModal(item);
                break;
            case 'delete':
                this.confirmDelete(item);
                break;
        }
    }
    
    setupPagination() {
        this.updatePagination();
    }
    
    updatePagination() {
        const totalPages = Math.ceil(this.filteredData.length / this.itemsPerPage);
        const paginationList = document.getElementById('paginationList');
        
        if (!paginationList || totalPages <= 1) {
            if (paginationList) paginationList.innerHTML = '';
            return;
        }
        
        let paginationHTML = '';
        
        // Previous button
        paginationHTML += `
            <li class="page-item ${this.currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${this.currentPage - 1}">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
        `;
        
        // Page numbers
        const startPage = Math.max(1, this.currentPage - 2);
        const endPage = Math.min(totalPages, this.currentPage + 2);
        
        if (startPage > 1) {
            paginationHTML += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
            if (startPage > 2) {
                paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }
        
        for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `
                <li class="page-item ${i === this.currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
        }
        
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
            paginationHTML += `<li class="page-item"><a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a></li>`;
        }
        
        // Next button
        paginationHTML += `
            <li class="page-item ${this.currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${this.currentPage + 1}">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        `;
        
        paginationList.innerHTML = paginationHTML;
        
        // Bind pagination events
        const pageLinks = paginationList.querySelectorAll('.page-link[data-page]');
        pageLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = parseInt(e.target.dataset.page);
                if (page && page !== this.currentPage && page >= 1 && page <= totalPages) {
                    this.currentPage = page;
                    this.renderTable();
                    this.updatePagination();
                    this.scrollToTop();
                }
            });
        });
    }
    
    updateResultsCount() {
        const countElement = document.getElementById('showingCount');
        if (countElement) {
            const startIndex = (this.currentPage - 1) * this.itemsPerPage + 1;
            const endIndex = Math.min(this.currentPage * this.itemsPerPage, this.filteredData.length);
            countElement.textContent = `${startIndex}-${endIndex}`;
        }
    }
    
    showLoading() {
        const loadingState = document.getElementById('loadingState');
        const tableContainer = document.querySelector('.table-responsive');
        
        if (loadingState && tableContainer) {
            tableContainer.style.display = 'none';
            loadingState.style.display = 'block';
        }
    }
    
    hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const tableContainer = document.querySelector('.table-responsive');
        
        if (loadingState && tableContainer) {
            loadingState.style.display = 'none';
            tableContainer.style.display = 'block';
        }
    }
    
    showEmptyState() {
        const emptyState = document.getElementById('emptyState');
        const tableContainer = document.querySelector('.table-responsive');
        
        if (emptyState && tableContainer) {
            tableContainer.style.display = 'none';
            emptyState.style.display = 'block';
        }
    }
    
    hideEmptyState() {
        const emptyState = document.getElementById('emptyState');
        const tableContainer = document.querySelector('.table-responsive');
        
        if (emptyState && tableContainer) {
            emptyState.style.display = 'none';
            tableContainer.style.display = 'block';
        }
    }
    
    switchView(viewType) {
        const viewBtns = document.querySelectorAll('.view-option-btn');
        viewBtns.forEach(btn => btn.classList.remove('active'));
        
        const activeBtn = document.querySelector(`[data-view="${viewType}"]`);
        if (activeBtn) {
            activeBtn.classList.add('active');
        }
        
        // TODO: Implement grid view
        if (viewType === 'grid') {
            console.log('Grid view not implemented yet');
        }
    }
    
    exportData() {
        const csvContent = this.generateCSV();
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        
        if (link.download !== undefined) {
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `data_kerja_sama_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
    
    generateCSV() {
        const headers = [
            'Nama Mitra',
            'Lokasi',
            'Jenis Perjanjian',
            'Tanggal Mulai',
            'Tanggal Berakhir',
            'Lingkup',
            'Status',
            'Progress (%)',
            'Unit Kerja',
            'Contact Person'
        ];
        
        const csvRows = [headers.join(',')];
        
        this.filteredData.forEach(item => {
            const row = [
                `"${item.partner_name}"`,
                `"${item.partner_location}"`,
                item.agreement_type.toUpperCase(),
                item.start_date,
                item.end_date,
                this.getScopeText(item.scope),
                this.getStatusText(item.status),
                item.progress,
                `"${item.unit_kerja}"`,
                `"${item.contact_person}"`
            ];
            csvRows.push(row.join(','));
        });
        
        return csvRows.join('\n');
    }
    
    showDetailModal(item) {
        // TODO: Implement detail modal
        console.log('Show detail for:', item);
        alert(`Detail ${item.partner_name} akan ditampilkan di modal`);
    }
    
    showEditModal(item) {
        // TODO: Implement edit modal
        console.log('Edit item:', item);
        alert(`Edit ${item.partner_name} akan ditampilkan di modal`);
    }
    
    showAddNewModal() {
        // TODO: Implement add new modal
        console.log('Show add new modal');
        alert('Form tambah kerja sama baru akan ditampilkan di modal');
    }
    
    confirmDelete(item) {
        if (confirm(`Apakah Anda yakin ingin menghapus kerja sama dengan ${item.partner_name}?`)) {
            this.deleteItem(item.id);
        }
    }
    
    deleteItem(id) {
        this.cooperationData = this.cooperationData.filter(item => item.id !== id);
        this.applyFilters();
        
        // Show success message
        this.showNotification('Data berhasil dihapus', 'success');
    }
    
    showNotification(message, type = 'info') {
        // TODO: Implement notification system
        console.log(`${type.toUpperCase()}: ${message}`);
    }
    
    scrollToTop() {
        const tableContainer = document.querySelector('.data-table-section');
        if (tableContainer) {
            tableContainer.scrollIntoView({ behavior: 'smooth' });
        }
    }
    
    // Utility functions
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }
    
    calculateDuration(startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        const years = Math.floor(diffDays / 365);
        const months = Math.floor((diffDays % 365) / 30);
        
        if (years > 0) {
            return `${years} tahun ${months} bulan`;
        } else if (months > 0) {
            return `${months} bulan`;
        } else {
            return `${diffDays} hari`;
        }
    }
    
    getStatusText(status) {
        const statusMap = {
            'active': 'Aktif',
            'expired': 'Berakhir',
            'pending': 'Menunggu'
        };
        return statusMap[status] || status;
    }
    
    getScopeText(scope) {
        const scopeMap = {
            'nasional': 'Nasional',
            'internasional': 'Internasional'
        };
        return scopeMap[scope] || scope;
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.kerjaSamaDataManager = new KerjaSamaDataManager();
});

// Global functions for external access
window.resetFilters = function() {
    if (window.kerjaSamaDataManager) {
        window.kerjaSamaDataManager.resetFilters();
    }
};