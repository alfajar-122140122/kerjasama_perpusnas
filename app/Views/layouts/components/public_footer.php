<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h5>Portal Kerjasama</h5>
                <ul>
                    <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                    <li><a href="<?= base_url('tentang') ?>">Tentang</a></li>
                    <li><a href="<?= base_url('aktivitas') ?>">Aktivitas</a></li>
                    <li><a href="<?= base_url('kerja-sama') ?>">Kerja Sama</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h5>Layanan</h5>
                <ul>
                    <li><a href="<?= base_url('permohonan-kerjasama') ?>">Ajukan Kerjasama</a></li>
                    <li><a href="<?= base_url('data-kerja-sama') ?>">Data Kerja Sama</a></li>
                    <li><a href="<?= base_url('implementasi-kerja-sama') ?>">Implementasi</a></li>
                    <li><a href="<?= base_url('peta-kerja-sama') ?>">Peta Kerja Sama</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h5>Kontak</h5>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Jl. Salemba Raya No. 28A, Jakarta Pusat</li>
                    <li><i class="fas fa-phone"></i> (021) 3192 6666</li>
                    <li><i class="fas fa-envelope"></i> kerjasama@perpusnas.go.id</li>
                    <li><a href="<?= base_url('kontak') ?>">Hubungi Kami</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h5>Sosial Media</h5>
                <ul>
                    <li><a href="https://facebook.com/perpusnas" target="_blank"><i class="fab fa-facebook"></i> Facebook</a></li>
                    <li><a href="https://twitter.com/perpusnas" target="_blank"><i class="fab fa-twitter"></i> Twitter</a></li>
                    <li><a href="https://instagram.com/perpusnas" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="https://youtube.com/perpusnas" target="_blank"><i class="fab fa-youtube"></i> YouTube</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Perpustakaan Nasional Republik Indonesia. Semua hak dilindungi.</p>
        </div>
    </div>
</footer>

<script>
// Back to top button functionality
document.addEventListener('DOMContentLoaded', function() {
    const backToTopButton = document.getElementById('btn-back-to-top');
    
    // Show/hide button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.style.display = 'block';
        } else {
            backToTopButton.style.display = 'none';
        }
    });
    
    // Smooth scroll to top
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
</script>