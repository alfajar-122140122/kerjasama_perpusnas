<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="user-table-container">
    <div class="table-header">
        <h4 class="table-title">Daftar User</h4>
        <button class="btn-add-user" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus me-2"></i>Tambah User
        </button>
    </div>
    
    <!-- Header Row -->
    <div class="user-row" style="background: rgba(255,255,255,0.2); margin-bottom: 15px;">
        <div class="user-info">
            <div class="user-name" style="color: white; font-weight: bold;">Nama User</div>
            <div class="user-role" style="color: white; font-weight: bold;">Hak Akses</div>
        </div>
        <div style="color: white; font-weight: bold;">Aksi</div>
    </div>
    
    <!-- User Rows -->
    <?php foreach ($users as $user): ?>
    <div class="user-row">
        <div class="user-info">
            <div class="user-name"><?= esc($user['name']) ?></div>
            <div class="user-role"><?= esc($user['role']) ?></div>
        </div>
        <div class="user-actions">
            <button class="btn-edit" onclick="editUser(<?= $user['id'] ?>)">
                <i class="fas fa-edit me-1"></i>Edit
            </button>
            <button class="btn-delete" onclick="deleteUser(<?= $user['id'] ?>)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addUserForm" action="<?= base_url('admin/users/add') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hak Akses</label>
                        <select class="form-select" name="role" required>
                            <option value="">Pilih Hak Akses</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function editUser(userId) {
        // TODO: Implement edit user functionality
        alert('Edit user dengan ID: ' + userId);
    }
    
    function deleteUser(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
            // TODO: Implement delete user functionality
            alert('Delete user dengan ID: ' + userId);
        }
    }
</script>
<?= $this->endSection() ?>