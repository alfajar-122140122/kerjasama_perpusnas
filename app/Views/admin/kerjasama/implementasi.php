<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Implementasi Kerjasama
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0 text-gray-800">Admin / Kelola Implementasi</h2>
        </div>
        <div>
            <a href="<?= base_url('admin/kerjasama/implementasi/tambah') ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahImplementasiModal">
                <i class="fas fa-plus me-2"></i>Tambah Implementasi
            </a>
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
                            <li><a class="dropdown-item" href="#" data-filter="dokumen">Dokumen</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="arsip">Arsip</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="pelatihan">Pelatihan</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="penelitian">Penelitian</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="teknologi">Teknologi</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="pengembangan">Pengembangan</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>Nama Mitra</th>
                            <th>Masa Berlaku</th>
                            <th>Implementasi</th>
                            <th>Lingkup</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Data from database via controller
                        if (empty($implementasiData)) {
                            $implementasiData = [];
                        }
                        
                        if (count($implementasiData) > 0): ?>
                            <?php foreach ($implementasiData as $implementasi): ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox" value="<?= $implementasi['id'] ?>">
                            </td>
                            <td><?= esc($implementasi['nama_mitra']) ?></td>
                            <td>
                                <small class="text-muted">
                                    <?php 
                                    // Display masa_berlaku directly if it exists
                                    if (!empty($implementasi['masa_berlaku'])) {
                                        echo esc($implementasi['masa_berlaku']);
                                    }
                                    // Otherwise calculate from kerjasama dates if available
                                    else if (!empty($implementasi['tanggal_mulai']) && !empty($implementasi['tanggal_berakhir'])) {
                                        $startDate = new DateTime($implementasi['tanggal_mulai']);
                                        $endDate = new DateTime($implementasi['tanggal_berakhir']);
                                        $interval = $endDate->diff($startDate);
                                        
                                        $duration = '';
                                        if ($interval->y > 0) $duration .= $interval->y . ' tahun ';
                                        if ($interval->m > 0 || $interval->y > 0) $duration .= $interval->m . ' bulan ';
                                        $duration .= $interval->d . ' hari';
                                        
                                        echo esc($duration);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </small>
                            </td>
                            <td>
                                <span class="text-muted"><?= substr(esc($implementasi['implementasi']), 0, 35) ?>...</span>
                            </td>
                            <td>
                                <span class="badge bg-info"><?= esc($implementasi['lingkup']) ?></span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat" onclick="viewImplementasi(<?= $implementasi['id'] ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Edit" onclick="editImplementasi(<?= $implementasi['id'] ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="deleteImplementasi(<?= $implementasi['id'] ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-3">Tidak ada data implementasi kerjasama</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted" id="paginationInfo">
        <?php if (isset($pagination)): ?>
            Menampilkan <?= $pagination['startItem'] ?>-<?= $pagination['endItem'] ?> dari <?= $pagination['totalItems'] ?> data
        <?php else: ?>
            Menampilkan 0 dari 0 data
        <?php endif; ?>
    </div>
    <nav aria-label="Implementasi Pagination Navigation">
        <ul class="pagination pagination-sm mb-0" id="paginationControls">
            <?php if (isset($pagination) && $pagination['totalPages'] > 1): ?>
                <!-- Previous Button -->
                <li class="page-item <?= $pagination['currentPage'] == 1 ? 'disabled' : '' ?>">
                    <?php if ($pagination['currentPage'] == 1): ?>
                        <span class="page-link">Previous</span>
                    <?php else: ?>
                        <a class="page-link" href="<?= current_url() ?>?page=<?= $pagination['currentPage'] - 1 ?>">Previous</a>
                    <?php endif; ?>
                </li>
                
                <?php
                $startPage = max(1, $pagination['currentPage'] - 2);
                $endPage = min($pagination['totalPages'], $pagination['currentPage'] + 2);
                
                // Show first page if not in range
                if ($startPage > 1):
                ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= current_url() ?>?page=1">1</a>
                    </li>
                    <?php if ($startPage > 2): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                
                <!-- Page Numbers -->
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?= $i == $pagination['currentPage'] ? 'active' : '' ?>">
                        <?php if ($i == $pagination['currentPage']): ?>
                            <span class="page-link"><?= $i ?></span>
                        <?php else: ?>
                            <a class="page-link" href="<?= current_url() ?>?page=<?= $i ?>"><?= $i ?></a>
                        <?php endif; ?>
                    </li>
                <?php endfor; ?>
                
                <!-- Show last page if not in range -->
                <?php if ($endPage < $pagination['totalPages']): ?>
                    <?php if ($endPage < $pagination['totalPages'] - 1): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= current_url() ?>?page=<?= $pagination['totalPages'] ?>"><?= $pagination['totalPages'] ?></a>
                    </li>
                <?php endif; ?>
                
                <!-- Next Button -->
                <li class="page-item <?= $pagination['currentPage'] == $pagination['totalPages'] ? 'disabled' : '' ?>">
                    <?php if ($pagination['currentPage'] == $pagination['totalPages']): ?>
                        <span class="page-link">Next</span>
                    <?php else: ?>
                        <a class="page-link" href="<?= current_url() ?>?page=<?= $pagination['currentPage'] + 1 ?>">Next</a>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
</div>

<!-- Modal Tambah Implementasi -->
<div class="modal fade" id="tambahImplementasiModal" tabindex="-1" aria-labelledby="tambahImplementasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahImplementasiModalLabel">Tambah Implementasi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahImplementasi" method="POST" action="<?= base_url('admin/kerjasama/implementasi/store') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kerjasama_id" class="form-label">Nama Mitra</label>
                            <select class="form-select" id="kerjasama_id" name="kerjasama_id" required>
                                <option value="">Pilih Mitra Kerjasama</option>
                                <?php 
                                // Load kerjasama data
                                $kerjasamaModel = new \App\Models\KerjasamaModel();
                                $kerjasamaList = $kerjasamaModel->orderBy('nama_mitra', 'ASC')->findAll();
                                
                                foreach ($kerjasamaList as $kerjasama): ?>
                                    <option value="<?= $kerjasama['id'] ?>" 
                                            data-tanggal-mulai="<?= $kerjasama['tanggal_mulai'] ?>" 
                                            data-tanggal-berakhir="<?= $kerjasama['tanggal_berakhir'] ?>"
                                            data-ruang-lingkup="<?= esc($kerjasama['ruang_lingkup']) ?>">
                                        <?= esc($kerjasama['nama_mitra']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lingkup" class="form-label">Lingkup</label>
                            <input type="text" class="form-control" id="lingkup" name="lingkup" placeholder="Masukkan lingkup implementasi" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="implementasi" class="form-label">Deskripsi Implementasi</label>
                        <textarea class="form-control" id="implementasi" name="implementasi" rows="3" placeholder="Masukkan deskripsi implementasi..." required></textarea>
                    </div>
                    
                    <!-- Info Kerjasama yang dipilih -->
                    <div class="row" id="kerjasama_info" style="display: none;">
                        <div class="col-md-12 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Informasi Periode Kerjasama</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted">Tanggal Mulai:</small>
                                            <p class="mb-1 fw-bold" id="info_tanggal_mulai">-</p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Tanggal Berakhir:</small>
                                            <p class="mb-1 fw-bold" id="info_tanggal_berakhir">-</p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Masa Berlaku:</small>
                                            <p class="mb-1 fw-bold text-primary" id="info_masa_berlaku">-</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <small class="text-muted">Ruang Lingkup Kerjasama:</small>
                                            <p class="mb-0" id="info_ruang_lingkup">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Implementasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Lihat Implementasi -->
<div class="modal fade" id="lihatImplementasiModal" tabindex="-1" aria-labelledby="lihatImplementasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lihatImplementasiModalLabel">Detail Implementasi Kerjasama</h5>
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
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Masa Berlaku Kerjasama</label>
                        <p id="view_masa_berlaku" class="border-bottom pb-2"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Mulai Kerjasama</label>
                        <p id="view_tanggal_mulai" class="border-bottom pb-2"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Berakhir Kerjasama</label>
                        <p id="view_tanggal_berakhir" class="border-bottom pb-2"></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Ruang Lingkup Kerjasama</label>
                        <p id="view_ruang_lingkup" class="border-bottom pb-2"></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Deskripsi Implementasi</label>
                        <p id="view_implementasi" class="border-bottom pb-2"></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Lingkup Implementasi</label>
                        <p id="view_lingkup" class="border-bottom pb-2"></p>
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
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Implementasi -->
<div class="modal fade" id="editImplementasiModal" tabindex="-1" aria-labelledby="editImplementasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editImplementasiModalLabel">Edit Implementasi Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditImplementasi" method="POST">
                <input type="hidden" id="edit_implementasi_id" name="implementasi_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_kerjasama_id" class="form-label">Nama Mitra</label>
                            <select class="form-select" id="edit_kerjasama_id" name="kerjasama_id" required>
                                <option value="">Pilih Mitra Kerjasama</option>
                                <?php 
                                // Load kerjasama data
                                $kerjasamaModel = new \App\Models\KerjasamaModel();
                                $kerjasamaList = $kerjasamaModel->orderBy('nama_mitra', 'ASC')->findAll();
                                
                                foreach ($kerjasamaList as $kerjasama): ?>
                                    <option value="<?= $kerjasama['id'] ?>" 
                                            data-tanggal-mulai="<?= $kerjasama['tanggal_mulai'] ?>" 
                                            data-tanggal-berakhir="<?= $kerjasama['tanggal_berakhir'] ?>"
                                            data-ruang-lingkup="<?= esc($kerjasama['ruang_lingkup']) ?>">
                                        <?= esc($kerjasama['nama_mitra']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_lingkup" class="form-label">Lingkup</label>
                            <input type="text" class="form-control" id="edit_lingkup" name="lingkup" placeholder="Masukkan lingkup implementasi" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_implementasi" class="form-label">Deskripsi Implementasi</label>
                        <textarea class="form-control" id="edit_implementasi" name="implementasi" rows="3" placeholder="Masukkan deskripsi implementasi..." required></textarea>
                    </div>
                    
                    <!-- Info Kerjasama yang dipilih -->
                    <div class="row" id="edit_kerjasama_info" style="display: none;">
                        <div class="col-md-12 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Informasi Periode Kerjasama</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted">Tanggal Mulai:</small>
                                            <p class="mb-1 fw-bold" id="edit_info_tanggal_mulai">-</p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Tanggal Berakhir:</small>
                                            <p class="mb-1 fw-bold" id="edit_info_tanggal_berakhir">-</p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Masa Berlaku:</small>
                                            <p class="mb-1 fw-bold text-primary" id="edit_info_masa_berlaku">-</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <small class="text-muted">Ruang Lingkup Kerjasama:</small>
                                            <p class="mb-0" id="edit_info_ruang_lingkup">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Function to calculate duration between two dates in years, months, days format
function calculateDuration(startDate, endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);
    
    // Return empty string if invalid dates
    if (isNaN(start.getTime()) || isNaN(end.getTime())) {
        return '';
    }
    
    // Calculate the difference in milliseconds
    let diff = end - start;
    
    // Check if end date is before start date
    if (diff < 0) {
        return 'Tanggal tidak valid';
    }
    
    // Convert to days
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    
    // Calculate years, months and remaining days
    const years = Math.floor(days / 365);
    let remainingDays = days % 365;
    const months = Math.floor(remainingDays / 30);
    remainingDays = remainingDays % 30;
    
    // Build the duration string
    let duration = '';
    if (years > 0) {
        duration += years + ' tahun ';
    }
    if (months > 0 || years > 0) {
        duration += months + ' bulan ';
    }
    duration += remainingDays + ' hari';
    
    return duration.trim();
}

// Function to update the duration preview - no longer needed for form inputs
// but kept for calculating duration display
function updateDurationPreview(startDate, endDate) {
    if (startDate && endDate) {
        return calculateDuration(startDate, endDate);
    }
    return '';
}

// Add event listeners for date changes
document.addEventListener('DOMContentLoaded', function() {
    // Function to format date to Indonesian format
    function formatDateIndonesian(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        return date.toLocaleDateString('id-ID', options);
    }
    
    // Function to show kerjasama information
    function showKerjasamaInfo(selectElement, infoContainerId, prefix = '') {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        
        if (selectedOption.value) {
            const tanggalMulai = selectedOption.dataset.tanggalMulai;
            const tanggalBerakhir = selectedOption.dataset.tanggalBerakhir;
            const ruangLingkup = selectedOption.dataset.ruangLingkup;
            
            // Calculate duration for preview display only (not saved to database)
            const duration = calculateDuration(tanggalMulai, tanggalBerakhir);
            
            // Format masa berlaku preview sesuai format database 
            const startDate = new Date(tanggalMulai);
            const endDate = new Date(tanggalBerakhir);
            const masaBerlakuFormatted = startDate.toLocaleDateString('id-ID').replace(/\//g, '-') + ' s/d ' + endDate.toLocaleDateString('id-ID').replace(/\//g, '-');
            
            // Update info display
            document.getElementById(prefix + 'info_tanggal_mulai').textContent = formatDateIndonesian(tanggalMulai);
            document.getElementById(prefix + 'info_tanggal_berakhir').textContent = formatDateIndonesian(tanggalBerakhir);
            document.getElementById(prefix + 'info_masa_berlaku').textContent = masaBerlakuFormatted + ' (' + duration + ')';
            document.getElementById(prefix + 'info_ruang_lingkup').textContent = ruangLingkup || '-';
            
            // Show info container
            document.getElementById(infoContainerId).style.display = '';
        } else {
            // Hide info container
            document.getElementById(infoContainerId).style.display = 'none';
        }
    }
    
    // For Add form - kerjasama selection change
    const kerjasamaSelect = document.getElementById('kerjasama_id');
    if (kerjasamaSelect) {
        kerjasamaSelect.addEventListener('change', function() {
            showKerjasamaInfo(this, 'kerjasama_info');
        });
    }
    
    // For Edit form - kerjasama selection change
    const editKerjasamaSelect = document.getElementById('edit_kerjasama_id');
    if (editKerjasamaSelect) {
        editKerjasamaSelect.addEventListener('change', function() {
            showKerjasamaInfo(this, 'edit_kerjasama_info', 'edit_');
        });
    }
    
    // Initialize modal events
    const tambahModal = document.getElementById('tambahImplementasiModal');
    if (tambahModal) {
        tambahModal.addEventListener('shown.bs.modal', function() {
            // Reset fields
            document.getElementById('kerjasama_id').value = '';
            document.getElementById('lingkup').value = '';
            document.getElementById('implementasi').value = '';
            document.getElementById('kerjasama_info').style.display = 'none';
        });
    }
    
    // Initialize edit modal events
    const editModal = document.getElementById('editImplementasiModal');
    if (editModal) {
        editModal.addEventListener('shown.bs.modal', function() {
            // Check if kerjasama is already selected and show info
            const selectedKerjasama = document.getElementById('edit_kerjasama_id');
            if (selectedKerjasama && selectedKerjasama.value) {
                showKerjasamaInfo(selectedKerjasama, 'edit_kerjasama_info', 'edit_');
            } else {
                document.getElementById('edit_kerjasama_info').style.display = 'none';
            }
        });
    }
});

// Function to show alerts
function showAlert(type, message) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    // Append to body
    document.body.appendChild(alertDiv);
    
    // Auto dismiss after 5 seconds
    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alertDiv);
        bsAlert.close();
    }, 5000);
}

// Select All Checkbox
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Pagination variables
let currentPage = 1;
let currentFilter = 'all';
let currentSearch = '';
const itemsPerPage = 10;

// Function to get all visible rows based on current search and filter
function getFilteredRows() {
    const tableRows = document.querySelectorAll('tbody tr');
    const filteredRows = [];
    
    tableRows.forEach(row => {
        let showRow = true;
        
        // Apply search filter
        if (currentSearch) {
            const namaMitra = row.cells[1].textContent.toLowerCase();
            const implementasi = row.cells[3].textContent.toLowerCase();
            const lingkup = row.cells[4].textContent.toLowerCase();
            
            if (!namaMitra.includes(currentSearch) && !implementasi.includes(currentSearch) && !lingkup.includes(currentSearch)) {
                showRow = false;
            }
        }
        
        // Apply category filter
        if (currentFilter !== 'all' && showRow) {
            const lingkupElement = row.querySelector('td:nth-child(5) .badge');
            if (!lingkupElement || !lingkupElement.textContent.toLowerCase().includes(currentFilter.toLowerCase())) {
                showRow = false;
            }
        }
        
        if (showRow) {
            filteredRows.push(row);
        }
    });
    
    return filteredRows;
}

// Function to display current page
function displayPage(page) {
    const filteredRows = getFilteredRows();
    const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
    
    // Validate page number
    if (page < 1) page = 1;
    if (page > totalPages && totalPages > 0) page = totalPages;
    if (totalPages === 0) page = 1;
    
    currentPage = page;
    
    // Hide all rows first
    const allRows = document.querySelectorAll('tbody tr');
    allRows.forEach(row => row.style.display = 'none');
    
    // Show rows for current page
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageRows = filteredRows.slice(startIndex, endIndex);
    
    pageRows.forEach(row => row.style.display = '');
    
    // Update pagination controls
    updatePaginationControls(totalPages, filteredRows.length);
    
    return totalPages;
}

// Function to update pagination controls
function updatePaginationControls(totalPages, totalItems) {
    const paginationContainer = document.querySelector('.pagination');
    if (!paginationContainer) return;
    
    paginationContainer.innerHTML = '';
    
    if (totalPages <= 1) {
        paginationContainer.style.display = 'none';
        return;
    }
    
    paginationContainer.style.display = 'flex';
    
    // Previous button
    const prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>`;
    paginationContainer.appendChild(prevLi);
    
    // Page numbers
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, currentPage + 2);
    
    if (startPage > 1) {
        const firstLi = document.createElement('li');
        firstLi.className = 'page-item';
        firstLi.innerHTML = `<a class="page-link" href="#" data-page="1">1</a>`;
        paginationContainer.appendChild(firstLi);
        
        if (startPage > 2) {
            const dotsLi = document.createElement('li');
            dotsLi.className = 'page-item disabled';
            dotsLi.innerHTML = `<span class="page-link">...</span>`;
            paginationContainer.appendChild(dotsLi);
        }
    }
    
    for (let i = startPage; i <= endPage; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
        paginationContainer.appendChild(li);
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const dotsLi = document.createElement('li');
            dotsLi.className = 'page-item disabled';
            dotsLi.innerHTML = `<span class="page-link">...</span>`;
            paginationContainer.appendChild(dotsLi);
        }
        
        const lastLi = document.createElement('li');
        lastLi.className = 'page-item';
        lastLi.innerHTML = `<a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>`;
        paginationContainer.appendChild(lastLi);
    }
    
    // Next button
    const nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>`;
    paginationContainer.appendChild(nextLi);
    
    // Add click events to pagination links
    paginationContainer.addEventListener('click', function(e) {
        e.preventDefault();
        if (e.target.classList.contains('page-link') && e.target.hasAttribute('data-page')) {
            const page = parseInt(e.target.getAttribute('data-page'));
            if (page !== currentPage && page >= 1 && page <= totalPages) {
                displayPage(page);
            }
        }
    });
}

// Search functionality with pagination
document.getElementById('searchInput').addEventListener('keyup', function() {
    currentSearch = this.value.toLowerCase();
    currentPage = 1; // Reset to first page
    displayPage(currentPage);
});

// Filter functionality with pagination
document.querySelectorAll('[data-filter]').forEach(filterBtn => {
    filterBtn.addEventListener('click', function(e) {
        e.preventDefault();
        currentFilter = this.dataset.filter;
        currentPage = 1; // Reset to first page
        displayPage(currentPage);
        
        // Update filter button text
        document.getElementById('filterDropdown').innerHTML = `<i class="fas fa-filter me-2"></i>${this.textContent}`;
    });
});

// Initialize pagination on page load
document.addEventListener('DOMContentLoaded', function() {
    // Small delay to ensure all DOM elements are ready
    setTimeout(() => {
        displayPage(1);
    }, 100);
});

// Error handling function for debugging
function handleApiError(error) {
    console.error('API Error:', error);
    showAlert('danger', 'Terjadi kesalahan pada server. Silakan cek konsol untuk detail.');
}

// Form submission handler
document.getElementById('formTambahImplementasi').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Get form data
    const formData = new FormData(this);
    
    // Get masa_berlaku from selected kerjasama data (using consistent format from database)
    const kerjasamaSelect = document.getElementById('kerjasama_id');
    const selectedOption = kerjasamaSelect.options[kerjasamaSelect.selectedIndex];
    
    if (selectedOption.value) {
        const tanggalMulai = selectedOption.dataset.tanggalMulai;
        const tanggalBerakhir = selectedOption.dataset.tanggalBerakhir;
        
        if (tanggalMulai && tanggalBerakhir) {
            // Format masa berlaku sesuai dengan format database: "dd-mm-yyyy s/d dd-mm-yyyy"
            const startDate = new Date(tanggalMulai);
            const endDate = new Date(tanggalBerakhir);
            const masaBerlaku = startDate.toLocaleDateString('id-ID').replace(/\//g, '-') + ' s/d ' + endDate.toLocaleDateString('id-ID').replace(/\//g, '-');
            formData.set('masa_berlaku', masaBerlaku);
        }
    }
    
    // Submit via AJAX
    fetch(this.getAttribute('action'), {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('tambahImplementasiModal'));
        modal.hide();
        
        // Reset form
        document.getElementById('formTambahImplementasi').reset();
        document.getElementById('kerjasama_info').style.display = 'none';
        
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        if (data.status) {
            // Show success message
            showAlert('success', data.message || 'Data implementasi berhasil ditambahkan!');
            
            // Reload page to show new data
            setTimeout(function() {
                location.reload();
            }, 1500);
        } else {
            // Show error message
            showAlert('danger', data.message || 'Gagal menyimpan data implementasi');
            
            // Display validation errors if available
            if (data.errors) {
                const errorMessages = Object.values(data.errors).join('<br>');
                showAlert('danger', errorMessages);
            }
        }
    })
    .catch(error => {
        handleApiError(error);
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// View Implementasi function
function viewImplementasi(id) {
    // Fetch implementasi data by ID
    fetch(`<?= base_url('admin/kerjasama/implementasi/get/') ?>${id}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            // Populate modal fields
            document.getElementById('view_nama_mitra').textContent = data.data.nama_mitra;
            
            // Format dates and calculate duration
            const startDate = data.data.tanggal_mulai ? new Date(data.data.tanggal_mulai) : null;
            const endDate = data.data.tanggal_berakhir ? new Date(data.data.tanggal_berakhir) : null;
            
            // Display formatted dates
            document.getElementById('view_tanggal_mulai').textContent = startDate ? startDate.toLocaleDateString('id-ID') : '-';
            document.getElementById('view_tanggal_berakhir').textContent = endDate ? endDate.toLocaleDateString('id-ID') : '-';
            
            // Display masa_berlaku (prioritize stored value)
            if (data.data.masa_berlaku) {
                document.getElementById('view_masa_berlaku').textContent = data.data.masa_berlaku;
            } else if (startDate && endDate) {
                const duration = calculateDuration(startDate, endDate);
                document.getElementById('view_masa_berlaku').textContent = duration;
            } else {
                document.getElementById('view_masa_berlaku').textContent = '-';
            }
            
            document.getElementById('view_implementasi').textContent = data.data.implementasi;
            document.getElementById('view_lingkup').textContent = data.data.lingkup;
            document.getElementById('view_ruang_lingkup').textContent = data.data.ruang_lingkup || '-';
            document.getElementById('view_created_at').textContent = new Date(data.data.created_at).toLocaleString('id-ID');
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('lihatImplementasiModal'));
            modal.show();
        } else {
            showAlert('danger', data.message || 'Gagal memuat data implementasi');
        }
    })
    .catch(error => {
        handleApiError(error);
    });
}

// Edit Implementasi function
function editImplementasi(id) {
    // Fetch implementasi data by ID
    fetch(`<?= base_url('admin/kerjasama/implementasi/get/') ?>${id}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            // Populate edit form fields
            document.getElementById('edit_implementasi_id').value = data.data.id;
            document.getElementById('edit_kerjasama_id').value = data.data.kerjasama_id;
            document.getElementById('edit_lingkup').value = data.data.lingkup;
            document.getElementById('edit_implementasi').value = data.data.implementasi;
            
            // Trigger change event to show kerjasama info
            const event = new Event('change');
            document.getElementById('edit_kerjasama_id').dispatchEvent(event);
            
            // Show edit modal
            const modal = new bootstrap.Modal(document.getElementById('editImplementasiModal'));
            modal.show();
        } else {
            showAlert('danger', data.message || 'Gagal memuat data implementasi untuk diedit');
        }
    })
    .catch(error => {
        handleApiError(error);
    });
}

// Delete Implementasi function
function deleteImplementasi(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data implementasi ini?')) {
        fetch(`<?= base_url('admin/kerjasama/implementasi/delete/') ?>${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                showAlert('success', data.message || 'Data implementasi berhasil dihapus');
                // Reload page to update table
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showAlert('danger', data.message || 'Gagal menghapus data implementasi');
            }
        })
        .catch(error => {
            handleApiError(error);
        });
    }
}

// Edit Implementasi form submission handler
document.getElementById('formEditImplementasi').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Get form data
    const formData = new FormData(this);
    
    // Get masa_berlaku from selected kerjasama data (using consistent format from database)
    const editKerjasamaSelect = document.getElementById('edit_kerjasama_id');
    const selectedOption = editKerjasamaSelect.options[editKerjasamaSelect.selectedIndex];
    
    if (selectedOption.value) {
        const tanggalMulai = selectedOption.dataset.tanggalMulai;
        const tanggalBerakhir = selectedOption.dataset.tanggalBerakhir;
        
        if (tanggalMulai && tanggalBerakhir) {
            // Format masa berlaku sesuai dengan format database: "dd-mm-yyyy s/d dd-mm-yyyy"
            const startDate = new Date(tanggalMulai);
            const endDate = new Date(tanggalBerakhir);
            const masaBerlaku = startDate.toLocaleDateString('id-ID').replace(/\//g, '-') + ' s/d ' + endDate.toLocaleDateString('id-ID').replace(/\//g, '-');
            formData.set('masa_berlaku', masaBerlaku);
        }
    }
    
    // Get the implementasi ID from the hidden field
    const implementasiId = document.getElementById('edit_implementasi_id').value;
    
    // Submit via AJAX
    fetch(`<?= base_url('admin/kerjasama/implementasi/update') ?>/${implementasiId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('editImplementasiModal'));
        modal.hide();
        
        // Reset form
        document.getElementById('formEditImplementasi').reset();
        document.getElementById('edit_kerjasama_info').style.display = 'none';
        
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        if (data.status) {
            // Show success message
            showAlert('success', data.message || 'Data implementasi berhasil diperbarui!');
            
            // Reload page to show updated data
            setTimeout(function() {
                location.reload();
            }, 1500);
        } else {
            // Show error message
            showAlert('danger', data.message || 'Gagal memperbarui data implementasi');
            
            // Display validation errors if available
            if (data.errors) {
                const errorMessages = Object.values(data.errors).join('<br>');
                showAlert('danger', errorMessages);
            }
        }
    })
    .catch(error => {
        handleApiError(error);
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>
<?= $this->endSection() ?>