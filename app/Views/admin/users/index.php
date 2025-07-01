<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header dengan tombol tambah -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Daftar User</h4>
        <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah User
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-users me-2"></i>Data User
            </h5>
        </div>
        <div class="card-body">
            <?php if (empty($users)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada user</h5>
                    <p class="text-muted">Klik tombol "Tambah User" untuk menambahkan user pertama.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Username</th>
                                <th width="15%">Hak Akses</th>
                                <th width="20%">Dibuat</th>
                                <th width="20%">Terakhir Update</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong><?= esc($user['username']) ?></strong>
                                                <?php if ($user['id_user'] == session()->get('user_id')): ?>
                                                    <small class="badge bg-info ms-1">Anda</small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($user['hak_akses'] == 'admin'): ?>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-crown me-1"></i>Admin
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-user me-1"></i>User
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($user['created_at'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($user['updated_at'])) ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url('admin/users/edit/' . $user['id_user']) ?>" 
                                               class="btn btn-outline-primary" 
                                               title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if ($user['id_user'] != session()->get('user_id')): ?>
                                                <button type="button" 
                                                        class="btn btn-outline-danger" 
                                                        title="Hapus User"
                                                        onclick="confirmDelete(<?= $user['id_user'] ?>, '<?= esc($user['username']) ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h5>Apakah Anda yakin?</h5>
                    <p>User <strong id="deleteUsername"></strong> akan dihapus secara permanen.</p>
                    <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <form id="deleteForm" method="POST" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function confirmDelete(userId, username) {
        document.getElementById('deleteUsername').textContent = username;
        document.getElementById('deleteForm').action = '<?= base_url('admin/users/delete/') ?>' + userId;
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    // Auto dismiss alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>

<style>
.user-avatar {
    width: 35px;
    height: 35px;
    background-color: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
}
</style>
<?= $this->endSection() ?>
