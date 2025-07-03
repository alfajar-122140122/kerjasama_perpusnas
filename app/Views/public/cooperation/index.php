<?= $this->extend('layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Kerjasama</h2>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <i class="bi bi-file-earmark-text fs-1 text-primary mb-3"></i>
                            <h5 class="card-title">Data Kerjasama</h5>
                            <p class="card-text">Informasi tentang seluruh kerjasama yang terjalin dengan berbagai institusi.</p>
                            <a href="/cooperation/data-cooperation" class="btn btn-primary">Lihat Data</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <i class="bi bi-clipboard2-check fs-1 text-success mb-3"></i>
                            <h5 class="card-title">Implementasi Kerjasama</h5>
                            <p class="card-text">Kegiatan yang telah dilaksanakan sebagai bentuk implementasi kerjasama.</p>
                            <a href="/cooperation/implementation" class="btn btn-success">Lihat Implementasi</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <i class="bi bi-hourglass-split fs-1 text-warning mb-3"></i>
                            <h5 class="card-title">Kerjasama Yang Akan Berakhir</h5>
                            <p class="card-text">Daftar kerjasama yang akan berakhir dalam waktu 3 bulan ke depan.</p>
                            <a href="/cooperation/expiring" class="btn btn-warning">Lihat Daftar</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <i class="bi bi-bar-chart-line fs-1 text-info mb-3"></i>
                            <h5 class="card-title">Progress Kerjasama</h5>
                            <p class="card-text">Statistik dan perkembangan seluruh kerjasama yang sedang berjalan.</p>
                            <a href="/cooperation/progress" class="btn btn-info">Lihat Progress</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <i class="bi bi-file-earmark-plus fs-1 text-danger mb-3"></i>
                            <h5 class="card-title">Permohonan Kerjasama</h5>
                            <p class="card-text">Formulir pengajuan permohonan kerjasama baru dengan Perpustakaan Nasional.</p>
                            <a href="/cooperation/submission" class="btn btn-danger">Ajukan Permohonan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
