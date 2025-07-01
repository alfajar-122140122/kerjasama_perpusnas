<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Tambah User<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Tambah User Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('admin/users') ?>">Manajemen User</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah User</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-plus me-2"></i>Form Tambah User
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Alert Messages -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($password_errors) && !empty($password_errors)): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Password tidak memenuhi kriteria keamanan:</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach ($password_errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form action="<?= base_url('admin/users/store') ?>" method="POST" id="userForm">
                        <?= csrf_field() ?>
                        
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-1"></i>Username <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control <?= (isset($validation) && $validation->getError('username')) ? 'is-invalid' : '' ?>" 
                                   id="username"
                                   name="username" 
                                   value="<?= old('username') ?? $old_input['username'] ?? '' ?>"
                                   required
                                   maxlength="50"
                                   autocomplete="username">
                            <?php if (isset($validation) && $validation->getError('username')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('username') ?></div>
                            <?php endif; ?>
                            <div class="form-text">Username minimal 3 karakter, maksimal 50 karakter</div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i>Password <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <input type="password" 
                                       class="form-control <?= (isset($validation) && $validation->getError('password')) ? 'is-invalid' : '' ?>" 
                                       id="password"
                                       name="password" 
                                       required
                                       minlength="8"
                                       autocomplete="new-password"
                                       oninput="checkPasswordStrength()">
                                <button type="button" 
                                        class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-2 password-toggle" 
                                        onclick="togglePassword('password', 'passwordToggleIcon')" 
                                        style="border: none; background: none; color: #666; z-index: 10;"
                                        tabindex="-1">
                                    <i class="fas fa-eye" id="passwordToggleIcon"></i>
                                </button>
                            </div>
                            <?php if (isset($validation) && $validation->getError('password')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
                            <?php endif; ?>
                            
                            <!-- Password Strength Indicator -->
                            <div id="passwordStrength" class="password-strength mt-2" style="display: none;">
                                <div class="strength-bar mb-2">
                                    <div class="strength-fill" id="strengthBar"></div>
                                </div>
                                <small id="strengthText" class="text-muted"></small>
                                <div id="strengthRequirements" class="mt-2">
                                    <small class="d-block">
                                        <i class="fas fa-times text-danger me-1" id="req-length"></i>
                                        Minimal 8 karakter
                                    </small>
                                    <small class="d-block">
                                        <i class="fas fa-times text-danger me-1" id="req-lowercase"></i>
                                        Mengandung huruf kecil (a-z)
                                    </small>
                                    <small class="d-block">
                                        <i class="fas fa-times text-danger me-1" id="req-uppercase"></i>
                                        Mengandung huruf besar (A-Z)
                                    </small>
                                    <small class="d-block">
                                        <i class="fas fa-times text-danger me-1" id="req-numbers"></i>
                                        Mengandung angka (0-9)
                                    </small>
                                    <small class="d-block">
                                        <i class="fas fa-times text-danger me-1" id="req-special"></i>
                                        Mengandung karakter khusus (@#$%^&*()[]{})
                                    </small>
                                </div>
                            </div>
                            
                            <div class="mt-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="generatePassword()">
                                    <i class="fas fa-magic me-1"></i>Generate Password Aman
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">
                                <i class="fas fa-lock me-1"></i>Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <input type="password" 
                                       class="form-control <?= (isset($validation) && $validation->getError('password_confirm')) ? 'is-invalid' : '' ?>" 
                                       id="password_confirm"
                                       name="password_confirm" 
                                       required
                                       autocomplete="new-password"
                                       oninput="checkPasswordMatch()">
                                <button type="button" 
                                        class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-2 password-toggle" 
                                        onclick="togglePassword('password_confirm', 'confirmToggleIcon')" 
                                        style="border: none; background: none; color: #666; z-index: 10;"
                                        tabindex="-1">
                                    <i class="fas fa-eye" id="confirmToggleIcon"></i>
                                </button>
                            </div>
                            <?php if (isset($validation) && $validation->getError('password_confirm')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('password_confirm') ?></div>
                            <?php endif; ?>
                            <div id="passwordMatch" class="form-text"></div>
                        </div>

                        <!-- Hak Akses -->
                        <div class="mb-4">
                            <label for="hak_akses" class="form-label">
                                <i class="fas fa-shield-alt me-1"></i>Hak Akses <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?= (isset($validation) && $validation->getError('hak_akses')) ? 'is-invalid' : '' ?>" 
                                    id="hak_akses" 
                                    name="hak_akses" 
                                    required>
                                <option value="">Pilih Hak Akses</option>
                                <option value="admin" <?= (old('hak_akses') ?? $old_input['hak_akses'] ?? '') == 'admin' ? 'selected' : '' ?>>
                                    Admin - Akses penuh sistem  
                                </option>
                                <option value="user" <?= (old('hak_akses') ?? $old_input['hak_akses'] ?? '') == 'user' ? 'selected' : '' ?>>
                                    User - Akses terbatas
                                </option>
                            </select>
                            <?php if (isset($validation) && $validation->getError('hak_akses')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('hak_akses') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-1"></i>Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Toggle password visibility
    function togglePassword(fieldId, iconId) {
        const passwordField = document.getElementById(fieldId);
        const toggleIcon = document.getElementById(iconId);
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Check password strength
    function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const strengthDiv = document.getElementById('passwordStrength');
        
        if (password.length === 0) {
            strengthDiv.style.display = 'none';
            return;
        }
        
        strengthDiv.style.display = 'block';
        
        // Send AJAX request to check password strength
        fetch('<?= base_url('auth/check-password-strength') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'password=' + encodeURIComponent(password) + '&<?= csrf_token() ?>=' + '<?= csrf_hash() ?>'
        })
        .then(response => response.json())
        .then(data => {
            updatePasswordStrengthUI(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Update password strength UI
    function updatePasswordStrengthUI(data) {
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        // Update strength bar
        const percentage = (data.score / 5) * 100;
        strengthBar.style.width = percentage + '%';
        
        // Update colors based on strength
        strengthBar.className = 'strength-fill';
        switch (data.strength) {
            case 'Sangat Lemah':
                strengthBar.classList.add('strength-very-weak');
                break;
            case 'Lemah':
                strengthBar.classList.add('strength-weak');
                break;
            case 'Sedang':
                strengthBar.classList.add('strength-medium');
                break;
            case 'Kuat':
                strengthBar.classList.add('strength-strong');
                break;
            case 'Sangat Kuat':
                strengthBar.classList.add('strength-very-strong');
                break;
        }
        
        strengthText.textContent = 'Kekuatan Password: ' + data.strength;
        
        // Update requirement indicators
        updateRequirement('req-length', data.requirements.length);
        updateRequirement('req-lowercase', data.requirements.lowercase);
        updateRequirement('req-uppercase', data.requirements.uppercase);
        updateRequirement('req-numbers', data.requirements.numbers);
        updateRequirement('req-special', data.requirements.special);
    }

    // Update individual requirement
    function updateRequirement(id, met) {
        const element = document.getElementById(id);
        if (met) {
            element.className = 'fas fa-check text-success me-1';
        } else {
            element.className = 'fas fa-times text-danger me-1';
        }
    }

    // Check password match
    function checkPasswordMatch() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirm').value;
        const matchDiv = document.getElementById('passwordMatch');
        
        if (confirmPassword.length === 0) {
            matchDiv.textContent = '';
            return;
        }
        
        if (password === confirmPassword) {
            matchDiv.innerHTML = '<i class="fas fa-check text-success me-1"></i>Password cocok';
            matchDiv.className = 'form-text text-success';
        } else {
            matchDiv.innerHTML = '<i class="fas fa-times text-danger me-1"></i>Password tidak cocok';
            matchDiv.className = 'form-text text-danger';
        }
    }

    // Generate secure password
    function generatePassword() {
        fetch('<?= base_url('admin/users/generate-password') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('password').value = data.password;
            document.getElementById('password_confirm').value = data.password;
            checkPasswordStrength();
            checkPasswordMatch();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Form validation before submit
    document.getElementById('userForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirm').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak cocok!');
            return;
        }
        
        // Disable submit button to prevent double submission
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
    });
</script>

<style>
.password-strength {
    max-width: 400px;
}

.strength-bar {
    height: 6px;
    background-color: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
}

.strength-fill {
    height: 100%;
    transition: all 0.3s ease;
    border-radius: 3px;
}

.strength-very-weak { background-color: #dc3545; }
.strength-weak { background-color: #fd7e14; }
.strength-medium { background-color: #ffc107; }
.strength-strong { background-color: #20c997; }
.strength-very-strong { background-color: #28a745; }

.password-toggle {
    cursor: pointer;
}

.password-toggle:hover {
    color: #0d6efd !important;
}
</style>
<?= $this->endSection() ?>
