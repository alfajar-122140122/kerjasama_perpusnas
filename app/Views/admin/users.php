<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <h2 class="page-title">Manajemen User</h2>
        <p class="text-muted mb-4">Kelola data user sistem</p>
    </div>
</div>

<!-- Alerts -->
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

<!-- User Management Container -->
<div class="user-table-container">
    <div class="table-header">
        <h4 class="table-title">
            <i class="fas fa-users me-2"></i>
            Daftar User (<?= count($users ?? []) ?> user)
        </h4>
        <button class="btn-add-user" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus me-2"></i>Tambah User
        </button>
    </div>
    
    <!-- Users List -->
    <?php if (isset($users) && !empty($users)): ?>
        <?php foreach ($users as $user): ?>
        <div class="user-row" data-user-id="<?= $user['id'] ?>">
            <div class="user-info">
                <div class="user-details">
                    <div class="user-name"><?= esc($user['name']) ?></div>
                    <div class="user-meta">
                        <span class="user-username">@<?= esc($user['username']) ?></span>
                        <span class="user-role badge bg-<?= $user['role'] === 'Admin' ? 'primary' : 'secondary' ?>">
                            <?= esc($user['role']) ?>
                        </span>
                    </div>
                </div>
                <div class="user-status">
                    <span class="status-indicator <?= $user['status'] === 'active' ? 'active' : 'inactive' ?>">
                        <i class="fas fa-circle"></i> <?= ucfirst($user['status']) ?>
                    </span>
                </div>
            </div>
            <div class="user-actions">
                <button class="btn-edit" onclick="editUser(<?= $user['id'] ?>)" title="Edit User">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-delete" onclick="deleteUser(<?= $user['id'] ?>)" title="Hapus User">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-users-slash"></i>
            </div>
            <h5>Belum ada user</h5>
            <p class="text-muted">Tambahkan user pertama dengan klik tombol "Tambah User"</p>
        </div>
    <?php endif; ?>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Tambah User Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addUserForm" action="<?= base_url('admin/users/add') ?>" method="POST" data-validate>
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">Nama lengkap harus diisi</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username *</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                                <div class="invalid-feedback">Username harus diisi</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Email valid harus diisi</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role *</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                                <div class="invalid-feedback">Role harus dipilih</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required minlength="6">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password')">
                                        <i class="fas fa-eye" id="passwordToggle"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Password minimal 6 karakter</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password *</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                <div class="invalid-feedback">Konfirmasi password harus sama</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">No. Telepon</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            User aktif
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">
                    <i class="fas fa-user-edit me-2"></i>Edit User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" method="POST" data-validate>
                <?= csrf_field() ?>
                <input type="hidden" id="edit_user_id" name="user_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_username" class="form-label">Username *</label>
                                <input type="text" class="form-control" id="edit_username" name="username" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_role" class="form-label">Role *</label>
                                <select class="form-select" id="edit_role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_phone" class="form-label">No. Telepon</label>
                        <input type="tel" class="form-control" id="edit_phone" name="phone">
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active">
                        <label class="form-check-label" for="edit_is_active">
                            User aktif
                        </label>
                    </div>
                    
                    <hr>
                    <h6>Ubah Password (Opsional)</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="edit_password" name="password" minlength="6">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_confirm_password" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="edit_confirm_password" name="confirm_password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Additional Styles for Users Page -->
<style>
.user-details {
    flex: 1;
}

.user-name {
    font-weight: 600;
    font-size: 16px;
    color: #333;
    margin-bottom: 5px;
}

.user-meta {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-username {
    color: #666;
    font-size: 14px;
}

.user-status {
    display: flex;
    align-items: center;
    margin-right: 20px;
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 500;
}

.status-indicator.active {
    color: #28a745;
}

.status-indicator.inactive {
    color: #dc3545;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 15px;
    margin: 20px 0;
}

.empty-icon {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 20px;
}

.btn-block {
    display: block;
    width: 100%;
}

.modal-body .row {
    margin-bottom: 0;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// User management functions
function editUser(userId) {
    // Get user data (in real app, fetch from API)
    const userRow = document.querySelector(`[data-user-id="${userId}"]`);
    if (!userRow) return;
    
    // Extract user data from DOM (temporary solution)
    const userName = userRow.querySelector('.user-name').textContent;
    const userUsername = userRow.querySelector('.user-username').textContent.replace('@', '');
    const userRole = userRow.querySelector('.user-role').textContent;
    
    // Populate edit form
    document.getElementById('edit_user_id').value = userId;
    document.getElementById('edit_name').value = userName;
    document.getElementById('edit_username').value = userUsername;
    document.getElementById('edit_role').value = userRole;
    
    // Set form action
    document.getElementById('editUserForm').action = `<?= base_url('admin/users/edit') ?>/${userId}`;
    
    // Show modal
    const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
    editModal.show();
}

function deleteUser(userId) {
    const userRow = document.querySelector(`[data-user-id="${userId}"]`);
    const userName = userRow.querySelector('.user-name').textContent;
    
    if (confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?`)) {
        // Show loading state
        const deleteBtn = userRow.querySelector('.btn-delete');
        const originalContent = deleteBtn.innerHTML;
        
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        deleteBtn.disabled = true;
        
        // Simulate API call
        fetch(`<?= base_url('admin/users/delete') ?>/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showAlert('success', data.message || 'User berhasil dihapus');
                
                // Remove row with animation
                userRow.style.transition = 'all 0.3s ease';
                userRow.style.opacity = '0';
                userRow.style.transform = 'translateX(100%)';
                
                setTimeout(() => {
                    userRow.remove();
                    updateUserCount();
                }, 300);
            } else {
                showAlert('danger', 'Gagal menghapus user: ' + (data.message || 'Unknown error'));
                deleteBtn.innerHTML = originalContent;
                deleteBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat menghapus user');
            deleteBtn.innerHTML = originalContent;
            deleteBtn.disabled = false;
        });
    }
}

function showAlert(type, message) {
    const alertContainer = document.querySelector('.content-area');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    alertContainer.insertBefore(alert, alertContainer.firstChild);
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}

function updateUserCount() {
    const userRows = document.querySelectorAll('.user-row');
    const countElement = document.querySelector('.table-title');
    if (countElement) {
        countElement.innerHTML = `<i class="fas fa-users me-2"></i>Daftar User (${userRows.length} user)`;
    }
}

function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const toggle = document.getElementById(inputId + 'Toggle');
    
    if (input.type === 'password') {
        input.type = 'text';
        toggle.classList.remove('fa-eye');
        toggle.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        toggle.classList.remove('fa-eye-slash');
        toggle.classList.add('fa-eye');
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    // Add user form validation
    const addForm = document.getElementById('addUserForm');
    addForm.addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            document.getElementById('confirm_password').classList.add('is-invalid');
            showAlert('danger', 'Password dan konfirmasi password tidak sama!');
            return false;
        }
    });
    
    // Edit user form validation
    const editForm = document.getElementById('editUserForm');
    editForm.addEventListener('submit', function(e) {
        const password = document.getElementById('edit_password').value;
        const confirmPassword = document.getElementById('edit_confirm_password').value;
        
        if (password && password !== confirmPassword) {
            e.preventDefault();
            document.getElementById('edit_confirm_password').classList.add('is-invalid');
            showAlert('danger', 'Password dan konfirmasi password tidak sama!');
            return false;
        }
    });
    
    // Real-time password confirmation validation
    document.getElementById('confirm_password').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        if (this.value && this.value !== password) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    document.getElementById('edit_confirm_password').addEventListener('input', function() {
        const password = document.getElementById('edit_password').value;
        if (this.value && this.value !== password) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
});
</script>
<?= $this->endSection() ?>