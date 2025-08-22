<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/admin/user-management.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/components/pagination.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Base URL untuk JavaScript -->
<script>
    window.BASE_URL = '<?= base_url() ?>';
</script>
<script src="<?= base_url('js/components/pagination.js') ?>"></script>

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

<!-- User Management Card -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Kelola User (<?= isset($users) ? count($users) : 0 ?>)</h6>
            <button class="btn btn-success btn-add-user" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus me-2"></i>Tambah User
            </button>
        </div>
    </div>
    
    <div class="card-body p-0">
        <!-- User Table -->
        <div class="table-responsive">
            <table class="table table-hover mb-0 table-paginate">
                <thead class="table-header">
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Nama User</th>
                        <th>Hak Akses</th>
                        <th>Terakhir Aktif</th>
                        <th style="width: 120px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($users) && !empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                        <?php $userId = isset($user['id']) ? $user['id'] : ''; ?>
                        <tr class="user-row" data-user-id="<?= $userId ?>">
                            <td>
                                <input type="checkbox" class="form-check-input user-checkbox" value="<?= $userId ?>">
                            </td>
                            <td>
                                <div class="user-info">
                                    <span class="user-name"><?= esc($user['username'] ?? '') ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge user-role-badge <?= ($user['role'] ?? '') === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                                    <?= ucfirst(esc($user['role'] ?? '')) ?>
                                </span>
                            </td>
                            <td>
                                <span class="last-active">
                                    <?php if (isset($user['last_active']) && $user['last_active']): ?>
                                        <?php
                                        $lastActive = new DateTime($user['last_active']);
                                        $now = new DateTime();
                                        $interval = $now->diff($lastActive);
                                        
                                        if ($interval->y > 0) {
                                            echo $interval->y . ' tahun yang lalu';
                                        } elseif ($interval->m > 0) {
                                            echo $interval->m . ' bulan yang lalu';
                                        } elseif ($interval->d > 0) {
                                            echo $interval->d . ' hari yang lalu';
                                        } elseif ($interval->h > 0) {
                                            echo $interval->h . ' jam yang lalu';
                                        } elseif ($interval->i > 0) {
                                            echo $interval->i . ' menit yang lalu';
                                        } else {
                                            echo 'Baru saja';
                                        }
                                        ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-edit" 
                                            data-user-id="<?= $userId ?>"
                                            data-username="<?= esc($user['username'] ?? '') ?>"
                                            data-hak-akses="<?= esc($user['role'] ?? '') ?>"
                                            data-email="<?= esc($user['email'] ?? '') ?>"
                                            title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-delete" 
                                            data-user-id="<?= $userId ?>"
                                            data-username="<?= esc($user['username'] ?? '') ?>"
                                            title="Hapus User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="empty-state">
                                    <i class="fas fa-users fa-3x mb-3 text-muted"></i>
                                    <h5>Belum ada user</h5>
                                    <p>Tambahkan user pertama dengan klik tombol "Tambah User"</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="pagination-container"></div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">
                    Tambah User Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/users/add') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username *</label>
                        <input type="text" class="form-control" id="username" name="username" required minlength="3" maxlength="50" value="<?= old('username') ?>">
                        <div class="form-text">Username minimal 3 karakter</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required maxlength="100" value="<?= old('email') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required minlength="8" oninput="checkPasswordStrength(this, 'add')">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Password minimal 8 karakter</div>
                        <!-- Password Strength Bar -->
                        <div class="progress mt-2" style="height: 8px;">
                            <div class="progress-bar" id="passwordStrengthAdd" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="passwordStrengthTextAdd" class="text-muted">Masukkan password untuk melihat kekuatan</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="hak_akses" class="form-label">Hak Akses *</label>
                        <select class="form-select" id="hak_akses" name="hak_akses" required>
                            <option value="">Pilih Hak Akses</option>
                            <option value="admin" <?= old('hak_akses') === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="staff" <?= old('hak_akses') === 'staff' ? 'selected' : '' ?>>Staff</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">
                    Edit User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" id="edit_user_id" name="user_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username *</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required minlength="3" maxlength="50">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required maxlength="100">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="edit_password" name="password" minlength="8" oninput="checkPasswordStrength(this, 'edit')">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('edit_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Password minimal 8 karakter</div>
                        <!-- Password Strength Bar -->
                        <div class="progress mt-2" style="height: 8px;">
                            <div class="progress-bar" id="passwordStrengthEdit" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="passwordStrengthTextEdit" class="text-muted">Masukkan password untuk melihat kekuatan</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_hak_akses" class="form-label">Hak Akses *</label>
                        <select class="form-select" id="edit_hak_akses" name="hak_akses" required>
                            <option value="">Pilih Hak Akses</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/admin/user-management.js') ?>"></script>
<?= $this->endSection() ?>