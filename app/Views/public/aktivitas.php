<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Aktivitas<?= $this->endSection() ?>

<?= $this->section('description') ?>Berita dan aktivitas terkini dari Sub Bidang Kerja Sama Perpustakaan, Perpustakaan Nasional RI. Informasi kegiatan, kerjasama, dan perkembangan perpustakaan.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>aktivitas, berita, kerjasama, perpustakaan nasional, kegiatan, jakarta, mou<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/navigation.css') ?>" rel="stylesheet">
<style>
/* Consistent header styles with other pages */
.home-header {
    background: var(--primary-green);
    padding: 1rem 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.home-nav {
    background: var(--primary-blue);
    padding: 0;
}

.home-nav .nav-link {
    color: white !important;
    padding: 15px 20px;
    font-size: 14px;
    font-weight: 500;
    transition: background 0.3s;
}

.home-nav .nav-link:hover,
.home-nav .nav-link.active {
    background: rgba(255,255,255,0.1);
}

/* Logo optimization - same as other pages */
.home-header .logo-container {
    width: 50px;
    height: 50px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.home-header .logo-container:hover {
    transform: scale(1.05);
}

.home-header .logo-container img {
    width: 35px;
    height: 35px;
    object-fit: contain;
}

/* Aktivitas page specific styles */
.aktivitas-section {
    background: white;
    padding: 2rem 0;
    min-height: calc(100vh - 200px);
}

.page-title {
    color: var(--text-dark, #333);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
    position: relative;
    padding-bottom: 0.5rem;
}

/* News Cards */
.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.news-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.news-image {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #f0f0f0;
}

.news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.news-card:hover .news-image img {
    transform: scale(1.05);
}

.news-image-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
    font-size: 1rem;
}

.news-content {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.news-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.news-date, .news-category {
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.news-date i, .news-category i {
    font-size: 0.75rem;
}

.news-category {
    color: var(--primary-blue, #2196F3);
}

.news-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark, #333);
    margin-bottom: 1rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.news-excerpt {
    color: var(--text-light, #666);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex-grow: 1;
}

.btn-read-more {
    background-color: var(--primary-green, #4CAF50);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    align-self: flex-start;
    margin-top: auto;
}

.btn-read-more:hover {
    background-color: #45a049;
    color: white;
    transform: translateY(-1px);
}

/* Pagination */
.pagination-wrapper {
    margin-top: 3rem;
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    gap: 0.5rem;
}

.page-link {
    color: var(--primary-blue, #2196F3);
    border: 1px solid #dee2e6;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.page-link:hover {
    color: white;
    background-color: var(--primary-blue, #2196F3);
    border-color: var(--primary-blue, #2196F3);
}

.page-item.active .page-link {
    background-color: var(--primary-blue, #2196F3);
    border-color: var(--primary-blue, #2196F3);
    color: white;
}

.page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
    cursor: not-allowed;
}

/* Filter Section */
.filter-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.filter-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark, #333);
    margin-bottom: 1rem;
}

.filter-options {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-option {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    border-radius: 20px;
    background: white;
    color: var(--text-dark, #333);
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.filter-option:hover,
.filter-option.active {
    background: var(--primary-blue, #2196F3);
    color: white;
    border-color: var(--primary-blue, #2196F3);
}

/* Responsive design */
@media (max-width: 992px) {
    .news-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .page-title {
        font-size: 1.75rem;
    }
}

@media (max-width: 768px) {
    .aktivitas-section {
        padding: 1.5rem 0;
    }
    
    .news-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .news-image {
        height: 180px;
    }
    
    .news-content {
        padding: 1.25rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .filter-section {
        padding: 1rem;
    }
    
    .filter-options {
        gap: 0.5rem;
    }
    
    .home-nav .nav-link {
        padding: 12px 15px;
        font-size: 13px;
    }
    
    .home-header .logo-container {
        width: 45px;
        height: 45px;
    }
    
    .home-header .logo-container img {
        width: 30px;
        height: 30px;
    }
}

@media (max-width: 576px) {
    .news-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .news-title {
        font-size: 1rem;
    }
    
    .news-excerpt {
        font-size: 0.9rem;
    }
    
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Include Navigation Component - Same as other pages -->
<?= $this->include('layouts/components/public_navigation') ?>

<!-- Main Content -->
<section class="aktivitas-section">
    <div class="container">
        <h1 class="page-title">Aktivitas</h1>
        
        <!-- News Grid -->
        <div class="news-grid">
            <!-- News Card 1 -->
            <article class="news-card">
                <div class="news-image">
                    <div class="news-image-placeholder">
                        <i class="fas fa-image fa-2x"></i>
                    </div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date"><i class="fas fa-calendar"></i> 2025-07-03</span>
                        <span class="news-category"><i class="fas fa-tag"></i> Berita</span>
                    </div>
                    <h3 class="news-title">Penguatan Kelembagaan Perpustakaan, Pemkab Asmat Konsultasi ke Perpusnas</h3>
                    <p class="news-excerpt">JAKARTA - Perpustakaan Nasional Republik Indonesia (Perpusnas) menerima kunjungan konsultasi dari Pemerintah Kabupaten Asmat terkait penguatan kelembagaan perpustakaan daerah. Kegiatan ini merupakan bagian dari upaya meningkatkan kualitas layanan perpustakaan di daerah.</p>
                    <a href="#" class="btn-read-more">Baca Selengkapnya</a>
                </div>
            </article>

            <!-- News Card 2 -->
            <article class="news-card">
                <div class="news-image">
                    <div class="news-image-placeholder">
                        <i class="fas fa-image fa-2x"></i>
                    </div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date"><i class="fas fa-calendar"></i> 2025-07-03</span>
                        <span class="news-category"><i class="fas fa-tag"></i> Berita</span>
                    </div>
                    <h3 class="news-title">Jelang Peringatan 200 Tahun Perang Jawa, Perpusnas Lakukan Audiensi</h3>
                    <p class="news-excerpt">JAKARTA - Dalam rangka memperingati 200 tahun Perang Jawa, Perpustakaan Nasional RI melakukan audiensi dengan berbagai pihak untuk membahas rencana kegiatan dan pameran koleksi bersejarah terkait peristiwa penting dalam sejarah Indonesia.</p>
                    <a href="#" class="btn-read-more">Baca Selengkapnya</a>
                </div>
            </article>

            <!-- News Card 3 -->
            <article class="news-card">
                <div class="news-image">
                    <div class="news-image-placeholder">
                        <i class="fas fa-image fa-2x"></i>
                    </div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date"><i class="fas fa-calendar"></i> 2025-07-02</span>
                        <span class="news-category"><i class="fas fa-tag"></i> Berita</span>
                    </div>
                    <h3 class="news-title">Relima, Gerakan Kolaboratif Relawan Literasi Bangkitkan Budaya Baca</h3>
                    <p class="news-excerpt">JAKARTA - Perpustakaan Nasional RI meluncurkan program Relima (Relawan Literasi Masyarakat), sebuah gerakan kolaboratif yang bertujuan membangkitkan budaya baca di masyarakat melalui pendekatan sukarela dan partisipatif.</p>
                    <a href="#" class="btn-read-more">Baca Selengkapnya</a>
                </div>
            </article>

            <!-- News Card 4 -->
            <article class="news-card">
                <div class="news-image">
                    <div class="news-image-placeholder">
                        <i class="fas fa-image fa-2x"></i>
                    </div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date"><i class="fas fa-calendar"></i> 2025-07-01</span>
                        <span class="news-category"><i class="fas fa-tag"></i> Berita</span>
                    </div>
                    <h3 class="news-title">Diskusi Penguatan Kolaborasi Antar Perpustakaan</h3>
                    <p class="news-excerpt">JAKARTA - Membahas strategi penguatan kolaborasi antar perpustakaan dalam rangka meningkatkan layanan perpustakaan di Indonesia. Diskusi melibatkan berbagai stakeholder dari perpustakaan daerah dan institusi pendidikan.</p>
                    <a href="#" class="btn-read-more">Baca Selengkapnya</a>
                </div>
            </article>

            <!-- News Card 5 -->
            <article class="news-card">
                <div class="news-image">
                    <div class="news-image-placeholder">
                        <i class="fas fa-image fa-2x"></i>
                    </div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date"><i class="fas fa-calendar"></i> 2025-06-30</span>
                        <span class="news-category"><i class="fas fa-tag"></i> Berita</span>
                    </div>
                    <h3 class="news-title">Penandatanganan MoU Kerjasama Perpustakaan Daerah</h3>
                    <p class="news-excerpt">JAKARTA - Perpustakaan Nasional melakukan penandatanganan MoU kerjasama dengan berbagai perpustakaan daerah untuk meningkatkan layanan dan kualitas perpustakaan di seluruh Indonesia melalui program pembinaan berkelanjutan.</p>
                    <a href="#" class="btn-read-more">Baca Selengkapnya</a>
                </div>
            </article>

            <!-- News Card 6 -->
            <article class="news-card">
                <div class="news-image">
                    <div class="news-image-placeholder">
                        <i class="fas fa-image fa-2x"></i>
                    </div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date"><i class="fas fa-calendar"></i> 2025-06-29</span>
                        <span class="news-category"><i class="fas fa-tag"></i> Berita</span>
                    </div>
                    <h3 class="news-title">Inspirasi dari Makna Hijrah dalam Pengembangan Perpustakaan</h3>
                    <p class="news-excerpt">JAKARTA - Kegiatan memperingati hari besar Islam dengan mengaitkan makna hijrah dalam pengembangan dan transformasi perpustakaan modern. Diskusi membahas inovasi layanan perpustakaan yang relevan dengan perkembangan zaman.</p>
                    <a href="#" class="btn-read-more">Baca Selengkapnya</a>
                </div>
            </article>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterOptions = document.querySelectorAll('.filter-option');
    const newsCards = document.querySelectorAll('.news-card');
    
    filterOptions.forEach(function(option) {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all options
            filterOptions.forEach(opt => opt.classList.remove('active'));
            
            // Add active class to clicked option
            this.classList.add('active');
            
            const filterValue = this.textContent.toLowerCase();
            
            // Filter news cards (in real implementation, this would be server-side)
            newsCards.forEach(function(card) {
                if (filterValue === 'semua') {
                    card.style.display = 'flex';
                } else {
                    // Simple filter logic - in real implementation, use data attributes
                    const category = card.querySelector('.news-category').textContent.toLowerCase();
                    const title = card.querySelector('.news-title').textContent.toLowerCase();
                    
                    if (title.includes(filterValue) || category.includes(filterValue)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        });
    });
    
    // Animate news cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe news cards
    newsCards.forEach(function(card, index) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });

    // Observe page title
    const pageTitle = document.querySelector('.page-title');
    if (pageTitle) {
        pageTitle.style.opacity = '0';
        pageTitle.style.transform = 'translateY(-20px)';
        pageTitle.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(pageTitle);
    }

    // Observe filter section
    const filterSection = document.querySelector('.filter-section');
    if (filterSection) {
        filterSection.style.opacity = '0';
        filterSection.style.transform = 'translateY(-10px)';
        filterSection.style.transition = 'opacity 0.6s ease 0.2s, transform 0.6s ease 0.2s';
        observer.observe(filterSection);
    }
});
</script>
<?= $this->endSection() ?>