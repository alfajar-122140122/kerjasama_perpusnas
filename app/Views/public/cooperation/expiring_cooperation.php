<?= $this->extend('layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Kerja Sama Yang Akan Berakhir</h2>
            
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Daftar kerja sama yang akan berakhir dalam 3 bulan ke depan.
                    </div>
                    
                    <!-- Data Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Judul Kerja Sama</th>
                                    <th>Instansi</th>
                                    <th>Jenis</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Sisa Waktu</th>
                                    <th>PIC</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($expiring) && $expiring): ?>
                                    <?php $no = 1; foreach($expiring as $ks): ?>
                                    <?php 
                                        // Calculate remaining time
                                        $end_date = new DateTime($ks['tanggal_berakhir']);
                                        $today = new DateTime();
                                        $interval = $today->diff($end_date);
                                        $days_remaining = $interval->format('%a');
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $ks['judul'] ?></td>
                                        <td><?= $ks['instansi'] ?></td>
                                        <td><?= $ks['jenis'] ?></td>
                                        <td><?= date('d-m-Y', strtotime($ks['tanggal_berakhir'])) ?></td>
                                        <td>
                                            <?php if($days_remaining <= 30): ?>
                                                <span class="badge bg-danger"><?= $days_remaining ?> hari</span>
                                            <?php elseif($days_remaining <= 60): ?>
                                                <span class="badge bg-warning"><?= $days_remaining ?> hari</span>
                                            <?php else: ?>
                                                <span class="badge bg-info"><?= $days_remaining ?> hari</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $ks['pic'] ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal<?= $ks['id'] ?>">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <!-- Detail Modal -->
                                    <div class="modal fade" id="detailModal<?= $ks['id'] ?>" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel">Detail Kerja Sama</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Judul Kerja Sama</div>
                                                        <div class="col-md-8"><?= $ks['judul'] ?></div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Instansi</div>
                                                        <div class="col-md-8"><?= $ks['instansi'] ?></div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Jenis Kerja Sama</div>
                                                        <div class="col-md-8"><?= $ks['jenis'] ?></div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Status</div>
                                                        <div class="col-md-8">
                                                            <span class="badge bg-warning">Akan Berakhir</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Periode</div>
                                                        <div class="col-md-8">
                                                            <?= date('d-m-Y', strtotime($ks['tanggal_mulai'])) ?> s/d 
                                                            <?= date('d-m-Y', strtotime($ks['tanggal_berakhir'])) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Sisa Waktu</div>
                                                        <div class="col-md-8">
                                                            <?= $days_remaining ?> hari
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">PIC</div>
                                                        <div class="col-md-8"><?= $ks['pic'] ?></div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Deskripsi</div>
                                                        <div class="col-md-8"><?= $ks['deskripsi'] ?? '-' ?></div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Rekomendasi</div>
                                                        <div class="col-md-8">
                                                            <?php if($days_remaining <= 30): ?>
                                                                <div class="alert alert-danger">
                                                                    Segera hubungi PIC untuk membahas perpanjangan kerja sama.
                                                                </div>
                                                            <?php elseif($days_remaining <= 60): ?>
                                                                <div class="alert alert-warning">
                                                                    Mulai mempersiapkan dokumen untuk perpanjangan kerja sama.
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="alert alert-info">
                                                                    Evaluasi hasil kerja sama untuk menentukan kelanjutan.
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <?php if(isset($ks['file_kerjasama']) && !empty($ks['file_kerjasama'])): ?>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Dokumen</div>
                                                        <div class="col-md-8">
                                                            <a href="/uploads/kerjasama/<?= $ks['file_kerjasama'] ?>" target="_blank" class="btn btn-sm btn-primary">
                                                                <i class="bi bi-file-earmark-pdf"></i> Lihat Dokumen
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada kerja sama yang akan berakhir dalam 3 bulan ke depan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
