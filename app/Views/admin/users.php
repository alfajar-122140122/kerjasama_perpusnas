<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/user-management.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

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
            <h6 class="mb-0">Kelola User (<?= count($users) ?>)</h6>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Tambah User
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <!-- Users Table with Green Background Style -->
        <div class="user-table-container" style="background: linear-gradient(135deg, #28a745, #20c997); min-height: 400px; padding: 20px; border-radius: 0 0 8px 8px;">
            <!-- Header Row -->
            <div class="row text-white fw-bold mb-3" style="padding: 10px 0;">
                <div class="col-6">
                    <span>Nama User</span>
                </div>
                <div class="col-3 text-center">
                    <span>Hak Akses</span>
                </div>
                <div class="col-3 text-center">
                    <span>Aksi</span>
                </div>
            </div>
            
            <!-- User Rows -->
            <?php if (isset($users) && !empty($users)): ?>
                <?php foreach ($users as $user): ?>
                <div class="user-row bg-white mb-3 p-3 shadow-sm" data-user-id="<?= $user['id_user'] ?>" style="border-radius: 20px;">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    <div class="avatar-circle">
                                        <?= strtoupper(substr($user['username'], 0, 2)) ?>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark user-name"><?= esc($user['username']) ?></div>
                                    <small class="text-muted user-username">@<?= esc($user['username']) ?></small>
                                    <?php if (isset($user['last_active']) && $user['last_active']): ?>
                                        <br><small class="text-success">Terakhir aktif: <?= date('d/m/Y H:i', strtotime($user['last_active'])) ?></small>
                                    <?php else: ?>
                                        <br><small class="text-muted">Belum pernah login</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 text-center">
                            <span class="badge bg-<?= $user['hak_akses'] === 'admin' ? 'primary' : 'secondary' ?> user-role">
                                <?= ucfirst(esc($user['hak_akses'])) ?>
                            </span>
                        </div>
                        <div class="col-3 text-center">
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-primary" onclick="editUser(<?= $user['id_user'] ?>)" title="Edit User">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="changePassword(<?= $user['id_user'] ?>)" title="Ubah Password">
                                    Password
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteUser(<?= $user['id_user'] ?>)" title="Hapus User">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Hidden data for JavaScript -->
                    <span class="user-email d-none"><?= esc($user['username']) ?>@example.com</span>
                    <span class="user-status d-none">active</span>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-white py-5">
                    <h5>Belum ada user</h5>
                    <p>Tambahkan user pertama dengan klik tombol "Tambah User"</p>
                </div>
            <?php endif; ?>
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
                        <input type="text" class="form-control" id="username" name="username" required minlength="3" maxlength="255" value="<?= old('username') ?>">
                        <div class="form-text">Username minimal 3 karakter</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required minlength="8">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password')">
                                Lihat
                            </button>
                        </div>
                        <div class="form-text">Password minimal 8 karakter</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="hak_akses" class="form-label">Hak Akses *</label>
                        <select class="form-select" id="hak_akses" name="hak_akses" required>
                            <option value="">Pilih Hak Akses</option>
                            <option value="admin" <?= old('hak_akses') === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="user" <?= old('hak_akses') === 'user' ? 'selected' : '' ?>>User</option>
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
                        <input type="text" class="form-control" id="edit_username" name="username" required minlength="3" maxlength="255">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="edit_password" name="password" minlength="8">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('edit_password')">
                                Lihat
                            </button>
                        </div>
                        <div class="form-text">Password minimal 8 karakter</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_hak_akses" class="form-label">Hak Akses *</label>
                        <select class="form-select" id="edit_hak_akses" name="hak_akses" required>
                            <option value="">Pilih Hak Akses</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
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

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="changePasswordModalLabel">
                    Ubah Password User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changePasswordForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-circle me-3" id="changePasswordAvatar">
                                <!-- Avatar will be populated by JavaScript -->
                            </div>
                            <div>
                                <h6 class="mb-0" id="changePasswordUserName">Nama User</h6>
                                <small class="text-muted" id="changePasswordUserEmail">username</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <strong>Perhatian:</strong> Password baru akan langsung aktif setelah disimpan.
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password')">
                                Lihat
                            </button>
                        </div>
                        <div class="form-text">Password minimal 8 karakter</div>
                        <div class="invalid-feedback">Password minimal 8 karakter</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password Baru *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirm_password')">
                                Lihat
                            </button>
                        </div>
                        <div class="invalid-feedback">Konfirmasi password harus sama dengan password baru</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="resetPasswordModalLabel">
                    Reset Password User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-circle me-3" id="resetPasswordAvatar">
                            <!-- Avatar will be populated by JavaScript -->
                        </div>
                        <div>
                            <h6 class="mb-0" id="resetPasswordUserName">Nama User</h6>
                            <small class="text-muted" id="resetPasswordUserEmail">username</small>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning">
                    <strong>Peringatan:</strong> Tindakan ini akan menghasilkan password acak baru dan menggantikan password lama.
                </div>
                
                <div class="alert alert-info" id="newPasswordAlert" style="display: none;">
                    <strong>Password Baru:</strong>
                    <div class="d-flex align-items-center mt-2">
                        <code id="generatedPassword" class="flex-grow-1"></code>
                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyPassword()" title="Copy Password">
                            Copy
                        </button>
                    </div>
                    <small class="text-muted">Pastikan untuk mencatat password ini dan memberitahukan kepada user.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="button" class="btn btn-info" id="resetPasswordBtn" onclick="confirmResetPassword()">
                    Reset Password
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let currentUserId = null;

// Edit user function
function editUser(userId) {
    currentUserId = userId;
    
    // Fetch user data
    fetch(`<?= base_url('admin/users/data') ?>/${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.data;
                
                // Populate edit form
                document.getElementById('edit_user_id').value = user.id_user;
                document.getElementById('edit_username').value = user.username;
                document.getElementById('edit_hak_akses').value = user.hak_akses;
                
                // Set form action
                document.getElementById('editUserForm').action = `<?= base_url('admin/users/edit') ?>/${userId}`;
                
                // Show modal
                const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                editModal.show();
            } else {
                showAlert('danger', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat mengambil data user');
        });
}

// Change Password Function
function changePassword(userId) {
    const userRow = document.querySelector(`[data-user-id="${userId}"]`);
    if (!userRow) return;
    
    currentUserId = userId;
    
    // Extract user data
    const userName = userRow.querySelector('.user-name').textContent;
    const userInitials = userName.substring(0, 2).toUpperCase();
    
    // Populate modal
    document.getElementById('changePasswordAvatar').textContent = userInitials;
    document.getElementById('changePasswordUserName').textContent = userName;
    document.getElementById('changePasswordUserEmail').textContent = `@${userName}`;
    
    // Reset form
    document.getElementById('changePasswordForm').reset();
    document.getElementById('new_password').classList.remove('is-invalid');
    document.getElementById('confirm_password').classList.remove('is-invalid');
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
    modal.show();
}

// Delete user function
function deleteUser(userId) {
    const userRow = document.querySelector(`[data-user-id="${userId}"]`);
    const userName = userRow.querySelector('.user-name').textContent;
    
    if (confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?`)) {
        window.location.href = `<?= base_url('admin/users/delete') ?>/${userId}`;
    }
}

// Reset Password Function
function resetPassword(userId) {
    const userRow = document.querySelector(`[data-user-id="${userId}"]`);
    if (!userRow) return;
    
    currentUserId = userId;
    
    // Extract user data
    const userName = userRow.querySelector('.user-name').textContent;
    const userInitials = userName.substring(0, 2).toUpperCase();
    
    // Populate modal
    document.getElementById('resetPasswordAvatar').textContent = userInitials;
    document.getElementById('resetPasswordUserName').textContent = userName;
    document.getElementById('resetPasswordUserEmail').textContent = `@${userName}`;
    
    // Reset modal state
    document.getElementById('newPasswordAlert').style.display = 'none';
    document.getElementById('resetPasswordBtn').style.display = 'inline-block';
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
    modal.show();
}

// Confirm Reset Password
function confirmResetPassword() {
    if (!currentUserId) return;
    
    const resetBtn = document.getElementById('resetPasswordBtn');
    const originalContent = resetBtn.innerHTML;
    
    // Show loading
    resetBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mereset...';
    resetBtn.disabled = true;
    
    // Make API call
    fetch(`<?= base_url('admin/users/reset-password') ?>/${currentUserId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show new password
            document.getElementById('generatedPassword').textContent = data.new_password;
            document.getElementById('newPasswordAlert').style.display = 'block';
            resetBtn.style.display = 'none';
            
            showAlert('success', data.message);
        } else {
            showAlert('danger', data.message || 'Gagal mereset password');
            resetBtn.innerHTML = originalContent;
            resetBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat mereset password');
        resetBtn.innerHTML = originalContent;
        resetBtn.disabled = false;
    });
}

// Copy Password Function
function copyPassword() {
    const passwordText = document.getElementById('generatedPassword').textContent;
    navigator.clipboard.writeText(passwordText).then(() => {
        showAlert('info', 'Password berhasil disalin ke clipboard');
    }).catch(err => {
        console.error('Failed to copy password:', err);
    });
}

// Toggle Password Visibility
function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    
    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = 'Sembunyikan';
    } else {
        input.type = 'password';
        button.textContent = 'Lihat';
    }
}

// Show Alert Function
function showAlert(type, message) {
    const alertContainer = document.querySelector('.content') || document.body;
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
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

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Change password form submission
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        // Validation
        if (newPassword.length < 8) {
            document.getElementById('new_password').classList.add('is-invalid');
            showAlert('danger', 'Password minimal 8 karakter');
            return;
        }
        
        if (newPassword !== confirmPassword) {
            document.getElementById('confirm_password').classList.add('is-invalid');
            showAlert('danger', 'Konfirmasi password tidak sama');
            return;
        }
        
        // Submit form
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalContent = submitBtn.innerHTML;
        
        // Show loading
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengubah...';
        submitBtn.disabled = true;
        
        // Make API call
        fetch(`<?= base_url('admin/users/change-password') ?>/${currentUserId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                modal.hide();
            } else {
                showAlert('danger', data.message || 'Gagal mengubah password');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat mengubah password');
        })
        .finally(() => {
            submitBtn.innerHTML = originalContent;
            submitBtn.disabled = false;
        });
    });
    
    // Real-time password confirmation validation
    document.getElementById('confirm_password').addEventListener('input', function() {
        const password = document.getElementById('new_password').value;
        if (this.value && this.value !== password) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
});
</script>
<?= $this->endSection() ?>