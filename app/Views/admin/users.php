<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Users<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen Users<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <h2 class="page-title">Manajemen Users</h2>
            <p class="text-muted mb-4">Kelola akun pengguna sistem kerjasama Perpustakaan Nasional</p>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0" id="totalUsers">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Admin Users</div>
                            <div class="h5 mb-0" id="adminUsers">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-user-shield fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Regular Users</div>
                            <div class="h5 mb-0" id="regularUsers">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Bulan Ini</div>
                            <div class="h5 mb-0" id="usersBulanIni">-</div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-calendar-plus fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Users</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus me-2"></i>Tambah User
            </button>
        </div>
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchUser" placeholder="Cari username...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterHakAkses">
                        <option value="">Semua Hak Akses</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary w-100" onclick="resetUserFilters()">
                        <i class="fas fa-redo me-1"></i>Reset Filter
                    </button>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-bordered" id="usersTable">
                    <thead>
                        <tr>
                            <th width="8%">No</th>
                            <th width="30%">Username</th>
                            <th width="20%">Hak Akses</th>
                            <th width="25%">Tanggal Dibuat</th>
                            <th width="17%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <!-- Data will be loaded by JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="text-center py-4" style="display: none;">
                <i class="fas fa-spinner fa-spin fa-2x text-primary mb-3"></i>
                <p class="text-muted">Memuat data...</p>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addUserForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" required>
                                <div class="invalid-feedback"></div>
                                <small class="form-text text-muted">Username minimal 4 karakter, hanya huruf dan angka</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hak_akses" class="form-label">Hak Akses <span class="text-danger">*</span></label>
                                <select class="form-select" id="hak_akses" name="hak_akses" required>
                                    <option value="">Pilih Hak Akses</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="passwordToggleIcon"></i>
                                    </button>
                                    <button class="btn btn-outline-info" type="button" onclick="generatePassword()" title="Generate Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback"></div>
                                <small class="form-text text-muted">Password minimal 8 karakter</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm">
                <input type="hidden" id="edit_user_id" name="user_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_username" name="username" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_hak_akses" class="form-label">Hak Akses <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_hak_akses" name="hak_akses" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_change_password" name="change_password">
                            <label class="form-check-label" for="edit_change_password">
                                Ubah Password
                            </label>
                        </div>
                    </div>
                    <div id="passwordFields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_password" class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="edit_password" name="password">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('edit_password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-info" type="button" onclick="generatePassword()" title="Generate Password">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_confirm_password" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="edit_confirm_password" name="confirm_password">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userDetail">
                <!-- Content will be loaded by JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    loadUserStatistics();
    loadUsersTable();
    setupEventListeners();
});

// Load user statistics
async function loadUserStatistics() {
    try {
        const response = await fetch('<?= base_url('api/users/statistics') ?>');
        const data = await response.json();
        
        if (data.success) {
            const stats = data.data;
            document.getElementById('totalUsers').textContent = stats.total_users || '0';
            document.getElementById('adminUsers').textContent = stats.admin_users || '0';
            document.getElementById('regularUsers').textContent = stats.regular_users || '0';
            document.getElementById('usersBulanIni').textContent = stats.users_bulan_ini || '0';
        }
    } catch (error) {
        console.error('Error loading statistics:', error);
        // Show placeholder data if stats endpoint doesn't exist
        document.getElementById('totalUsers').textContent = '0';
        document.getElementById('adminUsers').textContent = '0';
        document.getElementById('regularUsers').textContent = '0';
        document.getElementById('usersBulanIni').textContent = '0';
    }
}

// Load users table
async function loadUsersTable(filters = {}) {
    const loadingState = document.getElementById('loadingState');
    const tableBody = document.getElementById('usersTableBody');
    
    // Show loading
    loadingState.style.display = 'block';
    tableBody.style.display = 'none';
    
    try {
        const response = await fetch('<?= base_url('admin/users/data') ?>');
        const data = await response.json();
        
        if (data.success) {
            displayUsersTable(data.data, filters);
        } else {
            showAlert('danger', 'Gagal memuat data users');
            showEmptyTable();
        }
    } catch (error) {
        console.error('Error loading users:', error);
        showAlert('danger', 'Terjadi kesalahan saat memuat data');
        showEmptyTable();
    } finally {
        // Hide loading
        loadingState.style.display = 'none';
        tableBody.style.display = '';
    }
}

// Display users in table
function displayUsersTable(users, filters = {}) {
    let filteredUsers = [...users];
    
    // Apply filters
    if (filters.search) {
        const searchTerm = filters.search.toLowerCase();
        filteredUsers = filteredUsers.filter(user => 
            user.username.toLowerCase().includes(searchTerm)
        );
    }
    
    if (filters.hak_akses) {
        filteredUsers = filteredUsers.filter(user => user.hak_akses === filters.hak_akses);
    }
    
    const tbody = document.getElementById('usersTableBody');
    tbody.innerHTML = '';
    
    if (filteredUsers.length === 0) {
        showEmptyTable();
        return;
    }
    
    filteredUsers.forEach((user, index) => {
        // Format date - handle different formats
        let formattedDate = '';
        if (user.created_at) {
            try {
                const date = new Date(user.created_at);
                formattedDate = date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit', 
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            } catch (e) {
                formattedDate = user.created_at;
            }
        }
        
        const row = `
            <tr class="user-row" data-user-id="${user.id_user}">
                <td>${index + 1}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                            <span class="text-white fw-bold">${user.username.charAt(0).toUpperCase()}</span>
                        </div>
                        <strong>${user.username}</strong>
                    </div>
                </td>
                <td>
                    <span class="badge bg-${user.hak_akses === 'admin' ? 'danger' : 'primary'}">${user.hak_akses.toUpperCase()}</span>
                </td>
                <td>
                    <small>${formattedDate}</small>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-info" onclick="viewUser(${user.id_user})" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-warning" onclick="editUser(${user.id_user})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteUser(${user.id_user})" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
    
    // Update statistics from loaded data
    updateStatisticsFromData(users);
}

// Show empty table
function showEmptyTable() {
    const tbody = document.getElementById('usersTableBody');
    tbody.innerHTML = `
        <tr>
            <td colspan="5" class="text-center py-4">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <p class="text-muted">Tidak ada data user ditemukan</p>
            </td>
        </tr>
    `;
}

// Update statistics from data
function updateStatisticsFromData(users) {
    const totalUsers = users.length;
    const adminUsers = users.filter(u => u.hak_akses === 'admin').length;
    const regularUsers = users.filter(u => u.hak_akses === 'user').length;
    
    // Calculate users this month
    const thisMonth = new Date().toISOString().slice(0, 7); // YYYY-MM format
    const usersBulanIni = users.filter(user => {
        if (!user.created_at) return false;
        try {
            return user.created_at.slice(0, 7) === thisMonth;
        } catch (e) {
            return false;
        }
    }).length;
    
    document.getElementById('totalUsers').textContent = totalUsers;
    document.getElementById('adminUsers').textContent = adminUsers;
    document.getElementById('regularUsers').textContent = regularUsers;
    document.getElementById('usersBulanIni').textContent = usersBulanIni;
}

// Setup event listeners
function setupEventListeners() {
    // Search functionality
    document.getElementById('searchUser').addEventListener('input', function() {
        const filters = getActiveFilters();
        loadUsersTable(filters);
    });
    
    // Filter functionality
    document.getElementById('filterHakAkses').addEventListener('change', function() {
        const filters = getActiveFilters();
        loadUsersTable(filters);
    });
    
    // Form submission
    document.getElementById('addUserForm').addEventListener('submit', handleAddUser);
    document.getElementById('editUserForm').addEventListener('submit', handleEditUser);
    
    // Password toggle for edit
    document.getElementById('edit_change_password').addEventListener('change', function() {
        const passwordFields = document.getElementById('passwordFields');
        passwordFields.style.display = this.checked ? 'block' : 'none';
        
        // Set required attribute based on checkbox
        const passwordInputs = passwordFields.querySelectorAll('input[type="password"]');
        passwordInputs.forEach(input => {
            input.required = this.checked;
        });
    });
    
    // Password strength checker
    setupPasswordStrengthChecker();
}

// Password strength checker
function setupPasswordStrengthChecker() {
    const passwordInputs = ['password', 'edit_password'];
    
    passwordInputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('input', function() {
                checkPasswordStrength(this);
            });
        }
    });
}

// Check password strength
function checkPasswordStrength(input) {
    const password = input.value;
    if (!password) {
        // Remove strength indicator if password is empty
        const existingStrength = input.parentNode.parentNode.querySelector('.password-strength');
        if (existingStrength) {
            existingStrength.remove();
        }
        return;
    }
    
    let score = 0;
    let feedback = [];
    
    // Length check
    if (password.length >= 8) {
        score += 25;
        feedback.push('✓ Minimal 8 karakter');
    } else {
        feedback.push('✗ Minimal 8 karakter');
    }
    
    // Lowercase check
    if (/[a-z]/.test(password)) {
        score += 25;
        feedback.push('✓ Huruf kecil');
    } else {
        feedback.push('✗ Huruf kecil');
    }
    
    // Uppercase check
    if (/[A-Z]/.test(password)) {
        score += 25;
        feedback.push('✓ Huruf besar');
    } else {
        feedback.push('✗ Huruf besar');
    }
    
    // Number check
    if (/[0-9]/.test(password)) {
        score += 25;
        feedback.push('✓ Angka');
    } else {
        feedback.push('✗ Angka');
    }
    
    // Symbol check (bonus)
    if (/[^a-zA-Z0-9]/.test(password)) {
        score += 25;
        feedback.push('✓ Simbol (bonus)');
    }
    
    // Display strength
    let strengthDiv = input.parentNode.parentNode.querySelector('.password-strength');
    if (!strengthDiv) {
        strengthDiv = document.createElement('div');
        strengthDiv.className = 'password-strength mt-2';
        input.parentNode.parentNode.appendChild(strengthDiv);
    }
    
    let strengthLevel, strengthColor;
    if (score < 50) {
        strengthLevel = 'Lemah';
        strengthColor = 'danger';
    } else if (score < 75) {
        strengthLevel = 'Sedang';
        strengthColor = 'warning';
    } else if (score < 100) {
        strengthLevel = 'Kuat';
        strengthColor = 'info';
    } else {
        strengthLevel = 'Sangat Kuat';
        strengthColor = 'success';
    }
    
    strengthDiv.innerHTML = `
        <div class="progress mb-2" style="height: 5px;">
            <div class="progress-bar bg-${strengthColor}" style="width: ${Math.min(100, score)}%"></div>
        </div>
        <small class="text-${strengthColor}">
            Kekuatan: ${strengthLevel} (${Math.min(100, score)}%)
        </small>
        <div class="mt-1">
            ${feedback.map(f => `<small class="d-block text-muted" style="font-size: 0.75rem;">${f}</small>`).join('')}
        </div>
    `;
}

// Handle add user form
async function handleAddUser(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;
    
    // Show loading
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Clear previous errors
    clearFormErrors(this);
    
    try {
        const response = await fetch('<?= base_url('admin/users/create') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', data.message);
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            modal.hide();
            this.reset();
            
            // Clear password strength indicators
            const strengthIndicators = this.querySelectorAll('.password-strength');
            strengthIndicators.forEach(indicator => indicator.remove());
            
            // Reload data
            loadUsersTable();
        } else {
            showAlert('danger', data.message || 'Gagal menambahkan user');
            if (data.errors) {
                showFormErrors(this, data.errors);
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat menambahkan user');
    } finally {
        submitBtn.innerHTML = originalContent;
        submitBtn.disabled = false;
    }
}

// Handle edit user form
async function handleEditUser(e) {
    e.preventDefault();
    
    const userId = document.getElementById('edit_user_id').value;
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;
    
    // Show loading
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...';
    submitBtn.disabled = true;
    
    // Clear previous errors
    clearFormErrors(this);
    
    try {
        const response = await fetch(`<?= base_url('admin/users/update') ?>/${userId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', data.message);
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            modal.hide();
            
            // Reload data
            loadUsersTable();
        } else {
            showAlert('danger', data.message || 'Gagal memperbarui user');
            if (data.errors) {
                showFormErrors(this, data.errors);
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat memperbarui user');
    } finally {
        submitBtn.innerHTML = originalContent;
        submitBtn.disabled = false;
    }
}

// View user function
async function viewUser(userId) {
    try {
        const response = await fetch(`<?= base_url('admin/users/show') ?>/${userId}`);
        const data = await response.json();
        
        if (data.success) {
            const user = data.data;
            
            // Format dates
            let createdDate = 'N/A';
            let updatedDate = 'N/A';
            
            if (user.created_at) {
                try {
                    const date = new Date(user.created_at);
                    createdDate = date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long', 
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                } catch (e) {
                    createdDate = user.created_at;
                }
            }
            
            if (user.updated_at) {
                try {
                    const date = new Date(user.updated_at);
                    updatedDate = date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long', 
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                } catch (e) {
                    updatedDate = user.updated_at;
                }
            }
            
            const detailHtml = `
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px;">
                            <span class="text-white display-4 fw-bold">${user.username.charAt(0).toUpperCase()}</span>
                        </div>
                        <h5 class="text-primary">${user.username}</h5>
                        <p class="text-muted">@${user.username}</p>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>Username:</strong></td>
                                <td>${user.username}</td>
                            </tr>
                            <tr>
                                <td><strong>Hak Akses:</strong></td>
                                <td><span class="badge bg-${user.hak_akses === 'admin' ? 'danger' : 'primary'}">${user.hak_akses.toUpperCase()}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Dibuat:</strong></td>
                                <td>${createdDate}</td>
                            </tr>
                            <tr>
                                <td><strong>Terakhir Diupdate:</strong></td>
                                <td>${updatedDate}</td>
                            </tr>
                            <tr>
                                <td><strong>ID User:</strong></td>
                                <td><code>#${user.id_user}</code></td>
                            </tr>
                        </table>
                    </div>
                </div>
            `;
            
            document.getElementById('userDetail').innerHTML = detailHtml;
            const modal = new bootstrap.Modal(document.getElementById('viewUserModal'));
            modal.show();
        } else {
            showAlert('danger', 'User tidak ditemukan');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat memuat detail user');
    }
}

// Edit user function
async function editUser(userId) {
    try {
        const response = await fetch(`<?= base_url('admin/users/show') ?>/${userId}`);
        const data = await response.json();
        
        if (data.success) {
            const user = data.data;
            
            // Populate form
            document.getElementById('edit_user_id').value = user.id_user;
            document.getElementById('edit_username').value = user.username;
            document.getElementById('edit_hak_akses').value = user.hak_akses;
            
            // Reset password fields
            document.getElementById('edit_change_password').checked = false;
            document.getElementById('passwordFields').style.display = 'none';
            
            // Clear password inputs
            document.getElementById('edit_password').value = '';
            document.getElementById('edit_confirm_password').value = '';
            
            // Clear previous errors and strength indicators
            clearFormErrors(document.getElementById('editUserForm'));
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            modal.show();
        } else {
            showAlert('danger', 'User tidak ditemukan');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat memuat data user');
    }
}

// Delete user function
async function deleteUser(userId) {
    if (!confirm('Apakah Anda yakin ingin menghapus user ini?\n\nTindakan ini tidak dapat dibatalkan.')) {
        return;
    }
    
    try {
        const response = await fetch(`<?= base_url('admin/users/delete') ?>/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', data.message);
            loadUsersTable();
        } else {
            showAlert('danger', data.message || 'Gagal menghapus user');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat menghapus user');
    }
}

// Generate password
async function generatePassword() {
    try {
        const response = await fetch('<?= base_url('admin/users/generate-password') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Show password in active modal
            const activeModal = document.querySelector('.modal.show');
            if (activeModal) {
                const passwordInput = activeModal.querySelector('input[name="password"]');
                const confirmPasswordInput = activeModal.querySelector('input[name="confirm_password"]');
                
                if (passwordInput) {
                    passwordInput.value = data.password;
                    passwordInput.type = 'text'; // Show generated password
                    
                    if (confirmPasswordInput) {
                        confirmPasswordInput.value = data.password;
                    }
                    
                    // Show password strength
                    checkPasswordStrength(passwordInput);
                    
                    showAlert('success', 'Password berhasil digenerate');
                }
            }
        } else {
            showAlert('danger', 'Gagal generate password');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat generate password');
    }
}

// Utility functions
function getActiveFilters() {
    return {
        search: document.getElementById('searchUser').value,
        hak_akses: document.getElementById('filterHakAkses').value
    };
}

function resetUserFilters() {
    document.getElementById('searchUser').value = '';
    document.getElementById('filterHakAkses').value = '';
    loadUsersTable();
}

function showFormErrors(form, errors) {
    Object.keys(errors).forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            
            let feedback = input.parentNode.querySelector('.invalid-feedback');
            if (!feedback) {
                feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                input.parentNode.appendChild(feedback);
            }
            feedback.textContent = errors[field];
        }
    });
}

function clearFormErrors(form) {
    const inputs = form.querySelectorAll('.is-invalid, .is-valid');
    inputs.forEach(input => {
        input.classList.remove('is-invalid', 'is-valid');
    });
    
    const feedbacks = form.querySelectorAll('.invalid-feedback, .valid-feedback, .password-strength');
    feedbacks.forEach(feedback => {
        feedback.remove();
    });
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.parentNode.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto close after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            try {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            } catch (e) {
                alert.remove();
            }
        }
    }, 5000);
}
</script>
<?= $this->endSection() ?>