<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Pengaturan<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Pengaturan Akun<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <h2 class="page-title">Pengaturan Akun</h2>
        <p class="text-muted mb-4">Kelola profil dan pengaturan akun Anda</p>
    </div>
</div>

<!-- Alert Container -->
<div id="alertContainer"></div>

<div class="row">
    <!-- Profile Settings -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-user-edit me-2"></i>Informasi Profil
                </h6>
            </div>
            <div class="card-body">
                <form id="profileForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= esc($user['name']) ?>" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" value="<?= esc($user['username']) ?>" readonly>
                                <div class="form-text">Username tidak dapat diubah</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= esc($user['phone']) ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" class="form-control" id="role" value="<?= esc($user['role']) ?>" readonly>
                                <div class="form-text">Role ditentukan oleh administrator</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="created_at" class="form-label">Bergabung Sejak</label>
                                <input type="text" class="form-control" value="<?= date('d F Y', strtotime($user['created_at'])) ?>" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Account Info Sidebar -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-info-circle me-2"></i>Informasi Akun
                </h6>
            </div>
            <div class="card-body text-center">
                <div class="user-avatar-large mb-3">
                    <div class="avatar-circle-large">
                        <?= strtoupper(substr($user['name'], 0, 2)) ?>
                    </div>
                </div>
                <h5 class="mb-1"><?= esc($user['name']) ?></h5>
                <p class="text-muted mb-2">@<?= esc($user['username']) ?></p>
                <span class="badge bg-<?= $user['role'] === 'Admin' ? 'primary' : 'secondary' ?> mb-3">
                    <?= esc($user['role']) ?>
                </span>
                
                <hr>
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="mb-2">
                            <i class="fas fa-calendar-alt text-primary"></i>
                        </div>
                        <small class="text-muted">Bergabung</small>
                        <div class="fw-bold"><?= date('M Y', strtotime($user['created_at'])) ?></div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <i class="fas fa-clock text-success"></i>
                        </div>
                        <small class="text-muted">Login Terakhir</small>
                        <div class="fw-bold"><?= date('H:i', strtotime($user['last_login'])) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Security Settings -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%); color: white;">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-shield-alt me-2"></i>Keamanan Akun
                </h6>
            </div>
            <div class="card-body">
                <h6>Ubah Password</h6>
                <p class="text-muted mb-4">Pastikan akun Anda menggunakan password yang kuat untuk menjaga keamanan.</p>
                
                <form id="passwordForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('current_password', 'currentToggle')">
                                        <i class="fas fa-eye" id="currentToggle"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password', 'newToggle')">
                                        <i class="fas fa-eye" id="newToggle"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirm_password', 'confirmToggle')">
                                        <i class="fas fa-eye" id="confirmToggle"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div class="mb-3">
                        <label class="form-label">Kekuatan Password:</label>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="passwordStrengthText" class="text-muted">Masukkan password baru untuk melihat kekuatan</small>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-2"></i>Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
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

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: none;
}

.form-control:focus {
    border-color: #4A6CF7;
    box-shadow: 0 0 0 0.2rem rgba(74, 108, 247, 0.25);
}

.progress {
    background-color: #e9ecef;
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5em 1em;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Profile Form Handler
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;
    
    // Show loading
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Clear previous errors
    clearFormErrors(this);
    
    // Make API call
    fetch('<?= base_url('admin/pengaturan/update-profile') ?>', {
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
            updateUserDisplay();
        } else {
            showAlert('danger', data.message || 'Gagal memperbarui profil');
            if (data.errors) {
                showFormErrors(this, data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat memperbarui profil');
    })
    .finally(() => {
        submitBtn.innerHTML = originalContent;
        submitBtn.disabled = false;
    });
});

// Password Form Handler
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    // Client-side validation
    if (newPassword.length < 6) {
        showAlert('danger', 'Password baru minimal 6 karakter');
        document.getElementById('new_password').classList.add('is-invalid');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        showAlert('danger', 'Konfirmasi password tidak sama');
        document.getElementById('confirm_password').classList.add('is-invalid');
        return;
    }
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;
    
    // Show loading
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengubah...';
    submitBtn.disabled = true;
    
    // Clear previous errors
    clearFormErrors(this);
    
    // Make API call
    fetch('<?= base_url('admin/pengaturan/change-password') ?>', {
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
            this.reset();
            updatePasswordStrength('');
        } else {
            showAlert('danger', data.message || 'Gagal mengubah password');
            if (data.errors) {
                showFormErrors(this, data.errors);
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
    strengthText.textContent = password ? strengthLabel : 'Masukkan password baru untuk melihat kekuatan';
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

// Update User Display
function updateUserDisplay() {
    const name = document.getElementById('name').value;
    const initials = name.substring(0, 2).toUpperCase();
    
    document.querySelector('.avatar-circle-large').textContent = initials;
    document.querySelector('.card-body h5').textContent = name;
}

// Show Alert Function
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
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}

// Show Form Errors
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

// Clear Form Errors
function clearFormErrors(form) {
    const inputs = form.querySelectorAll('.is-invalid');
    inputs.forEach(input => {
        input.classList.remove('is-invalid');
    });
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
    
    // Clear validation errors on input
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>