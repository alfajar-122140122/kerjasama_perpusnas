<?= $this->extend('layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Kontak Kami</h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi Kontak</h5>
                    
                    <?php if(isset($contact)): ?>
                    <div class="mb-3">
                        <i class="bi bi-geo-alt-fill text-primary me-2"></i> 
                        <strong>Alamat:</strong><br>
                        <?= $contact['address'] ?? 'Jl. Salemba Raya No. 28A, Jakarta Pusat 10430' ?>
                    </div>
                    
                    <div class="mb-3">
                        <i class="bi bi-telephone-fill text-primary me-2"></i> 
                        <strong>Telepon:</strong><br>
                        <?= $contact['phone'] ?? '+62 21 3154864' ?>
                    </div>
                    
                    <div class="mb-3">
                        <i class="bi bi-envelope-fill text-primary me-2"></i> 
                        <strong>Email:</strong><br>
                        <?= $contact['email'] ?? 'kerjasama@perpusnas.go.id' ?>
                    </div>
                    
                    <div class="mb-3">
                        <i class="bi bi-clock-fill text-primary me-2"></i> 
                        <strong>Jam Kerja:</strong><br>
                        <?= $contact['working_hours'] ?? 'Senin - Jumat: 08.00 - 16.00 WIB' ?>
                    </div>
                    <?php else: ?>
                    <div class="mb-3">
                        <i class="bi bi-geo-alt-fill text-primary me-2"></i> 
                        <strong>Alamat:</strong><br>
                        Jl. Salemba Raya No. 28A, Jakarta Pusat 10430
                    </div>
                    
                    <div class="mb-3">
                        <i class="bi bi-telephone-fill text-primary me-2"></i> 
                        <strong>Telepon:</strong><br>
                        +62 21 3154864
                    </div>
                    
                    <div class="mb-3">
                        <i class="bi bi-envelope-fill text-primary me-2"></i> 
                        <strong>Email:</strong><br>
                        kerjasama@perpusnas.go.id
                    </div>
                    
                    <div class="mb-3">
                        <i class="bi bi-clock-fill text-primary me-2"></i> 
                        <strong>Jam Kerja:</strong><br>
                        Senin - Jumat: 08.00 - 16.00 WIB
                    </div>
                    <?php endif; ?>
                    
                    <div class="mt-4">
                        <h5>Sosial Media</h5>
                        <div class="social-media-links">
                            <a href="#" class="me-2"><i class="bi bi-facebook fs-4"></i></a>
                            <a href="#" class="me-2"><i class="bi bi-twitter fs-4"></i></a>
                            <a href="#" class="me-2"><i class="bi bi-instagram fs-4"></i></a>
                            <a href="#" class="me-2"><i class="bi bi-youtube fs-4"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Kirim Pesan</h5>
                    
                    <?php if(session()->has('success')): ?>
                        <div class="alert alert-success">
                            <?= session('success') ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(session()->has('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach(session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form action="/contact/send-message" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subjek</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lokasi Kami</h5>
                    <div id="map" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Leaflet CSS and JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map centered at Perpustakaan Nasional
    var map = L.map('map').setView([-6.1754, 106.8272], 16);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Add marker for Perpustakaan Nasional
    var marker = L.marker([-6.1754, 106.8272]).addTo(map);
    marker.bindPopup("<b>Perpustakaan Nasional RI</b><br>Jl. Salemba Raya No. 28A<br>Jakarta Pusat 10430").openPopup();
});
</script>

<?= $this->endSection() ?>
