<?= $this->extend('layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Statistik Kerjasama</h2>
            
            <div class="row">
                <!-- Statistics Cards -->
                <div class="col-md-3">
                    <div class="card text-center mb-4">
                        <div class="card-body">
                            <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                            <h5 class="card-title mt-3">120</h5>
                            <p class="card-text">Total Kerjasama</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-center mb-4">
                        <div class="card-body">
                            <i class="bi bi-check-circle fs-1 text-success"></i>
                            <h5 class="card-title mt-3">98</h5>
                            <p class="card-text">Kerjasama Aktif</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-center mb-4">
                        <div class="card-body">
                            <i class="bi bi-buildings fs-1 text-info"></i>
                            <h5 class="card-title mt-3">45</h5>
                            <p class="card-text">Instansi Mitra</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-center mb-4">
                        <div class="card-body">
                            <i class="bi bi-calendar-check fs-1 text-warning"></i>
                            <h5 class="card-title mt-3">15</h5>
                            <p class="card-text">Kerjasama Tahun Ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <h2 class="mb-4">Aktivitas Terbaru</h2>
            
            <div class="row">
                <!-- Activity Cards -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="/images/activity1.jpg" class="card-img-top" alt="Activity 1">
                        <div class="card-body">
                            <h5 class="card-title">Penandatanganan MoU dengan Universitas Indonesia</h5>
                            <p class="card-text">Perpustakaan Nasional menjalin kerjasama dengan Universitas Indonesia dalam pengembangan koleksi digital.</p>
                            <p class="text-muted"><i class="bi bi-calendar3"></i> 25 Juni 2025</p>
                            <a href="#" class="btn btn-outline-primary">Selengkapnya</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="/images/activity2.jpg" class="card-img-top" alt="Activity 2">
                        <div class="card-body">
                            <h5 class="card-title">Webinar Kerjasama Perpustakaan Digital</h5>
                            <p class="card-text">Webinar membahas potensi kerjasama dalam pengembangan perpustakaan digital di era modern.</p>
                            <p class="text-muted"><i class="bi bi-calendar3"></i> 18 Juni 2025</p>
                            <a href="#" class="btn btn-outline-primary">Selengkapnya</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="/images/activity3.jpg" class="card-img-top" alt="Activity 3">
                        <div class="card-body">
                            <h5 class="card-title">Workshop Pemanfaatan Koleksi Bersama</h5>
                            <p class="card-text">Workshop yang membahas standar pemanfaatan koleksi bersama antar perpustakaan mitra.</p>
                            <p class="text-muted"><i class="bi bi-calendar3"></i> 5 Juni 2025</p>
                            <a href="#" class="btn btn-outline-primary">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="#" class="btn btn-primary">Lihat Semua Aktivitas</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
