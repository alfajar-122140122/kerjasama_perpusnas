<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0 text-gray-800">Admin / Kelola Users / Hak Akses</h2>
        </div>
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

    <!-- User Permissions Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen Hak Akses User</h6>
        </div>
        <div class="card-body">
            <!-- Search -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari User..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
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
                            <th>Permissions</th>
                            <th>Status</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
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
                                <?php if ($user['role'] === 'superadmin'): ?>
                                    <span class="badge bg-warning">All Access</span>
                                <?php elseif (!empty($user['permissions'])): ?>
                                    <?php foreach ($user['permissions'] as $permission): ?>
                                        <span class="badge bg-success me-1"><?= ucfirst($permission) ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-muted">No permissions</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge <?= $user['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= ucfirst($user['status']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($user['role'] !== 'superadmin'): ?>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm" title="Lihat" onclick="viewPermissions(<?= $user['id'] ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Edit Permissions" onclick="editPermissions(<?= $user['id'] ?>)">
                                        <i class="fas fa-edit"></i>
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

<!-- Modal View Permissions -->
<div class="modal fade" id="viewPermissionsModal" tabindex="-1" aria-labelledby="viewPermissionsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPermissionsModalLabel">Detail Hak Akses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama User</label>
                    <p id="view_user_name" class="border-bottom pb-2"></p>
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
                    <label class="form-label fw-bold">Permissions</label>
                    <div id="view_user_permissions"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Permissions -->
<div class="modal fade" id="editPermissionsModal" tabindex="-1" aria-labelledby="editPermissionsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPermissionsModalLabel">Edit Hak Akses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditPermissions">
                <div class="modal-body">
                    <input type="hidden" id="edit_user_id">
                    
                    <div class="mb-3">
                        <label for="edit_user_role" class="form-label">Role</label>
                        <select class="form-select" id="edit_user_role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Permissions</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="kerjasama" id="perm_kerjasama">
                            <label class="form-check-label" for="perm_kerjasama">
                                Kelola Kerjasama
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="berita" id="perm_berita">
                            <label class="form-check-label" for="perm_berita">
                                Kelola Berita
                            </label>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Catatan:</strong> Admin dapat mengakses semua fitur yang dipilih. Staff hanya dapat mengakses fitur yang dipilih dengan batasan tertentu.
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

// View permissions function
function viewPermissions(userId) {
    const user = usersData.find(u => u.id === userId);
    if (!user) return;
    
    document.getElementById('view_user_name').textContent = user.name;
    document.getElementById('view_user_email').textContent = user.email;
    document.getElementById('view_user_role').textContent = user.role.charAt(0).toUpperCase() + user.role.slice(1);
    
    const permissionsContainer = document.getElementById('view_user_permissions');
    if (user.permissions && user.permissions.length > 0) {
        permissionsContainer.innerHTML = user.permissions.map(perm => 
            `<span class="badge bg-success me-1">${perm.charAt(0).toUpperCase() + perm.slice(1)}</span>`
        ).join('');
    } else {
        permissionsContainer.innerHTML = '<span class="text-muted">No permissions assigned</span>';
    }
    
    const modal = new bootstrap.Modal(document.getElementById('viewPermissionsModal'));
    modal.show();
}

// Edit permissions function
function editPermissions(userId) {
    const user = usersData.find(u => u.id === userId);
    if (!user) return;
    
    document.getElementById('edit_user_id').value = user.id;
    document.getElementById('edit_user_role').value = user.role;
    
    // Reset checkboxes
    document.getElementById('perm_kerjasama').checked = false;
    document.getElementById('perm_berita').checked = false;
    
    // Set current permissions
    if (user.permissions) {
        user.permissions.forEach(perm => {
            const checkbox = document.getElementById(`perm_${perm}`);
            if (checkbox) checkbox.checked = true;
        });
    }
    
    const modal = new bootstrap.Modal(document.getElementById('editPermissionsModal'));
    modal.show();
}

// Form submission
document.getElementById('formEditPermissions').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const userId = document.getElementById('edit_user_id').value;
    const role = document.getElementById('edit_user_role').value;
    const permissions = [];
    
    if (document.getElementById('perm_kerjasama').checked) {
        permissions.push('kerjasama');
    }
    if (document.getElementById('perm_berita').checked) {
        permissions.push('berita');
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Simulate AJAX request
    setTimeout(() => {
        fetch('<?= base_url("admin/users/update-permissions") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                user_id: userId,
                role: role,
                permissions: permissions
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('editPermissionsModal'));
                modal.hide();
                showAlert('success', data.message);
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert('danger', data.message);
            }
        })
        .catch(error => {
            showAlert('danger', 'Terjadi kesalahan: ' + error.message);
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }, 1000);
});

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach(row => {
        const name = row.cells[0].textContent.toLowerCase();
        const email = row.cells[1].textContent.toLowerCase();
        const role = row.cells[2].textContent.toLowerCase();
        
        if (name.includes(searchTerm) || email.includes(searchTerm) || role.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
<?= $this->endSection() ?>