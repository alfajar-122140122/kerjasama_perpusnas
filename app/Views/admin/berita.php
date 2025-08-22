<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Berita<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Admin / Kelola Berita<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/berita-management-new.css') ?>" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="<?= base_url('css/components/pagination.css') ?>" rel="stylesheet">
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
        </div>

        <!-- Berita Table -->
        <?php if (isset($berita) && !empty($berita)): ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-paginate align-middle mb-0" id="beritaTable">
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
                            <tr data-berita-id="<?= $item['id_berita'] ?>" class="berita-row">
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
                                        <button type="button" class="btn btn-success btn-sm" title="Lihat" onclick="viewBerita(<?= $item['id_berita'] ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm" title="Edit" onclick="editBerita(<?= $item['id_berita'] ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="deleteBerita(<?= $item['id_berita'] ?>)">
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
                <input type="hidden" id="edit_id_berita" name="id_berita">
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
<script src="<?= base_url('js/berita-management.js') ?>"></script>
<script src="<?= base_url('js/components/pagination.js') ?>"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Base URL for AJAX calls -->
<script>
    const base_url = '<?= base_url() ?>';
</script>
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
<?= $this->endSection() ?>
