<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0 text-gray-800">Admin / Kelola Users / Kelola User</h2>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
            <i class="fas fa-plus me-2"></i>Tambah User
        </button>
    </div>

    <!-- Alert Messages -->
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

    <!-- Users Management Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar User</h6>
        </div>
        <div class="card-body">
            <!-- Search and Filter -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari User..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-2"></i>Filter Role
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-filter="all">Semua</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="superadmin">Super Admin</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="admin">Admin</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="staff">Staff</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr data-role="<?= $user['role'] ?>">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2">
                                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold"><?= esc($user['name']) ?></div>
                                        <small class="text-muted">@<?= esc($user['username']) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?= esc($user['email']) ?></td>
                            <td>
                                <?php
                                $roleClass = '';
                                switch($user['role']) {
                                    case 'superadmin':
                                        $roleClass = 'bg-danger';
                                        break;
                                    case 'admin':
                                        $roleClass = 'bg-primary';
                                        break;
                                    case 'staff':
                                        $roleClass = 'bg-info';
                                        break;
                                }
                                ?>
                                <span class="badge <?= $roleClass ?>"><?= ucfirst($user['role']) ?></span>
                            </td>
                            <td>
                                <?= $user['phone'] ? esc($user['phone']) : '<span class="text-muted">-</span>' ?>
                            </td>
                            <td>
                                <small><?= $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : '<span class="text-muted">Never</span>' ?></small>
                            </td>
                            <td>
                                <span class="badge <?= $user['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= ucfirst($user['status']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($user['role'] !== 'superadmin' || $user['id'] !== session()->get('user_id')): ?>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat" onclick="viewUser(<?= $user['id'] ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Edit" onclick="editUser(<?= $user['id'] ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="deleteUser(<?= $user['id'] ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <?php else: ?>
                                    <span class="text-muted">Protected</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahUser" method="POST" action="<?= base_url('admin/users/add') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="add_name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="add_name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="add_username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="add_username" name="username" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="add_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="add_email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="add_phone" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="add_phone" name="phone">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="add_role" class="form-label">Role</label>
                            <select class="form-select" id="add_role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="add_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="add_password" name="password" required>
                            <div class="form-text">Minimal 8 karakter, mengandung huruf besar, kecil, angka, dan karakter khusus</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Tambah User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View User -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel">Detail User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <div class="avatar-lg bg-primary rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        <span id="view_user_initial"></span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <p id="view_user_name" class="border-bottom pb-2"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Username</label>
                    <p id="view_user_username" class="border-bottom pb-2"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <p id="view_user_email" class="border-bottom pb-2"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Role</label>
                    <p id="view_user_role" class="border-bottom pb-2"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">No. Telepon</label>
                    <p id="view_user_phone" class="border-bottom pb-2"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Bergabung</label>
                    <p id="view_user_created" class="border-bottom pb-2"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Last Login</label>
                    <p id="view_user_login" class="border-bottom pb-2"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditUser">
                <div class="modal-body">
                    <input type="hidden" id="edit_user_id">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="edit_username" name="username" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_phone" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="edit_phone" name="phone">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_role" class="form-label">Role</label>
                            <select class="form-select" id="edit_role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                            <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Sample user data for JavaScript
const usersData = <?= json_encode($users) ?>;

// Function to show alerts
function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alertDiv);
        bsAlert.close();
    }, 5000);
}

// View user function
function viewUser(userId) {
    const user = usersData.find(u => u.id === userId);
    if (!user) return;
    
    document.getElementById('view_user_initial').textContent = user.name.charAt(0).toUpperCase();
    document.getElementById('view_user_name').textContent = user.name;
    document.getElementById('view_user_username').textContent = '@' + user.username;
    document.getElementById('view_user_email').textContent = user.email;
    document.getElementById('view_user_role').textContent = user.role.charAt(0).toUpperCase() + user.role.slice(1);
    document.getElementById('view_user_phone').textContent = user.phone || '-';
    document.getElementById('view_user_created').textContent = new Date(user.created_at).toLocaleDateString('id-ID');
    document.getElementById('view_user_login').textContent = user.last_login ? new Date(user.last_login).toLocaleString('id-ID') : 'Never';
    
    const modal = new bootstrap.Modal(document.getElementById('viewUserModal'));
    modal.show();
}

// Edit user function
function editUser(userId) {
    const user = usersData.find(u => u.id === userId);
    if (!user) return;
    
    document.getElementById('edit_user_id').value = user.id;
    document.getElementById('edit_name').value = user.name;
    document.getElementById('edit_username').value = user.username;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_phone').value = user.phone || '';
    document.getElementById('edit_role').value = user.role;
    document.getElementById('edit_password').value = '';
    
    const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
    modal.show();
}

// Delete user function
function deleteUser(userId) {
    const user = usersData.find(u => u.id === userId);
    if (!user) return;
    
    if (confirm(`Apakah Anda yakin ingin menghapus user "${user.name}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
        // Simulate delete request
        showAlert('success', 'User berhasil dihapus');
        setTimeout(() => location.reload(), 1500);
    }
}

// Form submissions
document.getElementById('formTambahUser').addEventListener('submit', function(e) {
    // Form will be submitted normally to server
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
});

document.getElementById('formEditUser').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const userId = document.getElementById('edit_user_id').value;
    const formData = new FormData(this);
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Simulate form submission
    setTimeout(() => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
        modal.hide();
        
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        showAlert('success', 'User berhasil diperbarui!');
        setTimeout(() => location.reload(), 1500);
    }, 2000);
});

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach(row => {
        const name = row.cells[0].textContent.toLowerCase();
        const email = row.cells[1].textContent.toLowerCase();
        const username = row.cells[0].textContent.toLowerCase();
        
        if (name.includes(searchTerm) || email.includes(searchTerm) || username.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filter functionality
document.querySelectorAll('[data-filter]').forEach(filterBtn => {
    filterBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const filter = this.dataset.filter;
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            if (filter === 'all') {
                row.style.display = '';
            } else {
                const role = row.dataset.role;
                if (role === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
        
        // Update filter button text
        document.getElementById('filterDropdown').innerHTML = `<i class="fas fa-filter me-2"></i>${this.textContent}`;
    });
});
</script>
<?= $this->endSection() ?>