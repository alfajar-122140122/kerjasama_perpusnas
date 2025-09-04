<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Berita<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Admin / Kelola Berita<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/berita-management-new.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/components/pagination.css') ?>" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
// Make sure we have berita data from controller
if (!isset($berita)) {
    $berita = [];
}
?>

<!-- Alerts -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Berita Management Section -->
<div class="row">
    <div class="col-12">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" id="searchBerita" placeholder="Cari Berita">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
            </div>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBeritaModal">
                Tambah Berita
            </button>
        </div>

        <!-- Filter Section -->
        <div class="d-flex align-items-center mb-3">
            <button class="btn btn-outline-secondary dropdown-toggle me-2" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-filter"></i> Filter
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" onclick="filterByStatus('all')">Semua Status</a></li>
                <li><a class="dropdown-item" href="#" onclick="filterByStatus('published')">Published</a></li>
                <li><a class="dropdown-item" href="#" onclick="filterByStatus('draft')">Draft</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" onclick="resetFilters()"><i class="fas fa-times"></i> Reset Filter</a></li>
            </ul>
            
            <!-- Entries per page selector -->
            <div class="d-flex align-items-center ms-auto">
                <label for="entriesPerPage" class="form-label me-2 mb-0 text-muted">Tampilkan:</label>
                <select class="form-select form-select-sm" id="entriesPerPage" style="width: auto;" onchange="changeEntriesPerPage()">
                    <option value="10" <?= (isset($perPage) && $perPage == 10) ? 'selected' : '' ?>>10</option>
                    <option value="25" <?= (isset($perPage) && $perPage == 25) ? 'selected' : '' ?>>25</option>
                    <option value="50" <?= (isset($perPage) && $perPage == 50) ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= (isset($perPage) && $perPage == 100) ? 'selected' : '' ?>>100</option>
                </select>
                <span class="text-muted ms-2">entri</span>
            </div>
        </div>

        <!-- Berita Table -->
        <?php if (isset($berita) && !empty($berita)): ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-paginate align-middle mb-0" id="beritaAdminTable">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th width="15%">Gambar</th>
                                <th width="40%">Judul Berita</th>
                                <th width="15%">Status</th>
                                <th width="20%">Tanggal Publikasi</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($berita as $item): ?>
                            <tr data-berita-id="<?= $item['id'] ?>" class="berita-row">
                                <td class="p-3">
                                    <div class="berita-image" style="width: 80px; height: 60px;">
                                        <?php if ($item['gambar']): ?>
                                            <img src="<?= base_url('uploads/berita/' . $item['gambar']) ?>" alt="Berita Image" 
                                                 class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                                 style="width: 100%; height: 100%;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="p-3">
                                    <div class="berita-content">
                                        <h6 class="berita-title mb-1 text-dark"><?= esc($item['judul']) ?></h6>
                                        <small class="text-muted berita-excerpt">
                                            <?= esc(substr(strip_tags($item['isi_berita']), 0, 80)) ?>...
                                        </small>
                                    </div>
                                </td>
                                <td class="p-3">
                                    <?php if ($item['status'] === 'published'): ?>
                                        <span class="badge bg-success">Published</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3">
                                    <small class="text-muted">
                                        <?= $item['tanggal_publikasi'] ? date('d/m/Y', strtotime($item['tanggal_publikasi'])) : '-' ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success btn-sm" title="Lihat" onclick="viewBerita(<?= $item['id'] ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm" title="Edit" onclick="editBerita(<?= $item['id'] ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="deleteBerita(<?= $item['id'] ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="pagination-container"></div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <h5>Belum ada berita</h5>
                <p class="text-muted">Tambahkan berita pertama dengan klik tombol "Tambah Berita"</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add Berita Modal -->
<div class="modal fade" id="addBeritaModal" tabindex="-1" aria-labelledby="addBeritaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBeritaModalLabel">Tambah Berita Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addBeritaForm" action="<?= base_url('admin/berita/add') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Berita *</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                                <div class="invalid-feedback">Judul berita harus diisi</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="isi_berita" class="form-label">Isi Berita *</label>
                                <textarea class="form-control" id="isi_berita" name="isi_berita" rows="10" required></textarea>
                                <div class="invalid-feedback">Isi berita harus diisi</div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar Berita</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                                <div class="image-preview mt-2" id="imagePreview" style="display: none;">
                                    <img src="" alt="Preview" class="img-thumbnail" style="max-width: 100%; height: 200px; object-fit: cover;">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                                <input type="datetime-local" class="form-control" id="tanggal_publikasi" name="tanggal_publikasi">
                                <div class="form-text">Kosongkan untuk publikasi langsung</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Berita Modal -->
<div class="modal fade" id="editBeritaModal" tabindex="-1" aria-labelledby="editBeritaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBeritaModalLabel">Edit Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editBeritaForm" method="POST" action="" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="edit_judul" class="form-label">Judul Berita *</label>
                                <input type="text" class="form-control" id="edit_judul" name="judul" required>
                                <div class="invalid-feedback">Judul berita harus diisi</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_isi_berita" class="form-label">Isi Berita *</label>
                                <textarea class="form-control" id="edit_isi_berita" name="isi_berita" rows="10" required></textarea>
                                <div class="invalid-feedback">Isi berita harus diisi</div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_gambar" class="form-label">Gambar Berita</label>
                                <input type="file" class="form-control" id="edit_gambar" name="gambar" accept="image/*">
                                <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                                <div class="current-image mt-2" id="currentImage">
                                    <!-- Current image will be shown here -->
                                </div>
                                <div class="image-preview mt-2" id="editImagePreview" style="display: none;">
                                    <img src="" alt="Preview" class="img-thumbnail" style="max-width: 100%; height: 200px; object-fit: cover;">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status *</label>
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                                <input type="datetime-local" class="form-control" id="edit_tanggal_publikasi" name="tanggal_publikasi">
                                <div class="form-text">Kosongkan untuk publikasi langsung</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Berita Modal -->
<div class="modal fade" id="viewBeritaModal" tabindex="-1" aria-labelledby="viewBeritaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewBeritaModalLabel">Detail Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <h4 id="viewBeritaTitle">Judul Berita</h4>
                            <div class="text-muted mb-3">
                                <small>
                                    <span id="viewBeritaDate">Tanggal Publikasi</span> | 
                                    <span id="viewBeritaStatus" class="badge">Status</span>
                                </small>
                            </div>
                        </div>
                        
                        <div class="berita-content">
                            <div id="viewBeritaContent">Isi berita akan ditampilkan di sini...</div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div id="viewBeritaImage" class="mb-3">
                            <!-- Image will be shown here -->
                        </div>
                        
                        <div class="berita-meta">
                            <h6>Informasi Berita</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td><strong>Dibuat:</strong></td>
                                    <td id="viewBeritaCreated">-</td>
                                </tr>
                                <tr>
                                    <td><strong>Diperbarui:</strong></td>
                                    <td id="viewBeritaUpdated">-</td>
                                </tr>
                                <tr>
                                    <td><strong>Penulis:</strong></td>
                                    <td id="viewBeritaAuthor">-</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning" onclick="editBeritaFromView()">Edit Berita</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Base URL for AJAX calls -->
<script>
    const base_url = '<?= base_url() ?>';
    
    // Global variables for pagination
    let currentServerPage = <?= isset($paginationInfo) ? $paginationInfo['currentPage'] : 1 ?>;
    let currentServerPerPage = <?= isset($paginationInfo) ? $paginationInfo['perPage'] : 10 ?>;
    let totalServerData = <?= isset($paginationInfo) ? $paginationInfo['total'] : count($berita ?? []) ?>;
    let currentStatusFilter = 'all';
    let currentSearchTerm = '';
    
    // Store original server data
    let serverBeritaData = [];
    let filteredData = [];
    let currentClientPage = 1;
    let clientPerPage = 10;
    
    // Store server berita data on page load
    document.addEventListener('DOMContentLoaded', function() {
        storeServerData();
        initializeEventListeners();
    });
    
    function storeServerData() {
        const rows = document.querySelectorAll('#beritaAdminTable tbody tr.berita-row');
        serverBeritaData = [];
        
        rows.forEach(row => {
            const beritaData = {
                id: row.dataset.beritaId,
                title: row.querySelector('.berita-title').textContent.trim(),
                excerpt: row.querySelector('.berita-excerpt').textContent.trim(),
                status: row.querySelector('.badge').textContent.trim().toLowerCase(),
                date: row.querySelector('td:nth-child(4) small').textContent.trim(),
                html: row.outerHTML
            };
            serverBeritaData.push(beritaData);
        });
        
        filteredData = [...serverBeritaData];
        updateClientPagination();
    }
    
    function initializeEventListeners() {
        // Search functionality
        const searchInput = document.getElementById('searchBerita');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                currentSearchTerm = this.value.toLowerCase();
                applyFilters();
            });
        }
    }
    
    // Filter by status
    function filterByStatus(status) {
        currentStatusFilter = status;
        currentClientPage = 1; // Reset to first page
        applyFilters();
    }
    
    // Reset all filters
    function resetFilters() {
        currentStatusFilter = 'all';
        currentSearchTerm = '';
        currentClientPage = 1;
        
        const searchInput = document.getElementById('searchBerita');
        if (searchInput) searchInput.value = '';
        
        applyFilters();
    }
    
    // Apply all filters
    function applyFilters() {
        filteredData = serverBeritaData.filter(berita => {
            const matchesSearch = berita.title.toLowerCase().includes(currentSearchTerm) || 
                                berita.excerpt.toLowerCase().includes(currentSearchTerm);
            const matchesStatus = currentStatusFilter === 'all' || berita.status === currentStatusFilter;
            
            return matchesSearch && matchesStatus;
        });
        
        updateClientPagination();
        displayFilteredData();
    }
    
    // Update client-side pagination info
    function updateClientPagination() {
        const totalFiltered = filteredData.length;
        const totalPages = Math.ceil(totalFiltered / clientPerPage);
        
        if (currentClientPage > totalPages && totalPages > 0) {
            currentClientPage = totalPages;
        }
        
        const start = totalFiltered > 0 ? ((currentClientPage - 1) * clientPerPage) + 1 : 0;
        const end = Math.min(currentClientPage * clientPerPage, totalFiltered);
        
        updatePaginationDisplay(start, end, totalFiltered, currentClientPage, totalPages);
    }
    
    // Display filtered data
    function displayFilteredData() {
        const tbody = document.querySelector('#beritaAdminTable tbody');
        const startIndex = (currentClientPage - 1) * clientPerPage;
        const endIndex = startIndex + clientPerPage;
        const pageData = filteredData.slice(startIndex, endIndex);
        
        if (pageData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4"><em>Tidak ada data yang sesuai dengan filter</em></td></tr>';
        } else {
            tbody.innerHTML = pageData.map(berita => berita.html).join('');
        }
    }
    
    // Update pagination display
    function updatePaginationDisplay(start, end, total, currentPage, totalPages) {
        const infoElement = document.getElementById('paginationInfo');
        const controlsElement = document.getElementById('paginationControls');
        
        if (infoElement) {
            infoElement.textContent = `Menampilkan ${start}-${end} dari ${total} data`;
        }
        
        if (controlsElement) {
            let paginationHTML = '';
            
            // Previous button
            paginationHTML += `
                <li class="page-item ${currentPage <= 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="goToClientPage(${currentPage - 1}); return false;">Previous</a>
                </li>
            `;
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    paginationHTML += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                } else {
                    paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="goToClientPage(${i}); return false;">${i}</a></li>`;
                }
            }
            
            // Next button
            paginationHTML += `
                <li class="page-item ${currentPage >= totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="goToClientPage(${currentPage + 1}); return false;">Next</a>
                </li>
            `;
            
            controlsElement.innerHTML = paginationHTML;
        }
    }
    
    // Navigate to specific client page
    function goToClientPage(page) {
        const totalPages = Math.ceil(filteredData.length / clientPerPage);
        if (page >= 1 && page <= totalPages) {
            currentClientPage = page;
            updateClientPagination();
            displayFilteredData();
        }
    }
    
    // Change entries per page
    function changeEntriesPerPage() {
        const select = document.getElementById('entriesPerPage');
        const newPerPage = parseInt(select.value);
        
        // Build URL with current page and new perPage
        const currentUrl = new URL(window.location);
        currentUrl.searchParams.set('page', '1'); // Reset to first page
        currentUrl.searchParams.set('perPage', newPerPage);
        
        // Redirect to reload with new perPage
        window.location.href = currentUrl.toString();
    }
</script>
<!-- Berita Management JS -->
<script src="<?= base_url('js/berita-management.js') ?>"></script>
<!-- CKEditor for rich text editing -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    // Initialize CKEditor for Add Modal
    let addEditor, editEditor;
    
    // Initialize when modal is shown
    document.getElementById('addBeritaModal').addEventListener('shown.bs.modal', function() {
        if (!addEditor) {
            ClassicEditor
                .create(document.querySelector('#isi_berita'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', '|', 'undo', 'redo']
                })
                .then(editor => {
                    addEditor = editor;
                })
                .catch(error => {
                    console.error('Error initializing CKEditor:', error);
                });
        }
    });
    
    // Initialize when edit modal is shown
    document.getElementById('editBeritaModal').addEventListener('shown.bs.modal', function() {
        if (!editEditor) {
            ClassicEditor
                .create(document.querySelector('#edit_isi_berita'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', '|', 'undo', 'redo']
                })
                .then(editor => {
                    editEditor = editor;
                    
                    // Set content from stored value if available
                    if (window.pendingEditorContent !== undefined) {
                        editor.setData(window.pendingEditorContent);
                        window.pendingEditorContent = undefined;
                    }
                })
                .catch(error => {
                    console.error('Error initializing CKEditor:', error);
                });
        } else if (window.pendingEditorContent !== undefined) {
            // If editor already exists, set the content
            editEditor.setData(window.pendingEditorContent);
            window.pendingEditorContent = undefined;
        }
    });
    
    // Clean up when modals are hidden
    document.getElementById('addBeritaModal').addEventListener('hidden.bs.modal', function() {
        if (addEditor) {
            addEditor.destroy();
            addEditor = null;
        }
    });
    
    document.getElementById('editBeritaModal').addEventListener('hidden.bs.modal', function() {
        if (editEditor) {
            editEditor.destroy();
            editEditor = null;
        }
    });
</script>
<script src="<?= base_url('js/components/pagination.js') ?>"></script>
<?= $this->endSection() ?>
