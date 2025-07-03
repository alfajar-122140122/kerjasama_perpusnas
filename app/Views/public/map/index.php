<?= $this->extend('layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Peta Lokasi Kerjasama</h2>
            
            <div class="card">
                <div class="card-body">
                    <div id="map" style="width: 100%; height: 500px;"></div>
                    
                    <div class="mt-4">
                        <h4>Informasi Kerjasama berdasarkan Wilayah</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Provinsi</th>
                                        <th>Jumlah Kerjasama</th>
                                        <th>Jenis Kerjasama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>DKI Jakarta</td>
                                        <td>15</td>
                                        <td>Pertukaran Koleksi, Digitalisasi, Pengembangan SDM</td>
                                    </tr>
                                    <tr>
                                        <td>Jawa Barat</td>
                                        <td>12</td>
                                        <td>Pertukaran Koleksi, Penelitian</td>
                                    </tr>
                                    <tr>
                                        <td>Jawa Tengah</td>
                                        <td>8</td>
                                        <td>Pertukaran Koleksi, Digitalisasi</td>
                                    </tr>
                                    <tr>
                                        <td>Jawa Timur</td>
                                        <td>10</td>
                                        <td>Pertukaran Koleksi, Pengembangan SDM</td>
                                    </tr>
                                    <tr>
                                        <td>Sumatera Utara</td>
                                        <td>5</td>
                                        <td>Digitalisasi</td>
                                    </tr>
                                    <tr>
                                        <td>Sulawesi Selatan</td>
                                        <td>4</td>
                                        <td>Pertukaran Koleksi</td>
                                    </tr>
                                    <tr>
                                        <td>Kalimantan Timur</td>
                                        <td>3</td>
                                        <td>Pengembangan SDM</td>
                                    </tr>
                                    <tr>
                                        <td>Bali</td>
                                        <td>6</td>
                                        <td>Pertukaran Koleksi, Penelitian</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
    // Initialize map centered at Indonesia
    var map = L.map('map').setView([-2.5, 118], 5);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Sample data for markers - in real implementation, this would come from the database
    var locations = [
        { name: "Perpustakaan Nasional RI", lat: -6.1754, lng: 106.8272, count: 15 },
        { name: "Universitas Indonesia", lat: -6.3641, lng: 106.8250, count: 3 },
        { name: "Universitas Gadjah Mada", lat: -7.7713, lng: 110.3777, count: 5 },
        { name: "Universitas Airlangga", lat: -7.2675, lng: 112.7893, count: 4 },
        { name: "Universitas Sumatera Utara", lat: 3.5616, lng: 98.6564, count: 2 },
        { name: "Universitas Hasanuddin", lat: -5.1304, lng: 119.4873, count: 3 },
        { name: "Institut Teknologi Bandung", lat: -6.8915, lng: 107.6107, count: 6 },
        { name: "Universitas Udayana", lat: -8.7970, lng: 115.1674, count: 4 }
    ];
    
    // Add markers to the map
    locations.forEach(function(loc) {
        var marker = L.marker([loc.lat, loc.lng]).addTo(map);
        marker.bindPopup("<b>" + loc.name + "</b><br>Jumlah Kerjasama: " + loc.count);
    });
});
</script>

<?= $this->endSection() ?>
