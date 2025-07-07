<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Tentang<?= $this->endSection() ?>

<?= $this->section('description') ?>Portal Kerjasama Perpustakaan Nasional - Penyiapan bahan dan melakukan kerja sama perpustakaan dalam dan luar negeri sesuai dengan petunjuk dan pedoman yang berlaku.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>tentang, perpustakaan nasional, kerjasama, tugas, fungsi, mou, moa<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/navigation.css') ?>" rel="stylesheet">
<style>
/* Consistent header styles with home page */
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

/* Logo optimization - same as home */
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

/* Page specific styles */
.page-header {
    background: #F5F5F5;
    padding: 2rem 0 1rem 0;
}

.page-title {
    color: var(--text-dark, #333);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0;
}

.content-section {
    background: white;
    padding: 2rem 0;
    min-height: calc(100vh - 300px);
}

.about-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: start;
}

.about-image {
    width: 100%;
    height: 400px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.about-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.about-content {
    padding: 1rem 0;
}

.section-title {
    color: var(--text-dark, #333);
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.about-text {
    color: var(--text-light, #666);
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    text-align: justify;
}

.functions-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.function-item {
    color: var(--text-light, #666);
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 0.75rem;
    padding-left: 1.5rem;
    position: relative;
}

.function-item::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0.6rem;
    width: 6px;
    height: 6px;
    background: var(--primary-green, #4CAF50);
    border-radius: 50%;
}

.function-letter {
    font-weight: 600;
    color: var(--text-dark, #333);
}

/* Responsive design */
@media (max-width: 992px) {
    .about-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .about-image {
        height: 300px;
        order: -1;
    }
    
    .page-title {
        font-size: 1.75rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem 0 0.5rem 0;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .section-title {
        font-size: 1.25rem;
    }
    
    .about-text,
    .function-item {
        font-size: 0.95rem;
    }
    
    .about-container {
        gap: 1.5rem;
    }
    
    .about-image {
        height: 250px;
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
    .content-section {
        padding: 1.5rem 0;
    }
    
    .about-content {
        padding: 0;
    }
    
    .function-item {
        padding-left: 1.25rem;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Include Navigation Component - Same as Home -->
<?= $this->include('layouts/components/public_navigation') ?>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="page-title">Tentang</h1>
    </div>
</div>

<!-- Main Content -->
<section class="content-section">
    <div class="container">
        <div class="about-container">
            <!-- About Image -->
            <div class="about-image">
                <img src="<?= base_url('assets/images/public/about-kerjasama.jpg') ?>" 
                     alt="Kegiatan Kerjasama Perpustakaan Nasional" 
                     loading="lazy">
            </div>
            
            <!-- About Content -->
            <div class="about-content">
                <h2 class="section-title">Tugas</h2>
                <p class="about-text">
                    Penyiapan bahan dan melakukan kerja sama perpustakaan dalam dan luar negeri sesuai dengan petunjuk dan pedoman yang berlaku.
                </p>
                
                <h3 class="section-title">Fungsi:</h3>
                <ul class="functions-list">
                    <li class="function-item">
                        <span class="function-letter">a)</span> Pelaksanaan kerja sama perpustakaan dalam dan luar negeri
                    </li>
                    <li class="function-item">
                        <span class="function-letter">b)</span> Penerima dan mengelola permohonan inisiasi kerja sama
                    </li>
                    <li class="function-item">
                        <span class="function-letter">c)</span> Pelaksanaan penanda tanganan naskah Kesepahaman Bersama atau Memorandum of Understanding (MoU)
                    </li>
                    <li class="function-item">
                        <span class="function-letter">d)</span> Mengelola dan mengevaluasi implementasi kerja sama.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate function items on scroll
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

    // Observe function items
    const functionItems = document.querySelectorAll('.function-item');
    functionItems.forEach(function(item, index) {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(item);
    });

    // Observe about content
    const aboutContent = document.querySelector('.about-content');
    if (aboutContent) {
        aboutContent.style.opacity = '0';
        aboutContent.style.transform = 'translateX(30px)';
        aboutContent.style.transition = 'opacity 0.8s ease 0.2s, transform 0.8s ease 0.2s';
        observer.observe(aboutContent);
    }

    // Observe about image
    const aboutImage = document.querySelector('.about-image');
    if (aboutImage) {
        aboutImage.style.opacity = '0';
        aboutImage.style.transform = 'translateX(-30px)';
        aboutImage.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(aboutImage);
    }
});
</script>
<?= $this->endSection() ?>