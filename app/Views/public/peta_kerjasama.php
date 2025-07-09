<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Peta Kerja Sama<?= $this->endSection() ?>

<?= $this->section('description') ?>Pemetaan lokasi kerjasama perpustakaan di seluruh Indonesia. Visualisasi sebaran mitra kerjasama Perpustakaan Nasional RI dalam pengembangan layanan perpustakaan.<?= $this->endSection() ?>

<?= $this->section('keywords') ?>peta kerjasama, lokasi mitra, sebaran perpustakaan, kerjasama daerah, perpustakaan nasional, indonesia<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/public.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/public/peta_kerjasama.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

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
<script src="<?= base_url('js/public/peta_kerjasama.js') ?>"></script>
<?= $this->endSection() ?>