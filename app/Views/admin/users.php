<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/user-management.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
// Sample data for demo purposes - replace with actual data from controller
if (!isset($users)) {
    $users = [
        [
            'id' => 1,
            'name' => 'Fulan',
            'username' => 'fulan',
            'email' => 'fulan@example.com',
            'role' => 'Admin',
            'status' => 'active',
            'created_at' => '2024-01-15'
        ],
        [
            'id' => 2,
            'name' => 'Fulana',
            'username' => 'fulana',
            'email' => 'fulana@example.com',
            'role' => 'User',
            'status' => 'active',
            'created_at' => '2024-02-10'
        ],
        [
            'id' => 3,
            'name' => 'Fulani',
            'username' => 'fulani',
            'email' => 'fulani@example.com',
            'role' => 'Admin',
            'status' => 'active',
            'created_at' => '2024-03-05'
        ],
        [
            'id' => 4,
            'name' => 'Fulano',
            'username' => 'fulano',
            'email' => 'fulano@example.com',
            'role' => 'User',
            'status' => 'active',
            'created_at' => '2024-03-20'
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

<!-- User Management Card -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Kelola User</h6>
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
                <div class="user-row bg-white mb-3 p-3 shadow-sm" data-user-id="<?= $user['id'] ?>" style="border-radius: 20px;">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    <div class="avatar-circle">
                                        <?= strtoupper(substr($user['name'], 0, 2)) ?>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark user-name"><?= esc($user['name']) ?></div>
                                    <small class="text-muted user-username">@<?= esc($user['username']) ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 text-center">
                            <span class="badge bg-<?= $user['role'] === 'Admin' ? 'primary' : 'secondary' ?> user-role">
                                <?= esc($user['role']) ?>
                            </span>
                        </div>
                        <div class="col-3 text-center">
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-primary" onclick="editUser(<?= $user['id'] ?>)" title="Edit User">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteUser(<?= $user['id'] ?>)" title="Hapus User">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Hidden email for JavaScript -->
                    <span class="user-status d-none"><?= $user['status'] ?></span>
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
                                <small class="text-muted" id="changePasswordUserEmail">email@example.com</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <strong>Perhatian:</strong> Password baru akan langsung aktif setelah disimpan.
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password', 'newPasswordToggle')">
                                Lihat
                            </button>
                        </div>
                        <div class="form-text">Password minimal 6 karakter</div>
                        <div class="invalid-feedback">Password minimal 6 karakter</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password Baru *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirm_password', 'confirmPasswordToggle')">
                                Lihat
                            </button>
                        </div>
                        <div class="invalid-feedback">Konfirmasi password harus sama dengan password baru</div>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div class="mb-3">
                        <label class="form-label">Kekuatan Password:</label>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="passwordStrengthText" class="text-muted">Masukkan password untuk melihat kekuatan</small>
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
                            <small class="text-muted" id="resetPasswordUserEmail">email@example.com</small>
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

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel">
                    Detail User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="user-avatar-large mb-3">
                            <div class="avatar-circle-large" id="viewUserAvatar">
                                <!-- Avatar will be populated by JavaScript -->
                            </div>
                        </div>
                        <span class="badge bg-primary" id="viewUserRole">Admin</span>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nama Lengkap:</strong></td>
                                <td id="viewUserName">-</td>
                            </tr>
                            <tr>
                                <td><strong>Username:</strong></td>
                                <td id="viewUserUsername">-</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td id="viewUserEmail">-</td>
                            </tr>
                            <tr>
                                <td><strong>No. Telepon:</strong></td>
                                <td id="viewUserPhone">-</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td id="viewUserStatus">-</td>
                            </tr>
                            <tr>
                                <td><strong>Bergabung:</strong></td>
                                <td id="viewUserJoined">-</td>
                            </tr>
                            <tr>
                                <td><strong>Terakhir Login:</strong></td>
                                <td id="viewUserLastLogin">-</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="button" class="btn btn-warning" onclick="editUserFromView()">
                    Edit User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">
                    Tambah User Baru
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
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
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
                                        Lihat
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
    <div class="modal-dialog modal-lg">
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
                                <label for="edit_phone" class="form-label">No. Telepon</label>
                                <input type="tel" class="form-control" id="edit_phone" name="phone">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status *</label>
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <strong>Catatan:</strong> Untuk mengubah password, user dapat melakukannya melalui halaman pengaturan mereka sendiri.
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
<script>
let currentViewUserId = null;

// Search functionality
document.getElementById('searchUser').addEventListener('input', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#usersTable tbody tr');
    
    rows.forEach(row => {
        const name = row.querySelector('.user-name').textContent.toLowerCase();
        const username = row.querySelector('.user-username').textContent.toLowerCase();
        const email = row.querySelector('.user-email').textContent.toLowerCase();
        
        if (name.includes(filter) || username.includes(filter) || email.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filter by role
document.getElementById('filterRole').addEventListener('change', function() {
    const filter = this.value;
    const rows = document.querySelectorAll('#usersTable tbody tr');
    
    rows.forEach(row => {
        const role = row.querySelector('.user-role').textContent.trim();
        
        if (filter === '' || role === filter) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filter by status
document.getElementById('filterStatus').addEventListener('change', function() {
    const filter = this.value;
    const rows = document.querySelectorAll('#usersTable tbody tr');
    
    rows.forEach(row => {
        const status = row.querySelector('.user-status').textContent.trim().toLowerCase();
        
        if (filter === '' || status === filter) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActions();
});

// Individual checkbox functionality
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('user-checkbox')) {
        updateBulkActions();
    }
});

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    if (checkedBoxes.length > 0) {
        bulkActions.style.display = 'block';
        selectedCount.textContent = checkedBoxes.length;
    } else {
        bulkActions.style.display = 'none';
    }
}

function clearSelection() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    updateBulkActions();
}

function bulkDelete() {
    const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
    const userIds = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (confirm(`Apakah Anda yakin ingin menghapus ${userIds.length} user yang dipilih?`)) {
        // Implement bulk delete logic here
        console.log('Bulk delete users:', userIds);
        showAlert('success', `${userIds.length} user berhasil dihapus`);
        
        // Remove rows from table
        checkedBoxes.forEach(checkbox => {
            const row = checkbox.closest('tr');
            row.remove();
        });
        
        clearSelection();
        updateUserCount();
    }
}

// Change Password Function
function changePassword(userId) {
    const userRow = document.querySelector(`[data-user-id="${userId}"]`);
    if (!userRow) return;
    
    currentUserId = userId;
    
    // Extract user data
    const userName = userRow.querySelector('.user-name').textContent;
    const userEmail = userRow.querySelector('.user-email').textContent.replace(/.*\s/, '');
    const userInitials = userName.substring(0, 2).toUpperCase();
    
    // Populate modal
    document.getElementById('changePasswordAvatar').textContent = userInitials;
    document.getElementById('changePasswordUserName').textContent = userName;
    document.getElementById('changePasswordUserEmail').textContent = userEmail;
    
    // Reset form
    document.getElementById('changePasswordForm').reset();
    document.getElementById('new_password').classList.remove('is-invalid');
    document.getElementById('confirm_password').classList.remove('is-invalid');
    updatePasswordStrength('');
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
    modal.show();
}

// Reset Password Function
function resetPassword(userId) {
    const userRow = document.querySelector(`[data-user-id="${userId}"]`);
    if (!userRow) return;
    
    currentUserId = userId;
    
    // Extract user data
    const userName = userRow.querySelector('.user-name').textContent;
    const userEmail = userRow.querySelector('.user-email').textContent.replace(/.*\s/, '');
    const userInitials = userName.substring(0, 2).toUpperCase();
    
    // Populate modal
    document.getElementById('resetPasswordAvatar').textContent = userInitials;
    document.getElementById('resetPasswordUserName').textContent = userName;
    document.getElementById('resetPasswordUserEmail').textContent = userEmail;
    
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

// Password Strength Checker
function updatePasswordStrength(password) {
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('passwordStrengthText');
    
    let strength = 0;
    let strengthLabel = '';
    let strengthClass = '';
    
    if (password.length >= 6) strength += 1;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
    if (password.match(/[0-9]/)) strength += 1;
    if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
    
    switch (strength) {
        case 0:
        case 1:
            strengthLabel = 'Lemah';
            strengthClass = 'bg-danger';
            break;
        case 2:
            strengthLabel = 'Sedang';
            strengthClass = 'bg-warning';
            break;
        case 3:
        case 4:
            strengthLabel = 'Kuat';
            strengthClass = 'bg-success';
            break;
    }
    
    const percentage = (strength / 4) * 100;
    strengthBar.style.width = percentage + '%';
    strengthBar.className = `progress-bar ${strengthClass}`;
    strengthText.textContent = password ? strengthLabel : 'Masukkan password untuk melihat kekuatan';
}

// Toggle Password Visibility
function togglePasswordVisibility(inputId, toggleId) {
    const input = document.getElementById(inputId);
    const toggle = document.getElementById(toggleId);
    
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

// Show Alert Function
function showAlert(type, message) {
    const alertContainer = document.querySelector('.content-area');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'info' ? 'info-circle' : 'exclamation-triangle'} me-2"></i>
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
    // Password strength checker
    document.getElementById('new_password').addEventListener('input', function() {
        updatePasswordStrength(this.value);
        
        // Check password match
        const confirmPassword = document.getElementById('confirm_password');
        if (confirmPassword.value && confirmPassword.value !== this.value) {
            confirmPassword.classList.add('is-invalid');
        } else {
            confirmPassword.classList.remove('is-invalid');
        }
    });
    
    // Confirm password validation
    document.getElementById('confirm_password').addEventListener('input', function() {
        const newPassword = document.getElementById('new_password').value;
        if (this.value && this.value !== newPassword) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    // Change password form submission
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        // Validation
        if (newPassword.length < 6) {
            document.getElementById('new_password').classList.add('is-invalid');
            showAlert('danger', 'Password minimal 6 karakter');
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
                
                // Show field errors if any
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = document.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                        }
                    });
                }
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
});

// View user function
function viewUser(userId) {
    const userRow = document.querySelector(`[data-user-id="${userId}"]`);
    if (!userRow) return;
    
    currentViewUserId = userId;
    
    // Extract user data from table row
    const userName = userRow.querySelector('.user-name').textContent;
    const userUsername = userRow.querySelector('.user-username').textContent;
    const userEmail = userRow.querySelector('.user-email').textContent.replace(/.*\s/, '');
    const userRole = userRow.querySelector('.user-role').textContent.trim();
    const userStatus = userRow.querySelector('.user-status').textContent.trim();
    
    // Populate view modal
    document.getElementById('viewUserAvatar').textContent = userName.substring(0, 2).toUpperCase();
    document.getElementById('viewUserName').textContent = userName;
    document.getElementById('viewUserUsername').textContent = userUsername;
    document.getElementById('viewUserEmail').textContent = userEmail;
    document.getElementById('viewUserPhone').textContent = 'Tidak ada';
    document.getElementById('viewUserRole').textContent = userRole;
    document.getElementById('viewUserRole').className = `badge bg-${userRole === 'Admin' ? 'primary' : 'secondary'}`;
    document.getElementById('viewUserStatus').innerHTML = `<span class="badge bg-${userStatus.toLowerCase() === 'aktif' ? 'success' : 'danger'}">${userStatus}</span>`;
    document.getElementById('viewUserJoined').textContent = '01 Januari 2024';
    document.getElementById('viewUserLastLogin').textContent = 'Belum pernah login';
    
    // Show modal
    const viewModal = new bootstrap.Modal(document.getElementById('viewUserModal'));
    viewModal.show();
}

// Edit user from view modal
function editUserFromView() {
    const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewUserModal'));
    viewModal.hide();
    
    setTimeout(() => {
        editUser(currentViewUserId);
    }, 300);
}

// Edit user function
function editUser(userId) {
    const userRow = document.querySelector(`[data-user-id="${userId}"]`);
    if (!userRow) return;
    
    // Extract user data from DOM
    const userName = userRow.querySelector('.user-name').textContent;
    const userUsername = userRow.querySelector('.user-username').textContent.replace('@', '');
    const userEmail = userRow.querySelector('.user-email').textContent.replace(/.*\s/, '');
    const userRole = userRow.querySelector('.user-role').textContent.trim();
    const userStatus = userRow.querySelector('.user-status').textContent.trim().toLowerCase();
    
    // Populate edit form
    document.getElementById('edit_user_id').value = userId;
    document.getElementById('edit_name').value = userName;
    document.getElementById('edit_username').value = userUsername;
    document.getElementById('edit_email').value = userEmail;
    document.getElementById('edit_role').value = userRole;
    document.getElementById('edit_status').value = userStatus === 'aktif' ? 'active' : 'inactive';
    
    // Set form action
    document.getElementById('editUserForm').action = `<?= base_url('admin/users/edit') ?>/${userId}`;
    
    // Show modal
    const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
    editModal.show();
}

// Delete user function
function deleteUser(userId) {
    const userRow = document.querySelector(`[data-user-id="${userId}"]`);
    const userName = userRow.querySelector('.user-name').textContent;
    
    if (confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?`)) {
        // Show loading state
        const deleteBtn = userRow.querySelector('.btn-outline-danger');
        const originalContent = deleteBtn.innerHTML;
        
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        deleteBtn.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            // Success simulation
            showAlert('success', `User "${userName}" berhasil dihapus`);
            
            // Remove row with animation
            userRow.style.transition = 'all 0.3s ease';
            userRow.style.opacity = '0';
            userRow.style.transform = 'translateX(100%)';
            
            setTimeout(() => {
                userRow.remove();
                updateUserCount();
            }, 300);
        }, 1000);
    }
}

// Utility functions
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
    const userRows = document.querySelectorAll('#usersTable tbody tr');
    const countElement = document.querySelector('.card-header h6');
    if (countElement) {
        countElement.innerHTML = `<i class="fas fa-users me-2"></i>Daftar User (${userRows.length})`;
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