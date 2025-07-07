<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Kerja Sama - Pilih Halaman<?= $this->endSection() ?>

<?= $this->section('description') ?>Pilih halaman Kerja Sama yang ingin Anda kunjungi - Data Kerja Sama, Implementasi, Progress, dan lainnya.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>kerja sama, data, implementasi, progress, pengajuan, perpustakaan nasional<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/navigation.css') ?>" rel="stylesheet">
<style>
/* Kerja Sama Landing Page Styles */
.landing-wrapper {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 200px);
    padding: 3rem 0;
    position: relative;
    overflow: hidden;
}

.landing-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="%23ffffff" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
    pointer-events: none;
}

.page-header-section {
    background: white;
    padding: 2rem 0;
    margin-bottom: 3rem;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    position: relative;
    z-index: 2;
}

.page-header-content {
    text-align: center;
}

.page-main-title {
    color: #2c3e50;
    font-size: 2.75rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.2;
    position: relative;
}

.page-main-title::after {
    content: '';
    width: 80px;
    height: 4px;
    background: linear-gradient(45deg, #4CAF50, #66BB6A);
    display: block;
    margin: 1rem auto 0;
    border-radius: 2px;
}

.page-subtitle {
    color: #6c757d;
    font-size: 1.25rem;
    font-weight: 300;
    margin: 0;
    line-height: 1.4;
}

.breadcrumb-nav {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    color: #6c757d;
    font-size: 0.95rem;
    margin-top: 1.5rem;
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

/* Menu Grid Section */
.menu-section {
    position: relative;
    z-index: 2;
}

.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    max-width: 1000px;
    margin: 0 auto;
}

.menu-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    border: 1px solid #f0f0f0;
}

.menu-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.6s ease;
}

.menu-card:hover::before {
    left: 100%;
}

.menu-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    border-color: #4CAF50;
}

.menu-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #4CAF50, #66BB6A);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

.menu-card:hover .menu-icon {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 8px 20px rgba(76, 175, 80, 0.4);
}

.menu-title {
    color: #2c3e50;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.3;
    position: relative;
    z-index: 2;
}

.menu-description {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 2rem;
    position: relative;
    z-index: 2;
}

.menu-button {
    background: linear-gradient(45deg, #4CAF50, #66BB6A);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
    overflow: hidden;
}

.menu-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, #45a049, #5db85a);
    transition: left 0.3s ease;
    z-index: -1;
}

.menu-button:hover::before {
    left: 0;
}

.menu-button:hover {
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
}

.menu-button i {
    transition: transform 0.3s ease;
}

.menu-button:hover i {
    transform: translateX(4px);
}

/* Special styles for different menu items */
.menu-card:nth-child(1) .menu-icon {
    background: linear-gradient(135deg, #007bff, #4dabf7);
}

.menu-card:nth-child(1):hover .menu-icon {
    box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
}

.menu-card:nth-child(2) .menu-icon {
    background: linear-gradient(135deg, #28a745, #51cf66);
}

.menu-card:nth-child(2):hover .menu-icon {
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
}

.menu-card:nth-child(3) .menu-icon {
    background: linear-gradient(135deg, #ffc107, #ffdd57);
}

.menu-card:nth-child(3):hover .menu-icon {
    box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
}

.menu-card:nth-child(4) .menu-icon {
    background: linear-gradient(135deg, #17a2b8, #4dd0e1);
}

.menu-card:nth-child(4):hover .menu-icon {
    box-shadow: 0 8px 20px rgba(23, 162, 184, 0.4);
}

.menu-card:nth-child(5) .menu-icon {
    background: linear-gradient(135deg, #6f42c1, #9775fa);
}

.menu-card:nth-child(5):hover .menu-icon {
    box-shadow: 0 8px 20px rgba(111, 66, 193, 0.4);
}

/* Animation on scroll */
.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
}

.fade-in-up.animate {
    opacity: 1;
    transform: translateY(0);
}

/* Quick access section */
.quick-access-section {
    margin-top: 3rem;
    text-align: center;
    position: relative;
    z-index: 2;
}

.quick-access-title {
    color: #495057;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.quick-links {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.quick-link {
    background: white;
    color: #6c757d;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quick-link:hover {
    background: #4CAF50;
    color: white;
    border-color: #4CAF50;
    transform: translateY(-2px);
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
}

/* Responsive Design */
@media (max-width: 1200px) {
    .menu-grid {
        grid-template-columns: repeat(2, 1fr);
        max-width: 800px;
    }
}

@media (max-width: 992px) {
    .landing-wrapper {
        padding: 2rem 0;
    }
    
    .page-main-title {
        font-size: 2.25rem;
    }
    
    .page-subtitle {
        font-size: 1.1rem;
    }
    
    .menu-grid {
        gap: 1.5rem;
    }
    
    .menu-card {
        padding: 1.5rem;
    }
}

@media (max-width: 768px) {
    .menu-grid {
        grid-template-columns: 1fr;
        max-width: 400px;
    }
    
    .page-main-title {
        font-size: 2rem;
    }
    
    .page-subtitle {
        font-size: 1rem;
    }
    
    .menu-card {
        padding: 1.25rem;
    }
    
    .menu-icon {
        width: 70px;
        height: 70px;
        font-size: 2rem;
    }
    
    .menu-title {
        font-size: 1.1rem;
    }
    
    .quick-links {
        gap: 0.75rem;
    }
    
    .quick-link {
        padding: 0.6rem 1.25rem;
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .landing-wrapper {
        padding: 1.5rem 0;
    }
    
    .page-header-section {
        padding: 1.5rem 0;
        margin-bottom: 2rem;
    }
    
    .page-main-title {
        font-size: 1.75rem;
    }
    
    .breadcrumb-nav {
        font-size: 0.85rem;
    }
    
    .menu-card {
        padding: 1rem;
    }
    
    .menu-icon {
        width: 60px;
        height: 60px;
        font-size: 1.75rem;
        margin-bottom: 1rem;
    }
    
    .menu-title {
        font-size: 1rem;
    }
    
    .menu-description {
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }
    
    .menu-button {
        padding: 0.75rem 1.75rem;
        font-size: 0.9rem;
    }
}

/* Loading animation */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.menu-card.loading .menu-icon {
    animation: pulse 1.5s infinite;
}

/* Accessibility improvements */
@media (prefers-reduced-motion: reduce) {
    .menu-card,
    .menu-icon,
    .menu-button,
    .quick-link,
    .fade-in-up {
        transition: none;
        animation: none;
    }
    
    .menu-card:hover {
        transform: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .menu-card {
        border: 2px solid #000;
    }
    
    .menu-title {
        color: #000;
    }
    
    .menu-description {
        color: #333;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Include Navigation Component -->
<?= $this->include('layouts/components/public_navigation') ?>

<!-- Main Content Wrapper -->
<div class="landing-wrapper">
    <div class="container">
        
        <!-- Page Header -->
        <div class="page-header-section fade-in-up">
            <div class="page-header-content">
                <h1 class="page-main-title">Kerja Sama</h1>
                <p class="page-subtitle">Pilih halaman yang ingin Anda kunjungi untuk melihat informasi detail tentang kerja sama Perpustakaan Nasional</p>
                <nav class="breadcrumb-nav">
                    <a href="<?= base_url('/') ?>">Beranda</a>
                    <span class="breadcrumb-separator">/</span>
                    <span>Kerja Sama</span>
                </nav>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="menu-section">
            <div class="menu-grid">
                
                <!-- Data Kerja Sama -->
                <div class="menu-card fade-in-up" data-delay="100">
                    <div class="menu-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="menu-title">Data Kerja Sama</h3>
                    <p class="menu-description">
                        Lihat seluruh data kerja sama yang telah ditandatangani dengan berbagai institusi dan organisasi mitra.
                    </p>
                    <a href="<?= base_url('kerja-sama/data') ?>" class="menu-button">
                        Lihat Data
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <!-- Implementasi Kerja Sama -->
                <div class="menu-card fade-in-up" data-delay="200">
                    <div class="menu-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3 class="menu-title">Implementasi Kerja Sama</h3>
                    <p class="menu-description">
                        Monitor dan evaluasi implementasi dari kerja sama yang sedang berjalan dan pencapaian yang telah diraih.
                    </p>
                    <a href="<?= base_url('kerja-sama/implementasi') ?>" class="menu-button">
                        Lihat Implementasi
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <!-- Kerja Sama yang Akan Berakhir -->
                <div class="menu-card fade-in-up" data-delay="300">
                    <div class="menu-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3 class="menu-title">Kerja Sama yang Akan Berakhir</h3>
                    <p class="menu-description">
                        Pantau kerja sama yang akan segera berakhir dan memerlukan perpanjangan atau evaluasi lanjutan.
                    </p>
                    <a href="<?= base_url('kerja-sama/akan-berakhir') ?>" class="menu-button">
                        Lihat Status
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <!-- Progress -->
                <div class="menu-card fade-in-up" data-delay="400">
                    <div class="menu-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="menu-title">Progress</h3>
                    <p class="menu-description">
                        Analisis progress dan capaian dari berbagai program kerja sama yang sedang berjalan dengan mitra.
                    </p>
                    <a href="<?= base_url('kerja-sama/progress') ?>" class="menu-button">
                        Lihat Progress
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <!-- Pengajuan -->
                <div class="menu-card fade-in-up" data-delay="500">
                    <div class="menu-icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <h3 class="menu-title">Pengajuan</h3>
                    <p class="menu-description">
                        Ajukan proposal kerja sama baru atau perpanjangan kerja sama yang sudah ada dengan berbagai institusi.
                    </p>
                    <a href="<?= base_url('kerja-sama/pengajuan') ?>" class="menu-button">
                        Buat Pengajuan
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
            </div>
        </div>

        <!-- Quick Access Section -->
        <div class="quick-access-section fade-in-up" data-delay="600">
            <h4 class="quick-access-title">Akses Cepat</h4>
            <div class="quick-links">
                <a href="<?= base_url('/') ?>" class="quick-link">
                    <i class="fas fa-home"></i>
                    Beranda
                </a>
                <a href="<?= base_url('tentang') ?>" class="quick-link">
                    <i class="fas fa-info-circle"></i>
                    Tentang
                </a>
                <a href="<?= base_url('peta-kerja-sama') ?>" class="quick-link">
                    <i class="fas fa-map"></i>
                    Peta Kerja Sama
                </a>
                <a href="<?= base_url('kontak') ?>" class="quick-link">
                    <i class="fas fa-envelope"></i>
                    Kontak
                </a>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize landing page functionality
    initializeLandingPage();
    
    function initializeLandingPage() {
        // Setup scroll animations
        setupScrollAnimations();
        
        // Setup card interactions
        setupCardInteractions();
        
        // Setup loading states
        setupLoadingStates();
        
        // Add accessibility enhancements
        setupAccessibility();
    }
    
    function setupScrollAnimations() {
        const animatedElements = document.querySelectorAll('.fade-in-up');
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const delay = parseInt(entry.target.dataset.delay) || 0;
                    
                    setTimeout(() => {
                        entry.target.classList.add('animate');
                    }, delay);
                    
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        animatedElements.forEach(function(element) {
            observer.observe(element);
        });
    }
    
    function setupCardInteractions() {
        const menuCards = document.querySelectorAll('.menu-card');
        
        menuCards.forEach(function(card) {
            const button = card.querySelector('.menu-button');
            
            // Add click handler for entire card
            card.addEventListener('click', function(e) {
                if (e.target === card || e.target.closest('.menu-icon, .menu-title, .menu-description')) {
                    button.click();
                }
            });
            
            // Add keyboard navigation
            card.setAttribute('tabindex', '0');
            card.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    button.click();
                }
            });
            
            // Enhanced hover effects
            card.addEventListener('mouseenter', function() {
                this.style.cursor = 'pointer';
            });
        });
    }
    
    function setupLoadingStates() {
        const menuButtons = document.querySelectorAll('.menu-button');
        
        menuButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                const card = this.closest('.menu-card');
                
                // Add loading state
                card.classList.add('loading');
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
                this.style.pointerEvents = 'none';
                
                // Remove loading state after navigation (fallback)
                setTimeout(() => {
                    card.classList.remove('loading');
                }, 3000);
            });
        });
    }
    
    function setupAccessibility() {
        // Add ARIA labels
        const menuCards = document.querySelectorAll('.menu-card');
        menuCards.forEach(function(card, index) {
            const title = card.querySelector('.menu-title').textContent;
            card.setAttribute('aria-label', `Menu ${title}`);
            card.setAttribute('role', 'button');
        });
        
        // Add focus management
        const quickLinks = document.querySelectorAll('.quick-link');
        quickLinks.forEach(function(link) {
            link.addEventListener('focus', function() {
                this.style.outline = '2px solid #4CAF50';
                this.style.outlineOffset = '2px';
            });
            
            link.addEventListener('blur', function() {
                this.style.outline = 'none';
            });
        });
    }
    
    // Add performance monitoring
    function trackMenuUsage() {
        const menuButtons = document.querySelectorAll('.menu-button');
        
        menuButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const menuTitle = this.closest('.menu-card').querySelector('.menu-title').textContent;
                
                // Track usage (you can send this to analytics)
                console.log('Menu accessed:', menuTitle, 'at', new Date().toISOString());
                
                // Store in localStorage for future reference
                const accessHistory = JSON.parse(localStorage.getItem('menuAccessHistory') || '[]');
                accessHistory.push({
                    menu: menuTitle,
                    timestamp: new Date().toISOString()
                });
                
                // Keep only last 10 accesses
                if (accessHistory.length > 10) {
                    accessHistory.shift();
                }
                
                localStorage.setItem('menuAccessHistory', JSON.stringify(accessHistory));
            });
        });
    }
    
    trackMenuUsage();
    
    // Add smooth scrolling for quick links
    document.querySelectorAll('.quick-link[href^="#"]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add page visibility handling
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            // Page is hidden, pause animations
            document.querySelectorAll('.menu-card.loading .menu-icon').forEach(function(icon) {
                icon.style.animationPlayState = 'paused';
            });
        } else {
            // Page is visible, resume animations
            document.querySelectorAll('.menu-card.loading .menu-icon').forEach(function(icon) {
                icon.style.animationPlayState = 'running';
            });
        }
    });
});
</script>
<?= $this->endSection() ?>