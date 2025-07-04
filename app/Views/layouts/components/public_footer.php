<!-- Footer -->
<footer class="main-footer bg-dark text-white">
    <!-- Main Footer Content -->
    <div class="footer-content py-5">
        <div class="container">
            <div class="row">
                <!-- About Section -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-section">
                        <div class="footer-logo mb-3">
                            <img src="<?= base_url('assets/images/public/logo-perpusnas-white.png') ?>" alt="Logo Perpustakaan Nasional" class="footer-logo-img mb-3">
                            <h5 class="text-white">Portal Kerjasama</h5>
                            <h6 class="text-light">Perpustakaan Nasional RI</h6>
                        </div>
                        <p class="text-light mb-3">
                            Portal resmi untuk informasi dan pengajuan kerjasama dengan Perpustakaan Nasional Republik Indonesia. 
                            Membangun sinergi untuk kemajuan literasi bangsa.
                        </p>
                        <div class="social-media">
                            <h6 class="text-white mb-3">Ikuti Kami</h6>
                            <div class="social-links">
                                <a href="https://facebook.com/perpusnas" class="social-link me-3" target="_blank" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/perpusnas" class="social-link me-3" target="_blank" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://instagram.com/perpusnas" class="social-link me-3" target="_blank" aria-label="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="https://youtube.com/perpusnas" class="social-link me-3" target="_blank" aria-label="YouTube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                <a href="https://linkedin.com/company/perpusnas" class="social-link" target="_blank" aria-label="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <div class="footer-section">
                        <div class="service-hours">
                            <div class="contact-item mb-4">
                                <i class="fas fa-clock me-3"></i>
                                <div>
                                    <strong>Jam Layanan:</strong><br>
                                    Senin - Jumat<br>
                                    08:00 - 16:00 WIB
                                </div>
                            </div>
                        </div>
                        <div class="contact-info">
                            <div class="contact-item mb-3">
                                <i class="fas fa-map-marker-alt me-3"></i>
                                <div>
                                    <strong>Alamat:</strong><br>
                                    Jl. Salemba Raya No. 28A<br>
                                    Jakarta Pusat 10440<br>
                                    Indonesia
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-2">
                    <div class="footer-section">
                        <div class="contact-item mb-3">
                                <i class="fas fa-phone me-3"></i>
                                <div>
                                    <strong>Telepon:</strong><br>
                                    +62 21 3928 8221<br>
                                    +62 21 3928 8222
                                </div>
                            </div>
                            <div class="contact-item mb-3">
                                <i class="fas fa-envelope me-3"></i>
                                <div>
                                    <strong>Email:</strong><br>
                                    kerjasama@perpusnas.go.id<br>
                                    info@perpusnas.go.id
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Cookie Consent (if not already set) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if cookie consent has been given
    if (!localStorage.getItem('cookieConsent')) {
        setTimeout(function() {
            document.getElementById('cookieConsent').style.display = 'block';
        }, 2000);
    }
    
    // Newsletter form submission
    document.getElementById('newsletterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Handle newsletter subscription
        alert('Terima kasih telah berlangganan newsletter kami!');
    });
});

function acceptCookies() {
    localStorage.setItem('cookieConsent', 'true');
    document.getElementById('cookieConsent').style.display = 'none';
}
</script>