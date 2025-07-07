<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Berita<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen Berita<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/berita-management.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
// Sample data for demo purposes - replace with actual data from controller
if (!isset($berita)) {
    $berita = [
        [
            'id_berita' => 1,
            'judul' => 'Peluncuran Program Digitalisasi Perpustakaan Nasional 2025',
            'isi_berita' => 'Perpustakaan Nasional meluncurkan program digitalisasi besar-besaran untuk meningkatkan akses informasi...',
            'gambar' => 'berita1.jpg',
            'tanggal_publikasi' => '2025-01-15 10:00:00',
            'created_by_user_id' => 1,
            'created_at' => '2025-01-15 09:30:00',
            'updated_at' => '2025-01-15 09:30:00',
            'status' => 'published'
        ],
        [
            'id_berita' => 2,
            'judul' => 'Kerjasama Perpustakaan Nasional dengan Universitas Terkemuka',
            'isi_berita' => 'Perpustakaan Nasional menjalin kerjasama strategis dengan berbagai universitas untuk meningkatkan literasi...',
            'gambar' => 'berita2.jpg',
            'tanggal_publikasi' => '2025-01-10 14:30:00',
            'created_by_user_id' => 1,
            'created_at' => '2025-01-10 14:00:00',
            'updated_at' => '2025-01-10 14:00:00',
            'status' => 'published'
        ],
        [
            'id_berita' => 3,
            'judul' => 'Workshop Literasi Digital untuk Masyarakat',
            'isi_berita' => 'Perpustakaan Nasional mengadakan workshop literasi digital gratis untuk meningkatkan kemampuan masyarakat...',
            'gambar' => null,
            'tanggal_publikasi' => null,
            'created_by_user_id' => 1,
            'created_at' => '2025-01-05 16:00:00',
            'updated_at' => '2025-01-05 16:00:00',
            'status' => 'draft'
        ]
    ];
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

<!-- Berita Management Card -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Kelola Berita</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBeritaModal">
                Tambah Berita
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Search and Filter -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchBerita" placeholder="Cari berita...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterMonth">
                    <option value="">Semua Bulan</option>
                    <option value="2025-01">Januari 2025</option>
                    <option value="2024-12">Desember 2024</option>
                    <option value="2024-11">November 2024</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">Reset</button>
            </div>
        </div>

        <!-- Berita Table -->
        <?php if (isset($berita) && !empty($berita)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="beritaTable">
                <thead class="table-light">
                    <tr>
                        <th width="5%">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th width="10%">Gambar</th>
                        <th width="35%">Judul</th>
                        <th width="15%">Status</th>
                        <th width="15%">Tanggal Publikasi</th>
                        <th width="10%">Dibuat</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($berita as $item): ?>
                    <tr data-berita-id="<?= $item['id_berita'] ?>" class="berita-row">
                        <td>
                            <input type="checkbox" class="form-check-input berita-checkbox" value="<?= $item['id_berita'] ?>">
                        </td>
                        <td>
                            <div class="berita-image">
                                <?php if ($item['gambar']): ?>
                                    <img src="<?= base_url('uploads/berita/' . $item['gambar']) ?>" alt="Berita Image" class="img-thumbnail">
                                <?php else: ?>
                                    <div class="no-image">
                                        <span>No Image</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div class="berita-content">
                                <h6 class="berita-title mb-1"><?= esc($item['judul']) ?></h6>
                                <small class="text-muted berita-excerpt">
                                    <?= esc(substr(strip_tags($item['isi_berita']), 0, 100)) ?>...
                                </small>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-<?= $item['status'] === 'published' ? 'success' : 'warning' ?> berita-status">
                                <?= ucfirst($item['status']) ?>
                            </span>
                        </td>
                        <td>
                            <small class="text-muted berita-publish-date">
                                <?= $item['tanggal_publikasi'] ? date('d/m/Y H:i', strtotime($item['tanggal_publikasi'])) : 'Belum dipublikasi' ?>
                            </small>
                        </td>
                        <td>
                            <small class="text-muted berita-created-date">
                                <?= date('d/m/Y', strtotime($item['created_at'])) ?>
                            </small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-info" onclick="viewBerita(<?= $item['id_berita'] ?>)" title="Lihat Detail">
                                    Lihat
                                </button>
                                <button class="btn btn-sm btn-outline-warning" onclick="editBerita(<?= $item['id_berita'] ?>)" title="Edit Berita">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteBerita(<?= $item['id_berita'] ?>)" title="Hapus Berita">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <small class="text-muted">
                    Menampilkan <?= count($berita) ?> dari <?= count($berita) ?> berita
                </small>
            </div>
            <nav aria-label="Berita pagination">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
        <?php else: ?>
        <div class="empty-state text-center py-5">
            <h5>Belum ada berita</h5>
            <p class="text-muted">Tambahkan berita pertama dengan klik tombol "Tambah Berita"</p>
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
            <form id="editBeritaForm" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" id="edit_berita_id" name="id_berita">
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
                })
                .catch(error => {
                    console.error('Error initializing CKEditor:', error);
                });
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
