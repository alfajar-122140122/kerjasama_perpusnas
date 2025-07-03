<?= $this->extend('layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Data Kerjasama</h2>
            
            <div class="card">
                <div class="card-body">
                    <!-- Search and Filter Tools -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control" placeholder="Cari kerjasama...">
                                <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterJenis">
                                <option value="">Semua Jenis</option>
                                <option value="Pertukaran Koleksi">Pertukaran Koleksi</option>
                                <option value="Digitalisasi">Digitalisasi</option>
                                <option value="Pengembangan SDM">Pengembangan SDM</option>
                                <option value="Penelitian">Penelitian</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="tidak aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Data Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Judul Kerjasama</th>
                                    <th>Instansi</th>
                                    <th>Jenis</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>PIC</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($kerjasama) && $kerjasama): ?>
                                    <?php $no = 1; foreach($kerjasama as $ks): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $ks['judul'] ?></td>
                                        <td><?= $ks['instansi'] ?></td>
                                        <td><?= $ks['jenis'] ?></td>
                                        <td><?= date('d-m-Y', strtotime($ks['tanggal_mulai'])) ?></td>
                                        <td><?= date('d-m-Y', strtotime($ks['tanggal_berakhir'])) ?></td>
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
                                                    <h5 class="modal-title" id="detailModalLabel">Detail Kerjasama</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Judul Kerjasama</div>
                                                        <div class="col-md-8"><?= $ks['judul'] ?></div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Instansi</div>
                                                        <div class="col-md-8"><?= $ks['instansi'] ?></div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Jenis Kerjasama</div>
                                                        <div class="col-md-8"><?= $ks['jenis'] ?></div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Status</div>
                                                        <div class="col-md-8">
                                                            <?php if($ks['status'] == 'aktif'): ?>
                                                                <span class="badge bg-success">Aktif</span>
                                                            <?php elseif($ks['status'] == 'tidak aktif'): ?>
                                                                <span class="badge bg-danger">Tidak Aktif</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning">Akan Berakhir</span>
                                                            <?php endif; ?>
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
                                                        <div class="col-md-4 fw-bold">PIC</div>
                                                        <div class="col-md-8"><?= $ks['pic'] ?></div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 fw-bold">Deskripsi</div>
                                                        <div class="col-md-8"><?= $ks['deskripsi'] ?? '-' ?></div>
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
                                        <td colspan="8" class="text-center">Tidak ada data kerjasama</td>
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

<script>
// Search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterJenis = document.getElementById('filterJenis');
    const filterStatus = document.getElementById('filterStatus');
    const tableRows = document.querySelectorAll('tbody tr');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const jenisFilter = filterJenis.value.toLowerCase();
        const statusFilter = filterStatus.value.toLowerCase();
        
        tableRows.forEach(row => {
            const judul = row.cells[1].textContent.toLowerCase();
            const instansi = row.cells[2].textContent.toLowerCase();
            const jenis = row.cells[3].textContent.toLowerCase();
            const status = row.getAttribute('data-status')?.toLowerCase() || '';
            
            const matchesSearch = judul.includes(searchTerm) || instansi.includes(searchTerm);
            const matchesJenis = jenisFilter === '' || jenis === jenisFilter;
            const matchesStatus = statusFilter === '' || status === statusFilter;
            
            if (matchesSearch && matchesJenis && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    searchInput.addEventListener('input', filterTable);
    filterJenis.addEventListener('change', filterTable);
    filterStatus.addEventListener('change', filterTable);
});
</script>

<?= $this->endSection() ?>
