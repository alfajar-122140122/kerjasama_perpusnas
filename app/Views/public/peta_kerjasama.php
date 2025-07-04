<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Peta Kerja Sama<?= $this->endSection() ?>

<?= $this->section('description') ?>Pemetaan lokasi kerjasama perpustakaan di seluruh Indonesia. Visualisasi sebaran mitra kerjasama Perpustakaan Nasional RI dalam pengembangan layanan perpustakaan.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>peta kerjasama, lokasi mitra, sebaran perpustakaan, kerjasama daerah, perpustakaan nasional, indonesia<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
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

/* Peta Kerja Sama page specific styles */
.peta-section {
    background: white;
    padding: 2rem 0;
    min-height: calc(100vh - 200px);
}

.page-title {
    color: var(--text-dark, #333);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
}

.page-description {
    color: var(--text-light, #666);
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 3rem;
    text-align: center;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

/* Map Container with Custom Markers */
.map-wrapper {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 3rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.map-container {
    width: 100%;
    height: 500px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    position: relative;
    background: #e9ecef;
}

.map-container iframe {
    width: 100%;
    height: 100%;
    border: none;
}

/* Custom Map Markers Overlay */
.map-markers {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 10;
}

.marker {
    position: absolute;
    width: 30px;
    height: 30px;
    background: #ff4444;
    border: 3px solid white;
    border-radius: 50%;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    cursor: pointer;
    pointer-events: all;
    transition: transform 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.marker:hover {
    transform: scale(1.2);
    z-index: 20;
}

.marker.provinsi { background: #4CAF50; }
.marker.kabupaten { background: #2196F3; }
.marker.kota { background: #FF9800; }
.marker.swasta { background: #9C27B0; }

/* Marker positions (approximate for demo) */
.marker[data-location="jakarta"] { top: 60%; left: 52%; }
.marker[data-location="bandung"] { top: 65%; left: 50%; }
.marker[data-location="surabaya"] { top: 68%; left: 60%; }
.marker[data-location="bogor"] { top: 63%; left: 51%; }
.marker[data-location="depok"] { top: 61%; left: 51.5%; }
.marker[data-location="bali"] { top: 75%; left: 62%; }

/* Tooltip for markers */
.marker-tooltip {
    position: absolute;
    bottom: 35px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 0.5rem;
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

.marker:hover .marker-tooltip {
    opacity: 1;
}

.map-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.map-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-dark, #333);
    margin: 0;
}

.map-filters {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    border-radius: 20px;
    background: white;
    color: var(--text-dark, #333);
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--primary-blue, #2196F3);
    color: white;
    border-color: var(--primary-blue, #2196F3);
}

/* Statistics Cards */
.stats-section {
    margin-bottom: 3rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 2rem 1.5rem;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-top: 4px solid var(--primary-green, #4CAF50);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-blue, #2196F3);
    margin-bottom: 0.5rem;
    display: block;
}

.stat-label {
    font-size: 1rem;
    color: var(--text-dark, #333);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.stat-description {
    font-size: 0.875rem;
    color: var(--text-light, #666);
    line-height: 1.4;
}

/* Partner Slider Section */
.partner-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 3rem;
}

.partner-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-dark, #333);
    margin-bottom: 2rem;
    text-align: center;
}

/* Slider Container */
.partner-slider-container {
    position: relative;
    overflow: hidden;
}

.partner-slider {
    display: flex;
    transition: transform 0.5s ease;
    gap: 1.5rem;
}

.partner-slide {
    flex: 0 0 200px;
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.partner-slide:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.partner-logo {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    background: #f8f9fa;
    border-radius: 20px; /* Rounded square instead of circle */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: #666;
    border: none; /* Remove border */
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.partner-logo::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.1) 100%);
    border-radius: 20px;
}

.partner-logo.provinsi { 
    background: linear-gradient(135deg, #4CAF50 0%, #66BB6A 100%);
    color: white;
    box-shadow: 0 4px 20px rgba(76, 175, 80, 0.3);
}

.partner-logo.kabupaten { 
    background: linear-gradient(135deg, #2196F3 0%, #42A5F5 100%);
    color: white;
    box-shadow: 0 4px 20px rgba(33, 150, 243, 0.3);
}

.partner-logo.kota { 
    background: linear-gradient(135deg, #FF9800 0%, #FFB74D 100%);
    color: white;
    box-shadow: 0 4px 20px rgba(255, 152, 0, 0.3);
}

.partner-logo.swasta { 
    background: linear-gradient(135deg, #9C27B0 0%, #BA68C8 100%);
    color: white;
    box-shadow: 0 4px 20px rgba(156, 39, 176, 0.3);
}

.partner-slide:hover .partner-logo {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
}

/* Modern icons for different types */
.partner-logo i {
    position: relative;
    z-index: 2;
}

/* Custom icon styles for modern look */
.partner-logo.provinsi i::before {
    content: "\f19c"; /* fa-book-open */
}

.partner-logo.kabupaten i::before {
    content: "\f0f7"; /* fa-map-signs */
}

.partner-logo.kota i::before {
    content: "\f1ad"; /* fa-building */
}

.partner-logo.swasta i::before {
    content: "\f19c"; /* fa-graduation-cap */
}

/* Alternative: Use simple geometric shapes instead of icons */
.partner-logo.geometric {
    font-size: 0;
}

.partner-logo.geometric::after {
    content: '';
    width: 30px;
    height: 30px;
    background: rgba(255,255,255,0.9);
    border-radius: 8px;
    position: relative;
    z-index: 2;
}

.partner-logo.geometric.provinsi::after {
    border-radius: 50%;
}

.partner-logo.geometric.kabupaten::after {
    border-radius: 6px;
}

.partner-logo.geometric.kota::after {
    border-radius: 4px;
    transform: rotate(45deg);
}

.partner-logo.geometric.swasta::after {
    border-radius: 0;
    width: 24px;
    height: 24px;
    background: rgba(255,255,255,0.9);
    clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
    transform: none;
}

/* Responsive design */
@media (max-width: 992px) {
    .map-container {
        height: 400px;
    }
    
    .partner-slide {
        flex: 0 0 180px;
    }
}

@media (max-width: 768px) {
    .peta-section {
        padding: 1.5rem 0;
    }
    
    .map-wrapper {
        padding: 1.5rem;
    }
    
    .map-container {
        height: 350px;
    }
    
    .page-title {
        font-size: 1.75rem;
    }
    
    .map-controls {
        flex-direction: column;
        align-items: stretch;
    }
    
    .map-filters {
        justify-content: center;
    }
    
    .partner-slide {
        flex: 0 0 160px;
    }
    
    .partner-logo {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
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
    .page-description {
        font-size: 1rem;
    }
    
    .legend-items {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .map-filters {
        flex-direction: column;
    }
    
    .filter-btn {
        text-align: center;
    }
    
    .partner-slide {
        flex: 0 0 140px;
    }
    
    .slider-controls {
        flex-direction: column;
        gap: 1rem;
    }
}

/* Slider Controls - HAPUS TOMBOL */
.slider-controls {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
}

/* HAPUS STYLING UNTUK TOMBOL
.slider-btn {
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: var(--primary-blue, #2196F3);
    color: white;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.slider-btn:hover {
    background: #1976D2;
    transform: scale(1.1);
}

.slider-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
    transform: none;
}
*/

.slider-indicators {
    display: flex;
    gap: 0.5rem;
}

.indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #ccc;
    cursor: pointer;
    transition: background 0.3s ease;
}

.indicator.active {
    background: var(--primary-blue, #2196F3);
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Include Navigation Component - Same as other pages -->
<?= $this->include('layouts/components/public_navigation') ?>

<!-- Main Content -->
<section class="peta-section">
    <div class="container">
        <h1 class="page-title text-center">Peta Kerja Sama</h1>
        
        <p class="page-description">
            Visualisasi sebaran kerjasama Perpustakaan Nasional RI dengan berbagai institusi di seluruh Indonesia. 
            Peta ini menunjukkan lokasi mitra kerjasama dalam pengembangan layanan perpustakaan dan literasi.
        </p>

        <!-- Map Section -->
        <div class="map-wrapper">
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m2!1m1!1sindonesia!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c4c07d7496404b7%3A0xe37b4de71badf485!2sIndonesia!5e0!3m2!1sen!2sid!4v1699459200000!5m2!1sen!2sid"
                    width="100%" 
                    height="100%" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Peta Kerjasama Perpustakaan Nasional Indonesia">
                </iframe>
                
                <!-- Custom Markers Overlay -->
                <div class="map-markers">
                    <div class="marker provinsi" data-location="jakarta" data-type="provinsi">
                        <i class="fas fa-book"></i>
                        <div class="marker-tooltip">Perpustakaan Provinsi DKI Jakarta</div>
                    </div>
                    <div class="marker provinsi" data-location="bandung" data-type="provinsi">
                        <i class="fas fa-book"></i>
                        <div class="marker-tooltip">Perpustakaan Provinsi Jawa Barat</div>
                    </div>
                    <div class="marker kota" data-location="surabaya" data-type="kota">
                        <i class="fas fa-building"></i>
                        <div class="marker-tooltip">Perpustakaan Kota Surabaya</div>
                    </div>
                    <div class="marker kabupaten" data-location="bogor" data-type="kabupaten">
                        <i class="fas fa-landmark"></i>
                        <div class="marker-tooltip">Perpustakaan Kabupaten Bogor</div>
                    </div>
                    <div class="marker swasta" data-location="depok" data-type="swasta">
                        <i class="fas fa-university"></i>
                        <div class="marker-tooltip">Perpustakaan Universitas Indonesia</div>
                    </div>
                    <div class="marker provinsi" data-location="bali" data-type="provinsi">
                        <i class="fas fa-book"></i>
                        <div class="marker-tooltip">Perpustakaan Provinsi Bali</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partner Slider Section -->
        <div class="partner-section">
            <h3 class="partner-title">Mitra Kerjasama</h3>
            
            <div class="partner-slider-container">
                <div class="partner-slider" id="partnerSlider">
                    <!-- Partner Slide 1 -->
                    <div class="partner-slide" data-type="provinsi">
                        <div class="partner-logo provinsi">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="partner-name">Perpustakaan Provinsi DKI Jakarta</div>
                        <div class="partner-location">Jakarta</div>
                        <div class="partner-type-badge">Provinsi</div>
                    </div>
                    
                    <!-- Partner Slide 2 -->
                    <div class="partner-slide" data-type="provinsi">
                        <div class="partner-logo provinsi">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="partner-name">Perpustakaan Provinsi Jawa Barat</div>
                        <div class="partner-location">Bandung</div>
                        <div class="partner-type-badge">Provinsi</div>
                    </div>
                    
                    <!-- Partner Slide 3 -->
                    <div class="partner-slide" data-type="kota">
                        <div class="partner-logo kota">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="partner-name">Perpustakaan Kota Surabaya</div>
                        <div class="partner-location">Surabaya</div>
                        <div class="partner-type-badge">Kota</div>
                    </div>
                    
                    <!-- Partner Slide 4 -->
                    <div class="partner-slide" data-type="kabupaten">
                        <div class="partner-logo kabupaten">
                            <i class="fas fa-map-signs"></i>
                        </div>
                        <div class="partner-name">Perpustakaan Kabupaten Bogor</div>
                        <div class="partner-location">Cibinong</div>
                        <div class="partner-type-badge">Kabupaten</div>
                    </div>
                    
                    <!-- Partner Slide 5 -->
                    <div class="partner-slide" data-type="swasta">
                        <div class="partner-logo swasta">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="partner-name">Perpustakaan Universitas Indonesia</div>
                        <div class="partner-location">Depok</div>
                        <div class="partner-type-badge">Swasta</div>
                    </div>
                    
                    <!-- Partner Slide 6 -->
                    <div class="partner-slide" data-type="provinsi">
                        <div class="partner-logo provinsi geometric"></div>
                        <div class="partner-name">Perpustakaan Provinsi Bali</div>
                        <div class="partner-location">Denpasar</div>
                        <div class="partner-type-badge">Provinsi</div>
                    </div>
                    
                    <!-- Partner Slide 7 -->
                    <div class="partner-slide" data-type="provinsi">
                        <div class="partner-logo provinsi">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="partner-name">Perpustakaan Provinsi Jawa Tengah</div>
                        <div class="partner-location">Semarang</div>
                        <div class="partner-type-badge">Provinsi</div>
                    </div>
                    
                    <!-- Partner Slide 8 -->
                    <div class="partner-slide" data-type="kota">
                        <div class="partner-logo kota">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="partner-name">Perpustakaan Kota Yogyakarta</div>
                        <div class="partner-location">Yogyakarta</div>
                        <div class="partner-type-badge">Kota</div>
                    </div>
                </div>
            </div>
            
            <!-- Slider Controls - HANYA INDICATORS -->
            <div class="slider-controls">
                <div class="slider-indicators" id="sliderIndicators">
                    <!-- Indicators will be generated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Partner Slider functionality
    const slider = document.getElementById('partnerSlider');
    const slides = document.querySelectorAll('.partner-slide');
    const indicatorsContainer = document.getElementById('sliderIndicators');
    
    let currentSlide = 0;
    const slidesToShow = window.innerWidth >= 768 ? 4 : window.innerWidth >= 576 ? 3 : 2;
    const totalSlides = slides.length;
    const maxSlides = Math.max(0, totalSlides - slidesToShow);
    
    // Generate indicators
    for (let i = 0; i <= maxSlides; i++) {
        const indicator = document.createElement('div');
        indicator.className = 'indicator';
        if (i === 0) indicator.classList.add('active');
        indicator.addEventListener('click', () => goToSlide(i));
        indicatorsContainer.appendChild(indicator);
    }
    
    const indicators = document.querySelectorAll('.indicator');
    
    function updateSlider() {
        const slideWidth = slides[0].offsetWidth + 24; // including gap
        slider.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
        
        // Update indicators
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentSlide);
        });
    }
    
    function goToSlide(slideIndex) {
        currentSlide = Math.max(0, Math.min(slideIndex, maxSlides));
        updateSlider();
    }
    
    function nextSlide() {
        if (currentSlide < maxSlides) {
            currentSlide++;
        } else {
            currentSlide = 0; // Loop back to first slide
        }
        updateSlider();
    }
    
    // AUTO-SLIDE SETIAP 3 DETIK
    let autoSlideInterval = setInterval(nextSlide, 3000);
    
    // Pause auto-slide when hovering over slider
    slider.addEventListener('mouseenter', () => {
        clearInterval(autoSlideInterval);
    });
    
    // Resume auto-slide when mouse leaves
    slider.addEventListener('mouseleave', () => {
        autoSlideInterval = setInterval(nextSlide, 3000);
    });
    
    // Manual navigation via indicators (pause auto-slide temporarily)
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            clearInterval(autoSlideInterval);
            goToSlide(index);
            // Resume auto-slide after 5 seconds
            setTimeout(() => {
                autoSlideInterval = setInterval(nextSlide, 3000);
            }, 5000);
        });
    });
    
    // Initial update
    updateSlider();
    
    // Filter functionality for map markers
    const filterButtons = document.querySelectorAll('.filter-btn');
    const markers = document.querySelectorAll('.marker');
    const partnerSlides = document.querySelectorAll('.partner-slide');
    const searchInput = document.getElementById('searchPartner');
    
    // Filter by type
    filterButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            const filterType = this.getAttribute('data-filter');
            
            // Filter map markers
            markers.forEach(function(marker) {
                if (filterType === 'all') {
                    marker.style.display = 'flex';
                } else {
                    if (marker.getAttribute('data-type') === filterType) {
                        marker.style.display = 'flex';
                    } else {
                        marker.style.display = 'none';
                    }
                }
            });
            
            // Filter slider items
            partnerSlides.forEach(function(slide) {
                if (filterType === 'all') {
                    slide.style.display = 'block';
                } else {
                    if (slide.getAttribute('data-type') === filterType) {
                        slide.style.display = 'block';
                    } else {
                        slide.style.display = 'none';
                    }
                }
            });
            
            // Reset slider position and restart auto-slide
            currentSlide = 0;
            updateSlider();
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextSlide, 3000);
        });
    });
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            partnerSlides.forEach(function(slide) {
                const partnerName = slide.querySelector('.partner-name').textContent.toLowerCase();
                const partnerLocation = slide.querySelector('.partner-location').textContent.toLowerCase();
                
                if (partnerName.includes(searchTerm) || partnerLocation.includes(searchTerm)) {
                    slide.style.display = 'block';
                } else {
                    slide.style.display = 'none';
                }
            });
            
            // Reset slider position and restart auto-slide
            currentSlide = 0;
            updateSlider();
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextSlide, 3000);
        });
    }
    
    // Animate elements on scroll
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

    // Observe elements
    const pageTitle = document.querySelector('.page-title');
    const mapWrapper = document.querySelector('.map-wrapper');
    const partnerSection = document.querySelector('.partner-section');

    [pageTitle, mapWrapper, partnerSection].forEach(element => {
        if (element) {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(element);
        }
    });
    
    // Responsive slider update
    window.addEventListener('resize', function() {
        const newSlidesToShow = window.innerWidth >= 768 ? 4 : window.innerWidth >= 576 ? 3 : 2;
        if (newSlidesToShow !== slidesToShow) {
            location.reload(); // Simple solution for responsive changes
        }
    });
});
</script>
<?= $this->endSection() ?>