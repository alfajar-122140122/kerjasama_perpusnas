<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Kerja Sama<?= $this->endSection() ?>

<?= $this->section('description') ?>Implementasi Kerja Sama Perpustakaan Nasional RI dengan berbagai mitra institusi pendidikan, pemerintah, dan organisasi dalam bidang perpustakaan dan informasi.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>kerja sama, implementasi, MOU, MOA, kerjasama perpustakaan, mitra, akademi, universitas, badan informasi, perpustakaan nasional<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/navigation.css') ?>" rel="stylesheet">
<style>
/* Kerja Sama Page Styles */
.kerja-sama-wrapper {
    background: #f8f9fa;
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
}

.page-header-section {
    background: white;
    padding: 1.5rem 0;
    margin-bottom: 2rem;
    border-bottom: 1px solid #e9ecef;
}

.page-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-main-title {
    color: #2c3e50;
    font-size: 2.25rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6c757d;
    font-size: 0.95rem;
}

.breadcrumb-nav a {
    color: #007bff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-nav a:hover {
    color: #0056b3;
    text-decoration: underline;
}

.breadcrumb-separator {
    color: #adb5bd;
    margin: 0 0.25rem;
}

/* Search and Filter Section */
.search-filter-section {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.search-form-wrapper {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 1.5rem;
    align-items: end;
}

.search-input-group {
    position: relative;
}

.search-label {
    display: block;
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.search-input-field {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #fff;
}

.search-input-field:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.25rem rgba(0,123,255,0.25);
}

.search-btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
    box-shadow: 0 2px 4px rgba(0,123,255,0.3);
}

.search-btn-primary:hover {
    background: linear-gradient(45deg, #0056b3, #004085);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,123,255,0.4);
}

/* Table Section */
.table-section {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.table-header {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    padding: 1.5rem 2rem;
}

.table-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

.table-subtitle {
    font-size: 0.9rem;
    opacity: 0.9;
    margin: 0.25rem 0 0 0;
}

.table-responsive-wrapper {
    overflow-x: auto;
    background: white;
}

.cooperation-data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    margin: 0;
}

.cooperation-data-table thead th {
    background: #f8f9fa;
    color: #495057;
    padding: 1.25rem 1rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    border-bottom: 2px solid #dee2e6;
    white-space: nowrap;
}

.cooperation-data-table tbody td {
    padding: 1.25rem 1rem;
    border-bottom: 1px solid #f1f3f4;
    vertical-align: top;
    line-height: 1.5;
}

.cooperation-data-table tbody tr {
    transition: all 0.2s ease;
}

.cooperation-data-table tbody tr:hover {
    background: #f8f9fa;
    transform: scale(1.005);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.cooperation-data-table tbody tr:last-child td {
    border-bottom: none;
}

/* Table Column Styles */
.partner-info {
    min-width: 200px;
}

.partner-name {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
    font-size: 0.95rem;
}

.partner-location {
    color: #6c757d;
    font-size: 0.85rem;
    font-style: italic;
}

.date-info {
    min-width: 150px;
    white-space: nowrap;
}

.date-range {
    color: #495057;
    font-weight: 500;
    font-size: 0.9rem;
}

.implementation-details {
    min-width: 350px;
    max-width: 500px;
}

.implementation-list {
    margin: 0;
    padding-left: 1.2rem;
    color: #495057;
    line-height: 1.6;
}

.implementation-list li {
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
}

.scope-info {
    min-width: 120px;
    text-align: center;
}

.scope-badge {
    display: inline-block;
    padding: 0.375rem 0.875rem;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.scope-nasional {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
}

.scope-internasional {
    background: linear-gradient(45deg, #007bff, #6f42c1);
    color: white;
}

.unit-info {
    min-width: 200px;
    max-width: 250px;
}

.unit-details {
    color: #495057;
    font-size: 0.85rem;
    line-height: 1.4;
}

.unit-name {
    font-weight: 600;
    color: #2c3e50;
}

/* Pagination Section */
.pagination-section {
    display: flex;
    justify-content: center;
    padding: 2rem 0;
}

.pagination-wrapper {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.pagination-btn {
    width: 44px;
    height: 44px;
    border: 2px solid #e9ecef;
    background: white;
    color: #495057;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.pagination-btn:hover {
    background: #007bff;
    color: white;
    border-color: #007bff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,123,255,0.3);
    text-decoration: none;
}

.pagination-btn.active {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
    border-color: #28a745;
    box-shadow: 0 2px 4px rgba(40,167,69,0.3);
}

.pagination-btn.disabled {
    background: #f8f9fa;
    color: #adb5bd;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.pagination-btn.disabled:hover {
    background: #f8f9fa;
    color: #adb5bd;
    border-color: #e9ecef;
    transform: none;
    box-shadow: none;
}

/* Statistics Cards */
.stats-section {
    margin-bottom: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #007bff;
    margin-bottom: 0.5rem;
    line-height: 1;
}

.stat-label {
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .search-form-wrapper {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .page-header-content {
        flex-direction: column;
        align-items: start;
    }
}

@media (max-width: 992px) {
    .kerja-sama-wrapper {
        padding: 1.5rem 0;
    }
    
    .page-main-title {
        font-size: 2rem;
    }
    
    .search-filter-section {
        padding: 1.5rem;
    }
    
    .table-header {
        padding: 1.25rem 1.5rem;
    }
    
    .cooperation-data-table thead th,
    .cooperation-data-table tbody td {
        padding: 1rem 0.75rem;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .page-main-title {
        font-size: 1.75rem;
    }
    
    .search-filter-section {
        padding: 1.25rem;
    }
    
    .table-header {
        padding: 1rem;
    }
    
    .table-title {
        font-size: 1.1rem;
    }
    
    .cooperation-data-table {
        font-size: 0.8rem;
    }
    
    .cooperation-data-table thead th,
    .cooperation-data-table tbody td {
        padding: 0.75rem 0.5rem;
    }
    
    .implementation-details {
        min-width: 250px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-number {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .kerja-sama-wrapper {
        padding: 1rem 0;
    }
    
    .page-header-section {
        padding: 1rem 0;
    }
    
    .page-main-title {
        font-size: 1.5rem;
    }
    
    .search-filter-section {
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .breadcrumb-nav {
        font-size: 0.85rem;
    }
    
    .cooperation-data-table thead th {
        font-size: 0.75rem;
        padding: 0.6rem 0.4rem;
    }
    
    .cooperation-data-table tbody td {
        padding: 0.6rem 0.4rem;
    }
    
    .partner-info,
    .date-info,
    .implementation-details,
    .scope-info,
    .unit-info {
        min-width: auto;
    }
    
    .pagination-btn {
        width: 38px;
        height: 38px;
        font-size: 0.8rem;
    }
}

/* Loading and Animation States */
.table-loading {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.fade-in {
    opacity: 0;
    animation: fadeInUp 0.6s ease forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Print Styles */
@media print {
    .search-filter-section,
    .pagination-section {
        display: none;
    }
    
    .cooperation-data-table {
        font-size: 0.8rem;
    }
    
    .cooperation-data-table thead th,
    .cooperation-data-table tbody td {
        padding: 0.5rem;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Include Navigation Component -->
<?= $this->include('layouts/components/public_navigation') ?>

<!-- Main Content Wrapper -->
<div class="kerja-sama-wrapper">
    <div class="container">
        
        <!-- Page Header -->
        <div class="page-header-section">
            <div class="page-header-content">
                <h1 class="page-main-title">Implementasi Kerja Sama</h1>
                <nav class="breadcrumb-nav">
                    <a href="<?= base_url('/') ?>">Beranda</a>
                    <span class="breadcrumb-separator">/</span>
                    <span>Implementasi Kerja Sama</span>
                </nav>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-card fade-in">
                    <div class="stat-number">150</div>
                    <div class="stat-label">Total Mitra</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="stat-number">89</div>
                    <div class="stat-label">Aktif</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="stat-number">61</div>
                    <div class="stat-label">Berakhir</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="stat-number">25</div>
                    <div class="stat-label">Internasional</div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="search-filter-section fade-in">
            <form class="search-form-wrapper" id="cooperationSearchForm">
                <div class="search-input-group">
                    <label class="search-label" for="searchCooperation">Cari Data</label>
                    <input 
                        type="text" 
                        class="search-input-field" 
                        id="searchCooperation" 
                        placeholder="Masukkan nama mitra, lokasi, atau kata kunci..."
                        autocomplete="off"
                    >
                </div>
                <div>
                    <button type="submit" class="search-btn-primary">
                        <i class="fas fa-search"></i>
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Table Section -->
        <div class="table-section fade-in">
            <div class="table-header">
                <h2 class="table-title">Data Implementasi Kerja Sama</h2>
                <p class="table-subtitle">Daftar lengkap kerja sama Perpustakaan Nasional dengan berbagai mitra</p>
            </div>
            
            <div class="table-responsive-wrapper">
                <table class="cooperation-data-table" id="cooperationTable">
                    <thead>
                        <tr>
                            <th class="partner-info">Nama Mitra</th>
                            <th class="date-info">Masa Berlaku</th>
                            <th class="implementation-details">Implementasi Kerja Sama</th>
                            <th class="scope-info">Lingkup</th>
                            <th class="unit-info">Unit Kerja</th>
                        </tr>
                    </thead>
                    <tbody id="cooperationTableBody">
                        <tr data-aos="fade-up">
                            <td class="partner-info">
                                <div class="partner-name">Akademi Kebidanan Nusantara</div>
                                <div class="partner-location">Lubuklinggau</div>
                            </td>
                            <td class="date-info">
                                <div class="date-range">30 Mar 2016 - 30 Mar 2021</div>
                            </td>
                            <td class="implementation-details">
                                <ol class="implementation-list" type="a">
                                    <li>Pengembangan SDM bidang Perpustakaan</li>
                                    <li>Pertemuan ilmiah, penelitian dan publikasi bersama koleksi perpustakaan</li>
                                    <li>Pertukaran data katalog induk perpustakaan</li>
                                    <li>Pengembangan dan pemanfaatan bersama koleksi perpustakaan</li>
                                    <li>Penghimpunan dan pelestarian Karya Cetak Karya Rekam (KCKR)</li>
                                    <li>Pertukaran jejaring perpustakaan lingkup nasional dan internasional</li>
                                </ol>
                            </td>
                            <td class="scope-info">
                                <span class="scope-badge scope-nasional">Nasional</span>
                            </td>
                            <td class="unit-info">
                                <div class="unit-details">
                                    <span class="unit-name">-</span>
                                </div>
                            </td>
                        </tr>
                        
                        <tr data-aos="fade-up">
                            <td class="partner-info">
                                <div class="partner-name">Akademi Kebidanan Nusantara</div>
                                <div class="partner-location">Palembang</div>
                            </td>
                            <td class="date-info">
                                <div class="date-range">30 Mar 2016 - 30 Mar 2021</div>
                            </td>
                            <td class="implementation-details">
                                <ol class="implementation-list" type="a">
                                    <li>Pengembangan SDM bidang Perpustakaan</li>
                                    <li>Pertemuan ilmiah, penelitian dan publikasi bersama koleksi perpustakaan</li>
                                    <li>Pertukaran data katalog induk perpustakaan</li>
                                    <li>Pengembangan dan pemanfaatan bersama koleksi perpustakaan</li>
                                    <li>Penghimpunan dan pelestarian Karya Cetak Karya Rekam (KCKR)</li>
                                    <li>Pertukaran jejaring perpustakaan lingkup nasional dan internasional</li>
                                </ol>
                            </td>
                            <td class="scope-info">
                                <span class="scope-badge scope-nasional">Nasional</span>
                            </td>
                            <td class="unit-info">
                                <div class="unit-details">
                                    <span class="unit-name">-</span>
                                </div>
                            </td>
                        </tr>
                        
                        <tr data-aos="fade-up">
                            <td class="partner-info">
                                <div class="partner-name">ARSIP NASIONAL</div>
                                <div class="partner-location">Jakarta</div>
                            </td>
                            <td class="date-info">
                                <div class="date-range">5 Maret 2018</div>
                            </td>
                            <td class="implementation-details">
                                <ol class="implementation-list" type="a">
                                    <li>Pembinaan penyelenggaraan kearsipan dan perpustakaan</li>
                                    <li>Pertemuan ilmiah dan pengelolaan koleksi</li>
                                    <li>Pengembangan sumber daya manusia kearsipan dan perpustakaan</li>
                                    <li>Pengembangan sistem preservasi</li>
                                    <li>Penyusunan dan pengembangan jabatan fungsional konservator</li>
                                </ol>
                            </td>
                            <td class="scope-info">
                                <span class="scope-badge scope-nasional">Nasional</span>
                            </td>
                            <td class="unit-info">
                                <div class="unit-details">
                                    <span class="unit-name">Inspektorat, Pusat Jasa Informasi Perpustakaan dan Pengelolaan Naskah Nusantara, Pusat Pendidikan dan Pelatihan</span>
                                </div>
                            </td>
                        </tr>
                        
                        <tr data-aos="fade-up">
                            <td class="partner-info">
                                <div class="partner-name">Badan Informasi Geospasial (BIG)</div>
                                <div class="partner-location">Bogor</div>
                            </td>
                            <td class="date-info">
                                <div class="date-range">Belum terimplementasikan</div>
                            </td>
                            <td class="implementation-details">
                                <ol class="implementation-list" type="a">
                                    <li>Pengembangan informasi geospasial tematik bidang kepustakawanan</li>
                                    <li>Pertemuan ilmiah berbasis sumber informasi geospasial</li>
                                    <li>Pengembangan koleksi perpustakaan</li>
                                    <li>Peningkatan layanan informasi bidang kepustakawanan dan informasi geospasial pada masyarakat</li>
                                    <li>Publikasi informasi bidang informasi geospasial</li>
                                    <li>Peningkatan sumber daya manusia di bidang kepustakawanan dan informasi geospasial</li>
                                    <li>Penggunaan bersama data koleksi elektronik nasional dan internasional</li>
                                    <li>Penghimpunan dan pelestarian Karya Cetak Karya Rekam (KCKR)</li>
                                    <li>Penyerahan duplikat informasi geospasial statistik berupa peta dan atlas</li>
                                    <li>Pengembangan Simpul Jaringan Informasi Geospasial Nasional</li>
                                    <li>Pertukaran data katalog induk Nasional Perpustakaan</li>
                                </ol>
                            </td>
                            <td class="scope-info">
                                <span class="scope-badge scope-nasional">Nasional</span>
                            </td>
                            <td class="unit-info">
                                <div class="unit-details">
                                    <span class="unit-name">Biro SDM dan Umum, Pusat Bibliografi dan Pengolahan Bahan Perpustakaan, Pusat Pengembangan Koleksi Perpustakaan</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Section -->
        <div class="pagination-section">
            <div class="pagination-wrapper">
                <button class="pagination-btn disabled" id="prevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="pagination-btn active" data-page="1">1</button>
                <button class="pagination-btn" data-page="2">2</button>
                <button class="pagination-btn" data-page="3">3</button>
                <button class="pagination-btn" data-page="4">4</button>
                <button class="pagination-btn" data-page="5">5</button>
                <button class="pagination-btn" data-page="6">6</button>
                <button class="pagination-btn" id="nextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize page functionality
    initializeKerjaSamaPage();
    
    function initializeKerjaSamaPage() {
        // Search functionality
        setupSearchFunctionality();
        
        // Pagination functionality
        setupPaginationFunctionality();
        
        // Animation on scroll
        setupScrollAnimations();
        
        // Table interactions
        setupTableInteractions();
    }
    
    function setupSearchFunctionality() {
        const searchForm = document.getElementById('cooperationSearchForm');
        const searchInput = document.getElementById('searchCooperation');
        const tableRows = document.querySelectorAll('#cooperationTableBody tr');
        
        // Real-time search
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            filterTableRows(searchTerm, tableRows);
        });
        
        // Form submit
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const searchTerm = searchInput.value.toLowerCase().trim();
            filterTableRows(searchTerm, tableRows);
        });
        
        function filterTableRows(searchTerm, rows) {
            let visibleCount = 0;
            
            rows.forEach(function(row) {
                const partnerName = row.querySelector('.partner-name').textContent.toLowerCase();
                const partnerLocation = row.querySelector('.partner-location').textContent.toLowerCase();
                const implementationText = row.querySelector('.implementation-list').textContent.toLowerCase();
                const unitName = row.querySelector('.unit-name').textContent.toLowerCase();
                
                const isMatch = searchTerm === '' || 
                               partnerName.includes(searchTerm) || 
                               partnerLocation.includes(searchTerm) || 
                               implementationText.includes(searchTerm) || 
                               unitName.includes(searchTerm);
                
                if (isMatch) {
                    row.style.display = '';
                    visibleCount++;
                    // Add highlight effect
                    if (searchTerm !== '') {
                        row.style.backgroundColor = '#fff3cd';
                        setTimeout(() => {
                            row.style.backgroundColor = '';
                        }, 1000);
                    }
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update pagination visibility
            updatePaginationVisibility(searchTerm !== '');
            
            // Show no results message if needed
            showNoResultsMessage(visibleCount === 0 && searchTerm !== '');
        }
    }
    
    function setupPaginationFunctionality() {
        const paginationBtns = document.querySelectorAll('.pagination-btn[data-page]');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        paginationBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const page = parseInt(this.dataset.page);
                setActivePage(page);
                
                // Simulate page loading (you would implement actual pagination here)
                showLoadingState();
                setTimeout(() => {
                    hideLoadingState();
                    scrollToTop();
                }, 500);
            });
        });
        
        prevBtn.addEventListener('click', function() {
            const currentPage = getCurrentPage();
            if (currentPage > 1) {
                setActivePage(currentPage - 1);
            }
        });
        
        nextBtn.addEventListener('click', function() {
            const currentPage = getCurrentPage();
            const maxPage = 6; // Based on your pagination
            if (currentPage < maxPage) {
                setActivePage(currentPage + 1);
            }
        });
        
        function setActivePage(page) {
            // Remove active class from all buttons
            paginationBtns.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to selected page
            const targetBtn = document.querySelector(`[data-page="${page}"]`);
            if (targetBtn) {
                targetBtn.classList.add('active');
            }
            
            // Update prev/next button states
            updatePrevNextButtons(page);
        }
        
        function getCurrentPage() {
            const activeBtn = document.querySelector('.pagination-btn.active');
            return activeBtn ? parseInt(activeBtn.dataset.page) : 1;
        }
        
        function updatePrevNextButtons(currentPage) {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            prevBtn.classList.toggle('disabled', currentPage === 1);
            nextBtn.classList.toggle('disabled', currentPage === 6);
        }
    }
    
    function setupScrollAnimations() {
        const animatedElements = document.querySelectorAll('.fade-in');
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        animatedElements.forEach(function(element) {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(element);
        });
    }
    
    function setupTableInteractions() {
        const tableRows = document.querySelectorAll('#cooperationTableBody tr');
        
        tableRows.forEach(function(row) {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.01)';
                this.style.zIndex = '10';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.zIndex = '1';
            });
        });
    }
    
    function updatePaginationVisibility(isSearching) {
        const paginationSection = document.querySelector('.pagination-section');
        paginationSection.style.display = isSearching ? 'none' : 'flex';
    }
    
    function showNoResultsMessage(show) {
        const existingMessage = document.getElementById('noResultsMessage');
        
        if (show && !existingMessage) {
            const tableBody = document.getElementById('cooperationTableBody');
            const message = document.createElement('tr');
            message.id = 'noResultsMessage';
            message.innerHTML = `
                <td colspan="5" style="text-align: center; padding: 3rem; color: #6c757d;">
                    <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                    <div style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">Tidak ada data yang ditemukan</div>
                    <div style="font-size: 0.9rem;">Coba gunakan kata kunci yang berbeda</div>
                </td>
            `;
            tableBody.appendChild(message);
        } else if (!show && existingMessage) {
            existingMessage.remove();
        }
    }
    
    function showLoadingState() {
        const tableBody = document.getElementById('cooperationTableBody');
        const existingRows = tableBody.querySelectorAll('tr:not(#loadingMessage)');
        existingRows.forEach(row => row.style.opacity = '0.5');
        
        if (!document.getElementById('loadingMessage')) {
            const loadingRow = document.createElement('tr');
            loadingRow.id = 'loadingMessage';
            loadingRow.innerHTML = `
                <td colspan="5" style="text-align: center; padding: 2rem;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 1.5rem; color: #007bff;"></i>
                    <div style="margin-top: 0.5rem; color: #6c757d;">Memuat data...</div>
                </td>
            `;
            tableBody.appendChild(loadingRow);
        }
    }
    
    function hideLoadingState() {
        const loadingMessage = document.getElementById('loadingMessage');
        if (loadingMessage) {
            loadingMessage.remove();
        }
        
        const tableRows = document.querySelectorAll('#cooperationTableBody tr');
        tableRows.forEach(row => row.style.opacity = '1');
    }
    
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
    
    // Enhanced table functionality
    function enhanceTableFeatures() {
        // Add sorting functionality
        const headerCells = document.querySelectorAll('.cooperation-data-table thead th');
        
        headerCells.forEach(function(header, index) {
            header.style.cursor = 'pointer';
            header.style.userSelect = 'none';
            
            header.addEventListener('click', function() {
                sortTable(index);
            });
        });
    }
    
    function sortTable(columnIndex) {
        const table = document.getElementById('cooperationTable');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr:not(#noResultsMessage):not(#loadingMessage)'));
        
        // Toggle sort direction
        const currentSort = table.dataset.sortColumn;
        const currentDirection = table.dataset.sortDirection || 'asc';
        const newDirection = (currentSort === columnIndex.toString() && currentDirection === 'asc') ? 'desc' : 'asc';
        
        table.dataset.sortColumn = columnIndex;
        table.dataset.sortDirection = newDirection;
        
        // Sort rows
        rows.sort(function(a, b) {
            const aText = a.cells[columnIndex].textContent.trim();
            const bText = b.cells[columnIndex].textContent.trim();
            
            const comparison = aText.localeCompare(bText);
            return newDirection === 'asc' ? comparison : -comparison;
        });
        
        // Re-append sorted rows
        rows.forEach(row => tbody.appendChild(row));
        
        // Update header indicators
        updateSortIndicators(columnIndex, newDirection);
    }
    
    function updateSortIndicators(activeColumn, direction) {
        const headers = document.querySelectorAll('.cooperation-data-table thead th');
        
        headers.forEach(function(header, index) {
            // Remove existing indicators
            const existingIcon = header.querySelector('.sort-icon');
            if (existingIcon) {
                existingIcon.remove();
            }
            
            // Add new indicator for active column
            if (index === activeColumn) {
                const icon = document.createElement('i');
                icon.className = `fas fa-chevron-${direction === 'asc' ? 'up' : 'down'} sort-icon`;
                icon.style.marginLeft = '0.5rem';
                icon.style.fontSize = '0.8rem';
                header.appendChild(icon);
            }
        });
    }
    
    // Initialize enhanced features
    enhanceTableFeatures();
    
    // Statistics counter animation
    function animateCounters() {
        const counters = document.querySelectorAll('.stat-number');
        
        counters.forEach(function(counter) {
            const target = parseInt(counter.textContent);
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;
            
            const timer = setInterval(function() {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                counter.textContent = Math.floor(current);
            }, 16);
        });
    }
    
    // Trigger counter animation when stats section is visible
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        const statsObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    animateCounters();
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        statsObserver.observe(statsSection);
    }
});
</script>
<?= $this->endSection() ?>