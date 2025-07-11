<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Kerjasama Akan Berakhir
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0 text-gray-800">Admin / Kelola Kerja Sama yang Akan Berakhir</h2>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Search and Filter -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari Data" id="searchInput">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-filter="all">Semua</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="30-hari">30 Hari Lagi</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="60-hari">60 Hari Lagi</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="90-hari">90 Hari Lagi</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Mitra</th>
                            <th>Lingkup</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Data from controller (real database data)
                        if (empty($akanBerakhirData)) {
                            $akanBerakhirData = [];
                        }
                        ?>
                        
                        <?php foreach ($akanBerakhirData as $kerjasama): ?>
                        <tr data-sisa-hari="<?= $kerjasama['sisa_hari'] ?>" data-id="<?= $kerjasama['id'] ?>">
                            <td><?= esc($kerjasama['nama_mitra']) ?></td>
                            <td>
                                <span class="text-muted"><?= substr(esc($kerjasama['ruang_lingkup']), 0, 50) ?>...</span>
                            </td>
                            <td><?= $kerjasama['tanggal_mulai_formatted'] ?></td>
                            <td>
                                <span class="text-danger fw-bold"><?= $kerjasama['tanggal_berakhir_formatted'] ?></span>
                                <br>
                                <small class="text-warning">
                                    <i class="fas fa-clock me-1"></i><?= $kerjasama['sisa_hari'] ?> hari lagi
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat" onclick="viewKerjasama(<?= $kerjasama['id'] ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Empty State (jika tidak ada data) -->
            <?php if (empty($akanBerakhirData)): ?>
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada kerjasama yang akan berakhir dalam 90 hari ke depan</h5>
                <p class="text-muted">Semua kerjasama masih dalam masa berlaku yang aman.</p>
            </div>
            <?php endif; ?>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    <?php
                    $count = count($akanBerakhirData);
                    $start = $count > 0 ? 1 : 0;
                    echo "Menampilkan {$start}-{$count} dari {$count} data";
                    ?>
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">Next</span>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lihat Kerjasama -->
<div class="modal fade" id="lihatKerjasamaModal" tabindex="-1" aria-labelledby="lihatKerjasamaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lihatKerjasamaModalLabel">Detail Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Nama Mitra</label>
                        <p id="view_nama_mitra" class="border-bottom pb-2"></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Mulai</label>
                        <p id="view_tanggal_mulai" class="border-bottom pb-2"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Berakhir</label>
                        <p id="view_tanggal_berakhir" class="border-bottom pb-2"></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Sisa Waktu</label>
                        <p id="view_sisa_waktu" class="border-bottom pb-2 text-danger"></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Ruang Lingkup</label>
                        <p id="view_ruang_lingkup" class="border-bottom pb-2"></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Tanggal Pembuatan</label>
                        <p id="view_created_at" class="border-bottom pb-2"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn_perpanjang">Perpanjang</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach(row => {
        const namaMitra = row.cells[0].textContent.toLowerCase();
        const lingkup = row.cells[1].textContent.toLowerCase();
        
        if (namaMitra.includes(searchTerm) || lingkup.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filter functionality
document.querySelectorAll('[data-filter]').forEach(filterBtn => {
    filterBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const filter = this.dataset.filter;
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const sisaHari = parseInt(row.dataset.sisaHari);
            
            if (filter === 'all') {
                row.style.display = '';
            } else if (filter === '30-hari' && sisaHari <= 30) {
                row.style.display = '';
            } else if (filter === '60-hari' && sisaHari <= 60) {
                row.style.display = '';
            } else if (filter === '90-hari' && sisaHari <= 90) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update filter button text
        document.getElementById('filterDropdown').innerHTML = `<i class="fas fa-filter me-2"></i>${this.textContent}`;
    });
});

// View function
function viewKerjasama(id) {
    // Fetch data via AJAX
    fetch(`<?= base_url('admin/kerjasama/get/') ?>${id}`)
        .then(response => response.json())
        .then(result => {
            if (result.status) {
                const kerjasama = result.data;
                
                // Format dates for display
                const tanggalMulai = new Date(kerjasama.tanggal_mulai);
                const tanggalBerakhir = new Date(kerjasama.tanggal_berakhir);
                const formattedTanggalMulai = tanggalMulai.toLocaleDateString('id-ID', { 
                    day: '2-digit', month: '2-digit', year: 'numeric' 
                });
                const formattedTanggalBerakhir = tanggalBerakhir.toLocaleDateString('id-ID', { 
                    day: '2-digit', month: '2-digit', year: 'numeric' 
                });
                
                // Calculate days remaining
                const today = new Date();
                const diffTime = tanggalBerakhir - today;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                // Populate modal
                document.getElementById('view_nama_mitra').textContent = kerjasama.nama_mitra;
                document.getElementById('view_tanggal_mulai').textContent = formattedTanggalMulai;
                document.getElementById('view_tanggal_berakhir').textContent = formattedTanggalBerakhir;
                document.getElementById('view_sisa_waktu').textContent = `${diffDays} hari lagi`;
                document.getElementById('view_ruang_lingkup').textContent = kerjasama.ruang_lingkup;
                
                // Format created_at if available
                if (kerjasama.created_at) {
                    const createdAt = new Date(kerjasama.created_at);
                    document.getElementById('view_created_at').textContent = createdAt.toLocaleDateString('id-ID', { 
                        day: '2-digit', month: '2-digit', year: 'numeric', 
                        hour: '2-digit', minute: '2-digit' 
                    });
                } else {
                    document.getElementById('view_created_at').textContent = '-';
                }
                
                // Setup perpanjang button
                document.getElementById('btn_perpanjang').onclick = function() {
                    window.location.href = `<?= base_url('admin/kerjasama/edit/') ?>${id}`;
                };
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('lihatKerjasamaModal'));
                modal.show();
            } else {
                alert('Data tidak ditemukan');
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            alert('Terjadi kesalahan saat mengambil data');
        });
}

// Edit function
function editKerjasama(id) {
    window.location.href = `<?= base_url('admin/kerjasama/edit/') ?>${id}`;
}

// Delete function
function deleteKerjasama(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data kerjasama ini?')) {
        // Perform AJAX delete request
        fetch(`<?= base_url('admin/kerjasama/delete/') ?>${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.status) {
                // Remove row from table
                document.querySelector(`tr[data-id="${id}"]`)?.remove();
                alert('Data kerjasama berhasil dihapus');
                // Reload page to show updated data
                window.location.reload();
            } else {
                alert(result.message || 'Gagal menghapus data');
            }
        })
        .catch(error => {
            console.error('Error deleting data:', error);
            alert('Terjadi kesalahan saat menghapus data');
        });
    }
}

// Auto highlight rows berdasarkan sisa hari
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach(row => {
        const sisaHari = parseInt(row.dataset.sisaHari);
        
        if (sisaHari <= 30) {
            row.classList.add('table-danger');
        } else if (sisaHari <= 60) {
            row.classList.add('table-warning');
        }
    });
});
</script>
<?= $this->endSection() ?>