<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Kontak<?= $this->endSection() ?>

<?= $this->section('description') ?>Hubungi Sub Bidang Kerja Sama Perpustakaan, Perpustakaan Nasional RI. Gedung Layanan Lantai 5, Jl. Medan Merdeka Selatan No. 11 Jakarta Pusat.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>kontak, alamat, telepon, email, perpustakaan nasional, kerjasama, jakarta<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/navigation.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/kontak.css') ?>" rel="stylesheet">
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
<script src="<?= base_url('js/public/kontak.js') ?>"></script>
<?= $this->endSection() ?>