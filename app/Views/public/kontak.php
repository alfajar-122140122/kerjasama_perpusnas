<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Kontak<?= $this->endSection() ?>

<?= $this->section('description') ?>Hubungi Sub Bidang Kerja Sama Perpustakaan, Perpustakaan Nasional RI. Gedung Layanan Lantai 5, Jl. Medan Merdeka Selatan No. 11 Jakarta Pusat.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>kontak, alamat, telepon, email, perpustakaan nasional, kerjasama, jakarta<?= $this->endSection() ?>

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

/* Contact page specific styles */
.contact-section {
    background: white;
    padding: 2rem 0;
    min-height: calc(100vh - 200px);
}

.contact-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: start;
}

.map-container {
    width: 100%;
    height: 400px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    position: relative;
}

.map-container iframe {
    width: 100%;
    height: 100%;
    border: none;
}

.map-placeholder {
    width: 100%;
    height: 100%;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
    font-size: 1rem;
}

.contact-info {
    padding: 1rem 0;
}

.contact-title {
    color: var(--text-dark, #333);
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.contact-detail {
    margin-bottom: 1.5rem;
}

.contact-label {
    color: var(--text-dark, #333);
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.5rem;
    display: block;
}

.contact-value {
    color: var(--text-light, #666);
    font-size: 1rem;
    line-height: 1.6;
    margin: 0;
}

.contact-value a {
    color: var(--primary-blue, #2196F3);
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-value a:hover {
    color: var(--primary-green, #4CAF50);
    text-decoration: underline;
}

.contact-icon {
    color: var(--primary-green, #4CAF50);
    margin-right: 0.5rem;
    font-size: 1.1rem;
}

/* Contact form if needed */
.contact-form {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 2rem;
    margin-top: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    color: var(--text-dark, #333);
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-blue, #2196F3);
    box-shadow: 0 0 0 0.25rem rgba(33, 150, 243, 0.25);
}

.btn-submit {
    background: var(--primary-green, #4CAF50);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
}

.btn-submit:hover {
    background: #45a049;
    transform: translateY(-1px);
}

/* Responsive design */
@media (max-width: 992px) {
    .contact-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .map-container {
        height: 300px;
        order: -1;
    }
    
    .contact-title {
        font-size: 1.25rem;
    }
}

@media (max-width: 768px) {
    .contact-section {
        padding: 1.5rem 0;
    }
    
    .contact-container {
        gap: 1.5rem;
    }
    
    .map-container {
        height: 250px;
    }
    
    .contact-info {
        padding: 0;
    }
    
    .contact-form {
        padding: 1.5rem;
        margin-top: 1.5rem;
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
    .contact-detail {
        margin-bottom: 1rem;
    }
    
    .contact-value {
        font-size: 0.95rem;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Include Navigation Component - Same as other pages -->
<?= $this->include('layouts/components/public_navigation') ?>

<!-- Main Content -->
<section class="contact-section">
    <div class="container">
        <div class="contact-container">
            <!-- Google Maps -->
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.623033187347!2d106.82692039999999!3d-6.1811826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f442596e0c93%3A0x4ba58be40979fe36!2sPerpustakaan%20Nasional%20Republik%20Indonesia!5e0!3m2!1sid!2sid!4v1751613236634!5m2!1sid!2sid"
                    width="100%" 
                    height="100%" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi Perpustakaan Nasional Republik Indonesia">
                </iframe>
            </div>
            
            <!-- Contact Information -->
            <div class="contact-info">
                <h2 class="contact-title">Sub Bidang Kerja Sama Perpustakaan</h2>
                <h3 class="contact-title" style="font-size: 1.25rem;">Perpustakaan Nasional RI</h3>
                
                <div class="contact-detail">
                    <span class="contact-label">
                        <i class="fas fa-map-marker-alt contact-icon"></i>Alamat:
                    </span>
                    <p class="contact-value">
                        Gedung Layanan, Lantai 5<br>
                        Jl. Medan Merdeka Selatan No. 11<br>
                        Jakarta Pusat 10110
                    </p>
                </div>
                
                <div class="contact-detail">
                    <span class="contact-label">
                        <i class="fas fa-phone contact-icon"></i>Telepon:
                    </span>
                    <p class="contact-value">
                        <a href="tel:021-80664603">021-80664603</a>
                    </p>
                </div>
                
                <div class="contact-detail">
                    <span class="contact-label">
                        <i class="fas fa-envelope contact-icon"></i>Email:
                    </span>
                    <p class="contact-value">
                        <a href="mailto:kerjasama@perpusnas.go.id">kerjasama@perpusnas.go.id</a><br>
                        <a href="mailto:kerjasama@gmail.com">kerjasama@gmail.com</a>
                    </p>
                </div>
                
                <div class="contact-detail">
                    <span class="contact-label">
                        <i class="fas fa-clock contact-icon"></i>Jam Operasional:
                    </span>
                    <p class="contact-value">
                        Senin - Jumat: 08:00 - 16:00 WIB<br>
                        Sabtu - Minggu: Tutup
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact form submission
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic form validation
            const nama = document.getElementById('nama').value.trim();
            const email = document.getElementById('email').value.trim();
            const subjek = document.getElementById('subjek').value.trim();
            const pesan = document.getElementById('pesan').value.trim();
            
            if (!nama || !email || !subjek || !pesan) {
                alert('Mohon isi semua field yang wajib diisi (*)');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Format email tidak valid');
                return;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('.btn-submit');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            submitBtn.disabled = true;
            
            // Simulate form submission (replace with actual AJAX call)
            setTimeout(function() {
                alert('Pesan berhasil dikirim! Kami akan segera merespons.');
                contactForm.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    }
    
    // Animate contact info on scroll
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

    // Observe contact details
    const contactDetails = document.querySelectorAll('.contact-detail');
    contactDetails.forEach(function(detail, index) {
        detail.style.opacity = '0';
        detail.style.transform = 'translateY(20px)';
        detail.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(detail);
    });

    // Observe map container
    const mapContainer = document.querySelector('.map-container');
    if (mapContainer) {
        mapContainer.style.opacity = '0';
        mapContainer.style.transform = 'translateX(-30px)';
        mapContainer.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(mapContainer);
    }

    // Observe contact info
    const contactInfo = document.querySelector('.contact-info');
    if (contactInfo) {
        contactInfo.style.opacity = '0';
        contactInfo.style.transform = 'translateX(30px)';
        contactInfo.style.transition = 'opacity 0.8s ease 0.2s, transform 0.8s ease 0.2s';
        observer.observe(contactInfo);
    }
});
</script>
<?= $this->endSection() ?>