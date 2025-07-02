<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <h2 class="page-title">Manajemen User</h2>
        <p class="text-muted mb-4">Kelola pengguna sistem Perpustakaan Nasional</p>
    </div>
</div>

<!-- Alert Container -->
<div id="alertContainer"></div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-content">
                        <h4 class="stats-number"><?= $total_users ?></h4>
                        <p class="stats-label">Total User</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stats-content">
                        <h4 class="stats-number"><?= $active_users ?></h4>
                        <p class="stats-label">User Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning">
                        <i class="fas fa-user-times"></i>
                    </div>
                    <div class="stats-content">
                        <h4 class="stats-number"><?= $inactive_users ?></h4>
                        <p class="stats-label">User Tidak Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="stats-content">
                        <h4 class="stats-number"><?= $admin_users ?></h4>
                        <p class="stats-label">Administrator</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Management Card -->
<div class="card shadow">
    <div class="card-header py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-users me-2"></i>
                Daftar User
            </h6>
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus me-2"></i>Tambah User
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Search and Filter -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" id="searchUser" placeholder="Cari user...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterRole">
                    <option value="">Semua Role</option>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                    <i class="fas fa-redo me-1"></i>Reset
                </button>
            </div>
        </div>

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="usersTable">
                <thead class="table-primary">
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">
                            <i class="fas fa-user me-1"></i>User
                        </th>
                        <th width="20%">
                            <i class="fas fa-envelope me-1"></i>Email
                        </th>
                        <th width="10%">
                            <i class="fas fa-user-tag me-1"></i>Role
                        </th>
                        <th width="10%">
                            <i class="fas fa-toggle-on me-1"></i>Status
                        </th>
                        <th width="15%">
                            <i class="fas fa-calendar me-1"></i>Bergabung
                        </th>
                        <th width="15%" class="text-center">
                            <i class="fas fa-cogs me-1"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $index => $user): ?>
                    <tr data-user-id="<?= $user['id'] ?>" class="user-row">
                        <td>
                            <span class="fw-bold text-primary"><?= $index + 1 ?></span>
                        </td>
                        <td>
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
                        </td>
                        <td>
                            <a href="mailto:<?= esc($user['email']) ?>" class="text-decoration-none user-email">
                                <i class="fas fa-envelope text-muted me-1"></i>
                                <?= esc($user['email']) ?>
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-<?= $user['role'] === 'Admin' ? 'primary' : 'secondary' ?> user-role">
                                <i class="fas fa-<?= $user['role'] === 'Admin' ? 'crown' : 'user' ?> me-1"></i>
                                <?= esc($user['role']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-<?= $user['status'] === 'active' ? 'success' : 'danger' ?> user-status">
                                <i class="fas fa-circle me-1"></i>
                                <?= ucfirst($user['status']) ?>
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                <?= date('d/m/Y', strtotime($user['created_at'])) ?>
                            </small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" onclick="viewUser(<?= $user['id'] ?>)" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" onclick="editUser(<?= $user['id'] ?>)" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteUser(<?= $user['id'] ?>)" title="Hapus User">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
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
            <form id="addUserForm">
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
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password', 'passwordToggle')">
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

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel">
                    <i class="fas fa-eye me-2"></i>Detail User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="userDetail">
                    <!-- Content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
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
            <form id="editUserForm">
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
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Catatan:</strong> Password tidak dapat diubah melalui halaman ini. User dapat mengubah password mereka melalui halaman pengaturan.
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

<!-- Styles -->
<style>
.stats-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 2rem 0 rgba(33, 40, 50, 0.25);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-right: 1rem;
}

.stats-number {
    font-size: 2rem;
    font-weight: bold;
    margin: 0;
    color: #5a5c69;
}

.stats-label {
    margin: 0;
    color: #858796;
    font-size: 0.875rem;
}

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(45deg, #4A6CF7, #667eea);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: none;
}

.table th {
    background-color: #f8f9fc;
    border-color: #e3e6f0;
    font-weight: 600;
    color: #5a5c69;
    font-size: 0.875rem;
}

.table td {
    border-color: #e3e6f0;
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fc;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5em 0.75em;
}

.btn-group .btn {
    margin: 0 1px;
}

.modal-content {
    border-radius: 15px;
}

.form-control:focus {
    border-color: #4A6CF7;
    box-shadow: 0 0 0 0.2rem rgba(74, 108, 247, 0.25);
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Sample data for demo
const usersData = <?= json_encode($users) ?>;

// Add User Form Handler
document.getElementById('addUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        showAlert('danger', 'Password dan konfirmasi password tidak sama!');
        document.getElementById('confirm_password').classList.add('is-invalid');
        return;
    }
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    clearFormErrors(this);
    
    fetch('<?= base_url('admin/users/add') ?>', {
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            modal.hide();
            this.reset();
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('danger', data.message || 'Gagal menambahkan user');
            if (data.errors) {
                showFormErrors(this, data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat menambahkan user');
    })
    .finally(() => {
        submitBtn.innerHTML = originalContent;
        submitBtn.disabled = false;
    });
});

// Edit User Form Handler
document.getElementById('editUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const userId = document.getElementById('edit_user_id').value;
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...';
    submitBtn.disabled = true;
    
    clearFormErrors(this);
    
    fetch(`<?= base_url('admin/users/edit') ?>/${userId}`, {
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            modal.hide();
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('danger', data.message || 'Gagal memperbarui user');
            if (data.errors) {
                showFormErrors(this, data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat memperbarui user');
    })
    .finally(() => {
        submitBtn.innerHTML = originalContent;
        submitBtn.disabled = false;
    });
});

// View User Function
function viewUser(userId) {
    const user = usersData.find(u => u.id == userId);
    if (!user) return;
    
    const detailHtml = `
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="user-avatar-large">
                    <div class="avatar-circle-large">
                        ${user.name.substring(0, 2).toUpperCase()}
                    </div>
                </div>
                <h5 class="mt-3">${user.name}</h5>
                <p class="text-muted">@${user.username}</p>
                <span class="badge bg-${user.role === 'Admin' ? 'primary' : 'secondary'} mb-2">${user.role}</span>
                <br>
                <span class="badge bg-${user.status === 'active' ? 'success' : 'danger'}">${user.status.toUpperCase()}</span>
            </div>
            <div class="col-md-8">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><i class="fas fa-envelope text-muted me-2"></i><strong>Email:</strong></td>
                        <td>${user.email}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-phone text-muted me-2"></i><strong>Telepon:</strong></td>
                        <td>${user.phone || '-'}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-calendar-alt text-muted me-2"></i><strong>Bergabung:</strong></td>
                        <td>${new Date(user.created_at).toLocaleDateString('id-ID')}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-clock text-muted me-2"></i><strong>Login Terakhir:</strong></td>
                        <td>${new Date(user.last_login).toLocaleDateString('id-ID')} ${new Date(user.last_login).toLocaleTimeString('id-ID')}</td>
                    </tr>
                </table>
            </div>
        </div>
    `;
    
    document.getElementById('userDetail').innerHTML = detailHtml;
    const modal = new bootstrap.Modal(document.getElementById('viewUserModal'));
    modal.show();
}

// Edit User Function
function editUser(userId) {
    const user = usersData.find(u => u.id == userId);
    if (!user) return;
    
    document.getElementById('edit_user_id').value = user.id;
    document.getElementById('edit_name').value = user.name;
    document.getElementById('edit_username').value = user.username;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_phone').value = user.phone || '';
    document.getElementById('edit_role').value = user.role;
    document.getElementById('edit_status').value = user.status;
    
    clearFormErrors(document.getElementById('editUserForm'));
    
    const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
    modal.show();
}

// Delete User Function
function deleteUser(userId) {
    const user = usersData.find(u => u.id == userId);
    if (!user) return;
    
    if (confirm(`Apakah Anda yakin ingin menghapus user "${user.name}"?`)) {
        fetch(`<?= base_url('admin/users/delete') ?>/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                const row = document.querySelector(`[data-user-id="${userId}"]`);
                if (row) row.remove();
            } else {
                showAlert('danger', data.message || 'Gagal menghapus user');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat menghapus user');
        });
    }
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

// Search and Filter Functions
document.getElementById('searchUser').addEventListener('input', filterUsers);
document.getElementById('filterRole').addEventListener('change', filterUsers);
document.getElementById('filterStatus').addEventListener('change', filterUsers);

function filterUsers() {
    const searchTerm = document.getElementById('searchUser').value.toLowerCase();
    const roleFilter = document.getElementById('filterRole').value;
    const statusFilter = document.getElementById('filterStatus').value;
    
    const rows = document.querySelectorAll('.user-row');
    
    rows.forEach(row => {
        const name = row.querySelector('.user-name').textContent.toLowerCase();
        const username = row.querySelector('.user-username').textContent.toLowerCase();
        const email = row.querySelector('.user-email').textContent.toLowerCase();
        const role = row.querySelector('.user-role').textContent;
        const status = row.querySelector('.user-status').textContent.toLowerCase();
        
        const matchesSearch = name.includes(searchTerm) || username.includes(searchTerm) || email.includes(searchTerm);
        const matchesRole = !roleFilter || role === roleFilter;
        const matchesStatus = !statusFilter || status.includes(statusFilter);
        
        if (matchesSearch && matchesRole && matchesStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function resetFilters() {
    document.getElementById('searchUser').value = '';
    document.getElementById('filterRole').value = '';
    document.getElementById('filterStatus').value = '';
    filterUsers();
}

// Utility Functions
function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    alertContainer.appendChild(alert);
    
    setTimeout(() => {
        if (alert.parentNode) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}

function showFormErrors(form, errors) {
    Object.keys(errors).forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            const feedback = input.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.textContent = errors[field];
            }
        }
    });
}

function clearFormErrors(form) {
    const inputs = form.querySelectorAll('.is-invalid');
    inputs.forEach(input => {
        input.classList.remove('is-invalid');
    });
}

// Additional CSS for avatar
const additionalStyle = document.createElement('style');
additionalStyle.textContent = `
.avatar-circle-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(45deg, #4A6CF7, #667eea);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 24px;
    margin: 0 auto;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
`;
document.head.appendChild(additionalStyle);
</script>
<?= $this->endSection() ?>